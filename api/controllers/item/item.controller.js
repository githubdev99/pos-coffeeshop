const { Op, fn, col } = require('sequelize')
const models = global.core.models()

exports.addCategory = async (req, res) => {
    let output = {};

    try {
        let query = await models.item_category.create({
            name: req.body.name,
        })

        if (!query) {
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

exports.editCategory = async (req, res) => {
    let output = {};

    try {
        let query = await models.item_category.update({
            name: req.body.name,
        }, {
            where: {
                id: req.params.id
            }
        })

        if (!query) {
            output.status = {
                code: 400,
                message: 'gagal edit data',
            }
        } else {
            output.status = {
                code: 200,
                message: 'sukses edit data',
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

exports.editCategoryStatus = async (req, res) => {
    let output = {};

    try {
        let parsingData = await models.item_category.findOne({
            where: {
                id: req.params.id
            }
        })

        let isActive = (Boolean(parsingData.is_active)) ? 0 : 1

        let query = await models.item_category.update({
            is_active: isActive,
        }, {
            where: {
                id: req.params.id
            }
        })

        if (!query) {
            output.status = {
                code: 400,
                message: 'gagal edit status',
            }
        } else {
            output.status = {
                code: 200,
                message: 'sukses edit status',
            }
        }

        output.data = {
            isActive: Boolean(isActive)
        }
    } catch (error) {
        output.status = {
            code: 500,
            message: error.message
        }
    }

    res.status(output.status.code).send(output);
};

exports.getCategory = async (req, res) => {
    let output = {};

    try {
        let data = {}
        let paramData = {}

        paramData.where = {
            ...(req.query.isList && Boolean(Number(req.query.isList))) ? {} : {
                is_active: 1,
            }
        }
        paramData.order = [['name', 'ASC']]

        let parsingData = await models.item_category.findAll(paramData)

        data = await Promise.all(parsingData.map(async (items) => {
            let dataItems = {}

            dataItems.id = items.id
            dataItems.name = items.name
            dataItems.isActive = items.is_active

            return dataItems
        }))

        output.status = {
            code: 200,
            message: 'sukses mendapat data',
        }

        output.data = data;
    } catch (error) {
        output.status = {
            code: 500,
            message: error.message
        }
    }

    res.status(output.status.code).send(output);
};

// TODO belum ada fungsi upload foto
exports.addItem = async (req, res) => {
    let output = {};

    try {
        let query = await models.item.create({
            item_category_id: req.body.itemCategoryId,
            name: req.body.name,
            description: req.body.description,
            stock: req.body.stock,
            price: req.body.price,
        })

        if (!query) {
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

exports.editItem = async (req, res) => {
    let output = {};

    try {
        let query = await models.item.update({
            item_category_id: req.body.itemCategoryId,
            name: req.body.name,
            description: req.body.description,
            stock: req.body.stock,
            price: req.body.price,
        }, {
            where: {
                id: req.params.id
            }
        })

        if (!query) {
            output.status = {
                code: 400,
                message: 'gagal edit data',
            }
        } else {
            output.status = {
                code: 200,
                message: 'sukses edit data',
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

exports.editItemStatus = async (req, res) => {
    let output = {};

    try {
        let parsingData = await models.item.findOne({
            where: {
                id: req.params.id
            }
        })

        let isActive = (Boolean(parsingData.is_active)) ? 0 : 1

        let query = await models.item.update({
            is_active: isActive,
        }, {
            where: {
                id: req.params.id
            }
        })

        if (!query) {
            output.status = {
                code: 400,
                message: 'gagal edit status',
            }
        } else {
            output.status = {
                code: 200,
                message: 'sukses edit status',
            }
        }

        output.data = {
            isActive: Boolean(isActive)
        }
    } catch (error) {
        output.status = {
            code: 500,
            message: error.message
        }
    }

    res.status(output.status.code).send(output);
};

exports.getItem = async (req, res) => {
    let output = {};

    try {
        let data = {}
        let paramData = {}

        paramData.where = {
            ...(req.query.isList && Boolean(Number(req.query.isList))) ? {} : {
                is_active: 1,
            }
        }
        paramData.include = [
            {
                model: models.item_category,
                as: 'item_category',
                required: true,
            },
        ]
        paramData.order = [['name', 'ASC']]

        let parsingData = await models.item.findAll(paramData)

        data = await Promise.all(parsingData.map(async (items) => {
            let dataItems = {}

            dataItems.id = items.id
            dataItems.isActive = items.is_active
            dataItems.name = items.name
            dataItems.image = (items.image) ? `${global.core.pathImageItem}${items.image}` : global.core.noImageItem
            dataItems.qty = items.qty
            dataItems.price = items.price
            dataItems.priceCurrencyFormat = global.helper.rupiah(dataItems.price)

            return dataItems
        }))

        output.status = {
            code: 200,
            message: 'sukses mendapat data',
        }

        output.data = data;
    } catch (error) {
        output.status = {
            code: 500,
            message: error.message
        }
    }

    res.status(output.status.code).send(output);
};

// TODO lanjutin fungsi testing upload file
exports.testUploadFile = async (req, res) => {
    let output = {};

    try {
        output.status = {
            code: 200,
            message: 'sukses input data',
        }
    } catch (error) {
        output.status = {
            code: 500,
            message: error.message
        }
    }

    res.status(output.status.code).send(output);
};