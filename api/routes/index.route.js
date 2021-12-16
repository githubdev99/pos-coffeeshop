var express = require('express');
var router = express.Router();

router.get('/', function (req, res, next) {
	res.render('index', { title: 'POS Coffee Shop API' });
});

// Routing Base Endpoint
router.use('/auth', global.modules('route').auth);
router.use('/item', global.modules('route').item);
router.use('/cart', global.modules('route').cart);

module.exports = router;
