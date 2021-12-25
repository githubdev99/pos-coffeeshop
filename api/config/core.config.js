require('dotenv').config()

global.core = {}

global.core.dotenv = process.env
global.core.CryptoJS = require("crypto-js")
global.core.bcrypt = require("bcrypt")
global.core.moment = require('moment')
global.core.axios = require('axios')
global.core.fs = require('fs')
global.core.pathImageItem = `http://localhost/pos-coffeeshop/api/assets/img/items/`
global.core.noImageItem = `http://localhost/pos-coffeeshop/api/assets/img/img-item-thumbnail.png`

global.core.dbConnect = () => {
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

global.core.models = () => {
    const initModels = require(`${process.cwd()}/models/init-models`);
    const models = initModels(global.core.dbConnect());

    return models;
}

global.core.dataAuth = async (authorization) => {
    let models = global.core.models()
    let data = {}
    let token = global.helper.jwtDecode(global.helper.decryptText(authorization))

    let paramUserAccount = {}

    paramUserAccount.where = {
        id: token.id,
    }

    let parsingUserAccount = await models.admin.findOne(paramUserAccount)

    data.id = parsingUserAccount.id
    data.name = parsingUserAccount.name

    return data
}

global.core.dataCart = async (adminId) => {
    let models = global.core.models()
    let data = {}
    let paramData = {}

    paramData.where = {
        admin_id: adminId,
    }
    paramData.include = [
        {
            model: models.item,
            as: 'item',
            required: true,
        },
    ]
    paramData.order = [['id', 'DESC']]

    let parsingData = await models.cart.findAll(paramData)

    data.totalQty = 0
    data.totalPrice = 0
    data.totalPriceCurrencyFormat = global.helper.rupiah(data.totalPrice)

    let totalQty = []
    let totalPrice = []
    data.items = await Promise.all(parsingData.map(async (items) => {
        let dataItems = {}

        dataItems.id = items.id
        dataItems.itemId = items.item.id
        dataItems.name = items.item.name
        dataItems.image = (items.item.image) ? `${global.core.pathImageItem}${items.item.image}` : global.core.noImageItem
        dataItems.stock = items.item.stock
        dataItems.qty = items.qty
        dataItems.price = items.item.price
        dataItems.priceCurrencyFormat = global.helper.rupiah(dataItems.price)
        dataItems.totalPrice = (items.item.price * items.qty)
        dataItems.totalPriceCurrencyFormat = global.helper.rupiah(dataItems.totalPrice)

        totalQty.push(dataItems.qty)
        totalPrice.push(dataItems.totalPrice)

        return dataItems
    }))

    data.totalQty = global.helper.sumArray(totalQty)
    data.totalPrice = global.helper.sumArray(totalPrice)
    data.totalPriceCurrencyFormat = global.helper.rupiah(data.totalPrice)

    return data
}

global.core.generateBillCode = async (adminId) => {
    let models = global.core.models()
    let getMaxCode = await models.bill.max('bill', {
        where: {
            admin_id: adminId
        }
    })
    let generateCode = (getMaxCode) ? parseInt(getMaxCode.split('-')[1]) + 1 : 1

    let code = "" + generateCode
    let padCode = "0000"

    return `BILL-${padCode.substring(0, padCode.length - code.length) + generateCode}`
}