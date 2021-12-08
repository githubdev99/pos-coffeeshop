const { Op, fn, col } = require('sequelize')
const { check, body } = require('express-validator')
const models = global.modules('config').core.models();

const postLogin = () => [
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
            } else if (req.body.password && parsingAdmin && !(await global.modules('helper').main.verifyPassword(req.body.password, parsingAdmin.password))) {
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
                let token = global.modules('helper').main.jwtDecode(global.modules('helper').main.decryptText(headerAuth.split(' ')[1]))

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

const postUser = () => [
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
            let checkUsernameExist = await models.admin.findOne({
                where: {
                    username: req.body.username.toLowerCase(),
                }
            })

            if (req.body.username && checkUsernameExist) {
                return Promise.reject({
                    replaceCode: 409,
                    replaceMessage: 'username sudah di input',
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
    postLogin: [
        postLogin(),
        global.modules('helper').main.responseErrorValidator
    ],
    privateRoute: [
        privateRoute(),
        global.modules('helper').main.responseErrorValidator
    ],
    postUser: [
        postUser(),
        global.modules('helper').main.responseErrorValidator
    ],
};