var express = require('express');
var router = express.Router();

router.post('/login', [
    global.modules('middleware').auth.login
], global.modules('controller').auth.login);

router.post('/admin', [
    global.modules('middleware').auth.addUser
], global.modules('controller').auth.addUser);

module.exports = router;