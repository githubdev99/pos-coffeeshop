const { Op, fn, col } = require('sequelize')
const { check, body } = require('express-validator')
const models = global.modules('config').core.models();

const getUserDetail = () => [
    check('id')
        .trim()
        .escape()
        .isNumeric()
        .withMessage('format harus angka')
        .bail(),

    body().custom(async ({ }, { req }) => {
        try {
            let dataAuth = await global.modules('config').core.dataAuth(req.headers.authorization.split(' ')[1])

            let checkDataExist = await models.admin.findOne({
                where: {
                    id: req.params.id,
                    ...(dataAuth.role.id !== 1) ? {
                        role_id: {
                            [Op.ne]: 1,
                        },
                        company_id: dataAuth.company.id,
                    } : {},
                }
            })

            if (!checkDataExist) {
                return Promise.reject({
                    replaceCode: 404,
                    replaceMessage: 'data tidak ditemukan',
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

const postUser = () => [
    check('name')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('format tidak boleh kosong')
        .bail(),

    check('birthDate')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('format tidak boleh kosong')
        .bail(),

    check('phoneNumber')
        .trim()
        .escape()
        .optional({ checkFalsy: true })
        .isNumeric()
        .withMessage('format harus angka')
        .bail(),

    check('email')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('email tidak boleh kosong')
        .isEmail()
        .withMessage('format email salah')
        .bail(),

    check('password')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('format tidak boleh kosong')
        .bail(),

    check('genderId')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('silahkan pilih salah satu')
        .bail(),

    check('companyId')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('silahkan pilih salah satu')
        .bail(),

    body().custom(async ({ }, { req }) => {
        try {
            let checkEmailExist = await models.admin.findOne({
                where: {
                    email: req.body.email.toLowerCase(),
                }
            })

            let checkGenderExist = await models.gender.findOne({
                where: {
                    id: req.body.genderId,
                }
            })

            let checkCompanyExist = await models.company.findOne({
                where: {
                    id: req.body.companyId,
                }
            })

            if (req.body.email && checkEmailExist) {
                return Promise.reject({
                    replaceCode: 409,
                    replaceMessage: 'email sudah di input',
                });
            } else if (req.body.password !== req.body.confirmPassword) {
                return Promise.reject({
                    replaceCode: 400,
                    replaceMessage: 'password tidak sama',
                });
            } else if ((req.body.genderId && !checkGenderExist) || (req.body.companyId && !checkCompanyExist)) {
                return Promise.reject({
                    replaceCode: 404,
                    replaceMessage: 'data tidak ditemukan',
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

const updateProfile = () => [
    check('name')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('format tidak boleh kosong')
        .bail(),

    check('birthDate')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('format tidak boleh kosong')
        .bail(),

    check('phoneNumber')
        .trim()
        .escape()
        .optional({ checkFalsy: true })
        .isNumeric()
        .withMessage('format harus angka')
        .bail(),

    check('genderId')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('silahkan pilih salah satu')
        .bail(),

    body().custom(async ({ }, { req }) => {
        try {
            let checkGenderExist = await models.gender.findOne({
                where: {
                    id: req.body.genderId,
                }
            })

            if (!checkGenderExist) {
                return Promise.reject({
                    replaceCode: 404,
                    replaceMessage: 'data tidak ditemukan',
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
    getUserDetail: [
        getUserDetail(),
        global.modules('helper').main.responseErrorValidator
    ],
    postUser: [
        postUser(),
        global.modules('helper').main.responseErrorValidator
    ],
    updateProfile: [
        updateProfile(),
        global.modules('helper').main.responseErrorValidator
    ],
};