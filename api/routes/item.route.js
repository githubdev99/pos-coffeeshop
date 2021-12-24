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
router.put('/category/status/:id', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').item.editCategoryStatus,
], global.modules('controller').item.editCategoryStatus);
router.get('/category', [
    global.modules('middleware').auth.privateRoute,
], global.modules('controller').item.getCategory);

router.post('/', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').item.addItem,
], global.modules('controller').item.addItem);
router.put('/:id', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').item.editItem,
], global.modules('controller').item.editItem);
router.put('/status/:id', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').item.editItemStatus,
], global.modules('controller').item.editItemStatus);
router.get('/', [
    global.modules('middleware').auth.privateRoute,
], global.modules('controller').item.getItem);
router.post('/upload-file', [
    global.modules('middleware').auth.privateRoute,
    global.helper.uploadFile,
    global.modules('middleware').item.uploadFile,
], global.modules('controller').item.uploadFile);

module.exports = router;