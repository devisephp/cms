webpackJsonp([9],{

/***/ 692:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(924)
/* template */
var __vue_template__ = __webpack_require__(925)
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
Component.options.__file = "src/components/users/Index.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-3feb7e8b", Component.options)
  } else {
    hotAPI.reload("data-v-3feb7e8b", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 693:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(926)
/* template */
var __vue_template__ = __webpack_require__(927)
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
Component.options.__file = "src/components/users/Edit.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-001db13e", Component.options)
  } else {
    hotAPI.reload("data-v-001db13e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 696:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(697)
/* template */
var __vue_template__ = __webpack_require__(698)
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

/***/ 697:
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

/***/ 698:
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

/***/ 700:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(701)
/* template */
var __vue_template__ = __webpack_require__(702)
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

/***/ 701:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_ionicons_dist_ios_close_vue__ = __webpack_require__(696);
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

/***/ 702:
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

/***/ }),

/***/ 924:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__ = __webpack_require__(6);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utilities_Modal__ = __webpack_require__(700);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utilities_Modal___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__utilities_Modal__);
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
  name: 'UsersIndex',
  data: function data() {
    return {
      modulesToLoad: 1,
      showCreate: false,
      newUser: {
        name: null,
        email: null,
        password: null,
        password_confirmation: null
      }
    };
  },
  mounted: function mounted() {
    this.retrieveAllUsers();
  },

  methods: __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_2_vuex__["b" /* mapActions */])('devise', ['getUsers', 'createUser']), {
    requestCreateUser: function requestCreateUser() {
      var self = this;
      this.createUser(this.newUser).then(function () {
        self.newUser.name = null;
        self.newUser.email = null;
        self.newUser.password = null;
        self.newUser.password_confirmation = false;
        self.showCreate = false;
      });
    },
    retrieveAllUsers: function retrieveAllUsers() {
      var loadbar = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;

      this.getUsers().then(function () {
        if (loadbar) {
          devise.$bus.$emit('incrementLoadbar', self.modulesToLoad);
        }
      });
    },
    loadUser: function loadUser(id) {
      this.$router.push({ name: 'devise-users-edit', params: { userId: id } });
    }
  }),
  computed: __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_2_vuex__["c" /* mapGetters */])('devise', ['users']), {
    createInvalid: function createInvalid() {
      return this.newUser.name === null || this.newUser.email === null || this.newUser.password === null || this.newUser.password_confirmation === null || this.newUser.password !== this.newUser.password_confirmation;
    }
  }),
  components: {
    DeviseModal: __WEBPACK_IMPORTED_MODULE_1__utilities_Modal___default.a
  }
});

/***/ }),

/***/ 925:
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
              [_vm._v("\n        Create New User\n      ")]
            )
          ]),
          _vm._v(" "),
          _c(
            "h3",
            {
              staticClass: "dvs-mb-10",
              style: { color: _vm.theme.panel.color }
            },
            [_vm._v("Current Users")]
          ),
          _vm._v(" "),
          _vm._l(_vm.users.data, function(user) {
            return _c(
              "div",
              {
                key: user.id,
                staticClass:
                  "dvs-mb-6 dvs-flex dvs-justify-between dvs-items-center"
              },
              [
                _c(
                  "div",
                  { staticClass: "dvs-min-w-2/5 dvs-font-bold dvs-pr-8" },
                  [_vm._v("\n        " + _vm._s(user.name) + "\n      ")]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "dvs-w-2/5 dvs-pl-8 dvs-flex dvs-justify-end"
                  },
                  [
                    _c(
                      "button",
                      {
                        staticClass: "dvs-btn dvs-btn-xs",
                        style: _vm.theme.actionButtonGhost,
                        on: {
                          click: function($event) {
                            _vm.loadUser(user.id)
                          }
                        }
                      },
                      [_vm._v("Manage")]
                    )
                  ]
                )
              ]
            )
          })
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
                        "h3",
                        {
                          staticClass: "dvs-mb-4",
                          style: { color: _vm.theme.panel.color }
                        },
                        [_vm._v("Create new user")]
                      ),
                      _vm._v(" "),
                      _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                        _c("label", [_vm._v("Name")]),
                        _vm._v(" "),
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.newUser.name,
                              expression: "newUser.name"
                            }
                          ],
                          attrs: {
                            type: "text",
                            placeholder: "Name of the User"
                          },
                          domProps: { value: _vm.newUser.name },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(_vm.newUser, "name", $event.target.value)
                            }
                          }
                        })
                      ]),
                      _vm._v(" "),
                      _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                        _c("label", [_vm._v("Email")]),
                        _vm._v(" "),
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.newUser.email,
                              expression: "newUser.email"
                            }
                          ],
                          attrs: {
                            type: "text",
                            placeholder: "Email of the User"
                          },
                          domProps: { value: _vm.newUser.email },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                _vm.newUser,
                                "email",
                                $event.target.value
                              )
                            }
                          }
                        })
                      ]),
                      _vm._v(" "),
                      _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                        _c("label", [_vm._v("Password")]),
                        _vm._v(" "),
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.newUser.password,
                              expression: "newUser.password"
                            }
                          ],
                          attrs: { type: "password" },
                          domProps: { value: _vm.newUser.password },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                _vm.newUser,
                                "password",
                                $event.target.value
                              )
                            }
                          }
                        })
                      ]),
                      _vm._v(" "),
                      _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                        _c("label", [_vm._v("Confirm Password")]),
                        _vm._v(" "),
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.newUser.password_confirmation,
                              expression: "newUser.password_confirmation"
                            }
                          ],
                          attrs: { type: "password" },
                          domProps: {
                            value: _vm.newUser.password_confirmation
                          },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                _vm.newUser,
                                "password_confirmation",
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
                          on: { click: _vm.requestCreateUser }
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
    require("vue-hot-reload-api")      .rerender("data-v-3feb7e8b", module.exports)
  }
}

