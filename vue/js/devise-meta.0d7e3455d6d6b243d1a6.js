webpackJsonp([4],{

/***/ 532:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(558)
/* template */
var __vue_template__ = __webpack_require__(559)
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
Component.options.__file = "src/components/meta/Manage.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-287c0922", Component.options)
  } else {
    hotAPI.reload("data-v-287c0922", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 558:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends__);
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



/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'MetaManage',
  data: function data() {
    return {
      localValue: {
        data: []
      },
      modulesToLoad: 1,
      newMeta: {
        attribute_name: null,
        attribute_value: null,
        content: null
      }
    };
  },
  mounted: function mounted() {
    this.retrieveAllMeta();
  },

  methods: __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_2_vuex__["b" /* mapActions */])('devise', ['getMeta', 'createMeta', 'updateMeta', 'deleteMeta']), {
    requestCreateMeta: function requestCreateMeta() {
      var self = this;
      this.createMeta(this.newMeta).then(function () {
        self.newMeta.attribute_name = null;
        self.newMeta.attribute_value = null;
        self.newMeta.content = null;
      });
    },
    requestUpdateMeta: function requestUpdateMeta(meta) {
      this.updateMeta(meta).then(function () {
        meta.edit = false;
      });
    },
    requestDeleteMeta: function requestDeleteMeta(meta) {
      this.deleteMeta(meta);
    },
    retrieveAllMeta: function retrieveAllMeta() {
      var self = this;
      this.getMeta().then(function () {
        self.localValue = __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign___default()({}, self.localValue, self.meta);
        self.localValue.data.map(function (meta) {
          self.$set(meta, 'edit', false);
        });
        window.bus.$emit('incrementLoadbar', self.modulesToLoad);
      });
    }
  }),
  computed: __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_2_vuex__["c" /* mapGetters */])('devise', ['meta']), {
    isInvalid: function isInvalid() {
      return this.newMeta.attribute_name === null || this.newMeta.attribute_value === null || this.newMeta.content === null;
    },
    anyNewMetaPopulated: function anyNewMetaPopulated() {
      return this.newMeta.attribute_name !== null || this.newMeta.attribute_value !== null || this.newMeta.content !== null;
    }
  })
});

/***/ }),

