// file: resources/server/index.js
require = require("esm")(module);
require('@babel/register')({
    "babelrc": false,
    "presets": [
        ["@babel/preset-env", {
            "targets": {
                "node": "current"
            },
            "loose": true
        }],
        "@babel/preset-react"
    ],
    "plugins": ["@babel/plugin-syntax-dynamic-import", "add-module-exports"]
});

module.exports = require("./main.js")
