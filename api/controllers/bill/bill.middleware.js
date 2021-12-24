const { Op, fn, col } = require('sequelize')
const { check, body } = require('express-validator')
const models = global.core.models();

const addCheckout = () => [
    check('customerName')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('format tidak boleh kosong')
        .bail(),

    body().custom(async ({ }, { req }) => {
        try {
            let dataAuth = await global.core.dataAuth(req.headers.authorization.split(' ')[1])

            let checkDataNotEmpty = await models.cart.findOne({
                where: {
                    admin_id: dataAuth.id,
                }
            })

            if (!checkDataNotEmpty) {
                return Promise.reject({
                    replaceCode: 400,
                    replaceMessage: `keranjang belanja kosong`,
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
    addCheckout: [
        addCheckout(),
        global.helper.responseErrorValidator
    ],
};