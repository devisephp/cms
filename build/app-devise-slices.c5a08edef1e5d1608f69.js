webpackJsonp([7],{"0lwT":function(t,e,n){var i,o,r;o=this,r=function(t,e){"use strict";var n=t.document&&t.self===t.document.defaultView?t:window,i=n.document,o=i.documentElement,r=i.body;if(!r)throw Error("Mezr needs access to body element.");var s,a=Math.abs,c=Math.max,l=Math.min,d={content:1,padding:2,scroll:3,border:4,margin:5},u=["inline","table-column","table-column-group"],f={};function h(t,e){return k("width",t,(e=e&&d[e]||4)>1,e>2,e>3,e>4)}function p(t,e){return k("height",t,(e=e&&d[e]||4)>1,e>2,e>3,e>4)}function v(t,e){var r,s,a,c,l;if(t===i)return null;if(t===n)return i;var d=e||y(t,"position");if("relative"===d)return t;if("fixed"===d||"absolute"===d){if("fixed"===d&&f.transformLeaksFixed)return n;if(r=t===o?i:t.parentElement||null,"fixed"===d){for(;r&&r!==i&&!g(r);)r=r.parentElement||i;return r===i?n:r}for(;r&&r!==i&&"static"===y(r,"position")&&!g(r);)r=r.parentElement||i;return r}if("sticky"===d||"-webkit-sticky"===d){for(s=["overflow","overflow-y","overflow-x"],a=t.parentNode,t=null;!t&&a&&a!==i;){for(l=0;l<3;l++)if("auto"===(c=y(a,s[l]))||"scroll"===c){t=a;break}t||(a=a.parentNode)}return t||n}return null}function m(t){return"object"==typeof t&&"[object Object]"===Object.prototype.toString.call(t)}function g(t){var e=y(t,f.transform.styleName),n=y(t,"display");return"none"!==e&&"inline"!==n&&"none"!==n}function b(t){return parseFloat(t)||0}function y(t,e){return n.getComputedStyle(t,null).getPropertyValue(e)}function _(t,e){return b(y(t,e))}function w(t,e){Object.keys(e).forEach(function(n){t.style[n]=e[n]})}function S(t,e){var n=M(t),i=M(e);return{left:n.left-i.left,right:i.left+i.width-(n.left+n.width),top:n.top-i.top,bottom:i.top+i.height-(n.top+n.height)}}function O(t,e){var n={},i=M(t),o=S(i,M(e)),r=c(i.width+l(o.left,0)+l(o.right,0),0),s=c(i.height+l(o.top,0)+l(o.bottom,0),0),d=r>0&&s>0;return d&&(n.width=r,n.height=s,n.left=i.left+a(l(o.left,0)),n.top=i.top+a(l(o.top,0)),n.right=n.left+n.width,n.bottom=n.top+n.height),d?n:null}function x(t,e,n,i){return Math.sqrt(Math.pow(n-t,2)+Math.pow(i-e,2))}function k(t,a,l,d,f,h){var p,v,m,g,b,w,S,O="height"===t,x=O?"Height":"Width",k="inner"+x,E="client"+x,M="scroll"+x,C=0;return a.self===n.self?p=d?n[k]:o[E]:a===i?d?(C=n[k]-o[E],p=c(o[M]+C,r[M]+C,n[k])):p=c(o[M],r[M],o[E]):(v=O?"top":"left",m=O?"bottom":"right",p=(s||a.getBoundingClientRect())[t],d||(a===o?C=n[k]-o[E]:u.indexOf(y(a,"display"))<0&&(g=_(a,"border-"+v+"-width"),b=_(a,"border-"+m+"-width"),C=Math.round(p)-(a[E]+g+b)),p-=C>0?C:0),l||(p-=_(a,"padding-"+v),p-=_(a,"padding-"+m)),f||(p-=g!==e?g:_(a,"border-"+v+"-width"),p-=b!==e?b:_(a,"border-"+m+"-width")),h&&(w=_(a,"margin-"+v),S=_(a,"margin-"+m),p+=w>0?w:0,p+=S>0?S:0)),p>0?p:0}function E(t,e){var o={left:0,top:0};if(t===i)return o;if(o.left=n.pageXOffset||0,o.top=n.pageYOffset||0,t.self===n.self)return o;var r=s||t.getBoundingClientRect();if(o.left+=r.left,o.top+=r.top,5===(e=e&&d[e]||4)){var a=_(t,"margin-left"),c=_(t,"margin-top");o.left-=a>0?a:0,o.top-=c>0?c:0}return e<4&&(o.left+=_(t,"border-left-width"),o.top+=_(t,"border-top-width")),1===e&&(o.left+=_(t,"padding-left"),o.top+=_(t,"padding-top")),o}function M(t,e){return t?m(t)?t:C((t=[].concat(t))[0],t[1],e):null}function C(t,e,o){var r,c=t!==i&&t.self!==n.self;return e=e||"border",o&&(r=function(t,e){if(e=e||"border",t===n||t===i)return E(t,e);var o=y(t,"position"),r="absolute"===o||"fixed"===o?E(v(t)||i,"padding"):E(t,e);if("relative"===o){var s=y(t,"left"),c=y(t,"right"),u=y(t,"top"),f=y(t,"bottom");"auto"===s&&"auto"===c||(r.left-="auto"===s?-b(c):b(s)),"auto"===u&&"auto"===f||(r.top-="auto"===u?-b(f):b(u))}else if("absolute"===o||"fixed"===o){e=d[e];var h=_(t,"margin-left"),p=_(t,"margin-top");5===e&&(r.left-=a(l(h,0)),r.top-=a(l(p,0))),e<5&&(r.left+=h,r.top+=p),e<4&&(r.left+=_(t,"border-left-width"),r.top+=_(t,"border-top-width")),1===e&&(r.left+=_(t,"padding-left"),r.top+=_(t,"padding-top"))}return r}(t,e)),c&&(s=t.getBoundingClientRect()),o||(r=E(t,e)),r.width=h(t,e),r.height=p(t,e),r.bottom=r.top+r.height,r.right=r.left+r.width,c&&(s=null),r}function R(t,e,n,i,o,r,s){var a=t.charAt(0)+e.charAt(0),c=i+s-r;return"ll"===a||"tt"===a?c:"lc"===a||"tc"===a?c+n/2:"lr"===a||"tb"===a?c+n:"cl"===a||"ct"===a?c-o/2:"cr"===a||"cb"===a?c+n-o/2:"rl"===a||"bt"===a?c-o:"rc"===a||"bc"===a?c-o+n/2:"rr"===a||"bb"===a?c-o+n:c+n/2-o/2}function $(t,e,n){var i=0,o=n?"top":"left",r=n?"bottom":"right",s=t[o],c=t[r],l=e[o],d=e[r],u=l+d;return"push"!==s&&"forcepush"!==s||"push"!==c&&"forcepush"!==c||!(l<0||d<0)?("forcepush"===s||"push"===s)&&l<0?i-=l:("forcepush"===c||"push"===c)&&d<0&&(i+=d):(l<d&&(i-=u<0?l+a(u/2):l),d<l&&(i+=u<0?d+a(u/2):d),l+=i,d-=i,"forcepush"===s&&"forcepush"!==c&&l<0&&(i-=l),"forcepush"===c&&"forcepush"!==s&&d<0&&(i+=d)),i}return f.placeDefaultOptions={element:null,target:null,position:"left top left top",offsetX:0,offsetY:0,contain:null,adjust:null},f.transform=function(){for(var t=["transform","WebkitTransform","MozTransform","OTransform","msTransform"],n=0;n<t.length;n++)if(o.style[t[n]]!==e){var i=t[n],r=i.toLowerCase().split("transform")[0];return{prefix:r,propName:i,styleName:r?"-"+r+"-transform":i}}return null}(),f.transformLeaksFixed=function(){if(!f.transform)return!0;var t,e,n=i.createElement("div"),o=i.createElement("div");return w(n,{display:"block",visibility:"hidden",position:"absolute",width:"1px",height:"1px",left:"1px",top:"0",margin:"0"}),w(o,{display:"block",position:"fixed",width:"1px",height:"1px",left:"0",top:"0",margin:"0"}),n.appendChild(o),r.appendChild(n),t=o.getBoundingClientRect().left,n.style[f.transform.propName]="translateX(0)",e=o.getBoundingClientRect().left,r.removeChild(n),e===t}(),{width:h,height:p,offset:function(t,e){if(Array.isArray(t)||e&&"string"!=typeof e){var n=[].concat(t),i=[].concat(e),o=m(t)?t:E(n[0],n[1]),r=m(e)?e:E(i[0],i[1]);return{left:o.left-r.left,top:o.top-r.top}}return E(t,e)},rect:function(t,e){if(Array.isArray(t)||e&&"string"!=typeof e){var n=[].concat(t),i=[].concat(e),o=m(t)?t:C(n[0],n[1]),r=m(e)?e:E(i[0],i[1]);return o.left=o.left-r.left,o.top=o.top-r.top,o}return C(t,e)},containingBlock:v,distance:function(t,e){var n=M(t),i=M(e);return O(n,i)?-1:(o=n,r=i,s=o.left,a=s+o.width,c=o.top,l=c+o.height,d=r.left,u=d+r.width,f=r.top,h=f+r.height,(d>a||u<s)&&(f>l||h<c)?d>a?h<c?x(a,c,d,h):x(a,l,d,f):h<c?x(s,c,u,h):x(s,l,u,f):h<c?c-h:d>a?d-a:f>l?f-l:s-u);var o,r,s,a,c,l,d,u,f,h},intersection:function(){var t=O(arguments[0],arguments[1]);if(arguments.length>2)for(var e=2;e<arguments.length&&(t=O(t,arguments[e]));++e);return t},overflow:function(t,e){var n=S(e,t);return{left:-n.left,right:-n.right,top:-n.top,bottom:-n.bottom}},place:function(t){var e,n,i,o={},r=function t(e){for(var n,i,o={},r=0,s=e.length;r<s;r++)for(n in e[r])e[r].hasOwnProperty(n)&&(i=e[r][n],o[n]=m(i)?t([i]):Array.isArray(i)?i.slice():i);return o}([f.placeDefaultOptions,t||{}]),s="string"==typeof r.position?r.position.split(" "):r.position,a=M(r.element,!0),c=M(r.target),l=m(r.contain),d=l&&r.contain.within,u=l&&(y=r.contain.onOverflow,_=typeof y,w="none",O="none",x="none",k="none","string"===_?w=O=x=k=y:"object"===_&&(w=y.left||y.x||w,O=y.right||y.x||O,x=y.top||y.y||x,k=y.bottom||y.y||k),"none"!==w||"none"!==O||"none"!==x||"none"!==k?{left:w,right:O,top:x,bottom:k}:null),h=0,p=0,v=r.offsetX,g=r.offsetY;var y,_,w,O,x,k;return v="string"==typeof v&&v.indexOf("%")>-1?b(v)/100*a.width:b(v),g="string"==typeof g&&g.indexOf("%")>-1?b(g)/100*a.height:b(g),o.left=R(s[0],s[2],c.width,c.left,a.width,a.left,v),o.top=R(s[1],s[3],c.height,c.top,a.height,a.top,g),a.left+=o.left,a.top+=o.top,d&&u&&(((n=S(a,e=M(d))).left<0||n.right<0)&&(h=$(u,n),o.left+=h),(n.top<0||n.bottom<0)&&(p=$(u,n,1),o.top+=p)),"function"==typeof r.adjust&&(0!==h&&(a.left+=h,a.right=a.left+a.width),0!==p&&(a.top+=p,a.bottom=a.left+a.width),e=d?e||M(d):null,i=m(r.element)?r.element:E.apply(null,[].concat(r.element)),n=e?S(a,e):null,r.adjust(o,{elementRect:a,targetRect:c,containerRect:e,shift:{left:a.left-i.left,top:a.top-i.top},overflow:n?{left:-n.left,right:-n.right,top:-n.top,bottom:-n.bottom}:null,overflowCorrection:{left:h,top:p}})),o},_settings:f}},void 0===(i=function(){return r(o)}.apply(e,[]))||(t.exports=i)},IRx5:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return null!==t.sliceComponent?n(t.currentView,t._g({ref:"component",tag:"component",style:t.styles,attrs:{devise:t.deviseForSlice,breakpoint:t.breakpoint,slices:t.devise.slices,models:t.currentPage,component:t.sliceComponent}},t.$listeners)):t._e()},staticRenderFns:[]}},"V/iI":function(t,e,n){var i=n("VU/8")(n("mfSS"),null,!1,null,null,null);t.exports=i.exports},"VU/8":function(t,e){t.exports=function(t,e,n,i,o,r){var s,a=t=t||{},c=typeof t.default;"object"!==c&&"function"!==c||(s=t,a=t.default);var l,d="function"==typeof a?a.options:a;if(e&&(d.render=e.render,d.staticRenderFns=e.staticRenderFns,d._compiled=!0),n&&(d.functional=!0),o&&(d._scopeId=o),r?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),i&&i.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(r)},d._ssrRegister=l):i&&(l=i),l){var u=d.functional,f=u?d.render:d.beforeCreate;u?(d._injectStyles=l,d.render=function(t,e){return l.call(e),f(t,e)}):d.beforeCreate=f?[].concat(f,l):[l]}return{esModule:s,exports:a,options:d}}},"eo+j":function(t,e,n){"use strict";var i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},o=n("sknN");e.a={methods:{uppercase:function(t){return t.charAt(0).toUpperCase()+t.substring(1).toLowerCase()},slugify:function(t){return t.replace(/[^\w\-]+/g,"").replace(/\-/g,"").trim()},randomString:function(t){for(var e="",n="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789",i=0;i<t;i++)e+=n.charAt(Math.floor(Math.random()*n.length));return e},isEmail:function(t){return/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(t.toLowerCase())},escapeHtml:function(t){var e={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;"};return t.replace(/[&<>"']/g,function(t){return e[t]})},clipString:function(t,e,n){return void 0===n&&(n=!1),void 0!==t&&null!==t&&n&&(t=this.escapeHtml(t)),o(t,e,{html:n})},genUniqueKey:function(t){var e="__key_prefix__"+Date.now()+"_",n=0,o=function(t){if(null!==(r=t)&&"object"===(void 0===r?"undefined":i(r))){if("__unique_key_prop__"in t)return t.__unique_key_prop__;var o=e+n++;return Object.defineProperty(t,"__unique_key_prop__",{value:o}),o}var r;return t};return o(t)}}}},mfSS:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=n("s64Y"),o=n.n(i),r=(n("eo+j"),"function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t}),s="__key_prefix__"+Date.now()+"_",a=0,c=function(t){if(null!==(n=t)&&"object"===(void 0===n?"undefined":r(n))){if("__unique_key_prop__"in t)return t.__unique_key_prop__;var e=s+a++;return Object.defineProperty(t,"__unique_key_prop__",{value:e}),e}var n;return t};e.default={name:"DeviseSlices",functional:!0,render:function(t,e){if(e.props.slices&&e.props.slices.length)return e.props.slices.map(function(n){return"model"!==n.metadata.type?t(o.a,Object.assign({},e.data,{key:c(n),props:{devise:n,editorMode:e.props.editorMode}})):n.slices?n.slices.map(function(n){return t(o.a,Object.assign({},e.data,{key:c(n),props:{devise:n,editorMode:e.props.editorMode}}))}):void 0})},mounted:function(){this.$nextTick(function(){devise.$bus.$emit("devise-loaded")})},props:["editorMode"]}},p9BE:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});n("z+gd");var i=n("Zzkc"),o=(n.n(i),n("0lwT")),r=n.n(o),s=n("s64Y"),a=n.n(s),c=n("NYxO"),l=n("eo+j"),d="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},u=Object.assign||function(t){for(var e=1;e<arguments.length;e++){var n=arguments[e];for(var i in n)Object.prototype.hasOwnProperty.call(n,i)&&(t[i]=n[i])}return t},f=n("YrBu");e.default={name:"DeviseSlice",data:function(){return{backgroundColor:null,mounted:!1,showEditor:!1,sliceEl:null,sliceComponent:null,resizeObserver:null}},created:function(){this.hydrateMissingProperties(),this.checkDefaults(),this.backgroundColor=f("#fff").toRgb(),this.sliceComponent=this.component(this.devise.metadata.name)},mounted:function(){this.mounted=!0,this.sliceEl=this.$refs.component.$el,void 0===this.devise.settings&&this.$set(this.devise,"settings",{}),void 0!==this.devise.settings.backgroundColor&&(this.backgroundColor=f(this.devise.settings.backgroundColor).toRgb()),this.addListeners(),this.checkMediaSizesForRegeneration()},methods:u({},Object(c.b)("devise",["regenerateMedia"]),{addListeners:function(){deviseSettings.$bus.$on("jumpToSlice",this.attemptJumpToSlice),deviseSettings.$bus.$on("openSliceSettings",this.attemptOpenSliceSettings),deviseSettings.$bus.$on("markSlice",this.markSlice),this.addVisibilityScrollListeners()},hydrateMissingProperties:function(){var t=this.sliceConfig(this.devise).fields;if(t)for(var e in t)this.addMissingProperty(e),this.addFieldConfigurations(t,e)},addMissingProperty:function(t){var e=Object.assign({},{text:null,url:null,media:{},target:null,color:null,checked:null,enabled:!1},this.deviseForSlice[t]);this.$set(this.deviseForSlice,t,e)},checkDefaults:function(){var t=this.sliceConfig(this.devise).fields;if(t)for(var e in t)this.deviseForSlice.hasOwnProperty(e)&&t[e].default&&this.setDefaults(e,t[e].default)},addFieldConfigurations:function(t,e){for(var n in t[e])this.deviseForSlice[e].hasOwnProperty(n)||this.$set(this.deviseForSlice[e],n,t[e][n])},setDefaults:function(t,e){for(var n in e)void 0!==this.deviseForSlice[t][n]&&null!==this.deviseForSlice[t][n]||this.$set(this.deviseForSlice[t],n,e[n])},checkMediaSizesForRegeneration:function(){if(void 0!==this.currentView.fields)for(var t in this.currentView.fields){var e=this.currentView.fields[t];"image"===e.type&&null!==this.devise[t].url&&(void 0===e.sizes||"object"!==d(this.devise[t].media)||this.mediaAlreadyRequested({component:this.devise.metadata.name,fieldName:t})||this.determineMediaRegenerationNeeds(e,t))}},determineMediaRegenerationNeeds:function(t,e){var n={sizes:{}};for(var i in t.sizes)void 0===this.devise[e].media[i]&&(n.sizes[i]=t.sizes[i]);for(var i in t.sizes){var o=this.devise[e].sizes[i],r=t.sizes[i];o&&o.w===r.w&&o.h===r.h||(n.sizes[i]=r)}if(Object.keys(n.sizes).length>0){var s={allSizes:t.sizes,sizes:n,instanceId:this.devise.metadata.instance_id,fieldName:e,component:this.devise.metadata.name};this.makeMediaRegenerationRequest(s)}},makeMediaRegenerationRequest:function(t){this.regenerateMedia(t).then(function(){devise.$bus.$emit("showMessage",{title:"New Images Generated",message:"Pro tip: Some new sizes were generated for a slice you were working on (Field: "+t.fieldName+") You may need to refresh."})})},attemptJumpToSlice:function(t){if(this.devise.metadata&&t.metadata&&this.devise.metadata.instance_id===t.metadata.instance_id)try{var e=r.a.offset(this.sliceEl,"margin");window.scrollTo({top:e.top,behavior:"smooth"})}catch(t){console.warn("Devise Warning: There may be a problem with this slice. Try wrapping the template in a single <div> to resolve and prevent children components to be at the root level.")}},attemptOpenSliceSettings:function(t){this.devise.metadata&&t.metadata&&this.devise.metadata.instance_id===t.metadata.instance_id&&deviseSettings.$bus.$emit("open-slice-settings",this.deviseForSlice)},markSlice:function(t,e){if(this.devise.metadata&&t.metadata&&this.devise.metadata.instance_id===t.metadata.instance_id){for(var n=document.getElementsByClassName("devise-component-marker");n.length>0;)n[0].parentNode.removeChild(n[0]);if(e)try{var i=r.a.offset(this.sliceEl,"margin"),o=r.a.width(this.sliceEl,"margin"),s=r.a.height(this.sliceEl,"margin"),a=document.createElement("div");a.innerHTML='\n              <div class="dvs-absolute-center dvs-absolute">\n                <h1 class="dvs-text-grey-light dvs-font-hairline dvs-font-sans dvs-p-4 dvs-bg-abs-black dvs-rounded dvs-shadow-lg">\n                  '+this.devise.metadata.label+"\n                </h1>\n              </div>",a.classList="devise-component-marker dvs-absolute dvs-bg-black dvs-z-60 dvs-opacity-75",a.style.cssText="top:"+i.top+"px;left:"+i.left+"px;width:"+o+"px;height:"+s+"px",document.body.appendChild(a)}catch(t){console.warn("Devise Warning: There may be a problem with this slice. Try wrapping the template in a single <div> to resolve and prevent children components to be at the root level.")}}},addVisibilityScrollListeners:function(){var t=this;void 0===this.$refs.component.isVisible&&void 0===this.$refs.component.isHidden||void 0===this.$refs.component||window.addEventListener("scroll",function(){t.checkVisible(t.$refs.component.$el)?t.$refs.component&&void 0!==t.$refs.component.isVisible&&t.$refs.component.isVisible():t.$refs.component&&void 0!==t.$refs.component.isHidden&&t.$refs.component.isHidden()})},checkVisible:function(t){var e=t.getBoundingClientRect(),n=Math.max(document.documentElement.clientHeight,window.innerHeight);return!(e.bottom<0||e.top-n>=0)},buildStyles:function(t,e,n){return void 0!==e&&(void 0!==e.top&&(t.marginTop=e.top+"px"),void 0!==e.right&&(t.marginRight=e.right+"px"),void 0!==e.bottom&&(t.marginBottom=e.bottom+"px"),void 0!==e.left&&(t.marginLeft=e.left+"px")),void 0!==n&&(void 0!==n.top&&(t.paddingTop=n.top+"px"),void 0!==n.right&&(t.paddingRight=n.right+"px"),void 0!==n.bottom&&(t.paddingBottom=n.bottom+"px"),void 0!==n.left&&(t.paddingLeft=n.left+"px")),t}}),computed:u({},Object(c.c)("devise",["component","sliceConfig","breakpoint","mediaAlreadyRequested"]),{deviseForSlice:function(){return this.devise.config?this.devise.config:this.devise},styles:function(){var t={};void 0===this.deviseForSlice.settings&&this.$set(this.deviseForSlice,"settings",{});var e=this.deviseForSlice.settings.backgroundColor,n=this.deviseForSlice.settings.margin,i=this.deviseForSlice.settings.mobile_margin,o=this.deviseForSlice.settings.padding,r=this.deviseForSlice.settings.mobile_padding;return void 0!==e&&(t.backgroundColor=e),"mobile"===this.breakpoint?this.buildStyles(t,i,r):this.buildStyles(t,n,o)},currentView:function(){return this.devise.config?deviseSettings.$deviseComponents[this.devise.name]:deviseSettings.$deviseComponents[this.devise.metadata.name]}}),props:["editorMode"],mixins:[l.a],components:{Slice:a.a,SettingsIcon:function(){return n.e(13).then(n.bind(null,"PKnS"))},"sketch-picker":i.Sketch}}},s64Y:function(t,e,n){var i=n("VU/8")(n("p9BE"),n("IRx5"),!1,null,null,null);t.exports=i.exports},"z+gd":function(t,e,n){"use strict";(function(t){var e=function(){if("undefined"!=typeof Map)return Map;function t(t,e){var n=-1;return t.some(function(t,i){return t[0]===e&&(n=i,!0)}),n}return function(){function e(){this.__entries__=[]}return Object.defineProperty(e.prototype,"size",{get:function(){return this.__entries__.length},enumerable:!0,configurable:!0}),e.prototype.get=function(e){var n=t(this.__entries__,e),i=this.__entries__[n];return i&&i[1]},e.prototype.set=function(e,n){var i=t(this.__entries__,e);~i?this.__entries__[i][1]=n:this.__entries__.push([e,n])},e.prototype.delete=function(e){var n=this.__entries__,i=t(n,e);~i&&n.splice(i,1)},e.prototype.has=function(e){return!!~t(this.__entries__,e)},e.prototype.clear=function(){this.__entries__.splice(0)},e.prototype.forEach=function(t,e){void 0===e&&(e=null);for(var n=0,i=this.__entries__;n<i.length;n++){var o=i[n];t.call(e,o[1],o[0])}},e}()}(),n="undefined"!=typeof window&&"undefined"!=typeof document&&window.document===document,i=void 0!==t&&t.Math===Math?t:"undefined"!=typeof self&&self.Math===Math?self:"undefined"!=typeof window&&window.Math===Math?window:Function("return this")(),o="function"==typeof requestAnimationFrame?requestAnimationFrame.bind(i):function(t){return setTimeout(function(){return t(Date.now())},1e3/60)},r=2;var s=20,a=["top","right","bottom","left","width","height","size","weight"],c="undefined"!=typeof MutationObserver,l=function(){function t(){this.connected_=!1,this.mutationEventsAdded_=!1,this.mutationsObserver_=null,this.observers_=[],this.onTransitionEnd_=this.onTransitionEnd_.bind(this),this.refresh=function(t,e){var n=!1,i=!1,s=0;function a(){n&&(n=!1,t()),i&&l()}function c(){o(a)}function l(){var t=Date.now();if(n){if(t-s<r)return;i=!0}else n=!0,i=!1,setTimeout(c,e);s=t}return l}(this.refresh.bind(this),s)}return t.prototype.addObserver=function(t){~this.observers_.indexOf(t)||this.observers_.push(t),this.connected_||this.connect_()},t.prototype.removeObserver=function(t){var e=this.observers_,n=e.indexOf(t);~n&&e.splice(n,1),!e.length&&this.connected_&&this.disconnect_()},t.prototype.refresh=function(){this.updateObservers_()&&this.refresh()},t.prototype.updateObservers_=function(){var t=this.observers_.filter(function(t){return t.gatherActive(),t.hasActive()});return t.forEach(function(t){return t.broadcastActive()}),t.length>0},t.prototype.connect_=function(){n&&!this.connected_&&(document.addEventListener("transitionend",this.onTransitionEnd_),window.addEventListener("resize",this.refresh),c?(this.mutationsObserver_=new MutationObserver(this.refresh),this.mutationsObserver_.observe(document,{attributes:!0,childList:!0,characterData:!0,subtree:!0})):(document.addEventListener("DOMSubtreeModified",this.refresh),this.mutationEventsAdded_=!0),this.connected_=!0)},t.prototype.disconnect_=function(){n&&this.connected_&&(document.removeEventListener("transitionend",this.onTransitionEnd_),window.removeEventListener("resize",this.refresh),this.mutationsObserver_&&this.mutationsObserver_.disconnect(),this.mutationEventsAdded_&&document.removeEventListener("DOMSubtreeModified",this.refresh),this.mutationsObserver_=null,this.mutationEventsAdded_=!1,this.connected_=!1)},t.prototype.onTransitionEnd_=function(t){var e=t.propertyName,n=void 0===e?"":e;a.some(function(t){return!!~n.indexOf(t)})&&this.refresh()},t.getInstance=function(){return this.instance_||(this.instance_=new t),this.instance_},t.instance_=null,t}(),d=function(t,e){for(var n=0,i=Object.keys(e);n<i.length;n++){var o=i[n];Object.defineProperty(t,o,{value:e[o],enumerable:!1,writable:!1,configurable:!0})}return t},u=function(t){return t&&t.ownerDocument&&t.ownerDocument.defaultView||i},f=b(0,0,0,0);function h(t){return parseFloat(t)||0}function p(t){for(var e=[],n=1;n<arguments.length;n++)e[n-1]=arguments[n];return e.reduce(function(e,n){return e+h(t["border-"+n+"-width"])},0)}function v(t){var e=t.clientWidth,n=t.clientHeight;if(!e&&!n)return f;var i=u(t).getComputedStyle(t),o=function(t){for(var e={},n=0,i=["top","right","bottom","left"];n<i.length;n++){var o=i[n],r=t["padding-"+o];e[o]=h(r)}return e}(i),r=o.left+o.right,s=o.top+o.bottom,a=h(i.width),c=h(i.height);if("border-box"===i.boxSizing&&(Math.round(a+r)!==e&&(a-=p(i,"left","right")+r),Math.round(c+s)!==n&&(c-=p(i,"top","bottom")+s)),!function(t){return t===u(t).document.documentElement}(t)){var l=Math.round(a+r)-e,d=Math.round(c+s)-n;1!==Math.abs(l)&&(a-=l),1!==Math.abs(d)&&(c-=d)}return b(o.left,o.top,a,c)}var m="undefined"!=typeof SVGGraphicsElement?function(t){return t instanceof u(t).SVGGraphicsElement}:function(t){return t instanceof u(t).SVGElement&&"function"==typeof t.getBBox};function g(t){return n?m(t)?function(t){var e=t.getBBox();return b(0,0,e.width,e.height)}(t):v(t):f}function b(t,e,n,i){return{x:t,y:e,width:n,height:i}}var y=function(){function t(t){this.broadcastWidth=0,this.broadcastHeight=0,this.contentRect_=b(0,0,0,0),this.target=t}return t.prototype.isActive=function(){var t=g(this.target);return this.contentRect_=t,t.width!==this.broadcastWidth||t.height!==this.broadcastHeight},t.prototype.broadcastRect=function(){var t=this.contentRect_;return this.broadcastWidth=t.width,this.broadcastHeight=t.height,t},t}(),_=function(){return function(t,e){var n,i,o,r,s,a,c,l=(i=(n=e).x,o=n.y,r=n.width,s=n.height,a="undefined"!=typeof DOMRectReadOnly?DOMRectReadOnly:Object,c=Object.create(a.prototype),d(c,{x:i,y:o,width:r,height:s,top:o,right:i+r,bottom:s+o,left:i}),c);d(this,{target:t,contentRect:l})}}(),w=function(){function t(t,n,i){if(this.activeObservations_=[],this.observations_=new e,"function"!=typeof t)throw new TypeError("The callback provided as parameter 1 is not a function.");this.callback_=t,this.controller_=n,this.callbackCtx_=i}return t.prototype.observe=function(t){if(!arguments.length)throw new TypeError("1 argument required, but only 0 present.");if("undefined"!=typeof Element&&Element instanceof Object){if(!(t instanceof u(t).Element))throw new TypeError('parameter 1 is not of type "Element".');var e=this.observations_;e.has(t)||(e.set(t,new y(t)),this.controller_.addObserver(this),this.controller_.refresh())}},t.prototype.unobserve=function(t){if(!arguments.length)throw new TypeError("1 argument required, but only 0 present.");if("undefined"!=typeof Element&&Element instanceof Object){if(!(t instanceof u(t).Element))throw new TypeError('parameter 1 is not of type "Element".');var e=this.observations_;e.has(t)&&(e.delete(t),e.size||this.controller_.removeObserver(this))}},t.prototype.disconnect=function(){this.clearActive(),this.observations_.clear(),this.controller_.removeObserver(this)},t.prototype.gatherActive=function(){var t=this;this.clearActive(),this.observations_.forEach(function(e){e.isActive()&&t.activeObservations_.push(e)})},t.prototype.broadcastActive=function(){if(this.hasActive()){var t=this.callbackCtx_,e=this.activeObservations_.map(function(t){return new _(t.target,t.broadcastRect())});this.callback_.call(t,e,t),this.clearActive()}},t.prototype.clearActive=function(){this.activeObservations_.splice(0)},t.prototype.hasActive=function(){return this.activeObservations_.length>0},t}(),S="undefined"!=typeof WeakMap?new WeakMap:new e,O=function(){return function t(e){if(!(this instanceof t))throw new TypeError("Cannot call a class as a function.");if(!arguments.length)throw new TypeError("1 argument required, but only 0 present.");var n=l.getInstance(),i=new w(e,n,this);S.set(this,i)}}();["observe","unobserve","disconnect"].forEach(function(t){O.prototype[t]=function(){var e;return(e=S.get(this))[t].apply(e,arguments)}});void 0!==i.ResizeObserver&&i.ResizeObserver}).call(e,n("DuR2"))}});