/***/ }),

/***/ 926:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign__ = __webpack_require__(17);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends__ = __webpack_require__(6);
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
  name: 'UsersView',
  data: function data() {
    return {
      localValue: {},
      modulesToLoad: 1,
      showPassword: false
    };
  },
  mounted: function mounted() {
    this.retrieveAllUsers();
  },

  methods: __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_2_vuex__["b" /* mapActions */])('devise', ['getUsers', 'deleteUser', 'updateUser']), {
    requestSaveUser: function requestSaveUser() {
      this.updateUser({ user: this.user, data: this.localValue });
    },
    requestDeleteUser: function requestDeleteUser() {
      var self = this;
      this.deleteUser(this.user).then(function () {
        self.goToPage('devise-users-index');
      });
    },
    retrieveAllUsers: function retrieveAllUsers() {
      var self = this;
      this.getUsers().then(function () {
        self.localValue = __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign___default()({}, self.localValue, self.user);
        devise.$bus.$emit('incrementLoadbar', self.modulesToLoad);
      });
    }
  }),
  computed: __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_2_vuex__["c" /* mapGetters */])('devise', ['user']))
});

/***/ }),

/***/ 927:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
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
                    callback: _vm.requestDeleteUser,
                    message: "Are you sure you want to delete this user?"
                  },
                  expression:
                    "{callback: requestDeleteUser, message: 'Are you sure you want to delete this user?'}"
                }
              ],
              staticClass: "dvs-btn dvs-btn-sm dvs-mb-2",
              style: _vm.theme.actionButton
            },
            [_vm._v("\n        Delete This User\n      ")]
          )
        ]),
        _vm._v(" "),
        _c(
          "h3",
          {
            staticClass: "dvs-mb-8 dvs-pr-16",
            style: { color: _vm.theme.panel.color }
          },
          [_vm._v(_vm._s(_vm.localValue.name) + " Settings")]
        ),
        _vm._v(" "),
        _c("div", [
          _c(
            "form",
            [
              _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                _c("label", [_vm._v("Name of User")]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.localValue.name,
                      expression: "localValue.name"
                    }
                  ],
                  attrs: {
                    type: "text",
                    autocomplete: "off",
                    placeholder: "Name of the User"
                  },
                  domProps: { value: _vm.localValue.name },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(_vm.localValue, "name", $event.target.value)
                    }
                  }
                })
              ]),
              _vm._v(" "),
              _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                _c("label", [_vm._v("Email")]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.localValue.email,
                      expression: "localValue.email"
                    }
                  ],
                  attrs: {
                    type: "text",
                    autocomplete: "off",
                    placeholder: "Email of the User"
                  },
                  domProps: { value: _vm.localValue.email },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(_vm.localValue, "email", $event.target.value)
                    }
                  }
                })
              ]),
              _vm._v(" "),
              !_vm.showPassword
                ? _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                    _c("label", [_vm._v("Edit Password?")]),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.showPassword,
                          expression: "showPassword"
                        }
                      ],
                      attrs: { type: "checkbox" },
                      domProps: {
                        checked: Array.isArray(_vm.showPassword)
                          ? _vm._i(_vm.showPassword, null) > -1
                          : _vm.showPassword
                      },
                      on: {
                        change: function($event) {
                          var $$a = _vm.showPassword,
                            $$el = $event.target,
                            $$c = $$el.checked ? true : false
                          if (Array.isArray($$a)) {
                            var $$v = null,
                              $$i = _vm._i($$a, $$v)
                            if ($$el.checked) {
                              $$i < 0 && (_vm.showPassword = $$a.concat([$$v]))
                            } else {
                              $$i > -1 &&
                                (_vm.showPassword = $$a
                                  .slice(0, $$i)
                                  .concat($$a.slice($$i + 1)))
                            }
                          } else {
                            _vm.showPassword = $$c
                          }
                        }
                      }
                    })
                  ])
                : _vm._e(),
              _vm._v(" "),
              _vm.showPassword
                ? [
                    _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                      _c("label", [_vm._v("Password")]),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.localValue.password,
                            expression: "localValue.password"
                          }
                        ],
                        attrs: { type: "password", autocomplete: "off" },
                        domProps: { value: _vm.localValue.password },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.localValue,
                              "password",
                              $event.target.value
                            )
                          }
                        }
                      })
                    ]),
                    _vm._v(" "),
                    _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                      _c("label", [_vm._v("Password Confirm")]),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.localValue.password_confirmation,
                            expression: "localValue.password_confirmation"
                          }
                        ],
                        attrs: { type: "password", autocomplete: "off" },
                        domProps: {
                          value: _vm.localValue.password_confirmation
                        },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.localValue,
                              "password_confirmation",
                              $event.target.value
                            )
                          }
                        }
                      })
                    ])
                  ]
                : _vm._e()
            ],
            2
          ),
          _vm._v(" "),
          _c("div", { staticClass: "dvs-flex" }, [
            _c(
              "button",
              {
                staticClass: "dvs-btn dvs-mr-2",
                style: _vm.theme.actionButton,
                on: { click: _vm.requestSaveUser }
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
                    _vm.goToPage("devise-users-index")
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
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-001db13e", module.exports)
  }
}

/***/ })

});