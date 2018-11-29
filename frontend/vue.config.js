const path = require('path');
const CompressionPlugin = require("compression-webpack-plugin");
const BrotliPlugin = require('brotli-webpack-plugin');
const CompressionExtensions = ['js', 'css'];
const webpack = require('webpack');

function resolve (dir) {
  return path.join(__dirname, dir)
}

module.exports = {
  productionSourceMap: false,
  parallel: true,
  pages: {
    index: {
      entry: 'src/main.coffee'
    }
  },
  chainWebpack: config => {
    config.resolve.alias
      .set('@', resolve('src'))
      .set('static', resolve('static'))
    ;
    config.module.rule('coffee').test(/\.coffee$/);
    config.module.rule('coffee')
    .use('babel-loader')
    .loader('babel-loader')
    ;
    config.module.rule('coffee')
      .use('coffee-loader')
      .loader('coffee-loader')
      ;

    config
      .plugin('provide')
      .use(webpack.ProvidePlugin, [{
        $: "jquery/dist/jquery",
        jQuery: "jquery/dist/jquery",
        "window.jQuery": "jquery",
        "window.$": "jquery",
        Promise: 'es6-promise'
      }]);

    if(process.env.NODE_ENV !== 'production'){
      return;
    }

    config
      .plugin('compression')
      .use(CompressionPlugin, [{
          asset:     '[path].gz[query]',
          algorithm: 'gzip',
          test:      new RegExp(
            '\\.(' +
            CompressionExtensions.join('|') +
            ')$'
          ),
          threshold: 10240,
          minRatio:  0.8
      }]);
    config
    .plugin('brotli')
    .use(BrotliPlugin, [{
      asset:     '[path].br[query]',
      test:      new RegExp(
        '\\.(' +
        CompressionExtensions.join('|') +
        ')$'
      ),
      threshold: 10240,
      minRatio:  0.8
    }]);
  },
  configureWebpack: () => {

    var config = {
      resolve: {
        modules: [
          resolve('src'),
          "node_modules"
        ],
      }
    };

    if(process.env.NODE_ENV === 'production') {
      config.optimization = {
        splitChunks: {
          chunks: 'async',
        }
      };
    }

    return config;
  }
}
