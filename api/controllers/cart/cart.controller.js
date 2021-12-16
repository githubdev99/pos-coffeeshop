const { Op, fn, col } = require('sequelize')
const models = global.modules('config').core.models()

exports.addCart = async (req, res) => {
    let output = {};
    let dataAuth = await global.modules('config').core.dataAuth(req.headers.authorization.split(' ')[1])

    try {
        let parsingCart = await models.cart.findOne({
            where: {
                item_id: req.body.itemId,
            }
        })

        let queryCart = {}
        if (parsingCart) {
            queryCart = await models.item.update({
                qty: req.body.qty,
            }, {
                where: {
                    admin_id: dataAuth.id,
                    item_id: req.body.itemId,
                }
            })
        } else {
            queryCart = await models.item.create({
                admin_id: dataAuth.id,
                item_id: req.body.itemId,
                qty: parsingCart.qty + req.body.qty,
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