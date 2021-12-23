require('dotenv').config()

global.helper = {};

const { validationResult } = require('express-validator')
const nodemailer = require('nodemailer')
const smtpTransport = require('nodemailer-smtp-transport')
const ejs = require('ejs')
const bcrypt = require("bcrypt")
const CryptoJS = require("crypto-js")
const jwt = require('jsonwebtoken')
const path = require('path')
const multer = require('multer')

const dotenv = process.env

global.helper.rupiah = (number) => {
    var reverse = number.toString().split("").reverse().join(""),
        ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join(".").split("").reverse().join("");
    return "Rp" + ribuan;
}

global.helper.formatThousand = (number) => {
    var reverse = number.toString().split("").reverse().join(""),
        ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join(".").split("").reverse().join("");
    return ribuan;
}

global.helper.responseErrorValidator = (req, res, next) => {
    let output = {};
    let statusCode = 400
    let statusMessage = 'Permintaan tidak sesuai'
    const errors = validationResult(req);

    if (!errors.isEmpty()) {
        const errorMessages = errors.array({ onlyFirstError: true }).filter((error) => {
            if (!error.msg.replaceCode) {
                return error
            } else {
                statusCode = error.msg.replaceCode
                statusMessage = error.msg.replaceMessage
            }
        }).map((error) => {
            return {
                location: error.param,
                text: error.msg
            }
        });

        output.status = {
            code: statusCode,
            message: statusMessage,
        }

        output.errors = errorMessages

        return res.status(output.status.code).json(output);
    }

    next();
}

global.helper.mailing = (params) => {
    if (params) {
        let senderMail = "siplah.care@eurekabookhouse.co.id"
        let senderPass = "CARE@)!("

        let transporter = nodemailer.createTransport(smtpTransport({
            host: 'eureka1.eurekabookhouse.co.id',
            secureConnection: false,
            tls: {
                rejectUnauthorized: false
            },
            port: 587,
            auth: {
                user: senderMail,
                pass: senderPass,
            }
        }));

        return new Promise((resolve, reject) => {
            ejs.renderFile(`${process.cwd()}/views/index.ejs`, params.dataView, function (err, data) {
                if (err) {
                    return false
                } else {
                    const mailOptions = {
                        from: senderMail,
                        to: params.to,
                        subject: params.subject,
                        html: data
                    };

                    transporter.sendMail(mailOptions, (error, info) => {
                        resolve((error) ? false : true)
                    })
                }
            })
        })
    } else {
        return false;
    }
}

global.helper.removeSomeArrayExcept = (arr) => {
    return function (hiddenArr) {
        if (!(arr.indexOf(hiddenArr) === -1)) {
            return hiddenArr
        }
    }
}

global.helper.hashPassword = async (password) => {
    const salt = await bcrypt.genSalt(10);
    const hashing = await bcrypt.hash(password, salt);

    return hashing
}

global.helper.verifyPassword = async (password, hashPassword) => {
    const verifyPassword = await bcrypt.compare(password, hashPassword);

    return verifyPassword
}

global.helper.encryptText = (text) => {
    return CryptoJS.AES.encrypt(text, dotenv.AES_SECRET_KEY).toString()
}

global.helper.decryptText = (encryptText) => {
    let bytes = CryptoJS.AES.decrypt(encryptText, dotenv.AES_SECRET_KEY);

    return bytes.toString(CryptoJS.enc.Utf8);
}

global.helper.jwtEncode = (data, expiresIn = '') => {
    const token = jwt.sign(data, dotenv.JWT_SECRET_KEY, (expiresIn) ? {
        expiresIn: expiresIn
    } : {})

    return token;
}

global.helper.jwtDecode = (token) => {
    try {
        return jwt.verify(token, dotenv.JWT_SECRET_KEY, (err, decoded) => {
            return (err) ? {
                isError: true,
                ...err
            } : {
                isError: false,
                ...decoded
            }
        })
    } catch (error) {
        return false
    }
}

global.helper.formatPhoneNumber = (phoneNumber) => {
    if (phoneNumber) {
        let getFirstChar = phoneNumber.charAt(0)
        return (getFirstChar === '0') ? `62${phoneNumber.substring(1)}` : phoneNumber
    } else {
        return null
    }
}

global.helper.checkUrlValid = (url) => {
    try {
        new URL(url);
    } catch (e) {
        return false;
    }

    return true;
};

global.helper.replaceAll = (str, find, replace) => {
    return str.replace(new RegExp(find, 'g'), replace)
}

global.helper.sumArray = (input) => {
    if (toString.call(input) !== "[object Array]") {
        return false;
    }

    var total = 0;
    for (var i = 0; i < input.length; i++) {
        if (isNaN(input[i])) {
            continue;
        }
        total += Number(input[i]);
    }
    return total;
}

global.helper.removeSpace = (string) => {
    return string.replace(/(\r\n|\n|\r)/gm, "")
}

global.helper.ucwords = (string) => {
    return string.charAt(0).toUpperCase() + string.slice(1)
}

var uploadPath = ''
const upload = multer({
    storage: multer.diskStorage({
        destination: (req, file, cb) => {
            cb(null, uploadPath)
        },
        filename: (req, file, cb) => {
            cb(null, req.body.name + Date.now() + path.extname(file.originalname))
        }
    })
})

global.helper.uploadFile = upload.single('image'), uploadPath = './assets/img/items'