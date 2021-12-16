require('dotenv').config()
const core = {};

core.dotenv = process.env
core.CryptoJS = require("crypto-js")
core.bcrypt = require("bcrypt")
core.moment = require('moment')

core.dbConnect = () => {
    const dbConfig = require(`${process.cwd()}/config/db.config`);
    const Sequelize = require("sequelize");

    return new Sequelize(dbConfig.DB, dbConfig.USER, dbConfig.PASSWORD, {
        host: dbConfig.HOST,
        dialect: dbConfig.dialect,
        operatorsAliases: false,
        pool: {
            max: dbConfig.pool.max,
            min: dbConfig.pool.min,
            acquire: dbConfig.pool.acquire,
            idle: dbConfig.pool.idle
        },
        timezone: "+07:00",
    });
}

core.models = () => {
    const initModels = require(`${process.cwd()}/models/init-models`);
    const models = initModels(core.dbConnect());

    return models;
}

core.dataAuth = async (authorization) => {
    let models = core.models()
    let data = {}
    let token = global.modules('helper').main.jwtDecode(global.modules('helper').main.decryptText(authorization))

    let paramUserAccount = {}

    paramUserAccount.where = {
        id: token.id,
    }

    let parsingUserAccount = await models.admin.findOne(paramUserAccount)

    data.id = parsingUserAccount.id
    data.name = parsingUserAccount.name

    return data
}

// TODO bisa buat generate code bill
core.generateNumberAccount = async (accountCategoryId) => {
    let models = core.models()
    let parsingAccountCategory = await models.account_category.findOne({
        where: {
            id: accountCategoryId
        }
    })
    let getMaxCode = await models.account.max('number', {
        where: {
            account_category_id: accountCategoryId
        }
    })
    let generateCode = (getMaxCode) ? parseInt(getMaxCode.split('-')[1]) + 1 : `${parsingAccountCategory.prefix_code}0001`

    return `${parsingAccountCategory.prefix_code}-${generateCode}`
}

module.exports = core;