webpackJsonp([7],{

/***/ 648:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(719)
/* template */
var __vue_template__ = __webpack_require__(720)
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
Component.options.__file = "src/components/utilities/Loadbar.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-af9cf930", Component.options)
  } else {
    hotAPI.reload("data-v-af9cf930", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 655:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(755)
/* template */
var __vue_template__ = __webpack_require__(756)
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
Component.options.__file = "src/components/media-manager/MediaEditor.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1cea76b4", Component.options)
  } else {
    hotAPI.reload("data-v-1cea76b4", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 658:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(757)
/* template */
var __vue_template__ = __webpack_require__(775)
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
Component.options.__file = "src/components/media-manager/MediaManager.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7ff398c4", Component.options)
  } else {
    hotAPI.reload("data-v-7ff398c4", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 697:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(698)
/* template */
var __vue_template__ = __webpack_require__(699)
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

/***/ 698:
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

/***/ 699:
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

/***/ 719:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
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
  data: function data() {
    return {
      loadbarPercentage: 0,
      modulesLoaded: 0
    };
  },
  mounted: function mounted() {
    // The loadbar works in two ways - listening for incrementations or by
    // passing through a prop. If you pass through a prop it's up to the parent
    // to update the percentage and get to 100%
    if (this.percentage > 0) {
      this.loadbarPercentage = this.percentage;
    } else {
      this.addListeners();
    }
  },

  methods: {
    addListeners: function addListeners() {
      deviseSettings.$bus.$on("incrementLoadbar", this.incrementLoadbar);
    },
    incrementLoadbar: function incrementLoadbar(numberOfModulesToLoad) {
      this.modulesLoaded++;
      this.loadbarPercentage = this.modulesLoaded / numberOfModulesToLoad;
      this.checkIfLoaded();
    },
    checkIfLoaded: function checkIfLoaded() {
      var self = this;
      if (this.loadbarPercentage >= 1) {
        this.showLoadbar = false;
        setTimeout(function () {
          self.loadbarPercentage = 0;
          self.modulesLoaded = 0;
        }, 1000);
      }
    }
  },
  watch: {
    percentage: function percentage(newValue) {
      this.loadbarPercentage = newValue;
    }
  },
  props: {
    percentage: {
      type: Number,
      default: -1
    }
  }
});

/***/ }),

/***/ 720:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("transition", { attrs: { name: "dvs-fade" } }, [
        _c(
          "div",
          {
            directives: [
              {
                name: "show",
                rawName: "v-show",
                value: _vm.loadbarPercentage > 0 && _vm.loadbarPercentage < 1,
                expression: "loadbarPercentage > 0 && loadbarPercentage < 1"
              }
            ],
            staticClass: "dvs-fixed dvs-pin dvs-z-50"
          },
          [
            _c("div", { staticClass: "dvs-blocker" }),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass:
                  "dvs-text-center dvs-w-1/4 dvs-px-4 dvs-py-8 dvs-bg-white dvs-rounded dvs-flex dvs-flex-col dvs-items-center dvs-absolute dvs-absolute-center dvs-z-50"
              },
              [
                _c(
                  "h6",
                  {
                    staticClass:
                      "dvs-mb-2 dvs-text-action dvs-uppercase dvs-text-xs"
                  },
                  [_vm._v("Just a moment")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "dvs-loadbar" }, [
                  _c("div", {
                    staticClass: "dvs-bar dvs-background",
                    style: { width: _vm.loadbarPercentage * 100 + "%" }
                  })
                ])
              ]
            )
          ]
        )
      ])
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
    require("vue-hot-reload-api")      .rerender("data-v-af9cf930", module.exports)
  }
}

/***/ }),

/***/ 755:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_keys__ = __webpack_require__(58);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_keys___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_keys__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_core_js_object_assign__ = __webpack_require__(17);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_core_js_object_assign___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_babel_runtime_core_js_object_assign__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_vue_color__ = __webpack_require__(306);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_vue_color___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_vue_color__);


//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

var tinycolor = __webpack_require__(121);


/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      imagesLoaded: 0,
      edits: {
        q: 90,
        or: null,
        flip: null,
        fit: 'crop',
        bri: null,
        con: null,
        gam: null,
        sharp: 5,
        pixel: null,
        filt: null,
        bg: null
      },
      customSize: {
        w: null,
        h: null
      },
      originalDims: {
        w: null,
        h: null
      }
    };
  },
  mounted: function mounted() {
    this.imagesLoaded = 0;
    this.loadOriginalDimentions();
  },

  methods: {
    done: function done() {
      var edits = __WEBPACK_IMPORTED_MODULE_1_babel_runtime_core_js_object_assign___default()({}, this.edits);
      var cleanEdits = this.clean(edits);
      this.$emit('done', cleanEdits);
    },
    cancel: function cancel() {
      this.$emit('cancel');
    },
    loadOriginalDimentions: function loadOriginalDimentions() {
      var file = '/styled/preview/' + this.source;
      var self = this;
      var img = new Image();

      img.onload = function () {
        self.originalDims.w = this.width;
        self.originalDims.h = this.height;

        self.setCustomSizeToOriginal();
      };

      img.onerror = function () {
        alert('not a valid file: ' + file.type);
      };

      img.src = file;
    },
    addToImagesLoaded: function addToImagesLoaded(something) {
      this.imagesLoaded++;
    },
    setCustomSizeToOriginal: function setCustomSizeToOriginal() {
      this.customSize.w = this.originalDims.w;
      this.customSize.h = this.originalDims.h;
    },
    encodedSize: function encodedSize(size) {
      var encodedString = '';
      if (this.encodedEdits.length > 0) {
        encodedString += '&';
      }

      return encodedString + 'w=' + size.w + '&h=' + size.h;
    },
    clean: function clean(obj) {
      for (var propName in obj) {
        if (obj[propName] === null || obj[propName] === undefined) {
          delete obj[propName];
        } else if (propName === 'bg') {
          obj[propName] = obj[propName].substring(1);
        }
      }

      if (this.customSize.w && this.customSize.h) {
        obj.w = this.customSize.w;
        obj.h = this.customSize.h;
      }

      return obj;
    }
  },
  computed: {
    editorColor: {
      get: function get() {
        if (this.edits.bg === null) {
          return '#ffffff';
        }
        return tinycolor(this.edits.bg).toRgb();
      },
      set: function set(newValue) {
        this.edits.bg = newValue.hex;
      }
    },
    encodedEdits: function encodedEdits() {
      var encodedString = '';

      for (var property in this.edits) {
        if (this.edits[property] !== null) {
          if (encodedString !== '') {
            encodedString += '&';
          }

          var propertyValue = this.edits[property];

          // Chop off the hash for Glide
          if (property === 'bg') {
            propertyValue = propertyValue.substring(1);
          }

          encodedString += property + '=' + propertyValue;
        }
      }

      return encodedString;
    },
    allImagesLoaded: function allImagesLoaded() {
      var numberOfImages = this.imagesRequiredToLoad;
      if (this.imagesLoaded >= numberOfImages) {
        return true;
      }
      return false;
    },
    imagesRequiredToLoad: function imagesRequiredToLoad() {
      if (this.sizes) {
        return __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_keys___default()(this.sizes).length + 1;
      }

      return 1;
    }
  },
  props: {
    source: {
      type: String,
      required: true
    },
    sizes: {
      type: Object,
      required: false
    }
  },
  components: {
    'sketch-picker': __WEBPACK_IMPORTED_MODULE_2_vue_color__["Sketch"]
  }
});

/***/ }),

/***/ 756:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "media-manager-interface" }, [
    _c(
      "div",
      {
        staticClass:
          "dvs-py-4 dvs-px-8 dvs-rounded-tl dvs-rounded-tr dvs-flex dvs-justify-between dvs-items-center dvs-bg-grey-lighter dvs-border-b dvs-border-lighter dvs-relative"
      },
      [
        _vm._v("Media Editor\n    "),
        _c("div", [
          _c(
            "button",
            {
              staticClass: "dvs-btn",
              style: _vm.theme.actionButton,
              attrs: { disabled: !_vm.allImagesLoaded },
              on: { click: _vm.done }
            },
            [_vm._v("Done")]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "dvs-btn",
              style: _vm.theme.actionButtonGhost,
              on: { click: _vm.cancel }
            },
            [_vm._v("Cancel")]
          )
        ])
      ]
    ),
    _vm._v(" "),
    _c("div", { staticClass: "dvs-flex dvs-items-stretch dvs-h-full" }, [
      _c(
        "div",
        {
          staticClass:
            "dvs-min-w-1/3 dvs-border-r dvs-border-lighter dvs-bg-grey-light",
          attrs: { "data-simplebar": "" }
        },
        [
          _c(
            "div",
            {
              staticClass:
                "dvs-h-full dvs-p-8 dvs-flex dvs-flex-col dvs-justify-between"
            },
            [
              _c("h3", { staticClass: "dvs-mb-4" }, [_vm._v("Image Edits")]),
              _vm._v(" "),
              _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                _c("label", [_vm._v("Crop / Fitting")]),
                _vm._v(" "),
                _c(
                  "select",
                  {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.edits.fit,
                        expression: "edits.fit"
                      }
                    ],
                    on: {
                      change: function($event) {
                        var $$selectedVal = Array.prototype.filter
                          .call($event.target.options, function(o) {
                            return o.selected
                          })
                          .map(function(o) {
                            var val = "_value" in o ? o._value : o.value
                            return val
                          })
                        _vm.$set(
                          _vm.edits,
                          "fit",
                          $event.target.multiple
                            ? $$selectedVal
                            : $$selectedVal[0]
                        )
                      }
                    }
                  },
                  [
                    _c("option", { attrs: { label: null } }, [_vm._v("None")]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "crop" } }, [
                      _vm._v("Contain")
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "max" } }, [
                      _vm._v("Best Fit")
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "fill" } }, [
                      _vm._v("Fill")
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "stretch" } }, [
                      _vm._v("Stretch")
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "crop" } }, [
                      _vm._v("Crop Center")
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "crop-left" } }, [
                      _vm._v("Crop Center Left")
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "crop-right" } }, [
                      _vm._v("Crop Center Right")
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "crop-top" } }, [
                      _vm._v("Crop Top")
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "crop-top-left" } }, [
                      _vm._v("Crop Top Left")
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "crop-top-right" } }, [
                      _vm._v("Crop Top Right")
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "crop-bottom" } }, [
                      _vm._v("Crop Bottom")
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "crop-bottom-left" } }, [
                      _vm._v("Crop Bottom Left")
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "crop-bottom-right" } }, [
                      _vm._v("Crop Bottom Right")
                    ])
                  ]
                )
              ]),
              _vm._v(" "),
              _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                _c("label", [_vm._v("Quality")]),
                _vm._v(" "),
                _c("div", { staticClass: "dvs-flex" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.edits.q,
                        expression: "edits.q"
                      }
                    ],
                    attrs: { type: "range", min: "0", max: "100", step: "5" },
                    domProps: { value: _vm.edits.q },
                    on: {
                      dblclick: function($event) {
                        _vm.edits.q = null
                      },
                      __r: function($event) {
                        _vm.$set(_vm.edits, "q", $event.target.value)
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "dvs-font-bold dvs-text-xs dvs-pl-2" },
                    [_vm._v(_vm._s(_vm.edits.q))]
                  )
                ])
              ]),
              _vm._v(" "),
              _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                _c("label", [_vm._v("Sharpen")]),
                _vm._v(" "),
                _c("div", { staticClass: "dvs-flex" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.edits.sharp,
                        expression: "edits.sharp"
                      }
                    ],
                    attrs: { type: "range", min: "0", max: "100", step: "1" },
                    domProps: { value: _vm.edits.sharp },
                    on: {
                      dblclick: function($event) {
                        _vm.edits.sharp = null
                      },
                      __r: function($event) {
                        _vm.$set(_vm.edits, "sharp", $event.target.value)
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "dvs-font-bold dvs-text-xs dvs-pl-2" },
                    [_vm._v(_vm._s(_vm.edits.sharp))]
                  )
                ])
              ]),
              _vm._v(" "),
              _vm.edits.fit === "fill"
                ? _c(
                    "fieldset",
                    { staticClass: "dvs-fieldset dvs-mb-4" },
                    [
                      _c("label", [_vm._v("Background Color")]),
                      _vm._v(" "),
                      _c("sketch-picker", {
                        on: {
                          cancel: function($event) {
                            _vm.edits.bg = null
                          }
                        },
                        model: {
                          value: _vm.editorColor,
                          callback: function($$v) {
                            _vm.editorColor = $$v
                          },
                          expression: "editorColor"
                        }
                      })
                    ],
                    1
                  )
                : _vm._e(),
              _vm._v(" "),
              _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                _c("label", [_vm._v("Rotation")]),
                _vm._v(" "),
                _c(
                  "select",
                  {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.edits.or,
                        expression: "edits.or"
                      }
                    ],
                    on: {
                      change: function($event) {
                        var $$selectedVal = Array.prototype.filter
                          .call($event.target.options, function(o) {
                            return o.selected
                          })
                          .map(function(o) {
                            var val = "_value" in o ? o._value : o.value
                            return val
                          })
                        _vm.$set(
                          _vm.edits,
                          "or",
                          $event.target.multiple
                            ? $$selectedVal
                            : $$selectedVal[0]
                        )
                      }
                    }
                  },
                  [
                    _c("option", { domProps: { value: null } }, [
                      _vm._v("No Rotation")
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "90" } }, [
                      _vm._v("90° Counter Clockwise")
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "180" } }, [_vm._v("180°")]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "270" } }, [
                      _vm._v("270° Counter Clockwise")
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "auto" } }, [
                      _vm._v("Auto (Reads EXIF Data)")
                    ])
                  ]
                )
              ]),
              _vm._v(" "),
              _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                _c("label", [_vm._v("Flip")]),
                _vm._v(" "),
                _c(
                  "select",
                  {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.edits.flip,
                        expression: "edits.flip"
                      }
                    ],
                    on: {
                      change: function($event) {
                        var $$selectedVal = Array.prototype.filter
                          .call($event.target.options, function(o) {
                            return o.selected
                          })
                          .map(function(o) {
                            var val = "_value" in o ? o._value : o.value
                            return val
                          })
                        _vm.$set(
                          _vm.edits,
                          "flip",
                          $event.target.multiple
                            ? $$selectedVal
                            : $$selectedVal[0]
                        )
                      }
                    }
                  },
                  [
                    _c("option", { domProps: { value: null } }, [
                      _vm._v("No Flip")
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "v" } }, [
                      _vm._v("Vertical")
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "h" } }, [
                      _vm._v("Horizontal")
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "both" } }, [
                      _vm._v("Vertical & Horizontal")
                    ])
                  ]
                )
              ]),
              _vm._v(" "),
              _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                _c("label", [_vm._v("Effects")]),
                _vm._v(" "),
                _c(
                  "select",
                  {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.edits.filt,
                        expression: "edits.filt"
                      }
                    ],
                    on: {
                      change: function($event) {
                        var $$selectedVal = Array.prototype.filter
                          .call($event.target.options, function(o) {
                            return o.selected
                          })
                          .map(function(o) {
                            var val = "_value" in o ? o._value : o.value
                            return val
                          })
                        _vm.$set(
                          _vm.edits,
                          "filt",
                          $event.target.multiple
                            ? $$selectedVal
                            : $$selectedVal[0]
                        )
                      }
                    }
                  },
                  [
                    _c("option", { domProps: { value: null } }, [
                      _vm._v("No Effect")
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "greyscale" } }, [
                      _vm._v("Greyscale")
                    ]),
                    _vm._v(" "),
                    _c("option", { attrs: { value: "sepia" } }, [
                      _vm._v("Sepia")
                    ])
                  ]
                )
              ]),
              _vm._v(" "),
              _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                _c("label", [_vm._v("Brightness")]),
                _vm._v(" "),
                _c("div", { staticClass: "dvs-flex" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.edits.bri,
                        expression: "edits.bri"
                      }
                    ],
                    attrs: {
                      type: "range",
                      min: "-100",
                      max: "100",
                      step: "1"
                    },
                    domProps: { value: _vm.edits.bri },
                    on: {
                      dblclick: function($event) {
                        _vm.edits.bri = null
                      },
                      __r: function($event) {
                        _vm.$set(_vm.edits, "bri", $event.target.value)
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "dvs-font-bold dvs-text-xs dvs-pl-2" },
                    [_vm._v(_vm._s(_vm.edits.bri))]
                  )
                ])
              ]),
              _vm._v(" "),
              _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                _c("label", [_vm._v("Contrast")]),
                _vm._v(" "),
                _c("div", { staticClass: "dvs-flex" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.edits.con,
                        expression: "edits.con"
                      }
                    ],
                    attrs: {
                      type: "range",
                      min: "-100",
                      max: "100",
                      step: "1"
                    },
                    domProps: { value: _vm.edits.con },
                    on: {
                      dblclick: function($event) {
                        _vm.edits.con = null
                      },
                      __r: function($event) {
                        _vm.$set(_vm.edits, "con", $event.target.value)
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "dvs-font-bold dvs-text-xs dvs-pl-2" },
                    [_vm._v(_vm._s(_vm.edits.con))]
                  )
                ])
              ]),
              _vm._v(" "),
              _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                _c("label", [_vm._v("Gamma")]),
                _vm._v(" "),
                _c("div", { staticClass: "dvs-flex" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.edits.gam,
                        expression: "edits.gam"
                      }
                    ],
                    attrs: {
                      type: "range",
                      min: "0.1",
                      max: "9.99",
                      step: "0.01"
                    },
                    domProps: { value: _vm.edits.gam },
                    on: {
                      dblclick: function($event) {
                        _vm.edits.gam = null
                      },
                      __r: function($event) {
                        _vm.$set(_vm.edits, "gam", $event.target.value)
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "dvs-font-bold dvs-text-xs dvs-pl-2" },
                    [_vm._v(_vm._s(_vm.edits.gam))]
                  )
                ])
              ]),
              _vm._v(" "),
              _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
                _c("label", [_vm._v("Pixelate")]),
                _vm._v(" "),
                _c("div", { staticClass: "dvs-flex" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.edits.pixel,
                        expression: "edits.pixel"
                      }
                    ],
                    attrs: { type: "range", min: "0", max: "20", step: "1" },
                    domProps: { value: _vm.edits.pixel },
                    on: {
                      dblclick: function($event) {
                        _vm.edits.pixel = null
                      },
                      __r: function($event) {
                        _vm.$set(_vm.edits, "pixel", $event.target.value)
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "dvs-font-bold dvs-text-xs dvs-pl-2" },
                    [_vm._v(_vm._s(_vm.edits.pixel))]
                  )
                ])
              ])
            ]
          )
        ]
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "dvs-flex-grow dvs-relative dvs-overflow-y-scroll" },
        [
          _c(
            "div",
            { staticClass: "dvs-p-8 dvs-border-l dvs-border-grey-lighter" },
            [
              _vm.sizes
                ? [
                    _c("h3", { staticClass: "dvs-mb-4" }, [_vm._v("Images")]),
                    _vm._v(" "),
                    _c("h6", { staticClass: "dvs-mb-4" }, [
                      _vm._v("Original Image")
                    ]),
                    _vm._v(" "),
                    _c("img", {
                      attrs: { src: "/styled/preview/" + _vm.source },
                      on: { load: _vm.addToImagesLoaded }
                    }),
                    _vm._v(" "),
                    _c("hr", { staticClass: "my-4" }),
                    _vm._v(" "),
                    _vm._l(_vm.sizes, function(size, key) {
                      return _c("div", { key: key, staticClass: "mb-8" }, [
                        _c("h6", { staticClass: "dvs-mb-4" }, [
                          _vm._v(
                            _vm._s(key) +
                              " (" +
                              _vm._s(size.w) +
                              "x" +
                              _vm._s(size.h) +
                              ")"
                          )
                        ]),
                        _vm._v(" "),
                        _c("img", {
                          attrs: {
                            src:
                              "/styled/preview/" +
                              _vm.source +
                              "?" +
                              _vm.encodedEdits +
                              _vm.encodedSize(size)
                          },
                          on: { load: _vm.addToImagesLoaded }
                        })
                      ])
                    })
                  ]
                : [
                    _c("h3", { staticClass: "dvs-mb-4" }, [_vm._v("Image")]),
                    _vm._v(" "),
                    !_vm.customSize.w || !_vm.customSize.h
                      ? _c("help", { staticClass: "dvs-mb-4" }, [
                          _vm._v(
                            "Please provide a width and height for this image"
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "dvs-flex dvs-mb-8 dvs-items-center" },
                      [
                        _c(
                          "fieldset",
                          { staticClass: "dvs-fieldset dvs-mr-4" },
                          [
                            _c("label", [_vm._v("Width")]),
                            _vm._v(" "),
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.customSize.w,
                                  expression: "customSize.w"
                                }
                              ],
                              attrs: { type: "number" },
                              domProps: { value: _vm.customSize.w },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    _vm.customSize,
                                    "w",
                                    $event.target.value
                                  )
                                }
                              }
                            })
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "fieldset",
                          { staticClass: "dvs-fieldset dvs-mr-4" },
                          [
                            _c("label", [_vm._v("Height")]),
                            _vm._v(" "),
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.customSize.h,
                                  expression: "customSize.h"
                                }
                              ],
                              attrs: { type: "number" },
                              domProps: { value: _vm.customSize.h },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    _vm.customSize,
                                    "h",
                                    $event.target.value
                                  )
                                }
                              }
                            })
                          ]
                        ),
                        _vm._v(" "),
                        _c("fieldset", [
                          _c(
                            "button",
                            {
                              staticClass: "btn btn-sm",
                              style: _vm.theme.actionButton,
                              on: { click: _vm.setCustomSizeToOriginal }
                            },
                            [_vm._v("Original Dimensions")]
                          )
                        ])
                      ]
                    ),
                    _vm._v(" "),
                    _vm.customSize.w && _vm.customSize.h
                      ? _c("img", {
                          attrs: {
                            src:
                              "/styled/preview/" +
                              _vm.source +
                              "?" +
                              _vm.encodedEdits +
                              _vm.encodedSize(_vm.customSize)
                          },
                          on: { load: _vm.addToImagesLoaded }
                        })
                      : _vm._e()
                  ]
            ],
            2
          )
        ]
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
    require("vue-hot-reload-api")      .rerender("data-v-1cea76b4", module.exports)
  }
}

