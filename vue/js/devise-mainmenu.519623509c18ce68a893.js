webpackJsonp([5],{

/***/ 531:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(556)
/* template */
var __vue_template__ = __webpack_require__(557)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "src/components/menu/MainMenu.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-2f9415a8", Component.options)
  } else {
    hotAPI.reload("data-v-2f9415a8", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 556:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vuex__ = __webpack_require__(2);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


console.log('aaaahhhhhh');
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'MainMenu',
  data: function data() {
    return {};
  },
  mounted: function mounted() {
    console.log('hereerere');
  },

  methods: {}
});

/***/ }),

/***/ 557:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "dvs-p-8" }, [
    _c("h2", { staticClass: "dvs-font-bold dvs-mb-8" }, [
      _vm._v("Administration")
    ]),
    _vm._v(" "),
    _c("ul", { staticClass: "dvs-list-reset" }, [
      _c(
        "li",
        {
          staticClass: "dvs-cursor-pointer dvs-mb-6 dvs-text-lg",
          on: {
            click: function($event) {
              _vm.goToPage("devise-page-editor")
            }
          }
        },
        [_vm._v("\n      Edit this page\n    ")]
      ),
      _vm._v(" "),
      _c(
        "li",
        {
          staticClass: "dvs-cursor-pointer dvs-mb-6 dvs-text-lg",
          on: {
            click: function($event) {
              _vm.goToPage("devise-pages-index")
            }
          }
        },
        [_vm._v("\n      Pages\n    ")]
      ),
      _vm._v(" "),
      _c(
        "li",
        {
          staticClass: "dvs-cursor-pointer dvs-mb-6 dvs-text-lg",
          on: {
            click: function($event) {
              _vm.goToPage("devise-industries-index")
            }
          }
        },
        [_vm._v("\n      Industries\n    ")]
      ),
      _vm._v(" "),
      _c(
        "li",
        {
          staticClass: "dvs-cursor-pointer dvs-mb-6 dvs-text-lg",
          on: {
            click: function($event) {
              _vm.goToPage("devise-products-index")
            }
          }
        },
        [_vm._v("\n      Products\n    ")]
      ),
      _vm._v(" "),
      _c(
        "li",
        {
          staticClass: "dvs-cursor-pointer dvs-mb-6 dvs-text-lg",
          on: {
            click: function($event) {
              _vm.goToPage("devise-users-index")
            }
          }
        },
        [_vm._v("\n      Users\n    ")]
      ),
      _vm._v(" "),
      _c(
        "li",
        {
          staticClass: "dvs-cursor-pointer dvs-mb-6 dvs-text-lg",
          on: {
            click: function($event) {
              _vm.goToPage("Analytics")
            }
          }
        },
        [_vm._v("\n      Analytics\n    ")]
      ),
      _vm._v(" "),
      _c(
        "li",
        {
          staticClass: "dvs-cursor-pointer dvs-mb-6 dvs-text-lg",
          on: {
            click: function($event) {
              _vm.goToPage("devise-templates-index")
            }
          }
        },
        [_vm._v("\n      Templates\n    ")]
      ),
      _vm._v(" "),
      _c(
        "li",
        {
          staticClass: "dvs-cursor-pointer dvs-mb-6 dvs-text-lg",
          on: {
            click: function($event) {
              _vm.goToPage("devise-settings-index")
            }
          }
        },
        [_vm._v("\n      Settings\n    ")]
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-2f9415a8", module.exports)
  }
}

/***/ })

});