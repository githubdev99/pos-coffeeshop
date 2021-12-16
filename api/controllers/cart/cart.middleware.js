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

            if (req.body.itemCategoryId && !checkItemExist) {
                return Promise.reject({
                    replaceCode: 404,
                    replaceMessage: `menu tidak ditemukan`,
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
        global.modules('helper').main.responseErrorValidator
    ],
};