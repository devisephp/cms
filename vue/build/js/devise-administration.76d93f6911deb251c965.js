webpackJsonp([12],{667:function(e,n,t){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var s=t(13),r=t.n(s),i=t(63),u=t.n(i),a=t(29),o=t.n(a),c=t(257),l=t.n(c),d=t(258),v=t.n(d),f=t(7);n.default={name:"DeviseIndex",methods:{findMenu:function(e){if("object"===(void 0===e?"undefined":o()(e)))var n=u()(e).map(function(n){return e[n]});else n=e;for(var t=0;t<n.length;t++){var s=n[t];if(s.routeName===this.$route.name)return s;if(s.menu){var r=this.findMenu(s.menu);if(r)return r}}}},computed:r()({},Object(f.d)("devise",["adminMenu"]),{currentMenu:function(){return this.findMenu(this.adminMenu)}}),components:{Administration:l.a,Sidebar:v.a}}},668:function(e,n){e.exports={render:function(){var e=this,n=e.$createElement,t=e._self._c||n;return t("div",{staticClass:"dvs-p-8"},[t("h3",{staticClass:"mb-6",style:{color:e.theme.panel.color}},[e._v(e._s(e.currentMenu.label))]),e._v(" "),t("ul",{staticClass:"dvs-list-reset"},[t("transition-group",{attrs:{name:"dvs-fade"}},e._l(e.currentMenu.menu,function(n,s){return t("li",{key:s,staticClass:"dvs-mb-4"},[t("div",{staticClass:"dvs-block dvs-mb-4 dvs-switch-sm dvs-flex dvs-justify-between dvs-items-center dvs-cursor-pointer",style:{color:e.theme.panel.color},on:{click:function(t){e.goToPage(n.routeName,n.parameters)}}},[e._v("\n            "+e._s(n.label)+"\n        ")])])}))],1)])},staticRenderFns:[]}},719:function(e,n,t){var s=t(2)(t(667),t(668),!1,null,null,null);e.exports=s.exports}});