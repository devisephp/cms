webpackJsonp([16],{"/Jy0":function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default={name:"Cell",data:function(){return{eventName:""}},created:function(){this.$options.template="<div>"+this.contents+"</div>"},methods:{emit:function(e){this.eventName=e}},props:["contents","record"]}},"4ro4":function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=s("eo+j");t.default={name:"SuperTableSearch",data:function(){return{localFilters:null}},mounted:function(){var e=this;this.$nextTick(function(){e.localFilters=Object.assign({},this.localFilters,this.value)})},methods:{updateValue:function(){this.$emit("input",this.localFilters),this.$emit("change",this.localFilters)},clear:function(){this.localFilters="",this.updateValue()}},computed:{uiType:function(){return void 0!==this.options?Array.isArray(this.options)?"array-select":"object-select":"field"}},watch:{value:function(e){this.localFilters=Object.assign({},this.localFilters,e)}},props:["value","column","options"],mixins:[n.a]}},"5/LD":function(e,t,s){var n=s("VU/8")(s("WiMd"),s("HJgV"),!1,null,null,null);e.exports=n.exports},"5V/6":function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=s("NYxO"),r=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var s=arguments[t];for(var n in s)Object.prototype.hasOwnProperty.call(s,n)&&(e[n]=s[n])}return e};t.default={name:"SuperTableRelated",data:function(){return{selected:[],relatedFilter:""}},mounted:function(){this.filters[this.type].related.hasOwnProperty(this.options.field)&&(this.selected=this.filters[this.type].related[this.options.field])},methods:r({},Object(n.b)(["updateFilters"]),{clear:function(){this.selected=[],this.relatedFilter="",this.update()},update:function(){var e=this.filters;this.selected.length>0?(e[this.type].related[this.options.field]=this.selected,e[this.type].page=1):delete e[this.type].related[this.options.field],this.updateFilters(e)}}),computed:r({filteredOptions:function(){return void 0===this.relatedFilter||""===this.relatedFilter?this[this.options.data]:[]}},Object(n.c)(["filters","categoriesList"])),props:["options","type"]}},"91sm":function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"dvs-flex dvs-px-4 dvs-py-8 dvs-flex dvs-flex-col dvs-max-h-200  dvs-overflow-y-scroll"},[s("div",[s("fieldset",[s("input",{directives:[{name:"model",rawName:"v-model",value:e.relatedFilter,expression:"relatedFilter"}],staticClass:"dvs-w-full dvs-mb-4",attrs:{type:"text",placeholder:"Filter"},domProps:{value:e.relatedFilter},on:{input:function(t){t.target.composing||(e.relatedFilter=t.target.value)}}})])]),e._v(" "),e._l(e.filteredOptions,function(t,n){return s("div",[s("fieldset",{staticClass:"dvs-mr-4 dvs-flex mb-2"},[s("div",{staticClass:"dvs-flex dvs-items-center"},[s("input",{directives:[{name:"model",rawName:"v-model",value:e.selected,expression:"selected"}],attrs:{type:"checkbox"},domProps:{value:t[e.options.key],checked:Array.isArray(e.selected)?e._i(e.selected,t[e.options.key])>-1:e.selected},on:{change:[function(s){var n=e.selected,r=s.target,i=!!r.checked;if(Array.isArray(n)){var o=t[e.options.key],l=e._i(n,o);r.checked?l<0&&(e.selected=n.concat([o])):l>-1&&(e.selected=n.slice(0,l).concat(n.slice(l+1)))}else e.selected=i},e.update]}}),e._v(" "),s("label",{staticClass:"dvs-pl-2"},[e._v(e._s(t[e.options.label]))])])])])})],2)},staticRenderFns:[]}},"B+ZF":function(e,t,s){var n=s("VU/8")(s("4ro4"),s("WDEq"),!1,null,null,null);e.exports=n.exports},BjSH:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"dvs-flex dvs-items-stretch"},e._l(e.columns,function(t,n){return s("div",{key:n,staticClass:"dvs-flex dvs-flex-col dvs-justify-between dvs-w-full"},[s("div",{staticClass:"dvs-font-bold dvs-mb-2 dvs-pb-2 dvs-px-2 dvs-border-b",style:{borderColor:e.theme.panel.color},on:{click:function(s){e.sortByColumn(t)}}},[e._v("\n      "+e._s(t.name)+"\n      "),t===e.sortBy?["desc"===e.sortDir?s("arrow-down"):s("arrow-up")]:e._e()],2),e._v(" "),e._l(e.sortedData,function(n,r){return s("div",{key:r,staticClass:"dvs-overflow-hidden dvs-px-2"},[t.property?[e._v(e._s(n[1][t.property]))]:[e._v(e._s(n[0]))]],2)})],2)}),0)},staticRenderFns:[]}},CP4e:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return e.shouldDisplayControls?s("div",{staticClass:"dvs-ml-4"},[s("div",{staticClass:"dvs-cursor-pointer",on:{click:function(t){e.show=!0}}},[s("settings-icon")],1),e._v(" "),s("div",{directives:[{name:"show",rawName:"v-show",value:e.show,expression:"show"}]},[s("div",{staticClass:"dvs-blocker dvs-z-20",on:{click:e.hide}}),e._v(" "),s("div",{directives:[{name:"show",rawName:"v-show",value:e.show,expression:"show"}],staticClass:"dvs-absolute dvs-pin-b dvs-pin-l dvs-mb-1 dvs-min-w-250 dvs-z-40 dvs-shadow-lg",style:e.theme.panel},[s("div",{staticClass:"dvs-pt-4 dvs-pb-2 dvs-px-4 dvs-flex dvs-justify-between dvs-min-w-64"},[e._v("\n        "+e._s(this.column.label)+"\n        "),s("div",{staticClass:"dvs-flex dvs-justify-between"},[s("button",{staticClass:"dvs-btn dvs-btn-xs",style:e.theme.actionButton,on:{click:function(t){e.clearAll()}}},[e._v("Clear")]),e._v(" "),s("div",{on:{click:e.hide}},[s("close-icon",{staticClass:"dvs-pl-2 dvs-cursor-pointer",attrs:{w:"20",h:"20"}})],1)])]),e._v(" "),s("div",{staticClass:"dvs-px-4 dvs-column-control-modules",style:e.theme.panel},[void 0!==e.column.search?s("search",{ref:"search",attrs:{column:e.column.search,options:e.column.options},on:{change:e.updateValue},model:{value:e.localFilters,callback:function(t){e.localFilters=t},expression:"localFilters"}}):e._e()],1)])])]):e._e()},staticRenderFns:[]}},CXZq:function(e,t,s){var n=s("VU/8")(s("m0ED"),s("ka8M"),!1,null,null,null);e.exports=n.exports},GtBY:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return e.listMode?s("ul",{staticClass:"dvs-list-reset dvs-flex"},e._l(e.meta.last_page,function(t){return s("li",{key:t,staticClass:"dvs-btn dvs-btn-xs dvs-mr-1 dvs-cursor-pointer",class:{"dvs-current-page":e.isCurrentPage(t)},style:e.decideStyle(t),on:{click:function(s){e.update(t)}}},[e._v("\n    "+e._s(t)+"\n  ")])}),0):s("div",{staticClass:"dvs-flex"},[s("button",{staticClass:"dvs-btn dvs-btn-xs dvs-mr-1",style:this.theme.actionButtonGhost,on:{click:function(t){e.changePage(1)}}},[e._v("First")]),e._v(" "),s("button",{staticClass:"dvs-btn dvs-btn-xs dvs-mr-1",style:this.theme.actionButtonGhost,on:{click:function(t){e.changePage(e.meta.current_page-1)}}},[e._v("Prev")]),e._v(" "),s("select",{staticClass:"dvs-p-2 dvs-mr-1 dvs-text-xs dvs-appearance-none",domProps:{value:e.meta.current_page},on:{change:function(t){e.changePage(t.target.value)}}},e._l(e.meta.last_page,function(t){return s("option",{key:t,domProps:{value:t}},[e._v("\n      "+e._s(t)+"\n    ")])}),0),e._v(" "),s("button",{staticClass:"dvs-btn dvs-btn-xs dvs-mr-1",style:this.theme.actionButtonGhost,on:{click:function(t){e.changePage(e.meta.current_page+1)}}},[e._v("Next")]),e._v(" "),s("button",{staticClass:"dvs-btn dvs-btn-xs dvs-mr-1",style:this.theme.actionButtonGhost,on:{click:function(t){e.changePage(e.meta.last_page)}}},[e._v("Last")])])},staticRenderFns:[]}},HJgV:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"dvs-mr-4 dvs-relative"},[s("div",{on:{click:function(t){e.show=!0}}},[s("switch-icon",{staticClass:"dvs-cursor-pointer dvs-float-right"})],1),e._v(" "),s("div",{directives:[{name:"show",rawName:"v-show",value:e.show,expression:"show"}],staticClass:"dvs-absolute dvs-pin-t dvs-pin-r dvs-mt-1 dvs-z-40 dvs-shadow-lg dvs-border-t-2"},[s("div",{staticClass:"dvs-pt-4 dvs-pb-2 dvs-px-4"},[e._v("Toggle Columns\n      "),s("span",{on:{click:function(t){e.show=!1}}},[s("switch-icon",{staticClass:"dvs-cursor-pointer dvs-float-right"})],1)]),e._v(" "),s("div",{staticClass:"dvs-px-4"},[s("div",{staticClass:"dvs-flex dvs-px-4 dvs-py-8 dvs-flex dvs-flex-col dvs-max-h-200 dvs-overflow-y-scroll"},[s("div",e._l(e.columns,function(t){return t.toggleColumns?e._e():s("fieldset",{key:t.key,staticClass:"dvs-mr-4 dvs-flex dvs-mb-2"},[s("div",{staticClass:"dvs-flex dvs-items-center"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.show,expression:"column.show"}],attrs:{type:"checkbox"},domProps:{checked:Array.isArray(t.show)?e._i(t.show,null)>-1:t.show},on:{change:[function(s){var n=t.show,r=s.target,i=!!r.checked;if(Array.isArray(n)){var o=e._i(n,null);r.checked?o<0&&e.$set(t,"show",n.concat([null])):o>-1&&e.$set(t,"show",n.slice(0,o).concat(n.slice(o+1)))}else e.$set(t,"show",i)},e.update]}}),e._v(" "),s("label",{staticClass:"dvs-pl-2"},[e._v(e._s(t.label))])])])}),0)])])])])},staticRenderFns:[]}},HLpn:function(e,t,s){var n=s("VU/8")(s("ybne"),s("KYxh"),!1,null,null,null);e.exports=n.exports},Iuzt:function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default={name:"DeviseToggle",data:function(){return{localValue:!0}},mounted:function(){this.localValue=this.value},methods:{updateValue:function(){this.$emit("input",this.localValue),this.$emit("change",this.localValue)}},watch:{value:function(e){this.localValue=this.value}},props:["value","id","mini"]}},KYxh:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"dvs-flex dvs-px-4 dvs-py-8"},[s("fieldset",{staticClass:"dvs-w-full"},[s("label",{staticClass:"dvs-pb-2"},[e._v("Date Range")]),e._v(" "),s("flat-pickr",{staticClass:"dvs-w-full dvs-mb-4",attrs:{config:e.afterConfig,placeholder:"After"},on:{"on-change":e.onAfterChange},model:{value:e.after,callback:function(t){e.after=t},expression:"after"}}),e._v(" "),s("flat-pickr",{staticClass:"fancy w-full",attrs:{config:e.beforeConfig,placeholder:"Before"},on:{"on-change":e.onBeforeChange},model:{value:e.before,callback:function(t){e.before=t},expression:"before"}})],1)])},staticRenderFns:[]}},M0fd:function(e,t,s){var n=s("VU/8")(s("bVGK"),s("GtBY"),!1,null,null,null);e.exports=n.exports},QKS3:function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default={name:"SimpleTable",data:function(){return{sortBy:null,sortDir:null}},methods:{sortByColumn:function(e){this.sortBy===e?"desc"===this.sortDir?(this.sortDir=null,this.sortBy=null):"asc"===this.sortDir?this.sortDir="desc":this.sortDir="asc":(this.sortBy=e,this.sortDir="asc")},sortNumber:function(e,t,s){return"desc"===s?t-e:e-t},sortString:function(e,t,s){var n=e.toUpperCase(),r=t.toUpperCase();return n<r?"desc"===s?-1:1:n>r?"desc"===s?1:-1:void 0}},computed:{sortedData:function(){var e=this,t=[];for(var s in this.data)t.push([s,this.data[s]]);return null!==this.sortBy&&t.sort(function(t,s){return e.sortBy.property?"string"==typeof t[1][e.sortBy.name]?e.sortString(t[1][e.sortBy.property],s[1][e.sortBy.property],e.sortDir):e.sortNumber(t[1][e.sortBy.property],s[1][e.sortBy.property],e.sortDir):"string"==typeof t[0]?e.sortString(t[0],s[0],e.sortDir):e.sortNumber(t[0],s[0],e.sortDir)}),t}},props:{columns:{required:!0,type:Array},data:{required:!0,type:Object|Array}},components:{ArrowDown:function(){return s.e(0).then(s.bind(null,"BCJZ"))},ArrowUp:function(){return s.e(0).then(s.bind(null,"Rvl2"))}}}},QKlT:function(e,t,s){var n;"undefined"!=typeof self&&self,n=function(e){return function(e){var t={};function s(n){if(t[n])return t[n].exports;var r=t[n]={i:n,l:!1,exports:{}};return e[n].call(r.exports,r,r.exports,s),r.l=!0,r.exports}return s.m=e,s.c=t,s.d=function(e,t,n){s.o(e,t)||Object.defineProperty(e,t,{configurable:!1,enumerable:!0,get:n})},s.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return s.d(t,"a",t),t},s.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},s.p="",s(s.s=0)}([function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=s(2),r=s.n(n),i=["onChange","onClose","onDayCreate","onDestroy","onKeyDown","onMonthChange","onOpen","onParseConfig","onReady","onValueUpdate","onYearChange","onPreCalendarPosition"],o={name:"flat-pickr",props:{value:{default:null,required:!0,validator:function(e){return null===e||e instanceof Date||"string"==typeof e||e instanceof String||e instanceof Array||"number"==typeof e}},config:{type:Object,default:function(){return{wrap:!1,defaultDate:null}}},events:{type:Array,default:function(){return i}}},data:function(){return{fp:null}},mounted:function(){var e=this;this.fp||(this.events.forEach(function(t){var s;e.config[t]=(s=e.config[t]||[],s instanceof Array?s:[s]).concat(function(){for(var s=arguments.length,n=Array(s),r=0;r<s;r++)n[r]=arguments[r];var i;e.$emit.apply(e,[(i=t,i.replace(/([a-z])([A-Z])/g,"$1-$2").toLowerCase())].concat(n))})}),this.config.defaultDate=this.value||this.config.defaultDate,this.fp=new r.a(this.getElem(),this.config))},methods:{getElem:function(){return this.config.wrap?this.$el.parentNode:this.$el},onInput:function(e){this.$emit("input",e.target.value)}},watch:{config:{deep:!0,handler:function(e){i.forEach(function(t){delete e[t]}),this.fp.set(e)}},value:function(e){e!==this.$el.value&&this.fp&&this.fp.setDate(e,!0)}},beforeDestroy:function(){this.fp&&(this.fp.destroy(),this.fp=null)}},l={render:function(){var e=this.$createElement;return(this._self._c||e)("input",{attrs:{type:"text","data-input":""},on:{input:this.onInput}})},staticRenderFns:[]},a=s(1)(o,l,!1,null,null,null).exports;s.d(t,"Plugin",function(){return c}),s.d(t,"Component",function(){return a});var c=function(e,t){var s="flat-pickr";"string"==typeof t&&(s=t),e.component(s,a)};a.install=c;t.default=a},function(e,t){e.exports=function(e,t,s,n,r,i){var o,l=e=e||{},a=typeof e.default;"object"!==a&&"function"!==a||(o=e,l=e.default);var c,u="function"==typeof l?l.options:l;if(t&&(u.render=t.render,u.staticRenderFns=t.staticRenderFns,u._compiled=!0),s&&(u.functional=!0),r&&(u._scopeId=r),i?(c=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),n&&n.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(i)},u._ssrRegister=c):n&&(c=n),c){var d=u.functional,f=d?u.render:u.beforeCreate;d?(u._injectStyles=c,u.render=function(e,t){return c.call(t),f(e,t)}):u.beforeCreate=f?[].concat(f,c):[c]}return{esModule:o,exports:l,options:u}}},function(t,s){t.exports=e}]).default},e.exports=n(s("GxBP"))},Qe27:function(e,t,s){var n=s("VU/8")(s("/Jy0"),null,!1,null,null,null);e.exports=n.exports},WDEq:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return e.localFilters&&e.localFilters.search?s("div",{staticClass:"dvs-flex dvs-px-4 dvs-py-8"},[s("fieldset",{staticClass:"dvs-w-full dvs-fieldset"},[s("label",{staticClass:"dvs-pb-2"},[e._v("Search")]),e._v(" "),"field"===e.uiType?s("input",{directives:[{name:"model",rawName:"v-model",value:e.localFilters.search[e.column],expression:"localFilters.search[column]"}],staticClass:"dvs-w-full",attrs:{type:"text"},domProps:{value:e.localFilters.search[e.column]},on:{keyup:e.updateValue,input:function(t){t.target.composing||e.$set(e.localFilters.search,e.column,t.target.value)}}}):e._e(),e._v(" "),"array-select"===e.uiType?s("select",{directives:[{name:"model",rawName:"v-model",value:e.localFilters.search[e.column],expression:"localFilters.search[column]"}],staticClass:"w-full",on:{change:[function(t){var s=Array.prototype.filter.call(t.target.options,function(e){return e.selected}).map(function(e){return"_value"in e?e._value:e.value});e.$set(e.localFilters.search,e.column,t.target.multiple?s:s[0])},e.updateValue]}},[s("option",{attrs:{value:""}},[e._v("Any")]),e._v(" "),e._l(e.options,function(t){return s("option",{key:t},[e._v(e._s(t))])})],2):e._e(),e._v(" "),"object-select"===e.uiType?s("select",{directives:[{name:"model",rawName:"v-model",value:e.localFilters.search[e.column],expression:"localFilters.search[column]"}],staticClass:"w-full",on:{change:[function(t){var s=Array.prototype.filter.call(t.target.options,function(e){return e.selected}).map(function(e){return"_value"in e?e._value:e.value});e.$set(e.localFilters.search,e.column,t.target.multiple?s:s[0])},e.updateValue]}},[s("option",{attrs:{value:""}},[e._v("Any")]),e._v(" "),e._l(e.options,function(t,n){return s("option",{key:t,domProps:{value:n}},[e._v(e._s(t))])})],2):e._e()])]):e._e()},staticRenderFns:[]}},WiMd:function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=s("NYxO"),r=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var s=arguments[t];for(var n in s)Object.prototype.hasOwnProperty.call(s,n)&&(e[n]=s[n])}return e};t.default={name:"ToggleColumns",data:function(){return{show:!1,columns:[]}},mounted:function(){this.columns=this.value;for(var e=0;e<this.columns.length;e++)void 0===this.columns[e].show&&this.$set(this.columns[e],"show",!0)},methods:{update:function(){this.$emit("input",this.columns)}},computed:r({},Object(n.c)(["currentTeam"])),props:{value:{type:Array,required:!0},type:{type:String,required:!0}},components:{SwitchIcon:function(){return s.e(0).then(s.bind(null,"rN5t"))}}}},Y4TY:function(e,t,s){var n=s("VU/8")(s("hV1E"),s("CP4e"),!1,null,null,null);e.exports=n.exports},bVGK:function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=s("NYxO"),r=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var s=arguments[t];for(var n in s)Object.prototype.hasOwnProperty.call(s,n)&&(e[n]=s[n])}return e};t.default={name:"SuperTablePagination",methods:r({},Object(n.b)(["updateFilters"]),{changePage:function(e){e>0&&e<=this.meta.last_page&&this.$emit("changePage",e)},isCurrentPage:function(e){return e===this.meta.current_page},decideStyle:function(e){return this.isCurrentPage(e)?this.theme.actionButton:this.theme.actionButtonGhost}}),computed:r({},Object(n.c)(["filters"])),props:["meta","listMode"]}},"fv+6":function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=s("QNs8"),r=s("Qe27"),i=s.n(r),o=s("Y4TY"),l=s.n(o),a=s("M0fd"),c=s.n(a),u=s("eo+j"),d=s("mzBo"),f=s.n(d),v=s("5/LD"),p=s.n(v),h=s("NYxO"),m=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var s=arguments[t];for(var n in s)Object.prototype.hasOwnProperty.call(s,n)&&(e[n]=s[n])}return e};t.default={name:"SuperTable",data:function(){return{theOptions:{showLinks:!0},filters:{related:{},search:{},sort:{},dates:{},paginated:!0,page:"1",limit:5,single:!1,scopes:{}},refreshRecords:null,records:[],meta:{},newScope:"",newScopeProperties:""}},mounted:function(){if(this.theOptions.showLinks=this.showLinks,void 0!==this.editData){for(var e in this.editData.filters.scopes)if(this.editData.filters.scopes.hasOwnProperty(e)){var t=this.editData.filters.scopes[e];for(var s in t)t.hasOwnProperty(s)&&(this.filters.scopes[s]=t[s])}this.$set(this.filters,"limit",this.editData.filters.limit),this.$set(this.filters,"single",this.editData.filters.single),this.$set(this.filters,"page",this.editData.filters.page),this.$set(this.filters,"paginated",this.editData.filters.paginated)}this.requestRefreshRecords()},methods:m({},Object(h.b)("devise",["getModelRecords"]),{updateValue:function(){var e=this.model.class+"&"+n.a.buildFilterParams(this.filters);this.$emit("input",e),this.$emit("change",e),this.$nextTick(function(){this.$emit("done",e)})},cancel:function(){this.$emit("cancel")},requestRefreshRecords:function(){var e=this;this.updateValue(),clearTimeout(this.refreshRecords),this.refreshRecords=setTimeout(function(){e.getModelRecords({model:e.value,filters:e.filters}).then(function(t){e.records=t.data})},500)},changePage:function(e){this.filters.page=e,this.requestRefreshRecords()},showControls:function(e){this.$refs.hasOwnProperty(e)&&!1===this.$refs[e][0].show&&(this.$refs[e][0].show=!0)},getRecordColumn:function(e,t){return t.includes(".")?this.getRecordColumnTraversal(e,t):e[t]},getRecordColumnTraversal:function(e,t){for(var s=t.split(".[]."),n=0;n<s.length;n++){var r=s[n];e=n%2==1?this.getFormattedStringFromArray(e,r):[e].concat(r.split(".")).reduce(function(e,t){return e[t]})}return e},getFormattedStringFromArray:function(e,t){for(var s="",n=0;n<e.length;n++)n>0&&(s+=", "),s+=e[n][t];return s},showColumn:function(e){return!0===e.show||void 0===e.show},addScope:function(){""!==this.newScope&&(this.filters.scopes[this.newScope]=this.newScopeProperties,this.newScope="",this.newScopeProperties="",this.requestRefreshRecords())},removeScope:function(e){this.$delete(this.filters.scopes,e),this.requestRefreshRecords(),this.updateValue()}}),computed:{theRecords:function(){return void 0!==this.records.data?this.records.data:this.filters.single?[this.records]:this.records}},watch:{model:function(){this.requestRefreshRecords()},filters:function(){this.requestRefreshRecords()}},props:{value:{type:String},model:{type:Object},columns:{type:Array,required:!0},showLinks:{type:Boolean},editData:{type:Object}},mixins:[u.a],components:{CloseIcon:function(){return s.e(0).then(s.bind(null,"1bZM"))},ColumnControls:l.a,ToggleColumns:p.a,Pagination:c.a,Cell:i.a,Toggle:f.a}}},hV1E:function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=s("B+ZF"),r=s.n(n),i=s("CXZq"),o=s.n(i),l=s("nI1i"),a=s.n(l),c=s("HLpn"),u=s.n(c);t.default={name:"ColumnControls",data:function(){return{show:!1,localFilters:null}},mounted:function(){this.localFilters=Object.assign({},this.localFilters,this.value)},methods:{updateValue:function(){this.$emit("input",this.localFilters),this.$emit("change",this.localFilters)},clearAll:function(){this.localFilters={related:{},search:{},sort:{},dates:{},page:"1"},this.updateValue()},hide:function(){var e=this;this.$nextTick(function(){e.show=!1})}},computed:{shouldDisplayControls:function(){return void 0!==this.column.sort||void 0!==this.column.search}},props:{column:{type:Object,required:!0},value:{}},components:{CloseIcon:function(){return s.e(0).then(s.bind(null,"1bZM"))},SettingsIcon:function(){return s.e(0).then(s.bind(null,"PKnS"))},Dates:u.a,Related:a.a,Search:r.a,Sort:o.a}}},kEqT:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",[s("table",{staticClass:"dvs-table dvs-mb-8"},[s("tr",e._l(e.columns,function(t,n){return e.showColumn(t)?s("th",{key:n,class:{"dvs-hidden md:dvs-table-cell":t.hideMobile},on:{click:function(s){e.showControls(t.key)}}},[t.toggleColumns?s("div",{staticClass:"flex"},[s("toggle-columns",{model:{value:e.columns,callback:function(t){e.columns=t},expression:"columns"}}),e._v("\n          "+e._s(t.label)+"\n        ")],1):s("div",{staticClass:"dvs-flex"},[s("div",[e._v(e._s(t.label))]),e._v(" "),s("column-controls",{ref:t.key,refInFor:!0,attrs:{column:t},model:{value:e.filters,callback:function(t){e.filters=t},expression:"filters"}})],1)]):e._e()}),0),e._v(" "),e._l(e.theRecords,function(t,n){return s("tr",{key:n},[e._l(e.columns,function(n,r){return e.showColumn(n)?[s("td",{key:r,class:{"dvs-hidden lg:dvs-table-cell":n.hideMobile}},[n.template?s("cell",{attrs:{record:t,contents:e.getRecordColumn(t,n.key)}}):s("span",[e._v(e._s(e.getRecordColumn(t,n.key)))])],1)]:e._e()})],2)}),e._v(" "),e.theRecords.length?e._e():s("tr",[s("td",{staticClass:"dvs-text-center",attrs:{colspan:e.columns.length}},[e._v("No Results Found")])])],2),e._v(" "),e.records.data&&e.records.data.length?s("pagination",{staticClass:"dvs-mb-8",attrs:{meta:e.records},on:{changePage:e.changePage}}):e._e(),e._v(" "),e.filters.single?e._e():s("fieldset",{staticClass:"dvs-fieldset dvs-mb-4"},[s("label",[e._v("Do you want the data paginated?")]),e._v(" "),s("toggle",{attrs:{id:e.randomString(8)},on:{change:e.requestRefreshRecords},model:{value:e.filters.paginated,callback:function(t){e.$set(e.filters,"paginated",t)},expression:"filters.paginated"}})],1),e._v(" "),!e.filters.single&&e.filters.paginated?s("fieldset",{staticClass:"dvs-fieldset dvs-mb-4"},[s("label",[e._v("What is the number of records per page?")]),e._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:e.filters.limit,expression:"filters.limit"}],attrs:{type:"number"},domProps:{value:e.filters.limit},on:{keyup:e.requestRefreshRecords,input:function(t){t.target.composing||e.$set(e.filters,"limit",t.target.value)}}})]):e._e(),e._v(" "),s("fieldset",{staticClass:"dvs-fieldset dvs-mb-4"},[s("label",[e._v("Do you only want the first record?")]),e._v(" "),s("toggle",{attrs:{id:e.randomString(8)},on:{change:e.requestRefreshRecords},model:{value:e.filters.single,callback:function(t){e.$set(e.filters,"single",t)},expression:"filters.single"}})],1),e._v(" "),s("fieldset",{staticClass:"dvs-fieldset dvs-mb-8"},[s("label",{staticClass:"dvs-mb-8"},[e._v("Scopes")]),e._v(" "),e.filters.scopes!=={}?s("ul",{staticClass:"dvs-list-reset dvs-mb-4"},e._l(e.filters.scopes,function(t,n){return s("li",{key:n,staticClass:"dvs-mb-2 dvs-px-4 py-3 dvs-flex dvs-items-center dvs-justify-between",style:e.theme.actionButtonGhost},[e._v("\n        "+e._s(n)+"\n        "),s("div",{on:{click:function(t){e.removeScope(n)}}},[s("close-icon",{staticClass:"dvs-pl-2 dvs-cursor-pointer",attrs:{w:"20",h:"20"}})],1)])}),0):e._e(),e._v(" "),s("div",{staticClass:"dvs-flex"},[s("input",{directives:[{name:"model",rawName:"v-model",value:e.newScope,expression:"newScope"}],staticClass:"dvs-mb-4 dvs-mr-4",attrs:{placeholder:"New Scope Name",type:"text"},domProps:{value:e.newScope},on:{input:function(t){t.target.composing||(e.newScope=t.target.value)}}}),e._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:e.newScopeProperties,expression:"newScopeProperties"}],staticClass:"dvs-mb-4",attrs:{placeholder:"New Scope Properties",type:"text"},domProps:{value:e.newScopeProperties},on:{input:function(t){t.target.composing||(e.newScopeProperties=t.target.value)}}})]),e._v(" "),s("button",{staticClass:"dvs-btn dvs-btn-xs",style:e.theme.actionButtonGhost,on:{click:e.addScope}},[e._v("Add Scope")])])],1)},staticRenderFns:[]}},ka8M:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"dvs-flex dvs-px-4 dvs-py-8"},[s("fieldset",{staticClass:"dvs-mr-4 dvs-flex"},[s("div",{staticClass:"dvs-flex dvs-items-center"},[s("label",{staticClass:"dvs-pr-2"},[e._v("Ascending")]),e._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:e.direction,expression:"direction"}],attrs:{type:"radio",value:"asc"},domProps:{checked:e._q(e.direction,"asc")},on:{change:[function(t){e.direction="asc"},e.update],click:function(t){e.checkRemove(t.target.value)}}})])]),e._v(" "),s("fieldset",{staticClass:"dvs-ml-4"},[s("div",{staticClass:"dvs-flex dvs-items-center"},[s("label",{staticClass:"dvs-pr-2"},[e._v("Descending")]),e._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:e.direction,expression:"direction"}],attrs:{type:"radio",value:"desc"},domProps:{checked:e._q(e.direction,"desc")},on:{change:[function(t){e.direction="desc"},e.update],click:function(t){e.checkRemove(t.target.value)}}})])])])},staticRenderFns:[]}},lR3w:function(e,t,s){var n=s("VU/8")(s("fv+6"),s("kEqT"),!1,null,null,null);e.exports=n.exports},m0ED:function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=s("NYxO"),r=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var s=arguments[t];for(var n in s)Object.prototype.hasOwnProperty.call(s,n)&&(e[n]=s[n])}return e};t.default={name:"SuperTableSort",data:function(){return{direction:null}},mounted:function(){var e=this.filters[this.type].sort;e.hasOwnProperty(this.column)&&(this.direction=e[this.column])},methods:r({},Object(n.b)(["updateFilters"]),{clear:function(){this.removeFilter()},update:function(){var e={};e[this.type]=this.filters[this.type],e[this.type].sort[this.column]=this.direction,this.updateFilters(e)},checkRemove:function(e){this.direction===e&&this.removeFilter()},removeFilter:function(){this.direction=null;var e={};e[this.type]=this.filters[this.type],delete e[this.type].sort[this.column],this.updateFilters(e)}}),computed:r({},Object(n.c)(["filters"])),props:["type","column"]}},mzBo:function(e,t,s){var n=s("VU/8")(s("Iuzt"),s("nvSt"),!1,null,null,null);e.exports=n.exports},nI1i:function(e,t,s){var n=s("VU/8")(s("5V/6"),s("91sm"),!1,null,null,null);e.exports=n.exports},nvSt:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("label",{class:{"dvs-toggle":!e.mini,"dvs-mini-toggle":e.mini},attrs:{for:e.id}},[s("input",{directives:[{name:"model",rawName:"v-model",value:e.localValue,expression:"localValue"}],attrs:{type:"checkbox",id:e.id},domProps:{checked:Array.isArray(e.localValue)?e._i(e.localValue,null)>-1:e.localValue},on:{change:[function(t){var s=e.localValue,n=t.target,r=!!n.checked;if(Array.isArray(s)){var i=e._i(s,null);n.checked?i<0&&(e.localValue=s.concat([null])):i>-1&&(e.localValue=s.slice(0,i).concat(s.slice(i+1)))}else e.localValue=r},e.updateValue]}}),e._v(" "),s("div",{staticClass:"dvs-toggle-slider"})])},staticRenderFns:[]}},pQZG:function(e,t,s){var n=s("VU/8")(s("QKS3"),s("BjSH"),!1,null,null,null);e.exports=n.exports},ybne:function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=s("QKlT"),r=s.n(n),i=s("oqQY"),o=s.n(i),l=s("NYxO"),a=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var s=arguments[t];for(var n in s)Object.prototype.hasOwnProperty.call(s,n)&&(e[n]=s[n])}return e};t.default={name:"SuperTableDates",data:function(){return{afterConfig:{enableTime:!1,dateFormat:"F d Y"},beforeConfig:{enableTime:!1,dateFormat:"F d Y"},after:"",before:"",dates:{after:"",before:""},searchMethod:null,preventUpdate:!1}},created:function(){var e=this.filters[this.type].dates;if(e.hasOwnProperty(this.column)){var t=e[this.column];t.hasOwnProperty("after")&&""!==t.after&&(this.after=o()(t.after,"YYYY-MM-DD").format("MMMM D YYYY"),this.dates.after=t.after),t.hasOwnProperty("before")&&""!==t.before&&(this.before=o()(t.before,"YYYY-MM-DD").format("MMMM D YYYY"),this.dates.before=t.before)}},methods:a({},Object(l.b)(["updateFilters"]),{onAfterChange:function(e,t,s){this.dates.after=t?o()(t,"MMMM D YYYY").format("YYYY-MM-DD"):"",this.update()},onBeforeChange:function(e,t,s){this.dates.before=t?o()(t,"MMMM D YYYY").format("YYYY-MM-DD"):"",this.update()},clear:function(){this.after="",this.before=""},update:function(){var e={};e[this.type]=this.filters[this.type],e[this.type].dates[this.column]=this.dates,e[this.type].page=1,this.updateFilters(e)}}),computed:a({},Object(l.c)(["filters"])),components:{flatPickr:r.a},props:["type","column"]}}});