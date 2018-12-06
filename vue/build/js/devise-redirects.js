webpackJsonp([8],{

/***/ 1011:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__ = __webpack_require__(8);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utilities_Modal__ = __webpack_require__(689);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utilities_Modal___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__utilities_Modal__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_vue_ionicons_dist_ios_arrow_dropright_circle_vue__ = __webpack_require__(1012);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_vue_ionicons_dist_ios_arrow_dropright_circle_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_vue_ionicons_dist_ios_arrow_dropright_circle_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_vuex__ = __webpack_require__(5);

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
  name: 'RedirectsIndex',
  data: function data() {
    return {
      modulesToLoad: 1,
      showCreate: false,
      newRedirect: {
        from_url: null,
        to_url: null
      }
    };
  },
  mounted: function mounted() {
    this.retrieveAllRedirects();
  },

  methods: __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_3_vuex__["b" /* mapActions */])('devise', ['getRedirects', 'createRedirect']), {
    requestCreateRedirect: function requestCreateRedirect() {
      var self = this;
      this.createRedirect(this.newRedirect).then(function () {
        self.newRedirect.from_url = null;
        self.newRedirect.to_url = null;
        self.showCreate = false;
      });
    },
    retrieveAllRedirects: function retrieveAllRedirects() {
      var loadbar = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;

      this.getRedirects().then(function () {
        if (loadbar) {
          devise.$bus.$emit('incrementLoadbar', self.modulesToLoad);
        }
      });
    },
    loadRedirect: function loadRedirect(id) {
      this.$router.push({ name: 'devise-redirects-edit', params: { redirectId: id } });
    }
  }),
  computed: __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_3_vuex__["c" /* mapGetters */])('devise', ['redirects']), {
    createInvalid: function createInvalid() {
      return this.newRedirect.name === null || this.newRedirect.email === null || this.newRedirect.password === null || this.newRedirect.password_confirmation === null || this.newRedirect.password !== this.newRedirect.password_confirmation;
    }
  }),
  components: {
    DeviseModal: __WEBPACK_IMPORTED_MODULE_1__utilities_Modal___default.a,
    ArrowIcon: __WEBPACK_IMPORTED_MODULE_2_vue_ionicons_dist_ios_arrow_dropright_circle_vue___default.a
  }
});

/***/ }),

/***/ 1012:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(1013)
/* template */
var __vue_template__ = __webpack_require__(1014)
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
Component.options.__file = "node_modules/vue-ionicons/dist/ios-arrow-dropright-circle.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-d511bce4", Component.options)
  } else {
    hotAPI.reload("data-v-d511bce4", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 1013:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__ionicons_mixin__ = __webpack_require__(37);
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
  name: "ios-arrow-dropright-circle-icon",
  mixins: [__WEBPACK_IMPORTED_MODULE_0__ionicons_mixin__["a" /* default */]],
  data: function data() {
    var iconTitle = this.title ? this.title : "Ios Arrow Dropright Circle Icon";
    return {
      iconTitle: iconTitle
    };
  }
});

/***/ }),

