webpackJsonp([2],{

/***/ 538:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(624)
/* template */
var __vue_template__ = __webpack_require__(625)
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
Component.options.__file = "src/components/sites/Index.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4f32c58f", Component.options)
  } else {
    hotAPI.reload("data-v-4f32c58f", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 624:
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: 'SitesIndex',
  data: function data() {
    return {
      modulesToLoad: 2,
      showCreate: false,
      showEdit: false,
      editAddLanguage: null,
      editSite: {
        id: null,
        name: null,
        domain: null,
        languages: []
      },
      newSite: {
        name: null,
        domain: null
      }
    };
  },
  mounted: function mounted() {
    this.retrieveAllSites();
    this.retrieveAllLanguages();
  },

  methods: __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_2_vuex__["b" /* mapActions */])('devise', ['getSites', 'getLanguages', 'createSite', 'updateSite', 'deleteSite']), {
    requestCreateSite: function requestCreateSite() {
      var self = this;
      this.createSite(this.newSite).then(function () {
        self.newSite.name = null;
        self.newSite.domain = null;
        self.showCreate = false;
      });
    },
    showEditSite: function showEditSite(site) {
      this.editSite.id = site.id;
      this.editSite.name = site.name;
      this.editSite.domain = site.domain;
      this.editSite.languages = site.languages;
      this.showEdit = true;
    },
    requestEditSite: function requestEditSite() {
      var self = this;
      this.updateSite({ site: this.originalSite(this.editSite.id), data: this.editSite }).then(function () {
        self.editSite.id = null;
        self.editSite.name = null;
        self.editSite.domain = null;
        self.showEdit = false;
      });
    },
    requestDeleteSite: function requestDeleteSite(site) {
      var self = this;
      this.deleteSite(site).then(function () {
        self.retrieveAllSites();
      });
    },
    retrieveAllSites: function retrieveAllSites() {
      var loadbar = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;

      this.getSites().then(function () {
        if (loadbar) {
          devise.$bus.$emit('incrementLoadbar', self.modulesToLoad);
        }
      });
    },
    retrieveAllLanguages: function retrieveAllLanguages() {
      var loadbar = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;

      this.getLanguages().then(function () {
        if (loadbar) {
          devise.$bus.$emit('incrementLoadbar', self.modulesToLoad);
        }
      });
    },
    addEditLanguage: function addEditLanguage() {
      this.editAddLanguage.default = 0;
      this.editSite.languages.push(this.editAddLanguage);
      this.editAddLanguage = null;
    },
    setDefaultLanguage: function setDefaultLanguage(language) {
      // Set them all to off and turn the default to on
      this.editSite.languages.map(function (l) {
        l.default = 0;
        if (l.id === language.id) {
          l.default = 1;
          return 1;
        }
        return 0;
      });
    },
    originalSite: function originalSite(id) {
      return this.sites.data.find(function (site) {
        return site.id === id;
      });
    }
  }),
  computed: __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_2_vuex__["c" /* mapGetters */])('devise', ['sites', 'languages']), {
    createInvalid: function createInvalid() {
      return this.newSite.name === null || this.newSite.domain === null;
    },
    editInvalid: function editInvalid() {
      return this.editSite.name === null || this.editSite.domain === null;
    },
    languagesNotInEditSite: function languagesNotInEditSite() {
      var self = this;
      return this.languages.data.filter(function (language) {
        var match = self.editSite.languages.filter(function (l) {
          return l.id === language.id;
        });
        return match.length === 0;
      });
    }
  }),
  components: {
    DeviseModal: __WEBPACK_IMPORTED_MODULE_1__utilities_Modal___default.a
  }
});

/***/ }),

