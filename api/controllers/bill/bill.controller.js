const { Op, fn, col } = require('sequelize')
const models = global.core.models()

exports.addCheckout = async (req, res) => {
    let output = {};
    let dataAuth = await global.core.dataAuth(req.headers.authorization.split(' ')[1])

    try {
        let getCart = await global.core.dataCart(dataAuth.id)
        let billCode = await global.core.generateBillCode(dataAuth.id)

        queryBill = await models.bill.create({
            admin_id: dataAuth.id,
            bill: billCode,
            customer_name: req.body.customerName,
            total_price: getCart.totalPrice,
        })

        if (!queryBill) {
            output.status = {
                code: 400,
                message: 'gagal buat pesanan',
            }
        } else {
            await Promise.all(getCart.items.map(async (items) => {
                await models.bill_detail.create({
                    bill_id: queryBill.id,
                    item_id: items.itemId,
                    qty: items.qty,
                    price: items.price,
                    total_price: items.totalPrice,
                })

                await models.item.update({
                    stock: items.stock - items.qty,
                }, {
                    where: {
                        id: items.itemId,
                    }
                })
            }))

            await models.cart.destroy({
                where: {
                    admin_id: dataAuth.id,
                }
            })

            output.status = {
                code: 200,
                message: 'sukses buat pesanan',
            }

            output.data = queryBill.id
        }
    } catch (error) {
        output.status = {
            code: 500,
            message: error.message
        }
    }

    res.status(output.status.code).send(output);
};

exports.getBill = async (req, res) => {
    let output = {};
    let dataAuth = await global.core.dataAuth(req.headers.authorization.split(' ')[1])

    try {
        let data = {}
        let paramData = {}

        paramData.where = {
            admin_id: dataAuth.id,
        }
        paramData.order = [['id', 'DESC']]

        let parsingData = await models.bill.findAll(paramData)

        data = await Promise.all(parsingData.map(async (items) => {
            let dataItems = {}

            dataItems.id = items.id
            dataItems.bill = items.bill
            dataItems.customerName = items.customer_name
            dataItems.totalPrice = items.total_price
            dataItems.totalPriceCurrencyFormat = global.helper.rupiah(dataItems.totalPrice)
            dataItems.createdAt = global.core.moment(items.created_at).format('YYYY-MM-DD HH:mm:ss')

            return dataItems
        }))

        output.status = {
            code: 200,
            message: 'sukses mendapat data',
        }

        output.data = data;
    } catch (error) {
        output.status = {
            code: 500,
            message: error.message
        }
    }

    res.status(output.status.code).send(output);
};

exports.getBillDetail = async (req, res) => {
    let output = {};
    let dataAuth = await global.core.dataAuth(req.headers.authorization.split(' ')[1])

    try {
        let data = {}
        let paramData = {}

        paramData.where = {
            id: req.params.id,
        }

        let parsingData = await models.bill.findOne(paramData)

        data.id = parsingData.id
        data.bill = parsingData.bill
        data.customerName = parsingData.customer_name
        data.totalQty = 0
        data.totalPrice = parsingData.total_price
        data.totalPriceCurrencyFormat = global.helper.rupiah(data.totalPrice)
        data.createdAt = global.core.moment(parsingData.created_at).format('YYYY-MM-DD HH:mm:ss')

        let parsingDetail = await models.bill_detail.findAll({
            where: {
                bill_id: req.params.id,
            },
            include: [
                {
                    model: models.item,
                    as: 'item',
                    required: true,
                },
            ]
        })

        let totalQty = []
        data.items = await Promise.all(parsingDetail.map(async (items) => {
            let dataItems = {}

            dataItems.id = items.id
            dataItems.itemId = items.item.id
            dataItems.name = items.item.name
            dataItems.image = (items.item.image) ? `${global.core.pathImageItem}${items.item.image}` : global.core.noImageItem
            dataItems.qty = items.qty
            dataItems.price = items.price
            dataItems.priceCurrencyFormat = global.helper.rupiah(dataItems.price)
            dataItems.totalPrice = items.total_price
            dataItems.totalPriceCurrencyFormat = global.helper.rupiah(dataItems.totalPrice)

            totalQty.push(dataItems.qty)

            return dataItems
        }))

        data.totalQty = global.helper.sumArray(totalQty)

        output.status = {
            code: 200,
            message: 'sukses mendapat data',
        }

        output.data = data;
    } catch (error) {
        output.status = {
            code: 500,
            message: error.message
        }
    }

    res.status(output.status.code).send(output);
};