/***/ 1014:
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
      attrs: { title: _vm.iconTitle, name: "ios-arrow-dropright-circle-icon" }
    },
    [
      _c(
        "svg",
        {
          staticClass: "ion__svg",
          attrs: { width: _vm.w, height: _vm.h, viewBox: "0 0 512 512" }
        },
        [
          _c("path", {
            attrs: {
              d:
                "M48 256c0 114.9 93.1 208 208 208s208-93.1 208-208S370.9 48 256 48 48 141.1 48 256zm244.5 0l-81.9-81.1c-7.5-7.5-7.5-19.8 0-27.3s19.8-7.5 27.3 0l95.4 95.7c7.3 7.3 7.5 19.1.6 26.6l-94 94.3c-3.8 3.8-8.7 5.7-13.7 5.7-4.9 0-9.9-1.9-13.6-5.6-7.5-7.5-7.6-19.7 0-27.3l79.9-81z"
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
    require("vue-hot-reload-api")      .rerender("data-v-d511bce4", module.exports)
  }
}

/***/ }),

/***/ 1015:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c(
        "div",
        { attrs: { id: "devise-admin-content" } },
        [
          _c("action-bar", [
            _c(
              "li",
              {
                staticClass: "dvs-btn dvs-btn-sm dvs-mb-2",
                style: _vm.theme.actionButton,
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    _vm.showCreate = true
                  }
                }
              },
              [_vm._v("\n        Create Redirect\n      ")]
            )
          ]),
          _vm._v(" "),
          _c(
            "h3",
            {
              staticClass: "dvs-mb-10 dvs-mr-12",
              style: { color: _vm.theme.panel.color }
            },
            [_vm._v("Current Redirects")]
          ),
          _vm._v(" "),
          _vm._l(_vm.redirects.data, function(redirect) {
            return _c(
              "div",
              {
                key: redirect.id,
                staticClass:
                  "dvs-mb-6 dvs-flex dvs-justify-between dvs-items-center"
              },
              [
                _c(
                  "div",
                  { staticClass: "dvs-min-w-1/6 dvs-font-bold dvs-pr-8" },
                  [_vm._v("\n        " + _vm._s(redirect.type) + "\n      ")]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "dvs-min-w-2/6 dvs-font-bold dvs-pr-8" },
                  [
                    _vm._v(
                      "\n        From: " +
                        _vm._s(redirect.from_url) +
                        "\n      "
                    )
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "dvs-min-w-2/6 dvs-font-bold dvs-pr-8" },
                  [
                    _vm._v(
                      "\n        To: " + _vm._s(redirect.to_url) + "\n      "
                    )
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "dvs-w-1/6 dvs-px-8 dvs-flex dvs-justify-end"
                  },
                  [
                    _c(
                      "button",
                      {
                        staticClass: "dvs-btn dvs-btn-xs",
                        style: _vm.theme.actionButtonGhost,
                        on: {
                          click: function($event) {
                            _vm.loadRedirect(redirect.id)
                          }
                        }
                      },
                      [_vm._v("Manage")]
                    )
                  ]
                )
              ]
            )
          }),
          _vm._v(" "),
          _vm.redirects.data.length < 1
            ? _c("help", [_vm._v("You do not have any redirects currently")])
            : _vm._e()
        ],
        2
      ),
      _vm._v(" "),
      _c(
        "transition",
        { attrs: { name: "dvs-fade" } },
        [
          _c(
            "portal",
            { attrs: { to: "devise-root" } },
            [
              _vm.showCreate
                ? _c(
                    "devise-modal",
                    {
                      staticClass: "dvs-z-50",
                      on: {
                        close: function($event) {
                          _vm.showCreate = false
                        }
                      }
                    },
                    [
                      _c(
                        "h4",
                        {
                          staticClass: "dvs-mb-4",
                          style: { color: _vm.theme.panel.color }
                        },
                        [_vm._v("New Redirect")]
                      ),
                      _vm._v(" "),
                      _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                        _c("label", [_vm._v("From URL")]),
                        _vm._v(" "),
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.newRedirect.from_url,
                              expression: "newRedirect.from_url"
                            }
                          ],
                          attrs: { type: "text" },
                          domProps: { value: _vm.newRedirect.from_url },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                _vm.newRedirect,
                                "from_url",
                                $event.target.value
                              )
                            }
                          }
                        })
                      ]),
                      _vm._v(" "),
                      _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                        _c("label", [_vm._v("To URL")]),
                        _vm._v(" "),
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.newRedirect.to_url,
                              expression: "newRedirect.to_url"
                            }
                          ],
                          attrs: { type: "text" },
                          domProps: { value: _vm.newRedirect.to_url },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                _vm.newRedirect,
                                "to_url",
                                $event.target.value
                              )
                            }
                          }
                        })
                      ]),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          staticClass: "dvs-btn",
                          style: _vm.theme.actionButton,
                          attrs: { disabled: _vm.createInvalid },
                          on: { click: _vm.requestCreateRedirect }
                        },
                        [_vm._v("Create")]
                      ),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          staticClass: "dvs-btn",
                          style: _vm.theme.actionButtonGhost,
                          on: {
                            click: function($event) {
                              _vm.showCreate = false
                            }
                          }
                        },
                        [_vm._v("Cancel")]
                      )
                    ]
                  )
                : _vm._e()
            ],
            1
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-98e62c4c", module.exports)
  }
}

