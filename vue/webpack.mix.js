let mix = require('laravel-mix');
var tailwindcss = require('tailwindcss');
// require('laravel-mix-purgecss');

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
     chunkFilename: '[name].[chunkhash].js',
   },
 });

mix
  .setPublicPath(path.normalize('build'))
  .js('src/devise-app.js', 'js/devise.js')
  .js('src/installer/installer.js', 'js/devise-installer.js')
  .sass('src/sass/devise.scss', 'css/devise.css')
  .options({
    processCssUrls: false,
    postCss: [ tailwindcss('./tailwind.js') ],
  })
  // .purgeCss({
  //   enabled: true,
  //   whitelistPatterns: [/mobile/, /tablet/, /desktop/, /largeDesktop/, /ultraWideDesktop/]
  // });
