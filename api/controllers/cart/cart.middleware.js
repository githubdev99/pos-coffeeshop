const { Op, fn, col } = require('sequelize')
const { check, body } = require('express-validator')
const models = global.core.models();

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

const changeQty = () => [
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
        .optional({ checkFalsy: true })
        .isNumeric()
        .withMessage('format harus angka')
        .bail(),

    check('action')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('format tidak boleh kosong')
        .bail(),

    body().custom(async ({ }, { req }) => {
        try {
            let actionAllowed = ['change', 'add', 'less']

            let dataAuth = await global.core.dataAuth(req.headers.authorization.split(' ')[1])

            let checkItemExist = await models.item.findOne({
                where: {
                    id: req.body.itemId,
                }
            })

            let checkCartExist = await models.cart.findOne({
                where: {
                    item_id: req.body.itemId,
                    admin_id: dataAuth.id,
                }
            })

            let parsingCart = await models.cart.findOne({
                where: {
                    item_id: req.body.itemId,
                }
            })

            if (!actionAllowed.includes(req.params.action)) {
                return Promise.reject({
                    replaceCode: 404,
                    replaceMessage: `parameter tidak ditemukan, parameter yang valid adalah ${actionAllowed.join(', ')}`,
                });
            } else {
                if (req.body.itemId && !checkItemExist) {
                    return Promise.reject({
                        replaceCode: 404,
                        replaceMessage: `menu tidak ditemukan`,
                    });
                } else if (req.body.itemId && !checkCartExist) {
                    return Promise.reject({
                        replaceCode: 404,
                        replaceMessage: `data tidak ditemukan`,
                    });
                } else {
                    if ((req.params.action === 'change') && (Number(req.body.qty) <= 0)) {
                        return Promise.reject({
                            replaceCode: 400,
                            replaceMessage: `kuantitas tidak boleh kosong`,
                        });
                    } else {
                        let qty = 0

                        if (req.params.action === 'change') {
                            qty = req.body.qty
                        } else if (req.params.action === 'add') {
                            qty = parsingCart.qty + 1
                        } else if (req.params.action === 'less') {
                            qty = parsingCart.qty - 1
                        }

                        if (qty > checkItemExist.stock) {
                            return Promise.reject({
                                replaceCode: 400,
                                replaceMessage: `kuantitas tidak boleh lebih dari stok`,
                            });
                        }
                    }
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

const deleteCart = () => [
    check('id')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('format tidak boleh kosong')
        .isNumeric()
        .withMessage('format harus angka')
        .bail(),

    body().custom(async ({ }, { req }) => {
        try {
            let checkCartExist = await models.cart.findOne({
                where: {
                    id: req.params.id,
                }
            })

            if (req.params.id && !checkCartExist) {
                return Promise.reject({
                    replaceCode: 404,
                    replaceMessage: `data tidak ditemukan`,
                });
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
        global.helper.responseErrorValidator
    ],
    changeQty: [
        changeQty(),
        global.helper.responseErrorValidator
    ],
    deleteCart: [
        deleteCart(),
        global.helper.responseErrorValidator
    ],
};