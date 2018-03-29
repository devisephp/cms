var tailwindcss = require('tailwindcss');
module.exports = {
  plugins: [
    tailwindcss('./src/tailwind/tailwind.js'),
    require('autoprefixer')
  ]
}
