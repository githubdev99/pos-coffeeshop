var DataTypes = require("sequelize").DataTypes;
var _admin = require("./admin");
var _bill = require("./bill");
var _bill_detail = require("./bill_detail");
var _cart = require("./cart");
var _item = require("./item");
var _item_category = require("./item_category");

function initModels(sequelize) {
  var admin = _admin(sequelize, DataTypes);
  var bill = _bill(sequelize, DataTypes);
  var bill_detail = _bill_detail(sequelize, DataTypes);
  var cart = _cart(sequelize, DataTypes);
  var item = _item(sequelize, DataTypes);
  var item_category = _item_category(sequelize, DataTypes);

  bill.belongsTo(admin, { as: "admin", foreignKey: "admin_id"});
  admin.hasMany(bill, { as: "bills", foreignKey: "admin_id"});
  cart.belongsTo(admin, { as: "admin", foreignKey: "admin_id"});
  admin.hasMany(cart, { as: "carts", foreignKey: "admin_id"});
  bill_detail.belongsTo(bill, { as: "bill", foreignKey: "bill_id"});
  bill.hasMany(bill_detail, { as: "bill_details", foreignKey: "bill_id"});
  bill_detail.belongsTo(item, { as: "item", foreignKey: "item_id"});
  item.hasMany(bill_detail, { as: "bill_details", foreignKey: "item_id"});
  cart.belongsTo(item, { as: "item", foreignKey: "item_id"});
  item.hasMany(cart, { as: "carts", foreignKey: "item_id"});
  item.belongsTo(item_category, { as: "item_category", foreignKey: "item_category_id"});
  item_category.hasMany(item, { as: "items", foreignKey: "item_category_id"});

  return {
    admin,
    bill,
    bill_detail,
    cart,
    item,
    item_category,
  };
}
module.exports = initModels;
module.exports.initModels = initModels;
module.exports.default = initModels;
