// https://github.com/michael-ciniawsky/postcss-load-config

module.exports = {
  "plugins": [
    require('postcss-import')(),
    require('tailwindcss')('./tailwind.js'),
    require('autoprefixer')(),
  ]
}