/***/ 559:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "dvs-flex dvs-items-stretch dvs-min-h-screen dvs-relative" },
    [
      _c("div", { attrs: { id: "devise-sidebar" } }, [
        _c("h2", { staticClass: "dvs-font-bold dvs-mb-2" }, [
          _vm._v("Manage Global Meta")
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
                _vm.goToPage("devise-settings-index")
              }
            }
          },
          [_vm._v("Back to Settings")]
        )
      ]),
      _vm._v(" "),
      _c(
        "div",
        { attrs: { id: "devise-admin-content" } },
        [
          _c("h3", { staticClass: "dvs-mb-8" }, [_vm._v("Add Meta")]),
          _vm._v(" "),
          _c("help", { staticClass: "dvs-mb-8" }, [
            _vm._v(
              "Global Meta are the meta tags that will be attached to every page of this site. They can be overridden on a page level but this gives you to the opportunity to set the "
            ),
            _c("span", { staticClass: "dvs-fonts-mono" }, [_vm._v("<meta>")]),
            _vm._v(" across "),
            _c("strong", [_vm._v("all")]),
            _vm._v(" pages.")
          ]),
          _vm._v(" "),
          _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
            _c("label", [_vm._v("Attribute Name")]),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.newMeta.attribute_name,
                  expression: "newMeta.attribute_name"
                }
              ],
              attrs: { type: "text" },
              domProps: { value: _vm.newMeta.attribute_name },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.$set(_vm.newMeta, "attribute_name", $event.target.value)
                }
              }
            })
          ]),
          _vm._v(" "),
          _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
            _c("label", [_vm._v("Attribute Value")]),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.newMeta.attribute_value,
                  expression: "newMeta.attribute_value"
                }
              ],
              attrs: { type: "text" },
              domProps: { value: _vm.newMeta.attribute_value },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.$set(_vm.newMeta, "attribute_value", $event.target.value)
                }
              }
            })
          ]),
          _vm._v(" "),
          _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
            _c("label", [_vm._v("Content")]),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.newMeta.content,
                  expression: "newMeta.content"
                }
              ],
              attrs: { type: "text" },
              domProps: { value: _vm.newMeta.content },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.$set(_vm.newMeta, "content", $event.target.value)
                }
              }
            })
          ]),
          _vm._v(" "),
          _vm.anyNewMetaPopulated
            ? _c("help", { staticClass: "dvs-mb-4" }, [
                _vm._v(
                  "\n      <meta " +
                    _vm._s(_vm.newMeta.attribute_name) +
                    '="' +
                    _vm._s(_vm.newMeta.attribute_value) +
                    '" content="' +
                    _vm._s(_vm.newMeta.content) +
                    '">\n    '
                )
              ])
            : _vm._e(),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "dvs-btn dvs-mb-8",
              attrs: { disabled: _vm.isInvalid },
              on: { click: _vm.requestCreateMeta }
            },
            [_vm._v("Save New Meta")]
          ),
          _vm._v(" "),
          _c("h3", { staticClass: "dvs-mb-8" }, [
            _vm._v("Existing Global Meta")
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "dvs-mb-12 dvs-flex dvs-flex-col" },
            _vm._l(_vm.localValue.data, function(meta, key) {
              return _c(
                "div",
                {
                  staticClass:
                    "dvs-flex dvs-justify-between dvs-items-center dvs-mb-2"
                },
                [
                  _c(
                    "div",
                    { staticClass: "dvs-font-mono dvs-pr-8" },
                    [
                      !meta.edit
                        ? [
                            _vm._v(
                              "\n            <meta " +
                                _vm._s(meta.attribute_name) +
                                '="' +
                                _vm._s(meta.attribute_value) +
                                '" content="' +
                                _vm._s(meta.content) +
                                '">\n          '
                            )
                          ]
                        : [
                            _c("fieldset", { staticClass: "dvs-fieldset" }, [
                              _c(
                                "div",
                                { staticClass: "dvs-flex dvs-items-center" },
                                [
                                  _vm._v(
                                    "\n                <meta\n                "
                                  ),
                                  _c("input", {
                                    directives: [
                                      {
                                        name: "show",
                                        rawName: "v-show",
                                        value: meta.edit,
                                        expression: "meta.edit"
                                      },
                                      {
                                        name: "model",
                                        rawName: "v-model",
                                        value:
                                          _vm.localValue.data[key]
                                            .attribute_name,
                                        expression:
                                          "localValue.data[key].attribute_name"
                                      }
                                    ],
                                    staticClass: "dvs-ml-4",
                                    attrs: { type: "text" },
                                    domProps: {
                                      value:
                                        _vm.localValue.data[key].attribute_name
                                    },
                                    on: {
                                      input: function($event) {
                                        if ($event.target.composing) {
                                          return
                                        }
                                        _vm.$set(
                                          _vm.localValue.data[key],
                                          "attribute_name",
                                          $event.target.value
                                        )
                                      }
                                    }
                                  }),
                                  _vm._v('="\n                '),
                                  _c("input", {
                                    directives: [
                                      {
                                        name: "show",
                                        rawName: "v-show",
                                        value: meta.edit,
                                        expression: "meta.edit"
                                      },
                                      {
                                        name: "model",
                                        rawName: "v-model",
                                        value:
                                          _vm.localValue.data[key]
                                            .attribute_value,
                                        expression:
                                          "localValue.data[key].attribute_value"
                                      }
                                    ],
                                    attrs: { type: "text" },
                                    domProps: {
                                      value:
                                        _vm.localValue.data[key].attribute_value
                                    },
                                    on: {
                                      input: function($event) {
                                        if ($event.target.composing) {
                                          return
                                        }
                                        _vm.$set(
                                          _vm.localValue.data[key],
                                          "attribute_value",
                                          $event.target.value
                                        )
                                      }
                                    }
                                  }),
                                  _vm._v('"\n                '),
                                  _c("span", { staticClass: "dvs-ml-4" }, [
                                    _vm._v(' content="')
                                  ]),
                                  _vm._v(" "),
                                  _c("input", {
                                    directives: [
                                      {
                                        name: "show",
                                        rawName: "v-show",
                                        value: meta.edit,
                                        expression: "meta.edit"
                                      },
                                      {
                                        name: "model",
                                        rawName: "v-model",
                                        value: _vm.localValue.data[key].content,
                                        expression:
                                          "localValue.data[key].content"
                                      }
                                    ],
                                    attrs: { type: "text" },
                                    domProps: {
                                      value: _vm.localValue.data[key].content
                                    },
                                    on: {
                                      input: function($event) {
                                        if ($event.target.composing) {
                                          return
                                        }
                                        _vm.$set(
                                          _vm.localValue.data[key],
                                          "content",
                                          $event.target.value
                                        )
                                      }
                                    }
                                  }),
                                  _vm._v('">\n              ')
                                ]
                              )
                            ])
                          ]
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
                      !meta.edit
                        ? _c(
                            "button",
                            {
                              staticClass:
                                "dvs-btn dvs-btn-plain dvs-btn-xs dvs-ml-4",
                              on: {
                                click: function($event) {
                                  meta.edit = !meta.edit
                                }
                              }
                            },
                            [_c("i", { staticClass: "ion-edit" })]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      !meta.edit
                        ? _c(
                            "button",
                            {
                              directives: [
                                {
                                  name: "devise-alert-confirm",
                                  rawName: "v-devise-alert-confirm",
                                  value: {
                                    callback: _vm.requestDeleteMeta,
                                    arguments: meta,
                                    message:
                                      "Are you sure you want to delete this meta?"
                                  },
                                  expression:
                                    "{callback: requestDeleteMeta, arguments:meta, message: 'Are you sure you want to delete this meta?'}"
                                }
                              ],
                              staticClass:
                                "dvs-btn dvs-btn-plain dvs-btn-xs dvs-ml-4"
                            },
                            [_c("i", { staticClass: "ion-trash-b" })]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      meta.edit
                        ? _c(
                            "button",
                            {
                              staticClass: "dvs-btn dvs-mr-2",
                              on: {
                                click: function($event) {
                                  _vm.requestUpdateMeta(
                                    _vm.localValue.data[key]
                                  )
                                }
                              }
                            },
                            [_vm._v("Save")]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      meta.edit
                        ? _c(
                            "button",
                            {
                              staticClass: "dvs-btn dvs-btn-plain",
                              on: {
                                click: function($event) {
                                  meta.edit = false
                                }
                              }
                            },
                            [_vm._v("Cancel")]
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
    ]
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-287c0922", module.exports)
  }
}

/***/ })

});