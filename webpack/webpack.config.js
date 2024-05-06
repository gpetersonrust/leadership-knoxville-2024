const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { MODE } = require('./library/constants/global');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
 

module.exports = {
  mode: MODE,
  entry: {
    app: path.resolve(__dirname, 'src', 'app', 'js', 'app.js'),
    events: path.resolve(__dirname, 'src', 'events', 'js', 'events.js'),
    updates: path.resolve(__dirname, 'src', 'updates', 'js', 'updates.js'),
    alumni: path.resolve(__dirname, 'src', 'alumni', 'js', 'alumni.js'),
    ['verification-form']: path.resolve(__dirname, 'src', 'verification-form', 'js', 'verification-form.js'),
    
  },
  output: {
    publicPath: '/',
    path: path.resolve(__dirname.replace('webpack', ''), 'dist'),
    filename: ({ chunk: name }) => {
      return name === 'main'
        ? '[name]-wp[fullhash].js'
        : '[name]/[name]-wp[fullhash].js';
    },
    clean: true,
  },
  module: {
    rules: [
      {
        test: /.scss$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          'postcss-loader',
          'sass-loader',
        ],
      },
      {
        test: /.js$/,
        exclude: /node_modules/,
        use: 'babel-loader',
      },
    ],
  },
  optimization: {
    minimize: true,
    minimizer: [
      new CssMinimizerPlugin(),
      new TerserPlugin(),
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: ({ chunk: { name } }) => {
        return name === 'main'
          ? '[name]-wp[fullhash].css'
          : '[name]/[name]-wp[fullhash].css';
      },
    }),
  ],
  devtool: 'source-map',
};