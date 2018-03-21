/* eslint-disable */
var clip = require('text-clipper')

export default {
  methods: {
    uppercase (string) {
      return string.charAt(0).toUpperCase() + string.substring(1).toLowerCase();
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
    clipString (string, length, html) {
      if (typeof html === 'undefined') {
        html = false
      }

      return clip(string, length, {html: html})
    }
  }
}
