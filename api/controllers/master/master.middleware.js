const { Op, fn, col } = require('sequelize')
const { check, body } = require('express-validator')
const models = global.modules('config').core.models();

const checkMasterType = () => [
    body().custom(async ({ }, { req }) => {
        let type = ['option', 'list']

        try {
            if (!req.params.type || !type.includes(req.params.type)) {
                return Promise.reject({
                    replaceCode: 404,
                    replaceMessage: `tipe ${req.params.type} tidak ditemukan, tipe yang valid adalah ${type.join()}`,
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
    checkMasterType: [
        checkMasterType(),
        global.modules('helper').main.responseErrorValidator
    ]
};