/***/ }),

/***/ 757:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__ = __webpack_require__(6);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vuex__ = __webpack_require__(5);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__utilities_Loadbar__ = __webpack_require__(648);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__utilities_Loadbar___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__utilities_Loadbar__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__utilities_Uploader__ = __webpack_require__(758);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__utilities_Uploader___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__utilities_Uploader__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__MediaEditor__ = __webpack_require__(655);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__MediaEditor___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__MediaEditor__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__Breadcrumbs__ = __webpack_require__(762);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__Breadcrumbs___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5__Breadcrumbs__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6_vue_ionicons_dist_ios_folder_vue__ = __webpack_require__(765);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6_vue_ionicons_dist_ios_folder_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_6_vue_ionicons_dist_ios_folder_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7_vue_ionicons_dist_md_trash_vue__ = __webpack_require__(706);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7_vue_ionicons_dist_md_trash_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_7_vue_ionicons_dist_md_trash_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8_vue_ionicons_dist_ios_close_vue__ = __webpack_require__(697);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8_vue_ionicons_dist_ios_close_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_8_vue_ionicons_dist_ios_close_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9_vue_ionicons_dist_md_attach_vue__ = __webpack_require__(768);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9_vue_ionicons_dist_md_attach_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_9_vue_ionicons_dist_md_attach_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10_vue_ionicons_dist_ios_link_vue__ = __webpack_require__(771);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10_vue_ionicons_dist_ios_link_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_10_vue_ionicons_dist_ios_link_vue__);

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//














var Cookies = __webpack_require__(774);

/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      show: false,
      loaded: false,
      mode: 'list',
      directoryToCreate: '',
      target: null,
      callback: null,
      searchTerms: null,
      searchResults: [],
      selectedFile: null,
      searchResultsLimit: 100,
      currentlyOpenFile: null,
      options: null,
      cookieSettings: false
    };
  },
  mounted: function mounted() {
    this.startOpenerListener();
  },

  methods: __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_1_vuex__["b" /* mapActions */])('devise', ['setCurrentDirectory', 'generateImages', 'getCurrentFiles', 'getCurrentDirectories', 'mediaSearch', 'deleteFile', 'createDirectory', 'deleteDirectory']), {
    startOpenerListener: function startOpenerListener() {
      var self = this;

      deviseSettings.$bus.$on('devise-launch-media-manager', function (_ref) {
        var target = _ref.target,
            callback = _ref.callback,
            options = _ref.options;

        self.callback = callback;
        self.target = target;
        self.options = options;

        var cookieLocation = Cookies.get('devise-mediamanager-location');
        if (cookieLocation) {
          self.changeDirectories(cookieLocation);
          this.cookieSettings = true;
        } else {
          self.changeDirectories('');
        }

        self.show = true;
      });
    },
    changeDirectories: function changeDirectories(directory) {
      var self = this;
      self.loaded = false;
      this.searchTerms = null;
      this.$set(this, 'searchResults', []);

      self.setCurrentDirectory(directory).then(function () {
        self.getCurrentFiles(self.options).then(function () {
          self.getCurrentDirectories().then(function () {
            self.loaded = true;

            if (self.cookieSettings) {
              Cookies.set('devise-mediamanager-location', directory);
            }
          });
        });
      });
    },
    isActive: function isActive(file) {
      return file.used_count > 0;
    },
    refreshDirectory: function refreshDirectory() {
      this.changeDirectories(this.currentDirectory);
    },
    uploadError: function uploadError(file, message) {
      deviseSettings.$bus.$emit('showError', {
        title: 'Upload Error',
        message: 'There was a problem uploading your file. The file may be too large to be uploaded.'
      });
    },
    getUrlParam: function getUrlParam(paramName) {
      var reParam = new RegExp('(?:[?&]|&)' + paramName + '=([^&]+)', 'i');
      var match = window.location.search.match(reParam);

      return match && match.length > 1 ? match[1] : null;
    },
    openFile: function openFile(file) {
      this.$set(this, 'currentlyOpenFile', file);
    },
    closeFile: function closeFile(file) {
      this.$set(this, 'currentlyOpenFile', null);
    },
    selectSourceFile: function selectSourceFile(file) {
      this.selectedFile = file;

      if (this.options && this.options.type === 'file' || file && file.type === 'file') {
        if (typeof this.target !== 'undefined') {
          this.target.value = this.selectedFile.url;
        }
        if (typeof this.callback !== 'undefined') {
          this.callback(this.selectedFile.url);
        }

        this.show = false;
        this.$set(this, 'selectedFile', null);
      }
    },
    generateAndSetFile: function generateAndSetFile(edits) {
      var self = this;

      if (this.options && this.options.sizes) {
        edits.sizes = this.options.sizes;
      }

      devise.$bus.$emit('showLoadScreen', 'Images being generated');

      this.generateImages({ original: this.selectedFile.url, settings: edits }).then(function (response) {
        if (typeof self.target !== 'undefined') {
          self.target.value = response.data;
        }
        if (typeof self.callback !== 'undefined') {
          self.callback(response.data);
        }
        devise.$bus.$emit('hideLoadScreen');
        return true;
      });

      this.show = false;
      this.$set(this, 'selectedFile', null);
    },
    confirmedDeleteFile: function confirmedDeleteFile(file) {
      var self = this;
      this.deleteFile(file).then(function () {
        self.changeDirectories(self.currentDirectory);
      });
    },
    requestCreateDirectory: function requestCreateDirectory() {
      var self = this;

      // check to see if the directory already exists in the current location
      var existingMatches = this.directories.filter(function (dir) {
        return dir.name === self.directoryToCreate;
      });

      if (existingMatches.length === 0) {
        this.createDirectory({
          directory: self.currentDirectory,
          name: self.directoryToCreate
        }).then(function () {
          self.changeDirectories(self.currentDirectory);
          self.directoryToCreate = '';
        });
      } else {
        deviseSettings.$bus.$emit('showError', {
          title: 'Duplicate Name',
          message: 'There was already a directory with this name created in the current location.'
        });
      }
    },
    requestDeleteDirectory: function requestDeleteDirectory() {
      var self = this;
      this.deleteDirectory(self.currentDirectory).then(function () {
        self.changeDirectories('');
      });
    },
    search: function search() {
      var _this = this;

      this.mediaSearch(this.searchTerms).then(function (results) {
        _this.searchResults = results;
      });
    },
    closeSearch: function closeSearch() {
      this.searchTerms = null;
      this.$set(this, 'searchResults', []);
    }
  }),
  computed: __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_1_vuex__["c" /* mapGetters */])('devise', ['files', 'directories', 'currentDirectory', 'searchableMedia']), {
    currentFiles: function currentFiles() {
      if (this.searchResults.length > 0) {
        return this.searchResults;
      }
      return this.files;
    },
    uploadHeaders: function uploadHeaders() {
      var token = document.head.querySelector('meta[name="csrf-token"]');
      return {
        'X-CSRF-TOKEN': token.content
      };
    }
  }),
  watch: {
    cookieSettings: function cookieSettings(newValue) {
      if (!newValue) {
        Cookies.remove('devise-mediamanager-location');
      }
    }
  },
  components: {
    Loadbar: __WEBPACK_IMPORTED_MODULE_2__utilities_Loadbar___default.a,
    Breadcrumbs: __WEBPACK_IMPORTED_MODULE_5__Breadcrumbs___default.a,
    MediaEditor: __WEBPACK_IMPORTED_MODULE_4__MediaEditor___default.a,
    AttachIcon: __WEBPACK_IMPORTED_MODULE_9_vue_ionicons_dist_md_attach_vue___default.a,
    FolderIcon: __WEBPACK_IMPORTED_MODULE_6_vue_ionicons_dist_ios_folder_vue___default.a,
    LinkIcon: __WEBPACK_IMPORTED_MODULE_10_vue_ionicons_dist_ios_link_vue___default.a,
    TrashIcon: __WEBPACK_IMPORTED_MODULE_7_vue_ionicons_dist_md_trash_vue___default.a,
    CloseIcon: __WEBPACK_IMPORTED_MODULE_8_vue_ionicons_dist_ios_close_vue___default.a,
    Uploader: __WEBPACK_IMPORTED_MODULE_3__utilities_Uploader___default.a
  }
});

/***/ }),

