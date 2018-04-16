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
mix.setPublicPath('./')

mix
  .deviseMix()
  .js('src/main.js', './dist/devise.js')
  .sass('src/sass/devise.scss', './dist/devise.css')
  .options({
    processCssUrls: false,
    postCss: [ tailwindcss('./tailwind.js') ],
  })
  .sourceMaps()
  .version();
