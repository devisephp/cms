var tailwindcss = require('tailwindcss');
console.log('godbarf')
module.exports = {
  plugins: [
    tailwindcss('../../tailwind/tailwind.js'),
    require('autoprefixer')
  ]
}