/***/ 758:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(759)
/* template */
var __vue_template__ = __webpack_require__(761)
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
Component.options.__file = "src/components/utilities/Uploader.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-3a7b1c83", Component.options)
  } else {
    hotAPI.reload("data-v-3a7b1c83", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 759:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_ionicons_dist_ios_close_vue__ = __webpack_require__(697);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_ionicons_dist_ios_close_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue_ionicons_dist_ios_close_vue__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

var VueUpload = __webpack_require__(760);


/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      uploadingFiles: []
    };
  },

  methods: {
    /**
     * Has changed
     * @param  Object|undefined   newFile   Read only
     * @param  Object|undefined   oldFile   Read only
     * @return undefined
     */
    inputFile: function inputFile(newFile, oldFile) {
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        // Get response data
        if (newFile.xhr) {
          //  Get the response status code
          if (newFile.xhr.status === 200) {
            this.removeFileFromQueue(newFile);

            if (this.uploadingFiles.length < 1) {
              deviseSettings.$bus.$emit("showMessage", {
                title: "Upload Complete",
                message: "Your upload has been successfully completed"
              });
              this.$emit("all-files-uploaded", newFile);
            }
          }
        }
      }
    },
    /**
     * Pretreatment
     * @param  Object|undefined   newFile   Read and write
     * @param  Object|undefined   oldFile   Read only
     * @param  Function           prevent   Prevent changing
     * @return undefined
     */
    inputFilter: function inputFilter(newFile, oldFile, prevent) {
      // Create a blob field
      newFile.blob = "";
      var URL = window.URL || window.webkitURL;
      if (URL && URL.createObjectURL) {
        newFile.blob = URL.createObjectURL(newFile.file);
      }

      // Thumbnails
      newFile.thumb = "";
      if (newFile.blob && newFile.type.substr(0, 6) === "image/") {
        newFile.thumb = newFile.blob;
      }
    },
    removeFileFromQueue: function removeFileFromQueue(file) {
      this.uploadingFiles.splice(this.uploadingFiles.indexOf(file), 1);
    }
  },
  computed: {
    uploadHeaders: function uploadHeaders() {
      var token = document.head.querySelector('meta[name="csrf-token"]');
      return {
        "X-CSRF-TOKEN": token.content
      };
    }
  },
  components: {
    CloseIcon: __WEBPACK_IMPORTED_MODULE_0_vue_ionicons_dist_ios_close_vue___default.a,
    VueUpload: VueUpload
  },
  props: {
    currentDirectory: {
      type: String,
      required: true
    }
  }
});

/***/ }),

