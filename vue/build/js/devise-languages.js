webpackJsonp([11],{

/***/ 646:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(704)
/* template */
var __vue_template__ = __webpack_require__(705)
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
Component.options.__file = "node_modules/vue-ionicons/dist/md-create.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-716d8b68", Component.options)
  } else {
    hotAPI.reload("data-v-716d8b68", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 684:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(894)
/* template */
var __vue_template__ = __webpack_require__(895)
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
Component.options.__file = "src/components/languages/Manage.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-5bcf7d89", Component.options)
  } else {
    hotAPI.reload("data-v-5bcf7d89", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 704:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__ionicons_mixin__ = __webpack_require__(26);
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
  name: "md-create-icon",
  mixins: [__WEBPACK_IMPORTED_MODULE_0__ionicons_mixin__["a" /* default */]],
  data: function data() {
    var iconTitle = this.title ? this.title : "Md Create Icon";
    return {
      iconTitle: iconTitle
    };
  }
});

/***/ }),

/***/ 705:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass: "ion",
      class: _vm.ionClass,
      attrs: { title: _vm.iconTitle, name: "md-create-icon" }
    },
    [
      _c(
        "svg",
        {
          staticClass: "ion__svg",
          attrs: { viewBox: "0 0 512 512", width: _vm.w, height: _vm.h }
        },
        [
          _c("path", {
            attrs: {
              d:
                "M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z"
            }
          })
        ]
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-716d8b68", module.exports)
  }
}

/***/ }),

/***/ 894:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign__ = __webpack_require__(17);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends__ = __webpack_require__(6);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__admin_Administration__ = __webpack_require__(310);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__admin_Administration___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__admin_Administration__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__utilities_Sidebar__ = __webpack_require__(311);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__utilities_Sidebar___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__utilities_Sidebar__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_vue_ionicons_dist_md_create_vue__ = __webpack_require__(646);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_vue_ionicons_dist_md_create_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4_vue_ionicons_dist_md_create_vue__);
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
//
//
//







/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'LanguagesManage',
  data: function data() {
    return {
      localValue: {
        data: []
      },
      modulesToLoad: 1,
      newLanguage: {
        code: null
      }
    };
  },
  mounted: function mounted() {
    this.retrieveAllLanguages();
  },

  methods: __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_5_vuex__["b" /* mapActions */])('devise', ['getLanguages', 'createLanguage', 'updateLanguage']), {
    requestCreateLanguage: function requestCreateLanguage() {
      this.createLanguage(this.newLanguage);
    },
    requestUpdateLanguage: function requestUpdateLanguage(language) {
      this.updateLanguage(language).then(function () {
        language.editCode = false;
      });
    },
    retrieveAllLanguages: function retrieveAllLanguages() {
      var self = this;
      this.getLanguages().then(function () {
        self.localValue = __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign___default()({}, self.localValue, self.languages);
        self.localValue.data.map(function (language) {
          self.$set(language, 'editCode', false);
        });
        devise.$bus.$emit('incrementLoadbar', self.modulesToLoad);
      });
    }
  }),
  computed: __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_5_vuex__["c" /* mapGetters */])('devise', ['languages', 'settingsMenu'])),
  components: {
    Administration: __WEBPACK_IMPORTED_MODULE_2__admin_Administration___default.a,
    CreateIcon: __WEBPACK_IMPORTED_MODULE_4_vue_ionicons_dist_md_create_vue___default.a,
    Sidebar: __WEBPACK_IMPORTED_MODULE_3__utilities_Sidebar___default.a
  }
});

/***/ }),

