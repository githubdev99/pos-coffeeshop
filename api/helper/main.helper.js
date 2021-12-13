require('dotenv').config()

const helper = {};
const { validationResult } = require('express-validator')
const nodemailer = require('nodemailer')
const smtpTransport = require('nodemailer-smtp-transport')
const ejs = require('ejs')
const bcrypt = require("bcrypt")
const CryptoJS = require("crypto-js")
const jwt = require('jsonwebtoken')

const dotenv = process.env

helper.rupiah = (number) => {
    var reverse = number.toString().split("").reverse().join(""),
        ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join(".").split("").reverse().join("");
    return "Rp" + ribuan;
}

helper.responseErrorValidator = (req, res, next) => {
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

helper.mailing = (params) => {
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

helper.removeSomeArrayExcept = (arr) => {
    return function (hiddenArr) {
        if (!(arr.indexOf(hiddenArr) === -1)) {
            return hiddenArr
        }
    }
}

helper.hashPassword = async (password) => {
    const salt = await bcrypt.genSalt(10);
    const hashing = await bcrypt.hash(password, salt);

    return hashing
}

helper.verifyPassword = async (password, hashPassword) => {
    const verifyPassword = await bcrypt.compare(password, hashPassword);

    return verifyPassword
}

helper.encryptText = (text) => {
    return CryptoJS.AES.encrypt(text, dotenv.AES_SECRET_KEY).toString()
}

helper.decryptText = (encryptText) => {
    let bytes = CryptoJS.AES.decrypt(encryptText, dotenv.AES_SECRET_KEY);

    return bytes.toString(CryptoJS.enc.Utf8);
}

helper.jwtEncode = (data, expiresIn = '') => {
    const token = jwt.sign(data, dotenv.JWT_SECRET_KEY, (expiresIn) ? {
        expiresIn: expiresIn
    } : {})

    return token;
}

helper.jwtDecode = (token) => {
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

helper.formatPhoneNumber = (phoneNumber) => {
    if (phoneNumber) {
        let getFirstChar = phoneNumber.charAt(0)
        return (getFirstChar === '0') ? `62${phoneNumber.substring(1)}` : phoneNumber
    } else {
        return null
    }
}

helper.checkUrlValid = (url) => {
    try {
        new URL(url);
    } catch (e) {
        return false;
    }

    return true;
};

helper.replaceAll = (str, find, replace) => {
    return str.replace(new RegExp(find, 'g'), replace)
}

module.exports = helper;