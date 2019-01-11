/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 517);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */,
/* 1 */
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file.
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate

    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),
/* 2 */,
/* 3 */,
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var bind = __webpack_require__(39);
var isBuffer = __webpack_require__(73);

/*global toString:true*/

// utils is a library of generic helper functions non-specific to axios

var toString = Object.prototype.toString;

/**
 * Determine if a value is an Array
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an Array, otherwise false
 */
function isArray(val) {
  return toString.call(val) === '[object Array]';
}

/**
 * Determine if a value is an ArrayBuffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an ArrayBuffer, otherwise false
 */
function isArrayBuffer(val) {
  return toString.call(val) === '[object ArrayBuffer]';
}

/**
 * Determine if a value is a FormData
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an FormData, otherwise false
 */
function isFormData(val) {
  return (typeof FormData !== 'undefined') && (val instanceof FormData);
}

/**
 * Determine if a value is a view on an ArrayBuffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a view on an ArrayBuffer, otherwise false
 */
function isArrayBufferView(val) {
  var result;
  if ((typeof ArrayBuffer !== 'undefined') && (ArrayBuffer.isView)) {
    result = ArrayBuffer.isView(val);
  } else {
    result = (val) && (val.buffer) && (val.buffer instanceof ArrayBuffer);
  }
  return result;
}

/**
 * Determine if a value is a String
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a String, otherwise false
 */
function isString(val) {
  return typeof val === 'string';
}

/**
 * Determine if a value is a Number
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Number, otherwise false
 */
function isNumber(val) {
  return typeof val === 'number';
}

/**
 * Determine if a value is undefined
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if the value is undefined, otherwise false
 */
function isUndefined(val) {
  return typeof val === 'undefined';
}

/**
 * Determine if a value is an Object
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an Object, otherwise false
 */
function isObject(val) {
  return val !== null && typeof val === 'object';
}

/**
 * Determine if a value is a Date
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Date, otherwise false
 */
function isDate(val) {
  return toString.call(val) === '[object Date]';
}

/**
 * Determine if a value is a File
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a File, otherwise false
 */
function isFile(val) {
  return toString.call(val) === '[object File]';
}

/**
 * Determine if a value is a Blob
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Blob, otherwise false
 */
function isBlob(val) {
  return toString.call(val) === '[object Blob]';
}

/**
 * Determine if a value is a Function
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Function, otherwise false
 */
function isFunction(val) {
  return toString.call(val) === '[object Function]';
}

/**
 * Determine if a value is a Stream
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Stream, otherwise false
 */
function isStream(val) {
  return isObject(val) && isFunction(val.pipe);
}

/**
 * Determine if a value is a URLSearchParams object
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a URLSearchParams object, otherwise false
 */
function isURLSearchParams(val) {
  return typeof URLSearchParams !== 'undefined' && val instanceof URLSearchParams;
}

/**
 * Trim excess whitespace off the beginning and end of a string
 *
 * @param {String} str The String to trim
 * @returns {String} The String freed of excess whitespace
 */
function trim(str) {
  return str.replace(/^\s*/, '').replace(/\s*$/, '');
}

/**
 * Determine if we're running in a standard browser environment
 *
 * This allows axios to run in a web worker, and react-native.
 * Both environments support XMLHttpRequest, but not fully standard globals.
 *
 * web workers:
 *  typeof window -> undefined
 *  typeof document -> undefined
 *
 * react-native:
 *  navigator.product -> 'ReactNative'
 */
function isStandardBrowserEnv() {
  if (typeof navigator !== 'undefined' && navigator.product === 'ReactNative') {
    return false;
  }
  return (
    typeof window !== 'undefined' &&
    typeof document !== 'undefined'
  );
}

/**
 * Iterate over an Array or an Object invoking a function for each item.
 *
 * If `obj` is an Array callback will be called passing
 * the value, index, and complete array for each item.
 *
 * If 'obj' is an Object callback will be called passing
 * the value, key, and complete object for each property.
 *
 * @param {Object|Array} obj The object to iterate
 * @param {Function} fn The callback to invoke for each item
 */
function forEach(obj, fn) {
  // Don't bother if no value provided
  if (obj === null || typeof obj === 'undefined') {
    return;
  }

  // Force an array if not already something iterable
  if (typeof obj !== 'object') {
    /*eslint no-param-reassign:0*/
    obj = [obj];
  }

  if (isArray(obj)) {
    // Iterate over array values
    for (var i = 0, l = obj.length; i < l; i++) {
      fn.call(null, obj[i], i, obj);
    }
  } else {
    // Iterate over object keys
    for (var key in obj) {
      if (Object.prototype.hasOwnProperty.call(obj, key)) {
        fn.call(null, obj[key], key, obj);
      }
    }
  }
}

/**
 * Accepts varargs expecting each argument to be an object, then
 * immutably merges the properties of each object and returns result.
 *
 * When multiple objects contain the same key the later object in
 * the arguments list will take precedence.
 *
 * Example:
 *
 * ```js
 * var result = merge({foo: 123}, {foo: 456});
 * console.log(result.foo); // outputs 456
 * ```
 *
 * @param {Object} obj1 Object to merge
 * @returns {Object} Result of all merge properties
 */
function merge(/* obj1, obj2, obj3, ... */) {
  var result = {};
  function assignValue(val, key) {
    if (typeof result[key] === 'object' && typeof val === 'object') {
      result[key] = merge(result[key], val);
    } else {
      result[key] = val;
    }
  }

  for (var i = 0, l = arguments.length; i < l; i++) {
    forEach(arguments[i], assignValue);
  }
  return result;
}

/**
 * Extends object a by mutably adding to it the properties of object b.
 *
 * @param {Object} a The object to be extended
 * @param {Object} b The object to copy properties from
 * @param {Object} thisArg The object to bind function to
 * @return {Object} The resulting value of object a
 */
function extend(a, b, thisArg) {
  forEach(b, function assignValue(val, key) {
    if (thisArg && typeof val === 'function') {
      a[key] = bind(val, thisArg);
    } else {
      a[key] = val;
    }
  });
  return a;
}

module.exports = {
  isArray: isArray,
  isArrayBuffer: isArrayBuffer,
  isBuffer: isBuffer,
  isFormData: isFormData,
  isArrayBufferView: isArrayBufferView,
  isString: isString,
  isNumber: isNumber,
  isObject: isObject,
  isUndefined: isUndefined,
  isDate: isDate,
  isFile: isFile,
  isBlob: isBlob,
  isFunction: isFunction,
  isStream: isStream,
  isURLSearchParams: isURLSearchParams,
  isStandardBrowserEnv: isStandardBrowserEnv,
  forEach: forEach,
  merge: merge,
  extend: extend,
  trim: trim
};


/***/ }),
/* 5 */,
/* 6 */,
/* 7 */,
/* 8 */,
/* 9 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(global, setImmediate) {/*!
 * Vue.js v2.5.17
 * (c) 2014-2018 Evan You
 * Released under the MIT License.
 */


/*  */

var emptyObject = Object.freeze({});

// these helpers produces better vm code in JS engines due to their
// explicitness and function inlining
function isUndef (v) {
  return v === undefined || v === null
}

function isDef (v) {
  return v !== undefined && v !== null
}

function isTrue (v) {
  return v === true
}

function isFalse (v) {
  return v === false
}

/**
 * Check if value is primitive
 */
function isPrimitive (value) {
  return (
    typeof value === 'string' ||
    typeof value === 'number' ||
    // $flow-disable-line
    typeof value === 'symbol' ||
    typeof value === 'boolean'
  )
}

/**
 * Quick object check - this is primarily used to tell
 * Objects from primitive values when we know the value
 * is a JSON-compliant type.
 */
function isObject (obj) {
  return obj !== null && typeof obj === 'object'
}

/**
 * Get the raw type string of a value e.g. [object Object]
 */
var _toString = Object.prototype.toString;

function toRawType (value) {
  return _toString.call(value).slice(8, -1)
}

/**
 * Strict object type check. Only returns true
 * for plain JavaScript objects.
 */
function isPlainObject (obj) {
  return _toString.call(obj) === '[object Object]'
}

function isRegExp (v) {
  return _toString.call(v) === '[object RegExp]'
}

/**
 * Check if val is a valid array index.
 */
function isValidArrayIndex (val) {
  var n = parseFloat(String(val));
  return n >= 0 && Math.floor(n) === n && isFinite(val)
}

/**
 * Convert a value to a string that is actually rendered.
 */
function toString (val) {
  return val == null
    ? ''
    : typeof val === 'object'
      ? JSON.stringify(val, null, 2)
      : String(val)
}

/**
 * Convert a input value to a number for persistence.
 * If the conversion fails, return original string.
 */
function toNumber (val) {
  var n = parseFloat(val);
  return isNaN(n) ? val : n
}

/**
 * Make a map and return a function for checking if a key
 * is in that map.
 */
function makeMap (
  str,
  expectsLowerCase
) {
  var map = Object.create(null);
  var list = str.split(',');
  for (var i = 0; i < list.length; i++) {
    map[list[i]] = true;
  }
  return expectsLowerCase
    ? function (val) { return map[val.toLowerCase()]; }
    : function (val) { return map[val]; }
}

/**
 * Check if a tag is a built-in tag.
 */
var isBuiltInTag = makeMap('slot,component', true);

/**
 * Check if a attribute is a reserved attribute.
 */
var isReservedAttribute = makeMap('key,ref,slot,slot-scope,is');

/**
 * Remove an item from an array
 */
function remove (arr, item) {
  if (arr.length) {
    var index = arr.indexOf(item);
    if (index > -1) {
      return arr.splice(index, 1)
    }
  }
}

/**
 * Check whether the object has the property.
 */
var hasOwnProperty = Object.prototype.hasOwnProperty;
function hasOwn (obj, key) {
  return hasOwnProperty.call(obj, key)
}

/**
 * Create a cached version of a pure function.
 */
function cached (fn) {
  var cache = Object.create(null);
  return (function cachedFn (str) {
    var hit = cache[str];
    return hit || (cache[str] = fn(str))
  })
}

/**
 * Camelize a hyphen-delimited string.
 */
var camelizeRE = /-(\w)/g;
var camelize = cached(function (str) {
  return str.replace(camelizeRE, function (_, c) { return c ? c.toUpperCase() : ''; })
});

/**
 * Capitalize a string.
 */
var capitalize = cached(function (str) {
  return str.charAt(0).toUpperCase() + str.slice(1)
});

/**
 * Hyphenate a camelCase string.
 */
var hyphenateRE = /\B([A-Z])/g;
var hyphenate = cached(function (str) {
  return str.replace(hyphenateRE, '-$1').toLowerCase()
});

/**
 * Simple bind polyfill for environments that do not support it... e.g.
 * PhantomJS 1.x. Technically we don't need this anymore since native bind is
 * now more performant in most browsers, but removing it would be breaking for
 * code that was able to run in PhantomJS 1.x, so this must be kept for
 * backwards compatibility.
 */

/* istanbul ignore next */
function polyfillBind (fn, ctx) {
  function boundFn (a) {
    var l = arguments.length;
    return l
      ? l > 1
        ? fn.apply(ctx, arguments)
        : fn.call(ctx, a)
      : fn.call(ctx)
  }

  boundFn._length = fn.length;
  return boundFn
}

function nativeBind (fn, ctx) {
  return fn.bind(ctx)
}

var bind = Function.prototype.bind
  ? nativeBind
  : polyfillBind;

/**
 * Convert an Array-like object to a real Array.
 */
function toArray (list, start) {
  start = start || 0;
  var i = list.length - start;
  var ret = new Array(i);
  while (i--) {
    ret[i] = list[i + start];
  }
  return ret
}

/**
 * Mix properties into target object.
 */
function extend (to, _from) {
  for (var key in _from) {
    to[key] = _from[key];
  }
  return to
}

/**
 * Merge an Array of Objects into a single Object.
 */
function toObject (arr) {
  var res = {};
  for (var i = 0; i < arr.length; i++) {
    if (arr[i]) {
      extend(res, arr[i]);
    }
  }
  return res
}

/**
 * Perform no operation.
 * Stubbing args to make Flow happy without leaving useless transpiled code
 * with ...rest (https://flow.org/blog/2017/05/07/Strict-Function-Call-Arity/)
 */
function noop (a, b, c) {}

/**
 * Always return false.
 */
var no = function (a, b, c) { return false; };

/**
 * Return same value
 */
var identity = function (_) { return _; };

/**
 * Generate a static keys string from compiler modules.
 */
function genStaticKeys (modules) {
  return modules.reduce(function (keys, m) {
    return keys.concat(m.staticKeys || [])
  }, []).join(',')
}

/**
 * Check if two values are loosely equal - that is,
 * if they are plain objects, do they have the same shape?
 */
function looseEqual (a, b) {
  if (a === b) { return true }
  var isObjectA = isObject(a);
  var isObjectB = isObject(b);
  if (isObjectA && isObjectB) {
    try {
      var isArrayA = Array.isArray(a);
      var isArrayB = Array.isArray(b);
      if (isArrayA && isArrayB) {
        return a.length === b.length && a.every(function (e, i) {
          return looseEqual(e, b[i])
        })
      } else if (!isArrayA && !isArrayB) {
        var keysA = Object.keys(a);
        var keysB = Object.keys(b);
        return keysA.length === keysB.length && keysA.every(function (key) {
          return looseEqual(a[key], b[key])
        })
      } else {
        /* istanbul ignore next */
        return false
      }
    } catch (e) {
      /* istanbul ignore next */
      return false
    }
  } else if (!isObjectA && !isObjectB) {
    return String(a) === String(b)
  } else {
    return false
  }
}

function looseIndexOf (arr, val) {
  for (var i = 0; i < arr.length; i++) {
    if (looseEqual(arr[i], val)) { return i }
  }
  return -1
}

/**
 * Ensure a function is called only once.
 */
function once (fn) {
  var called = false;
  return function () {
    if (!called) {
      called = true;
      fn.apply(this, arguments);
    }
  }
}

var SSR_ATTR = 'data-server-rendered';

var ASSET_TYPES = [
  'component',
  'directive',
  'filter'
];

var LIFECYCLE_HOOKS = [
  'beforeCreate',
  'created',
  'beforeMount',
  'mounted',
  'beforeUpdate',
  'updated',
  'beforeDestroy',
  'destroyed',
  'activated',
  'deactivated',
  'errorCaptured'
];

/*  */

var config = ({
  /**
   * Option merge strategies (used in core/util/options)
   */
  // $flow-disable-line
  optionMergeStrategies: Object.create(null),

  /**
   * Whether to suppress warnings.
   */
  silent: false,

  /**
   * Show production mode tip message on boot?
   */
  productionTip: "development" !== 'production',

  /**
   * Whether to enable devtools
   */
  devtools: "development" !== 'production',

  /**
   * Whether to record perf
   */
  performance: false,

  /**
   * Error handler for watcher errors
   */
  errorHandler: null,

  /**
   * Warn handler for watcher warns
   */
  warnHandler: null,

  /**
   * Ignore certain custom elements
   */
  ignoredElements: [],

  /**
   * Custom user key aliases for v-on
   */
  // $flow-disable-line
  keyCodes: Object.create(null),

  /**
   * Check if a tag is reserved so that it cannot be registered as a
   * component. This is platform-dependent and may be overwritten.
   */
  isReservedTag: no,

  /**
   * Check if an attribute is reserved so that it cannot be used as a component
   * prop. This is platform-dependent and may be overwritten.
   */
  isReservedAttr: no,

  /**
   * Check if a tag is an unknown element.
   * Platform-dependent.
   */
  isUnknownElement: no,

  /**
   * Get the namespace of an element
   */
  getTagNamespace: noop,

  /**
   * Parse the real tag name for the specific platform.
   */
  parsePlatformTagName: identity,

  /**
   * Check if an attribute must be bound using property, e.g. value
   * Platform-dependent.
   */
  mustUseProp: no,

  /**
   * Exposed for legacy reasons
   */
  _lifecycleHooks: LIFECYCLE_HOOKS
})

/*  */

/**
 * Check if a string starts with $ or _
 */
function isReserved (str) {
  var c = (str + '').charCodeAt(0);
  return c === 0x24 || c === 0x5F
}

/**
 * Define a property.
 */
function def (obj, key, val, enumerable) {
  Object.defineProperty(obj, key, {
    value: val,
    enumerable: !!enumerable,
    writable: true,
    configurable: true
  });
}

/**
 * Parse simple path.
 */
var bailRE = /[^\w.$]/;
function parsePath (path) {
  if (bailRE.test(path)) {
    return
  }
  var segments = path.split('.');
  return function (obj) {
    for (var i = 0; i < segments.length; i++) {
      if (!obj) { return }
      obj = obj[segments[i]];
    }
    return obj
  }
}

/*  */

// can we use __proto__?
var hasProto = '__proto__' in {};

// Browser environment sniffing
var inBrowser = typeof window !== 'undefined';
var inWeex = typeof WXEnvironment !== 'undefined' && !!WXEnvironment.platform;
var weexPlatform = inWeex && WXEnvironment.platform.toLowerCase();
var UA = inBrowser && window.navigator.userAgent.toLowerCase();
var isIE = UA && /msie|trident/.test(UA);
var isIE9 = UA && UA.indexOf('msie 9.0') > 0;
var isEdge = UA && UA.indexOf('edge/') > 0;
var isAndroid = (UA && UA.indexOf('android') > 0) || (weexPlatform === 'android');
var isIOS = (UA && /iphone|ipad|ipod|ios/.test(UA)) || (weexPlatform === 'ios');
var isChrome = UA && /chrome\/\d+/.test(UA) && !isEdge;

// Firefox has a "watch" function on Object.prototype...
var nativeWatch = ({}).watch;

var supportsPassive = false;
if (inBrowser) {
  try {
    var opts = {};
    Object.defineProperty(opts, 'passive', ({
      get: function get () {
        /* istanbul ignore next */
        supportsPassive = true;
      }
    })); // https://github.com/facebook/flow/issues/285
    window.addEventListener('test-passive', null, opts);
  } catch (e) {}
}

// this needs to be lazy-evaled because vue may be required before
// vue-server-renderer can set VUE_ENV
var _isServer;
var isServerRendering = function () {
  if (_isServer === undefined) {
    /* istanbul ignore if */
    if (!inBrowser && !inWeex && typeof global !== 'undefined') {
      // detect presence of vue-server-renderer and avoid
      // Webpack shimming the process
      _isServer = global['process'].env.VUE_ENV === 'server';
    } else {
      _isServer = false;
    }
  }
  return _isServer
};

// detect devtools
var devtools = inBrowser && window.__VUE_DEVTOOLS_GLOBAL_HOOK__;

/* istanbul ignore next */
function isNative (Ctor) {
  return typeof Ctor === 'function' && /native code/.test(Ctor.toString())
}

var hasSymbol =
  typeof Symbol !== 'undefined' && isNative(Symbol) &&
  typeof Reflect !== 'undefined' && isNative(Reflect.ownKeys);

var _Set;
/* istanbul ignore if */ // $flow-disable-line
if (typeof Set !== 'undefined' && isNative(Set)) {
  // use native Set when available.
  _Set = Set;
} else {
  // a non-standard Set polyfill that only works with primitive keys.
  _Set = (function () {
    function Set () {
      this.set = Object.create(null);
    }
    Set.prototype.has = function has (key) {
      return this.set[key] === true
    };
    Set.prototype.add = function add (key) {
      this.set[key] = true;
    };
    Set.prototype.clear = function clear () {
      this.set = Object.create(null);
    };

    return Set;
  }());
}

/*  */

var warn = noop;
var tip = noop;
var generateComponentTrace = (noop); // work around flow check
var formatComponentName = (noop);

if (true) {
  var hasConsole = typeof console !== 'undefined';
  var classifyRE = /(?:^|[-_])(\w)/g;
  var classify = function (str) { return str
    .replace(classifyRE, function (c) { return c.toUpperCase(); })
    .replace(/[-_]/g, ''); };

  warn = function (msg, vm) {
    var trace = vm ? generateComponentTrace(vm) : '';

    if (config.warnHandler) {
      config.warnHandler.call(null, msg, vm, trace);
    } else if (hasConsole && (!config.silent)) {
      console.error(("[Vue warn]: " + msg + trace));
    }
  };

  tip = function (msg, vm) {
    if (hasConsole && (!config.silent)) {
      console.warn("[Vue tip]: " + msg + (
        vm ? generateComponentTrace(vm) : ''
      ));
    }
  };

  formatComponentName = function (vm, includeFile) {
    if (vm.$root === vm) {
      return '<Root>'
    }
    var options = typeof vm === 'function' && vm.cid != null
      ? vm.options
      : vm._isVue
        ? vm.$options || vm.constructor.options
        : vm || {};
    var name = options.name || options._componentTag;
    var file = options.__file;
    if (!name && file) {
      var match = file.match(/([^/\\]+)\.vue$/);
      name = match && match[1];
    }

    return (
      (name ? ("<" + (classify(name)) + ">") : "<Anonymous>") +
      (file && includeFile !== false ? (" at " + file) : '')
    )
  };

  var repeat = function (str, n) {
    var res = '';
    while (n) {
      if (n % 2 === 1) { res += str; }
      if (n > 1) { str += str; }
      n >>= 1;
    }
    return res
  };

  generateComponentTrace = function (vm) {
    if (vm._isVue && vm.$parent) {
      var tree = [];
      var currentRecursiveSequence = 0;
      while (vm) {
        if (tree.length > 0) {
          var last = tree[tree.length - 1];
          if (last.constructor === vm.constructor) {
            currentRecursiveSequence++;
            vm = vm.$parent;
            continue
          } else if (currentRecursiveSequence > 0) {
            tree[tree.length - 1] = [last, currentRecursiveSequence];
            currentRecursiveSequence = 0;
          }
        }
        tree.push(vm);
        vm = vm.$parent;
      }
      return '\n\nfound in\n\n' + tree
        .map(function (vm, i) { return ("" + (i === 0 ? '---> ' : repeat(' ', 5 + i * 2)) + (Array.isArray(vm)
            ? ((formatComponentName(vm[0])) + "... (" + (vm[1]) + " recursive calls)")
            : formatComponentName(vm))); })
        .join('\n')
    } else {
      return ("\n\n(found in " + (formatComponentName(vm)) + ")")
    }
  };
}

/*  */


var uid = 0;

/**
 * A dep is an observable that can have multiple
 * directives subscribing to it.
 */
var Dep = function Dep () {
  this.id = uid++;
  this.subs = [];
};

Dep.prototype.addSub = function addSub (sub) {
  this.subs.push(sub);
};

Dep.prototype.removeSub = function removeSub (sub) {
  remove(this.subs, sub);
};

Dep.prototype.depend = function depend () {
  if (Dep.target) {
    Dep.target.addDep(this);
  }
};

Dep.prototype.notify = function notify () {
  // stabilize the subscriber list first
  var subs = this.subs.slice();
  for (var i = 0, l = subs.length; i < l; i++) {
    subs[i].update();
  }
};

// the current target watcher being evaluated.
// this is globally unique because there could be only one
// watcher being evaluated at any time.
Dep.target = null;
var targetStack = [];

function pushTarget (_target) {
  if (Dep.target) { targetStack.push(Dep.target); }
  Dep.target = _target;
}

function popTarget () {
  Dep.target = targetStack.pop();
}

/*  */

var VNode = function VNode (
  tag,
  data,
  children,
  text,
  elm,
  context,
  componentOptions,
  asyncFactory
) {
  this.tag = tag;
  this.data = data;
  this.children = children;
  this.text = text;
  this.elm = elm;
  this.ns = undefined;
  this.context = context;
  this.fnContext = undefined;
  this.fnOptions = undefined;
  this.fnScopeId = undefined;
  this.key = data && data.key;
  this.componentOptions = componentOptions;
  this.componentInstance = undefined;
  this.parent = undefined;
  this.raw = false;
  this.isStatic = false;
  this.isRootInsert = true;
  this.isComment = false;
  this.isCloned = false;
  this.isOnce = false;
  this.asyncFactory = asyncFactory;
  this.asyncMeta = undefined;
  this.isAsyncPlaceholder = false;
};

var prototypeAccessors = { child: { configurable: true } };

// DEPRECATED: alias for componentInstance for backwards compat.
/* istanbul ignore next */
prototypeAccessors.child.get = function () {
  return this.componentInstance
};

Object.defineProperties( VNode.prototype, prototypeAccessors );

var createEmptyVNode = function (text) {
  if ( text === void 0 ) text = '';

  var node = new VNode();
  node.text = text;
  node.isComment = true;
  return node
};

function createTextVNode (val) {
  return new VNode(undefined, undefined, undefined, String(val))
}

// optimized shallow clone
// used for static nodes and slot nodes because they may be reused across
// multiple renders, cloning them avoids errors when DOM manipulations rely
// on their elm reference.
function cloneVNode (vnode) {
  var cloned = new VNode(
    vnode.tag,
    vnode.data,
    vnode.children,
    vnode.text,
    vnode.elm,
    vnode.context,
    vnode.componentOptions,
    vnode.asyncFactory
  );
  cloned.ns = vnode.ns;
  cloned.isStatic = vnode.isStatic;
  cloned.key = vnode.key;
  cloned.isComment = vnode.isComment;
  cloned.fnContext = vnode.fnContext;
  cloned.fnOptions = vnode.fnOptions;
  cloned.fnScopeId = vnode.fnScopeId;
  cloned.isCloned = true;
  return cloned
}

/*
 * not type checking this file because flow doesn't play well with
 * dynamically accessing methods on Array prototype
 */

var arrayProto = Array.prototype;
var arrayMethods = Object.create(arrayProto);

var methodsToPatch = [
  'push',
  'pop',
  'shift',
  'unshift',
  'splice',
  'sort',
  'reverse'
];

/**
 * Intercept mutating methods and emit events
 */
methodsToPatch.forEach(function (method) {
  // cache original method
  var original = arrayProto[method];
  def(arrayMethods, method, function mutator () {
    var args = [], len = arguments.length;
    while ( len-- ) args[ len ] = arguments[ len ];

    var result = original.apply(this, args);
    var ob = this.__ob__;
    var inserted;
    switch (method) {
      case 'push':
      case 'unshift':
        inserted = args;
        break
      case 'splice':
        inserted = args.slice(2);
        break
    }
    if (inserted) { ob.observeArray(inserted); }
    // notify change
    ob.dep.notify();
    return result
  });
});

/*  */

var arrayKeys = Object.getOwnPropertyNames(arrayMethods);

/**
 * In some cases we may want to disable observation inside a component's
 * update computation.
 */
var shouldObserve = true;

function toggleObserving (value) {
  shouldObserve = value;
}

/**
 * Observer class that is attached to each observed
 * object. Once attached, the observer converts the target
 * object's property keys into getter/setters that
 * collect dependencies and dispatch updates.
 */
var Observer = function Observer (value) {
  this.value = value;
  this.dep = new Dep();
  this.vmCount = 0;
  def(value, '__ob__', this);
  if (Array.isArray(value)) {
    var augment = hasProto
      ? protoAugment
      : copyAugment;
    augment(value, arrayMethods, arrayKeys);
    this.observeArray(value);
  } else {
    this.walk(value);
  }
};

/**
 * Walk through each property and convert them into
 * getter/setters. This method should only be called when
 * value type is Object.
 */
Observer.prototype.walk = function walk (obj) {
  var keys = Object.keys(obj);
  for (var i = 0; i < keys.length; i++) {
    defineReactive(obj, keys[i]);
  }
};

/**
 * Observe a list of Array items.
 */
Observer.prototype.observeArray = function observeArray (items) {
  for (var i = 0, l = items.length; i < l; i++) {
    observe(items[i]);
  }
};

// helpers

/**
 * Augment an target Object or Array by intercepting
 * the prototype chain using __proto__
 */
function protoAugment (target, src, keys) {
  /* eslint-disable no-proto */
  target.__proto__ = src;
  /* eslint-enable no-proto */
}

/**
 * Augment an target Object or Array by defining
 * hidden properties.
 */
/* istanbul ignore next */
function copyAugment (target, src, keys) {
  for (var i = 0, l = keys.length; i < l; i++) {
    var key = keys[i];
    def(target, key, src[key]);
  }
}

/**
 * Attempt to create an observer instance for a value,
 * returns the new observer if successfully observed,
 * or the existing observer if the value already has one.
 */
function observe (value, asRootData) {
  if (!isObject(value) || value instanceof VNode) {
    return
  }
  var ob;
  if (hasOwn(value, '__ob__') && value.__ob__ instanceof Observer) {
    ob = value.__ob__;
  } else if (
    shouldObserve &&
    !isServerRendering() &&
    (Array.isArray(value) || isPlainObject(value)) &&
    Object.isExtensible(value) &&
    !value._isVue
  ) {
    ob = new Observer(value);
  }
  if (asRootData && ob) {
    ob.vmCount++;
  }
  return ob
}

/**
 * Define a reactive property on an Object.
 */
function defineReactive (
  obj,
  key,
  val,
  customSetter,
  shallow
) {
  var dep = new Dep();

  var property = Object.getOwnPropertyDescriptor(obj, key);
  if (property && property.configurable === false) {
    return
  }

  // cater for pre-defined getter/setters
  var getter = property && property.get;
  if (!getter && arguments.length === 2) {
    val = obj[key];
  }
  var setter = property && property.set;

  var childOb = !shallow && observe(val);
  Object.defineProperty(obj, key, {
    enumerable: true,
    configurable: true,
    get: function reactiveGetter () {
      var value = getter ? getter.call(obj) : val;
      if (Dep.target) {
        dep.depend();
        if (childOb) {
          childOb.dep.depend();
          if (Array.isArray(value)) {
            dependArray(value);
          }
        }
      }
      return value
    },
    set: function reactiveSetter (newVal) {
      var value = getter ? getter.call(obj) : val;
      /* eslint-disable no-self-compare */
      if (newVal === value || (newVal !== newVal && value !== value)) {
        return
      }
      /* eslint-enable no-self-compare */
      if ("development" !== 'production' && customSetter) {
        customSetter();
      }
      if (setter) {
        setter.call(obj, newVal);
      } else {
        val = newVal;
      }
      childOb = !shallow && observe(newVal);
      dep.notify();
    }
  });
}

/**
 * Set a property on an object. Adds the new property and
 * triggers change notification if the property doesn't
 * already exist.
 */
function set (target, key, val) {
  if ("development" !== 'production' &&
    (isUndef(target) || isPrimitive(target))
  ) {
    warn(("Cannot set reactive property on undefined, null, or primitive value: " + ((target))));
  }
  if (Array.isArray(target) && isValidArrayIndex(key)) {
    target.length = Math.max(target.length, key);
    target.splice(key, 1, val);
    return val
  }
  if (key in target && !(key in Object.prototype)) {
    target[key] = val;
    return val
  }
  var ob = (target).__ob__;
  if (target._isVue || (ob && ob.vmCount)) {
    "development" !== 'production' && warn(
      'Avoid adding reactive properties to a Vue instance or its root $data ' +
      'at runtime - declare it upfront in the data option.'
    );
    return val
  }
  if (!ob) {
    target[key] = val;
    return val
  }
  defineReactive(ob.value, key, val);
  ob.dep.notify();
  return val
}

/**
 * Delete a property and trigger change if necessary.
 */
function del (target, key) {
  if ("development" !== 'production' &&
    (isUndef(target) || isPrimitive(target))
  ) {
    warn(("Cannot delete reactive property on undefined, null, or primitive value: " + ((target))));
  }
  if (Array.isArray(target) && isValidArrayIndex(key)) {
    target.splice(key, 1);
    return
  }
  var ob = (target).__ob__;
  if (target._isVue || (ob && ob.vmCount)) {
    "development" !== 'production' && warn(
      'Avoid deleting properties on a Vue instance or its root $data ' +
      '- just set it to null.'
    );
    return
  }
  if (!hasOwn(target, key)) {
    return
  }
  delete target[key];
  if (!ob) {
    return
  }
  ob.dep.notify();
}

/**
 * Collect dependencies on array elements when the array is touched, since
 * we cannot intercept array element access like property getters.
 */
function dependArray (value) {
  for (var e = (void 0), i = 0, l = value.length; i < l; i++) {
    e = value[i];
    e && e.__ob__ && e.__ob__.dep.depend();
    if (Array.isArray(e)) {
      dependArray(e);
    }
  }
}

/*  */

/**
 * Option overwriting strategies are functions that handle
 * how to merge a parent option value and a child option
 * value into the final value.
 */
var strats = config.optionMergeStrategies;

/**
 * Options with restrictions
 */
if (true) {
  strats.el = strats.propsData = function (parent, child, vm, key) {
    if (!vm) {
      warn(
        "option \"" + key + "\" can only be used during instance " +
        'creation with the `new` keyword.'
      );
    }
    return defaultStrat(parent, child)
  };
}

/**
 * Helper that recursively merges two data objects together.
 */
function mergeData (to, from) {
  if (!from) { return to }
  var key, toVal, fromVal;
  var keys = Object.keys(from);
  for (var i = 0; i < keys.length; i++) {
    key = keys[i];
    toVal = to[key];
    fromVal = from[key];
    if (!hasOwn(to, key)) {
      set(to, key, fromVal);
    } else if (isPlainObject(toVal) && isPlainObject(fromVal)) {
      mergeData(toVal, fromVal);
    }
  }
  return to
}

/**
 * Data
 */
function mergeDataOrFn (
  parentVal,
  childVal,
  vm
) {
  if (!vm) {
    // in a Vue.extend merge, both should be functions
    if (!childVal) {
      return parentVal
    }
    if (!parentVal) {
      return childVal
    }
    // when parentVal & childVal are both present,
    // we need to return a function that returns the
    // merged result of both functions... no need to
    // check if parentVal is a function here because
    // it has to be a function to pass previous merges.
    return function mergedDataFn () {
      return mergeData(
        typeof childVal === 'function' ? childVal.call(this, this) : childVal,
        typeof parentVal === 'function' ? parentVal.call(this, this) : parentVal
      )
    }
  } else {
    return function mergedInstanceDataFn () {
      // instance merge
      var instanceData = typeof childVal === 'function'
        ? childVal.call(vm, vm)
        : childVal;
      var defaultData = typeof parentVal === 'function'
        ? parentVal.call(vm, vm)
        : parentVal;
      if (instanceData) {
        return mergeData(instanceData, defaultData)
      } else {
        return defaultData
      }
    }
  }
}

strats.data = function (
  parentVal,
  childVal,
  vm
) {
  if (!vm) {
    if (childVal && typeof childVal !== 'function') {
      "development" !== 'production' && warn(
        'The "data" option should be a function ' +
        'that returns a per-instance value in component ' +
        'definitions.',
        vm
      );

      return parentVal
    }
    return mergeDataOrFn(parentVal, childVal)
  }

  return mergeDataOrFn(parentVal, childVal, vm)
};

/**
 * Hooks and props are merged as arrays.
 */
function mergeHook (
  parentVal,
  childVal
) {
  return childVal
    ? parentVal
      ? parentVal.concat(childVal)
      : Array.isArray(childVal)
        ? childVal
        : [childVal]
    : parentVal
}

LIFECYCLE_HOOKS.forEach(function (hook) {
  strats[hook] = mergeHook;
});

/**
 * Assets
 *
 * When a vm is present (instance creation), we need to do
 * a three-way merge between constructor options, instance
 * options and parent options.
 */
function mergeAssets (
  parentVal,
  childVal,
  vm,
  key
) {
  var res = Object.create(parentVal || null);
  if (childVal) {
    "development" !== 'production' && assertObjectType(key, childVal, vm);
    return extend(res, childVal)
  } else {
    return res
  }
}

ASSET_TYPES.forEach(function (type) {
  strats[type + 's'] = mergeAssets;
});

/**
 * Watchers.
 *
 * Watchers hashes should not overwrite one
 * another, so we merge them as arrays.
 */
strats.watch = function (
  parentVal,
  childVal,
  vm,
  key
) {
  // work around Firefox's Object.prototype.watch...
  if (parentVal === nativeWatch) { parentVal = undefined; }
  if (childVal === nativeWatch) { childVal = undefined; }
  /* istanbul ignore if */
  if (!childVal) { return Object.create(parentVal || null) }
  if (true) {
    assertObjectType(key, childVal, vm);
  }
  if (!parentVal) { return childVal }
  var ret = {};
  extend(ret, parentVal);
  for (var key$1 in childVal) {
    var parent = ret[key$1];
    var child = childVal[key$1];
    if (parent && !Array.isArray(parent)) {
      parent = [parent];
    }
    ret[key$1] = parent
      ? parent.concat(child)
      : Array.isArray(child) ? child : [child];
  }
  return ret
};

/**
 * Other object hashes.
 */
strats.props =
strats.methods =
strats.inject =
strats.computed = function (
  parentVal,
  childVal,
  vm,
  key
) {
  if (childVal && "development" !== 'production') {
    assertObjectType(key, childVal, vm);
  }
  if (!parentVal) { return childVal }
  var ret = Object.create(null);
  extend(ret, parentVal);
  if (childVal) { extend(ret, childVal); }
  return ret
};
strats.provide = mergeDataOrFn;

/**
 * Default strategy.
 */
var defaultStrat = function (parentVal, childVal) {
  return childVal === undefined
    ? parentVal
    : childVal
};

/**
 * Validate component names
 */
function checkComponents (options) {
  for (var key in options.components) {
    validateComponentName(key);
  }
}

function validateComponentName (name) {
  if (!/^[a-zA-Z][\w-]*$/.test(name)) {
    warn(
      'Invalid component name: "' + name + '". Component names ' +
      'can only contain alphanumeric characters and the hyphen, ' +
      'and must start with a letter.'
    );
  }
  if (isBuiltInTag(name) || config.isReservedTag(name)) {
    warn(
      'Do not use built-in or reserved HTML elements as component ' +
      'id: ' + name
    );
  }
}

/**
 * Ensure all props option syntax are normalized into the
 * Object-based format.
 */
function normalizeProps (options, vm) {
  var props = options.props;
  if (!props) { return }
  var res = {};
  var i, val, name;
  if (Array.isArray(props)) {
    i = props.length;
    while (i--) {
      val = props[i];
      if (typeof val === 'string') {
        name = camelize(val);
        res[name] = { type: null };
      } else if (true) {
        warn('props must be strings when using array syntax.');
      }
    }
  } else if (isPlainObject(props)) {
    for (var key in props) {
      val = props[key];
      name = camelize(key);
      res[name] = isPlainObject(val)
        ? val
        : { type: val };
    }
  } else if (true) {
    warn(
      "Invalid value for option \"props\": expected an Array or an Object, " +
      "but got " + (toRawType(props)) + ".",
      vm
    );
  }
  options.props = res;
}

/**
 * Normalize all injections into Object-based format
 */
function normalizeInject (options, vm) {
  var inject = options.inject;
  if (!inject) { return }
  var normalized = options.inject = {};
  if (Array.isArray(inject)) {
    for (var i = 0; i < inject.length; i++) {
      normalized[inject[i]] = { from: inject[i] };
    }
  } else if (isPlainObject(inject)) {
    for (var key in inject) {
      var val = inject[key];
      normalized[key] = isPlainObject(val)
        ? extend({ from: key }, val)
        : { from: val };
    }
  } else if (true) {
    warn(
      "Invalid value for option \"inject\": expected an Array or an Object, " +
      "but got " + (toRawType(inject)) + ".",
      vm
    );
  }
}

/**
 * Normalize raw function directives into object format.
 */
function normalizeDirectives (options) {
  var dirs = options.directives;
  if (dirs) {
    for (var key in dirs) {
      var def = dirs[key];
      if (typeof def === 'function') {
        dirs[key] = { bind: def, update: def };
      }
    }
  }
}

function assertObjectType (name, value, vm) {
  if (!isPlainObject(value)) {
    warn(
      "Invalid value for option \"" + name + "\": expected an Object, " +
      "but got " + (toRawType(value)) + ".",
      vm
    );
  }
}

/**
 * Merge two option objects into a new one.
 * Core utility used in both instantiation and inheritance.
 */
function mergeOptions (
  parent,
  child,
  vm
) {
  if (true) {
    checkComponents(child);
  }

  if (typeof child === 'function') {
    child = child.options;
  }

  normalizeProps(child, vm);
  normalizeInject(child, vm);
  normalizeDirectives(child);
  var extendsFrom = child.extends;
  if (extendsFrom) {
    parent = mergeOptions(parent, extendsFrom, vm);
  }
  if (child.mixins) {
    for (var i = 0, l = child.mixins.length; i < l; i++) {
      parent = mergeOptions(parent, child.mixins[i], vm);
    }
  }
  var options = {};
  var key;
  for (key in parent) {
    mergeField(key);
  }
  for (key in child) {
    if (!hasOwn(parent, key)) {
      mergeField(key);
    }
  }
  function mergeField (key) {
    var strat = strats[key] || defaultStrat;
    options[key] = strat(parent[key], child[key], vm, key);
  }
  return options
}

/**
 * Resolve an asset.
 * This function is used because child instances need access
 * to assets defined in its ancestor chain.
 */
function resolveAsset (
  options,
  type,
  id,
  warnMissing
) {
  /* istanbul ignore if */
  if (typeof id !== 'string') {
    return
  }
  var assets = options[type];
  // check local registration variations first
  if (hasOwn(assets, id)) { return assets[id] }
  var camelizedId = camelize(id);
  if (hasOwn(assets, camelizedId)) { return assets[camelizedId] }
  var PascalCaseId = capitalize(camelizedId);
  if (hasOwn(assets, PascalCaseId)) { return assets[PascalCaseId] }
  // fallback to prototype chain
  var res = assets[id] || assets[camelizedId] || assets[PascalCaseId];
  if ("development" !== 'production' && warnMissing && !res) {
    warn(
      'Failed to resolve ' + type.slice(0, -1) + ': ' + id,
      options
    );
  }
  return res
}

/*  */

function validateProp (
  key,
  propOptions,
  propsData,
  vm
) {
  var prop = propOptions[key];
  var absent = !hasOwn(propsData, key);
  var value = propsData[key];
  // boolean casting
  var booleanIndex = getTypeIndex(Boolean, prop.type);
  if (booleanIndex > -1) {
    if (absent && !hasOwn(prop, 'default')) {
      value = false;
    } else if (value === '' || value === hyphenate(key)) {
      // only cast empty string / same name to boolean if
      // boolean has higher priority
      var stringIndex = getTypeIndex(String, prop.type);
      if (stringIndex < 0 || booleanIndex < stringIndex) {
        value = true;
      }
    }
  }
  // check default value
  if (value === undefined) {
    value = getPropDefaultValue(vm, prop, key);
    // since the default value is a fresh copy,
    // make sure to observe it.
    var prevShouldObserve = shouldObserve;
    toggleObserving(true);
    observe(value);
    toggleObserving(prevShouldObserve);
  }
  if (
    true
  ) {
    assertProp(prop, key, value, vm, absent);
  }
  return value
}

/**
 * Get the default value of a prop.
 */
function getPropDefaultValue (vm, prop, key) {
  // no default, return undefined
  if (!hasOwn(prop, 'default')) {
    return undefined
  }
  var def = prop.default;
  // warn against non-factory defaults for Object & Array
  if ("development" !== 'production' && isObject(def)) {
    warn(
      'Invalid default value for prop "' + key + '": ' +
      'Props with type Object/Array must use a factory function ' +
      'to return the default value.',
      vm
    );
  }
  // the raw prop value was also undefined from previous render,
  // return previous default value to avoid unnecessary watcher trigger
  if (vm && vm.$options.propsData &&
    vm.$options.propsData[key] === undefined &&
    vm._props[key] !== undefined
  ) {
    return vm._props[key]
  }
  // call factory function for non-Function types
  // a value is Function if its prototype is function even across different execution context
  return typeof def === 'function' && getType(prop.type) !== 'Function'
    ? def.call(vm)
    : def
}

/**
 * Assert whether a prop is valid.
 */
function assertProp (
  prop,
  name,
  value,
  vm,
  absent
) {
  if (prop.required && absent) {
    warn(
      'Missing required prop: "' + name + '"',
      vm
    );
    return
  }
  if (value == null && !prop.required) {
    return
  }
  var type = prop.type;
  var valid = !type || type === true;
  var expectedTypes = [];
  if (type) {
    if (!Array.isArray(type)) {
      type = [type];
    }
    for (var i = 0; i < type.length && !valid; i++) {
      var assertedType = assertType(value, type[i]);
      expectedTypes.push(assertedType.expectedType || '');
      valid = assertedType.valid;
    }
  }
  if (!valid) {
    warn(
      "Invalid prop: type check failed for prop \"" + name + "\"." +
      " Expected " + (expectedTypes.map(capitalize).join(', ')) +
      ", got " + (toRawType(value)) + ".",
      vm
    );
    return
  }
  var validator = prop.validator;
  if (validator) {
    if (!validator(value)) {
      warn(
        'Invalid prop: custom validator check failed for prop "' + name + '".',
        vm
      );
    }
  }
}

var simpleCheckRE = /^(String|Number|Boolean|Function|Symbol)$/;

function assertType (value, type) {
  var valid;
  var expectedType = getType(type);
  if (simpleCheckRE.test(expectedType)) {
    var t = typeof value;
    valid = t === expectedType.toLowerCase();
    // for primitive wrapper objects
    if (!valid && t === 'object') {
      valid = value instanceof type;
    }
  } else if (expectedType === 'Object') {
    valid = isPlainObject(value);
  } else if (expectedType === 'Array') {
    valid = Array.isArray(value);
  } else {
    valid = value instanceof type;
  }
  return {
    valid: valid,
    expectedType: expectedType
  }
}

/**
 * Use function string name to check built-in types,
 * because a simple equality check will fail when running
 * across different vms / iframes.
 */
function getType (fn) {
  var match = fn && fn.toString().match(/^\s*function (\w+)/);
  return match ? match[1] : ''
}

function isSameType (a, b) {
  return getType(a) === getType(b)
}

function getTypeIndex (type, expectedTypes) {
  if (!Array.isArray(expectedTypes)) {
    return isSameType(expectedTypes, type) ? 0 : -1
  }
  for (var i = 0, len = expectedTypes.length; i < len; i++) {
    if (isSameType(expectedTypes[i], type)) {
      return i
    }
  }
  return -1
}

/*  */

function handleError (err, vm, info) {
  if (vm) {
    var cur = vm;
    while ((cur = cur.$parent)) {
      var hooks = cur.$options.errorCaptured;
      if (hooks) {
        for (var i = 0; i < hooks.length; i++) {
          try {
            var capture = hooks[i].call(cur, err, vm, info) === false;
            if (capture) { return }
          } catch (e) {
            globalHandleError(e, cur, 'errorCaptured hook');
          }
        }
      }
    }
  }
  globalHandleError(err, vm, info);
}

function globalHandleError (err, vm, info) {
  if (config.errorHandler) {
    try {
      return config.errorHandler.call(null, err, vm, info)
    } catch (e) {
      logError(e, null, 'config.errorHandler');
    }
  }
  logError(err, vm, info);
}

function logError (err, vm, info) {
  if (true) {
    warn(("Error in " + info + ": \"" + (err.toString()) + "\""), vm);
  }
  /* istanbul ignore else */
  if ((inBrowser || inWeex) && typeof console !== 'undefined') {
    console.error(err);
  } else {
    throw err
  }
}

/*  */
/* globals MessageChannel */

var callbacks = [];
var pending = false;

function flushCallbacks () {
  pending = false;
  var copies = callbacks.slice(0);
  callbacks.length = 0;
  for (var i = 0; i < copies.length; i++) {
    copies[i]();
  }
}

// Here we have async deferring wrappers using both microtasks and (macro) tasks.
// In < 2.4 we used microtasks everywhere, but there are some scenarios where
// microtasks have too high a priority and fire in between supposedly
// sequential events (e.g. #4521, #6690) or even between bubbling of the same
// event (#6566). However, using (macro) tasks everywhere also has subtle problems
// when state is changed right before repaint (e.g. #6813, out-in transitions).
// Here we use microtask by default, but expose a way to force (macro) task when
// needed (e.g. in event handlers attached by v-on).
var microTimerFunc;
var macroTimerFunc;
var useMacroTask = false;

// Determine (macro) task defer implementation.
// Technically setImmediate should be the ideal choice, but it's only available
// in IE. The only polyfill that consistently queues the callback after all DOM
// events triggered in the same loop is by using MessageChannel.
/* istanbul ignore if */
if (typeof setImmediate !== 'undefined' && isNative(setImmediate)) {
  macroTimerFunc = function () {
    setImmediate(flushCallbacks);
  };
} else if (typeof MessageChannel !== 'undefined' && (
  isNative(MessageChannel) ||
  // PhantomJS
  MessageChannel.toString() === '[object MessageChannelConstructor]'
)) {
  var channel = new MessageChannel();
  var port = channel.port2;
  channel.port1.onmessage = flushCallbacks;
  macroTimerFunc = function () {
    port.postMessage(1);
  };
} else {
  /* istanbul ignore next */
  macroTimerFunc = function () {
    setTimeout(flushCallbacks, 0);
  };
}

// Determine microtask defer implementation.
/* istanbul ignore next, $flow-disable-line */
if (typeof Promise !== 'undefined' && isNative(Promise)) {
  var p = Promise.resolve();
  microTimerFunc = function () {
    p.then(flushCallbacks);
    // in problematic UIWebViews, Promise.then doesn't completely break, but
    // it can get stuck in a weird state where callbacks are pushed into the
    // microtask queue but the queue isn't being flushed, until the browser
    // needs to do some other work, e.g. handle a timer. Therefore we can
    // "force" the microtask queue to be flushed by adding an empty timer.
    if (isIOS) { setTimeout(noop); }
  };
} else {
  // fallback to macro
  microTimerFunc = macroTimerFunc;
}

/**
 * Wrap a function so that if any code inside triggers state change,
 * the changes are queued using a (macro) task instead of a microtask.
 */
function withMacroTask (fn) {
  return fn._withTask || (fn._withTask = function () {
    useMacroTask = true;
    var res = fn.apply(null, arguments);
    useMacroTask = false;
    return res
  })
}

function nextTick (cb, ctx) {
  var _resolve;
  callbacks.push(function () {
    if (cb) {
      try {
        cb.call(ctx);
      } catch (e) {
        handleError(e, ctx, 'nextTick');
      }
    } else if (_resolve) {
      _resolve(ctx);
    }
  });
  if (!pending) {
    pending = true;
    if (useMacroTask) {
      macroTimerFunc();
    } else {
      microTimerFunc();
    }
  }
  // $flow-disable-line
  if (!cb && typeof Promise !== 'undefined') {
    return new Promise(function (resolve) {
      _resolve = resolve;
    })
  }
}

/*  */

var mark;
var measure;

if (true) {
  var perf = inBrowser && window.performance;
  /* istanbul ignore if */
  if (
    perf &&
    perf.mark &&
    perf.measure &&
    perf.clearMarks &&
    perf.clearMeasures
  ) {
    mark = function (tag) { return perf.mark(tag); };
    measure = function (name, startTag, endTag) {
      perf.measure(name, startTag, endTag);
      perf.clearMarks(startTag);
      perf.clearMarks(endTag);
      perf.clearMeasures(name);
    };
  }
}

/* not type checking this file because flow doesn't play well with Proxy */

var initProxy;

if (true) {
  var allowedGlobals = makeMap(
    'Infinity,undefined,NaN,isFinite,isNaN,' +
    'parseFloat,parseInt,decodeURI,decodeURIComponent,encodeURI,encodeURIComponent,' +
    'Math,Number,Date,Array,Object,Boolean,String,RegExp,Map,Set,JSON,Intl,' +
    'require' // for Webpack/Browserify
  );

  var warnNonPresent = function (target, key) {
    warn(
      "Property or method \"" + key + "\" is not defined on the instance but " +
      'referenced during render. Make sure that this property is reactive, ' +
      'either in the data option, or for class-based components, by ' +
      'initializing the property. ' +
      'See: https://vuejs.org/v2/guide/reactivity.html#Declaring-Reactive-Properties.',
      target
    );
  };

  var hasProxy =
    typeof Proxy !== 'undefined' && isNative(Proxy);

  if (hasProxy) {
    var isBuiltInModifier = makeMap('stop,prevent,self,ctrl,shift,alt,meta,exact');
    config.keyCodes = new Proxy(config.keyCodes, {
      set: function set (target, key, value) {
        if (isBuiltInModifier(key)) {
          warn(("Avoid overwriting built-in modifier in config.keyCodes: ." + key));
          return false
        } else {
          target[key] = value;
          return true
        }
      }
    });
  }

  var hasHandler = {
    has: function has (target, key) {
      var has = key in target;
      var isAllowed = allowedGlobals(key) || key.charAt(0) === '_';
      if (!has && !isAllowed) {
        warnNonPresent(target, key);
      }
      return has || !isAllowed
    }
  };

  var getHandler = {
    get: function get (target, key) {
      if (typeof key === 'string' && !(key in target)) {
        warnNonPresent(target, key);
      }
      return target[key]
    }
  };

  initProxy = function initProxy (vm) {
    if (hasProxy) {
      // determine which proxy handler to use
      var options = vm.$options;
      var handlers = options.render && options.render._withStripped
        ? getHandler
        : hasHandler;
      vm._renderProxy = new Proxy(vm, handlers);
    } else {
      vm._renderProxy = vm;
    }
  };
}

/*  */

var seenObjects = new _Set();

/**
 * Recursively traverse an object to evoke all converted
 * getters, so that every nested property inside the object
 * is collected as a "deep" dependency.
 */
function traverse (val) {
  _traverse(val, seenObjects);
  seenObjects.clear();
}

function _traverse (val, seen) {
  var i, keys;
  var isA = Array.isArray(val);
  if ((!isA && !isObject(val)) || Object.isFrozen(val) || val instanceof VNode) {
    return
  }
  if (val.__ob__) {
    var depId = val.__ob__.dep.id;
    if (seen.has(depId)) {
      return
    }
    seen.add(depId);
  }
  if (isA) {
    i = val.length;
    while (i--) { _traverse(val[i], seen); }
  } else {
    keys = Object.keys(val);
    i = keys.length;
    while (i--) { _traverse(val[keys[i]], seen); }
  }
}

/*  */

var normalizeEvent = cached(function (name) {
  var passive = name.charAt(0) === '&';
  name = passive ? name.slice(1) : name;
  var once$$1 = name.charAt(0) === '~'; // Prefixed last, checked first
  name = once$$1 ? name.slice(1) : name;
  var capture = name.charAt(0) === '!';
  name = capture ? name.slice(1) : name;
  return {
    name: name,
    once: once$$1,
    capture: capture,
    passive: passive
  }
});

function createFnInvoker (fns) {
  function invoker () {
    var arguments$1 = arguments;

    var fns = invoker.fns;
    if (Array.isArray(fns)) {
      var cloned = fns.slice();
      for (var i = 0; i < cloned.length; i++) {
        cloned[i].apply(null, arguments$1);
      }
    } else {
      // return handler return value for single handlers
      return fns.apply(null, arguments)
    }
  }
  invoker.fns = fns;
  return invoker
}

function updateListeners (
  on,
  oldOn,
  add,
  remove$$1,
  vm
) {
  var name, def, cur, old, event;
  for (name in on) {
    def = cur = on[name];
    old = oldOn[name];
    event = normalizeEvent(name);
    /* istanbul ignore if */
    if (isUndef(cur)) {
      "development" !== 'production' && warn(
        "Invalid handler for event \"" + (event.name) + "\": got " + String(cur),
        vm
      );
    } else if (isUndef(old)) {
      if (isUndef(cur.fns)) {
        cur = on[name] = createFnInvoker(cur);
      }
      add(event.name, cur, event.once, event.capture, event.passive, event.params);
    } else if (cur !== old) {
      old.fns = cur;
      on[name] = old;
    }
  }
  for (name in oldOn) {
    if (isUndef(on[name])) {
      event = normalizeEvent(name);
      remove$$1(event.name, oldOn[name], event.capture);
    }
  }
}

/*  */

function mergeVNodeHook (def, hookKey, hook) {
  if (def instanceof VNode) {
    def = def.data.hook || (def.data.hook = {});
  }
  var invoker;
  var oldHook = def[hookKey];

  function wrappedHook () {
    hook.apply(this, arguments);
    // important: remove merged hook to ensure it's called only once
    // and prevent memory leak
    remove(invoker.fns, wrappedHook);
  }

  if (isUndef(oldHook)) {
    // no existing hook
    invoker = createFnInvoker([wrappedHook]);
  } else {
    /* istanbul ignore if */
    if (isDef(oldHook.fns) && isTrue(oldHook.merged)) {
      // already a merged invoker
      invoker = oldHook;
      invoker.fns.push(wrappedHook);
    } else {
      // existing plain hook
      invoker = createFnInvoker([oldHook, wrappedHook]);
    }
  }

  invoker.merged = true;
  def[hookKey] = invoker;
}

/*  */

function extractPropsFromVNodeData (
  data,
  Ctor,
  tag
) {
  // we are only extracting raw values here.
  // validation and default values are handled in the child
  // component itself.
  var propOptions = Ctor.options.props;
  if (isUndef(propOptions)) {
    return
  }
  var res = {};
  var attrs = data.attrs;
  var props = data.props;
  if (isDef(attrs) || isDef(props)) {
    for (var key in propOptions) {
      var altKey = hyphenate(key);
      if (true) {
        var keyInLowerCase = key.toLowerCase();
        if (
          key !== keyInLowerCase &&
          attrs && hasOwn(attrs, keyInLowerCase)
        ) {
          tip(
            "Prop \"" + keyInLowerCase + "\" is passed to component " +
            (formatComponentName(tag || Ctor)) + ", but the declared prop name is" +
            " \"" + key + "\". " +
            "Note that HTML attributes are case-insensitive and camelCased " +
            "props need to use their kebab-case equivalents when using in-DOM " +
            "templates. You should probably use \"" + altKey + "\" instead of \"" + key + "\"."
          );
        }
      }
      checkProp(res, props, key, altKey, true) ||
      checkProp(res, attrs, key, altKey, false);
    }
  }
  return res
}

function checkProp (
  res,
  hash,
  key,
  altKey,
  preserve
) {
  if (isDef(hash)) {
    if (hasOwn(hash, key)) {
      res[key] = hash[key];
      if (!preserve) {
        delete hash[key];
      }
      return true
    } else if (hasOwn(hash, altKey)) {
      res[key] = hash[altKey];
      if (!preserve) {
        delete hash[altKey];
      }
      return true
    }
  }
  return false
}

/*  */

// The template compiler attempts to minimize the need for normalization by
// statically analyzing the template at compile time.
//
// For plain HTML markup, normalization can be completely skipped because the
// generated render function is guaranteed to return Array<VNode>. There are
// two cases where extra normalization is needed:

// 1. When the children contains components - because a functional component
// may return an Array instead of a single root. In this case, just a simple
// normalization is needed - if any child is an Array, we flatten the whole
// thing with Array.prototype.concat. It is guaranteed to be only 1-level deep
// because functional components already normalize their own children.
function simpleNormalizeChildren (children) {
  for (var i = 0; i < children.length; i++) {
    if (Array.isArray(children[i])) {
      return Array.prototype.concat.apply([], children)
    }
  }
  return children
}

// 2. When the children contains constructs that always generated nested Arrays,
// e.g. <template>, <slot>, v-for, or when the children is provided by user
// with hand-written render functions / JSX. In such cases a full normalization
// is needed to cater to all possible types of children values.
function normalizeChildren (children) {
  return isPrimitive(children)
    ? [createTextVNode(children)]
    : Array.isArray(children)
      ? normalizeArrayChildren(children)
      : undefined
}

function isTextNode (node) {
  return isDef(node) && isDef(node.text) && isFalse(node.isComment)
}

function normalizeArrayChildren (children, nestedIndex) {
  var res = [];
  var i, c, lastIndex, last;
  for (i = 0; i < children.length; i++) {
    c = children[i];
    if (isUndef(c) || typeof c === 'boolean') { continue }
    lastIndex = res.length - 1;
    last = res[lastIndex];
    //  nested
    if (Array.isArray(c)) {
      if (c.length > 0) {
        c = normalizeArrayChildren(c, ((nestedIndex || '') + "_" + i));
        // merge adjacent text nodes
        if (isTextNode(c[0]) && isTextNode(last)) {
          res[lastIndex] = createTextVNode(last.text + (c[0]).text);
          c.shift();
        }
        res.push.apply(res, c);
      }
    } else if (isPrimitive(c)) {
      if (isTextNode(last)) {
        // merge adjacent text nodes
        // this is necessary for SSR hydration because text nodes are
        // essentially merged when rendered to HTML strings
        res[lastIndex] = createTextVNode(last.text + c);
      } else if (c !== '') {
        // convert primitive to vnode
        res.push(createTextVNode(c));
      }
    } else {
      if (isTextNode(c) && isTextNode(last)) {
        // merge adjacent text nodes
        res[lastIndex] = createTextVNode(last.text + c.text);
      } else {
        // default key for nested array children (likely generated by v-for)
        if (isTrue(children._isVList) &&
          isDef(c.tag) &&
          isUndef(c.key) &&
          isDef(nestedIndex)) {
          c.key = "__vlist" + nestedIndex + "_" + i + "__";
        }
        res.push(c);
      }
    }
  }
  return res
}

/*  */

function ensureCtor (comp, base) {
  if (
    comp.__esModule ||
    (hasSymbol && comp[Symbol.toStringTag] === 'Module')
  ) {
    comp = comp.default;
  }
  return isObject(comp)
    ? base.extend(comp)
    : comp
}

function createAsyncPlaceholder (
  factory,
  data,
  context,
  children,
  tag
) {
  var node = createEmptyVNode();
  node.asyncFactory = factory;
  node.asyncMeta = { data: data, context: context, children: children, tag: tag };
  return node
}

function resolveAsyncComponent (
  factory,
  baseCtor,
  context
) {
  if (isTrue(factory.error) && isDef(factory.errorComp)) {
    return factory.errorComp
  }

  if (isDef(factory.resolved)) {
    return factory.resolved
  }

  if (isTrue(factory.loading) && isDef(factory.loadingComp)) {
    return factory.loadingComp
  }

  if (isDef(factory.contexts)) {
    // already pending
    factory.contexts.push(context);
  } else {
    var contexts = factory.contexts = [context];
    var sync = true;

    var forceRender = function () {
      for (var i = 0, l = contexts.length; i < l; i++) {
        contexts[i].$forceUpdate();
      }
    };

    var resolve = once(function (res) {
      // cache resolved
      factory.resolved = ensureCtor(res, baseCtor);
      // invoke callbacks only if this is not a synchronous resolve
      // (async resolves are shimmed as synchronous during SSR)
      if (!sync) {
        forceRender();
      }
    });

    var reject = once(function (reason) {
      "development" !== 'production' && warn(
        "Failed to resolve async component: " + (String(factory)) +
        (reason ? ("\nReason: " + reason) : '')
      );
      if (isDef(factory.errorComp)) {
        factory.error = true;
        forceRender();
      }
    });

    var res = factory(resolve, reject);

    if (isObject(res)) {
      if (typeof res.then === 'function') {
        // () => Promise
        if (isUndef(factory.resolved)) {
          res.then(resolve, reject);
        }
      } else if (isDef(res.component) && typeof res.component.then === 'function') {
        res.component.then(resolve, reject);

        if (isDef(res.error)) {
          factory.errorComp = ensureCtor(res.error, baseCtor);
        }

        if (isDef(res.loading)) {
          factory.loadingComp = ensureCtor(res.loading, baseCtor);
          if (res.delay === 0) {
            factory.loading = true;
          } else {
            setTimeout(function () {
              if (isUndef(factory.resolved) && isUndef(factory.error)) {
                factory.loading = true;
                forceRender();
              }
            }, res.delay || 200);
          }
        }

        if (isDef(res.timeout)) {
          setTimeout(function () {
            if (isUndef(factory.resolved)) {
              reject(
                 true
                  ? ("timeout (" + (res.timeout) + "ms)")
                  : null
              );
            }
          }, res.timeout);
        }
      }
    }

    sync = false;
    // return in case resolved synchronously
    return factory.loading
      ? factory.loadingComp
      : factory.resolved
  }
}

/*  */

function isAsyncPlaceholder (node) {
  return node.isComment && node.asyncFactory
}

/*  */

function getFirstComponentChild (children) {
  if (Array.isArray(children)) {
    for (var i = 0; i < children.length; i++) {
      var c = children[i];
      if (isDef(c) && (isDef(c.componentOptions) || isAsyncPlaceholder(c))) {
        return c
      }
    }
  }
}

/*  */

/*  */

function initEvents (vm) {
  vm._events = Object.create(null);
  vm._hasHookEvent = false;
  // init parent attached events
  var listeners = vm.$options._parentListeners;
  if (listeners) {
    updateComponentListeners(vm, listeners);
  }
}

var target;

function add (event, fn, once) {
  if (once) {
    target.$once(event, fn);
  } else {
    target.$on(event, fn);
  }
}

function remove$1 (event, fn) {
  target.$off(event, fn);
}

function updateComponentListeners (
  vm,
  listeners,
  oldListeners
) {
  target = vm;
  updateListeners(listeners, oldListeners || {}, add, remove$1, vm);
  target = undefined;
}

function eventsMixin (Vue) {
  var hookRE = /^hook:/;
  Vue.prototype.$on = function (event, fn) {
    var this$1 = this;

    var vm = this;
    if (Array.isArray(event)) {
      for (var i = 0, l = event.length; i < l; i++) {
        this$1.$on(event[i], fn);
      }
    } else {
      (vm._events[event] || (vm._events[event] = [])).push(fn);
      // optimize hook:event cost by using a boolean flag marked at registration
      // instead of a hash lookup
      if (hookRE.test(event)) {
        vm._hasHookEvent = true;
      }
    }
    return vm
  };

  Vue.prototype.$once = function (event, fn) {
    var vm = this;
    function on () {
      vm.$off(event, on);
      fn.apply(vm, arguments);
    }
    on.fn = fn;
    vm.$on(event, on);
    return vm
  };

  Vue.prototype.$off = function (event, fn) {
    var this$1 = this;

    var vm = this;
    // all
    if (!arguments.length) {
      vm._events = Object.create(null);
      return vm
    }
    // array of events
    if (Array.isArray(event)) {
      for (var i = 0, l = event.length; i < l; i++) {
        this$1.$off(event[i], fn);
      }
      return vm
    }
    // specific event
    var cbs = vm._events[event];
    if (!cbs) {
      return vm
    }
    if (!fn) {
      vm._events[event] = null;
      return vm
    }
    if (fn) {
      // specific handler
      var cb;
      var i$1 = cbs.length;
      while (i$1--) {
        cb = cbs[i$1];
        if (cb === fn || cb.fn === fn) {
          cbs.splice(i$1, 1);
          break
        }
      }
    }
    return vm
  };

  Vue.prototype.$emit = function (event) {
    var vm = this;
    if (true) {
      var lowerCaseEvent = event.toLowerCase();
      if (lowerCaseEvent !== event && vm._events[lowerCaseEvent]) {
        tip(
          "Event \"" + lowerCaseEvent + "\" is emitted in component " +
          (formatComponentName(vm)) + " but the handler is registered for \"" + event + "\". " +
          "Note that HTML attributes are case-insensitive and you cannot use " +
          "v-on to listen to camelCase events when using in-DOM templates. " +
          "You should probably use \"" + (hyphenate(event)) + "\" instead of \"" + event + "\"."
        );
      }
    }
    var cbs = vm._events[event];
    if (cbs) {
      cbs = cbs.length > 1 ? toArray(cbs) : cbs;
      var args = toArray(arguments, 1);
      for (var i = 0, l = cbs.length; i < l; i++) {
        try {
          cbs[i].apply(vm, args);
        } catch (e) {
          handleError(e, vm, ("event handler for \"" + event + "\""));
        }
      }
    }
    return vm
  };
}

/*  */



/**
 * Runtime helper for resolving raw children VNodes into a slot object.
 */
function resolveSlots (
  children,
  context
) {
  var slots = {};
  if (!children) {
    return slots
  }
  for (var i = 0, l = children.length; i < l; i++) {
    var child = children[i];
    var data = child.data;
    // remove slot attribute if the node is resolved as a Vue slot node
    if (data && data.attrs && data.attrs.slot) {
      delete data.attrs.slot;
    }
    // named slots should only be respected if the vnode was rendered in the
    // same context.
    if ((child.context === context || child.fnContext === context) &&
      data && data.slot != null
    ) {
      var name = data.slot;
      var slot = (slots[name] || (slots[name] = []));
      if (child.tag === 'template') {
        slot.push.apply(slot, child.children || []);
      } else {
        slot.push(child);
      }
    } else {
      (slots.default || (slots.default = [])).push(child);
    }
  }
  // ignore slots that contains only whitespace
  for (var name$1 in slots) {
    if (slots[name$1].every(isWhitespace)) {
      delete slots[name$1];
    }
  }
  return slots
}

function isWhitespace (node) {
  return (node.isComment && !node.asyncFactory) || node.text === ' '
}

function resolveScopedSlots (
  fns, // see flow/vnode
  res
) {
  res = res || {};
  for (var i = 0; i < fns.length; i++) {
    if (Array.isArray(fns[i])) {
      resolveScopedSlots(fns[i], res);
    } else {
      res[fns[i].key] = fns[i].fn;
    }
  }
  return res
}

/*  */

var activeInstance = null;
var isUpdatingChildComponent = false;

function initLifecycle (vm) {
  var options = vm.$options;

  // locate first non-abstract parent
  var parent = options.parent;
  if (parent && !options.abstract) {
    while (parent.$options.abstract && parent.$parent) {
      parent = parent.$parent;
    }
    parent.$children.push(vm);
  }

  vm.$parent = parent;
  vm.$root = parent ? parent.$root : vm;

  vm.$children = [];
  vm.$refs = {};

  vm._watcher = null;
  vm._inactive = null;
  vm._directInactive = false;
  vm._isMounted = false;
  vm._isDestroyed = false;
  vm._isBeingDestroyed = false;
}

function lifecycleMixin (Vue) {
  Vue.prototype._update = function (vnode, hydrating) {
    var vm = this;
    if (vm._isMounted) {
      callHook(vm, 'beforeUpdate');
    }
    var prevEl = vm.$el;
    var prevVnode = vm._vnode;
    var prevActiveInstance = activeInstance;
    activeInstance = vm;
    vm._vnode = vnode;
    // Vue.prototype.__patch__ is injected in entry points
    // based on the rendering backend used.
    if (!prevVnode) {
      // initial render
      vm.$el = vm.__patch__(
        vm.$el, vnode, hydrating, false /* removeOnly */,
        vm.$options._parentElm,
        vm.$options._refElm
      );
      // no need for the ref nodes after initial patch
      // this prevents keeping a detached DOM tree in memory (#5851)
      vm.$options._parentElm = vm.$options._refElm = null;
    } else {
      // updates
      vm.$el = vm.__patch__(prevVnode, vnode);
    }
    activeInstance = prevActiveInstance;
    // update __vue__ reference
    if (prevEl) {
      prevEl.__vue__ = null;
    }
    if (vm.$el) {
      vm.$el.__vue__ = vm;
    }
    // if parent is an HOC, update its $el as well
    if (vm.$vnode && vm.$parent && vm.$vnode === vm.$parent._vnode) {
      vm.$parent.$el = vm.$el;
    }
    // updated hook is called by the scheduler to ensure that children are
    // updated in a parent's updated hook.
  };

  Vue.prototype.$forceUpdate = function () {
    var vm = this;
    if (vm._watcher) {
      vm._watcher.update();
    }
  };

  Vue.prototype.$destroy = function () {
    var vm = this;
    if (vm._isBeingDestroyed) {
      return
    }
    callHook(vm, 'beforeDestroy');
    vm._isBeingDestroyed = true;
    // remove self from parent
    var parent = vm.$parent;
    if (parent && !parent._isBeingDestroyed && !vm.$options.abstract) {
      remove(parent.$children, vm);
    }
    // teardown watchers
    if (vm._watcher) {
      vm._watcher.teardown();
    }
    var i = vm._watchers.length;
    while (i--) {
      vm._watchers[i].teardown();
    }
    // remove reference from data ob
    // frozen object may not have observer.
    if (vm._data.__ob__) {
      vm._data.__ob__.vmCount--;
    }
    // call the last hook...
    vm._isDestroyed = true;
    // invoke destroy hooks on current rendered tree
    vm.__patch__(vm._vnode, null);
    // fire destroyed hook
    callHook(vm, 'destroyed');
    // turn off all instance listeners.
    vm.$off();
    // remove __vue__ reference
    if (vm.$el) {
      vm.$el.__vue__ = null;
    }
    // release circular reference (#6759)
    if (vm.$vnode) {
      vm.$vnode.parent = null;
    }
  };
}

function mountComponent (
  vm,
  el,
  hydrating
) {
  vm.$el = el;
  if (!vm.$options.render) {
    vm.$options.render = createEmptyVNode;
    if (true) {
      /* istanbul ignore if */
      if ((vm.$options.template && vm.$options.template.charAt(0) !== '#') ||
        vm.$options.el || el) {
        warn(
          'You are using the runtime-only build of Vue where the template ' +
          'compiler is not available. Either pre-compile the templates into ' +
          'render functions, or use the compiler-included build.',
          vm
        );
      } else {
        warn(
          'Failed to mount component: template or render function not defined.',
          vm
        );
      }
    }
  }
  callHook(vm, 'beforeMount');

  var updateComponent;
  /* istanbul ignore if */
  if ("development" !== 'production' && config.performance && mark) {
    updateComponent = function () {
      var name = vm._name;
      var id = vm._uid;
      var startTag = "vue-perf-start:" + id;
      var endTag = "vue-perf-end:" + id;

      mark(startTag);
      var vnode = vm._render();
      mark(endTag);
      measure(("vue " + name + " render"), startTag, endTag);

      mark(startTag);
      vm._update(vnode, hydrating);
      mark(endTag);
      measure(("vue " + name + " patch"), startTag, endTag);
    };
  } else {
    updateComponent = function () {
      vm._update(vm._render(), hydrating);
    };
  }

  // we set this to vm._watcher inside the watcher's constructor
  // since the watcher's initial patch may call $forceUpdate (e.g. inside child
  // component's mounted hook), which relies on vm._watcher being already defined
  new Watcher(vm, updateComponent, noop, null, true /* isRenderWatcher */);
  hydrating = false;

  // manually mounted instance, call mounted on self
  // mounted is called for render-created child components in its inserted hook
  if (vm.$vnode == null) {
    vm._isMounted = true;
    callHook(vm, 'mounted');
  }
  return vm
}

function updateChildComponent (
  vm,
  propsData,
  listeners,
  parentVnode,
  renderChildren
) {
  if (true) {
    isUpdatingChildComponent = true;
  }

  // determine whether component has slot children
  // we need to do this before overwriting $options._renderChildren
  var hasChildren = !!(
    renderChildren ||               // has new static slots
    vm.$options._renderChildren ||  // has old static slots
    parentVnode.data.scopedSlots || // has new scoped slots
    vm.$scopedSlots !== emptyObject // has old scoped slots
  );

  vm.$options._parentVnode = parentVnode;
  vm.$vnode = parentVnode; // update vm's placeholder node without re-render

  if (vm._vnode) { // update child tree's parent
    vm._vnode.parent = parentVnode;
  }
  vm.$options._renderChildren = renderChildren;

  // update $attrs and $listeners hash
  // these are also reactive so they may trigger child update if the child
  // used them during render
  vm.$attrs = parentVnode.data.attrs || emptyObject;
  vm.$listeners = listeners || emptyObject;

  // update props
  if (propsData && vm.$options.props) {
    toggleObserving(false);
    var props = vm._props;
    var propKeys = vm.$options._propKeys || [];
    for (var i = 0; i < propKeys.length; i++) {
      var key = propKeys[i];
      var propOptions = vm.$options.props; // wtf flow?
      props[key] = validateProp(key, propOptions, propsData, vm);
    }
    toggleObserving(true);
    // keep a copy of raw propsData
    vm.$options.propsData = propsData;
  }

  // update listeners
  listeners = listeners || emptyObject;
  var oldListeners = vm.$options._parentListeners;
  vm.$options._parentListeners = listeners;
  updateComponentListeners(vm, listeners, oldListeners);

  // resolve slots + force update if has children
  if (hasChildren) {
    vm.$slots = resolveSlots(renderChildren, parentVnode.context);
    vm.$forceUpdate();
  }

  if (true) {
    isUpdatingChildComponent = false;
  }
}

function isInInactiveTree (vm) {
  while (vm && (vm = vm.$parent)) {
    if (vm._inactive) { return true }
  }
  return false
}

function activateChildComponent (vm, direct) {
  if (direct) {
    vm._directInactive = false;
    if (isInInactiveTree(vm)) {
      return
    }
  } else if (vm._directInactive) {
    return
  }
  if (vm._inactive || vm._inactive === null) {
    vm._inactive = false;
    for (var i = 0; i < vm.$children.length; i++) {
      activateChildComponent(vm.$children[i]);
    }
    callHook(vm, 'activated');
  }
}

function deactivateChildComponent (vm, direct) {
  if (direct) {
    vm._directInactive = true;
    if (isInInactiveTree(vm)) {
      return
    }
  }
  if (!vm._inactive) {
    vm._inactive = true;
    for (var i = 0; i < vm.$children.length; i++) {
      deactivateChildComponent(vm.$children[i]);
    }
    callHook(vm, 'deactivated');
  }
}

function callHook (vm, hook) {
  // #7573 disable dep collection when invoking lifecycle hooks
  pushTarget();
  var handlers = vm.$options[hook];
  if (handlers) {
    for (var i = 0, j = handlers.length; i < j; i++) {
      try {
        handlers[i].call(vm);
      } catch (e) {
        handleError(e, vm, (hook + " hook"));
      }
    }
  }
  if (vm._hasHookEvent) {
    vm.$emit('hook:' + hook);
  }
  popTarget();
}

/*  */


var MAX_UPDATE_COUNT = 100;

var queue = [];
var activatedChildren = [];
var has = {};
var circular = {};
var waiting = false;
var flushing = false;
var index = 0;

/**
 * Reset the scheduler's state.
 */
function resetSchedulerState () {
  index = queue.length = activatedChildren.length = 0;
  has = {};
  if (true) {
    circular = {};
  }
  waiting = flushing = false;
}

/**
 * Flush both queues and run the watchers.
 */
function flushSchedulerQueue () {
  flushing = true;
  var watcher, id;

  // Sort queue before flush.
  // This ensures that:
  // 1. Components are updated from parent to child. (because parent is always
  //    created before the child)
  // 2. A component's user watchers are run before its render watcher (because
  //    user watchers are created before the render watcher)
  // 3. If a component is destroyed during a parent component's watcher run,
  //    its watchers can be skipped.
  queue.sort(function (a, b) { return a.id - b.id; });

  // do not cache length because more watchers might be pushed
  // as we run existing watchers
  for (index = 0; index < queue.length; index++) {
    watcher = queue[index];
    id = watcher.id;
    has[id] = null;
    watcher.run();
    // in dev build, check and stop circular updates.
    if ("development" !== 'production' && has[id] != null) {
      circular[id] = (circular[id] || 0) + 1;
      if (circular[id] > MAX_UPDATE_COUNT) {
        warn(
          'You may have an infinite update loop ' + (
            watcher.user
              ? ("in watcher with expression \"" + (watcher.expression) + "\"")
              : "in a component render function."
          ),
          watcher.vm
        );
        break
      }
    }
  }

  // keep copies of post queues before resetting state
  var activatedQueue = activatedChildren.slice();
  var updatedQueue = queue.slice();

  resetSchedulerState();

  // call component updated and activated hooks
  callActivatedHooks(activatedQueue);
  callUpdatedHooks(updatedQueue);

  // devtool hook
  /* istanbul ignore if */
  if (devtools && config.devtools) {
    devtools.emit('flush');
  }
}

function callUpdatedHooks (queue) {
  var i = queue.length;
  while (i--) {
    var watcher = queue[i];
    var vm = watcher.vm;
    if (vm._watcher === watcher && vm._isMounted) {
      callHook(vm, 'updated');
    }
  }
}

/**
 * Queue a kept-alive component that was activated during patch.
 * The queue will be processed after the entire tree has been patched.
 */
function queueActivatedComponent (vm) {
  // setting _inactive to false here so that a render function can
  // rely on checking whether it's in an inactive tree (e.g. router-view)
  vm._inactive = false;
  activatedChildren.push(vm);
}

function callActivatedHooks (queue) {
  for (var i = 0; i < queue.length; i++) {
    queue[i]._inactive = true;
    activateChildComponent(queue[i], true /* true */);
  }
}

/**
 * Push a watcher into the watcher queue.
 * Jobs with duplicate IDs will be skipped unless it's
 * pushed when the queue is being flushed.
 */
function queueWatcher (watcher) {
  var id = watcher.id;
  if (has[id] == null) {
    has[id] = true;
    if (!flushing) {
      queue.push(watcher);
    } else {
      // if already flushing, splice the watcher based on its id
      // if already past its id, it will be run next immediately.
      var i = queue.length - 1;
      while (i > index && queue[i].id > watcher.id) {
        i--;
      }
      queue.splice(i + 1, 0, watcher);
    }
    // queue the flush
    if (!waiting) {
      waiting = true;
      nextTick(flushSchedulerQueue);
    }
  }
}

/*  */

var uid$1 = 0;

/**
 * A watcher parses an expression, collects dependencies,
 * and fires callback when the expression value changes.
 * This is used for both the $watch() api and directives.
 */
var Watcher = function Watcher (
  vm,
  expOrFn,
  cb,
  options,
  isRenderWatcher
) {
  this.vm = vm;
  if (isRenderWatcher) {
    vm._watcher = this;
  }
  vm._watchers.push(this);
  // options
  if (options) {
    this.deep = !!options.deep;
    this.user = !!options.user;
    this.lazy = !!options.lazy;
    this.sync = !!options.sync;
  } else {
    this.deep = this.user = this.lazy = this.sync = false;
  }
  this.cb = cb;
  this.id = ++uid$1; // uid for batching
  this.active = true;
  this.dirty = this.lazy; // for lazy watchers
  this.deps = [];
  this.newDeps = [];
  this.depIds = new _Set();
  this.newDepIds = new _Set();
  this.expression =  true
    ? expOrFn.toString()
    : '';
  // parse expression for getter
  if (typeof expOrFn === 'function') {
    this.getter = expOrFn;
  } else {
    this.getter = parsePath(expOrFn);
    if (!this.getter) {
      this.getter = function () {};
      "development" !== 'production' && warn(
        "Failed watching path: \"" + expOrFn + "\" " +
        'Watcher only accepts simple dot-delimited paths. ' +
        'For full control, use a function instead.',
        vm
      );
    }
  }
  this.value = this.lazy
    ? undefined
    : this.get();
};

/**
 * Evaluate the getter, and re-collect dependencies.
 */
Watcher.prototype.get = function get () {
  pushTarget(this);
  var value;
  var vm = this.vm;
  try {
    value = this.getter.call(vm, vm);
  } catch (e) {
    if (this.user) {
      handleError(e, vm, ("getter for watcher \"" + (this.expression) + "\""));
    } else {
      throw e
    }
  } finally {
    // "touch" every property so they are all tracked as
    // dependencies for deep watching
    if (this.deep) {
      traverse(value);
    }
    popTarget();
    this.cleanupDeps();
  }
  return value
};

/**
 * Add a dependency to this directive.
 */
Watcher.prototype.addDep = function addDep (dep) {
  var id = dep.id;
  if (!this.newDepIds.has(id)) {
    this.newDepIds.add(id);
    this.newDeps.push(dep);
    if (!this.depIds.has(id)) {
      dep.addSub(this);
    }
  }
};

/**
 * Clean up for dependency collection.
 */
Watcher.prototype.cleanupDeps = function cleanupDeps () {
    var this$1 = this;

  var i = this.deps.length;
  while (i--) {
    var dep = this$1.deps[i];
    if (!this$1.newDepIds.has(dep.id)) {
      dep.removeSub(this$1);
    }
  }
  var tmp = this.depIds;
  this.depIds = this.newDepIds;
  this.newDepIds = tmp;
  this.newDepIds.clear();
  tmp = this.deps;
  this.deps = this.newDeps;
  this.newDeps = tmp;
  this.newDeps.length = 0;
};

/**
 * Subscriber interface.
 * Will be called when a dependency changes.
 */
Watcher.prototype.update = function update () {
  /* istanbul ignore else */
  if (this.lazy) {
    this.dirty = true;
  } else if (this.sync) {
    this.run();
  } else {
    queueWatcher(this);
  }
};

/**
 * Scheduler job interface.
 * Will be called by the scheduler.
 */
Watcher.prototype.run = function run () {
  if (this.active) {
    var value = this.get();
    if (
      value !== this.value ||
      // Deep watchers and watchers on Object/Arrays should fire even
      // when the value is the same, because the value may
      // have mutated.
      isObject(value) ||
      this.deep
    ) {
      // set new value
      var oldValue = this.value;
      this.value = value;
      if (this.user) {
        try {
          this.cb.call(this.vm, value, oldValue);
        } catch (e) {
          handleError(e, this.vm, ("callback for watcher \"" + (this.expression) + "\""));
        }
      } else {
        this.cb.call(this.vm, value, oldValue);
      }
    }
  }
};

/**
 * Evaluate the value of the watcher.
 * This only gets called for lazy watchers.
 */
Watcher.prototype.evaluate = function evaluate () {
  this.value = this.get();
  this.dirty = false;
};

/**
 * Depend on all deps collected by this watcher.
 */
Watcher.prototype.depend = function depend () {
    var this$1 = this;

  var i = this.deps.length;
  while (i--) {
    this$1.deps[i].depend();
  }
};

/**
 * Remove self from all dependencies' subscriber list.
 */
Watcher.prototype.teardown = function teardown () {
    var this$1 = this;

  if (this.active) {
    // remove self from vm's watcher list
    // this is a somewhat expensive operation so we skip it
    // if the vm is being destroyed.
    if (!this.vm._isBeingDestroyed) {
      remove(this.vm._watchers, this);
    }
    var i = this.deps.length;
    while (i--) {
      this$1.deps[i].removeSub(this$1);
    }
    this.active = false;
  }
};

/*  */

var sharedPropertyDefinition = {
  enumerable: true,
  configurable: true,
  get: noop,
  set: noop
};

function proxy (target, sourceKey, key) {
  sharedPropertyDefinition.get = function proxyGetter () {
    return this[sourceKey][key]
  };
  sharedPropertyDefinition.set = function proxySetter (val) {
    this[sourceKey][key] = val;
  };
  Object.defineProperty(target, key, sharedPropertyDefinition);
}

function initState (vm) {
  vm._watchers = [];
  var opts = vm.$options;
  if (opts.props) { initProps(vm, opts.props); }
  if (opts.methods) { initMethods(vm, opts.methods); }
  if (opts.data) {
    initData(vm);
  } else {
    observe(vm._data = {}, true /* asRootData */);
  }
  if (opts.computed) { initComputed(vm, opts.computed); }
  if (opts.watch && opts.watch !== nativeWatch) {
    initWatch(vm, opts.watch);
  }
}

function initProps (vm, propsOptions) {
  var propsData = vm.$options.propsData || {};
  var props = vm._props = {};
  // cache prop keys so that future props updates can iterate using Array
  // instead of dynamic object key enumeration.
  var keys = vm.$options._propKeys = [];
  var isRoot = !vm.$parent;
  // root instance props should be converted
  if (!isRoot) {
    toggleObserving(false);
  }
  var loop = function ( key ) {
    keys.push(key);
    var value = validateProp(key, propsOptions, propsData, vm);
    /* istanbul ignore else */
    if (true) {
      var hyphenatedKey = hyphenate(key);
      if (isReservedAttribute(hyphenatedKey) ||
          config.isReservedAttr(hyphenatedKey)) {
        warn(
          ("\"" + hyphenatedKey + "\" is a reserved attribute and cannot be used as component prop."),
          vm
        );
      }
      defineReactive(props, key, value, function () {
        if (vm.$parent && !isUpdatingChildComponent) {
          warn(
            "Avoid mutating a prop directly since the value will be " +
            "overwritten whenever the parent component re-renders. " +
            "Instead, use a data or computed property based on the prop's " +
            "value. Prop being mutated: \"" + key + "\"",
            vm
          );
        }
      });
    } else {
      defineReactive(props, key, value);
    }
    // static props are already proxied on the component's prototype
    // during Vue.extend(). We only need to proxy props defined at
    // instantiation here.
    if (!(key in vm)) {
      proxy(vm, "_props", key);
    }
  };

  for (var key in propsOptions) loop( key );
  toggleObserving(true);
}

function initData (vm) {
  var data = vm.$options.data;
  data = vm._data = typeof data === 'function'
    ? getData(data, vm)
    : data || {};
  if (!isPlainObject(data)) {
    data = {};
    "development" !== 'production' && warn(
      'data functions should return an object:\n' +
      'https://vuejs.org/v2/guide/components.html#data-Must-Be-a-Function',
      vm
    );
  }
  // proxy data on instance
  var keys = Object.keys(data);
  var props = vm.$options.props;
  var methods = vm.$options.methods;
  var i = keys.length;
  while (i--) {
    var key = keys[i];
    if (true) {
      if (methods && hasOwn(methods, key)) {
        warn(
          ("Method \"" + key + "\" has already been defined as a data property."),
          vm
        );
      }
    }
    if (props && hasOwn(props, key)) {
      "development" !== 'production' && warn(
        "The data property \"" + key + "\" is already declared as a prop. " +
        "Use prop default value instead.",
        vm
      );
    } else if (!isReserved(key)) {
      proxy(vm, "_data", key);
    }
  }
  // observe data
  observe(data, true /* asRootData */);
}

function getData (data, vm) {
  // #7573 disable dep collection when invoking data getters
  pushTarget();
  try {
    return data.call(vm, vm)
  } catch (e) {
    handleError(e, vm, "data()");
    return {}
  } finally {
    popTarget();
  }
}

var computedWatcherOptions = { lazy: true };

function initComputed (vm, computed) {
  // $flow-disable-line
  var watchers = vm._computedWatchers = Object.create(null);
  // computed properties are just getters during SSR
  var isSSR = isServerRendering();

  for (var key in computed) {
    var userDef = computed[key];
    var getter = typeof userDef === 'function' ? userDef : userDef.get;
    if ("development" !== 'production' && getter == null) {
      warn(
        ("Getter is missing for computed property \"" + key + "\"."),
        vm
      );
    }

    if (!isSSR) {
      // create internal watcher for the computed property.
      watchers[key] = new Watcher(
        vm,
        getter || noop,
        noop,
        computedWatcherOptions
      );
    }

    // component-defined computed properties are already defined on the
    // component prototype. We only need to define computed properties defined
    // at instantiation here.
    if (!(key in vm)) {
      defineComputed(vm, key, userDef);
    } else if (true) {
      if (key in vm.$data) {
        warn(("The computed property \"" + key + "\" is already defined in data."), vm);
      } else if (vm.$options.props && key in vm.$options.props) {
        warn(("The computed property \"" + key + "\" is already defined as a prop."), vm);
      }
    }
  }
}

function defineComputed (
  target,
  key,
  userDef
) {
  var shouldCache = !isServerRendering();
  if (typeof userDef === 'function') {
    sharedPropertyDefinition.get = shouldCache
      ? createComputedGetter(key)
      : userDef;
    sharedPropertyDefinition.set = noop;
  } else {
    sharedPropertyDefinition.get = userDef.get
      ? shouldCache && userDef.cache !== false
        ? createComputedGetter(key)
        : userDef.get
      : noop;
    sharedPropertyDefinition.set = userDef.set
      ? userDef.set
      : noop;
  }
  if ("development" !== 'production' &&
      sharedPropertyDefinition.set === noop) {
    sharedPropertyDefinition.set = function () {
      warn(
        ("Computed property \"" + key + "\" was assigned to but it has no setter."),
        this
      );
    };
  }
  Object.defineProperty(target, key, sharedPropertyDefinition);
}

function createComputedGetter (key) {
  return function computedGetter () {
    var watcher = this._computedWatchers && this._computedWatchers[key];
    if (watcher) {
      if (watcher.dirty) {
        watcher.evaluate();
      }
      if (Dep.target) {
        watcher.depend();
      }
      return watcher.value
    }
  }
}

function initMethods (vm, methods) {
  var props = vm.$options.props;
  for (var key in methods) {
    if (true) {
      if (methods[key] == null) {
        warn(
          "Method \"" + key + "\" has an undefined value in the component definition. " +
          "Did you reference the function correctly?",
          vm
        );
      }
      if (props && hasOwn(props, key)) {
        warn(
          ("Method \"" + key + "\" has already been defined as a prop."),
          vm
        );
      }
      if ((key in vm) && isReserved(key)) {
        warn(
          "Method \"" + key + "\" conflicts with an existing Vue instance method. " +
          "Avoid defining component methods that start with _ or $."
        );
      }
    }
    vm[key] = methods[key] == null ? noop : bind(methods[key], vm);
  }
}

function initWatch (vm, watch) {
  for (var key in watch) {
    var handler = watch[key];
    if (Array.isArray(handler)) {
      for (var i = 0; i < handler.length; i++) {
        createWatcher(vm, key, handler[i]);
      }
    } else {
      createWatcher(vm, key, handler);
    }
  }
}

function createWatcher (
  vm,
  expOrFn,
  handler,
  options
) {
  if (isPlainObject(handler)) {
    options = handler;
    handler = handler.handler;
  }
  if (typeof handler === 'string') {
    handler = vm[handler];
  }
  return vm.$watch(expOrFn, handler, options)
}

function stateMixin (Vue) {
  // flow somehow has problems with directly declared definition object
  // when using Object.defineProperty, so we have to procedurally build up
  // the object here.
  var dataDef = {};
  dataDef.get = function () { return this._data };
  var propsDef = {};
  propsDef.get = function () { return this._props };
  if (true) {
    dataDef.set = function (newData) {
      warn(
        'Avoid replacing instance root $data. ' +
        'Use nested data properties instead.',
        this
      );
    };
    propsDef.set = function () {
      warn("$props is readonly.", this);
    };
  }
  Object.defineProperty(Vue.prototype, '$data', dataDef);
  Object.defineProperty(Vue.prototype, '$props', propsDef);

  Vue.prototype.$set = set;
  Vue.prototype.$delete = del;

  Vue.prototype.$watch = function (
    expOrFn,
    cb,
    options
  ) {
    var vm = this;
    if (isPlainObject(cb)) {
      return createWatcher(vm, expOrFn, cb, options)
    }
    options = options || {};
    options.user = true;
    var watcher = new Watcher(vm, expOrFn, cb, options);
    if (options.immediate) {
      cb.call(vm, watcher.value);
    }
    return function unwatchFn () {
      watcher.teardown();
    }
  };
}

/*  */

function initProvide (vm) {
  var provide = vm.$options.provide;
  if (provide) {
    vm._provided = typeof provide === 'function'
      ? provide.call(vm)
      : provide;
  }
}

function initInjections (vm) {
  var result = resolveInject(vm.$options.inject, vm);
  if (result) {
    toggleObserving(false);
    Object.keys(result).forEach(function (key) {
      /* istanbul ignore else */
      if (true) {
        defineReactive(vm, key, result[key], function () {
          warn(
            "Avoid mutating an injected value directly since the changes will be " +
            "overwritten whenever the provided component re-renders. " +
            "injection being mutated: \"" + key + "\"",
            vm
          );
        });
      } else {
        defineReactive(vm, key, result[key]);
      }
    });
    toggleObserving(true);
  }
}

function resolveInject (inject, vm) {
  if (inject) {
    // inject is :any because flow is not smart enough to figure out cached
    var result = Object.create(null);
    var keys = hasSymbol
      ? Reflect.ownKeys(inject).filter(function (key) {
        /* istanbul ignore next */
        return Object.getOwnPropertyDescriptor(inject, key).enumerable
      })
      : Object.keys(inject);

    for (var i = 0; i < keys.length; i++) {
      var key = keys[i];
      var provideKey = inject[key].from;
      var source = vm;
      while (source) {
        if (source._provided && hasOwn(source._provided, provideKey)) {
          result[key] = source._provided[provideKey];
          break
        }
        source = source.$parent;
      }
      if (!source) {
        if ('default' in inject[key]) {
          var provideDefault = inject[key].default;
          result[key] = typeof provideDefault === 'function'
            ? provideDefault.call(vm)
            : provideDefault;
        } else if (true) {
          warn(("Injection \"" + key + "\" not found"), vm);
        }
      }
    }
    return result
  }
}

/*  */

/**
 * Runtime helper for rendering v-for lists.
 */
function renderList (
  val,
  render
) {
  var ret, i, l, keys, key;
  if (Array.isArray(val) || typeof val === 'string') {
    ret = new Array(val.length);
    for (i = 0, l = val.length; i < l; i++) {
      ret[i] = render(val[i], i);
    }
  } else if (typeof val === 'number') {
    ret = new Array(val);
    for (i = 0; i < val; i++) {
      ret[i] = render(i + 1, i);
    }
  } else if (isObject(val)) {
    keys = Object.keys(val);
    ret = new Array(keys.length);
    for (i = 0, l = keys.length; i < l; i++) {
      key = keys[i];
      ret[i] = render(val[key], key, i);
    }
  }
  if (isDef(ret)) {
    (ret)._isVList = true;
  }
  return ret
}

/*  */

/**
 * Runtime helper for rendering <slot>
 */
function renderSlot (
  name,
  fallback,
  props,
  bindObject
) {
  var scopedSlotFn = this.$scopedSlots[name];
  var nodes;
  if (scopedSlotFn) { // scoped slot
    props = props || {};
    if (bindObject) {
      if ("development" !== 'production' && !isObject(bindObject)) {
        warn(
          'slot v-bind without argument expects an Object',
          this
        );
      }
      props = extend(extend({}, bindObject), props);
    }
    nodes = scopedSlotFn(props) || fallback;
  } else {
    var slotNodes = this.$slots[name];
    // warn duplicate slot usage
    if (slotNodes) {
      if ("development" !== 'production' && slotNodes._rendered) {
        warn(
          "Duplicate presence of slot \"" + name + "\" found in the same render tree " +
          "- this will likely cause render errors.",
          this
        );
      }
      slotNodes._rendered = true;
    }
    nodes = slotNodes || fallback;
  }

  var target = props && props.slot;
  if (target) {
    return this.$createElement('template', { slot: target }, nodes)
  } else {
    return nodes
  }
}

/*  */

/**
 * Runtime helper for resolving filters
 */
function resolveFilter (id) {
  return resolveAsset(this.$options, 'filters', id, true) || identity
}

/*  */

function isKeyNotMatch (expect, actual) {
  if (Array.isArray(expect)) {
    return expect.indexOf(actual) === -1
  } else {
    return expect !== actual
  }
}

/**
 * Runtime helper for checking keyCodes from config.
 * exposed as Vue.prototype._k
 * passing in eventKeyName as last argument separately for backwards compat
 */
function checkKeyCodes (
  eventKeyCode,
  key,
  builtInKeyCode,
  eventKeyName,
  builtInKeyName
) {
  var mappedKeyCode = config.keyCodes[key] || builtInKeyCode;
  if (builtInKeyName && eventKeyName && !config.keyCodes[key]) {
    return isKeyNotMatch(builtInKeyName, eventKeyName)
  } else if (mappedKeyCode) {
    return isKeyNotMatch(mappedKeyCode, eventKeyCode)
  } else if (eventKeyName) {
    return hyphenate(eventKeyName) !== key
  }
}

/*  */

/**
 * Runtime helper for merging v-bind="object" into a VNode's data.
 */
function bindObjectProps (
  data,
  tag,
  value,
  asProp,
  isSync
) {
  if (value) {
    if (!isObject(value)) {
      "development" !== 'production' && warn(
        'v-bind without argument expects an Object or Array value',
        this
      );
    } else {
      if (Array.isArray(value)) {
        value = toObject(value);
      }
      var hash;
      var loop = function ( key ) {
        if (
          key === 'class' ||
          key === 'style' ||
          isReservedAttribute(key)
        ) {
          hash = data;
        } else {
          var type = data.attrs && data.attrs.type;
          hash = asProp || config.mustUseProp(tag, type, key)
            ? data.domProps || (data.domProps = {})
            : data.attrs || (data.attrs = {});
        }
        if (!(key in hash)) {
          hash[key] = value[key];

          if (isSync) {
            var on = data.on || (data.on = {});
            on[("update:" + key)] = function ($event) {
              value[key] = $event;
            };
          }
        }
      };

      for (var key in value) loop( key );
    }
  }
  return data
}

/*  */

/**
 * Runtime helper for rendering static trees.
 */
function renderStatic (
  index,
  isInFor
) {
  var cached = this._staticTrees || (this._staticTrees = []);
  var tree = cached[index];
  // if has already-rendered static tree and not inside v-for,
  // we can reuse the same tree.
  if (tree && !isInFor) {
    return tree
  }
  // otherwise, render a fresh tree.
  tree = cached[index] = this.$options.staticRenderFns[index].call(
    this._renderProxy,
    null,
    this // for render fns generated for functional component templates
  );
  markStatic(tree, ("__static__" + index), false);
  return tree
}

/**
 * Runtime helper for v-once.
 * Effectively it means marking the node as static with a unique key.
 */
function markOnce (
  tree,
  index,
  key
) {
  markStatic(tree, ("__once__" + index + (key ? ("_" + key) : "")), true);
  return tree
}

function markStatic (
  tree,
  key,
  isOnce
) {
  if (Array.isArray(tree)) {
    for (var i = 0; i < tree.length; i++) {
      if (tree[i] && typeof tree[i] !== 'string') {
        markStaticNode(tree[i], (key + "_" + i), isOnce);
      }
    }
  } else {
    markStaticNode(tree, key, isOnce);
  }
}

function markStaticNode (node, key, isOnce) {
  node.isStatic = true;
  node.key = key;
  node.isOnce = isOnce;
}

/*  */

function bindObjectListeners (data, value) {
  if (value) {
    if (!isPlainObject(value)) {
      "development" !== 'production' && warn(
        'v-on without argument expects an Object value',
        this
      );
    } else {
      var on = data.on = data.on ? extend({}, data.on) : {};
      for (var key in value) {
        var existing = on[key];
        var ours = value[key];
        on[key] = existing ? [].concat(existing, ours) : ours;
      }
    }
  }
  return data
}

/*  */

function installRenderHelpers (target) {
  target._o = markOnce;
  target._n = toNumber;
  target._s = toString;
  target._l = renderList;
  target._t = renderSlot;
  target._q = looseEqual;
  target._i = looseIndexOf;
  target._m = renderStatic;
  target._f = resolveFilter;
  target._k = checkKeyCodes;
  target._b = bindObjectProps;
  target._v = createTextVNode;
  target._e = createEmptyVNode;
  target._u = resolveScopedSlots;
  target._g = bindObjectListeners;
}

/*  */

function FunctionalRenderContext (
  data,
  props,
  children,
  parent,
  Ctor
) {
  var options = Ctor.options;
  // ensure the createElement function in functional components
  // gets a unique context - this is necessary for correct named slot check
  var contextVm;
  if (hasOwn(parent, '_uid')) {
    contextVm = Object.create(parent);
    // $flow-disable-line
    contextVm._original = parent;
  } else {
    // the context vm passed in is a functional context as well.
    // in this case we want to make sure we are able to get a hold to the
    // real context instance.
    contextVm = parent;
    // $flow-disable-line
    parent = parent._original;
  }
  var isCompiled = isTrue(options._compiled);
  var needNormalization = !isCompiled;

  this.data = data;
  this.props = props;
  this.children = children;
  this.parent = parent;
  this.listeners = data.on || emptyObject;
  this.injections = resolveInject(options.inject, parent);
  this.slots = function () { return resolveSlots(children, parent); };

  // support for compiled functional template
  if (isCompiled) {
    // exposing $options for renderStatic()
    this.$options = options;
    // pre-resolve slots for renderSlot()
    this.$slots = this.slots();
    this.$scopedSlots = data.scopedSlots || emptyObject;
  }

  if (options._scopeId) {
    this._c = function (a, b, c, d) {
      var vnode = createElement(contextVm, a, b, c, d, needNormalization);
      if (vnode && !Array.isArray(vnode)) {
        vnode.fnScopeId = options._scopeId;
        vnode.fnContext = parent;
      }
      return vnode
    };
  } else {
    this._c = function (a, b, c, d) { return createElement(contextVm, a, b, c, d, needNormalization); };
  }
}

installRenderHelpers(FunctionalRenderContext.prototype);

function createFunctionalComponent (
  Ctor,
  propsData,
  data,
  contextVm,
  children
) {
  var options = Ctor.options;
  var props = {};
  var propOptions = options.props;
  if (isDef(propOptions)) {
    for (var key in propOptions) {
      props[key] = validateProp(key, propOptions, propsData || emptyObject);
    }
  } else {
    if (isDef(data.attrs)) { mergeProps(props, data.attrs); }
    if (isDef(data.props)) { mergeProps(props, data.props); }
  }

  var renderContext = new FunctionalRenderContext(
    data,
    props,
    children,
    contextVm,
    Ctor
  );

  var vnode = options.render.call(null, renderContext._c, renderContext);

  if (vnode instanceof VNode) {
    return cloneAndMarkFunctionalResult(vnode, data, renderContext.parent, options)
  } else if (Array.isArray(vnode)) {
    var vnodes = normalizeChildren(vnode) || [];
    var res = new Array(vnodes.length);
    for (var i = 0; i < vnodes.length; i++) {
      res[i] = cloneAndMarkFunctionalResult(vnodes[i], data, renderContext.parent, options);
    }
    return res
  }
}

function cloneAndMarkFunctionalResult (vnode, data, contextVm, options) {
  // #7817 clone node before setting fnContext, otherwise if the node is reused
  // (e.g. it was from a cached normal slot) the fnContext causes named slots
  // that should not be matched to match.
  var clone = cloneVNode(vnode);
  clone.fnContext = contextVm;
  clone.fnOptions = options;
  if (data.slot) {
    (clone.data || (clone.data = {})).slot = data.slot;
  }
  return clone
}

function mergeProps (to, from) {
  for (var key in from) {
    to[camelize(key)] = from[key];
  }
}

/*  */




// Register the component hook to weex native render engine.
// The hook will be triggered by native, not javascript.


// Updates the state of the component to weex native render engine.

/*  */

// https://github.com/Hanks10100/weex-native-directive/tree/master/component

// listening on native callback

/*  */

/*  */

// inline hooks to be invoked on component VNodes during patch
var componentVNodeHooks = {
  init: function init (
    vnode,
    hydrating,
    parentElm,
    refElm
  ) {
    if (
      vnode.componentInstance &&
      !vnode.componentInstance._isDestroyed &&
      vnode.data.keepAlive
    ) {
      // kept-alive components, treat as a patch
      var mountedNode = vnode; // work around flow
      componentVNodeHooks.prepatch(mountedNode, mountedNode);
    } else {
      var child = vnode.componentInstance = createComponentInstanceForVnode(
        vnode,
        activeInstance,
        parentElm,
        refElm
      );
      child.$mount(hydrating ? vnode.elm : undefined, hydrating);
    }
  },

  prepatch: function prepatch (oldVnode, vnode) {
    var options = vnode.componentOptions;
    var child = vnode.componentInstance = oldVnode.componentInstance;
    updateChildComponent(
      child,
      options.propsData, // updated props
      options.listeners, // updated listeners
      vnode, // new parent vnode
      options.children // new children
    );
  },

  insert: function insert (vnode) {
    var context = vnode.context;
    var componentInstance = vnode.componentInstance;
    if (!componentInstance._isMounted) {
      componentInstance._isMounted = true;
      callHook(componentInstance, 'mounted');
    }
    if (vnode.data.keepAlive) {
      if (context._isMounted) {
        // vue-router#1212
        // During updates, a kept-alive component's child components may
        // change, so directly walking the tree here may call activated hooks
        // on incorrect children. Instead we push them into a queue which will
        // be processed after the whole patch process ended.
        queueActivatedComponent(componentInstance);
      } else {
        activateChildComponent(componentInstance, true /* direct */);
      }
    }
  },

  destroy: function destroy (vnode) {
    var componentInstance = vnode.componentInstance;
    if (!componentInstance._isDestroyed) {
      if (!vnode.data.keepAlive) {
        componentInstance.$destroy();
      } else {
        deactivateChildComponent(componentInstance, true /* direct */);
      }
    }
  }
};

var hooksToMerge = Object.keys(componentVNodeHooks);

function createComponent (
  Ctor,
  data,
  context,
  children,
  tag
) {
  if (isUndef(Ctor)) {
    return
  }

  var baseCtor = context.$options._base;

  // plain options object: turn it into a constructor
  if (isObject(Ctor)) {
    Ctor = baseCtor.extend(Ctor);
  }

  // if at this stage it's not a constructor or an async component factory,
  // reject.
  if (typeof Ctor !== 'function') {
    if (true) {
      warn(("Invalid Component definition: " + (String(Ctor))), context);
    }
    return
  }

  // async component
  var asyncFactory;
  if (isUndef(Ctor.cid)) {
    asyncFactory = Ctor;
    Ctor = resolveAsyncComponent(asyncFactory, baseCtor, context);
    if (Ctor === undefined) {
      // return a placeholder node for async component, which is rendered
      // as a comment node but preserves all the raw information for the node.
      // the information will be used for async server-rendering and hydration.
      return createAsyncPlaceholder(
        asyncFactory,
        data,
        context,
        children,
        tag
      )
    }
  }

  data = data || {};

  // resolve constructor options in case global mixins are applied after
  // component constructor creation
  resolveConstructorOptions(Ctor);

  // transform component v-model data into props & events
  if (isDef(data.model)) {
    transformModel(Ctor.options, data);
  }

  // extract props
  var propsData = extractPropsFromVNodeData(data, Ctor, tag);

  // functional component
  if (isTrue(Ctor.options.functional)) {
    return createFunctionalComponent(Ctor, propsData, data, context, children)
  }

  // extract listeners, since these needs to be treated as
  // child component listeners instead of DOM listeners
  var listeners = data.on;
  // replace with listeners with .native modifier
  // so it gets processed during parent component patch.
  data.on = data.nativeOn;

  if (isTrue(Ctor.options.abstract)) {
    // abstract components do not keep anything
    // other than props & listeners & slot

    // work around flow
    var slot = data.slot;
    data = {};
    if (slot) {
      data.slot = slot;
    }
  }

  // install component management hooks onto the placeholder node
  installComponentHooks(data);

  // return a placeholder vnode
  var name = Ctor.options.name || tag;
  var vnode = new VNode(
    ("vue-component-" + (Ctor.cid) + (name ? ("-" + name) : '')),
    data, undefined, undefined, undefined, context,
    { Ctor: Ctor, propsData: propsData, listeners: listeners, tag: tag, children: children },
    asyncFactory
  );

  // Weex specific: invoke recycle-list optimized @render function for
  // extracting cell-slot template.
  // https://github.com/Hanks10100/weex-native-directive/tree/master/component
  /* istanbul ignore if */
  return vnode
}

function createComponentInstanceForVnode (
  vnode, // we know it's MountedComponentVNode but flow doesn't
  parent, // activeInstance in lifecycle state
  parentElm,
  refElm
) {
  var options = {
    _isComponent: true,
    parent: parent,
    _parentVnode: vnode,
    _parentElm: parentElm || null,
    _refElm: refElm || null
  };
  // check inline-template render functions
  var inlineTemplate = vnode.data.inlineTemplate;
  if (isDef(inlineTemplate)) {
    options.render = inlineTemplate.render;
    options.staticRenderFns = inlineTemplate.staticRenderFns;
  }
  return new vnode.componentOptions.Ctor(options)
}

function installComponentHooks (data) {
  var hooks = data.hook || (data.hook = {});
  for (var i = 0; i < hooksToMerge.length; i++) {
    var key = hooksToMerge[i];
    hooks[key] = componentVNodeHooks[key];
  }
}

// transform component v-model info (value and callback) into
// prop and event handler respectively.
function transformModel (options, data) {
  var prop = (options.model && options.model.prop) || 'value';
  var event = (options.model && options.model.event) || 'input';(data.props || (data.props = {}))[prop] = data.model.value;
  var on = data.on || (data.on = {});
  if (isDef(on[event])) {
    on[event] = [data.model.callback].concat(on[event]);
  } else {
    on[event] = data.model.callback;
  }
}

/*  */

var SIMPLE_NORMALIZE = 1;
var ALWAYS_NORMALIZE = 2;

// wrapper function for providing a more flexible interface
// without getting yelled at by flow
function createElement (
  context,
  tag,
  data,
  children,
  normalizationType,
  alwaysNormalize
) {
  if (Array.isArray(data) || isPrimitive(data)) {
    normalizationType = children;
    children = data;
    data = undefined;
  }
  if (isTrue(alwaysNormalize)) {
    normalizationType = ALWAYS_NORMALIZE;
  }
  return _createElement(context, tag, data, children, normalizationType)
}

function _createElement (
  context,
  tag,
  data,
  children,
  normalizationType
) {
  if (isDef(data) && isDef((data).__ob__)) {
    "development" !== 'production' && warn(
      "Avoid using observed data object as vnode data: " + (JSON.stringify(data)) + "\n" +
      'Always create fresh vnode data objects in each render!',
      context
    );
    return createEmptyVNode()
  }
  // object syntax in v-bind
  if (isDef(data) && isDef(data.is)) {
    tag = data.is;
  }
  if (!tag) {
    // in case of component :is set to falsy value
    return createEmptyVNode()
  }
  // warn against non-primitive key
  if ("development" !== 'production' &&
    isDef(data) && isDef(data.key) && !isPrimitive(data.key)
  ) {
    {
      warn(
        'Avoid using non-primitive value as key, ' +
        'use string/number value instead.',
        context
      );
    }
  }
  // support single function children as default scoped slot
  if (Array.isArray(children) &&
    typeof children[0] === 'function'
  ) {
    data = data || {};
    data.scopedSlots = { default: children[0] };
    children.length = 0;
  }
  if (normalizationType === ALWAYS_NORMALIZE) {
    children = normalizeChildren(children);
  } else if (normalizationType === SIMPLE_NORMALIZE) {
    children = simpleNormalizeChildren(children);
  }
  var vnode, ns;
  if (typeof tag === 'string') {
    var Ctor;
    ns = (context.$vnode && context.$vnode.ns) || config.getTagNamespace(tag);
    if (config.isReservedTag(tag)) {
      // platform built-in elements
      vnode = new VNode(
        config.parsePlatformTagName(tag), data, children,
        undefined, undefined, context
      );
    } else if (isDef(Ctor = resolveAsset(context.$options, 'components', tag))) {
      // component
      vnode = createComponent(Ctor, data, context, children, tag);
    } else {
      // unknown or unlisted namespaced elements
      // check at runtime because it may get assigned a namespace when its
      // parent normalizes children
      vnode = new VNode(
        tag, data, children,
        undefined, undefined, context
      );
    }
  } else {
    // direct component options / constructor
    vnode = createComponent(tag, data, context, children);
  }
  if (Array.isArray(vnode)) {
    return vnode
  } else if (isDef(vnode)) {
    if (isDef(ns)) { applyNS(vnode, ns); }
    if (isDef(data)) { registerDeepBindings(data); }
    return vnode
  } else {
    return createEmptyVNode()
  }
}

function applyNS (vnode, ns, force) {
  vnode.ns = ns;
  if (vnode.tag === 'foreignObject') {
    // use default namespace inside foreignObject
    ns = undefined;
    force = true;
  }
  if (isDef(vnode.children)) {
    for (var i = 0, l = vnode.children.length; i < l; i++) {
      var child = vnode.children[i];
      if (isDef(child.tag) && (
        isUndef(child.ns) || (isTrue(force) && child.tag !== 'svg'))) {
        applyNS(child, ns, force);
      }
    }
  }
}

// ref #5318
// necessary to ensure parent re-render when deep bindings like :style and
// :class are used on slot nodes
function registerDeepBindings (data) {
  if (isObject(data.style)) {
    traverse(data.style);
  }
  if (isObject(data.class)) {
    traverse(data.class);
  }
}

/*  */

function initRender (vm) {
  vm._vnode = null; // the root of the child tree
  vm._staticTrees = null; // v-once cached trees
  var options = vm.$options;
  var parentVnode = vm.$vnode = options._parentVnode; // the placeholder node in parent tree
  var renderContext = parentVnode && parentVnode.context;
  vm.$slots = resolveSlots(options._renderChildren, renderContext);
  vm.$scopedSlots = emptyObject;
  // bind the createElement fn to this instance
  // so that we get proper render context inside it.
  // args order: tag, data, children, normalizationType, alwaysNormalize
  // internal version is used by render functions compiled from templates
  vm._c = function (a, b, c, d) { return createElement(vm, a, b, c, d, false); };
  // normalization is always applied for the public version, used in
  // user-written render functions.
  vm.$createElement = function (a, b, c, d) { return createElement(vm, a, b, c, d, true); };

  // $attrs & $listeners are exposed for easier HOC creation.
  // they need to be reactive so that HOCs using them are always updated
  var parentData = parentVnode && parentVnode.data;

  /* istanbul ignore else */
  if (true) {
    defineReactive(vm, '$attrs', parentData && parentData.attrs || emptyObject, function () {
      !isUpdatingChildComponent && warn("$attrs is readonly.", vm);
    }, true);
    defineReactive(vm, '$listeners', options._parentListeners || emptyObject, function () {
      !isUpdatingChildComponent && warn("$listeners is readonly.", vm);
    }, true);
  } else {
    defineReactive(vm, '$attrs', parentData && parentData.attrs || emptyObject, null, true);
    defineReactive(vm, '$listeners', options._parentListeners || emptyObject, null, true);
  }
}

function renderMixin (Vue) {
  // install runtime convenience helpers
  installRenderHelpers(Vue.prototype);

  Vue.prototype.$nextTick = function (fn) {
    return nextTick(fn, this)
  };

  Vue.prototype._render = function () {
    var vm = this;
    var ref = vm.$options;
    var render = ref.render;
    var _parentVnode = ref._parentVnode;

    // reset _rendered flag on slots for duplicate slot check
    if (true) {
      for (var key in vm.$slots) {
        // $flow-disable-line
        vm.$slots[key]._rendered = false;
      }
    }

    if (_parentVnode) {
      vm.$scopedSlots = _parentVnode.data.scopedSlots || emptyObject;
    }

    // set parent vnode. this allows render functions to have access
    // to the data on the placeholder node.
    vm.$vnode = _parentVnode;
    // render self
    var vnode;
    try {
      vnode = render.call(vm._renderProxy, vm.$createElement);
    } catch (e) {
      handleError(e, vm, "render");
      // return error render result,
      // or previous vnode to prevent render error causing blank component
      /* istanbul ignore else */
      if (true) {
        if (vm.$options.renderError) {
          try {
            vnode = vm.$options.renderError.call(vm._renderProxy, vm.$createElement, e);
          } catch (e) {
            handleError(e, vm, "renderError");
            vnode = vm._vnode;
          }
        } else {
          vnode = vm._vnode;
        }
      } else {
        vnode = vm._vnode;
      }
    }
    // return empty vnode in case the render function errored out
    if (!(vnode instanceof VNode)) {
      if ("development" !== 'production' && Array.isArray(vnode)) {
        warn(
          'Multiple root nodes returned from render function. Render function ' +
          'should return a single root node.',
          vm
        );
      }
      vnode = createEmptyVNode();
    }
    // set parent
    vnode.parent = _parentVnode;
    return vnode
  };
}

/*  */

var uid$3 = 0;

function initMixin (Vue) {
  Vue.prototype._init = function (options) {
    var vm = this;
    // a uid
    vm._uid = uid$3++;

    var startTag, endTag;
    /* istanbul ignore if */
    if ("development" !== 'production' && config.performance && mark) {
      startTag = "vue-perf-start:" + (vm._uid);
      endTag = "vue-perf-end:" + (vm._uid);
      mark(startTag);
    }

    // a flag to avoid this being observed
    vm._isVue = true;
    // merge options
    if (options && options._isComponent) {
      // optimize internal component instantiation
      // since dynamic options merging is pretty slow, and none of the
      // internal component options needs special treatment.
      initInternalComponent(vm, options);
    } else {
      vm.$options = mergeOptions(
        resolveConstructorOptions(vm.constructor),
        options || {},
        vm
      );
    }
    /* istanbul ignore else */
    if (true) {
      initProxy(vm);
    } else {
      vm._renderProxy = vm;
    }
    // expose real self
    vm._self = vm;
    initLifecycle(vm);
    initEvents(vm);
    initRender(vm);
    callHook(vm, 'beforeCreate');
    initInjections(vm); // resolve injections before data/props
    initState(vm);
    initProvide(vm); // resolve provide after data/props
    callHook(vm, 'created');

    /* istanbul ignore if */
    if ("development" !== 'production' && config.performance && mark) {
      vm._name = formatComponentName(vm, false);
      mark(endTag);
      measure(("vue " + (vm._name) + " init"), startTag, endTag);
    }

    if (vm.$options.el) {
      vm.$mount(vm.$options.el);
    }
  };
}

function initInternalComponent (vm, options) {
  var opts = vm.$options = Object.create(vm.constructor.options);
  // doing this because it's faster than dynamic enumeration.
  var parentVnode = options._parentVnode;
  opts.parent = options.parent;
  opts._parentVnode = parentVnode;
  opts._parentElm = options._parentElm;
  opts._refElm = options._refElm;

  var vnodeComponentOptions = parentVnode.componentOptions;
  opts.propsData = vnodeComponentOptions.propsData;
  opts._parentListeners = vnodeComponentOptions.listeners;
  opts._renderChildren = vnodeComponentOptions.children;
  opts._componentTag = vnodeComponentOptions.tag;

  if (options.render) {
    opts.render = options.render;
    opts.staticRenderFns = options.staticRenderFns;
  }
}

function resolveConstructorOptions (Ctor) {
  var options = Ctor.options;
  if (Ctor.super) {
    var superOptions = resolveConstructorOptions(Ctor.super);
    var cachedSuperOptions = Ctor.superOptions;
    if (superOptions !== cachedSuperOptions) {
      // super option changed,
      // need to resolve new options.
      Ctor.superOptions = superOptions;
      // check if there are any late-modified/attached options (#4976)
      var modifiedOptions = resolveModifiedOptions(Ctor);
      // update base extend options
      if (modifiedOptions) {
        extend(Ctor.extendOptions, modifiedOptions);
      }
      options = Ctor.options = mergeOptions(superOptions, Ctor.extendOptions);
      if (options.name) {
        options.components[options.name] = Ctor;
      }
    }
  }
  return options
}

function resolveModifiedOptions (Ctor) {
  var modified;
  var latest = Ctor.options;
  var extended = Ctor.extendOptions;
  var sealed = Ctor.sealedOptions;
  for (var key in latest) {
    if (latest[key] !== sealed[key]) {
      if (!modified) { modified = {}; }
      modified[key] = dedupe(latest[key], extended[key], sealed[key]);
    }
  }
  return modified
}

function dedupe (latest, extended, sealed) {
  // compare latest and sealed to ensure lifecycle hooks won't be duplicated
  // between merges
  if (Array.isArray(latest)) {
    var res = [];
    sealed = Array.isArray(sealed) ? sealed : [sealed];
    extended = Array.isArray(extended) ? extended : [extended];
    for (var i = 0; i < latest.length; i++) {
      // push original options and not sealed options to exclude duplicated options
      if (extended.indexOf(latest[i]) >= 0 || sealed.indexOf(latest[i]) < 0) {
        res.push(latest[i]);
      }
    }
    return res
  } else {
    return latest
  }
}

function Vue (options) {
  if ("development" !== 'production' &&
    !(this instanceof Vue)
  ) {
    warn('Vue is a constructor and should be called with the `new` keyword');
  }
  this._init(options);
}

initMixin(Vue);
stateMixin(Vue);
eventsMixin(Vue);
lifecycleMixin(Vue);
renderMixin(Vue);

/*  */

function initUse (Vue) {
  Vue.use = function (plugin) {
    var installedPlugins = (this._installedPlugins || (this._installedPlugins = []));
    if (installedPlugins.indexOf(plugin) > -1) {
      return this
    }

    // additional parameters
    var args = toArray(arguments, 1);
    args.unshift(this);
    if (typeof plugin.install === 'function') {
      plugin.install.apply(plugin, args);
    } else if (typeof plugin === 'function') {
      plugin.apply(null, args);
    }
    installedPlugins.push(plugin);
    return this
  };
}

/*  */

function initMixin$1 (Vue) {
  Vue.mixin = function (mixin) {
    this.options = mergeOptions(this.options, mixin);
    return this
  };
}

/*  */

function initExtend (Vue) {
  /**
   * Each instance constructor, including Vue, has a unique
   * cid. This enables us to create wrapped "child
   * constructors" for prototypal inheritance and cache them.
   */
  Vue.cid = 0;
  var cid = 1;

  /**
   * Class inheritance
   */
  Vue.extend = function (extendOptions) {
    extendOptions = extendOptions || {};
    var Super = this;
    var SuperId = Super.cid;
    var cachedCtors = extendOptions._Ctor || (extendOptions._Ctor = {});
    if (cachedCtors[SuperId]) {
      return cachedCtors[SuperId]
    }

    var name = extendOptions.name || Super.options.name;
    if ("development" !== 'production' && name) {
      validateComponentName(name);
    }

    var Sub = function VueComponent (options) {
      this._init(options);
    };
    Sub.prototype = Object.create(Super.prototype);
    Sub.prototype.constructor = Sub;
    Sub.cid = cid++;
    Sub.options = mergeOptions(
      Super.options,
      extendOptions
    );
    Sub['super'] = Super;

    // For props and computed properties, we define the proxy getters on
    // the Vue instances at extension time, on the extended prototype. This
    // avoids Object.defineProperty calls for each instance created.
    if (Sub.options.props) {
      initProps$1(Sub);
    }
    if (Sub.options.computed) {
      initComputed$1(Sub);
    }

    // allow further extension/mixin/plugin usage
    Sub.extend = Super.extend;
    Sub.mixin = Super.mixin;
    Sub.use = Super.use;

    // create asset registers, so extended classes
    // can have their private assets too.
    ASSET_TYPES.forEach(function (type) {
      Sub[type] = Super[type];
    });
    // enable recursive self-lookup
    if (name) {
      Sub.options.components[name] = Sub;
    }

    // keep a reference to the super options at extension time.
    // later at instantiation we can check if Super's options have
    // been updated.
    Sub.superOptions = Super.options;
    Sub.extendOptions = extendOptions;
    Sub.sealedOptions = extend({}, Sub.options);

    // cache constructor
    cachedCtors[SuperId] = Sub;
    return Sub
  };
}

function initProps$1 (Comp) {
  var props = Comp.options.props;
  for (var key in props) {
    proxy(Comp.prototype, "_props", key);
  }
}

function initComputed$1 (Comp) {
  var computed = Comp.options.computed;
  for (var key in computed) {
    defineComputed(Comp.prototype, key, computed[key]);
  }
}

/*  */

function initAssetRegisters (Vue) {
  /**
   * Create asset registration methods.
   */
  ASSET_TYPES.forEach(function (type) {
    Vue[type] = function (
      id,
      definition
    ) {
      if (!definition) {
        return this.options[type + 's'][id]
      } else {
        /* istanbul ignore if */
        if ("development" !== 'production' && type === 'component') {
          validateComponentName(id);
        }
        if (type === 'component' && isPlainObject(definition)) {
          definition.name = definition.name || id;
          definition = this.options._base.extend(definition);
        }
        if (type === 'directive' && typeof definition === 'function') {
          definition = { bind: definition, update: definition };
        }
        this.options[type + 's'][id] = definition;
        return definition
      }
    };
  });
}

/*  */

function getComponentName (opts) {
  return opts && (opts.Ctor.options.name || opts.tag)
}

function matches (pattern, name) {
  if (Array.isArray(pattern)) {
    return pattern.indexOf(name) > -1
  } else if (typeof pattern === 'string') {
    return pattern.split(',').indexOf(name) > -1
  } else if (isRegExp(pattern)) {
    return pattern.test(name)
  }
  /* istanbul ignore next */
  return false
}

function pruneCache (keepAliveInstance, filter) {
  var cache = keepAliveInstance.cache;
  var keys = keepAliveInstance.keys;
  var _vnode = keepAliveInstance._vnode;
  for (var key in cache) {
    var cachedNode = cache[key];
    if (cachedNode) {
      var name = getComponentName(cachedNode.componentOptions);
      if (name && !filter(name)) {
        pruneCacheEntry(cache, key, keys, _vnode);
      }
    }
  }
}

function pruneCacheEntry (
  cache,
  key,
  keys,
  current
) {
  var cached$$1 = cache[key];
  if (cached$$1 && (!current || cached$$1.tag !== current.tag)) {
    cached$$1.componentInstance.$destroy();
  }
  cache[key] = null;
  remove(keys, key);
}

var patternTypes = [String, RegExp, Array];

var KeepAlive = {
  name: 'keep-alive',
  abstract: true,

  props: {
    include: patternTypes,
    exclude: patternTypes,
    max: [String, Number]
  },

  created: function created () {
    this.cache = Object.create(null);
    this.keys = [];
  },

  destroyed: function destroyed () {
    var this$1 = this;

    for (var key in this$1.cache) {
      pruneCacheEntry(this$1.cache, key, this$1.keys);
    }
  },

  mounted: function mounted () {
    var this$1 = this;

    this.$watch('include', function (val) {
      pruneCache(this$1, function (name) { return matches(val, name); });
    });
    this.$watch('exclude', function (val) {
      pruneCache(this$1, function (name) { return !matches(val, name); });
    });
  },

  render: function render () {
    var slot = this.$slots.default;
    var vnode = getFirstComponentChild(slot);
    var componentOptions = vnode && vnode.componentOptions;
    if (componentOptions) {
      // check pattern
      var name = getComponentName(componentOptions);
      var ref = this;
      var include = ref.include;
      var exclude = ref.exclude;
      if (
        // not included
        (include && (!name || !matches(include, name))) ||
        // excluded
        (exclude && name && matches(exclude, name))
      ) {
        return vnode
      }

      var ref$1 = this;
      var cache = ref$1.cache;
      var keys = ref$1.keys;
      var key = vnode.key == null
        // same constructor may get registered as different local components
        // so cid alone is not enough (#3269)
        ? componentOptions.Ctor.cid + (componentOptions.tag ? ("::" + (componentOptions.tag)) : '')
        : vnode.key;
      if (cache[key]) {
        vnode.componentInstance = cache[key].componentInstance;
        // make current key freshest
        remove(keys, key);
        keys.push(key);
      } else {
        cache[key] = vnode;
        keys.push(key);
        // prune oldest entry
        if (this.max && keys.length > parseInt(this.max)) {
          pruneCacheEntry(cache, keys[0], keys, this._vnode);
        }
      }

      vnode.data.keepAlive = true;
    }
    return vnode || (slot && slot[0])
  }
}

var builtInComponents = {
  KeepAlive: KeepAlive
}

/*  */

function initGlobalAPI (Vue) {
  // config
  var configDef = {};
  configDef.get = function () { return config; };
  if (true) {
    configDef.set = function () {
      warn(
        'Do not replace the Vue.config object, set individual fields instead.'
      );
    };
  }
  Object.defineProperty(Vue, 'config', configDef);

  // exposed util methods.
  // NOTE: these are not considered part of the public API - avoid relying on
  // them unless you are aware of the risk.
  Vue.util = {
    warn: warn,
    extend: extend,
    mergeOptions: mergeOptions,
    defineReactive: defineReactive
  };

  Vue.set = set;
  Vue.delete = del;
  Vue.nextTick = nextTick;

  Vue.options = Object.create(null);
  ASSET_TYPES.forEach(function (type) {
    Vue.options[type + 's'] = Object.create(null);
  });

  // this is used to identify the "base" constructor to extend all plain-object
  // components with in Weex's multi-instance scenarios.
  Vue.options._base = Vue;

  extend(Vue.options.components, builtInComponents);

  initUse(Vue);
  initMixin$1(Vue);
  initExtend(Vue);
  initAssetRegisters(Vue);
}

initGlobalAPI(Vue);

Object.defineProperty(Vue.prototype, '$isServer', {
  get: isServerRendering
});

Object.defineProperty(Vue.prototype, '$ssrContext', {
  get: function get () {
    /* istanbul ignore next */
    return this.$vnode && this.$vnode.ssrContext
  }
});

// expose FunctionalRenderContext for ssr runtime helper installation
Object.defineProperty(Vue, 'FunctionalRenderContext', {
  value: FunctionalRenderContext
});

Vue.version = '2.5.17';

/*  */

// these are reserved for web because they are directly compiled away
// during template compilation
var isReservedAttr = makeMap('style,class');

// attributes that should be using props for binding
var acceptValue = makeMap('input,textarea,option,select,progress');
var mustUseProp = function (tag, type, attr) {
  return (
    (attr === 'value' && acceptValue(tag)) && type !== 'button' ||
    (attr === 'selected' && tag === 'option') ||
    (attr === 'checked' && tag === 'input') ||
    (attr === 'muted' && tag === 'video')
  )
};

var isEnumeratedAttr = makeMap('contenteditable,draggable,spellcheck');

var isBooleanAttr = makeMap(
  'allowfullscreen,async,autofocus,autoplay,checked,compact,controls,declare,' +
  'default,defaultchecked,defaultmuted,defaultselected,defer,disabled,' +
  'enabled,formnovalidate,hidden,indeterminate,inert,ismap,itemscope,loop,multiple,' +
  'muted,nohref,noresize,noshade,novalidate,nowrap,open,pauseonexit,readonly,' +
  'required,reversed,scoped,seamless,selected,sortable,translate,' +
  'truespeed,typemustmatch,visible'
);

var xlinkNS = 'http://www.w3.org/1999/xlink';

var isXlink = function (name) {
  return name.charAt(5) === ':' && name.slice(0, 5) === 'xlink'
};

var getXlinkProp = function (name) {
  return isXlink(name) ? name.slice(6, name.length) : ''
};

var isFalsyAttrValue = function (val) {
  return val == null || val === false
};

/*  */

function genClassForVnode (vnode) {
  var data = vnode.data;
  var parentNode = vnode;
  var childNode = vnode;
  while (isDef(childNode.componentInstance)) {
    childNode = childNode.componentInstance._vnode;
    if (childNode && childNode.data) {
      data = mergeClassData(childNode.data, data);
    }
  }
  while (isDef(parentNode = parentNode.parent)) {
    if (parentNode && parentNode.data) {
      data = mergeClassData(data, parentNode.data);
    }
  }
  return renderClass(data.staticClass, data.class)
}

function mergeClassData (child, parent) {
  return {
    staticClass: concat(child.staticClass, parent.staticClass),
    class: isDef(child.class)
      ? [child.class, parent.class]
      : parent.class
  }
}

function renderClass (
  staticClass,
  dynamicClass
) {
  if (isDef(staticClass) || isDef(dynamicClass)) {
    return concat(staticClass, stringifyClass(dynamicClass))
  }
  /* istanbul ignore next */
  return ''
}

function concat (a, b) {
  return a ? b ? (a + ' ' + b) : a : (b || '')
}

function stringifyClass (value) {
  if (Array.isArray(value)) {
    return stringifyArray(value)
  }
  if (isObject(value)) {
    return stringifyObject(value)
  }
  if (typeof value === 'string') {
    return value
  }
  /* istanbul ignore next */
  return ''
}

function stringifyArray (value) {
  var res = '';
  var stringified;
  for (var i = 0, l = value.length; i < l; i++) {
    if (isDef(stringified = stringifyClass(value[i])) && stringified !== '') {
      if (res) { res += ' '; }
      res += stringified;
    }
  }
  return res
}

function stringifyObject (value) {
  var res = '';
  for (var key in value) {
    if (value[key]) {
      if (res) { res += ' '; }
      res += key;
    }
  }
  return res
}

/*  */

var namespaceMap = {
  svg: 'http://www.w3.org/2000/svg',
  math: 'http://www.w3.org/1998/Math/MathML'
};

var isHTMLTag = makeMap(
  'html,body,base,head,link,meta,style,title,' +
  'address,article,aside,footer,header,h1,h2,h3,h4,h5,h6,hgroup,nav,section,' +
  'div,dd,dl,dt,figcaption,figure,picture,hr,img,li,main,ol,p,pre,ul,' +
  'a,b,abbr,bdi,bdo,br,cite,code,data,dfn,em,i,kbd,mark,q,rp,rt,rtc,ruby,' +
  's,samp,small,span,strong,sub,sup,time,u,var,wbr,area,audio,map,track,video,' +
  'embed,object,param,source,canvas,script,noscript,del,ins,' +
  'caption,col,colgroup,table,thead,tbody,td,th,tr,' +
  'button,datalist,fieldset,form,input,label,legend,meter,optgroup,option,' +
  'output,progress,select,textarea,' +
  'details,dialog,menu,menuitem,summary,' +
  'content,element,shadow,template,blockquote,iframe,tfoot'
);

// this map is intentionally selective, only covering SVG elements that may
// contain child elements.
var isSVG = makeMap(
  'svg,animate,circle,clippath,cursor,defs,desc,ellipse,filter,font-face,' +
  'foreignObject,g,glyph,image,line,marker,mask,missing-glyph,path,pattern,' +
  'polygon,polyline,rect,switch,symbol,text,textpath,tspan,use,view',
  true
);

var isPreTag = function (tag) { return tag === 'pre'; };

var isReservedTag = function (tag) {
  return isHTMLTag(tag) || isSVG(tag)
};

function getTagNamespace (tag) {
  if (isSVG(tag)) {
    return 'svg'
  }
  // basic support for MathML
  // note it doesn't support other MathML elements being component roots
  if (tag === 'math') {
    return 'math'
  }
}

var unknownElementCache = Object.create(null);
function isUnknownElement (tag) {
  /* istanbul ignore if */
  if (!inBrowser) {
    return true
  }
  if (isReservedTag(tag)) {
    return false
  }
  tag = tag.toLowerCase();
  /* istanbul ignore if */
  if (unknownElementCache[tag] != null) {
    return unknownElementCache[tag]
  }
  var el = document.createElement(tag);
  if (tag.indexOf('-') > -1) {
    // http://stackoverflow.com/a/28210364/1070244
    return (unknownElementCache[tag] = (
      el.constructor === window.HTMLUnknownElement ||
      el.constructor === window.HTMLElement
    ))
  } else {
    return (unknownElementCache[tag] = /HTMLUnknownElement/.test(el.toString()))
  }
}

var isTextInputType = makeMap('text,number,password,search,email,tel,url');

/*  */

/**
 * Query an element selector if it's not an element already.
 */
function query (el) {
  if (typeof el === 'string') {
    var selected = document.querySelector(el);
    if (!selected) {
      "development" !== 'production' && warn(
        'Cannot find element: ' + el
      );
      return document.createElement('div')
    }
    return selected
  } else {
    return el
  }
}

/*  */

function createElement$1 (tagName, vnode) {
  var elm = document.createElement(tagName);
  if (tagName !== 'select') {
    return elm
  }
  // false or null will remove the attribute but undefined will not
  if (vnode.data && vnode.data.attrs && vnode.data.attrs.multiple !== undefined) {
    elm.setAttribute('multiple', 'multiple');
  }
  return elm
}

function createElementNS (namespace, tagName) {
  return document.createElementNS(namespaceMap[namespace], tagName)
}

function createTextNode (text) {
  return document.createTextNode(text)
}

function createComment (text) {
  return document.createComment(text)
}

function insertBefore (parentNode, newNode, referenceNode) {
  parentNode.insertBefore(newNode, referenceNode);
}

function removeChild (node, child) {
  node.removeChild(child);
}

function appendChild (node, child) {
  node.appendChild(child);
}

function parentNode (node) {
  return node.parentNode
}

function nextSibling (node) {
  return node.nextSibling
}

function tagName (node) {
  return node.tagName
}

function setTextContent (node, text) {
  node.textContent = text;
}

function setStyleScope (node, scopeId) {
  node.setAttribute(scopeId, '');
}


var nodeOps = Object.freeze({
	createElement: createElement$1,
	createElementNS: createElementNS,
	createTextNode: createTextNode,
	createComment: createComment,
	insertBefore: insertBefore,
	removeChild: removeChild,
	appendChild: appendChild,
	parentNode: parentNode,
	nextSibling: nextSibling,
	tagName: tagName,
	setTextContent: setTextContent,
	setStyleScope: setStyleScope
});

/*  */

var ref = {
  create: function create (_, vnode) {
    registerRef(vnode);
  },
  update: function update (oldVnode, vnode) {
    if (oldVnode.data.ref !== vnode.data.ref) {
      registerRef(oldVnode, true);
      registerRef(vnode);
    }
  },
  destroy: function destroy (vnode) {
    registerRef(vnode, true);
  }
}

function registerRef (vnode, isRemoval) {
  var key = vnode.data.ref;
  if (!isDef(key)) { return }

  var vm = vnode.context;
  var ref = vnode.componentInstance || vnode.elm;
  var refs = vm.$refs;
  if (isRemoval) {
    if (Array.isArray(refs[key])) {
      remove(refs[key], ref);
    } else if (refs[key] === ref) {
      refs[key] = undefined;
    }
  } else {
    if (vnode.data.refInFor) {
      if (!Array.isArray(refs[key])) {
        refs[key] = [ref];
      } else if (refs[key].indexOf(ref) < 0) {
        // $flow-disable-line
        refs[key].push(ref);
      }
    } else {
      refs[key] = ref;
    }
  }
}

/**
 * Virtual DOM patching algorithm based on Snabbdom by
 * Simon Friis Vindum (@paldepind)
 * Licensed under the MIT License
 * https://github.com/paldepind/snabbdom/blob/master/LICENSE
 *
 * modified by Evan You (@yyx990803)
 *
 * Not type-checking this because this file is perf-critical and the cost
 * of making flow understand it is not worth it.
 */

var emptyNode = new VNode('', {}, []);

var hooks = ['create', 'activate', 'update', 'remove', 'destroy'];

function sameVnode (a, b) {
  return (
    a.key === b.key && (
      (
        a.tag === b.tag &&
        a.isComment === b.isComment &&
        isDef(a.data) === isDef(b.data) &&
        sameInputType(a, b)
      ) || (
        isTrue(a.isAsyncPlaceholder) &&
        a.asyncFactory === b.asyncFactory &&
        isUndef(b.asyncFactory.error)
      )
    )
  )
}

function sameInputType (a, b) {
  if (a.tag !== 'input') { return true }
  var i;
  var typeA = isDef(i = a.data) && isDef(i = i.attrs) && i.type;
  var typeB = isDef(i = b.data) && isDef(i = i.attrs) && i.type;
  return typeA === typeB || isTextInputType(typeA) && isTextInputType(typeB)
}

function createKeyToOldIdx (children, beginIdx, endIdx) {
  var i, key;
  var map = {};
  for (i = beginIdx; i <= endIdx; ++i) {
    key = children[i].key;
    if (isDef(key)) { map[key] = i; }
  }
  return map
}

function createPatchFunction (backend) {
  var i, j;
  var cbs = {};

  var modules = backend.modules;
  var nodeOps = backend.nodeOps;

  for (i = 0; i < hooks.length; ++i) {
    cbs[hooks[i]] = [];
    for (j = 0; j < modules.length; ++j) {
      if (isDef(modules[j][hooks[i]])) {
        cbs[hooks[i]].push(modules[j][hooks[i]]);
      }
    }
  }

  function emptyNodeAt (elm) {
    return new VNode(nodeOps.tagName(elm).toLowerCase(), {}, [], undefined, elm)
  }

  function createRmCb (childElm, listeners) {
    function remove () {
      if (--remove.listeners === 0) {
        removeNode(childElm);
      }
    }
    remove.listeners = listeners;
    return remove
  }

  function removeNode (el) {
    var parent = nodeOps.parentNode(el);
    // element may have already been removed due to v-html / v-text
    if (isDef(parent)) {
      nodeOps.removeChild(parent, el);
    }
  }

  function isUnknownElement$$1 (vnode, inVPre) {
    return (
      !inVPre &&
      !vnode.ns &&
      !(
        config.ignoredElements.length &&
        config.ignoredElements.some(function (ignore) {
          return isRegExp(ignore)
            ? ignore.test(vnode.tag)
            : ignore === vnode.tag
        })
      ) &&
      config.isUnknownElement(vnode.tag)
    )
  }

  var creatingElmInVPre = 0;

  function createElm (
    vnode,
    insertedVnodeQueue,
    parentElm,
    refElm,
    nested,
    ownerArray,
    index
  ) {
    if (isDef(vnode.elm) && isDef(ownerArray)) {
      // This vnode was used in a previous render!
      // now it's used as a new node, overwriting its elm would cause
      // potential patch errors down the road when it's used as an insertion
      // reference node. Instead, we clone the node on-demand before creating
      // associated DOM element for it.
      vnode = ownerArray[index] = cloneVNode(vnode);
    }

    vnode.isRootInsert = !nested; // for transition enter check
    if (createComponent(vnode, insertedVnodeQueue, parentElm, refElm)) {
      return
    }

    var data = vnode.data;
    var children = vnode.children;
    var tag = vnode.tag;
    if (isDef(tag)) {
      if (true) {
        if (data && data.pre) {
          creatingElmInVPre++;
        }
        if (isUnknownElement$$1(vnode, creatingElmInVPre)) {
          warn(
            'Unknown custom element: <' + tag + '> - did you ' +
            'register the component correctly? For recursive components, ' +
            'make sure to provide the "name" option.',
            vnode.context
          );
        }
      }

      vnode.elm = vnode.ns
        ? nodeOps.createElementNS(vnode.ns, tag)
        : nodeOps.createElement(tag, vnode);
      setScope(vnode);

      /* istanbul ignore if */
      {
        createChildren(vnode, children, insertedVnodeQueue);
        if (isDef(data)) {
          invokeCreateHooks(vnode, insertedVnodeQueue);
        }
        insert(parentElm, vnode.elm, refElm);
      }

      if ("development" !== 'production' && data && data.pre) {
        creatingElmInVPre--;
      }
    } else if (isTrue(vnode.isComment)) {
      vnode.elm = nodeOps.createComment(vnode.text);
      insert(parentElm, vnode.elm, refElm);
    } else {
      vnode.elm = nodeOps.createTextNode(vnode.text);
      insert(parentElm, vnode.elm, refElm);
    }
  }

  function createComponent (vnode, insertedVnodeQueue, parentElm, refElm) {
    var i = vnode.data;
    if (isDef(i)) {
      var isReactivated = isDef(vnode.componentInstance) && i.keepAlive;
      if (isDef(i = i.hook) && isDef(i = i.init)) {
        i(vnode, false /* hydrating */, parentElm, refElm);
      }
      // after calling the init hook, if the vnode is a child component
      // it should've created a child instance and mounted it. the child
      // component also has set the placeholder vnode's elm.
      // in that case we can just return the element and be done.
      if (isDef(vnode.componentInstance)) {
        initComponent(vnode, insertedVnodeQueue);
        if (isTrue(isReactivated)) {
          reactivateComponent(vnode, insertedVnodeQueue, parentElm, refElm);
        }
        return true
      }
    }
  }

  function initComponent (vnode, insertedVnodeQueue) {
    if (isDef(vnode.data.pendingInsert)) {
      insertedVnodeQueue.push.apply(insertedVnodeQueue, vnode.data.pendingInsert);
      vnode.data.pendingInsert = null;
    }
    vnode.elm = vnode.componentInstance.$el;
    if (isPatchable(vnode)) {
      invokeCreateHooks(vnode, insertedVnodeQueue);
      setScope(vnode);
    } else {
      // empty component root.
      // skip all element-related modules except for ref (#3455)
      registerRef(vnode);
      // make sure to invoke the insert hook
      insertedVnodeQueue.push(vnode);
    }
  }

  function reactivateComponent (vnode, insertedVnodeQueue, parentElm, refElm) {
    var i;
    // hack for #4339: a reactivated component with inner transition
    // does not trigger because the inner node's created hooks are not called
    // again. It's not ideal to involve module-specific logic in here but
    // there doesn't seem to be a better way to do it.
    var innerNode = vnode;
    while (innerNode.componentInstance) {
      innerNode = innerNode.componentInstance._vnode;
      if (isDef(i = innerNode.data) && isDef(i = i.transition)) {
        for (i = 0; i < cbs.activate.length; ++i) {
          cbs.activate[i](emptyNode, innerNode);
        }
        insertedVnodeQueue.push(innerNode);
        break
      }
    }
    // unlike a newly created component,
    // a reactivated keep-alive component doesn't insert itself
    insert(parentElm, vnode.elm, refElm);
  }

  function insert (parent, elm, ref$$1) {
    if (isDef(parent)) {
      if (isDef(ref$$1)) {
        if (ref$$1.parentNode === parent) {
          nodeOps.insertBefore(parent, elm, ref$$1);
        }
      } else {
        nodeOps.appendChild(parent, elm);
      }
    }
  }

  function createChildren (vnode, children, insertedVnodeQueue) {
    if (Array.isArray(children)) {
      if (true) {
        checkDuplicateKeys(children);
      }
      for (var i = 0; i < children.length; ++i) {
        createElm(children[i], insertedVnodeQueue, vnode.elm, null, true, children, i);
      }
    } else if (isPrimitive(vnode.text)) {
      nodeOps.appendChild(vnode.elm, nodeOps.createTextNode(String(vnode.text)));
    }
  }

  function isPatchable (vnode) {
    while (vnode.componentInstance) {
      vnode = vnode.componentInstance._vnode;
    }
    return isDef(vnode.tag)
  }

  function invokeCreateHooks (vnode, insertedVnodeQueue) {
    for (var i$1 = 0; i$1 < cbs.create.length; ++i$1) {
      cbs.create[i$1](emptyNode, vnode);
    }
    i = vnode.data.hook; // Reuse variable
    if (isDef(i)) {
      if (isDef(i.create)) { i.create(emptyNode, vnode); }
      if (isDef(i.insert)) { insertedVnodeQueue.push(vnode); }
    }
  }

  // set scope id attribute for scoped CSS.
  // this is implemented as a special case to avoid the overhead
  // of going through the normal attribute patching process.
  function setScope (vnode) {
    var i;
    if (isDef(i = vnode.fnScopeId)) {
      nodeOps.setStyleScope(vnode.elm, i);
    } else {
      var ancestor = vnode;
      while (ancestor) {
        if (isDef(i = ancestor.context) && isDef(i = i.$options._scopeId)) {
          nodeOps.setStyleScope(vnode.elm, i);
        }
        ancestor = ancestor.parent;
      }
    }
    // for slot content they should also get the scopeId from the host instance.
    if (isDef(i = activeInstance) &&
      i !== vnode.context &&
      i !== vnode.fnContext &&
      isDef(i = i.$options._scopeId)
    ) {
      nodeOps.setStyleScope(vnode.elm, i);
    }
  }

  function addVnodes (parentElm, refElm, vnodes, startIdx, endIdx, insertedVnodeQueue) {
    for (; startIdx <= endIdx; ++startIdx) {
      createElm(vnodes[startIdx], insertedVnodeQueue, parentElm, refElm, false, vnodes, startIdx);
    }
  }

  function invokeDestroyHook (vnode) {
    var i, j;
    var data = vnode.data;
    if (isDef(data)) {
      if (isDef(i = data.hook) && isDef(i = i.destroy)) { i(vnode); }
      for (i = 0; i < cbs.destroy.length; ++i) { cbs.destroy[i](vnode); }
    }
    if (isDef(i = vnode.children)) {
      for (j = 0; j < vnode.children.length; ++j) {
        invokeDestroyHook(vnode.children[j]);
      }
    }
  }

  function removeVnodes (parentElm, vnodes, startIdx, endIdx) {
    for (; startIdx <= endIdx; ++startIdx) {
      var ch = vnodes[startIdx];
      if (isDef(ch)) {
        if (isDef(ch.tag)) {
          removeAndInvokeRemoveHook(ch);
          invokeDestroyHook(ch);
        } else { // Text node
          removeNode(ch.elm);
        }
      }
    }
  }

  function removeAndInvokeRemoveHook (vnode, rm) {
    if (isDef(rm) || isDef(vnode.data)) {
      var i;
      var listeners = cbs.remove.length + 1;
      if (isDef(rm)) {
        // we have a recursively passed down rm callback
        // increase the listeners count
        rm.listeners += listeners;
      } else {
        // directly removing
        rm = createRmCb(vnode.elm, listeners);
      }
      // recursively invoke hooks on child component root node
      if (isDef(i = vnode.componentInstance) && isDef(i = i._vnode) && isDef(i.data)) {
        removeAndInvokeRemoveHook(i, rm);
      }
      for (i = 0; i < cbs.remove.length; ++i) {
        cbs.remove[i](vnode, rm);
      }
      if (isDef(i = vnode.data.hook) && isDef(i = i.remove)) {
        i(vnode, rm);
      } else {
        rm();
      }
    } else {
      removeNode(vnode.elm);
    }
  }

  function updateChildren (parentElm, oldCh, newCh, insertedVnodeQueue, removeOnly) {
    var oldStartIdx = 0;
    var newStartIdx = 0;
    var oldEndIdx = oldCh.length - 1;
    var oldStartVnode = oldCh[0];
    var oldEndVnode = oldCh[oldEndIdx];
    var newEndIdx = newCh.length - 1;
    var newStartVnode = newCh[0];
    var newEndVnode = newCh[newEndIdx];
    var oldKeyToIdx, idxInOld, vnodeToMove, refElm;

    // removeOnly is a special flag used only by <transition-group>
    // to ensure removed elements stay in correct relative positions
    // during leaving transitions
    var canMove = !removeOnly;

    if (true) {
      checkDuplicateKeys(newCh);
    }

    while (oldStartIdx <= oldEndIdx && newStartIdx <= newEndIdx) {
      if (isUndef(oldStartVnode)) {
        oldStartVnode = oldCh[++oldStartIdx]; // Vnode has been moved left
      } else if (isUndef(oldEndVnode)) {
        oldEndVnode = oldCh[--oldEndIdx];
      } else if (sameVnode(oldStartVnode, newStartVnode)) {
        patchVnode(oldStartVnode, newStartVnode, insertedVnodeQueue);
        oldStartVnode = oldCh[++oldStartIdx];
        newStartVnode = newCh[++newStartIdx];
      } else if (sameVnode(oldEndVnode, newEndVnode)) {
        patchVnode(oldEndVnode, newEndVnode, insertedVnodeQueue);
        oldEndVnode = oldCh[--oldEndIdx];
        newEndVnode = newCh[--newEndIdx];
      } else if (sameVnode(oldStartVnode, newEndVnode)) { // Vnode moved right
        patchVnode(oldStartVnode, newEndVnode, insertedVnodeQueue);
        canMove && nodeOps.insertBefore(parentElm, oldStartVnode.elm, nodeOps.nextSibling(oldEndVnode.elm));
        oldStartVnode = oldCh[++oldStartIdx];
        newEndVnode = newCh[--newEndIdx];
      } else if (sameVnode(oldEndVnode, newStartVnode)) { // Vnode moved left
        patchVnode(oldEndVnode, newStartVnode, insertedVnodeQueue);
        canMove && nodeOps.insertBefore(parentElm, oldEndVnode.elm, oldStartVnode.elm);
        oldEndVnode = oldCh[--oldEndIdx];
        newStartVnode = newCh[++newStartIdx];
      } else {
        if (isUndef(oldKeyToIdx)) { oldKeyToIdx = createKeyToOldIdx(oldCh, oldStartIdx, oldEndIdx); }
        idxInOld = isDef(newStartVnode.key)
          ? oldKeyToIdx[newStartVnode.key]
          : findIdxInOld(newStartVnode, oldCh, oldStartIdx, oldEndIdx);
        if (isUndef(idxInOld)) { // New element
          createElm(newStartVnode, insertedVnodeQueue, parentElm, oldStartVnode.elm, false, newCh, newStartIdx);
        } else {
          vnodeToMove = oldCh[idxInOld];
          if (sameVnode(vnodeToMove, newStartVnode)) {
            patchVnode(vnodeToMove, newStartVnode, insertedVnodeQueue);
            oldCh[idxInOld] = undefined;
            canMove && nodeOps.insertBefore(parentElm, vnodeToMove.elm, oldStartVnode.elm);
          } else {
            // same key but different element. treat as new element
            createElm(newStartVnode, insertedVnodeQueue, parentElm, oldStartVnode.elm, false, newCh, newStartIdx);
          }
        }
        newStartVnode = newCh[++newStartIdx];
      }
    }
    if (oldStartIdx > oldEndIdx) {
      refElm = isUndef(newCh[newEndIdx + 1]) ? null : newCh[newEndIdx + 1].elm;
      addVnodes(parentElm, refElm, newCh, newStartIdx, newEndIdx, insertedVnodeQueue);
    } else if (newStartIdx > newEndIdx) {
      removeVnodes(parentElm, oldCh, oldStartIdx, oldEndIdx);
    }
  }

  function checkDuplicateKeys (children) {
    var seenKeys = {};
    for (var i = 0; i < children.length; i++) {
      var vnode = children[i];
      var key = vnode.key;
      if (isDef(key)) {
        if (seenKeys[key]) {
          warn(
            ("Duplicate keys detected: '" + key + "'. This may cause an update error."),
            vnode.context
          );
        } else {
          seenKeys[key] = true;
        }
      }
    }
  }

  function findIdxInOld (node, oldCh, start, end) {
    for (var i = start; i < end; i++) {
      var c = oldCh[i];
      if (isDef(c) && sameVnode(node, c)) { return i }
    }
  }

  function patchVnode (oldVnode, vnode, insertedVnodeQueue, removeOnly) {
    if (oldVnode === vnode) {
      return
    }

    var elm = vnode.elm = oldVnode.elm;

    if (isTrue(oldVnode.isAsyncPlaceholder)) {
      if (isDef(vnode.asyncFactory.resolved)) {
        hydrate(oldVnode.elm, vnode, insertedVnodeQueue);
      } else {
        vnode.isAsyncPlaceholder = true;
      }
      return
    }

    // reuse element for static trees.
    // note we only do this if the vnode is cloned -
    // if the new node is not cloned it means the render functions have been
    // reset by the hot-reload-api and we need to do a proper re-render.
    if (isTrue(vnode.isStatic) &&
      isTrue(oldVnode.isStatic) &&
      vnode.key === oldVnode.key &&
      (isTrue(vnode.isCloned) || isTrue(vnode.isOnce))
    ) {
      vnode.componentInstance = oldVnode.componentInstance;
      return
    }

    var i;
    var data = vnode.data;
    if (isDef(data) && isDef(i = data.hook) && isDef(i = i.prepatch)) {
      i(oldVnode, vnode);
    }

    var oldCh = oldVnode.children;
    var ch = vnode.children;
    if (isDef(data) && isPatchable(vnode)) {
      for (i = 0; i < cbs.update.length; ++i) { cbs.update[i](oldVnode, vnode); }
      if (isDef(i = data.hook) && isDef(i = i.update)) { i(oldVnode, vnode); }
    }
    if (isUndef(vnode.text)) {
      if (isDef(oldCh) && isDef(ch)) {
        if (oldCh !== ch) { updateChildren(elm, oldCh, ch, insertedVnodeQueue, removeOnly); }
      } else if (isDef(ch)) {
        if (isDef(oldVnode.text)) { nodeOps.setTextContent(elm, ''); }
        addVnodes(elm, null, ch, 0, ch.length - 1, insertedVnodeQueue);
      } else if (isDef(oldCh)) {
        removeVnodes(elm, oldCh, 0, oldCh.length - 1);
      } else if (isDef(oldVnode.text)) {
        nodeOps.setTextContent(elm, '');
      }
    } else if (oldVnode.text !== vnode.text) {
      nodeOps.setTextContent(elm, vnode.text);
    }
    if (isDef(data)) {
      if (isDef(i = data.hook) && isDef(i = i.postpatch)) { i(oldVnode, vnode); }
    }
  }

  function invokeInsertHook (vnode, queue, initial) {
    // delay insert hooks for component root nodes, invoke them after the
    // element is really inserted
    if (isTrue(initial) && isDef(vnode.parent)) {
      vnode.parent.data.pendingInsert = queue;
    } else {
      for (var i = 0; i < queue.length; ++i) {
        queue[i].data.hook.insert(queue[i]);
      }
    }
  }

  var hydrationBailed = false;
  // list of modules that can skip create hook during hydration because they
  // are already rendered on the client or has no need for initialization
  // Note: style is excluded because it relies on initial clone for future
  // deep updates (#7063).
  var isRenderedModule = makeMap('attrs,class,staticClass,staticStyle,key');

  // Note: this is a browser-only function so we can assume elms are DOM nodes.
  function hydrate (elm, vnode, insertedVnodeQueue, inVPre) {
    var i;
    var tag = vnode.tag;
    var data = vnode.data;
    var children = vnode.children;
    inVPre = inVPre || (data && data.pre);
    vnode.elm = elm;

    if (isTrue(vnode.isComment) && isDef(vnode.asyncFactory)) {
      vnode.isAsyncPlaceholder = true;
      return true
    }
    // assert node match
    if (true) {
      if (!assertNodeMatch(elm, vnode, inVPre)) {
        return false
      }
    }
    if (isDef(data)) {
      if (isDef(i = data.hook) && isDef(i = i.init)) { i(vnode, true /* hydrating */); }
      if (isDef(i = vnode.componentInstance)) {
        // child component. it should have hydrated its own tree.
        initComponent(vnode, insertedVnodeQueue);
        return true
      }
    }
    if (isDef(tag)) {
      if (isDef(children)) {
        // empty element, allow client to pick up and populate children
        if (!elm.hasChildNodes()) {
          createChildren(vnode, children, insertedVnodeQueue);
        } else {
          // v-html and domProps: innerHTML
          if (isDef(i = data) && isDef(i = i.domProps) && isDef(i = i.innerHTML)) {
            if (i !== elm.innerHTML) {
              /* istanbul ignore if */
              if ("development" !== 'production' &&
                typeof console !== 'undefined' &&
                !hydrationBailed
              ) {
                hydrationBailed = true;
                console.warn('Parent: ', elm);
                console.warn('server innerHTML: ', i);
                console.warn('client innerHTML: ', elm.innerHTML);
              }
              return false
            }
          } else {
            // iterate and compare children lists
            var childrenMatch = true;
            var childNode = elm.firstChild;
            for (var i$1 = 0; i$1 < children.length; i$1++) {
              if (!childNode || !hydrate(childNode, children[i$1], insertedVnodeQueue, inVPre)) {
                childrenMatch = false;
                break
              }
              childNode = childNode.nextSibling;
            }
            // if childNode is not null, it means the actual childNodes list is
            // longer than the virtual children list.
            if (!childrenMatch || childNode) {
              /* istanbul ignore if */
              if ("development" !== 'production' &&
                typeof console !== 'undefined' &&
                !hydrationBailed
              ) {
                hydrationBailed = true;
                console.warn('Parent: ', elm);
                console.warn('Mismatching childNodes vs. VNodes: ', elm.childNodes, children);
              }
              return false
            }
          }
        }
      }
      if (isDef(data)) {
        var fullInvoke = false;
        for (var key in data) {
          if (!isRenderedModule(key)) {
            fullInvoke = true;
            invokeCreateHooks(vnode, insertedVnodeQueue);
            break
          }
        }
        if (!fullInvoke && data['class']) {
          // ensure collecting deps for deep class bindings for future updates
          traverse(data['class']);
        }
      }
    } else if (elm.data !== vnode.text) {
      elm.data = vnode.text;
    }
    return true
  }

  function assertNodeMatch (node, vnode, inVPre) {
    if (isDef(vnode.tag)) {
      return vnode.tag.indexOf('vue-component') === 0 || (
        !isUnknownElement$$1(vnode, inVPre) &&
        vnode.tag.toLowerCase() === (node.tagName && node.tagName.toLowerCase())
      )
    } else {
      return node.nodeType === (vnode.isComment ? 8 : 3)
    }
  }

  return function patch (oldVnode, vnode, hydrating, removeOnly, parentElm, refElm) {
    if (isUndef(vnode)) {
      if (isDef(oldVnode)) { invokeDestroyHook(oldVnode); }
      return
    }

    var isInitialPatch = false;
    var insertedVnodeQueue = [];

    if (isUndef(oldVnode)) {
      // empty mount (likely as component), create new root element
      isInitialPatch = true;
      createElm(vnode, insertedVnodeQueue, parentElm, refElm);
    } else {
      var isRealElement = isDef(oldVnode.nodeType);
      if (!isRealElement && sameVnode(oldVnode, vnode)) {
        // patch existing root node
        patchVnode(oldVnode, vnode, insertedVnodeQueue, removeOnly);
      } else {
        if (isRealElement) {
          // mounting to a real element
          // check if this is server-rendered content and if we can perform
          // a successful hydration.
          if (oldVnode.nodeType === 1 && oldVnode.hasAttribute(SSR_ATTR)) {
            oldVnode.removeAttribute(SSR_ATTR);
            hydrating = true;
          }
          if (isTrue(hydrating)) {
            if (hydrate(oldVnode, vnode, insertedVnodeQueue)) {
              invokeInsertHook(vnode, insertedVnodeQueue, true);
              return oldVnode
            } else if (true) {
              warn(
                'The client-side rendered virtual DOM tree is not matching ' +
                'server-rendered content. This is likely caused by incorrect ' +
                'HTML markup, for example nesting block-level elements inside ' +
                '<p>, or missing <tbody>. Bailing hydration and performing ' +
                'full client-side render.'
              );
            }
          }
          // either not server-rendered, or hydration failed.
          // create an empty node and replace it
          oldVnode = emptyNodeAt(oldVnode);
        }

        // replacing existing element
        var oldElm = oldVnode.elm;
        var parentElm$1 = nodeOps.parentNode(oldElm);

        // create new node
        createElm(
          vnode,
          insertedVnodeQueue,
          // extremely rare edge case: do not insert if old element is in a
          // leaving transition. Only happens when combining transition +
          // keep-alive + HOCs. (#4590)
          oldElm._leaveCb ? null : parentElm$1,
          nodeOps.nextSibling(oldElm)
        );

        // update parent placeholder node element, recursively
        if (isDef(vnode.parent)) {
          var ancestor = vnode.parent;
          var patchable = isPatchable(vnode);
          while (ancestor) {
            for (var i = 0; i < cbs.destroy.length; ++i) {
              cbs.destroy[i](ancestor);
            }
            ancestor.elm = vnode.elm;
            if (patchable) {
              for (var i$1 = 0; i$1 < cbs.create.length; ++i$1) {
                cbs.create[i$1](emptyNode, ancestor);
              }
              // #6513
              // invoke insert hooks that may have been merged by create hooks.
              // e.g. for directives that uses the "inserted" hook.
              var insert = ancestor.data.hook.insert;
              if (insert.merged) {
                // start at index 1 to avoid re-invoking component mounted hook
                for (var i$2 = 1; i$2 < insert.fns.length; i$2++) {
                  insert.fns[i$2]();
                }
              }
            } else {
              registerRef(ancestor);
            }
            ancestor = ancestor.parent;
          }
        }

        // destroy old node
        if (isDef(parentElm$1)) {
          removeVnodes(parentElm$1, [oldVnode], 0, 0);
        } else if (isDef(oldVnode.tag)) {
          invokeDestroyHook(oldVnode);
        }
      }
    }

    invokeInsertHook(vnode, insertedVnodeQueue, isInitialPatch);
    return vnode.elm
  }
}

/*  */

var directives = {
  create: updateDirectives,
  update: updateDirectives,
  destroy: function unbindDirectives (vnode) {
    updateDirectives(vnode, emptyNode);
  }
}

function updateDirectives (oldVnode, vnode) {
  if (oldVnode.data.directives || vnode.data.directives) {
    _update(oldVnode, vnode);
  }
}

function _update (oldVnode, vnode) {
  var isCreate = oldVnode === emptyNode;
  var isDestroy = vnode === emptyNode;
  var oldDirs = normalizeDirectives$1(oldVnode.data.directives, oldVnode.context);
  var newDirs = normalizeDirectives$1(vnode.data.directives, vnode.context);

  var dirsWithInsert = [];
  var dirsWithPostpatch = [];

  var key, oldDir, dir;
  for (key in newDirs) {
    oldDir = oldDirs[key];
    dir = newDirs[key];
    if (!oldDir) {
      // new directive, bind
      callHook$1(dir, 'bind', vnode, oldVnode);
      if (dir.def && dir.def.inserted) {
        dirsWithInsert.push(dir);
      }
    } else {
      // existing directive, update
      dir.oldValue = oldDir.value;
      callHook$1(dir, 'update', vnode, oldVnode);
      if (dir.def && dir.def.componentUpdated) {
        dirsWithPostpatch.push(dir);
      }
    }
  }

  if (dirsWithInsert.length) {
    var callInsert = function () {
      for (var i = 0; i < dirsWithInsert.length; i++) {
        callHook$1(dirsWithInsert[i], 'inserted', vnode, oldVnode);
      }
    };
    if (isCreate) {
      mergeVNodeHook(vnode, 'insert', callInsert);
    } else {
      callInsert();
    }
  }

  if (dirsWithPostpatch.length) {
    mergeVNodeHook(vnode, 'postpatch', function () {
      for (var i = 0; i < dirsWithPostpatch.length; i++) {
        callHook$1(dirsWithPostpatch[i], 'componentUpdated', vnode, oldVnode);
      }
    });
  }

  if (!isCreate) {
    for (key in oldDirs) {
      if (!newDirs[key]) {
        // no longer present, unbind
        callHook$1(oldDirs[key], 'unbind', oldVnode, oldVnode, isDestroy);
      }
    }
  }
}

var emptyModifiers = Object.create(null);

function normalizeDirectives$1 (
  dirs,
  vm
) {
  var res = Object.create(null);
  if (!dirs) {
    // $flow-disable-line
    return res
  }
  var i, dir;
  for (i = 0; i < dirs.length; i++) {
    dir = dirs[i];
    if (!dir.modifiers) {
      // $flow-disable-line
      dir.modifiers = emptyModifiers;
    }
    res[getRawDirName(dir)] = dir;
    dir.def = resolveAsset(vm.$options, 'directives', dir.name, true);
  }
  // $flow-disable-line
  return res
}

function getRawDirName (dir) {
  return dir.rawName || ((dir.name) + "." + (Object.keys(dir.modifiers || {}).join('.')))
}

function callHook$1 (dir, hook, vnode, oldVnode, isDestroy) {
  var fn = dir.def && dir.def[hook];
  if (fn) {
    try {
      fn(vnode.elm, dir, vnode, oldVnode, isDestroy);
    } catch (e) {
      handleError(e, vnode.context, ("directive " + (dir.name) + " " + hook + " hook"));
    }
  }
}

var baseModules = [
  ref,
  directives
]

/*  */

function updateAttrs (oldVnode, vnode) {
  var opts = vnode.componentOptions;
  if (isDef(opts) && opts.Ctor.options.inheritAttrs === false) {
    return
  }
  if (isUndef(oldVnode.data.attrs) && isUndef(vnode.data.attrs)) {
    return
  }
  var key, cur, old;
  var elm = vnode.elm;
  var oldAttrs = oldVnode.data.attrs || {};
  var attrs = vnode.data.attrs || {};
  // clone observed objects, as the user probably wants to mutate it
  if (isDef(attrs.__ob__)) {
    attrs = vnode.data.attrs = extend({}, attrs);
  }

  for (key in attrs) {
    cur = attrs[key];
    old = oldAttrs[key];
    if (old !== cur) {
      setAttr(elm, key, cur);
    }
  }
  // #4391: in IE9, setting type can reset value for input[type=radio]
  // #6666: IE/Edge forces progress value down to 1 before setting a max
  /* istanbul ignore if */
  if ((isIE || isEdge) && attrs.value !== oldAttrs.value) {
    setAttr(elm, 'value', attrs.value);
  }
  for (key in oldAttrs) {
    if (isUndef(attrs[key])) {
      if (isXlink(key)) {
        elm.removeAttributeNS(xlinkNS, getXlinkProp(key));
      } else if (!isEnumeratedAttr(key)) {
        elm.removeAttribute(key);
      }
    }
  }
}

function setAttr (el, key, value) {
  if (el.tagName.indexOf('-') > -1) {
    baseSetAttr(el, key, value);
  } else if (isBooleanAttr(key)) {
    // set attribute for blank value
    // e.g. <option disabled>Select one</option>
    if (isFalsyAttrValue(value)) {
      el.removeAttribute(key);
    } else {
      // technically allowfullscreen is a boolean attribute for <iframe>,
      // but Flash expects a value of "true" when used on <embed> tag
      value = key === 'allowfullscreen' && el.tagName === 'EMBED'
        ? 'true'
        : key;
      el.setAttribute(key, value);
    }
  } else if (isEnumeratedAttr(key)) {
    el.setAttribute(key, isFalsyAttrValue(value) || value === 'false' ? 'false' : 'true');
  } else if (isXlink(key)) {
    if (isFalsyAttrValue(value)) {
      el.removeAttributeNS(xlinkNS, getXlinkProp(key));
    } else {
      el.setAttributeNS(xlinkNS, key, value);
    }
  } else {
    baseSetAttr(el, key, value);
  }
}

function baseSetAttr (el, key, value) {
  if (isFalsyAttrValue(value)) {
    el.removeAttribute(key);
  } else {
    // #7138: IE10 & 11 fires input event when setting placeholder on
    // <textarea>... block the first input event and remove the blocker
    // immediately.
    /* istanbul ignore if */
    if (
      isIE && !isIE9 &&
      el.tagName === 'TEXTAREA' &&
      key === 'placeholder' && !el.__ieph
    ) {
      var blocker = function (e) {
        e.stopImmediatePropagation();
        el.removeEventListener('input', blocker);
      };
      el.addEventListener('input', blocker);
      // $flow-disable-line
      el.__ieph = true; /* IE placeholder patched */
    }
    el.setAttribute(key, value);
  }
}

var attrs = {
  create: updateAttrs,
  update: updateAttrs
}

/*  */

function updateClass (oldVnode, vnode) {
  var el = vnode.elm;
  var data = vnode.data;
  var oldData = oldVnode.data;
  if (
    isUndef(data.staticClass) &&
    isUndef(data.class) && (
      isUndef(oldData) || (
        isUndef(oldData.staticClass) &&
        isUndef(oldData.class)
      )
    )
  ) {
    return
  }

  var cls = genClassForVnode(vnode);

  // handle transition classes
  var transitionClass = el._transitionClasses;
  if (isDef(transitionClass)) {
    cls = concat(cls, stringifyClass(transitionClass));
  }

  // set the class
  if (cls !== el._prevClass) {
    el.setAttribute('class', cls);
    el._prevClass = cls;
  }
}

var klass = {
  create: updateClass,
  update: updateClass
}

/*  */

var validDivisionCharRE = /[\w).+\-_$\]]/;

function parseFilters (exp) {
  var inSingle = false;
  var inDouble = false;
  var inTemplateString = false;
  var inRegex = false;
  var curly = 0;
  var square = 0;
  var paren = 0;
  var lastFilterIndex = 0;
  var c, prev, i, expression, filters;

  for (i = 0; i < exp.length; i++) {
    prev = c;
    c = exp.charCodeAt(i);
    if (inSingle) {
      if (c === 0x27 && prev !== 0x5C) { inSingle = false; }
    } else if (inDouble) {
      if (c === 0x22 && prev !== 0x5C) { inDouble = false; }
    } else if (inTemplateString) {
      if (c === 0x60 && prev !== 0x5C) { inTemplateString = false; }
    } else if (inRegex) {
      if (c === 0x2f && prev !== 0x5C) { inRegex = false; }
    } else if (
      c === 0x7C && // pipe
      exp.charCodeAt(i + 1) !== 0x7C &&
      exp.charCodeAt(i - 1) !== 0x7C &&
      !curly && !square && !paren
    ) {
      if (expression === undefined) {
        // first filter, end of expression
        lastFilterIndex = i + 1;
        expression = exp.slice(0, i).trim();
      } else {
        pushFilter();
      }
    } else {
      switch (c) {
        case 0x22: inDouble = true; break         // "
        case 0x27: inSingle = true; break         // '
        case 0x60: inTemplateString = true; break // `
        case 0x28: paren++; break                 // (
        case 0x29: paren--; break                 // )
        case 0x5B: square++; break                // [
        case 0x5D: square--; break                // ]
        case 0x7B: curly++; break                 // {
        case 0x7D: curly--; break                 // }
      }
      if (c === 0x2f) { // /
        var j = i - 1;
        var p = (void 0);
        // find first non-whitespace prev char
        for (; j >= 0; j--) {
          p = exp.charAt(j);
          if (p !== ' ') { break }
        }
        if (!p || !validDivisionCharRE.test(p)) {
          inRegex = true;
        }
      }
    }
  }

  if (expression === undefined) {
    expression = exp.slice(0, i).trim();
  } else if (lastFilterIndex !== 0) {
    pushFilter();
  }

  function pushFilter () {
    (filters || (filters = [])).push(exp.slice(lastFilterIndex, i).trim());
    lastFilterIndex = i + 1;
  }

  if (filters) {
    for (i = 0; i < filters.length; i++) {
      expression = wrapFilter(expression, filters[i]);
    }
  }

  return expression
}

function wrapFilter (exp, filter) {
  var i = filter.indexOf('(');
  if (i < 0) {
    // _f: resolveFilter
    return ("_f(\"" + filter + "\")(" + exp + ")")
  } else {
    var name = filter.slice(0, i);
    var args = filter.slice(i + 1);
    return ("_f(\"" + name + "\")(" + exp + (args !== ')' ? ',' + args : args))
  }
}

/*  */

function baseWarn (msg) {
  console.error(("[Vue compiler]: " + msg));
}

function pluckModuleFunction (
  modules,
  key
) {
  return modules
    ? modules.map(function (m) { return m[key]; }).filter(function (_) { return _; })
    : []
}

function addProp (el, name, value) {
  (el.props || (el.props = [])).push({ name: name, value: value });
  el.plain = false;
}

function addAttr (el, name, value) {
  (el.attrs || (el.attrs = [])).push({ name: name, value: value });
  el.plain = false;
}

// add a raw attr (use this in preTransforms)
function addRawAttr (el, name, value) {
  el.attrsMap[name] = value;
  el.attrsList.push({ name: name, value: value });
}

function addDirective (
  el,
  name,
  rawName,
  value,
  arg,
  modifiers
) {
  (el.directives || (el.directives = [])).push({ name: name, rawName: rawName, value: value, arg: arg, modifiers: modifiers });
  el.plain = false;
}

function addHandler (
  el,
  name,
  value,
  modifiers,
  important,
  warn
) {
  modifiers = modifiers || emptyObject;
  // warn prevent and passive modifier
  /* istanbul ignore if */
  if (
    "development" !== 'production' && warn &&
    modifiers.prevent && modifiers.passive
  ) {
    warn(
      'passive and prevent can\'t be used together. ' +
      'Passive handler can\'t prevent default event.'
    );
  }

  // check capture modifier
  if (modifiers.capture) {
    delete modifiers.capture;
    name = '!' + name; // mark the event as captured
  }
  if (modifiers.once) {
    delete modifiers.once;
    name = '~' + name; // mark the event as once
  }
  /* istanbul ignore if */
  if (modifiers.passive) {
    delete modifiers.passive;
    name = '&' + name; // mark the event as passive
  }

  // normalize click.right and click.middle since they don't actually fire
  // this is technically browser-specific, but at least for now browsers are
  // the only target envs that have right/middle clicks.
  if (name === 'click') {
    if (modifiers.right) {
      name = 'contextmenu';
      delete modifiers.right;
    } else if (modifiers.middle) {
      name = 'mouseup';
    }
  }

  var events;
  if (modifiers.native) {
    delete modifiers.native;
    events = el.nativeEvents || (el.nativeEvents = {});
  } else {
    events = el.events || (el.events = {});
  }

  var newHandler = {
    value: value.trim()
  };
  if (modifiers !== emptyObject) {
    newHandler.modifiers = modifiers;
  }

  var handlers = events[name];
  /* istanbul ignore if */
  if (Array.isArray(handlers)) {
    important ? handlers.unshift(newHandler) : handlers.push(newHandler);
  } else if (handlers) {
    events[name] = important ? [newHandler, handlers] : [handlers, newHandler];
  } else {
    events[name] = newHandler;
  }

  el.plain = false;
}

function getBindingAttr (
  el,
  name,
  getStatic
) {
  var dynamicValue =
    getAndRemoveAttr(el, ':' + name) ||
    getAndRemoveAttr(el, 'v-bind:' + name);
  if (dynamicValue != null) {
    return parseFilters(dynamicValue)
  } else if (getStatic !== false) {
    var staticValue = getAndRemoveAttr(el, name);
    if (staticValue != null) {
      return JSON.stringify(staticValue)
    }
  }
}

// note: this only removes the attr from the Array (attrsList) so that it
// doesn't get processed by processAttrs.
// By default it does NOT remove it from the map (attrsMap) because the map is
// needed during codegen.
function getAndRemoveAttr (
  el,
  name,
  removeFromMap
) {
  var val;
  if ((val = el.attrsMap[name]) != null) {
    var list = el.attrsList;
    for (var i = 0, l = list.length; i < l; i++) {
      if (list[i].name === name) {
        list.splice(i, 1);
        break
      }
    }
  }
  if (removeFromMap) {
    delete el.attrsMap[name];
  }
  return val
}

/*  */

/**
 * Cross-platform code generation for component v-model
 */
function genComponentModel (
  el,
  value,
  modifiers
) {
  var ref = modifiers || {};
  var number = ref.number;
  var trim = ref.trim;

  var baseValueExpression = '$$v';
  var valueExpression = baseValueExpression;
  if (trim) {
    valueExpression =
      "(typeof " + baseValueExpression + " === 'string'" +
      "? " + baseValueExpression + ".trim()" +
      ": " + baseValueExpression + ")";
  }
  if (number) {
    valueExpression = "_n(" + valueExpression + ")";
  }
  var assignment = genAssignmentCode(value, valueExpression);

  el.model = {
    value: ("(" + value + ")"),
    expression: ("\"" + value + "\""),
    callback: ("function (" + baseValueExpression + ") {" + assignment + "}")
  };
}

/**
 * Cross-platform codegen helper for generating v-model value assignment code.
 */
function genAssignmentCode (
  value,
  assignment
) {
  var res = parseModel(value);
  if (res.key === null) {
    return (value + "=" + assignment)
  } else {
    return ("$set(" + (res.exp) + ", " + (res.key) + ", " + assignment + ")")
  }
}

/**
 * Parse a v-model expression into a base path and a final key segment.
 * Handles both dot-path and possible square brackets.
 *
 * Possible cases:
 *
 * - test
 * - test[key]
 * - test[test1[key]]
 * - test["a"][key]
 * - xxx.test[a[a].test1[key]]
 * - test.xxx.a["asa"][test1[key]]
 *
 */

var len;
var str;
var chr;
var index$1;
var expressionPos;
var expressionEndPos;



function parseModel (val) {
  // Fix https://github.com/vuejs/vue/pull/7730
  // allow v-model="obj.val " (trailing whitespace)
  val = val.trim();
  len = val.length;

  if (val.indexOf('[') < 0 || val.lastIndexOf(']') < len - 1) {
    index$1 = val.lastIndexOf('.');
    if (index$1 > -1) {
      return {
        exp: val.slice(0, index$1),
        key: '"' + val.slice(index$1 + 1) + '"'
      }
    } else {
      return {
        exp: val,
        key: null
      }
    }
  }

  str = val;
  index$1 = expressionPos = expressionEndPos = 0;

  while (!eof()) {
    chr = next();
    /* istanbul ignore if */
    if (isStringStart(chr)) {
      parseString(chr);
    } else if (chr === 0x5B) {
      parseBracket(chr);
    }
  }

  return {
    exp: val.slice(0, expressionPos),
    key: val.slice(expressionPos + 1, expressionEndPos)
  }
}

function next () {
  return str.charCodeAt(++index$1)
}

function eof () {
  return index$1 >= len
}

function isStringStart (chr) {
  return chr === 0x22 || chr === 0x27
}

function parseBracket (chr) {
  var inBracket = 1;
  expressionPos = index$1;
  while (!eof()) {
    chr = next();
    if (isStringStart(chr)) {
      parseString(chr);
      continue
    }
    if (chr === 0x5B) { inBracket++; }
    if (chr === 0x5D) { inBracket--; }
    if (inBracket === 0) {
      expressionEndPos = index$1;
      break
    }
  }
}

function parseString (chr) {
  var stringQuote = chr;
  while (!eof()) {
    chr = next();
    if (chr === stringQuote) {
      break
    }
  }
}

/*  */

var warn$1;

// in some cases, the event used has to be determined at runtime
// so we used some reserved tokens during compile.
var RANGE_TOKEN = '__r';
var CHECKBOX_RADIO_TOKEN = '__c';

function model (
  el,
  dir,
  _warn
) {
  warn$1 = _warn;
  var value = dir.value;
  var modifiers = dir.modifiers;
  var tag = el.tag;
  var type = el.attrsMap.type;

  if (true) {
    // inputs with type="file" are read only and setting the input's
    // value will throw an error.
    if (tag === 'input' && type === 'file') {
      warn$1(
        "<" + (el.tag) + " v-model=\"" + value + "\" type=\"file\">:\n" +
        "File inputs are read only. Use a v-on:change listener instead."
      );
    }
  }

  if (el.component) {
    genComponentModel(el, value, modifiers);
    // component v-model doesn't need extra runtime
    return false
  } else if (tag === 'select') {
    genSelect(el, value, modifiers);
  } else if (tag === 'input' && type === 'checkbox') {
    genCheckboxModel(el, value, modifiers);
  } else if (tag === 'input' && type === 'radio') {
    genRadioModel(el, value, modifiers);
  } else if (tag === 'input' || tag === 'textarea') {
    genDefaultModel(el, value, modifiers);
  } else if (!config.isReservedTag(tag)) {
    genComponentModel(el, value, modifiers);
    // component v-model doesn't need extra runtime
    return false
  } else if (true) {
    warn$1(
      "<" + (el.tag) + " v-model=\"" + value + "\">: " +
      "v-model is not supported on this element type. " +
      'If you are working with contenteditable, it\'s recommended to ' +
      'wrap a library dedicated for that purpose inside a custom component.'
    );
  }

  // ensure runtime directive metadata
  return true
}

function genCheckboxModel (
  el,
  value,
  modifiers
) {
  var number = modifiers && modifiers.number;
  var valueBinding = getBindingAttr(el, 'value') || 'null';
  var trueValueBinding = getBindingAttr(el, 'true-value') || 'true';
  var falseValueBinding = getBindingAttr(el, 'false-value') || 'false';
  addProp(el, 'checked',
    "Array.isArray(" + value + ")" +
    "?_i(" + value + "," + valueBinding + ")>-1" + (
      trueValueBinding === 'true'
        ? (":(" + value + ")")
        : (":_q(" + value + "," + trueValueBinding + ")")
    )
  );
  addHandler(el, 'change',
    "var $$a=" + value + "," +
        '$$el=$event.target,' +
        "$$c=$$el.checked?(" + trueValueBinding + "):(" + falseValueBinding + ");" +
    'if(Array.isArray($$a)){' +
      "var $$v=" + (number ? '_n(' + valueBinding + ')' : valueBinding) + "," +
          '$$i=_i($$a,$$v);' +
      "if($$el.checked){$$i<0&&(" + (genAssignmentCode(value, '$$a.concat([$$v])')) + ")}" +
      "else{$$i>-1&&(" + (genAssignmentCode(value, '$$a.slice(0,$$i).concat($$a.slice($$i+1))')) + ")}" +
    "}else{" + (genAssignmentCode(value, '$$c')) + "}",
    null, true
  );
}

function genRadioModel (
  el,
  value,
  modifiers
) {
  var number = modifiers && modifiers.number;
  var valueBinding = getBindingAttr(el, 'value') || 'null';
  valueBinding = number ? ("_n(" + valueBinding + ")") : valueBinding;
  addProp(el, 'checked', ("_q(" + value + "," + valueBinding + ")"));
  addHandler(el, 'change', genAssignmentCode(value, valueBinding), null, true);
}

function genSelect (
  el,
  value,
  modifiers
) {
  var number = modifiers && modifiers.number;
  var selectedVal = "Array.prototype.filter" +
    ".call($event.target.options,function(o){return o.selected})" +
    ".map(function(o){var val = \"_value\" in o ? o._value : o.value;" +
    "return " + (number ? '_n(val)' : 'val') + "})";

  var assignment = '$event.target.multiple ? $$selectedVal : $$selectedVal[0]';
  var code = "var $$selectedVal = " + selectedVal + ";";
  code = code + " " + (genAssignmentCode(value, assignment));
  addHandler(el, 'change', code, null, true);
}

function genDefaultModel (
  el,
  value,
  modifiers
) {
  var type = el.attrsMap.type;

  // warn if v-bind:value conflicts with v-model
  // except for inputs with v-bind:type
  if (true) {
    var value$1 = el.attrsMap['v-bind:value'] || el.attrsMap[':value'];
    var typeBinding = el.attrsMap['v-bind:type'] || el.attrsMap[':type'];
    if (value$1 && !typeBinding) {
      var binding = el.attrsMap['v-bind:value'] ? 'v-bind:value' : ':value';
      warn$1(
        binding + "=\"" + value$1 + "\" conflicts with v-model on the same element " +
        'because the latter already expands to a value binding internally'
      );
    }
  }

  var ref = modifiers || {};
  var lazy = ref.lazy;
  var number = ref.number;
  var trim = ref.trim;
  var needCompositionGuard = !lazy && type !== 'range';
  var event = lazy
    ? 'change'
    : type === 'range'
      ? RANGE_TOKEN
      : 'input';

  var valueExpression = '$event.target.value';
  if (trim) {
    valueExpression = "$event.target.value.trim()";
  }
  if (number) {
    valueExpression = "_n(" + valueExpression + ")";
  }

  var code = genAssignmentCode(value, valueExpression);
  if (needCompositionGuard) {
    code = "if($event.target.composing)return;" + code;
  }

  addProp(el, 'value', ("(" + value + ")"));
  addHandler(el, event, code, null, true);
  if (trim || number) {
    addHandler(el, 'blur', '$forceUpdate()');
  }
}

/*  */

// normalize v-model event tokens that can only be determined at runtime.
// it's important to place the event as the first in the array because
// the whole point is ensuring the v-model callback gets called before
// user-attached handlers.
function normalizeEvents (on) {
  /* istanbul ignore if */
  if (isDef(on[RANGE_TOKEN])) {
    // IE input[type=range] only supports `change` event
    var event = isIE ? 'change' : 'input';
    on[event] = [].concat(on[RANGE_TOKEN], on[event] || []);
    delete on[RANGE_TOKEN];
  }
  // This was originally intended to fix #4521 but no longer necessary
  // after 2.5. Keeping it for backwards compat with generated code from < 2.4
  /* istanbul ignore if */
  if (isDef(on[CHECKBOX_RADIO_TOKEN])) {
    on.change = [].concat(on[CHECKBOX_RADIO_TOKEN], on.change || []);
    delete on[CHECKBOX_RADIO_TOKEN];
  }
}

var target$1;

function createOnceHandler (handler, event, capture) {
  var _target = target$1; // save current target element in closure
  return function onceHandler () {
    var res = handler.apply(null, arguments);
    if (res !== null) {
      remove$2(event, onceHandler, capture, _target);
    }
  }
}

function add$1 (
  event,
  handler,
  once$$1,
  capture,
  passive
) {
  handler = withMacroTask(handler);
  if (once$$1) { handler = createOnceHandler(handler, event, capture); }
  target$1.addEventListener(
    event,
    handler,
    supportsPassive
      ? { capture: capture, passive: passive }
      : capture
  );
}

function remove$2 (
  event,
  handler,
  capture,
  _target
) {
  (_target || target$1).removeEventListener(
    event,
    handler._withTask || handler,
    capture
  );
}

function updateDOMListeners (oldVnode, vnode) {
  if (isUndef(oldVnode.data.on) && isUndef(vnode.data.on)) {
    return
  }
  var on = vnode.data.on || {};
  var oldOn = oldVnode.data.on || {};
  target$1 = vnode.elm;
  normalizeEvents(on);
  updateListeners(on, oldOn, add$1, remove$2, vnode.context);
  target$1 = undefined;
}

var events = {
  create: updateDOMListeners,
  update: updateDOMListeners
}

/*  */

function updateDOMProps (oldVnode, vnode) {
  if (isUndef(oldVnode.data.domProps) && isUndef(vnode.data.domProps)) {
    return
  }
  var key, cur;
  var elm = vnode.elm;
  var oldProps = oldVnode.data.domProps || {};
  var props = vnode.data.domProps || {};
  // clone observed objects, as the user probably wants to mutate it
  if (isDef(props.__ob__)) {
    props = vnode.data.domProps = extend({}, props);
  }

  for (key in oldProps) {
    if (isUndef(props[key])) {
      elm[key] = '';
    }
  }
  for (key in props) {
    cur = props[key];
    // ignore children if the node has textContent or innerHTML,
    // as these will throw away existing DOM nodes and cause removal errors
    // on subsequent patches (#3360)
    if (key === 'textContent' || key === 'innerHTML') {
      if (vnode.children) { vnode.children.length = 0; }
      if (cur === oldProps[key]) { continue }
      // #6601 work around Chrome version <= 55 bug where single textNode
      // replaced by innerHTML/textContent retains its parentNode property
      if (elm.childNodes.length === 1) {
        elm.removeChild(elm.childNodes[0]);
      }
    }

    if (key === 'value') {
      // store value as _value as well since
      // non-string values will be stringified
      elm._value = cur;
      // avoid resetting cursor position when value is the same
      var strCur = isUndef(cur) ? '' : String(cur);
      if (shouldUpdateValue(elm, strCur)) {
        elm.value = strCur;
      }
    } else {
      elm[key] = cur;
    }
  }
}

// check platforms/web/util/attrs.js acceptValue


function shouldUpdateValue (elm, checkVal) {
  return (!elm.composing && (
    elm.tagName === 'OPTION' ||
    isNotInFocusAndDirty(elm, checkVal) ||
    isDirtyWithModifiers(elm, checkVal)
  ))
}

function isNotInFocusAndDirty (elm, checkVal) {
  // return true when textbox (.number and .trim) loses focus and its value is
  // not equal to the updated value
  var notInFocus = true;
  // #6157
  // work around IE bug when accessing document.activeElement in an iframe
  try { notInFocus = document.activeElement !== elm; } catch (e) {}
  return notInFocus && elm.value !== checkVal
}

function isDirtyWithModifiers (elm, newVal) {
  var value = elm.value;
  var modifiers = elm._vModifiers; // injected by v-model runtime
  if (isDef(modifiers)) {
    if (modifiers.lazy) {
      // inputs with lazy should only be updated when not in focus
      return false
    }
    if (modifiers.number) {
      return toNumber(value) !== toNumber(newVal)
    }
    if (modifiers.trim) {
      return value.trim() !== newVal.trim()
    }
  }
  return value !== newVal
}

var domProps = {
  create: updateDOMProps,
  update: updateDOMProps
}

/*  */

var parseStyleText = cached(function (cssText) {
  var res = {};
  var listDelimiter = /;(?![^(]*\))/g;
  var propertyDelimiter = /:(.+)/;
  cssText.split(listDelimiter).forEach(function (item) {
    if (item) {
      var tmp = item.split(propertyDelimiter);
      tmp.length > 1 && (res[tmp[0].trim()] = tmp[1].trim());
    }
  });
  return res
});

// merge static and dynamic style data on the same vnode
function normalizeStyleData (data) {
  var style = normalizeStyleBinding(data.style);
  // static style is pre-processed into an object during compilation
  // and is always a fresh object, so it's safe to merge into it
  return data.staticStyle
    ? extend(data.staticStyle, style)
    : style
}

// normalize possible array / string values into Object
function normalizeStyleBinding (bindingStyle) {
  if (Array.isArray(bindingStyle)) {
    return toObject(bindingStyle)
  }
  if (typeof bindingStyle === 'string') {
    return parseStyleText(bindingStyle)
  }
  return bindingStyle
}

/**
 * parent component style should be after child's
 * so that parent component's style could override it
 */
function getStyle (vnode, checkChild) {
  var res = {};
  var styleData;

  if (checkChild) {
    var childNode = vnode;
    while (childNode.componentInstance) {
      childNode = childNode.componentInstance._vnode;
      if (
        childNode && childNode.data &&
        (styleData = normalizeStyleData(childNode.data))
      ) {
        extend(res, styleData);
      }
    }
  }

  if ((styleData = normalizeStyleData(vnode.data))) {
    extend(res, styleData);
  }

  var parentNode = vnode;
  while ((parentNode = parentNode.parent)) {
    if (parentNode.data && (styleData = normalizeStyleData(parentNode.data))) {
      extend(res, styleData);
    }
  }
  return res
}

/*  */

var cssVarRE = /^--/;
var importantRE = /\s*!important$/;
var setProp = function (el, name, val) {
  /* istanbul ignore if */
  if (cssVarRE.test(name)) {
    el.style.setProperty(name, val);
  } else if (importantRE.test(val)) {
    el.style.setProperty(name, val.replace(importantRE, ''), 'important');
  } else {
    var normalizedName = normalize(name);
    if (Array.isArray(val)) {
      // Support values array created by autoprefixer, e.g.
      // {display: ["-webkit-box", "-ms-flexbox", "flex"]}
      // Set them one by one, and the browser will only set those it can recognize
      for (var i = 0, len = val.length; i < len; i++) {
        el.style[normalizedName] = val[i];
      }
    } else {
      el.style[normalizedName] = val;
    }
  }
};

var vendorNames = ['Webkit', 'Moz', 'ms'];

var emptyStyle;
var normalize = cached(function (prop) {
  emptyStyle = emptyStyle || document.createElement('div').style;
  prop = camelize(prop);
  if (prop !== 'filter' && (prop in emptyStyle)) {
    return prop
  }
  var capName = prop.charAt(0).toUpperCase() + prop.slice(1);
  for (var i = 0; i < vendorNames.length; i++) {
    var name = vendorNames[i] + capName;
    if (name in emptyStyle) {
      return name
    }
  }
});

function updateStyle (oldVnode, vnode) {
  var data = vnode.data;
  var oldData = oldVnode.data;

  if (isUndef(data.staticStyle) && isUndef(data.style) &&
    isUndef(oldData.staticStyle) && isUndef(oldData.style)
  ) {
    return
  }

  var cur, name;
  var el = vnode.elm;
  var oldStaticStyle = oldData.staticStyle;
  var oldStyleBinding = oldData.normalizedStyle || oldData.style || {};

  // if static style exists, stylebinding already merged into it when doing normalizeStyleData
  var oldStyle = oldStaticStyle || oldStyleBinding;

  var style = normalizeStyleBinding(vnode.data.style) || {};

  // store normalized style under a different key for next diff
  // make sure to clone it if it's reactive, since the user likely wants
  // to mutate it.
  vnode.data.normalizedStyle = isDef(style.__ob__)
    ? extend({}, style)
    : style;

  var newStyle = getStyle(vnode, true);

  for (name in oldStyle) {
    if (isUndef(newStyle[name])) {
      setProp(el, name, '');
    }
  }
  for (name in newStyle) {
    cur = newStyle[name];
    if (cur !== oldStyle[name]) {
      // ie9 setting to null has no effect, must use empty string
      setProp(el, name, cur == null ? '' : cur);
    }
  }
}

var style = {
  create: updateStyle,
  update: updateStyle
}

/*  */

/**
 * Add class with compatibility for SVG since classList is not supported on
 * SVG elements in IE
 */
function addClass (el, cls) {
  /* istanbul ignore if */
  if (!cls || !(cls = cls.trim())) {
    return
  }

  /* istanbul ignore else */
  if (el.classList) {
    if (cls.indexOf(' ') > -1) {
      cls.split(/\s+/).forEach(function (c) { return el.classList.add(c); });
    } else {
      el.classList.add(cls);
    }
  } else {
    var cur = " " + (el.getAttribute('class') || '') + " ";
    if (cur.indexOf(' ' + cls + ' ') < 0) {
      el.setAttribute('class', (cur + cls).trim());
    }
  }
}

/**
 * Remove class with compatibility for SVG since classList is not supported on
 * SVG elements in IE
 */
function removeClass (el, cls) {
  /* istanbul ignore if */
  if (!cls || !(cls = cls.trim())) {
    return
  }

  /* istanbul ignore else */
  if (el.classList) {
    if (cls.indexOf(' ') > -1) {
      cls.split(/\s+/).forEach(function (c) { return el.classList.remove(c); });
    } else {
      el.classList.remove(cls);
    }
    if (!el.classList.length) {
      el.removeAttribute('class');
    }
  } else {
    var cur = " " + (el.getAttribute('class') || '') + " ";
    var tar = ' ' + cls + ' ';
    while (cur.indexOf(tar) >= 0) {
      cur = cur.replace(tar, ' ');
    }
    cur = cur.trim();
    if (cur) {
      el.setAttribute('class', cur);
    } else {
      el.removeAttribute('class');
    }
  }
}

/*  */

function resolveTransition (def) {
  if (!def) {
    return
  }
  /* istanbul ignore else */
  if (typeof def === 'object') {
    var res = {};
    if (def.css !== false) {
      extend(res, autoCssTransition(def.name || 'v'));
    }
    extend(res, def);
    return res
  } else if (typeof def === 'string') {
    return autoCssTransition(def)
  }
}

var autoCssTransition = cached(function (name) {
  return {
    enterClass: (name + "-enter"),
    enterToClass: (name + "-enter-to"),
    enterActiveClass: (name + "-enter-active"),
    leaveClass: (name + "-leave"),
    leaveToClass: (name + "-leave-to"),
    leaveActiveClass: (name + "-leave-active")
  }
});

var hasTransition = inBrowser && !isIE9;
var TRANSITION = 'transition';
var ANIMATION = 'animation';

// Transition property/event sniffing
var transitionProp = 'transition';
var transitionEndEvent = 'transitionend';
var animationProp = 'animation';
var animationEndEvent = 'animationend';
if (hasTransition) {
  /* istanbul ignore if */
  if (window.ontransitionend === undefined &&
    window.onwebkittransitionend !== undefined
  ) {
    transitionProp = 'WebkitTransition';
    transitionEndEvent = 'webkitTransitionEnd';
  }
  if (window.onanimationend === undefined &&
    window.onwebkitanimationend !== undefined
  ) {
    animationProp = 'WebkitAnimation';
    animationEndEvent = 'webkitAnimationEnd';
  }
}

// binding to window is necessary to make hot reload work in IE in strict mode
var raf = inBrowser
  ? window.requestAnimationFrame
    ? window.requestAnimationFrame.bind(window)
    : setTimeout
  : /* istanbul ignore next */ function (fn) { return fn(); };

function nextFrame (fn) {
  raf(function () {
    raf(fn);
  });
}

function addTransitionClass (el, cls) {
  var transitionClasses = el._transitionClasses || (el._transitionClasses = []);
  if (transitionClasses.indexOf(cls) < 0) {
    transitionClasses.push(cls);
    addClass(el, cls);
  }
}

function removeTransitionClass (el, cls) {
  if (el._transitionClasses) {
    remove(el._transitionClasses, cls);
  }
  removeClass(el, cls);
}

function whenTransitionEnds (
  el,
  expectedType,
  cb
) {
  var ref = getTransitionInfo(el, expectedType);
  var type = ref.type;
  var timeout = ref.timeout;
  var propCount = ref.propCount;
  if (!type) { return cb() }
  var event = type === TRANSITION ? transitionEndEvent : animationEndEvent;
  var ended = 0;
  var end = function () {
    el.removeEventListener(event, onEnd);
    cb();
  };
  var onEnd = function (e) {
    if (e.target === el) {
      if (++ended >= propCount) {
        end();
      }
    }
  };
  setTimeout(function () {
    if (ended < propCount) {
      end();
    }
  }, timeout + 1);
  el.addEventListener(event, onEnd);
}

var transformRE = /\b(transform|all)(,|$)/;

function getTransitionInfo (el, expectedType) {
  var styles = window.getComputedStyle(el);
  var transitionDelays = styles[transitionProp + 'Delay'].split(', ');
  var transitionDurations = styles[transitionProp + 'Duration'].split(', ');
  var transitionTimeout = getTimeout(transitionDelays, transitionDurations);
  var animationDelays = styles[animationProp + 'Delay'].split(', ');
  var animationDurations = styles[animationProp + 'Duration'].split(', ');
  var animationTimeout = getTimeout(animationDelays, animationDurations);

  var type;
  var timeout = 0;
  var propCount = 0;
  /* istanbul ignore if */
  if (expectedType === TRANSITION) {
    if (transitionTimeout > 0) {
      type = TRANSITION;
      timeout = transitionTimeout;
      propCount = transitionDurations.length;
    }
  } else if (expectedType === ANIMATION) {
    if (animationTimeout > 0) {
      type = ANIMATION;
      timeout = animationTimeout;
      propCount = animationDurations.length;
    }
  } else {
    timeout = Math.max(transitionTimeout, animationTimeout);
    type = timeout > 0
      ? transitionTimeout > animationTimeout
        ? TRANSITION
        : ANIMATION
      : null;
    propCount = type
      ? type === TRANSITION
        ? transitionDurations.length
        : animationDurations.length
      : 0;
  }
  var hasTransform =
    type === TRANSITION &&
    transformRE.test(styles[transitionProp + 'Property']);
  return {
    type: type,
    timeout: timeout,
    propCount: propCount,
    hasTransform: hasTransform
  }
}

function getTimeout (delays, durations) {
  /* istanbul ignore next */
  while (delays.length < durations.length) {
    delays = delays.concat(delays);
  }

  return Math.max.apply(null, durations.map(function (d, i) {
    return toMs(d) + toMs(delays[i])
  }))
}

function toMs (s) {
  return Number(s.slice(0, -1)) * 1000
}

/*  */

function enter (vnode, toggleDisplay) {
  var el = vnode.elm;

  // call leave callback now
  if (isDef(el._leaveCb)) {
    el._leaveCb.cancelled = true;
    el._leaveCb();
  }

  var data = resolveTransition(vnode.data.transition);
  if (isUndef(data)) {
    return
  }

  /* istanbul ignore if */
  if (isDef(el._enterCb) || el.nodeType !== 1) {
    return
  }

  var css = data.css;
  var type = data.type;
  var enterClass = data.enterClass;
  var enterToClass = data.enterToClass;
  var enterActiveClass = data.enterActiveClass;
  var appearClass = data.appearClass;
  var appearToClass = data.appearToClass;
  var appearActiveClass = data.appearActiveClass;
  var beforeEnter = data.beforeEnter;
  var enter = data.enter;
  var afterEnter = data.afterEnter;
  var enterCancelled = data.enterCancelled;
  var beforeAppear = data.beforeAppear;
  var appear = data.appear;
  var afterAppear = data.afterAppear;
  var appearCancelled = data.appearCancelled;
  var duration = data.duration;

  // activeInstance will always be the <transition> component managing this
  // transition. One edge case to check is when the <transition> is placed
  // as the root node of a child component. In that case we need to check
  // <transition>'s parent for appear check.
  var context = activeInstance;
  var transitionNode = activeInstance.$vnode;
  while (transitionNode && transitionNode.parent) {
    transitionNode = transitionNode.parent;
    context = transitionNode.context;
  }

  var isAppear = !context._isMounted || !vnode.isRootInsert;

  if (isAppear && !appear && appear !== '') {
    return
  }

  var startClass = isAppear && appearClass
    ? appearClass
    : enterClass;
  var activeClass = isAppear && appearActiveClass
    ? appearActiveClass
    : enterActiveClass;
  var toClass = isAppear && appearToClass
    ? appearToClass
    : enterToClass;

  var beforeEnterHook = isAppear
    ? (beforeAppear || beforeEnter)
    : beforeEnter;
  var enterHook = isAppear
    ? (typeof appear === 'function' ? appear : enter)
    : enter;
  var afterEnterHook = isAppear
    ? (afterAppear || afterEnter)
    : afterEnter;
  var enterCancelledHook = isAppear
    ? (appearCancelled || enterCancelled)
    : enterCancelled;

  var explicitEnterDuration = toNumber(
    isObject(duration)
      ? duration.enter
      : duration
  );

  if ("development" !== 'production' && explicitEnterDuration != null) {
    checkDuration(explicitEnterDuration, 'enter', vnode);
  }

  var expectsCSS = css !== false && !isIE9;
  var userWantsControl = getHookArgumentsLength(enterHook);

  var cb = el._enterCb = once(function () {
    if (expectsCSS) {
      removeTransitionClass(el, toClass);
      removeTransitionClass(el, activeClass);
    }
    if (cb.cancelled) {
      if (expectsCSS) {
        removeTransitionClass(el, startClass);
      }
      enterCancelledHook && enterCancelledHook(el);
    } else {
      afterEnterHook && afterEnterHook(el);
    }
    el._enterCb = null;
  });

  if (!vnode.data.show) {
    // remove pending leave element on enter by injecting an insert hook
    mergeVNodeHook(vnode, 'insert', function () {
      var parent = el.parentNode;
      var pendingNode = parent && parent._pending && parent._pending[vnode.key];
      if (pendingNode &&
        pendingNode.tag === vnode.tag &&
        pendingNode.elm._leaveCb
      ) {
        pendingNode.elm._leaveCb();
      }
      enterHook && enterHook(el, cb);
    });
  }

  // start enter transition
  beforeEnterHook && beforeEnterHook(el);
  if (expectsCSS) {
    addTransitionClass(el, startClass);
    addTransitionClass(el, activeClass);
    nextFrame(function () {
      removeTransitionClass(el, startClass);
      if (!cb.cancelled) {
        addTransitionClass(el, toClass);
        if (!userWantsControl) {
          if (isValidDuration(explicitEnterDuration)) {
            setTimeout(cb, explicitEnterDuration);
          } else {
            whenTransitionEnds(el, type, cb);
          }
        }
      }
    });
  }

  if (vnode.data.show) {
    toggleDisplay && toggleDisplay();
    enterHook && enterHook(el, cb);
  }

  if (!expectsCSS && !userWantsControl) {
    cb();
  }
}

function leave (vnode, rm) {
  var el = vnode.elm;

  // call enter callback now
  if (isDef(el._enterCb)) {
    el._enterCb.cancelled = true;
    el._enterCb();
  }

  var data = resolveTransition(vnode.data.transition);
  if (isUndef(data) || el.nodeType !== 1) {
    return rm()
  }

  /* istanbul ignore if */
  if (isDef(el._leaveCb)) {
    return
  }

  var css = data.css;
  var type = data.type;
  var leaveClass = data.leaveClass;
  var leaveToClass = data.leaveToClass;
  var leaveActiveClass = data.leaveActiveClass;
  var beforeLeave = data.beforeLeave;
  var leave = data.leave;
  var afterLeave = data.afterLeave;
  var leaveCancelled = data.leaveCancelled;
  var delayLeave = data.delayLeave;
  var duration = data.duration;

  var expectsCSS = css !== false && !isIE9;
  var userWantsControl = getHookArgumentsLength(leave);

  var explicitLeaveDuration = toNumber(
    isObject(duration)
      ? duration.leave
      : duration
  );

  if ("development" !== 'production' && isDef(explicitLeaveDuration)) {
    checkDuration(explicitLeaveDuration, 'leave', vnode);
  }

  var cb = el._leaveCb = once(function () {
    if (el.parentNode && el.parentNode._pending) {
      el.parentNode._pending[vnode.key] = null;
    }
    if (expectsCSS) {
      removeTransitionClass(el, leaveToClass);
      removeTransitionClass(el, leaveActiveClass);
    }
    if (cb.cancelled) {
      if (expectsCSS) {
        removeTransitionClass(el, leaveClass);
      }
      leaveCancelled && leaveCancelled(el);
    } else {
      rm();
      afterLeave && afterLeave(el);
    }
    el._leaveCb = null;
  });

  if (delayLeave) {
    delayLeave(performLeave);
  } else {
    performLeave();
  }

  function performLeave () {
    // the delayed leave may have already been cancelled
    if (cb.cancelled) {
      return
    }
    // record leaving element
    if (!vnode.data.show) {
      (el.parentNode._pending || (el.parentNode._pending = {}))[(vnode.key)] = vnode;
    }
    beforeLeave && beforeLeave(el);
    if (expectsCSS) {
      addTransitionClass(el, leaveClass);
      addTransitionClass(el, leaveActiveClass);
      nextFrame(function () {
        removeTransitionClass(el, leaveClass);
        if (!cb.cancelled) {
          addTransitionClass(el, leaveToClass);
          if (!userWantsControl) {
            if (isValidDuration(explicitLeaveDuration)) {
              setTimeout(cb, explicitLeaveDuration);
            } else {
              whenTransitionEnds(el, type, cb);
            }
          }
        }
      });
    }
    leave && leave(el, cb);
    if (!expectsCSS && !userWantsControl) {
      cb();
    }
  }
}

// only used in dev mode
function checkDuration (val, name, vnode) {
  if (typeof val !== 'number') {
    warn(
      "<transition> explicit " + name + " duration is not a valid number - " +
      "got " + (JSON.stringify(val)) + ".",
      vnode.context
    );
  } else if (isNaN(val)) {
    warn(
      "<transition> explicit " + name + " duration is NaN - " +
      'the duration expression might be incorrect.',
      vnode.context
    );
  }
}

function isValidDuration (val) {
  return typeof val === 'number' && !isNaN(val)
}

/**
 * Normalize a transition hook's argument length. The hook may be:
 * - a merged hook (invoker) with the original in .fns
 * - a wrapped component method (check ._length)
 * - a plain function (.length)
 */
function getHookArgumentsLength (fn) {
  if (isUndef(fn)) {
    return false
  }
  var invokerFns = fn.fns;
  if (isDef(invokerFns)) {
    // invoker
    return getHookArgumentsLength(
      Array.isArray(invokerFns)
        ? invokerFns[0]
        : invokerFns
    )
  } else {
    return (fn._length || fn.length) > 1
  }
}

function _enter (_, vnode) {
  if (vnode.data.show !== true) {
    enter(vnode);
  }
}

var transition = inBrowser ? {
  create: _enter,
  activate: _enter,
  remove: function remove$$1 (vnode, rm) {
    /* istanbul ignore else */
    if (vnode.data.show !== true) {
      leave(vnode, rm);
    } else {
      rm();
    }
  }
} : {}

var platformModules = [
  attrs,
  klass,
  events,
  domProps,
  style,
  transition
]

/*  */

// the directive module should be applied last, after all
// built-in modules have been applied.
var modules = platformModules.concat(baseModules);

var patch = createPatchFunction({ nodeOps: nodeOps, modules: modules });

/**
 * Not type checking this file because flow doesn't like attaching
 * properties to Elements.
 */

/* istanbul ignore if */
if (isIE9) {
  // http://www.matts411.com/post/internet-explorer-9-oninput/
  document.addEventListener('selectionchange', function () {
    var el = document.activeElement;
    if (el && el.vmodel) {
      trigger(el, 'input');
    }
  });
}

var directive = {
  inserted: function inserted (el, binding, vnode, oldVnode) {
    if (vnode.tag === 'select') {
      // #6903
      if (oldVnode.elm && !oldVnode.elm._vOptions) {
        mergeVNodeHook(vnode, 'postpatch', function () {
          directive.componentUpdated(el, binding, vnode);
        });
      } else {
        setSelected(el, binding, vnode.context);
      }
      el._vOptions = [].map.call(el.options, getValue);
    } else if (vnode.tag === 'textarea' || isTextInputType(el.type)) {
      el._vModifiers = binding.modifiers;
      if (!binding.modifiers.lazy) {
        el.addEventListener('compositionstart', onCompositionStart);
        el.addEventListener('compositionend', onCompositionEnd);
        // Safari < 10.2 & UIWebView doesn't fire compositionend when
        // switching focus before confirming composition choice
        // this also fixes the issue where some browsers e.g. iOS Chrome
        // fires "change" instead of "input" on autocomplete.
        el.addEventListener('change', onCompositionEnd);
        /* istanbul ignore if */
        if (isIE9) {
          el.vmodel = true;
        }
      }
    }
  },

  componentUpdated: function componentUpdated (el, binding, vnode) {
    if (vnode.tag === 'select') {
      setSelected(el, binding, vnode.context);
      // in case the options rendered by v-for have changed,
      // it's possible that the value is out-of-sync with the rendered options.
      // detect such cases and filter out values that no longer has a matching
      // option in the DOM.
      var prevOptions = el._vOptions;
      var curOptions = el._vOptions = [].map.call(el.options, getValue);
      if (curOptions.some(function (o, i) { return !looseEqual(o, prevOptions[i]); })) {
        // trigger change event if
        // no matching option found for at least one value
        var needReset = el.multiple
          ? binding.value.some(function (v) { return hasNoMatchingOption(v, curOptions); })
          : binding.value !== binding.oldValue && hasNoMatchingOption(binding.value, curOptions);
        if (needReset) {
          trigger(el, 'change');
        }
      }
    }
  }
};

function setSelected (el, binding, vm) {
  actuallySetSelected(el, binding, vm);
  /* istanbul ignore if */
  if (isIE || isEdge) {
    setTimeout(function () {
      actuallySetSelected(el, binding, vm);
    }, 0);
  }
}

function actuallySetSelected (el, binding, vm) {
  var value = binding.value;
  var isMultiple = el.multiple;
  if (isMultiple && !Array.isArray(value)) {
    "development" !== 'production' && warn(
      "<select multiple v-model=\"" + (binding.expression) + "\"> " +
      "expects an Array value for its binding, but got " + (Object.prototype.toString.call(value).slice(8, -1)),
      vm
    );
    return
  }
  var selected, option;
  for (var i = 0, l = el.options.length; i < l; i++) {
    option = el.options[i];
    if (isMultiple) {
      selected = looseIndexOf(value, getValue(option)) > -1;
      if (option.selected !== selected) {
        option.selected = selected;
      }
    } else {
      if (looseEqual(getValue(option), value)) {
        if (el.selectedIndex !== i) {
          el.selectedIndex = i;
        }
        return
      }
    }
  }
  if (!isMultiple) {
    el.selectedIndex = -1;
  }
}

function hasNoMatchingOption (value, options) {
  return options.every(function (o) { return !looseEqual(o, value); })
}

function getValue (option) {
  return '_value' in option
    ? option._value
    : option.value
}

function onCompositionStart (e) {
  e.target.composing = true;
}

function onCompositionEnd (e) {
  // prevent triggering an input event for no reason
  if (!e.target.composing) { return }
  e.target.composing = false;
  trigger(e.target, 'input');
}

function trigger (el, type) {
  var e = document.createEvent('HTMLEvents');
  e.initEvent(type, true, true);
  el.dispatchEvent(e);
}

/*  */

// recursively search for possible transition defined inside the component root
function locateNode (vnode) {
  return vnode.componentInstance && (!vnode.data || !vnode.data.transition)
    ? locateNode(vnode.componentInstance._vnode)
    : vnode
}

var show = {
  bind: function bind (el, ref, vnode) {
    var value = ref.value;

    vnode = locateNode(vnode);
    var transition$$1 = vnode.data && vnode.data.transition;
    var originalDisplay = el.__vOriginalDisplay =
      el.style.display === 'none' ? '' : el.style.display;
    if (value && transition$$1) {
      vnode.data.show = true;
      enter(vnode, function () {
        el.style.display = originalDisplay;
      });
    } else {
      el.style.display = value ? originalDisplay : 'none';
    }
  },

  update: function update (el, ref, vnode) {
    var value = ref.value;
    var oldValue = ref.oldValue;

    /* istanbul ignore if */
    if (!value === !oldValue) { return }
    vnode = locateNode(vnode);
    var transition$$1 = vnode.data && vnode.data.transition;
    if (transition$$1) {
      vnode.data.show = true;
      if (value) {
        enter(vnode, function () {
          el.style.display = el.__vOriginalDisplay;
        });
      } else {
        leave(vnode, function () {
          el.style.display = 'none';
        });
      }
    } else {
      el.style.display = value ? el.__vOriginalDisplay : 'none';
    }
  },

  unbind: function unbind (
    el,
    binding,
    vnode,
    oldVnode,
    isDestroy
  ) {
    if (!isDestroy) {
      el.style.display = el.__vOriginalDisplay;
    }
  }
}

var platformDirectives = {
  model: directive,
  show: show
}

/*  */

// Provides transition support for a single element/component.
// supports transition mode (out-in / in-out)

var transitionProps = {
  name: String,
  appear: Boolean,
  css: Boolean,
  mode: String,
  type: String,
  enterClass: String,
  leaveClass: String,
  enterToClass: String,
  leaveToClass: String,
  enterActiveClass: String,
  leaveActiveClass: String,
  appearClass: String,
  appearActiveClass: String,
  appearToClass: String,
  duration: [Number, String, Object]
};

// in case the child is also an abstract component, e.g. <keep-alive>
// we want to recursively retrieve the real component to be rendered
function getRealChild (vnode) {
  var compOptions = vnode && vnode.componentOptions;
  if (compOptions && compOptions.Ctor.options.abstract) {
    return getRealChild(getFirstComponentChild(compOptions.children))
  } else {
    return vnode
  }
}

function extractTransitionData (comp) {
  var data = {};
  var options = comp.$options;
  // props
  for (var key in options.propsData) {
    data[key] = comp[key];
  }
  // events.
  // extract listeners and pass them directly to the transition methods
  var listeners = options._parentListeners;
  for (var key$1 in listeners) {
    data[camelize(key$1)] = listeners[key$1];
  }
  return data
}

function placeholder (h, rawChild) {
  if (/\d-keep-alive$/.test(rawChild.tag)) {
    return h('keep-alive', {
      props: rawChild.componentOptions.propsData
    })
  }
}

function hasParentTransition (vnode) {
  while ((vnode = vnode.parent)) {
    if (vnode.data.transition) {
      return true
    }
  }
}

function isSameChild (child, oldChild) {
  return oldChild.key === child.key && oldChild.tag === child.tag
}

var Transition = {
  name: 'transition',
  props: transitionProps,
  abstract: true,

  render: function render (h) {
    var this$1 = this;

    var children = this.$slots.default;
    if (!children) {
      return
    }

    // filter out text nodes (possible whitespaces)
    children = children.filter(function (c) { return c.tag || isAsyncPlaceholder(c); });
    /* istanbul ignore if */
    if (!children.length) {
      return
    }

    // warn multiple elements
    if ("development" !== 'production' && children.length > 1) {
      warn(
        '<transition> can only be used on a single element. Use ' +
        '<transition-group> for lists.',
        this.$parent
      );
    }

    var mode = this.mode;

    // warn invalid mode
    if ("development" !== 'production' &&
      mode && mode !== 'in-out' && mode !== 'out-in'
    ) {
      warn(
        'invalid <transition> mode: ' + mode,
        this.$parent
      );
    }

    var rawChild = children[0];

    // if this is a component root node and the component's
    // parent container node also has transition, skip.
    if (hasParentTransition(this.$vnode)) {
      return rawChild
    }

    // apply transition data to child
    // use getRealChild() to ignore abstract components e.g. keep-alive
    var child = getRealChild(rawChild);
    /* istanbul ignore if */
    if (!child) {
      return rawChild
    }

    if (this._leaving) {
      return placeholder(h, rawChild)
    }

    // ensure a key that is unique to the vnode type and to this transition
    // component instance. This key will be used to remove pending leaving nodes
    // during entering.
    var id = "__transition-" + (this._uid) + "-";
    child.key = child.key == null
      ? child.isComment
        ? id + 'comment'
        : id + child.tag
      : isPrimitive(child.key)
        ? (String(child.key).indexOf(id) === 0 ? child.key : id + child.key)
        : child.key;

    var data = (child.data || (child.data = {})).transition = extractTransitionData(this);
    var oldRawChild = this._vnode;
    var oldChild = getRealChild(oldRawChild);

    // mark v-show
    // so that the transition module can hand over the control to the directive
    if (child.data.directives && child.data.directives.some(function (d) { return d.name === 'show'; })) {
      child.data.show = true;
    }

    if (
      oldChild &&
      oldChild.data &&
      !isSameChild(child, oldChild) &&
      !isAsyncPlaceholder(oldChild) &&
      // #6687 component root is a comment node
      !(oldChild.componentInstance && oldChild.componentInstance._vnode.isComment)
    ) {
      // replace old child transition data with fresh one
      // important for dynamic transitions!
      var oldData = oldChild.data.transition = extend({}, data);
      // handle transition mode
      if (mode === 'out-in') {
        // return placeholder node and queue update when leave finishes
        this._leaving = true;
        mergeVNodeHook(oldData, 'afterLeave', function () {
          this$1._leaving = false;
          this$1.$forceUpdate();
        });
        return placeholder(h, rawChild)
      } else if (mode === 'in-out') {
        if (isAsyncPlaceholder(child)) {
          return oldRawChild
        }
        var delayedLeave;
        var performLeave = function () { delayedLeave(); };
        mergeVNodeHook(data, 'afterEnter', performLeave);
        mergeVNodeHook(data, 'enterCancelled', performLeave);
        mergeVNodeHook(oldData, 'delayLeave', function (leave) { delayedLeave = leave; });
      }
    }

    return rawChild
  }
}

/*  */

// Provides transition support for list items.
// supports move transitions using the FLIP technique.

// Because the vdom's children update algorithm is "unstable" - i.e.
// it doesn't guarantee the relative positioning of removed elements,
// we force transition-group to update its children into two passes:
// in the first pass, we remove all nodes that need to be removed,
// triggering their leaving transition; in the second pass, we insert/move
// into the final desired state. This way in the second pass removed
// nodes will remain where they should be.

var props = extend({
  tag: String,
  moveClass: String
}, transitionProps);

delete props.mode;

var TransitionGroup = {
  props: props,

  render: function render (h) {
    var tag = this.tag || this.$vnode.data.tag || 'span';
    var map = Object.create(null);
    var prevChildren = this.prevChildren = this.children;
    var rawChildren = this.$slots.default || [];
    var children = this.children = [];
    var transitionData = extractTransitionData(this);

    for (var i = 0; i < rawChildren.length; i++) {
      var c = rawChildren[i];
      if (c.tag) {
        if (c.key != null && String(c.key).indexOf('__vlist') !== 0) {
          children.push(c);
          map[c.key] = c
          ;(c.data || (c.data = {})).transition = transitionData;
        } else if (true) {
          var opts = c.componentOptions;
          var name = opts ? (opts.Ctor.options.name || opts.tag || '') : c.tag;
          warn(("<transition-group> children must be keyed: <" + name + ">"));
        }
      }
    }

    if (prevChildren) {
      var kept = [];
      var removed = [];
      for (var i$1 = 0; i$1 < prevChildren.length; i$1++) {
        var c$1 = prevChildren[i$1];
        c$1.data.transition = transitionData;
        c$1.data.pos = c$1.elm.getBoundingClientRect();
        if (map[c$1.key]) {
          kept.push(c$1);
        } else {
          removed.push(c$1);
        }
      }
      this.kept = h(tag, null, kept);
      this.removed = removed;
    }

    return h(tag, null, children)
  },

  beforeUpdate: function beforeUpdate () {
    // force removing pass
    this.__patch__(
      this._vnode,
      this.kept,
      false, // hydrating
      true // removeOnly (!important, avoids unnecessary moves)
    );
    this._vnode = this.kept;
  },

  updated: function updated () {
    var children = this.prevChildren;
    var moveClass = this.moveClass || ((this.name || 'v') + '-move');
    if (!children.length || !this.hasMove(children[0].elm, moveClass)) {
      return
    }

    // we divide the work into three loops to avoid mixing DOM reads and writes
    // in each iteration - which helps prevent layout thrashing.
    children.forEach(callPendingCbs);
    children.forEach(recordPosition);
    children.forEach(applyTranslation);

    // force reflow to put everything in position
    // assign to this to avoid being removed in tree-shaking
    // $flow-disable-line
    this._reflow = document.body.offsetHeight;

    children.forEach(function (c) {
      if (c.data.moved) {
        var el = c.elm;
        var s = el.style;
        addTransitionClass(el, moveClass);
        s.transform = s.WebkitTransform = s.transitionDuration = '';
        el.addEventListener(transitionEndEvent, el._moveCb = function cb (e) {
          if (!e || /transform$/.test(e.propertyName)) {
            el.removeEventListener(transitionEndEvent, cb);
            el._moveCb = null;
            removeTransitionClass(el, moveClass);
          }
        });
      }
    });
  },

  methods: {
    hasMove: function hasMove (el, moveClass) {
      /* istanbul ignore if */
      if (!hasTransition) {
        return false
      }
      /* istanbul ignore if */
      if (this._hasMove) {
        return this._hasMove
      }
      // Detect whether an element with the move class applied has
      // CSS transitions. Since the element may be inside an entering
      // transition at this very moment, we make a clone of it and remove
      // all other transition classes applied to ensure only the move class
      // is applied.
      var clone = el.cloneNode();
      if (el._transitionClasses) {
        el._transitionClasses.forEach(function (cls) { removeClass(clone, cls); });
      }
      addClass(clone, moveClass);
      clone.style.display = 'none';
      this.$el.appendChild(clone);
      var info = getTransitionInfo(clone);
      this.$el.removeChild(clone);
      return (this._hasMove = info.hasTransform)
    }
  }
}

function callPendingCbs (c) {
  /* istanbul ignore if */
  if (c.elm._moveCb) {
    c.elm._moveCb();
  }
  /* istanbul ignore if */
  if (c.elm._enterCb) {
    c.elm._enterCb();
  }
}

function recordPosition (c) {
  c.data.newPos = c.elm.getBoundingClientRect();
}

function applyTranslation (c) {
  var oldPos = c.data.pos;
  var newPos = c.data.newPos;
  var dx = oldPos.left - newPos.left;
  var dy = oldPos.top - newPos.top;
  if (dx || dy) {
    c.data.moved = true;
    var s = c.elm.style;
    s.transform = s.WebkitTransform = "translate(" + dx + "px," + dy + "px)";
    s.transitionDuration = '0s';
  }
}

var platformComponents = {
  Transition: Transition,
  TransitionGroup: TransitionGroup
}

/*  */

// install platform specific utils
Vue.config.mustUseProp = mustUseProp;
Vue.config.isReservedTag = isReservedTag;
Vue.config.isReservedAttr = isReservedAttr;
Vue.config.getTagNamespace = getTagNamespace;
Vue.config.isUnknownElement = isUnknownElement;

// install platform runtime directives & components
extend(Vue.options.directives, platformDirectives);
extend(Vue.options.components, platformComponents);

// install platform patch function
Vue.prototype.__patch__ = inBrowser ? patch : noop;

// public mount method
Vue.prototype.$mount = function (
  el,
  hydrating
) {
  el = el && inBrowser ? query(el) : undefined;
  return mountComponent(this, el, hydrating)
};

// devtools global hook
/* istanbul ignore next */
if (inBrowser) {
  setTimeout(function () {
    if (config.devtools) {
      if (devtools) {
        devtools.emit('init', Vue);
      } else if (
        "development" !== 'production' &&
        "development" !== 'test' &&
        isChrome
      ) {
        console[console.info ? 'info' : 'log'](
          'Download the Vue Devtools extension for a better development experience:\n' +
          'https://github.com/vuejs/vue-devtools'
        );
      }
    }
    if ("development" !== 'production' &&
      "development" !== 'test' &&
      config.productionTip !== false &&
      typeof console !== 'undefined'
    ) {
      console[console.info ? 'info' : 'log'](
        "You are running Vue in development mode.\n" +
        "Make sure to turn on production mode when deploying for production.\n" +
        "See more tips at https://vuejs.org/guide/deployment.html"
      );
    }
  }, 0);
}

/*  */

var defaultTagRE = /\{\{((?:.|\n)+?)\}\}/g;
var regexEscapeRE = /[-.*+?^${}()|[\]\/\\]/g;

var buildRegex = cached(function (delimiters) {
  var open = delimiters[0].replace(regexEscapeRE, '\\$&');
  var close = delimiters[1].replace(regexEscapeRE, '\\$&');
  return new RegExp(open + '((?:.|\\n)+?)' + close, 'g')
});



function parseText (
  text,
  delimiters
) {
  var tagRE = delimiters ? buildRegex(delimiters) : defaultTagRE;
  if (!tagRE.test(text)) {
    return
  }
  var tokens = [];
  var rawTokens = [];
  var lastIndex = tagRE.lastIndex = 0;
  var match, index, tokenValue;
  while ((match = tagRE.exec(text))) {
    index = match.index;
    // push text token
    if (index > lastIndex) {
      rawTokens.push(tokenValue = text.slice(lastIndex, index));
      tokens.push(JSON.stringify(tokenValue));
    }
    // tag token
    var exp = parseFilters(match[1].trim());
    tokens.push(("_s(" + exp + ")"));
    rawTokens.push({ '@binding': exp });
    lastIndex = index + match[0].length;
  }
  if (lastIndex < text.length) {
    rawTokens.push(tokenValue = text.slice(lastIndex));
    tokens.push(JSON.stringify(tokenValue));
  }
  return {
    expression: tokens.join('+'),
    tokens: rawTokens
  }
}

/*  */

function transformNode (el, options) {
  var warn = options.warn || baseWarn;
  var staticClass = getAndRemoveAttr(el, 'class');
  if ("development" !== 'production' && staticClass) {
    var res = parseText(staticClass, options.delimiters);
    if (res) {
      warn(
        "class=\"" + staticClass + "\": " +
        'Interpolation inside attributes has been removed. ' +
        'Use v-bind or the colon shorthand instead. For example, ' +
        'instead of <div class="{{ val }}">, use <div :class="val">.'
      );
    }
  }
  if (staticClass) {
    el.staticClass = JSON.stringify(staticClass);
  }
  var classBinding = getBindingAttr(el, 'class', false /* getStatic */);
  if (classBinding) {
    el.classBinding = classBinding;
  }
}

function genData (el) {
  var data = '';
  if (el.staticClass) {
    data += "staticClass:" + (el.staticClass) + ",";
  }
  if (el.classBinding) {
    data += "class:" + (el.classBinding) + ",";
  }
  return data
}

var klass$1 = {
  staticKeys: ['staticClass'],
  transformNode: transformNode,
  genData: genData
}

/*  */

function transformNode$1 (el, options) {
  var warn = options.warn || baseWarn;
  var staticStyle = getAndRemoveAttr(el, 'style');
  if (staticStyle) {
    /* istanbul ignore if */
    if (true) {
      var res = parseText(staticStyle, options.delimiters);
      if (res) {
        warn(
          "style=\"" + staticStyle + "\": " +
          'Interpolation inside attributes has been removed. ' +
          'Use v-bind or the colon shorthand instead. For example, ' +
          'instead of <div style="{{ val }}">, use <div :style="val">.'
        );
      }
    }
    el.staticStyle = JSON.stringify(parseStyleText(staticStyle));
  }

  var styleBinding = getBindingAttr(el, 'style', false /* getStatic */);
  if (styleBinding) {
    el.styleBinding = styleBinding;
  }
}

function genData$1 (el) {
  var data = '';
  if (el.staticStyle) {
    data += "staticStyle:" + (el.staticStyle) + ",";
  }
  if (el.styleBinding) {
    data += "style:(" + (el.styleBinding) + "),";
  }
  return data
}

var style$1 = {
  staticKeys: ['staticStyle'],
  transformNode: transformNode$1,
  genData: genData$1
}

/*  */

var decoder;

var he = {
  decode: function decode (html) {
    decoder = decoder || document.createElement('div');
    decoder.innerHTML = html;
    return decoder.textContent
  }
}

/*  */

var isUnaryTag = makeMap(
  'area,base,br,col,embed,frame,hr,img,input,isindex,keygen,' +
  'link,meta,param,source,track,wbr'
);

// Elements that you can, intentionally, leave open
// (and which close themselves)
var canBeLeftOpenTag = makeMap(
  'colgroup,dd,dt,li,options,p,td,tfoot,th,thead,tr,source'
);

// HTML5 tags https://html.spec.whatwg.org/multipage/indices.html#elements-3
// Phrasing Content https://html.spec.whatwg.org/multipage/dom.html#phrasing-content
var isNonPhrasingTag = makeMap(
  'address,article,aside,base,blockquote,body,caption,col,colgroup,dd,' +
  'details,dialog,div,dl,dt,fieldset,figcaption,figure,footer,form,' +
  'h1,h2,h3,h4,h5,h6,head,header,hgroup,hr,html,legend,li,menuitem,meta,' +
  'optgroup,option,param,rp,rt,source,style,summary,tbody,td,tfoot,th,thead,' +
  'title,tr,track'
);

/**
 * Not type-checking this file because it's mostly vendor code.
 */

/*!
 * HTML Parser By John Resig (ejohn.org)
 * Modified by Juriy "kangax" Zaytsev
 * Original code by Erik Arvidsson, Mozilla Public License
 * http://erik.eae.net/simplehtmlparser/simplehtmlparser.js
 */

// Regular Expressions for parsing tags and attributes
var attribute = /^\s*([^\s"'<>\/=]+)(?:\s*(=)\s*(?:"([^"]*)"+|'([^']*)'+|([^\s"'=<>`]+)))?/;
// could use https://www.w3.org/TR/1999/REC-xml-names-19990114/#NT-QName
// but for Vue templates we can enforce a simple charset
var ncname = '[a-zA-Z_][\\w\\-\\.]*';
var qnameCapture = "((?:" + ncname + "\\:)?" + ncname + ")";
var startTagOpen = new RegExp(("^<" + qnameCapture));
var startTagClose = /^\s*(\/?)>/;
var endTag = new RegExp(("^<\\/" + qnameCapture + "[^>]*>"));
var doctype = /^<!DOCTYPE [^>]+>/i;
// #7298: escape - to avoid being pased as HTML comment when inlined in page
var comment = /^<!\--/;
var conditionalComment = /^<!\[/;

var IS_REGEX_CAPTURING_BROKEN = false;
'x'.replace(/x(.)?/g, function (m, g) {
  IS_REGEX_CAPTURING_BROKEN = g === '';
});

// Special Elements (can contain anything)
var isPlainTextElement = makeMap('script,style,textarea', true);
var reCache = {};

var decodingMap = {
  '&lt;': '<',
  '&gt;': '>',
  '&quot;': '"',
  '&amp;': '&',
  '&#10;': '\n',
  '&#9;': '\t'
};
var encodedAttr = /&(?:lt|gt|quot|amp);/g;
var encodedAttrWithNewLines = /&(?:lt|gt|quot|amp|#10|#9);/g;

// #5992
var isIgnoreNewlineTag = makeMap('pre,textarea', true);
var shouldIgnoreFirstNewline = function (tag, html) { return tag && isIgnoreNewlineTag(tag) && html[0] === '\n'; };

function decodeAttr (value, shouldDecodeNewlines) {
  var re = shouldDecodeNewlines ? encodedAttrWithNewLines : encodedAttr;
  return value.replace(re, function (match) { return decodingMap[match]; })
}

function parseHTML (html, options) {
  var stack = [];
  var expectHTML = options.expectHTML;
  var isUnaryTag$$1 = options.isUnaryTag || no;
  var canBeLeftOpenTag$$1 = options.canBeLeftOpenTag || no;
  var index = 0;
  var last, lastTag;
  while (html) {
    last = html;
    // Make sure we're not in a plaintext content element like script/style
    if (!lastTag || !isPlainTextElement(lastTag)) {
      var textEnd = html.indexOf('<');
      if (textEnd === 0) {
        // Comment:
        if (comment.test(html)) {
          var commentEnd = html.indexOf('-->');

          if (commentEnd >= 0) {
            if (options.shouldKeepComment) {
              options.comment(html.substring(4, commentEnd));
            }
            advance(commentEnd + 3);
            continue
          }
        }

        // http://en.wikipedia.org/wiki/Conditional_comment#Downlevel-revealed_conditional_comment
        if (conditionalComment.test(html)) {
          var conditionalEnd = html.indexOf(']>');

          if (conditionalEnd >= 0) {
            advance(conditionalEnd + 2);
            continue
          }
        }

        // Doctype:
        var doctypeMatch = html.match(doctype);
        if (doctypeMatch) {
          advance(doctypeMatch[0].length);
          continue
        }

        // End tag:
        var endTagMatch = html.match(endTag);
        if (endTagMatch) {
          var curIndex = index;
          advance(endTagMatch[0].length);
          parseEndTag(endTagMatch[1], curIndex, index);
          continue
        }

        // Start tag:
        var startTagMatch = parseStartTag();
        if (startTagMatch) {
          handleStartTag(startTagMatch);
          if (shouldIgnoreFirstNewline(lastTag, html)) {
            advance(1);
          }
          continue
        }
      }

      var text = (void 0), rest = (void 0), next = (void 0);
      if (textEnd >= 0) {
        rest = html.slice(textEnd);
        while (
          !endTag.test(rest) &&
          !startTagOpen.test(rest) &&
          !comment.test(rest) &&
          !conditionalComment.test(rest)
        ) {
          // < in plain text, be forgiving and treat it as text
          next = rest.indexOf('<', 1);
          if (next < 0) { break }
          textEnd += next;
          rest = html.slice(textEnd);
        }
        text = html.substring(0, textEnd);
        advance(textEnd);
      }

      if (textEnd < 0) {
        text = html;
        html = '';
      }

      if (options.chars && text) {
        options.chars(text);
      }
    } else {
      var endTagLength = 0;
      var stackedTag = lastTag.toLowerCase();
      var reStackedTag = reCache[stackedTag] || (reCache[stackedTag] = new RegExp('([\\s\\S]*?)(</' + stackedTag + '[^>]*>)', 'i'));
      var rest$1 = html.replace(reStackedTag, function (all, text, endTag) {
        endTagLength = endTag.length;
        if (!isPlainTextElement(stackedTag) && stackedTag !== 'noscript') {
          text = text
            .replace(/<!\--([\s\S]*?)-->/g, '$1') // #7298
            .replace(/<!\[CDATA\[([\s\S]*?)]]>/g, '$1');
        }
        if (shouldIgnoreFirstNewline(stackedTag, text)) {
          text = text.slice(1);
        }
        if (options.chars) {
          options.chars(text);
        }
        return ''
      });
      index += html.length - rest$1.length;
      html = rest$1;
      parseEndTag(stackedTag, index - endTagLength, index);
    }

    if (html === last) {
      options.chars && options.chars(html);
      if ("development" !== 'production' && !stack.length && options.warn) {
        options.warn(("Mal-formatted tag at end of template: \"" + html + "\""));
      }
      break
    }
  }

  // Clean up any remaining tags
  parseEndTag();

  function advance (n) {
    index += n;
    html = html.substring(n);
  }

  function parseStartTag () {
    var start = html.match(startTagOpen);
    if (start) {
      var match = {
        tagName: start[1],
        attrs: [],
        start: index
      };
      advance(start[0].length);
      var end, attr;
      while (!(end = html.match(startTagClose)) && (attr = html.match(attribute))) {
        advance(attr[0].length);
        match.attrs.push(attr);
      }
      if (end) {
        match.unarySlash = end[1];
        advance(end[0].length);
        match.end = index;
        return match
      }
    }
  }

  function handleStartTag (match) {
    var tagName = match.tagName;
    var unarySlash = match.unarySlash;

    if (expectHTML) {
      if (lastTag === 'p' && isNonPhrasingTag(tagName)) {
        parseEndTag(lastTag);
      }
      if (canBeLeftOpenTag$$1(tagName) && lastTag === tagName) {
        parseEndTag(tagName);
      }
    }

    var unary = isUnaryTag$$1(tagName) || !!unarySlash;

    var l = match.attrs.length;
    var attrs = new Array(l);
    for (var i = 0; i < l; i++) {
      var args = match.attrs[i];
      // hackish work around FF bug https://bugzilla.mozilla.org/show_bug.cgi?id=369778
      if (IS_REGEX_CAPTURING_BROKEN && args[0].indexOf('""') === -1) {
        if (args[3] === '') { delete args[3]; }
        if (args[4] === '') { delete args[4]; }
        if (args[5] === '') { delete args[5]; }
      }
      var value = args[3] || args[4] || args[5] || '';
      var shouldDecodeNewlines = tagName === 'a' && args[1] === 'href'
        ? options.shouldDecodeNewlinesForHref
        : options.shouldDecodeNewlines;
      attrs[i] = {
        name: args[1],
        value: decodeAttr(value, shouldDecodeNewlines)
      };
    }

    if (!unary) {
      stack.push({ tag: tagName, lowerCasedTag: tagName.toLowerCase(), attrs: attrs });
      lastTag = tagName;
    }

    if (options.start) {
      options.start(tagName, attrs, unary, match.start, match.end);
    }
  }

  function parseEndTag (tagName, start, end) {
    var pos, lowerCasedTagName;
    if (start == null) { start = index; }
    if (end == null) { end = index; }

    if (tagName) {
      lowerCasedTagName = tagName.toLowerCase();
    }

    // Find the closest opened tag of the same type
    if (tagName) {
      for (pos = stack.length - 1; pos >= 0; pos--) {
        if (stack[pos].lowerCasedTag === lowerCasedTagName) {
          break
        }
      }
    } else {
      // If no tag name is provided, clean shop
      pos = 0;
    }

    if (pos >= 0) {
      // Close all the open elements, up the stack
      for (var i = stack.length - 1; i >= pos; i--) {
        if ("development" !== 'production' &&
          (i > pos || !tagName) &&
          options.warn
        ) {
          options.warn(
            ("tag <" + (stack[i].tag) + "> has no matching end tag.")
          );
        }
        if (options.end) {
          options.end(stack[i].tag, start, end);
        }
      }

      // Remove the open elements from the stack
      stack.length = pos;
      lastTag = pos && stack[pos - 1].tag;
    } else if (lowerCasedTagName === 'br') {
      if (options.start) {
        options.start(tagName, [], true, start, end);
      }
    } else if (lowerCasedTagName === 'p') {
      if (options.start) {
        options.start(tagName, [], false, start, end);
      }
      if (options.end) {
        options.end(tagName, start, end);
      }
    }
  }
}

/*  */

var onRE = /^@|^v-on:/;
var dirRE = /^v-|^@|^:/;
var forAliasRE = /([^]*?)\s+(?:in|of)\s+([^]*)/;
var forIteratorRE = /,([^,\}\]]*)(?:,([^,\}\]]*))?$/;
var stripParensRE = /^\(|\)$/g;

var argRE = /:(.*)$/;
var bindRE = /^:|^v-bind:/;
var modifierRE = /\.[^.]+/g;

var decodeHTMLCached = cached(he.decode);

// configurable state
var warn$2;
var delimiters;
var transforms;
var preTransforms;
var postTransforms;
var platformIsPreTag;
var platformMustUseProp;
var platformGetTagNamespace;



function createASTElement (
  tag,
  attrs,
  parent
) {
  return {
    type: 1,
    tag: tag,
    attrsList: attrs,
    attrsMap: makeAttrsMap(attrs),
    parent: parent,
    children: []
  }
}

/**
 * Convert HTML string to AST.
 */
function parse (
  template,
  options
) {
  warn$2 = options.warn || baseWarn;

  platformIsPreTag = options.isPreTag || no;
  platformMustUseProp = options.mustUseProp || no;
  platformGetTagNamespace = options.getTagNamespace || no;

  transforms = pluckModuleFunction(options.modules, 'transformNode');
  preTransforms = pluckModuleFunction(options.modules, 'preTransformNode');
  postTransforms = pluckModuleFunction(options.modules, 'postTransformNode');

  delimiters = options.delimiters;

  var stack = [];
  var preserveWhitespace = options.preserveWhitespace !== false;
  var root;
  var currentParent;
  var inVPre = false;
  var inPre = false;
  var warned = false;

  function warnOnce (msg) {
    if (!warned) {
      warned = true;
      warn$2(msg);
    }
  }

  function closeElement (element) {
    // check pre state
    if (element.pre) {
      inVPre = false;
    }
    if (platformIsPreTag(element.tag)) {
      inPre = false;
    }
    // apply post-transforms
    for (var i = 0; i < postTransforms.length; i++) {
      postTransforms[i](element, options);
    }
  }

  parseHTML(template, {
    warn: warn$2,
    expectHTML: options.expectHTML,
    isUnaryTag: options.isUnaryTag,
    canBeLeftOpenTag: options.canBeLeftOpenTag,
    shouldDecodeNewlines: options.shouldDecodeNewlines,
    shouldDecodeNewlinesForHref: options.shouldDecodeNewlinesForHref,
    shouldKeepComment: options.comments,
    start: function start (tag, attrs, unary) {
      // check namespace.
      // inherit parent ns if there is one
      var ns = (currentParent && currentParent.ns) || platformGetTagNamespace(tag);

      // handle IE svg bug
      /* istanbul ignore if */
      if (isIE && ns === 'svg') {
        attrs = guardIESVGBug(attrs);
      }

      var element = createASTElement(tag, attrs, currentParent);
      if (ns) {
        element.ns = ns;
      }

      if (isForbiddenTag(element) && !isServerRendering()) {
        element.forbidden = true;
        "development" !== 'production' && warn$2(
          'Templates should only be responsible for mapping the state to the ' +
          'UI. Avoid placing tags with side-effects in your templates, such as ' +
          "<" + tag + ">" + ', as they will not be parsed.'
        );
      }

      // apply pre-transforms
      for (var i = 0; i < preTransforms.length; i++) {
        element = preTransforms[i](element, options) || element;
      }

      if (!inVPre) {
        processPre(element);
        if (element.pre) {
          inVPre = true;
        }
      }
      if (platformIsPreTag(element.tag)) {
        inPre = true;
      }
      if (inVPre) {
        processRawAttrs(element);
      } else if (!element.processed) {
        // structural directives
        processFor(element);
        processIf(element);
        processOnce(element);
        // element-scope stuff
        processElement(element, options);
      }

      function checkRootConstraints (el) {
        if (true) {
          if (el.tag === 'slot' || el.tag === 'template') {
            warnOnce(
              "Cannot use <" + (el.tag) + "> as component root element because it may " +
              'contain multiple nodes.'
            );
          }
          if (el.attrsMap.hasOwnProperty('v-for')) {
            warnOnce(
              'Cannot use v-for on stateful component root element because ' +
              'it renders multiple elements.'
            );
          }
        }
      }

      // tree management
      if (!root) {
        root = element;
        checkRootConstraints(root);
      } else if (!stack.length) {
        // allow root elements with v-if, v-else-if and v-else
        if (root.if && (element.elseif || element.else)) {
          checkRootConstraints(element);
          addIfCondition(root, {
            exp: element.elseif,
            block: element
          });
        } else if (true) {
          warnOnce(
            "Component template should contain exactly one root element. " +
            "If you are using v-if on multiple elements, " +
            "use v-else-if to chain them instead."
          );
        }
      }
      if (currentParent && !element.forbidden) {
        if (element.elseif || element.else) {
          processIfConditions(element, currentParent);
        } else if (element.slotScope) { // scoped slot
          currentParent.plain = false;
          var name = element.slotTarget || '"default"';(currentParent.scopedSlots || (currentParent.scopedSlots = {}))[name] = element;
        } else {
          currentParent.children.push(element);
          element.parent = currentParent;
        }
      }
      if (!unary) {
        currentParent = element;
        stack.push(element);
      } else {
        closeElement(element);
      }
    },

    end: function end () {
      // remove trailing whitespace
      var element = stack[stack.length - 1];
      var lastNode = element.children[element.children.length - 1];
      if (lastNode && lastNode.type === 3 && lastNode.text === ' ' && !inPre) {
        element.children.pop();
      }
      // pop stack
      stack.length -= 1;
      currentParent = stack[stack.length - 1];
      closeElement(element);
    },

    chars: function chars (text) {
      if (!currentParent) {
        if (true) {
          if (text === template) {
            warnOnce(
              'Component template requires a root element, rather than just text.'
            );
          } else if ((text = text.trim())) {
            warnOnce(
              ("text \"" + text + "\" outside root element will be ignored.")
            );
          }
        }
        return
      }
      // IE textarea placeholder bug
      /* istanbul ignore if */
      if (isIE &&
        currentParent.tag === 'textarea' &&
        currentParent.attrsMap.placeholder === text
      ) {
        return
      }
      var children = currentParent.children;
      text = inPre || text.trim()
        ? isTextTag(currentParent) ? text : decodeHTMLCached(text)
        // only preserve whitespace if its not right after a starting tag
        : preserveWhitespace && children.length ? ' ' : '';
      if (text) {
        var res;
        if (!inVPre && text !== ' ' && (res = parseText(text, delimiters))) {
          children.push({
            type: 2,
            expression: res.expression,
            tokens: res.tokens,
            text: text
          });
        } else if (text !== ' ' || !children.length || children[children.length - 1].text !== ' ') {
          children.push({
            type: 3,
            text: text
          });
        }
      }
    },
    comment: function comment (text) {
      currentParent.children.push({
        type: 3,
        text: text,
        isComment: true
      });
    }
  });
  return root
}

function processPre (el) {
  if (getAndRemoveAttr(el, 'v-pre') != null) {
    el.pre = true;
  }
}

function processRawAttrs (el) {
  var l = el.attrsList.length;
  if (l) {
    var attrs = el.attrs = new Array(l);
    for (var i = 0; i < l; i++) {
      attrs[i] = {
        name: el.attrsList[i].name,
        value: JSON.stringify(el.attrsList[i].value)
      };
    }
  } else if (!el.pre) {
    // non root node in pre blocks with no attributes
    el.plain = true;
  }
}

function processElement (element, options) {
  processKey(element);

  // determine whether this is a plain element after
  // removing structural attributes
  element.plain = !element.key && !element.attrsList.length;

  processRef(element);
  processSlot(element);
  processComponent(element);
  for (var i = 0; i < transforms.length; i++) {
    element = transforms[i](element, options) || element;
  }
  processAttrs(element);
}

function processKey (el) {
  var exp = getBindingAttr(el, 'key');
  if (exp) {
    if ("development" !== 'production' && el.tag === 'template') {
      warn$2("<template> cannot be keyed. Place the key on real elements instead.");
    }
    el.key = exp;
  }
}

function processRef (el) {
  var ref = getBindingAttr(el, 'ref');
  if (ref) {
    el.ref = ref;
    el.refInFor = checkInFor(el);
  }
}

function processFor (el) {
  var exp;
  if ((exp = getAndRemoveAttr(el, 'v-for'))) {
    var res = parseFor(exp);
    if (res) {
      extend(el, res);
    } else if (true) {
      warn$2(
        ("Invalid v-for expression: " + exp)
      );
    }
  }
}



function parseFor (exp) {
  var inMatch = exp.match(forAliasRE);
  if (!inMatch) { return }
  var res = {};
  res.for = inMatch[2].trim();
  var alias = inMatch[1].trim().replace(stripParensRE, '');
  var iteratorMatch = alias.match(forIteratorRE);
  if (iteratorMatch) {
    res.alias = alias.replace(forIteratorRE, '');
    res.iterator1 = iteratorMatch[1].trim();
    if (iteratorMatch[2]) {
      res.iterator2 = iteratorMatch[2].trim();
    }
  } else {
    res.alias = alias;
  }
  return res
}

function processIf (el) {
  var exp = getAndRemoveAttr(el, 'v-if');
  if (exp) {
    el.if = exp;
    addIfCondition(el, {
      exp: exp,
      block: el
    });
  } else {
    if (getAndRemoveAttr(el, 'v-else') != null) {
      el.else = true;
    }
    var elseif = getAndRemoveAttr(el, 'v-else-if');
    if (elseif) {
      el.elseif = elseif;
    }
  }
}

function processIfConditions (el, parent) {
  var prev = findPrevElement(parent.children);
  if (prev && prev.if) {
    addIfCondition(prev, {
      exp: el.elseif,
      block: el
    });
  } else if (true) {
    warn$2(
      "v-" + (el.elseif ? ('else-if="' + el.elseif + '"') : 'else') + " " +
      "used on element <" + (el.tag) + "> without corresponding v-if."
    );
  }
}

function findPrevElement (children) {
  var i = children.length;
  while (i--) {
    if (children[i].type === 1) {
      return children[i]
    } else {
      if ("development" !== 'production' && children[i].text !== ' ') {
        warn$2(
          "text \"" + (children[i].text.trim()) + "\" between v-if and v-else(-if) " +
          "will be ignored."
        );
      }
      children.pop();
    }
  }
}

function addIfCondition (el, condition) {
  if (!el.ifConditions) {
    el.ifConditions = [];
  }
  el.ifConditions.push(condition);
}

function processOnce (el) {
  var once$$1 = getAndRemoveAttr(el, 'v-once');
  if (once$$1 != null) {
    el.once = true;
  }
}

function processSlot (el) {
  if (el.tag === 'slot') {
    el.slotName = getBindingAttr(el, 'name');
    if ("development" !== 'production' && el.key) {
      warn$2(
        "`key` does not work on <slot> because slots are abstract outlets " +
        "and can possibly expand into multiple elements. " +
        "Use the key on a wrapping element instead."
      );
    }
  } else {
    var slotScope;
    if (el.tag === 'template') {
      slotScope = getAndRemoveAttr(el, 'scope');
      /* istanbul ignore if */
      if ("development" !== 'production' && slotScope) {
        warn$2(
          "the \"scope\" attribute for scoped slots have been deprecated and " +
          "replaced by \"slot-scope\" since 2.5. The new \"slot-scope\" attribute " +
          "can also be used on plain elements in addition to <template> to " +
          "denote scoped slots.",
          true
        );
      }
      el.slotScope = slotScope || getAndRemoveAttr(el, 'slot-scope');
    } else if ((slotScope = getAndRemoveAttr(el, 'slot-scope'))) {
      /* istanbul ignore if */
      if ("development" !== 'production' && el.attrsMap['v-for']) {
        warn$2(
          "Ambiguous combined usage of slot-scope and v-for on <" + (el.tag) + "> " +
          "(v-for takes higher priority). Use a wrapper <template> for the " +
          "scoped slot to make it clearer.",
          true
        );
      }
      el.slotScope = slotScope;
    }
    var slotTarget = getBindingAttr(el, 'slot');
    if (slotTarget) {
      el.slotTarget = slotTarget === '""' ? '"default"' : slotTarget;
      // preserve slot as an attribute for native shadow DOM compat
      // only for non-scoped slots.
      if (el.tag !== 'template' && !el.slotScope) {
        addAttr(el, 'slot', slotTarget);
      }
    }
  }
}

function processComponent (el) {
  var binding;
  if ((binding = getBindingAttr(el, 'is'))) {
    el.component = binding;
  }
  if (getAndRemoveAttr(el, 'inline-template') != null) {
    el.inlineTemplate = true;
  }
}

function processAttrs (el) {
  var list = el.attrsList;
  var i, l, name, rawName, value, modifiers, isProp;
  for (i = 0, l = list.length; i < l; i++) {
    name = rawName = list[i].name;
    value = list[i].value;
    if (dirRE.test(name)) {
      // mark element as dynamic
      el.hasBindings = true;
      // modifiers
      modifiers = parseModifiers(name);
      if (modifiers) {
        name = name.replace(modifierRE, '');
      }
      if (bindRE.test(name)) { // v-bind
        name = name.replace(bindRE, '');
        value = parseFilters(value);
        isProp = false;
        if (modifiers) {
          if (modifiers.prop) {
            isProp = true;
            name = camelize(name);
            if (name === 'innerHtml') { name = 'innerHTML'; }
          }
          if (modifiers.camel) {
            name = camelize(name);
          }
          if (modifiers.sync) {
            addHandler(
              el,
              ("update:" + (camelize(name))),
              genAssignmentCode(value, "$event")
            );
          }
        }
        if (isProp || (
          !el.component && platformMustUseProp(el.tag, el.attrsMap.type, name)
        )) {
          addProp(el, name, value);
        } else {
          addAttr(el, name, value);
        }
      } else if (onRE.test(name)) { // v-on
        name = name.replace(onRE, '');
        addHandler(el, name, value, modifiers, false, warn$2);
      } else { // normal directives
        name = name.replace(dirRE, '');
        // parse arg
        var argMatch = name.match(argRE);
        var arg = argMatch && argMatch[1];
        if (arg) {
          name = name.slice(0, -(arg.length + 1));
        }
        addDirective(el, name, rawName, value, arg, modifiers);
        if ("development" !== 'production' && name === 'model') {
          checkForAliasModel(el, value);
        }
      }
    } else {
      // literal attribute
      if (true) {
        var res = parseText(value, delimiters);
        if (res) {
          warn$2(
            name + "=\"" + value + "\": " +
            'Interpolation inside attributes has been removed. ' +
            'Use v-bind or the colon shorthand instead. For example, ' +
            'instead of <div id="{{ val }}">, use <div :id="val">.'
          );
        }
      }
      addAttr(el, name, JSON.stringify(value));
      // #6887 firefox doesn't update muted state if set via attribute
      // even immediately after element creation
      if (!el.component &&
          name === 'muted' &&
          platformMustUseProp(el.tag, el.attrsMap.type, name)) {
        addProp(el, name, 'true');
      }
    }
  }
}

function checkInFor (el) {
  var parent = el;
  while (parent) {
    if (parent.for !== undefined) {
      return true
    }
    parent = parent.parent;
  }
  return false
}

function parseModifiers (name) {
  var match = name.match(modifierRE);
  if (match) {
    var ret = {};
    match.forEach(function (m) { ret[m.slice(1)] = true; });
    return ret
  }
}

function makeAttrsMap (attrs) {
  var map = {};
  for (var i = 0, l = attrs.length; i < l; i++) {
    if (
      "development" !== 'production' &&
      map[attrs[i].name] && !isIE && !isEdge
    ) {
      warn$2('duplicate attribute: ' + attrs[i].name);
    }
    map[attrs[i].name] = attrs[i].value;
  }
  return map
}

// for script (e.g. type="x/template") or style, do not decode content
function isTextTag (el) {
  return el.tag === 'script' || el.tag === 'style'
}

function isForbiddenTag (el) {
  return (
    el.tag === 'style' ||
    (el.tag === 'script' && (
      !el.attrsMap.type ||
      el.attrsMap.type === 'text/javascript'
    ))
  )
}

var ieNSBug = /^xmlns:NS\d+/;
var ieNSPrefix = /^NS\d+:/;

/* istanbul ignore next */
function guardIESVGBug (attrs) {
  var res = [];
  for (var i = 0; i < attrs.length; i++) {
    var attr = attrs[i];
    if (!ieNSBug.test(attr.name)) {
      attr.name = attr.name.replace(ieNSPrefix, '');
      res.push(attr);
    }
  }
  return res
}

function checkForAliasModel (el, value) {
  var _el = el;
  while (_el) {
    if (_el.for && _el.alias === value) {
      warn$2(
        "<" + (el.tag) + " v-model=\"" + value + "\">: " +
        "You are binding v-model directly to a v-for iteration alias. " +
        "This will not be able to modify the v-for source array because " +
        "writing to the alias is like modifying a function local variable. " +
        "Consider using an array of objects and use v-model on an object property instead."
      );
    }
    _el = _el.parent;
  }
}

/*  */

/**
 * Expand input[v-model] with dyanmic type bindings into v-if-else chains
 * Turn this:
 *   <input v-model="data[type]" :type="type">
 * into this:
 *   <input v-if="type === 'checkbox'" type="checkbox" v-model="data[type]">
 *   <input v-else-if="type === 'radio'" type="radio" v-model="data[type]">
 *   <input v-else :type="type" v-model="data[type]">
 */

function preTransformNode (el, options) {
  if (el.tag === 'input') {
    var map = el.attrsMap;
    if (!map['v-model']) {
      return
    }

    var typeBinding;
    if (map[':type'] || map['v-bind:type']) {
      typeBinding = getBindingAttr(el, 'type');
    }
    if (!map.type && !typeBinding && map['v-bind']) {
      typeBinding = "(" + (map['v-bind']) + ").type";
    }

    if (typeBinding) {
      var ifCondition = getAndRemoveAttr(el, 'v-if', true);
      var ifConditionExtra = ifCondition ? ("&&(" + ifCondition + ")") : "";
      var hasElse = getAndRemoveAttr(el, 'v-else', true) != null;
      var elseIfCondition = getAndRemoveAttr(el, 'v-else-if', true);
      // 1. checkbox
      var branch0 = cloneASTElement(el);
      // process for on the main node
      processFor(branch0);
      addRawAttr(branch0, 'type', 'checkbox');
      processElement(branch0, options);
      branch0.processed = true; // prevent it from double-processed
      branch0.if = "(" + typeBinding + ")==='checkbox'" + ifConditionExtra;
      addIfCondition(branch0, {
        exp: branch0.if,
        block: branch0
      });
      // 2. add radio else-if condition
      var branch1 = cloneASTElement(el);
      getAndRemoveAttr(branch1, 'v-for', true);
      addRawAttr(branch1, 'type', 'radio');
      processElement(branch1, options);
      addIfCondition(branch0, {
        exp: "(" + typeBinding + ")==='radio'" + ifConditionExtra,
        block: branch1
      });
      // 3. other
      var branch2 = cloneASTElement(el);
      getAndRemoveAttr(branch2, 'v-for', true);
      addRawAttr(branch2, ':type', typeBinding);
      processElement(branch2, options);
      addIfCondition(branch0, {
        exp: ifCondition,
        block: branch2
      });

      if (hasElse) {
        branch0.else = true;
      } else if (elseIfCondition) {
        branch0.elseif = elseIfCondition;
      }

      return branch0
    }
  }
}

function cloneASTElement (el) {
  return createASTElement(el.tag, el.attrsList.slice(), el.parent)
}

var model$2 = {
  preTransformNode: preTransformNode
}

var modules$1 = [
  klass$1,
  style$1,
  model$2
]

/*  */

function text (el, dir) {
  if (dir.value) {
    addProp(el, 'textContent', ("_s(" + (dir.value) + ")"));
  }
}

/*  */

function html (el, dir) {
  if (dir.value) {
    addProp(el, 'innerHTML', ("_s(" + (dir.value) + ")"));
  }
}

var directives$1 = {
  model: model,
  text: text,
  html: html
}

/*  */

var baseOptions = {
  expectHTML: true,
  modules: modules$1,
  directives: directives$1,
  isPreTag: isPreTag,
  isUnaryTag: isUnaryTag,
  mustUseProp: mustUseProp,
  canBeLeftOpenTag: canBeLeftOpenTag,
  isReservedTag: isReservedTag,
  getTagNamespace: getTagNamespace,
  staticKeys: genStaticKeys(modules$1)
};

/*  */

var isStaticKey;
var isPlatformReservedTag;

var genStaticKeysCached = cached(genStaticKeys$1);

/**
 * Goal of the optimizer: walk the generated template AST tree
 * and detect sub-trees that are purely static, i.e. parts of
 * the DOM that never needs to change.
 *
 * Once we detect these sub-trees, we can:
 *
 * 1. Hoist them into constants, so that we no longer need to
 *    create fresh nodes for them on each re-render;
 * 2. Completely skip them in the patching process.
 */
function optimize (root, options) {
  if (!root) { return }
  isStaticKey = genStaticKeysCached(options.staticKeys || '');
  isPlatformReservedTag = options.isReservedTag || no;
  // first pass: mark all non-static nodes.
  markStatic$1(root);
  // second pass: mark static roots.
  markStaticRoots(root, false);
}

function genStaticKeys$1 (keys) {
  return makeMap(
    'type,tag,attrsList,attrsMap,plain,parent,children,attrs' +
    (keys ? ',' + keys : '')
  )
}

function markStatic$1 (node) {
  node.static = isStatic(node);
  if (node.type === 1) {
    // do not make component slot content static. this avoids
    // 1. components not able to mutate slot nodes
    // 2. static slot content fails for hot-reloading
    if (
      !isPlatformReservedTag(node.tag) &&
      node.tag !== 'slot' &&
      node.attrsMap['inline-template'] == null
    ) {
      return
    }
    for (var i = 0, l = node.children.length; i < l; i++) {
      var child = node.children[i];
      markStatic$1(child);
      if (!child.static) {
        node.static = false;
      }
    }
    if (node.ifConditions) {
      for (var i$1 = 1, l$1 = node.ifConditions.length; i$1 < l$1; i$1++) {
        var block = node.ifConditions[i$1].block;
        markStatic$1(block);
        if (!block.static) {
          node.static = false;
        }
      }
    }
  }
}

function markStaticRoots (node, isInFor) {
  if (node.type === 1) {
    if (node.static || node.once) {
      node.staticInFor = isInFor;
    }
    // For a node to qualify as a static root, it should have children that
    // are not just static text. Otherwise the cost of hoisting out will
    // outweigh the benefits and it's better off to just always render it fresh.
    if (node.static && node.children.length && !(
      node.children.length === 1 &&
      node.children[0].type === 3
    )) {
      node.staticRoot = true;
      return
    } else {
      node.staticRoot = false;
    }
    if (node.children) {
      for (var i = 0, l = node.children.length; i < l; i++) {
        markStaticRoots(node.children[i], isInFor || !!node.for);
      }
    }
    if (node.ifConditions) {
      for (var i$1 = 1, l$1 = node.ifConditions.length; i$1 < l$1; i$1++) {
        markStaticRoots(node.ifConditions[i$1].block, isInFor);
      }
    }
  }
}

function isStatic (node) {
  if (node.type === 2) { // expression
    return false
  }
  if (node.type === 3) { // text
    return true
  }
  return !!(node.pre || (
    !node.hasBindings && // no dynamic bindings
    !node.if && !node.for && // not v-if or v-for or v-else
    !isBuiltInTag(node.tag) && // not a built-in
    isPlatformReservedTag(node.tag) && // not a component
    !isDirectChildOfTemplateFor(node) &&
    Object.keys(node).every(isStaticKey)
  ))
}

function isDirectChildOfTemplateFor (node) {
  while (node.parent) {
    node = node.parent;
    if (node.tag !== 'template') {
      return false
    }
    if (node.for) {
      return true
    }
  }
  return false
}

/*  */

var fnExpRE = /^([\w$_]+|\([^)]*?\))\s*=>|^function\s*\(/;
var simplePathRE = /^[A-Za-z_$][\w$]*(?:\.[A-Za-z_$][\w$]*|\['[^']*?']|\["[^"]*?"]|\[\d+]|\[[A-Za-z_$][\w$]*])*$/;

// KeyboardEvent.keyCode aliases
var keyCodes = {
  esc: 27,
  tab: 9,
  enter: 13,
  space: 32,
  up: 38,
  left: 37,
  right: 39,
  down: 40,
  'delete': [8, 46]
};

// KeyboardEvent.key aliases
var keyNames = {
  esc: 'Escape',
  tab: 'Tab',
  enter: 'Enter',
  space: ' ',
  // #7806: IE11 uses key names without `Arrow` prefix for arrow keys.
  up: ['Up', 'ArrowUp'],
  left: ['Left', 'ArrowLeft'],
  right: ['Right', 'ArrowRight'],
  down: ['Down', 'ArrowDown'],
  'delete': ['Backspace', 'Delete']
};

// #4868: modifiers that prevent the execution of the listener
// need to explicitly return null so that we can determine whether to remove
// the listener for .once
var genGuard = function (condition) { return ("if(" + condition + ")return null;"); };

var modifierCode = {
  stop: '$event.stopPropagation();',
  prevent: '$event.preventDefault();',
  self: genGuard("$event.target !== $event.currentTarget"),
  ctrl: genGuard("!$event.ctrlKey"),
  shift: genGuard("!$event.shiftKey"),
  alt: genGuard("!$event.altKey"),
  meta: genGuard("!$event.metaKey"),
  left: genGuard("'button' in $event && $event.button !== 0"),
  middle: genGuard("'button' in $event && $event.button !== 1"),
  right: genGuard("'button' in $event && $event.button !== 2")
};

function genHandlers (
  events,
  isNative,
  warn
) {
  var res = isNative ? 'nativeOn:{' : 'on:{';
  for (var name in events) {
    res += "\"" + name + "\":" + (genHandler(name, events[name])) + ",";
  }
  return res.slice(0, -1) + '}'
}

function genHandler (
  name,
  handler
) {
  if (!handler) {
    return 'function(){}'
  }

  if (Array.isArray(handler)) {
    return ("[" + (handler.map(function (handler) { return genHandler(name, handler); }).join(',')) + "]")
  }

  var isMethodPath = simplePathRE.test(handler.value);
  var isFunctionExpression = fnExpRE.test(handler.value);

  if (!handler.modifiers) {
    if (isMethodPath || isFunctionExpression) {
      return handler.value
    }
    /* istanbul ignore if */
    return ("function($event){" + (handler.value) + "}") // inline statement
  } else {
    var code = '';
    var genModifierCode = '';
    var keys = [];
    for (var key in handler.modifiers) {
      if (modifierCode[key]) {
        genModifierCode += modifierCode[key];
        // left/right
        if (keyCodes[key]) {
          keys.push(key);
        }
      } else if (key === 'exact') {
        var modifiers = (handler.modifiers);
        genModifierCode += genGuard(
          ['ctrl', 'shift', 'alt', 'meta']
            .filter(function (keyModifier) { return !modifiers[keyModifier]; })
            .map(function (keyModifier) { return ("$event." + keyModifier + "Key"); })
            .join('||')
        );
      } else {
        keys.push(key);
      }
    }
    if (keys.length) {
      code += genKeyFilter(keys);
    }
    // Make sure modifiers like prevent and stop get executed after key filtering
    if (genModifierCode) {
      code += genModifierCode;
    }
    var handlerCode = isMethodPath
      ? ("return " + (handler.value) + "($event)")
      : isFunctionExpression
        ? ("return (" + (handler.value) + ")($event)")
        : handler.value;
    /* istanbul ignore if */
    return ("function($event){" + code + handlerCode + "}")
  }
}

function genKeyFilter (keys) {
  return ("if(!('button' in $event)&&" + (keys.map(genFilterCode).join('&&')) + ")return null;")
}

function genFilterCode (key) {
  var keyVal = parseInt(key, 10);
  if (keyVal) {
    return ("$event.keyCode!==" + keyVal)
  }
  var keyCode = keyCodes[key];
  var keyName = keyNames[key];
  return (
    "_k($event.keyCode," +
    (JSON.stringify(key)) + "," +
    (JSON.stringify(keyCode)) + "," +
    "$event.key," +
    "" + (JSON.stringify(keyName)) +
    ")"
  )
}

/*  */

function on (el, dir) {
  if ("development" !== 'production' && dir.modifiers) {
    warn("v-on without argument does not support modifiers.");
  }
  el.wrapListeners = function (code) { return ("_g(" + code + "," + (dir.value) + ")"); };
}

/*  */

function bind$1 (el, dir) {
  el.wrapData = function (code) {
    return ("_b(" + code + ",'" + (el.tag) + "'," + (dir.value) + "," + (dir.modifiers && dir.modifiers.prop ? 'true' : 'false') + (dir.modifiers && dir.modifiers.sync ? ',true' : '') + ")")
  };
}

/*  */

var baseDirectives = {
  on: on,
  bind: bind$1,
  cloak: noop
}

/*  */

var CodegenState = function CodegenState (options) {
  this.options = options;
  this.warn = options.warn || baseWarn;
  this.transforms = pluckModuleFunction(options.modules, 'transformCode');
  this.dataGenFns = pluckModuleFunction(options.modules, 'genData');
  this.directives = extend(extend({}, baseDirectives), options.directives);
  var isReservedTag = options.isReservedTag || no;
  this.maybeComponent = function (el) { return !isReservedTag(el.tag); };
  this.onceId = 0;
  this.staticRenderFns = [];
};



function generate (
  ast,
  options
) {
  var state = new CodegenState(options);
  var code = ast ? genElement(ast, state) : '_c("div")';
  return {
    render: ("with(this){return " + code + "}"),
    staticRenderFns: state.staticRenderFns
  }
}

function genElement (el, state) {
  if (el.staticRoot && !el.staticProcessed) {
    return genStatic(el, state)
  } else if (el.once && !el.onceProcessed) {
    return genOnce(el, state)
  } else if (el.for && !el.forProcessed) {
    return genFor(el, state)
  } else if (el.if && !el.ifProcessed) {
    return genIf(el, state)
  } else if (el.tag === 'template' && !el.slotTarget) {
    return genChildren(el, state) || 'void 0'
  } else if (el.tag === 'slot') {
    return genSlot(el, state)
  } else {
    // component or element
    var code;
    if (el.component) {
      code = genComponent(el.component, el, state);
    } else {
      var data = el.plain ? undefined : genData$2(el, state);

      var children = el.inlineTemplate ? null : genChildren(el, state, true);
      code = "_c('" + (el.tag) + "'" + (data ? ("," + data) : '') + (children ? ("," + children) : '') + ")";
    }
    // module transforms
    for (var i = 0; i < state.transforms.length; i++) {
      code = state.transforms[i](el, code);
    }
    return code
  }
}

// hoist static sub-trees out
function genStatic (el, state) {
  el.staticProcessed = true;
  state.staticRenderFns.push(("with(this){return " + (genElement(el, state)) + "}"));
  return ("_m(" + (state.staticRenderFns.length - 1) + (el.staticInFor ? ',true' : '') + ")")
}

// v-once
function genOnce (el, state) {
  el.onceProcessed = true;
  if (el.if && !el.ifProcessed) {
    return genIf(el, state)
  } else if (el.staticInFor) {
    var key = '';
    var parent = el.parent;
    while (parent) {
      if (parent.for) {
        key = parent.key;
        break
      }
      parent = parent.parent;
    }
    if (!key) {
      "development" !== 'production' && state.warn(
        "v-once can only be used inside v-for that is keyed. "
      );
      return genElement(el, state)
    }
    return ("_o(" + (genElement(el, state)) + "," + (state.onceId++) + "," + key + ")")
  } else {
    return genStatic(el, state)
  }
}

function genIf (
  el,
  state,
  altGen,
  altEmpty
) {
  el.ifProcessed = true; // avoid recursion
  return genIfConditions(el.ifConditions.slice(), state, altGen, altEmpty)
}

function genIfConditions (
  conditions,
  state,
  altGen,
  altEmpty
) {
  if (!conditions.length) {
    return altEmpty || '_e()'
  }

  var condition = conditions.shift();
  if (condition.exp) {
    return ("(" + (condition.exp) + ")?" + (genTernaryExp(condition.block)) + ":" + (genIfConditions(conditions, state, altGen, altEmpty)))
  } else {
    return ("" + (genTernaryExp(condition.block)))
  }

  // v-if with v-once should generate code like (a)?_m(0):_m(1)
  function genTernaryExp (el) {
    return altGen
      ? altGen(el, state)
      : el.once
        ? genOnce(el, state)
        : genElement(el, state)
  }
}

function genFor (
  el,
  state,
  altGen,
  altHelper
) {
  var exp = el.for;
  var alias = el.alias;
  var iterator1 = el.iterator1 ? ("," + (el.iterator1)) : '';
  var iterator2 = el.iterator2 ? ("," + (el.iterator2)) : '';

  if ("development" !== 'production' &&
    state.maybeComponent(el) &&
    el.tag !== 'slot' &&
    el.tag !== 'template' &&
    !el.key
  ) {
    state.warn(
      "<" + (el.tag) + " v-for=\"" + alias + " in " + exp + "\">: component lists rendered with " +
      "v-for should have explicit keys. " +
      "See https://vuejs.org/guide/list.html#key for more info.",
      true /* tip */
    );
  }

  el.forProcessed = true; // avoid recursion
  return (altHelper || '_l') + "((" + exp + ")," +
    "function(" + alias + iterator1 + iterator2 + "){" +
      "return " + ((altGen || genElement)(el, state)) +
    '})'
}

function genData$2 (el, state) {
  var data = '{';

  // directives first.
  // directives may mutate the el's other properties before they are generated.
  var dirs = genDirectives(el, state);
  if (dirs) { data += dirs + ','; }

  // key
  if (el.key) {
    data += "key:" + (el.key) + ",";
  }
  // ref
  if (el.ref) {
    data += "ref:" + (el.ref) + ",";
  }
  if (el.refInFor) {
    data += "refInFor:true,";
  }
  // pre
  if (el.pre) {
    data += "pre:true,";
  }
  // record original tag name for components using "is" attribute
  if (el.component) {
    data += "tag:\"" + (el.tag) + "\",";
  }
  // module data generation functions
  for (var i = 0; i < state.dataGenFns.length; i++) {
    data += state.dataGenFns[i](el);
  }
  // attributes
  if (el.attrs) {
    data += "attrs:{" + (genProps(el.attrs)) + "},";
  }
  // DOM props
  if (el.props) {
    data += "domProps:{" + (genProps(el.props)) + "},";
  }
  // event handlers
  if (el.events) {
    data += (genHandlers(el.events, false, state.warn)) + ",";
  }
  if (el.nativeEvents) {
    data += (genHandlers(el.nativeEvents, true, state.warn)) + ",";
  }
  // slot target
  // only for non-scoped slots
  if (el.slotTarget && !el.slotScope) {
    data += "slot:" + (el.slotTarget) + ",";
  }
  // scoped slots
  if (el.scopedSlots) {
    data += (genScopedSlots(el.scopedSlots, state)) + ",";
  }
  // component v-model
  if (el.model) {
    data += "model:{value:" + (el.model.value) + ",callback:" + (el.model.callback) + ",expression:" + (el.model.expression) + "},";
  }
  // inline-template
  if (el.inlineTemplate) {
    var inlineTemplate = genInlineTemplate(el, state);
    if (inlineTemplate) {
      data += inlineTemplate + ",";
    }
  }
  data = data.replace(/,$/, '') + '}';
  // v-bind data wrap
  if (el.wrapData) {
    data = el.wrapData(data);
  }
  // v-on data wrap
  if (el.wrapListeners) {
    data = el.wrapListeners(data);
  }
  return data
}

function genDirectives (el, state) {
  var dirs = el.directives;
  if (!dirs) { return }
  var res = 'directives:[';
  var hasRuntime = false;
  var i, l, dir, needRuntime;
  for (i = 0, l = dirs.length; i < l; i++) {
    dir = dirs[i];
    needRuntime = true;
    var gen = state.directives[dir.name];
    if (gen) {
      // compile-time directive that manipulates AST.
      // returns true if it also needs a runtime counterpart.
      needRuntime = !!gen(el, dir, state.warn);
    }
    if (needRuntime) {
      hasRuntime = true;
      res += "{name:\"" + (dir.name) + "\",rawName:\"" + (dir.rawName) + "\"" + (dir.value ? (",value:(" + (dir.value) + "),expression:" + (JSON.stringify(dir.value))) : '') + (dir.arg ? (",arg:\"" + (dir.arg) + "\"") : '') + (dir.modifiers ? (",modifiers:" + (JSON.stringify(dir.modifiers))) : '') + "},";
    }
  }
  if (hasRuntime) {
    return res.slice(0, -1) + ']'
  }
}

function genInlineTemplate (el, state) {
  var ast = el.children[0];
  if ("development" !== 'production' && (
    el.children.length !== 1 || ast.type !== 1
  )) {
    state.warn('Inline-template components must have exactly one child element.');
  }
  if (ast.type === 1) {
    var inlineRenderFns = generate(ast, state.options);
    return ("inlineTemplate:{render:function(){" + (inlineRenderFns.render) + "},staticRenderFns:[" + (inlineRenderFns.staticRenderFns.map(function (code) { return ("function(){" + code + "}"); }).join(',')) + "]}")
  }
}

function genScopedSlots (
  slots,
  state
) {
  return ("scopedSlots:_u([" + (Object.keys(slots).map(function (key) {
      return genScopedSlot(key, slots[key], state)
    }).join(',')) + "])")
}

function genScopedSlot (
  key,
  el,
  state
) {
  if (el.for && !el.forProcessed) {
    return genForScopedSlot(key, el, state)
  }
  var fn = "function(" + (String(el.slotScope)) + "){" +
    "return " + (el.tag === 'template'
      ? el.if
        ? ((el.if) + "?" + (genChildren(el, state) || 'undefined') + ":undefined")
        : genChildren(el, state) || 'undefined'
      : genElement(el, state)) + "}";
  return ("{key:" + key + ",fn:" + fn + "}")
}

function genForScopedSlot (
  key,
  el,
  state
) {
  var exp = el.for;
  var alias = el.alias;
  var iterator1 = el.iterator1 ? ("," + (el.iterator1)) : '';
  var iterator2 = el.iterator2 ? ("," + (el.iterator2)) : '';
  el.forProcessed = true; // avoid recursion
  return "_l((" + exp + ")," +
    "function(" + alias + iterator1 + iterator2 + "){" +
      "return " + (genScopedSlot(key, el, state)) +
    '})'
}

function genChildren (
  el,
  state,
  checkSkip,
  altGenElement,
  altGenNode
) {
  var children = el.children;
  if (children.length) {
    var el$1 = children[0];
    // optimize single v-for
    if (children.length === 1 &&
      el$1.for &&
      el$1.tag !== 'template' &&
      el$1.tag !== 'slot'
    ) {
      return (altGenElement || genElement)(el$1, state)
    }
    var normalizationType = checkSkip
      ? getNormalizationType(children, state.maybeComponent)
      : 0;
    var gen = altGenNode || genNode;
    return ("[" + (children.map(function (c) { return gen(c, state); }).join(',')) + "]" + (normalizationType ? ("," + normalizationType) : ''))
  }
}

// determine the normalization needed for the children array.
// 0: no normalization needed
// 1: simple normalization needed (possible 1-level deep nested array)
// 2: full normalization needed
function getNormalizationType (
  children,
  maybeComponent
) {
  var res = 0;
  for (var i = 0; i < children.length; i++) {
    var el = children[i];
    if (el.type !== 1) {
      continue
    }
    if (needsNormalization(el) ||
        (el.ifConditions && el.ifConditions.some(function (c) { return needsNormalization(c.block); }))) {
      res = 2;
      break
    }
    if (maybeComponent(el) ||
        (el.ifConditions && el.ifConditions.some(function (c) { return maybeComponent(c.block); }))) {
      res = 1;
    }
  }
  return res
}

function needsNormalization (el) {
  return el.for !== undefined || el.tag === 'template' || el.tag === 'slot'
}

function genNode (node, state) {
  if (node.type === 1) {
    return genElement(node, state)
  } if (node.type === 3 && node.isComment) {
    return genComment(node)
  } else {
    return genText(node)
  }
}

function genText (text) {
  return ("_v(" + (text.type === 2
    ? text.expression // no need for () because already wrapped in _s()
    : transformSpecialNewlines(JSON.stringify(text.text))) + ")")
}

function genComment (comment) {
  return ("_e(" + (JSON.stringify(comment.text)) + ")")
}

function genSlot (el, state) {
  var slotName = el.slotName || '"default"';
  var children = genChildren(el, state);
  var res = "_t(" + slotName + (children ? ("," + children) : '');
  var attrs = el.attrs && ("{" + (el.attrs.map(function (a) { return ((camelize(a.name)) + ":" + (a.value)); }).join(',')) + "}");
  var bind$$1 = el.attrsMap['v-bind'];
  if ((attrs || bind$$1) && !children) {
    res += ",null";
  }
  if (attrs) {
    res += "," + attrs;
  }
  if (bind$$1) {
    res += (attrs ? '' : ',null') + "," + bind$$1;
  }
  return res + ')'
}

// componentName is el.component, take it as argument to shun flow's pessimistic refinement
function genComponent (
  componentName,
  el,
  state
) {
  var children = el.inlineTemplate ? null : genChildren(el, state, true);
  return ("_c(" + componentName + "," + (genData$2(el, state)) + (children ? ("," + children) : '') + ")")
}

function genProps (props) {
  var res = '';
  for (var i = 0; i < props.length; i++) {
    var prop = props[i];
    /* istanbul ignore if */
    {
      res += "\"" + (prop.name) + "\":" + (transformSpecialNewlines(prop.value)) + ",";
    }
  }
  return res.slice(0, -1)
}

// #3895, #4268
function transformSpecialNewlines (text) {
  return text
    .replace(/\u2028/g, '\\u2028')
    .replace(/\u2029/g, '\\u2029')
}

/*  */

// these keywords should not appear inside expressions, but operators like
// typeof, instanceof and in are allowed
var prohibitedKeywordRE = new RegExp('\\b' + (
  'do,if,for,let,new,try,var,case,else,with,await,break,catch,class,const,' +
  'super,throw,while,yield,delete,export,import,return,switch,default,' +
  'extends,finally,continue,debugger,function,arguments'
).split(',').join('\\b|\\b') + '\\b');

// these unary operators should not be used as property/method names
var unaryOperatorsRE = new RegExp('\\b' + (
  'delete,typeof,void'
).split(',').join('\\s*\\([^\\)]*\\)|\\b') + '\\s*\\([^\\)]*\\)');

// strip strings in expressions
var stripStringRE = /'(?:[^'\\]|\\.)*'|"(?:[^"\\]|\\.)*"|`(?:[^`\\]|\\.)*\$\{|\}(?:[^`\\]|\\.)*`|`(?:[^`\\]|\\.)*`/g;

// detect problematic expressions in a template
function detectErrors (ast) {
  var errors = [];
  if (ast) {
    checkNode(ast, errors);
  }
  return errors
}

function checkNode (node, errors) {
  if (node.type === 1) {
    for (var name in node.attrsMap) {
      if (dirRE.test(name)) {
        var value = node.attrsMap[name];
        if (value) {
          if (name === 'v-for') {
            checkFor(node, ("v-for=\"" + value + "\""), errors);
          } else if (onRE.test(name)) {
            checkEvent(value, (name + "=\"" + value + "\""), errors);
          } else {
            checkExpression(value, (name + "=\"" + value + "\""), errors);
          }
        }
      }
    }
    if (node.children) {
      for (var i = 0; i < node.children.length; i++) {
        checkNode(node.children[i], errors);
      }
    }
  } else if (node.type === 2) {
    checkExpression(node.expression, node.text, errors);
  }
}

function checkEvent (exp, text, errors) {
  var stipped = exp.replace(stripStringRE, '');
  var keywordMatch = stipped.match(unaryOperatorsRE);
  if (keywordMatch && stipped.charAt(keywordMatch.index - 1) !== '$') {
    errors.push(
      "avoid using JavaScript unary operator as property name: " +
      "\"" + (keywordMatch[0]) + "\" in expression " + (text.trim())
    );
  }
  checkExpression(exp, text, errors);
}

function checkFor (node, text, errors) {
  checkExpression(node.for || '', text, errors);
  checkIdentifier(node.alias, 'v-for alias', text, errors);
  checkIdentifier(node.iterator1, 'v-for iterator', text, errors);
  checkIdentifier(node.iterator2, 'v-for iterator', text, errors);
}

function checkIdentifier (
  ident,
  type,
  text,
  errors
) {
  if (typeof ident === 'string') {
    try {
      new Function(("var " + ident + "=_"));
    } catch (e) {
      errors.push(("invalid " + type + " \"" + ident + "\" in expression: " + (text.trim())));
    }
  }
}

function checkExpression (exp, text, errors) {
  try {
    new Function(("return " + exp));
  } catch (e) {
    var keywordMatch = exp.replace(stripStringRE, '').match(prohibitedKeywordRE);
    if (keywordMatch) {
      errors.push(
        "avoid using JavaScript keyword as property name: " +
        "\"" + (keywordMatch[0]) + "\"\n  Raw expression: " + (text.trim())
      );
    } else {
      errors.push(
        "invalid expression: " + (e.message) + " in\n\n" +
        "    " + exp + "\n\n" +
        "  Raw expression: " + (text.trim()) + "\n"
      );
    }
  }
}

/*  */

function createFunction (code, errors) {
  try {
    return new Function(code)
  } catch (err) {
    errors.push({ err: err, code: code });
    return noop
  }
}

function createCompileToFunctionFn (compile) {
  var cache = Object.create(null);

  return function compileToFunctions (
    template,
    options,
    vm
  ) {
    options = extend({}, options);
    var warn$$1 = options.warn || warn;
    delete options.warn;

    /* istanbul ignore if */
    if (true) {
      // detect possible CSP restriction
      try {
        new Function('return 1');
      } catch (e) {
        if (e.toString().match(/unsafe-eval|CSP/)) {
          warn$$1(
            'It seems you are using the standalone build of Vue.js in an ' +
            'environment with Content Security Policy that prohibits unsafe-eval. ' +
            'The template compiler cannot work in this environment. Consider ' +
            'relaxing the policy to allow unsafe-eval or pre-compiling your ' +
            'templates into render functions.'
          );
        }
      }
    }

    // check cache
    var key = options.delimiters
      ? String(options.delimiters) + template
      : template;
    if (cache[key]) {
      return cache[key]
    }

    // compile
    var compiled = compile(template, options);

    // check compilation errors/tips
    if (true) {
      if (compiled.errors && compiled.errors.length) {
        warn$$1(
          "Error compiling template:\n\n" + template + "\n\n" +
          compiled.errors.map(function (e) { return ("- " + e); }).join('\n') + '\n',
          vm
        );
      }
      if (compiled.tips && compiled.tips.length) {
        compiled.tips.forEach(function (msg) { return tip(msg, vm); });
      }
    }

    // turn code into functions
    var res = {};
    var fnGenErrors = [];
    res.render = createFunction(compiled.render, fnGenErrors);
    res.staticRenderFns = compiled.staticRenderFns.map(function (code) {
      return createFunction(code, fnGenErrors)
    });

    // check function generation errors.
    // this should only happen if there is a bug in the compiler itself.
    // mostly for codegen development use
    /* istanbul ignore if */
    if (true) {
      if ((!compiled.errors || !compiled.errors.length) && fnGenErrors.length) {
        warn$$1(
          "Failed to generate render function:\n\n" +
          fnGenErrors.map(function (ref) {
            var err = ref.err;
            var code = ref.code;

            return ((err.toString()) + " in\n\n" + code + "\n");
        }).join('\n'),
          vm
        );
      }
    }

    return (cache[key] = res)
  }
}

/*  */

function createCompilerCreator (baseCompile) {
  return function createCompiler (baseOptions) {
    function compile (
      template,
      options
    ) {
      var finalOptions = Object.create(baseOptions);
      var errors = [];
      var tips = [];
      finalOptions.warn = function (msg, tip) {
        (tip ? tips : errors).push(msg);
      };

      if (options) {
        // merge custom modules
        if (options.modules) {
          finalOptions.modules =
            (baseOptions.modules || []).concat(options.modules);
        }
        // merge custom directives
        if (options.directives) {
          finalOptions.directives = extend(
            Object.create(baseOptions.directives || null),
            options.directives
          );
        }
        // copy other options
        for (var key in options) {
          if (key !== 'modules' && key !== 'directives') {
            finalOptions[key] = options[key];
          }
        }
      }

      var compiled = baseCompile(template, finalOptions);
      if (true) {
        errors.push.apply(errors, detectErrors(compiled.ast));
      }
      compiled.errors = errors;
      compiled.tips = tips;
      return compiled
    }

    return {
      compile: compile,
      compileToFunctions: createCompileToFunctionFn(compile)
    }
  }
}

/*  */

// `createCompilerCreator` allows creating compilers that use alternative
// parser/optimizer/codegen, e.g the SSR optimizing compiler.
// Here we just export a default compiler using the default parts.
var createCompiler = createCompilerCreator(function baseCompile (
  template,
  options
) {
  var ast = parse(template.trim(), options);
  if (options.optimize !== false) {
    optimize(ast, options);
  }
  var code = generate(ast, options);
  return {
    ast: ast,
    render: code.render,
    staticRenderFns: code.staticRenderFns
  }
});

/*  */

var ref$1 = createCompiler(baseOptions);
var compileToFunctions = ref$1.compileToFunctions;

/*  */

// check whether current browser encodes a char inside attribute values
var div;
function getShouldDecode (href) {
  div = div || document.createElement('div');
  div.innerHTML = href ? "<a href=\"\n\"/>" : "<div a=\"\n\"/>";
  return div.innerHTML.indexOf('&#10;') > 0
}

// #3663: IE encodes newlines inside attribute values while other browsers don't
var shouldDecodeNewlines = inBrowser ? getShouldDecode(false) : false;
// #6828: chrome encodes content in a[href]
var shouldDecodeNewlinesForHref = inBrowser ? getShouldDecode(true) : false;

/*  */

var idToTemplate = cached(function (id) {
  var el = query(id);
  return el && el.innerHTML
});

var mount = Vue.prototype.$mount;
Vue.prototype.$mount = function (
  el,
  hydrating
) {
  el = el && query(el);

  /* istanbul ignore if */
  if (el === document.body || el === document.documentElement) {
    "development" !== 'production' && warn(
      "Do not mount Vue to <html> or <body> - mount to normal elements instead."
    );
    return this
  }

  var options = this.$options;
  // resolve template/el and convert to render function
  if (!options.render) {
    var template = options.template;
    if (template) {
      if (typeof template === 'string') {
        if (template.charAt(0) === '#') {
          template = idToTemplate(template);
          /* istanbul ignore if */
          if ("development" !== 'production' && !template) {
            warn(
              ("Template element not found or is empty: " + (options.template)),
              this
            );
          }
        }
      } else if (template.nodeType) {
        template = template.innerHTML;
      } else {
        if (true) {
          warn('invalid template option:' + template, this);
        }
        return this
      }
    } else if (el) {
      template = getOuterHTML(el);
    }
    if (template) {
      /* istanbul ignore if */
      if ("development" !== 'production' && config.performance && mark) {
        mark('compile');
      }

      var ref = compileToFunctions(template, {
        shouldDecodeNewlines: shouldDecodeNewlines,
        shouldDecodeNewlinesForHref: shouldDecodeNewlinesForHref,
        delimiters: options.delimiters,
        comments: options.comments
      }, this);
      var render = ref.render;
      var staticRenderFns = ref.staticRenderFns;
      options.render = render;
      options.staticRenderFns = staticRenderFns;

      /* istanbul ignore if */
      if ("development" !== 'production' && config.performance && mark) {
        mark('compile end');
        measure(("vue " + (this._name) + " compile"), 'compile', 'compile end');
      }
    }
  }
  return mount.call(this, el, hydrating)
};

/**
 * Get outerHTML of elements, taking care
 * of SVG elements in IE as well.
 */
function getOuterHTML (el) {
  if (el.outerHTML) {
    return el.outerHTML
  } else {
    var container = document.createElement('div');
    container.appendChild(el.cloneNode(true));
    return container.innerHTML
  }
}

Vue.compile = compileToFunctions;

module.exports = Vue;

/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(12), __webpack_require__(90).setImmediate))

/***/ }),
/* 10 */,
/* 11 */
/***/ (function(module, exports) {

// https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
var global = module.exports = typeof window != 'undefined' && window.Math == Math
  ? window : typeof self != 'undefined' && self.Math == Math ? self
  // eslint-disable-next-line no-new-func
  : Function('return this')();
if (typeof __g == 'number') __g = global; // eslint-disable-line no-undef


/***/ }),
/* 12 */
/***/ (function(module, exports) {

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || Function("return this")() || (1,eval)("this");
} catch(e) {
	// This works if the window reference is available
	if(typeof window === "object")
		g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ }),
/* 13 */,
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

var store = __webpack_require__(294)('wks');
var uid = __webpack_require__(295);
var Symbol = __webpack_require__(11).Symbol;
var USE_SYMBOL = typeof Symbol == 'function';

var $exports = module.exports = function (name) {
  return store[name] || (store[name] =
    USE_SYMBOL && Symbol[name] || (USE_SYMBOL ? Symbol : uid)('Symbol.' + name));
};

$exports.store = store;


/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(583)
/* template */
var __vue_template__ = __webpack_require__(584)
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
Component.options.__file = "src/installer/components/Item.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0a1669fc", Component.options)
  } else {
    hotAPI.reload("data-v-0a1669fc", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 16 */,
/* 17 */,
/* 18 */,
/* 19 */,
/* 20 */,
/* 21 */,
/* 22 */,
/* 23 */,
/* 24 */,
/* 25 */
/***/ (function(module, exports) {

var core = module.exports = { version: '2.5.7' };
if (typeof __e == 'number') __e = core; // eslint-disable-line no-undef


/***/ }),
/* 26 */,
/* 27 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(process) {

var utils = __webpack_require__(4);
var normalizeHeaderName = __webpack_require__(75);

var DEFAULT_CONTENT_TYPE = {
  'Content-Type': 'application/x-www-form-urlencoded'
};

function setContentTypeIfUnset(headers, value) {
  if (!utils.isUndefined(headers) && utils.isUndefined(headers['Content-Type'])) {
    headers['Content-Type'] = value;
  }
}

function getDefaultAdapter() {
  var adapter;
  if (typeof XMLHttpRequest !== 'undefined') {
    // For browsers use XHR adapter
    adapter = __webpack_require__(40);
  } else if (typeof process !== 'undefined') {
    // For node use HTTP adapter
    adapter = __webpack_require__(40);
  }
  return adapter;
}

var defaults = {
  adapter: getDefaultAdapter(),

  transformRequest: [function transformRequest(data, headers) {
    normalizeHeaderName(headers, 'Content-Type');
    if (utils.isFormData(data) ||
      utils.isArrayBuffer(data) ||
      utils.isBuffer(data) ||
      utils.isStream(data) ||
      utils.isFile(data) ||
      utils.isBlob(data)
    ) {
      return data;
    }
    if (utils.isArrayBufferView(data)) {
      return data.buffer;
    }
    if (utils.isURLSearchParams(data)) {
      setContentTypeIfUnset(headers, 'application/x-www-form-urlencoded;charset=utf-8');
      return data.toString();
    }
    if (utils.isObject(data)) {
      setContentTypeIfUnset(headers, 'application/json;charset=utf-8');
      return JSON.stringify(data);
    }
    return data;
  }],

  transformResponse: [function transformResponse(data) {
    /*eslint no-param-reassign:0*/
    if (typeof data === 'string') {
      try {
        data = JSON.parse(data);
      } catch (e) { /* Ignore */ }
    }
    return data;
  }],

  /**
   * A timeout in milliseconds to abort a request. If set to 0 (default) a
   * timeout is not created.
   */
  timeout: 0,

  xsrfCookieName: 'XSRF-TOKEN',
  xsrfHeaderName: 'X-XSRF-TOKEN',

  maxContentLength: -1,

  validateStatus: function validateStatus(status) {
    return status >= 200 && status < 300;
  }
};

defaults.headers = {
  common: {
    'Accept': 'application/json, text/plain, */*'
  }
};

utils.forEach(['delete', 'get', 'head'], function forEachMethodNoData(method) {
  defaults.headers[method] = {};
});

utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
  defaults.headers[method] = utils.merge(DEFAULT_CONTENT_TYPE);
});

module.exports = defaults;

/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(28)))

/***/ }),
/* 28 */
/***/ (function(module, exports) {

// shim for using process in browser
var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
}
function defaultClearTimeout () {
    throw new Error('clearTimeout has not been defined');
}
(function () {
    try {
        if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
        } else {
            cachedSetTimeout = defaultSetTimout;
        }
    } catch (e) {
        cachedSetTimeout = defaultSetTimout;
    }
    try {
        if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
        } else {
            cachedClearTimeout = defaultClearTimeout;
        }
    } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
    }
} ())
function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
    } catch(e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
        } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
        }
    }


}
function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
    } catch (e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
        } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
        }
    }



}
var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
    if (!draining || !currentQueue) {
        return;
    }
    draining = false;
    if (currentQueue.length) {
        queue = currentQueue.concat(queue);
    } else {
        queueIndex = -1;
    }
    if (queue.length) {
        drainQueue();
    }
}

function drainQueue() {
    if (draining) {
        return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        while (++queueIndex < len) {
            if (currentQueue) {
                currentQueue[queueIndex].run();
            }
        }
        queueIndex = -1;
        len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
}

process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
        }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
    }
};

// v8 likes predictible objects
function Item(fun, array) {
    this.fun = fun;
    this.array = array;
}
Item.prototype.run = function () {
    this.fun.apply(null, this.array);
};
process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;
process.prependListener = noop;
process.prependOnceListener = noop;

process.listeners = function (name) { return [] }

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };


/***/ }),
/* 29 */,
/* 30 */,
/* 31 */,
/* 32 */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(54);
module.exports = function (it) {
  if (!isObject(it)) throw TypeError(it + ' is not an object!');
  return it;
};


/***/ }),
/* 33 */,
/* 34 */,
/* 35 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export Store */
/* unused harmony export install */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return mapState; });
/* unused harmony export mapMutations */
/* unused harmony export mapGetters */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return mapActions; });
/* unused harmony export createNamespacedHelpers */
/**
 * vuex v3.0.1
 * (c) 2017 Evan You
 * @license MIT
 */
var applyMixin = function (Vue) {
  var version = Number(Vue.version.split('.')[0]);

  if (version >= 2) {
    Vue.mixin({ beforeCreate: vuexInit });
  } else {
    // override init and inject vuex init procedure
    // for 1.x backwards compatibility.
    var _init = Vue.prototype._init;
    Vue.prototype._init = function (options) {
      if ( options === void 0 ) options = {};

      options.init = options.init
        ? [vuexInit].concat(options.init)
        : vuexInit;
      _init.call(this, options);
    };
  }

  /**
   * Vuex init hook, injected into each instances init hooks list.
   */

  function vuexInit () {
    var options = this.$options;
    // store injection
    if (options.store) {
      this.$store = typeof options.store === 'function'
        ? options.store()
        : options.store;
    } else if (options.parent && options.parent.$store) {
      this.$store = options.parent.$store;
    }
  }
};

var devtoolHook =
  typeof window !== 'undefined' &&
  window.__VUE_DEVTOOLS_GLOBAL_HOOK__;

function devtoolPlugin (store) {
  if (!devtoolHook) { return }

  store._devtoolHook = devtoolHook;

  devtoolHook.emit('vuex:init', store);

  devtoolHook.on('vuex:travel-to-state', function (targetState) {
    store.replaceState(targetState);
  });

  store.subscribe(function (mutation, state) {
    devtoolHook.emit('vuex:mutation', mutation, state);
  });
}

/**
 * Get the first item that pass the test
 * by second argument function
 *
 * @param {Array} list
 * @param {Function} f
 * @return {*}
 */
/**
 * Deep copy the given object considering circular structure.
 * This function caches all nested objects and its copies.
 * If it detects circular structure, use cached copy to avoid infinite loop.
 *
 * @param {*} obj
 * @param {Array<Object>} cache
 * @return {*}
 */


/**
 * forEach for object
 */
function forEachValue (obj, fn) {
  Object.keys(obj).forEach(function (key) { return fn(obj[key], key); });
}

function isObject (obj) {
  return obj !== null && typeof obj === 'object'
}

function isPromise (val) {
  return val && typeof val.then === 'function'
}

function assert (condition, msg) {
  if (!condition) { throw new Error(("[vuex] " + msg)) }
}

var Module = function Module (rawModule, runtime) {
  this.runtime = runtime;
  this._children = Object.create(null);
  this._rawModule = rawModule;
  var rawState = rawModule.state;
  this.state = (typeof rawState === 'function' ? rawState() : rawState) || {};
};

var prototypeAccessors$1 = { namespaced: { configurable: true } };

prototypeAccessors$1.namespaced.get = function () {
  return !!this._rawModule.namespaced
};

Module.prototype.addChild = function addChild (key, module) {
  this._children[key] = module;
};

Module.prototype.removeChild = function removeChild (key) {
  delete this._children[key];
};

Module.prototype.getChild = function getChild (key) {
  return this._children[key]
};

Module.prototype.update = function update (rawModule) {
  this._rawModule.namespaced = rawModule.namespaced;
  if (rawModule.actions) {
    this._rawModule.actions = rawModule.actions;
  }
  if (rawModule.mutations) {
    this._rawModule.mutations = rawModule.mutations;
  }
  if (rawModule.getters) {
    this._rawModule.getters = rawModule.getters;
  }
};

Module.prototype.forEachChild = function forEachChild (fn) {
  forEachValue(this._children, fn);
};

Module.prototype.forEachGetter = function forEachGetter (fn) {
  if (this._rawModule.getters) {
    forEachValue(this._rawModule.getters, fn);
  }
};

Module.prototype.forEachAction = function forEachAction (fn) {
  if (this._rawModule.actions) {
    forEachValue(this._rawModule.actions, fn);
  }
};

Module.prototype.forEachMutation = function forEachMutation (fn) {
  if (this._rawModule.mutations) {
    forEachValue(this._rawModule.mutations, fn);
  }
};

Object.defineProperties( Module.prototype, prototypeAccessors$1 );

var ModuleCollection = function ModuleCollection (rawRootModule) {
  // register root module (Vuex.Store options)
  this.register([], rawRootModule, false);
};

ModuleCollection.prototype.get = function get (path) {
  return path.reduce(function (module, key) {
    return module.getChild(key)
  }, this.root)
};

ModuleCollection.prototype.getNamespace = function getNamespace (path) {
  var module = this.root;
  return path.reduce(function (namespace, key) {
    module = module.getChild(key);
    return namespace + (module.namespaced ? key + '/' : '')
  }, '')
};

ModuleCollection.prototype.update = function update$1 (rawRootModule) {
  update([], this.root, rawRootModule);
};

ModuleCollection.prototype.register = function register (path, rawModule, runtime) {
    var this$1 = this;
    if ( runtime === void 0 ) runtime = true;

  if (true) {
    assertRawModule(path, rawModule);
  }

  var newModule = new Module(rawModule, runtime);
  if (path.length === 0) {
    this.root = newModule;
  } else {
    var parent = this.get(path.slice(0, -1));
    parent.addChild(path[path.length - 1], newModule);
  }

  // register nested modules
  if (rawModule.modules) {
    forEachValue(rawModule.modules, function (rawChildModule, key) {
      this$1.register(path.concat(key), rawChildModule, runtime);
    });
  }
};

ModuleCollection.prototype.unregister = function unregister (path) {
  var parent = this.get(path.slice(0, -1));
  var key = path[path.length - 1];
  if (!parent.getChild(key).runtime) { return }

  parent.removeChild(key);
};

function update (path, targetModule, newModule) {
  if (true) {
    assertRawModule(path, newModule);
  }

  // update target module
  targetModule.update(newModule);

  // update nested modules
  if (newModule.modules) {
    for (var key in newModule.modules) {
      if (!targetModule.getChild(key)) {
        if (true) {
          console.warn(
            "[vuex] trying to add a new module '" + key + "' on hot reloading, " +
            'manual reload is needed'
          );
        }
        return
      }
      update(
        path.concat(key),
        targetModule.getChild(key),
        newModule.modules[key]
      );
    }
  }
}

var functionAssert = {
  assert: function (value) { return typeof value === 'function'; },
  expected: 'function'
};

var objectAssert = {
  assert: function (value) { return typeof value === 'function' ||
    (typeof value === 'object' && typeof value.handler === 'function'); },
  expected: 'function or object with "handler" function'
};

var assertTypes = {
  getters: functionAssert,
  mutations: functionAssert,
  actions: objectAssert
};

function assertRawModule (path, rawModule) {
  Object.keys(assertTypes).forEach(function (key) {
    if (!rawModule[key]) { return }

    var assertOptions = assertTypes[key];

    forEachValue(rawModule[key], function (value, type) {
      assert(
        assertOptions.assert(value),
        makeAssertionMessage(path, key, type, value, assertOptions.expected)
      );
    });
  });
}

function makeAssertionMessage (path, key, type, value, expected) {
  var buf = key + " should be " + expected + " but \"" + key + "." + type + "\"";
  if (path.length > 0) {
    buf += " in module \"" + (path.join('.')) + "\"";
  }
  buf += " is " + (JSON.stringify(value)) + ".";
  return buf
}

var Vue; // bind on install

var Store = function Store (options) {
  var this$1 = this;
  if ( options === void 0 ) options = {};

  // Auto install if it is not done yet and `window` has `Vue`.
  // To allow users to avoid auto-installation in some cases,
  // this code should be placed here. See #731
  if (!Vue && typeof window !== 'undefined' && window.Vue) {
    install(window.Vue);
  }

  if (true) {
    assert(Vue, "must call Vue.use(Vuex) before creating a store instance.");
    assert(typeof Promise !== 'undefined', "vuex requires a Promise polyfill in this browser.");
    assert(this instanceof Store, "Store must be called with the new operator.");
  }

  var plugins = options.plugins; if ( plugins === void 0 ) plugins = [];
  var strict = options.strict; if ( strict === void 0 ) strict = false;

  var state = options.state; if ( state === void 0 ) state = {};
  if (typeof state === 'function') {
    state = state() || {};
  }

  // store internal state
  this._committing = false;
  this._actions = Object.create(null);
  this._actionSubscribers = [];
  this._mutations = Object.create(null);
  this._wrappedGetters = Object.create(null);
  this._modules = new ModuleCollection(options);
  this._modulesNamespaceMap = Object.create(null);
  this._subscribers = [];
  this._watcherVM = new Vue();

  // bind commit and dispatch to self
  var store = this;
  var ref = this;
  var dispatch = ref.dispatch;
  var commit = ref.commit;
  this.dispatch = function boundDispatch (type, payload) {
    return dispatch.call(store, type, payload)
  };
  this.commit = function boundCommit (type, payload, options) {
    return commit.call(store, type, payload, options)
  };

  // strict mode
  this.strict = strict;

  // init root module.
  // this also recursively registers all sub-modules
  // and collects all module getters inside this._wrappedGetters
  installModule(this, state, [], this._modules.root);

  // initialize the store vm, which is responsible for the reactivity
  // (also registers _wrappedGetters as computed properties)
  resetStoreVM(this, state);

  // apply plugins
  plugins.forEach(function (plugin) { return plugin(this$1); });

  if (Vue.config.devtools) {
    devtoolPlugin(this);
  }
};

var prototypeAccessors = { state: { configurable: true } };

prototypeAccessors.state.get = function () {
  return this._vm._data.$$state
};

prototypeAccessors.state.set = function (v) {
  if (true) {
    assert(false, "Use store.replaceState() to explicit replace store state.");
  }
};

Store.prototype.commit = function commit (_type, _payload, _options) {
    var this$1 = this;

  // check object-style commit
  var ref = unifyObjectStyle(_type, _payload, _options);
    var type = ref.type;
    var payload = ref.payload;
    var options = ref.options;

  var mutation = { type: type, payload: payload };
  var entry = this._mutations[type];
  if (!entry) {
    if (true) {
      console.error(("[vuex] unknown mutation type: " + type));
    }
    return
  }
  this._withCommit(function () {
    entry.forEach(function commitIterator (handler) {
      handler(payload);
    });
  });
  this._subscribers.forEach(function (sub) { return sub(mutation, this$1.state); });

  if (
    "development" !== 'production' &&
    options && options.silent
  ) {
    console.warn(
      "[vuex] mutation type: " + type + ". Silent option has been removed. " +
      'Use the filter functionality in the vue-devtools'
    );
  }
};

Store.prototype.dispatch = function dispatch (_type, _payload) {
    var this$1 = this;

  // check object-style dispatch
  var ref = unifyObjectStyle(_type, _payload);
    var type = ref.type;
    var payload = ref.payload;

  var action = { type: type, payload: payload };
  var entry = this._actions[type];
  if (!entry) {
    if (true) {
      console.error(("[vuex] unknown action type: " + type));
    }
    return
  }

  this._actionSubscribers.forEach(function (sub) { return sub(action, this$1.state); });

  return entry.length > 1
    ? Promise.all(entry.map(function (handler) { return handler(payload); }))
    : entry[0](payload)
};

Store.prototype.subscribe = function subscribe (fn) {
  return genericSubscribe(fn, this._subscribers)
};

Store.prototype.subscribeAction = function subscribeAction (fn) {
  return genericSubscribe(fn, this._actionSubscribers)
};

Store.prototype.watch = function watch (getter, cb, options) {
    var this$1 = this;

  if (true) {
    assert(typeof getter === 'function', "store.watch only accepts a function.");
  }
  return this._watcherVM.$watch(function () { return getter(this$1.state, this$1.getters); }, cb, options)
};

Store.prototype.replaceState = function replaceState (state) {
    var this$1 = this;

  this._withCommit(function () {
    this$1._vm._data.$$state = state;
  });
};

Store.prototype.registerModule = function registerModule (path, rawModule, options) {
    if ( options === void 0 ) options = {};

  if (typeof path === 'string') { path = [path]; }

  if (true) {
    assert(Array.isArray(path), "module path must be a string or an Array.");
    assert(path.length > 0, 'cannot register the root module by using registerModule.');
  }

  this._modules.register(path, rawModule);
  installModule(this, this.state, path, this._modules.get(path), options.preserveState);
  // reset store to update getters...
  resetStoreVM(this, this.state);
};

Store.prototype.unregisterModule = function unregisterModule (path) {
    var this$1 = this;

  if (typeof path === 'string') { path = [path]; }

  if (true) {
    assert(Array.isArray(path), "module path must be a string or an Array.");
  }

  this._modules.unregister(path);
  this._withCommit(function () {
    var parentState = getNestedState(this$1.state, path.slice(0, -1));
    Vue.delete(parentState, path[path.length - 1]);
  });
  resetStore(this);
};

Store.prototype.hotUpdate = function hotUpdate (newOptions) {
  this._modules.update(newOptions);
  resetStore(this, true);
};

Store.prototype._withCommit = function _withCommit (fn) {
  var committing = this._committing;
  this._committing = true;
  fn();
  this._committing = committing;
};

Object.defineProperties( Store.prototype, prototypeAccessors );

function genericSubscribe (fn, subs) {
  if (subs.indexOf(fn) < 0) {
    subs.push(fn);
  }
  return function () {
    var i = subs.indexOf(fn);
    if (i > -1) {
      subs.splice(i, 1);
    }
  }
}

function resetStore (store, hot) {
  store._actions = Object.create(null);
  store._mutations = Object.create(null);
  store._wrappedGetters = Object.create(null);
  store._modulesNamespaceMap = Object.create(null);
  var state = store.state;
  // init all modules
  installModule(store, state, [], store._modules.root, true);
  // reset vm
  resetStoreVM(store, state, hot);
}

function resetStoreVM (store, state, hot) {
  var oldVm = store._vm;

  // bind store public getters
  store.getters = {};
  var wrappedGetters = store._wrappedGetters;
  var computed = {};
  forEachValue(wrappedGetters, function (fn, key) {
    // use computed to leverage its lazy-caching mechanism
    computed[key] = function () { return fn(store); };
    Object.defineProperty(store.getters, key, {
      get: function () { return store._vm[key]; },
      enumerable: true // for local getters
    });
  });

  // use a Vue instance to store the state tree
  // suppress warnings just in case the user has added
  // some funky global mixins
  var silent = Vue.config.silent;
  Vue.config.silent = true;
  store._vm = new Vue({
    data: {
      $$state: state
    },
    computed: computed
  });
  Vue.config.silent = silent;

  // enable strict mode for new vm
  if (store.strict) {
    enableStrictMode(store);
  }

  if (oldVm) {
    if (hot) {
      // dispatch changes in all subscribed watchers
      // to force getter re-evaluation for hot reloading.
      store._withCommit(function () {
        oldVm._data.$$state = null;
      });
    }
    Vue.nextTick(function () { return oldVm.$destroy(); });
  }
}

function installModule (store, rootState, path, module, hot) {
  var isRoot = !path.length;
  var namespace = store._modules.getNamespace(path);

  // register in namespace map
  if (module.namespaced) {
    store._modulesNamespaceMap[namespace] = module;
  }

  // set state
  if (!isRoot && !hot) {
    var parentState = getNestedState(rootState, path.slice(0, -1));
    var moduleName = path[path.length - 1];
    store._withCommit(function () {
      Vue.set(parentState, moduleName, module.state);
    });
  }

  var local = module.context = makeLocalContext(store, namespace, path);

  module.forEachMutation(function (mutation, key) {
    var namespacedType = namespace + key;
    registerMutation(store, namespacedType, mutation, local);
  });

  module.forEachAction(function (action, key) {
    var type = action.root ? key : namespace + key;
    var handler = action.handler || action;
    registerAction(store, type, handler, local);
  });

  module.forEachGetter(function (getter, key) {
    var namespacedType = namespace + key;
    registerGetter(store, namespacedType, getter, local);
  });

  module.forEachChild(function (child, key) {
    installModule(store, rootState, path.concat(key), child, hot);
  });
}

/**
 * make localized dispatch, commit, getters and state
 * if there is no namespace, just use root ones
 */
function makeLocalContext (store, namespace, path) {
  var noNamespace = namespace === '';

  var local = {
    dispatch: noNamespace ? store.dispatch : function (_type, _payload, _options) {
      var args = unifyObjectStyle(_type, _payload, _options);
      var payload = args.payload;
      var options = args.options;
      var type = args.type;

      if (!options || !options.root) {
        type = namespace + type;
        if ("development" !== 'production' && !store._actions[type]) {
          console.error(("[vuex] unknown local action type: " + (args.type) + ", global type: " + type));
          return
        }
      }

      return store.dispatch(type, payload)
    },

    commit: noNamespace ? store.commit : function (_type, _payload, _options) {
      var args = unifyObjectStyle(_type, _payload, _options);
      var payload = args.payload;
      var options = args.options;
      var type = args.type;

      if (!options || !options.root) {
        type = namespace + type;
        if ("development" !== 'production' && !store._mutations[type]) {
          console.error(("[vuex] unknown local mutation type: " + (args.type) + ", global type: " + type));
          return
        }
      }

      store.commit(type, payload, options);
    }
  };

  // getters and state object must be gotten lazily
  // because they will be changed by vm update
  Object.defineProperties(local, {
    getters: {
      get: noNamespace
        ? function () { return store.getters; }
        : function () { return makeLocalGetters(store, namespace); }
    },
    state: {
      get: function () { return getNestedState(store.state, path); }
    }
  });

  return local
}

function makeLocalGetters (store, namespace) {
  var gettersProxy = {};

  var splitPos = namespace.length;
  Object.keys(store.getters).forEach(function (type) {
    // skip if the target getter is not match this namespace
    if (type.slice(0, splitPos) !== namespace) { return }

    // extract local getter type
    var localType = type.slice(splitPos);

    // Add a port to the getters proxy.
    // Define as getter property because
    // we do not want to evaluate the getters in this time.
    Object.defineProperty(gettersProxy, localType, {
      get: function () { return store.getters[type]; },
      enumerable: true
    });
  });

  return gettersProxy
}

function registerMutation (store, type, handler, local) {
  var entry = store._mutations[type] || (store._mutations[type] = []);
  entry.push(function wrappedMutationHandler (payload) {
    handler.call(store, local.state, payload);
  });
}

function registerAction (store, type, handler, local) {
  var entry = store._actions[type] || (store._actions[type] = []);
  entry.push(function wrappedActionHandler (payload, cb) {
    var res = handler.call(store, {
      dispatch: local.dispatch,
      commit: local.commit,
      getters: local.getters,
      state: local.state,
      rootGetters: store.getters,
      rootState: store.state
    }, payload, cb);
    if (!isPromise(res)) {
      res = Promise.resolve(res);
    }
    if (store._devtoolHook) {
      return res.catch(function (err) {
        store._devtoolHook.emit('vuex:error', err);
        throw err
      })
    } else {
      return res
    }
  });
}

function registerGetter (store, type, rawGetter, local) {
  if (store._wrappedGetters[type]) {
    if (true) {
      console.error(("[vuex] duplicate getter key: " + type));
    }
    return
  }
  store._wrappedGetters[type] = function wrappedGetter (store) {
    return rawGetter(
      local.state, // local state
      local.getters, // local getters
      store.state, // root state
      store.getters // root getters
    )
  };
}

function enableStrictMode (store) {
  store._vm.$watch(function () { return this._data.$$state }, function () {
    if (true) {
      assert(store._committing, "Do not mutate vuex store state outside mutation handlers.");
    }
  }, { deep: true, sync: true });
}

function getNestedState (state, path) {
  return path.length
    ? path.reduce(function (state, key) { return state[key]; }, state)
    : state
}

function unifyObjectStyle (type, payload, options) {
  if (isObject(type) && type.type) {
    options = payload;
    payload = type;
    type = type.type;
  }

  if (true) {
    assert(typeof type === 'string', ("Expects string as the type, but found " + (typeof type) + "."));
  }

  return { type: type, payload: payload, options: options }
}

function install (_Vue) {
  if (Vue && _Vue === Vue) {
    if (true) {
      console.error(
        '[vuex] already installed. Vue.use(Vuex) should be called only once.'
      );
    }
    return
  }
  Vue = _Vue;
  applyMixin(Vue);
}

var mapState = normalizeNamespace(function (namespace, states) {
  var res = {};
  normalizeMap(states).forEach(function (ref) {
    var key = ref.key;
    var val = ref.val;

    res[key] = function mappedState () {
      var state = this.$store.state;
      var getters = this.$store.getters;
      if (namespace) {
        var module = getModuleByNamespace(this.$store, 'mapState', namespace);
        if (!module) {
          return
        }
        state = module.context.state;
        getters = module.context.getters;
      }
      return typeof val === 'function'
        ? val.call(this, state, getters)
        : state[val]
    };
    // mark vuex getter for devtools
    res[key].vuex = true;
  });
  return res
});

var mapMutations = normalizeNamespace(function (namespace, mutations) {
  var res = {};
  normalizeMap(mutations).forEach(function (ref) {
    var key = ref.key;
    var val = ref.val;

    res[key] = function mappedMutation () {
      var args = [], len = arguments.length;
      while ( len-- ) args[ len ] = arguments[ len ];

      var commit = this.$store.commit;
      if (namespace) {
        var module = getModuleByNamespace(this.$store, 'mapMutations', namespace);
        if (!module) {
          return
        }
        commit = module.context.commit;
      }
      return typeof val === 'function'
        ? val.apply(this, [commit].concat(args))
        : commit.apply(this.$store, [val].concat(args))
    };
  });
  return res
});

var mapGetters = normalizeNamespace(function (namespace, getters) {
  var res = {};
  normalizeMap(getters).forEach(function (ref) {
    var key = ref.key;
    var val = ref.val;

    val = namespace + val;
    res[key] = function mappedGetter () {
      if (namespace && !getModuleByNamespace(this.$store, 'mapGetters', namespace)) {
        return
      }
      if ("development" !== 'production' && !(val in this.$store.getters)) {
        console.error(("[vuex] unknown getter: " + val));
        return
      }
      return this.$store.getters[val]
    };
    // mark vuex getter for devtools
    res[key].vuex = true;
  });
  return res
});

var mapActions = normalizeNamespace(function (namespace, actions) {
  var res = {};
  normalizeMap(actions).forEach(function (ref) {
    var key = ref.key;
    var val = ref.val;

    res[key] = function mappedAction () {
      var args = [], len = arguments.length;
      while ( len-- ) args[ len ] = arguments[ len ];

      var dispatch = this.$store.dispatch;
      if (namespace) {
        var module = getModuleByNamespace(this.$store, 'mapActions', namespace);
        if (!module) {
          return
        }
        dispatch = module.context.dispatch;
      }
      return typeof val === 'function'
        ? val.apply(this, [dispatch].concat(args))
        : dispatch.apply(this.$store, [val].concat(args))
    };
  });
  return res
});

var createNamespacedHelpers = function (namespace) { return ({
  mapState: mapState.bind(null, namespace),
  mapGetters: mapGetters.bind(null, namespace),
  mapMutations: mapMutations.bind(null, namespace),
  mapActions: mapActions.bind(null, namespace)
}); };

function normalizeMap (map) {
  return Array.isArray(map)
    ? map.map(function (key) { return ({ key: key, val: key }); })
    : Object.keys(map).map(function (key) { return ({ key: key, val: map[key] }); })
}

function normalizeNamespace (fn) {
  return function (namespace, map) {
    if (typeof namespace !== 'string') {
      map = namespace;
      namespace = '';
    } else if (namespace.charAt(namespace.length - 1) !== '/') {
      namespace += '/';
    }
    return fn(namespace, map)
  }
}

function getModuleByNamespace (store, helper, namespace) {
  var module = store._modulesNamespaceMap[namespace];
  if ("development" !== 'production' && !module) {
    console.error(("[vuex] module namespace not found in " + helper + "(): " + namespace));
  }
  return module
}

var index_esm = {
  Store: Store,
  install: install,
  version: '3.0.1',
  mapState: mapState,
  mapMutations: mapMutations,
  mapGetters: mapGetters,
  mapActions: mapActions,
  createNamespacedHelpers: createNamespacedHelpers
};


/* harmony default export */ __webpack_exports__["a"] = (index_esm);


/***/ }),
/* 36 */
/***/ (function(module, exports, __webpack_require__) {

var dP = __webpack_require__(67);
var createDesc = __webpack_require__(290);
module.exports = __webpack_require__(55) ? function (object, key, value) {
  return dP.f(object, key, createDesc(1, value));
} : function (object, key, value) {
  object[key] = value;
  return object;
};


/***/ }),
/* 37 */,
/* 38 */
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function(useSourceMap) {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		return this.map(function (item) {
			var content = cssWithMappingToString(item, useSourceMap);
			if(item[2]) {
				return "@media " + item[2] + "{" + content + "}";
			} else {
				return content;
			}
		}).join("");
	};

	// import a list of modules into the list
	list.i = function(modules, mediaQuery) {
		if(typeof modules === "string")
			modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for(var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if(typeof id === "number")
				alreadyImportedModules[id] = true;
		}
		for(i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if(mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if(mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};

function cssWithMappingToString(item, useSourceMap) {
	var content = item[1] || '';
	var cssMapping = item[3];
	if (!cssMapping) {
		return content;
	}

	if (useSourceMap && typeof btoa === 'function') {
		var sourceMapping = toComment(cssMapping);
		var sourceURLs = cssMapping.sources.map(function (source) {
			return '/*# sourceURL=' + cssMapping.sourceRoot + source + ' */'
		});

		return [content].concat(sourceURLs).concat([sourceMapping]).join('\n');
	}

	return [content].join('\n');
}

// Adapted from convert-source-map (MIT)
function toComment(sourceMap) {
	// eslint-disable-next-line no-undef
	var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap))));
	var data = 'sourceMappingURL=data:application/json;charset=utf-8;base64,' + base64;

	return '/*# ' + data + ' */';
}


/***/ }),
/* 39 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function bind(fn, thisArg) {
  return function wrap() {
    var args = new Array(arguments.length);
    for (var i = 0; i < args.length; i++) {
      args[i] = arguments[i];
    }
    return fn.apply(thisArg, args);
  };
};


/***/ }),
/* 40 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(4);
var settle = __webpack_require__(76);
var buildURL = __webpack_require__(78);
var parseHeaders = __webpack_require__(79);
var isURLSameOrigin = __webpack_require__(80);
var createError = __webpack_require__(41);
var btoa = (typeof window !== 'undefined' && window.btoa && window.btoa.bind(window)) || __webpack_require__(81);

module.exports = function xhrAdapter(config) {
  return new Promise(function dispatchXhrRequest(resolve, reject) {
    var requestData = config.data;
    var requestHeaders = config.headers;

    if (utils.isFormData(requestData)) {
      delete requestHeaders['Content-Type']; // Let the browser set it
    }

    var request = new XMLHttpRequest();
    var loadEvent = 'onreadystatechange';
    var xDomain = false;

    // For IE 8/9 CORS support
    // Only supports POST and GET calls and doesn't returns the response headers.
    // DON'T do this for testing b/c XMLHttpRequest is mocked, not XDomainRequest.
    if ("development" !== 'test' &&
        typeof window !== 'undefined' &&
        window.XDomainRequest && !('withCredentials' in request) &&
        !isURLSameOrigin(config.url)) {
      request = new window.XDomainRequest();
      loadEvent = 'onload';
      xDomain = true;
      request.onprogress = function handleProgress() {};
      request.ontimeout = function handleTimeout() {};
    }

    // HTTP basic authentication
    if (config.auth) {
      var username = config.auth.username || '';
      var password = config.auth.password || '';
      requestHeaders.Authorization = 'Basic ' + btoa(username + ':' + password);
    }

    request.open(config.method.toUpperCase(), buildURL(config.url, config.params, config.paramsSerializer), true);

    // Set the request timeout in MS
    request.timeout = config.timeout;

    // Listen for ready state
    request[loadEvent] = function handleLoad() {
      if (!request || (request.readyState !== 4 && !xDomain)) {
        return;
      }

      // The request errored out and we didn't get a response, this will be
      // handled by onerror instead
      // With one exception: request that using file: protocol, most browsers
      // will return status as 0 even though it's a successful request
      if (request.status === 0 && !(request.responseURL && request.responseURL.indexOf('file:') === 0)) {
        return;
      }

      // Prepare the response
      var responseHeaders = 'getAllResponseHeaders' in request ? parseHeaders(request.getAllResponseHeaders()) : null;
      var responseData = !config.responseType || config.responseType === 'text' ? request.responseText : request.response;
      var response = {
        data: responseData,
        // IE sends 1223 instead of 204 (https://github.com/axios/axios/issues/201)
        status: request.status === 1223 ? 204 : request.status,
        statusText: request.status === 1223 ? 'No Content' : request.statusText,
        headers: responseHeaders,
        config: config,
        request: request
      };

      settle(resolve, reject, response);

      // Clean up request
      request = null;
    };

    // Handle low level network errors
    request.onerror = function handleError() {
      // Real errors are hidden from us by the browser
      // onerror should only fire if it's a network error
      reject(createError('Network Error', config, null, request));

      // Clean up request
      request = null;
    };

    // Handle timeout
    request.ontimeout = function handleTimeout() {
      reject(createError('timeout of ' + config.timeout + 'ms exceeded', config, 'ECONNABORTED',
        request));

      // Clean up request
      request = null;
    };

    // Add xsrf header
    // This is only done if running in a standard browser environment.
    // Specifically not if we're in a web worker, or react-native.
    if (utils.isStandardBrowserEnv()) {
      var cookies = __webpack_require__(82);

      // Add xsrf header
      var xsrfValue = (config.withCredentials || isURLSameOrigin(config.url)) && config.xsrfCookieName ?
          cookies.read(config.xsrfCookieName) :
          undefined;

      if (xsrfValue) {
        requestHeaders[config.xsrfHeaderName] = xsrfValue;
      }
    }

    // Add headers to the request
    if ('setRequestHeader' in request) {
      utils.forEach(requestHeaders, function setRequestHeader(val, key) {
        if (typeof requestData === 'undefined' && key.toLowerCase() === 'content-type') {
          // Remove Content-Type if data is undefined
          delete requestHeaders[key];
        } else {
          // Otherwise add header to the request
          request.setRequestHeader(key, val);
        }
      });
    }

    // Add withCredentials to request if needed
    if (config.withCredentials) {
      request.withCredentials = true;
    }

    // Add responseType to request if needed
    if (config.responseType) {
      try {
        request.responseType = config.responseType;
      } catch (e) {
        // Expected DOMException thrown by browsers not compatible XMLHttpRequest Level 2.
        // But, this can be suppressed for 'json' type as it can be parsed by default 'transformResponse' function.
        if (config.responseType !== 'json') {
          throw e;
        }
      }
    }

    // Handle progress if needed
    if (typeof config.onDownloadProgress === 'function') {
      request.addEventListener('progress', config.onDownloadProgress);
    }

    // Not all browsers support upload events
    if (typeof config.onUploadProgress === 'function' && request.upload) {
      request.upload.addEventListener('progress', config.onUploadProgress);
    }

    if (config.cancelToken) {
      // Handle cancellation
      config.cancelToken.promise.then(function onCanceled(cancel) {
        if (!request) {
          return;
        }

        request.abort();
        reject(cancel);
        // Clean up request
        request = null;
      });
    }

    if (requestData === undefined) {
      requestData = null;
    }

    // Send the request
    request.send(requestData);
  });
};


/***/ }),
/* 41 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var enhanceError = __webpack_require__(77);

/**
 * Create an Error with the specified message, config, error code, request and response.
 *
 * @param {string} message The error message.
 * @param {Object} config The config.
 * @param {string} [code] The error code (for example, 'ECONNABORTED').
 * @param {Object} [request] The request.
 * @param {Object} [response] The response.
 * @returns {Error} The created error.
 */
module.exports = function createError(message, config, code, request, response) {
  var error = new Error(message);
  return enhanceError(error, config, code, request, response);
};


/***/ }),
/* 42 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function isCancel(value) {
  return !!(value && value.__CANCEL__);
};


/***/ }),
/* 43 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * A `Cancel` is an object that is thrown when an operation is canceled.
 *
 * @class
 * @param {string=} message The message.
 */
function Cancel(message) {
  this.message = message;
}

Cancel.prototype.toString = function toString() {
  return 'Cancel' + (this.message ? ': ' + this.message : '');
};

Cancel.prototype.__CANCEL__ = true;

module.exports = Cancel;


/***/ }),
/* 44 */,
/* 45 */,
/* 46 */,
/* 47 */,
/* 48 */,
/* 49 */,
/* 50 */,
/* 51 */,
/* 52 */,
/* 53 */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(11);
var core = __webpack_require__(25);
var ctx = __webpack_require__(65);
var hide = __webpack_require__(36);
var has = __webpack_require__(68);
var PROTOTYPE = 'prototype';

var $export = function (type, name, source) {
  var IS_FORCED = type & $export.F;
  var IS_GLOBAL = type & $export.G;
  var IS_STATIC = type & $export.S;
  var IS_PROTO = type & $export.P;
  var IS_BIND = type & $export.B;
  var IS_WRAP = type & $export.W;
  var exports = IS_GLOBAL ? core : core[name] || (core[name] = {});
  var expProto = exports[PROTOTYPE];
  var target = IS_GLOBAL ? global : IS_STATIC ? global[name] : (global[name] || {})[PROTOTYPE];
  var key, own, out;
  if (IS_GLOBAL) source = name;
  for (key in source) {
    // contains in native
    own = !IS_FORCED && target && target[key] !== undefined;
    if (own && has(exports, key)) continue;
    // export native or passed
    out = own ? target[key] : source[key];
    // prevent global pollution for namespaces
    exports[key] = IS_GLOBAL && typeof target[key] != 'function' ? source[key]
    // bind timers to global for call from export context
    : IS_BIND && own ? ctx(out, global)
    // wrap global constructors for prevent change them in library
    : IS_WRAP && target[key] == out ? (function (C) {
      var F = function (a, b, c) {
        if (this instanceof C) {
          switch (arguments.length) {
            case 0: return new C();
            case 1: return new C(a);
            case 2: return new C(a, b);
          } return new C(a, b, c);
        } return C.apply(this, arguments);
      };
      F[PROTOTYPE] = C[PROTOTYPE];
      return F;
    // make static versions for prototype methods
    })(out) : IS_PROTO && typeof out == 'function' ? ctx(Function.call, out) : out;
    // export proto methods to core.%CONSTRUCTOR%.methods.%NAME%
    if (IS_PROTO) {
      (exports.virtual || (exports.virtual = {}))[key] = out;
      // export proto methods to core.%CONSTRUCTOR%.prototype.%NAME%
      if (type & $export.R && expProto && !expProto[key]) hide(expProto, key, out);
    }
  }
};
// type bitmap
$export.F = 1;   // forced
$export.G = 2;   // global
$export.S = 4;   // static
$export.P = 8;   // proto
$export.B = 16;  // bind
$export.W = 32;  // wrap
$export.U = 64;  // safe
$export.R = 128; // real proto method for `library`
module.exports = $export;


/***/ }),
/* 54 */
/***/ (function(module, exports) {

module.exports = function (it) {
  return typeof it === 'object' ? it !== null : typeof it === 'function';
};


/***/ }),
/* 55 */
/***/ (function(module, exports, __webpack_require__) {

// Thank's IE8 for his funny defineProperty
module.exports = !__webpack_require__(108)(function () {
  return Object.defineProperty({}, 'a', { get: function () { return 7; } }).a != 7;
});


/***/ }),
/* 56 */
/***/ (function(module, exports) {

module.exports = {};


/***/ }),
/* 57 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


exports.__esModule = true;

var _assign = __webpack_require__(289);

var _assign2 = _interopRequireDefault(_assign);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = _assign2.default || function (target) {
  for (var i = 1; i < arguments.length; i++) {
    var source = arguments[i];

    for (var key in source) {
      if (Object.prototype.hasOwnProperty.call(source, key)) {
        target[key] = source[key];
      }
    }
  }

  return target;
};

/***/ }),
/* 58 */,
/* 59 */,
/* 60 */,
/* 61 */,
/* 62 */,
/* 63 */,
/* 64 */,
/* 65 */
/***/ (function(module, exports, __webpack_require__) {

// optional / simple context binding
var aFunction = __webpack_require__(66);
module.exports = function (fn, that, length) {
  aFunction(fn);
  if (that === undefined) return fn;
  switch (length) {
    case 1: return function (a) {
      return fn.call(that, a);
    };
    case 2: return function (a, b) {
      return fn.call(that, a, b);
    };
    case 3: return function (a, b, c) {
      return fn.call(that, a, b, c);
    };
  }
  return function (/* ...args */) {
    return fn.apply(that, arguments);
  };
};


/***/ }),
/* 66 */
/***/ (function(module, exports) {

module.exports = function (it) {
  if (typeof it != 'function') throw TypeError(it + ' is not a function!');
  return it;
};


/***/ }),
/* 67 */
/***/ (function(module, exports, __webpack_require__) {

var anObject = __webpack_require__(32);
var IE8_DOM_DEFINE = __webpack_require__(526);
var toPrimitive = __webpack_require__(527);
var dP = Object.defineProperty;

exports.f = __webpack_require__(55) ? Object.defineProperty : function defineProperty(O, P, Attributes) {
  anObject(O);
  P = toPrimitive(P, true);
  anObject(Attributes);
  if (IE8_DOM_DEFINE) try {
    return dP(O, P, Attributes);
  } catch (e) { /* empty */ }
  if ('get' in Attributes || 'set' in Attributes) throw TypeError('Accessors not supported!');
  if ('value' in Attributes) O[P] = Attributes.value;
  return O;
};


/***/ }),
/* 68 */
/***/ (function(module, exports) {

var hasOwnProperty = {}.hasOwnProperty;
module.exports = function (it, key) {
  return hasOwnProperty.call(it, key);
};


/***/ }),
/* 69 */
/***/ (function(module, exports) {

var toString = {}.toString;

module.exports = function (it) {
  return toString.call(it).slice(8, -1);
};


/***/ }),
/* 70 */
/***/ (function(module, exports, __webpack_require__) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/

var stylesInDom = {};

var	memoize = function (fn) {
	var memo;

	return function () {
		if (typeof memo === "undefined") memo = fn.apply(this, arguments);
		return memo;
	};
};

var isOldIE = memoize(function () {
	// Test for IE <= 9 as proposed by Browserhacks
	// @see http://browserhacks.com/#hack-e71d8692f65334173fee715c222cb805
	// Tests for existence of standard globals is to allow style-loader
	// to operate correctly into non-standard environments
	// @see https://github.com/webpack-contrib/style-loader/issues/177
	return window && document && document.all && !window.atob;
});

var getElement = (function (fn) {
	var memo = {};

	return function(selector) {
		if (typeof memo[selector] === "undefined") {
			memo[selector] = fn.call(this, selector);
		}

		return memo[selector]
	};
})(function (target) {
	return document.querySelector(target)
});

var singleton = null;
var	singletonCounter = 0;
var	stylesInsertedAtTop = [];

var	fixUrls = __webpack_require__(105);

module.exports = function(list, options) {
	if (typeof DEBUG !== "undefined" && DEBUG) {
		if (typeof document !== "object") throw new Error("The style-loader cannot be used in a non-browser environment");
	}

	options = options || {};

	options.attrs = typeof options.attrs === "object" ? options.attrs : {};

	// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
	// tags it will allow on a page
	if (!options.singleton) options.singleton = isOldIE();

	// By default, add <style> tags to the <head> element
	if (!options.insertInto) options.insertInto = "head";

	// By default, add <style> tags to the bottom of the target
	if (!options.insertAt) options.insertAt = "bottom";

	var styles = listToStyles(list, options);

	addStylesToDom(styles, options);

	return function update (newList) {
		var mayRemove = [];

		for (var i = 0; i < styles.length; i++) {
			var item = styles[i];
			var domStyle = stylesInDom[item.id];

			domStyle.refs--;
			mayRemove.push(domStyle);
		}

		if(newList) {
			var newStyles = listToStyles(newList, options);
			addStylesToDom(newStyles, options);
		}

		for (var i = 0; i < mayRemove.length; i++) {
			var domStyle = mayRemove[i];

			if(domStyle.refs === 0) {
				for (var j = 0; j < domStyle.parts.length; j++) domStyle.parts[j]();

				delete stylesInDom[domStyle.id];
			}
		}
	};
};

function addStylesToDom (styles, options) {
	for (var i = 0; i < styles.length; i++) {
		var item = styles[i];
		var domStyle = stylesInDom[item.id];

		if(domStyle) {
			domStyle.refs++;

			for(var j = 0; j < domStyle.parts.length; j++) {
				domStyle.parts[j](item.parts[j]);
			}

			for(; j < item.parts.length; j++) {
				domStyle.parts.push(addStyle(item.parts[j], options));
			}
		} else {
			var parts = [];

			for(var j = 0; j < item.parts.length; j++) {
				parts.push(addStyle(item.parts[j], options));
			}

			stylesInDom[item.id] = {id: item.id, refs: 1, parts: parts};
		}
	}
}

function listToStyles (list, options) {
	var styles = [];
	var newStyles = {};

	for (var i = 0; i < list.length; i++) {
		var item = list[i];
		var id = options.base ? item[0] + options.base : item[0];
		var css = item[1];
		var media = item[2];
		var sourceMap = item[3];
		var part = {css: css, media: media, sourceMap: sourceMap};

		if(!newStyles[id]) styles.push(newStyles[id] = {id: id, parts: [part]});
		else newStyles[id].parts.push(part);
	}

	return styles;
}

function insertStyleElement (options, style) {
	var target = getElement(options.insertInto)

	if (!target) {
		throw new Error("Couldn't find a style target. This probably means that the value for the 'insertInto' parameter is invalid.");
	}

	var lastStyleElementInsertedAtTop = stylesInsertedAtTop[stylesInsertedAtTop.length - 1];

	if (options.insertAt === "top") {
		if (!lastStyleElementInsertedAtTop) {
			target.insertBefore(style, target.firstChild);
		} else if (lastStyleElementInsertedAtTop.nextSibling) {
			target.insertBefore(style, lastStyleElementInsertedAtTop.nextSibling);
		} else {
			target.appendChild(style);
		}
		stylesInsertedAtTop.push(style);
	} else if (options.insertAt === "bottom") {
		target.appendChild(style);
	} else {
		throw new Error("Invalid value for parameter 'insertAt'. Must be 'top' or 'bottom'.");
	}
}

function removeStyleElement (style) {
	if (style.parentNode === null) return false;
	style.parentNode.removeChild(style);

	var idx = stylesInsertedAtTop.indexOf(style);
	if(idx >= 0) {
		stylesInsertedAtTop.splice(idx, 1);
	}
}

function createStyleElement (options) {
	var style = document.createElement("style");

	options.attrs.type = "text/css";

	addAttrs(style, options.attrs);
	insertStyleElement(options, style);

	return style;
}

function createLinkElement (options) {
	var link = document.createElement("link");

	options.attrs.type = "text/css";
	options.attrs.rel = "stylesheet";

	addAttrs(link, options.attrs);
	insertStyleElement(options, link);

	return link;
}

function addAttrs (el, attrs) {
	Object.keys(attrs).forEach(function (key) {
		el.setAttribute(key, attrs[key]);
	});
}

function addStyle (obj, options) {
	var style, update, remove, result;

	// If a transform function was defined, run it on the css
	if (options.transform && obj.css) {
	    result = options.transform(obj.css);

	    if (result) {
	    	// If transform returns a value, use that instead of the original css.
	    	// This allows running runtime transformations on the css.
	    	obj.css = result;
	    } else {
	    	// If the transform function returns a falsy value, don't add this css.
	    	// This allows conditional loading of css
	    	return function() {
	    		// noop
	    	};
	    }
	}

	if (options.singleton) {
		var styleIndex = singletonCounter++;

		style = singleton || (singleton = createStyleElement(options));

		update = applyToSingletonTag.bind(null, style, styleIndex, false);
		remove = applyToSingletonTag.bind(null, style, styleIndex, true);

	} else if (
		obj.sourceMap &&
		typeof URL === "function" &&
		typeof URL.createObjectURL === "function" &&
		typeof URL.revokeObjectURL === "function" &&
		typeof Blob === "function" &&
		typeof btoa === "function"
	) {
		style = createLinkElement(options);
		update = updateLink.bind(null, style, options);
		remove = function () {
			removeStyleElement(style);

			if(style.href) URL.revokeObjectURL(style.href);
		};
	} else {
		style = createStyleElement(options);
		update = applyToTag.bind(null, style);
		remove = function () {
			removeStyleElement(style);
		};
	}

	update(obj);

	return function updateStyle (newObj) {
		if (newObj) {
			if (
				newObj.css === obj.css &&
				newObj.media === obj.media &&
				newObj.sourceMap === obj.sourceMap
			) {
				return;
			}

			update(obj = newObj);
		} else {
			remove();
		}
	};
}

var replaceText = (function () {
	var textStore = [];

	return function (index, replacement) {
		textStore[index] = replacement;

		return textStore.filter(Boolean).join('\n');
	};
})();

function applyToSingletonTag (style, index, remove, obj) {
	var css = remove ? "" : obj.css;

	if (style.styleSheet) {
		style.styleSheet.cssText = replaceText(index, css);
	} else {
		var cssNode = document.createTextNode(css);
		var childNodes = style.childNodes;

		if (childNodes[index]) style.removeChild(childNodes[index]);

		if (childNodes.length) {
			style.insertBefore(cssNode, childNodes[index]);
		} else {
			style.appendChild(cssNode);
		}
	}
}

function applyToTag (style, obj) {
	var css = obj.css;
	var media = obj.media;

	if(media) {
		style.setAttribute("media", media)
	}

	if(style.styleSheet) {
		style.styleSheet.cssText = css;
	} else {
		while(style.firstChild) {
			style.removeChild(style.firstChild);
		}

		style.appendChild(document.createTextNode(css));
	}
}

function updateLink (link, options, obj) {
	var css = obj.css;
	var sourceMap = obj.sourceMap;

	/*
		If convertToAbsoluteUrls isn't defined, but sourcemaps are enabled
		and there is no publicPath defined then lets turn convertToAbsoluteUrls
		on by default.  Otherwise default to the convertToAbsoluteUrls option
		directly
	*/
	var autoFixUrls = options.convertToAbsoluteUrls === undefined && sourceMap;

	if (options.convertToAbsoluteUrls || autoFixUrls) {
		css = fixUrls(css);
	}

	if (sourceMap) {
		// http://stackoverflow.com/a/26603875
		css += "\n/*# sourceMappingURL=data:application/json;base64," + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + " */";
	}

	var blob = new Blob([css], { type: "text/css" });

	var oldSrc = link.href;

	link.href = URL.createObjectURL(blob);

	if(oldSrc) URL.revokeObjectURL(oldSrc);
}


/***/ }),
/* 71 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(72);

/***/ }),
/* 72 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(4);
var bind = __webpack_require__(39);
var Axios = __webpack_require__(74);
var defaults = __webpack_require__(27);

/**
 * Create an instance of Axios
 *
 * @param {Object} defaultConfig The default config for the instance
 * @return {Axios} A new instance of Axios
 */
function createInstance(defaultConfig) {
  var context = new Axios(defaultConfig);
  var instance = bind(Axios.prototype.request, context);

  // Copy axios.prototype to instance
  utils.extend(instance, Axios.prototype, context);

  // Copy context to instance
  utils.extend(instance, context);

  return instance;
}

// Create the default instance to be exported
var axios = createInstance(defaults);

// Expose Axios class to allow class inheritance
axios.Axios = Axios;

// Factory for creating new instances
axios.create = function create(instanceConfig) {
  return createInstance(utils.merge(defaults, instanceConfig));
};

// Expose Cancel & CancelToken
axios.Cancel = __webpack_require__(43);
axios.CancelToken = __webpack_require__(88);
axios.isCancel = __webpack_require__(42);

// Expose all/spread
axios.all = function all(promises) {
  return Promise.all(promises);
};
axios.spread = __webpack_require__(89);

module.exports = axios;

// Allow use of default import syntax in TypeScript
module.exports.default = axios;


/***/ }),
/* 73 */
/***/ (function(module, exports) {

/*!
 * Determine if an object is a Buffer
 *
 * @author   Feross Aboukhadijeh <https://feross.org>
 * @license  MIT
 */

// The _isBuffer check is for Safari 5-7 support, because it's missing
// Object.prototype.constructor. Remove this eventually
module.exports = function (obj) {
  return obj != null && (isBuffer(obj) || isSlowBuffer(obj) || !!obj._isBuffer)
}

function isBuffer (obj) {
  return !!obj.constructor && typeof obj.constructor.isBuffer === 'function' && obj.constructor.isBuffer(obj)
}

// For Node v0.10 support. Remove this eventually.
function isSlowBuffer (obj) {
  return typeof obj.readFloatLE === 'function' && typeof obj.slice === 'function' && isBuffer(obj.slice(0, 0))
}


/***/ }),
/* 74 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var defaults = __webpack_require__(27);
var utils = __webpack_require__(4);
var InterceptorManager = __webpack_require__(83);
var dispatchRequest = __webpack_require__(84);

/**
 * Create a new instance of Axios
 *
 * @param {Object} instanceConfig The default config for the instance
 */
function Axios(instanceConfig) {
  this.defaults = instanceConfig;
  this.interceptors = {
    request: new InterceptorManager(),
    response: new InterceptorManager()
  };
}

/**
 * Dispatch a request
 *
 * @param {Object} config The config specific for this request (merged with this.defaults)
 */
Axios.prototype.request = function request(config) {
  /*eslint no-param-reassign:0*/
  // Allow for axios('example/url'[, config]) a la fetch API
  if (typeof config === 'string') {
    config = utils.merge({
      url: arguments[0]
    }, arguments[1]);
  }

  config = utils.merge(defaults, {method: 'get'}, this.defaults, config);
  config.method = config.method.toLowerCase();

  // Hook up interceptors middleware
  var chain = [dispatchRequest, undefined];
  var promise = Promise.resolve(config);

  this.interceptors.request.forEach(function unshiftRequestInterceptors(interceptor) {
    chain.unshift(interceptor.fulfilled, interceptor.rejected);
  });

  this.interceptors.response.forEach(function pushResponseInterceptors(interceptor) {
    chain.push(interceptor.fulfilled, interceptor.rejected);
  });

  while (chain.length) {
    promise = promise.then(chain.shift(), chain.shift());
  }

  return promise;
};

// Provide aliases for supported request methods
utils.forEach(['delete', 'get', 'head', 'options'], function forEachMethodNoData(method) {
  /*eslint func-names:0*/
  Axios.prototype[method] = function(url, config) {
    return this.request(utils.merge(config || {}, {
      method: method,
      url: url
    }));
  };
});

utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
  /*eslint func-names:0*/
  Axios.prototype[method] = function(url, data, config) {
    return this.request(utils.merge(config || {}, {
      method: method,
      url: url,
      data: data
    }));
  };
});

module.exports = Axios;


/***/ }),
/* 75 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(4);

module.exports = function normalizeHeaderName(headers, normalizedName) {
  utils.forEach(headers, function processHeader(value, name) {
    if (name !== normalizedName && name.toUpperCase() === normalizedName.toUpperCase()) {
      headers[normalizedName] = value;
      delete headers[name];
    }
  });
};


/***/ }),
/* 76 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var createError = __webpack_require__(41);

/**
 * Resolve or reject a Promise based on response status.
 *
 * @param {Function} resolve A function that resolves the promise.
 * @param {Function} reject A function that rejects the promise.
 * @param {object} response The response.
 */
module.exports = function settle(resolve, reject, response) {
  var validateStatus = response.config.validateStatus;
  // Note: status is not exposed by XDomainRequest
  if (!response.status || !validateStatus || validateStatus(response.status)) {
    resolve(response);
  } else {
    reject(createError(
      'Request failed with status code ' + response.status,
      response.config,
      null,
      response.request,
      response
    ));
  }
};


/***/ }),
/* 77 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Update an Error with the specified config, error code, and response.
 *
 * @param {Error} error The error to update.
 * @param {Object} config The config.
 * @param {string} [code] The error code (for example, 'ECONNABORTED').
 * @param {Object} [request] The request.
 * @param {Object} [response] The response.
 * @returns {Error} The error.
 */
module.exports = function enhanceError(error, config, code, request, response) {
  error.config = config;
  if (code) {
    error.code = code;
  }
  error.request = request;
  error.response = response;
  return error;
};


/***/ }),
/* 78 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(4);

function encode(val) {
  return encodeURIComponent(val).
    replace(/%40/gi, '@').
    replace(/%3A/gi, ':').
    replace(/%24/g, '$').
    replace(/%2C/gi, ',').
    replace(/%20/g, '+').
    replace(/%5B/gi, '[').
    replace(/%5D/gi, ']');
}

/**
 * Build a URL by appending params to the end
 *
 * @param {string} url The base of the url (e.g., http://www.google.com)
 * @param {object} [params] The params to be appended
 * @returns {string} The formatted url
 */
module.exports = function buildURL(url, params, paramsSerializer) {
  /*eslint no-param-reassign:0*/
  if (!params) {
    return url;
  }

  var serializedParams;
  if (paramsSerializer) {
    serializedParams = paramsSerializer(params);
  } else if (utils.isURLSearchParams(params)) {
    serializedParams = params.toString();
  } else {
    var parts = [];

    utils.forEach(params, function serialize(val, key) {
      if (val === null || typeof val === 'undefined') {
        return;
      }

      if (utils.isArray(val)) {
        key = key + '[]';
      } else {
        val = [val];
      }

      utils.forEach(val, function parseValue(v) {
        if (utils.isDate(v)) {
          v = v.toISOString();
        } else if (utils.isObject(v)) {
          v = JSON.stringify(v);
        }
        parts.push(encode(key) + '=' + encode(v));
      });
    });

    serializedParams = parts.join('&');
  }

  if (serializedParams) {
    url += (url.indexOf('?') === -1 ? '?' : '&') + serializedParams;
  }

  return url;
};


/***/ }),
/* 79 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(4);

// Headers whose duplicates are ignored by node
// c.f. https://nodejs.org/api/http.html#http_message_headers
var ignoreDuplicateOf = [
  'age', 'authorization', 'content-length', 'content-type', 'etag',
  'expires', 'from', 'host', 'if-modified-since', 'if-unmodified-since',
  'last-modified', 'location', 'max-forwards', 'proxy-authorization',
  'referer', 'retry-after', 'user-agent'
];

/**
 * Parse headers into an object
 *
 * ```
 * Date: Wed, 27 Aug 2014 08:58:49 GMT
 * Content-Type: application/json
 * Connection: keep-alive
 * Transfer-Encoding: chunked
 * ```
 *
 * @param {String} headers Headers needing to be parsed
 * @returns {Object} Headers parsed into an object
 */
module.exports = function parseHeaders(headers) {
  var parsed = {};
  var key;
  var val;
  var i;

  if (!headers) { return parsed; }

  utils.forEach(headers.split('\n'), function parser(line) {
    i = line.indexOf(':');
    key = utils.trim(line.substr(0, i)).toLowerCase();
    val = utils.trim(line.substr(i + 1));

    if (key) {
      if (parsed[key] && ignoreDuplicateOf.indexOf(key) >= 0) {
        return;
      }
      if (key === 'set-cookie') {
        parsed[key] = (parsed[key] ? parsed[key] : []).concat([val]);
      } else {
        parsed[key] = parsed[key] ? parsed[key] + ', ' + val : val;
      }
    }
  });

  return parsed;
};


/***/ }),
/* 80 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(4);

module.exports = (
  utils.isStandardBrowserEnv() ?

  // Standard browser envs have full support of the APIs needed to test
  // whether the request URL is of the same origin as current location.
  (function standardBrowserEnv() {
    var msie = /(msie|trident)/i.test(navigator.userAgent);
    var urlParsingNode = document.createElement('a');
    var originURL;

    /**
    * Parse a URL to discover it's components
    *
    * @param {String} url The URL to be parsed
    * @returns {Object}
    */
    function resolveURL(url) {
      var href = url;

      if (msie) {
        // IE needs attribute set twice to normalize properties
        urlParsingNode.setAttribute('href', href);
        href = urlParsingNode.href;
      }

      urlParsingNode.setAttribute('href', href);

      // urlParsingNode provides the UrlUtils interface - http://url.spec.whatwg.org/#urlutils
      return {
        href: urlParsingNode.href,
        protocol: urlParsingNode.protocol ? urlParsingNode.protocol.replace(/:$/, '') : '',
        host: urlParsingNode.host,
        search: urlParsingNode.search ? urlParsingNode.search.replace(/^\?/, '') : '',
        hash: urlParsingNode.hash ? urlParsingNode.hash.replace(/^#/, '') : '',
        hostname: urlParsingNode.hostname,
        port: urlParsingNode.port,
        pathname: (urlParsingNode.pathname.charAt(0) === '/') ?
                  urlParsingNode.pathname :
                  '/' + urlParsingNode.pathname
      };
    }

    originURL = resolveURL(window.location.href);

    /**
    * Determine if a URL shares the same origin as the current location
    *
    * @param {String} requestURL The URL to test
    * @returns {boolean} True if URL shares the same origin, otherwise false
    */
    return function isURLSameOrigin(requestURL) {
      var parsed = (utils.isString(requestURL)) ? resolveURL(requestURL) : requestURL;
      return (parsed.protocol === originURL.protocol &&
            parsed.host === originURL.host);
    };
  })() :

  // Non standard browser envs (web workers, react-native) lack needed support.
  (function nonStandardBrowserEnv() {
    return function isURLSameOrigin() {
      return true;
    };
  })()
);


/***/ }),
/* 81 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


// btoa polyfill for IE<10 courtesy https://github.com/davidchambers/Base64.js

var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';

function E() {
  this.message = 'String contains an invalid character';
}
E.prototype = new Error;
E.prototype.code = 5;
E.prototype.name = 'InvalidCharacterError';

function btoa(input) {
  var str = String(input);
  var output = '';
  for (
    // initialize result and counter
    var block, charCode, idx = 0, map = chars;
    // if the next str index does not exist:
    //   change the mapping table to "="
    //   check if d has no fractional digits
    str.charAt(idx | 0) || (map = '=', idx % 1);
    // "8 - idx % 1 * 8" generates the sequence 2, 4, 6, 8
    output += map.charAt(63 & block >> 8 - idx % 1 * 8)
  ) {
    charCode = str.charCodeAt(idx += 3 / 4);
    if (charCode > 0xFF) {
      throw new E();
    }
    block = block << 8 | charCode;
  }
  return output;
}

module.exports = btoa;


/***/ }),
/* 82 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(4);

module.exports = (
  utils.isStandardBrowserEnv() ?

  // Standard browser envs support document.cookie
  (function standardBrowserEnv() {
    return {
      write: function write(name, value, expires, path, domain, secure) {
        var cookie = [];
        cookie.push(name + '=' + encodeURIComponent(value));

        if (utils.isNumber(expires)) {
          cookie.push('expires=' + new Date(expires).toGMTString());
        }

        if (utils.isString(path)) {
          cookie.push('path=' + path);
        }

        if (utils.isString(domain)) {
          cookie.push('domain=' + domain);
        }

        if (secure === true) {
          cookie.push('secure');
        }

        document.cookie = cookie.join('; ');
      },

      read: function read(name) {
        var match = document.cookie.match(new RegExp('(^|;\\s*)(' + name + ')=([^;]*)'));
        return (match ? decodeURIComponent(match[3]) : null);
      },

      remove: function remove(name) {
        this.write(name, '', Date.now() - 86400000);
      }
    };
  })() :

  // Non standard browser env (web workers, react-native) lack needed support.
  (function nonStandardBrowserEnv() {
    return {
      write: function write() {},
      read: function read() { return null; },
      remove: function remove() {}
    };
  })()
);


/***/ }),
/* 83 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(4);

function InterceptorManager() {
  this.handlers = [];
}

/**
 * Add a new interceptor to the stack
 *
 * @param {Function} fulfilled The function to handle `then` for a `Promise`
 * @param {Function} rejected The function to handle `reject` for a `Promise`
 *
 * @return {Number} An ID used to remove interceptor later
 */
InterceptorManager.prototype.use = function use(fulfilled, rejected) {
  this.handlers.push({
    fulfilled: fulfilled,
    rejected: rejected
  });
  return this.handlers.length - 1;
};

/**
 * Remove an interceptor from the stack
 *
 * @param {Number} id The ID that was returned by `use`
 */
InterceptorManager.prototype.eject = function eject(id) {
  if (this.handlers[id]) {
    this.handlers[id] = null;
  }
};

/**
 * Iterate over all the registered interceptors
 *
 * This method is particularly useful for skipping over any
 * interceptors that may have become `null` calling `eject`.
 *
 * @param {Function} fn The function to call for each interceptor
 */
InterceptorManager.prototype.forEach = function forEach(fn) {
  utils.forEach(this.handlers, function forEachHandler(h) {
    if (h !== null) {
      fn(h);
    }
  });
};

module.exports = InterceptorManager;


/***/ }),
/* 84 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(4);
var transformData = __webpack_require__(85);
var isCancel = __webpack_require__(42);
var defaults = __webpack_require__(27);
var isAbsoluteURL = __webpack_require__(86);
var combineURLs = __webpack_require__(87);

/**
 * Throws a `Cancel` if cancellation has been requested.
 */
function throwIfCancellationRequested(config) {
  if (config.cancelToken) {
    config.cancelToken.throwIfRequested();
  }
}

/**
 * Dispatch a request to the server using the configured adapter.
 *
 * @param {object} config The config that is to be used for the request
 * @returns {Promise} The Promise to be fulfilled
 */
module.exports = function dispatchRequest(config) {
  throwIfCancellationRequested(config);

  // Support baseURL config
  if (config.baseURL && !isAbsoluteURL(config.url)) {
    config.url = combineURLs(config.baseURL, config.url);
  }

  // Ensure headers exist
  config.headers = config.headers || {};

  // Transform request data
  config.data = transformData(
    config.data,
    config.headers,
    config.transformRequest
  );

  // Flatten headers
  config.headers = utils.merge(
    config.headers.common || {},
    config.headers[config.method] || {},
    config.headers || {}
  );

  utils.forEach(
    ['delete', 'get', 'head', 'post', 'put', 'patch', 'common'],
    function cleanHeaderConfig(method) {
      delete config.headers[method];
    }
  );

  var adapter = config.adapter || defaults.adapter;

  return adapter(config).then(function onAdapterResolution(response) {
    throwIfCancellationRequested(config);

    // Transform response data
    response.data = transformData(
      response.data,
      response.headers,
      config.transformResponse
    );

    return response;
  }, function onAdapterRejection(reason) {
    if (!isCancel(reason)) {
      throwIfCancellationRequested(config);

      // Transform response data
      if (reason && reason.response) {
        reason.response.data = transformData(
          reason.response.data,
          reason.response.headers,
          config.transformResponse
        );
      }
    }

    return Promise.reject(reason);
  });
};


/***/ }),
/* 85 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(4);

/**
 * Transform the data for a request or a response
 *
 * @param {Object|String} data The data to be transformed
 * @param {Array} headers The headers for the request or response
 * @param {Array|Function} fns A single function or Array of functions
 * @returns {*} The resulting transformed data
 */
module.exports = function transformData(data, headers, fns) {
  /*eslint no-param-reassign:0*/
  utils.forEach(fns, function transform(fn) {
    data = fn(data, headers);
  });

  return data;
};


/***/ }),
/* 86 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Determines whether the specified URL is absolute
 *
 * @param {string} url The URL to test
 * @returns {boolean} True if the specified URL is absolute, otherwise false
 */
module.exports = function isAbsoluteURL(url) {
  // A URL is considered absolute if it begins with "<scheme>://" or "//" (protocol-relative URL).
  // RFC 3986 defines scheme name as a sequence of characters beginning with a letter and followed
  // by any combination of letters, digits, plus, period, or hyphen.
  return /^([a-z][a-z\d\+\-\.]*:)?\/\//i.test(url);
};


/***/ }),
/* 87 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Creates a new URL by combining the specified URLs
 *
 * @param {string} baseURL The base URL
 * @param {string} relativeURL The relative URL
 * @returns {string} The combined URL
 */
module.exports = function combineURLs(baseURL, relativeURL) {
  return relativeURL
    ? baseURL.replace(/\/+$/, '') + '/' + relativeURL.replace(/^\/+/, '')
    : baseURL;
};


/***/ }),
/* 88 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var Cancel = __webpack_require__(43);

/**
 * A `CancelToken` is an object that can be used to request cancellation of an operation.
 *
 * @class
 * @param {Function} executor The executor function.
 */
function CancelToken(executor) {
  if (typeof executor !== 'function') {
    throw new TypeError('executor must be a function.');
  }

  var resolvePromise;
  this.promise = new Promise(function promiseExecutor(resolve) {
    resolvePromise = resolve;
  });

  var token = this;
  executor(function cancel(message) {
    if (token.reason) {
      // Cancellation has already been requested
      return;
    }

    token.reason = new Cancel(message);
    resolvePromise(token.reason);
  });
}

/**
 * Throws a `Cancel` if cancellation has been requested.
 */
CancelToken.prototype.throwIfRequested = function throwIfRequested() {
  if (this.reason) {
    throw this.reason;
  }
};

/**
 * Returns an object that contains a new `CancelToken` and a function that, when called,
 * cancels the `CancelToken`.
 */
CancelToken.source = function source() {
  var cancel;
  var token = new CancelToken(function executor(c) {
    cancel = c;
  });
  return {
    token: token,
    cancel: cancel
  };
};

module.exports = CancelToken;


/***/ }),
/* 89 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Syntactic sugar for invoking a function and expanding an array for arguments.
 *
 * Common use case would be to use `Function.prototype.apply`.
 *
 *  ```js
 *  function f(x, y, z) {}
 *  var args = [1, 2, 3];
 *  f.apply(null, args);
 *  ```
 *
 * With `spread` this example can be re-written.
 *
 *  ```js
 *  spread(function(x, y, z) {})([1, 2, 3]);
 *  ```
 *
 * @param {Function} callback
 * @returns {Function}
 */
module.exports = function spread(callback) {
  return function wrap(arr) {
    return callback.apply(null, arr);
  };
};


/***/ }),
/* 90 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {var scope = (typeof global !== "undefined" && global) ||
            (typeof self !== "undefined" && self) ||
            window;
var apply = Function.prototype.apply;

// DOM APIs, for completeness

exports.setTimeout = function() {
  return new Timeout(apply.call(setTimeout, scope, arguments), clearTimeout);
};
exports.setInterval = function() {
  return new Timeout(apply.call(setInterval, scope, arguments), clearInterval);
};
exports.clearTimeout =
exports.clearInterval = function(timeout) {
  if (timeout) {
    timeout.close();
  }
};

function Timeout(id, clearFn) {
  this._id = id;
  this._clearFn = clearFn;
}
Timeout.prototype.unref = Timeout.prototype.ref = function() {};
Timeout.prototype.close = function() {
  this._clearFn.call(scope, this._id);
};

// Does not start the time, just sets up the members needed.
exports.enroll = function(item, msecs) {
  clearTimeout(item._idleTimeoutId);
  item._idleTimeout = msecs;
};

exports.unenroll = function(item) {
  clearTimeout(item._idleTimeoutId);
  item._idleTimeout = -1;
};

exports._unrefActive = exports.active = function(item) {
  clearTimeout(item._idleTimeoutId);

  var msecs = item._idleTimeout;
  if (msecs >= 0) {
    item._idleTimeoutId = setTimeout(function onTimeout() {
      if (item._onTimeout)
        item._onTimeout();
    }, msecs);
  }
};

// setimmediate attaches itself to the global object
__webpack_require__(91);
// On some exotic environments, it's not clear which object `setimmediate` was
// able to install onto.  Search each possibility in the same order as the
// `setimmediate` library.
exports.setImmediate = (typeof self !== "undefined" && self.setImmediate) ||
                       (typeof global !== "undefined" && global.setImmediate) ||
                       (this && this.setImmediate);
exports.clearImmediate = (typeof self !== "undefined" && self.clearImmediate) ||
                         (typeof global !== "undefined" && global.clearImmediate) ||
                         (this && this.clearImmediate);

/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(12)))

/***/ }),
/* 91 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global, process) {(function (global, undefined) {
    "use strict";

    if (global.setImmediate) {
        return;
    }

    var nextHandle = 1; // Spec says greater than zero
    var tasksByHandle = {};
    var currentlyRunningATask = false;
    var doc = global.document;
    var registerImmediate;

    function setImmediate(callback) {
      // Callback can either be a function or a string
      if (typeof callback !== "function") {
        callback = new Function("" + callback);
      }
      // Copy function arguments
      var args = new Array(arguments.length - 1);
      for (var i = 0; i < args.length; i++) {
          args[i] = arguments[i + 1];
      }
      // Store and register the task
      var task = { callback: callback, args: args };
      tasksByHandle[nextHandle] = task;
      registerImmediate(nextHandle);
      return nextHandle++;
    }

    function clearImmediate(handle) {
        delete tasksByHandle[handle];
    }

    function run(task) {
        var callback = task.callback;
        var args = task.args;
        switch (args.length) {
        case 0:
            callback();
            break;
        case 1:
            callback(args[0]);
            break;
        case 2:
            callback(args[0], args[1]);
            break;
        case 3:
            callback(args[0], args[1], args[2]);
            break;
        default:
            callback.apply(undefined, args);
            break;
        }
    }

    function runIfPresent(handle) {
        // From the spec: "Wait until any invocations of this algorithm started before this one have completed."
        // So if we're currently running a task, we'll need to delay this invocation.
        if (currentlyRunningATask) {
            // Delay by doing a setTimeout. setImmediate was tried instead, but in Firefox 7 it generated a
            // "too much recursion" error.
            setTimeout(runIfPresent, 0, handle);
        } else {
            var task = tasksByHandle[handle];
            if (task) {
                currentlyRunningATask = true;
                try {
                    run(task);
                } finally {
                    clearImmediate(handle);
                    currentlyRunningATask = false;
                }
            }
        }
    }

    function installNextTickImplementation() {
        registerImmediate = function(handle) {
            process.nextTick(function () { runIfPresent(handle); });
        };
    }

    function canUsePostMessage() {
        // The test against `importScripts` prevents this implementation from being installed inside a web worker,
        // where `global.postMessage` means something completely different and can't be used for this purpose.
        if (global.postMessage && !global.importScripts) {
            var postMessageIsAsynchronous = true;
            var oldOnMessage = global.onmessage;
            global.onmessage = function() {
                postMessageIsAsynchronous = false;
            };
            global.postMessage("", "*");
            global.onmessage = oldOnMessage;
            return postMessageIsAsynchronous;
        }
    }

    function installPostMessageImplementation() {
        // Installs an event handler on `global` for the `message` event: see
        // * https://developer.mozilla.org/en/DOM/window.postMessage
        // * http://www.whatwg.org/specs/web-apps/current-work/multipage/comms.html#crossDocumentMessages

        var messagePrefix = "setImmediate$" + Math.random() + "$";
        var onGlobalMessage = function(event) {
            if (event.source === global &&
                typeof event.data === "string" &&
                event.data.indexOf(messagePrefix) === 0) {
                runIfPresent(+event.data.slice(messagePrefix.length));
            }
        };

        if (global.addEventListener) {
            global.addEventListener("message", onGlobalMessage, false);
        } else {
            global.attachEvent("onmessage", onGlobalMessage);
        }

        registerImmediate = function(handle) {
            global.postMessage(messagePrefix + handle, "*");
        };
    }

    function installMessageChannelImplementation() {
        var channel = new MessageChannel();
        channel.port1.onmessage = function(event) {
            var handle = event.data;
            runIfPresent(handle);
        };

        registerImmediate = function(handle) {
            channel.port2.postMessage(handle);
        };
    }

    function installReadyStateChangeImplementation() {
        var html = doc.documentElement;
        registerImmediate = function(handle) {
            // Create a <script> element; its readystatechange event will be fired asynchronously once it is inserted
            // into the document. Do so, thus queuing up the task. Remember to clean up once it's been called.
            var script = doc.createElement("script");
            script.onreadystatechange = function () {
                runIfPresent(handle);
                script.onreadystatechange = null;
                html.removeChild(script);
                script = null;
            };
            html.appendChild(script);
        };
    }

    function installSetTimeoutImplementation() {
        registerImmediate = function(handle) {
            setTimeout(runIfPresent, 0, handle);
        };
    }

    // If supported, we should attach to the prototype of global, since that is where setTimeout et al. live.
    var attachTo = Object.getPrototypeOf && Object.getPrototypeOf(global);
    attachTo = attachTo && attachTo.setTimeout ? attachTo : global;

    // Don't get fooled by e.g. browserify environments.
    if ({}.toString.call(global.process) === "[object process]") {
        // For Node.js before 0.9
        installNextTickImplementation();

    } else if (canUsePostMessage()) {
        // For non-IE10 modern browsers
        installPostMessageImplementation();

    } else if (global.MessageChannel) {
        // For web workers, where supported
        installMessageChannelImplementation();

    } else if (doc && "onreadystatechange" in doc.createElement("script")) {
        // For IE 6–8
        installReadyStateChangeImplementation();

    } else {
        // For older browsers
        installSetTimeoutImplementation();
    }

    attachTo.setImmediate = setImmediate;
    attachTo.clearImmediate = clearImmediate;
}(typeof self === "undefined" ? typeof global === "undefined" ? this : global : self));

/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(12), __webpack_require__(28)))

/***/ }),
/* 92 */,
/* 93 */,
/* 94 */,
/* 95 */,
/* 96 */,
/* 97 */,
/* 98 */,
/* 99 */,
/* 100 */,
/* 101 */,
/* 102 */,
/* 103 */,
/* 104 */,
/* 105 */
/***/ (function(module, exports) {


/**
 * When source maps are enabled, `style-loader` uses a link element with a data-uri to
 * embed the css on the page. This breaks all relative urls because now they are relative to a
 * bundle instead of the current page.
 *
 * One solution is to only use full urls, but that may be impossible.
 *
 * Instead, this function "fixes" the relative urls to be absolute according to the current page location.
 *
 * A rudimentary test suite is located at `test/fixUrls.js` and can be run via the `npm test` command.
 *
 */

module.exports = function (css) {
  // get current location
  var location = typeof window !== "undefined" && window.location;

  if (!location) {
    throw new Error("fixUrls requires window.location");
  }

	// blank or null?
	if (!css || typeof css !== "string") {
	  return css;
  }

  var baseUrl = location.protocol + "//" + location.host;
  var currentDir = baseUrl + location.pathname.replace(/\/[^\/]*$/, "/");

	// convert each url(...)
	/*
	This regular expression is just a way to recursively match brackets within
	a string.

	 /url\s*\(  = Match on the word "url" with any whitespace after it and then a parens
	   (  = Start a capturing group
	     (?:  = Start a non-capturing group
	         [^)(]  = Match anything that isn't a parentheses
	         |  = OR
	         \(  = Match a start parentheses
	             (?:  = Start another non-capturing groups
	                 [^)(]+  = Match anything that isn't a parentheses
	                 |  = OR
	                 \(  = Match a start parentheses
	                     [^)(]*  = Match anything that isn't a parentheses
	                 \)  = Match a end parentheses
	             )  = End Group
              *\) = Match anything and then a close parens
          )  = Close non-capturing group
          *  = Match anything
       )  = Close capturing group
	 \)  = Match a close parens

	 /gi  = Get all matches, not the first.  Be case insensitive.
	 */
	var fixedCss = css.replace(/url\s*\(((?:[^)(]|\((?:[^)(]+|\([^)(]*\))*\))*)\)/gi, function(fullMatch, origUrl) {
		// strip quotes (if they exist)
		var unquotedOrigUrl = origUrl
			.trim()
			.replace(/^"(.*)"$/, function(o, $1){ return $1; })
			.replace(/^'(.*)'$/, function(o, $1){ return $1; });

		// already a full url? no change
		if (/^(#|data:|http:\/\/|https:\/\/|file:\/\/\/)/i.test(unquotedOrigUrl)) {
		  return fullMatch;
		}

		// convert the url to a full url
		var newUrl;

		if (unquotedOrigUrl.indexOf("//") === 0) {
		  	//TODO: should we add protocol?
			newUrl = unquotedOrigUrl;
		} else if (unquotedOrigUrl.indexOf("/") === 0) {
			// path should be relative to the base url
			newUrl = baseUrl + unquotedOrigUrl; // already starts with '/'
		} else {
			// path should be relative to current directory
			newUrl = currentDir + unquotedOrigUrl.replace(/^\.\//, ""); // Strip leading './'
		}

		// send back the fixed url(...)
		return "url(" + JSON.stringify(newUrl) + ")";
	});

	// send back the fixed css
	return fixedCss;
};


/***/ }),
/* 106 */,
/* 107 */,
/* 108 */
/***/ (function(module, exports) {

module.exports = function (exec) {
  try {
    return !!exec();
  } catch (e) {
    return true;
  }
};


/***/ }),
/* 109 */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(54);
var document = __webpack_require__(11).document;
// typeof document.createElement is 'object' in old IE
var is = isObject(document) && isObject(document.createElement);
module.exports = function (it) {
  return is ? document.createElement(it) : {};
};


/***/ }),
/* 110 */
/***/ (function(module, exports, __webpack_require__) {

// to indexed object, toObject with fallback for non-array-like ES3 strings
var IObject = __webpack_require__(292);
var defined = __webpack_require__(111);
module.exports = function (it) {
  return IObject(defined(it));
};


/***/ }),
/* 111 */
/***/ (function(module, exports) {

// 7.2.1 RequireObjectCoercible(argument)
module.exports = function (it) {
  if (it == undefined) throw TypeError("Can't call method on  " + it);
  return it;
};


/***/ }),
/* 112 */
/***/ (function(module, exports) {

// 7.1.4 ToInteger
var ceil = Math.ceil;
var floor = Math.floor;
module.exports = function (it) {
  return isNaN(it = +it) ? 0 : (it > 0 ? floor : ceil)(it);
};


/***/ }),
/* 113 */
/***/ (function(module, exports, __webpack_require__) {

var shared = __webpack_require__(294)('keys');
var uid = __webpack_require__(295);
module.exports = function (key) {
  return shared[key] || (shared[key] = uid(key));
};


/***/ }),
/* 114 */
/***/ (function(module, exports) {

module.exports = true;


/***/ }),
/* 115 */
/***/ (function(module, exports, __webpack_require__) {

var def = __webpack_require__(67).f;
var has = __webpack_require__(68);
var TAG = __webpack_require__(14)('toStringTag');

module.exports = function (it, tag, stat) {
  if (it && !has(it = stat ? it : it.prototype, TAG)) def(it, TAG, { configurable: true, value: tag });
};


/***/ }),
/* 116 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

// 25.4.1.5 NewPromiseCapability(C)
var aFunction = __webpack_require__(66);

function PromiseCapability(C) {
  var resolve, reject;
  this.promise = new C(function ($$resolve, $$reject) {
    if (resolve !== undefined || reject !== undefined) throw TypeError('Bad Promise constructor');
    resolve = $$resolve;
    reject = $$reject;
  });
  this.resolve = aFunction(resolve);
  this.reject = aFunction(reject);
}

module.exports.f = function (C) {
  return new PromiseCapability(C);
};


/***/ }),
/* 117 */
/***/ (function(module, exports, __webpack_require__) {

/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
  Modified by Evan You @yyx990803
*/

var hasDocument = typeof document !== 'undefined'

if (typeof DEBUG !== 'undefined' && DEBUG) {
  if (!hasDocument) {
    throw new Error(
    'vue-style-loader cannot be used in a non-browser environment. ' +
    "Use { target: 'node' } in your Webpack config to indicate a server-rendering environment."
  ) }
}

var listToStyles = __webpack_require__(567)

/*
type StyleObject = {
  id: number;
  parts: Array<StyleObjectPart>
}

type StyleObjectPart = {
  css: string;
  media: string;
  sourceMap: ?string
}
*/

var stylesInDom = {/*
  [id: number]: {
    id: number,
    refs: number,
    parts: Array<(obj?: StyleObjectPart) => void>
  }
*/}

var head = hasDocument && (document.head || document.getElementsByTagName('head')[0])
var singletonElement = null
var singletonCounter = 0
var isProduction = false
var noop = function () {}
var options = null
var ssrIdKey = 'data-vue-ssr-id'

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

module.exports = function (parentId, list, _isProduction, _options) {
  isProduction = _isProduction

  options = _options || {}

  var styles = listToStyles(parentId, list)
  addStylesToDom(styles)

  return function update (newList) {
    var mayRemove = []
    for (var i = 0; i < styles.length; i++) {
      var item = styles[i]
      var domStyle = stylesInDom[item.id]
      domStyle.refs--
      mayRemove.push(domStyle)
    }
    if (newList) {
      styles = listToStyles(parentId, newList)
      addStylesToDom(styles)
    } else {
      styles = []
    }
    for (var i = 0; i < mayRemove.length; i++) {
      var domStyle = mayRemove[i]
      if (domStyle.refs === 0) {
        for (var j = 0; j < domStyle.parts.length; j++) {
          domStyle.parts[j]()
        }
        delete stylesInDom[domStyle.id]
      }
    }
  }
}

function addStylesToDom (styles /* Array<StyleObject> */) {
  for (var i = 0; i < styles.length; i++) {
    var item = styles[i]
    var domStyle = stylesInDom[item.id]
    if (domStyle) {
      domStyle.refs++
      for (var j = 0; j < domStyle.parts.length; j++) {
        domStyle.parts[j](item.parts[j])
      }
      for (; j < item.parts.length; j++) {
        domStyle.parts.push(addStyle(item.parts[j]))
      }
      if (domStyle.parts.length > item.parts.length) {
        domStyle.parts.length = item.parts.length
      }
    } else {
      var parts = []
      for (var j = 0; j < item.parts.length; j++) {
        parts.push(addStyle(item.parts[j]))
      }
      stylesInDom[item.id] = { id: item.id, refs: 1, parts: parts }
    }
  }
}

function createStyleElement () {
  var styleElement = document.createElement('style')
  styleElement.type = 'text/css'
  head.appendChild(styleElement)
  return styleElement
}

function addStyle (obj /* StyleObjectPart */) {
  var update, remove
  var styleElement = document.querySelector('style[' + ssrIdKey + '~="' + obj.id + '"]')

  if (styleElement) {
    if (isProduction) {
      // has SSR styles and in production mode.
      // simply do nothing.
      return noop
    } else {
      // has SSR styles but in dev mode.
      // for some reason Chrome can't handle source map in server-rendered
      // style tags - source maps in <style> only works if the style tag is
      // created and inserted dynamically. So we remove the server rendered
      // styles and inject new ones.
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  if (isOldIE) {
    // use singleton mode for IE9.
    var styleIndex = singletonCounter++
    styleElement = singletonElement || (singletonElement = createStyleElement())
    update = applyToSingletonTag.bind(null, styleElement, styleIndex, false)
    remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true)
  } else {
    // use multi-style-tag mode in all other cases
    styleElement = createStyleElement()
    update = applyToTag.bind(null, styleElement)
    remove = function () {
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  update(obj)

  return function updateStyle (newObj /* StyleObjectPart */) {
    if (newObj) {
      if (newObj.css === obj.css &&
          newObj.media === obj.media &&
          newObj.sourceMap === obj.sourceMap) {
        return
      }
      update(obj = newObj)
    } else {
      remove()
    }
  }
}

var replaceText = (function () {
  var textStore = []

  return function (index, replacement) {
    textStore[index] = replacement
    return textStore.filter(Boolean).join('\n')
  }
})()

function applyToSingletonTag (styleElement, index, remove, obj) {
  var css = remove ? '' : obj.css

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = replaceText(index, css)
  } else {
    var cssNode = document.createTextNode(css)
    var childNodes = styleElement.childNodes
    if (childNodes[index]) styleElement.removeChild(childNodes[index])
    if (childNodes.length) {
      styleElement.insertBefore(cssNode, childNodes[index])
    } else {
      styleElement.appendChild(cssNode)
    }
  }
}

function applyToTag (styleElement, obj) {
  var css = obj.css
  var media = obj.media
  var sourceMap = obj.sourceMap

  if (media) {
    styleElement.setAttribute('media', media)
  }
  if (options.ssrId) {
    styleElement.setAttribute(ssrIdKey, obj.id)
  }

  if (sourceMap) {
    // https://developer.chrome.com/devtools/docs/javascript-debugging
    // this makes source maps inside style tags work properly in Chrome
    css += '\n/*# sourceURL=' + sourceMap.sources[0] + ' */'
    // http://stackoverflow.com/a/26603875
    css += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + ' */'
  }

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild)
    }
    styleElement.appendChild(document.createTextNode(css))
  }
}


/***/ }),
/* 118 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
const A_ROTATE = 'rotate'
const A_BEAT = 'beat'
const A_SHAKE = 'shake'

/* harmony default export */ __webpack_exports__["a"] = ({
  computed: {
    ionClass() {
      let addClass = ''
      if (this.animate === A_ROTATE) {
        addClass = 'ion-rotate '
      } else if (this.animate === A_BEAT) {
        addClass = 'ion-beat '
      } else if (this.animate === A_SHAKE) {
        addClass = 'ion-shake '
      }

      return `${this.rootClass} ${addClass}`
    }
  },
  props: {
    title: {
      type: String,
      default: ''
    },
    rootClass: {
      type: String,
      default: ''
    },
    w: {
      type: String,
      default: '14px'
    },
    h: {
      type: String,
      default: '14px'
    },
    animate: {
      type: String,
      default: ''
    }
  }
});


/***/ }),
/* 119 */,
/* 120 */,
/* 121 */,
/* 122 */,
/* 123 */,
/* 124 */,
/* 125 */,
/* 126 */,
/* 127 */,
/* 128 */,
/* 129 */,
/* 130 */,
/* 131 */,
/* 132 */,
/* 133 */,
/* 134 */,
/* 135 */,
/* 136 */,
/* 137 */,
/* 138 */,
/* 139 */,
/* 140 */,
/* 141 */,
/* 142 */,
/* 143 */,
/* 144 */,
/* 145 */,
/* 146 */,
/* 147 */,
/* 148 */,
/* 149 */,
/* 150 */,
/* 151 */,
/* 152 */,
/* 153 */,
/* 154 */,
/* 155 */,
/* 156 */,
/* 157 */,
/* 158 */,
/* 159 */,
/* 160 */,
/* 161 */,
/* 162 */,
/* 163 */,
/* 164 */,
/* 165 */,
/* 166 */,
/* 167 */,
/* 168 */,
/* 169 */,
/* 170 */,
/* 171 */,
/* 172 */,
/* 173 */,
/* 174 */,
/* 175 */,
/* 176 */,
/* 177 */,
/* 178 */,
/* 179 */,
/* 180 */,
/* 181 */,
/* 182 */,
/* 183 */,
/* 184 */,
/* 185 */,
/* 186 */,
/* 187 */,
/* 188 */,
/* 189 */,
/* 190 */,
/* 191 */,
/* 192 */,
/* 193 */,
/* 194 */,
/* 195 */,
/* 196 */,
/* 197 */,
/* 198 */,
/* 199 */,
/* 200 */,
/* 201 */,
/* 202 */,
/* 203 */,
/* 204 */,
/* 205 */,
/* 206 */,
/* 207 */,
/* 208 */,
/* 209 */,
/* 210 */,
/* 211 */,
/* 212 */,
/* 213 */,
/* 214 */,
/* 215 */,
/* 216 */,
/* 217 */,
/* 218 */,
/* 219 */,
/* 220 */,
/* 221 */,
/* 222 */,
/* 223 */,
/* 224 */,
/* 225 */,
/* 226 */,
/* 227 */,
/* 228 */,
/* 229 */,
/* 230 */,
/* 231 */,
/* 232 */,
/* 233 */,
/* 234 */,
/* 235 */,
/* 236 */,
/* 237 */,
/* 238 */,
/* 239 */,
/* 240 */,
/* 241 */,
/* 242 */,
/* 243 */,
/* 244 */,
/* 245 */,
/* 246 */,
/* 247 */,
/* 248 */,
/* 249 */,
/* 250 */,
/* 251 */,
/* 252 */,
/* 253 */,
/* 254 */,
/* 255 */,
/* 256 */,
/* 257 */,
/* 258 */,
/* 259 */,
/* 260 */,
/* 261 */,
/* 262 */,
/* 263 */,
/* 264 */,
/* 265 */,
/* 266 */,
/* 267 */,
/* 268 */,
/* 269 */,
/* 270 */,
/* 271 */,
/* 272 */,
/* 273 */,
/* 274 */,
/* 275 */,
/* 276 */,
/* 277 */,
/* 278 */,
/* 279 */,
/* 280 */,
/* 281 */,
/* 282 */,
/* 283 */,
/* 284 */,
/* 285 */,
/* 286 */,
/* 287 */,
/* 288 */,
/* 289 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = { "default": __webpack_require__(524), __esModule: true };

/***/ }),
/* 290 */
/***/ (function(module, exports) {

module.exports = function (bitmap, value) {
  return {
    enumerable: !(bitmap & 1),
    configurable: !(bitmap & 2),
    writable: !(bitmap & 4),
    value: value
  };
};


/***/ }),
/* 291 */
/***/ (function(module, exports, __webpack_require__) {

// 19.1.2.14 / 15.2.3.14 Object.keys(O)
var $keys = __webpack_require__(529);
var enumBugKeys = __webpack_require__(296);

module.exports = Object.keys || function keys(O) {
  return $keys(O, enumBugKeys);
};


/***/ }),
/* 292 */
/***/ (function(module, exports, __webpack_require__) {

// fallback for non-array-like ES3 and non-enumerable old V8 strings
var cof = __webpack_require__(69);
// eslint-disable-next-line no-prototype-builtins
module.exports = Object('z').propertyIsEnumerable(0) ? Object : function (it) {
  return cof(it) == 'String' ? it.split('') : Object(it);
};


/***/ }),
/* 293 */
/***/ (function(module, exports, __webpack_require__) {

// 7.1.15 ToLength
var toInteger = __webpack_require__(112);
var min = Math.min;
module.exports = function (it) {
  return it > 0 ? min(toInteger(it), 0x1fffffffffffff) : 0; // pow(2, 53) - 1 == 9007199254740991
};


/***/ }),
/* 294 */
/***/ (function(module, exports, __webpack_require__) {

var core = __webpack_require__(25);
var global = __webpack_require__(11);
var SHARED = '__core-js_shared__';
var store = global[SHARED] || (global[SHARED] = {});

(module.exports = function (key, value) {
  return store[key] || (store[key] = value !== undefined ? value : {});
})('versions', []).push({
  version: core.version,
  mode: __webpack_require__(114) ? 'pure' : 'global',
  copyright: '© 2018 Denis Pushkarev (zloirock.ru)'
});


/***/ }),
/* 295 */
/***/ (function(module, exports) {

var id = 0;
var px = Math.random();
module.exports = function (key) {
  return 'Symbol('.concat(key === undefined ? '' : key, ')_', (++id + px).toString(36));
};


/***/ }),
/* 296 */
/***/ (function(module, exports) {

// IE 8- don't enum bug keys
module.exports = (
  'constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf'
).split(',');


/***/ }),
/* 297 */
/***/ (function(module, exports, __webpack_require__) {

// 7.1.13 ToObject(argument)
var defined = __webpack_require__(111);
module.exports = function (it) {
  return Object(defined(it));
};


/***/ }),
/* 298 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var LIBRARY = __webpack_require__(114);
var $export = __webpack_require__(53);
var redefine = __webpack_require__(540);
var hide = __webpack_require__(36);
var Iterators = __webpack_require__(56);
var $iterCreate = __webpack_require__(541);
var setToStringTag = __webpack_require__(115);
var getPrototypeOf = __webpack_require__(544);
var ITERATOR = __webpack_require__(14)('iterator');
var BUGGY = !([].keys && 'next' in [].keys()); // Safari has buggy iterators w/o `next`
var FF_ITERATOR = '@@iterator';
var KEYS = 'keys';
var VALUES = 'values';

var returnThis = function () { return this; };

module.exports = function (Base, NAME, Constructor, next, DEFAULT, IS_SET, FORCED) {
  $iterCreate(Constructor, NAME, next);
  var getMethod = function (kind) {
    if (!BUGGY && kind in proto) return proto[kind];
    switch (kind) {
      case KEYS: return function keys() { return new Constructor(this, kind); };
      case VALUES: return function values() { return new Constructor(this, kind); };
    } return function entries() { return new Constructor(this, kind); };
  };
  var TAG = NAME + ' Iterator';
  var DEF_VALUES = DEFAULT == VALUES;
  var VALUES_BUG = false;
  var proto = Base.prototype;
  var $native = proto[ITERATOR] || proto[FF_ITERATOR] || DEFAULT && proto[DEFAULT];
  var $default = $native || getMethod(DEFAULT);
  var $entries = DEFAULT ? !DEF_VALUES ? $default : getMethod('entries') : undefined;
  var $anyNative = NAME == 'Array' ? proto.entries || $native : $native;
  var methods, key, IteratorPrototype;
  // Fix native
  if ($anyNative) {
    IteratorPrototype = getPrototypeOf($anyNative.call(new Base()));
    if (IteratorPrototype !== Object.prototype && IteratorPrototype.next) {
      // Set @@toStringTag to native iterators
      setToStringTag(IteratorPrototype, TAG, true);
      // fix for some old engines
      if (!LIBRARY && typeof IteratorPrototype[ITERATOR] != 'function') hide(IteratorPrototype, ITERATOR, returnThis);
    }
  }
  // fix Array#{values, @@iterator}.name in V8 / FF
  if (DEF_VALUES && $native && $native.name !== VALUES) {
    VALUES_BUG = true;
    $default = function values() { return $native.call(this); };
  }
  // Define iterator
  if ((!LIBRARY || FORCED) && (BUGGY || VALUES_BUG || !proto[ITERATOR])) {
    hide(proto, ITERATOR, $default);
  }
  // Plug for library
  Iterators[NAME] = $default;
  Iterators[TAG] = returnThis;
  if (DEFAULT) {
    methods = {
      values: DEF_VALUES ? $default : getMethod(VALUES),
      keys: IS_SET ? $default : getMethod(KEYS),
      entries: $entries
    };
    if (FORCED) for (key in methods) {
      if (!(key in proto)) redefine(proto, key, methods[key]);
    } else $export($export.P + $export.F * (BUGGY || VALUES_BUG), NAME, methods);
  }
  return methods;
};


/***/ }),
/* 299 */
/***/ (function(module, exports, __webpack_require__) {

var document = __webpack_require__(11).document;
module.exports = document && document.documentElement;


/***/ }),
/* 300 */
/***/ (function(module, exports, __webpack_require__) {

// getting tag from 19.1.3.6 Object.prototype.toString()
var cof = __webpack_require__(69);
var TAG = __webpack_require__(14)('toStringTag');
// ES3 wrong here
var ARG = cof(function () { return arguments; }()) == 'Arguments';

// fallback for IE11 Script Access Denied error
var tryGet = function (it, key) {
  try {
    return it[key];
  } catch (e) { /* empty */ }
};

module.exports = function (it) {
  var O, T, B;
  return it === undefined ? 'Undefined' : it === null ? 'Null'
    // @@toStringTag case
    : typeof (T = tryGet(O = Object(it), TAG)) == 'string' ? T
    // builtinTag case
    : ARG ? cof(O)
    // ES3 arguments fallback
    : (B = cof(O)) == 'Object' && typeof O.callee == 'function' ? 'Arguments' : B;
};


/***/ }),
/* 301 */
/***/ (function(module, exports, __webpack_require__) {

// 7.3.20 SpeciesConstructor(O, defaultConstructor)
var anObject = __webpack_require__(32);
var aFunction = __webpack_require__(66);
var SPECIES = __webpack_require__(14)('species');
module.exports = function (O, D) {
  var C = anObject(O).constructor;
  var S;
  return C === undefined || (S = anObject(C)[SPECIES]) == undefined ? D : aFunction(S);
};


/***/ }),
/* 302 */
/***/ (function(module, exports, __webpack_require__) {

var ctx = __webpack_require__(65);
var invoke = __webpack_require__(555);
var html = __webpack_require__(299);
var cel = __webpack_require__(109);
var global = __webpack_require__(11);
var process = global.process;
var setTask = global.setImmediate;
var clearTask = global.clearImmediate;
var MessageChannel = global.MessageChannel;
var Dispatch = global.Dispatch;
var counter = 0;
var queue = {};
var ONREADYSTATECHANGE = 'onreadystatechange';
var defer, channel, port;
var run = function () {
  var id = +this;
  // eslint-disable-next-line no-prototype-builtins
  if (queue.hasOwnProperty(id)) {
    var fn = queue[id];
    delete queue[id];
    fn();
  }
};
var listener = function (event) {
  run.call(event.data);
};
// Node.js 0.9+ & IE10+ has setImmediate, otherwise:
if (!setTask || !clearTask) {
  setTask = function setImmediate(fn) {
    var args = [];
    var i = 1;
    while (arguments.length > i) args.push(arguments[i++]);
    queue[++counter] = function () {
      // eslint-disable-next-line no-new-func
      invoke(typeof fn == 'function' ? fn : Function(fn), args);
    };
    defer(counter);
    return counter;
  };
  clearTask = function clearImmediate(id) {
    delete queue[id];
  };
  // Node.js 0.8-
  if (__webpack_require__(69)(process) == 'process') {
    defer = function (id) {
      process.nextTick(ctx(run, id, 1));
    };
  // Sphere (JS game engine) Dispatch API
  } else if (Dispatch && Dispatch.now) {
    defer = function (id) {
      Dispatch.now(ctx(run, id, 1));
    };
  // Browsers with MessageChannel, includes WebWorkers
  } else if (MessageChannel) {
    channel = new MessageChannel();
    port = channel.port2;
    channel.port1.onmessage = listener;
    defer = ctx(port.postMessage, port, 1);
  // Browsers with postMessage, skip WebWorkers
  // IE8 has postMessage, but it's sync & typeof its postMessage is 'object'
  } else if (global.addEventListener && typeof postMessage == 'function' && !global.importScripts) {
    defer = function (id) {
      global.postMessage(id + '', '*');
    };
    global.addEventListener('message', listener, false);
  // IE8-
  } else if (ONREADYSTATECHANGE in cel('script')) {
    defer = function (id) {
      html.appendChild(cel('script'))[ONREADYSTATECHANGE] = function () {
        html.removeChild(this);
        run.call(id);
      };
    };
  // Rest old browsers
  } else {
    defer = function (id) {
      setTimeout(ctx(run, id, 1), 0);
    };
  }
}
module.exports = {
  set: setTask,
  clear: clearTask
};


/***/ }),
/* 303 */
/***/ (function(module, exports) {

module.exports = function (exec) {
  try {
    return { e: false, v: exec() };
  } catch (e) {
    return { e: true, v: e };
  }
};


/***/ }),
/* 304 */
/***/ (function(module, exports, __webpack_require__) {

var anObject = __webpack_require__(32);
var isObject = __webpack_require__(54);
var newPromiseCapability = __webpack_require__(116);

module.exports = function (C, x) {
  anObject(C);
  if (isObject(x) && x.constructor === C) return x;
  var promiseCapability = newPromiseCapability.f(C);
  var resolve = promiseCapability.resolve;
  resolve(x);
  return promiseCapability.promise;
};


/***/ }),
/* 305 */,
/* 306 */,
/* 307 */,
/* 308 */,
/* 309 */,
/* 310 */,
/* 311 */,
/* 312 */,
/* 313 */,
/* 314 */,
/* 315 */,
/* 316 */,
/* 317 */,
/* 318 */,
/* 319 */,
/* 320 */,
/* 321 */,
/* 322 */,
/* 323 */,
/* 324 */,
/* 325 */,
/* 326 */,
/* 327 */,
/* 328 */,
/* 329 */,
/* 330 */,
/* 331 */,
/* 332 */,
/* 333 */,
/* 334 */,
/* 335 */,
/* 336 */,
/* 337 */,
/* 338 */,
/* 339 */,
/* 340 */,
/* 341 */,
/* 342 */,
/* 343 */,
/* 344 */,
/* 345 */,
/* 346 */,
/* 347 */,
/* 348 */,
/* 349 */,
/* 350 */,
/* 351 */,
/* 352 */,
/* 353 */,
/* 354 */,
/* 355 */,
/* 356 */,
/* 357 */,
/* 358 */,
/* 359 */,
/* 360 */,
/* 361 */,
/* 362 */,
/* 363 */,
/* 364 */,
/* 365 */,
/* 366 */,
/* 367 */,
/* 368 */,
/* 369 */,
/* 370 */,
/* 371 */,
/* 372 */,
/* 373 */,
/* 374 */,
/* 375 */,
/* 376 */,
/* 377 */,
/* 378 */,
/* 379 */,
/* 380 */,
/* 381 */,
/* 382 */,
/* 383 */,
/* 384 */,
/* 385 */,
/* 386 */,
/* 387 */,
/* 388 */,
/* 389 */,
/* 390 */,
/* 391 */,
/* 392 */,
/* 393 */,
/* 394 */,
/* 395 */,
/* 396 */,
/* 397 */,
/* 398 */,
/* 399 */,
/* 400 */,
/* 401 */,
/* 402 */,
/* 403 */,
/* 404 */,
/* 405 */,
/* 406 */,
/* 407 */,
/* 408 */,
/* 409 */,
/* 410 */,
/* 411 */,
/* 412 */,
/* 413 */,
/* 414 */,
/* 415 */,
/* 416 */,
/* 417 */,
/* 418 */,
/* 419 */,
/* 420 */,
/* 421 */,
/* 422 */,
/* 423 */,
/* 424 */,
/* 425 */,
/* 426 */,
/* 427 */,
/* 428 */,
/* 429 */,
/* 430 */,
/* 431 */,
/* 432 */,
/* 433 */,
/* 434 */,
/* 435 */,
/* 436 */,
/* 437 */,
/* 438 */,
/* 439 */,
/* 440 */,
/* 441 */,
/* 442 */,
/* 443 */,
/* 444 */,
/* 445 */,
/* 446 */,
/* 447 */,
/* 448 */,
/* 449 */,
/* 450 */,
/* 451 */,
/* 452 */,
/* 453 */,
/* 454 */,
/* 455 */,
/* 456 */,
/* 457 */,
/* 458 */,
/* 459 */,
/* 460 */,
/* 461 */,
/* 462 */,
/* 463 */,
/* 464 */,
/* 465 */,
/* 466 */,
/* 467 */,
/* 468 */,
/* 469 */,
/* 470 */,
/* 471 */,
/* 472 */,
/* 473 */,
/* 474 */,
/* 475 */,
/* 476 */,
/* 477 */,
/* 478 */,
/* 479 */,
/* 480 */,
/* 481 */,
/* 482 */,
/* 483 */,
/* 484 */,
/* 485 */,
/* 486 */,
/* 487 */,
/* 488 */,
/* 489 */,
/* 490 */,
/* 491 */,
/* 492 */,
/* 493 */,
/* 494 */,
/* 495 */,
/* 496 */,
/* 497 */,
/* 498 */,
/* 499 */,
/* 500 */,
/* 501 */,
/* 502 */,
/* 503 */,
/* 504 */,
/* 505 */,
/* 506 */,
/* 507 */,
/* 508 */,
/* 509 */,
/* 510 */,
/* 511 */,
/* 512 */,
/* 513 */,
/* 514 */,
/* 515 */,
/* 516 */,
/* 517 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(518);


/***/ }),
/* 518 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_es6_promise_auto__ = __webpack_require__(520);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_es6_promise_auto___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_es6_promise_auto__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__vuex_store__ = __webpack_require__(522);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_Installer__ = __webpack_require__(564);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_Installer___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__components_Installer__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__components_InstallerFinish__ = __webpack_require__(614);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__components_InstallerFinish___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__components_InstallerFinish__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__components_Item__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__components_Item___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__components_Item__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__components_ItemCheck__ = __webpack_require__(617);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__components_ItemCheck___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5__components_ItemCheck__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__components_Help__ = __webpack_require__(622);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__components_Help___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_6__components_Help__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7_vue_ionicons_dist_ios_checkmark_circle_outline_vue__ = __webpack_require__(624);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7_vue_ionicons_dist_ios_checkmark_circle_outline_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_7_vue_ionicons_dist_ios_checkmark_circle_outline_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8_vue_ionicons_dist_ios_close_circle_outline_vue__ = __webpack_require__(627);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8_vue_ionicons_dist_ios_close_circle_outline_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_8_vue_ionicons_dist_ios_close_circle_outline_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9_vue_ionicons_dist_ios_alert_vue__ = __webpack_require__(630);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9_vue_ionicons_dist_ios_alert_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_9_vue_ionicons_dist_ios_alert_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10_prismjs__ = __webpack_require__(633);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10_prismjs___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_10_prismjs__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11_prismjs_themes_prism_okaidia_css__ = __webpack_require__(634);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11_prismjs_themes_prism_okaidia_css___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_11_prismjs_themes_prism_okaidia_css__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_12_prismjs_components_prism_clike_min_js__ = __webpack_require__(636);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_12_prismjs_components_prism_clike_min_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_12_prismjs_components_prism_clike_min_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_13_prismjs_components_prism_markup_templating_min_js__ = __webpack_require__(637);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_13_prismjs_components_prism_markup_templating_min_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_13_prismjs_components_prism_markup_templating_min_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_14_prismjs_components_prism_php_min_js__ = __webpack_require__(638);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_14_prismjs_components_prism_php_min_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_14_prismjs_components_prism_php_min_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_15_prismjs_components_prism_ini_min_js__ = __webpack_require__(639);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_15_prismjs_components_prism_ini_min_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_15_prismjs_components_prism_ini_min_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_16_prismjs_components_prism_javascript_min_js__ = __webpack_require__(640);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_16_prismjs_components_prism_javascript_min_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_16_prismjs_components_prism_javascript_min_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_17_prismjs_components_prism_bash_min_js__ = __webpack_require__(641);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_17_prismjs_components_prism_bash_min_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_17_prismjs_components_prism_bash_min_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_18_prismjs_plugins_normalize_whitespace_prism_normalize_whitespace_js__ = __webpack_require__(642);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_18_prismjs_plugins_normalize_whitespace_prism_normalize_whitespace_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_18_prismjs_plugins_normalize_whitespace_prism_normalize_whitespace_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_19_prismjs_plugins_line_numbers_prism_line_numbers_js__ = __webpack_require__(643);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_19_prismjs_plugins_line_numbers_prism_line_numbers_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_19_prismjs_plugins_line_numbers_prism_line_numbers_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_20_prismjs_plugins_line_numbers_prism_line_numbers_css__ = __webpack_require__(644);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_20_prismjs_plugins_line_numbers_prism_line_numbers_css___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_20_prismjs_plugins_line_numbers_prism_line_numbers_css__);
window.Vue = __webpack_require__(9);

var VueScrollactive = __webpack_require__(519);
Vue.use(VueScrollactive);





window.axios = __webpack_require__(71);

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

var token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.$bus = new Vue();


Vue.component('devise-installer', __WEBPACK_IMPORTED_MODULE_2__components_Installer___default.a);


Vue.component('installer-finish', __WEBPACK_IMPORTED_MODULE_3__components_InstallerFinish___default.a);


Vue.component('devise-installer-item', __WEBPACK_IMPORTED_MODULE_4__components_Item___default.a);


Vue.component('item-check', __WEBPACK_IMPORTED_MODULE_5__components_ItemCheck___default.a);


Vue.component('help', __WEBPACK_IMPORTED_MODULE_6__components_Help___default.a);


Vue.component('checkmark-icon', __WEBPACK_IMPORTED_MODULE_7_vue_ionicons_dist_ios_checkmark_circle_outline_vue___default.a);


Vue.component('close-circle-icon', __WEBPACK_IMPORTED_MODULE_8_vue_ionicons_dist_ios_close_circle_outline_vue___default.a);


Vue.component('alert-icon', __WEBPACK_IMPORTED_MODULE_9_vue_ionicons_dist_ios_alert_vue___default.a);










// var loadComponents = require('prismjs/components/index.js');
// loadComponents(['ini', 'javascript', 'bash', 'php']);





__WEBPACK_IMPORTED_MODULE_10_prismjs___default.a.highlightAll();

__WEBPACK_IMPORTED_MODULE_10_prismjs___default.a.plugins.NormalizeWhitespace.setDefaults({
  'remove-trailing': true,
  'remove-indent': true,
  'left-trim': true,
  'right-trim': true
  /*'break-lines': 80,
  'indent': 2,
  'remove-initial-line-feed': false,
  'tabs-to-spaces': 4,
  'spaces-to-tabs': 4*/
});

new Vue({
  el: '#installer-app',
  store: __WEBPACK_IMPORTED_MODULE_1__vuex_store__["a" /* default */]
});

/***/ }),
/* 519 */
/***/ (function(module, exports, __webpack_require__) {

!function(t,e){ true?module.exports=e():"function"==typeof define&&define.amd?define([],e):"object"==typeof exports?exports["vue-scrollactive"]=e():t.vueScrollactive=e()}(window,function(){return function(t){var e={};function n(r){if(e[r])return e[r].exports;var i=e[r]={i:r,l:!1,exports:{}};return t[r].call(i.exports,i,i.exports,n),i.l=!0,i.exports}return n.m=t,n.c=e,n.d=function(t,e,r){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:r})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var i in t)n.d(r,i,function(e){return t[e]}.bind(null,i));return r},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="/dist/",n(n.s=1)}([function(t,e){var n=4,r=.001,i=1e-7,o=10,s=11,l=1/(s-1),a="function"==typeof Float32Array;function c(t,e){return 1-3*e+3*t}function u(t,e){return 3*e-6*t}function f(t){return 3*t}function d(t,e,n){return((c(e,n)*t+u(e,n))*t+f(e))*t}function v(t,e,n){return 3*c(e,n)*t*t+2*u(e,n)*t+f(e)}t.exports=function(t,e,c,u){if(!(0<=t&&t<=1&&0<=c&&c<=1))throw new Error("bezier x values must be in [0, 1] range");var f=a?new Float32Array(s):new Array(s);if(t!==e||c!==u)for(var h=0;h<s;++h)f[h]=d(h*l,t,c);function m(e){for(var a=0,u=1,h=s-1;u!==h&&f[u]<=e;++u)a+=l;var m=a+(e-f[--u])/(f[u+1]-f[u])*l,p=v(m,t,c);return p>=r?function(t,e,r,i){for(var o=0;o<n;++o){var s=v(e,r,i);if(0===s)return e;e-=(d(e,r,i)-t)/s}return e}(e,m,t,c):0===p?m:function(t,e,n,r,s){var l,a,c=0;do{(l=d(a=e+(n-e)/2,r,s)-t)>0?n=a:e=a}while(Math.abs(l)>i&&++c<o);return a}(e,a,a+l,t,c)}return function(n){return t===e&&c===u?n:0===n?0:1===n?1:d(m(n),e,u)}}},function(t,e,n){t.exports=n(2)},function(t,e,n){"use strict";n.r(e);var r=function(){var t=this.$createElement;return(this._self._c||t)("nav",{ref:"scrollactive-nav-wrapper",staticClass:"scrollactive-nav"},[this._t("default")],2)};r._withStripped=!0;var i=n(0),o=n.n(i);function s(t){return function(t){if(Array.isArray(t)){for(var e=0,n=new Array(t.length);e<t.length;e++)n[e]=t[e];return n}}(t)||function(t){if(Symbol.iterator in Object(t)||"[object Arguments]"===Object.prototype.toString.call(t))return Array.from(t)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance")}()}var l=function(t,e,n,r,i,o,s,l){var a,c="function"==typeof t?t.options:t;if(e&&(c.render=e,c.staticRenderFns=n,c._compiled=!0),r&&(c.functional=!0),o&&(c._scopeId="data-v-"+o),s?(a=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),i&&i.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(s)},c._ssrRegister=a):i&&(a=l?function(){i.call(this,this.$root.$options.shadowRoot)}:i),a)if(c.functional){c._injectStyles=a;var u=c.render;c.render=function(t,e){return a.call(e),u(t,e)}}else{var f=c.beforeCreate;c.beforeCreate=f?[].concat(f,a):[a]}return{exports:t,options:c}}({props:{activeClass:{type:String,default:"is-active"},offset:{type:Number,default:20},scrollContainerSelector:{type:String,default:""},clickToScroll:{type:Boolean,default:!0},duration:{type:Number,default:600},alwaysTrack:{type:Boolean,default:!1},bezierEasingValue:{type:String,default:".5,0,.35,1"},modifyUrl:{type:Boolean,default:!0},exact:{type:Boolean,default:!1}},data:function(){return{observer:null,items:[],currentItem:null,lastActiveItem:null,scrollAnimationFrame:null,bezierEasing:o.a}},computed:{cubicBezierArray:function(){return this.bezierEasingValue.split(",")},scrollContainer:function(){var t=window;return this.scrollContainerSelector&&(t=document.querySelector(this.scrollContainerSelector)||window),t}},mounted:function(){var t=window.MutationObserver||window.WebKitMutationObserver;this.observer||(this.observer=new t(this.initScrollactiveItems),this.observer.observe(this.$refs["scrollactive-nav-wrapper"],{childList:!0,subtree:!0})),this.initScrollactiveItems(),this.removeActiveClass(),this.currentItem=this.getItemInsideWindow(),this.currentItem&&this.currentItem.classList.add(this.activeClass),this.scrollContainer.addEventListener("scroll",this.onScroll)},updated:function(){this.initScrollactiveItems()},beforeDestroy:function(){this.scrollContainer.removeEventListener("scroll",this.onScroll),window.cancelAnimationFrame(this.scrollAnimationFrame)},methods:{onScroll:function(t){this.currentItem=this.getItemInsideWindow(),this.currentItem!==this.lastActiveItem&&(this.removeActiveClass(),this.$emit("itemchanged",t,this.currentItem,this.lastActiveItem),this.lastActiveItem=this.currentItem),this.currentItem&&this.currentItem.classList.add(this.activeClass)},getItemInsideWindow:function(){var t,e=this;return[].forEach.call(this.items,function(n){var r=document.getElementById(n.hash.substr(1));if(r){var i=e.scrollContainer.scrollTop||window.pageYOffset,o=i>=e.getOffsetTop(r)-e.offset,s=i<e.getOffsetTop(r)-e.offset+r.offsetHeight;e.exact&&o&&s&&(t=n),!e.exact&&o&&(t=n)}}),t},initScrollactiveItems:function(){var t=this;this.items=this.$el.querySelectorAll(".scrollactive-item"),this.clickToScroll?[].forEach.call(this.items,function(e){e.addEventListener("click",t.handleClick)}):[].forEach.call(this.items,function(e){e.removeEventListener("click",t.handleClick)})},setScrollactiveItems:function(){this.initScrollactiveItems()},handleClick:function(t){var e=this;t.preventDefault();var n=t.currentTarget.hash,r=document.getElementById(n.substr(1));r?(this.alwaysTrack||(this.scrollContainer.removeEventListener("scroll",this.onScroll),window.cancelAnimationFrame(this.scrollAnimationFrame),this.removeActiveClass(),t.currentTarget.classList.add(this.activeClass)),this.scrollTo(r).then(function(){e.modifyUrl&&(window.history.pushState?window.history.pushState(null,null,n):window.location.hash=n)})):console.warn("[vue-scrollactive] Element '".concat(n,"' was not found. Make sure it is set in the DOM."))},scrollTo:function(t){var e=this;return new Promise(function(n){var r=e.getOffsetTop(t),i=e.scrollContainer.scrollTop||window.pageYOffset,o=r-i,l=e.bezierEasing.apply(e,s(e.cubicBezierArray)),a=null;window.requestAnimationFrame(function t(r){a||(a=r);var s=r-a,c=s/e.duration;s>=e.duration&&(s=e.duration),c>=1&&(c=1);var u=i+l(c)*(o-e.offset);e.scrollContainer.scrollTo(0,u),s<e.duration?e.scrollAnimationFrame=window.requestAnimationFrame(t):(e.scrollContainer.addEventListener("scroll",e.onScroll),n())})})},getOffsetTop:function(t){for(var e=0,n=t;n;)e+=n.offsetTop,n=n.offsetParent;return this.scrollContainer.offsetTop&&(e-=this.scrollContainer.offsetTop),e},removeActiveClass:function(){var t=this;[].forEach.call(this.items,function(e){e.classList.remove(t.activeClass)})}}},r,[],!1,null,null,null);l.options.__file="src/scrollactive.vue";var a=l.exports,c={install:function(t){c.install.installed||t.component("scrollactive",a)}};"undefined"!=typeof window&&window.Vue&&c.install(window.Vue);e.default=c}])});

/***/ }),
/* 520 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
// This file can be required in Browserify and Node.js for automatic polyfill
// To use it:  require('es6-promise/auto');

module.exports = __webpack_require__(521).polyfill();


/***/ }),
/* 521 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(process, global) {/*!
 * @overview es6-promise - a tiny implementation of Promises/A+.
 * @copyright Copyright (c) 2014 Yehuda Katz, Tom Dale, Stefan Penner and contributors (Conversion to ES6 API by Jake Archibald)
 * @license   Licensed under MIT license
 *            See https://raw.githubusercontent.com/stefanpenner/es6-promise/master/LICENSE
 * @version   v4.2.5+7f2b526d
 */

(function (global, factory) {
	 true ? module.exports = factory() :
	typeof define === 'function' && define.amd ? define(factory) :
	(global.ES6Promise = factory());
}(this, (function () { 'use strict';

function objectOrFunction(x) {
  var type = typeof x;
  return x !== null && (type === 'object' || type === 'function');
}

function isFunction(x) {
  return typeof x === 'function';
}



var _isArray = void 0;
if (Array.isArray) {
  _isArray = Array.isArray;
} else {
  _isArray = function (x) {
    return Object.prototype.toString.call(x) === '[object Array]';
  };
}

var isArray = _isArray;

var len = 0;
var vertxNext = void 0;
var customSchedulerFn = void 0;

var asap = function asap(callback, arg) {
  queue[len] = callback;
  queue[len + 1] = arg;
  len += 2;
  if (len === 2) {
    // If len is 2, that means that we need to schedule an async flush.
    // If additional callbacks are queued before the queue is flushed, they
    // will be processed by this flush that we are scheduling.
    if (customSchedulerFn) {
      customSchedulerFn(flush);
    } else {
      scheduleFlush();
    }
  }
};

function setScheduler(scheduleFn) {
  customSchedulerFn = scheduleFn;
}

function setAsap(asapFn) {
  asap = asapFn;
}

var browserWindow = typeof window !== 'undefined' ? window : undefined;
var browserGlobal = browserWindow || {};
var BrowserMutationObserver = browserGlobal.MutationObserver || browserGlobal.WebKitMutationObserver;
var isNode = typeof self === 'undefined' && typeof process !== 'undefined' && {}.toString.call(process) === '[object process]';

// test for web worker but not in IE10
var isWorker = typeof Uint8ClampedArray !== 'undefined' && typeof importScripts !== 'undefined' && typeof MessageChannel !== 'undefined';

// node
function useNextTick() {
  // node version 0.10.x displays a deprecation warning when nextTick is used recursively
  // see https://github.com/cujojs/when/issues/410 for details
  return function () {
    return process.nextTick(flush);
  };
}

// vertx
function useVertxTimer() {
  if (typeof vertxNext !== 'undefined') {
    return function () {
      vertxNext(flush);
    };
  }

  return useSetTimeout();
}

function useMutationObserver() {
  var iterations = 0;
  var observer = new BrowserMutationObserver(flush);
  var node = document.createTextNode('');
  observer.observe(node, { characterData: true });

  return function () {
    node.data = iterations = ++iterations % 2;
  };
}

// web worker
function useMessageChannel() {
  var channel = new MessageChannel();
  channel.port1.onmessage = flush;
  return function () {
    return channel.port2.postMessage(0);
  };
}

function useSetTimeout() {
  // Store setTimeout reference so es6-promise will be unaffected by
  // other code modifying setTimeout (like sinon.useFakeTimers())
  var globalSetTimeout = setTimeout;
  return function () {
    return globalSetTimeout(flush, 1);
  };
}

var queue = new Array(1000);
function flush() {
  for (var i = 0; i < len; i += 2) {
    var callback = queue[i];
    var arg = queue[i + 1];

    callback(arg);

    queue[i] = undefined;
    queue[i + 1] = undefined;
  }

  len = 0;
}

function attemptVertx() {
  try {
    var vertx = Function('return this')().require('vertx');
    vertxNext = vertx.runOnLoop || vertx.runOnContext;
    return useVertxTimer();
  } catch (e) {
    return useSetTimeout();
  }
}

var scheduleFlush = void 0;
// Decide what async method to use to triggering processing of queued callbacks:
if (isNode) {
  scheduleFlush = useNextTick();
} else if (BrowserMutationObserver) {
  scheduleFlush = useMutationObserver();
} else if (isWorker) {
  scheduleFlush = useMessageChannel();
} else if (browserWindow === undefined && "function" === 'function') {
  scheduleFlush = attemptVertx();
} else {
  scheduleFlush = useSetTimeout();
}

function then(onFulfillment, onRejection) {
  var parent = this;

  var child = new this.constructor(noop);

  if (child[PROMISE_ID] === undefined) {
    makePromise(child);
  }

  var _state = parent._state;


  if (_state) {
    var callback = arguments[_state - 1];
    asap(function () {
      return invokeCallback(_state, child, callback, parent._result);
    });
  } else {
    subscribe(parent, child, onFulfillment, onRejection);
  }

  return child;
}

/**
  `Promise.resolve` returns a promise that will become resolved with the
  passed `value`. It is shorthand for the following:

  ```javascript
  let promise = new Promise(function(resolve, reject){
    resolve(1);
  });

  promise.then(function(value){
    // value === 1
  });
  ```

  Instead of writing the above, your code now simply becomes the following:

  ```javascript
  let promise = Promise.resolve(1);

  promise.then(function(value){
    // value === 1
  });
  ```

  @method resolve
  @static
  @param {Any} value value that the returned promise will be resolved with
  Useful for tooling.
  @return {Promise} a promise that will become fulfilled with the given
  `value`
*/
function resolve$1(object) {
  /*jshint validthis:true */
  var Constructor = this;

  if (object && typeof object === 'object' && object.constructor === Constructor) {
    return object;
  }

  var promise = new Constructor(noop);
  resolve(promise, object);
  return promise;
}

var PROMISE_ID = Math.random().toString(36).substring(2);

function noop() {}

var PENDING = void 0;
var FULFILLED = 1;
var REJECTED = 2;

var TRY_CATCH_ERROR = { error: null };

function selfFulfillment() {
  return new TypeError("You cannot resolve a promise with itself");
}

function cannotReturnOwn() {
  return new TypeError('A promises callback cannot return that same promise.');
}

function getThen(promise) {
  try {
    return promise.then;
  } catch (error) {
    TRY_CATCH_ERROR.error = error;
    return TRY_CATCH_ERROR;
  }
}

function tryThen(then$$1, value, fulfillmentHandler, rejectionHandler) {
  try {
    then$$1.call(value, fulfillmentHandler, rejectionHandler);
  } catch (e) {
    return e;
  }
}

function handleForeignThenable(promise, thenable, then$$1) {
  asap(function (promise) {
    var sealed = false;
    var error = tryThen(then$$1, thenable, function (value) {
      if (sealed) {
        return;
      }
      sealed = true;
      if (thenable !== value) {
        resolve(promise, value);
      } else {
        fulfill(promise, value);
      }
    }, function (reason) {
      if (sealed) {
        return;
      }
      sealed = true;

      reject(promise, reason);
    }, 'Settle: ' + (promise._label || ' unknown promise'));

    if (!sealed && error) {
      sealed = true;
      reject(promise, error);
    }
  }, promise);
}

function handleOwnThenable(promise, thenable) {
  if (thenable._state === FULFILLED) {
    fulfill(promise, thenable._result);
  } else if (thenable._state === REJECTED) {
    reject(promise, thenable._result);
  } else {
    subscribe(thenable, undefined, function (value) {
      return resolve(promise, value);
    }, function (reason) {
      return reject(promise, reason);
    });
  }
}

function handleMaybeThenable(promise, maybeThenable, then$$1) {
  if (maybeThenable.constructor === promise.constructor && then$$1 === then && maybeThenable.constructor.resolve === resolve$1) {
    handleOwnThenable(promise, maybeThenable);
  } else {
    if (then$$1 === TRY_CATCH_ERROR) {
      reject(promise, TRY_CATCH_ERROR.error);
      TRY_CATCH_ERROR.error = null;
    } else if (then$$1 === undefined) {
      fulfill(promise, maybeThenable);
    } else if (isFunction(then$$1)) {
      handleForeignThenable(promise, maybeThenable, then$$1);
    } else {
      fulfill(promise, maybeThenable);
    }
  }
}

function resolve(promise, value) {
  if (promise === value) {
    reject(promise, selfFulfillment());
  } else if (objectOrFunction(value)) {
    handleMaybeThenable(promise, value, getThen(value));
  } else {
    fulfill(promise, value);
  }
}

function publishRejection(promise) {
  if (promise._onerror) {
    promise._onerror(promise._result);
  }

  publish(promise);
}

function fulfill(promise, value) {
  if (promise._state !== PENDING) {
    return;
  }

  promise._result = value;
  promise._state = FULFILLED;

  if (promise._subscribers.length !== 0) {
    asap(publish, promise);
  }
}

function reject(promise, reason) {
  if (promise._state !== PENDING) {
    return;
  }
  promise._state = REJECTED;
  promise._result = reason;

  asap(publishRejection, promise);
}

function subscribe(parent, child, onFulfillment, onRejection) {
  var _subscribers = parent._subscribers;
  var length = _subscribers.length;


  parent._onerror = null;

  _subscribers[length] = child;
  _subscribers[length + FULFILLED] = onFulfillment;
  _subscribers[length + REJECTED] = onRejection;

  if (length === 0 && parent._state) {
    asap(publish, parent);
  }
}

function publish(promise) {
  var subscribers = promise._subscribers;
  var settled = promise._state;

  if (subscribers.length === 0) {
    return;
  }

  var child = void 0,
      callback = void 0,
      detail = promise._result;

  for (var i = 0; i < subscribers.length; i += 3) {
    child = subscribers[i];
    callback = subscribers[i + settled];

    if (child) {
      invokeCallback(settled, child, callback, detail);
    } else {
      callback(detail);
    }
  }

  promise._subscribers.length = 0;
}

function tryCatch(callback, detail) {
  try {
    return callback(detail);
  } catch (e) {
    TRY_CATCH_ERROR.error = e;
    return TRY_CATCH_ERROR;
  }
}

function invokeCallback(settled, promise, callback, detail) {
  var hasCallback = isFunction(callback),
      value = void 0,
      error = void 0,
      succeeded = void 0,
      failed = void 0;

  if (hasCallback) {
    value = tryCatch(callback, detail);

    if (value === TRY_CATCH_ERROR) {
      failed = true;
      error = value.error;
      value.error = null;
    } else {
      succeeded = true;
    }

    if (promise === value) {
      reject(promise, cannotReturnOwn());
      return;
    }
  } else {
    value = detail;
    succeeded = true;
  }

  if (promise._state !== PENDING) {
    // noop
  } else if (hasCallback && succeeded) {
    resolve(promise, value);
  } else if (failed) {
    reject(promise, error);
  } else if (settled === FULFILLED) {
    fulfill(promise, value);
  } else if (settled === REJECTED) {
    reject(promise, value);
  }
}

function initializePromise(promise, resolver) {
  try {
    resolver(function resolvePromise(value) {
      resolve(promise, value);
    }, function rejectPromise(reason) {
      reject(promise, reason);
    });
  } catch (e) {
    reject(promise, e);
  }
}

var id = 0;
function nextId() {
  return id++;
}

function makePromise(promise) {
  promise[PROMISE_ID] = id++;
  promise._state = undefined;
  promise._result = undefined;
  promise._subscribers = [];
}

function validationError() {
  return new Error('Array Methods must be provided an Array');
}

var Enumerator = function () {
  function Enumerator(Constructor, input) {
    this._instanceConstructor = Constructor;
    this.promise = new Constructor(noop);

    if (!this.promise[PROMISE_ID]) {
      makePromise(this.promise);
    }

    if (isArray(input)) {
      this.length = input.length;
      this._remaining = input.length;

      this._result = new Array(this.length);

      if (this.length === 0) {
        fulfill(this.promise, this._result);
      } else {
        this.length = this.length || 0;
        this._enumerate(input);
        if (this._remaining === 0) {
          fulfill(this.promise, this._result);
        }
      }
    } else {
      reject(this.promise, validationError());
    }
  }

  Enumerator.prototype._enumerate = function _enumerate(input) {
    for (var i = 0; this._state === PENDING && i < input.length; i++) {
      this._eachEntry(input[i], i);
    }
  };

  Enumerator.prototype._eachEntry = function _eachEntry(entry, i) {
    var c = this._instanceConstructor;
    var resolve$$1 = c.resolve;


    if (resolve$$1 === resolve$1) {
      var _then = getThen(entry);

      if (_then === then && entry._state !== PENDING) {
        this._settledAt(entry._state, i, entry._result);
      } else if (typeof _then !== 'function') {
        this._remaining--;
        this._result[i] = entry;
      } else if (c === Promise$1) {
        var promise = new c(noop);
        handleMaybeThenable(promise, entry, _then);
        this._willSettleAt(promise, i);
      } else {
        this._willSettleAt(new c(function (resolve$$1) {
          return resolve$$1(entry);
        }), i);
      }
    } else {
      this._willSettleAt(resolve$$1(entry), i);
    }
  };

  Enumerator.prototype._settledAt = function _settledAt(state, i, value) {
    var promise = this.promise;


    if (promise._state === PENDING) {
      this._remaining--;

      if (state === REJECTED) {
        reject(promise, value);
      } else {
        this._result[i] = value;
      }
    }

    if (this._remaining === 0) {
      fulfill(promise, this._result);
    }
  };

  Enumerator.prototype._willSettleAt = function _willSettleAt(promise, i) {
    var enumerator = this;

    subscribe(promise, undefined, function (value) {
      return enumerator._settledAt(FULFILLED, i, value);
    }, function (reason) {
      return enumerator._settledAt(REJECTED, i, reason);
    });
  };

  return Enumerator;
}();

/**
  `Promise.all` accepts an array of promises, and returns a new promise which
  is fulfilled with an array of fulfillment values for the passed promises, or
  rejected with the reason of the first passed promise to be rejected. It casts all
  elements of the passed iterable to promises as it runs this algorithm.

  Example:

  ```javascript
  let promise1 = resolve(1);
  let promise2 = resolve(2);
  let promise3 = resolve(3);
  let promises = [ promise1, promise2, promise3 ];

  Promise.all(promises).then(function(array){
    // The array here would be [ 1, 2, 3 ];
  });
  ```

  If any of the `promises` given to `all` are rejected, the first promise
  that is rejected will be given as an argument to the returned promises's
  rejection handler. For example:

  Example:

  ```javascript
  let promise1 = resolve(1);
  let promise2 = reject(new Error("2"));
  let promise3 = reject(new Error("3"));
  let promises = [ promise1, promise2, promise3 ];

  Promise.all(promises).then(function(array){
    // Code here never runs because there are rejected promises!
  }, function(error) {
    // error.message === "2"
  });
  ```

  @method all
  @static
  @param {Array} entries array of promises
  @param {String} label optional string for labeling the promise.
  Useful for tooling.
  @return {Promise} promise that is fulfilled when all `promises` have been
  fulfilled, or rejected if any of them become rejected.
  @static
*/
function all(entries) {
  return new Enumerator(this, entries).promise;
}

/**
  `Promise.race` returns a new promise which is settled in the same way as the
  first passed promise to settle.

  Example:

  ```javascript
  let promise1 = new Promise(function(resolve, reject){
    setTimeout(function(){
      resolve('promise 1');
    }, 200);
  });

  let promise2 = new Promise(function(resolve, reject){
    setTimeout(function(){
      resolve('promise 2');
    }, 100);
  });

  Promise.race([promise1, promise2]).then(function(result){
    // result === 'promise 2' because it was resolved before promise1
    // was resolved.
  });
  ```

  `Promise.race` is deterministic in that only the state of the first
  settled promise matters. For example, even if other promises given to the
  `promises` array argument are resolved, but the first settled promise has
  become rejected before the other promises became fulfilled, the returned
  promise will become rejected:

  ```javascript
  let promise1 = new Promise(function(resolve, reject){
    setTimeout(function(){
      resolve('promise 1');
    }, 200);
  });

  let promise2 = new Promise(function(resolve, reject){
    setTimeout(function(){
      reject(new Error('promise 2'));
    }, 100);
  });

  Promise.race([promise1, promise2]).then(function(result){
    // Code here never runs
  }, function(reason){
    // reason.message === 'promise 2' because promise 2 became rejected before
    // promise 1 became fulfilled
  });
  ```

  An example real-world use case is implementing timeouts:

  ```javascript
  Promise.race([ajax('foo.json'), timeout(5000)])
  ```

  @method race
  @static
  @param {Array} promises array of promises to observe
  Useful for tooling.
  @return {Promise} a promise which settles in the same way as the first passed
  promise to settle.
*/
function race(entries) {
  /*jshint validthis:true */
  var Constructor = this;

  if (!isArray(entries)) {
    return new Constructor(function (_, reject) {
      return reject(new TypeError('You must pass an array to race.'));
    });
  } else {
    return new Constructor(function (resolve, reject) {
      var length = entries.length;
      for (var i = 0; i < length; i++) {
        Constructor.resolve(entries[i]).then(resolve, reject);
      }
    });
  }
}

/**
  `Promise.reject` returns a promise rejected with the passed `reason`.
  It is shorthand for the following:

  ```javascript
  let promise = new Promise(function(resolve, reject){
    reject(new Error('WHOOPS'));
  });

  promise.then(function(value){
    // Code here doesn't run because the promise is rejected!
  }, function(reason){
    // reason.message === 'WHOOPS'
  });
  ```

  Instead of writing the above, your code now simply becomes the following:

  ```javascript
  let promise = Promise.reject(new Error('WHOOPS'));

  promise.then(function(value){
    // Code here doesn't run because the promise is rejected!
  }, function(reason){
    // reason.message === 'WHOOPS'
  });
  ```

  @method reject
  @static
  @param {Any} reason value that the returned promise will be rejected with.
  Useful for tooling.
  @return {Promise} a promise rejected with the given `reason`.
*/
function reject$1(reason) {
  /*jshint validthis:true */
  var Constructor = this;
  var promise = new Constructor(noop);
  reject(promise, reason);
  return promise;
}

function needsResolver() {
  throw new TypeError('You must pass a resolver function as the first argument to the promise constructor');
}

function needsNew() {
  throw new TypeError("Failed to construct 'Promise': Please use the 'new' operator, this object constructor cannot be called as a function.");
}

/**
  Promise objects represent the eventual result of an asynchronous operation. The
  primary way of interacting with a promise is through its `then` method, which
  registers callbacks to receive either a promise's eventual value or the reason
  why the promise cannot be fulfilled.

  Terminology
  -----------

  - `promise` is an object or function with a `then` method whose behavior conforms to this specification.
  - `thenable` is an object or function that defines a `then` method.
  - `value` is any legal JavaScript value (including undefined, a thenable, or a promise).
  - `exception` is a value that is thrown using the throw statement.
  - `reason` is a value that indicates why a promise was rejected.
  - `settled` the final resting state of a promise, fulfilled or rejected.

  A promise can be in one of three states: pending, fulfilled, or rejected.

  Promises that are fulfilled have a fulfillment value and are in the fulfilled
  state.  Promises that are rejected have a rejection reason and are in the
  rejected state.  A fulfillment value is never a thenable.

  Promises can also be said to *resolve* a value.  If this value is also a
  promise, then the original promise's settled state will match the value's
  settled state.  So a promise that *resolves* a promise that rejects will
  itself reject, and a promise that *resolves* a promise that fulfills will
  itself fulfill.


  Basic Usage:
  ------------

  ```js
  let promise = new Promise(function(resolve, reject) {
    // on success
    resolve(value);

    // on failure
    reject(reason);
  });

  promise.then(function(value) {
    // on fulfillment
  }, function(reason) {
    // on rejection
  });
  ```

  Advanced Usage:
  ---------------

  Promises shine when abstracting away asynchronous interactions such as
  `XMLHttpRequest`s.

  ```js
  function getJSON(url) {
    return new Promise(function(resolve, reject){
      let xhr = new XMLHttpRequest();

      xhr.open('GET', url);
      xhr.onreadystatechange = handler;
      xhr.responseType = 'json';
      xhr.setRequestHeader('Accept', 'application/json');
      xhr.send();

      function handler() {
        if (this.readyState === this.DONE) {
          if (this.status === 200) {
            resolve(this.response);
          } else {
            reject(new Error('getJSON: `' + url + '` failed with status: [' + this.status + ']'));
          }
        }
      };
    });
  }

  getJSON('/posts.json').then(function(json) {
    // on fulfillment
  }, function(reason) {
    // on rejection
  });
  ```

  Unlike callbacks, promises are great composable primitives.

  ```js
  Promise.all([
    getJSON('/posts'),
    getJSON('/comments')
  ]).then(function(values){
    values[0] // => postsJSON
    values[1] // => commentsJSON

    return values;
  });
  ```

  @class Promise
  @param {Function} resolver
  Useful for tooling.
  @constructor
*/

var Promise$1 = function () {
  function Promise(resolver) {
    this[PROMISE_ID] = nextId();
    this._result = this._state = undefined;
    this._subscribers = [];

    if (noop !== resolver) {
      typeof resolver !== 'function' && needsResolver();
      this instanceof Promise ? initializePromise(this, resolver) : needsNew();
    }
  }

  /**
  The primary way of interacting with a promise is through its `then` method,
  which registers callbacks to receive either a promise's eventual value or the
  reason why the promise cannot be fulfilled.
   ```js
  findUser().then(function(user){
    // user is available
  }, function(reason){
    // user is unavailable, and you are given the reason why
  });
  ```
   Chaining
  --------
   The return value of `then` is itself a promise.  This second, 'downstream'
  promise is resolved with the return value of the first promise's fulfillment
  or rejection handler, or rejected if the handler throws an exception.
   ```js
  findUser().then(function (user) {
    return user.name;
  }, function (reason) {
    return 'default name';
  }).then(function (userName) {
    // If `findUser` fulfilled, `userName` will be the user's name, otherwise it
    // will be `'default name'`
  });
   findUser().then(function (user) {
    throw new Error('Found user, but still unhappy');
  }, function (reason) {
    throw new Error('`findUser` rejected and we're unhappy');
  }).then(function (value) {
    // never reached
  }, function (reason) {
    // if `findUser` fulfilled, `reason` will be 'Found user, but still unhappy'.
    // If `findUser` rejected, `reason` will be '`findUser` rejected and we're unhappy'.
  });
  ```
  If the downstream promise does not specify a rejection handler, rejection reasons will be propagated further downstream.
   ```js
  findUser().then(function (user) {
    throw new PedagogicalException('Upstream error');
  }).then(function (value) {
    // never reached
  }).then(function (value) {
    // never reached
  }, function (reason) {
    // The `PedgagocialException` is propagated all the way down to here
  });
  ```
   Assimilation
  ------------
   Sometimes the value you want to propagate to a downstream promise can only be
  retrieved asynchronously. This can be achieved by returning a promise in the
  fulfillment or rejection handler. The downstream promise will then be pending
  until the returned promise is settled. This is called *assimilation*.
   ```js
  findUser().then(function (user) {
    return findCommentsByAuthor(user);
  }).then(function (comments) {
    // The user's comments are now available
  });
  ```
   If the assimliated promise rejects, then the downstream promise will also reject.
   ```js
  findUser().then(function (user) {
    return findCommentsByAuthor(user);
  }).then(function (comments) {
    // If `findCommentsByAuthor` fulfills, we'll have the value here
  }, function (reason) {
    // If `findCommentsByAuthor` rejects, we'll have the reason here
  });
  ```
   Simple Example
  --------------
   Synchronous Example
   ```javascript
  let result;
   try {
    result = findResult();
    // success
  } catch(reason) {
    // failure
  }
  ```
   Errback Example
   ```js
  findResult(function(result, err){
    if (err) {
      // failure
    } else {
      // success
    }
  });
  ```
   Promise Example;
   ```javascript
  findResult().then(function(result){
    // success
  }, function(reason){
    // failure
  });
  ```
   Advanced Example
  --------------
   Synchronous Example
   ```javascript
  let author, books;
   try {
    author = findAuthor();
    books  = findBooksByAuthor(author);
    // success
  } catch(reason) {
    // failure
  }
  ```
   Errback Example
   ```js
   function foundBooks(books) {
   }
   function failure(reason) {
   }
   findAuthor(function(author, err){
    if (err) {
      failure(err);
      // failure
    } else {
      try {
        findBoooksByAuthor(author, function(books, err) {
          if (err) {
            failure(err);
          } else {
            try {
              foundBooks(books);
            } catch(reason) {
              failure(reason);
            }
          }
        });
      } catch(error) {
        failure(err);
      }
      // success
    }
  });
  ```
   Promise Example;
   ```javascript
  findAuthor().
    then(findBooksByAuthor).
    then(function(books){
      // found books
  }).catch(function(reason){
    // something went wrong
  });
  ```
   @method then
  @param {Function} onFulfilled
  @param {Function} onRejected
  Useful for tooling.
  @return {Promise}
  */

  /**
  `catch` is simply sugar for `then(undefined, onRejection)` which makes it the same
  as the catch block of a try/catch statement.
  ```js
  function findAuthor(){
  throw new Error('couldn't find that author');
  }
  // synchronous
  try {
  findAuthor();
  } catch(reason) {
  // something went wrong
  }
  // async with promises
  findAuthor().catch(function(reason){
  // something went wrong
  });
  ```
  @method catch
  @param {Function} onRejection
  Useful for tooling.
  @return {Promise}
  */


  Promise.prototype.catch = function _catch(onRejection) {
    return this.then(null, onRejection);
  };

  /**
    `finally` will be invoked regardless of the promise's fate just as native
    try/catch/finally behaves
  
    Synchronous example:
  
    ```js
    findAuthor() {
      if (Math.random() > 0.5) {
        throw new Error();
      }
      return new Author();
    }
  
    try {
      return findAuthor(); // succeed or fail
    } catch(error) {
      return findOtherAuther();
    } finally {
      // always runs
      // doesn't affect the return value
    }
    ```
  
    Asynchronous example:
  
    ```js
    findAuthor().catch(function(reason){
      return findOtherAuther();
    }).finally(function(){
      // author was either found, or not
    });
    ```
  
    @method finally
    @param {Function} callback
    @return {Promise}
  */


  Promise.prototype.finally = function _finally(callback) {
    var promise = this;
    var constructor = promise.constructor;

    if (isFunction(callback)) {
      return promise.then(function (value) {
        return constructor.resolve(callback()).then(function () {
          return value;
        });
      }, function (reason) {
        return constructor.resolve(callback()).then(function () {
          throw reason;
        });
      });
    }

    return promise.then(callback, callback);
  };

  return Promise;
}();

Promise$1.prototype.then = then;
Promise$1.all = all;
Promise$1.race = race;
Promise$1.resolve = resolve$1;
Promise$1.reject = reject$1;
Promise$1._setScheduler = setScheduler;
Promise$1._setAsap = setAsap;
Promise$1._asap = asap;

/*global self*/
function polyfill() {
  var local = void 0;

  if (typeof global !== 'undefined') {
    local = global;
  } else if (typeof self !== 'undefined') {
    local = self;
  } else {
    try {
      local = Function('return this')();
    } catch (e) {
      throw new Error('polyfill failed because global object is unavailable in this environment');
    }
  }

  var P = local.Promise;

  if (P) {
    var promiseToString = null;
    try {
      promiseToString = Object.prototype.toString.call(P.resolve());
    } catch (e) {
      // silently ignored
    }

    if (promiseToString === '[object Promise]' && !P.cast) {
      return;
    }
  }

  local.Promise = Promise$1;
}

// Strange compat..
Promise$1.polyfill = polyfill;
Promise$1.Promise = Promise$1;

return Promise$1;

})));



//# sourceMappingURL=es6-promise.map

/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(28), __webpack_require__(12)))

/***/ }),
/* 522 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue__ = __webpack_require__(9);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vuex__ = __webpack_require__(35);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__mutations__ = __webpack_require__(523);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__actions__ = __webpack_require__(534);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__getters__ = __webpack_require__(563);






__WEBPACK_IMPORTED_MODULE_0_vue___default.a.use(__WEBPACK_IMPORTED_MODULE_1_vuex__["a" /* default */]);

// root state object.
// each Vuex instance is just a single state tree.
var state = {
  // Application State
  api: {
    baseUrl: '/api/devise/'
  },
  checklist: {
    database: false,
    migrations: false,
    auth: false,
    user: false,
    site: false,
    page: false,
    image_library: false,
    image_optimization: {
      jpegoptim: false,
      optipng: false,
      pngquant: false,
      svgo: false,
      gifsicle: false
    }
  },
  languages: {
    data: []
  }
};

// A Vuex instance is created by combining the state, the actions,
// and the mutations. Because the actions and mutations are just
// functions that do not depend on the instance itself, they can
// be easily tested or even hot-reloaded (see counter-hot example).
//
// You can also provide middlewares, which is just an array of
// objects containing some hooks to be called at initialization
// and after each mutation.
/* harmony default export */ __webpack_exports__["a"] = (new __WEBPACK_IMPORTED_MODULE_1_vuex__["a" /* default */].Store({
  state: state,
  mutations: __WEBPACK_IMPORTED_MODULE_2__mutations__["a" /* default */],
  actions: __WEBPACK_IMPORTED_MODULE_3__actions__["a" /* default */],
  getters: __WEBPACK_IMPORTED_MODULE_4__getters__["a" /* default */]
}));

/***/ }),
/* 523 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign__ = __webpack_require__(289);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign__);

/* harmony default export */ __webpack_exports__["a"] = ({
  // Checklist
  updateChecklist: function updateChecklist(state, checklist) {
    state.checklist = __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign___default()({}, state.checklist, checklist);
  },


  // Languages
  setLanguages: function setLanguages(state, payload) {
    state.languages = payload;
  }
});

/***/ }),
/* 524 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(525);
module.exports = __webpack_require__(25).Object.assign;


/***/ }),
/* 525 */
/***/ (function(module, exports, __webpack_require__) {

// 19.1.3.1 Object.assign(target, source)
var $export = __webpack_require__(53);

$export($export.S + $export.F, 'Object', { assign: __webpack_require__(528) });


/***/ }),
/* 526 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = !__webpack_require__(55) && !__webpack_require__(108)(function () {
  return Object.defineProperty(__webpack_require__(109)('div'), 'a', { get: function () { return 7; } }).a != 7;
});


/***/ }),
/* 527 */
/***/ (function(module, exports, __webpack_require__) {

// 7.1.1 ToPrimitive(input [, PreferredType])
var isObject = __webpack_require__(54);
// instead of the ES6 spec version, we didn't implement @@toPrimitive case
// and the second argument - flag - preferred type is a string
module.exports = function (it, S) {
  if (!isObject(it)) return it;
  var fn, val;
  if (S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it))) return val;
  if (typeof (fn = it.valueOf) == 'function' && !isObject(val = fn.call(it))) return val;
  if (!S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it))) return val;
  throw TypeError("Can't convert object to primitive value");
};


/***/ }),
/* 528 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

// 19.1.2.1 Object.assign(target, source, ...)
var getKeys = __webpack_require__(291);
var gOPS = __webpack_require__(532);
var pIE = __webpack_require__(533);
var toObject = __webpack_require__(297);
var IObject = __webpack_require__(292);
var $assign = Object.assign;

// should work with symbols and should have deterministic property order (V8 bug)
module.exports = !$assign || __webpack_require__(108)(function () {
  var A = {};
  var B = {};
  // eslint-disable-next-line no-undef
  var S = Symbol();
  var K = 'abcdefghijklmnopqrst';
  A[S] = 7;
  K.split('').forEach(function (k) { B[k] = k; });
  return $assign({}, A)[S] != 7 || Object.keys($assign({}, B)).join('') != K;
}) ? function assign(target, source) { // eslint-disable-line no-unused-vars
  var T = toObject(target);
  var aLen = arguments.length;
  var index = 1;
  var getSymbols = gOPS.f;
  var isEnum = pIE.f;
  while (aLen > index) {
    var S = IObject(arguments[index++]);
    var keys = getSymbols ? getKeys(S).concat(getSymbols(S)) : getKeys(S);
    var length = keys.length;
    var j = 0;
    var key;
    while (length > j) if (isEnum.call(S, key = keys[j++])) T[key] = S[key];
  } return T;
} : $assign;


/***/ }),
/* 529 */
/***/ (function(module, exports, __webpack_require__) {

var has = __webpack_require__(68);
var toIObject = __webpack_require__(110);
var arrayIndexOf = __webpack_require__(530)(false);
var IE_PROTO = __webpack_require__(113)('IE_PROTO');

module.exports = function (object, names) {
  var O = toIObject(object);
  var i = 0;
  var result = [];
  var key;
  for (key in O) if (key != IE_PROTO) has(O, key) && result.push(key);
  // Don't enum bug & hidden keys
  while (names.length > i) if (has(O, key = names[i++])) {
    ~arrayIndexOf(result, key) || result.push(key);
  }
  return result;
};


/***/ }),
/* 530 */
/***/ (function(module, exports, __webpack_require__) {

// false -> Array#indexOf
// true  -> Array#includes
var toIObject = __webpack_require__(110);
var toLength = __webpack_require__(293);
var toAbsoluteIndex = __webpack_require__(531);
module.exports = function (IS_INCLUDES) {
  return function ($this, el, fromIndex) {
    var O = toIObject($this);
    var length = toLength(O.length);
    var index = toAbsoluteIndex(fromIndex, length);
    var value;
    // Array#includes uses SameValueZero equality algorithm
    // eslint-disable-next-line no-self-compare
    if (IS_INCLUDES && el != el) while (length > index) {
      value = O[index++];
      // eslint-disable-next-line no-self-compare
      if (value != value) return true;
    // Array#indexOf ignores holes, Array#includes - not
    } else for (;length > index; index++) if (IS_INCLUDES || index in O) {
      if (O[index] === el) return IS_INCLUDES || index || 0;
    } return !IS_INCLUDES && -1;
  };
};


/***/ }),
/* 531 */
/***/ (function(module, exports, __webpack_require__) {

var toInteger = __webpack_require__(112);
var max = Math.max;
var min = Math.min;
module.exports = function (index, length) {
  index = toInteger(index);
  return index < 0 ? max(index + length, 0) : min(index, length);
};


/***/ }),
/* 532 */
/***/ (function(module, exports) {

exports.f = Object.getOwnPropertySymbols;


/***/ }),
/* 533 */
/***/ (function(module, exports) {

exports.f = {}.propertyIsEnumerable;


/***/ }),
/* 534 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_promise__ = __webpack_require__(535);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_promise___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_promise__);

var actions = {
  // Checklist
  refreshChecklist: function refreshChecklist(context) {
    return new __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_promise___default.a(function (resolve, reject) {
      window.axios.get(context.state.api.baseUrl + 'install-checklist/').then(function (response) {
        context.commit('updateChecklist', response.data);
        resolve(response);
      }).catch(function (error) {
        console.log('error in retrieving checklist');
      });
    }).catch(function (error) {
      console.log('error in retrieving checklist');
    });
  },


  // Install Complete
  completeInstall: function completeInstall(context) {
    return new __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_promise___default.a(function (resolve, reject) {
      window.axios.post(context.state.api.baseUrl + 'install-complete/').then(function (response) {
        resolve(response);
      }).catch(function (error) {
        console.log('error in completing the install. You can add DVS_MODE=active to your .env to manually complete');
      });
    }).catch(function (error) {
      console.log('error in completing the install.  You can add DVS_MODE=active to your .env to manually complete');
    });
  },


  // Languages
  getLanguages: function getLanguages(context) {
    return new __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_promise___default.a(function (resolve, reject) {
      window.axios.get(context.state.api.baseUrl + 'languages/').then(function (response) {
        context.commit('setLanguages', response.data);
        resolve(response);
      }).catch(function (error) {
        window.$bus.$emit('showError', error);
      });
    }).catch(function (error) {
      window.$bus.$emit('showError', error);
    });
  },
  createLanguage: function createLanguage(context, language) {
    return new __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_promise___default.a(function (resolve, reject) {
      window.axios.post(context.state.api.baseUrl + 'languages/', language).then(function (response) {
        window.$bus.$emit('showMessage', {
          content: 'Your new language has been added.'
        });
        context.commit('createLanguage', response.data);
        resolve(response);
      }).catch(function (error) {
        window.$bus.$emit('showError', error);
      });
    }).catch(function (error) {
      window.$bus.$emit('showError', error);
    });
  },


  // Pages
  createPage: function createPage(context, page) {
    return new __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_promise___default.a(function (resolve, reject) {
      window.axios.post(context.state.api.baseUrl + 'pages/', page).then(function (response) {
        window.$bus.$emit('showMessage', {
          content: page.title + ' has been created.'
        });
        context.commit('createPage', response.data.data);
        resolve(response);
      }).catch(function (error) {
        window.$bus.$emit('showError', error);
      });
    }).catch(function (error) {
      window.$bus.$emit('showError', error);
    });
  },


  // Sites
  createSite: function createSite(context, site) {
    return new __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_promise___default.a(function (resolve, reject) {
      window.axios.post(context.state.api.baseUrl + 'sites/', site).then(function (response) {
        window.$bus.$emit('showMessage', {
          content: site.name + ' has been created.'
        });
        context.commit('createSite', response.data.data);
        resolve(response);
      }).catch(function (error) {
        window.$bus.$emit('showError', error);
      });
    }).catch(function (error) {
      window.$bus.$emit('showError', error);
    });
  },


  // Users
  createUser: function createUser(context, user) {
    return new __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_promise___default.a(function (resolve, reject) {
      window.axios.post(context.state.api.baseUrl + 'users/', user).then(function (response) {
        window.$bus.$emit('showMessage', {
          content: '<strong>Step complete!</strong> ' + user.name + ' has been created.'
        });
        context.commit('createUser', response.data.data);
        resolve(response);
      }).catch(function (error) {
        window.$bus.$emit('showError', error);
      });
    }).catch(function (error) {
      window.$bus.$emit('showError', error);
    });
  }
};

/* harmony default export */ __webpack_exports__["a"] = (actions);

/***/ }),
/* 535 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = { "default": __webpack_require__(536), __esModule: true };

/***/ }),
/* 536 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(537);
__webpack_require__(538);
__webpack_require__(545);
__webpack_require__(549);
__webpack_require__(561);
__webpack_require__(562);
module.exports = __webpack_require__(25).Promise;


/***/ }),
/* 537 */
/***/ (function(module, exports) {



/***/ }),
/* 538 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $at = __webpack_require__(539)(true);

// 21.1.3.27 String.prototype[@@iterator]()
__webpack_require__(298)(String, 'String', function (iterated) {
  this._t = String(iterated); // target
  this._i = 0;                // next index
// 21.1.5.2.1 %StringIteratorPrototype%.next()
}, function () {
  var O = this._t;
  var index = this._i;
  var point;
  if (index >= O.length) return { value: undefined, done: true };
  point = $at(O, index);
  this._i += point.length;
  return { value: point, done: false };
});


/***/ }),
/* 539 */
/***/ (function(module, exports, __webpack_require__) {

var toInteger = __webpack_require__(112);
var defined = __webpack_require__(111);
// true  -> String#at
// false -> String#codePointAt
module.exports = function (TO_STRING) {
  return function (that, pos) {
    var s = String(defined(that));
    var i = toInteger(pos);
    var l = s.length;
    var a, b;
    if (i < 0 || i >= l) return TO_STRING ? '' : undefined;
    a = s.charCodeAt(i);
    return a < 0xd800 || a > 0xdbff || i + 1 === l || (b = s.charCodeAt(i + 1)) < 0xdc00 || b > 0xdfff
      ? TO_STRING ? s.charAt(i) : a
      : TO_STRING ? s.slice(i, i + 2) : (a - 0xd800 << 10) + (b - 0xdc00) + 0x10000;
  };
};


/***/ }),
/* 540 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(36);


/***/ }),
/* 541 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var create = __webpack_require__(542);
var descriptor = __webpack_require__(290);
var setToStringTag = __webpack_require__(115);
var IteratorPrototype = {};

// 25.1.2.1.1 %IteratorPrototype%[@@iterator]()
__webpack_require__(36)(IteratorPrototype, __webpack_require__(14)('iterator'), function () { return this; });

module.exports = function (Constructor, NAME, next) {
  Constructor.prototype = create(IteratorPrototype, { next: descriptor(1, next) });
  setToStringTag(Constructor, NAME + ' Iterator');
};


/***/ }),
/* 542 */
/***/ (function(module, exports, __webpack_require__) {

// 19.1.2.2 / 15.2.3.5 Object.create(O [, Properties])
var anObject = __webpack_require__(32);
var dPs = __webpack_require__(543);
var enumBugKeys = __webpack_require__(296);
var IE_PROTO = __webpack_require__(113)('IE_PROTO');
var Empty = function () { /* empty */ };
var PROTOTYPE = 'prototype';

// Create object with fake `null` prototype: use iframe Object with cleared prototype
var createDict = function () {
  // Thrash, waste and sodomy: IE GC bug
  var iframe = __webpack_require__(109)('iframe');
  var i = enumBugKeys.length;
  var lt = '<';
  var gt = '>';
  var iframeDocument;
  iframe.style.display = 'none';
  __webpack_require__(299).appendChild(iframe);
  iframe.src = 'javascript:'; // eslint-disable-line no-script-url
  // createDict = iframe.contentWindow.Object;
  // html.removeChild(iframe);
  iframeDocument = iframe.contentWindow.document;
  iframeDocument.open();
  iframeDocument.write(lt + 'script' + gt + 'document.F=Object' + lt + '/script' + gt);
  iframeDocument.close();
  createDict = iframeDocument.F;
  while (i--) delete createDict[PROTOTYPE][enumBugKeys[i]];
  return createDict();
};

module.exports = Object.create || function create(O, Properties) {
  var result;
  if (O !== null) {
    Empty[PROTOTYPE] = anObject(O);
    result = new Empty();
    Empty[PROTOTYPE] = null;
    // add "__proto__" for Object.getPrototypeOf polyfill
    result[IE_PROTO] = O;
  } else result = createDict();
  return Properties === undefined ? result : dPs(result, Properties);
};


/***/ }),
/* 543 */
/***/ (function(module, exports, __webpack_require__) {

var dP = __webpack_require__(67);
var anObject = __webpack_require__(32);
var getKeys = __webpack_require__(291);

module.exports = __webpack_require__(55) ? Object.defineProperties : function defineProperties(O, Properties) {
  anObject(O);
  var keys = getKeys(Properties);
  var length = keys.length;
  var i = 0;
  var P;
  while (length > i) dP.f(O, P = keys[i++], Properties[P]);
  return O;
};


/***/ }),
/* 544 */
/***/ (function(module, exports, __webpack_require__) {

// 19.1.2.9 / 15.2.3.2 Object.getPrototypeOf(O)
var has = __webpack_require__(68);
var toObject = __webpack_require__(297);
var IE_PROTO = __webpack_require__(113)('IE_PROTO');
var ObjectProto = Object.prototype;

module.exports = Object.getPrototypeOf || function (O) {
  O = toObject(O);
  if (has(O, IE_PROTO)) return O[IE_PROTO];
  if (typeof O.constructor == 'function' && O instanceof O.constructor) {
    return O.constructor.prototype;
  } return O instanceof Object ? ObjectProto : null;
};


/***/ }),
/* 545 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(546);
var global = __webpack_require__(11);
var hide = __webpack_require__(36);
var Iterators = __webpack_require__(56);
var TO_STRING_TAG = __webpack_require__(14)('toStringTag');

var DOMIterables = ('CSSRuleList,CSSStyleDeclaration,CSSValueList,ClientRectList,DOMRectList,DOMStringList,' +
  'DOMTokenList,DataTransferItemList,FileList,HTMLAllCollection,HTMLCollection,HTMLFormElement,HTMLSelectElement,' +
  'MediaList,MimeTypeArray,NamedNodeMap,NodeList,PaintRequestList,Plugin,PluginArray,SVGLengthList,SVGNumberList,' +
  'SVGPathSegList,SVGPointList,SVGStringList,SVGTransformList,SourceBufferList,StyleSheetList,TextTrackCueList,' +
  'TextTrackList,TouchList').split(',');

for (var i = 0; i < DOMIterables.length; i++) {
  var NAME = DOMIterables[i];
  var Collection = global[NAME];
  var proto = Collection && Collection.prototype;
  if (proto && !proto[TO_STRING_TAG]) hide(proto, TO_STRING_TAG, NAME);
  Iterators[NAME] = Iterators.Array;
}


/***/ }),
/* 546 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var addToUnscopables = __webpack_require__(547);
var step = __webpack_require__(548);
var Iterators = __webpack_require__(56);
var toIObject = __webpack_require__(110);

// 22.1.3.4 Array.prototype.entries()
// 22.1.3.13 Array.prototype.keys()
// 22.1.3.29 Array.prototype.values()
// 22.1.3.30 Array.prototype[@@iterator]()
module.exports = __webpack_require__(298)(Array, 'Array', function (iterated, kind) {
  this._t = toIObject(iterated); // target
  this._i = 0;                   // next index
  this._k = kind;                // kind
// 22.1.5.2.1 %ArrayIteratorPrototype%.next()
}, function () {
  var O = this._t;
  var kind = this._k;
  var index = this._i++;
  if (!O || index >= O.length) {
    this._t = undefined;
    return step(1);
  }
  if (kind == 'keys') return step(0, index);
  if (kind == 'values') return step(0, O[index]);
  return step(0, [index, O[index]]);
}, 'values');

// argumentsList[@@iterator] is %ArrayProto_values% (9.4.4.6, 9.4.4.7)
Iterators.Arguments = Iterators.Array;

addToUnscopables('keys');
addToUnscopables('values');
addToUnscopables('entries');


/***/ }),
/* 547 */
/***/ (function(module, exports) {

module.exports = function () { /* empty */ };


/***/ }),
/* 548 */
/***/ (function(module, exports) {

module.exports = function (done, value) {
  return { value: value, done: !!done };
};


/***/ }),
/* 549 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var LIBRARY = __webpack_require__(114);
var global = __webpack_require__(11);
var ctx = __webpack_require__(65);
var classof = __webpack_require__(300);
var $export = __webpack_require__(53);
var isObject = __webpack_require__(54);
var aFunction = __webpack_require__(66);
var anInstance = __webpack_require__(550);
var forOf = __webpack_require__(551);
var speciesConstructor = __webpack_require__(301);
var task = __webpack_require__(302).set;
var microtask = __webpack_require__(556)();
var newPromiseCapabilityModule = __webpack_require__(116);
var perform = __webpack_require__(303);
var userAgent = __webpack_require__(557);
var promiseResolve = __webpack_require__(304);
var PROMISE = 'Promise';
var TypeError = global.TypeError;
var process = global.process;
var versions = process && process.versions;
var v8 = versions && versions.v8 || '';
var $Promise = global[PROMISE];
var isNode = classof(process) == 'process';
var empty = function () { /* empty */ };
var Internal, newGenericPromiseCapability, OwnPromiseCapability, Wrapper;
var newPromiseCapability = newGenericPromiseCapability = newPromiseCapabilityModule.f;

var USE_NATIVE = !!function () {
  try {
    // correct subclassing with @@species support
    var promise = $Promise.resolve(1);
    var FakePromise = (promise.constructor = {})[__webpack_require__(14)('species')] = function (exec) {
      exec(empty, empty);
    };
    // unhandled rejections tracking support, NodeJS Promise without it fails @@species test
    return (isNode || typeof PromiseRejectionEvent == 'function')
      && promise.then(empty) instanceof FakePromise
      // v8 6.6 (Node 10 and Chrome 66) have a bug with resolving custom thenables
      // https://bugs.chromium.org/p/chromium/issues/detail?id=830565
      // we can't detect it synchronously, so just check versions
      && v8.indexOf('6.6') !== 0
      && userAgent.indexOf('Chrome/66') === -1;
  } catch (e) { /* empty */ }
}();

// helpers
var isThenable = function (it) {
  var then;
  return isObject(it) && typeof (then = it.then) == 'function' ? then : false;
};
var notify = function (promise, isReject) {
  if (promise._n) return;
  promise._n = true;
  var chain = promise._c;
  microtask(function () {
    var value = promise._v;
    var ok = promise._s == 1;
    var i = 0;
    var run = function (reaction) {
      var handler = ok ? reaction.ok : reaction.fail;
      var resolve = reaction.resolve;
      var reject = reaction.reject;
      var domain = reaction.domain;
      var result, then, exited;
      try {
        if (handler) {
          if (!ok) {
            if (promise._h == 2) onHandleUnhandled(promise);
            promise._h = 1;
          }
          if (handler === true) result = value;
          else {
            if (domain) domain.enter();
            result = handler(value); // may throw
            if (domain) {
              domain.exit();
              exited = true;
            }
          }
          if (result === reaction.promise) {
            reject(TypeError('Promise-chain cycle'));
          } else if (then = isThenable(result)) {
            then.call(result, resolve, reject);
          } else resolve(result);
        } else reject(value);
      } catch (e) {
        if (domain && !exited) domain.exit();
        reject(e);
      }
    };
    while (chain.length > i) run(chain[i++]); // variable length - can't use forEach
    promise._c = [];
    promise._n = false;
    if (isReject && !promise._h) onUnhandled(promise);
  });
};
var onUnhandled = function (promise) {
  task.call(global, function () {
    var value = promise._v;
    var unhandled = isUnhandled(promise);
    var result, handler, console;
    if (unhandled) {
      result = perform(function () {
        if (isNode) {
          process.emit('unhandledRejection', value, promise);
        } else if (handler = global.onunhandledrejection) {
          handler({ promise: promise, reason: value });
        } else if ((console = global.console) && console.error) {
          console.error('Unhandled promise rejection', value);
        }
      });
      // Browsers should not trigger `rejectionHandled` event if it was handled here, NodeJS - should
      promise._h = isNode || isUnhandled(promise) ? 2 : 1;
    } promise._a = undefined;
    if (unhandled && result.e) throw result.v;
  });
};
var isUnhandled = function (promise) {
  return promise._h !== 1 && (promise._a || promise._c).length === 0;
};
var onHandleUnhandled = function (promise) {
  task.call(global, function () {
    var handler;
    if (isNode) {
      process.emit('rejectionHandled', promise);
    } else if (handler = global.onrejectionhandled) {
      handler({ promise: promise, reason: promise._v });
    }
  });
};
var $reject = function (value) {
  var promise = this;
  if (promise._d) return;
  promise._d = true;
  promise = promise._w || promise; // unwrap
  promise._v = value;
  promise._s = 2;
  if (!promise._a) promise._a = promise._c.slice();
  notify(promise, true);
};
var $resolve = function (value) {
  var promise = this;
  var then;
  if (promise._d) return;
  promise._d = true;
  promise = promise._w || promise; // unwrap
  try {
    if (promise === value) throw TypeError("Promise can't be resolved itself");
    if (then = isThenable(value)) {
      microtask(function () {
        var wrapper = { _w: promise, _d: false }; // wrap
        try {
          then.call(value, ctx($resolve, wrapper, 1), ctx($reject, wrapper, 1));
        } catch (e) {
          $reject.call(wrapper, e);
        }
      });
    } else {
      promise._v = value;
      promise._s = 1;
      notify(promise, false);
    }
  } catch (e) {
    $reject.call({ _w: promise, _d: false }, e); // wrap
  }
};

// constructor polyfill
if (!USE_NATIVE) {
  // 25.4.3.1 Promise(executor)
  $Promise = function Promise(executor) {
    anInstance(this, $Promise, PROMISE, '_h');
    aFunction(executor);
    Internal.call(this);
    try {
      executor(ctx($resolve, this, 1), ctx($reject, this, 1));
    } catch (err) {
      $reject.call(this, err);
    }
  };
  // eslint-disable-next-line no-unused-vars
  Internal = function Promise(executor) {
    this._c = [];             // <- awaiting reactions
    this._a = undefined;      // <- checked in isUnhandled reactions
    this._s = 0;              // <- state
    this._d = false;          // <- done
    this._v = undefined;      // <- value
    this._h = 0;              // <- rejection state, 0 - default, 1 - handled, 2 - unhandled
    this._n = false;          // <- notify
  };
  Internal.prototype = __webpack_require__(558)($Promise.prototype, {
    // 25.4.5.3 Promise.prototype.then(onFulfilled, onRejected)
    then: function then(onFulfilled, onRejected) {
      var reaction = newPromiseCapability(speciesConstructor(this, $Promise));
      reaction.ok = typeof onFulfilled == 'function' ? onFulfilled : true;
      reaction.fail = typeof onRejected == 'function' && onRejected;
      reaction.domain = isNode ? process.domain : undefined;
      this._c.push(reaction);
      if (this._a) this._a.push(reaction);
      if (this._s) notify(this, false);
      return reaction.promise;
    },
    // 25.4.5.1 Promise.prototype.catch(onRejected)
    'catch': function (onRejected) {
      return this.then(undefined, onRejected);
    }
  });
  OwnPromiseCapability = function () {
    var promise = new Internal();
    this.promise = promise;
    this.resolve = ctx($resolve, promise, 1);
    this.reject = ctx($reject, promise, 1);
  };
  newPromiseCapabilityModule.f = newPromiseCapability = function (C) {
    return C === $Promise || C === Wrapper
      ? new OwnPromiseCapability(C)
      : newGenericPromiseCapability(C);
  };
}

$export($export.G + $export.W + $export.F * !USE_NATIVE, { Promise: $Promise });
__webpack_require__(115)($Promise, PROMISE);
__webpack_require__(559)(PROMISE);
Wrapper = __webpack_require__(25)[PROMISE];

// statics
$export($export.S + $export.F * !USE_NATIVE, PROMISE, {
  // 25.4.4.5 Promise.reject(r)
  reject: function reject(r) {
    var capability = newPromiseCapability(this);
    var $$reject = capability.reject;
    $$reject(r);
    return capability.promise;
  }
});
$export($export.S + $export.F * (LIBRARY || !USE_NATIVE), PROMISE, {
  // 25.4.4.6 Promise.resolve(x)
  resolve: function resolve(x) {
    return promiseResolve(LIBRARY && this === Wrapper ? $Promise : this, x);
  }
});
$export($export.S + $export.F * !(USE_NATIVE && __webpack_require__(560)(function (iter) {
  $Promise.all(iter)['catch'](empty);
})), PROMISE, {
  // 25.4.4.1 Promise.all(iterable)
  all: function all(iterable) {
    var C = this;
    var capability = newPromiseCapability(C);
    var resolve = capability.resolve;
    var reject = capability.reject;
    var result = perform(function () {
      var values = [];
      var index = 0;
      var remaining = 1;
      forOf(iterable, false, function (promise) {
        var $index = index++;
        var alreadyCalled = false;
        values.push(undefined);
        remaining++;
        C.resolve(promise).then(function (value) {
          if (alreadyCalled) return;
          alreadyCalled = true;
          values[$index] = value;
          --remaining || resolve(values);
        }, reject);
      });
      --remaining || resolve(values);
    });
    if (result.e) reject(result.v);
    return capability.promise;
  },
  // 25.4.4.4 Promise.race(iterable)
  race: function race(iterable) {
    var C = this;
    var capability = newPromiseCapability(C);
    var reject = capability.reject;
    var result = perform(function () {
      forOf(iterable, false, function (promise) {
        C.resolve(promise).then(capability.resolve, reject);
      });
    });
    if (result.e) reject(result.v);
    return capability.promise;
  }
});


/***/ }),
/* 550 */
/***/ (function(module, exports) {

module.exports = function (it, Constructor, name, forbiddenField) {
  if (!(it instanceof Constructor) || (forbiddenField !== undefined && forbiddenField in it)) {
    throw TypeError(name + ': incorrect invocation!');
  } return it;
};


/***/ }),
/* 551 */
/***/ (function(module, exports, __webpack_require__) {

var ctx = __webpack_require__(65);
var call = __webpack_require__(552);
var isArrayIter = __webpack_require__(553);
var anObject = __webpack_require__(32);
var toLength = __webpack_require__(293);
var getIterFn = __webpack_require__(554);
var BREAK = {};
var RETURN = {};
var exports = module.exports = function (iterable, entries, fn, that, ITERATOR) {
  var iterFn = ITERATOR ? function () { return iterable; } : getIterFn(iterable);
  var f = ctx(fn, that, entries ? 2 : 1);
  var index = 0;
  var length, step, iterator, result;
  if (typeof iterFn != 'function') throw TypeError(iterable + ' is not iterable!');
  // fast case for arrays with default iterator
  if (isArrayIter(iterFn)) for (length = toLength(iterable.length); length > index; index++) {
    result = entries ? f(anObject(step = iterable[index])[0], step[1]) : f(iterable[index]);
    if (result === BREAK || result === RETURN) return result;
  } else for (iterator = iterFn.call(iterable); !(step = iterator.next()).done;) {
    result = call(iterator, f, step.value, entries);
    if (result === BREAK || result === RETURN) return result;
  }
};
exports.BREAK = BREAK;
exports.RETURN = RETURN;


/***/ }),
/* 552 */
/***/ (function(module, exports, __webpack_require__) {

// call something on iterator step with safe closing on error
var anObject = __webpack_require__(32);
module.exports = function (iterator, fn, value, entries) {
  try {
    return entries ? fn(anObject(value)[0], value[1]) : fn(value);
  // 7.4.6 IteratorClose(iterator, completion)
  } catch (e) {
    var ret = iterator['return'];
    if (ret !== undefined) anObject(ret.call(iterator));
    throw e;
  }
};


/***/ }),
/* 553 */
/***/ (function(module, exports, __webpack_require__) {

// check on default Array iterator
var Iterators = __webpack_require__(56);
var ITERATOR = __webpack_require__(14)('iterator');
var ArrayProto = Array.prototype;

module.exports = function (it) {
  return it !== undefined && (Iterators.Array === it || ArrayProto[ITERATOR] === it);
};


/***/ }),
/* 554 */
/***/ (function(module, exports, __webpack_require__) {

var classof = __webpack_require__(300);
var ITERATOR = __webpack_require__(14)('iterator');
var Iterators = __webpack_require__(56);
module.exports = __webpack_require__(25).getIteratorMethod = function (it) {
  if (it != undefined) return it[ITERATOR]
    || it['@@iterator']
    || Iterators[classof(it)];
};


/***/ }),
/* 555 */
/***/ (function(module, exports) {

// fast apply, http://jsperf.lnkit.com/fast-apply/5
module.exports = function (fn, args, that) {
  var un = that === undefined;
  switch (args.length) {
    case 0: return un ? fn()
                      : fn.call(that);
    case 1: return un ? fn(args[0])
                      : fn.call(that, args[0]);
    case 2: return un ? fn(args[0], args[1])
                      : fn.call(that, args[0], args[1]);
    case 3: return un ? fn(args[0], args[1], args[2])
                      : fn.call(that, args[0], args[1], args[2]);
    case 4: return un ? fn(args[0], args[1], args[2], args[3])
                      : fn.call(that, args[0], args[1], args[2], args[3]);
  } return fn.apply(that, args);
};


/***/ }),
/* 556 */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(11);
var macrotask = __webpack_require__(302).set;
var Observer = global.MutationObserver || global.WebKitMutationObserver;
var process = global.process;
var Promise = global.Promise;
var isNode = __webpack_require__(69)(process) == 'process';

module.exports = function () {
  var head, last, notify;

  var flush = function () {
    var parent, fn;
    if (isNode && (parent = process.domain)) parent.exit();
    while (head) {
      fn = head.fn;
      head = head.next;
      try {
        fn();
      } catch (e) {
        if (head) notify();
        else last = undefined;
        throw e;
      }
    } last = undefined;
    if (parent) parent.enter();
  };

  // Node.js
  if (isNode) {
    notify = function () {
      process.nextTick(flush);
    };
  // browsers with MutationObserver, except iOS Safari - https://github.com/zloirock/core-js/issues/339
  } else if (Observer && !(global.navigator && global.navigator.standalone)) {
    var toggle = true;
    var node = document.createTextNode('');
    new Observer(flush).observe(node, { characterData: true }); // eslint-disable-line no-new
    notify = function () {
      node.data = toggle = !toggle;
    };
  // environments with maybe non-completely correct, but existent Promise
  } else if (Promise && Promise.resolve) {
    // Promise.resolve without an argument throws an error in LG WebOS 2
    var promise = Promise.resolve(undefined);
    notify = function () {
      promise.then(flush);
    };
  // for other environments - macrotask based on:
  // - setImmediate
  // - MessageChannel
  // - window.postMessag
  // - onreadystatechange
  // - setTimeout
  } else {
    notify = function () {
      // strange IE + webpack dev server bug - use .call(global)
      macrotask.call(global, flush);
    };
  }

  return function (fn) {
    var task = { fn: fn, next: undefined };
    if (last) last.next = task;
    if (!head) {
      head = task;
      notify();
    } last = task;
  };
};


/***/ }),
/* 557 */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(11);
var navigator = global.navigator;

module.exports = navigator && navigator.userAgent || '';


/***/ }),
/* 558 */
/***/ (function(module, exports, __webpack_require__) {

var hide = __webpack_require__(36);
module.exports = function (target, src, safe) {
  for (var key in src) {
    if (safe && target[key]) target[key] = src[key];
    else hide(target, key, src[key]);
  } return target;
};


/***/ }),
/* 559 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var global = __webpack_require__(11);
var core = __webpack_require__(25);
var dP = __webpack_require__(67);
var DESCRIPTORS = __webpack_require__(55);
var SPECIES = __webpack_require__(14)('species');

module.exports = function (KEY) {
  var C = typeof core[KEY] == 'function' ? core[KEY] : global[KEY];
  if (DESCRIPTORS && C && !C[SPECIES]) dP.f(C, SPECIES, {
    configurable: true,
    get: function () { return this; }
  });
};


/***/ }),
/* 560 */
/***/ (function(module, exports, __webpack_require__) {

var ITERATOR = __webpack_require__(14)('iterator');
var SAFE_CLOSING = false;

try {
  var riter = [7][ITERATOR]();
  riter['return'] = function () { SAFE_CLOSING = true; };
  // eslint-disable-next-line no-throw-literal
  Array.from(riter, function () { throw 2; });
} catch (e) { /* empty */ }

module.exports = function (exec, skipClosing) {
  if (!skipClosing && !SAFE_CLOSING) return false;
  var safe = false;
  try {
    var arr = [7];
    var iter = arr[ITERATOR]();
    iter.next = function () { return { done: safe = true }; };
    arr[ITERATOR] = function () { return iter; };
    exec(arr);
  } catch (e) { /* empty */ }
  return safe;
};


/***/ }),
/* 561 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
// https://github.com/tc39/proposal-promise-finally

var $export = __webpack_require__(53);
var core = __webpack_require__(25);
var global = __webpack_require__(11);
var speciesConstructor = __webpack_require__(301);
var promiseResolve = __webpack_require__(304);

$export($export.P + $export.R, 'Promise', { 'finally': function (onFinally) {
  var C = speciesConstructor(this, core.Promise || global.Promise);
  var isFunction = typeof onFinally == 'function';
  return this.then(
    isFunction ? function (x) {
      return promiseResolve(C, onFinally()).then(function () { return x; });
    } : onFinally,
    isFunction ? function (e) {
      return promiseResolve(C, onFinally()).then(function () { throw e; });
    } : onFinally
  );
} });


/***/ }),
/* 562 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

// https://github.com/tc39/proposal-promise-try
var $export = __webpack_require__(53);
var newPromiseCapability = __webpack_require__(116);
var perform = __webpack_require__(303);

$export($export.S, 'Promise', { 'try': function (callbackfn) {
  var promiseCapability = newPromiseCapability.f(this);
  var result = perform(callbackfn);
  (result.e ? promiseCapability.reject : promiseCapability.resolve)(result.v);
  return promiseCapability.promise;
} });


/***/ }),
/* 563 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var getters = {};

/* harmony default export */ __webpack_exports__["a"] = (getters);

/***/ }),
/* 564 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(565)
}
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(568)
/* template */
var __vue_template__ = __webpack_require__(613)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
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
Component.options.__file = "src/installer/components/Installer.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-10043a22", Component.options)
  } else {
    hotAPI.reload("data-v-10043a22", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 565 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(566);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(117)("0a52a593", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../node_modules/css-loader/index.js!../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-10043a22\",\"scoped\":false,\"hasInlineConfig\":true}!../../../node_modules/sass-loader/lib/loader.js!../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Installer.vue", function() {
     var newContent = require("!!../../../node_modules/css-loader/index.js!../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-10043a22\",\"scoped\":false,\"hasInlineConfig\":true}!../../../node_modules/sass-loader/lib/loader.js!../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Installer.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 566 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(38)(false);
// imports


// module
exports.push([module.i, "\nbody {\n  background-color: aquamarine;\n}\n#sidebar {\n  width: 200px;\n}\n#content {\n  left: 200px;\n}\nsection {\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n}\nsection > div:first-child {\n  width: 50%;\n  color: #48525b;\n  background-color: #f8fafc;\n  padding: 3em;\n}\nsection > div:last-child {\n  width: 50%;\n  background-color: #22292f;\n  color: #f8fafc;\n  padding: 3em;\n  font-size: .8em;\n}\n#menu {\n  font-size: .9em;\n}\n#menu a {\n  text-decoration: none;\n  font-weight: normal;\n}\n#menu a.is-active {\n  font-weight: bold;\n}\n#menu ul {\n  padding-bottom: 1em;\n}\n#menu ul > li:first-child {\n  margin-top: .5em;\n}\n#menu li {\n  padding-top: .5em;\n  padding-bottom: .5em;\n}\n", ""]);

// exports


/***/ }),
/* 567 */
/***/ (function(module, exports) {

/**
 * Translates the list format produced by css-loader into something
 * easier to manipulate.
 */
module.exports = function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = {
      id: parentId + ':' + i,
      css: css,
      media: media,
      sourceMap: sourceMap
    }
    if (!newStyles[id]) {
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      newStyles[id].parts.push(part)
    }
  }
  return styles
}


/***/ }),
/* 568 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__ = __webpack_require__(57);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vuex__ = __webpack_require__(35);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__Messages__ = __webpack_require__(569);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__Messages___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__Messages__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__MainMenu_vue__ = __webpack_require__(575);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__MainMenu_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__MainMenu_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__components_utilities_DeviseLogo_vue__ = __webpack_require__(578);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__components_utilities_DeviseLogo_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__components_utilities_DeviseLogo_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__items_Database_vue__ = __webpack_require__(581);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__items_Database_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5__items_Database_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__items_Migrations_vue__ = __webpack_require__(586);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__items_Migrations_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_6__items_Migrations_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__items_Auth_vue__ = __webpack_require__(589);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__items_Auth_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_7__items_Auth_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__items_User_vue__ = __webpack_require__(592);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__items_User_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_8__items_User_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__items_Site_vue__ = __webpack_require__(595);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__items_Site_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_9__items_Site_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__items_Slices_vue__ = __webpack_require__(598);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__items_Slices_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_10__items_Slices_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11__items_Page_vue__ = __webpack_require__(601);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11__items_Page_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_11__items_Page_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_12__items_ImageLibrary_vue__ = __webpack_require__(604);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_12__items_ImageLibrary_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_12__items_ImageLibrary_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_13__items_ImageOptimization_vue__ = __webpack_require__(607);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_13__items_ImageOptimization_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_13__items_ImageOptimization_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_14__items_OptionalExtras_vue__ = __webpack_require__(610);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_14__items_OptionalExtras_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_14__items_OptionalExtras_vue__);

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  mounted: function mounted() {
    this.getLanguages();
    this.startChecker();
  },

  methods: __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_1_vuex__["b" /* mapActions */])(['refreshChecklist', 'getLanguages']), {
    startChecker: function startChecker() {
      var _this = this;

      this.refreshChecklist();
      setInterval(function () {
        _this.refreshChecklist();
      }, 5000);
    }
  }),
  computed: __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_1_vuex__["c" /* mapState */])({
    checklist: function checklist(state) {
      return state.checklist;
    },
    languages: function languages(state) {
      return state.languages.data;
    }
  }), {
    finished: function finished() {
      for (var task in this.checklist) {
        if (this.checklist.hasOwnProperty(task)) {
          if (!this.checklist[task]) {
            return false;
          }
        }
      }

      return true;
    },
    finishedStyles: function finishedStyles() {
      if (this.finished) {
        return { top: 0 };
      }

      return { top: '-200px' };
    },
    bodyFinishedStyles: function bodyFinishedStyles() {
      if (this.finished) {
        return { marginTop: '200px' };
      }

      return { marginTop: '0' };
    }
  }),
  components: {
    Auth: __WEBPACK_IMPORTED_MODULE_7__items_Auth_vue___default.a,
    Database: __WEBPACK_IMPORTED_MODULE_5__items_Database_vue___default.a,
    Migrations: __WEBPACK_IMPORTED_MODULE_6__items_Migrations_vue___default.a,
    User: __WEBPACK_IMPORTED_MODULE_8__items_User_vue___default.a,
    Site: __WEBPACK_IMPORTED_MODULE_9__items_Site_vue___default.a,
    Slices: __WEBPACK_IMPORTED_MODULE_10__items_Slices_vue___default.a,
    Page: __WEBPACK_IMPORTED_MODULE_11__items_Page_vue___default.a,
    ImageLibrary: __WEBPACK_IMPORTED_MODULE_12__items_ImageLibrary_vue___default.a,
    ImageOptimization: __WEBPACK_IMPORTED_MODULE_13__items_ImageOptimization_vue___default.a,
    OptionalExtras: __WEBPACK_IMPORTED_MODULE_14__items_OptionalExtras_vue___default.a,
    Messages: __WEBPACK_IMPORTED_MODULE_2__Messages___default.a,
    MainMenu: __WEBPACK_IMPORTED_MODULE_3__MainMenu_vue___default.a,
    DeviseLogo: __WEBPACK_IMPORTED_MODULE_4__components_utilities_DeviseLogo_vue___default.a
  }
});

/***/ }),
/* 569 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(570)
}
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(572)
/* template */
var __vue_template__ = __webpack_require__(574)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
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
Component.options.__file = "src/installer/components/Messages.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-c4f64996", Component.options)
  } else {
    hotAPI.reload("data-v-c4f64996", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 570 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(571);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(117)("5286c2d3", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../node_modules/css-loader/index.js!../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-c4f64996\",\"scoped\":false,\"hasInlineConfig\":true}!../../../node_modules/sass-loader/lib/loader.js!../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Messages.vue", function() {
     var newContent = require("!!../../../node_modules/css-loader/index.js!../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-c4f64996\",\"scoped\":false,\"hasInlineConfig\":true}!../../../node_modules/sass-loader/lib/loader.js!../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Messages.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 571 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(38)(false);
// imports


// module
exports.push([module.i, "\n", ""]);

// exports


/***/ }),
/* 572 */
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

var hash = __webpack_require__(573);

/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      messages: []
    };
  },
  mounted: function mounted() {
    window.$bus.$on('showMessage', this.addMessage);
    window.$bus.$on('showError', this.addError);
  },

  methods: {
    addMessage: function addMessage(message) {
      var _this = this;

      var messageObj = {
        content: '<p>' + message.content + '</p>',
        type: 'message'
      };
      this.messages.push(messageObj);

      setTimeout(function () {
        _this.messages.splice(_this.messages.indexOf(messageObj), 1);
      }, 4000);
    },
    addError: function addError(error) {
      var _this2 = this;

      var errorMessage = {
        content: this.buildError(error.response),
        type: 'error'
      };
      this.messages.push(errorMessage);

      setTimeout(function () {
        _this2.messages.splice(_this2.messages.indexOf(errorMessage), 1);
      }, 6000);
    },
    getHash: function getHash(message) {
      message.date = new Date();
      return hash(message);
    },
    buildError: function buildError(error) {
      // API Error
      if (error.data && error.data.message) {
        return this.buildValidationErrorMessage(error.data);
      }
      // Laravel Error
      else if (error.exception) {
          return this.buildLaravelErrorMessage(error);
        }

      return '<p>There was an error with your request</p>';
    },
    buildValidationErrorMessage: function buildValidationErrorMessage(errorData) {
      var errorString = '<p>' + errorData.message + '</p>';

      if (errorData.errors) {
        errorString += '<ul>';

        for (var key in errorData.errors) {
          if (errorData.errors.hasOwnProperty(key)) {
            errorString += '<li>' + errorData.errors[key] + '</li>';
          }
        }

        errorString += '</ul>';
      }

      return errorString;
    },
    buildLaravelErrorMessage: function buildLaravelErrorMessage(error) {
      var errorString = '';

      return errorString;
    }
  }
});

/***/ }),
/* 573 */
/***/ (function(module, exports, __webpack_require__) {

var require;var require;!function(e){if(true)module.exports=e();else if("function"==typeof define&&define.amd)define(e);else{var t;"undefined"!=typeof window?t=window:"undefined"!=typeof global?t=global:"undefined"!=typeof self&&(t=self),t.objectHash=e()}}(function(){return function e(t,n,r){function o(u,a){if(!n[u]){if(!t[u]){var f="function"==typeof require&&require;if(!a&&f)return require(u,!0);if(i)return i(u,!0);throw new Error("Cannot find module '"+u+"'")}var s=n[u]={exports:{}};t[u][0].call(s.exports,function(e){var n=t[u][1][e];return o(n?n:e)},s,s.exports,e,t,n,r)}return n[u].exports}for(var i="function"==typeof require&&require,u=0;u<r.length;u++)o(r[u]);return o}({1:[function(e,t,n){(function(r,o,i,u,a,f,s,c,l){"use strict";function d(e,t){return t=h(e,t),g(e,t)}function h(e,t){if(t=t||{},t.algorithm=t.algorithm||"sha1",t.encoding=t.encoding||"hex",t.excludeValues=!!t.excludeValues,t.algorithm=t.algorithm.toLowerCase(),t.encoding=t.encoding.toLowerCase(),t.ignoreUnknown=t.ignoreUnknown===!0,t.respectType=t.respectType!==!1,t.respectFunctionNames=t.respectFunctionNames!==!1,t.respectFunctionProperties=t.respectFunctionProperties!==!1,t.unorderedArrays=t.unorderedArrays===!0,t.unorderedSets=t.unorderedSets!==!1,t.unorderedObjects=t.unorderedObjects!==!1,t.replacer=t.replacer||void 0,t.excludeKeys=t.excludeKeys||void 0,"undefined"==typeof e)throw new Error("Object argument required.");for(var n=0;n<v.length;++n)v[n].toLowerCase()===t.algorithm.toLowerCase()&&(t.algorithm=v[n]);if(v.indexOf(t.algorithm)===-1)throw new Error('Algorithm "'+t.algorithm+'"  not supported. supported values: '+v.join(", "));if(m.indexOf(t.encoding)===-1&&"passthrough"!==t.algorithm)throw new Error('Encoding "'+t.encoding+'"  not supported. supported values: '+m.join(", "));return t}function p(e){if("function"!=typeof e)return!1;var t=/^function\s+\w*\s*\(\s*\)\s*{\s+\[native code\]\s+}$/i;return null!=t.exec(Function.prototype.toString.call(e))}function g(e,t){var n;n="passthrough"!==t.algorithm?b.createHash(t.algorithm):new w,"undefined"==typeof n.write&&(n.write=n.update,n.end=n.update);var r=y(t,n);if(r.dispatch(e),n.update||n.end(""),n.digest)return n.digest("buffer"===t.encoding?void 0:t.encoding);var o=n.read();return"buffer"===t.encoding?o:o.toString(t.encoding)}function y(e,t,n){n=n||[];var r=function(e){return t.update?t.update(e,"utf8"):t.write(e,"utf8")};return{dispatch:function(t){e.replacer&&(t=e.replacer(t));var n=typeof t;return null===t&&(n="null"),this["_"+n](t)},_object:function(t){var o=/\[object (.*)\]/i,u=Object.prototype.toString.call(t),a=o.exec(u);a=a?a[1]:"unknown:["+u+"]",a=a.toLowerCase();var f=null;if((f=n.indexOf(t))>=0)return this.dispatch("[CIRCULAR:"+f+"]");if(n.push(t),"undefined"!=typeof i&&i.isBuffer&&i.isBuffer(t))return r("buffer:"),r(t);if("object"===a||"function"===a){var s=Object.keys(t);e.unorderedObjects&&(s=s.sort()),e.respectType===!1||p(t)||s.splice(0,0,"prototype","__proto__","constructor"),e.excludeKeys&&(s=s.filter(function(t){return!e.excludeKeys(t)})),r("object:"+s.length+":");var c=this;return s.forEach(function(n){c.dispatch(n),r(":"),e.excludeValues||c.dispatch(t[n]),r(",")})}if(!this["_"+a]){if(e.ignoreUnknown)return r("["+a+"]");throw new Error('Unknown object type "'+a+'"')}this["_"+a](t)},_array:function(t,o){o="undefined"!=typeof o?o:e.unorderedArrays!==!1;var i=this;if(r("array:"+t.length+":"),!o||t.length<=1)return t.forEach(function(e){return i.dispatch(e)});var u=[],a=t.map(function(t){var r=new w,o=n.slice(),i=y(e,r,o);return i.dispatch(t),u=u.concat(o.slice(n.length)),r.read().toString()});return n=n.concat(u),a.sort(),this._array(a,!1)},_date:function(e){return r("date:"+e.toJSON())},_symbol:function(e){return r("symbol:"+e.toString())},_error:function(e){return r("error:"+e.toString())},_boolean:function(e){return r("bool:"+e.toString())},_string:function(e){r("string:"+e.length+":"),r(e.toString())},_function:function(t){r("fn:"),p(t)?this.dispatch("[native]"):this.dispatch(t.toString()),e.respectFunctionNames!==!1&&this.dispatch("function-name:"+String(t.name)),e.respectFunctionProperties&&this._object(t)},_number:function(e){return r("number:"+e.toString())},_xml:function(e){return r("xml:"+e.toString())},_null:function(){return r("Null")},_undefined:function(){return r("Undefined")},_regexp:function(e){return r("regex:"+e.toString())},_uint8array:function(e){return r("uint8array:"),this.dispatch(Array.prototype.slice.call(e))},_uint8clampedarray:function(e){return r("uint8clampedarray:"),this.dispatch(Array.prototype.slice.call(e))},_int8array:function(e){return r("uint8array:"),this.dispatch(Array.prototype.slice.call(e))},_uint16array:function(e){return r("uint16array:"),this.dispatch(Array.prototype.slice.call(e))},_int16array:function(e){return r("uint16array:"),this.dispatch(Array.prototype.slice.call(e))},_uint32array:function(e){return r("uint32array:"),this.dispatch(Array.prototype.slice.call(e))},_int32array:function(e){return r("uint32array:"),this.dispatch(Array.prototype.slice.call(e))},_float32array:function(e){return r("float32array:"),this.dispatch(Array.prototype.slice.call(e))},_float64array:function(e){return r("float64array:"),this.dispatch(Array.prototype.slice.call(e))},_arraybuffer:function(e){return r("arraybuffer:"),this.dispatch(new Uint8Array(e))},_url:function(e){return r("url:"+e.toString(),"utf8")},_map:function(t){r("map:");var n=Array.from(t);return this._array(n,e.unorderedSets!==!1)},_set:function(t){r("set:");var n=Array.from(t);return this._array(n,e.unorderedSets!==!1)},_blob:function(){if(e.ignoreUnknown)return r("[blob]");throw Error('Hashing Blob objects is currently not supported\n(see https://github.com/puleos/object-hash/issues/26)\nUse "options.replacer" or "options.ignoreUnknown"\n')},_domwindow:function(){return r("domwindow")},_process:function(){return r("process")},_timer:function(){return r("timer")},_pipe:function(){return r("pipe")},_tcp:function(){return r("tcp")},_udp:function(){return r("udp")},_tty:function(){return r("tty")},_statwatcher:function(){return r("statwatcher")},_securecontext:function(){return r("securecontext")},_connection:function(){return r("connection")},_zlib:function(){return r("zlib")},_context:function(){return r("context")},_nodescript:function(){return r("nodescript")},_httpparser:function(){return r("httpparser")},_dataview:function(){return r("dataview")},_signal:function(){return r("signal")},_fsevent:function(){return r("fsevent")},_tlswrap:function(){return r("tlswrap")}}}function w(){return{buf:"",write:function(e){this.buf+=e},end:function(e){this.buf+=e},read:function(){return this.buf}}}var b=e("crypto");n=t.exports=d,n.sha1=function(e){return d(e)},n.keys=function(e){return d(e,{excludeValues:!0,algorithm:"sha1",encoding:"hex"})},n.MD5=function(e){return d(e,{algorithm:"md5",encoding:"hex"})},n.keysMD5=function(e){return d(e,{algorithm:"md5",encoding:"hex",excludeValues:!0})};var v=b.getHashes?b.getHashes().slice():["sha1","md5"];v.push("passthrough");var m=["buffer","hex","binary","base64"];n.writeToStream=function(e,t,n){return"undefined"==typeof n&&(n=t,t={}),t=h(e,t),y(t,n).dispatch(e)}}).call(this,e("lYpoI2"),"undefined"!=typeof self?self:"undefined"!=typeof window?window:{},e("buffer").Buffer,arguments[3],arguments[4],arguments[5],arguments[6],"/fake_e8180ef5.js","/")},{buffer:3,crypto:5,lYpoI2:10}],2:[function(e,t,n){(function(e,t,r,o,i,u,a,f,s){var c="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";!function(e){"use strict";function t(e){var t=e.charCodeAt(0);return t===i||t===l?62:t===u||t===d?63:t<a?-1:t<a+10?t-a+26+26:t<s+26?t-s:t<f+26?t-f+26:void 0}function n(e){function n(e){s[l++]=e}var r,i,u,a,f,s;if(e.length%4>0)throw new Error("Invalid string. Length must be a multiple of 4");var c=e.length;f="="===e.charAt(c-2)?2:"="===e.charAt(c-1)?1:0,s=new o(3*e.length/4-f),u=f>0?e.length-4:e.length;var l=0;for(r=0,i=0;r<u;r+=4,i+=3)a=t(e.charAt(r))<<18|t(e.charAt(r+1))<<12|t(e.charAt(r+2))<<6|t(e.charAt(r+3)),n((16711680&a)>>16),n((65280&a)>>8),n(255&a);return 2===f?(a=t(e.charAt(r))<<2|t(e.charAt(r+1))>>4,n(255&a)):1===f&&(a=t(e.charAt(r))<<10|t(e.charAt(r+1))<<4|t(e.charAt(r+2))>>2,n(a>>8&255),n(255&a)),s}function r(e){function t(e){return c.charAt(e)}function n(e){return t(e>>18&63)+t(e>>12&63)+t(e>>6&63)+t(63&e)}var r,o,i,u=e.length%3,a="";for(r=0,i=e.length-u;r<i;r+=3)o=(e[r]<<16)+(e[r+1]<<8)+e[r+2],a+=n(o);switch(u){case 1:o=e[e.length-1],a+=t(o>>2),a+=t(o<<4&63),a+="==";break;case 2:o=(e[e.length-2]<<8)+e[e.length-1],a+=t(o>>10),a+=t(o>>4&63),a+=t(o<<2&63),a+="="}return a}var o="undefined"!=typeof Uint8Array?Uint8Array:Array,i="+".charCodeAt(0),u="/".charCodeAt(0),a="0".charCodeAt(0),f="a".charCodeAt(0),s="A".charCodeAt(0),l="-".charCodeAt(0),d="_".charCodeAt(0);e.toByteArray=n,e.fromByteArray=r}("undefined"==typeof n?this.base64js={}:n)}).call(this,e("lYpoI2"),"undefined"!=typeof self?self:"undefined"!=typeof window?window:{},e("buffer").Buffer,arguments[3],arguments[4],arguments[5],arguments[6],"/node_modules/gulp-browserify/node_modules/base64-js/lib/b64.js","/node_modules/gulp-browserify/node_modules/base64-js/lib")},{buffer:3,lYpoI2:10}],3:[function(e,t,n){(function(t,r,o,i,u,a,f,s,c){function o(e,t,n){if(!(this instanceof o))return new o(e,t,n);var r=typeof e;if("base64"===t&&"string"===r)for(e=N(e);e.length%4!==0;)e+="=";var i;if("number"===r)i=F(e);else if("string"===r)i=o.byteLength(e,t);else{if("object"!==r)throw new Error("First argument needs to be a number, array or string.");i=F(e.length)}var u;o._useTypedArrays?u=o._augment(new Uint8Array(i)):(u=this,u.length=i,u._isBuffer=!0);var a;if(o._useTypedArrays&&"number"==typeof e.byteLength)u._set(e);else if(O(e))for(a=0;a<i;a++)o.isBuffer(e)?u[a]=e.readUInt8(a):u[a]=e[a];else if("string"===r)u.write(e,0,t);else if("number"===r&&!o._useTypedArrays&&!n)for(a=0;a<i;a++)u[a]=0;return u}function l(e,t,n,r){n=Number(n)||0;var i=e.length-n;r?(r=Number(r),r>i&&(r=i)):r=i;var u=t.length;$(u%2===0,"Invalid hex string"),r>u/2&&(r=u/2);for(var a=0;a<r;a++){var f=parseInt(t.substr(2*a,2),16);$(!isNaN(f),"Invalid hex string"),e[n+a]=f}return o._charsWritten=2*a,a}function d(e,t,n,r){var i=o._charsWritten=W(V(t),e,n,r);return i}function h(e,t,n,r){var i=o._charsWritten=W(q(t),e,n,r);return i}function p(e,t,n,r){return h(e,t,n,r)}function g(e,t,n,r){var i=o._charsWritten=W(R(t),e,n,r);return i}function y(e,t,n,r){var i=o._charsWritten=W(P(t),e,n,r);return i}function w(e,t,n){return 0===t&&n===e.length?G.fromByteArray(e):G.fromByteArray(e.slice(t,n))}function b(e,t,n){var r="",o="";n=Math.min(e.length,n);for(var i=t;i<n;i++)e[i]<=127?(r+=J(o)+String.fromCharCode(e[i]),o=""):o+="%"+e[i].toString(16);return r+J(o)}function v(e,t,n){var r="";n=Math.min(e.length,n);for(var o=t;o<n;o++)r+=String.fromCharCode(e[o]);return r}function m(e,t,n){return v(e,t,n)}function _(e,t,n){var r=e.length;(!t||t<0)&&(t=0),(!n||n<0||n>r)&&(n=r);for(var o="",i=t;i<n;i++)o+=H(e[i]);return o}function E(e,t,n){for(var r=e.slice(t,n),o="",i=0;i<r.length;i+=2)o+=String.fromCharCode(r[i]+256*r[i+1]);return o}function I(e,t,n,r){r||($("boolean"==typeof n,"missing or invalid endian"),$(void 0!==t&&null!==t,"missing offset"),$(t+1<e.length,"Trying to read beyond buffer length"));var o=e.length;if(!(t>=o)){var i;return n?(i=e[t],t+1<o&&(i|=e[t+1]<<8)):(i=e[t]<<8,t+1<o&&(i|=e[t+1])),i}}function A(e,t,n,r){r||($("boolean"==typeof n,"missing or invalid endian"),$(void 0!==t&&null!==t,"missing offset"),$(t+3<e.length,"Trying to read beyond buffer length"));var o=e.length;if(!(t>=o)){var i;return n?(t+2<o&&(i=e[t+2]<<16),t+1<o&&(i|=e[t+1]<<8),i|=e[t],t+3<o&&(i+=e[t+3]<<24>>>0)):(t+1<o&&(i=e[t+1]<<16),t+2<o&&(i|=e[t+2]<<8),t+3<o&&(i|=e[t+3]),i+=e[t]<<24>>>0),i}}function B(e,t,n,r){r||($("boolean"==typeof n,"missing or invalid endian"),$(void 0!==t&&null!==t,"missing offset"),$(t+1<e.length,"Trying to read beyond buffer length"));var o=e.length;if(!(t>=o)){var i=I(e,t,n,!0),u=32768&i;return u?(65535-i+1)*-1:i}}function L(e,t,n,r){r||($("boolean"==typeof n,"missing or invalid endian"),$(void 0!==t&&null!==t,"missing offset"),$(t+3<e.length,"Trying to read beyond buffer length"));var o=e.length;if(!(t>=o)){var i=A(e,t,n,!0),u=2147483648&i;return u?(4294967295-i+1)*-1:i}}function U(e,t,n,r){return r||($("boolean"==typeof n,"missing or invalid endian"),$(t+3<e.length,"Trying to read beyond buffer length")),Q.read(e,t,n,23,4)}function x(e,t,n,r){return r||($("boolean"==typeof n,"missing or invalid endian"),$(t+7<e.length,"Trying to read beyond buffer length")),Q.read(e,t,n,52,8)}function S(e,t,n,r,o){o||($(void 0!==t&&null!==t,"missing value"),$("boolean"==typeof r,"missing or invalid endian"),$(void 0!==n&&null!==n,"missing offset"),$(n+1<e.length,"trying to write beyond buffer length"),K(t,65535));var i=e.length;if(!(n>=i))for(var u=0,a=Math.min(i-n,2);u<a;u++)e[n+u]=(t&255<<8*(r?u:1-u))>>>8*(r?u:1-u)}function j(e,t,n,r,o){o||($(void 0!==t&&null!==t,"missing value"),$("boolean"==typeof r,"missing or invalid endian"),$(void 0!==n&&null!==n,"missing offset"),$(n+3<e.length,"trying to write beyond buffer length"),K(t,4294967295));var i=e.length;if(!(n>=i))for(var u=0,a=Math.min(i-n,4);u<a;u++)e[n+u]=t>>>8*(r?u:3-u)&255}function C(e,t,n,r,o){o||($(void 0!==t&&null!==t,"missing value"),$("boolean"==typeof r,"missing or invalid endian"),$(void 0!==n&&null!==n,"missing offset"),$(n+1<e.length,"Trying to write beyond buffer length"),z(t,32767,-32768));var i=e.length;n>=i||(t>=0?S(e,t,n,r,o):S(e,65535+t+1,n,r,o))}function k(e,t,n,r,o){o||($(void 0!==t&&null!==t,"missing value"),$("boolean"==typeof r,"missing or invalid endian"),$(void 0!==n&&null!==n,"missing offset"),$(n+3<e.length,"Trying to write beyond buffer length"),z(t,2147483647,-2147483648));var i=e.length;n>=i||(t>=0?j(e,t,n,r,o):j(e,4294967295+t+1,n,r,o))}function T(e,t,n,r,o){o||($(void 0!==t&&null!==t,"missing value"),$("boolean"==typeof r,"missing or invalid endian"),$(void 0!==n&&null!==n,"missing offset"),$(n+3<e.length,"Trying to write beyond buffer length"),X(t,3.4028234663852886e38,-3.4028234663852886e38));var i=e.length;n>=i||Q.write(e,t,n,r,23,4)}function M(e,t,n,r,o){o||($(void 0!==t&&null!==t,"missing value"),$("boolean"==typeof r,"missing or invalid endian"),$(void 0!==n&&null!==n,"missing offset"),$(n+7<e.length,"Trying to write beyond buffer length"),X(t,1.7976931348623157e308,-1.7976931348623157e308));var i=e.length;n>=i||Q.write(e,t,n,r,52,8)}function N(e){return e.trim?e.trim():e.replace(/^\s+|\s+$/g,"")}function Y(e,t,n){return"number"!=typeof e?n:(e=~~e,e>=t?t:e>=0?e:(e+=t,e>=0?e:0))}function F(e){return e=~~Math.ceil(+e),e<0?0:e}function D(e){return(Array.isArray||function(e){return"[object Array]"===Object.prototype.toString.call(e)})(e)}function O(e){return D(e)||o.isBuffer(e)||e&&"object"==typeof e&&"number"==typeof e.length}function H(e){return e<16?"0"+e.toString(16):e.toString(16)}function V(e){for(var t=[],n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<=127)t.push(e.charCodeAt(n));else{var o=n;r>=55296&&r<=57343&&n++;for(var i=encodeURIComponent(e.slice(o,n+1)).substr(1).split("%"),u=0;u<i.length;u++)t.push(parseInt(i[u],16))}}return t}function q(e){for(var t=[],n=0;n<e.length;n++)t.push(255&e.charCodeAt(n));return t}function P(e){for(var t,n,r,o=[],i=0;i<e.length;i++)t=e.charCodeAt(i),n=t>>8,r=t%256,o.push(r),o.push(n);return o}function R(e){return G.toByteArray(e)}function W(e,t,n,r){for(var o=0;o<r&&!(o+n>=t.length||o>=e.length);o++)t[o+n]=e[o];return o}function J(e){try{return decodeURIComponent(e)}catch(t){return String.fromCharCode(65533)}}function K(e,t){$("number"==typeof e,"cannot write a non-number as a number"),$(e>=0,"specified a negative value for writing an unsigned value"),$(e<=t,"value is larger than maximum value for type"),$(Math.floor(e)===e,"value has a fractional component")}function z(e,t,n){$("number"==typeof e,"cannot write a non-number as a number"),$(e<=t,"value larger than maximum allowed value"),$(e>=n,"value smaller than minimum allowed value"),$(Math.floor(e)===e,"value has a fractional component")}function X(e,t,n){$("number"==typeof e,"cannot write a non-number as a number"),$(e<=t,"value larger than maximum allowed value"),$(e>=n,"value smaller than minimum allowed value")}function $(e,t){if(!e)throw new Error(t||"Failed assertion")}var G=e("base64-js"),Q=e("ieee754");n.Buffer=o,n.SlowBuffer=o,n.INSPECT_MAX_BYTES=50,o.poolSize=8192,o._useTypedArrays=function(){try{var e=new ArrayBuffer(0),t=new Uint8Array(e);return t.foo=function(){return 42},42===t.foo()&&"function"==typeof t.subarray}catch(n){return!1}}(),o.isEncoding=function(e){switch(String(e).toLowerCase()){case"hex":case"utf8":case"utf-8":case"ascii":case"binary":case"base64":case"raw":case"ucs2":case"ucs-2":case"utf16le":case"utf-16le":return!0;default:return!1}},o.isBuffer=function(e){return!(null===e||void 0===e||!e._isBuffer)},o.byteLength=function(e,t){var n;switch(e+="",t||"utf8"){case"hex":n=e.length/2;break;case"utf8":case"utf-8":n=V(e).length;break;case"ascii":case"binary":case"raw":n=e.length;break;case"base64":n=R(e).length;break;case"ucs2":case"ucs-2":case"utf16le":case"utf-16le":n=2*e.length;break;default:throw new Error("Unknown encoding")}return n},o.concat=function(e,t){if($(D(e),"Usage: Buffer.concat(list, [totalLength])\nlist should be an Array."),0===e.length)return new o(0);if(1===e.length)return e[0];var n;if("number"!=typeof t)for(t=0,n=0;n<e.length;n++)t+=e[n].length;var r=new o(t),i=0;for(n=0;n<e.length;n++){var u=e[n];u.copy(r,i),i+=u.length}return r},o.prototype.write=function(e,t,n,r){if(isFinite(t))isFinite(n)||(r=n,n=void 0);else{var o=r;r=t,t=n,n=o}t=Number(t)||0;var i=this.length-t;n?(n=Number(n),n>i&&(n=i)):n=i,r=String(r||"utf8").toLowerCase();var u;switch(r){case"hex":u=l(this,e,t,n);break;case"utf8":case"utf-8":u=d(this,e,t,n);break;case"ascii":u=h(this,e,t,n);break;case"binary":u=p(this,e,t,n);break;case"base64":u=g(this,e,t,n);break;case"ucs2":case"ucs-2":case"utf16le":case"utf-16le":u=y(this,e,t,n);break;default:throw new Error("Unknown encoding")}return u},o.prototype.toString=function(e,t,n){var r=this;if(e=String(e||"utf8").toLowerCase(),t=Number(t)||0,n=void 0!==n?Number(n):n=r.length,n===t)return"";var o;switch(e){case"hex":o=_(r,t,n);break;case"utf8":case"utf-8":o=b(r,t,n);break;case"ascii":o=v(r,t,n);break;case"binary":o=m(r,t,n);break;case"base64":o=w(r,t,n);break;case"ucs2":case"ucs-2":case"utf16le":case"utf-16le":o=E(r,t,n);break;default:throw new Error("Unknown encoding")}return o},o.prototype.toJSON=function(){return{type:"Buffer",data:Array.prototype.slice.call(this._arr||this,0)}},o.prototype.copy=function(e,t,n,r){var i=this;if(n||(n=0),r||0===r||(r=this.length),t||(t=0),r!==n&&0!==e.length&&0!==i.length){$(r>=n,"sourceEnd < sourceStart"),$(t>=0&&t<e.length,"targetStart out of bounds"),$(n>=0&&n<i.length,"sourceStart out of bounds"),$(r>=0&&r<=i.length,"sourceEnd out of bounds"),r>this.length&&(r=this.length),e.length-t<r-n&&(r=e.length-t+n);var u=r-n;if(u<100||!o._useTypedArrays)for(var a=0;a<u;a++)e[a+t]=this[a+n];else e._set(this.subarray(n,n+u),t)}},o.prototype.slice=function(e,t){var n=this.length;if(e=Y(e,n,0),t=Y(t,n,n),o._useTypedArrays)return o._augment(this.subarray(e,t));for(var r=t-e,i=new o(r,(void 0),(!0)),u=0;u<r;u++)i[u]=this[u+e];return i},o.prototype.get=function(e){return console.log(".get() is deprecated. Access using array indexes instead."),this.readUInt8(e)},o.prototype.set=function(e,t){return console.log(".set() is deprecated. Access using array indexes instead."),this.writeUInt8(e,t)},o.prototype.readUInt8=function(e,t){if(t||($(void 0!==e&&null!==e,"missing offset"),$(e<this.length,"Trying to read beyond buffer length")),!(e>=this.length))return this[e]},o.prototype.readUInt16LE=function(e,t){return I(this,e,!0,t)},o.prototype.readUInt16BE=function(e,t){return I(this,e,!1,t)},o.prototype.readUInt32LE=function(e,t){return A(this,e,!0,t)},o.prototype.readUInt32BE=function(e,t){return A(this,e,!1,t)},o.prototype.readInt8=function(e,t){if(t||($(void 0!==e&&null!==e,"missing offset"),$(e<this.length,"Trying to read beyond buffer length")),!(e>=this.length)){var n=128&this[e];return n?(255-this[e]+1)*-1:this[e]}},o.prototype.readInt16LE=function(e,t){return B(this,e,!0,t)},o.prototype.readInt16BE=function(e,t){return B(this,e,!1,t)},o.prototype.readInt32LE=function(e,t){return L(this,e,!0,t)},o.prototype.readInt32BE=function(e,t){return L(this,e,!1,t)},o.prototype.readFloatLE=function(e,t){return U(this,e,!0,t)},o.prototype.readFloatBE=function(e,t){return U(this,e,!1,t)},o.prototype.readDoubleLE=function(e,t){return x(this,e,!0,t)},o.prototype.readDoubleBE=function(e,t){return x(this,e,!1,t)},o.prototype.writeUInt8=function(e,t,n){n||($(void 0!==e&&null!==e,"missing value"),$(void 0!==t&&null!==t,"missing offset"),$(t<this.length,"trying to write beyond buffer length"),K(e,255)),t>=this.length||(this[t]=e)},o.prototype.writeUInt16LE=function(e,t,n){S(this,e,t,!0,n)},o.prototype.writeUInt16BE=function(e,t,n){S(this,e,t,!1,n)},o.prototype.writeUInt32LE=function(e,t,n){j(this,e,t,!0,n)},o.prototype.writeUInt32BE=function(e,t,n){j(this,e,t,!1,n)},o.prototype.writeInt8=function(e,t,n){n||($(void 0!==e&&null!==e,"missing value"),$(void 0!==t&&null!==t,"missing offset"),$(t<this.length,"Trying to write beyond buffer length"),z(e,127,-128)),t>=this.length||(e>=0?this.writeUInt8(e,t,n):this.writeUInt8(255+e+1,t,n))},o.prototype.writeInt16LE=function(e,t,n){C(this,e,t,!0,n)},o.prototype.writeInt16BE=function(e,t,n){C(this,e,t,!1,n)},o.prototype.writeInt32LE=function(e,t,n){k(this,e,t,!0,n)},o.prototype.writeInt32BE=function(e,t,n){k(this,e,t,!1,n)},o.prototype.writeFloatLE=function(e,t,n){T(this,e,t,!0,n)},o.prototype.writeFloatBE=function(e,t,n){T(this,e,t,!1,n)},o.prototype.writeDoubleLE=function(e,t,n){M(this,e,t,!0,n)},o.prototype.writeDoubleBE=function(e,t,n){M(this,e,t,!1,n)},o.prototype.fill=function(e,t,n){if(e||(e=0),t||(t=0),n||(n=this.length),"string"==typeof e&&(e=e.charCodeAt(0)),$("number"==typeof e&&!isNaN(e),"value is not a number"),$(n>=t,"end < start"),n!==t&&0!==this.length){$(t>=0&&t<this.length,"start out of bounds"),$(n>=0&&n<=this.length,"end out of bounds");for(var r=t;r<n;r++)this[r]=e}},o.prototype.inspect=function(){for(var e=[],t=this.length,r=0;r<t;r++)if(e[r]=H(this[r]),r===n.INSPECT_MAX_BYTES){e[r+1]="...";break}return"<Buffer "+e.join(" ")+">"},o.prototype.toArrayBuffer=function(){if("undefined"!=typeof Uint8Array){if(o._useTypedArrays)return new o(this).buffer;for(var e=new Uint8Array(this.length),t=0,n=e.length;t<n;t+=1)e[t]=this[t];return e.buffer}throw new Error("Buffer.toArrayBuffer not supported in this browser")};var Z=o.prototype;o._augment=function(e){return e._isBuffer=!0,e._get=e.get,e._set=e.set,e.get=Z.get,e.set=Z.set,e.write=Z.write,e.toString=Z.toString,e.toLocaleString=Z.toString,e.toJSON=Z.toJSON,e.copy=Z.copy,e.slice=Z.slice,e.readUInt8=Z.readUInt8,e.readUInt16LE=Z.readUInt16LE,e.readUInt16BE=Z.readUInt16BE,e.readUInt32LE=Z.readUInt32LE,e.readUInt32BE=Z.readUInt32BE,e.readInt8=Z.readInt8,e.readInt16LE=Z.readInt16LE,e.readInt16BE=Z.readInt16BE,e.readInt32LE=Z.readInt32LE,e.readInt32BE=Z.readInt32BE,e.readFloatLE=Z.readFloatLE,e.readFloatBE=Z.readFloatBE,e.readDoubleLE=Z.readDoubleLE,e.readDoubleBE=Z.readDoubleBE,e.writeUInt8=Z.writeUInt8,e.writeUInt16LE=Z.writeUInt16LE,e.writeUInt16BE=Z.writeUInt16BE,e.writeUInt32LE=Z.writeUInt32LE,e.writeUInt32BE=Z.writeUInt32BE,e.writeInt8=Z.writeInt8,e.writeInt16LE=Z.writeInt16LE,e.writeInt16BE=Z.writeInt16BE,e.writeInt32LE=Z.writeInt32LE,e.writeInt32BE=Z.writeInt32BE,e.writeFloatLE=Z.writeFloatLE,e.writeFloatBE=Z.writeFloatBE,e.writeDoubleLE=Z.writeDoubleLE,e.writeDoubleBE=Z.writeDoubleBE,e.fill=Z.fill,e.inspect=Z.inspect,e.toArrayBuffer=Z.toArrayBuffer,e}}).call(this,e("lYpoI2"),"undefined"!=typeof self?self:"undefined"!=typeof window?window:{},e("buffer").Buffer,arguments[3],arguments[4],arguments[5],arguments[6],"/node_modules/gulp-browserify/node_modules/buffer/index.js","/node_modules/gulp-browserify/node_modules/buffer")},{"base64-js":2,buffer:3,ieee754:11,lYpoI2:10}],4:[function(e,t,n){(function(n,r,o,i,u,a,f,s,c){function l(e,t){if(e.length%p!==0){var n=e.length+(p-e.length%p);e=o.concat([e,g],n)}for(var r=[],i=t?e.readInt32BE:e.readInt32LE,u=0;u<e.length;u+=p)r.push(i.call(e,u));return r}function d(e,t,n){for(var r=new o(t),i=n?r.writeInt32BE:r.writeInt32LE,u=0;u<e.length;u++)i.call(r,e[u],4*u,!0);return r}function h(e,t,n,r){o.isBuffer(e)||(e=new o(e));var i=t(l(e,r),e.length*y);return d(i,n,r)}var o=e("buffer").Buffer,p=4,g=new o(p);g.fill(0);var y=8;t.exports={hash:h}}).call(this,e("lYpoI2"),"undefined"!=typeof self?self:"undefined"!=typeof window?window:{},e("buffer").Buffer,arguments[3],arguments[4],arguments[5],arguments[6],"/node_modules/gulp-browserify/node_modules/crypto-browserify/helpers.js","/node_modules/gulp-browserify/node_modules/crypto-browserify")},{buffer:3,lYpoI2:10}],5:[function(e,t,n){(function(t,r,o,i,u,a,f,s,c){function l(e,t,n){o.isBuffer(t)||(t=new o(t)),o.isBuffer(n)||(n=new o(n)),t.length>m?t=e(t):t.length<m&&(t=o.concat([t,_],m));for(var r=new o(m),i=new o(m),u=0;u<m;u++)r[u]=54^t[u],i[u]=92^t[u];var a=e(o.concat([r,n]));return e(o.concat([i,a]))}function d(e,t){e=e||"sha1";var n=v[e],r=[],i=0;return n||h("algorithm:",e,"is not yet supported"),{update:function(e){return o.isBuffer(e)||(e=new o(e)),r.push(e),i+=e.length,this},digest:function(e){var i=o.concat(r),u=t?l(n,t,i):n(i);return r=null,e?u.toString(e):u}}}function h(){var e=[].slice.call(arguments).join(" ");throw new Error([e,"we accept pull requests","http://github.com/dominictarr/crypto-browserify"].join("\n"))}function p(e,t){for(var n in e)t(e[n],n)}var o=e("buffer").Buffer,g=e("./sha"),y=e("./sha256"),w=e("./rng"),b=e("./md5"),v={sha1:g,sha256:y,md5:b},m=64,_=new o(m);_.fill(0),n.createHash=function(e){return d(e)},n.createHmac=function(e,t){return d(e,t)},n.randomBytes=function(e,t){if(!t||!t.call)return new o(w(e));try{t.call(this,void 0,new o(w(e)))}catch(n){t(n)}},p(["createCredentials","createCipher","createCipheriv","createDecipher","createDecipheriv","createSign","createVerify","createDiffieHellman","pbkdf2"],function(e){n[e]=function(){h("sorry,",e,"is not implemented yet")}})}).call(this,e("lYpoI2"),"undefined"!=typeof self?self:"undefined"!=typeof window?window:{},e("buffer").Buffer,arguments[3],arguments[4],arguments[5],arguments[6],"/node_modules/gulp-browserify/node_modules/crypto-browserify/index.js","/node_modules/gulp-browserify/node_modules/crypto-browserify")},{"./md5":6,"./rng":7,"./sha":8,"./sha256":9,buffer:3,lYpoI2:10}],6:[function(e,t,n){(function(n,r,o,i,u,a,f,s,c){function l(e,t){e[t>>5]|=128<<t%32,e[(t+64>>>9<<4)+14]=t;for(var n=1732584193,r=-271733879,o=-1732584194,i=271733878,u=0;u<e.length;u+=16){var a=n,f=r,s=o,c=i;n=h(n,r,o,i,e[u+0],7,-680876936),i=h(i,n,r,o,e[u+1],12,-389564586),o=h(o,i,n,r,e[u+2],17,606105819),r=h(r,o,i,n,e[u+3],22,-1044525330),n=h(n,r,o,i,e[u+4],7,-176418897),i=h(i,n,r,o,e[u+5],12,1200080426),o=h(o,i,n,r,e[u+6],17,-1473231341),r=h(r,o,i,n,e[u+7],22,-45705983),n=h(n,r,o,i,e[u+8],7,1770035416),i=h(i,n,r,o,e[u+9],12,-1958414417),o=h(o,i,n,r,e[u+10],17,-42063),r=h(r,o,i,n,e[u+11],22,-1990404162),n=h(n,r,o,i,e[u+12],7,1804603682),i=h(i,n,r,o,e[u+13],12,-40341101),o=h(o,i,n,r,e[u+14],17,-1502002290),r=h(r,o,i,n,e[u+15],22,1236535329),n=p(n,r,o,i,e[u+1],5,-165796510),i=p(i,n,r,o,e[u+6],9,-1069501632),o=p(o,i,n,r,e[u+11],14,643717713),r=p(r,o,i,n,e[u+0],20,-373897302),n=p(n,r,o,i,e[u+5],5,-701558691),i=p(i,n,r,o,e[u+10],9,38016083),o=p(o,i,n,r,e[u+15],14,-660478335),r=p(r,o,i,n,e[u+4],20,-405537848),n=p(n,r,o,i,e[u+9],5,568446438),i=p(i,n,r,o,e[u+14],9,-1019803690),o=p(o,i,n,r,e[u+3],14,-187363961),r=p(r,o,i,n,e[u+8],20,1163531501),n=p(n,r,o,i,e[u+13],5,-1444681467),i=p(i,n,r,o,e[u+2],9,-51403784),o=p(o,i,n,r,e[u+7],14,1735328473),r=p(r,o,i,n,e[u+12],20,-1926607734),n=g(n,r,o,i,e[u+5],4,-378558),i=g(i,n,r,o,e[u+8],11,-2022574463),o=g(o,i,n,r,e[u+11],16,1839030562),r=g(r,o,i,n,e[u+14],23,-35309556),n=g(n,r,o,i,e[u+1],4,-1530992060),i=g(i,n,r,o,e[u+4],11,1272893353),o=g(o,i,n,r,e[u+7],16,-155497632),r=g(r,o,i,n,e[u+10],23,-1094730640),n=g(n,r,o,i,e[u+13],4,681279174),i=g(i,n,r,o,e[u+0],11,-358537222),o=g(o,i,n,r,e[u+3],16,-722521979),r=g(r,o,i,n,e[u+6],23,76029189),n=g(n,r,o,i,e[u+9],4,-640364487),i=g(i,n,r,o,e[u+12],11,-421815835),o=g(o,i,n,r,e[u+15],16,530742520),r=g(r,o,i,n,e[u+2],23,-995338651),n=y(n,r,o,i,e[u+0],6,-198630844),i=y(i,n,r,o,e[u+7],10,1126891415),o=y(o,i,n,r,e[u+14],15,-1416354905),r=y(r,o,i,n,e[u+5],21,-57434055),n=y(n,r,o,i,e[u+12],6,1700485571),i=y(i,n,r,o,e[u+3],10,-1894986606),o=y(o,i,n,r,e[u+10],15,-1051523),r=y(r,o,i,n,e[u+1],21,-2054922799),n=y(n,r,o,i,e[u+8],6,1873313359),i=y(i,n,r,o,e[u+15],10,-30611744),o=y(o,i,n,r,e[u+6],15,-1560198380),r=y(r,o,i,n,e[u+13],21,1309151649),n=y(n,r,o,i,e[u+4],6,-145523070),i=y(i,n,r,o,e[u+11],10,-1120210379),o=y(o,i,n,r,e[u+2],15,718787259),r=y(r,o,i,n,e[u+9],21,-343485551),n=w(n,a),r=w(r,f),o=w(o,s),i=w(i,c)}return Array(n,r,o,i)}function d(e,t,n,r,o,i){return w(b(w(w(t,e),w(r,i)),o),n)}function h(e,t,n,r,o,i,u){return d(t&n|~t&r,e,t,o,i,u)}function p(e,t,n,r,o,i,u){return d(t&r|n&~r,e,t,o,i,u)}function g(e,t,n,r,o,i,u){return d(t^n^r,e,t,o,i,u)}function y(e,t,n,r,o,i,u){return d(n^(t|~r),e,t,o,i,u)}function w(e,t){var n=(65535&e)+(65535&t),r=(e>>16)+(t>>16)+(n>>16);return r<<16|65535&n}function b(e,t){return e<<t|e>>>32-t}var v=e("./helpers");t.exports=function(e){return v.hash(e,l,16)}}).call(this,e("lYpoI2"),"undefined"!=typeof self?self:"undefined"!=typeof window?window:{},e("buffer").Buffer,arguments[3],arguments[4],arguments[5],arguments[6],"/node_modules/gulp-browserify/node_modules/crypto-browserify/md5.js","/node_modules/gulp-browserify/node_modules/crypto-browserify")},{"./helpers":4,buffer:3,lYpoI2:10}],7:[function(e,t,n){(function(e,n,r,o,i,u,a,f,s){!function(){var e,n,r=this;e=function(e){for(var t,t,n=new Array(e),r=0;r<e;r++)0==(3&r)&&(t=4294967296*Math.random()),n[r]=t>>>((3&r)<<3)&255;return n},r.crypto&&crypto.getRandomValues&&(n=function(e){var t=new Uint8Array(e);return crypto.getRandomValues(t),t}),t.exports=n||e}()}).call(this,e("lYpoI2"),"undefined"!=typeof self?self:"undefined"!=typeof window?window:{},e("buffer").Buffer,arguments[3],arguments[4],arguments[5],arguments[6],"/node_modules/gulp-browserify/node_modules/crypto-browserify/rng.js","/node_modules/gulp-browserify/node_modules/crypto-browserify")},{buffer:3,lYpoI2:10}],8:[function(e,t,n){(function(n,r,o,i,u,a,f,s,c){function l(e,t){e[t>>5]|=128<<24-t%32,e[(t+64>>9<<4)+15]=t;for(var n=Array(80),r=1732584193,o=-271733879,i=-1732584194,u=271733878,a=-1009589776,f=0;f<e.length;f+=16){for(var s=r,c=o,l=i,y=u,w=a,b=0;b<80;b++){b<16?n[b]=e[f+b]:n[b]=g(n[b-3]^n[b-8]^n[b-14]^n[b-16],1);var v=p(p(g(r,5),d(b,o,i,u)),p(p(a,n[b]),h(b)));a=u,u=i,i=g(o,30),o=r,r=v}r=p(r,s),o=p(o,c),i=p(i,l),u=p(u,y),a=p(a,w)}return Array(r,o,i,u,a)}function d(e,t,n,r){return e<20?t&n|~t&r:e<40?t^n^r:e<60?t&n|t&r|n&r:t^n^r}function h(e){return e<20?1518500249:e<40?1859775393:e<60?-1894007588:-899497514}function p(e,t){var n=(65535&e)+(65535&t),r=(e>>16)+(t>>16)+(n>>16);return r<<16|65535&n}function g(e,t){return e<<t|e>>>32-t}var y=e("./helpers");t.exports=function(e){return y.hash(e,l,20,!0)}}).call(this,e("lYpoI2"),"undefined"!=typeof self?self:"undefined"!=typeof window?window:{},e("buffer").Buffer,arguments[3],arguments[4],arguments[5],arguments[6],"/node_modules/gulp-browserify/node_modules/crypto-browserify/sha.js","/node_modules/gulp-browserify/node_modules/crypto-browserify")},{"./helpers":4,buffer:3,lYpoI2:10}],9:[function(e,t,n){(function(n,r,o,i,u,a,f,s,c){var l=e("./helpers"),d=function(e,t){var n=(65535&e)+(65535&t),r=(e>>16)+(t>>16)+(n>>16);return r<<16|65535&n},h=function(e,t){return e>>>t|e<<32-t},p=function(e,t){return e>>>t},g=function(e,t,n){return e&t^~e&n},y=function(e,t,n){return e&t^e&n^t&n},w=function(e){return h(e,2)^h(e,13)^h(e,22);
},b=function(e){return h(e,6)^h(e,11)^h(e,25)},v=function(e){return h(e,7)^h(e,18)^p(e,3)},m=function(e){return h(e,17)^h(e,19)^p(e,10)},_=function(e,t){var n,r,o,i,u,a,f,s,c,l,h,p,_=new Array(1116352408,1899447441,3049323471,3921009573,961987163,1508970993,2453635748,2870763221,3624381080,310598401,607225278,1426881987,1925078388,2162078206,2614888103,3248222580,3835390401,4022224774,264347078,604807628,770255983,1249150122,1555081692,1996064986,2554220882,2821834349,2952996808,3210313671,3336571891,3584528711,113926993,338241895,666307205,773529912,1294757372,1396182291,1695183700,1986661051,2177026350,2456956037,2730485921,2820302411,3259730800,3345764771,3516065817,3600352804,4094571909,275423344,430227734,506948616,659060556,883997877,958139571,1322822218,1537002063,1747873779,1955562222,2024104815,2227730452,2361852424,2428436474,2756734187,3204031479,3329325298),E=new Array(1779033703,3144134277,1013904242,2773480762,1359893119,2600822924,528734635,1541459225),I=new Array(64);e[t>>5]|=128<<24-t%32,e[(t+64>>9<<4)+15]=t;for(var c=0;c<e.length;c+=16){n=E[0],r=E[1],o=E[2],i=E[3],u=E[4],a=E[5],f=E[6],s=E[7];for(var l=0;l<64;l++)l<16?I[l]=e[l+c]:I[l]=d(d(d(m(I[l-2]),I[l-7]),v(I[l-15])),I[l-16]),h=d(d(d(d(s,b(u)),g(u,a,f)),_[l]),I[l]),p=d(w(n),y(n,r,o)),s=f,f=a,a=u,u=d(i,h),i=o,o=r,r=n,n=d(h,p);E[0]=d(n,E[0]),E[1]=d(r,E[1]),E[2]=d(o,E[2]),E[3]=d(i,E[3]),E[4]=d(u,E[4]),E[5]=d(a,E[5]),E[6]=d(f,E[6]),E[7]=d(s,E[7])}return E};t.exports=function(e){return l.hash(e,_,32,!0)}}).call(this,e("lYpoI2"),"undefined"!=typeof self?self:"undefined"!=typeof window?window:{},e("buffer").Buffer,arguments[3],arguments[4],arguments[5],arguments[6],"/node_modules/gulp-browserify/node_modules/crypto-browserify/sha256.js","/node_modules/gulp-browserify/node_modules/crypto-browserify")},{"./helpers":4,buffer:3,lYpoI2:10}],10:[function(e,t,n){(function(e,n,r,o,i,u,a,f,s){function c(){}var e=t.exports={};e.nextTick=function(){var e="undefined"!=typeof window&&window.setImmediate,t="undefined"!=typeof window&&window.postMessage&&window.addEventListener;if(e)return function(e){return window.setImmediate(e)};if(t){var n=[];return window.addEventListener("message",function(e){var t=e.source;if((t===window||null===t)&&"process-tick"===e.data&&(e.stopPropagation(),n.length>0)){var r=n.shift();r()}},!0),function(e){n.push(e),window.postMessage("process-tick","*")}}return function(e){setTimeout(e,0)}}(),e.title="browser",e.browser=!0,e.env={},e.argv=[],e.on=c,e.addListener=c,e.once=c,e.off=c,e.removeListener=c,e.removeAllListeners=c,e.emit=c,e.binding=function(e){throw new Error("process.binding is not supported")},e.cwd=function(){return"/"},e.chdir=function(e){throw new Error("process.chdir is not supported")}}).call(this,e("lYpoI2"),"undefined"!=typeof self?self:"undefined"!=typeof window?window:{},e("buffer").Buffer,arguments[3],arguments[4],arguments[5],arguments[6],"/node_modules/gulp-browserify/node_modules/process/browser.js","/node_modules/gulp-browserify/node_modules/process")},{buffer:3,lYpoI2:10}],11:[function(e,t,n){(function(e,t,r,o,i,u,a,f,s){n.read=function(e,t,n,r,o){var i,u,a=8*o-r-1,f=(1<<a)-1,s=f>>1,c=-7,l=n?o-1:0,d=n?-1:1,h=e[t+l];for(l+=d,i=h&(1<<-c)-1,h>>=-c,c+=a;c>0;i=256*i+e[t+l],l+=d,c-=8);for(u=i&(1<<-c)-1,i>>=-c,c+=r;c>0;u=256*u+e[t+l],l+=d,c-=8);if(0===i)i=1-s;else{if(i===f)return u?NaN:(h?-1:1)*(1/0);u+=Math.pow(2,r),i-=s}return(h?-1:1)*u*Math.pow(2,i-r)},n.write=function(e,t,n,r,o,i){var u,a,f,s=8*i-o-1,c=(1<<s)-1,l=c>>1,d=23===o?Math.pow(2,-24)-Math.pow(2,-77):0,h=r?0:i-1,p=r?1:-1,g=t<0||0===t&&1/t<0?1:0;for(t=Math.abs(t),isNaN(t)||t===1/0?(a=isNaN(t)?1:0,u=c):(u=Math.floor(Math.log(t)/Math.LN2),t*(f=Math.pow(2,-u))<1&&(u--,f*=2),t+=u+l>=1?d/f:d*Math.pow(2,1-l),t*f>=2&&(u++,f/=2),u+l>=c?(a=0,u=c):u+l>=1?(a=(t*f-1)*Math.pow(2,o),u+=l):(a=t*Math.pow(2,l-1)*Math.pow(2,o),u=0));o>=8;e[n+h]=255&a,h+=p,a/=256,o-=8);for(u=u<<o|a,s+=o;s>0;e[n+h]=255&u,h+=p,u/=256,s-=8);e[n+h-p]|=128*g}}).call(this,e("lYpoI2"),"undefined"!=typeof self?self:"undefined"!=typeof window?window:{},e("buffer").Buffer,arguments[3],arguments[4],arguments[5],arguments[6],"/node_modules/ieee754/index.js","/node_modules/ieee754")},{buffer:3,lYpoI2:10}]},{},[1])(1)});

/***/ }),
/* 574 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c(
      "ul",
      {
        staticClass: "dvs-list-reset dvs-fixed dvs-pin-l dvs-pin-b dvs-pin-r",
        attrs: { id: "messages" }
      },
      _vm._l(_vm.messages, function(message) {
        return _c("li", {
          key: _vm.getHash(message),
          staticClass: "dvs-p-4 dvs-text-white",
          class: {
            "dvs-bg-red": message.type === "error",
            "dvs-bg-green": message.type === "message"
          },
          domProps: { innerHTML: _vm._s(message.content) }
        })
      })
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-c4f64996", module.exports)
  }
}

/***/ }),
/* 575 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(576)
/* template */
var __vue_template__ = __webpack_require__(577)
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
Component.options.__file = "src/installer/components/MainMenu.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-61d14ea1", Component.options)
  } else {
    hotAPI.reload("data-v-61d14ea1", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 576 */
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: {
    checklist: {
      required: true
    }
  }
});

/***/ }),
/* 577 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass:
        "dvs-absolute dvs-pin-l dvs-pin-t dvs-pin-b dvs-bg-grey-lighter dvs-p-4",
      attrs: { id: "sidebar" }
    },
    [
      _c(
        "scrollactive",
        {
          attrs: {
            offset: 80,
            duration: 800,
            "bezier-easing-value": ".5,0,.35,1",
            "scroll-container-selector": "#content",
            id: "menu"
          }
        },
        [
          _c("ul", { staticClass: "dvs-list-reset" }, [
            _c("li", [
              _c(
                "a",
                {
                  staticClass: "scrollactive-item",
                  attrs: { href: "#nav-welcome" }
                },
                [_vm._v("Welcome")]
              )
            ]),
            _vm._v(" "),
            _c("li", [
              _c(
                "a",
                {
                  staticClass: "scrollactive-item",
                  attrs: { href: "#nav-required" }
                },
                [_vm._v("Required")]
              ),
              _vm._v(" "),
              _c("ul", { staticClass: "dvs-list-reset dvs-ml-4" }, [
                _c(
                  "li",
                  { staticClass: "dvs-flex" },
                  [
                    _c("item-check", {
                      staticClass: "dvs-mr-2",
                      attrs: { item: _vm.checklist.database, size: 15 }
                    }),
                    _vm._v(" "),
                    _c(
                      "a",
                      {
                        staticClass: "scrollactive-item",
                        attrs: { href: "#nav-database-connection" }
                      },
                      [_vm._v("Database Connection")]
                    )
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "dvs-flex" },
                  [
                    _c("item-check", {
                      staticClass: "dvs-mr-2",
                      attrs: { item: _vm.checklist.migrations, size: 15 }
                    }),
                    _vm._v(" "),
                    _c(
                      "a",
                      {
                        staticClass: "scrollactive-item",
                        attrs: { href: "#nav-database-migration" }
                      },
                      [_vm._v("Database Migration")]
                    )
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "dvs-flex" },
                  [
                    _c("item-check", {
                      staticClass: "dvs-mr-2",
                      attrs: { item: _vm.checklist.auth, size: 15 }
                    }),
                    _vm._v(" "),
                    _c(
                      "a",
                      {
                        staticClass: "scrollactive-item",
                        attrs: { href: "#nav-auth" }
                      },
                      [_vm._v("Authentication")]
                    )
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "dvs-flex" },
                  [
                    _c("item-check", {
                      staticClass: "dvs-mr-2",
                      attrs: { item: _vm.checklist.user, size: 15 }
                    }),
                    _vm._v(" "),
                    _c(
                      "a",
                      {
                        staticClass: "scrollactive-item",
                        attrs: { href: "#nav-user" }
                      },
                      [_vm._v("First User")]
                    )
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "dvs-flex" },
                  [
                    _c("item-check", {
                      staticClass: "dvs-mr-2",
                      attrs: { item: _vm.checklist.site, size: 15 }
                    }),
                    _vm._v(" "),
                    _c(
                      "a",
                      {
                        staticClass: "scrollactive-item",
                        attrs: { href: "#nav-site" }
                      },
                      [_vm._v("First Site")]
                    )
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "dvs-flex" },
                  [
                    _c("item-check", {
                      staticClass: "dvs-mr-2",
                      attrs: { item: _vm.checklist.page, size: 15 }
                    }),
                    _vm._v(" "),
                    _c(
                      "a",
                      {
                        staticClass: "scrollactive-item",
                        attrs: { href: "#nav-page" }
                      },
                      [_vm._v("First Page")]
                    )
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "dvs-flex" },
                  [
                    _c("item-check", {
                      staticClass: "dvs-mr-2",
                      attrs: { item: _vm.checklist.slices, size: 15 }
                    }),
                    _vm._v(" "),
                    _c(
                      "a",
                      {
                        staticClass: "scrollactive-item",
                        attrs: { href: "#nav-slices" }
                      },
                      [_vm._v("Slices Directory")]
                    )
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "dvs-flex" },
                  [
                    _c("item-check", {
                      staticClass: "dvs-mr-2",
                      attrs: { item: _vm.checklist.image_library, size: 15 }
                    }),
                    _vm._v(" "),
                    _c(
                      "a",
                      {
                        staticClass: "scrollactive-item",
                        attrs: { href: "#nav-image-library" }
                      },
                      [_vm._v("Image Library")]
                    )
                  ],
                  1
                )
              ])
            ]),
            _vm._v(" "),
            _c("li", [
              _c(
                "a",
                {
                  staticClass: "scrollactive-item",
                  attrs: { href: "#nav-suggested" }
                },
                [_vm._v("Suggested")]
              ),
              _vm._v(" "),
              _c("ul", { staticClass: "dvs-list-reset dvs-ml-4" }, [
                _c("li", { staticClass: "dvs-flex" }, [
                  _c(
                    "a",
                    {
                      staticClass: "scrollactive-item",
                      attrs: { href: "#nav-remove-laravel-route" }
                    },
                    [_vm._v("Remove Laravel Routes")]
                  )
                ]),
                _vm._v(" "),
                _c("li", [
                  _c(
                    "a",
                    {
                      staticClass: "scrollactive-item",
                      attrs: { href: "#nav-image-optimization" }
                    },
                    [_vm._v("Image Optimization")]
                  ),
                  _vm._v(" "),
                  _c("ul", [
                    _c(
                      "li",
                      { staticClass: "dvs-flex" },
                      [
                        _c("item-check", {
                          staticClass: "dvs-mr-2",
                          attrs: {
                            item: _vm.checklist.image_optimization.gifsicle,
                            size: 15
                          }
                        }),
                        _vm._v(" "),
                        _c(
                          "a",
                          {
                            staticClass: "scrollactive-item",
                            attrs: { href: "#nav-image-optimization" }
                          },
                          [_vm._v("Gifsicle")]
                        )
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "li",
                      { staticClass: "dvs-flex" },
                      [
                        _c("item-check", {
                          staticClass: "dvs-mr-2",
                          attrs: {
                            item: _vm.checklist.image_optimization.jpegoptim,
                            size: 15
                          }
                        }),
                        _vm._v(" "),
                        _c(
                          "a",
                          {
                            staticClass: "scrollactive-item",
                            attrs: { href: "#nav-image-optimization" }
                          },
                          [_vm._v("Jpegoptim")]
                        )
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "li",
                      { staticClass: "dvs-flex" },
                      [
                        _c("item-check", {
                          staticClass: "dvs-mr-2",
                          attrs: {
                            item: _vm.checklist.image_optimization.optipng,
                            size: 15
                          }
                        }),
                        _vm._v(" "),
                        _c(
                          "a",
                          {
                            staticClass: "scrollactive-item",
                            attrs: { href: "#nav-image-optimization" }
                          },
                          [_vm._v("Optipng")]
                        )
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "li",
                      { staticClass: "dvs-flex" },
                      [
                        _c("item-check", {
                          staticClass: "dvs-mr-2",
                          attrs: {
                            item: _vm.checklist.image_optimization.pngquant,
                            size: 15
                          }
                        }),
                        _vm._v(" "),
                        _c(
                          "a",
                          {
                            staticClass: "scrollactive-item",
                            attrs: { href: "#nav-image-optimization" }
                          },
                          [_vm._v("Pngquant")]
                        )
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "li",
                      { staticClass: "dvs-flex" },
                      [
                        _c("item-check", {
                          staticClass: "dvs-mr-2",
                          attrs: {
                            item: _vm.checklist.image_optimization.svgo,
                            size: 15
                          }
                        }),
                        _vm._v(" "),
                        _c(
                          "a",
                          {
                            staticClass: "scrollactive-item",
                            attrs: { href: "#nav-image-optimization" }
                          },
                          [_vm._v("Svgo")]
                        )
                      ],
                      1
                    )
                  ])
                ])
              ])
            ])
          ])
        ]
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
    require("vue-hot-reload-api")      .rerender("data-v-61d14ea1", module.exports)
  }
}

/***/ }),
/* 578 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(579)
/* template */
var __vue_template__ = __webpack_require__(580)
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
Component.options.__file = "src/components/utilities/DeviseLogo.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-76de9066", Component.options)
  } else {
    hotAPI.reload("data-v-76de9066", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 579 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//


// currently unused but we need to optimized if we want to use this in the future

/* harmony default export */ __webpack_exports__["default"] = ({
    props: {
        color: {
            default: '#fff'
        }
    }
});

/***/ }),
/* 580 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c(
      "svg",
      {
        attrs: {
          xmlns: "http://www.w3.org/2000/svg",
          viewBox: "0 0 175.58 58.56"
        }
      },
      [
        _c("title", [_vm._v("Devise Logo")]),
        _c("path", {
          attrs: {
            id: "devise-logo-path",
            fill: _vm.color,
            d:
              "M72.3,52.47a.79.79,0,0,1,.07-.44s.13,0,.23,0v-.33c.23-.06.07-.24.12-.36s.15-.12.09-.2-.13-.17,0-.3c.35-.4.46-.93.77-1.36-.12-.26.18-.3.26-.48.29-.56.61-1.11,1-1.64.11-.16.32-.25.46-.4a6.43,6.43,0,0,0,.83-1,8.3,8.3,0,0,1,1.38-1.46,8,8,0,0,1,1.75-1.41,8.66,8.66,0,0,0,1.38-1.25.66.66,0,0,0,.55.07L81,41.82c.69-.43,2.12-.17,2.64-.85.38-.49,4.65-1.22,4.7-.58,0,.15.18-.22.21,0s.1.12.2.14c.31.07.61.17.92.24.14,0,.23,0,.22-.18a.17.17,0,0,1,.15,0c.14,0,0,.09,0,.15a1.92,1.92,0,0,0,0,.35l.16-.15c.1.07,0,.37.3.19s.61,0,.89.17a1.64,1.64,0,0,1,.29.16c.27.21,0-.19.19-.12.38.14,1.63,1.06,2,1.14a6.16,6.16,0,0,1,1.18,1,8.77,8.77,0,0,0,.61.89c.06.07.1.16.16.23.23.28.5.54.45,1a.2.2,0,0,0,.1.18.36.36,0,0,1,.26.44s.09.09.14.12.12.14,0,.23-.32.26-.13.49l.17-.35v1l.25-.12a4,4,0,0,1,0,.78,2.68,2.68,0,0,1,0,1.35c0,.12-.09.24-.12.37a.28.28,0,0,0,.07.13l.15-.13v.71L97,50.35a6.68,6.68,0,0,0-.16.74s.07.1.11.15c-.17.21-.11.46-.12.7s.07.24-.12.26a.48.48,0,0,0,0-.12l0-.1a.39.39,0,0,0-.08.1.48.48,0,0,0,0,.12l-.12.16c.15.1.07.24,0,.31s-.19.59-.45.77c.07.13-.26.24,0,.38,0,0,0,.12,0,.16.33-.35-2.38,2.39-2.36,2.54a.17.17,0,0,1-.1.12,7.47,7.47,0,0,0-1.1.54l.12.13a4.62,4.62,0,0,0-1,.29c0-.22-.21-.13-.3-.1a3.08,3.08,0,0,0-.45.22h0a.25.25,0,0,0,0-.09s0,0-.07,0a.29.29,0,0,0,.08.07c0,.1.08.25-.11.24s-.48-.08-.63,0-.37-.14-.73,0c-.13,0-.12,0-.1,0h.28v-.05c-.1,0-.21,0-.31-.06s0,0,.13.08a1.19,1.19,0,0,1,.47.26H88.64l.14.36c-.2,0-.44-.16-.58-.09a11,11,0,0,1-1.28-.05c-.35-.17-.69,0-1-.09-.12.24-.3-.13-.48.07a2,2,0,0,1-1.12-.07l-.37.12c-1.32-.09-2.64.16-4,.12-.09,0-.25,0-.26-.07a2.29,2.29,0,0,0-.94-.05A3,3,0,0,0,79,60.22s-.08.15-.15.18.14.25.22.36.08,0,.12,0h.13V61l-.12.09.12.15c.09.65.46,1.21.6,1.85.45.42.29,1.12.71,1.56-.13.35.24.54.28.85s.33.49.34.81c.19.23.38.46.55.7a.83.83,0,0,1,0-.2c.08-.08.18-.09.23,0a9.83,9.83,0,0,1,.47,1.77l.34-.16a3.42,3.42,0,0,0,.63,1c-.29.08-.34-.3-.67-.35a1.47,1.47,0,0,0,.79.71v-.24a1.79,1.79,0,0,1,.72.48l-.57-.13,0,.09c.06,0,.16,0,.17,0,0,.29.38.37.43.65,0,.06.11.29.29.09,0,0,.18,0,.27,0a3.91,3.91,0,0,0,.8.17c.23,0,.15,0,.1-.12s-.21.16-.33,0c0,0-.06.08-.06.12s.12.13.21.12.26.27.08-.16c-.33-.16-.37-.24-.41-.32s.21,0,.23-.09a.48.48,0,0,0-.47-.27v-.12c.3,0,.3,0,.44-.27a1.59,1.59,0,0,0,.16.32c.09.1.17.31.37.12l.08,0c.24.41.73,0,1,.33.24-.2.52-.09.77-.12A1,1,0,0,0,89,71s.09,0,.1,0a1.76,1.76,0,0,0,1.11.33,4.63,4.63,0,0,0,2.5-.6c.37-.17.76-.3,1.12-.48a3.44,3.44,0,0,0,1-.69c.25-.26.5-.52.76-.76A18.29,18.29,0,0,0,97,67.32l0,.1.08-.1a1.08,1.08,0,0,0,.76-.72s0-.09.08-.13a2.86,2.86,0,0,1,.76-.93.28.28,0,0,0,.08-.15c.07-.35.44-.47.59-.76.34,0,.36-.35.45-.58s.42-.53.43-.9a2.67,2.67,0,0,1,.09-.26c0-.15-.11-.38.2-.39a.35.35,0,0,0,0-.16v-.45l.17.14s.07-.09.06-.12-.08-.17-.1-.26.07-.06.17-.06,0,0,0,0l0,0,.07.06s0,0,0-.08c-.1-.22,0-.35.12-.5a13.46,13.46,0,0,0,.65-1.58c0-.1,0-.26.18-.23,0,0,.06-.06,0-.07-.22-.54-.11-1.13-.32-1.67a2.69,2.69,0,0,1-.13-.9,11.72,11.72,0,0,1-.38-2.49,3.12,3.12,0,0,0-.11-.67c-.08-.53-.16-1.06-.23-1.59-.08-.23,0-.53-.07-.75a4.08,4.08,0,0,1-.3-1.19,2.29,2.29,0,0,1-.11-.49,7.73,7.73,0,0,0-.46-2.09c-.79-2.67-2.49-4.7,1-5.62l1.24-.47a.89.89,0,0,1,.56,0c.79.41,1.57.87,2.32,1.36a2.59,2.59,0,0,1,1.22,1.4,11.37,11.37,0,0,1,.85,1.62c.28.55.64,1,.89,1.62a8.61,8.61,0,0,1,.55,1.81,15.62,15.62,0,0,0,.39,1.64,6.15,6.15,0,0,1,.43,1.8,12.11,12.11,0,0,0,.32,2.32q.09,1.47.06,2.94c.19.14-.1.25,0,.39a.8.8,0,0,1,.11.37,1.53,1.53,0,0,0,.21.88c.08.13,0,.37,0,.56s-.09.34,0,.43a9.43,9.43,0,0,0,.2,1.06c.09.56.2,1.11.33,1.67a4.88,4.88,0,0,0,.38,1.34c0,.15-.15.38-.08.47a.65.65,0,0,1,.09.5c0,.08-.09.16-.11.25s0,.24,0,.43c.11-.06.22-.08.23-.12a3.85,3.85,0,0,0,0-.48,1.9,1.9,0,0,1,.29,1,.26.26,0,0,1,.07.15,7.25,7.25,0,0,1,.12,1.39.93.93,0,0,0,.21.7c.17.42.31.85.44,1.29l.13-.28.13.12a1.19,1.19,0,0,1,.3-.73,2.24,2.24,0,0,0,.35-.81,8.38,8.38,0,0,1,.37-1,9.26,9.26,0,0,1,.65-2,4.29,4.29,0,0,1,.33-1,.64.64,0,0,0,.08-.64,1.71,1.71,0,0,1,.46-.94c.11-.12.13.12.21.25.07-.27.11-.52.18-.75s.21-.47.34-.77l0,.65.35-.17a.56.56,0,0,1,0-.61c0-.05.1-.1.09-.14a35.54,35.54,0,0,1,1-4,.47.47,0,0,0,0-.16,3.19,3.19,0,0,1,.34-1.42,2.29,2.29,0,0,0,0-.42,19,19,0,0,0-.82,2l-.28-.16v.47h-.07l-.12-.27c-.07.22,0,.47-.29.52a5.29,5.29,0,0,1,.39-1.76c.22-.82.53-1.57.79-2.37a.39.39,0,0,0,0-.28c0-.07-.07-.09,0-.18s.15-.27.11-.31a3.1,3.1,0,0,1,.3-.57c.11-.47.46-.88.36-1.41.09-.56.2-1.12.31-1.67.12-.15.08-.39.16-.59a5.23,5.23,0,0,0,.15-.66,1.57,1.57,0,0,0,0-1.11,1.39,1.39,0,0,1,.32-1.36c.28-.33.69-.55.92-.93.11-.19.2-.36.42-.41,0-.26.25-.35.39-.5s.35-.24.49-.39.49-.1.73-.13c0,0,.1.06.13.1a7.45,7.45,0,0,1,.79,4.48,4.57,4.57,0,0,0,.23,1.76,9.9,9.9,0,0,1-.71,2.82,10.13,10.13,0,0,1-.7,1.63,3.64,3.64,0,0,1-.27.6,7.41,7.41,0,0,0-.72,2,16.76,16.76,0,0,0-.36,1.71c-.14.79-1.56,2.56-1.08,3.36.1.17.06.42.14.6a3.74,3.74,0,0,0,.94,1.15c.08.71,2.5,1,2.87.56.17-.21.55-.19.62-.53,0-.14.31,0,.24-.25.57-.43.7-1.17,1.17-1.68a2.19,2.19,0,0,0,.27-.6c0-.09.06-.2.13-.25.25-.19.26-.49.35-.76,0-.1,0-.25.12-.3.3-.22.25-.63.48-.89-.1-.35.28-.58.24-.92.16-.11.12-.27.12-.43,0-.36,0-.72,0-1.08a2.75,2.75,0,0,1,.1-1,.62.62,0,0,0-.06-.62c-.06-.07,0-.22,0-.34,0-2.3,0-4.6,0-6.9a6,6,0,0,1,.2-1.17,6.74,6.74,0,0,0,0-1c0-.24.07-.48.1-.72.19,0,.36,0,.45,0s.5-.27.42-.65a.59.59,0,0,1,.33-.7.86.86,0,0,1,1.05-.66c.13-.09-.07-.4.24-.37.22-.26.63-.32.71-.76l.43.31c.18-.27.21-.29.6-.51.37.16.38.6.72.93a2.65,2.65,0,0,0-.58-1.28c.94.29,2.67.23,2.82,1.73A5.87,5.87,0,0,0,134.7,44c.3.82.48,1.68.78,2.49a2,2,0,0,0,.13.91,8.74,8.74,0,0,1,.12,1.69,3.75,3.75,0,0,0,.11.67c0,.23-.11.49.12.68,0,.34.1.7-.09,1a.2.2,0,0,0,0,.11,11.39,11.39,0,0,0,0,1.85,3.22,3.22,0,0,1,0,1.66s0,.08,0,.1A32.16,32.16,0,0,1,136,59c0,.34.14.64.13,1a14.75,14.75,0,0,0,.11,2c-.06.91.18,1.8.14,2.71a3,3,0,0,0,.11,1.23c0,.3.2.59.12.91a.18.18,0,0,0,0,.1.78.78,0,0,1,.3.59,3.36,3.36,0,0,0,1.48,2c.11.3.45,0,.61.25a2.35,2.35,0,0,0,1.26-.09c.05,0,.12,0,.15-.06a9,9,0,0,0,1.35-1.48,7.66,7.66,0,0,0,.45-1,.87.87,0,0,0-.28-.72c-.41-.28-.41-.28-.44-.6a.83.83,0,0,0-.07-.27c-.12-.22,0-.4.11-.68,0,0-.05.07,0,.09l.18.12s.07-.1.05-.14-.08-.08-.19-.07c-.34.11-.43.36-.28.73a1.75,1.75,0,0,1-.24-.15,1.91,1.91,0,0,1-.24-.32.47.47,0,0,1-.11-.25,2.31,2.31,0,0,0-.12-.67,1.19,1.19,0,0,1,.06-1.05,4.09,4.09,0,0,1,.23.47,6,6,0,0,1,.54-1.14,2.12,2.12,0,0,0,.43-.42l.11.29a.43.43,0,0,1,.49-.41s.18,0,.27,0,.11-.07.15-.06a3.77,3.77,0,0,0,.43.1,3.48,3.48,0,0,0,.44-.1.24.24,0,0,1,.2.06l.46.49a3.38,3.38,0,0,0,.65-.95c.19-.38.38-.77.54-1.15s.35-.74.52-1.11c.26-.56.38-1.16.59-1.73.34-.94.63-1.9,1-2.82.15-.58.29-1.16.42-1.75a.27.27,0,0,1,0-.15,3.61,3.61,0,0,0,.31-1.2c.13-.5.21-1,.35-1.53a12.65,12.65,0,0,1,.85-2.05,22.73,22.73,0,0,1,1.44-2.4,4.44,4.44,0,0,1,.58-1.07c0-.21.23-.12.26-.25s.07-.21.1-.32.07-.36.12-.55c.13-.44.17-.89.68-1.09l0,0c.25-.68,1-.63,1.47-.92a10.49,10.49,0,0,0,1.83-.78,4.85,4.85,0,0,1,1.86-.31,1.3,1.3,0,0,0,.87-.06c.24-.15.56.1.77-.17a2,2,0,0,1,1.88,0c.2.44.69.59,1,1a7.12,7.12,0,0,1-1.58.91,1.83,1.83,0,0,1-.62.53c-.23.1-.42.25-.64.35s-.46,0-.6.27c-.38,0-.38.5-.7.6-.06,0-.1.22-.07.32.11.44.16.89.25,1.34s.31,1.16.4,1.74a14.69,14.69,0,0,1,.44,2,6,6,0,0,0,.21.86c.06.28,0,.58.12.85,0,.08,0,.2,0,.3a11.16,11.16,0,0,0,.2,1.29,8.55,8.55,0,0,0,.7,2,3.18,3.18,0,0,0,.09.33,7.4,7.4,0,0,0,.43.84,1.61,1.61,0,0,1,.38.92c.28.27.28.72.59.95s.07.3.17.42a17.69,17.69,0,0,1,1.39,2.48,12.28,12.28,0,0,1,1,2.74,2.78,2.78,0,0,1,0,2c.09.43-.16.83-.12,1.27a2.48,2.48,0,0,0-.25,1.48c0,.1-.12.21-.1.31s-.12.35-.17.53a2.61,2.61,0,0,0-.22.51.87.87,0,0,1-.29.47,7.39,7.39,0,0,1-1.23,1.09,7,7,0,0,0-1.25,1,.93.93,0,0,1-.22.08L161,72l-.77.36a2,2,0,0,0,.36,0A3.34,3.34,0,0,0,162,72c.65-.32,1.3-.64,1.94-1,0,.4-.09.48-.45.6a1.42,1.42,0,0,0-.63.36.65.65,0,0,0-.12.15v0a.25.25,0,0,0-.09,0s0,0,0,.07a.29.29,0,0,0,.07-.08.65.65,0,0,1,.12-.15.33.33,0,0,1,.31.11c.07-.12.19-.11.31-.11s.29-.22.38-.34a1.74,1.74,0,0,1,.26-.37c.11-.09.28-.1.4-.18a1.11,1.11,0,0,0,.53-.48c.13-.27,0-.24-.15-.31a3.51,3.51,0,0,1,1-1c.05,0,.12-.07.13-.12.11-.39.56-.41.76-.7,0,.33-.33.46-.49.68s-.29.41-.44.62c-.15-.13-.15-.13-.36.12h.24v.12a.25.25,0,0,0-.09,0s0,0,0,.07a.29.29,0,0,0,.07-.08.65.65,0,0,1,.12-.15h.24l0,.1.08-.1.1,0-.1-.08c0-.25.31,0,.41-.21s.24-.17.34-.27a.85.85,0,0,0,.09-.24l.12-.12a1.14,1.14,0,0,0,.15-.18s0,0,0,0l.05,0,.06-.07s0,0-.08,0a1.93,1.93,0,0,1-.27.3l-.37.18c.07-.23.22-.29.29-.41s.07-.25.13-.36a.25.25,0,0,1,.31-.13c.25.07.4-.09.55-.25a15.8,15.8,0,0,0,1.1-1.19l-.33.12.12-.6c.57-.13.74-.33.52-.59a1.08,1.08,0,0,0-.3.11.52.52,0,0,0-.1.18l-.12.3-.36.24c0-.06,0-.15,0-.18.2-.34.41-.67.64-1a3.69,3.69,0,0,0,.79-.93,1.34,1.34,0,0,0,.18-.53,1.51,1.51,0,0,0-.17-.52s-.06-.06-.06-.1c-.15-.58-.29-1.16-.42-1.75a.17.17,0,0,1,0-.17,20.87,20.87,0,0,0-.25-3.1c.09-.51.18-1,.25-1.52s.63-2.73.48-3.22c.31-.4.24-.91.37-1.35a2.88,2.88,0,0,1,.42-1,1.87,1.87,0,0,0,.28-.78,15.59,15.59,0,0,1,1.43-2.71c.29-.49.7-.9,1-1.38.56-.54,1.1-1.09,1.64-1.64s1.32-.94,1.9-1.51c.86-.57,1.73-1.12,2.61-1.66a7.89,7.89,0,0,1,2.29-1c.49-.11,1-.27,1.46-.4a10.22,10.22,0,0,1,5.15.2,1.65,1.65,0,0,0,.57.22,2.07,2.07,0,0,1,.55.11,6.74,6.74,0,0,1,2.09.74A7.81,7.81,0,0,1,193.24,43c.28.4.63.78.93,1.18a1.47,1.47,0,0,1,.28.54c.15.52.3,1,.43,1.57a9.37,9.37,0,0,1,.24,2.48,5.72,5.72,0,0,1-.3,2.81,9.79,9.79,0,0,0-.62,1.6,2.59,2.59,0,0,1-.46.89,16.44,16.44,0,0,0-1,1.3s0,0,0,0c-.6.24-.88.84-1.34,1.23a7.15,7.15,0,0,1-1.84,1.21,12,12,0,0,1-2.43.82,17.57,17.57,0,0,1-3.77.59c-1.4-.12-4.64.23-5.44.23,0,.1,0,.2,0,.25a4.39,4.39,0,0,1,.37,1.41,12.18,12.18,0,0,0,.36,1.35A8.85,8.85,0,0,1,179.3,64a.91.91,0,0,0,.29.47,6,6,0,0,1,.66.87,7.69,7.69,0,0,0,.87,1,5.32,5.32,0,0,1,.93,1.18,3.31,3.31,0,0,0,.58.47,9,9,0,0,0,3,2,4.07,4.07,0,0,0,1,.31,6.38,6.38,0,0,0,1.14.3c.11,0,.22.06.33.07a6.08,6.08,0,0,0,2.17-.12,3,3,0,0,0,.6,0A9.93,9.93,0,0,0,192.1,70a3.39,3.39,0,0,0,.93-.67,17.63,17.63,0,0,1,1.69-1.55c.41-.3.63-.73,1-1a7,7,0,0,0,.86-1.07,13.23,13.23,0,0,1,1.21-1.48,10.47,10.47,0,0,1,1.32-1.42c.41-.4.84-.77,1.26-1.15a.54.54,0,0,1,.76.19.48.48,0,0,1,0,.58.79.79,0,0,0,0,.3c.14,0,.27-.08.32,0s.18.24.15.28c-.17.25-.06.45,0,.7a.63.63,0,0,1-.19.7.58.58,0,0,0-.15.4,1.43,1.43,0,0,1-.83,1.26,6.46,6.46,0,0,0-1.22,1.23,5.61,5.61,0,0,0-.85,1.15c-.15.27-.38.48-.54.74a17.84,17.84,0,0,1-5.7,5.14,1,1,0,0,1-.68.24.21.21,0,0,0-.15.07,3.88,3.88,0,0,1-1.58.83c-.43.16-.84.38-1.27.54a9.32,9.32,0,0,1-1.35.37,10.27,10.27,0,0,1-2,.11,3.54,3.54,0,0,1-1.29-.22,1.37,1.37,0,0,0-.35,0A3.49,3.49,0,0,1,182,76a.59.59,0,0,0-.23,0,1.89,1.89,0,0,1-.95-.19,3.62,3.62,0,0,0-1.06-.17c-.09,0-.22.05-.16-.18,0,0,0,0-.06,0s0,.06.06.06l.17-.07s-.06,0-.17,0-.36.17-.36-.12c0,0,0,0-.06,0s0,.06.06.06l.17-.07s-.06,0-.17,0-.29.12-.3-.06l.1,0-.1-.08,0-.1-.08.1a.54.54,0,0,1-.22-.05c-.15-.08-.27-.22-.42-.28a16.31,16.31,0,0,1-2.83-2.14A14.68,14.68,0,0,1,173,70.58a4.74,4.74,0,0,1-.69-1,1.12,1.12,0,0,0-.3-.35.37.37,0,0,0-.26,0c-.08.36-.45.19-.63.37a1.9,1.9,0,0,1-.6.43,4.69,4.69,0,0,0-1.33,1,4.59,4.59,0,0,1-.52.33c-.16.1-.33.18-.48.27s0,.1-.08.14a1.16,1.16,0,0,1-.23.26c-.15.11-.36.1-.46.33a1.58,1.58,0,0,1-.46.47A6.13,6.13,0,0,1,165.4,74a3,3,0,0,0-.62.38,1,1,0,0,1-.6.31s-.05,0-.06,0c-.28.4-.76.37-1.16.53a6.41,6.41,0,0,0-.76.32c-.28.15-.59.09-.88.21a11.15,11.15,0,0,0-1.52.23c-.05,0-.19,0-.29,0l-1.4-.23h-.06c-.24,0-.48,0-.72,0a6,6,0,0,0-.61-.11,5.16,5.16,0,0,0-1.18,0,6,6,0,0,0-1,.44c-.09-.29-.09-.29.14-.58l-1.32-.15c-.17,0-.33-.09-.49-.12a7,7,0,0,1-2-.63c-.23-.11-.49,0-.7-.2a2.25,2.25,0,0,0-.69-.35c-.59-.31-1.18-.64-1.75-1a5.83,5.83,0,0,1-.7-.49,16.57,16.57,0,0,0-1.6-1.19c-.27-.19-.52-.39-.78-.58s-.43-.31-.65-.46c.19-.23.3-.5,0-.77-.11.14-.29.26-.34.42a13.68,13.68,0,0,1-2.42,3,2.53,2.53,0,0,1-.63.5,1.93,1.93,0,0,0-.54.44,11.48,11.48,0,0,1-2.72,1.4c-.34,0-.56.35-.94.25h0a.25.25,0,0,0,0-.09s0,0-.07,0a.29.29,0,0,0,.08.07c-.1.23-.32.24-.55.24-.42,0-.84,0-1.25,0a1,1,0,0,1-1-.48c.23,0,.44.16.56-.1a1.05,1.05,0,0,0,.24.08c.07,0,.11-.17.21,0a.11.11,0,0,0,.08,0s0-.1,0-.11a1.54,1.54,0,0,0-1.12-.33c-.15.07-.29.16-.44.24,0-.16.07-.35-.2-.4,0,0-.05-.2-.08-.32-.13.14-.25.17-.38,0a5.16,5.16,0,0,0-1-1l0-.1-.08.1h-.12c.06-.36-.05-.62-.44-.69l-.15.14.11.19c-.09,0-.23-.06-.24.12h-.06c0-.16-.08-.32-.13-.47-.14.22-.24-.09-.37,0-.21-.37-.67-.62-.59-1.17l-.09.2c-.18-.26-.38-.52-.56-.8a4.41,4.41,0,0,1-1-2.05.88.88,0,0,0-.12-.5,1.52,1.52,0,0,1-.12-.36,16.53,16.53,0,0,0-.33-2,5.45,5.45,0,0,0-.26-1.44,1.38,1.38,0,0,0,0-1.16.33.33,0,0,1,0-.28c.16-.16.07-.34.09-.51s0-.45-.21-.48a2.78,2.78,0,0,0-1.15,1.29,4.61,4.61,0,0,0-1,1.14c-.09.2-.36,0-.45.29s-.28.33-.45.47c-.56.49-1.25.89-1.84,1.33-.09-.09-.19-.2-.28,0a.48.48,0,0,0-.12,0l-.1,0a.21.21,0,0,0,.22.08c0,.16-.13.12-.21.12a5,5,0,0,1-1.27.13c-.26.09-.55,0-.77.16s-.21-.16-.34,0a1.61,1.61,0,0,1-.28.17c-.16.09-.32-.18-.5,0s-.34,0-.55-.07a4.3,4.3,0,0,1-.1.72c-.06.21-.27.33-.42.49,0-.21-.09-.31-.29-.38a3.91,3.91,0,0,0-.32,1.24c.31-.15.26-.49.49-.62a2.13,2.13,0,0,1-.27.92s-.14,0-.21,0a.48.48,0,0,0,0-.12l0-.1a.39.39,0,0,0-.08.1v.12a.25.25,0,0,0-.09,0s0,0,0,.07a.29.29,0,0,0,.07-.08.18.18,0,0,1,.12,0v.12a4.37,4.37,0,0,1-1,2.6c-.28.46-.55.92-.81,1.4-.16.32-.15.32.13.57-.25.37-.72.12-1,.34,0,0-.09-.07-.15-.13l-.09.44-.4-.3s-.09,0-.1,0-.07.13,0,.16a1.88,1.88,0,0,0,.24.25c0,.39-.42.31-.63.39a.55.55,0,0,1-.7-.2,1.61,1.61,0,0,1,0,.22c0,.05-.06.11-.1.11a.16.16,0,0,1-.14-.07l-.2-.59a3,3,0,0,1-.17.59c-.06.12-.18.33-.34.13s-.32.21-.43,0c-.2.46-.52.12-.79.15a1.87,1.87,0,0,1-.64-.12,5.49,5.49,0,0,1-.69-.21,2.52,2.52,0,0,1-.94-.54l.1,0a.49.49,0,0,0-.13-.08h0a.25.25,0,0,0,0-.09s0,0-.07,0a.29.29,0,0,0,.08.07.18.18,0,0,1,0,.12c-.38,0-.52-.35-.72-.6,0-.06-.07-.15-.13-.18s0-.18,0-.27-.07-.1-.11-.15a1,1,0,0,0-.55-1c0-.06-.16,0-.26-.08,0-.34,0-.33-.43-.64a.5.5,0,0,1-.19-.27c-.13-.53-.56-.93-.62-1.48-.25-.47-.51-.93-.78-1.39-.07-.06-.16-.15-.16-.23,0-.43-.41-.72-.39-1.15-.33-.26-.33-.67-.44-1s-.17-.56-.26-.84c0,0-.08-.07-.12-.1s.23-.22,0-.4,0-.29-.1-.44c0,.2-.21.37-.07.59,0,0,0,.11-.07.13-.28.14-.28.13-.43.52,0,0-.06.06-.09.08-.23.13-.43.27-.33.6l.59-.49c-.08.23-.09.39-.14.4-.24.08-.24.36-.46.45a3,3,0,0,0-1,1.11.6.6,0,0,0-.08.08L100.2,68a2.79,2.79,0,0,0-.53,1c.29-.15.41-.37.67-.55a1.17,1.17,0,0,1-.1.29l-.46.47c-.09.09.15.24-.06.3a1.64,1.64,0,0,1-1,1l.09-.53-.26.16c-.14.07-.21.41-.46.14l-.39.34H98s0,.1,0,.1a1.2,1.2,0,0,0-.68.25c-.17.1-.28.35-.55.26,0,0,0,0,0,0s-.14.18-.12.24.14.09.23,0,.09,0,.12,0a.26.26,0,0,1,0,.12c-.28,0-.43.3-.74.3a1.3,1.3,0,0,1,.1-.15s0-.07,0-.1a.56.56,0,0,0-.15.1s0,.1.08.15a2,2,0,0,1-.81.47,1.81,1.81,0,0,1,.25-.3.48.48,0,0,0,.14-.36s0,0,0,0l0,0,.06-.07s0,0-.08,0c-.29.33-.7.42-.87.81v0a.25.25,0,0,0-.09,0s0,0,0,.07a.29.29,0,0,0,.07-.08.73.73,0,0,1,.26-.11l.22,0c0,.26-.3.28-.46.38a5.2,5.2,0,0,1-1,.52,2.84,2.84,0,0,1-.5.06l0-.1-.08.1c-.21-.07-.36.15-.55.11-.7.34-1.41.66-2.12,1a.73.73,0,0,0-.29.15,2,2,0,0,1-1.32.45,1.5,1.5,0,0,0-.85.4,7.19,7.19,0,0,1-1.07.46c-.07,0-.13.09-.2.1a9,9,0,0,1-3.57.12c-.37,0-.76,0-1.13,0a.43.43,0,0,1-.21-.09c-.12-.11-.22-.25-.37,0l-.22-.17.24-.09c-.22-.24-.59-.22-.82-.44l.12-.12h.12c0,.18.15.1.38.16.06,0,0,0,0,0a.4.4,0,0,0-.11,0s0,.1.08.11.1,0,.06-.07c-.15-.22-.29-.14-.38-.16l0-.1-.08.1h-.12a.25.25,0,0,0,0-.09s0,0-.07,0a.29.29,0,0,0,.08.07.18.18,0,0,1,0,.12c-.31-.06-.42-.17-.42-.54,0,0,0,0-.06,0s0,.06,0,.06l.18-.07s-.06,0-.17,0a2.54,2.54,0,0,1-.78-.42H80a4.71,4.71,0,0,1-.53-.48q-.33-.08-.27-.36c-.16,0-.13.12-.13.21a.83.83,0,0,0,0,.15h.36a1.11,1.11,0,0,0,0,.36,4.38,4.38,0,0,1-.84-.42l-.38-.38a4.08,4.08,0,0,0-1.06-.88l-.48-.39v.27l-.3-.36-.06,0,.13.42-.09.05-.94-1.1a13.47,13.47,0,0,1-1-1,6.85,6.85,0,0,1-.7-1c-.45-.15-1.34-2-1.51-2.36A8.32,8.32,0,0,1,71.79,66,8,8,0,0,1,71.4,64a2.13,2.13,0,0,0-.07-.27c0-.2-.16-.38-.06-.61a.35.35,0,0,0-.11-.42V59.62a4.25,4.25,0,0,0,.11-1.74,7.42,7.42,0,0,1,.24-1.94,3.23,3.23,0,0,0,0-.54c0-.15.09-.28.12-.43.13-.63.22-1.26.39-1.88a.5.5,0,0,1,.27-.62s0,0,0,0l-.05.05.07.06S72.34,52.52,72.3,52.47Zm70,12.28-.06-.07-.05,0,.07.06s0,0-.12-.11h0a.25.25,0,0,0,0-.09s0,0-.07,0A.64.64,0,0,0,142.31,64.75Zm-22,0-.06-.07-.05,0,.07.06s0,0-.07-.11l-.12-.12c-.12-.22-.12-.23.23-.17l-.06-.07-.05.05.07.06s0,0-.07-.11l-.49-.36s-.07,0-.11,0l-.21-.29c0,.19-.13.34.09.41s.27.48.6.48A1.65,1.65,0,0,0,120.35,64.75Zm.36-.12-.06-.07-.05,0,.07.06s0,0-.12-.11h0a.25.25,0,0,0,0-.09s0,0-.07,0A.64.64,0,0,0,120.71,64.63Zm78.85-.79a5.12,5.12,0,0,0,.55-.59l-.07.06.05,0,.06-.07s0,0-.11.07a2.18,2.18,0,0,0-.48.53v0a.25.25,0,0,0-.09,0s0,0,0,.07A.2.2,0,0,0,199.56,63.84Zm-125,2.83-.06-.07,0,.05.07.06s0,0-.12-.11h.05a.25.25,0,0,0,0-.09s0,0-.07,0A.64.64,0,0,0,74.51,66.67Zm100-.12-.06-.07,0,0,.07.06s0,0-.12-.11h.05a.25.25,0,0,0,0-.09s0,0-.07,0A.64.64,0,0,0,174.47,66.55Zm-64.56-4.2-.06-.07,0,0,.07.06s0,0-.12-.11h0a.25.25,0,0,0,0-.09l-.07,0A.64.64,0,0,0,109.91,62.35Zm26.89,7.37a1.65,1.65,0,0,0,.23.19l-.06-.07-.05,0L137,70s0,0-.07-.11a1,1,0,0,0-.29-.24h.05a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07Zm-3,0a1.65,1.65,0,0,0,.23.19l-.06-.07-.05,0L134,70s0,0-.07-.11a.5.5,0,0,0-.17-.12h.05a.25.25,0,0,0,0-.09l-.07,0A.2.2,0,0,0,133.8,69.72Zm-.48,0,.12.12.12.12.36.36s.08.08.07.1a2.64,2.64,0,0,1,.17.33c.08.34.48.44.56.79a.19.19,0,0,0,.13.1c.2,0,.22.16.29.31s.24.26.42,0c0,0,.1,0,.16-.06s-.08-.1-.12-.12a1.39,1.39,0,0,1-.86-.82.89.89,0,0,0-.7-.56l-.36-.36-.12-.12a1,1,0,0,0-.29-.24h0a.25.25,0,0,0,0-.09l-.07,0A.2.2,0,0,0,133.32,69.72Zm-35.4,0L98,69.6l.72-.72s.08-.08.19-.41a1.2,1.2,0,0,0-.07.18.4.4,0,0,0,0,.11s.1-.05.11-.08,0-.1-.11.08l-.12.12c-.44,0-.6.32-.72.72l-.24.24c-.09,0-.23-.06-.24.17V70a.25.25,0,0,0-.09,0s0,0,0,.07a.2.2,0,0,0,.07-.11c.09,0,.23.06.24-.12Zm37.43.31-.06-.07,0,.05.07.06s0,0-.12-.11h.05a.25.25,0,0,0,0-.09s0,0-.07,0A.64.64,0,0,0,135.35,70Zm-1.68-1.92-.06-.07-.05,0,.07.06s0,0-.07-.11l-.12-.12c0-.13-.07-.21-.11-.31s-.29-.24-.34-.44a9.57,9.57,0,0,1-.39-1.32s-.08-.06-.12-.09.11-.3-.12-.23c0-.23,0-.36,0-.42a.42.42,0,0,1-.11-.32.8.8,0,0,0-.05-.21.8.8,0,0,0,.17.82c0,.12-.11.3.12.36,0,.16-.17.33,0,.49-.08.36.17.63.29.94a1.37,1.37,0,0,0,.67.73A1.65,1.65,0,0,0,133.67,68.11Zm.37-.55.12.12c0,.06,0,.14,0,.18.36.5.67,1,1,1.55a1.21,1.21,0,0,0,.63.68.77.77,0,0,1-.1-.48l-.07.06.05,0,.06-.07s0,0-.11.07a4.69,4.69,0,0,1-.49-.76,2.81,2.81,0,0,0-1-1.28,1,1,0,0,0-.29-.24h0a.25.25,0,0,0,0-.09l-.07,0a.2.2,0,0,0,.11.07Zm41.15-.17-.06-.07,0,.05.07.06s0,0-.07-.11a.5.5,0,0,0-.17-.12H175a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07A1.65,1.65,0,0,0,175.19,67.39Zm-40.32,1.92-.06-.07-.05.05.07.06s0,0-.07-.11l-.12-.12c0-.09.06-.23-.12-.24a.22.22,0,0,0-.21-.07c.06-.07.09-.09.09-.11a.8.8,0,0,0,0-.15l-.08,0a.2.2,0,0,0,.11.19l.12.12c0,.09-.06.23.12.24A1.65,1.65,0,0,0,134.87,69.31Zm41.53-.67.12.12c0,.09-.06.23.23.31l-.06-.07-.05,0,.07.06s0,0-.07-.11.06-.23-.12-.24l-.12-.12a.5.5,0,0,0-.17-.12h.05a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07ZM77.23,45.49l-.07.06,0,.05.06-.07s0,0-.11.12v0a.25.25,0,0,0-.09,0s0,0,0,.07A.64.64,0,0,0,77.23,45.49Zm16.85-.13.12-.12h.18v.13l.07.48c.1.18.3.3.27.55,0,0,.14,0,.35-.42,0,.31-.16.48,0,.71a.37.37,0,0,1-.07.39,16,16,0,0,0,.22,1.59,1.22,1.22,0,0,0,.22-.78c0-.26,0-.52,0-.77,0,0-.05,0-.08-.08l-.08.35h-.13c.16-.45.16-.88-.19-1a.68.68,0,0,1-.12-.55c0-.31-.3-.48-.3-.77a2.59,2.59,0,0,0-1-.94c-.24.18.12.26.17.4s0,0,0,.06l-.1,0,.1.08V45l-.1,0,.1.08a.76.76,0,0,1,0,.14c-.14.23-.14.23,0,.58,0-.22,0-.41,0-.6h.12l.12.12,0,.1Zm62-.59-.07.06.05.05.06-.07s0,0-.11.12v0a.25.25,0,0,0-.09,0s0,0,0,.07A.64.64,0,0,0,156.07,44.77ZM94,44.11,93.89,44l0,.05.07.06s0,0-.12-.11h0a.25.25,0,0,0,0-.09s0,0-.07,0A.64.64,0,0,0,94,44.11ZM75.48,47a1.65,1.65,0,0,0,.19-.23l-.07.06.05.05.06-.07s0,0-.11.07a.5.5,0,0,0-.12.17V47a.25.25,0,0,0-.09,0s0,0,0,.07A.2.2,0,0,0,75.48,47Zm15.91,8.53-.07.06.05,0,.06-.07s0,0-.11.12v0a.25.25,0,0,0-.09,0s0,0,0,.07A.64.64,0,0,0,91.39,55.57Zm42.6-.12-.07.06.05.05.06-.07s0,0-.11.12v0a.25.25,0,0,0-.09,0s0,0,0,.07A.64.64,0,0,0,134,55.45ZM92.83,55l-.07.06,0,0,.06-.07s0,0-.11.12v-.05a.25.25,0,0,0-.09,0s0,0,0,.07A.64.64,0,0,0,92.83,55Zm-2.4-2.28-.07.06,0,0,.06-.07s0,0-.11.12V52.8a.25.25,0,0,0-.09,0s0,0,0,.07A.64.64,0,0,0,90.43,52.69ZM178,72.24h.05a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07l.12.12q.28,1,.84.6c.14.29.32.41.56.34,0,0,.05-.08,0-.1-.15-.22-.27-.48-.65-.48h0a.25.25,0,0,0,0-.09l-.07,0a.2.2,0,0,0,.11.07V73c-.19-.17-.38-.36-.59-.52a.82.82,0,0,0-.25-.08A.5.5,0,0,0,178,72.24Zm-14.59,0a.25.25,0,0,0-.09.16l-.06-.09c-.15.1-.3.27-.46.28-.35,0-.22.2-.2.39a6,6,0,0,0,.69-.62,1.65,1.65,0,0,0,.19-.23l-.07.06.05,0,.06-.07S163.52,72.14,163.44,72.24Zm-83,2.16v-.12l.4,0-.4-.33.1,0a.4.4,0,0,0-.15-.08h.05a.25.25,0,0,0,0-.09l-.07,0a.2.2,0,0,0,.11.07v.12h-.24l-.48-.36-.12-.12a.9.9,0,0,0-.6-.6l0-.1s0,.07-.06.21l-.08-.11s-.06.06-.06.08a.88.88,0,0,0,0,.15.33.33,0,0,0,.07-.23H79a.31.31,0,0,0,.11.31c-.23.22,0,.25.13.28a1.08,1.08,0,0,0,.36,0l.12.12c0,.33.08.35.48.36V74l-.1,0,.1.08a2.59,2.59,0,0,0,.35.31l-.06-.07,0,0,.07.06S80.5,74.48,80.4,74.4Zm3.47.19-.06-.07,0,0,.07.06s0,0-.12-.11h.05a.25.25,0,0,0,0-.09s0,0-.07,0A.64.64,0,0,0,83.87,74.59Zm93-2.76-.06-.07-.05,0,.07.06s0,0-.07-.11l-.12-.12-.12-.12-.12-.12a1,1,0,0,0-.29-.24h0a.25.25,0,0,0,0-.09l-.07,0a.2.2,0,0,0,.11.07l.12.12.12.12.12.12A2.59,2.59,0,0,0,176.87,71.83Zm-95.39,3v-.12c.11,0,.25-.05.24.15a1.5,1.5,0,0,0,.08.27,3.38,3.38,0,0,0,.64-.55s0-.07,0,0L81,74.31c0,.13-.12.28.21.4l-.06-.07,0,0,.07.06s0,0-.07-.11.11-.15.19-.1a.72.72,0,0,1,.17.22l-.1,0,.21.15-.06-.07,0,.05.07.06S81.58,75,81.48,74.88Zm101-3h.05a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07l.12.12c0,.38,0,.39.48.48,0,.18.15.1.24.12s.08.08,0,.08a1.14,1.14,0,0,0,1.25.35l-1.16-.31-.12-.12c0-.18-.15-.1-.24-.12l-.48-.48A.5.5,0,0,0,182.47,71.88Zm-73.68,3h0a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07L109,75c.06.23.06.23.33.45-.05-.22-.05-.22-.33-.45A.5.5,0,0,0,108.79,74.88Zm73.12-2.81-.06-.07,0,0,.07.06s0,0-.12-.11h.05a.25.25,0,0,0,0-.09l-.07,0A.64.64,0,0,0,181.91,72.07Zm-44.56-.19h.05a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07,1.65,1.65,0,0,0,.23.19l-.06-.07,0,0,.07.06s0,0-.07-.11A.5.5,0,0,0,137.35,71.88ZM95,71.88l0-.1-.08.1c-.25,0-.49.09-.6.41v-.05a.25.25,0,0,0-.09,0s0,0,0,.07a.2.2,0,0,0,.07-.11c.23,0,.46-.09.68-.15,0,0,0-.06,0-.09l.1,0ZM78.55,73.56h0a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07l0,.1s0-.07.15-.21l-.07.06,0,0,.06-.07s0,0-.11.07Zm13.85-.19v-.05a.25.25,0,0,0-.09,0s0,0,0,.07a.2.2,0,0,0,.07-.11l.12-.12a.29.29,0,0,0,.36-.24c.09,0,.23.06.36-.25l-.12.07s0,.06,0,.06l.18-.07s-.06,0-.23.07-.23-.06-.24.12a1.48,1.48,0,0,0-1.13.36c.16,0,.29,0,.34,0a.38.38,0,0,1,.31-.11ZM80,73.51,80,73.44l0,0c.12.09.1.07,0,0h0a.25.25,0,0,0,0-.09l-.07,0A.64.64,0,0,0,80,73.51Zm103.21.17s.08.08.1,0c.13.46.22.55.49.5a4.05,4.05,0,0,0-.47-.41.5.5,0,0,0-.17-.12h.05a.25.25,0,0,0,0-.09s0,0-.07,0A.2.2,0,0,0,183.24,73.68ZM94,72.53v0a.25.25,0,0,0-.09,0s0,0,0,.07a.64.64,0,0,0,.14-.22l-.07.06.05,0,.06-.07S94,72.38,94,72.53Zm14,1.75s.08.08.41.19l-.18-.07a.4.4,0,0,0-.11,0s0,.1.08.11.1,0-.08-.11a.5.5,0,0,0-.17-.12h0a.25.25,0,0,0,0-.09l-.07,0A.2.2,0,0,0,108,74.28ZM131.76,73l.12.12a2.18,2.18,0,0,0,.27.24l.33.28c0-.19-.13-.29-.36-.28q.06-.3-.24-.24a1,1,0,0,0-.29-.24h0a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07Zm20.47-.24h.05a.25.25,0,0,0,0-.09l-.07,0a.2.2,0,0,0,.11.07,1.65,1.65,0,0,0,.23.19l-.06-.07,0,0,.07.06s0,0-.07-.11A.5.5,0,0,0,152.23,72.72ZM82.8,71.28l-.1,0,.1.08,0,.1.08-.1.47.56-.23.08.45.31.15-.23.83.15a5.55,5.55,0,0,0-1.67-1,1,1,0,0,0-.29-.24h.05a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07l.12.12Zm54.07-.72h0a.25.25,0,0,0,0-.09s0,0-.07,0a.64.64,0,0,0,.22.14l-.06-.07-.05,0,.07.06S137,70.64,136.87,70.56Zm-40.39.6L96.6,71a.17.17,0,0,0,.1-.25c.3,0,.44,0,.35-.22a.39.39,0,0,0-.21.23l-.12.12L96.6,71a1,1,0,0,0-.24.29v0a.25.25,0,0,0-.09,0s0,0,0,.07a.2.2,0,0,0,.07-.11Zm18.24-.07v0a.25.25,0,0,0-.09,0s0,0,0,.07a.64.64,0,0,0,.14-.22l-.07.06,0,.05.06-.07S114.8,70.94,114.72,71.09Zm62.83,0h0a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07.42.42,0,0,0,.22.12h-.11l0,.36h.08a.47.47,0,0,0-.11-.35A.5.5,0,0,0,177.55,71Zm3.53,0a.5.5,0,0,0-.17-.12H181a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07,1.65,1.65,0,0,0,.23.19l-.06-.07,0,0,.07.06S181.18,71.12,181.08,71Zm-84.65-.47-.07.06,0,.05.06-.07s0,0-.11.07a.5.5,0,0,0-.12.17v0a.25.25,0,0,0-.09,0s0,0,0,.07a.2.2,0,0,0,.07-.11A1.65,1.65,0,0,0,96.43,70.57ZM81,70.56h0a.25.25,0,0,0,0-.09s0,0-.07,0a.64.64,0,0,0,.22.14l-.06-.07,0,0,.07.06S81.1,70.64,81,70.56Zm54.89-.24,0,.1.08-.1a.48.48,0,0,1,.23.07l-.06-.07,0,.05.07.06s0,0-.07-.11l0-.1-.08.1h-.12a.25.25,0,0,0,0-.09s0,0-.07,0A.2.2,0,0,0,135.84,70.32Zm-2.89.19-.06-.07,0,0,.07.06s0,0-.07-.11a.5.5,0,0,0-.17-.12h.05a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07A1.65,1.65,0,0,0,133,70.51Zm49.92,1.08-.06-.07-.05,0,.07.06s0,0-.12-.11h0a.25.25,0,0,0,0-.09s0,0-.07,0A.64.64,0,0,0,182.87,71.59Zm-48.24-1.08-.06-.07,0,0,.07.06s0,0-.12-.11h.05a.25.25,0,0,0,0-.09l-.07,0A.64.64,0,0,0,134.63,70.51Zm-60.81-20-.08-.11s-.06.06-.06.08a.88.88,0,0,0,0,.15.86.86,0,0,0,.14-.34l-.07.06,0,0,.06-.07S73.88,50.3,73.82,50.51Zm31.3.85c0,.09-.06.23.1.23s.17.34.12.42-.15.26,0,.44l.12-.25.16.29c0-.79,0-.79-.33-.89,0-.09.06-.23-.21-.19.06-.07.09-.09.09-.11a.8.8,0,0,0,0-.15s-.08,0-.08,0A.2.2,0,0,0,105.12,51.36Zm-24,22.75L81.05,74l0,0,.07.06s0,0-.07-.11-.15-.1-.29-.12h.05a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07C80.77,74.1,80.91,74,81.11,74.11Zm7.21-18-.12.07s0,.06,0,.06l.18-.07s-.06,0-.23.12v0a.25.25,0,0,0-.09,0s0,0,0,.07A1.28,1.28,0,0,0,88.32,56.15Zm86.4,13.93a.22.22,0,0,0-.21-.07c.06-.07.09-.09.09-.11a.8.8,0,0,0,0-.15l-.08,0a.2.2,0,0,0,.11.19l.12.12c0,.18.15.1.11.1.41.2.71.36,1,.5.05,0,.12,0,.23,0A1.8,1.8,0,0,0,175,70.2C175,70,174.81,70.1,174.72,70.08Zm-81.48-15-.12.07s0,.06,0,.06l.18-.07s-.06,0-.23.12v0a.25.25,0,0,0-.09,0s0,0,0,.07A1.28,1.28,0,0,0,93.24,55.07Zm84.23,15.44-.06-.07,0,0,.07.06s0,0-.07-.11.06-.23-.17-.24h.05a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07C177.26,70.29,177.18,70.43,177.47,70.51ZM91.23,51.65c.06-.07.09-.09.09-.11a.8.8,0,0,0,0-.15l-.08,0a.2.2,0,0,0,.11.19,2,2,0,0,0,0,.31c-.35-.14-.35-.14-.61.18a1.94,1.94,0,0,0,.59-.25l.12-.09A.22.22,0,0,0,91.23,51.65Zm-17.55,0c-.18,0-.1.15-.12.1l-.27.62c.31-.1.27-.3.27-.48.18,0,.1-.15.19-.35l-.07.06,0,.05.06-.07S73.76,51.5,73.68,51.6Zm81.55-.12h.05a.25.25,0,0,0,0-.09l-.07,0a.2.2,0,0,0,.11.07c0,.09-.06.23.12.24,0,.09-.06.23.12.24-.06.36.26.6.29.94a.37.37,0,0,0,.31.33s0,.11,0,.28l-.08-.11s-.06.06-.06.08a.88.88,0,0,0,.05.15.33.33,0,0,0,.07-.23l.22.1s0-.07,0-.08L155.58,52h-.06c0-.09.06-.23-.12-.24C155.38,51.63,155.46,51.49,155.23,51.48ZM176.52,73c0-.18-.15-.1-.15-.14-.23-.11-.28-.35-.66-.33.25.16.3.4.57.35,0,.18.15.1.24.12,0,.18.15.1.24.12s0,.11.09.14a10.06,10.06,0,0,1,1.6,1.31,4.18,4.18,0,0,1,.68.38,1.1,1.1,0,0,0,.62.09.39.39,0,0,1,.32.11.58.58,0,0,0,.28.09,2.1,2.1,0,0,0-.83-.68l-.11-.1c-.11-.38-.25-.48-.62-.43l.61.41.12.12c0,.15-.11.14-.2.1a2.29,2.29,0,0,1-1.17-1.05l-.07.06,0,.05.06-.07s0,0-.11.07l-.65-.73-.08,0,.1.32-.69-.24C176.75,72.9,176.61,73,176.52,73ZM107.47,56.88h0a.25.25,0,0,0,0-.09l-.07,0a1.28,1.28,0,0,0,.24.19l-.07-.12-.06,0,.07.18S107.62,57.05,107.47,56.88ZM136.27,73h0a.25.25,0,0,0,0-.09s0,0-.07,0,0,0,.4.14l-.18-.07h-.11s.05.1.08.11S136.5,73.06,136.27,73Zm-21.89-.73-.08-.11s-.06.06-.06.08a.88.88,0,0,0,.05.15.86.86,0,0,0,.14-.34l-.07.06,0,.05.06-.07S114.44,72,114.38,72.23ZM74,64.63,74,64.56l0,0,.07.06s0,0-.16-.06c.06-.07.09-.09.09-.11a.8.8,0,0,0,0-.15s-.08,0-.08,0S73.82,64.5,74,64.63Zm58.56,3.6-.06-.07-.05,0,.07.06s0,0-.16-.06c.06-.07.09-.09.09-.11a.8.8,0,0,0,0-.15s-.08,0-.08,0S132.38,68.1,132.59,68.23Zm-53.15-.07.12.12c0,.2.08.36.35.55l-.06-.07,0,0,.07.06s0,0-.07-.11a2.81,2.81,0,0,1,0-.29c0-.21-.1-.2-.24-.19a.22.22,0,0,0-.21-.07c.06-.07.09-.09.09-.11a.8.8,0,0,0,0-.15s-.08,0-.08,0A.2.2,0,0,0,79.44,68.16Zm75.19-21.41a1.2,1.2,0,0,0-.07.18.4.4,0,0,0,0,.11s.1,0,.11-.08,0-.1-.11.13V47c-.09,0-.12,0-.07.11S154.54,47.11,154.63,46.75ZM77,46.51a1.2,1.2,0,0,0-.07.18.4.4,0,0,0,0,.11s.1,0,.11-.08,0-.1-.06.17c-.07-.06-.09-.09-.11-.09l-.15,0s0,.08,0,.08S76.86,46.9,77,46.51ZM73.27,63.6h0a.25.25,0,0,0,0-.09l-.07,0a1.28,1.28,0,0,0,.24.19l-.07-.12-.06,0,.07.18S73.42,63.77,73.27,63.6ZM157.33,46l-.07-.12s-.06,0-.06.06.05.11.07.17,0-.06-.16-.18c.06-.07.09-.09.09-.11a.8.8,0,0,0,0-.15l-.08,0C157.09,45.71,157.1,45.78,157.33,46Zm19.5,25.44h0a.25.25,0,0,0,0-.09s0,0-.07,0,0,0,.4.14L177,71.4a.4.4,0,0,0-.11,0s.05.1.08.11S177.06,71.5,176.83,71.4Zm-46.08-5.16h.05a.25.25,0,0,0,0-.09s0,0-.07,0a1.28,1.28,0,0,0,.24.19l-.07-.12s-.06,0-.06.05l.07.18S130.9,66.41,130.75,66.24Zm-20.68.41c.06-.07.09-.09.09-.11a.8.8,0,0,0,0-.15l-.08,0c0,.06,0,.13.24.31l-.07-.12s-.06,0-.06.05l.07.18S110.26,66.77,110.07,66.65Zm20.88.24c.06-.07.09-.09.09-.11a.8.8,0,0,0,0-.15s-.08,0-.08,0a.2.2,0,0,0,.11.19c0,.09-.06.23.12.24a.85.85,0,0,0,0,.22,6.6,6.6,0,0,1,.43.89c.18.62.53,1.17.73,1.77,0,.05.12.12.16.11s0-.09,0-.14c0-.25-.16-.46-.16-.71a.73.73,0,0,0-.23-.58c0-.09.06-.23-.12-.24,0-.06,0-.14,0-.17a1.77,1.77,0,0,1-.5-1.36l-.15.32-.19-.11C131.14,67,131.22,66.85,131,66.89Zm2.28-1.56a.17.17,0,0,0,.06-.26s-.08,0-.08,0,0,.13.24.31l-.07-.12s-.06,0-.06,0l.07.18S133.42,65.45,133.23,65.33Zm-27.8.31h0a.25.25,0,0,0,0-.09l-.07,0a.2.2,0,0,0,.11.07c0,.09-.06.23.12.24,0,.09-.06.23.12.24a2,2,0,0,0,.09.26,2.77,2.77,0,0,1,.39,1.28s0,.1,0,.1c.37.08.16.37.21.56s0,.21,0,.31a.22.22,0,0,0,.09-.16,4.06,4.06,0,0,0-.12-1.15,1.7,1.7,0,0,1,.24.22c.19.28.3.64.7.71,0-.06,0-.12,0-.16a1.78,1.78,0,0,0-.59-.71,1.47,1.47,0,0,1-.46-1.11c0-.24,0-.48,0-.72,0,0-.07-.1-.2-.1.06-.07.09-.09.09-.11a.8.8,0,0,0,0-.15l-.08,0a.2.2,0,0,0,.11.19c0,.22.06.44-.1.68s.2.39.05.63c-.18-.17-.13-.51-.43-.59,0-.09.06-.23-.12-.24C105.58,65.79,105.66,65.65,105.43,65.64ZM83.64,42.48l0-.1-.08.1c-.09,0-.23-.06-.24.17v0a.25.25,0,0,0-.09,0s0,0,0,.07a.2.2,0,0,0,.07-.11c.09,0,.23.06.24-.12a2,2,0,0,1,.41.07l-.18-.07h-.11s0,.1.08.11S83.82,42.58,83.64,42.48Zm8.59-.24h0a.25.25,0,0,0,0-.09l-.07,0s0,0,.4.14a.43.43,0,0,0-.29-.07s0,.1.08.11S92.46,42.34,92.23,42.24ZM78.79,72.48h0a.25.25,0,0,0,0-.09s0,0-.07,0,0,0,.4.14L79,72.48a.4.4,0,0,0-.11,0s0,.1.08.11S79,72.58,78.79,72.48ZM75,48.84h.12a1.08,1.08,0,0,1,0,.18c0,.11-.26.12-.18.29s-.17.2-.16.3-.17.34,0,.56.07.29-.18.39a.57.57,0,0,0-.25.73,1.13,1.13,0,0,1,.55-.1l-.06-.07,0,.05.07.06s0,0-.07-.11a.62.62,0,0,1,.13-.62,2.51,2.51,0,0,1,.39-.92c0-.11,0-.22.09-.32.34-.17.41-.47.23-.89h-.08l-.21.59-.19-.11a2.51,2.51,0,0,1,.07-.53,1.2,1.2,0,0,0-.07.18.4.4,0,0,0,0,.11s.1-.05.11-.08,0-.1-.11.08c-.18,0-.1.15-.12.29v0a.25.25,0,0,0-.09,0s0,0,0,.07A.2.2,0,0,0,75,48.84Zm-.22-.13-.08-.11s-.06.06-.06.08a.88.88,0,0,0,0,.15.86.86,0,0,0,.14-.34l-.07.06,0,.05.06-.07S74.84,48.5,74.78,48.71Zm102.09,22.4-.06-.07-.05,0,.07.06s0,0-.16-.06c.06-.07.09-.09.09-.11a.8.8,0,0,0,0-.15l-.08,0C176.65,70.91,176.66,71,176.87,71.11ZM75.62,49.67l-.08-.11s-.06.06-.06.08a.88.88,0,0,0,0,.15.86.86,0,0,0,.14-.34l-.07.06.05.05.06-.07S75.68,49.46,75.62,49.67Zm79.61-.47h.05a.25.25,0,0,0,0-.09l-.07,0a.2.2,0,0,0,.11.07c0,.09-.06.23.13.1,0,.43.08.66.36.81a3.19,3.19,0,0,0-.37-.67C155.38,49.35,155.46,49.21,155.23,49.2Zm-47.36,20-.06-.07,0,0,.07.06s0,0-.16-.06c.06-.07.09-.09.09-.11a.8.8,0,0,0,0-.15s-.08,0-.08,0S107.66,69.06,107.87,69.19Zm48.72-21.48-.06-.07-.05,0,.07.06s0,0-.07-.11a2.51,2.51,0,0,1,.07-.53,1.2,1.2,0,0,0-.07.18.4.4,0,0,0,0,.11s.1,0,.11-.08,0-.1-.11.08l-.12.09A1.21,1.21,0,0,0,156.59,47.71ZM93.47,43,93.41,43l0,0,.07.06s0,0,.07-.12l-.35-.22C93.06,43,93.2,43,93.47,43ZM76.56,52.8c-.23.06-.07.24-.12.36a.58.58,0,0,0-.24.6l-.24.63.06.09s0,0,.06,0a2,2,0,0,1,.14.35l-.08-.11s-.06.06-.06.08a.88.88,0,0,0,0,.15.33.33,0,0,0,.07-.23l.19.11a10.29,10.29,0,0,0,0-1.11c-.14-.22.12-.38,0-.56.23-.06.07-.24.12-.36a.22.22,0,0,0,.15,0,3.74,3.74,0,0,0-.1,1c.06-.32.33-.6.07-1v-.24h.06c.08,0,.19-.13.24-.1s0,.14,0,.24a.83.83,0,0,0,0,.32H77l.43-1.29h.43a1.43,1.43,0,0,0-.25,1.11s-.15.09-.23.13a1.52,1.52,0,0,1-.12.84c.22.11,0,.21,0,.32s0,.3,0,.51c.08-.08.11-.13.14-.13s.13,0,.1.12-.09.18-.19.38c.37-.2.3-.45.38-.77l-.07.06,0,0,.06-.07s0,0-.11.07-.16-.12-.09-.2a1.18,1.18,0,0,0,.21-.87c0-.22,0-.44,0-.66a2.52,2.52,0,0,1,.21-.89,6.59,6.59,0,0,0,0,1.66c.35.28.11.67.18,1-.23.32-.07.68-.15,1.13.17-.17.23-.27.32-.31s.15.17.25.21a16,16,0,0,0,4-.83,3.28,3.28,0,0,0,1-.23c.88-.39,1.77-.75,2.67-1.1.06,0,.15,0,.21-.07a7.33,7.33,0,0,1,2-1,1.08,1.08,0,0,0,.61-.35c.17-.35.55-.42.74-.7.06-.09.25-.1.28-.18a3.85,3.85,0,0,0,1-1.69s0-.1,0-.11c.25-.21,0-1.38-.11-1.62a4.29,4.29,0,0,1-.25-.74c0-.06-.11-.12-.11-.18s.12-.21.09-.25c-.17-.22-.21-.52-.45-.71a.85.85,0,0,1-.37-.75s0-.14-.06-.14c-.26,0-.2-.29-.37-.4a1.35,1.35,0,0,0-1.25-.63,2.49,2.49,0,0,1-.77.07c-.36,0-.75-.15-1.09.11,0,0-.11,0-.16,0a1.68,1.68,0,0,0-.88-.2c-.3,0-.65-.12-.87.23a.42.42,0,0,0-.36-.1,4.26,4.26,0,0,0-.74.37c-.1.06-.13.09-.22,0s-.18,0-.19,0c-.14.36-.71.18-.76.63a1.93,1.93,0,0,0-.92.44l.1.11c-.18.11-.47.19-.54.36-.37.71-.71,1.43-1,2.17a2.41,2.41,0,0,0-.23.13c-.14.11-.55.09-.26.45,0,0,0,.08,0,.08-.41,0-.24.37-.3.57-.24-.09-.39,0-.47.27v-.31c-.3-.21-.32.14-.53.19h0a.25.25,0,0,0,0-.09l-.07,0a.2.2,0,0,0,.11.07l0,.58-.14-.33a1.85,1.85,0,0,1-.31,1H77.4l.12-.72c.22-.09.11-.23.09-.29-.38-.36-.24.21-.45.17a4.17,4.17,0,0,1,.12-1.32c.2,0,.25-.19.24-.38a2.48,2.48,0,0,1,.07-.63,1.2,1.2,0,0,0-.07.18.4.4,0,0,0,0,.11s.1,0,.11-.08,0-.1-.11.08-.12.1-.11.15c0,.2-.09.23-.25.21L77,47.59a3.61,3.61,0,0,0-1.17,1.9c-.06.24,0,.52,0,.77s.33.46,0,.68a.33.33,0,0,0,.1.06c.18,0,.16.1.09.23a1.84,1.84,0,0,0-.08.43l.27-.24c0,.16,0,.25-.1.31s-.2.19-.16.35l-.1,0,.1.08v.66l.09,0,.07-.46h.06l0,.33c.31-.13.23-.57.58-.71l-.13.48C76.5,52.57,76.58,52.71,76.56,52.8Zm1.57-5.38.22-.35c-.23-.09-.24,0-.23.26v0a.25.25,0,0,0-.09,0s0,0,0,.07S78.1,47.35,78.13,47.42Zm-2.34,6.35c0-.06,0-.07,0-.09V53.4h0c0,.1,0,.21-.06.31s0,0,.18-.6a1.2,1.2,0,0,0-.07.18.4.4,0,0,0,0,.11s.1,0,.11-.08S75.94,53.22,75.79,53.77Zm32.7,6.11-.07-.12c-.09.06-.09.13,0,.23s0-.06-.17-.23h.11l0-.36h-.08C108.25,59.53,108.26,59.65,108.49,59.88Zm-19-2.54v-.11l-.36,0v.08a.48.48,0,0,0,.42-.22l-.07.06,0,.05.06-.07S89.6,57.14,89.52,57.34ZM155.64,73c0-.18-.15-.1-.21-.13-.13-.2-.31-.08-.46-.1a.66.66,0,0,0,0,.1h.46c0,.18.15.1.61.17-.06,0-.07-.05-.09-.05h-.28V73c.1,0,.21,0,.31.06S156,73,155.64,73ZM182,71.16h0a.25.25,0,0,0,0-.09l-.07,0s0,0,.12-.07c0,.3,0,.44.22.35A.37.37,0,0,0,182,71.16Zm-3,1.15-.06-.07-.05.05.07.06s0,0-.44-.16c.06,0,.07,0,.09,0h.28v0c-.1,0-.21,0-.31-.06S178.58,72.16,179,72.31ZM74.83,56.53c0-.06,0-.07,0-.09v-.28h0c0,.1,0,.21-.06.31s0,0,.18-.6a1.2,1.2,0,0,0-.07.18.4.4,0,0,0,0,.11s.1,0,.11-.08S75,56,74.83,56.53Zm45.72,8.39h0a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07V65a2.9,2.9,0,0,1-.59,0c-.19,0-.37-.16-.56-.22a.48.48,0,0,0-.32,0c0-.18-.09-.34-.37-.24a1.31,1.31,0,0,0,.4.19,1.41,1.41,0,0,0,1.44.3V65c.15,0,.32,0,.58-.12ZM79.19,72.31l-.06-.07,0,.05.07.06s0,0-.07-.11V72c.17,0,.23.18.27.33a.12.12,0,0,0,.1,0q.24-.15,0-.42c-.09,0-.17-.12-.3-.54l-.09.08.14.22.06.06a.68.68,0,0,0,.06-.09c0-.1-.11-.18-.12.09-.09,0-.23-.06-.24.12C78.78,72.09,78.85,72.23,79.19,72.31Zm-3.6-13.9c-.2.13-.08.31-.1.46l.1,0a1.67,1.67,0,0,1,.08-.57l-.07.06.05,0,.06-.07S75.68,58.34,75.59,58.41ZM75.47,54c-.2.13-.08.31-.1.46l.1,0a6.09,6.09,0,0,1,.06-.83c0,.06,0,.07,0,.09V54h0c0-.1,0-.21.06-.31S75.56,53.66,75.47,54Zm32.68,16.76c.06-.07.09-.09.09-.11a.8.8,0,0,0,0-.15l-.08,0a.2.2,0,0,0,.11.19.29.29,0,0,0,.24.36.68.68,0,0,0,.12.48,1.86,1.86,0,0,1-.89-.6h.05a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07c0,.29.19.43.36.65v0a.25.25,0,0,0-.09,0s0,0,0,.07a.2.2,0,0,0,.07-.11c.16.16.4.2.53.44a2.18,2.18,0,0,0,.49.52.36.36,0,0,0-.08-.32,1.72,1.72,0,0,1-.46-.64h.27l-.39-.48C108.5,70.85,108.43,70.73,108.15,70.73Zm-31-17.3c.2-.13.08-.31.1-.46l-.1,0a6.09,6.09,0,0,1-.06.83c0-.06,0-.07,0-.09V53.4h0c0,.1,0,.21-.06.31S77.08,53.74,77.17,53.43Zm101.58,18h.05a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07c0,.19.17.26.25.21.34.29.52.62.94.58-.32-.12-.46-.51-.83-.55C179.11,71.45,179,71.38,178.75,71.4ZM133.2,74.28a5.93,5.93,0,0,0-.57-.45.11.11,0,0,0,0,.08c.13.11.21.3.43.25V74.1c0-.25-.25-.22-.4-.3s0,0,.4.36a1.33,1.33,0,0,0,.42.24,1.77,1.77,0,0,0-.19-.12s-.1,0-.11.06,0,.2.14.18S133.41,74.46,133.2,74.28Zm.43-5h.05a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07c0,.19.17.26.47.31l-.06-.07-.05,0,.07.06s0,0-.07-.11S133.87,69.22,133.63,69.24ZM95.31,49c.06-.07.09-.09.09-.11a.8.8,0,0,0,0-.15s-.08,0-.08,0,0,.13.2.19a.57.57,0,0,0,0,.59A.61.61,0,0,0,95.31,49ZM80.75,70.87l-.06-.07,0,0,.07.06s0,0-.07,0a1.05,1.05,0,0,0,0-.19c0-.09,0-.17-.07-.25l-.16,0,.09.23S80.55,70.78,80.75,70.87ZM108,69.48h0a.25.25,0,0,0,0-.09s0,0-.07,0a.59.59,0,0,0,.11.1.28.28,0,0,0,.28.33A3.39,3.39,0,0,0,108,69.48Zm7-4.7-.27.62c.31-.1.27-.3.34-.59l-.07.06.05,0,.06-.07S115,64.82,115,64.78ZM92.53,44.28l-.07-.12-.06.05.07.18s0-.06,0-.24l-.25-.43C92.16,44,92.06,44.2,92.53,44.28ZM154.71,74.9c.27.2.27.2.45,0a1.66,1.66,0,0,0-.7.14l.22-.22a.8.8,0,0,0-.26,0s-.08.09-.09.15S154.39,75,154.71,74.9Zm25-1.34h0a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07c.22.31.26.32.48.12h.24c-.25-.29-.25-.29-.48-.12ZM108,58.68h0a.25.25,0,0,0,0-.09s0,0-.07,0,0,0,.08,0l.24.73C108.25,59,108.29,58.79,108,58.68Zm27.29,12.24.24.12c.06.1-.21.13,0,.27a1.3,1.3,0,0,1,.46.57c0,.12.18.14.41.19l-.06-.07-.05,0,.07.06s0,0-.07-.11l-.12-.24c.16,0,.25.07.35.16a.53.53,0,0,0,.22.08l.06-.11c-.49-.18-.73-.68-1.23-.85-.1-.37-.19-.44-.46-.42a2.41,2.41,0,0,1,.22.35v0a.25.25,0,0,0-.09,0s0,0,0,.07A.2.2,0,0,0,135.24,70.92Zm-53.69,1.2h0a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07v.24a.25.25,0,0,1-.09,0c-.11-.12-.14-.07-.15.06v.22q-.24.18,0,.36l-.12.24-.5-.42.21-.1-.25-.92h-.23c-.08,0-.14-.08-.21-.07a.51.51,0,0,0-.28.08.88.88,0,0,1-.06.53c-.17.24-.18.43,0,.61.45.36.92.7,1.4,1,0-.56.38,0,.49-.19l-.11-.19a.3.3,0,0,0,.35-.22c-.25-.09-.4-.37-.71-.38V72.6l.64.51.06,0-.22-.46s.09,0,.1,0C82.09,72.21,81.74,72.25,81.55,72.12Zm73.36-23.57-.06-.07,0,.05.07.06s0,0-.1-.11.14-.47-.18-.57C154.48,48.14,154.69,48.29,154.91,48.55Zm-46.35,6.29c-.07.37-.07.37.18.68a1.75,1.75,0,0,0-.29-.68c0-.2.14-.47-.18-.57C108.16,54.5,108.37,54.65,108.56,54.84ZM74.63,65.47l-.06-.07,0,0,.07.06s0,0-.07-.06c0-.23,0-.41-.17-.51a.16.16,0,0,0-.15,0s0,.13,0,.15A1.61,1.61,0,0,0,74.63,65.47Zm103.32,7-.06-.07,0,0,.07.06s0,0-.5-.6l0,.07a1.53,1.53,0,0,1,.18.18c.08.11.09.36.29.22s0-.24-.16-.32S177.5,71.92,178,72.43ZM180,70H180a.25.25,0,0,0,0-.09s0,0-.07,0A.2.2,0,0,0,180,70c.11.27.35.32.71.43l-.06-.07-.05.05.07.06s0,0-.07-.11A.55.55,0,0,0,180,70Zm-65.28,1.68h0a.25.25,0,0,0,0-.09l-.07,0s0,.05.41-.59l-.36,1C115,71.65,115.06,71.35,114.67,71.64Zm41.57-20.28a.48.48,0,0,1,.23.07l-.06-.07,0,0,.07.06s0,0-.07-.11-.07-.44-.13-.65c0,0-.11-.08-.13-.06s-.11.13-.09.16a1.12,1.12,0,0,1,.23.6v0a.25.25,0,0,0-.09,0s0,0,0,.07A.2.2,0,0,0,156.24,51.36ZM107,64.56c0-.15-.05-.31.06-.38l-.31-.3c0,.23.08.45.13.68a2,2,0,0,1-.48-1.31c0-.21.08-.45-.16-.59-.18.07-.33.28-.56.1,0-.09.06-.23-.14-.24a7.62,7.62,0,0,1-.11-1,9.68,9.68,0,0,0,0-1.08.42.42,0,0,0-.22.61,1.54,1.54,0,0,1,.09.73.94.94,0,0,0,.25.7c0,.09-.06.23.12.24a10.76,10.76,0,0,0,1.17,3.75c.09.14.15,0,.23-.05a3.89,3.89,0,0,1,.28,1.09,1.1,1.1,0,0,0,.2.51c.1.17.31-.09.4.06v.63a3.1,3.1,0,0,0,.24.67c.18.18.4.32.39.62a.26.26,0,0,0,.15,0s.06-.06.06-.09a3.85,3.85,0,0,0-.32-.75,1.28,1.28,0,0,1-.31-1s-.09,0-.21,0a.54.54,0,0,0,0-.18c-.07-.16-.17-.32-.24-.49-.14-.36-.27-.71-.39-1.08-.21-.17,0-.34-.07-.53A2.94,2.94,0,0,1,107,65l.2.12A.49.49,0,0,0,107,64.56Zm27.35-5.28.22.4c0-.23.13-.44-.19-.41a4.15,4.15,0,0,0-.27-.41s-.13,0-.2,0,0,.16,0,.2S134.18,59.34,134.39,59.28Zm-3.33-.36h.11l0-.36h-.08a.44.44,0,0,0,.11.34v.54c0,.18,0,.36,0,.55A1.26,1.26,0,0,0,131.06,58.92ZM109,62.76h.11l0-.36H109a.39.39,0,0,0,.15.35,1.25,1.25,0,0,0,.17.93C109.41,63.35,109.21,63.07,109,62.76Zm24,2.35-.06-.07,0,0,.07.06s0,0-.12-.11a2.8,2.8,0,0,0-.3-1.46A3.59,3.59,0,0,0,133,65.11ZM75.51,50.48c-.41.12-.25.55-.52.7l.33.16c.06-.27.12-.54.23-1.11a1.2,1.2,0,0,0-.07.18.4.4,0,0,0,0,.11s.1-.05.11-.08S75.58,50.34,75.51,50.48ZM135,63.84h-.09v.48c0,.16,0,.32,0,.49a1.94,1.94,0,0,0,.1-.75c0-.07,0-.14-.22-.2h.12c0-.19,0-.39-.06-.58s-.08-.32-.12-.48-.09-.32-.13-.48A2.62,2.62,0,0,0,135,63.84ZM82.32,71.28l0-.1-.08.1c-.19-.2-.37-.41-.55-.62a.34.34,0,0,1-.1-.33l-.07.06,0,0,.06-.07s0,0-.11.07l-.19-.11a.28.28,0,0,0,.06.41c.27.25.53.52.85.84v-.3a.16.16,0,0,1,.13,0,.73.73,0,0,0,.23.7l.24-.22C82.63,71.63,82.48,71.48,82.32,71.28Zm1.08,1.45c0-.35-.17-.25-.4-.22.16.09.28.15.71.68-.09-.15-.19-.27-.17-.3.24-.29-.08-.15-.14-.16s-.1.1-.15.1c-.33,0-.19.2-.18.36C83.26,73.19,83.43,73.19,83.4,72.73ZM78.84,48l0-.09a.8.8,0,0,0-.2.07.64.64,0,0,0,0,.15c.07,0,.14-.09-.59.92.14-.23.48-.31.21-.6.3,0,.21-.26.24-.44s.11-.12.1-.15a2.05,2.05,0,0,0-.28-.29C78.48,48.15,77.89,48.44,78.84,48Zm29.29,15.16-.07-.12-.06,0,.07.18s0-.06-.18-.22c.19-.56-.17-1-.18-1.55,0-.09-.08-.17-.13-.25l-.08,0A6.81,6.81,0,0,0,108.13,63.12ZM92.35,42.84h.05a.25.25,0,0,0,0-.09l-.07,0s0,0,0,0l.24.32A.91.91,0,0,1,91.9,43c.1.41.4.49.72.62a1,1,0,0,1,0-.33Q92.88,42.84,92.35,42.84ZM107.83,73.2h0a.25.25,0,0,0,0-.09s0,0-.07,0a.11.11,0,0,0,.12,0l0,.06c.1.06.21.19.31.19a3,3,0,0,1,.5.61c.23-.52.23-.56-.2-1,0,.22,0,.3-.21.22A1.06,1.06,0,0,0,107.83,73.2Zm20.27-26a5.44,5.44,0,0,0-.17.78,2.25,2.25,0,0,0,.06.89c.46-.77.38-1-.22-.69a1.86,1.86,0,0,0,0-1.43,3.45,3.45,0,0,0-.15.71C127.56,47.65,127.46,47.94,128.1,47.16ZM78.57,59h-.06v.47h.06a.47.47,0,0,0-.19-.45l.14,0a4.34,4.34,0,0,1-.16-.47c-.08-.37-1.27,0-.23,1V58.48A1,1,0,0,0,78.57,59ZM157,74.88l0,.13a9.15,9.15,0,0,1,1.8.23.2.2,0,0,0,.11,0,.38.38,0,0,0,.1-.12c0-.1,0-.12-.12-.13s-.28-.1-.43-.1c-.49,0-1,0,.55,0V75c.42,0,.84,0,1.26,0,.06,0,.12-.11.28-.26-.35.06-.57.12-.79.15S159.25,74.89,157,74.88ZM119.05,58.8l-.07-.12-.06,0,.07.18s0-.06-.66,1.37c.31-.37.22-.86.56-1.15,0,0,0-.06,0-.08a1.82,1.82,0,0,0,0-.77c.07-.09,0-.29,0-.5a11.7,11.7,0,0,0-.45,1.2,1.08,1.08,0,0,0,0,.18,2.34,2.34,0,0,1,0,.55C118.25,59.86,118.33,60,119.05,58.8ZM74.82,51.59c-.34,0-.54.21-.61.6L74.1,52c-.06.11-.11.19-.15.28l-.27.66s0,.13.07.14a.14.14,0,0,0,.15,0,.72.72,0,0,0,.14-.24,2.72,2.72,0,0,0,0-.3h.08l.19.49a3,3,0,0,0,.26-.65C74.64,52,75,51.93,74.82,51.59Zm82.61-2.8-.06-.07-.05.05.07.06s0,0-.18-.09l.11,0v-.24c0-.26-.29-.52,0-.79,0,0-.07,0-.08-.08s-.09-.25-.13-.37a2.67,2.67,0,0,0-.14-.36c-.06-.1-.21-.25-.19-.29.17-.27-.23-.06-.17-.23s0-.1,0-.15a2.9,2.9,0,0,0,.2,1c.09.22.14.38,0,.58s0,.19,0,.36l.12-.3A2.32,2.32,0,0,0,157.43,48.79ZM131,53.28h0a.25.25,0,0,0,0-.09l-.07,0s0,0,.19.06l-.12,0a1.77,1.77,0,0,1,.15.48c0,.5,0,1,0,1.5a.94.94,0,0,1-.11.37.38.38,0,0,0,.18.51c.21-.14.2-.34.14-.56a1.77,1.77,0,0,1,0-1.09,5.4,5.4,0,0,1,.16.72c0,.1.1.17.26.23A7.15,7.15,0,0,0,131,53.28Zm50.08,18.43-.06-.07,0,0,.07.06s0,0,0-.11a2.33,2.33,0,0,0-.72-.48,2.5,2.5,0,0,0-.5-.23,1.22,1.22,0,0,1-.6-.27,1.53,1.53,0,0,0-.74-.31c.08.13.19.31.3.32.32,0,0,.33.24.39s.17.08.25.1a1.59,1.59,0,0,1,.39.07c.34.2.76.17,1.09.4C180.78,71.67,180.88,71.64,181.07,71.71Zm-25-24.24-.06-.07-.05.05.07.06s0,0-.07-.11a.76.76,0,0,0-.26-.67c-.15-.14-.17-.33-.26-.49s0-.34-.09-.43,0-.4-.35-.3v.69a.25.25,0,0,0-.09,0s0,0,0,.07a.2.2,0,0,0,.07-.11c.2,0,.14.23.11.26-.18.17-.1.3,0,.45a.71.71,0,0,1,.12.49,6.9,6.9,0,0,0,.29,1.9c.07-.18,0-.41.1-.52s0-.34,0-.52a3.14,3.14,0,0,1-.2-1.63c.13.19.22.34.32.48A2,2,0,0,0,156.11,47.47ZM73.69,61.7a2.22,2.22,0,0,1,.22.51c0,.17,0,.34.24.42A1.83,1.83,0,0,0,74,61.46l-.1.1a3.52,3.52,0,0,1-.18-1.37l-.08-.07-.23.35-.07,0,.12-1.39a2.63,2.63,0,0,1-.46.54.15.15,0,0,0,0,.11s.06,0,.07,0,.19-.1.14,0a2.93,2.93,0,0,0-.11,1.1c0,.22.11.47-.11.67,0,0,.06.13.07.2.06.44.41.75.48,1.19a4.9,4.9,0,0,1,0,1.21A1.29,1.29,0,0,0,73.4,64a.16.16,0,0,0-.08.05l.15.53c.06-.19.07-.3.11-.31a.9.9,0,0,0,.19-.64,5,5,0,0,1,.62,1,1.11,1.11,0,0,0-.14-.77,4.83,4.83,0,0,1-.33-.64,2.61,2.61,0,0,1-.2-.75A3,3,0,0,1,73.69,61.7Zm34.43,3.94a2.54,2.54,0,0,0,.07.47c0,.17.15.33.29.6a3.38,3.38,0,0,1,0-.9.94.94,0,0,0,0-.29.6.6,0,0,0-.09-.15,5.67,5.67,0,0,1-.63-2.07c-.25-.12,0-.4-.2-.58-.12-.37-.22-.74-.31-1.12-.3-.68-.44-1.41-.68-2.11a8.67,8.67,0,0,1-.38-1.52s-.09-.09-.13-.13S106,58,106,58a.84.84,0,0,0,.11.3,1,1,0,0,1,.07.83c.09.23.18.46.26.7,0,0-.15.09,0,.15s.32.41.14.77-.06.6.26.79a5.16,5.16,0,0,0,.36.92,3,3,0,0,1,.29,1.83s-.24.08-.16.14,0,.4.23.47l.12.12c0,.44.17.86.14,1.32a.61.61,0,0,0,.35.5,2.94,2.94,0,0,1-.21-1.48Zm49,6.36c.26,0,.42,0,.53-.13.29-.44.69-.82.66-1.41a.83.83,0,0,1,.11-.37c.09-.21.22-.41,0-.64a.4.4,0,0,1,0-.32c.08-.19.13-.37,0-.53l-.14-.51a3.87,3.87,0,0,0-.24-1.34,6.54,6.54,0,0,0-1-2.11c-.29-.44-.55-.89-.82-1.34-.18-.29-.34-.59-.52-.87s-.45-.82-.67-1.23a5.61,5.61,0,0,1-.47-.87c-.29-.91-.82-1.7-1.15-2.59-.12-.31-.32-.59-.41-.91a11.92,11.92,0,0,0-.51-1.29,1.71,1.71,0,0,1-.25-.74,1.58,1.58,0,0,0-.23-.56c0-.05-.1-.08-.15-.12s-.08.08-.09.13a3.11,3.11,0,0,1-.56,1.21c-.05.08-.14.15-.15.23a4.18,4.18,0,0,1-.65,1.3,13.89,13.89,0,0,0-1.24,2.54,4.44,4.44,0,0,1-.51,1c-.08.09-.07.26-.13.36-.17.26-.05.63-.29.84a1.73,1.73,0,0,0-.38.75,7.46,7.46,0,0,0-.31.83,11.83,11.83,0,0,1-.34,1.3c-.15.38-.31.75-.45,1.13a.71.71,0,0,0,.16.84,6.72,6.72,0,0,0,2.17,1.56,8.32,8.32,0,0,1,1.28.7c.59.4,1.19.8,1.77,1.23a6.32,6.32,0,0,0,1.85,1c.58.19,1.16.4,1.75.56S156.72,71.92,157.1,72Zm20.8-15.59c.23-.07.5.11.71-.12a11.26,11.26,0,0,1,2.37-.38.74.74,0,0,0,.46-.18,1.45,1.45,0,0,1,.9-.3l1.47-.64A4.31,4.31,0,0,0,186,53.5a.78.78,0,0,1,.25-.26,8.24,8.24,0,0,0,1.31-1.19.65.65,0,0,0,.15-.24,8.84,8.84,0,0,1,.57-1.56l0-1.85a8.77,8.77,0,0,1,0-.89,1.79,1.79,0,0,0-.16-.9c-.13-.26,0-.5-.09-.74s-.27-.42-.24-.69a.68.68,0,0,0,0-.28,2.34,2.34,0,0,0-1.53-1.33,1.91,1.91,0,0,0-1.27,0,3,3,0,0,0-1.23.51,24,24,0,0,1-2.58,1.83,1.27,1.27,0,0,0-.37.4,5.2,5.2,0,0,1-.46.59,4.52,4.52,0,0,1-.76,1.12,7,7,0,0,0-1.17,1.86c-.16.35-.14.78-.43,1.08,0,0,0,.12,0,.18l-.12,1.45a.48.48,0,0,1,0,.12,1.84,1.84,0,0,0,0,1.4.36.36,0,0,1,0,.23c-.23.44-.07.89-.12,1.34A1,1,0,0,0,177.9,56.41ZM119.83,55a.72.72,0,0,1-.2.79,1.14,1.14,0,0,0-.23.68,14.81,14.81,0,0,0-.2,1.76c.09-.12.14-.23.28-.3a.44.44,0,0,0,.15-.39c-.11-.42.22-.72.28-1.08,0-.09.09-.18.08-.26a.57.57,0,0,1,.2-.52s0-.13,0-.2C119.89,55.49,120.07,55.2,119.83,55Zm8.29-9.64c-.08-.36-.08-.36-.3-.56a1.9,1.9,0,0,0-.13.43c0,.18.06.41,0,.53s.09.19.11.27,0,.35.22.41a3.39,3.39,0,0,0,.28-2.66A2.94,2.94,0,0,0,128.12,45.34ZM105.9,53.5c-.06.22-.2.43-.15.57a8.94,8.94,0,0,1,.3,1.84c.14.78.41,1.52.58,2.29a1,1,0,0,0,0-.66c-.19-.37-.66-2.29-.38-2.74-.19-.17,0-.46-.14-.6S106,53.74,105.9,53.5Zm24.9,7.76v1.38a7.28,7.28,0,0,1,.12,1.32.81.81,0,0,1,.13.55s.1,0,.15,0,.07-.06.06-.07c-.26-.35.05-.81-.21-1.17a.24.24,0,0,1,0-.23c0-.48,0-1,0-1.45C131,61.53,130.91,61.43,130.8,61.26Zm-16.27,4.49c-.16.66-.37,1.31-.53,2,0,0,0,.09.06.09.44-.08.62-.43.54-1.08A.84.84,0,0,0,114.53,65.75Zm17.93-2.62v-1.9l-.34-.14a6.74,6.74,0,0,1,0,.78.49.49,0,0,0,.18.41c.14.13.12.24-.11.25a.26.26,0,0,0,0,.19A3.4,3.4,0,0,0,132.46,63.13Zm26.17,11.3.05.1,1.85-.13s.09,0,.11,0c.16-.18.38-.08.56-.08a1.18,1.18,0,0,0,.62-.13h-.31c-.86-.07-1.71.2-2.58.13C158.83,74.28,158.73,74.38,158.63,74.43ZM119.86,58.25l-.08-.06a3.42,3.42,0,0,1-.27.65c-.23.35-.26.78-.47,1.13a.33.33,0,0,0,0,.17s0,.09.06.09a.24.24,0,0,0,.16,0c.11-.38.24-.74.38-1.11A1.53,1.53,0,0,0,119.86,58.25Zm12.23,9a7.46,7.46,0,0,0-.63-2.59,8.42,8.42,0,0,0,.07,1s0,0,0,0c.26.3.12.75.42,1a.14.14,0,0,1,0,.11C131.77,67.06,132.08,67.16,132.09,67.29Zm-22.44.86a2.35,2.35,0,0,0-.22-.94,7.14,7.14,0,0,0-.53-1.35c-.25.42.17.68.2,1A3,3,0,0,0,109.65,68.15Zm18.63-19.46a2.77,2.77,0,0,0-.36,2.07,2.23,2.23,0,0,0,0,.23H128V49.92a.85.85,0,0,1,.24-.42Zm-53,10a2.4,2.4,0,0,0-.12,1.91c0-.06,0-.11,0-.16a1.21,1.21,0,0,0,.1-.14.22.22,0,0,0,0-.16.3.3,0,0,1-.09-.31C75.49,59.47,75.29,59.08,75.31,58.7Zm56.8-2.55h.13a5.76,5.76,0,0,0-.22-2.26c0,.08,0,.13,0,.19C131.92,54.77,132.21,55.44,132.11,56.15Zm-11.09-6a3.45,3.45,0,0,0,.29-1.09,2,2,0,0,0-.15-.47C121.08,49.14,120.76,49.63,121,50.17ZM74.5,60h-.1c0,.65,0,1.3,0,1.95-.07.37-.08.37.1.66Zm83.14-12c0-.27.14-.54-.08-.78,0,0,0-.1.06-.16l.16.08a1.84,1.84,0,0,0-.09-.25l-.35-.69A5.57,5.57,0,0,0,157.64,48Zm-37.41,3.69a1.68,1.68,0,0,0,.61-1.12c.06-.22,0-.4-.12-.39s0,.25-.14.32-.11.25-.09.38a1.3,1.3,0,0,1-.16.59C120.3,51.53,120.26,51.6,120.23,51.67Zm-12,11.94-.07,0c.09.39.18.78.25,1.17a1.8,1.8,0,0,0,.34.44A5.45,5.45,0,0,0,108.18,63.61Zm-2.42-7.43c0,.33-.18.68.07,1,0,.05,0,.18,0,.28s-.05.23-.09.44c.22-.22.47-.34.37-.59A5.48,5.48,0,0,1,105.76,56.18Zm59.84,14.5-1.11.8a.58.58,0,0,0,.65-.18c.12-.13.28,0,.33-.1A2.81,2.81,0,0,0,165.6,70.68Zm-58.24-10a3.56,3.56,0,0,0-.4-1.65A4.93,4.93,0,0,0,107.36,60.71ZM135.07,66l-.06.06.42,1.39c.18-.4-.06-.73-.08-1.09C135.34,66.22,135.17,66.11,135.07,66ZM89.85,41.74c-.3-.42-.73-.35-1.23-.32A3.68,3.68,0,0,0,89.85,41.74Zm21.29,27.79c-.06-.33-.08-.59-.15-.83a5.24,5.24,0,0,0-.29-.64A2.36,2.36,0,0,0,111.14,69.53ZM83,73.54c0-.17,0-.35-.07-.52a.56.56,0,0,0-.13-.24c-.07-.1-.16-.07-.24,0s-.13.12,0,.21,0,.14.08.21l.13-.13C82.77,73.47,82.77,73.47,83,73.54Zm.66-31.22a.91.91,0,0,0,1-.27c-.09-.06-.19-.18-.24-.16A7.45,7.45,0,0,0,83.65,42.32Zm70.9,7.92a1.27,1.27,0,0,0-.32-1.14,4.33,4.33,0,0,0,.11.89C154.35,50.06,154.44,50.11,154.55,50.24ZM108.18,67c-.18.51.23.93.24,1.42C108.57,67.89,108.28,67.45,108.18,67Zm3.16,7.34,0,0c-.26-.18-.35-.18-.49,0s.11.19.17.28a1,1,0,0,1,.05.18ZM134.45,58.1c0,.35-.21.74.15,1.08C134.75,58.77,134.47,58.45,134.45,58.1ZM91.82,48.84c.15-.69.15-.69-.19-1.12Zm42.36,12.82a3.71,3.71,0,0,0,0-1.52Zm0,3.48a.5.5,0,0,0,.05-.56c-.06-.18-.08-.2-.35-.31Zm-48.5-10.2c-.29.06-.5.09-.71.15,0,0-.06.09,0,.14s.07.08.11.09C85.37,55.4,85.52,55.2,85.73,54.94Zm-3.64,18.9a.52.52,0,0,0,.83.14A.89.89,0,0,0,82.09,73.84Zm49.15-16.57c.14-.38-.16-.66-.13-1A1.07,1.07,0,0,0,131.24,57.27Zm24.26-6.65-.11.07c.05.21.09.42.16.63,0,0,.1,0,.15,0a.18.18,0,0,0,.06-.09C155.68,51.05,155.59,50.84,155.5,50.62ZM86.87,54.53l-.06-.07c-.24.06-.31.22-.2.5Zm13.78,13.09.09.06a.56.56,0,0,0,.29-.53c-.13-.13-.18.07-.24.13A1.73,1.73,0,0,0,100.65,67.62Zm30.65-6.06c.08,0,.17,0,.18,0,.09-.21.05-.34-.18-.55Zm.72-2.9a1.68,1.68,0,0,0,0-1Zm-24.33-1.28c0,.28-.11.57.15.8C108,57.88,107.72,57.65,107.69,57.38ZM84.52,55.54l-.87.18A.74.74,0,0,0,84.52,55.54Zm68.81,19c0,.11,0,.21.09.22.21.06.42.24.65.07ZM115.52,63c.07-.24.09-.45-.16-.62C115.29,62.63,115.27,62.84,115.52,63Zm-16.68,6.5c-.13.18-.44.24-.4.55C98.59,69.89,98.84,69.81,98.84,69.51Zm55.28-20.69c0-.24.21-.52-.16-.71ZM108.78,70.2c-.19.25.09.4.12.68C109,70.57,109,70.36,108.78,70.2ZM89.88,56.61l-.06-.09a4.27,4.27,0,0,0-.48.13s0,.09-.06.14,0,.09.06.08Zm25.3,9a1.06,1.06,0,0,0,0,.8Zm70.72,7.68a1,1,0,0,0,.8,0ZM91,74l-.07-.08c-.13.06-.26.11-.38.18s0,.12,0,.15C90.7,74.34,90.85,74.25,91,74Zm-8.3-.32c-.37-.22-.37-.22-.57,0Zm-1.12-2.45L81.33,71a1.51,1.51,0,0,0-.09.18c0,.11,0,.21.15.17S81.47,71.3,81.54,71.21Zm27.78-2.45c-.16.34-.11.54.15.59,0,0,.09-.08.08-.11A4.47,4.47,0,0,0,109.32,68.76Zm.09,6.67c0,.08.06.15.09.16a.6.6,0,0,0,.23,0c.07,0,.11.24.18,0s-.06-.15-.17-.15a1.67,1.67,0,0,1-.2-.08ZM109,67.58c-.08-.06-.13-.13-.18-.13s-.13.11-.11.2.07.1.11.15Zm.44-6.16a.77.77,0,0,0,0-.68Zm24.61,14.12.74.19C134.6,75.43,134.39,75.45,134.07,75.54ZM135.22,63a.77.77,0,0,0,0,.68Zm.42,9.21a1.87,1.87,0,0,0-.67.07c.2.13.44,0,.57.18Zm-50.3.21a2,2,0,0,0-.33-.19s-.11,0-.15,0,0,.08,0,.1a.2.2,0,0,0,.13.09A2.94,2.94,0,0,0,85.34,72.44ZM129.22,46.7a.71.71,0,0,0,0,.68ZM117.48,59.46l-.06-.06a.43.43,0,0,0-.15.59h0ZM116,71l.1.08.31-.49C116.08,70.58,116.12,70.82,116,71ZM77.25,58.56h-.06v.72h.06Zm-2.52,1.2h-.06v.72h.06ZM183.2,74.86l-.08.1.49.31C183.58,74.92,183.34,75,183.2,74.86Zm4.66-1.65c-.08-.06-.13-.12-.19-.12a.76.76,0,0,0-.21,0,1.92,1.92,0,0,0,.23.19S187.77,73.27,187.86,73.21Zm-56.6-8.51a.75.75,0,0,0,0,.69ZM82.38,43.46a1.87,1.87,0,0,0-.27,0,.44.44,0,0,0-.15.12s0,.09,0,.09a.44.44,0,0,0,.2,0S82.28,43.54,82.38,43.46Zm1.2,30.22a1.44,1.44,0,0,0-.24-.23s-.11,0-.16,0,0,.08,0,.1a.23.23,0,0,0,.12.1Zm45.2-25.22a.52.52,0,0,0,0-.56ZM94.45,54l-.29-.15-.22.09L94,54ZM75.74,55.3h.1l0-.44h-.07Zm57.19,2.54h-.06v.48h.06Zm48.85,13.52v0l-.28-.16,0,0,.23.2S181.75,71.37,181.78,71.36ZM80,71.48c.39,0,.39,0,.34-.18ZM78,59.77H77.9a.44.44,0,0,0,0,.16.76.76,0,0,0,.09.18s.07,0,.11,0a.8.8,0,0,1-.08-.16A1,1,0,0,1,78,59.77Zm56.82,9.75v0l.28.16,0,0-.23-.2S134.81,69.51,134.78,69.52ZM76.22,56.14h.1l0-.43h-.07Zm60.91,16.23v-.09l-.24-.12h-.08a.71.71,0,0,0,0,.15C136.92,72.34,137,72.35,137.13,72.37Zm-8-26.55h.1l0-.43h-.07Zm6.07,18h-.06v.48h.06Zm42,8.26c0,.15.11.37.32.18Zm-19.6-25.68h.1l0-.43h-.07Zm23.5,27.33c-.1-.09-.15-.27-.36-.14C180.82,73.7,180.87,73.88,181.08,73.75ZM106.89,52.68h-.06v.48h.06Zm70.5,19H177l.15.23Zm-91-29.38c.12.08.15.27.38.14C86.65,42.35,86.62,42.16,86.39,42.29Zm24.68,30.8c.13-.23-.06-.26-.14-.38C110.8,72.94,111,73,111.07,73.09ZM109.3,59.54h-.1l0,.44h.07Zm23.8-.76h.1l0-.43h-.07ZM182,73.34l.12.24.09,0,0-.35Zm-73-8.19h.06a.44.44,0,0,0,0-.16.76.76,0,0,0-.09-.18s-.07,0-.11,0A.8.8,0,0,1,109,65,1,1,0,0,1,109,65.15Zm5.38,8.39h.11l0-.31h-.06Zm5.92-18.22s0,0,0,0,0-.12,0-.15-.1,0-.15,0a.49.49,0,0,0,0,.16S120.28,55.29,120.3,55.32Zm32.88,18c-.13.32,0,.3.16.25Zm-42.35-.1-.07.09.2.15s.05-.09,0-.1Zm20.91-17h-.11l.05.31h.06Zm48.4,16.08v.11l.31-.05v-.06Zm-43.6.08v-.11l-.31,0v.06ZM132.1,64.1H132l0,.31h.06ZM82.62,68.88s0,0,0,0,0-.12,0-.15-.1,0-.15,0a.49.49,0,0,0,0,.16S82.6,68.85,82.62,68.88Zm27.92.82h.11l-.05-.31h-.06Zm69.05-.1-.09.07c.05.06.09.12.14.17s.07,0,.1,0Zm-68.45.46h.11l0-.31h-.06ZM86.62,57.82v-.11l-.31,0v.06Zm-.6.24V58l-.31,0v.06Zm-11.36.36h.11l0-.32h-.06Zm7.52-.24v-.11l-.31,0v.06ZM76.94,59h.11l0-.32h-.06Zm56.52.72h.11l0-.32h-.06Zm-25.84-.2h-.11l0,.32h.06ZM74,60.72H74v-.36H74Zm59.58.12h-.06v.36h.06Zm-24.72.72h-.06v.36h.06Zm-2.87.14h-.11l0,.31h.06Zm10.08.09.08.13.16-.2s-.08,0-.1,0A.85.85,0,0,0,116,61.79Zm12.64-15.37h.11l-.05-.31h-.06Zm-50,2.52h.11l0-.31h-.06ZM180.86,75H181l-.05-.32h-.06Zm.1-1V74h.36V74Zm-99.26.31v-.11l-.31,0v.06Zm74-28.78h.06v-.36h-.06ZM81.56,43c.32.13.3,0,.25-.16ZM128,46.68H128V47H128Zm54.22,28.18-.07.09.2.15s0-.09,0-.1ZM84.5,41.11,84.41,41l-.15.21s.09,0,.1,0S84.45,41.17,84.5,41.11Zm7.48,3s0,0,0,.05,0,.12,0,.15.1,0,.15,0a.49.49,0,0,0,0-.16S92,44.19,92,44.16Zm19,31.41v-.06h-.36v.06Zm5.55-14.13h.06V61.2h-.06Zm40-13-.1,0s0,.07,0,.1,0,.07.08.1ZM133.77,62.28h-.06v.24h.06Zm-.83-.36-.1.06c0,.06,0,.11,0,.16l.08,0C133,62,132.94,62,132.94,61.92Zm23.21-14h.06v-.24h-.06Zm-4,24.5-.18,0s0,0,0,.08l.16,0S152.13,72.43,152.16,72.38Zm4.11-24.14h.06V48h-.06ZM156,49.38l-.1,0s0,.07,0,.1.05.07.08.1Zm-46.79,24.9h.06V74h-.06Zm-1.8-15h.06V59h-.06Zm27.18,1.56h-.06v.24h.06Zm-28.86.24h.06v-.24h-.06Zm72.59,10-.06-.16s-.07.06-.08.1,0,.07,0,.1ZM131.18,60.54l-.1,0s0,.07,0,.1.05.07.08.1Zm-17,12.12-.06-.16s-.07.06-.08.1,0,.07,0,.1Zm66,0,.16-.06s-.06-.07-.1-.08-.07,0-.1,0Zm-47.37-12.5h-.06v.24h.06Zm-1.8,0H131v.24H131Zm11.82,5.52h.06V65.4h-.06Zm-21-.86,0,.1s.07,0,.1,0,.07,0,.1-.08ZM111.14,66.9l-.1,0s0,.07,0,.1,0,.07.08.1Zm-28,8.4-.1,0c-.06.08,0,.14,0,.2Zm52.56-8-.06-.16s-.07.06-.08.1,0,.07,0,.1ZM90.14,41.94l-.06-.16s-.07.06-.08.1,0,.07,0,.1Zm-7-.06h-.06v.24h.06ZM131.66,66.3l-.06-.16s-.07.06-.08.1,0,.07,0,.1Zm-.24-.12-.1,0s0,.07,0,.1.05.07.08.1ZM90.48,42l-.18,0s0,0,0,.08l.16,0S90.45,42.07,90.48,42Zm1.54.22c0-.07,0-.12,0-.18S92,42,92,42s0,.1,0,.16Zm64.49,3.48h.06v-.24h-.06ZM109.42,63.84l-.1.06c0,.06,0,.11,0,.16s.08,0,.08,0S109.42,63.91,109.42,63.84Zm-26.17,11h-.06v.24h.06ZM110.37,64h-.06v.24h.06Zm22.86-6.48h.06v-.24h-.06Zm-57.9-.24h-.06v.24h.06Zm-1.62.12h.06v-.24h-.06Zm57.72-.24h.06v-.24h-.06Zm-22.38-.36H109V57h.06Zm6,13.86-.06-.16s-.07.06-.08.1,0,.07,0,.1ZM75.94,56.52l-.1.06c0,.06,0,.11,0,.16l.08,0C76,56.64,75.94,56.59,75.94,56.52Zm15.2,17.14,0,.1s.07,0,.1,0,.07,0,.1-.08Zm40-16-.06-.16s-.07.06-.08.1,0,.07,0,.1Zm-41.84-.2,0,.1s.07,0,.1,0,.07-.05.1-.08Zm44.37.14h.06v-.24h-.06Zm-3.37-.18-.1,0s0,.07,0,.1.05.07.08.1Zm-16.08,16.2-.1,0s0,.07,0,.1,0,.07.08.1ZM77.54,55.38l-.06-.16s-.07.06-.08.1,0,.07,0,.1Zm3.6,14.88-.06-.16s-.07.06-.08.1,0,.07,0,.1ZM158.31,55.2h.06V55h-.06Zm3.51,18.1,0,.1s.07,0,.1,0,.07,0,.1-.08ZM78,53.88l-.1.06c0,.06,0,.11,0,.16l.08,0C78,54,78,54,78,53.88ZM116.49,70.2h-.06v.24h.06ZM90.63,52.56h.06v-.24h-.06Zm-14.77.18-.1,0s0,.07,0,.1,0,.07.08.1Zm16.36,2.92,0,.1s.07,0,.1,0,.07,0,.1-.08Zm13.48-.1-.1.06c0,.06,0,.11,0,.16l.08,0C105.72,55.68,105.7,55.63,105.7,55.56ZM75.5,53l-.1,0s0,.07,0,.1,0,.07.08.1Zm83,2.34h-.06v.24h.06Zm0,18.74.16-.06s-.06-.07-.1-.08-.07,0-.1,0ZM114.38,74l-.1,0s0,.07,0,.1.05.07.08.1Zm16.81-15.54h.06V58.2h-.06Zm-24.25.42-.06-.16s-.07.06-.08.1,0,.07,0,.1ZM156,50.22l-.1,0s0,.07,0,.1.05.07.08.1ZM77.5,58.44l-.1.06c0,.06,0,.11,0,.16s.08,0,.08,0S77.5,58.51,77.5,58.44ZM180.48,74s0-.1-.06-.1l-.16,0s0,.08,0,.08Zm-82.8-4.44s-.05-.1-.06-.1l-.16,0s0,.08,0,.08Zm56.5-19.06c0-.07,0-.12,0-.18s0,0-.08,0,0,.1,0,.16Zm-25.88-.18-.1,0s0,.07,0,.1.05.07.08.1Zm31.16,8c-.05,0-.1,0-.1.06s0,.11,0,.16l.08,0C159.48,58.44,159.46,58.39,159.46,58.32ZM159.24,74V74H159V74Zm-23.1-1.27.16-.06s-.06-.07-.1-.08-.07,0-.1,0ZM75.1,51.6c0-.07,0-.12,0-.18s-.05,0-.08,0,0,.1,0,.16ZM76,58.26l-.06-.16s-.07.06-.08.1,0,.07,0,.1Zm41.53.9h.06v-.24h-.06Zm-43.86-.24h-.06v.24h.06Zm57,0-.1.06c0,.06,0,.11,0,.16l.08,0C130.68,59,130.66,59,130.66,58.92Zm-15.8,13.74-.1,0s0,.07,0,.1,0,.07.08.1ZM82.34,70.84l0,.08s0,0,0,0l0-.08ZM97,70.38s0,0,0,0l-.08,0,0,0Zm39.7,5.06,0-.08s0,0,0,0,0,0,0,.08ZM79.32,71.22s0,0,0,0l-.08,0,0,0ZM135.8,75.7l0,0-.08,0,0,0ZM80.46,71s0,0,0,0,0,0,0,.08l0,0Zm34.84-.44,0,0,0,.08s0,0,0,0ZM82.42,75.88l0,0s0,0,0,.08,0,0,0,0Zm-.48-.08,0-.08s0,0,0,0l0,.08Zm.18,0,.08,0s0,0,0,0l-.08,0Zm13.32-5.36,0,0,.08,0,0,0ZM79.28,72.74l-.08,0,0,0,.08,0ZM85.06,74l0-.08,0,0S85,74,85,74Zm97.08-1.2,0-.08s0,0,0,0,0,0,0,.08Zm-3.52,1s0,0,0,0,0,0,0,.08,0,0,0,0S178.63,73.83,178.62,73.8Zm-93.82,0-.08,0s0,0,0,0l.08,0ZM78.28,73l0,0,.08,0s0,0,0,0Zm59.94-.46,0,0,0,.08,0,0Zm-44.58.1,0,0,.08,0,0,0Zm84.34,0,0,.08,0,0s0-.05,0-.08Zm2.58,0-.08,0s0,0,0,0l.08,0Zm2.4.6-.08,0,0,0,.08,0Zm-102.72.2,0,0-.08,0s0,0,0,0Zm5.72,0,.08,0s0,0,0,0l-.08,0Zm26.12,0,0,0-.08,0s0,0,0,0Zm72.14,0,0,.08,0,0,0-.08Zm-30.6.16,0,0s0,0,0-.08,0,0,0,0Zm-.9-.54-.08,0s0,0,0,0l.08,0Zm25.68.8,0,0-.08,0s0,0,0,0Zm-93.9,0,0,0s0,0,0-.08,0,0,0,0Zm-1.56,0,0,0s0,0,0-.08,0,0,0,0Zm-4,0,0-.08s0,0,0,0l0,.08Zm14.16-.52,0,0,0,.08s0,0,0,0Zm15.28-1.16,0,0s0-.05,0-.08,0,0,0,0Zm-12.26-.5s0,0,0,0l-.08,0S96.07,71.63,96.12,71.58Zm-.92.08,0,0,.08,0s0,0,0,0Zm87.92,3.52,0,0-.08,0,0,0Zm-45.9-.06,0,0s0,0,0,.08l0,0S137.23,75.15,137.22,75.12Zm23.92-.64,0-.08,0,0s0,0,0,.08Zm20.64-2.2,0,0,0,.08s0,0,0,0Zm-.34,2.06,0,0-.08,0s0,0,0,0Zm-99-1.84-.08,0s0,0,0,0l.08,0Zm52.46-.34,0,0s0,0,0,.08l0,0Zm46.68,0,0-.08,0,0s0,0,0,.08Zm.1,2.22-.08,0q0,.08.12,0ZM83,72.26l0,0,.08,0s0,0,0,0Zm10.1,0s0,0,0,0l0,.08s0,0,0,0S93.07,72.27,93.06,72.24Zm18.88,0,0,0,0,.08s0,0,0,0Zm44-20.42-.08,0,0,0,.08,0Zm1.4.2.08,0,0,0-.08,0Zm-61.26.22,0-.08s0,0,0,0l0,.08Zm61.36,0,0,.08,0,0s0-.05,0-.08Zm-80,.16,0-.08,0,0s0,0,0,.08Zm18.36,0,0-.08,0,0s0,0,0,.08Zm-22.6,0,0,0,0,.08,0,0S73.27,52.47,73.26,52.44Zm82.82,0-.08,0,0,0,.08,0Zm-80.5.26,0,0,0,.08s0,0,0,0Zm20.26.18,0,0-.08,0,0,0ZM75.1,53l0,0L75,53l0,0Zm-.82.14s0,0,0,0l-.08,0S74.23,53.15,74.28,53.1Zm1.44,0,0,0-.08,0s0,0,0,0Zm19.8,0,0,0-.08,0,0,0Zm-21.44.28.08,0,0,0-.08,0Zm.18.18,0,0s0,0,0,.08l0,0Zm82.06.66,0,0-.08,0,0,0ZM74.48,49.7l-.08,0,0,0,.08,0Zm-.1.26,0,0,0,.08,0,0Zm81.26.38s0,0,0,0l-.08,0,0,0Zm-55,.12s0,0,0,0l-.08,0,0,0Zm-9.5.26,0-.08,0,0,0,.08ZM75.52,51l0,0,.08,0,0,0Zm81.58.42,0,0,0-.08,0,0Zm-82.74.18-.08,0,0,0,.08,0Zm1.28,0,0,0,.08,0,0,0Zm80.7.06,0-.08,0,0,0,.08Zm.16,0,0,.08,0,0,0-.08Zm.8.16,0-.08,0,0s0,.05,0,.08ZM74.14,56.44l0,0s0,.05,0,.08,0,0,0,0Zm34.8,0,0,0,0,.08s0,0,0,0Zm-35,.26s0,0,0,0l-.08,0s0,0,0,0Zm57.8.08-.08,0s0,0,0,0l.08,0ZM78.14,57l0,0s0,0,0-.08,0,0,0,0Zm-2.44.24,0-.08,0,0s0,.05,0,.08Zm14.18.22,0,0-.08,0,0,0Zm-1.26.18,0,0,0,.08,0,0S88.63,57.63,88.62,57.6Zm-4.94.22.08,0s0,0,0,0l-.08,0Zm1.88.08s0,0,0,0l-.08,0s0,0,0,0Zm2.5-3.58,0-.08,0,0s0,0,0,.08Zm19.2.12,0-.08,0,0s0,.05,0,.08Zm49.22,0,0,0-.08,0s0,0,0,0Zm-63.62.14,0-.08s0,0,0,0,0,0,0,.08Zm39.74.1,0,0-.08,0s0,0,0,0ZM86.1,55l0,0s0,0,0,.08l0,0Zm6,.2,0,0,0-.08,0,0Zm-17,.16,0,0,0,.08,0,0S75.07,55.35,75.06,55.32Zm11.52,0,0,0s0,0,0,.08l0,0Zm6.16.2,0-.08,0,0,0,.08Zm13.76-.08,0,0,0,.08,0,0Zm-32.68.4,0,.08,0,0,0-.08Zm18.92.36,0,0,0,.08,0,0ZM86.58,41.28l0,0s0,0,0,.08l0,0Zm-2.88.12,0,0,0,.08s0,0,0,0S83.71,41.43,83.7,41.4Zm-.26.26,0,0,.08,0,0,0Zm-.54.42,0-.08,0,0,0,.08Zm48.08,0,0,0s0,.05,0,.08l0,0Zm-36.32,4.6,0,0,0,.08s0,0,0,0Zm-16.2.12,0,0,0,.08,0,0Zm-1.4.12,0,.08,0,0,0-.08Zm.44.12,0,0s0,.05,0,.08,0,0,0,0Zm2.16.24,0,0,0,.08,0,0Zm-.26.18,0,0-.08,0s0,0,0,0ZM75.22,48l0-.08s0,0,0,0l0,.08Zm.68-.08s0,0,0,0l0,.08,0,0S75.91,47.91,75.9,47.88Zm2.84.56,0,0s0,0,0-.08l0,0Zm43.38.5,0,0-.08,0s0,0,0,0Zm7.1-.06,0,0q-.08.07,0,.12Zm25.92,0,0,0s0,.09,0,.12Zm2.4.24,0,0s0,.05,0,.08,0,0,0,0Zm-83.2.08s0,0,0,0l0,.08,0,0S74.35,49.23,74.34,49.2Zm19-5.78,0,0-.08,0s0,0,0,0Zm63.16.92,0,0-.08,0s0,0,0,0Zm-62.3.1,0,0,0,.08s0,0,0,0Zm-2,.18.08,0s0,0,0,0l-.08,0Zm64.34.26s0,0,0,0,0,0,0,.08l0,0Zm-27.92.44,0-.08,0,0,0,.08Zm27.76.68,0,.08,0,0,0-.08ZM133.06,68.32l0,0,0,.08s0,0,0,0Zm-33.6.24,0,0,0,.08s0,0,0,0Zm68,0,0,.08s0,0,0,0,0,0,0-.08Zm-68.22.1-.08,0,0,0,.08,0Zm8.4.08,0,0-.08,0s0,0,0,0Zm27.84.12,0,0-.08,0s0,0,0,0Zm-25.46,0s0,0,0,0l0,.08s0,0,0,0S110,68.91,110,68.88Zm57.76,0,0,0s0,.05,0,.08,0,0,0,0Zm-59.2-2s0,0,0,0l0,.08,0,0S108.55,67,108.54,67Zm23.74.74,0,0,.08,0s0,0,0,0Zm3.88,0-.08,0,0,0,.08,0ZM97.24,69.94l.08,0s0,0,0,0l-.08,0Zm39,.24,0,0-.08,0s0,0,0,0Zm-26.18-.94s0,0,0,0,0,0,0,.08,0,0,0,0Zm25.92,0s0,0,0,0l0,.08s0,0,0,0S136,69.27,136,69.24Zm1.46.38-.08,0,0,0,.08,0Zm-4-9.46,0,.08,0,0s0-.05,0-.08Zm.22.26s0,0,0,0l-.08,0,0,0Zm-.76.16,0,0-.08,0,0,0Zm-16,.14,0,0s0,.05,0,.08,0,0,0,0Zm-42.86.5,0,0,.08,0,0,0Zm32.68,1,0,0-.08,0s0,0,0,0ZM85.5,58.08l0,0,0,.08s0,0,0,0Zm20.06.14-.08,0,0,0,.08,0Zm1.22.3,0-.08,0,0s0,.05,0,.08Zm-33,.12,0-.08,0,0s0,0,0,.08Zm33.6.2,0,0,0,.08,0,0Zm2.16.12,0,0,0,.08,0,0Zm22.68.6,0,0,0,.08,0,0Zm.48.36,0,0s0,0,0,.08l0,0Zm-25,.3,0,0-.08,0s0,0,0,0Zm-1.7,4.7,0,0s0,.05,0,.08,0,0,0,0Zm36.52.08,0-.08,0,0s0,.05,0,.08Zm-32.76.2,0,0s0,0,0,.08,0,0,0,0Zm-1,.52,0-.08s0,0,0,0l0,.08Zm-1.22.14,0,0-.08,0s0,0,0,0Zm2.34.1,0,0s0,0,0-.08,0,0,0,0Zm23.94.06-.08,0,0,0,.08,0Zm.14.26,0,0s0,.05,0,.08,0,0,0,0ZM111,66.7l0,0-.08,0s0,0,0,0Zm22.9,0s0,0,0,0l0,.08s0,0,0,0S133.87,66.75,133.86,66.72Zm-2.16-3.36,0,0s0,.05,0,.08,0,0,0,0Zm-7.32.36,0,0s0,.05,0,.08,0,0,0,0ZM100,64,100,64s0,0,0,0l.08,0Zm8.76,0-.08,0s0,0,0,0l.08,0Zm.7.34s0,0,0,0l0,.08,0,0Zm32.5.1.08,0s-.07,0-.12,0Zm-33.1.14,0,0,0,.08s0,0,0,0S108.91,64.59,108.9,64.56Zm33.88,0,0,0,0,.08s0,0,0,0ZM56.4,75.72c-.18.1-.38.19-.12.42-.16.16-.49.11-.53.41a2.64,2.64,0,0,1-.62.24c-.21,0-.33.34-.58.15,0,0-.08.07-.12.09a4.43,4.43,0,0,1-1.47.38,4.54,4.54,0,0,0-.69.21,2.88,2.88,0,0,1-.85.26c-.07,0-.14.06-.21.09l-.55.15a1.07,1.07,0,0,0-.77.19c-.09.08-.24.15-.35-.1s-.37-.17-.59-.14a.14.14,0,0,1-.11,0s0-.07,0-.15a1,1,0,0,0,1-.34c.2.16.34-.15.37-.12s1.2-.48,1.29-.54c-.13-.09-.18-.3-.38-.14a.37.37,0,0,1-.27.05,1.8,1.8,0,0,0-.62.12c-.09,0-.22,0-.18.15s.13.1.22.16c-.25.09-.5.19-.75.27a.28.28,0,0,1-.2,0c-.09-.08-.16-.07-.25,0a1.4,1.4,0,0,1-.42.28c-.13,0-.27-.07-.44,0a3.37,3.37,0,0,1-.73.13c-.24,0-.51-.11-.73.11l-.5.13c-.3-.08-.56.13-.85.12a.3.3,0,0,0-.19.1,1.31,1.31,0,0,0-.7.33s0,0,0,0c-.13-.18-.28.09-.37,0s-.23.07-.34.11a1,1,0,0,0-1.26-.14c-.08-.18-.16.09-.26,0s-.22,0-.33-.07a1.56,1.56,0,0,1-.62-.23,4.63,4.63,0,0,0-.91-.12,1.24,1.24,0,0,1-.74-.25,2.56,2.56,0,0,0-1.81-.35c.06-.5-.43-.35-.63-.55.1-.17.1-.17-.2-.31l-.08.39s-.07-.05-.07-.07a1.28,1.28,0,0,0-.52-1.34.31.31,0,0,0-.37-.1.72.72,0,0,1-.52,0c-.3-.19-.7-.16-.95-.45a.61.61,0,0,1-.09-.2l-.17.1-.07-.68a1.58,1.58,0,0,0-.2.23.41.41,0,0,1-.31.22c-.2,0-.14-.14-.2-.22a.05.05,0,0,0-.05,0c-.37-.07-.16-.47-.37-.63s-.52-.2-.52-.56c0,0-.08-.1-.13-.13A4.37,4.37,0,0,1,31,70.85c0-.08.1-.17.09-.26a19,19,0,0,1,.14-2c.21-.2.06-.45.11-.68a1.17,1.17,0,0,1,.1-.15v1a7.06,7.06,0,0,0,.44-2.37.36.36,0,0,1,.33.41,2.19,2.19,0,0,0,.2-.42c0-.07.1-.39-.16-.12A1.24,1.24,0,0,1,32,66c0-.06,0-.21,0-.22-.59-.14,0-.53-.16-.75l.14.12a.92.92,0,0,1,.49-.73c.29.1.32-.18.39-.32a2.47,2.47,0,0,1,.61-.8c0,.21,0,.37,0,.57,0,0,0,0-.07,0s-.08.14,0,.23a.33.33,0,0,0,.08-.18,3.27,3.27,0,0,0,.5-1.31l.15.31a9.31,9.31,0,0,0,.29-1c.21-1.16.54-1.17.28-2.65l-.06.6-.15-.13-.17.37c0-.76,0-1.38,0-2s.53-2.9.16-3.39l-.13.26a1.57,1.57,0,0,1,0-.71,1.85,1.85,0,0,0-.08-.77s0-.06,0-.09a2.58,2.58,0,0,1,.08-.26l.28.11a2,2,0,0,0,0-.35c.14-.18.34-.33.18-.67-.08.27-.13.47-.18.67-.35,0-.38-.23-.08-.68.14-.12.22-.28,0-.4q-.33-.69.18-.93s0,0,0,0l0,0,.07.06s0,0,0-.08a4.54,4.54,0,0,1-.07-.82,8,8,0,0,0-.12-2s-.09-.08-.13-.13-.09-.08-.1-.12a12.69,12.69,0,0,1-.12-2,.24.24,0,0,1,.06-.08l.13.11a.34.34,0,0,0,0-.11c0-.21,0-.41-.06-.64s.09-.4.05-.58a13.53,13.53,0,0,1-.12-2.29,4.23,4.23,0,0,0-.18-.78l-.09.44h-.07v-.58h-.09a1.85,1.85,0,0,0,0,.23,18.86,18.86,0,0,0,0,2.3,2.55,2.55,0,0,1,0,.48,1.12,1.12,0,0,1-.24.79,11.11,11.11,0,0,0,.12-1.16c.1-.27-.32-.53,0-.8,0-1-.05-1.82-.11-2.77,0-.37,0-1.18,0-1.52,0-3-.16-6-.24-9-1.32-.56-4.48,2-6,1.17a3.19,3.19,0,0,0-.64-.2l-.46-.08c0-.28.06-.59-.13-.84,0,0,0,0,0-.06.1-.37-.05-1.22.21-1.52s-.46-.84.4-1.1l-.23-.09c0-.16.42-.26.1-.5.23-.16.14-.34,0-.5l.44-.13c-.39,0-.51-.15-.34-.36a.38.38,0,0,0,.09-.64s0-.05,0-.08c.16,0,.27-.1.2-.26a1.14,1.14,0,0,0-.22-.32s.08-.06.1-.05A1.76,1.76,0,0,0,28.69,24a1.51,1.51,0,0,1-.08.3c-.09.1-.19.19-.28.28.21.27.05.59.14.92a.39.39,0,0,0,.32-.41.81.81,0,0,0,.31-.67l.12.24a.71.71,0,0,0,.06-.73.58.58,0,0,0,.12-.1s0-.09.11-.14v.55a1.06,1.06,0,0,0,.85-1.08c.15-.59,1.86-.88,2.19-1.35,0-.06.13-.07.2-.09s1.41-.63,1.59-.43a8.18,8.18,0,0,0,2.61.28l-.46-.07a.23.23,0,0,1,.06-.09c.18,0,.34-.16.55-.12a.34.34,0,0,0,.21-.06,14.24,14.24,0,0,1,3.83-.9c1.34.13,2.69.21,4,.24.55.22,1.18,0,1.71.36.71,0,1.36.36,2.07.36.59.28,1.29.21,1.85.59,1.46,0,3.71,1.36,5,1.93q1,.07.81.84c-.15,0-.16.14-.09.2s.37.26.56.39c.42-.25.65.15,1,.31-.33-.15-.54-.09-.64.18-1.47-.05-2.19-.54-2.18-1.5-.25-.19-.47-.45-.89-.41,0,0,0,0,0-.07s-.06-.06-.08-.06l-.15.05a.33.33,0,0,0,.18.08c.16.14.34.23.41.47a6.41,6.41,0,0,1-1.71-.48c-.38-.32-.9-.33-1.29-.64a5.83,5.83,0,0,0-1.16-.67,1.68,1.68,0,0,0-.82-.51c-.06,0-.26-.12-.29-.09a11.23,11.23,0,0,1-1.52,0c-.28-.51-3.74-.27-4.25-.1-.1-.25-.3-.07-.47-.12.22.45.5.56.84.31.08-.48,2.28.83,2.38.82l.11.13a4.29,4.29,0,0,1-.85.37.19.19,0,0,1-.36.08s-.14,0-.16,0c-.17.2-.41,0-.61.12.17.45,4.6.61,5.24.58A1,1,0,0,0,51,23.92l.35.35c1.25-.37,2.43,1,3.57,1.2a.52.52,0,0,1,.19.11l-.06.1a1,1,0,0,1-.73-.2c-.17,0-.36,0-.53-.05A10.41,10.41,0,0,1,51.4,25a7,7,0,0,0-1.19-.25l.91.76c-.32.29-.71.16-1.08.25a.73.73,0,0,1,.7,1s-.07,0-.08,0c-.17-.19-.16.1-.27.09l.64.33.21-.2L51,26.82a1.65,1.65,0,0,1,.62-.14c-1.31-2.31,4.61.08,4.74.11s0,0,0,0l0,0,.07.06s0,0,0-.08a.58.58,0,0,1-.06-.2c-.35-.08-.36-.45-.56-.68a1.39,1.39,0,0,1,.74.46c.22,0,.15.22.29.29a19.59,19.59,0,0,1,2.36,1.91s.1.11.14.1a4.48,4.48,0,0,1,2.12,2c.12.18.38.05.5.24.15-.26-.06-.43-.15-.62a.53.53,0,0,1-.14-.78,1.31,1.31,0,0,1,.63.79l.31-.23c-.07.39-.05.47.18.72l.72.84.11-.24,0,0c.35.67.73,1.33,1.13,2a4.11,4.11,0,0,1,.21.62l-.12.09.18.21s0,0,0-.06l-.06,0,.07.18s0-.06,0-.17a.65.65,0,0,1-.06-.3c.3.17.36.51.57.75l0,.05a.7.7,0,0,0,.12.8,19.27,19.27,0,0,1,1.07,2.13c0,.22.06.42.06.63.24.51.46,1,.65,1.56a.25.25,0,0,1,0,.17A11.13,11.13,0,0,1,67.8,42a.92.92,0,0,0,.22.57,2.66,2.66,0,0,1,.26,1c-.09,0-.23-.06-.24.15v0a.25.25,0,0,0-.09,0s0,0,0,.07a.29.29,0,0,0,.07-.08c.22.09.23.09.24-.15,0,0,.11.1.11.15,0,.24-.06.52,0,.71s.19,1.67.52,1.87.15.12.1.31a3.17,3.17,0,0,0,0,.92c0,.09.09.21,0,.27-.4.8.19,2.25.13,3.15,0,.33-.07.66-.11,1,0,.06,0,.15,0,.23.15.26.09.32-.17.19l-.17.23-.07-.49h-.06l0,.32c-.07.13-.12-.22-.25,0a3.5,3.5,0,0,0-.44,1.19c-.08.36-.08.73-.14,1.09a1.74,1.74,0,0,1-.16.41.4.4,0,0,0-.54-.07,5.79,5.79,0,0,0-.15,1.41c.27-.14,0-.44.32-.45,0,0,0,0,0-.06l-.06,0,.07.18s0-.06,0-.17a3.05,3.05,0,0,1,.09-.81,2.48,2.48,0,0,1-.07,2.29s-.07.09-.08.14l-.12,1.15a4.16,4.16,0,0,0,.12.69,5.84,5.84,0,0,1-.33,2,4.28,4.28,0,0,1-.62,1.66c0,.16-.11.18-.21.27a1,1,0,0,0-.16.47c0,.15-.15.07-.24.09s0-.25,0-.29c.24-.18.21-.43.24-.69a4.54,4.54,0,0,1,.23-.68.36.36,0,0,0,0-.24c-.13.44-.44.76-.58,1.2a6.71,6.71,0,0,1-.64,1.17c-.22-.22,0-.38.09-.55a1.74,1.74,0,0,1,.3-.46c-.06-.05-.19-.11-.2-.19a3.58,3.58,0,0,0-.11-.73.75.75,0,0,1,.06-.63,2.24,2.24,0,0,0,.16-.7.58.58,0,0,1,.07-.21c.16-.21.13-.47.22-.69a1.6,1.6,0,0,0,.2-.64.39.39,0,0,1,.13-.3c.17-.15.06-.33.08-.5a15.21,15.21,0,0,0-.71,1.67c-.24.56-.52,1.1-.81,1.69,0-1.47,1-3,1.32-4.44l-.26.33v-.47c-.34.12-.22.38-.24.62v0a.25.25,0,0,0-.09,0s0,0,0,.07a.29.29,0,0,0,.07-.08,1.05,1.05,0,0,1,.24-.15,1,1,0,0,1,0,.3c0,.06-.1.11-.16.17-.38-.06-.58.11-.61.52-.05,0,.06.22,0,.34l-.31.78.33-.22c-.13.55-.38,1-.55,1.57l-.1-.48a.86.86,0,0,1-.8.38v-.39c-.41.3-.45.76-.68,1.1a.57.57,0,0,0,.31-.19c.09-.13.07-.33.25-.4,0,.11,0,.26,0,.33-.23.24-.17.49-.08.78v0a.25.25,0,0,0-.09,0s0,0,0,.07a.29.29,0,0,0,.07-.08.18.18,0,0,1,.12,0L63,63.3l.2-.17s.08.11.07.12-.11.41-.36.47v-.3a1.71,1.71,0,0,0-.6.9c-.09,0-.22,0-.26.09a1.58,1.58,0,0,0-.34.78v0a.25.25,0,0,0-.09,0s0,0,0,.07a.29.29,0,0,0,.07-.08.8.8,0,0,1,.18-.15c0,.08,0,.16,0,.23a1.68,1.68,0,0,1-.07.3,1.14,1.14,0,0,0-.23.28c.23.09.24,0,.23-.28a.14.14,0,0,0,.18-.06c.34-.61.9-1,1.28-1.62a.14.14,0,0,1,.15,0s.08.12.07.14c-.18.17,0,.57-.44.6A1.68,1.68,0,0,0,63,65v0a.25.25,0,0,0-.09,0s0,0,0,.07A.29.29,0,0,0,63,65s0,0,.06,0c.19.09.37.1.51-.21.08.47-.21.71-.34,1.09a1.13,1.13,0,0,0,.63-.64l.5.34c-.19.24-.38.47-.55.72a1,1,0,0,0-.09.26l-.12.12c-.19.05-.26.17-.24.39v0a.25.25,0,0,0-.09,0s0,0,0,.07a.29.29,0,0,0,.07-.08.34.34,0,0,0,.24-.39l.12-.12.53-.39.06.08L64,66.5l.51-.08c.14.42-.56.77-.25,1.18.13.18.18-.1.28,0l.08,0c-.51.78-1.21,1.41-1.7,2.21a7.7,7.7,0,0,1-1.3,1.44,5.53,5.53,0,0,0-.82,1,6.14,6.14,0,0,1-2,1.32c.26-.22.31-.43.14-.64,0,0-.14,0-.13.06,0,.23-.37.28-.25.56l-1.44,1.34c-.07,0-.24-.06-.32,0a4.78,4.78,0,0,0-.55.39l.41.09C56.52,75.49,56.32,75.5,56.4,75.72ZM60.84,65v0a.25.25,0,0,0-.09,0s0,0,0,.07a.64.64,0,0,0,.14-.22l-.07.06,0,0,.06-.07S60.92,64.82,60.84,65Zm1.63-2.56-.07.06.05.05.06-.07s0,0-.11.12v0a.25.25,0,0,0-.09,0s0,0,0,.07A.64.64,0,0,0,62.47,62.41ZM51.91,69.73l-.07.06,0,0,.06-.07s0,0-.11.12v0a.25.25,0,0,0-.09,0s0,0,0,.07A.64.64,0,0,0,51.91,69.73Zm3.77-.13a1.65,1.65,0,0,0,.19-.23l-.07.06.05,0,.06-.07s0,0-.11.07a.5.5,0,0,0-.12.17V69.6a.25.25,0,0,0-.09,0s0,0,0,.07A.2.2,0,0,0,55.68,69.6Zm-.65.49-.07.06,0,0,.06-.07s0,0-.11.07a.22.22,0,0,0-.07.21c-.07-.06-.09-.09-.11-.09a.8.8,0,0,0-.15,0s0,.08,0,.08a.2.2,0,0,0,.19-.11A1.65,1.65,0,0,0,55,70.09ZM54.79,70l-.07.06.05,0,.06-.07s0,0-.11.12v0a.25.25,0,0,0-.09,0s0,0,0,.07A.64.64,0,0,0,54.79,70Zm-1-.72-.07.06.05,0,.06-.07s0,0-.11.12v0a.25.25,0,0,0-.09,0s0,0,0,.07A.64.64,0,0,0,53.83,69.25ZM53.59,69l-.07.06,0,.05.06-.07s0,0-.11.12v0a.25.25,0,0,0-.09,0s0,0,0,.07A.64.64,0,0,0,53.59,69ZM44.28,57.84l0-.1-.08.1c-.13,0-.3,0-.2-.24h.72a1.12,1.12,0,0,0-.11-.24c-.07-.1.15-.23,0-.3l.27-.06a.47.47,0,0,0,.09-.06c-.16-.25-.16-.25,0-.3l.19-.07c-.22-.17,0-.24.08-.28a.64.64,0,0,1,.4-.07,8.75,8.75,0,0,1,1.21-.54c.05,0,.11.12.15.11a1.58,1.58,0,0,0,.37-.11c.24-.1.46-.24.71-.32a1.61,1.61,0,0,1,1.45-.28s.1,0,.12,0c.59-.09.81.11.68.6-.2.06-.26.17-.12.34s.24.25.36.38c.09.37.1.37.43.24,0,0,.11,0,.28.07l-.06-.07-.05,0,.07.06s0,0-.07-.11l.12-.18.32.31-.36.32.6.26c-.21.06-.33.11-.45.13a2.21,2.21,0,0,1-.88.12l.13-.34c.14.19.25-.06.39,0s.16-.12.07-.24c-.33.08-1,.27-1.07-.34l-.07.06,0,0,.06-.07s0,0-.11.07l-.57,0,.42-.19c-.37.08-.5-.1-.38-.55a1.2,1.2,0,0,0-.07.18.4.4,0,0,0,0,.11s.1-.05.11-.08,0-.1-.11.08h-.24s-.08.06-.12.09l.12.15a1.76,1.76,0,0,1,0,.23.35.35,0,0,1-.08.13l-.28-.18.11-.11a.38.38,0,0,1-.16-.3l-.07.06,0,0,.06-.07s0,0-.11.07a1.23,1.23,0,0,1-1.08.24l.42.2c-.21,0-.4,0-.49.07-.3.25-.09-.2-.22-.14-.3.49-1.18.69-1.39,1.17-.07.16-.12.33-.19.51-.13-.3-.13-.3-.29-.18a1.57,1.57,0,0,0-.19.18c-.15-.26-.15-.26-.65-.43a.48.48,0,0,0,0,.12,1.5,1.5,0,0,1,.11.13c-.05,0-.11.06-.15,0-.28-.06-.35,0-.44.22,0,.05,0,.13-.07.13-.27,0-.34.3-.54.43.27.14.32.28.18.42s-.13.07-.18.12-.2.21-.35.36h-.46c-.06.56.66.41.94.26v.22l-.1,0,.1.08V61c-.28.21-.49.35-.69.51a3.42,3.42,0,0,1-.63.09.43.43,0,0,1-.05-.37l-.38.06.31.43c0,.12.11.27.06.34-.16.26.25,0,.14.26h-.25c-.23-.12-.31,0-.25.25a.49.49,0,0,1-.06.77s0,0,0,.11v0a.25.25,0,0,0-.09,0s0,0,0,.07a.2.2,0,0,0,.07-.11l.7-.15c-.26.19-.71,1-.88,1.11a1,1,0,0,0-.54.24c-.14.15-.37.22-.43.47,0,0-.31,0-.31.21-.26.05-.29.4-.57.47A8.24,8.24,0,0,0,39,66.77c.08.31-.38.46-.25.79a16,16,0,0,1-.71,2.23,2.16,2.16,0,0,1,0,.8A1.32,1.32,0,0,0,37.83,72h.58a.84.84,0,0,0,.3,1.1,2.12,2.12,0,0,1-.17-.32.32.32,0,0,1,.29-.33c.05,0,0-.15.05-.22.2.14.17.43.39.58s.29.41.47.57.26.11.23.32.14.07.23.09.15.54.46.64a1.69,1.69,0,0,0,.39.08l.21-.1c-.24.36.11.63,0,1,.18-.1.25-.33.45-.17,0,0,0-.07,0-.1a2.08,2.08,0,0,0-.1-.24c.11,0,.21,0,.26,0s.08.16.14.22.14,0,.2.09l.4.4c.27-.36.58.11.88,0l-.07-.18s.08,0,.1,0,.1.07.11.11,0,.23,0,.36c.25-.11.52-.13.58-.42-.39,0-.52-.15-.39-.4.16.22.2,0,.3-.08.38-.15.73-.42,1.19-.13s.47,0,.43-.41l-.13.26-.12-.25c-.16.22-.42-.17-.59.09,0,.07-.21.06-.31.1-.54,0-.61-.15-.23-.55a.78.78,0,0,1,.71-.07c.09,0,.23,0,.34,0a.32.32,0,0,0,.37-.22,3,3,0,0,1-.34-.2s0-.1,0-.15a.12.12,0,0,1,.1,0l.35.31s.06,0,.09,0l0-.29.56-.17.05.33a4.27,4.27,0,0,0,1.17-.37l-.06-.07-.05,0,.07.06s0,0-.07-.11c0-.29.18-.4.41-.48s.17-.11.25-.11.16.07.25.1c0-.34.44-.22.53-.47.06,0,.12-.11.18-.11s.18-.12.18-.25a.68.68,0,0,0,.78-.26c.1,0,.12-.18-.06-.22l0-.1-.08.1a.66.66,0,0,1-.82-.16l.46-.32a2.53,2.53,0,0,1,1.31-1l-.06-.07,0,0,.07.06s0,0-.07-.11c.07-.23.26-.07.39-.12s.29.11.4-.23l-.07.06.05,0,.06-.07s0,0-.11.07H51.5a1.48,1.48,0,0,0,.5-.58c.25-.26.51-.51.76-.76s1.21-1.56,1.71-1.35l-.06-.07,0,0,.07.06s0,0-.07-.11A22.31,22.31,0,0,0,55.83,65a.26.26,0,0,1,.33-.17c-.06.21-.26.36-.23.66l-.31.31c.18,0,.33-.12.3-.37q.78-.3.24-.6a12.59,12.59,0,0,0,1-1.23c.22-.52.75-.85.85-1.44,0,0,.09-.06.13-.09a14.79,14.79,0,0,0,2.8-3.84c.75-1.39,1.45-2.8,2.17-4.2.06-.12.19-.24.17-.34.08-.49.16-1,.25-1.46a3.27,3.27,0,0,1,.1-1,19.33,19.33,0,0,0,.14-4c0-.45.35-.92.35-1.24a.45.45,0,0,1,.18-.35.19.19,0,0,0,0-.13,2.87,2.87,0,0,0-.14-.72A1.49,1.49,0,0,1,64,44c-.3-.37-.3-.87-.54-1.28a2,2,0,0,1-.31-1c0-.1-.1-.2-.16-.3a.55.55,0,0,0,0,.47c.13.21,0,.26-.16.39a4.79,4.79,0,0,1-.44-1.34c-.13-.31-.13-.67-.43-.91v-.65c.24.06.11.31.22.46a1,1,0,0,1,.27.77c0,.06.15.14.36.33l-.07-.12c-.09.06-.09.13,0,.23s0-.06-.07-.23a2.79,2.79,0,0,0-.72-1.87v.43c-.23,0,0-.28-.15-.32-.44-.14-.5-.62-.79-.89a.31.31,0,0,0-.23.46,1.12,1.12,0,0,1,.08.26.14.14,0,0,1-.07.12c-.49.13-.89-1.8-.52-2.22l.37.37v-.75l.56.43A9.75,9.75,0,0,0,60.35,35a1.13,1.13,0,0,0-.71-.18l.11-.55a9.93,9.93,0,0,0-.86-1.08,6,6,0,0,1,.27.63c0,.13-.1.22-.17.15-.23-.24-.25.13-.37.11s-.2-.25-.4-.23-.11.34-.35.37a1.46,1.46,0,0,1-.95-1.62,2.58,2.58,0,0,0,1,1c.12-.3-.13-.49-.13-.73a4.58,4.58,0,0,1-.92-.78,1.8,1.8,0,0,0-1.19-.85v.3c-.08,0-.19.09-.22.06-.36-.29-.34-.53.07-.7a1.36,1.36,0,0,1,.11-.53c0-.08-.19-.15-.19-.22a.32.32,0,0,0-.55,0,3.79,3.79,0,0,0-.76-.79,15.73,15.73,0,0,0-3.82-.7c-.12,0-.25-.13-.4-.23a.64.64,0,0,1,0,.25s-.11.08-.16.11,0-.09,0-.12c.16-.24,0-.34-.18-.41a.18.18,0,0,1-.08-.09s0-.05,0-.08l.42-.07a4.73,4.73,0,0,1-.8-.35c-.43.06-.47.17-.14.35-.23.2-.23.2-.91-.11a2.22,2.22,0,0,1,.15-.43l-.07.06.05.05.06-.07s0,0-.11.07l-.35,0,.11-.08c-.06-.08-.14-.08-.23,0a.33.33,0,0,0,.23.07v.3a1.67,1.67,0,0,1-1.52.08c-.07.13-.15.23-.2.22-.21,0-.42.07-.63-.1a.3.3,0,0,0-.41.07,2.43,2.43,0,0,0-.15.26l-.31-.16.13-.26-.63-.13a3.87,3.87,0,0,1-1.16.64l.58.23a8.92,8.92,0,0,0-2.13.41.88.88,0,0,1-.17-.1.86.86,0,0,1-.13-.14c0,.06-.06.15-.11.16-.24.09.12,2.75.08,2.92-.08.55-.19,1.11-.32,1.66a1.3,1.3,0,0,1-.24,1v1.17h.08l.07-.36c.08.09.06.19.09.27a2.52,2.52,0,0,1,.23.57,2.18,2.18,0,0,1-.11.6s0,.08.09.09q.74.33.18,1.29c0,.21,0,.43,0,.64.12,0,.17-.17.25,0,.5.95-.12,3.83-.59,4.76a2.76,2.76,0,0,0-.11,1.47l.21-.43c0-.87-.15,1.73.3,1.08l.15.14.06-.5c.08.2,0,.42.14.57.24.38,0,1.34-.14,1.74a11,11,0,0,0-.55,2.47l-.33.06a2.49,2.49,0,0,1-.16,2h0a.25.25,0,0,0,0-.09l-.07,0a.2.2,0,0,0,.11.07c0,.19-.13.3-.17.47l-.16-.08c0,.1,0,.19,0,.29s.39,0,.14.22c0,0,.12.28.08.34-.19.21-.09.45-.11.67a16.54,16.54,0,0,1-.77,3.49l-.13-.11a1.24,1.24,0,0,1-.23.23h0a.25.25,0,0,0,0-.09l-.07,0a.2.2,0,0,0,.11.07v.36l.54-.28-.23.67-.17-.34v.6c.16-.07.33-.18.38-.14s.22,0,.32,0c-.05.12.11.3-.17.36h.05a.25.25,0,0,0,0-.09s0,0-.07,0a.2.2,0,0,0,.11.07l.12.38.48-.38c0,.17.08.22.21.29s.14,0,.15-.08a.15.15,0,0,1,.1,0c.26,0,.32-.07.21-.26s-.1-.19,0-.3a3.72,3.72,0,0,0,.26-.34l.1.64a1.25,1.25,0,0,1,.78-.33s.14,0,.22.06l-.37.3.34.16.07-.19.46.15c-.21.1-.12.27-.1.44l-.29-.13,0,.37a.86.86,0,0,0,.2-.26.85.85,0,0,1,.35.07l-.06-.07-.05,0,.07.06s0,0-.07-.11a2,2,0,0,1,.35-.83c.2,0,.13-.17.13-.27s-.15-.07-.23-.1a.58.58,0,0,1-.13-.14s0-.1.06-.09c.35.1.29-.2.36-.39,0,.29.27.23.45.33l-.16,0-.12.08c.26.09.42,0,.49-.2l.1,0ZM37,50.77l-.07.06,0,.05.06-.07s0,0-.11.12v0a.25.25,0,0,0-.09,0s0,0,0,.07A.64.64,0,0,0,37,50.77Zm18.72,21.6-.07.06,0,0,.06-.07s0,0-.11.07-.08.08-.13,0l-.22.35c.23.09.24,0,.23-.21A1.65,1.65,0,0,0,55.75,72.37Zm.29-.61a1.65,1.65,0,0,0,.19-.23l-.07.06.05,0,.06-.07s0,0-.11.07l-.12.12A.22.22,0,0,0,56,72c-.07-.06-.09-.09-.11-.09a.8.8,0,0,0-.15,0s0,.08,0,.08a.2.2,0,0,0,.19-.11Zm-8.57,1.81-.07.06.05.05.06-.07s0,0-.11.12v0a.25.25,0,0,0-.09,0s0,0,0,.07A.64.64,0,0,0,47.47,73.57Zm11.76-1-.07.06.05,0,.06-.07s0,0-.11.12v0a.25.25,0,0,0-.09,0s0,0,0,.07A.64.64,0,0,0,59.23,72.61ZM47.59,74.05l-.07.06,0,0,.06-.07s0,0-.11.12v0a.25.25,0,0,0-.09,0s0,0,0,.07A.64.64,0,0,0,47.59,74.05Zm8.69-2.84v0a.25.25,0,0,0-.09,0s0,0,0,.07a.64.64,0,0,0,.14-.22l-.07.06,0,0,.06-.07S56.36,71.06,56.28,71.21Zm.31,0-.07.06,0,0,.06-.07s0,0-.11.12v0a.25.25,0,0,0-.09,0s0,0,0,.07A.64.64,0,0,0,56.59,71.17Zm-4.51.4v0a.25.25,0,0,0-.09,0s0,0,0,.07a.64.64,0,0,0,.14-.22l-.07.06.05,0C52.22,71.4,52.2,71.42,52.08,71.57Zm-1.2,6.19.1,0-.1-.08c-.05,0-.11-.12-.14-.11a2.75,2.75,0,0,0-.42.23h.44l0,.1Zm-3.73-1.25-.06-.07-.05,0,.07.06s0,0-.07-.11l0-.1-.08.1H46.7l0-.09.47-.22a.37.37,0,0,0-.5,0,.51.51,0,0,1-.37.11c-.27.12-.25.2,0,.24a.48.48,0,0,0,.12,0c.19.26.21.26.48,0A.48.48,0,0,1,47.15,76.51Zm7.57-4.94v0a.25.25,0,0,0-.09,0s0,0,0,.07a.64.64,0,0,0,.14-.22l-.07.06.05,0C54.86,71.4,54.84,71.42,54.72,71.57Zm-2.95-.8c-.07-.06-.09-.09-.11-.09l-.15,0s0,.08,0,.08.13,0,.26-.22l-.07.06.05.05.06-.07S51.8,70.58,51.77,70.77Zm-17-19.3-.08-.11s-.06.06-.06.08a.88.88,0,0,0,0,.15.86.86,0,0,0,.14-.34l-.07.06.05,0,.06-.07S34.88,51.26,34.82,51.47Zm29.88,7-.08-.11s-.06.06-.06.08a.88.88,0,0,0,0,.15s.06-.07.14-.52a1.2,1.2,0,0,0-.07.18.4.4,0,0,0,0,.11s.1,0,.11-.08S64.78,58.14,64.7,58.43ZM53.64,70.08c.09,0,.23.06.24-.12.09,0,.23.06.24-.12s.08-.08.17-.49c0,.06,0,.07,0,.09v.28h0c0-.1,0-.21.06-.31s0,0-.11.31l-.12.12c-.23-.06-.07-.24,0-.47l-.07.06,0,0,.06-.07s0,0-.11.07a1.48,1.48,0,0,0-.24.29v0a.25.25,0,0,0-.09,0s0,0,0,.07a.2.2,0,0,0,.07-.11c.18,0,.1.15.12.24s-.23-.06-.24.17v0a.25.25,0,0,0-.09,0s0,0,0,.07A.2.2,0,0,0,53.64,70.08ZM65.07,37c.06-.07.09-.09.09-.11a.8.8,0,0,0,0-.15s-.08,0-.08,0,0,.13.24.31L65.22,37l-.06,0,.07.18S65.26,37.13,65.07,37ZM54,68.75l-.12.07s0,.06.06.06l.17-.07s-.06,0-.23.12v-.05a.25.25,0,0,0-.09,0s0,0,0,.07A1.28,1.28,0,0,0,54,68.75Zm-4.15,5.62c-.07-.06-.09-.09-.11-.09a.8.8,0,0,0-.15,0s0,.08,0,.08.13,0,.31-.24l-.12.07s0,.06.06.06l.17-.07S50,74.18,49.85,74.37Zm-3.53,1.11,0,.1.08-.1H47c.17,0,.28-.07.44-.37l-.12.07s0,.06,0,.06l.18-.07s-.06,0-.23.07a1,1,0,0,0-.84.24s-.08,0,0,0l-.35-.22C46,75.48,46.16,75.49,46.32,75.48ZM53.9,73c-.3,0-.44,0-.35.22a.63.63,0,0,0,.28-.34l-.07.06.05,0,.06-.07S53.84,72.86,53.9,73Zm1.4-2.78c.3,0,.44,0,.35-.22a.39.39,0,0,0-.21.23l-.6.54c.2-.15.45-.08.48-.36v-.06c-.22,0-.3.14-.43.25s0,.05.43-.25C55.36,70.28,55.4,70.24,55.3,70.19ZM56,66.72h0c0-.09,0-.12-.11-.07s0,0,.35.15l0-.09a.68.68,0,0,0-.2.07.64.64,0,0,0,0,.15C56.14,66.89,56.21,66.84,56,66.72Zm9.36-4.43c0-.06.05-.07.05-.09v-.28h-.05c0,.1,0,.21-.06.31s0,0,.18-.6a1.2,1.2,0,0,0-.07.18.4.4,0,0,0,0,.11s.1-.05.11-.08S65.5,61.74,65.35,62.29ZM43.83,76.92h.1l0-.36a.21.21,0,0,0-.09.16c0,.07,0,.14.35,0l-.07,0s0,.11,0,.15-.22.06-.08.19a.13.13,0,0,0,.1,0C44.24,76.82,44.17,76.79,43.83,76.92ZM63.89,67c-.18,0-.34.09-.24.37a3,3,0,0,0,.26-.51l-.07.06,0,0,.06-.07S63.92,66.86,63.89,67ZM52,22.44h0a.25.25,0,0,0,0-.09s0,0-.07,0,0,.05,0,.07l.62.27C52.46,22.4,52.26,22.44,52,22.44ZM54.64,73c-.35-.13-.46.11-.61.3a.73.73,0,0,0,.29-.11.39.39,0,0,1,.29-.08l.22-.35C54.6,72.66,54.59,72.8,54.64,73Zm-2.31-3.94c.15-.15.29-.28.42-.42s0-.14,0-.22c-.16.21-.49.27-.45.64v0a.25.25,0,0,0-.09,0s0,0,0,.07ZM62.75,68a1.53,1.53,0,0,0,.46-.76.86.86,0,0,0-.43.8l-.08-.11s-.06.06-.06.08a.88.88,0,0,0,0,.15A.22.22,0,0,0,62.75,68Zm4.06-11.12a2.08,2.08,0,0,0-.3,1.25,3.1,3.1,0,0,0,.38-1.61c0,.06,0,.07,0,.09v.28h0c0-.1,0-.21.06-.31S66.92,56.54,66.81,56.87Zm-27.33-5-.36.17v.91c-.26.08-.07.3-.14.45-.21.83-.41,1.66-.62,2.49l-.2-.43a1.49,1.49,0,0,1-.24,1.16,6.31,6.31,0,0,1,0,1,3.28,3.28,0,0,1-.25.44l.27.13c-.22.21,0,.6-.35.77,0,0,0,.17,0,.26a2,2,0,0,0,.13.25c.06-.29.45-.29.46-.6.23.31.35-.12.54-.08l.13.08a7.47,7.47,0,0,1,0-.86c0,.06,0,.07,0,.09v.28h0c.09-.41.08-.41,0,0-.43-.08-.44-.38,0-.9a4,4,0,0,0,.14-.78c.21-.34.08-.72.13-1,.2-.13.08-.31.1-.46l-.1,0c0,.16,0,.31,0,.46h-.06c-.15-.21,0-.51-.18-.71a.81.81,0,0,1,.44-.39s0-.07,0-.08,0-.18,0-.3,0-.29,0-.44a.24.24,0,0,0-.09.15l0,.21c-.08-.19-.14-.45-.05-.55s-.13-.35,0-.53a2.08,2.08,0,0,0,.38-1c.08-.1.19-.18.21-.28s-.1-.16-.21-.32A4.28,4.28,0,0,1,39.48,51.84Zm6,24.49c.13.2.31.08.46.1a.66.66,0,0,0,0-.1h-.49c.12-.25-.14-.3-.19-.43l.46-.22a1.94,1.94,0,0,0-1.57.16c-.08,0-.15.11-.29.21l1.31-.18-.16.28Zm3-.85a.67.67,0,0,0,.19-.35,1,1,0,0,1-.38.21c-.08,0-.18-.1-.31-.18l.61-.35c-.28-.18-.46.16-.76.14l.28-.38c-.26-.22-.26-.22-.7.12.13.17.16.44.44.47,0,0,0,.06,0,.12l-.3.33h.58c-.13.11-.21.17-.21.23a2.47,2.47,0,0,0-.49,0c-.19.11-.21.22-.06.35a2.16,2.16,0,0,0,.47-.36,1.45,1.45,0,0,0,.86-.36ZM48.81,27a.84.84,0,0,0,.18.15c.22.08,1,.82,1.28.82a2.28,2.28,0,0,0,.37,0,2.32,2.32,0,0,1,1.36.11c.27,0,.5.31.82.06-.1,0-3.79-1.44-3.48-.5-.15-.38-.15-.38-.24-.33a2.11,2.11,0,0,0-.15.15C49.09,27.49,49.18,27.53,48.81,27ZM36.91,56.88h-.09a9.43,9.43,0,0,1,.07-1.06,1.7,1.7,0,0,0-.06-1.06v.69c-.41,0-.1-.39-.29-.49l-.24.63-.11-.27a11.06,11.06,0,0,0-.36,2.27,3.59,3.59,0,0,1,.17-.34,1.42,1.42,0,0,1,.26-.22,9.89,9.89,0,0,0-.38,2.17c-.31.36-.2.86-.41,1.27-.14-.11-.29-.18-.1-.41.05-.05-.1-.27-.14-.39-.48.44-.26,1-.25,1.53l.14-.29.21.3c.23-.43.39-.88.93-1,0,0,.09-.11.09-.17s0-.17.16-.19a.89.89,0,0,0,.31-.11.55.55,0,0,0,.39-.58c0-.1-.22-.18,0-.33s0-.29.06-.38a.47.47,0,0,0,.06-.39c0-.09-.16-.16-.29-.27a1.17,1.17,0,0,0,.22-1.27l-.09.21-.16-.1ZM66,44.26a5.82,5.82,0,0,1,.2-1.25c-.13-.22,0-.46-.1-.7-.08-.5-.16-1-.26-1.51s-.17-.87-.34-1.3a4.79,4.79,0,0,1-.36-1.28A9.78,9.78,0,0,0,64.92,37c-.07-.29-.15-.57-.24-.86s-.13-.32-.31-.25c.1.42.36.75.25,1.19a.2.2,0,0,0,0,.13,1,1,0,0,1,.17.79c0,.06.07.13.1.2s.06.4.18.52.31,1.79.32,1.77c.2.2.15.5.22.74a4.84,4.84,0,0,1,.14,1.56.64.64,0,0,0,0,.24Q65.92,43.65,66,44.26ZM38.22,54.83a1.09,1.09,0,0,1,.16-.38,7.61,7.61,0,0,0,.59-3l-.16.3c-.16-.33.27-.58,0-.86a2.08,2.08,0,0,0-.17.89.45.45,0,0,1,0,.16A9.57,9.57,0,0,0,38.22,54.83Zm29.62-3.12c.07-.23.1-.35.14-.47s.13-.25.11-.36c-.07-.5,0-1,0-1.56,0-.08,0-.15-.06-.31a11.75,11.75,0,0,0-.28,1.29A6.91,6.91,0,0,0,67.84,51.71Zm-39.48-27a1.09,1.09,0,0,1-.51-.06c-.25.05-.25.22,0,.51a2.16,2.16,0,0,0-.44.1l.27.28c.09-.15.25,0,.39-.12S28.22,25,28.36,24.72ZM36.55,53a1.66,1.66,0,0,0,.39-1.34A1.24,1.24,0,0,0,36.55,53Zm.76,3.37h.11V55a1.73,1.73,0,0,0-.34,1.11s0,.06.07.09l.16-.35ZM56,70.86a.59.59,0,0,0-.72.32c-.09.15-.13.36-.4.39l.4.17c0-.1,0-.24,0-.25C55.66,71.39,55.73,71,56,70.86ZM67.33,54.8l.35-.43c-.21-.23.09-.39.07-.63C67.3,53.93,67.31,54.3,67.33,54.8Zm1.43-4.39c0,.35,0,.54,0,.74,0,0,.07.08.11.08a.17.17,0,0,0,.12-.08C69.05,50.91,68.92,50.72,68.76,50.41ZM36.68,54.46a2.05,2.05,0,0,0,.17-.85C36.44,53.87,36.67,54.19,36.68,54.46Zm28.7,7.18c.21-.23.42-.3.38-.56,0,0-.06-.11-.09-.11s-.13,0-.14.05A5.17,5.17,0,0,0,65.38,61.64ZM56,71.12c-.12.22-.25.43-.38.63C55.82,71.62,56.12,71.57,56,71.12ZM35.31,59.28h.06v-1h-.06Zm30.39-1.7c.06-.18.28-.33.14-.56C65.65,57.21,65.65,57.21,65.7,57.58Zm-9,13.81a1.29,1.29,0,0,1-.07.21,2.39,2.39,0,0,1-.12.22.4.4,0,0,0,.35-.27ZM27.48,24.78c-.25.13-.25.13-.38.5l.38-.38S27.48,24.82,27.48,24.78ZM41,60.1c.13-.11.18-.27.36-.28a.39.39,0,0,0,0-.11c-.12-.11-.23-.07-.35.12S41,60,41,60.1ZM53.18,73.66c0-.14.37-.32,0-.44ZM40,74.11c-.07.19-.13.32,0,.4s.1,0,.15-.05ZM66.14,58c-.24,0-.33.17-.21.41ZM56.61,70.15l.54-.27C56.9,69.8,56.75,69.83,56.61,70.15Zm7.25-21.09a.52.52,0,0,0,0-.56Zm-17,26.74c.27,0,.27,0,.36-.26ZM66.74,55.5c-.16,0-.36.11-.19.32ZM60.56,67.22h0l-.16.28s0,0,0,0C60.59,67.46,60.64,67.35,60.56,67.22Zm5.82-10.16c-.15,0-.37.11-.18.32ZM44.78,76.82v.08a.44.44,0,0,0,.16,0,.61.61,0,0,0,.18-.09s0-.07,0-.11l-.17.08Zm-.52-49.18.05.09.35-.05-.17-.17Zm21.6,32.42c.16-.05.36-.11.19-.32ZM34.8,57.62h-.07a1.33,1.33,0,0,1-.09.21c0,.06-.12.12,0,.14s.13,0,.13-.07A1.22,1.22,0,0,0,34.8,57.62ZM36.18,30c-.08-.07-.13-.12-.18-.13s-.08.05-.12.08a.44.44,0,0,0,.13.14S36.09,30.07,36.18,30Zm30.3,28.44h-.07a1.33,1.33,0,0,1-.09.21c0,.06-.13.11,0,.14S66.56,58.66,66.48,58.46Zm-27-2.08h.1l0-.43H39.5Zm2.4,3c-.15,0-.37.11-.18.32Zm-3.6-17.6h.1l0-.43H38.3ZM61,66.82H61a1.33,1.33,0,0,1,.09-.21c.05-.06.13-.11,0-.14s-.14,0-.14.07A1.2,1.2,0,0,0,61,66.82Zm1.42-1.12c.16,0,.36-.11.19-.32Zm-4,1.26s0,0,0,.05,0,.12,0,.15.1,0,.15,0a.49.49,0,0,0,0-.16S58.4,67,58.38,67ZM53.5,68.57l.09.08.15-.21s-.09,0-.1,0S53.55,68.51,53.5,68.57ZM31.39,69l-.07.09.2.15s.05-.09,0-.1Zm34.7-11.5H66v.36h.06Zm.06,2.16h.06v-.36h-.06ZM37.47,52.92h.06v-.36h-.06Zm3-1.1h.11l0-.32h-.06Zm-.52,1.24h-.11l.05.31h.06Zm1.44-13.68h-.11l0,.32h.06ZM39.7,54.14h-.11l0,.31h.06Zm8.84-26.3s0,0,0-.05,0-.12,0-.15-.1,0-.15,0a.49.49,0,0,0,0,.16S48.52,27.81,48.54,27.84ZM69,48.6h-.06v.24H69ZM62.74,62.52l-.1.06c0,.06,0,.11,0,.16l.08,0C62.76,62.64,62.74,62.59,62.74,62.52Zm4.34-2.79v-.06h-.24v.06Zm-26.26-10-.1,0s0,.07,0,.1,0,.07.08.1Zm-5.68,9.78c0-.07,0-.12,0-.18s0,0-.08,0,0,.1,0,.16ZM63.57,61h-.06v.24h.06Zm-21.21-.33v.06h.24v-.06Zm19.9,5.49c0-.07,0-.12,0-.18l-.08,0s0,.1,0,.16ZM60.82,35c-.12,0-.14.11-.06.22l.08,0C60.84,35.16,60.82,35.11,60.82,35Zm7.24,8.34L68,43.22s-.07.06-.08.1,0,.07,0,.1Zm-1.91-2.94h.06V40.2h-.06ZM37.77,46.32h-.06v.24h.06Zm1.85.18-.1,0s0,.07,0,.1.05.07.08.1ZM54.18,71.42l.16-.06s-.06-.07-.1-.08-.07,0-.1,0ZM39,45.06l-.1,0s0,.07,0,.1,0,.07.08.1ZM54.18,68l0,.1s.07,0,.1,0,.07,0,.1-.08Zm1.2,4.08,0,.1s.07,0,.1,0,.07,0,.1-.08ZM67.92,52.17v-.06h-.24v.06ZM39.39,57.12h.06v-.24h-.06ZM66,56.52l-.1.06c0,.06,0,.11,0,.16l.08,0C66,56.64,66,56.59,66,56.52ZM35.42,58l-.06-.16c-.09.06-.1.12,0,.2ZM67.83,52h.06v-.24h-.06Zm-28-.12h-.06v.24h.06Zm6.45,21.7,0,.1s.07,0,.1,0,.07-.05.1-.08ZM50,78.09V78H49.8v.06ZM37,56.52h.06v-.24H37ZM49.86,77.74l0,.1s.07,0,.1,0,.07,0,.1-.08Zm4-49.48-.06-.16s-.07.06-.08.1,0,.07,0,.1Zm-3,48.16s-.05-.1-.06-.1l-.16,0s0,.08,0,.08Zm1.44-3.67v.06h.24v-.06ZM47.88,27l-.18,0s0,.05,0,.08S47.84,27.14,47.88,27Zm3.84,46.92-.18,0s0,0,0,.08l.16,0S51.69,74,51.72,73.94Zm-8.26,2.22,0,0s0,0,0-.08,0,0,0,0Zm3.86.26.08,0,0,0-.08,0Zm-2.12-1-.08,0,0,0,.08,0ZM51,71l0,0-.08,0s0,0,0,0Zm-1-.1,0,0S50,71,50,71s0,0,0,0Zm4.6.2,0-.08s0,0,0,0,0,0,0,.08ZM43.78,76l0-.08s0,0,0,0,0,0,0,.08Zm6.12,1,0,0s0,0,0,.08l0,0Zm.36-.44,0-.08,0,0s0,.05,0,.08Zm.18-.18,0,0,.08,0s0,0,0,0ZM57,71.32l0,0s0,0,0,.08,0,0,0,0Zm-6.3.06.08,0s0,0,0,0l-.08,0Zm6.12-.72.08,0s0,0,0,0l-.08,0Zm-2.46.46,0-.08s0,0,0,0,0,0,0,.08ZM51.2,77.54l-.08,0s0,0,0,0l.08,0ZM47.78,74l0,.08s0,0,0,0,0,0,0-.08Zm5.54-1.34,0,0,.08,0s0,0,0,0Zm-2.82,1.5,0-.08s0,0,0,0,0,0,0,.08Zm-3.66-.3,0,0,.08,0s0,0,0,0Zm2.66-.74s0,0,0,0,0,0,0,.08,0,0,0,0S49.51,73.11,49.5,73.08Zm6,0,0,0s0,0,0,.08,0,0,0,0Zm-6.3.18.08,0s0,0,0,0l-.08,0Zm4.22.38s0,0,0,0,0,0,0,.08l0,0S53.47,73.71,53.46,73.68Zm1.34-.38,0,0-.08,0s0,0,0,0Zm-1.4-1.36,0,0-.08,0s0,0,0,0Zm-12.8,3,0,0,.08,0s0,0,0,0Zm16.74-3.1,0,0s0,0,0,.08l0,0Zm-7.9,2.66,0,0-.08,0s0,0,0,0Zm-.84,0,0,0-.08,0s0,0,0,0Zm8.84-1.88,0,0-.08,0s0,0,0,0ZM47,74.28l0,0s0,.05,0,.08,0,0,0,0Zm10.08.36s0,0,0,0l0,.08s0,0,0,0S57.07,74.67,57.06,74.64Zm-8.72-.08,0,0s0,0,0,.08,0,0,0,0Zm-2.24,0,0,0s0,0,0-.08,0,0,0,0Zm8.34-2.34-.08,0s0,0,0,0l.08,0ZM67.64,53.5l0,0-.08,0,0,0Zm-33.18.78,0,.08,0,0s0,0,0-.08ZM68.86,50l0,0s0,0,0,.08l0,0Zm-4.2.48,0,0,0,.08s0,0,0,0ZM48.28,56.5l.08,0q0-.08-.12,0Zm1.94-.1,0,0s0,.05,0,.08,0,0,0,0S50.23,56.43,50.22,56.4Zm-5.44,1,0,0s0,0,0-.08l0,0Zm0,.4s0,0,0,0,0,0,0,.08l0,0S44.83,57.87,44.82,57.84Zm-7.3-3,0,0-.08,0,0,0Zm2.06-.06,0,0s0,.05,0,.08,0,0,0,0Zm-1.5.46,0,0,.08,0s0,0,0,0Zm-3.14,1,0,0,0-.08s0,0,0,0Zm29.36-21,0-.08s0,0,0,0l0,.08Zm-29.56.52,0,0s0,.05,0,.08l0,0S34.75,35.79,34.74,35.76Zm-.8.68,0-.08,0,0s0,.05,0,.08ZM65.38,38.2l0,0,0,.08,0,0Zm1.52.92,0,0,0,.08,0,0S66.91,39.15,66.9,39.12ZM43.12,21.94l.08,0s0,0,0,0l-.08,0Zm1.3.06,0,.08s0,0,0,0,0-.05,0-.08ZM56.2,24.5l0,0,.08,0,0,0Zm-6.4.16s0,0,0,0l-.08,0,0,0Zm-.1,1,0,0s0-.05,0-.08,0,0,0,0Zm-2.2,1.92,0-.08,0,0s0,.05,0,.08Zm2.64.6,0-.08s0,0,0,0,0,.05,0,.08Zm3.5,0,0,0-.08,0s0,0,0,0Zm-.5.14,0-.08,0,0s0,.05,0,.08ZM40.9,30.88l0,0s0,.05,0,.08l0,0ZM34.3,46.64l0-.08,0,0s0,0,0,.08ZM68.06,44l0,.08,0,0,0-.08ZM62.58,68.28l0,0s0,.05,0,.08,0,0,0,0S62.59,68.31,62.58,68.28Zm-9.32.52,0,0s0,.09,0,.12Zm1.82.14,0,0-.08,0s0,0,0,0Zm-2.54.34,0,0s0,.05,0,.08,0,0,0,0Zm2.86-2,0,0-.08,0s0,0,0,0Zm.38.18,0,0s0,0,0,.08,0,0,0,0Zm-.72.48,0,0L55,68s0,0,0,0Zm-.5.22-.08,0s0,0,0,0l.08,0Zm-.58.18,0-.08,0,0s0,.05,0,.08Zm-.84,1.56,0-.08,0,0s0,.05,0,.08Zm.24,0,0,0,0,.08s0,0,0,0Zm-1.16.24,0,.08s0,0,0,0,0,0,0-.08Zm-.16.12,0,0,0,.08s0,0,0,0Zm2.32,0,0,0s0,0,0-.08l0,0Zm-.88-.72,0-.08,0,0s0,0,0,.08Zm1-.08,0,0s0,0,0,.08l0,0S54.55,69.51,54.54,69.48Zm11.32-9,0-.08,0,0s0,.05,0,.08Zm-22.58.26,0,0s-.09,0-.12,0Zm23.26.14s0,0,0,0l0,.08,0,0S66.55,60.87,66.54,60.84Zm-30.82.38-.08,0,0,0,.08,0ZM64.44,59l0,0-.08,0s0,0,0,0ZM64,66.7l0,0-.08,0,0,0ZM55.8,67s0,0,0,0l-.08,0s0,0,0,0Zm6.68-3.64-.08,0,0,0,.08,0Zm-1.08.68,0,0-.08,0,0,0ZM137.52,34.8h-.6l.08.48a4.56,4.56,0,0,1-.64,0c-.19,0-.27,0-.33.23s-.23,0-.18.14.13.22.22.23.29,0,.35.23a3.92,3.92,0,0,1-1.7-.19,1.39,1.39,0,0,0-.41,0c-1.61,0-3.49.26-4.76-1a7.72,7.72,0,0,1-1.27-1.69,6.91,6.91,0,0,1-1-2.06,18.93,18.93,0,0,1-.93-2.91c-.07-.18.06-.44.14-.64s.17-.13.26-.2-.1-.32,0-.37-.15-.27,0-.42l.14.14A1.31,1.31,0,0,1,127,27c.17-.13.36-.19.49-.42s.45-.31.57-.6a1.11,1.11,0,0,0,.48-.25,1,1,0,0,0,.7-.51.16.16,0,0,1,0-.1c.37.09.27-.28.41-.42s.08-.1.17,0,.19.06.23-.1a.88.88,0,0,1,.5-.09,1.68,1.68,0,0,1,1.55,1,10.05,10.05,0,0,0,.75,1.13,17.59,17.59,0,0,1,1.1,1.82,23.61,23.61,0,0,0,1.61,2.69c.37.53.71,1.07,1.11,1.57a4.36,4.36,0,0,0,.81.65,1.64,1.64,0,0,1,.86.84h-1.54A2.06,2.06,0,0,0,137.52,34.8Zm-6.36-2.52a.17.17,0,0,0,.15.07c.28.43.28.43.67.61,0-.18.08-.32-.21-.34s-.31-.17-.49-.22l-.12-.12a.5.5,0,0,0-.17-.12h0a.25.25,0,0,0,0-.09l-.07,0a.2.2,0,0,0,.11.07Zm1.31,2.23-.06-.07,0,.05.07.06s0,0-.07-.11l-.12-.12c0-.22.27-.14.3-.1.16.22.28,0,.42,0s.08.08.41.19l-.18-.07h-.11s0,.1.08.11.1,0-.08-.11L133,34.2a1.83,1.83,0,0,0-1.13-.36l0,0q-.15.36.45.45A1.65,1.65,0,0,0,132.47,34.51Zm.74-.41.11-.08s-.06-.06-.08-.06l-.15,0s.07.06.52.14l-.18-.07h-.11s.05.1.08.11S133.5,34.18,133.21,34.1Zm2.62-.55-.06-.07-.05.05.07.06s0,0-.18-.09l.11-.08c-.06-.08-.14-.08-.23,0A.86.86,0,0,0,135.83,33.55Zm-3.48-.36-.06-.07,0,.05.07.06s0,0-.16-.06c.06-.07.09-.09.09-.11a.8.8,0,0,0,0-.15l-.08,0C132.13,33,132.14,33.06,132.35,33.19Zm2.46.84-.18-.07h-.11s0,.1.08.11.1,0-.45-.16c.06,0,.07.05.09.05h.28v-.05c-.1,0-.21,0-.31-.06S134.18,33.88,134.81,34Zm-1.5-.36-.06-.07-.05,0,.07.06s0,0-.1-.06-.09-.34-.37-.24A3,3,0,0,0,133.31,33.67Zm.26-.89.11-.08s-.06-.06-.08-.06l-.15,0a.33.33,0,0,0,.23.07A.29.29,0,0,0,134,33v.24c-.18-.16-.39-.12-.65-.12h.05a.25.25,0,0,0,0-.09l-.07,0a.2.2,0,0,0,.11.07s.07.12.09.11c.18,0,.34.05.38.21.1.37.35.27.69.27-.48-.17-.48-.17-.56-.47a.68.68,0,0,0,.48.12.37.37,0,0,0,.34.29l.22.07.3.1c-.07-.39-.35-.14-.5-.22a.29.29,0,0,0-.36-.24c-.11-.19-.22-.38-.48-.36C134,32.81,133.87,32.74,133.57,32.78Zm1.23,1.44.42-.06-.16-.21Zm.26-.84.16-.06s-.06-.07-.1-.08-.07,0-.1,0Zm-2.26-.24-.08,0,0,0,.08,0Zm.66.62,0,.08s0,0,0,0,0,0,0-.08Zm.5.3.08,0,0,0-.08,0Zm-.06.22,0-.08s0,0,0,0l0,.08Zm-1,.6,0,0s0-.05,0-.08,0,0,0,0Zm.64.28s0,0,0,0,0,0,0,.08l0,0S133.51,35.19,133.5,35.16Zm.32.16,0,.08,0,0s0,0,0-.08ZM47.45,23.16A.48.48,0,0,1,47,23c.2-.17,0-.43.15-.65a.83.83,0,0,1,.17.15,1.19,1.19,0,0,1,0,.22c.16-.23,1.49.52.32.84-.14,0-.3,0-.2-.35.3-.39.27-.44.25-.48s-.06,0-.06.06,0,.11.07.17S47.74,22.85,47.45,23.16Zm.33.06-.06-.16s-.07.06-.08.1,0,.07,0,.1ZM33.54,47.13c.12.24,0,.52.19.8v-1l.23.49c0-.33,0-.53,0-.72a1.74,1.74,0,0,0-.07-.69c0,.34-.2.31-.43.33A2.14,2.14,0,0,0,33.54,47.13Zm44.85,27c-.26-1-.72-1.34-1.37-1.11C77.56,73.2,77.76,73.83,78.39,74.09Zm88.85-6.3c-.05,0-.06.15-.11.29.18-.13.29-.27.39-.27.27,0,.42-.14.45-.34l-.29-.13C167.57,67.45,167.4,67.61,167.24,67.79ZM130.8,73.08a.83.83,0,0,0,.21.72c.21-.14.21-.14.27-.36ZM115.82,58a13,13,0,0,0-.14,1.4l.1,0a7.3,7.3,0,0,0,.14-1.4ZM80.51,75.56a.6.6,0,0,0-.72-.31C80,75.52,80.17,75.69,80.51,75.56ZM68,61.05a1.28,1.28,0,0,0-.32,1.06C67.91,61.82,67.91,61.82,68,61.05Zm-5.73,3.27a.32.32,0,0,1-.12.31.89.89,0,0,0-.12.26,1.75,1.75,0,0,0,.6-.81ZM34.06,49.66v-1A1.76,1.76,0,0,0,34.06,49.66Zm98.8,25.25a.66.66,0,0,0,.55.54A2,2,0,0,0,132.86,74.91ZM48.28,78.12a3.17,3.17,0,0,1,.44,0C48,78,48,78,47.87,78.2Zm18.8-15.71c-.15.12-.15.24,0,.35l.18-.22C67.18,62.48,67.13,62.41,67.08,62.41Zm49.23-4V59h.06v-.6ZM31.59,65.88v.6h.06v-.6Zm-2.35-43-.23.23C29.21,23.13,29.21,23.13,29.24,22.88ZM31,22.29s0,.1.05.15l.35-.18C31.18,22.19,31.05,22.13,31,22.29ZM81.32,75.94s0,0,.05,0c0-.29-.24-.12-.39-.14Zm83.16-5.43c.28.1.33-.06.37-.24ZM36.35,76.44s-.1,0-.11.06,0,.2.14.18.07-.06.16-.12A1.77,1.77,0,0,0,36.35,76.44ZM62.64,64.08a.29.29,0,0,0,.24-.36A.29.29,0,0,0,62.64,64.08ZM34,59.19l0,.43h.07v-.44ZM78.48,74.4a.29.29,0,0,0,.36.24A.29.29,0,0,0,78.48,74.4ZM34.33,55.65l0-.31h-.06v.32ZM66.6,62.82l.2.16s0-.08,0-.1a.85.85,0,0,0-.11-.14ZM85.08,70.2q-.27.21.12.24Zm31.41-12v-.36h-.06v.36ZM64.93,59.61l-.05-.31h-.06v.32Zm50.75.07V59.4h-.05c0,.1,0,.21-.06.31l.06.06C115.66,59.71,115.68,59.7,115.68,59.68ZM78.27,74.17c-.09.23,0,.24.35.22ZM72.6,51.36q-.24.18,0,.36Zm6.84,22.92c0,.18.15.1.24.12C79.67,74.22,79.53,74.3,79.44,74.28Zm-2.76-1.8c0,.09-.06.23.12.24C76.78,72.63,76.86,72.49,76.68,72.48ZM64.11,62.4v.24h.06V62.4Zm-1,.13a.4.4,0,0,0,0,.11s.1,0,.11-.08,0-.1,0-.21A1.2,1.2,0,0,0,63.12,62.53Zm16.56-1.09c0,.09-.06.23.12.24C79.78,61.59,79.86,61.45,79.68,61.44ZM34,48.14c-.06.08,0,.14,0,.2l.06-.16Zm97.42,26s.07,0,.1,0,.07,0,.1-.08l-.16-.06ZM79.32,61v.24h.12C79.42,61.11,79.5,61,79.32,61ZM163.92,71c.09,0,.23.06.24-.12C164.07,70.94,163.93,70.86,163.92,71ZM64.83,65.28v.24h.06v-.24ZM81,75.66s-.06-.06-.08-.06l-.15.05.12.09Zm36.12-6.9c.18,0,.1-.15.12-.24C117.06,68.53,117.14,68.67,117.12,68.76ZM63.48,63.6c.18,0,.1-.15.12-.24C63.42,63.37,63.5,63.51,63.48,63.6Zm1.76,1.1s-.07.06-.08.1,0,.07,0,.1l.1,0ZM32,64.52s-.06-.07-.1-.08-.07,0-.1,0l0,.1Zm33.5-.32c.18,0,.1-.15.12-.24C65.46,64,65.54,64.11,65.52,64.2ZM28.89,24.72v-.24h-.06v.24Zm0-.84s0,.05,0,.08L29,24s0-.05.06-.1ZM91.38,57.72l-.15,0s0,.08,0,.08l.24,0C91.42,57.75,91.4,57.72,91.38,57.72ZM92.82,73.8a.8.8,0,0,0-.15,0s0,.08,0,.08l.24,0C92.86,73.83,92.84,73.8,92.82,73.8Zm-58.44-22s-.06.06-.06.08a.88.88,0,0,0,0,.15l.09-.12Zm-3.46,18.5c-.09.06-.1.12,0,.2l.1,0Zm-.17-47.9v.24h.06v-.24ZM47.3,78.2c.08.06.14,0,.2,0l-.16-.06Zm1-54.68s0,.05,0,.08l.16,0s0-.05.06-.1Zm20.9,29.3s-.07.06-.08.1,0,.07,0,.1l.1,0ZM130.62,73.2s-.06,0-.06,0l.07.18.06-.11ZM85.08,70.08c0-.18-.15-.1-.24-.12C84.85,70.14,85,70.06,85.08,70.08ZM97,51.13a.4.4,0,0,0,0,.11s.1-.05.11-.08,0-.1,0-.21A1.2,1.2,0,0,0,97,51.13ZM84.6,69.54c0,.06,0,.11,0,.16s.08,0,.08,0,0-.11,0-.18S84.6,69.53,84.6,69.54ZM67.44,58.74s0,0-.08,0,0,.1,0,.16l.1.06C67.42,58.85,67.44,58.8,67.44,58.74Zm96.72,12.18.12-.12ZM43.8,21.72a.25.25,0,0,0-.09,0s0,0,0,.07l.07-.06ZM36.24,76.44a.25.25,0,0,0,0-.09l-.07,0,.06.07ZM98,70.63l0,.05.06-.07s0,0,0,0ZM56.45,75.72l-.05,0,.07.06,0,0ZM85.2,70.44l.12.12Zm79.08.31.05,0,.06-.07s0,0,0,0Zm-131,4.91s0,0,0,0l.08,0,0,0ZM76.8,72.72l.12.12Zm15.68,1.22-.08,0,0,0,.08,0Zm-14.72,0,.12.12ZM77,73l-.12-.12Zm29.64.84a.25.25,0,0,0-.09,0s0,0,0,.07l.07-.06ZM77.16,72.6a.25.25,0,0,0-.09,0s0,0,0,.07l.07-.06ZM77.93,74l-.05,0,.07.06,0,0Zm15.19-.42.08,0,0,0-.08,0Zm38.28-.18,0,.1.08-.1Zm-38,0,0,.1.08-.1Zm-15.6.48-.12-.12Zm15.12-.17.05,0,.06-.07s0,0,0,0Zm-15.24,0a.25.25,0,0,0,0-.09l-.07,0,.06.07Zm2.16,1.44a.25.25,0,0,0,0-.09s0,0-.07,0l.06.07ZM79.38,75s0,0,0,.08,0,0,0,0l0-.08Zm99.54.12h-.12l.12.12Zm-100-.48,0,0,.07.06s0,0,0,0ZM96.6,52.2l0,.1.08-.1Zm-62.4.18s0,0,0,0l-.08,0,0,0ZM33.78,50l0,0s0,.05,0,.08l0,0Zm38.94,1.32,0-.1-.08.1Zm18.72,6.36.12-.12ZM67.86,55.8l0,.08,0,0,0-.08Zm69.71-21,0,.05.07.06,0,0ZM89.66,40.48l0,.08,0,0s0-.05,0-.08Zm-42.8-17.8,0,0s0-.05,0-.08l0,0Zm1.62.42-.08,0,0,0,.08,0Zm-19.74.18s0,0,0,0,0,0,0-.08l0,0Zm.54.6c0-.09,0-.12-.11-.07l.06.07Zm21.54,0s0,0,0,0,0-.05,0-.08l0,0Zm-23.22.06s0,0,0,0l.08,0,0,0Zm29.09.66,0,0,.07.06,0,0Zm-5.27,1.08s0-.05,0-.08,0,0,0,0l0,.08Zm6.3.18,0,0-.08,0,0,0Zm3.6,3.72-.08,0s0,0,0,0l.08,0Zm1.2.49,0,.05.06-.07s0,0,0,0Zm-1,.59,0,0,.08,0,0,0ZM33.66,48.12l0-.08,0,0,0,.08Zm.06.54-.08,0,0,0,.08,0Zm135,18.42-.12.12Zm-71.64.24,0-.1-.08.1Zm70.68,0,.05,0,.06-.07s0,0,0,0Zm.72,0,.12-.12Zm0,0-.12.12ZM31.32,67.5l.08,0s0,0,0,0l-.08,0Zm136.92.06.12-.12Zm0,0-.12.12Zm-.24.24.12-.12Zm-56.4.06s0,0,0,0l.08,0,0,0ZM168,67.8a.25.25,0,0,0-.09,0s0,0,0,.07l.07-.06Zm-56.46.36s0,0,0-.08,0,0,0,0l0,.08ZM84.84,70a.25.25,0,0,0,0-.09s0,0-.07,0l.06.07Zm80.88,0h.12v-.12Zm.48,0v-.12l-.12.12ZM84.41,70l0,.05.07.06,0,0Zm-.77-.48-.12-.12Zm.72.06-.08,0s0,0,0,0l.08,0ZM79.14,60.6l0-.08s0,0,0,0l0,.08Zm36.6.48,0,0s0,.05,0,.08l0,0Zm-36.18.24-.12-.12Zm0,0,.12.12Zm-16.32.12-.12.12Zm16.61.24,0,0,.07.06,0,0ZM63.6,63.31l0,0,.06-.07,0,0Zm38-4.39s0,0,0,.08l0,0,0-.08ZM68.4,59.7l.08,0,0,0-.08,0Zm34.08,5.94a.25.25,0,0,0-.09,0s0,0,0,.07l.07-.06Zm19.2,1.2.1,0-.1-.08Zm46.8-.12a.25.25,0,0,0-.09,0s0,0,0,.07l.07-.06Zm-105-3.12a.25.25,0,0,0-.09,0s0,0,0,.07l.07-.06Zm2,.6a.25.25,0,0,0-.09,0s0,0,0,.07l.07-.06ZM76.86,48.39s0,.08,0,.08l-.07-.06,0,0s0,0,0,0a.85.85,0,0,0-.54.93l.19-.11c.21.25-.09.47-.07.71l.19-.11.14.29c0-.3,0-.58.08-.74s0-.27-.15-.34-.15-.3.06-.4a.28.28,0,0,1-.06.4,7.19,7.19,0,0,0,.58-.66L77.16,48A1.24,1.24,0,0,0,76.86,48.39Zm1.44,2c-.08.24,0,.29.19.37a1,1,0,0,1,.21-.87c0-.06,0-.2,0-.38l-.14.3h-.06v-.34h-.12A3.17,3.17,0,0,1,78.3,50.37Zm-.78.68a2.8,2.8,0,0,1,0,.4s0,.08-.06.12l.21,0a3,3,0,0,0-.12-1.08Zm-.72-.69v.28h0c0-.1,0-.21.06-.31l-.06-.06C76.82,50.33,76.8,50.34,76.8,50.36Zm1.23.76v.36h.06v-.36Zm-1.71-1.8c-.18,0-.1.15-.12.24C76.38,49.55,76.3,49.41,76.32,49.32Zm-.24.48c.18,0,.1-.15.12-.24C76,49.57,76.1,49.71,76.08,49.8Zm1.44-.12,0-.1a.39.39,0,0,0-.08.1.48.48,0,0,0,0,.12h.12A.48.48,0,0,0,77.52,49.68Zm-.48.24c.18,0,.1-.15.12-.24C77,49.69,77.06,49.83,77,49.92Zm.3-.12s-.06.06-.06.08a.88.88,0,0,0,0,.15l.09-.12Zm-.9.12c-.09,0-.23-.06-.24.12C76.29,50,76.43,50.1,76.44,49.92Zm.54,0s-.06.06-.06.08a.88.88,0,0,0,0,.15l.09-.12Zm1.11.36V50H78v.24ZM76,50.16s-.06.06-.06.08a.88.88,0,0,0,.05.15l.09-.12Zm2.34-.78a.8.8,0,0,0,0-.15l-.08,0c0,.06,0,.13,0,.24C78.33,49.42,78.36,49.4,78.36,49.38ZM77.07,51.6v.24h.06V51.6Zm1.17-.66a.8.8,0,0,0,0-.15s-.08,0-.08,0,0,.13,0,.24C78.21,51,78.24,51,78.24,50.94Zm.06.06c-.09.06-.09.13,0,.23l.06-.11Zm-1-.48s-.06.06-.06.08a.88.88,0,0,0,0,.15l.09-.12Zm-.6.12s-.06.06-.06.08a.88.88,0,0,0,0,.15l.09-.12Zm.5-.46c-.09.06-.1.12,0,.2l.1,0Zm-1.18,2-.1-.08v.12Zm8.26,1.62-.08,0s0,0,0,0l.08,0S84.33,53.78,84.32,53.78Zm-8.24-4a.25.25,0,0,0-.09,0s0,0,0,.07l.07-.06Zm0,.36L76.2,50Zm.24.3-.08,0,0,0,.08,0Zm.84.48.08,0s0,0,0,0l-.08,0Zm0,.2-.08,0s0,0,0,0l.08,0ZM78.42,55l0,0,0,.08,0,0Zm29.1,9.6v.36l.12.12C107.79,64.81,107.79,64.81,107.52,64.56Zm-.75-3.24v-.48h-.06v.48Zm1.35,4.32.18.12c0-.05.07-.1,0-.14s-.08-.08-.14-.15C108.16,65.55,108.11,65.62,108.12,65.64Zm-1.32-4.13,0,.05.06-.07s0,0,0,0Zm-.33,2.93-.19-.72C106.28,64,106,64.27,106.47,64.44Zm.45.12a1.93,1.93,0,0,0,0,.34s.07.09.11.14v-.48Zm-.71-.84,0-.36h-.08v.35ZM73.68,61.8a.83.83,0,0,1-.13-.42,1.14,1.14,0,0,0-.11-.43c0-.12-.12-.23-.23-.45a1.41,1.41,0,0,0,.29,1.66C73.66,62.09,73.43,61.82,73.68,61.8Zm6.74,10.64.28.16,0,0-.23-.2s-.06,0-.09,0Zm1.3,1.12c0-.18-.15-.1-.24-.12C81.49,73.62,81.63,73.54,81.72,73.56Zm-.36-.24.12.12Zm-.12-.12.12.12Zm38.22-16.08,0,0s0,.05,0,.08l0,0Zm-13,10.2a.25.25,0,0,0,0-.09s0,0-.07,0l.06.07Zm25.44,1.17.12.15V68.4Zm.16.25.08-.1H132ZM74.57,51.84l0,0,.07.06,0,0Zm19.25-7.12-.1-.08v.12ZM94,45l0-.1-.08.1Zm-.12,0h-.12v.12h.12Zm.12.12h.12L94,45Zm.12,0v.12h.12ZM83.76,72.06S83.7,72,83.68,72l-.15,0,.12.09Zm-1-.66h.12v-.12H82.8ZM76.25,53.76l0,.05.07.06s0,0,0,0Zm-.17.67,0,0,.06-.07,0,0Zm60,17.33a.25.25,0,0,0,0-.09s0,0-.07,0l.06.07Zm-54.36.72-.12-.12Zm0,0,.12.12ZM119.64,64l-.12.12ZM92.48,73.1l-.08.1h.12ZM79.08,72,79,71.88Zm16,0v-.12h-.12ZM80.28,74.16v.12h.12Zm0,0L80.16,74v.12Zm100-.48c0-.18-.15-.1-.24-.12C180,73.74,180.15,73.66,180.24,73.68ZM94,45.12h-.12v.12H94Zm.12.12H94v.12h.12ZM49.56,71.64c-.89-.43-.2-.09-1.42.46l.94-.1c.07-.27.28-.25.48-.24Zm-7,3.24.2-.43-.77.4Zm-.92-16.54,0,.26.37-.26Zm6.16-1.07c.05-.06.15-.12,0-.15s-.27.21-.15.48Zm-7.15,1c-.27,0-.48-.14-.43.25Zm-.26,15.31a2,2,0,0,1-.16-.2V74Zm-1.51-6.08.05.31H39v-.32Zm9.44-10.33.17-.14s0-.07,0-.1l-.2.15Zm7.37-25.58.24.24Q56,31.5,55.68,31.56ZM40.77,74.15c.09-.23-.05-.24-.35-.22ZM48,28.59h-.36v.06H48ZM43.56,61.35h-.24v.06h.24ZM44,74.43H43.8v.06H44Zm1-14.64h-.24v.06H45Zm-1.2.81c0-.18-.15-.1-.24-.12v.12ZM59.92,35.42s0,.07,0,.1,0,.07.08.1l.06-.16Zm3.23,7.18v.24h.06V42.6Zm-3.63-7.71.12.15V34.8Zm-1.4-.67s0,.07,0,.1.05.07.08.1l.06-.16ZM47.28,57.78c0,.06,0,.11,0,.16l.08,0c0-.06,0-.11,0-.18ZM44,57.36s0,0,0,.08l.16,0s0,0,.06-.1Zm6.41-1.68h-.11s0,.1.08.11.1,0,.21,0Zm-4.07,3.18s0,.06.06.06l.17-.07-.11-.06Zm-5.92-.28s-.07.06-.08.1,0,.07,0,.1l.1,0Zm2.08,0s0,.06.06.06l.17-.07-.11-.06Zm2.64,0h.24v-.06h-.24Zm1.14.27-.15,0s0,.08,0,.08l.24,0C46.3,59,46.28,58.92,46.26,58.92Zm.92,14s.07,0,.1,0,.07,0,.1-.08l-.16-.06Zm2.38-1.33,0,0,.06-.07,0,0Zm.24-.79a.25.25,0,0,0,0-.09l-.07,0,.06.07Zm.4.58.08-.1h-.12ZM47.7,72.6l0,.08,0,0,0-.08Zm-7.14,1.32a.25.25,0,0,0,0-.09s0,0-.07,0l.06.07ZM43.26,75s0,0,0,.08,0,0,0,0l0-.08Zm5.82-3,.12.12Zm-10.2.24a.25.25,0,0,0,0-.09s0,0-.07,0l.06.07ZM42,74.58s0,0,0,0l.08,0,0,0Zm7.08-18.11.05.05.06-.07s0,0,0,0Zm-1,.31-.08,0,0,0,.08,0S48.09,56.78,48.08,56.78ZM44.34,57l0,0,0-.08,0,0Zm3,.38-.08,0,0,0,.08,0Zm-3.74.1s0,.05,0,.08l0,0,0-.08Zm4,.12a.25.25,0,0,0-.09,0s0,0,0,.07l.07-.06Zm-.6.18-.08,0,0,0,.08,0Zm-2.88.06.12.12v-.12Zm2.64-2.21.05,0,.06-.07,0,0Zm3.72.72,0,0,.06-.07,0,0ZM59.69,35l0,.05.07.06,0,0ZM48.18,28.8l0,0s0-.05,0-.08l0,0Zm7.79,3,0,.05.07.06,0,0ZM41,44.28l0-.08s0,0,0,0l0,.08ZM43.85,60.6l-.05,0,.07.06s0,0,0,0Zm0,.48,0,0s0,.05,0,.08l0,0Zm-1.62.48-.12.12Zm.18.12,0,0s0,.05,0,.08l0,0Zm.9.54-.08,0s0,0,0,0l.08,0Zm-.76.68-.08,0s0,0,0,0l.08,0Zm-1.22-4.82,0,0,0,.08,0,0Zm.66.19,0,0,.06-.07,0,0Zm1,0,0,.08,0,0,0-.08S43,58.23,43,58.24Zm3,.08,0,0,0,.08,0,0Zm-5.94.24.12-.12Zm6.84-.06,0,0,.08,0,0,0Zm-6.84.06-.12.12Zm.36.43.05,0,.06-.07,0,0Zm2.76,0q-.08-.07-.12,0l.08,0Zm.78-.06,0,0s0,0,0,.08l0,0Zm0,.24s0,.05,0,.08l0,0,0-.08Zm-7.26-1.65-.12.68c.18-.34.64-.59.41-1.08l-.15.36v-.7C36.65,57.06,36.75,57.3,36.72,57.51Zm-.09-1.95v.84h.06v-.84Zm-.09,3a1,1,0,0,0-.17.25c0,.06,0,.14,0,.27l.21-.45Zm-.75,1.2V60h.06v-.24Zm.35-1.52s0,0,0,.08l0,0s0-.05,0-.08S36.14,58.23,36.14,58.24Zm.88.2,0,0,0,.08,0,0Zm-.12.48,0,0s0-.05,0-.08l0,0Zm1.35-1.08v-.47h-.06v.47Zm.09,0s-.06,0-.06.06,0,.11.07.17l.06-.11Zm.18.66s0,0,0,0l.08,0,0,0Zm.18-6.3s-.06.06-.06.08a.88.88,0,0,0,0,.15l.09-.12Zm.06-.05.05.05.06-.07s0,0,0,0Zm9.66,23.33a.8.8,0,0,0-.15,0s0,.08,0,.08l.24,0C48.46,75.51,48.44,75.48,48.42,75.48Zm-2,.91.05,0,.06-.07s0,0,0,0Zm4.32,1.37h.12v-.12Z",
            transform: "translate(-26.04 -20.26)"
          }
        })
      ]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-76de9066", module.exports)
  }
}

/***/ }),
/* 581 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(582)
/* template */
var __vue_template__ = __webpack_require__(585)
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
Component.options.__file = "src/installer/components/items/Database.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-3da8b513", Component.options)
  } else {
    hotAPI.reload("data-v-3da8b513", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 582 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Item__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Item___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__Item__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  components: {
    Item: __WEBPACK_IMPORTED_MODULE_0__Item___default.a
  },
  props: {
    item: {
      required: true
    }
  }
});

/***/ }),
/* 583 */
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

/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    item: {
      type: Boolean,
      default: null
    },
    title: {
      required: true,
      type: String
    }
  }
});

/***/ }),
/* 584 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("section", [
    _c(
      "div",
      { staticClass: "dvs-relative dvs-pl-16" },
      [
        _vm.item !== null
          ? _c("item-check", {
              staticClass: "dvs-absolute dvs-pin-t dvs-pin-l dvs-ml-6 dvs-mt-8",
              attrs: { item: _vm.item }
            })
          : _vm._e(),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "dvs-pl-8" },
          [
            _c("h3", { staticClass: "dvs-mb-4" }, [_vm._v(_vm._s(_vm.title))]),
            _vm._v(" "),
            _vm._t("instructions")
          ],
          2
        )
      ],
      1
    ),
    _vm._v(" "),
    _c("div", [_vm._t("example")], 2)
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-0a1669fc", module.exports)
  }
}

/***/ }),
/* 585 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "devise-installer-item",
    {
      attrs: {
        item: _vm.item,
        id: "nav-database-connection",
        title: "Database Connection (required)"
      }
    },
    [
      _c("template", { slot: "instructions" }, [
        _c("p", [
          _vm._v(
            "\n      Your application will need to connect to a database. You can do this by editing your\n      "
          ),
          _c("span", { staticClass: "dvs-font-monospace" }, [_vm._v(".env")]),
          _vm._v(
            " file in the root of your project and ensuring the following values are set:\n    "
          )
        ])
      ]),
      _vm._v(" "),
      _c("template", { slot: "example" }, [
        _vm._v("In your .env file\n    "),
        _c(
          "pre",
          {
            staticClass: "lang-ini line-numbers",
            attrs: { "data-start": "1" }
          },
          [
            _vm._v("        "),
            _c("code", [
              _vm._v("\n          DB_CONNECTION=mysql\n          "),
              _c("br"),
              _vm._v("DB_HOST=127.0.0.1\n          "),
              _c("br"),
              _vm._v("DB_PORT=3306\n          "),
              _c("br"),
              _vm._v("DB_DATABASE=database_name\n          "),
              _c("br"),
              _vm._v("DB_USERNAME=root\n          "),
              _c("br"),
              _vm._v("DB_PASSWORD=\n          "),
              _c("br"),
              _vm._v("\n        ")
            ]),
            _vm._v("\n      ")
          ]
        )
      ])
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
    require("vue-hot-reload-api")      .rerender("data-v-3da8b513", module.exports)
  }
}

/***/ }),
/* 586 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(587)
/* template */
var __vue_template__ = __webpack_require__(588)
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
Component.options.__file = "src/installer/components/items/Migrations.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-53707606", Component.options)
  } else {
    hotAPI.reload("data-v-53707606", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 587 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Item__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Item___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__Item__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  components: {
    Item: __WEBPACK_IMPORTED_MODULE_0__Item___default.a
  },
  props: {
    item: {
      required: true
    }
  }
});

/***/ }),
/* 588 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "devise-installer-item",
    {
      attrs: {
        item: _vm.item,
        id: "nav-database-migration",
        title: "Database Migrations (required)"
      }
    },
    [
      _c("template", { slot: "instructions" }, [
        _c("p", [
          _vm._v(
            "Now to populate the database you'll run the Laravel artisan migration command. This command will build out the tables needed for Devise to run properly."
          )
        ]),
        _vm._v(" "),
        _c("p", [
          _vm._v("\n      More information on migrations can be found\n      "),
          _c(
            "a",
            { attrs: { href: "https://laravel.com/docs/5.7/migrations" } },
            [_vm._v("here")]
          )
        ])
      ]),
      _vm._v(" "),
      _c("template", { slot: "example" }, [
        _c("p", [
          _vm._v(
            "From the root of your project on the command line run the following command"
          )
        ]),
        _vm._v(" "),
        _c("pre", { staticClass: "lang-bash", attrs: { "data-start": "1" } }, [
          _vm._v("        "),
          _c("code", [_vm._v("\n          php artisan migrate\n        ")]),
          _vm._v("\n      ")
        ])
      ])
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
    require("vue-hot-reload-api")      .rerender("data-v-53707606", module.exports)
  }
}

/***/ }),
/* 589 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(590)
/* template */
var __vue_template__ = __webpack_require__(591)
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
Component.options.__file = "src/installer/components/items/Auth.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1778e2c0", Component.options)
  } else {
    hotAPI.reload("data-v-1778e2c0", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 590 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Item__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Item___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__Item__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  components: {
    Item: __WEBPACK_IMPORTED_MODULE_0__Item___default.a
  },
  props: {
    item: {
      required: true
    }
  }
});

/***/ }),
/* 591 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "devise-installer-item",
    {
      attrs: {
        item: _vm.item,
        id: "nav-auth",
        title: "Authentication (required)"
      }
    },
    [
      _c("template", { slot: "instructions" }, [
        _c("p", [
          _vm._v(
            "Devise is not opinionated about the authentication system that you use. But to get started fast you can use the one that ships with Laravel which is great for systems with simple permissions."
          )
        ]),
        _vm._v(" "),
        _c("p", [
          _vm._v(
            "\n      More information on laravels authentication you can read the documentation\n      "
          ),
          _c(
            "a",
            { attrs: { href: "https://laravel.com/docs/5.7/authentication" } },
            [_vm._v("here")]
          )
        ])
      ]),
      _vm._v(" "),
      _c("template", { slot: "example" }, [
        _c("p", [
          _vm._v(
            "From the root of your project on the command line run the following command"
          )
        ]),
        _vm._v(" "),
        _c("pre", { staticClass: "lang-bash", attrs: { "data-start": "1" } }, [
          _vm._v("        "),
          _c("code", [_vm._v("\n          php artisan make:auth\n        ")]),
          _vm._v("\n      ")
        ])
      ])
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
    require("vue-hot-reload-api")      .rerender("data-v-1778e2c0", module.exports)
  }
}

/***/ }),
/* 592 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(593)
/* template */
var __vue_template__ = __webpack_require__(594)
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
Component.options.__file = "src/installer/components/items/User.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-9b8fb13a", Component.options)
  } else {
    hotAPI.reload("data-v-9b8fb13a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 593 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__ = __webpack_require__(57);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vuex__ = __webpack_require__(35);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__Item__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__Item___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__Item__);

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      newUser: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    };
  },

  methods: __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_1_vuex__["b" /* mapActions */])(['createUser']), {
    attemptCreateUser: function attemptCreateUser() {
      this.createUser(this.newUser);
    }
  }),
  components: {
    Item: __WEBPACK_IMPORTED_MODULE_2__Item___default.a
  },
  props: {
    item: {
      required: true
    }
  }
});

/***/ }),
/* 594 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "devise-installer-item",
    {
      attrs: {
        item: _vm.item,
        id: "nav-user",
        title: "First Administration User (required)"
      }
    },
    [
      _c("template", { slot: "instructions" }, [
        _c("p", [
          _vm._v(
            "You need to update the User.php model to add the HasPermissions trait"
          )
        ]),
        _vm._v(" "),
        _c("p", [
          _vm._v(
            "Also, for the first user to login you will need to create a user. You can either enter one directly into the database manually or add one using the form to the right."
          )
        ])
      ]),
      _vm._v(" "),
      _c("template", { slot: "example" }, [
        _c("h3", { staticClass: "dvs-mb-4" }, [
          _vm._v("Add HasPermissions trait to the User model")
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "dvs-mb-8" }, [
          _c("pre", { staticClass: "lang-php line-numbers" }, [
            _vm._v("        "),
            _c("code", [
              _vm._v(
                "\n        <?php\n        namespace App;\n        use Illuminate\\Notifications\\Notifiable;\n        use Illuminate\\Contracts\\Auth\\MustVerifyEmail;\n        use Illuminate\\Foundation\\Auth\\User as Authenticatable;\n        use Devise\\Traits\\HasPermissions;\n\n        class User extends Authenticatable\n        {\n          use Notifiable, HasPermissions;\n\n          /**\n          * The attributes that are mass assignable.\n          *\n          * @var array\n          */\n          protected $fillable = [\n            'name', 'email', 'password',\n          ];\n\n          /**\n          * The attributes that should be hidden for arrays.\n          *\n          * @var array\n          */\n          protected $hidden = [\n            'password', 'remember_token',\n          ];\n        }\n        "
              )
            ]),
            _vm._v("\n      ")
          ])
        ]),
        _vm._v(" "),
        _c(
          "h3",
          { staticClass: "dvs-mb-4" },
          [
            _vm._v("Create Your first User\n      "),
            _vm.item ? [_vm._v("(Already Created)")] : _vm._e()
          ],
          2
        ),
        _vm._v(" "),
        _c("form", { class: { "dvs-opacity-50": _vm.item } }, [
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
              attrs: { type: "text", disabled: _vm.item },
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
              attrs: { type: "email", disabled: _vm.item },
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
          _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-6" }, [
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
              attrs: { type: "text", disabled: _vm.item },
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
          _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-6" }, [
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
              attrs: { type: "text", disabled: _vm.item },
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
              staticClass: "dvs-btn dvs-bg-green dvs-text-white",
              attrs: { disabled: _vm.item },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  _vm.attemptCreateUser()
                }
              }
            },
            [_vm._v("Create User")]
          )
        ])
      ])
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
    require("vue-hot-reload-api")      .rerender("data-v-9b8fb13a", module.exports)
  }
}

/***/ }),
/* 595 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(596)
/* template */
var __vue_template__ = __webpack_require__(597)
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
Component.options.__file = "src/installer/components/items/Site.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-2b4e0642", Component.options)
  } else {
    hotAPI.reload("data-v-2b4e0642", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 596 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__ = __webpack_require__(57);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vuex__ = __webpack_require__(35);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__Item__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__Item___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__Item__);

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      newSite: {
        name: '',
        domain: '',
        code: 'en',
        selectedLanguage: null,
        languages: [],
        settings: {}
      }
    };
  },

  methods: __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_1_vuex__["b" /* mapActions */])(['createSite', 'createLanguage']), {
    attemptCreateSite: function attemptCreateSite() {
      var _this = this;

      // If a language hasn't been created yet
      if (!this.languages.count) {
        this.createLanguage(this.newSite).then(function (response) {
          _this.newSite.languages = [];
          _this.newSite.languages.push({ id: response.data.data.id, default: 1 });
          _this.createSite(_this.newSite);
        });
      } else {
        // If a language was created but the site failed we will end up here
        this.newSite.languages = [];
        this.newSite.languages.push({ id: this.newSite.selectedLanguage, default: 1 });
        this.createSite(this.newSite);
      }
    }
  }),
  computed: __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_1_vuex__["c" /* mapState */])({
    languages: function languages(state) {
      return state.languages.data;
    }
  })),
  components: {
    Item: __WEBPACK_IMPORTED_MODULE_2__Item___default.a
  },
  props: {
    item: {
      required: true
    }
  }
});

/***/ }),
/* 597 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "devise-installer-item",
    {
      attrs: {
        item: _vm.item,
        id: "nav-site",
        title: "First Site and Language (required)"
      }
    },
    [
      _c(
        "template",
        { slot: "instructions" },
        [
          _c("p", [
            _vm._v(
              "Devise works as a multi-tenant system out of the box meaning that you can run multiple sites under the same code base. Even if you are running only one domain Devise needs to know about it. Use the form to the right to set this up."
            )
          ]),
          _vm._v(" "),
          _c("p", [
            _vm._v(
              "\n      Each site also needs a language. You can assign any number of languages once you have completed installation. The language should be the\n      "
            ),
            _c(
              "a",
              {
                attrs: {
                  href:
                    "https://www.loc.gov/standards/iso639-2/php/code_list.php"
                }
              },
              [_vm._v("ISO Code")]
            ),
            _vm._v(" of that language\n    ")
          ]),
          _vm._v(" "),
          _c("help", [
            _c("p", [
              _vm._v(
                'The domain should not include the http or https:// protocol identifier. So your site entry could be "my-super-awesome-site.com" or "sub-domain.my-super-awesome-site.com". To Support development environments you can override these values in your .env file in the root of your project with something like "SITE_1_DOMAIN=my-super-awesome-site.test" for your local development or staging.'
              )
            ]),
            _vm._v(" "),
            _c("p", [
              _c("strong", [_vm._v("Important:")]),
              _vm._v(" The domain should be the\n        "),
              _c("em", [_vm._v("final")]),
              _vm._v(
                " domain name. If you're working on this site locally you will need to add an override in your .env file like the example to the right.\n      "
              )
            ])
          ])
        ],
        1
      ),
      _vm._v(" "),
      _c("template", { slot: "example" }, [
        _c(
          "h3",
          { staticClass: "dvs-mb-4" },
          [
            _vm._v("Create Your first Site\n      "),
            _vm.item ? [_vm._v("(Already Created)")] : _vm._e()
          ],
          2
        ),
        _vm._v(" "),
        _c(
          "form",
          { staticClass: "dvs-mb-8", class: { "dvs-opacity-50": _vm.item } },
          [
            _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
              _c("label", [_vm._v("Site Name")]),
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
                attrs: { type: "text", disabled: _vm.item },
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
            _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
              _c("label", [_vm._v("Site's Actual Domain (See below)")]),
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
                attrs: { type: "text", disabled: _vm.item },
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
            _vm.languages.count
              ? _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-6" }, [
                  _c("label", [_vm._v("Default Language")]),
                  _vm._v(" "),
                  _c(
                    "select",
                    {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.newSite.selectedLanguage,
                          expression: "newSite.selectedLanguage"
                        }
                      ],
                      attrs: { disabled: _vm.item },
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
                            _vm.newSite,
                            "selectedLanguage",
                            $event.target.multiple
                              ? $$selectedVal
                              : $$selectedVal[0]
                          )
                        }
                      }
                    },
                    [
                      _c("option", { domProps: { value: null } }, [
                        _vm._v("Select a Language")
                      ]),
                      _vm._v(" "),
                      _vm._l(_vm.languages, function(language) {
                        return _c(
                          "option",
                          {
                            key: language.id,
                            domProps: { value: language.id }
                          },
                          [_vm._v(_vm._s(language.code))]
                        )
                      })
                    ],
                    2
                  )
                ])
              : _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-6" }, [
                  _c("label", [_vm._v("Default Language")]),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.newSite.code,
                        expression: "newSite.code"
                      }
                    ],
                    attrs: { type: "text", disabled: _vm.item },
                    domProps: { value: _vm.newSite.code },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.newSite, "code", $event.target.value)
                      }
                    }
                  })
                ]),
            _vm._v(" "),
            _c(
              "button",
              {
                staticClass: "dvs-btn dvs-bg-green dvs-text-white",
                attrs: { type: "submit", disabled: _vm.item },
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    _vm.attemptCreateSite()
                  }
                }
              },
              [_vm._v("Create Site")]
            )
          ]
        ),
        _vm._v(" "),
        _c("h3", { staticClass: "dvs-mb-4" }, [
          _vm._v("A note on the domain during development")
        ]),
        _vm._v(" "),
        _c("p", [
          _vm._v(
            "If you're working locally using something like Larvel's Valet or Homestead make sure you provide the acutal domain name above and add a development override in your local .env file. Since this is the first site it needs to have a \"1\" (which will be the ID of the site)"
          )
        ]),
        _vm._v(" "),
        _c("pre", { staticClass: "lang-bash", attrs: { "data-start": "1" } }, [
          _vm._v("      "),
          _c("code", [
            _vm._v("\n        SITE_1_DOMAIN=project-name.test \n      ")
          ]),
          _vm._v("\n    ")
        ])
      ])
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
    require("vue-hot-reload-api")      .rerender("data-v-2b4e0642", module.exports)
  }
}

/***/ }),
/* 598 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(599)
/* template */
var __vue_template__ = __webpack_require__(600)
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
Component.options.__file = "src/installer/components/items/Slices.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1c1d148e", Component.options)
  } else {
    hotAPI.reload("data-v-1c1d148e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 599 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Item__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Item___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__Item__);
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    Item: __WEBPACK_IMPORTED_MODULE_0__Item___default.a
  },
  props: {
    item: {
      required: true
    }
  }
});

/***/ }),
/* 600 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "devise-installer-item",
    {
      attrs: {
        item: _vm.item,
        id: "nav-slices",
        title: "Authentication (required)"
      }
    },
    [
      _c("template", { slot: "instructions" }, [
        _c("p", [
          _vm._v(
            "Devise pages are made up of slices and they live inside /resources/views/slices directory. Make this directory and you'll be on your way."
          )
        ])
      ])
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
    require("vue-hot-reload-api")      .rerender("data-v-1c1d148e", module.exports)
  }
}

/***/ }),
/* 601 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(602)
/* template */
var __vue_template__ = __webpack_require__(603)
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
Component.options.__file = "src/installer/components/items/Page.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1556c7b2", Component.options)
  } else {
    hotAPI.reload("data-v-1556c7b2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 602 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__ = __webpack_require__(57);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vuex__ = __webpack_require__(35);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__Item__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__Item___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__Item__);

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      newPage: {
        site_id: 1,
        language_id: 1,
        title: 'Homepage',
        layout: 'main',
        language: null,
        slug: '/'
      },
      layoutTemplate: '\n            &lt;!doctype html&gt;\n            &lt;html lang="&#123;&#123; app()-&gt;getLocale() &#125;&#125;"&gt;\n              &lt;head&gt;\n                &#64;isset($page)\n                &#123;!! Devise::head($page) !!&#125;\n                &#64;else\n                &#123;!! Devise::head() !!&#125;\n                &#64;endif\n\n                &lt;meta charset="utf-8"&gt;\n                &lt;meta http-equiv="X-UA-Compatible" content="IE=edge"&gt;\n                &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;\n                &lt;meta name="csrf-token" content="&#123;&#123; csrf_token() &#125;&#125;"&gt;\n\n                &lt;style&gt;\n                  &#123;&#123; require public_path(\'css/essentials.css\') &#125;&#125;\n                &lt;/style&gt;\n\n                &lt;title&gt;Your Project&lt;/title&gt;\n              &lt;/head&gt;\n\n              &lt;body&gt;\n                &lt;div id="app"&gt;\n                    &lt;div&gt;\n                      &lt;div id="devise-blocker"&gt;&lt;/div&gt;\n                      &lt;devise&gt;&lt;/devise&gt;\n                    &lt;/div&gt;\n                &lt;/div&gt;\n                \n                &lt;script src="&#123;&#123;mix(\'/js/manifest.js\')&#125;&#125;"&gt;&lt;/script&gt;\n                &lt;script src="&#123;&#123;mix(\'/js/devise-administration-vendor.js\')&#125;&#125;"&gt;&lt;/script&gt;\n                &lt;script src="&#123;&#123;mix(\'/js/app.js\')&#125;&#125;"&gt;&lt;/script&gt;\n\n                &lt;noscript id="deferred-styles"&gt;\n                  &lt;link rel="stylesheet" type="text/css" href="&#123;&#123; mix(\'css/app.css\') &#125;&#125;"/&gt;\n                &lt;/noscript&gt;\n\n                &lt;script&gt;\n                      var loadDeferredStyles = function() {\n                        var addStylesNode = document.getElementById("deferred-styles");\n                        var replacement = document.createElement("div");\n                        replacement.innerHTML = addStylesNode.textContent;\n                        document.body.appendChild(replacement)\n                        addStylesNode.parentElement.removeChild(addStylesNode);\n                      };\n                      var raf = requestAnimationFrame || mozRequestAnimationFrame ||\n                          webkitRequestAnimationFrame || msRequestAnimationFrame;\n                      if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });\n                      else window.addEventListener(\'load\', loadDeferredStyles);\n                &lt;/script&gt;\n              &lt;/body&gt;\n            &lt;/html&gt;\n            '
    };
  },

  methods: __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_1_vuex__["b" /* mapActions */])(['createPage']), {
    attemptCreatePage: function attemptCreatePage() {
      this.createPage(this.newPage);
    }
  }),
  computed: __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_1_vuex__["c" /* mapState */])({
    languages: function languages(state) {
      return state.languages.data;
    }
  }), {
    layouts: function layouts() {
      return window.deviseSettings.$config.layouts;
    }
  }),
  components: {
    Item: __WEBPACK_IMPORTED_MODULE_2__Item___default.a
  },
  props: {
    item: {
      required: true
    }
  }
});

/***/ }),
/* 603 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "devise-installer-item",
    {
      attrs: { item: _vm.item, id: "nav-page", title: "First Page (required)" }
    },
    [
      _c("template", { slot: "instructions" }, [
        _c("p", [
          _vm._v(
            "It's time to create your first page. We'd suggest maybe making your homepage. There's a lot to cover here but don't be intimidated. We will walk you through each step."
          )
        ]),
        _vm._v(" "),
        _c("p", [
          _vm._v(
            "\n      A Devise page is built on two parts: A layout file which follows\n      "
          ),
          _c(
            "a",
            {
              attrs: {
                href: "https://laravel.com/docs/5.7/blade",
                target: "_blank"
              }
            },
            [_vm._v("Laravel's Blade System")]
          ),
          _vm._v(" and slices.\n    ")
        ]),
        _vm._v(" "),
        _c("p", [
          _c("strong", [_vm._v("What a Layout Is:")]),
          _vm._v(
            " A layout blade file is a file that is intended to be used across many pages. This way you don't have to set the <head>, Javascript includes, style inclues, etc on every single page. Each page that is assigned that layout extends it placing it's content where you see fit. We have provided a boilerplate for you to the right. Copy the contents and save them to \"/resources/views/main.blade.php\".\n    "
          )
        ]),
        _vm._v(" "),
        _c("p", [
          _c("strong", [_vm._v("Language:")]),
          _vm._v(
            ": The language should be pretty obvious: What language is this page in? But what is exciting is that if you have multiple languages you'll be able to quickly deploy localized content based on whatever language the user has selected. More on that in the official documention. For now: select your first language you created above in the sites section.\n    "
          )
        ]),
        _vm._v(" "),
        _c("p", [
          _c("strong", [_vm._v("Slug:")]),
          _vm._v(
            ' Finally, the slug is just the url the page lives on. The homepage slug would be "/" while an about page might live at "/about" or "/about-us". The important thing is that it is lower case, has no spaces and is prefixed with a slash.\n    '
          )
        ])
      ]),
      _vm._v(" "),
      _c("template", { slot: "example" }, [
        _c(
          "h3",
          { staticClass: "dvs-mb-4" },
          [
            _vm._v("Create Your first Page\n      "),
            _vm.item ? [_vm._v("(Already Created)")] : _vm._e()
          ],
          2
        ),
        _vm._v(" "),
        _c(
          "form",
          { staticClass: "dvs-mb-8", class: { "dvs-opacity-50": _vm.item } },
          [
            _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-4" }, [
              _c("label", [_vm._v("Page Title")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.newPage.title,
                    expression: "newPage.title"
                  }
                ],
                attrs: { type: "text", disabled: _vm.item },
                domProps: { value: _vm.newPage.title },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(_vm.newPage, "title", $event.target.value)
                  }
                }
              })
            ]),
            _vm._v(" "),
            _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-8" }, [
              _c("label", [_vm._v("Layout")]),
              _vm._v(" "),
              _c(
                "select",
                {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.newPage.layout,
                      expression: "newPage.layout"
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
                        _vm.newPage,
                        "layout",
                        $event.target.multiple
                          ? $$selectedVal
                          : $$selectedVal[0]
                      )
                    }
                  }
                },
                _vm._l(_vm.layouts, function(layout) {
                  return _c(
                    "option",
                    { key: layout, domProps: { value: layout } },
                    [_vm._v(_vm._s(layout))]
                  )
                })
              )
            ]),
            _vm._v(" "),
            _vm.languages.length
              ? _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-6" }, [
                  _c("label", [_vm._v("Language")]),
                  _vm._v(" "),
                  _c(
                    "select",
                    {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.newPage.language_id,
                          expression: "newPage.language_id"
                        }
                      ],
                      attrs: { disabled: _vm.item },
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
                            _vm.newPage,
                            "language_id",
                            $event.target.multiple
                              ? $$selectedVal
                              : $$selectedVal[0]
                          )
                        }
                      }
                    },
                    _vm._l(_vm.languages, function(language) {
                      return _c(
                        "option",
                        { key: language.id, domProps: { value: language.id } },
                        [_vm._v(_vm._s(language.code))]
                      )
                    })
                  )
                ])
              : _vm._e(),
            _vm._v(" "),
            _c("fieldset", { staticClass: "dvs-fieldset dvs-mb-6" }, [
              _c("label", [_vm._v("Slug")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.newPage.slug,
                    expression: "newPage.slug"
                  }
                ],
                attrs: { type: "text", disabled: _vm.item },
                domProps: { value: _vm.newPage.slug },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(_vm.newPage, "slug", $event.target.value)
                  }
                }
              })
            ]),
            _vm._v(" "),
            _c(
              "button",
              {
                staticClass: "dvs-btn dvs-bg-green dvs-text-white",
                attrs: { type: "submit", disabled: _vm.item },
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    _vm.attemptCreatePage()
                  }
                }
              },
              [_vm._v("Create Page")]
            )
          ]
        ),
        _vm._v(" "),
        _c("h3", { staticClass: "dvs-mb-4" }, [
          _vm._v("A solid boilerplate for your first layout file")
        ]),
        _vm._v(" "),
        _c("p", [
          _vm._v("\n      Save the following to\n      "),
          _c("span", { staticClass: "dvs-font-mono" }, [
            _vm._v("/resource/views/main.blade.php")
          ])
        ]),
        _vm._v(" "),
        _c("pre", { staticClass: "lang-html line-numbers" }, [
          _vm._v("            "),
          _c("code", { domProps: { innerHTML: _vm._s(_vm.layoutTemplate) } }),
          _vm._v("\n          ")
        ])
      ])
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
    require("vue-hot-reload-api")      .rerender("data-v-1556c7b2", module.exports)
  }
}

/***/ }),
/* 604 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(605)
/* template */
var __vue_template__ = __webpack_require__(606)
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
Component.options.__file = "src/installer/components/items/ImageLibrary.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-68b60ff8", Component.options)
  } else {
    hotAPI.reload("data-v-68b60ff8", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 605 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Item__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Item___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__Item__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  components: {
    Item: __WEBPACK_IMPORTED_MODULE_0__Item___default.a
  },
  props: {
    item: {
      required: true
    }
  }
});

/***/ }),
/* 606 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "devise-installer-item",
    {
      attrs: {
        item: _vm.item,
        id: "nav-image-library",
        title: "Image Library (Required)"
      }
    },
    [
      _c("template", { slot: "instructions" }, [
        _c("p", [
          _vm._v(
            "Devise allows users to select images from a media manager and manipulate them. To do this Devise needs ImageMagick (preferred) or GD installed. You don't need both - just one or the other. Getting either library installed can be a little tricky depending on the version of PHP you're running and environment but we have provided a few tips to the right."
          )
        ])
      ]),
      _vm._v(" "),
      _c("template", { slot: "example" }, [
        _c("h3", { staticClass: "dvs-mb-4" }, [
          _vm._v("\n      Mac OS (using\n      "),
          _c("a", { attrs: { href: "https://brew.sh/", target: "_blank" } }, [
            _vm._v("Homebrew")
          ]),
          _vm._v(")\n    ")
        ]),
        _vm._v(" "),
        _c("p", [_vm._v("On the command line run the following command")]),
        _vm._v(" "),
        _c("pre", { staticClass: "lang-bash", attrs: { "data-start": "1" } }, [
          _vm._v("              "),
          _c("code", [
            _vm._v("\n                brew install imagemagick\n              ")
          ]),
          _vm._v("\n            ")
        ]),
        _vm._v(" "),
        _c("p", [_vm._v("Or")]),
        _vm._v(" "),
        _c("pre", { staticClass: "lang-bash", attrs: { "data-start": "1" } }, [
          _vm._v("              "),
          _c("code", [
            _vm._v("\n                brew install gd\n              ")
          ]),
          _vm._v("\n            ")
        ]),
        _vm._v(" "),
        _c("h3", { staticClass: "dvs-mb-4" }, [_vm._v("Windows")]),
        _vm._v(" "),
        _c("p", [
          _vm._v(
            "This is very much dependent on what you are using for development but any help you can provide others is greatly appreciated. Please submit any ideas for this section through a pull request."
          )
        ])
      ])
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
    require("vue-hot-reload-api")      .rerender("data-v-68b60ff8", module.exports)
  }
}

/***/ }),
/* 607 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(608)
/* template */
var __vue_template__ = __webpack_require__(609)
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
Component.options.__file = "src/installer/components/items/ImageOptimization.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-47067300", Component.options)
  } else {
    hotAPI.reload("data-v-47067300", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 608 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Item__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Item___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__Item__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  components: {
    Item: __WEBPACK_IMPORTED_MODULE_0__Item___default.a
  },
  props: {
    checklist: {
      required: true
    }
  }
});

/***/ }),
/* 609 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "devise-installer-item",
    {
      attrs: {
        item:
          _vm.checklist.image_optimization.jpegoptim ||
          _vm.checklist.image_optimization.optipng ||
          _vm.checklist.image_optimization.pngquant ||
          _vm.checklist.image_optimization.svgo ||
          _vm.checklist.image_optimization.gifsicle,
        id: "nav-image-optimization",
        title: "Image Optimization (Optional)"
      }
    },
    [
      _c("template", { slot: "instructions" }, [
        _c("p", [
          _vm._v(
            "When images are uploaded to the media manager nothing happens. We store the highest resolution image we can. However, when a user select's an image when populating content Devise will attempt to optimize the image by running a series of optimizations depending on file type. These are not required but you can greatly increase the performance for end-users by having these installed."
          )
        ])
      ]),
      _vm._v(" "),
      _c("template", { slot: "example" }, [
        _c("h3", { staticClass: "dvs-mb-4" }, [
          _vm._v("\n      Mac OS (using\n      "),
          _c("a", { attrs: { href: "https://brew.sh/", target: "_blank" } }, [
            _vm._v("Homebrew")
          ]),
          _vm._v(")\n    ")
        ]),
        _vm._v(" "),
        _c("p", [_vm._v("On the command line run the following command")]),
        _vm._v(" "),
        _c("pre", { staticClass: "lang-bash", attrs: { "data-start": "1" } }, [
          _vm._v("              "),
          _c("code", [
            _vm._v(
              "\n                brew install jpegoptim\n                brew install optipng\n                brew install pngquant\n                brew install svgo\n                brew install gifsicle\n              "
            )
          ]),
          _vm._v("\n            ")
        ]),
        _vm._v(" "),
        _c("h3", { staticClass: "dvs-mb-4" }, [_vm._v("Ubuntu")]),
        _vm._v(" "),
        _c("p", [_vm._v("On the command line run the following command")]),
        _vm._v(" "),
        _c("pre", { staticClass: "lang-bash", attrs: { "data-start": "1" } }, [
          _vm._v("              "),
          _c("code", [
            _vm._v(
              "\n                sudo apt-get install jpegoptim\n                sudo apt-get install optipng\n                sudo apt-get install pngquant\n                sudo npm install -g svgo\n                sudo apt-get install gifsicle\n              "
            )
          ]),
          _vm._v("\n            ")
        ])
      ])
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
    require("vue-hot-reload-api")      .rerender("data-v-47067300", module.exports)
  }
}

/***/ }),
/* 610 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(611)
/* template */
var __vue_template__ = __webpack_require__(612)
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
Component.options.__file = "src/installer/components/items/OptionalExtras.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-3b486d7b", Component.options)
  } else {
    hotAPI.reload("data-v-3b486d7b", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 611 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Item__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Item___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__Item__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  components: {
    Item: __WEBPACK_IMPORTED_MODULE_0__Item___default.a
  }
});

/***/ }),
/* 612 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "devise-installer-item",
    {
      attrs: {
        id: "nav-remove-laravel-route",
        title: "Remove Laravel Routes (Optional)"
      }
    },
    [
      _c(
        "template",
        { slot: "instructions" },
        [
          _c("p", [
            _vm._v(
              'Laravel ships with a default route for the homepage and if you ran the "make:auth" command above added some more. You most likely want to remove these.'
            )
          ]),
          _vm._v(" "),
          _c("help", [
            _c("strong", [_vm._v("Important:")]),
            _vm._v(" Do NOT remove the Auth::routes(); line from web.php\n    ")
          ])
        ],
        1
      ),
      _vm._v(" "),
      _c("template", { slot: "example" }, [
        _c("h3", { staticClass: "dvs-mb-4" }, [
          _vm._v("Where the routes are located:")
        ]),
        _vm._v(" "),
        _c("p", [_vm._v("In '/routes/web.php' remove the following:")]),
        _vm._v(" "),
        _c("pre", { staticClass: "lang-bash", attrs: { "data-start": "1" } }, [
          _vm._v("              "),
          _c("code", [
            _vm._v(
              "\n                Route::get('/', function () {\n                    return view('welcome');\n                });\n              "
            )
          ]),
          _vm._v("\n            ")
        ]),
        _vm._v(" "),
        _c("pre", { staticClass: "lang-bash", attrs: { "data-start": "1" } }, [
          _vm._v("              "),
          _c("code", [
            _vm._v(
              "\n                Route::get('/home', 'HomeController@index')->name('home');\n              "
            )
          ]),
          _vm._v("\n            ")
        ])
      ])
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
    require("vue-hot-reload-api")      .rerender("data-v-3b486d7b", module.exports)
  }
}

/***/ }),
/* 613 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "dvs-flex" },
    [
      _c("installer-finish", {
        ref: "finshline",
        staticClass: "dvs-fixed dvs-pin-t dvs-pin-l dvs-pin-r dvs-z-50",
        style: _vm.finishedStyles,
        attrs: { finished: _vm.finished }
      }),
      _vm._v(" "),
      _vm.checklist.database
        ? _c("main-menu", {
            style: _vm.bodyFinishedStyles,
            attrs: { checklist: _vm.checklist }
          })
        : _vm._e(),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "dvs-absolute dvs-pin dvs-overflow-scroll",
          style: _vm.bodyFinishedStyles,
          attrs: { id: "content" }
        },
        [
          _c("section", { attrs: { id: "nav-welcome", name: "nav-welcome" } }, [
            _c("div", [
              _c(
                "div",
                { staticClass: "dvs-w-1/2 dvs-mb-4" },
                [_c("devise-logo", { attrs: { color: "#222" } })],
                1
              ),
              _vm._v(" "),
              _c("p", { staticClass: "dvs-text-xl dvs-mb-16" }, [
                _vm._v(
                  "We are very excited that you are giving Devise 2 a spin. We are still in the early beta stages of this product but we do believe we have settled on the final structure of things. We encourage you to send us any feedback via Github issues, submit any PR's or just let us know what you think of the project on Twitter @devisephp."
                )
              ]),
              _vm._v(" "),
              _vm._m(0),
              _vm._v(" "),
              _vm._m(1)
            ]),
            _vm._v(" "),
            _c("div")
          ]),
          _vm._v(" "),
          _c("div", { attrs: { id: "nav-required" } }),
          _vm._v(" "),
          _vm.checklist.database
            ? [
                _c("database", { attrs: { item: _vm.checklist.database } }),
                _vm._v(" "),
                _c("migrations", { attrs: { item: _vm.checklist.migrations } }),
                _vm._v(" "),
                _c("auth", { attrs: { item: _vm.checklist.auth } }),
                _vm._v(" "),
                _c("user", { attrs: { item: _vm.checklist.user } }),
                _vm._v(" "),
                _c("site", { attrs: { item: _vm.checklist.site } }),
                _vm._v(" "),
                _c("page", { attrs: { item: _vm.checklist.page } }),
                _vm._v(" "),
                _c("slices", { attrs: { item: _vm.checklist.slices } }),
                _vm._v(" "),
                _c("image-library", {
                  attrs: { item: _vm.checklist.image_library }
                }),
                _vm._v(" "),
                _c("div", { attrs: { id: "nav-suggested" } }),
                _vm._v(" "),
                _c("optional-extras"),
                _vm._v(" "),
                _c("image-optimization", {
                  attrs: { checklist: _vm.checklist }
                })
              ]
            : _vm._e()
        ],
        2
      ),
      _vm._v(" "),
      _c("messages")
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "dvs-mb-16 dvs-flex" }, [
      _c(
        "a",
        {
          staticClass: "dvs-btn dvs-bg-blue dvs-text-white dvs-mr-2",
          attrs: { href: "https://devise.gitbook.io/cms/", target: "_blank" }
        },
        [_vm._v("Documentation")]
      ),
      _vm._v(" "),
      _c(
        "a",
        {
          staticClass: "dvs-btn dvs-bg-blue dvs-text-white dvs-mr-2",
          attrs: { href: "https://devisephp.com", target: "_blank" }
        },
        [_vm._v("Website")]
      ),
      _vm._v(" "),
      _c(
        "a",
        {
          staticClass: "dvs-btn dvs-bg-blue dvs-text-white",
          attrs: { href: "https://github.com/devisephp/cms", target: "_blank" }
        },
        [_vm._v("Github")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "dvs-text-left dvs-w-full" }, [
      _c("h2", { staticClass: "dvs-mb-4" }, [_vm._v("Installation")]),
      _vm._v(" "),
      _c("p", { staticClass: "dvs-mb-4" }, [
        _vm._v(
          'Below we have setup an interactive installer that will continually poll to see if you have correctly configured your server and application for Devise. Once you have turned all the items in "Required Setup" green you are good to go. However, we have also provided some helpful items in "Non-required Setup" that you may want to take a look at.'
        )
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-10043a22", module.exports)
  }
}

/***/ }),
/* 614 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(615)
/* template */
var __vue_template__ = __webpack_require__(616)
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
Component.options.__file = "src/installer/components/InstallerFinish.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0f64ece2", Component.options)
  } else {
    hotAPI.reload("data-v-0f64ece2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 615 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__ = __webpack_require__(57);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vuex__ = __webpack_require__(35);

//
//
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
  methods: __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default()({}, Object(__WEBPACK_IMPORTED_MODULE_1_vuex__["b" /* mapActions */])(['completeInstall']), {
    attemptCompleteInstall: function attemptCompleteInstall() {
      this.completeInstall().then(function () {
        location.reload();
      });
    }
  }),
  props: {
    finished: {
      type: Boolean,
      required: true
    }
  }
});

/***/ }),
/* 616 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "dvs-p-8 dvs-bg-green dvs-text-white" }, [
    _c("h2", [_vm._v("Congratulations!")]),
    _vm._v(" "),
    _c("p", [
      _vm._v(
        'You are finished with the required elements of your Devise install. Click below to complete your install. If you ever want to come back simple delete the "DVS_MODE=active" from your .env file.'
      )
    ]),
    _vm._v(" "),
    _c(
      "button",
      {
        staticClass: "dvs-btn dvs-bg-white dvs-text-green",
        on: {
          click: function($event) {
            $event.preventDefault()
            _vm.attemptCompleteInstall()
          }
        }
      },
      [_vm._v("Complete Install")]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-0f64ece2", module.exports)
  }
}

/***/ }),
/* 617 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(618)
}
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(620)
/* template */
var __vue_template__ = __webpack_require__(621)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
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
Component.options.__file = "src/installer/components/ItemCheck.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-43fb8ac8", Component.options)
  } else {
    hotAPI.reload("data-v-43fb8ac8", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 618 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(619);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(117)("bc36d376", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../node_modules/css-loader/index.js!../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-43fb8ac8\",\"scoped\":false,\"hasInlineConfig\":true}!../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./ItemCheck.vue", function() {
     var newContent = require("!!../../../node_modules/css-loader/index.js!../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-43fb8ac8\",\"scoped\":false,\"hasInlineConfig\":true}!../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./ItemCheck.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 619 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(38)(false);
// imports


// module
exports.push([module.i, "\n", ""]);

// exports


/***/ }),
/* 620 */
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

/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    item: {
      type: Boolean,
      required: true
    },
    size: {
      type: Number,
      default: 50
    }
  }
});

/***/ }),
/* 621 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      !_vm.item
        ? _c("close-circle-icon", {
            attrs: { w: _vm.size.toString(), h: _vm.size.toString() }
          })
        : _c(
            "div",
            { staticClass: "dvs-text-green" },
            [
              _c("checkmark-icon", {
                attrs: { w: _vm.size.toString(), h: _vm.size.toString() }
              })
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
    require("vue-hot-reload-api")      .rerender("data-v-43fb8ac8", module.exports)
  }
}

/***/ }),
/* 622 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = null
/* template */
var __vue_template__ = __webpack_require__(623)
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
Component.options.__file = "src/installer/components/Help.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-d65811ac", Component.options)
  } else {
    hotAPI.reload("data-v-d65811ac", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 623 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass:
        "dvs-mb-8 dvs-relative dvs-bg-green-lightest dvs-p-6 dvs-pl-16 dvs-relative dvs-border dvs-rounded dvs-border-green dvs-text-green"
    },
    [
      _c("alert-icon", {
        staticClass:
          "dvs-mr-4 dvs-absolute dvs-pin-l dvs-pin-t dvs-mt-6 dvs-ml-4",
        attrs: { w: "40", h: "40" }
      }),
      _vm._v(" "),
      _vm._t("default")
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
    require("vue-hot-reload-api")      .rerender("data-v-d65811ac", module.exports)
  }
}

/***/ }),
/* 624 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(625)
/* template */
var __vue_template__ = __webpack_require__(626)
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
Component.options.__file = "src/installer/node_modules/vue-ionicons/dist/ios-checkmark-circle-outline.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-879c47f6", Component.options)
  } else {
    hotAPI.reload("data-v-879c47f6", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 625 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__ionicons_mixin__ = __webpack_require__(118);
//
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
  name: "ios-checkmark-circle-outline-icon",
  mixins: [__WEBPACK_IMPORTED_MODULE_0__ionicons_mixin__["a" /* default */]],
  data: function data() {
    var iconTitle = this.title ? this.title : "Ios Checkmark Circle Outline Icon";
    return {
      iconTitle: iconTitle
    };
  }
});

/***/ }),
/* 626 */
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
      attrs: { title: _vm.iconTitle, name: "ios-checkmark-circle-outline-icon" }
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
                "M362.6 192.9L345 174.8c-.7-.8-1.8-1.2-2.8-1.2-1.1 0-2.1.4-2.8 1.2l-122 122.9-44.4-44.4c-.8-.8-1.8-1.2-2.8-1.2-1 0-2 .4-2.8 1.2l-17.8 17.8c-1.6 1.6-1.6 4.1 0 5.7l56 56c3.6 3.6 8 5.7 11.7 5.7 5.3 0 9.9-3.9 11.6-5.5h.1l133.7-134.4c1.4-1.7 1.4-4.2-.1-5.7z"
            }
          }),
          _c("path", {
            attrs: {
              d:
                "M256 76c48.1 0 93.3 18.7 127.3 52.7S436 207.9 436 256s-18.7 93.3-52.7 127.3S304.1 436 256 436c-48.1 0-93.3-18.7-127.3-52.7S76 304.1 76 256s18.7-93.3 52.7-127.3S207.9 76 256 76m0-28C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48z"
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
    require("vue-hot-reload-api")      .rerender("data-v-879c47f6", module.exports)
  }
}

/***/ }),
/* 627 */
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
Component.options.__file = "src/installer/node_modules/vue-ionicons/dist/ios-close-circle-outline.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-646ee5fc", Component.options)
  } else {
    hotAPI.reload("data-v-646ee5fc", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 628 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__ionicons_mixin__ = __webpack_require__(118);
//
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
  name: "ios-close-circle-outline-icon",
  mixins: [__WEBPACK_IMPORTED_MODULE_0__ionicons_mixin__["a" /* default */]],
  data: function data() {
    var iconTitle = this.title ? this.title : "Ios Close Circle Outline Icon";
    return {
      iconTitle: iconTitle
    };
  }
});

/***/ }),
/* 629 */
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
      attrs: { title: _vm.iconTitle, name: "ios-close-circle-outline-icon" }
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
                "M331.3 308.7L278.6 256l52.7-52.7c6.2-6.2 6.2-16.4 0-22.6-6.2-6.2-16.4-6.2-22.6 0L256 233.4l-52.7-52.7c-6.2-6.2-15.6-7.1-22.6 0-7.1 7.1-6 16.6 0 22.6l52.7 52.7-52.7 52.7c-6.7 6.7-6.4 16.3 0 22.6 6.4 6.4 16.4 6.2 22.6 0l52.7-52.7 52.7 52.7c6.2 6.2 16.4 6.2 22.6 0 6.3-6.2 6.3-16.4 0-22.6z"
            }
          }),
          _c("path", {
            attrs: {
              d:
                "M256 76c48.1 0 93.3 18.7 127.3 52.7S436 207.9 436 256s-18.7 93.3-52.7 127.3S304.1 436 256 436c-48.1 0-93.3-18.7-127.3-52.7S76 304.1 76 256s18.7-93.3 52.7-127.3S207.9 76 256 76m0-28C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48z"
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
    require("vue-hot-reload-api")      .rerender("data-v-646ee5fc", module.exports)
  }
}

/***/ }),
/* 630 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(631)
/* template */
var __vue_template__ = __webpack_require__(632)
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
Component.options.__file = "src/installer/node_modules/vue-ionicons/dist/ios-alert.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1a7ad544", Component.options)
  } else {
    hotAPI.reload("data-v-1a7ad544", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 631 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__ionicons_mixin__ = __webpack_require__(118);
//
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
  name: "ios-alert-icon",
  mixins: [__WEBPACK_IMPORTED_MODULE_0__ionicons_mixin__["a" /* default */]],
  data: function data() {
    var iconTitle = this.title ? this.title : "Ios Alert Icon";
    return {
      iconTitle: iconTitle
    };
  }
});

/***/ }),
/* 632 */
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
      attrs: { title: _vm.iconTitle, name: "ios-alert-icon" }
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
                "M256 48C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48zm17.2 109.6l-3.1 115.1c-.2 8.2-5.9 14.8-14.1 14.8s-13.9-6.6-14.1-14.8l-3.1-115.1c-.2-9.6 7.5-17.6 17.2-17.6 9.6 0 17.4 7.9 17.2 17.6zM256 354c-10.7 0-19.1-8.1-19.1-18.4s8.4-18.4 19.1-18.4c10.7 0 19.1 8.1 19.1 18.4S266.7 354 256 354z"
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
    require("vue-hot-reload-api")      .rerender("data-v-1a7ad544", module.exports)
  }
}

/***/ }),
/* 633 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {
/* **********************************************
     Begin prism-core.js
********************************************** */

var _self = (typeof window !== 'undefined')
	? window   // if in browser
	: (
		(typeof WorkerGlobalScope !== 'undefined' && self instanceof WorkerGlobalScope)
		? self // if in worker
		: {}   // if in node js
	);

/**
 * Prism: Lightweight, robust, elegant syntax highlighting
 * MIT license http://www.opensource.org/licenses/mit-license.php/
 * @author Lea Verou http://lea.verou.me
 */

var Prism = (function(){

// Private helper vars
var lang = /\blang(?:uage)?-([\w-]+)\b/i;
var uniqueId = 0;

var _ = _self.Prism = {
	manual: _self.Prism && _self.Prism.manual,
	disableWorkerMessageHandler: _self.Prism && _self.Prism.disableWorkerMessageHandler,
	util: {
		encode: function (tokens) {
			if (tokens instanceof Token) {
				return new Token(tokens.type, _.util.encode(tokens.content), tokens.alias);
			} else if (_.util.type(tokens) === 'Array') {
				return tokens.map(_.util.encode);
			} else {
				return tokens.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/\u00a0/g, ' ');
			}
		},

		type: function (o) {
			return Object.prototype.toString.call(o).match(/\[object (\w+)\]/)[1];
		},

		objId: function (obj) {
			if (!obj['__id']) {
				Object.defineProperty(obj, '__id', { value: ++uniqueId });
			}
			return obj['__id'];
		},

		// Deep clone a language definition (e.g. to extend it)
		clone: function (o, visited) {
			var type = _.util.type(o);
			visited = visited || {};

			switch (type) {
				case 'Object':
					if (visited[_.util.objId(o)]) {
						return visited[_.util.objId(o)];
					}
					var clone = {};
					visited[_.util.objId(o)] = clone;

					for (var key in o) {
						if (o.hasOwnProperty(key)) {
							clone[key] = _.util.clone(o[key], visited);
						}
					}

					return clone;

				case 'Array':
					if (visited[_.util.objId(o)]) {
						return visited[_.util.objId(o)];
					}
					var clone = [];
					visited[_.util.objId(o)] = clone;

					o.forEach(function (v, i) {
						clone[i] = _.util.clone(v, visited);
					});

					return clone;
			}

			return o;
		}
	},

	languages: {
		extend: function (id, redef) {
			var lang = _.util.clone(_.languages[id]);

			for (var key in redef) {
				lang[key] = redef[key];
			}

			return lang;
		},

		/**
		 * Insert a token before another token in a language literal
		 * As this needs to recreate the object (we cannot actually insert before keys in object literals),
		 * we cannot just provide an object, we need anobject and a key.
		 * @param inside The key (or language id) of the parent
		 * @param before The key to insert before. If not provided, the function appends instead.
		 * @param insert Object with the key/value pairs to insert
		 * @param root The object that contains `inside`. If equal to Prism.languages, it can be omitted.
		 */
		insertBefore: function (inside, before, insert, root) {
			root = root || _.languages;
			var grammar = root[inside];

			if (arguments.length == 2) {
				insert = arguments[1];

				for (var newToken in insert) {
					if (insert.hasOwnProperty(newToken)) {
						grammar[newToken] = insert[newToken];
					}
				}

				return grammar;
			}

			var ret = {};

			for (var token in grammar) {

				if (grammar.hasOwnProperty(token)) {

					if (token == before) {

						for (var newToken in insert) {

							if (insert.hasOwnProperty(newToken)) {
								ret[newToken] = insert[newToken];
							}
						}
					}

					ret[token] = grammar[token];
				}
			}

			// Update references in other language definitions
			_.languages.DFS(_.languages, function(key, value) {
				if (value === root[inside] && key != inside) {
					this[key] = ret;
				}
			});

			return root[inside] = ret;
		},

		// Traverse a language definition with Depth First Search
		DFS: function(o, callback, type, visited) {
			visited = visited || {};
			for (var i in o) {
				if (o.hasOwnProperty(i)) {
					callback.call(o, i, o[i], type || i);

					if (_.util.type(o[i]) === 'Object' && !visited[_.util.objId(o[i])]) {
						visited[_.util.objId(o[i])] = true;
						_.languages.DFS(o[i], callback, null, visited);
					}
					else if (_.util.type(o[i]) === 'Array' && !visited[_.util.objId(o[i])]) {
						visited[_.util.objId(o[i])] = true;
						_.languages.DFS(o[i], callback, i, visited);
					}
				}
			}
		}
	},
	plugins: {},

	highlightAll: function(async, callback) {
		_.highlightAllUnder(document, async, callback);
	},

	highlightAllUnder: function(container, async, callback) {
		var env = {
			callback: callback,
			selector: 'code[class*="language-"], [class*="language-"] code, code[class*="lang-"], [class*="lang-"] code'
		};

		_.hooks.run("before-highlightall", env);

		var elements = env.elements || container.querySelectorAll(env.selector);

		for (var i=0, element; element = elements[i++];) {
			_.highlightElement(element, async === true, env.callback);
		}
	},

	highlightElement: function(element, async, callback) {
		// Find language
		var language, grammar, parent = element;

		while (parent && !lang.test(parent.className)) {
			parent = parent.parentNode;
		}

		if (parent) {
			language = (parent.className.match(lang) || [,''])[1].toLowerCase();
			grammar = _.languages[language];
		}

		// Set language on the element, if not present
		element.className = element.className.replace(lang, '').replace(/\s+/g, ' ') + ' language-' + language;

		if (element.parentNode) {
			// Set language on the parent, for styling
			parent = element.parentNode;

			if (/pre/i.test(parent.nodeName)) {
				parent.className = parent.className.replace(lang, '').replace(/\s+/g, ' ') + ' language-' + language;
			}
		}

		var code = element.textContent;

		var env = {
			element: element,
			language: language,
			grammar: grammar,
			code: code
		};

		_.hooks.run('before-sanity-check', env);

		if (!env.code || !env.grammar) {
			if (env.code) {
				_.hooks.run('before-highlight', env);
				env.element.textContent = env.code;
				_.hooks.run('after-highlight', env);
			}
			_.hooks.run('complete', env);
			return;
		}

		_.hooks.run('before-highlight', env);

		if (async && _self.Worker) {
			var worker = new Worker(_.filename);

			worker.onmessage = function(evt) {
				env.highlightedCode = evt.data;

				_.hooks.run('before-insert', env);

				env.element.innerHTML = env.highlightedCode;

				callback && callback.call(env.element);
				_.hooks.run('after-highlight', env);
				_.hooks.run('complete', env);
			};

			worker.postMessage(JSON.stringify({
				language: env.language,
				code: env.code,
				immediateClose: true
			}));
		}
		else {
			env.highlightedCode = _.highlight(env.code, env.grammar, env.language);

			_.hooks.run('before-insert', env);

			env.element.innerHTML = env.highlightedCode;

			callback && callback.call(element);

			_.hooks.run('after-highlight', env);
			_.hooks.run('complete', env);
		}
	},

	highlight: function (text, grammar, language) {
		var env = {
			code: text,
			grammar: grammar,
			language: language
		};
		_.hooks.run('before-tokenize', env);
		env.tokens = _.tokenize(env.code, env.grammar);
		_.hooks.run('after-tokenize', env);
		return Token.stringify(_.util.encode(env.tokens), env.language);
	},

	matchGrammar: function (text, strarr, grammar, index, startPos, oneshot, target) {
		var Token = _.Token;

		for (var token in grammar) {
			if(!grammar.hasOwnProperty(token) || !grammar[token]) {
				continue;
			}

			if (token == target) {
				return;
			}

			var patterns = grammar[token];
			patterns = (_.util.type(patterns) === "Array") ? patterns : [patterns];

			for (var j = 0; j < patterns.length; ++j) {
				var pattern = patterns[j],
					inside = pattern.inside,
					lookbehind = !!pattern.lookbehind,
					greedy = !!pattern.greedy,
					lookbehindLength = 0,
					alias = pattern.alias;

				if (greedy && !pattern.pattern.global) {
					// Without the global flag, lastIndex won't work
					var flags = pattern.pattern.toString().match(/[imuy]*$/)[0];
					pattern.pattern = RegExp(pattern.pattern.source, flags + "g");
				}

				pattern = pattern.pattern || pattern;

				// Don’t cache length as it changes during the loop
				for (var i = index, pos = startPos; i < strarr.length; pos += strarr[i].length, ++i) {

					var str = strarr[i];

					if (strarr.length > text.length) {
						// Something went terribly wrong, ABORT, ABORT!
						return;
					}

					if (str instanceof Token) {
						continue;
					}

					if (greedy && i != strarr.length - 1) {
						pattern.lastIndex = pos;
						var match = pattern.exec(text);
						if (!match) {
							break;
						}

						var from = match.index + (lookbehind ? match[1].length : 0),
						    to = match.index + match[0].length,
						    k = i,
						    p = pos;

						for (var len = strarr.length; k < len && (p < to || (!strarr[k].type && !strarr[k - 1].greedy)); ++k) {
							p += strarr[k].length;
							// Move the index i to the element in strarr that is closest to from
							if (from >= p) {
								++i;
								pos = p;
							}
						}

						// If strarr[i] is a Token, then the match starts inside another Token, which is invalid
						if (strarr[i] instanceof Token) {
							continue;
						}

						// Number of tokens to delete and replace with the new match
						delNum = k - i;
						str = text.slice(pos, p);
						match.index -= pos;
					} else {
						pattern.lastIndex = 0;

						var match = pattern.exec(str),
							delNum = 1;
					}

					if (!match) {
						if (oneshot) {
							break;
						}

						continue;
					}

					if(lookbehind) {
						lookbehindLength = match[1] ? match[1].length : 0;
					}

					var from = match.index + lookbehindLength,
					    match = match[0].slice(lookbehindLength),
					    to = from + match.length,
					    before = str.slice(0, from),
					    after = str.slice(to);

					var args = [i, delNum];

					if (before) {
						++i;
						pos += before.length;
						args.push(before);
					}

					var wrapped = new Token(token, inside? _.tokenize(match, inside) : match, alias, match, greedy);

					args.push(wrapped);

					if (after) {
						args.push(after);
					}

					Array.prototype.splice.apply(strarr, args);

					if (delNum != 1)
						_.matchGrammar(text, strarr, grammar, i, pos, true, token);

					if (oneshot)
						break;
				}
			}
		}
	},

	tokenize: function(text, grammar, language) {
		var strarr = [text];

		var rest = grammar.rest;

		if (rest) {
			for (var token in rest) {
				grammar[token] = rest[token];
			}

			delete grammar.rest;
		}

		_.matchGrammar(text, strarr, grammar, 0, 0, false);

		return strarr;
	},

	hooks: {
		all: {},

		add: function (name, callback) {
			var hooks = _.hooks.all;

			hooks[name] = hooks[name] || [];

			hooks[name].push(callback);
		},

		run: function (name, env) {
			var callbacks = _.hooks.all[name];

			if (!callbacks || !callbacks.length) {
				return;
			}

			for (var i=0, callback; callback = callbacks[i++];) {
				callback(env);
			}
		}
	}
};

var Token = _.Token = function(type, content, alias, matchedStr, greedy) {
	this.type = type;
	this.content = content;
	this.alias = alias;
	// Copy of the full string this token was created from
	this.length = (matchedStr || "").length|0;
	this.greedy = !!greedy;
};

Token.stringify = function(o, language, parent) {
	if (typeof o == 'string') {
		return o;
	}

	if (_.util.type(o) === 'Array') {
		return o.map(function(element) {
			return Token.stringify(element, language, o);
		}).join('');
	}

	var env = {
		type: o.type,
		content: Token.stringify(o.content, language, parent),
		tag: 'span',
		classes: ['token', o.type],
		attributes: {},
		language: language,
		parent: parent
	};

	if (o.alias) {
		var aliases = _.util.type(o.alias) === 'Array' ? o.alias : [o.alias];
		Array.prototype.push.apply(env.classes, aliases);
	}

	_.hooks.run('wrap', env);

	var attributes = Object.keys(env.attributes).map(function(name) {
		return name + '="' + (env.attributes[name] || '').replace(/"/g, '&quot;') + '"';
	}).join(' ');

	return '<' + env.tag + ' class="' + env.classes.join(' ') + '"' + (attributes ? ' ' + attributes : '') + '>' + env.content + '</' + env.tag + '>';

};

if (!_self.document) {
	if (!_self.addEventListener) {
		// in Node.js
		return _self.Prism;
	}

	if (!_.disableWorkerMessageHandler) {
		// In worker
		_self.addEventListener('message', function (evt) {
			var message = JSON.parse(evt.data),
				lang = message.language,
				code = message.code,
				immediateClose = message.immediateClose;

			_self.postMessage(_.highlight(code, _.languages[lang], lang));
			if (immediateClose) {
				_self.close();
			}
		}, false);
	}

	return _self.Prism;
}

//Get current script and highlight
var script = document.currentScript || [].slice.call(document.getElementsByTagName("script")).pop();

if (script) {
	_.filename = script.src;

	if (!_.manual && !script.hasAttribute('data-manual')) {
		if(document.readyState !== "loading") {
			if (window.requestAnimationFrame) {
				window.requestAnimationFrame(_.highlightAll);
			} else {
				window.setTimeout(_.highlightAll, 16);
			}
		}
		else {
			document.addEventListener('DOMContentLoaded', _.highlightAll);
		}
	}
}

return _self.Prism;

})();

if (typeof module !== 'undefined' && module.exports) {
	module.exports = Prism;
}

// hack for components to work correctly in node.js
if (typeof global !== 'undefined') {
	global.Prism = Prism;
}


/* **********************************************
     Begin prism-markup.js
********************************************** */

Prism.languages.markup = {
	'comment': /<!--[\s\S]*?-->/,
	'prolog': /<\?[\s\S]+?\?>/,
	'doctype': /<!DOCTYPE[\s\S]+?>/i,
	'cdata': /<!\[CDATA\[[\s\S]*?]]>/i,
	'tag': {
		pattern: /<\/?(?!\d)[^\s>\/=$<%]+(?:\s+[^\s>\/=]+(?:=(?:("|')(?:\\[\s\S]|(?!\1)[^\\])*\1|[^\s'">=]+))?)*\s*\/?>/i,
		greedy: true,
		inside: {
			'tag': {
				pattern: /^<\/?[^\s>\/]+/i,
				inside: {
					'punctuation': /^<\/?/,
					'namespace': /^[^\s>\/:]+:/
				}
			},
			'attr-value': {
				pattern: /=(?:("|')(?:\\[\s\S]|(?!\1)[^\\])*\1|[^\s'">=]+)/i,
				inside: {
					'punctuation': [
						/^=/,
						{
							pattern: /(^|[^\\])["']/,
							lookbehind: true
						}
					]
				}
			},
			'punctuation': /\/?>/,
			'attr-name': {
				pattern: /[^\s>\/]+/,
				inside: {
					'namespace': /^[^\s>\/:]+:/
				}
			}

		}
	},
	'entity': /&#?[\da-z]{1,8};/i
};

Prism.languages.markup['tag'].inside['attr-value'].inside['entity'] =
	Prism.languages.markup['entity'];

// Plugin to make entity title show the real entity, idea by Roman Komarov
Prism.hooks.add('wrap', function(env) {

	if (env.type === 'entity') {
		env.attributes['title'] = env.content.replace(/&amp;/, '&');
	}
});

Prism.languages.xml = Prism.languages.markup;
Prism.languages.html = Prism.languages.markup;
Prism.languages.mathml = Prism.languages.markup;
Prism.languages.svg = Prism.languages.markup;


/* **********************************************
     Begin prism-css.js
********************************************** */

Prism.languages.css = {
	'comment': /\/\*[\s\S]*?\*\//,
	'atrule': {
		pattern: /@[\w-]+?.*?(?:;|(?=\s*\{))/i,
		inside: {
			'rule': /@[\w-]+/
			// See rest below
		}
	},
	'url': /url\((?:(["'])(?:\\(?:\r\n|[\s\S])|(?!\1)[^\\\r\n])*\1|.*?)\)/i,
	'selector': /[^{}\s][^{};]*?(?=\s*\{)/,
	'string': {
		pattern: /("|')(?:\\(?:\r\n|[\s\S])|(?!\1)[^\\\r\n])*\1/,
		greedy: true
	},
	'property': /[-_a-z\xA0-\uFFFF][-\w\xA0-\uFFFF]*(?=\s*:)/i,
	'important': /\B!important\b/i,
	'function': /[-a-z0-9]+(?=\()/i,
	'punctuation': /[(){};:]/
};

Prism.languages.css['atrule'].inside.rest = Prism.languages.css;

if (Prism.languages.markup) {
	Prism.languages.insertBefore('markup', 'tag', {
		'style': {
			pattern: /(<style[\s\S]*?>)[\s\S]*?(?=<\/style>)/i,
			lookbehind: true,
			inside: Prism.languages.css,
			alias: 'language-css',
			greedy: true
		}
	});

	Prism.languages.insertBefore('inside', 'attr-value', {
		'style-attr': {
			pattern: /\s*style=("|')(?:\\[\s\S]|(?!\1)[^\\])*\1/i,
			inside: {
				'attr-name': {
					pattern: /^\s*style/i,
					inside: Prism.languages.markup.tag.inside
				},
				'punctuation': /^\s*=\s*['"]|['"]\s*$/,
				'attr-value': {
					pattern: /.+/i,
					inside: Prism.languages.css
				}
			},
			alias: 'language-css'
		}
	}, Prism.languages.markup.tag);
}

/* **********************************************
     Begin prism-clike.js
********************************************** */

Prism.languages.clike = {
	'comment': [
		{
			pattern: /(^|[^\\])\/\*[\s\S]*?(?:\*\/|$)/,
			lookbehind: true
		},
		{
			pattern: /(^|[^\\:])\/\/.*/,
			lookbehind: true,
			greedy: true
		}
	],
	'string': {
		pattern: /(["'])(?:\\(?:\r\n|[\s\S])|(?!\1)[^\\\r\n])*\1/,
		greedy: true
	},
	'class-name': {
		pattern: /((?:\b(?:class|interface|extends|implements|trait|instanceof|new)\s+)|(?:catch\s+\())[\w.\\]+/i,
		lookbehind: true,
		inside: {
			punctuation: /[.\\]/
		}
	},
	'keyword': /\b(?:if|else|while|do|for|return|in|instanceof|function|new|try|throw|catch|finally|null|break|continue)\b/,
	'boolean': /\b(?:true|false)\b/,
	'function': /[a-z0-9_]+(?=\()/i,
	'number': /\b0x[\da-f]+\b|(?:\b\d+\.?\d*|\B\.\d+)(?:e[+-]?\d+)?/i,
	'operator': /--?|\+\+?|!=?=?|<=?|>=?|==?=?|&&?|\|\|?|\?|\*|\/|~|\^|%/,
	'punctuation': /[{}[\];(),.:]/
};


/* **********************************************
     Begin prism-javascript.js
********************************************** */

Prism.languages.javascript = Prism.languages.extend('clike', {
	'keyword': /\b(?:as|async|await|break|case|catch|class|const|continue|debugger|default|delete|do|else|enum|export|extends|finally|for|from|function|get|if|implements|import|in|instanceof|interface|let|new|null|of|package|private|protected|public|return|set|static|super|switch|this|throw|try|typeof|var|void|while|with|yield)\b/,
	'number': /\b(?:0[xX][\dA-Fa-f]+|0[bB][01]+|0[oO][0-7]+|NaN|Infinity)\b|(?:\b\d+\.?\d*|\B\.\d+)(?:[Ee][+-]?\d+)?/,
	// Allow for all non-ASCII characters (See http://stackoverflow.com/a/2008444)
	'function': /[_$a-z\xA0-\uFFFF][$\w\xA0-\uFFFF]*(?=\s*\()/i,
	'operator': /-[-=]?|\+[+=]?|!=?=?|<<?=?|>>?>?=?|=(?:==?|>)?|&[&=]?|\|[|=]?|\*\*?=?|\/=?|~|\^=?|%=?|\?|\.{3}/
});

Prism.languages.insertBefore('javascript', 'keyword', {
	'regex': {
		pattern: /((?:^|[^$\w\xA0-\uFFFF."'\])\s])\s*)\/(\[[^\]\r\n]+]|\\.|[^/\\\[\r\n])+\/[gimyu]{0,5}(?=\s*($|[\r\n,.;})\]]))/,
		lookbehind: true,
		greedy: true
	},
	// This must be declared before keyword because we use "function" inside the look-forward
	'function-variable': {
		pattern: /[_$a-z\xA0-\uFFFF][$\w\xA0-\uFFFF]*(?=\s*=\s*(?:function\b|(?:\([^()]*\)|[_$a-z\xA0-\uFFFF][$\w\xA0-\uFFFF]*)\s*=>))/i,
		alias: 'function'
	},
	'constant': /\b[A-Z][A-Z\d_]*\b/
});

Prism.languages.insertBefore('javascript', 'string', {
	'template-string': {
		pattern: /`(?:\\[\s\S]|\${[^}]+}|[^\\`])*`/,
		greedy: true,
		inside: {
			'interpolation': {
				pattern: /\${[^}]+}/,
				inside: {
					'interpolation-punctuation': {
						pattern: /^\${|}$/,
						alias: 'punctuation'
					},
					rest: null // See below
				}
			},
			'string': /[\s\S]+/
		}
	}
});
Prism.languages.javascript['template-string'].inside['interpolation'].inside.rest = Prism.languages.javascript;

if (Prism.languages.markup) {
	Prism.languages.insertBefore('markup', 'tag', {
		'script': {
			pattern: /(<script[\s\S]*?>)[\s\S]*?(?=<\/script>)/i,
			lookbehind: true,
			inside: Prism.languages.javascript,
			alias: 'language-javascript',
			greedy: true
		}
	});
}

Prism.languages.js = Prism.languages.javascript;


/* **********************************************
     Begin prism-file-highlight.js
********************************************** */

(function () {
	if (typeof self === 'undefined' || !self.Prism || !self.document || !document.querySelector) {
		return;
	}

	self.Prism.fileHighlight = function() {

		var Extensions = {
			'js': 'javascript',
			'py': 'python',
			'rb': 'ruby',
			'ps1': 'powershell',
			'psm1': 'powershell',
			'sh': 'bash',
			'bat': 'batch',
			'h': 'c',
			'tex': 'latex'
		};

		Array.prototype.slice.call(document.querySelectorAll('pre[data-src]')).forEach(function (pre) {
			var src = pre.getAttribute('data-src');

			var language, parent = pre;
			var lang = /\blang(?:uage)?-([\w-]+)\b/i;
			while (parent && !lang.test(parent.className)) {
				parent = parent.parentNode;
			}

			if (parent) {
				language = (pre.className.match(lang) || [, ''])[1];
			}

			if (!language) {
				var extension = (src.match(/\.(\w+)$/) || [, ''])[1];
				language = Extensions[extension] || extension;
			}

			var code = document.createElement('code');
			code.className = 'language-' + language;

			pre.textContent = '';

			code.textContent = 'Loading…';

			pre.appendChild(code);

			var xhr = new XMLHttpRequest();

			xhr.open('GET', src, true);

			xhr.onreadystatechange = function () {
				if (xhr.readyState == 4) {

					if (xhr.status < 400 && xhr.responseText) {
						code.textContent = xhr.responseText;

						Prism.highlightElement(code);
					}
					else if (xhr.status >= 400) {
						code.textContent = '✖ Error ' + xhr.status + ' while fetching file: ' + xhr.statusText;
					}
					else {
						code.textContent = '✖ Error: File does not exist or is empty';
					}
				}
			};

			xhr.send(null);
		});

		if (Prism.plugins.toolbar) {
			Prism.plugins.toolbar.registerButton('download-file', function (env) {
				var pre = env.element.parentNode;
				if (!pre || !/pre/i.test(pre.nodeName) || !pre.hasAttribute('data-src') || !pre.hasAttribute('data-download-link')) {
					return;
				}
				var src = pre.getAttribute('data-src');
				var a = document.createElement('a');
				a.textContent = pre.getAttribute('data-download-link-label') || 'Download';
				a.setAttribute('download', '');
				a.href = src;
				return a;
			});
		}

	};

	document.addEventListener('DOMContentLoaded', self.Prism.fileHighlight);

})();
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(12)))

/***/ }),
/* 634 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(635);
if(typeof content === 'string') content = [[module.i, content, '']];
// Prepare cssTransformation
var transform;

var options = {}
options.transform = transform
// add the styles to the DOM
var update = __webpack_require__(70)(content, options);
if(content.locals) module.exports = content.locals;
// Hot Module Replacement
if(false) {
	// When the styles change, update the <style> tags
	if(!content.locals) {
		module.hot.accept("!!../../../../../node_modules/css-loader/index.js!./prism-okaidia.css", function() {
			var newContent = require("!!../../../../../node_modules/css-loader/index.js!./prism-okaidia.css");
			if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
			update(newContent);
		});
	}
	// When the module is disposed, remove the <style> tags
	module.hot.dispose(function() { update(); });
}

/***/ }),
/* 635 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(38)(false);
// imports


// module
exports.push([module.i, "/**\n * okaidia theme for JavaScript, CSS and HTML\n * Loosely based on Monokai textmate theme by http://www.monokai.nl/\n * @author ocodia\n */\n\ncode[class*=\"language-\"],\npre[class*=\"language-\"] {\n\tcolor: #f8f8f2;\n\tbackground: none;\n\ttext-shadow: 0 1px rgba(0, 0, 0, 0.3);\n\tfont-family: Consolas, Monaco, 'Andale Mono', 'Ubuntu Mono', monospace;\n\ttext-align: left;\n\twhite-space: pre;\n\tword-spacing: normal;\n\tword-break: normal;\n\tword-wrap: normal;\n\tline-height: 1.5;\n\n\t-moz-tab-size: 4;\n\t-o-tab-size: 4;\n\ttab-size: 4;\n\n\t-webkit-hyphens: none;\n\t-moz-hyphens: none;\n\t-ms-hyphens: none;\n\thyphens: none;\n}\n\n/* Code blocks */\npre[class*=\"language-\"] {\n\tpadding: 1em;\n\tmargin: .5em 0;\n\toverflow: auto;\n\tborder-radius: 0.3em;\n}\n\n:not(pre) > code[class*=\"language-\"],\npre[class*=\"language-\"] {\n\tbackground: #272822;\n}\n\n/* Inline code */\n:not(pre) > code[class*=\"language-\"] {\n\tpadding: .1em;\n\tborder-radius: .3em;\n\twhite-space: normal;\n}\n\n.token.comment,\n.token.prolog,\n.token.doctype,\n.token.cdata {\n\tcolor: slategray;\n}\n\n.token.punctuation {\n\tcolor: #f8f8f2;\n}\n\n.namespace {\n\topacity: .7;\n}\n\n.token.property,\n.token.tag,\n.token.constant,\n.token.symbol,\n.token.deleted {\n\tcolor: #f92672;\n}\n\n.token.boolean,\n.token.number {\n\tcolor: #ae81ff;\n}\n\n.token.selector,\n.token.attr-name,\n.token.string,\n.token.char,\n.token.builtin,\n.token.inserted {\n\tcolor: #a6e22e;\n}\n\n.token.operator,\n.token.entity,\n.token.url,\n.language-css .token.string,\n.style .token.string,\n.token.variable {\n\tcolor: #f8f8f2;\n}\n\n.token.atrule,\n.token.attr-value,\n.token.function,\n.token.class-name {\n\tcolor: #e6db74;\n}\n\n.token.keyword {\n\tcolor: #66d9ef;\n}\n\n.token.regex,\n.token.important {\n\tcolor: #fd971f;\n}\n\n.token.important,\n.token.bold {\n\tfont-weight: bold;\n}\n.token.italic {\n\tfont-style: italic;\n}\n\n.token.entity {\n\tcursor: help;\n}\n", ""]);

// exports


/***/ }),
/* 636 */
/***/ (function(module, exports) {

Prism.languages.clike={comment:[{pattern:/(^|[^\\])\/\*[\s\S]*?(?:\*\/|$)/,lookbehind:!0},{pattern:/(^|[^\\:])\/\/.*/,lookbehind:!0,greedy:!0}],string:{pattern:/(["'])(?:\\(?:\r\n|[\s\S])|(?!\1)[^\\\r\n])*\1/,greedy:!0},"class-name":{pattern:/((?:\b(?:class|interface|extends|implements|trait|instanceof|new)\s+)|(?:catch\s+\())[\w.\\]+/i,lookbehind:!0,inside:{punctuation:/[.\\]/}},keyword:/\b(?:if|else|while|do|for|return|in|instanceof|function|new|try|throw|catch|finally|null|break|continue)\b/,"boolean":/\b(?:true|false)\b/,"function":/[a-z0-9_]+(?=\()/i,number:/\b0x[\da-f]+\b|(?:\b\d+\.?\d*|\B\.\d+)(?:e[+-]?\d+)?/i,operator:/--?|\+\+?|!=?=?|<=?|>=?|==?=?|&&?|\|\|?|\?|\*|\/|~|\^|%/,punctuation:/[{}[\];(),.:]/};

/***/ }),
/* 637 */
/***/ (function(module, exports) {

Prism.languages["markup-templating"]={},Object.defineProperties(Prism.languages["markup-templating"],{buildPlaceholders:{value:function(e,t,n,a){e.language===t&&(e.tokenStack=[],e.code=e.code.replace(n,function(n){if("function"==typeof a&&!a(n))return n;for(var r=e.tokenStack.length;-1!==e.code.indexOf("___"+t.toUpperCase()+r+"___");)++r;return e.tokenStack[r]=n,"___"+t.toUpperCase()+r+"___"}),e.grammar=Prism.languages.markup)}},tokenizePlaceholders:{value:function(e,t){if(e.language===t&&e.tokenStack){e.grammar=Prism.languages[t];var n=0,a=Object.keys(e.tokenStack),r=function(o){if(!(n>=a.length))for(var i=0;i<o.length;i++){var g=o[i];if("string"==typeof g||g.content&&"string"==typeof g.content){var c=a[n],s=e.tokenStack[c],l="string"==typeof g?g:g.content,p=l.indexOf("___"+t.toUpperCase()+c+"___");if(p>-1){++n;var f,u=l.substring(0,p),_=new Prism.Token(t,Prism.tokenize(s,e.grammar,t),"language-"+t,s),k=l.substring(p+("___"+t.toUpperCase()+c+"___").length);if(u||k?(f=[u,_,k].filter(function(e){return!!e}),r(f)):f=_,"string"==typeof g?Array.prototype.splice.apply(o,[i,1].concat(f)):g.content=f,n>=a.length)break}}else g.content&&"string"!=typeof g.content&&r(g.content)}};r(e.tokens)}}}});

/***/ }),
/* 638 */
/***/ (function(module, exports) {

!function(e){e.languages.php=e.languages.extend("clike",{keyword:/\b(?:and|or|xor|array|as|break|case|cfunction|class|const|continue|declare|default|die|do|else|elseif|enddeclare|endfor|endforeach|endif|endswitch|endwhile|extends|for|foreach|function|include|include_once|global|if|new|return|static|switch|use|require|require_once|var|while|abstract|interface|public|implements|private|protected|parent|throw|null|echo|print|trait|namespace|final|yield|goto|instanceof|finally|try|catch)\b/i,constant:/\b[A-Z0-9_]{2,}\b/,comment:{pattern:/(^|[^\\])(?:\/\*[\s\S]*?\*\/|\/\/.*)/,lookbehind:!0}}),e.languages.insertBefore("php","string",{"shell-comment":{pattern:/(^|[^\\])#.*/,lookbehind:!0,alias:"comment"}}),e.languages.insertBefore("php","keyword",{delimiter:{pattern:/\?>|<\?(?:php|=)?/i,alias:"important"},variable:/\$+(?:\w+\b|(?={))/i,"package":{pattern:/(\\|namespace\s+|use\s+)[\w\\]+/,lookbehind:!0,inside:{punctuation:/\\/}}}),e.languages.insertBefore("php","operator",{property:{pattern:/(->)[\w]+/,lookbehind:!0}}),e.languages.insertBefore("php","string",{"nowdoc-string":{pattern:/<<<'([^']+)'(?:\r\n?|\n)(?:.*(?:\r\n?|\n))*?\1;/,greedy:!0,alias:"string",inside:{delimiter:{pattern:/^<<<'[^']+'|[a-z_]\w*;$/i,alias:"symbol",inside:{punctuation:/^<<<'?|[';]$/}}}},"heredoc-string":{pattern:/<<<(?:"([^"]+)"(?:\r\n?|\n)(?:.*(?:\r\n?|\n))*?\1;|([a-z_]\w*)(?:\r\n?|\n)(?:.*(?:\r\n?|\n))*?\2;)/i,greedy:!0,alias:"string",inside:{delimiter:{pattern:/^<<<(?:"[^"]+"|[a-z_]\w*)|[a-z_]\w*;$/i,alias:"symbol",inside:{punctuation:/^<<<"?|[";]$/}},interpolation:null}},"single-quoted-string":{pattern:/'(?:\\[\s\S]|[^\\'])*'/,greedy:!0,alias:"string"},"double-quoted-string":{pattern:/"(?:\\[\s\S]|[^\\"])*"/,greedy:!0,alias:"string",inside:{interpolation:null}}}),delete e.languages.php.string;var n={pattern:/{\$(?:{(?:{[^{}]+}|[^{}]+)}|[^{}])+}|(^|[^\\{])\$+(?:\w+(?:\[.+?]|->\w+)*)/,lookbehind:!0,inside:{rest:e.languages.php}};e.languages.php["heredoc-string"].inside.interpolation=n,e.languages.php["double-quoted-string"].inside.interpolation=n,e.hooks.add("before-tokenize",function(n){if(/(?:<\?php|<\?)/gi.test(n.code)){var i=/(?:<\?php|<\?)[\s\S]*?(?:\?>|$)/gi;e.languages["markup-templating"].buildPlaceholders(n,"php",i)}}),e.hooks.add("after-tokenize",function(n){e.languages["markup-templating"].tokenizePlaceholders(n,"php")})}(Prism);

/***/ }),
/* 639 */
/***/ (function(module, exports) {

Prism.languages.ini={comment:/^[ \t]*;.*$/m,selector:/^[ \t]*\[.*?\]/m,constant:/^[ \t]*[^\s=]+?(?=[ \t]*=)/m,"attr-value":{pattern:/=.*/,inside:{punctuation:/^[=]/}}};

/***/ }),
/* 640 */
/***/ (function(module, exports) {

Prism.languages.javascript=Prism.languages.extend("clike",{keyword:/\b(?:as|async|await|break|case|catch|class|const|continue|debugger|default|delete|do|else|enum|export|extends|finally|for|from|function|get|if|implements|import|in|instanceof|interface|let|new|null|of|package|private|protected|public|return|set|static|super|switch|this|throw|try|typeof|var|void|while|with|yield)\b/,number:/\b(?:0[xX][\dA-Fa-f]+|0[bB][01]+|0[oO][0-7]+|NaN|Infinity)\b|(?:\b\d+\.?\d*|\B\.\d+)(?:[Ee][+-]?\d+)?/,"function":/[_$a-z\xA0-\uFFFF][$\w\xA0-\uFFFF]*(?=\s*\()/i,operator:/-[-=]?|\+[+=]?|!=?=?|<<?=?|>>?>?=?|=(?:==?|>)?|&[&=]?|\|[|=]?|\*\*?=?|\/=?|~|\^=?|%=?|\?|\.{3}/}),Prism.languages.insertBefore("javascript","keyword",{regex:{pattern:/((?:^|[^$\w\xA0-\uFFFF."'\])\s])\s*)\/(\[[^\]\r\n]+]|\\.|[^\/\\\[\r\n])+\/[gimyu]{0,5}(?=\s*($|[\r\n,.;})\]]))/,lookbehind:!0,greedy:!0},"function-variable":{pattern:/[_$a-z\xA0-\uFFFF][$\w\xA0-\uFFFF]*(?=\s*=\s*(?:function\b|(?:\([^()]*\)|[_$a-z\xA0-\uFFFF][$\w\xA0-\uFFFF]*)\s*=>))/i,alias:"function"},constant:/\b[A-Z][A-Z\d_]*\b/}),Prism.languages.insertBefore("javascript","string",{"template-string":{pattern:/`(?:\\[\s\S]|\${[^}]+}|[^\\`])*`/,greedy:!0,inside:{interpolation:{pattern:/\${[^}]+}/,inside:{"interpolation-punctuation":{pattern:/^\${|}$/,alias:"punctuation"},rest:null}},string:/[\s\S]+/}}}),Prism.languages.javascript["template-string"].inside.interpolation.inside.rest=Prism.languages.javascript,Prism.languages.markup&&Prism.languages.insertBefore("markup","tag",{script:{pattern:/(<script[\s\S]*?>)[\s\S]*?(?=<\/script>)/i,lookbehind:!0,inside:Prism.languages.javascript,alias:"language-javascript",greedy:!0}}),Prism.languages.js=Prism.languages.javascript;

/***/ }),
/* 641 */
/***/ (function(module, exports) {

!function(e){var t={variable:[{pattern:/\$?\(\([\s\S]+?\)\)/,inside:{variable:[{pattern:/(^\$\(\([\s\S]+)\)\)/,lookbehind:!0},/^\$\(\(/],number:/\b0x[\dA-Fa-f]+\b|(?:\b\d+\.?\d*|\B\.\d+)(?:[Ee]-?\d+)?/,operator:/--?|-=|\+\+?|\+=|!=?|~|\*\*?|\*=|\/=?|%=?|<<=?|>>=?|<=?|>=?|==?|&&?|&=|\^=?|\|\|?|\|=|\?|:/,punctuation:/\(\(?|\)\)?|,|;/}},{pattern:/\$\([^)]+\)|`[^`]+`/,greedy:!0,inside:{variable:/^\$\(|^`|\)$|`$/}},/\$(?:[\w#?*!@]+|\{[^}]+\})/i]};e.languages.bash={shebang:{pattern:/^#!\s*\/bin\/bash|^#!\s*\/bin\/sh/,alias:"important"},comment:{pattern:/(^|[^"{\\])#.*/,lookbehind:!0},string:[{pattern:/((?:^|[^<])<<\s*)["']?(\w+?)["']?\s*\r?\n(?:[\s\S])*?\r?\n\2/,lookbehind:!0,greedy:!0,inside:t},{pattern:/(["'])(?:\\[\s\S]|\$\([^)]+\)|`[^`]+`|(?!\1)[^\\])*\1/,greedy:!0,inside:t}],variable:t.variable,"function":{pattern:/(^|[\s;|&])(?:alias|apropos|apt-get|aptitude|aspell|awk|basename|bash|bc|bg|builtin|bzip2|cal|cat|cd|cfdisk|chgrp|chmod|chown|chroot|chkconfig|cksum|clear|cmp|comm|command|cp|cron|crontab|csplit|curl|cut|date|dc|dd|ddrescue|df|diff|diff3|dig|dir|dircolors|dirname|dirs|dmesg|du|egrep|eject|enable|env|ethtool|eval|exec|expand|expect|export|expr|fdformat|fdisk|fg|fgrep|file|find|fmt|fold|format|free|fsck|ftp|fuser|gawk|getopts|git|grep|groupadd|groupdel|groupmod|groups|gzip|hash|head|help|hg|history|hostname|htop|iconv|id|ifconfig|ifdown|ifup|import|install|jobs|join|kill|killall|less|link|ln|locate|logname|logout|look|lpc|lpr|lprint|lprintd|lprintq|lprm|ls|lsof|make|man|mkdir|mkfifo|mkisofs|mknod|more|most|mount|mtools|mtr|mv|mmv|nano|netstat|nice|nl|nohup|notify-send|npm|nslookup|open|op|passwd|paste|pathchk|ping|pkill|popd|pr|printcap|printenv|printf|ps|pushd|pv|pwd|quota|quotacheck|quotactl|ram|rar|rcp|read|readarray|readonly|reboot|rename|renice|remsync|rev|rm|rmdir|rsync|screen|scp|sdiff|sed|seq|service|sftp|shift|shopt|shutdown|sleep|slocate|sort|source|split|ssh|stat|strace|su|sudo|sum|suspend|sync|tail|tar|tee|test|time|timeout|times|touch|top|traceroute|trap|tr|tsort|tty|type|ulimit|umask|umount|unalias|uname|unexpand|uniq|units|unrar|unshar|uptime|useradd|userdel|usermod|users|uuencode|uudecode|v|vdir|vi|vmstat|wait|watch|wc|wget|whereis|which|who|whoami|write|xargs|xdg-open|yes|zip)(?=$|[\s;|&])/,lookbehind:!0},keyword:{pattern:/(^|[\s;|&])(?:let|:|\.|if|then|else|elif|fi|for|break|continue|while|in|case|function|select|do|done|until|echo|exit|return|set|declare)(?=$|[\s;|&])/,lookbehind:!0},"boolean":{pattern:/(^|[\s;|&])(?:true|false)(?=$|[\s;|&])/,lookbehind:!0},operator:/&&?|\|\|?|==?|!=?|<<<?|>>|<=?|>=?|=~/,punctuation:/\$?\(\(?|\)\)?|\.\.|[{}[\];]/};var a=t.variable[1].inside;a.string=e.languages.bash.string,a["function"]=e.languages.bash["function"],a.keyword=e.languages.bash.keyword,a["boolean"]=e.languages.bash["boolean"],a.operator=e.languages.bash.operator,a.punctuation=e.languages.bash.punctuation,e.languages.shell=e.languages.bash}(Prism);

/***/ }),
/* 642 */
/***/ (function(module, exports) {

(function() {

var assign = Object.assign || function (obj1, obj2) {
	for (var name in obj2) {
		if (obj2.hasOwnProperty(name))
			obj1[name] = obj2[name];
	}
	return obj1;
}

function NormalizeWhitespace(defaults) {
	this.defaults = assign({}, defaults);
}

function toCamelCase(value) {
	return value.replace(/-(\w)/g, function(match, firstChar) {
		return firstChar.toUpperCase();
	});
}

function tabLen(str) {
	var res = 0;
	for (var i = 0; i < str.length; ++i) {
		if (str.charCodeAt(i) == '\t'.charCodeAt(0))
			res += 3;
	}
	return str.length + res;
}

NormalizeWhitespace.prototype = {
	setDefaults: function (defaults) {
		this.defaults = assign(this.defaults, defaults);
	},
	normalize: function (input, settings) {
		settings = assign(this.defaults, settings);

		for (var name in settings) {
			var methodName = toCamelCase(name);
			if (name !== "normalize" && methodName !== 'setDefaults' &&
					settings[name] && this[methodName]) {
				input = this[methodName].call(this, input, settings[name]);
			}
		}

		return input;
	},

	/*
	 * Normalization methods
	 */
	leftTrim: function (input) {
		return input.replace(/^\s+/, '');
	},
	rightTrim: function (input) {
		return input.replace(/\s+$/, '');
	},
	tabsToSpaces: function (input, spaces) {
		spaces = spaces|0 || 4;
		return input.replace(/\t/g, new Array(++spaces).join(' '));
	},
	spacesToTabs: function (input, spaces) {
		spaces = spaces|0 || 4;
		return input.replace(new RegExp(' {' + spaces + '}', 'g'), '\t');
	},
	removeTrailing: function (input) {
		return input.replace(/\s*?$/gm, '');
	},
	// Support for deprecated plugin remove-initial-line-feed
	removeInitialLineFeed: function (input) {
		return input.replace(/^(?:\r?\n|\r)/, '');
	},
	removeIndent: function (input) {
		var indents = input.match(/^[^\S\n\r]*(?=\S)/gm);

		if (!indents || !indents[0].length)
			return input;

		indents.sort(function(a, b){return a.length - b.length; });

		if (!indents[0].length)
			return input;

		return input.replace(new RegExp('^' + indents[0], 'gm'), '');
	},
	indent: function (input, tabs) {
		return input.replace(/^[^\S\n\r]*(?=\S)/gm, new Array(++tabs).join('\t') + '$&');
	},
	breakLines: function (input, characters) {
		characters = (characters === true) ? 80 : characters|0 || 80;

		var lines = input.split('\n');
		for (var i = 0; i < lines.length; ++i) {
			if (tabLen(lines[i]) <= characters)
				continue;

			var line = lines[i].split(/(\s+)/g),
			    len = 0;

			for (var j = 0; j < line.length; ++j) {
				var tl = tabLen(line[j]);
				len += tl;
				if (len > characters) {
					line[j] = '\n' + line[j];
					len = tl;
				}
			}
			lines[i] = line.join('');
		}
		return lines.join('\n');
	}
};

// Support node modules
if (typeof module !== 'undefined' && module.exports) {
	module.exports = NormalizeWhitespace;
}

// Exit if prism is not loaded
if (typeof Prism === 'undefined') {
	return;
}

Prism.plugins.NormalizeWhitespace = new NormalizeWhitespace({
	'remove-trailing': true,
	'remove-indent': true,
	'left-trim': true,
	'right-trim': true,
	/*'break-lines': 80,
	'indent': 2,
	'remove-initial-line-feed': false,
	'tabs-to-spaces': 4,
	'spaces-to-tabs': 4*/
});

Prism.hooks.add('before-sanity-check', function (env) {
	var Normalizer = Prism.plugins.NormalizeWhitespace;

	// Check settings
	if (env.settings && env.settings['whitespace-normalization'] === false) {
		return;
	}

	// Simple mode if there is no env.element
	if ((!env.element || !env.element.parentNode) && env.code) {
		env.code = Normalizer.normalize(env.code, env.settings);
		return;
	}

	// Normal mode
	var pre = env.element.parentNode;
	var clsReg = /\bno-whitespace-normalization\b/;
	if (!env.code || !pre || pre.nodeName.toLowerCase() !== 'pre' ||
			clsReg.test(pre.className) || clsReg.test(env.element.className))
		return;

	var children = pre.childNodes,
	    before = '',
	    after = '',
	    codeFound = false;

	// Move surrounding whitespace from the <pre> tag into the <code> tag
	for (var i = 0; i < children.length; ++i) {
		var node = children[i];

		if (node == env.element) {
			codeFound = true;
		} else if (node.nodeName === "#text") {
			if (codeFound) {
				after += node.nodeValue;
			} else {
				before += node.nodeValue;
			}

			pre.removeChild(node);
			--i;
		}
	}

	if (!env.element.children.length || !Prism.plugins.KeepMarkup) {
		env.code = before + env.code + after;
		env.code = Normalizer.normalize(env.code, env.settings);
	} else {
		// Preserve markup for keep-markup plugin
		var html = before + env.element.innerHTML + after;
		env.element.innerHTML = Normalizer.normalize(html, env.settings);
		env.code = env.element.textContent;
	}
});

}());

/***/ }),
/* 643 */
/***/ (function(module, exports) {

(function () {

	if (typeof self === 'undefined' || !self.Prism || !self.document) {
		return;
	}

	/**
	 * Plugin name which is used as a class name for <pre> which is activating the plugin
	 * @type {String}
	 */
	var PLUGIN_NAME = 'line-numbers';
	
	/**
	 * Regular expression used for determining line breaks
	 * @type {RegExp}
	 */
	var NEW_LINE_EXP = /\n(?!$)/g;

	/**
	 * Resizes line numbers spans according to height of line of code
	 * @param {Element} element <pre> element
	 */
	var _resizeElement = function (element) {
		var codeStyles = getStyles(element);
		var whiteSpace = codeStyles['white-space'];

		if (whiteSpace === 'pre-wrap' || whiteSpace === 'pre-line') {
			var codeElement = element.querySelector('code');
			var lineNumbersWrapper = element.querySelector('.line-numbers-rows');
			var lineNumberSizer = element.querySelector('.line-numbers-sizer');
			var codeLines = codeElement.textContent.split(NEW_LINE_EXP);

			if (!lineNumberSizer) {
				lineNumberSizer = document.createElement('span');
				lineNumberSizer.className = 'line-numbers-sizer';

				codeElement.appendChild(lineNumberSizer);
			}

			lineNumberSizer.style.display = 'block';

			codeLines.forEach(function (line, lineNumber) {
				lineNumberSizer.textContent = line || '\n';
				var lineSize = lineNumberSizer.getBoundingClientRect().height;
				lineNumbersWrapper.children[lineNumber].style.height = lineSize + 'px';
			});

			lineNumberSizer.textContent = '';
			lineNumberSizer.style.display = 'none';
		}
	};

	/**
	 * Returns style declarations for the element
	 * @param {Element} element
	 */
	var getStyles = function (element) {
		if (!element) {
			return null;
		}

		return window.getComputedStyle ? getComputedStyle(element) : (element.currentStyle || null);
	};

	window.addEventListener('resize', function () {
		Array.prototype.forEach.call(document.querySelectorAll('pre.' + PLUGIN_NAME), _resizeElement);
	});

	Prism.hooks.add('complete', function (env) {
		if (!env.code) {
			return;
		}

		// works only for <code> wrapped inside <pre> (not inline)
		var pre = env.element.parentNode;
		var clsReg = /\s*\bline-numbers\b\s*/;
		if (
			!pre || !/pre/i.test(pre.nodeName) ||
			// Abort only if nor the <pre> nor the <code> have the class
			(!clsReg.test(pre.className) && !clsReg.test(env.element.className))
		) {
			return;
		}

		if (env.element.querySelector('.line-numbers-rows')) {
			// Abort if line numbers already exists
			return;
		}

		if (clsReg.test(env.element.className)) {
			// Remove the class 'line-numbers' from the <code>
			env.element.className = env.element.className.replace(clsReg, ' ');
		}
		if (!clsReg.test(pre.className)) {
			// Add the class 'line-numbers' to the <pre>
			pre.className += ' line-numbers';
		}

		var match = env.code.match(NEW_LINE_EXP);
		var linesNum = match ? match.length + 1 : 1;
		var lineNumbersWrapper;

		var lines = new Array(linesNum + 1);
		lines = lines.join('<span></span>');

		lineNumbersWrapper = document.createElement('span');
		lineNumbersWrapper.setAttribute('aria-hidden', 'true');
		lineNumbersWrapper.className = 'line-numbers-rows';
		lineNumbersWrapper.innerHTML = lines;

		if (pre.hasAttribute('data-start')) {
			pre.style.counterReset = 'linenumber ' + (parseInt(pre.getAttribute('data-start'), 10) - 1);
		}

		env.element.appendChild(lineNumbersWrapper);

		_resizeElement(pre);

		Prism.hooks.run('line-numbers', env);
	});

	Prism.hooks.add('line-numbers', function (env) {
		env.plugins = env.plugins || {};
		env.plugins.lineNumbers = true;
	});
	
	/**
	 * Global exports
	 */
	Prism.plugins.lineNumbers = {
		/**
		 * Get node for provided line number
		 * @param {Element} element pre element
		 * @param {Number} number line number
		 * @return {Element|undefined}
		 */
		getLine: function (element, number) {
			if (element.tagName !== 'PRE' || !element.classList.contains(PLUGIN_NAME)) {
				return;
			}

			var lineNumberRows = element.querySelector('.line-numbers-rows');
			var lineNumberStart = parseInt(element.getAttribute('data-start'), 10) || 1;
			var lineNumberEnd = lineNumberStart + (lineNumberRows.children.length - 1);

			if (number < lineNumberStart) {
				number = lineNumberStart;
			}
			if (number > lineNumberEnd) {
				number = lineNumberEnd;
			}

			var lineIndex = number - lineNumberStart;

			return lineNumberRows.children[lineIndex];
		}
	};

}());

/***/ }),
/* 644 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(645);
if(typeof content === 'string') content = [[module.i, content, '']];
// Prepare cssTransformation
var transform;

var options = {}
options.transform = transform
// add the styles to the DOM
var update = __webpack_require__(70)(content, options);
if(content.locals) module.exports = content.locals;
// Hot Module Replacement
if(false) {
	// When the styles change, update the <style> tags
	if(!content.locals) {
		module.hot.accept("!!../../../../../../node_modules/css-loader/index.js!./prism-line-numbers.css", function() {
			var newContent = require("!!../../../../../../node_modules/css-loader/index.js!./prism-line-numbers.css");
			if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
			update(newContent);
		});
	}
	// When the module is disposed, remove the <style> tags
	module.hot.dispose(function() { update(); });
}

/***/ }),
/* 645 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(38)(false);
// imports


// module
exports.push([module.i, "pre[class*=\"language-\"].line-numbers {\n\tposition: relative;\n\tpadding-left: 3.8em;\n\tcounter-reset: linenumber;\n}\n\npre[class*=\"language-\"].line-numbers > code {\n\tposition: relative;\n\twhite-space: inherit;\n}\n\n.line-numbers .line-numbers-rows {\n\tposition: absolute;\n\tpointer-events: none;\n\ttop: 0;\n\tfont-size: 100%;\n\tleft: -3.8em;\n\twidth: 3em; /* works for line-numbers below 1000 lines */\n\tletter-spacing: -1px;\n\tborder-right: 1px solid #999;\n\n\t-webkit-user-select: none;\n\t-moz-user-select: none;\n\t-ms-user-select: none;\n\tuser-select: none;\n\n}\n\n\t.line-numbers-rows > span {\n\t\tpointer-events: none;\n\t\tdisplay: block;\n\t\tcounter-increment: linenumber;\n\t}\n\n\t\t.line-numbers-rows > span:before {\n\t\t\tcontent: counter(linenumber);\n\t\t\tcolor: #999;\n\t\t\tdisplay: block;\n\t\t\tpadding-right: 0.8em;\n\t\t\ttext-align: right;\n\t\t}\n", ""]);

// exports


/***/ })
/******/ ]);