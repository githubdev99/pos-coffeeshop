const { Op, fn, col } = require('sequelize')
const models = global.modules('config').core.models()

const configGetUser = () => {
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
            name: 'Email',
            field: 'email',
            isOrder: true,
            inActive: false,
            value: 'default-email',
            valueSearch: 'default-email',
            order: '',
        },
        {
            name: 'Perusahaan',
            field: 'company',
            isOrder: true,
            inActive: false,
            value: 'company-name',
            valueSearch: 'company-name',
            order: '',
        },
        {
            name: 'Jabatan',
            field: 'role',
            isOrder: true,
            inActive: false,
            value: 'role-name',
            valueSearch: 'role-name',
            order: '',
        },
        {
            name: 'Status',
            field: 'isActive',
            isOrder: true,
            inActive: false,
            value: 'default-is_active',
            valueSearch: 'default-is_active',
            order: '',
        },
        {
            name: 'Tgl Register',
            field: 'createdAt',
            isOrder: true,
            inActive: false,
            value: 'default-created_at',
            valueSearch: 'default-created_at',
            order: '',
        },
        {
            name: 'Tgl Update',
            field: 'updatedAt',
            isOrder: true,
            inActive: false,
            value: 'default-updated_at',
            valueSearch: 'default-updated_at',
            order: '',
        },
        {
            name: 'Opsi',
            field: '',
            isOrder: false,
            inActive: false,
            value: '',
            valueSearch: '',
            order: '',
        },
    ]

    return {
        column: column
    }
}

exports.postUser = async (req, res) => {
    let output = {};

    try {
        let insertUser = await models.admin.create({
            name: req.body.name,
            birth_date: global.modules('config').core.moment(req.body.birthDate).format('YYYY-MM-DD'),
            phone_number: global.modules('helper').main.formatPhoneNumber(req.body.phoneNumber) || null,
            email: req.body.email,
            password: await global.modules('helper').main.hashPassword(req.body.password),
            gender_id: req.body.genderId,
            company_id: req.body.companyId || null,
            role_id: 2,
            created_at: Date.now(),
            updated_at: Date.now(),
        })

        if (!insertUser) {
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

exports.getUser = async (req, res) => {
    let output = {};
    let dataAuth = await global.modules('config').core.dataAuth(req.headers.authorization.split(' ')[1])

    try {
        let page = (req.query.page) ? parseInt(req.query.page) : 1
        let limit = (req.query.limit) ? parseInt(req.query.limit) : 10
        let sort = (req.query.sort) ? req.query.sort.split('-') : []

        let data = {}
        let column = configGetUser().column
        let paramUser = {}

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
                } else {
                    dataColumn = {
                        [`$${valueSearch[0]}.${valueSearch[1]}$`]: {
                            [Op.like]: `%${req.query.keyword}%`
                        }
                    }
                }
            }

            return dataColumn
        }) : []

        paramUser.where = {
            ...(dataAuth.role.id !== 1) ? {
                role_id: {
                    [Op.ne]: 1,
                },
                company_id: dataAuth.company.id,
            } : {},
            ...(req.params.type === 'option') ? {
                is_active: 1
            } : {},
            ...(req.query.keyword) ? (req.params.type === 'option') ? {
                name: {
                    [Op.like]: `%${req.query.keyword}%`
                }
            } : {
                [Op.or]: columnSearch
            } : {},
        }

        paramUser.include = [
            {
                model: models.gender,
                as: 'gender',
                required: true,
            },
            {
                model: models.company,
                as: 'company',
                required: true,
            },
            {
                model: models.role,
                as: 'role',
                required: true,
            },
        ]

        paramUser.order = [['name', 'ASC']]
        if (req.query.sort) {
            if (sort[0] === 'default') {
                paramUser.order = [
                    [sort[1], sort[2]],
                ]
            } else {
                paramUser.order = [
                    [sort[0], sort[1], sort[2]],
                ]
            }
        }

        paramUser.limit = limit
        paramUser.offset = (page - 1) * limit

        let parsingUser = await models.admin.findAndCountAll(paramUser)

        let totalData = parsingUser.count;
        let totalPage = Math.ceil(parsingUser.count / limit);

        data.path = req.originalUrl;
        data.limit = limit;
        data.totalData = parsingUser.count;
        data.totalPage = totalPage;
        data.keyword = req.query.keyword
        data.sort = req.query.sort

        let no = (totalData > 0) ? (page - 1) * limit + 1 : 0
        data.items = await Promise.all(parsingUser.rows.map(async (items) => {
            let dataItems = {}

            dataItems.no = no
            dataItems.id = items.id
            dataItems.name = items.name
            dataItems.birthDate = items.birth_date
            dataItems.phoneNumber = items.phone_number
            dataItems.email = items.email
            dataItems.company = (items.company) ? {
                id: items.company.id,
                name: items.company.name,
                isActive: items.company.is_active,
            } : {}
            dataItems.role = {
                id: items.role.id,
                name: items.role.name,
            }
            dataItems.isActive = items.isActive
            dataItems.createdAt = global.modules('config').core.moment(items.created_at).format('YYYY-MM-DD HH:mm:ss')
            dataItems.updatedAt = (items.updated_at) ? global.modules('config').core.moment(items.updated_at).format('YYYY-MM-DD HH:mm:ss') : null
            dataItems.gender = {
                id: items.gender.id,
                name: items.gender.name,
            }

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

exports.getProfile = async (req, res) => {
    let output = {};
    let dataAuth = await global.modules('config').core.dataAuth(req.headers.authorization.split(' ')[1])

    try {
        output.status = {
            code: 200,
            message: 'sukses mendapat data',
        }

        output.data = dataAuth
    } catch (error) {
        output.status = {
            code: 500,
            message: error.message
        }
    }

    res.status(output.status.code).send(output);
};

exports.updateProfile = async (req, res) => {
    let output = {};
    let dataAuth = await global.modules('config').core.dataAuth(req.headers.authorization.split(' ')[1])

    try {
        let updateUser = await models.admin.update({
            name: req.body.name,
            birth_date: global.modules('config').core.moment(req.body.birthDate).format('YYYY-MM-DD'),
            phone_number: global.modules('helper').main.formatPhoneNumber(req.body.phoneNumber) || null,
            gender_id: req.body.genderId,
            updated_at: Date.now(),
        }, {
            where: {
                id: dataAuth.id,
            },
        })

        if (!updateUser) {
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