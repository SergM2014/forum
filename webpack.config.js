let path = require('path');
let webpack = require('webpack');
let ExtractTextPlugin = require("extract-text-webpack-plugin");



module.exports = {

    entry : {

         script:path.resolve(__dirname,'./resources/src/js/script.js'),
         uploadImage:path.resolve(__dirname,'./resources/src/js/uploadImage.js'),
         admin:path.resolve(__dirname,'./resources/src/js/admin.js'),

    },

    output: {
        path:path.resolve(__dirname, './public/assets/js'),
        filename: '[name].js'
    },





};



