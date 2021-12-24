var express = require('express');
var router = express.Router();

router.post('/checkout', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').bill.addCheckout,
], global.modules('controller').bill.addCheckout);
router.get('/', [
    global.modules('middleware').auth.privateRoute,
], global.modules('controller').bill.getBill);
router.get('/:id', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').bill.getBillDetail,
], global.modules('controller').bill.getBillDetail);

module.exports = router;