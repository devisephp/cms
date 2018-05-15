webpackJsonp([1],{

/***/ 539:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(626)
/* template */
var __vue_template__ = __webpack_require__(627)
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

/***/ 540:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(628)
/* template */
var __vue_template__ = __webpack_require__(629)
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

/***/ 626:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utilities_Modal__ = __webpack_require__(207);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utilities_Modal___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__utilities_Modal__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_vuex__ = __webpack_require__(2);

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  created: function created() {
    console.log('asdfasdfasdf');
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

/***/ 627:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass:
        "dvs-flex dvs-justify-end dvs-items-stretch dvs-min-h-screen dvs-relative"
    },
    [
      _c("div", { attrs: { id: "devise-sidebar" } }, [
        _c("h2", { staticClass: "dvs-font-bold dvs-mb-2" }, [_vm._v("Users")]),
        _vm._v(" "),
        _c(
          "a",
          {
            staticClass:
              "dvs-mb-8 dvs-block dvs-uppercase dvs-font-bold dvs-text-xs",
            attrs: { href: "#" },
            on: {
              click: function($event) {
                $event.preventDefault()
                _vm.goToPage("devise-index")
              }
            }
          },
          [_vm._v("Back to Main Menu")]
        ),
        _vm._v(" "),
        _c("ul", { staticClass: "dvs-list-reset" }, [
          _c(
            "li",
            {
              staticClass:
                "dvs-cursor-pointer dvs-mb-6 dvs-text-lg dvs-cursor-pointer",
              on: {
                click: function($event) {
                  $event.preventDefault()
                  _vm.showCreate = true
                }
              }
            },
            [_vm._v("\n        Create New User\n      ")]
          )
        ])
      ]),
      _vm._v(" "),
      _c(
        "div",
        { attrs: { id: "devise-admin-content" } },
        [
          _c("h2", { staticClass: "dvs-mb-10" }, [_vm._v("Current Users")]),
          _vm._v(" "),
          _vm._l(_vm.users.data, function(user) {
            return _c(
              "div",
              {
                staticClass:
                  "dvs-mb-6 dvs-rounded-sm dvs-bg-white dvs-shadow-sm dvs-flex dvs-justify-between dvs-items-center"
              },
              [
                _c(
                  "div",
                  {
                    staticClass:
                      "dvs-min-w-2/5 dvs-text-xl dvs-font-bold dvs-pr-8"
                  },
                  [_vm._v("\n        " + _vm._s(user.name) + "\n      ")]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "dvs-w-2/5 dvs-px-8 dvs-flex dvs-justify-end"
                  },
                  [
                    _c(
                      "button",
                      {
                        staticClass: "dvs-btn dvs-btn-xs",
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
        { attrs: { name: "fade" } },
        [
          _vm.showCreate
            ? _c("devise-modal", { staticClass: "dvs-z-50" }, [
                _c("h4", { staticClass: "dvs-mb-4" }, [
                  _vm._v("Create new user")
                ]),
                _vm._v(" "),
                _c("fieldset", { staticClass: "dvs-fieldset mb-4" }, [
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
                    attrs: { type: "text", placeholder: "Name of the User" },
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
                _c("fieldset", { staticClass: "dvs-fieldset mb-4" }, [
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
                    attrs: { type: "text", placeholder: "Email of the User" },
                    domProps: { value: _vm.newUser.email },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.newUser, "email", $event.target.value)
                      }
                    }
                  })
                ]),
                _vm._v(" "),
                _c("fieldset", { staticClass: "dvs-fieldset mb-4" }, [
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
                        _vm.$set(_vm.newUser, "password", $event.target.value)
                      }
                    }
                  })
                ]),
                _vm._v(" "),
                _c("fieldset", { staticClass: "dvs-fieldset mb-4" }, [
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
                    domProps: { value: _vm.newUser.password_confirmation },
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
                    attrs: { disabled: _vm.createInvalid },
                    on: { click: _vm.requestCreateUser }
                  },
                  [_vm._v("Create")]
                ),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "dvs-btn dvs-btn-plain",
                    on: {
                      click: function($event) {
                        _vm.showCreate = false
                      }
                    }
                  },
                  [_vm._v("Cancel")]
                )
              ])
            : _vm._e()
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

/***/ 628:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__utilities_Modal__ = __webpack_require__(207);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__utilities_Modal___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__utilities_Modal__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_vuex__ = __webpack_require__(2);


//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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

  methods: __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_3_vuex__["b" /* mapActions */])('devise', ['getUsers', 'deleteUser', 'updateUser']), {
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
  computed: __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_3_vuex__["c" /* mapGetters */])('devise', ['user'])),
  components: {
    DeviseModal: __WEBPACK_IMPORTED_MODULE_2__utilities_Modal___default.a
  }
});

/***/ }),

/***/ 629:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.user
    ? _c(
        "div",
        {
          staticClass:
            "dvs-flex dvs-items-stretch dvs-min-h-screen dvs-relative"
        },
        [
          _c("div", { attrs: { id: "devise-sidebar" } }, [
            _c("h2", { staticClass: "dvs-font-bold dvs-mb-2" }, [
              _vm._v("Manage User")
            ]),
            _vm._v(" "),
            _c(
              "a",
              {
                staticClass:
                  "dvs-mb-8 dvs-block dvs-uppercase dvs-font-bold dvs-text-xs",
                attrs: { href: "#" },
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    _vm.goToPage("devise-users-index")
                  }
                }
              },
              [_vm._v("Back to Users")]
            ),
            _vm._v(" "),
            _c("ul", { staticClass: "dvs-list-reset dvs-mb-10" }, [
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
                  staticClass: "dvs-cursor-pointer dvs-mb-6 dvs-text-lg"
                },
                [_vm._v("\n        Delete This User\n      ")]
              )
            ])
          ]),
          _vm._v(" "),
          _c("div", { attrs: { id: "devise-admin-content" } }, [
            _c("h3", { staticClass: "dvs-mb-8" }, [
              _vm._v(_vm._s(_vm.localValue.name) + " Settings")
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "dvs-mb-12" }, [
              _c(
                "form",
                [
                  _c("fieldset", { staticClass: "dvs-fieldset mb-4" }, [
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
                  _c("fieldset", { staticClass: "dvs-fieldset mb-4" }, [
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
                    ? _c("fieldset", { staticClass: "dvs-fieldset mb-4" }, [
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
                                  $$i < 0 &&
                                    (_vm.showPassword = $$a.concat([$$v]))
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
                        _c("fieldset", { staticClass: "dvs-fieldset mb-4" }, [
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
                        _c("fieldset", { staticClass: "dvs-fieldset mb-4" }, [
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
                    on: { click: _vm.requestSaveUser }
                  },
                  [_vm._v("Save")]
                ),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "dvs-btn dvs-btn-plain dvs-mr-4",
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
          ])
        ]
      )
    : _vm._e()
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