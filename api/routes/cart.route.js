var express = require('express');
var router = express.Router();

router.post('/', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').cart.addCart,
], global.modules('controller').cart.addCart);
router.get('/', [
    global.modules('middleware').auth.privateRoute,
], global.modules('controller').cart.getCart);
router.put('/qty/:action', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').cart.changeQty,
], global.modules('controller').cart.changeQty);
router.delete('/:id', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').cart.deleteCart,
], global.modules('controller').cart.deleteCart);

module.exports = router;