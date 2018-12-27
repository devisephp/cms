webpackJsonp([12],{

/***/ 684:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(891)
/* template */
var __vue_template__ = __webpack_require__(892)
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
Component.options.__file = "src/components/admin/Index.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-452a4712", Component.options)
  } else {
    hotAPI.reload("data-v-452a4712", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 891:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__ = __webpack_require__(6);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_core_js_object_keys__ = __webpack_require__(58);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_core_js_object_keys___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_babel_runtime_core_js_object_keys__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_babel_runtime_helpers_typeof__ = __webpack_require__(20);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_babel_runtime_helpers_typeof___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_babel_runtime_helpers_typeof__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__Administration__ = __webpack_require__(310);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__Administration___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__Administration__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__utilities_Sidebar__ = __webpack_require__(311);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__utilities_Sidebar___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__utilities_Sidebar__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_vuex__ = __webpack_require__(5);



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





/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'DeviseIndex',
  methods: {
    findMenu: function findMenu(menu) {
      if ((typeof menu === 'undefined' ? 'undefined' : __WEBPACK_IMPORTED_MODULE_2_babel_runtime_helpers_typeof___default()(menu)) === 'object') {
        var safeMenu = __WEBPACK_IMPORTED_MODULE_1_babel_runtime_core_js_object_keys___default()(menu).map(function (i) {
          return menu[i];
        });
      } else {
        var safeMenu = menu;
      }

      for (var i = 0; i < safeMenu.length; i++) {
        var m = safeMenu[i];
        if (m.routeName === this.$route.name) {
          return m;
        }
        if (m.menu) {
          var foundMenu = this.findMenu(m.menu);
          if (foundMenu) {
            return foundMenu;
          }
        }
      }
    }
  },
  computed: __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_5_vuex__["d" /* mapState */])('devise', ['adminMenu']), {
    currentMenu: function currentMenu() {
      return this.findMenu(this.adminMenu);
    }
  }),
  components: {
    Administration: __WEBPACK_IMPORTED_MODULE_3__Administration___default.a,
    Sidebar: __WEBPACK_IMPORTED_MODULE_4__utilities_Sidebar___default.a
  }
});

/***/ }),

/***/ 892:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "dvs-p-8" }, [
    _c(
      "h3",
      { staticClass: "dvs-mb-6", style: { color: _vm.theme.panel.color } },
      [_vm._v(_vm._s(_vm.currentMenu.label))]
    ),
    _vm._v(" "),
    _c(
      "ul",
      { staticClass: "dvs-list-reset" },
      [
        _c(
          "transition-group",
          { attrs: { name: "dvs-fade" } },
          _vm._l(_vm.currentMenu.menu, function(menuItem, key) {
            return _c("li", { key: key, staticClass: "dvs-mb-4" }, [
              _c(
                "div",
                {
                  staticClass:
                    "dvs-block dvs-mb-4 dvs-switch-sm dvs-flex dvs-justify-between dvs-items-center dvs-cursor-pointer",
                  style: { color: _vm.theme.panel.color },
                  on: {
                    click: function($event) {
                      _vm.goToPage(menuItem.routeName, menuItem.parameters)
                    }
                  }
                },
                [_vm._v(_vm._s(menuItem.label))]
              )
            ])
          })
        )
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-452a4712", module.exports)
  }
}

/***/ })

});