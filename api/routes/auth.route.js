var express = require('express');
var router = express.Router();

router.post('/login', [
    global.modules('middleware').auth.postLogin
], global.modules('controller').auth.postLogin);

module.exports = router;