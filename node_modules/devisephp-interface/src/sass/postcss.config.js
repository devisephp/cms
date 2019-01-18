var tailwindcss = require('tailwindcss');
module.exports = {
  plugins: [
    tailwindcss('./vendor/devisephp/cms/vue/src/tailwind/tailwind.js'),
    require('autoprefixer')
  ]
}
