var express = require('express');
var router = express.Router();

router.get('/gender', global.modules('controller').master.getGender);
router.get('/role', global.modules('controller').master.getRole);
router.get('/bank/:type', [
    global.modules('middleware').auth.privateRoute,
    global.modules('middleware').master.checkMasterType
], global.modules('controller').master.getBank);

module.exports = router;