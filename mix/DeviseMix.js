let mix = require('laravel-mix');
let webpack = require('webpack');

const config = require('./config')
const vueLoaderConfig = require('./vue-loader.conf')
const utils = require('./utils')
const env = require('./config/prod.env')

const ExtractTextPlugin = require('extract-text-webpack-plugin')
const UglifyJsPlugin = require('uglifyjs-webpack-plugin')
const WebpackLaravelMixManifest = require('webpack-laravel-mix-manifest').default;

function resolve (dir) {
  return path.join(__dirname, '..', dir)
}

const createLintingRule = () => ({
  test: /\.(js|vue)$/,
  loader: 'eslint-loader',
  enforce: 'pre',
  include: [resolve('src'), resolve('test')],
  options: {
    formatter: require('eslint-friendly-formatter'),
    emitWarning: !config.dev.showEslintErrorsInOverlay
  }
})

class DeviseMix {
  /**
   * All dependencies that should be installed by Mix.
   *
   * @return {Array}
   */
  dependencies() {
      // Example:
      // return ['typeScript', 'ts'];
  }

  /**
   * Register the component.
   *
   * When your component is called, all user parameters
   * will be passed to this method.
   *
   * Ex: register(src, output) {}
   * Ex: mix.yourPlugin('src/path', 'output/path');
   *
   * @param  {*} ...params
   * @return {void}
   *
   */
  register(params) {
      // Example:
      // this.config = { proxy: arg };
  }

  /**
   * Boot the component. This method is triggered after the
   * user's webpack.mix.js file has executed.
   */
  boot() {
      // Example:
      // if (Config.options.foo) {}
  }

  /**
   * Append to the master Mix webpack entry object.
   *
   * @param  {Entry} entry
   * @return {void}
   */
  webpackEntry(entry) {
      // Example:
      // entry.add('foo', 'bar');
  }

  /**
   * Rules to be merged with the master webpack loaders.
   *
   * @return {Array|Object}
   */
  webpackRules() {
      // Example:
      // return {
      //     test: /\.less$/,
      //     loaders: ['...']
      // });
    return [
      ...(config.dev.useEslint ? [createLintingRule()] : []),
      // {
      //   test: /\.vue$/,
      //   loader: 'vue-loader',
      //   // `vue-loader` options goes here
      //   options: {
      //     config: {
      //       path: '../vue/src/tailwind/tailwind.js'
      //     }
      //   }
      // }
    ]
  }

  /*
   * Plugins to be merged with the master webpack config.
   *
   * @return {Array|Object}
   */
  webpackPlugins() {
      // Example:
      // return new webpack.ProvidePlugin(this.aliases);
      return [
        new webpack.DefinePlugin({
          'process.env': env
        }),
        new UglifyJsPlugin({
          uglifyOptions: {
            compress: {
              warnings: false
            }
          },
          sourceMap: config.build.productionSourceMap,
          parallel: true
        }),
        // extract css into its own file
        new ExtractTextPlugin({
          filename: utils.assetsPath('css/[name].[contenthash].css'),
          // Setting the following option to `false` will not extract CSS from codesplit chunks.
          // Their CSS will instead be inserted dynamically with style-loader when the codesplit chunk has been loaded by webpack.
          // It's currently set to `true` because we are seeing that sourcemaps are included in the codesplit bundle as well when it's `false`,
          // increasing file size: https://github.com/vuejs-templates/webpack/issues/1110
          allChunks: true,
        }),
        // new PrerenderSpaPlugin(
        //   // Path to compiled app
        //   path.join(__dirname, '../dist'),
        //   // List of endpoints you wish to prerender
        //   [ '/' ]
        // ),
        // keep module.id stable when vendor modules does not change
        new webpack.HashedModuleIdsPlugin(),
        // enable scope hoisting
        new webpack.optimize.ModuleConcatenationPlugin(),

        // Strips out the unnecessary locales from moment
        // TODO - do we really need moment?
        new webpack.ContextReplacementPlugin(/moment[\\\/]locale$/, /^\.\/(en)$/),

        // Builds Laravel Mix compatible manifest file
        new WebpackLaravelMixManifest()
      ]
  }

  /**
   * Override the generated webpack configuration.
   *
   * @param  {Object} webpackConfig
   * @return {void}
   */
  webpackConfig(webpackConfig) {
    // Example:
    // webpackConfig.resolve.extensions.push('.ts', '.tsx');

    let vueLoader = webpackConfig.module.rules.filter(rule => {
      return rule.loader === 'vue-loader'
    })

    webpackConfig.module.rules.splice(webpackConfig.module.rules.indexOf(vueLoader), 1, {
        test: /\.vue$/,
        loader: 'vue-loader',
        exclude: /bower_components/,
        options: {
          config: {
            path: '../vue/src/tailwind/tailwind.js'
          }
        }
    })
  }

  /**
   * Babel config to be merged with Mix's defaults.
   *
   * @return {Object}
   */
  babelConfig() {
      // Example:
      // return { presets: ['react'] };
  }
}

mix.extend('deviseMix', new DeviseMix());
