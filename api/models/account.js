const Sequelize = require('sequelize');
module.exports = function(sequelize, DataTypes) {
  return sequelize.define('account', {
    id: {
      autoIncrement: true,
      type: DataTypes.INTEGER,
      allowNull: false,
      primaryKey: true
    },
    number: {
      type: DataTypes.STRING(100),
      allowNull: false
    },
    name: {
      type: DataTypes.STRING(100),
      allowNull: false
    },
    description: {
      type: DataTypes.TEXT,
      allowNull: true
    },
    parent_id: {
      type: DataTypes.INTEGER,
      allowNull: false,
      defaultValue: 0
    },
    account_category_id: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: 'account_category',
        key: 'id'
      }
    },
    company_tax_id: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: 'company_tax',
        key: 'id'
      }
    },
    company_id: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: 'company',
        key: 'id'
      }
    },
    bank_id: {
      type: DataTypes.INTEGER,
      allowNull: true,
      references: {
        model: 'bank',
        key: 'id'
      }
    },
    account_number: {
      type: DataTypes.STRING(50),
      allowNull: true
    },
    balance: {
      type: DataTypes.BIGINT,
      allowNull: false,
      defaultValue: 0
    },
    created_at: {
      type: DataTypes.DATE,
      allowNull: false
    },
    updated_at: {
      type: DataTypes.DATE,
      allowNull: true
    }
  }, {
    sequelize,
    tableName: 'account',
    timestamps: false,
    indexes: [
      {
        name: "PRIMARY",
        unique: true,
        using: "BTREE",
        fields: [
          { name: "id" },
        ]
      },
      {
        name: "company_tax_id",
        using: "BTREE",
        fields: [
          { name: "company_tax_id" },
        ]
      },
      {
        name: "account_category_id",
        using: "BTREE",
        fields: [
          { name: "account_category_id" },
        ]
      },
      {
        name: "bank_id",
        using: "BTREE",
        fields: [
          { name: "bank_id" },
        ]
      },
      {
        name: "company_id",
        using: "BTREE",
        fields: [
          { name: "company_id" },
        ]
      },
    ]
  });
};
