var createError = require('http-errors');
var express = require('express');
var path = require('path');
var cookieParser = require('cookie-parser');
const cors = require("cors");
var logger = require('morgan');
const helmet = require("helmet");

var app = express();

// Global Module
global.modules = (module) => {
	let modules = {
		config: {
			core: require(`${process.cwd()}/config/core.config`),
		},
		helper: {
			main: require(`${process.cwd()}/helper/main.helper`),
		},
		route: {
			auth: require(`${process.cwd()}/routes/auth.route`),
			item: require(`${process.cwd()}/routes/item.route`),
			cart: require(`${process.cwd()}/routes/cart.route`),
		},
		middleware: {
			auth: require(`${process.cwd()}/controllers/auth/auth.middleware`),
			item: require(`${process.cwd()}/controllers/item/item.middleware`),
			cart: require(`${process.cwd()}/controllers/cart/cart.middleware`),
		},
		controller: {
			auth: require(`${process.cwd()}/controllers/auth/auth.controller`),
			item: require(`${process.cwd()}/controllers/item/item.controller`),
			cart: require(`${process.cwd()}/controllers/cart/cart.controller`),
		},
	}

	return modules[module]
}
// End Global Module

app.use(helmet());

app.use(cors({
	origin: "*",
	methods: ['GET', 'POST', 'PATCH', 'DELETE', 'PUT'],
	allowedHeaders: 'Content-Type, Authorization, Origin, X-Requested-With, Accept'
}));

// view engine setup
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'ejs');

app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));

app.use('/', require('./routes/index.route'));

// catch 404 and forward to error handler
app.use(function (req, res, next) {
	// next(createError(404));

	res.status(500).send({
		status: {
			code: 500,
			message: 'Endpoint tidak ditemukan'
		}
	});
});

// error handler
app.use(function (err, req, res, next) {
	// set locals, only providing error in development
	res.locals.message = err.message;
	res.locals.error = req.app.get('env') === 'development' ? err : {};

	// render the error page
	res.status(err.status || 500);
	res.render('error', {
		title: 'POS Coffee Shop API',
		message: err.message,
		error: err
	});
});

module.exports = app;
