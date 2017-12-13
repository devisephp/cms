window.axios = require('axios')
window._ = require('underscore')
window.moment = require('moment')
window.Promise = require('promise')
window.Cookies = require('js-cookie')

let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
  window.csrfToken = token.content
  window.axios.defaults.headers.common['X-XSRF-TOKEN'] = token.content
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
}

/*
 * Define Moment locales
 */
window.moment.defineLocale('en-short', {
  parentLocale: 'en',
  relativeTime: {
    future: 'in %s',
    past: '%s',
    s: '1s',
    m: '1m',
    mm: '%dm',
    h: '1h',
    hh: '%dh',
    d: '1d',
    dd: '%dd',
    M: '1 month ago',
    MM: '%d months ago',
    y: '1y',
    yy: '%dy'
  }
})
window.moment.locale('en')
