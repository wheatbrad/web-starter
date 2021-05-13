const path = require('path');
// const webpack = require('webpack');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const { WebpackManifestPlugin } = require('webpack-manifest-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserJSPlugin = require('terser-webpack-plugin');

module.exports = {
    entry: {
        main: './src/index.js',
    },
    output: {
        filename: 'main.js',
        path: path.resolve(__dirname, 'public/js'),
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                use: [ MiniCssExtractPlugin.loader, 'css-loader' ]
            }
        ]
    },
    optimization: {
        minimizer: [ new TerserJSPlugin({}) ]
    },
    performance: {
        maxEntrypointSize: 1024000,
        maxAssetSize: 1024000
    },
    plugins: [
        new CleanWebpackPlugin(),
        new WebpackManifestPlugin({
            fileName: path.resolve(__dirname, 'public/manifest.json'),
            publicPath: 'js/'
        }),
        new MiniCssExtractPlugin({
            ignoreOrder: false
        })
    ],
    watchOptions: {
        ignored: [ './node_modules/' ]
    },
    mode: 'development'
};