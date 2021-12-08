const { Op, fn, col } = require('sequelize')
const { check, body } = require('express-validator')
const models = global.modules('config').core.models();

const postLogin = () => [
    check('email')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('format tidak boleh kosong')
        .isEmail()
        .withMessage('format email salah')
        .bail(),

    check('password')
        .trim()
        .escape()
        .notEmpty()
        .withMessage('format tidak boleh kosong')
        .bail(),

    body().custom(async ({ }, { req }) => {
        try {
            let parsingUserAccount = await models.user.findOne({
                where: {
                    email: req.body.email.toLowerCase(),
                },
                include: [
                    {
                        model: models.company,
                        as: 'company',
                        required: false,
                    },
                ]
            })

            if (req.body.email && !parsingUserAccount) {
                return Promise.reject({
                    replaceCode: 404,
                    replaceMessage: 'email tidak ditemukan',
                });
            } else if (req.body.password && parsingUserAccount && !(await global.modules('helper').main.verifyPassword(req.body.password, parsingUserAccount.password))) {
                return Promise.reject({
                    replaceCode: 400,
                    replaceMessage: 'email atau password salah',
                });
            } else {
                if (parsingUserAccount.company && !parsingUserAccount.company.is_active) {
                    return Promise.reject({
                        replaceCode: 400,
                        replaceMessage: 'perusahaan telah di nonaktifkan, silahkan hubungi admin',
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

const privateRouteSuperAdmin = () => [
    body().custom(async ({ }, { req }) => {
        let roleAllowed = [1]

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
                    } else if (!roleAllowed.includes(token.roleId)) {
                        return Promise.reject({
                            replaceCode: 401,
                            replaceMessage: 'maaf anda dilarang akses',
                        });
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

const privateRoute = () => [
    body().custom(async ({ }, { req }) => {
        let parsingRole = await models.role.findAll()

        let roleAllowed = parsingRole.map((item) => {
            return item.id
        })

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
                    } else if (!roleAllowed.includes(token.roleId)) {
                        return Promise.reject({
                            replaceCode: 401,
                            replaceMessage: 'maaf anda dilarang akses',
                        });
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

module.exports = {
    postLogin: [
        postLogin(),
        global.modules('helper').main.responseErrorValidator
    ],
    privateRouteSuperAdmin: [
        privateRouteSuperAdmin(),
        global.modules('helper').main.responseErrorValidator
    ],
    privateRoute: [
        privateRoute(),
        global.modules('helper').main.responseErrorValidator
    ],
};