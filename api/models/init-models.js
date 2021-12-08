var DataTypes = require("sequelize").DataTypes;
var _account = require("./account");
var _account_category = require("./account_category");
var _bank = require("./bank");
var _company = require("./company");
var _company_bank = require("./company_bank");
var _company_tax = require("./company_tax");
var _gender = require("./gender");
var _product_category = require("./product_category");
var _product_unit_type = require("./product_unit_type");
var _role = require("./role");
var _user = require("./user");

function initModels(sequelize) {
  var account = _account(sequelize, DataTypes);
  var account_category = _account_category(sequelize, DataTypes);
  var bank = _bank(sequelize, DataTypes);
  var company = _company(sequelize, DataTypes);
  var company_bank = _company_bank(sequelize, DataTypes);
  var company_tax = _company_tax(sequelize, DataTypes);
  var gender = _gender(sequelize, DataTypes);
  var product_category = _product_category(sequelize, DataTypes);
  var product_unit_type = _product_unit_type(sequelize, DataTypes);
  var role = _role(sequelize, DataTypes);
  var user = _user(sequelize, DataTypes);

  account.belongsTo(account_category, { as: "account_category", foreignKey: "account_category_id"});
  account_category.hasMany(account, { as: "accounts", foreignKey: "account_category_id"});
  account.belongsTo(bank, { as: "bank", foreignKey: "bank_id"});
  bank.hasMany(account, { as: "accounts", foreignKey: "bank_id"});
  company_bank.belongsTo(bank, { as: "bank", foreignKey: "bank_id"});
  bank.hasMany(company_bank, { as: "company_banks", foreignKey: "bank_id"});
  account.belongsTo(company, { as: "company", foreignKey: "company_id"});
  company.hasMany(account, { as: "accounts", foreignKey: "company_id"});
  company_bank.belongsTo(company, { as: "company", foreignKey: "company_id"});
  company.hasMany(company_bank, { as: "company_banks", foreignKey: "company_id"});
  product_category.belongsTo(company, { as: "company", foreignKey: "company_id"});
  company.hasMany(product_category, { as: "product_categories", foreignKey: "company_id"});
  product_unit_type.belongsTo(company, { as: "company", foreignKey: "company_id"});
  company.hasMany(product_unit_type, { as: "product_unit_types", foreignKey: "company_id"});
  user.belongsTo(company, { as: "company", foreignKey: "company_id"});
  company.hasMany(user, { as: "users", foreignKey: "company_id"});
  account.belongsTo(company_tax, { as: "company_tax", foreignKey: "company_tax_id"});
  company_tax.hasMany(account, { as: "accounts", foreignKey: "company_tax_id"});
  user.belongsTo(gender, { as: "gender", foreignKey: "gender_id"});
  gender.hasMany(user, { as: "users", foreignKey: "gender_id"});
  user.belongsTo(role, { as: "role", foreignKey: "role_id"});
  role.hasMany(user, { as: "users", foreignKey: "role_id"});

  return {
    account,
    account_category,
    bank,
    company,
    company_bank,
    company_tax,
    gender,
    product_category,
    product_unit_type,
    role,
    user,
  };
}
module.exports = initModels;
module.exports.initModels = initModels;
module.exports.default = initModels;