/***/ }),

/***/ 1016:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign__ = __webpack_require__(17);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends__ = __webpack_require__(8);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_vuex__ = __webpack_require__(5);


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
  name: 'RedirectsView',
  data: function data() {
    return {
      localValue: {},
      modulesToLoad: 1,
      showPassword: false
    };
  },
  mounted: function mounted() {
    this.retrieveAllRedirects();
  },

  methods: __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_2_vuex__["b" /* mapActions */])('devise', ['getRedirects', 'deleteRedirect', 'updateRedirect']), {
    requestSaveRedirect: function requestSaveRedirect() {
      this.updateRedirect({ redirect: this.redirect, data: this.localValue });
    },
    requestDeleteRedirect: function requestDeleteRedirect() {
      var self = this;
      this.deleteRedirect(this.redirect).then(function () {
        self.goToPage('devise-redirects-index');
      });
    },
    retrieveAllRedirects: function retrieveAllRedirects() {
      var self = this;
      this.getRedirects().then(function () {
        self.localValue = __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign___default()({}, self.localValue, self.redirect);
        devise.$bus.$emit('incrementLoadbar', self.modulesToLoad);
      });
    }
  }),
  computed: __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_2_vuex__["c" /* mapGetters */])('devise', ['redirect']))
});

/***/ }),

/***/ 1017:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "administration",
    [
      _c("sidebar", { attrs: { title: "Manage Redirects" } }),
      _vm._v(" "),
      _c(
        "div",
        { attrs: { id: "devise-admin-content" } },
        [
          _c("action-bar", [
            _c(
              "li",
              {
                directives: [
                  {
                    name: "devise-alert-confirm",
                    rawName: "v-devise-alert-confirm",
                    value: {
                      callback: _vm.requestDeleteRedirect,
                      message: "Are you sure you want to delete this redirect?"
                    },
                    expression:
                      "{callback: requestDeleteRedirect, message: 'Are you sure you want to delete this redirect?'}"
                  }
                ],
                staticClass: "dvs-btn dvs-btn-sm dvs-mb-2",
                style: _vm.theme.actionButton
              },
              [_vm._v("\n        Delete This Redirect\n      ")]
            )
          ]),
          _vm._v(" "),
          _c(
            "h3",
            {
              staticClass: "dvs-mb-8 dvs-pr-16",
              style: { color: _vm.theme.panel.color }
            },
            [_vm._v("Redirect Settings")]
          ),
          _vm._v(" "),
          _c("div", { staticClass: "dvs-mb-12" }, [
            _c("form", [
              _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                _c("label", [_vm._v("From URL")]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.localValue.from_url,
                      expression: "localValue.from_url"
                    }
                  ],
                  attrs: {
                    type: "text",
                    autocomplete: "off",
                    placeholder: "Name of the Redirect"
                  },
                  domProps: { value: _vm.localValue.from_url },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(_vm.localValue, "from_url", $event.target.value)
                    }
                  }
                })
              ]),
              _vm._v(" "),
              _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                _c("label", [_vm._v("To URL")]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.localValue.to_url,
                      expression: "localValue.to_url"
                    }
                  ],
                  attrs: {
                    type: "text",
                    autocomplete: "off",
                    placeholder: "Email of the Redirect"
                  },
                  domProps: { value: _vm.localValue.to_url },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(_vm.localValue, "to_url", $event.target.value)
                    }
                  }
                })
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "dvs-flex" }, [
              _c(
                "button",
                {
                  staticClass: "dvs-btn dvs-mr-2",
                  style: _vm.theme.actionButton,
                  on: { click: _vm.requestSaveRedirect }
                },
                [_vm._v("Save")]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "dvs-btn dvs-mr-4",
                  style: _vm.theme.actionButtonGhost,
                  on: {
                    click: function($event) {
                      _vm.goToPage("devise-redirects-index")
                    }
                  }
                },
                [_vm._v("Cancel")]
              )
            ])
          ])
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-6c44d39c", module.exports)
  }
}

/***/ }),

