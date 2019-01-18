/* eslint-disable */
var clip = require('text-clipper')

export default {
  methods: {
    uppercase (string) {
      return string.charAt(0).toUpperCase() + string.substring(1).toLowerCase();
    },
    slugify (string) {
      return string.replace(/[^\w\-]+/g, '')       // Remove all non-word chars
          .replace(/\-/g, '')         // Replace multiple - with single -
          .trim()
    },
    randomString (length) {
      var text = "";
      var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

      for (var i = 0; i < length; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

      return text;
    },
    isEmail (email) {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email.toLowerCase());
    },
    escapeHtml (text) {
      var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
      }

      return text.replace(/[&<>"']/g, function(m) { return map[m]; })
    },
    clipString (text, length, html) {
      if (typeof html === 'undefined') {
        html = false
      }
      if (typeof text !== 'undefined' && text !== null && html) {
        text = this.escapeHtml(text)
      }

      return clip(text, length, {html: html})
    },
    genUniqueKey (item) {
      const UNIQUE_KEY_PROP = '__unique_key_prop__'
      const KEY_PREFIX = '__key_prefix__' + Date.now() + '_'
      let uid = 0
      
      const isObject = val => val !== null && typeof val === 'object'
      
      const genUniqueKey = obj => {
        if (isObject(obj)) {
          if (UNIQUE_KEY_PROP in obj) {
            return obj[UNIQUE_KEY_PROP]
          }
          const value = KEY_PREFIX + uid++
          Object.defineProperty(obj, UNIQUE_KEY_PROP, { value })
          return value
        }
        return obj
      }

      return genUniqueKey(item)
    }
  }
}
