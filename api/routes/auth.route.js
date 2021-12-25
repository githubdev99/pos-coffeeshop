var express = require('express');
var router = express.Router();

router.post('/login', [
    global.modules('middleware').auth.login
], global.modules('controller').auth.login);
router.post('/admin', [
    global.modules('middleware').auth.addUser
], global.modules('controller').auth.addUser);
router.get('/profile', [
    global.modules('middleware').auth.privateRoute,
], global.modules('controller').auth.getProfile);

module.exports = router;