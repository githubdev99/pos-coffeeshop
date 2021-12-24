const { Op, fn, col } = require('sequelize')
const models = global.core.models()

exports.addCart = async (req, res) => {
    let output = {};
    let dataAuth = await global.core.dataAuth(req.headers.authorization.split(' ')[1])

    try {
        let parsingCart = await models.cart.findOne({
            where: {
                item_id: req.body.itemId,
            }
        })

        let queryCart = {}
        if (parsingCart) {
            queryCart = await models.cart.update({
                qty: parsingCart.qty + parseInt(req.body.qty),
            }, {
                where: {
                    admin_id: dataAuth.id,
                    item_id: req.body.itemId,
                }
            })
        } else {
            queryCart = await models.cart.create({
                admin_id: dataAuth.id,
                item_id: req.body.itemId,
                qty: parseInt(req.body.qty),
            })
        }

        if (!queryCart) {
            output.status = {
                code: 400,
                message: 'gagal tambah data',
            }
        } else {
            output.status = {
                code: 200,
                message: 'sukses tambah data',
            }
        }
    } catch (error) {
        output.status = {
            code: 500,
            message: error.message
        }
    }

    res.status(output.status.code).send(output);
};

exports.changeQty = async (req, res) => {
    let output = {};
    let dataAuth = await global.core.dataAuth(req.headers.authorization.split(' ')[1])

    try {
        let parsingCart = await models.cart.findOne({
            where: {
                item_id: req.body.itemId,
            }
        })

        let qty = 0

        if (req.params.action === 'change') {
            qty = req.body.qty
        } else if (req.params.action === 'add') {
            qty = parsingCart.qty + 1
        } else if (req.params.action === 'less') {
            qty = parsingCart.qty - 1
        }

        if (qty > 0) {
            let queryCart = await models.cart.update({
                qty: qty,
            }, {
                where: {
                    admin_id: dataAuth.id,
                    item_id: req.body.itemId,
                }
            })

            if (!queryCart) {
                output.status = {
                    code: 400,
                    message: 'gagal edit data',
                }
            } else {
                output.status = {
                    code: 200,
                    message: 'sukses edit data',
                }
            }
        } else {
            let queryCart = await models.cart.destroy({
                where: {
                    admin_id: dataAuth.id,
                    item_id: req.body.itemId,
                }
            })

            if (!queryCart) {
                output.status = {
                    code: 400,
                    message: 'gagal hapus data',
                }
            } else {
                output.status = {
                    code: 200,
                    message: 'sukses hapus data',
                }
            }
        }
    } catch (error) {
        output.status = {
            code: 500,
            message: error.message
        }
    }

    res.status(output.status.code).send(output);
};

exports.getCart = async (req, res) => {
    let output = {};
    let dataAuth = await global.core.dataAuth(req.headers.authorization.split(' ')[1])

    try {
        let data = {}
        let paramData = {}

        paramData.where = {
            admin_id: dataAuth.id,
        }
        paramData.include = [
            {
                model: models.item,
                as: 'item',
                required: true,
            },
        ]
        paramData.order = [['id', 'DESC']]

        let parsingData = await models.cart.findAll(paramData)

        data.totalQty = 0
        data.totalPrice = 0
        data.totalPriceCurrencyFormat = global.helper.rupiah(data.totalPrice)

        let totalQty = []
        let totalPrice = []
        data.items = await Promise.all(parsingData.map(async (items) => {
            let dataItems = {}

            dataItems.id = items.id
            dataItems.itemId = items.item.id
            dataItems.name = items.item.name
            dataItems.image = (items.item.image) ? `${global.core.pathImageItem}${items.item.image}` : global.core.noImageItem
            dataItems.qty = items.qty
            dataItems.price = items.item.price
            dataItems.priceCurrencyFormat = global.helper.rupiah(dataItems.price)
            dataItems.totalPrice = (items.item.price * items.qty)
            dataItems.totalPriceCurrencyFormat = global.helper.rupiah(dataItems.totalPrice)

            totalQty.push(dataItems.qty)
            totalPrice.push(dataItems.totalPrice)

            return dataItems
        }))

        data.totalQty = global.helper.sumArray(totalQty)
        data.totalPrice = global.helper.sumArray(totalPrice)
        data.totalPriceCurrencyFormat = global.helper.rupiah(data.totalPrice)

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

exports.deleteCart = async (req, res) => {
    let output = {};
    let dataAuth = await global.core.dataAuth(req.headers.authorization.split(' ')[1])

    try {
        let queryCart = await models.cart.destroy({
            where: {
                id: req.params.id,
                admin_id: dataAuth.id,
            }
        })

        if (!queryCart) {
            output.status = {
                code: 400,
                message: 'gagal hapus data',
            }
        } else {
            output.status = {
                code: 200,
                message: 'sukses hapus data',
            }
        }
    } catch (error) {
        output.status = {
            code: 500,
            message: error.message
        }
    }

    res.status(output.status.code).send(output);
};