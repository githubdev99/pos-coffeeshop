var express = require('express');
var router = express.Router();

router.post('/', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').user.postUser
], global.modules('controller').user.postUser);
router.get('/profile', [
    global.modules('middleware').auth.privateRoute
], global.modules('controller').user.getProfile);
router.put('/profile', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').user.updateProfile
], global.modules('controller').user.updateProfile);
router.get('/:type', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').master.checkMasterType
], global.modules('controller').user.getUser);
router.get('/detail/:id', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').user.getUserDetail
], global.modules('controller').user.getUserDetail);

module.exports = router;