webpackJsonp([11],{561:function(e,t,a){var n=a(1)(a(599),a(600),!1,null,null,null);e.exports=n.exports},599:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=a(35);t.default={name:"md-create-icon",mixins:[n.a],data:function(){return{iconTitle:this.title?this.title:"Md Create Icon"}}}},600:function(e,t){e.exports={render:function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"ion",class:this.ionClass,attrs:{title:this.iconTitle,name:"md-create-icon"}},[t("svg",{staticClass:"ion__svg",attrs:{viewBox:"0 0 512 512",width:this.w,height:this.h}},[t("path",{attrs:{d:"M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z"}})])])},staticRenderFns:[]}},783:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=a(16),s=a.n(n),o=a(8),i=a.n(o),l=a(296),d=a.n(l),u=a(297),c=a.n(u),r=a(561),v=a.n(r),g=a(5);t.default={name:"LanguagesManage",data:function(){return{localValue:{data:[]},modulesToLoad:1,newLanguage:{code:null}}},mounted:function(){this.retrieveAllLanguages()},methods:i()({},Object(g.b)("devise",["getLanguages","createLanguage","updateLanguage"]),{requestCreateLanguage:function(){this.createLanguage(this.newLanguage)},requestUpdateLanguage:function(e){this.updateLanguage(e).then(function(){e.editCode=!1})},retrieveAllLanguages:function(){var e=this;this.getLanguages().then(function(){e.localValue=s()({},e.localValue,e.languages),e.localValue.data.map(function(t){e.$set(t,"editCode",!1)}),devise.$bus.$emit("incrementLoadbar",e.modulesToLoad)})}}),computed:i()({},Object(g.c)("devise",["languages","settingsMenu"])),components:{Administration:d.a,CreateIcon:v.a,Sidebar:c.a}}},784:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,a=e._self._c||t;return e.languages.data.length?a("div",[a("div",{attrs:{id:"devise-admin-content"}},[a("h3",{staticClass:"dvs-mb-8 dvs-pr-16",style:{color:e.theme.panel.color}},[e._v("Add Language")]),e._v(" "),a("help",{staticClass:"dvs-mb-8"},[e._v("When you add a language to this site it is immediately enabled. Afterwards you can create translated versions of pages that will be linked to one another allowing you to provide ways to switch languages on your front-end. We "),a("a",{staticClass:"dvs-font-bold",attrs:{href:"https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes",target:"_blank"}},[e._v("highly suggest using the ISO 639-1 2 letter codes")]),e._v(" but you can technically use whatever you want.")]),e._v(" "),a("fieldset",{staticClass:"dvs-fieldset dvs-mb-4"},[a("label",[e._v("New Language Code")]),e._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:e.newLanguage.code,expression:"newLanguage.code"}],attrs:{type:"text",maxlength:"2"},domProps:{value:e.newLanguage.code},on:{input:function(t){t.target.composing||e.$set(e.newLanguage,"code",t.target.value)}}})]),e._v(" "),a("button",{staticClass:"dvs-btn dvs-mb-8",style:e.theme.actionButton,attrs:{disabled:null===e.newLanguage.code},on:{click:e.requestCreateLanguage}},[e._v("Save New Language")]),e._v(" "),a("h3",{staticClass:"dvs-mb-8 dvs-pr-16",style:{color:e.theme.panel.color}},[e._v("Existing Languages")]),e._v(" "),a("div",{staticClass:"dvs-mb-12 dvs-flex dvs-flex-col"},e._l(e.localValue.data,function(t,n){return a("div",{key:n,staticClass:"dvs-flex dvs-justify-between dvs-items-center dvs-mb-2"},[a("div",{staticClass:"dvs-text-xl dvs-font-bold dvs-mb-4"},[t.editCode?e._e():[e._v("\n            "+e._s(t.code)+"\n          ")],e._v(" "),a("fieldset",{staticClass:"dvs-fieldset"},[a("input",{directives:[{name:"show",rawName:"v-show",value:t.editCode,expression:"language.editCode"},{name:"model",rawName:"v-model",value:e.localValue.data[n].code,expression:"localValue.data[key].code"}],attrs:{type:"text"},domProps:{value:e.localValue.data[n].code},on:{input:function(t){t.target.composing||e.$set(e.localValue.data[n],"code",t.target.value)}}})])],2),e._v(" "),a("div",{staticClass:"dvs-flex dvs-justify-between dvs-items-center"},[t.editCode?e._e():a("button",{staticClass:"dvs-btn dvs-btn-xs dvs-ml-4",style:e.theme.actionButtonGhost,on:{click:function(e){t.editCode=!t.editCode}}},[a("CreateIcon")],1),e._v(" "),t.editCode?a("button",{staticClass:"dvs-btn dvs-mr-2",style:e.theme.actionButton,on:{click:function(t){e.requestUpdateLanguage(e.localValue.data[n])}}},[e._v("\n              Save Language Code\n          ")]):e._e(),e._v(" "),t.editCode?a("button",{staticClass:"dvs-btn",style:e.theme.actionButtonGhost,on:{click:function(e){t.editCode=!1}}},[e._v("\n              Cancel\n          ")]):e._e()])])}))],1)]):e._e()},staticRenderFns:[]}},836:function(e,t,a){var n=a(1)(a(783),a(784),!1,null,null,null);e.exports=n.exports}});