/***/ 760:
/***/ (function(module, exports, __webpack_require__) {

/*!
 * Name: vue-upload-component
 * Version: 2.8.16
 * Author: LianYue
 */
(function (global, factory) {
   true ? module.exports = factory() :
  typeof define === 'function' && define.amd ? define(factory) :
  (global.VueUploadComponent = factory());
}(this, (function () { 'use strict';

  /**
   * Creates a XHR request
   *
   * @param {Object} options
   */
  var createRequest = function createRequest(options) {
    var xhr = new XMLHttpRequest();
    xhr.open(options.method || 'GET', options.url);
    xhr.responseType = 'json';
    if (options.headers) {
      Object.keys(options.headers).forEach(function (key) {
        xhr.setRequestHeader(key, options.headers[key]);
      });
    }

    return xhr;
  };

  /**
   * Sends a XHR request with certain body
   *
   * @param {XMLHttpRequest} xhr
   * @param {Object} body
   */
  var sendRequest = function sendRequest(xhr, body) {
    return new Promise(function (resolve, reject) {
      xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
          var response;
          try {
            response = JSON.parse(xhr.response);
          } catch (err) {
            response = xhr.response;
          }
          resolve(response);
        } else {
          reject(xhr.response);
        }
      };
      xhr.onerror = function () {
        return reject(xhr.response);
      };
      xhr.send(JSON.stringify(body));
    });
  };

  /**
   * Sends a XHR request with certain form data
   *
   * @param {XMLHttpRequest} xhr
   * @param {Object} data
   */
  var sendFormRequest = function sendFormRequest(xhr, data) {
    var body = new FormData();
    for (var name in data) {
      body.append(name, data[name]);
    }

    return new Promise(function (resolve, reject) {
      xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
          var response;
          try {
            response = JSON.parse(xhr.response);
          } catch (err) {
            response = xhr.response;
          }
          resolve(response);
        } else {
          reject(xhr.response);
        }
      };
      xhr.onerror = function () {
        return reject(xhr.response);
      };
      xhr.send(body);
    });
  };

  /**
   * Creates and sends XHR request
   *
   * @param {Object} options
   *
   * @returns Promise
   */
  function request (options) {
    var xhr = createRequest(options);

    return sendRequest(xhr, options.body);
  }

  var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

  function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

  var ChunkUploadHandler = function () {
    /**
     * Constructor
     *
     * @param {File} file
     * @param {Object} options
     */
    function ChunkUploadHandler(file, options) {
      _classCallCheck(this, ChunkUploadHandler);

      this.file = file;
      this.options = options;
    }

    /**
     * Gets the max retries from options
     */


    _createClass(ChunkUploadHandler, [{
      key: 'createChunks',


      /**
       * Creates all the chunks in the initial state
       */
      value: function createChunks() {
        this.chunks = [];

        var start = 0;
        var end = this.chunkSize;
        while (start < this.fileSize) {
          this.chunks.push({
            blob: this.file.file.slice(start, end),
            startOffset: start,
            active: false,
            retries: this.maxRetries
          });
          start = end;
          end = start + this.chunkSize;
        }
      }

      /**
       * Updates the progress of the file with the handler's progress
       */

    }, {
      key: 'updateFileProgress',
      value: function updateFileProgress() {
        this.file.progress = this.progress;
      }

      /**
       * Paues the upload process
       * - Stops all active requests
       * - Sets the file not active
       */

    }, {
      key: 'pause',
      value: function pause() {
        this.file.active = false;
        this.stopChunks();
      }

      /**
       * Stops all the current chunks
       */

    }, {
      key: 'stopChunks',
      value: function stopChunks() {
        this.chunksUploading.forEach(function (chunk) {
          chunk.xhr.abort();
          chunk.active = false;
        });
      }

      /**
       * Resumes the file upload
       * - Sets the file active
       * - Starts the following chunks
       */

    }, {
      key: 'resume',
      value: function resume() {
        this.file.active = true;
        this.startChunking();
      }

      /**
       * Starts the file upload
       *
       * @returns Promise
       * - resolve  The file was uploaded
       * - reject   The file upload failed
       */

    }, {
      key: 'upload',
      value: function upload() {
        var _this = this;

        this.promise = new Promise(function (resolve, reject) {
          _this.resolve = resolve;
          _this.reject = reject;
        });
        this.start();

        return this.promise;
      }

      /**
       * Start phase
       * Sends a request to the backend to initialise the chunks
       */

    }, {
      key: 'start',
      value: function start() {
        var _this2 = this;

        request({
          method: 'POST',
          headers: Object.assign({}, this.headers, {
            'Content-Type': 'application/json'
          }),
          url: this.action,
          body: Object.assign(this.startBody, {
            phase: 'start',
            mime_type: this.fileType,
            size: this.fileSize,
            name: this.fileName
          })
        }).then(function (res) {
          if (res.status !== 'success') {
            _this2.file.response = res;
            return _this2.reject('server');
          }

          _this2.sessionId = res.data.session_id;
          _this2.chunkSize = res.data.end_offset;

          _this2.createChunks();
          _this2.startChunking();
        }).catch(function (res) {
          _this2.file.response = res;
          _this2.reject('server');
        });
      }

      /**
       * Starts to upload chunks
       */

    }, {
      key: 'startChunking',
      value: function startChunking() {
        for (var i = 0; i < this.maxActiveChunks; i++) {
          this.uploadNextChunk();
        }
      }

      /**
       * Uploads the next chunk
       * - Won't do anything if the process is paused
       * - Will start finish phase if there are no more chunks to upload
       */

    }, {
      key: 'uploadNextChunk',
      value: function uploadNextChunk() {
        if (this.file.active) {
          if (this.hasChunksToUpload) {
            return this.uploadChunk(this.chunksToUpload[0]);
          }

          if (this.chunksUploading.length === 0) {
            return this.finish();
          }
        }
      }

      /**
       * Uploads a chunk
       * - Sends the chunk to the backend
       * - Sets the chunk as uploaded if everything went well
       * - Decreases the number of retries if anything went wrong
       * - Fails if there are no more retries
       *
       * @param {Object} chunk
       */

    }, {
      key: 'uploadChunk',
      value: function uploadChunk(chunk) {
        var _this3 = this;

        chunk.progress = 0;
        chunk.active = true;
        this.updateFileProgress();
        chunk.xhr = createRequest({
          method: 'POST',
          headers: this.headers,
          url: this.action
        });

        chunk.xhr.upload.addEventListener('progress', function (evt) {
          if (evt.lengthComputable) {
            chunk.progress = Math.round(evt.loaded / evt.total * 100);
          }
        }, false);

        sendFormRequest(chunk.xhr, Object.assign(this.uploadBody, {
          phase: 'upload',
          session_id: this.sessionId,
          start_offset: chunk.startOffset,
          chunk: chunk.blob
        })).then(function (res) {
          chunk.active = false;
          if (res.status === 'success') {
            chunk.uploaded = true;
          } else {
            if (chunk.retries-- <= 0) {
              _this3.stopChunks();
              return _this3.reject('upload');
            }
          }

          _this3.uploadNextChunk();
        }).catch(function () {
          chunk.active = false;
          if (chunk.retries-- <= 0) {
            _this3.stopChunks();
            return _this3.reject('upload');
          }

          _this3.uploadNextChunk();
        });
      }

      /**
       * Finish phase
       * Sends a request to the backend to finish the process
       */

    }, {
      key: 'finish',
      value: function finish() {
        var _this4 = this;

        this.updateFileProgress();

        request({
          method: 'POST',
          headers: Object.assign({}, this.headers, {
            'Content-Type': 'application/json'
          }),
          url: this.action,
          body: Object.assign(this.finishBody, {
            phase: 'finish',
            session_id: this.sessionId
          })
        }).then(function (res) {
          _this4.file.response = res;
          if (res.status !== 'success') {
            return _this4.reject('server');
          }

          _this4.resolve(res);
        }).catch(function (res) {
          _this4.file.response = res;
          _this4.reject('server');
        });
      }
    }, {
      key: 'maxRetries',
      get: function get() {
        return parseInt(this.options.maxRetries);
      }

      /**
       * Gets the max number of active chunks being uploaded at once from options
       */

    }, {
      key: 'maxActiveChunks',
      get: function get() {
        return parseInt(this.options.maxActive);
      }

      /**
       * Gets the file type
       */

    }, {
      key: 'fileType',
      get: function get() {
        return this.file.type;
      }

      /**
       * Gets the file size
       */

    }, {
      key: 'fileSize',
      get: function get() {
        return this.file.size;
      }

      /**
       * Gets the file size
       */

    }, {
      key: 'fileName',
      get: function get() {
        return this.file.name;
      }

      /**
       * Gets action (url) to upload the file
       */

    }, {
      key: 'action',
      get: function get() {
        return this.options.action || null;
      }

      /**
       * Gets the body to be merged when sending the request in start phase
       */

    }, {
      key: 'startBody',
      get: function get() {
        return this.options.startBody || {};
      }

      /**
       * Gets the body to be merged when sending the request in upload phase
       */

    }, {
      key: 'uploadBody',
      get: function get() {
        return this.options.uploadBody || {};
      }

      /**
       * Gets the body to be merged when sending the request in finish phase
       */

    }, {
      key: 'finishBody',
      get: function get() {
        return this.options.finishBody || {};
      }

      /**
       * Gets the headers of the requests from options
       */

    }, {
      key: 'headers',
      get: function get() {
        return this.options.headers || {};
      }

      /**
       * Whether it's ready to upload files or not
       */

    }, {
      key: 'readyToUpload',
      get: function get() {
        return !!this.chunks;
      }

      /**
       * Gets the progress of the chunk upload
       * - Gets all the completed chunks
       * - Gets the progress of all the chunks that are being uploaded
       */

    }, {
      key: 'progress',
      get: function get() {
        var _this5 = this;

        var completedProgress = this.chunksUploaded.length / this.chunks.length * 100;
        var uploadingProgress = this.chunksUploading.reduce(function (progress, chunk) {
          return progress + (chunk.progress | 0) / _this5.chunks.length;
        }, 0);

        return Math.min(completedProgress + uploadingProgress, 100);
      }

      /**
       * Gets all the chunks that are pending to be uploaded
       */

    }, {
      key: 'chunksToUpload',
      get: function get() {
        return this.chunks.filter(function (chunk) {
          return !chunk.active && !chunk.uploaded;
        });
      }

      /**
       * Whether there are chunks to upload or not
       */

    }, {
      key: 'hasChunksToUpload',
      get: function get() {
        return this.chunksToUpload.length > 0;
      }

      /**
       * Gets all the chunks that are uploading
       */

    }, {
      key: 'chunksUploading',
      get: function get() {
        return this.chunks.filter(function (chunk) {
          return !!chunk.xhr && !!chunk.active;
        });
      }

      /**
       * Gets all the chunks that have finished uploading
       */

    }, {
      key: 'chunksUploaded',
      get: function get() {
        return this.chunks.filter(function (chunk) {
          return !!chunk.uploaded;
        });
      }
    }]);

    return ChunkUploadHandler;
  }();

  //
  //
  //
  //
  //
  //
  //
  //
  //
  //
  //
  //
  //
  //

  var script = {
    methods: {
      change: function change(e) {
        this.$parent.addInputFile(e.target);
        e.target.value = '';
        if (!e.target.files) {
          // ie9 fix #219
          this.$destroy();
          // eslint-disable-next-line
          new this.constructor({
            parent: this.$parent,
            el: this.$el
          });
        }
      }
    }
  };

  /* script */
  var __vue_script__ = script;

  /* template */
  var __vue_render__ = function __vue_render__() {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('input', { attrs: { "type": "file", "name": _vm.$parent.name, "id": _vm.$parent.inputId || _vm.$parent.name, "accept": _vm.$parent.accept, "capture": _vm.$parent.capture, "disabled": _vm.$parent.disabled, "webkitdirectory": _vm.$parent.directory && _vm.$parent.features.directory, "directory": _vm.$parent.directory && _vm.$parent.features.directory, "multiple": _vm.$parent.multiple && _vm.$parent.features.html5 }, on: { "change": _vm.change } });
  };
  var __vue_staticRenderFns__ = [];

  /* style */
  var __vue_inject_styles__ = undefined;
  /* scoped */
  var __vue_scope_id__ = undefined;
  /* module identifier */
  var __vue_module_identifier__ = undefined;
  /* functional template */
  var __vue_is_functional_template__ = false;
  /* component normalizer */
  function __vue_normalize__(template, style, script$$1, scope, functional, moduleIdentifier, createInjector, createInjectorSSR) {
    var component = (typeof script$$1 === 'function' ? script$$1.options : script$$1) || {};

    if (!component.render) {
      component.render = template.render;
      component.staticRenderFns = template.staticRenderFns;
      component._compiled = true;

      if (functional) component.functional = true;
    }

    component._scopeId = scope;

    return component;
  }
  /* style inject */
  function __vue_create_injector__() {
    var head = document.head || document.getElementsByTagName('head')[0];
    var styles = __vue_create_injector__.styles || (__vue_create_injector__.styles = {});
    var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\\b/.test(navigator.userAgent.toLowerCase());

    return function addStyle(id, css) {
      if (document.querySelector('style[data-vue-ssr-id~="' + id + '"]')) return; // SSR styles are present.

      var group = isOldIE ? css.media || 'default' : id;
      var style = styles[group] || (styles[group] = { ids: [], parts: [], element: undefined });

      if (!style.ids.includes(id)) {
        var code = css.source;
        var index = style.ids.length;

        style.ids.push(id);

        if (css.map) {
          // https://developer.chrome.com/devtools/docs/javascript-debugging
          // this makes source maps inside style tags work properly in Chrome
          code += '\n/*# sourceURL=' + css.map.sources[0] + ' */';
          // http://stackoverflow.com/a/26603875
          code += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(css.map)))) + ' */';
        }

        if (isOldIE) {
          style.element = style.element || document.querySelector('style[data-group=' + group + ']');
        }

        if (!style.element) {
          var el = style.element = document.createElement('style');
          el.type = 'text/css';

          if (css.media) el.setAttribute('media', css.media);
          if (isOldIE) {
            el.setAttribute('data-group', group);
            el.setAttribute('data-next-index', '0');
          }

          head.appendChild(el);
        }

        if (isOldIE) {
          index = parseInt(style.element.getAttribute('data-next-index'));
          style.element.setAttribute('data-next-index', index + 1);
        }

        if (style.element.styleSheet) {
          style.parts.push(code);
          style.element.styleSheet.cssText = style.parts.filter(Boolean).join('\n');
        } else {
          var textNode = document.createTextNode(code);
          var nodes = style.element.childNodes;
          if (nodes[index]) style.element.removeChild(nodes[index]);
          if (nodes.length) style.element.insertBefore(textNode, nodes[index]);else style.element.appendChild(textNode);
        }
      }
    };
  }
  /* style inject SSR */

  var InputFile = __vue_normalize__({ render: __vue_render__, staticRenderFns: __vue_staticRenderFns__ }, __vue_inject_styles__, __vue_script__, __vue_scope_id__, __vue_is_functional_template__, __vue_module_identifier__, __vue_create_injector__, undefined);

  var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

  var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

  function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

  var CHUNK_DEFAULT_OPTIONS = {
    headers: {},
    action: '',
    minSize: 1048576,
    maxActive: 3,
    maxRetries: 5,

    handler: ChunkUploadHandler
  };

  var script$1 = {
    components: {
      InputFile: InputFile
    },
    props: {
      inputId: {
        type: String
      },

      name: {
        type: String,
        default: 'file'
      },

      accept: {
        type: String
      },

      capture: {},

      disabled: {},

      multiple: {
        type: Boolean
      },

      maximum: {
        type: Number,
        default: function _default() {
          return this.multiple ? 0 : 1;
        }
      },

      addIndex: {
        type: [Boolean, Number]
      },

      directory: {
        type: Boolean
      },

      postAction: {
        type: String
      },

      putAction: {
        type: String
      },

      customAction: {
        type: Function
      },

      headers: {
        type: Object,
        default: Object
      },

      data: {
        type: Object,
        default: Object
      },

      timeout: {
        type: Number,
        default: 0
      },

      drop: {
        default: false
      },

      dropDirectory: {
        type: Boolean,
        default: true
      },

      size: {
        type: Number,
        default: 0
      },

      extensions: {
        default: Array
      },

      value: {
        type: Array,
        default: Array
      },

      thread: {
        type: Number,
        default: 1
      },

      // Chunk upload enabled
      chunkEnabled: {
        type: Boolean,
        default: false
      },

      // Chunk upload properties
      chunk: {
        type: Object,
        default: function _default() {
          return CHUNK_DEFAULT_OPTIONS;
        }
      }
    },

    data: function data() {
      return {
        files: this.value,
        features: {
          html5: true,
          directory: false,
          drag: false
        },

        active: false,
        dropActive: false,

        uploading: 0,

        destroy: false
      };
    },


    /**
     * mounted
     * @return {[type]} [description]
     */
    mounted: function mounted() {
      var input = document.createElement('input');
      input.type = 'file';
      input.multiple = true;

      // html5 特征
      if (window.FormData && input.files) {
        // 上传目录特征
        if (typeof input.webkitdirectory === 'boolean' || typeof input.directory === 'boolean') {
          this.features.directory = true;
        }

        // 拖拽特征
        if (this.features.html5 && typeof input.ondrop !== 'undefined') {
          this.features.drop = true;
        }
      } else {
        this.features.html5 = false;
      }

      // files 定位缓存
      this.maps = {};
      if (this.files) {
        for (var i = 0; i < this.files.length; i++) {
          var file = this.files[i];
          this.maps[file.id] = file;
        }
      }

      this.$nextTick(function () {

        // 更新下父级
        if (this.$parent) {
          this.$parent.$forceUpdate();
        }

        // 拖拽渲染
        this.watchDrop(this.drop);
      });
    },


    /**
     * beforeDestroy
     * @return {[type]} [description]
     */
    beforeDestroy: function beforeDestroy() {
      // 已销毁
      this.destroy = true;

      // 设置成不激活
      this.active = false;
    },


    computed: {
      /**
       * uploading 正在上传的线程
       * @return {[type]} [description]
       */

      /**
       * uploaded 文件列表是否全部已上传
       * @return {[type]} [description]
       */
      uploaded: function uploaded() {
        var file = void 0;
        for (var i = 0; i < this.files.length; i++) {
          file = this.files[i];
          if (file.fileObject && !file.error && !file.success) {
            return false;
          }
        }
        return true;
      },
      chunkOptions: function chunkOptions() {
        return Object.assign(CHUNK_DEFAULT_OPTIONS, this.chunk);
      },
      className: function className() {
        return ['file-uploads', this.features.html5 ? 'file-uploads-html5' : 'file-uploads-html4', this.features.directory && this.directory ? 'file-uploads-directory' : undefined, this.features.drop && this.drop ? 'file-uploads-drop' : undefined, this.disabled ? 'file-uploads-disabled' : undefined];
      }
    },

    watch: {
      active: function active(_active) {
        this.watchActive(_active);
      },
      dropActive: function dropActive() {
        if (this.$parent) {
          this.$parent.$forceUpdate();
        }
      },
      drop: function drop(value) {
        this.watchDrop(value);
      },
      value: function value(files) {
        if (this.files === files) {
          return;
        }
        this.files = files;

        var oldMaps = this.maps;

        // 重写 maps 缓存
        this.maps = {};
        for (var i = 0; i < this.files.length; i++) {
          var file = this.files[i];
          this.maps[file.id] = file;
        }

        // add, update
        for (var key in this.maps) {
          var newFile = this.maps[key];
          var oldFile = oldMaps[key];
          if (newFile !== oldFile) {
            this.emitFile(newFile, oldFile);
          }
        }

        // delete
        for (var _key in oldMaps) {
          if (!this.maps[_key]) {
            this.emitFile(undefined, oldMaps[_key]);
          }
        }
      }
    },

    methods: {

      // 清空
      clear: function clear() {
        if (this.files.length) {
          var files = this.files;
          this.files = [];

          // 定位
          this.maps = {};

          // 事件
          this.emitInput();
          for (var i = 0; i < files.length; i++) {
            this.emitFile(undefined, files[i]);
          }
        }
        return true;
      },


      // 选择
      get: function get(id) {
        if (!id) {
          return false;
        }

        if ((typeof id === 'undefined' ? 'undefined' : _typeof(id)) === 'object') {
          return this.maps[id.id] || false;
        }

        return this.maps[id] || false;
      },


      // 添加
      add: function add(_files) {
        var index = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : this.addIndex;

        var files = _files;
        var isArray = files instanceof Array;

        // 不是数组整理成数组
        if (!isArray) {
          files = [files];
        }

        // 遍历规范对象
        var addFiles = [];
        for (var i = 0; i < files.length; i++) {
          var file = files[i];
          if (this.features.html5 && file instanceof Blob) {
            file = {
              file: file,
              size: file.size,
              name: file.webkitRelativePath || file.relativePath || file.name || 'unknown',
              type: file.type
            };
          }
          var fileObject = false;
          if (file.fileObject === false) ; else if (file.fileObject) {
            fileObject = true;
          } else if (typeof Element !== 'undefined' && file.el instanceof Element) {
            fileObject = true;
          } else if (typeof Blob !== 'undefined' && file.file instanceof Blob) {
            fileObject = true;
          }
          if (fileObject) {
            file = _extends({
              fileObject: true,
              size: -1,
              name: 'Filename',
              type: '',
              active: false,
              error: '',
              success: false,
              putAction: this.putAction,
              postAction: this.postAction,
              timeout: this.timeout
            }, file, {
              response: {},

              progress: '0.00', // 只读
              speed: 0 // 只读
              // xhr: false,                // 只读
              // iframe: false,             // 只读
            });

            file.data = _extends({}, this.data, file.data ? file.data : {});

            file.headers = _extends({}, this.headers, file.headers ? file.headers : {});
          }

          // 必须包含 id
          if (!file.id) {
            file.id = Math.random().toString(36).substr(2);
          }

          if (this.emitFilter(file, undefined)) {
            continue;
          }

          // 最大数量限制
          if (this.maximum > 1 && addFiles.length + this.files.length >= this.maximum) {
            break;
          }

          addFiles.push(file);

          // 最大数量限制
          if (this.maximum === 1) {
            break;
          }
        }

        // 没有文件
        if (!addFiles.length) {
          return false;
        }

        // 如果是 1 清空
        if (this.maximum === 1) {
          this.clear();
        }

        // 添加进去 files
        var newFiles = void 0;
        if (index === true || index === 0) {
          newFiles = addFiles.concat(this.files);
        } else if (index) {
          var _newFiles;

          newFiles = this.files.concat([]);
          (_newFiles = newFiles).splice.apply(_newFiles, [index, 0].concat(addFiles));
        } else {
          newFiles = this.files.concat(addFiles);
        }

        this.files = newFiles;

        // 定位
        for (var _i = 0; _i < addFiles.length; _i++) {
          var _file2 = addFiles[_i];
          this.maps[_file2.id] = _file2;
        }

        // 事件
        this.emitInput();
        for (var _i2 = 0; _i2 < addFiles.length; _i2++) {
          this.emitFile(addFiles[_i2], undefined);
        }

        return isArray ? addFiles : addFiles[0];
      },


      // 添加表单文件
      addInputFile: function addInputFile(el) {
        var files = [];
        if (el.files) {
          for (var i = 0; i < el.files.length; i++) {
            var file = el.files[i];
            files.push({
              size: file.size,
              name: file.webkitRelativePath || file.relativePath || file.name,
              type: file.type,
              file: file
            });
          }
        } else {
          var names = el.value.replace(/\\/g, '/').split('/');
          delete el.__vuex__;
          files.push({
            name: names[names.length - 1],
            el: el
          });
        }
        return this.add(files);
      },


      // 添加 DataTransfer
      addDataTransfer: function addDataTransfer(dataTransfer) {
        var _this = this;

        var files = [];
        if (dataTransfer.items && dataTransfer.items.length) {
          var items = [];
          for (var i = 0; i < dataTransfer.items.length; i++) {
            var item = dataTransfer.items[i];
            if (item.getAsEntry) {
              item = item.getAsEntry() || item.getAsFile();
            } else if (item.webkitGetAsEntry) {
              item = item.webkitGetAsEntry() || item.getAsFile();
            } else {
              item = item.getAsFile();
            }
            if (item) {
              items.push(item);
            }
          }

          return new Promise(function (resolve, reject) {
            var forEach = function forEach(i) {
              var item = items[i];
              // 结束 文件数量大于 最大数量
              if (!item || _this.maximum > 0 && files.length >= _this.maximum) {
                return resolve(_this.add(files));
              }
              _this.getEntry(item).then(function (results) {
                files.push.apply(files, _toConsumableArray(results));
                forEach(i + 1);
              });
            };
            forEach(0);
          });
        }

        if (dataTransfer.files.length) {
          for (var _i3 = 0; _i3 < dataTransfer.files.length; _i3++) {
            files.push(dataTransfer.files[_i3]);
            if (this.maximum > 0 && files.length >= this.maximum) {
              break;
            }
          }
          return Promise.resolve(this.add(files));
        }

        return Promise.resolve([]);
      },


      // 获得 entry
      getEntry: function getEntry(entry) {
        var _this2 = this;

        var path = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

        return new Promise(function (resolve, reject) {
          if (entry.isFile) {
            entry.file(function (file) {
              resolve([{
                size: file.size,
                name: path + file.name,
                type: file.type,
                file: file
              }]);
            });
          } else if (entry.isDirectory && _this2.dropDirectory) {
            var files = [];
            var dirReader = entry.createReader();
            var readEntries = function readEntries() {
              dirReader.readEntries(function (entries) {
                var forEach = function forEach(i) {
                  if (!entries[i] && i === 0 || _this2.maximum > 0 && files.length >= _this2.maximum) {
                    return resolve(files);
                  }
                  if (!entries[i]) {
                    return readEntries();
                  }
                  _this2.getEntry(entries[i], path + entry.name + '/').then(function (results) {
                    files.push.apply(files, _toConsumableArray(results));
                    forEach(i + 1);
                  });
                };
                forEach(0);
              });
            };
            readEntries();
          } else {
            resolve([]);
          }
        });
      },
      replace: function replace(id1, id2) {
        var file1 = this.get(id1);
        var file2 = this.get(id2);
        if (!file1 || !file2 || file1 === file2) {
          return false;
        }
        var files = this.files.concat([]);
        var index1 = files.indexOf(file1);
        var index2 = files.indexOf(file2);
        if (index1 === -1 || index2 === -1) {
          return false;
        }
        files[index1] = file2;
        files[index2] = file1;
        this.files = files;
        this.emitInput();
        return true;
      },


      // 移除
      remove: function remove(id) {
        var file = this.get(id);
        if (file) {
          if (this.emitFilter(undefined, file)) {
            return false;
          }
          var files = this.files.concat([]);
          var index = files.indexOf(file);
          if (index === -1) {
            console.error('remove', file);
            return false;
          }
          files.splice(index, 1);
          this.files = files;

          // 定位
          delete this.maps[file.id];

          // 事件
          this.emitInput();
          this.emitFile(undefined, file);
        }
        return file;
      },


      // 更新
      update: function update(id, data) {
        var file = this.get(id);
        if (file) {
          var newFile = _extends({}, file, data);
          // 停用必须加上错误
          if (file.fileObject && file.active && !newFile.active && !newFile.error && !newFile.success) {
            newFile.error = 'abort';
          }

          if (this.emitFilter(newFile, file)) {
            return false;
          }

          var files = this.files.concat([]);
          var index = files.indexOf(file);
          if (index === -1) {
            console.error('update', file);
            return false;
          }
          files.splice(index, 1, newFile);
          this.files = files;

          // 删除  旧定位 写入 新定位 （已便支持修改id)
          delete this.maps[file.id];
          this.maps[newFile.id] = newFile;

          // 事件
          this.emitInput();
          this.emitFile(newFile, file);
          return newFile;
        }
        return false;
      },


      // 预处理 事件 过滤器
      emitFilter: function emitFilter(newFile, oldFile) {
        var isPrevent = false;
        this.$emit('input-filter', newFile, oldFile, function () {
          isPrevent = true;
          return isPrevent;
        });
        return isPrevent;
      },


      // 处理后 事件 分发
      emitFile: function emitFile(newFile, oldFile) {
        this.$emit('input-file', newFile, oldFile);
        if (newFile && newFile.fileObject && newFile.active && (!oldFile || !oldFile.active)) {
          this.uploading++;
          // 激活
          this.$nextTick(function () {
            var _this3 = this;

            setTimeout(function () {
              _this3.upload(newFile).then(function () {
                // eslint-disable-next-line
                newFile = _this3.get(newFile);
                if (newFile && newFile.fileObject) {
                  _this3.update(newFile, {
                    active: false,
                    success: !newFile.error
                  });
                }
              }).catch(function (e) {
                _this3.update(newFile, {
                  active: false,
                  success: false,
                  error: e.code || e.error || e.message || e
                });
              });
            }, parseInt(Math.random() * 50 + 50, 10));
          });
        } else if ((!newFile || !newFile.fileObject || !newFile.active) && oldFile && oldFile.fileObject && oldFile.active) {
          // 停止
          this.uploading--;
        }

        // 自动延续激活
        if (this.active && (Boolean(newFile) !== Boolean(oldFile) || newFile.active !== oldFile.active)) {
          this.watchActive(true);
        }
      },
      emitInput: function emitInput() {
        this.$emit('input', this.files);
      },


      // 上传
      upload: function upload(id) {
        var file = this.get(id);

        // 被删除
        if (!file) {
          return Promise.reject('not_exists');
        }

        // 不是文件对象
        if (!file.fileObject) {
          return Promise.reject('file_object');
        }

        // 有错误直接响应
        if (file.error) {
          return Promise.reject(file.error);
        }

        // 已完成直接响应
        if (file.success) {
          return Promise.resolve(file);
        }

        // 后缀
        var extensions = this.extensions;
        if (extensions && (extensions.length || typeof extensions.length === 'undefined')) {
          if ((typeof extensions === 'undefined' ? 'undefined' : _typeof(extensions)) !== 'object' || !(extensions instanceof RegExp)) {
            if (typeof extensions === 'string') {
              extensions = extensions.split(',').map(function (value) {
                return value.trim();
              }).filter(function (value) {
                return value;
              });
            }
            extensions = new RegExp('\\.(' + extensions.join('|').replace(/\./g, '\\.') + ')$', 'i');
          }
          if (file.name.search(extensions) === -1) {
            return Promise.reject('extension');
          }
        }

        // 大小
        if (this.size > 0 && file.size >= 0 && file.size > this.size) {
          return Promise.reject('size');
        }

        if (this.customAction) {
          return this.customAction(file, this);
        }

        if (this.features.html5) {
          if (this.shouldUseChunkUpload(file)) {
            return this.uploadChunk(file);
          }
          if (file.putAction) {
            return this.uploadPut(file);
          }
          if (file.postAction) {
            return this.uploadHtml5(file);
          }
        }
        if (file.postAction) {
          return this.uploadHtml4(file);
        }
        return Promise.reject('No action configured');
      },


      /**
       * Whether this file should be uploaded using chunk upload or not
       *
       * @param Object file
       */
      shouldUseChunkUpload: function shouldUseChunkUpload(file) {
        return this.chunkEnabled && !!this.chunkOptions.handler && file.size > this.chunkOptions.minSize;
      },


      /**
       * Upload a file using Chunk method
       *
       * @param File file
       */
      uploadChunk: function uploadChunk(file) {
        var HandlerClass = this.chunkOptions.handler;
        file.chunk = new HandlerClass(file, this.chunkOptions);

        return file.chunk.upload();
      },
      uploadPut: function uploadPut(file) {
        var querys = [];
        var value = void 0;
        for (var key in file.data) {
          value = file.data[key];
          if (value !== null && value !== undefined) {
            querys.push(encodeURIComponent(key) + '=' + encodeURIComponent(value));
          }
        }
        var queryString = querys.length ? (file.putAction.indexOf('?') === -1 ? '?' : '&') + querys.join('&') : '';
        var xhr = new XMLHttpRequest();
        xhr.open('PUT', file.putAction + queryString);
        return this.uploadXhr(xhr, file, file.file);
      },
      uploadHtml5: function uploadHtml5(file) {
        var form = new window.FormData();
        var value = void 0;
        for (var key in file.data) {
          value = file.data[key];
          if (value && (typeof value === 'undefined' ? 'undefined' : _typeof(value)) === 'object' && typeof value.toString !== 'function') {
            if (value instanceof File) {
              form.append(key, value, value.name);
            } else {
              form.append(key, JSON.stringify(value));
            }
          } else if (value !== null && value !== undefined) {
            form.append(key, value);
          }
        }
        form.append(this.name, file.file, file.file.filename || file.name);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', file.postAction);
        return this.uploadXhr(xhr, file, form);
      },
      uploadXhr: function uploadXhr(xhr, _file, body) {
        var _this4 = this;

        var file = _file;
        var speedTime = 0;
        var speedLoaded = 0;

        // 进度条
        xhr.upload.onprogress = function (e) {
          // 还未开始上传 已删除 未激活
          file = _this4.get(file);
          if (!e.lengthComputable || !file || !file.fileObject || !file.active) {
            return;
          }

          // 进度 速度 每秒更新一次
          var speedTime2 = Math.round(Date.now() / 1000);
          if (speedTime2 === speedTime) {
            return;
          }
          speedTime = speedTime2;

          file = _this4.update(file, {
            progress: (e.loaded / e.total * 100).toFixed(2),
            speed: e.loaded - speedLoaded
          });
          speedLoaded = e.loaded;
        };

        // 检查激活状态
        var interval = setInterval(function () {
          file = _this4.get(file);
          if (file && file.fileObject && !file.success && !file.error && file.active) {
            return;
          }

          if (interval) {
            clearInterval(interval);
            interval = false;
          }

          try {
            xhr.abort();
            xhr.timeout = 1;
          } catch (e) {}
        }, 100);

        return new Promise(function (resolve, reject) {
          var complete = void 0;
          var fn = function fn(e) {
            // 已经处理过了
            if (complete) {
              return;
            }
            complete = true;
            if (interval) {
              clearInterval(interval);
              interval = false;
            }

            file = _this4.get(file);

            // 不存在直接响应
            if (!file) {
              return reject('not_exists');
            }

            // 不是文件对象
            if (!file.fileObject) {
              return reject('file_object');
            }

            // 有错误自动响应
            if (file.error) {
              return reject(file.error);
            }

            // 未激活
            if (!file.active) {
              return reject('abort');
            }

            // 已完成 直接相应
            if (file.success) {
              return resolve(file);
            }

            var data = {};

            switch (e.type) {
              case 'timeout':
              case 'abort':
                data.error = e.type;
                break;
              case 'error':
                if (!xhr.status) {
                  data.error = 'network';
                } else if (xhr.status >= 500) {
                  data.error = 'server';
                } else if (xhr.status >= 400) {
                  data.error = 'denied';
                }
                break;
              default:
                if (xhr.status >= 500) {
                  data.error = 'server';
                } else if (xhr.status >= 400) {
                  data.error = 'denied';
                } else {
                  data.progress = '100.00';
                }
            }

            if (xhr.responseText) {
              var contentType = xhr.getResponseHeader('Content-Type');
              if (contentType && contentType.indexOf('/json') !== -1) {
                data.response = JSON.parse(xhr.responseText);
              } else {
                data.response = xhr.responseText;
              }
            }

            // 更新
            file = _this4.update(file, data);

            // 相应错误
            if (file.error) {
              return reject(file.error);
            }

            // 响应
            return resolve(file);
          };

          // 事件
          xhr.onload = fn;
          xhr.onerror = fn;
          xhr.onabort = fn;
          xhr.ontimeout = fn;

          // 超时
          if (file.timeout) {
            xhr.timeout = file.timeout;
          }

          // headers
          for (var key in file.headers) {
            xhr.setRequestHeader(key, file.headers[key]);
          }

          // 更新 xhr
          file = _this4.update(file, { xhr: xhr });

          // 开始上传
          xhr.send(body);
        });
      },
      uploadHtml4: function uploadHtml4(_file) {
        var _this5 = this;

        var file = _file;
        var onKeydown = function onKeydown(e) {
          if (e.keyCode === 27) {
            e.preventDefault();
          }
        };

        var iframe = document.createElement('iframe');
        iframe.id = 'upload-iframe-' + file.id;
        iframe.name = 'upload-iframe-' + file.id;
        iframe.src = 'about:blank';
        iframe.setAttribute('style', 'width:1px;height:1px;top:-999em;position:absolute; margin-top:-999em;');

        var form = document.createElement('form');

        form.action = file.postAction;

        form.name = 'upload-form-' + file.id;

        form.setAttribute('method', 'POST');
        form.setAttribute('target', 'upload-iframe-' + file.id);
        form.setAttribute('enctype', 'multipart/form-data');

        var value = void 0;
        var input = void 0;
        for (var key in file.data) {
          value = file.data[key];
          if (value && (typeof value === 'undefined' ? 'undefined' : _typeof(value)) === 'object' && typeof value.toString !== 'function') {
            value = JSON.stringify(value);
          }
          if (value !== null && value !== undefined) {
            input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            form.appendChild(input);
          }
        }
        form.appendChild(file.el);

        document.body.appendChild(iframe).appendChild(form);

        var getResponseData = function getResponseData() {
          var doc = void 0;
          try {
            if (iframe.contentWindow) {
              doc = iframe.contentWindow.document;
            }
          } catch (err) {}
          if (!doc) {
            try {
              doc = iframe.contentDocument ? iframe.contentDocument : iframe.document;
            } catch (err) {
              doc = iframe.document;
            }
          }
          if (doc && doc.body) {
            return doc.body.innerHTML;
          }
          return null;
        };

        return new Promise(function (resolve, reject) {
          setTimeout(function () {
            file = _this5.update(file, { iframe: iframe });

            // 不存在
            if (!file) {
              return reject('not_exists');
            }

            // 定时检查
            var interval = setInterval(function () {
              file = _this5.get(file);
              if (file && file.fileObject && !file.success && !file.error && file.active) {
                return;
              }

              if (interval) {
                clearInterval(interval);
                interval = false;
              }

              iframe.onabort({ type: file ? 'abort' : 'not_exists' });
            }, 100);

            var complete = void 0;
            var fn = function fn(e) {
              // 已经处理过了
              if (complete) {
                return;
              }
              complete = true;

              if (interval) {
                clearInterval(interval);
                interval = false;
              }

              // 关闭 esc 事件
              document.body.removeEventListener('keydown', onKeydown);

              file = _this5.get(file);

              // 不存在直接响应
              if (!file) {
                return reject('not_exists');
              }

              // 不是文件对象
              if (!file.fileObject) {
                return reject('file_object');
              }

              // 有错误自动响应
              if (file.error) {
                return reject(file.error);
              }

              // 未激活
              if (!file.active) {
                return reject('abort');
              }

              // 已完成 直接相应
              if (file.success) {
                return resolve(file);
              }

              var response = getResponseData();
              var data = {};
              switch (e.type) {
                case 'abort':
                  data.error = 'abort';
                  break;
                case 'error':
                  if (file.error) {
                    data.error = file.error;
                  } else if (response === null) {
                    data.error = 'network';
                  } else {
                    data.error = 'denied';
                  }
                  break;
                default:
                  if (file.error) {
                    data.error = file.error;
                  } else if (data === null) {
                    data.error = 'network';
                  } else {
                    data.progress = '100.00';
                  }
              }

              if (response !== null) {
                if (response && response.substr(0, 1) === '{' && response.substr(response.length - 1, 1) === '}') {
                  try {
                    response = JSON.parse(response);
                  } catch (err) {}
                }
                data.response = response;
              }

              // 更新
              file = _this5.update(file, data);

              if (file.error) {
                return reject(file.error);
              }

              // 响应
              return resolve(file);
            };

            // 添加事件
            iframe.onload = fn;
            iframe.onerror = fn;
            iframe.onabort = fn;

            // 禁止 esc 键
            document.body.addEventListener('keydown', onKeydown);

            // 提交
            form.submit();
          }, 50);
        }).then(function (res) {
          iframe.parentNode && iframe.parentNode.removeChild(iframe);
          return res;
        }).catch(function (res) {
          iframe.parentNode && iframe.parentNode.removeChild(iframe);
          return res;
        });
      },
      watchActive: function watchActive(active) {
        var file = void 0;
        var index = 0;
        while (file = this.files[index]) {
          index++;
          if (!file.fileObject) ; else if (active && !this.destroy) {
            if (this.uploading >= this.thread || this.uploading && !this.features.html5) {
              break;
            }
            if (!file.active && !file.error && !file.success) {
              this.update(file, { active: true });
            }
          } else {
            if (file.active) {
              this.update(file, { active: false });
            }
          }
        }
        if (this.uploading === 0) {
          this.active = false;
        }
      },
      watchDrop: function watchDrop(_el) {
        var el = _el;
        if (!this.features.drop) {
          return;
        }

        // 移除挂载
        if (this.dropElement) {
          try {
            document.removeEventListener('dragenter', this.onDragenter, false);
            document.removeEventListener('dragleave', this.onDragleave, false);
            document.removeEventListener('drop', this.onDocumentDrop, false);
            this.dropElement.removeEventListener('dragover', this.onDragover, false);
            this.dropElement.removeEventListener('drop', this.onDrop, false);
          } catch (e) {}
        }

        if (!el) {
          el = false;
        } else if (typeof el === 'string') {
          el = document.querySelector(el) || this.$root.$el.querySelector(el);
        } else if (el === true) {
          el = this.$parent.$el;
        }

        this.dropElement = el;

        if (this.dropElement) {
          document.addEventListener('dragenter', this.onDragenter, false);
          document.addEventListener('dragleave', this.onDragleave, false);
          document.addEventListener('drop', this.onDocumentDrop, false);
          this.dropElement.addEventListener('dragover', this.onDragover, false);
          this.dropElement.addEventListener('drop', this.onDrop, false);
        }
      },
      onDragenter: function onDragenter(e) {
        e.preventDefault();
        if (this.dropActive) {
          return;
        }
        if (!e.dataTransfer) {
          return;
        }
        var dt = e.dataTransfer;
        if (dt.files && dt.files.length) {
          this.dropActive = true;
        } else if (!dt.types) {
          this.dropActive = true;
        } else if (dt.types.indexOf && dt.types.indexOf('Files') !== -1) {
          this.dropActive = true;
        } else if (dt.types.contains && dt.types.contains('Files')) {
          this.dropActive = true;
        }
      },
      onDragleave: function onDragleave(e) {
        e.preventDefault();
        if (!this.dropActive) {
          return;
        }
        if (e.target.nodeName === 'HTML' || e.target === e.explicitOriginalTarget || !e.fromElement && (e.clientX <= 0 || e.clientY <= 0 || e.clientX >= window.innerWidth || e.clientY >= window.innerHeight)) {
          this.dropActive = false;
        }
      },
      onDragover: function onDragover(e) {
        e.preventDefault();
      },
      onDocumentDrop: function onDocumentDrop() {
        this.dropActive = false;
      },
      onDrop: function onDrop(e) {
        e.preventDefault();
        this.addDataTransfer(e.dataTransfer);
      }
    }
  };

  /* script */
  var __vue_script__$1 = script$1;

  /* template */
  var __vue_render__$1 = function __vue_render__() {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('span', { class: _vm.className }, [_vm._t("default"), _vm._v(" "), _c('label', { attrs: { "for": _vm.inputId || _vm.name } }), _vm._v(" "), _c('input-file')], 2);
  };
  var __vue_staticRenderFns__$1 = [];

  /* style */
  var __vue_inject_styles__$1 = function (inject) {
    if (!inject) return;
    inject("data-v-7cf02a5d_0", { source: "\n.file-uploads{overflow:hidden;position:relative;text-align:center;display:inline-block\n}\n.file-uploads.file-uploads-html4 input[type=file],.file-uploads.file-uploads-html5 label{background:#fff;opacity:0;font-size:20em;z-index:1;top:0;left:0;right:0;bottom:0;position:absolute;width:100%;height:100%\n}\n.file-uploads.file-uploads-html4 label,.file-uploads.file-uploads-html5 input[type=file]{background:rgba(255,255,255,0);overflow:hidden;position:fixed;width:1px;height:1px;z-index:-1;opacity:0\n}", map: undefined, media: undefined });
  };
  /* scoped */
  var __vue_scope_id__$1 = undefined;
  /* module identifier */
  var __vue_module_identifier__$1 = undefined;
  /* functional template */
  var __vue_is_functional_template__$1 = false;
  /* component normalizer */
  function __vue_normalize__$1(template, style, script, scope, functional, moduleIdentifier, createInjector, createInjectorSSR) {
    var component = (typeof script === 'function' ? script.options : script) || {};

    if (!component.render) {
      component.render = template.render;
      component.staticRenderFns = template.staticRenderFns;
      component._compiled = true;

      if (functional) component.functional = true;
    }

    component._scopeId = scope;

    {
      var hook = void 0;
      if (style) {
        hook = function hook(context) {
          style.call(this, createInjector(context));
        };
      }

      if (hook !== undefined) {
        if (component.functional) {
          // register for functional component in vue file
          var originalRender = component.render;
          component.render = function renderWithStyleInjection(h, context) {
            hook.call(context);
            return originalRender(h, context);
          };
        } else {
          // inject component registration as beforeCreate hook
          var existing = component.beforeCreate;
          component.beforeCreate = existing ? [].concat(existing, hook) : [hook];
        }
      }
    }

    return component;
  }
  /* style inject */
  function __vue_create_injector__$1() {
    var head = document.head || document.getElementsByTagName('head')[0];
    var styles = __vue_create_injector__$1.styles || (__vue_create_injector__$1.styles = {});
    var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\\b/.test(navigator.userAgent.toLowerCase());

    return function addStyle(id, css) {
      if (document.querySelector('style[data-vue-ssr-id~="' + id + '"]')) return; // SSR styles are present.

      var group = isOldIE ? css.media || 'default' : id;
      var style = styles[group] || (styles[group] = { ids: [], parts: [], element: undefined });

      if (!style.ids.includes(id)) {
        var code = css.source;
        var index = style.ids.length;

        style.ids.push(id);

        if (css.map) {
          // https://developer.chrome.com/devtools/docs/javascript-debugging
          // this makes source maps inside style tags work properly in Chrome
          code += '\n/*# sourceURL=' + css.map.sources[0] + ' */';
          // http://stackoverflow.com/a/26603875
          code += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(css.map)))) + ' */';
        }

        if (isOldIE) {
          style.element = style.element || document.querySelector('style[data-group=' + group + ']');
        }

        if (!style.element) {
          var el = style.element = document.createElement('style');
          el.type = 'text/css';

          if (css.media) el.setAttribute('media', css.media);
          if (isOldIE) {
            el.setAttribute('data-group', group);
            el.setAttribute('data-next-index', '0');
          }

          head.appendChild(el);
        }

        if (isOldIE) {
          index = parseInt(style.element.getAttribute('data-next-index'));
          style.element.setAttribute('data-next-index', index + 1);
        }

        if (style.element.styleSheet) {
          style.parts.push(code);
          style.element.styleSheet.cssText = style.parts.filter(Boolean).join('\n');
        } else {
          var textNode = document.createTextNode(code);
          var nodes = style.element.childNodes;
          if (nodes[index]) style.element.removeChild(nodes[index]);
          if (nodes.length) style.element.insertBefore(textNode, nodes[index]);else style.element.appendChild(textNode);
        }
      }
    };
  }
  /* style inject SSR */

  var FileUpload = __vue_normalize__$1({ render: __vue_render__$1, staticRenderFns: __vue_staticRenderFns__$1 }, __vue_inject_styles__$1, __vue_script__$1, __vue_scope_id__$1, __vue_is_functional_template__$1, __vue_module_identifier__$1, __vue_create_injector__$1, undefined);

  var FileUpload$1 = /*#__PURE__*/Object.freeze({
    default: FileUpload
  });

  var require$$0 = ( FileUpload$1 && FileUpload ) || FileUpload$1;

  var src = require$$0;

  return src;

})));
//# sourceMappingURL=vue-upload-component.js.map


