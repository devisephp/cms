let mix = require('laravel-mix');
let webpack = require('webpack');
let glob = require('glob-all');
let purgeCss = require('purgecss-webpack-plugin')

const config = require('./config')
const vueLoaderConfig = require('./vue-loader.conf')
const utils = require('./utils')

var env = require('./config/dev.env')
if (mix.inProduction()) {
  env = require('./config/prod.env')
}

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
      // ...(config.dev.useEslint ? [createLintingRule()] : []),
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

    let plugins = []

    plugins.push(
      new webpack.optimize.CommonsChunkPlugin({
        name: utils.assetsPath('/js/vendor'),
        minChunks (module) {
          // any required modules inside node_modules are extracted to vendor
          return (
            module.resource &&
            /\.js$/.test(module.resource) &&
            module.resource.indexOf(
              path.join(__dirname, '../vue/node_modules')
            ) === 0
          )
        }
      })
    )

    plugins.push(
      // extract webpack runtime and module manifest to its own file in order to
      // prevent vendor hash from being updated whenever app bundle is updated
      new webpack.optimize.CommonsChunkPlugin({
        name: 'manifest',
        minChunks: Infinity
      })
    )

    if (mix.inProduction()) {
      plugins.push(
        new webpack.DefinePlugin({
          'process.env': env
        })
      )

        // new UglifyJsPlugin({
        //   uglifyOptions: {
        //     compress: {
        //       warnings: false
        //     }
        //   },
        //   sourceMap: config.build.productionSourceMap,
        //   parallel: true
        // }),

        // // extract css into its own file
        // new ExtractTextPlugin({
        //   filename: utils.assetsPath('css/[name].[contenthash].css'),
        //   // Setting the following option to `false` will not extract CSS from codesplit chunks.
        //   // Their CSS will instead be inserted dynamically with style-loader when the codesplit chunk has been loaded by webpack.
        //   // It's currently set to `true` because we are seeing that sourcemaps are included in the codesplit bundle as well when it's `false`,
        //   // increasing file size: https://github.com/vuejs-templates/webpack/issues/1110
        //   allChunks: true,
        // }),
        // new PrerenderSpaPlugin(
        //   // Path to compiled app
        //   path.join(__dirname, '../dist'),
        //   // List of endpoints you wish to prerender
        //   [ '/' ]
        // ),
        // keep module.id stable when vendor modules does not change
        // new webpack.HashedModuleIdsPlugin(),
        // // // enable scope hoisting
        // new webpack.optimize.ModuleConcatenationPlugin(),

      plugins.push(
        // This instance extracts shared chunks from code splitted chunks and bundles them
        // in a separate chunk, similar to the vendor chunk
        // see: https://webpack.js.org/plugins/commons-chunk-plugin/#extra-async-commons-chunk
        new webpack.optimize.CommonsChunkPlugin({
          name: 'app.chunkFilename',
          async: 'vendor-async',
          children: true,
          minChunks: 3
        })
      )

      plugins.push(
        // Strips out the unnecessary locales from moment
        // TODO - do we really need moment?
        new webpack.ContextReplacementPlugin(/moment[\\\/]locale$/, /^\.\/(en)$/)
      )

      plugins.push(
        new purgeCss({
          paths: glob.sync([
            path.join(__dirname, '../vue/src/components/**/*.vue')
          ]),
          extractors: [
            {
              extractor: class {
                static extract(content) {
                  return content.match(/[A-z0-9-:\/]+/g)
                }
              },
              extensions: ['html', 'js', 'php', 'vue']
            }
          ]
        })
      )
    }

    plugins.push(
      // Builds Laravel Mix compatible manifest file
      new WebpackLaravelMixManifest()
    )

    return plugins
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

    // delete mix's vue loader and replace it with mine for custom tailwind config
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