/***/ 895:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.languages.data.length
    ? _c("div", [
        _c(
          "div",
          { attrs: { id: "devise-admin-content" } },
          [
            _c(
              "h3",
              {
                staticClass: "dvs-mb-8 dvs-pr-16",
                style: { color: _vm.theme.panel.color }
              },
              [_vm._v("Add Language")]
            ),
            _vm._v(" "),
            _c("help", { staticClass: "dvs-mb-8" }, [
              _vm._v(
                "When you add a language to this site it is immediately enabled. Afterwards you can create translated versions of pages that will be linked to one another allowing you to provide ways to switch languages on your front-end. We "
              ),
              _c(
                "a",
                {
                  staticClass: "dvs-font-bold",
                  attrs: {
                    href:
                      "https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes",
                    target: "_blank"
                  }
                },
                [_vm._v("highly suggest using the ISO 639-1 2 letter codes")]
              ),
              _vm._v(" but you can technically use whatever you want.")
            ]),
            _vm._v(" "),
            _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
              _c("label", [_vm._v("New Language Code")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.newLanguage.code,
                    expression: "newLanguage.code"
                  }
                ],
                attrs: { type: "text", maxlength: "2" },
                domProps: { value: _vm.newLanguage.code },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(_vm.newLanguage, "code", $event.target.value)
                  }
                }
              })
            ]),
            _vm._v(" "),
            _c(
              "button",
              {
                staticClass: "dvs-btn dvs-mb-8",
                style: _vm.theme.actionButton,
                attrs: { disabled: _vm.newLanguage.code === null },
                on: { click: _vm.requestCreateLanguage }
              },
              [_vm._v("Save New Language")]
            ),
            _vm._v(" "),
            _c(
              "h3",
              {
                staticClass: "dvs-mb-8 dvs-pr-16",
                style: { color: _vm.theme.panel.color }
              },
              [_vm._v("Existing Languages")]
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "dvs-mb-12 dvs-flex dvs-flex-col" },
              _vm._l(_vm.localValue.data, function(language, key) {
                return _c(
                  "div",
                  {
                    key: key,
                    staticClass:
                      "dvs-flex dvs-justify-between dvs-items-center dvs-mb-2"
                  },
                  [
                    _c(
                      "div",
                      { staticClass: "dvs-text-xl dvs-font-bold dvs-mb-4" },
                      [
                        !language.editCode
                          ? [
                              _vm._v(
                                "\n            " +
                                  _vm._s(language.code) +
                                  "\n          "
                              )
                            ]
                          : _vm._e(),
                        _vm._v(" "),
                        _c("fieldset", { staticClass: "dvs-fieldset" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: language.editCode,
                                expression: "language.editCode"
                              },
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.localValue.data[key].code,
                                expression: "localValue.data[key].code"
                              }
                            ],
                            attrs: { type: "text" },
                            domProps: { value: _vm.localValue.data[key].code },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  _vm.localValue.data[key],
                                  "code",
                                  $event.target.value
                                )
                              }
                            }
                          })
                        ])
                      ],
                      2
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "dvs-flex dvs-justify-between dvs-items-center"
                      },
                      [
                        !language.editCode
                          ? _c(
                              "button",
                              {
                                staticClass: "dvs-btn dvs-btn-xs dvs-ml-4",
                                style: _vm.theme.actionButtonGhost,
                                on: {
                                  click: function($event) {
                                    language.editCode = !language.editCode
                                  }
                                }
                              },
                              [_c("CreateIcon")],
                              1
                            )
                          : _vm._e(),
                        _vm._v(" "),
                        language.editCode
                          ? _c(
                              "button",
                              {
                                staticClass: "dvs-btn dvs-mr-2",
                                style: _vm.theme.actionButton,
                                on: {
                                  click: function($event) {
                                    _vm.requestUpdateLanguage(
                                      _vm.localValue.data[key]
                                    )
                                  }
                                }
                              },
                              [
                                _vm._v(
                                  "\n              Save Language Code\n          "
                                )
                              ]
                            )
                          : _vm._e(),
                        _vm._v(" "),
                        language.editCode
                          ? _c(
                              "button",
                              {
                                staticClass: "dvs-btn",
                                style: _vm.theme.actionButtonGhost,
                                on: {
                                  click: function($event) {
                                    language.editCode = false
                                  }
                                }
                              },
                              [_vm._v("\n              Cancel\n          ")]
                            )
                          : _vm._e()
                      ]
                    )
                  ]
                )
              })
            )
          ],
          1
        )
      ])
    : _vm._e()
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-5bcf7d89", module.exports)
  }
}

/***/ })

});