/***/ }),

/***/ 761:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c(
      "div",
      {
        directives: [
          {
            name: "show",
            rawName: "v-show",
            value: _vm.$refs.upload && _vm.$refs.upload.dropActive,
            expression: "$refs.upload && $refs.upload.dropActive"
          }
        ],
        staticClass: "dvs-fixed dvs-pin",
        staticStyle: { "z-index": "9999" }
      },
      [_c("div", { staticClass: "dvs-blocker" }), _vm._v(" "), _vm._m(0)]
    ),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "dvs-m-4 dvs-flex" },
      [
        _c(
          "vue-upload",
          {
            ref: "upload",
            staticClass:
              "dvs-w-full dvs-bg-abs-white dvs-p-4 dvs-py-6 dvs-shadow dvs-rounded-sm dvs-font-bold dvs-uppercase dvs-text-xs",
            attrs: {
              "post-action":
                "/api/devise/media?directory=" + this.currentDirectory,
              headers: _vm.uploadHeaders,
              drop: true,
              multiple: true
            },
            on: {
              "input-file": _vm.inputFile,
              "input-filter": _vm.inputFilter
            },
            model: {
              value: _vm.uploadingFiles,
              callback: function($$v) {
                _vm.uploadingFiles = $$v
              },
              expression: "uploadingFiles"
            }
          },
          [_vm._v("Upload New Files")]
        )
      ],
      1
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        directives: [
          {
            name: "show",
            rawName: "v-show",
            value: _vm.uploadingFiles.length,
            expression: "uploadingFiles.length"
          }
        ],
        staticClass: "dvs-w-full"
      },
      [
        _c(
          "table",
          { staticClass: "dvs-w-full dvs-mb-4 dvs-border-collapse" },
          [
            _vm._m(1),
            _vm._v(" "),
            _vm._l(_vm.uploadingFiles, function(file) {
              return _c("tr", { key: file.id, staticClass: "dvs-border-b" }, [
                _c("td", { staticClass: "dvs-p-4" }, [
                  _c("div", { staticClass: "dvs-flex" }, [
                    _c(
                      "div",
                      {
                        staticClass:
                          "dvs-cursor-pointer dvs-flex dvs-justify-center dvs-items-center dvs-mr-2",
                        on: {
                          click: function($event) {
                            _vm.removeFileFromQueue(file)
                          }
                        }
                      },
                      [_c("close-icon", { attrs: { w: "40", h: "40" } })],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass: "dvs-bg-cover dvs-bg-center",
                        style:
                          "width:40px;height:40px;background-image:url(" +
                          file.thumb +
                          ")"
                      },
                      [
                        !file.thumb
                          ? _c("span", [_vm._v("No Image")])
                          : _vm._e()
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "dvs-ml-4 dvs-text-sm dvs-font-normal" },
                      [_vm._v(_vm._s(file.name))]
                    )
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "dvs-bg-grey dvs-w-full dvs-mt-4 dvs-flex dvs-items-center",
                      staticStyle: { height: "5px" }
                    },
                    [
                      _c("div", {
                        staticStyle: { height: "3px" },
                        style: {
                          background: _vm.theme.actionButton.background,
                          width: file.progress + "%"
                        }
                      })
                    ]
                  )
                ])
              ])
            })
          ],
          2
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            directives: [
              {
                name: "show",
                rawName: "v-show",
                value: !_vm.$refs.upload || !_vm.$refs.upload.active,
                expression: "!$refs.upload || !$refs.upload.active"
              }
            ],
            staticClass: "dvs-btn",
            style: _vm.theme.actionButton,
            attrs: { type: "button" },
            on: {
              click: function($event) {
                $event.preventDefault()
                _vm.$refs.upload.active = true
              }
            }
          },
          [_vm._v("Start upload")]
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            directives: [
              {
                name: "show",
                rawName: "v-show",
                value: _vm.$refs.upload && _vm.$refs.upload.active,
                expression: "$refs.upload && $refs.upload.active"
              }
            ],
            staticClass: "dvs-btn",
            style: _vm.theme.actionButtonGhost,
            attrs: { type: "button" },
            on: {
              click: function($event) {
                $event.preventDefault()
                _vm.$refs.upload.active = false
              }
            }
          },
          [_vm._v("Stop upload")]
        )
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      {
        staticClass:
          "dvs-flex dvs-justify-center dvs-items-center dvs-relative",
        staticStyle: { "z-index": "9999" }
      },
      [
        _c(
          "div",
          { staticClass: "dvs-bg-black dvs-p-8 dvs-rounded dvs-shadow" },
          [
            _c("h3", { staticClass: "dvs-text-abs-white" }, [
              _vm._v("Drop files to upload")
            ])
          ]
        )
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", { staticClass: "dvs-border-b-2" }, [
      _c(
        "th",
        { staticClass: "dvs-p-2 dvs-text-xs dvs-uppercase dvs-text-left" },
        [_vm._v("Queued Files for Upload")]
      )
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-3a7b1c83", module.exports)
  }
}

