var express = require('express');
var router = express.Router();

router.post('/category', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').item.addCategory,
], global.modules('controller').item.addCategory);
router.put('/category/:id', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').item.editCategory,
], global.modules('controller').item.editCategory);
router.post('/', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').item.addItem,
], global.modules('controller').item.addItem);

// TODO lanjutin fungsi testing upload file
router.post('/testUploadFile', [
    global.modules('middleware').auth.privateRoute,
], global.modules('controller').item.testUploadFile);
module.exports = router;