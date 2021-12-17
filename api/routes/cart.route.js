var express = require('express');
var router = express.Router();

router.post('/', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').cart.addCart,
], global.modules('controller').cart.addCart);

router.put('/qty/:action', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').cart.changeQty,
], global.modules('controller').cart.changeQty);

module.exports = router;