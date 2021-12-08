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
            include: {
                model: models.company_bank,
                as: 'company_banks',
                required: false,
                include: {
                    model: models.bank,
                    as: 'bank',
                    required: true,
                },
            }
        },
        {
            model: models.role,
            as: 'role',
            required: true,
        },
    ]

    let parsingUserAccount = await models.user.findOne(paramUserAccount)

    data.id = parsingUserAccount.id
    data.name = parsingUserAccount.name
    data.birthDate = parsingUserAccount.birth_date
    data.phoneNumber = parsingUserAccount.phone_number
    data.email = parsingUserAccount.email
    data.isActive = parsingUserAccount.isActive
    data.createdAt = core.moment(parsingUserAccount.created_at).format('YYYY-MM-DD HH:mm:ss')
    data.updatedAt = (parsingUserAccount.updated_at) ? core.moment(parsingUserAccount.updated_at).format('YYYY-MM-DD HH:mm:ss') : null
    data.gender = {
        id: parsingUserAccount.gender.id,
        name: parsingUserAccount.gender.name,
    }
    data.company = (parsingUserAccount.company) ? {
        id: parsingUserAccount.company.id,
        name: parsingUserAccount.company.name,
        address: parsingUserAccount.company.address,
        phoneNumber: parsingUserAccount.company.phone_number,
        fax: parsingUserAccount.company.fax,
        taxNumber: parsingUserAccount.company.tax_number,
        website: parsingUserAccount.company.website,
        isActive: parsingUserAccount.company.is_active,
        bank: (parsingUserAccount.company.company_banks.length) ? await Promise.all(parsingUserAccount.company.company_banks.map(async (items) => {
            return {
                id: items.id,
                name: items.name,
                branch: items.branch,
                address: items.address,
                accountNumber: items.account_number,
                accountName: items.account_name,
                detail: {
                    id: items.bank.id,
                    code: items.bank.code,
                    name: items.bank.name,
                },
            }
        })) : []
    } : {}
    data.role = {
        id: parsingUserAccount.role.id,
        name: parsingUserAccount.role.name,
    }

    return data
}

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