const path = require('path')
const webpack = require('webpack')

module.exports = {
    runtimeCompiler: true,
    /*chainWebpack: config => {
        config.resolve.alias
            .set('@', path.resolve(__dirname, 'src'));
    },*/
  configureWebpack: {
    /*resolve: {
      alias: require('./aliases.config').webpack
    },*/
    plugins: [
    ]
  },
  css: {
    // Enable CSS source maps.
    sourceMap: true
  },
  outputDir: path.resolve(__dirname, '../public'),
  publicPath:'/',
  assetsDir:'static',
  indexPath: path.resolve(__dirname, '../resources/views/layouts/vue.blade.php'),
  devServer: {
    proxy: {
    // proxy all requests starting with /api to jsonplaceholder
    '/api': {
      target: process.env.PROXY_ROOT_API+'/api/',
      changeOrigin: true,
      pathRewrite: {
        '^/api': '/'
      }
    }
}
  }
}