/***/ }),

/***/ 762:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(763)
/* template */
var __vue_template__ = __webpack_require__(764)
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
Component.options.__file = "src/components/media-manager/Breadcrumbs.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0f7f4b85", Component.options)
  } else {
    hotAPI.reload("data-v-0f7f4b85", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 763:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
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
    chooseDirectory: function chooseDirectory(directory) {
      this.$emit('chooseDirectory', directory);
    },
    goToHome: function goToHome() {
      this.chooseDirectory('');
    }
  },
  computed: {
    directoriesObj: function directoriesObj() {
      var directoriesObj = {};
      var directoriesStr = '';
      var directoriesArr = this.currentDirectory.split('.');

      for (var i = 0; i < directoriesArr.length; i++) {
        directoriesStr += directoriesArr[i];
        directoriesObj[directoriesStr] = directoriesArr[i];
        directoriesStr += '.';
      }

      return directoriesObj;
    }
  },
  props: ['currentDirectory']
});

/***/ }),

/***/ 764:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "dvs-w-full dvs-flex dvs-flex-wrap dvs-items-center" },
    [
      _vm.currentDirectory !== ""
        ? [
            _c(
              "span",
              {
                staticClass: "dvs-cursor-pointer dvs-mr-1 dvs-mb-1",
                on: {
                  click: function($event) {
                    _vm.goToHome()
                  }
                }
              },
              [_vm._v("Home")]
            ),
            _vm._v(" "),
            _vm._l(_vm.directoriesObj, function(dir, key) {
              return [
                _c("span", { staticClass: "dvs-mr-1 dvs-mb-1" }, [_vm._v(">")]),
                _vm._v(" "),
                _c(
                  "span",
                  {
                    staticClass: "dvs-cursor-pointer dvs-mr-1 dvs-mb-1",
                    on: {
                      click: function($event) {
                        _vm.chooseDirectory(key)
                      }
                    }
                  },
                  [_vm._v(_vm._s(dir))]
                )
              ]
            })
          ]
        : _vm._e()
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-0f7f4b85", module.exports)
  }
}

/***/ }),

/***/ 765:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(766)
/* template */
var __vue_template__ = __webpack_require__(767)
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
Component.options.__file = "node_modules/vue-ionicons/dist/ios-folder.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-ac355cb0", Component.options)
  } else {
    hotAPI.reload("data-v-ac355cb0", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 766:
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
  name: "ios-folder-icon",
  mixins: [__WEBPACK_IMPORTED_MODULE_0__ionicons_mixin__["a" /* default */]],
  data: function data() {
    var iconTitle = this.title ? this.title : "Ios Folder Icon";
    return {
      iconTitle: iconTitle
    };
  }
});

/***/ }),

/***/ 767:
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
      attrs: { title: _vm.iconTitle, name: "ios-folder-icon" }
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
                "M480 119c0-13.3-9.4-23-22.8-23H198.9c-2.8 0-4.3-.6-6.1-2.4l-22.5-22.5-.2-.2c-4.9-4.6-8.9-6.9-17.3-6.9H56.7C42.9 64 32 74.3 32 87v73.7c0 1.6 1.7 1.5 3 .7s5-1.4 7-1.4h428c2 0 5.7.6 7 1.4 1.3.8 3 .9 3-.7V119zM32 416.4c0 17.5 14.2 31.6 31.6 31.6H448c17.6 0 32-14.4 32-32V204c0-8.8-7.2-16-16-16H48c-8.8 0-16 7.2-16 16v212.4z"
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
    require("vue-hot-reload-api")      .rerender("data-v-ac355cb0", module.exports)
  }
}

/***/ }),

/***/ 768:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(769)
/* template */
var __vue_template__ = __webpack_require__(770)
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
Component.options.__file = "node_modules/vue-ionicons/dist/md-attach.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-aa85e79e", Component.options)
  } else {
    hotAPI.reload("data-v-aa85e79e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 769:
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
  name: "md-attach-icon",
  mixins: [__WEBPACK_IMPORTED_MODULE_0__ionicons_mixin__["a" /* default */]],
  data: function data() {
    var iconTitle = this.title ? this.title : "Md Attach Icon";
    return {
      iconTitle: iconTitle
    };
  }
});

/***/ }),

/***/ 770:
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
      attrs: { title: _vm.iconTitle, name: "md-attach-icon" }
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
                "M341.334 128v234.666C341.334 409.604 302.938 448 256 448c-46.937 0-85.333-38.396-85.333-85.334V117.334C170.667 87.469 194.135 64 224 64c29.864 0 53.333 23.469 53.333 53.334v245.333c0 11.729-9.605 21.333-21.334 21.333s-21.333-9.604-21.333-21.333V160h-32v202.667C202.667 392.531 226.135 416 256 416c29.865 0 53.334-23.469 53.334-53.333V117.334C309.334 70.401 270.938 32 224 32s-85.334 38.401-85.334 85.334v245.332C138.667 427.729 190.938 480 256 480c65.062 0 117.334-52.271 117.334-117.334V128h-32z"
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
    require("vue-hot-reload-api")      .rerender("data-v-aa85e79e", module.exports)
  }
}

/***/ }),

/***/ 771:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(772)
/* template */
var __vue_template__ = __webpack_require__(773)
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
Component.options.__file = "node_modules/vue-ionicons/dist/ios-link.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-94bf8098", Component.options)
  } else {
    hotAPI.reload("data-v-94bf8098", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 772:
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
  name: "ios-link-icon",
  mixins: [__WEBPACK_IMPORTED_MODULE_0__ionicons_mixin__["a" /* default */]],
  data: function data() {
    var iconTitle = this.title ? this.title : "Ios Link Icon";
    return {
      iconTitle: iconTitle
    };
  }
});

/***/ }),

/***/ 773:
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
      attrs: { title: _vm.iconTitle, name: "ios-link-icon" }
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
                "M280 341.1l-1.2.1c-3.6.4-7 2-9.6 4.5l-64.6 64.6c-13.7 13.7-32 21.2-51.5 21.2s-37.8-7.5-51.5-21.2c-13.7-13.7-21.2-32-21.2-51.5s7.5-37.8 21.2-51.5l68.6-68.6c3.5-3.5 7.3-6.6 11.4-9.3 4.6-3 9.6-5.6 14.8-7.5 4.8-1.8 9.9-3 15-3.7 3.4-.5 6.9-.7 10.2-.7 1.4 0 2.8.1 4.6.2 17.7 1.1 34.4 8.6 46.8 21 7.7 7.7 13.6 17.1 17.1 27.3 2.8 8 11.2 12.5 19.3 10.1.1 0 .2-.1.3-.1.1 0 .2 0 .2-.1 8.1-2.5 12.8-11 10.5-19.1-4.4-15.6-12.2-28.7-24.6-41-15.6-15.6-35.9-25.8-57.6-29.3-1.9-.3-3.8-.6-5.7-.8-3.7-.4-7.4-.6-11.1-.6-2.6 0-5.2.1-7.7.3-5.4.4-10.8 1.2-16.2 2.5-1.1.2-2.1.5-3.2.8-6.7 1.8-13.3 4.2-19.5 7.3-10.3 5.1-19.6 11.7-27.7 19.9l-68.6 68.6C58.9 304.4 48 330.8 48 359c0 28.2 10.9 54.6 30.7 74.4C98.5 453.1 124.9 464 153 464c28.2 0 54.6-10.9 74.4-30.7l65.3-65.3c10.4-10.5 2-28.3-12.7-26.9z"
            }
          }),
          _c("path", {
            attrs: {
              d:
                "M433.3 78.7C413.5 58.9 387.1 48 359 48s-54.6 10.9-74.4 30.7l-63.7 63.7c-9.7 9.7-3.6 26.3 10.1 27.4 4.7.4 9.3-1.3 12.7-4.6l63.8-63.6c13.7-13.7 32-21.2 51.5-21.2s37.8 7.5 51.5 21.2c13.7 13.7 21.2 32 21.2 51.5s-7.5 37.8-21.2 51.5l-68.6 68.6c-3.5 3.5-7.3 6.6-11.4 9.3-4.6 3-9.6 5.6-14.8 7.5-4.8 1.8-9.9 3-15 3.7-3.4.5-6.9.7-10.2.7-1.4 0-2.9-.1-4.6-.2-17.7-1.1-34.4-8.6-46.8-21-7.3-7.3-12.8-16-16.4-25.5-2.9-7.7-11.1-11.9-19.1-9.8-8.9 2.3-14.1 11.7-11.3 20.5 4.5 14 12.1 25.9 23.7 37.5l.2.2c16.9 16.9 39.4 27.6 63.3 30.1 3.7.4 7.4.6 11.1.6 2.6 0 5.2-.1 7.8-.3 6.5-.5 13-1.6 19.3-3.2 6.7-1.8 13.3-4.2 19.5-7.3 10.3-5.1 19.6-11.7 27.7-19.9l68.6-68.6c19.8-19.8 30.7-46.2 30.7-74.4s-11.1-54.6-30.9-74.4z"
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
    require("vue-hot-reload-api")      .rerender("data-v-94bf8098", module.exports)
  }
}

/***/ }),

