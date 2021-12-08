var express = require('express');
var router = express.Router();

router.post('/login', [
    global.modules('middleware').auth.postLogin
], global.modules('controller').auth.postLogin);

router.post('/admin', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').auth.postUser
], global.modules('controller').auth.postUser);

module.exports = router;