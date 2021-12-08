const { Op, fn, col } = require('sequelize')
const models = global.modules('config').core.models()

const configGetBank = () => {
    let column = [
        {
            name: 'No.',
            field: 'no',
            isOrder: false,
            inActive: false,
            value: '',
            valueSearch: '',
            order: '',
        },
        {
            name: 'Nama',
            field: 'name',
            isOrder: true,
            inActive: false,
            value: 'default-name',
            valueSearch: 'default-name',
            order: '',
        },
        {
            name: 'Singkatan',
            field: 'shortName',
            isOrder: true,
            inActive: false,
            value: 'default-short',
            valueSearch: 'default-short',
            order: '',
        },
    ]

    return {
        column: column
    }
}

exports.getGender = async (req, res) => {
    let output = {};

    try {
        let parsingGender = await models.gender.findAll()

        output.status = {
            code: 200,
            message: 'sukses mendapat data',
        }

        output.data = parsingGender;
    } catch (error) {
        output.status = {
            code: 500,
            message: error.message
        }
    }

    res.status(output.status.code).send(output);
};

exports.getRole = async (req, res) => {
    let output = {};

    try {
        let parsingRole = await models.role.findAll({
            where: {
                id: {
                    [Op.ne]: 1
                }
            }
        })

        output.status = {
            code: 200,
            message: 'sukses mendapat data',
        }

        output.data = parsingRole;
    } catch (error) {
        output.status = {
            code: 500,
            message: error.message
        }
    }

    res.status(output.status.code).send(output);
};

exports.getBank = async (req, res) => {
    let output = {};

    try {
        let page = (req.query.page) ? parseInt(req.query.page) : 1
        let limit = (req.query.limit) ? parseInt(req.query.limit) : 10
        let sort = (req.query.sort) ? req.query.sort.split('-') : []

        let data = {}
        let column = configGetBank().column
        let paramBank = {}

        let columnSearch = (req.query.keyword) ? column.map((itemColumn) => {
            let valueSearch = itemColumn.valueSearch.split('-')

            let dataColumn = {}
            if (itemColumn.isOrder) {
                if (valueSearch[0] === 'default') {
                    dataColumn = {
                        [valueSearch[1]]: {
                            [Op.like]: `%${req.query.keyword}%`
                        }
                    }
                }
            }

            return dataColumn
        }) : []

        paramBank.where = {
            ...(req.query.keyword) ? (req.params.type === 'option') ? {
                name: {
                    [Op.like]: `%${req.query.keyword}%`
                }
            } : {
                [Op.or]: columnSearch
            } : {},
        }

        paramBank.order = [['name', 'ASC']]
        if (req.query.sort) {
            if (sort[0] === 'default') {
                paramBank.order = [
                    [sort[1], sort[2]],
                ]
            }
        }

        paramBank.limit = limit
        paramBank.offset = (page - 1) * limit

        let parsingBank = await models.bank.findAndCountAll(paramBank)

        let totalData = parsingBank.count;
        let totalPage = Math.ceil(parsingBank.count / limit);

        data.path = req.originalUrl;
        data.limit = limit;
        data.totalData = parsingBank.count;
        data.totalPage = totalPage;
        data.keyword = req.query.keyword
        data.sort = req.query.sort

        let no = (totalData > 0) ? (page - 1) * limit + 1 : 0
        data.items = await Promise.all(parsingBank.rows.map(async (items) => {
            let dataItems = {}

            dataItems.no = no
            dataItems.id = items.id
            dataItems.name = items.name
            dataItems.code = items.code
            dataItems.rtgs = items.rtgs
            dataItems.shortName = items.short
            dataItems.bankCode = items.bank_code

            no++

            return dataItems
        }))

        output.status = {
            code: 200,
            message: 'sukses mendapat data',
        }

        output.data = data;
        output.column = (req.params.type === 'option') ? [] : column.map((itemColumn, indexColumn) => {
            return {
                name: itemColumn.name,
                field: itemColumn.field,
                isOrder: itemColumn.isOrder,
                inActive: (sort[1] === itemColumn.value.split('-')[1]) ? true : false,
                value: itemColumn.value,
                valueSearch: itemColumn.valueSearch,
                order: (sort[1] === itemColumn.value.split('-')[1]) ? sort[2] : '',
            }
        });
    } catch (error) {
        output.status = {
            code: 500,
            message: error.message
        }
    }

    res.status(output.status.code).send(output);
};