/***/ 774:
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
 * JavaScript Cookie v2.2.0
 * https://github.com/js-cookie/js-cookie
 *
 * Copyright 2006, 2015 Klaus Hartl & Fagner Brack
 * Released under the MIT license
 */
;(function (factory) {
	var registeredInModuleLoader = false;
	if (true) {
		!(__WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) :
				__WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
		registeredInModuleLoader = true;
	}
	if (true) {
		module.exports = factory();
		registeredInModuleLoader = true;
	}
	if (!registeredInModuleLoader) {
		var OldCookies = window.Cookies;
		var api = window.Cookies = factory();
		api.noConflict = function () {
			window.Cookies = OldCookies;
			return api;
		};
	}
}(function () {
	function extend () {
		var i = 0;
		var result = {};
		for (; i < arguments.length; i++) {
			var attributes = arguments[ i ];
			for (var key in attributes) {
				result[key] = attributes[key];
			}
		}
		return result;
	}

	function init (converter) {
		function api (key, value, attributes) {
			var result;
			if (typeof document === 'undefined') {
				return;
			}

			// Write

			if (arguments.length > 1) {
				attributes = extend({
					path: '/'
				}, api.defaults, attributes);

				if (typeof attributes.expires === 'number') {
					var expires = new Date();
					expires.setMilliseconds(expires.getMilliseconds() + attributes.expires * 864e+5);
					attributes.expires = expires;
				}

				// We're using "expires" because "max-age" is not supported by IE
				attributes.expires = attributes.expires ? attributes.expires.toUTCString() : '';

				try {
					result = JSON.stringify(value);
					if (/^[\{\[]/.test(result)) {
						value = result;
					}
				} catch (e) {}

				if (!converter.write) {
					value = encodeURIComponent(String(value))
						.replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent);
				} else {
					value = converter.write(value, key);
				}

				key = encodeURIComponent(String(key));
				key = key.replace(/%(23|24|26|2B|5E|60|7C)/g, decodeURIComponent);
				key = key.replace(/[\(\)]/g, escape);

				var stringifiedAttributes = '';

				for (var attributeName in attributes) {
					if (!attributes[attributeName]) {
						continue;
					}
					stringifiedAttributes += '; ' + attributeName;
					if (attributes[attributeName] === true) {
						continue;
					}
					stringifiedAttributes += '=' + attributes[attributeName];
				}
				return (document.cookie = key + '=' + value + stringifiedAttributes);
			}

			// Read

			if (!key) {
				result = {};
			}

			// To prevent the for loop in the first place assign an empty array
			// in case there are no cookies at all. Also prevents odd result when
			// calling "get()"
			var cookies = document.cookie ? document.cookie.split('; ') : [];
			var rdecode = /(%[0-9A-Z]{2})+/g;
			var i = 0;

			for (; i < cookies.length; i++) {
				var parts = cookies[i].split('=');
				var cookie = parts.slice(1).join('=');

				if (!this.json && cookie.charAt(0) === '"') {
					cookie = cookie.slice(1, -1);
				}

				try {
					var name = parts[0].replace(rdecode, decodeURIComponent);
					cookie = converter.read ?
						converter.read(cookie, name) : converter(cookie, name) ||
						cookie.replace(rdecode, decodeURIComponent);

					if (this.json) {
						try {
							cookie = JSON.parse(cookie);
						} catch (e) {}
					}

					if (key === name) {
						result = cookie;
						break;
					}

					if (!key) {
						result[name] = cookie;
					}
				} catch (e) {}
			}

			return result;
		}

		api.set = api;
		api.get = function (key) {
			return api.call(api, key);
		};
		api.getJSON = function () {
			return api.apply({
				json: true
			}, [].slice.call(arguments));
		};
		api.defaults = {};

		api.remove = function (key, attributes) {
			api(key, '', extend(attributes, {
				expires: -1
			}));
		};

		api.withConverter = init;

		return api;
	}

	return init(function () {});
}));


/***/ }),

