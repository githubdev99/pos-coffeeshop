var express = require('express');
var router = express.Router();

router.get('/', function (req, res, next) {
	res.render('index', { title: 'Elogs API' });
});

// Routing Base Endpoint
router.use('/auth', global.modules('route').auth);
router.use('/master', global.modules('route').master);
router.use('/user', global.modules('route').user);

module.exports = router;