/***/ 683:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(1011)
/* template */
var __vue_template__ = __webpack_require__(1015)
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
Component.options.__file = "src/components/redirects/Index.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-98e62c4c", Component.options)
  } else {
    hotAPI.reload("data-v-98e62c4c", Component.options)
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
var __vue_script__ = __webpack_require__(1016)
/* template */
var __vue_template__ = __webpack_require__(1017)
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
Component.options.__file = "src/components/redirects/Edit.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6c44d39c", Component.options)
  } else {
    hotAPI.reload("data-v-6c44d39c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 685:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(686)
/* template */
var __vue_template__ = __webpack_require__(687)
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
Component.options.__file = "node_modules/vue-ionicons/dist/ios-close.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4516aeae", Component.options)
  } else {
    hotAPI.reload("data-v-4516aeae", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 686:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__ionicons_mixin__ = __webpack_require__(37);
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
  name: "ios-close-icon",
  mixins: [__WEBPACK_IMPORTED_MODULE_0__ionicons_mixin__["a" /* default */]],
  data: function data() {
    var iconTitle = this.title ? this.title : "Ios Close Icon";
    return {
      iconTitle: iconTitle
    };
  }
});

/***/ }),

/***/ 687:
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
      attrs: { title: _vm.iconTitle, name: "ios-close-icon" }
    },
    [
      _c(
        "svg",
        {
          staticClass: "ion__svg",
          attrs: { width: _vm.w, height: _vm.h, viewBox: "0 0 512 512" }
        },
        [
          _c("path", {
            attrs: {
              d:
                "M278.6 256l68.2-68.2c6.2-6.2 6.2-16.4 0-22.6-6.2-6.2-16.4-6.2-22.6 0L256 233.4l-68.2-68.2c-6.2-6.2-16.4-6.2-22.6 0-3.1 3.1-4.7 7.2-4.7 11.3 0 4.1 1.6 8.2 4.7 11.3l68.2 68.2-68.2 68.2c-3.1 3.1-4.7 7.2-4.7 11.3 0 4.1 1.6 8.2 4.7 11.3 6.2 6.2 16.4 6.2 22.6 0l68.2-68.2 68.2 68.2c6.2 6.2 16.4 6.2 22.6 0 6.2-6.2 6.2-16.4 0-22.6L278.6 256z"
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
    require("vue-hot-reload-api")      .rerender("data-v-4516aeae", module.exports)
  }
}

/***/ }),

/***/ 689:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(690)
/* template */
var __vue_template__ = __webpack_require__(691)
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
Component.options.__file = "src/components/utilities/Modal.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7cf19530", Component.options)
  } else {
    hotAPI.reload("data-v-7cf19530", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 690:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_ionicons_dist_ios_close_vue__ = __webpack_require__(685);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_ionicons_dist_ios_close_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue_ionicons_dist_ios_close_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__Panel__ = __webpack_require__(38);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__Panel___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__Panel__);
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
  methods: {
    close: function close() {
      this.$emit('close');
    }
  },
  components: {
    CloseIcon: __WEBPACK_IMPORTED_MODULE_0_vue_ionicons_dist_ios_close_vue___default.a,
    Panel: __WEBPACK_IMPORTED_MODULE_1__Panel___default.a
  }
});

/***/ }),

/***/ 691:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "dvs-fixed dvs-pin" }, [
    _c("div", {
      staticClass: "dvs-blocker dvs-fixed dvs-pin",
      on: { click: _vm.close }
    }),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass:
          "dvs-absolute dvs-absolute-center dvs-z-50 dvs-min-w-2/3 dvs-max-h-screen"
      },
      [
        _c(
          "panel",
          {
            staticClass: "dvs-w-full",
            attrs: { "panel-style": _vm.theme.panel }
          },
          [
            _c(
              "div",
              { staticClass: "dvs-p-8" },
              [
                _c(
                  "div",
                  { on: { click: _vm.close } },
                  [
                    _c("close-icon", {
                      staticClass:
                        "dvs-absolute dvs-pin-t dvs-pin-r dvs-m-6 dvs-cursor-pointer",
                      style: { color: _vm.theme.panel.color },
                      attrs: { w: "40", h: "40" }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _vm._t("default")
              ],
              2
            )
          ]
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
    require("vue-hot-reload-api")      .rerender("data-v-7cf19530", module.exports)
  }
}

/***/ })

});