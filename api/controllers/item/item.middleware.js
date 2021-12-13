const { Op, fn, col } = require('sequelize')
const { check, body } = require('express-validator')
const models = global.modules('config').core.models();

const addCategory = () => [
    check('name')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('format tidak boleh kosong')
        .bail(),

    body().custom(async ({ }, { req }) => {
        try {
            let checkDataInserted = await models.item_category.findOne({
                where: {
                    name: req.body.name.toLowerCase(),
                }
            })

            if (req.body.name && checkDataInserted) {
                return Promise.reject({
                    replaceCode: 409,
                    replaceMessage: `kategori ${req.body.name} sudah di input`,
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

const editCategory = () => [
    check('id')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('format tidak boleh kosong')
        .isNumeric()
        .withMessage('format harus angka')
        .bail(),

    check('name')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('format tidak boleh kosong')
        .bail(),

    body().custom(async ({ }, { req }) => {
        try {
            let checkDataExist = await models.item_category.findOne({
                where: {
                    id: req.params.id
                }
            })

            if (!checkDataExist) {
                return Promise.reject({
                    replaceCode: 404,
                    replaceMessage: 'data tidak ditemukan',
                });
            } else {
                let checkDataInserted = await models.item_category.findOne({
                    where: {
                        name: req.body.name.toLowerCase(),
                        id: {
                            [Op.ne]: req.params.id
                        }
                    }
                })

                if (req.body.name && checkDataInserted) {
                    return Promise.reject({
                        replaceCode: 409,
                        replaceMessage: `kategori ${req.body.name} sudah di input`,
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
    addCategory: [
        addCategory(),
        global.modules('helper').main.responseErrorValidator
    ],
    editCategory: [
        editCategory(),
        global.modules('helper').main.responseErrorValidator
    ],
};