const { Op, fn, col } = require('sequelize')
const models = global.core.models()

exports.login = async (req, res) => {
    let output = {};

    try {
        let data = {}
        let paramAdmin = {}

        paramAdmin.where = {
            username: req.body.username,
        }

        let parsingAdmin = await models.admin.findOne(paramAdmin)

        data = global.helper.encryptText(global.helper.jwtEncode({
            id: parsingAdmin.id,
        }))

        output.status = {
            code: 200,
            message: 'berhasil login',
        }
        output.data = `Bearer ${data}`;
    } catch (error) {
        output.status = {
            code: 500,
            message: error.message
        }
    }

    res.status(output.status.code).send(output);
};

exports.addUser = async (req, res) => {
    let output = {};

    try {
        let insertAdmin = await models.admin.create({
            username: req.body.username,
            password: await global.helper.hashPassword(req.body.password),
            name: req.body.name,
        })

        if (!insertAdmin) {
            output.status = {
                code: 400,
                message: 'gagal input data',
            }
        } else {
            output.status = {
                code: 200,
                message: 'sukses input data',
            }
        }
    } catch (error) {
        output.status = {
            code: 500,
            message: error.message
        }
    }

    res.status(output.status.code).send(output);
};

exports.getProfile = async (req, res) => {
    let output = {};
    let dataAuth = await global.core.dataAuth(req.headers.authorization.split(' ')[1])

    try {
        output.status = {
            code: 200,
            message: 'sukses mendapat data',
        }
        output.data = dataAuth;
    } catch (error) {
        output.status = {
            code: 500,
            message: error.message
        }
    }

    res.status(output.status.code).send(output);
};