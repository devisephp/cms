webpackJsonp([10],{

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

/***/ 686:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(895)
/* template */
var __vue_template__ = __webpack_require__(896)
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

/***/ 706:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(707)
/* template */
var __vue_template__ = __webpack_require__(708)
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
Component.options.__file = "node_modules/vue-ionicons/dist/md-trash.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-dc27ad08", Component.options)
  } else {
    hotAPI.reload("data-v-dc27ad08", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 707:
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
  name: "md-trash-icon",
  mixins: [__WEBPACK_IMPORTED_MODULE_0__ionicons_mixin__["a" /* default */]],
  data: function data() {
    var iconTitle = this.title ? this.title : "Md Trash Icon";
    return {
      iconTitle: iconTitle
    };
  }
});

/***/ }),

/***/ 708:
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
      attrs: { title: _vm.iconTitle, name: "md-trash-icon" }
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
                "M128 405.429C128 428.846 147.198 448 170.667 448h170.667C364.802 448 384 428.846 384 405.429V160H128v245.429zM416 96h-80l-26.785-32H202.786L176 96H96v32h320V96z"
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
    require("vue-hot-reload-api")      .rerender("data-v-dc27ad08", module.exports)
  }
}

/***/ }),

/***/ 743:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(744)
/* template */
var __vue_template__ = __webpack_require__(745)
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
Component.options.__file = "src/components/meta/MetaForm.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-30de93f3", Component.options)
  } else {
    hotAPI.reload("data-v-30de93f3", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 744:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign__ = __webpack_require__(17);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_ionicons_dist_md_trash_vue__ = __webpack_require__(706);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_ionicons_dist_md_trash_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_vue_ionicons_dist_md_trash_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_vue_ionicons_dist_md_create_vue__ = __webpack_require__(646);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_vue_ionicons_dist_md_create_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_vue_ionicons_dist_md_create_vue__);

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: 'MetaForm',
  data: function data() {
    return {
      newMeta: {
        site_id: 0,
        attribute_name: null,
        attribute_value: null,
        content: null
      }
    };
  },
  mounted: function mounted() {
    this.newMeta.site_id = deviseSettings.$page.site_id;
  },

  methods: {
    requestCreateMeta: function requestCreateMeta() {
      this.$emit('request-create-meta', this.newMeta);
      this.newMeta = __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign___default()({}, this.newMeta);
    },
    requestUpdateMeta: function requestUpdateMeta(meta) {
      this.$emit('request-update-meta', meta);
    },
    requestDeleteMeta: function requestDeleteMeta(meta) {
      this.$emit('request-delete-meta', meta);
    },
    setEditMode: function setEditMode(meta) {
      if (typeof meta.edit === 'undefined') {
        this.$set(meta, 'edit', true);
      } else {
        meta.edit = !meta.edit;
      }
    }
  },
  computed: {
    isInvalid: function isInvalid() {
      return this.newMeta.attribute_name === null || this.newMeta.attribute_value === null || this.newMeta.content === null;
    },
    anyNewMetaPopulated: function anyNewMetaPopulated() {
      return this.newMeta.attribute_name !== null || this.newMeta.attribute_value !== null || this.newMeta.content !== null;
    }
  },
  props: {
    value: {},
    globalForm: {
      type: Boolean,
      default: true
    }
  },
  components: {
    TrashIcon: __WEBPACK_IMPORTED_MODULE_1_vue_ionicons_dist_md_trash_vue___default.a,
    EditIcon: __WEBPACK_IMPORTED_MODULE_2_vue_ionicons_dist_md_create_vue___default.a
  }
});

/***/ }),

