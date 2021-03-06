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
        output.status = {
            code: 200,
            message: 'sukses mendapat data',
        }

        output.data = await global.core.dataCart(dataAuth.id);
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