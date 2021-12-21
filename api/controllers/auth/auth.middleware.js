const { Op, fn, col } = require('sequelize')
const { check, body } = require('express-validator')
const models = global.core.models();

const login = () => [
    check('username')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('format tidak boleh kosong')
        .bail(),

    check('password')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('format tidak boleh kosong')
        .bail(),

    body().custom(async ({ }, { req }) => {
        try {
            let parsingAdmin = await models.admin.findOne({
                where: {
                    username: req.body.username.toLowerCase(),
                },
            })

            if (req.body.username && !parsingAdmin) {
                return Promise.reject({
                    replaceCode: 404,
                    replaceMessage: 'username tidak ditemukan',
                });
            } else if (req.body.password && parsingAdmin && !(await global.helper.verifyPassword(req.body.password, parsingAdmin.password))) {
                return Promise.reject({
                    replaceCode: 400,
                    replaceMessage: 'username atau password salah',
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

const privateRoute = () => [
    body().custom(async ({ }, { req }) => {
        try {
            let headerAuth = req.headers.authorization

            if (!headerAuth || (headerAuth && (headerAuth.split(' ')[0] !== 'Bearer'))) {
                return Promise.reject({
                    replaceCode: 401,
                    replaceMessage: 'autentikasi tidak valid',
                });
            } else {
                let token = global.helper.jwtDecode(global.helper.decryptText(headerAuth.split(' ')[1]))

                if (!token) {
                    return Promise.reject({
                        replaceCode: 401,
                        replaceMessage: 'autentikasi tidak valid',
                    });
                } else {
                    if (token.isError) {
                        if (token.name === 'TokenExpiredError') {
                            return Promise.reject({
                                replaceCode: 401,
                                replaceMessage: 'maaf sesi telah habis, silahkan login kembali',
                            });
                        } else {
                            return Promise.reject({
                                replaceCode: 401,
                                replaceMessage: 'autentikasi tidak valid',
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

const addUser = () => [
    check('username')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('format tidak boleh kosong')
        .bail(),

    check('password')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('format tidak boleh kosong')
        .bail(),

    check('name')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('format tidak boleh kosong')
        .bail(),

    body().custom(async ({ }, { req }) => {
        try {
            let checkDataInserted = await models.admin.findOne({
                where: {
                    username: req.body.username.toLowerCase(),
                }
            })

            if (req.body.username && checkDataInserted) {
                return Promise.reject({
                    replaceCode: 409,
                    replaceMessage: `username ${req.body.username} sudah di input`,
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
    login: [
        login(),
        global.helper.responseErrorValidator
    ],
    privateRoute: [
        privateRoute(),
        global.helper.responseErrorValidator
    ],
    addUser: [
        addUser(),
        global.helper.responseErrorValidator
    ],
};