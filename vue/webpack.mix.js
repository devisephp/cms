let mix = require('laravel-mix');
var tailwindcss = require('tailwindcss');

require('./mix/DeviseMix');

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
 mix.webpackConfig({
   output: {
     publicPath: '/',
     chunkFilename: 'dist/js/[name].[chunkhash].js',
   },
 });

mix
  .deviseMix()
  .js('src/devise-app.js', 'dist/js/devise.js')
  .sass('src/sass/devise.scss', './dist/css/devise.css')
  .options({
    processCssUrls: false,
    postCss: [ tailwindcss('./tailwind.js') ],
  })
