const { Op, fn, col } = require('sequelize')
const { check, body } = require('express-validator')
const models = global.modules('config').core.models();

// TODO lanjutin add cart
const addCart = () => [
    check('itemId')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('format tidak boleh kosong')
        .isNumeric()
        .withMessage('format harus angka')
        .bail(),

    check('qty')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('format tidak boleh kosong')
        .isNumeric()
        .withMessage('format harus angka')
        .bail(),

    body().custom(async ({ }, { req }) => {
        try {
            let checkItemExist = await models.item.findOne({
                where: {
                    id: req.body.itemId,
                }
            })

            let parsingCart = await models.cart.findOne({
                where: {
                    item_id: req.body.itemId,
                }
            })

            if (req.body.itemId && !checkItemExist) {
                return Promise.reject({
                    replaceCode: 404,
                    replaceMessage: `menu tidak ditemukan`,
                });
            } else {
                let qty = (parsingCart) ? parsingCart.qty + parseInt(req.body.qty) : parseInt(req.body.qty)

                if (qty > checkItemExist.stock) {
                    return Promise.reject({
                        replaceCode: 400,
                        replaceMessage: `kuantitas tidak boleh lebih dari stok`,
                    });
                }
            }
        } catch (error) {
            return Promise.reject({
                replaceCode: 500,
                replaceMessage: error.message,
            });
        };
    })
]

module.exports = {
    addCart: [
        addCart(),
        global.modules('helper').main.responseErrorValidator
    ],
};