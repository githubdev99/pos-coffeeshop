const { Op, fn, col } = require('sequelize')
const models = global.modules('config').core.models()

exports.addCart = async (req, res) => {
    let output = {};

    try {
        let insert = await models.item.create({
            item_category_id: req.body.itemCategoryId,
            name: req.body.name,
            description: req.body.description,
            stock: req.body.stock,
            price: req.body.price,
        })

        if (!insert) {
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