/***/ 775:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.show
    ? _c(
        "div",
        {
          staticClass:
            "dvs-min-h-screen dvs-fixed dvs-pin dvs-z-60 dvs-text-grey-darker",
          class: { "dvs-pointer-events-none": !_vm.loaded }
        },
        [
          _c("div", {
            staticClass: "dvs-blocker dvs-z-30",
            on: {
              click: function($event) {
                _vm.show = false
              }
            }
          }),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "media-manager dvs-min-w-4/5" },
            [
              !_vm.loaded
                ? _c("div", { staticClass: "media-manager-interface" }, [
                    _c(
                      "div",
                      {
                        staticClass:
                          "dvs-absolute dvs-absolute-center dvs-w-1/2"
                      },
                      [_c("loadbar", { attrs: { percentage: 0.5 } })],
                      1
                    )
                  ])
                : _vm.loaded && _vm.selectedFile === null
                ? _c("div", { staticClass: "media-manager-interface" }, [
                    _c(
                      "div",
                      {
                        staticClass:
                          "dvs-py-4 dvs-px-8 dvs-rounded-tl dvs-rounded-tr dvs-flex dvs-justify-between dvs-items-center dvs-bg-grey-lighter dvs-border-b dvs-border-lighter dvs-relative",
                        staticStyle: { "min-height": "70px" }
                      },
                      [
                        _c("div", [
                          _c("div", { staticClass: "dvs-font-bold" }, [
                            _vm._v("Media Manager")
                          ]),
                          _vm._v(" "),
                          _vm.currentDirectory !== ""
                            ? _c(
                                "div",
                                {
                                  staticClass:
                                    "dvs-flex dvs-mt-2 dvs-justify-between dvs-items-center dvs-font-mono dvs-text-sm dvs-tracking-tight"
                                },
                                [
                                  _c("breadcrumbs", {
                                    attrs: {
                                      currentDirectory: _vm.currentDirectory
                                    },
                                    on: {
                                      chooseDirectory: _vm.changeDirectories
                                    }
                                  })
                                ],
                                1
                              )
                            : _vm._e()
                        ]),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "dvs-flex dvs-items-center" },
                          [
                            _c(
                              "fieldset",
                              { staticClass: "dvs-fieldset dvs-mr-8" },
                              [
                                _c(
                                  "div",
                                  { staticClass: "dvs-flex dvs-items-center" },
                                  [
                                    _c(
                                      "label",
                                      { staticClass: "dvs-mr-2 dvs-my-2" },
                                      [_vm._v("Remember Location?")]
                                    ),
                                    _vm._v(" "),
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.cookieSettings,
                                          expression: "cookieSettings"
                                        }
                                      ],
                                      staticClass: "dvs-my-2",
                                      attrs: { type: "checkbox" },
                                      domProps: {
                                        checked: Array.isArray(
                                          _vm.cookieSettings
                                        )
                                          ? _vm._i(_vm.cookieSettings, null) >
                                            -1
                                          : _vm.cookieSettings
                                      },
                                      on: {
                                        change: function($event) {
                                          var $$a = _vm.cookieSettings,
                                            $$el = $event.target,
                                            $$c = $$el.checked ? true : false
                                          if (Array.isArray($$a)) {
                                            var $$v = null,
                                              $$i = _vm._i($$a, $$v)
                                            if ($$el.checked) {
                                              $$i < 0 &&
                                                (_vm.cookieSettings = $$a.concat(
                                                  [$$v]
                                                ))
                                            } else {
                                              $$i > -1 &&
                                                (_vm.cookieSettings = $$a
                                                  .slice(0, $$i)
                                                  .concat($$a.slice($$i + 1)))
                                            }
                                          } else {
                                            _vm.cookieSettings = $$c
                                          }
                                        }
                                      }
                                    })
                                  ]
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "fieldset",
                              { staticClass: "dvs-fieldset dvs-mr-8" },
                              [
                                _c(
                                  "div",
                                  { staticClass: "dvs-flex dvs-items-center" },
                                  [
                                    _c(
                                      "label",
                                      { staticClass: "dvs-mr-2 dvs-my-2" },
                                      [_vm._v("Contact Sheet")]
                                    ),
                                    _vm._v(" "),
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.mode,
                                          expression: "mode"
                                        }
                                      ],
                                      staticClass: "dvs-my-2",
                                      attrs: {
                                        type: "radio",
                                        value: "contactSheet"
                                      },
                                      domProps: {
                                        checked: _vm._q(
                                          _vm.mode,
                                          "contactSheet"
                                        )
                                      },
                                      on: {
                                        change: function($event) {
                                          _vm.mode = "contactSheet"
                                        }
                                      }
                                    })
                                  ]
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "fieldset",
                              { staticClass: "dvs-fieldset dvs-mr-8" },
                              [
                                _c(
                                  "div",
                                  { staticClass: "dvs-flex dvs-items-center" },
                                  [
                                    _c(
                                      "label",
                                      { staticClass: "dvs-mr-2 dvs-my-2" },
                                      [_vm._v("Thumbnails")]
                                    ),
                                    _vm._v(" "),
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.mode,
                                          expression: "mode"
                                        }
                                      ],
                                      staticClass: "dvs-my-2",
                                      attrs: {
                                        type: "radio",
                                        value: "thumbnails"
                                      },
                                      domProps: {
                                        checked: _vm._q(_vm.mode, "thumbnails")
                                      },
                                      on: {
                                        change: function($event) {
                                          _vm.mode = "thumbnails"
                                        }
                                      }
                                    })
                                  ]
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c("fieldset", { staticClass: "dvs-fieldset" }, [
                              _c(
                                "div",
                                { staticClass: "dvs-flex dvs-items-center" },
                                [
                                  _c(
                                    "label",
                                    { staticClass: "dvs-mr-2 dvs-my-2" },
                                    [_vm._v("List")]
                                  ),
                                  _vm._v(" "),
                                  _c("input", {
                                    directives: [
                                      {
                                        name: "model",
                                        rawName: "v-model",
                                        value: _vm.mode,
                                        expression: "mode"
                                      }
                                    ],
                                    staticClass: "dvs-my-2",
                                    attrs: { type: "radio", value: "list" },
                                    domProps: {
                                      checked: _vm._q(_vm.mode, "list")
                                    },
                                    on: {
                                      change: function($event) {
                                        _vm.mode = "list"
                                      }
                                    }
                                  })
                                ]
                              )
                            ])
                          ]
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "dvs-flex dvs-items-stretch dvs-h-full" },
                      [
                        _c(
                          "div",
                          {
                            staticClass: "dvs-min-w-1/3",
                            attrs: { "data-simplebar": "" }
                          },
                          [
                            _c(
                              "div",
                              {
                                staticClass:
                                  "dvs-h-full dvs-p-8 dvs-bg-grey-lightest dvs-flex dvs-flex-col dvs-justify-between dvs-border-r dvs-border-lighter"
                              },
                              [
                                _c(
                                  "form",
                                  {
                                    on: {
                                      submit: function($event) {
                                        $event.preventDefault()
                                        return _vm.search($event)
                                      }
                                    }
                                  },
                                  [
                                    _c("div", { staticClass: "mb-8 flex" }, [
                                      _c(
                                        "fieldset",
                                        { staticClass: "dvs-fieldset mr-2" },
                                        [
                                          _c("input", {
                                            directives: [
                                              {
                                                name: "model",
                                                rawName: "v-model",
                                                value: _vm.searchTerms,
                                                expression: "searchTerms"
                                              }
                                            ],
                                            staticClass: "mr-2",
                                            attrs: {
                                              type: "text",
                                              placeholder: "Search"
                                            },
                                            domProps: {
                                              value: _vm.searchTerms
                                            },
                                            on: {
                                              input: function($event) {
                                                if ($event.target.composing) {
                                                  return
                                                }
                                                _vm.searchTerms =
                                                  $event.target.value
                                              }
                                            }
                                          })
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "button",
                                        {
                                          staticClass: "dvs-btn dvs-btn-sm",
                                          style: _vm.theme.actionButton,
                                          attrs: { type: "submit" }
                                        },
                                        [_vm._v("Search")]
                                      )
                                    ])
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "ul",
                                  {
                                    staticClass:
                                      "dvs-list-reset dvs-mb-10 dvs-font-mono dvs-text-sm dvs-tracking-tight"
                                  },
                                  [
                                    _vm._l(_vm.directories, function(
                                      directory
                                    ) {
                                      return _c(
                                        "li",
                                        {
                                          key: directory.id,
                                          staticClass:
                                            "dvs-cursor-pointer dvs-mt-2 dvs-text-bold",
                                          on: {
                                            click: function($event) {
                                              _vm.changeDirectories(
                                                directory.path
                                              )
                                            }
                                          }
                                        },
                                        [
                                          _c("folder-icon", {
                                            staticClass: "dvs-mr-2"
                                          }),
                                          _vm._v(
                                            "\n                " +
                                              _vm._s(directory.name) +
                                              "\n              "
                                          )
                                        ],
                                        1
                                      )
                                    }),
                                    _vm._v(" "),
                                    _vm.directories.length < 1
                                      ? _c("li", [
                                          _vm._v(
                                            "No directories within this directory"
                                          )
                                        ])
                                      : _vm._e()
                                  ],
                                  2
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  { staticClass: "dvs-flex dvs-flex-col" },
                                  [
                                    _c(
                                      "fieldset",
                                      { staticClass: "dvs-fieldset dvs-mb-4" },
                                      [
                                        _c("input", {
                                          directives: [
                                            {
                                              name: "model",
                                              rawName: "v-model",
                                              value: _vm.directoryToCreate,
                                              expression: "directoryToCreate"
                                            }
                                          ],
                                          staticClass: "mr-2",
                                          attrs: {
                                            type: "text",
                                            placeholder: "New Directory"
                                          },
                                          domProps: {
                                            value: _vm.directoryToCreate
                                          },
                                          on: {
                                            input: function($event) {
                                              if ($event.target.composing) {
                                                return
                                              }
                                              _vm.directoryToCreate =
                                                $event.target.value
                                            }
                                          }
                                        })
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "button",
                                      {
                                        staticClass: "dvs-btn dvs-btn-sm",
                                        style: _vm.theme.actionButton,
                                        on: {
                                          click: function($event) {
                                            _vm.requestCreateDirectory()
                                          }
                                        }
                                      },
                                      [_vm._v("Create")]
                                    )
                                  ]
                                )
                              ]
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          {
                            staticClass:
                              "dvs-flex-grow dvs-relative dvs-overflow-y-scroll dvs-p-4",
                            class: { "w-full": _vm.directories.length < 1 }
                          },
                          [
                            _vm.searchResults.length > 0
                              ? _c("div", { staticClass: "dvs-p-8 dvs-flex" }, [
                                  _c("h4", [
                                    _vm._v(
                                      "\n              Showing up to " +
                                        _vm._s(_vm.searchResultsLimit) +
                                        " results for:\n              "
                                    ),
                                    _c("strong", [
                                      _vm._v(_vm._s(_vm.searchTerms))
                                    ])
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    { on: { click: _vm.closeSearch } },
                                    [
                                      _c("close-icon", {
                                        staticClass:
                                          "dvs-ml-2 dvs-cursor-pointer",
                                        attrs: { w: "30", h: "30" }
                                      })
                                    ],
                                    1
                                  )
                                ])
                              : _vm.searchableMedia.data.length > 0 &&
                                _vm.searchTerms !== null &&
                                _vm.searchTerms !== ""
                              ? _c("div", { staticClass: "dvs-p-8 dvs-flex" }, [
                                  _c("h4", [
                                    _vm._v(
                                      '\n              Hit "Search" for results of:\n              '
                                    ),
                                    _c("strong", [
                                      _vm._v(_vm._s(_vm.searchTerms))
                                    ])
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    { on: { click: _vm.closeSearch } },
                                    [
                                      _c("close-icon", {
                                        staticClass:
                                          "dvs-ml-2 dvs-cursor-pointer",
                                        attrs: { w: "30", h: "30" }
                                      })
                                    ],
                                    1
                                  )
                                ])
                              : _vm._e(),
                            _vm._v(" "),
                            _c("uploader", {
                              attrs: {
                                "current-directory": _vm.currentDirectory
                              },
                              on: { "all-files-uploaded": _vm.refreshDirectory }
                            }),
                            _vm._v(" "),
                            _vm.currentFiles.length < 1 &&
                            _vm.directories.length < 1 &&
                            _vm.currentDirectory !== ""
                              ? _c(
                                  "div",
                                  {
                                    staticClass:
                                      "dvs-flex dvs-justify-center dvs-items-center dvs-absolute dvs-absolute-center"
                                  },
                                  [
                                    _c(
                                      "div",
                                      {
                                        staticClass:
                                          "dvs-bg-white dvs-text-grey-dark dvs-rounded dvs-p-8 dvs--mt-15 dvs-text-center dvs-shadow dvs-cursor-pointer",
                                        on: {
                                          click: function($event) {
                                            _vm.requestDeleteDirectory()
                                          }
                                        }
                                      },
                                      [
                                        _c("trash-icon", {
                                          style: {
                                            color: _vm.theme.panel.color
                                          },
                                          attrs: { h: "40", w: "40" }
                                        }),
                                        _vm._v(" "),
                                        _c(
                                          "h6",
                                          {
                                            staticClass: "dvs-mt-2 dvs-text-sm"
                                          },
                                          [_vm._v("Delete this directory")]
                                        )
                                      ],
                                      1
                                    )
                                  ]
                                )
                              : _vm._e(),
                            _vm._v(" "),
                            _vm.currentFiles.length < 1 &&
                            _vm.directories.length > 0 &&
                            _vm.currentDirectory !== ""
                              ? _c(
                                  "div",
                                  {
                                    staticClass:
                                      "dvs-flex dvs-justify-center dvs-items-center dvs-absolute dvs-absolute-center"
                                  },
                                  [
                                    _c(
                                      "div",
                                      {
                                        staticClass:
                                          "dvs-bg-white dvs-rounded dvs-p-8 dvs--mt-15 dvs-text-center dvs-shadow"
                                      },
                                      [
                                        _c("folder-icon", {
                                          style: {
                                            color: _vm.theme.panel.color
                                          },
                                          attrs: { h: "40", w: "40" }
                                        }),
                                        _vm._v(" "),
                                        _vm._m(0)
                                      ],
                                      1
                                    )
                                  ]
                                )
                              : _c(
                                  "ul",
                                  {
                                    staticClass:
                                      "dvs-list-reset dvs-flex dvs-justify-center dvs-flex-wrap dvs-p-4"
                                  },
                                  _vm._l(_vm.currentFiles, function(file) {
                                    return _c(
                                      "li",
                                      {
                                        key: file.id,
                                        staticClass:
                                          "dvs-relative dvs-bg-white dvs-card dvs-mt-2",
                                        class: {
                                          "dvs-cursor-pointer": !file.on,
                                          "dvs-border-b dvs-border-lighter dvs-p-2 dvs-mx-4":
                                            _vm.mode === "thumbnails",
                                          "dvs-p-0 dvs-mb-4":
                                            _vm.mode !== "thumbnails",
                                          "dvs-mx-2":
                                            _vm.mode === "contactSheet",
                                          "dvs-w-full": _vm.mode === "list"
                                        },
                                        on: {
                                          click: function($event) {
                                            _vm.openFile(file)
                                          }
                                        }
                                      },
                                      [
                                        file === _vm.currentlyOpenFile
                                          ? _c(
                                              "div",
                                              {
                                                on: {
                                                  click: function($event) {
                                                    $event.stopPropagation()
                                                    $event.preventDefault()
                                                    _vm.closeFile(file)
                                                  }
                                                }
                                              },
                                              [
                                                _c("close-icon", {
                                                  staticClass:
                                                    "dvs-absolute dvs-pin-t dvs-pin-r dvs-mt-4 dvs-mr-4 dvs-cursor-pointer",
                                                  attrs: { w: "30", h: "30" }
                                                })
                                              ],
                                              1
                                            )
                                          : _vm._e(),
                                        _vm._v(" "),
                                        file !== _vm.currentlyOpenFile
                                          ? _c(
                                              "div",
                                              {
                                                staticClass:
                                                  "dvs-overflow-hidden"
                                              },
                                              [
                                                _vm.mode === "contactSheet"
                                                  ? _c(
                                                      "div",
                                                      {
                                                        staticClass:
                                                          "dvs-overflow-hidden dvs-text-center",
                                                        staticStyle: {
                                                          width: "100px",
                                                          height: "105px"
                                                        }
                                                      },
                                                      [
                                                        _c("img", {
                                                          staticStyle: {
                                                            "min-width": "75px",
                                                            height: "75px"
                                                          },
                                                          attrs: {
                                                            src:
                                                              "/styled/preview/" +
                                                              file.url +
                                                              "?w=100&h=100"
                                                          }
                                                        }),
                                                        _vm._v(" "),
                                                        _c(
                                                          "div",
                                                          {
                                                            staticClass:
                                                              "dvs-text-xs dvs-font-bold dvs-px-2"
                                                          },
                                                          [
                                                            _vm._v(
                                                              _vm._s(file.name)
                                                            )
                                                          ]
                                                        )
                                                      ]
                                                    )
                                                  : _vm.mode === "thumbnails"
                                                  ? _c(
                                                      "div",
                                                      {
                                                        staticClass:
                                                          "dvs-grid-preview dvs-font-bold dvs-relative",
                                                        style:
                                                          "background-size:cover;background-image:url('" +
                                                          ("/styled/preview/" +
                                                            file.url +
                                                            "?w=200&h=200") +
                                                          "')"
                                                      },
                                                      [
                                                        _c(
                                                          "div",
                                                          {
                                                            staticClass:
                                                              "dvs-text-center dvs-absolute dvs-pin-b dvs-pin-l dvs-pin-r dvs-text-white dvs-p-4",
                                                            staticStyle: {
                                                              "text-shadow":
                                                                "2px 2px 2px rgba(0,0,0,0.5)",
                                                              "background-color":
                                                                "rgba(0,0,0,0.4)"
                                                            }
                                                          },
                                                          [
                                                            _vm._v(
                                                              _vm._s(file.name)
                                                            )
                                                          ]
                                                        )
                                                      ]
                                                    )
                                                  : _c(
                                                      "div",
                                                      {
                                                        staticClass:
                                                          "dvs-w-full dvs-flex dvs-items-center"
                                                      },
                                                      [
                                                        _c("img", {
                                                          staticStyle: {
                                                            "min-width": "75px",
                                                            height: "75px"
                                                          },
                                                          attrs: {
                                                            src:
                                                              "/styled/preview/" +
                                                              file.url +
                                                              "?w=100&h=100"
                                                          }
                                                        }),
                                                        _vm._v(" "),
                                                        _c(
                                                          "div",
                                                          {
                                                            staticClass:
                                                              "dvs-px-4 dvs-font-bold"
                                                          },
                                                          [
                                                            _vm._v(
                                                              _vm._s(file.name)
                                                            )
                                                          ]
                                                        )
                                                      ]
                                                    )
                                              ]
                                            )
                                          : _c(
                                              "div",
                                              {
                                                staticClass:
                                                  "dvs-flex dvs-p-4 dvs-overflow-hidden"
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass:
                                                      "dvs-w-1/2 dvs-mr-8 dvs-flex dvs-flex-col dvs-justify-between"
                                                  },
                                                  [
                                                    _c("img", {
                                                      staticClass:
                                                        "dvs-cursor-pointer dvs-mb-4",
                                                      attrs: {
                                                        src:
                                                          "/styled/preview/" +
                                                          file.url +
                                                          "?w=500&h=500"
                                                      }
                                                    }),
                                                    _vm._v(" "),
                                                    _c(
                                                      "div",
                                                      {
                                                        staticClass: "dvs-flex"
                                                      },
                                                      [
                                                        _c(
                                                          "div",
                                                          {
                                                            directives: [
                                                              {
                                                                name:
                                                                  "devise-alert-confirm",
                                                                rawName:
                                                                  "v-devise-alert-confirm",
                                                                value: {
                                                                  callback:
                                                                    _vm.confirmedDeleteFile,
                                                                  arguments: file,
                                                                  message:
                                                                    "Are you sure you want to delete this media?"
                                                                },
                                                                expression:
                                                                  "{callback: confirmedDeleteFile, arguments: file, message: 'Are you sure you want to delete this media?'}"
                                                              }
                                                            ],
                                                            staticClass:
                                                              "dvs-mr-4 dvs-cursor-pointer",
                                                            style: {
                                                              color:
                                                                _vm.theme
                                                                  .actionButton
                                                                  .background
                                                            }
                                                          },
                                                          [
                                                            _c("trash-icon", {
                                                              attrs: {
                                                                h: "20",
                                                                w: "20"
                                                              }
                                                            })
                                                          ],
                                                          1
                                                        ),
                                                        _vm._v(" "),
                                                        _c(
                                                          "a",
                                                          {
                                                            style: {
                                                              color:
                                                                _vm.theme
                                                                  .actionButton
                                                                  .background
                                                            },
                                                            attrs: {
                                                              href: "file.url",
                                                              target: "_blank"
                                                            }
                                                          },
                                                          [
                                                            _c("link-icon", {
                                                              attrs: {
                                                                h: "20",
                                                                w: "20"
                                                              }
                                                            })
                                                          ],
                                                          1
                                                        )
                                                      ]
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "div",
                                                  { staticClass: "dvs-w-1/2" },
                                                  [
                                                    _c(
                                                      "h6",
                                                      {
                                                        staticClass:
                                                          "dvs-text-xs dvs-uppercase dvs-mb-1"
                                                      },
                                                      [_vm._v("Filename")]
                                                    ),
                                                    _vm._v(" "),
                                                    _c(
                                                      "p",
                                                      {
                                                        staticClass:
                                                          "dvs-text-sm"
                                                      },
                                                      [
                                                        _vm._v(
                                                          _vm._s(file.name)
                                                        )
                                                      ]
                                                    ),
                                                    _vm._v(" "),
                                                    _c(
                                                      "fieldset",
                                                      {
                                                        staticClass:
                                                          "dvs-fieldset dvs-mb-4"
                                                      },
                                                      [
                                                        _c(
                                                          "label",
                                                          {
                                                            staticClass:
                                                              "dvs-text-xs dvs-uppercase dvs-mb-1"
                                                          },
                                                          [_vm._v("URL")]
                                                        ),
                                                        _vm._v(" "),
                                                        _c("input", {
                                                          attrs: {
                                                            type: "text"
                                                          },
                                                          domProps: {
                                                            value: file.url
                                                          }
                                                        })
                                                      ]
                                                    ),
                                                    _vm._v(" "),
                                                    _vm.callback
                                                      ? _c("p", [
                                                          _c(
                                                            "button",
                                                            {
                                                              staticClass:
                                                                "dvs-btn",
                                                              style:
                                                                _vm.theme
                                                                  .actionButton,
                                                              on: {
                                                                click: function(
                                                                  $event
                                                                ) {
                                                                  _vm.selectSourceFile(
                                                                    file
                                                                  )
                                                                }
                                                              }
                                                            },
                                                            [_vm._v("Select")]
                                                          )
                                                        ])
                                                      : _vm._e(),
                                                    _vm._v(" "),
                                                    _c(
                                                      "fieldset",
                                                      {
                                                        staticClass:
                                                          "dvs-fieldset dvs-mb-4"
                                                      },
                                                      [
                                                        _c(
                                                          "a",
                                                          {
                                                            staticClass:
                                                              "dvs-btn",
                                                            style:
                                                              _vm.theme
                                                                .actionButtonGhost,
                                                            attrs: {
                                                              href: file.url,
                                                              target: "_blank",
                                                              download: ""
                                                            }
                                                          },
                                                          [
                                                            _vm._v(
                                                              "Click to download"
                                                            )
                                                          ]
                                                        )
                                                      ]
                                                    ),
                                                    _vm._v(" "),
                                                    _vm.isActive(file)
                                                      ? [
                                                          _c(
                                                            "h6",
                                                            {
                                                              staticClass:
                                                                "dvs-my-2 dvs-text-sm"
                                                            },
                                                            [
                                                              _vm._v(
                                                                "Appears On"
                                                              )
                                                            ]
                                                          ),
                                                          _vm._v(" "),
                                                          _c(
                                                            "ul",
                                                            {
                                                              staticClass:
                                                                "dvs-list-reset"
                                                            },
                                                            _vm._l(
                                                              file.fields,
                                                              function(field) {
                                                                return _c(
                                                                  "li",
                                                                  {
                                                                    key:
                                                                      field.id,
                                                                    staticClass:
                                                                      "dvs-py-2"
                                                                  },
                                                                  [
                                                                    _c(
                                                                      "a",
                                                                      {
                                                                        staticClass:
                                                                          "dvs-btn dvs-btn-sm",
                                                                        attrs: {
                                                                          href:
                                                                            "field.page_slug",
                                                                          target:
                                                                            "_blank"
                                                                        }
                                                                      },
                                                                      [
                                                                        _vm._v(
                                                                          _vm._s(
                                                                            field.page_title
                                                                          ) +
                                                                            " - " +
                                                                            _vm._s(
                                                                              field.field_name
                                                                            )
                                                                        )
                                                                      ]
                                                                    )
                                                                  ]
                                                                )
                                                              }
                                                            )
                                                          )
                                                        ]
                                                      : _vm._e()
                                                  ],
                                                  2
                                                )
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
                  ])
                : _vm.selectedFile && _vm.selectedFile.type === "image"
                ? [
                    typeof _vm.options !== "undefined" && _vm.options.sizes
                      ? _c(
                          "div",
                          [
                            _c("media-editor", {
                              attrs: {
                                source: _vm.selectedFile.url,
                                sizes: _vm.options.sizes
                              },
                              on: {
                                cancel: function($event) {
                                  _vm.selectedFile = null
                                },
                                done: _vm.generateAndSetFile
                              }
                            })
                          ],
                          1
                        )
                      : _c(
                          "div",
                          [
                            _c("media-editor", {
                              attrs: { source: _vm.selectedFile.url },
                              on: {
                                cancel: function($event) {
                                  _vm.selectedFile = null
                                },
                                done: _vm.generateAndSetFile
                              }
                            })
                          ],
                          1
                        )
                  ]
                : _vm._e()
            ],
            2
          )
        ]
      )
    : _vm._e()
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("h6", { staticClass: "dvs-mt-2 dvs-text-sm" }, [
      _c("span", [_vm._v("No files in this directory")])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-7ff398c4", module.exports)
  }
}

/***/ })

});