/***/ 745:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
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
              "\n    <meta " +
                _vm._s(_vm.newMeta.attribute_name) +
                '="' +
                _vm._s(_vm.newMeta.attribute_value) +
                '" content="' +
                _vm._s(_vm.newMeta.content) +
                '">\n  '
            )
          ])
        : _vm._e(),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "dvs-btn dvs-mb-11",
          style: _vm.theme.actionButton,
          attrs: { disabled: _vm.isInvalid },
          on: { click: _vm.requestCreateMeta }
        },
        [_vm._v("Add New Meta")]
      ),
      _vm._v(" "),
      _vm.globalForm
        ? _c(
            "h3",
            {
              staticClass: "dvs-mb-8 dvs-pr-16",
              style: { color: _vm.theme.panel.color }
            },
            [_vm._v("Existing Global Meta")]
          )
        : _vm._e(),
      _vm._v(" "),
      _vm.value.length == 0
        ? _c("help", { staticClass: "dvs-mb-8" }, [
            _vm._v("You currently do not have any meta tags at this time.")
          ])
        : _vm._e(),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "dvs-mb-8 dvs-flex dvs-flex-col" },
        _vm._l(_vm.value, function(meta, key) {
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
                { staticClass: "dvs-font-mono dvs-pr-8" },
                [
                  !meta.edit
                    ? [
                        _vm._v(
                          "\n          <meta " +
                            _vm._s(meta.attribute_name) +
                            '="' +
                            _vm._s(meta.attribute_value) +
                            '" content="' +
                            _vm._s(meta.content) +
                            '">\n        '
                        )
                      ]
                    : [
                        _c("fieldset", { staticClass: "dvs-fieldset" }, [
                          _c(
                            "div",
                            { staticClass: "dvs-flex dvs-items-center" },
                            [
                              _vm._v("\n              <meta\n              "),
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
                                    value: _vm.value[key].attribute_name,
                                    expression: "value[key].attribute_name"
                                  }
                                ],
                                staticClass: "dvs-ml-4",
                                attrs: { type: "text" },
                                domProps: {
                                  value: _vm.value[key].attribute_name
                                },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      _vm.value[key],
                                      "attribute_name",
                                      $event.target.value
                                    )
                                  }
                                }
                              }),
                              _vm._v('="\n              '),
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
                                    value: _vm.value[key].attribute_value,
                                    expression: "value[key].attribute_value"
                                  }
                                ],
                                attrs: { type: "text" },
                                domProps: {
                                  value: _vm.value[key].attribute_value
                                },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      _vm.value[key],
                                      "attribute_value",
                                      $event.target.value
                                    )
                                  }
                                }
                              }),
                              _vm._v('"\n              '),
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
                                    value: _vm.value[key].content,
                                    expression: "value[key].content"
                                  }
                                ],
                                attrs: { type: "text" },
                                domProps: { value: _vm.value[key].content },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      _vm.value[key],
                                      "content",
                                      $event.target.value
                                    )
                                  }
                                }
                              }),
                              _vm._v('">\n            ')
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
                  staticClass: "dvs-flex dvs-justify-between dvs-items-center"
                },
                [
                  !meta.edit
                    ? _c("div", [
                        _c(
                          "button",
                          {
                            staticClass: "dvs-btn dvs-btn-xs dvs-ml-4",
                            style: _vm.theme.actionButtonGhost,
                            on: {
                              click: function($event) {
                                _vm.setEditMode(meta)
                              }
                            }
                          },
                          [_c("edit-icon", { attrs: { w: "20", h: "20" } })],
                          1
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
                                  callback: _vm.requestDeleteMeta,
                                  arguments: meta,
                                  message:
                                    "Are you sure you want to delete this meta?"
                                },
                                expression:
                                  "{callback: requestDeleteMeta, arguments:meta, message: 'Are you sure you want to delete this meta?'}"
                              }
                            ],
                            staticClass: "dvs-btn dvs-btn-xs dvs-ml-4",
                            style: _vm.theme.actionButtonGhost
                          },
                          [_c("trash-icon", { attrs: { w: "20", h: "20" } })],
                          1
                        )
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  meta.edit
                    ? _c(
                        "button",
                        {
                          staticClass: "dvs-btn dvs-mr-2",
                          style: _vm.theme.actionButton,
                          on: {
                            click: function($event) {
                              _vm.requestUpdateMeta(_vm.value[key])
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
                          staticClass: "dvs-btn",
                          on: {
                            click: function($event) {
                              _vm.setEditMode(meta)
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
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-30de93f3", module.exports)
  }
}

/***/ }),

/***/ 895:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign__ = __webpack_require__(17);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends__ = __webpack_require__(6);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_vuex__ = __webpack_require__(5);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__MetaForm__ = __webpack_require__(743);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__MetaForm___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__MetaForm__);


//
//
//
//
//
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
      modulesToLoad: 1
    };
  },
  mounted: function mounted() {
    this.retrieveAllMeta();
  },

  methods: __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_2_vuex__["b" /* mapActions */])('devise', ['getMeta', 'createMeta', 'updateMeta', 'deleteMeta']), {
    requestCreateMeta: function requestCreateMeta(newMeta) {
      this.createMeta(newMeta);
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
        devise.$bus.$emit('incrementLoadbar', self.modulesToLoad);
      });
    }
  }),
  computed: __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_2_vuex__["c" /* mapGetters */])('devise', ['meta'])),
  components: {
    MetaForm: __WEBPACK_IMPORTED_MODULE_3__MetaForm___default.a
  }
});

/***/ }),

/***/ 896:
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
        _c(
          "h3",
          { staticClass: "dvs-mb-8", style: { color: _vm.theme.panel.color } },
          [_vm._v("Add Global Meta")]
        ),
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
        _c("meta-form", {
          on: {
            "request-create-meta": _vm.requestCreateMeta,
            "request-update-meta": _vm.requestUpdateMeta,
            "request-delete-meta": _vm.requestDeleteMeta
          },
          model: {
            value: _vm.localValue.data,
            callback: function($$v) {
              _vm.$set(_vm.localValue, "data", $$v)
            },
            expression: "localValue.data"
          }
        })
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
    require("vue-hot-reload-api")      .rerender("data-v-287c0922", module.exports)
  }
}

/***/ })

});