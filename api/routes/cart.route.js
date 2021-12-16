var express = require('express');
var router = express.Router();

router.post('/', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').cart.addCart,
], global.modules('controller').cart.addCart);

module.exports = router;