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
                    item_id: items.id,
                    qty: items.qty,
                    price: items.price,
                    total_price: items.totalPrice,
                })

                await models.item.update({
                    stock: items.stock - items.qty,
                }, {
                    where: {
                        id: items.id,
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