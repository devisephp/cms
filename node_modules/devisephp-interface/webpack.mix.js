let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');

require('laravel-mix-purgecss');

mix.autoload({
  jquery: ['$', 'window.jQuery', 'jQuery']
});

if (mix.inProduction()) {
  mix.webpackConfig({
    output: {
      publicPath: '/devise/',
      chunkFilename: '[name].[chunkhash].js'
    },
    module: {
      rules: [
        {
          test: /\.js?$/,
          include: /(vue-ionicons)/,
          use: [
            {
              loader: 'babel-loader',
              options: mix.config.babel()
            }
          ]
        }
      ]
    }
  });
}

const webpack = require('webpack');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
mix.webpackConfig({
  plugins: [new BundleAnalyzerPlugin(), new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)]
});

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
  .setPublicPath(path.normalize('build'))
  .js('src/devise-app.js', 'js/devise.js')
  .js('src/installer/installer.js', 'js/devise-installer.js')
  .sass('src/sass/devise.scss', 'css/devise.css')
  .options({
    processCssUrls: false,
    postCss: [tailwindcss('./tailwind.js')]
  });

if (mix.inProduction()) {
  mix
    .extract(
      [
        'chart.js',
        'dayjs',
        'moment',
        'gsap',
        'popper.js',
        'sortablejs',
        'flatpickr',
        'jquery',
        'lodash',
        'vue-tippy',
        'SimpleBar',
        'vue-color',
        'text-clipper',
        'tinycolor2',
        'vuedraggable',
        'vue-scrollactive'
      ],
      'js/devise-administration-vendor.js'
    )
    .version()
    .purgeCss({
      folders: ['src'],
      globs: [path.join(__dirname, 'node_modules/simplebar/**/*.js')],
      whitelistPatterns: [/mobile/, /tablet/, /desktop/, /largeDesktop/, /ultraWideDesktop/]
    });
}