/***/ 625:
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
        _c("h2", { staticClass: "dvs-font-bold dvs-mb-2" }, [_vm._v("Sites")]),
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
                _vm.goToPage("devise-developers-index")
              }
            }
          },
          [_vm._v("Back to Developers")]
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
            [_vm._v("\n        Create New Site\n      ")]
          )
        ])
      ]),
      _vm._v(" "),
      _c(
        "div",
        { attrs: { id: "devise-admin-content" } },
        [
          _c("h2", { staticClass: "dvs-mb-10" }, [_vm._v("Current Sites")]),
          _vm._v(" "),
          _vm._l(_vm.sites.data, function(site) {
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
                      "dvs-min-w-2/5 dvs-text-base dvs-font-bold dvs-pr-8"
                  },
                  [
                    _vm._v("\n        " + _vm._s(site.name)),
                    _c("br"),
                    _vm._v(" "),
                    _c(
                      "span",
                      { staticClass: "dvs-font-mono dvs-font-normal" },
                      [_vm._v(_vm._s(site.domain))]
                    )
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass:
                      "dvs-min-w-1/5 dvs-text-sm dvs-font-mono dvs-pr-8"
                  },
                  [
                    _vm._v(
                      "\n        SITE_" + _vm._s(site.id) + "_DOMAIN\n      "
                    )
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "dvs-min-w-1/5 dvs-flex dvs-flex-wrap dvs-pr-8"
                  },
                  _vm._l(site.languages, function(language) {
                    return _c(
                      "span",
                      {
                        staticClass:
                          "dvs-mb-2 dvs-mr-2 dvs-tag dvs-bg-grey-lighter",
                        class: {
                          "dvs-bg-green-dark dvs-text-white": language.default
                        }
                      },
                      [_vm._v(_vm._s(language.code))]
                    )
                  })
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "dvs-w-1/5 dvs-px-8 dvs-flex dvs-justify-end"
                  },
                  [
                    _c(
                      "button",
                      {
                        staticClass: "dvs-btn dvs-btn-xs dvs-mr-2",
                        on: {
                          click: function($event) {
                            _vm.showEditSite(site)
                          }
                        }
                      },
                      [_vm._v("Edit")]
                    ),
                    _vm._v(" "),
                    _c(
                      "button",
                      {
                        directives: [
                          {
                            name: "devise-alert-confirm",
                            rawName: "v-devise-alert-confirm",
                            value: {
                              callback: _vm.requestDeleteSite,
                              arguments: site,
                              message:
                                "Are you sure you want to delete this site?"
                            },
                            expression:
                              "{callback: requestDeleteSite, arguments: site, message: 'Are you sure you want to delete this site?'}"
                          }
                        ],
                        staticClass: "dvs-btn dvs-btn-xs"
                      },
                      [_vm._v("Delete")]
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
                  _c("h4", { staticClass: "dvs-mb-4" }, [
                    _vm._v("Create new site")
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
                          value: _vm.newSite.name,
                          expression: "newSite.name"
                        }
                      ],
                      attrs: { type: "text", placeholder: "Name of the Site" },
                      domProps: { value: _vm.newSite.name },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(_vm.newSite, "name", $event.target.value)
                        }
                      }
                    })
                  ]),
                  _vm._v(" "),
                  _c("help", { staticClass: "dvs-mb-8" }, [
                    _vm._v(
                      'The domain should not include the http or https:// protocol identifier. So your site entry could be "my-super-awesome-site.com" or "sub-domain.my-super-awesome-site.com". To Support development environments you can override these values in your .env file in the root of your project with something like "SITE_1_DOMAIN=my-super-awesome-site.test" for your local development or staging.'
                    )
                  ]),
                  _vm._v(" "),
                  _c("fieldset", { staticClass: "dvs-fieldset mb-4" }, [
                    _c("label", [_vm._v("Domain")]),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.newSite.domain,
                          expression: "newSite.domain"
                        }
                      ],
                      attrs: {
                        type: "text",
                        placeholder: "Domain of the Site"
                      },
                      domProps: { value: _vm.newSite.domain },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(_vm.newSite, "domain", $event.target.value)
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
                      on: { click: _vm.requestCreateSite }
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
                ],
                1
              )
            : _vm._e()
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "transition",
        { attrs: { name: "fade" } },
        [
          _vm.showEdit
            ? _c(
                "devise-modal",
                {
                  staticClass: "dvs-z-50",
                  on: {
                    close: function($event) {
                      _vm.showEdit = false
                    }
                  }
                },
                [
                  _c("h4", { staticClass: "dvs-mb-4" }, [_vm._v("Edit site")]),
                  _vm._v(" "),
                  _c("fieldset", { staticClass: "dvs-fieldset mb-4" }, [
                    _c("label", [_vm._v("Name")]),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.editSite.name,
                          expression: "editSite.name"
                        }
                      ],
                      attrs: { type: "text", placeholder: "Name of the Site" },
                      domProps: { value: _vm.editSite.name },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(_vm.editSite, "name", $event.target.value)
                        }
                      }
                    })
                  ]),
                  _vm._v(" "),
                  _c("help", { staticClass: "dvs-mb-8" }, [
                    _vm._v(
                      'The domain should not include the http or https:// protocol identifier. So your site entry could be "my-super-awesome-site.com" or "sub-domain.my-super-awesome-site.com". To Support development environments you can override these values in your .env file in the root of your project with something like "SITE_1_DOMAIN=my-super-awesome-site.test" for your local development or staging.'
                    )
                  ]),
                  _vm._v(" "),
                  _c("fieldset", { staticClass: "dvs-fieldset mb-4" }, [
                    _c("label", [_vm._v("Domain")]),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.editSite.domain,
                          expression: "editSite.domain"
                        }
                      ],
                      attrs: {
                        type: "text",
                        placeholder: "Domain of the Site"
                      },
                      domProps: { value: _vm.editSite.domain },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(_vm.editSite, "domain", $event.target.value)
                        }
                      }
                    })
                  ]),
                  _vm._v(" "),
                  _c("fieldset", { staticClass: "dvs-fieldset mb-4" }, [
                    _c("label", [_vm._v("Languages")]),
                    _vm._v(" "),
                    _c(
                      "select",
                      {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.editAddLanguage,
                            expression: "editAddLanguage"
                          }
                        ],
                        on: {
                          change: [
                            function($event) {
                              var $$selectedVal = Array.prototype.filter
                                .call($event.target.options, function(o) {
                                  return o.selected
                                })
                                .map(function(o) {
                                  var val = "_value" in o ? o._value : o.value
                                  return val
                                })
                              _vm.editAddLanguage = $event.target.multiple
                                ? $$selectedVal
                                : $$selectedVal[0]
                            },
                            function($event) {
                              _vm.addEditLanguage()
                            }
                          ]
                        }
                      },
                      [
                        _c("option", { domProps: { value: null } }, [
                          _vm._v("Add a Language")
                        ]),
                        _vm._v(" "),
                        _vm._l(_vm.languagesNotInEditSite, function(language) {
                          return _c(
                            "option",
                            { domProps: { value: language } },
                            [_vm._v(_vm._s(language.code))]
                          )
                        })
                      ],
                      2
                    )
                  ]),
                  _vm._v(" "),
                  _c(
                    "fieldset",
                    { staticClass: "dvs-fieldset mb-8" },
                    [
                      _c("help", { staticClass: "dvs-mb-8" }, [
                        _vm._v(
                          "Green indicates the default language. Click on the language tags below to change."
                        )
                      ]),
                      _vm._v(" "),
                      _c("label", [_vm._v("Current Languages")]),
                      _vm._v(" "),
                      _vm._l(_vm.editSite.languages, function(language) {
                        return _c(
                          "span",
                          {
                            staticClass:
                              "dvs-mr-2 dvs-tag dvs-bg-grey-lighter dvs-cursor-pointer",
                            class: {
                              "dvs-bg-green-dark dvs-text-white":
                                language.default
                            },
                            on: {
                              click: function($event) {
                                _vm.setDefaultLanguage(language)
                              }
                            }
                          },
                          [_vm._v(_vm._s(language.code))]
                        )
                      }),
                      _vm._v(" "),
                      _vm.editSite.languages.length < 1
                        ? _c("span", [_vm._v("No Languages")])
                        : _vm._e()
                    ],
                    2
                  ),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      staticClass: "dvs-btn",
                      attrs: { disabled: _vm.editInvalid },
                      on: { click: _vm.requestEditSite }
                    },
                    [_vm._v("Edit")]
                  ),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      staticClass: "dvs-btn dvs-btn-plain",
                      on: {
                        click: function($event) {
                          _vm.showEdit = false
                        }
                      }
                    },
                    [_vm._v("Cancel")]
                  )
                ],
                1
              )
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
    require("vue-hot-reload-api")      .rerender("data-v-4f32c58f", module.exports)
  }
}

/***/ })

});