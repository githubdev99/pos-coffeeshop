const { Op, fn, col } = require('sequelize')
const models = global.modules('config').core.models()

exports.postLogin = async (req, res) => {
    let output = {};

    try {
        let data = {}
        let paramUserAccount = {}

        paramUserAccount.where = {
            email: req.body.email,
        }

        paramUserAccount.include = [
            {
                model: models.gender,
                as: 'gender',
                required: true,
            },
            {
                model: models.company,
                as: 'company',
                required: false,
            },
            {
                model: models.role,
                as: 'role',
                required: true,
            },
        ]

        let parsingUserAccount = await models.admin.findOne(paramUserAccount)

        data = global.modules('helper').main.encryptText(global.modules('helper').main.jwtEncode({
            id: parsingUserAccount.id,
            roleId: parsingUserAccount.role.id,
        }))

        output.status = {
            code: 200,
            message: 'sukses mendapat data',
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