(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["devise-administration"],{adf4:function(e,t,n){"use strict";n.r(t);var r=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",[n("h3",{staticClass:"dvs-p-8 dvs-font-light dvs-uppercase dvs-border-b",style:{color:e.theme.panel.color,borderColor:e.theme.panel.color,backgroundColor:e.theme.panelCard.background}},[e._v(e._s(e.currentMenu.label))]),n("ul",{staticClass:"dvs-list-reset dvs-pb-8"},e._l(e.currentMenu.menu,function(t,r){return n("li",{key:t.id,staticClass:"dvs-py-3 dvs-px-8 dvs-border-t",class:{"dvs-pt-8":0===r},style:{borderTopColor:e.theme.panelCard.background}},[n("div",{staticClass:"dvs-block dvs-switch-sm dvs-flex dvs-justify-between dvs-items-center dvs-cursor-pointer",style:{color:e.theme.panel.color},on:{click:function(n){return e.goToPage(t.routeName,t.parameters)}}},[e._v(e._s(t.label))])])}),0)])},s=[],o=n("cebc"),a=(n("7f7f"),n("a4bb")),u=n.n(a),c=n("7618"),d=n("2f62"),i={name:"DeviseIndex",methods:{findMenu:function(e){var t=e;"object"===Object(c["a"])(e)&&(t=u()(e).map(function(t){return e[t]}));for(var n=0;n<t.length;n+=1){var r=t[n];if(r.routeName===this.$route.name)return r;if(r.menu){var s=this.findMenu(r.menu);if(s)return s}}return!1}},computed:Object(o["a"])({},Object(d["d"])("devise",["adminMenu"]),{currentMenu:function(){return this.findMenu(this.adminMenu)}})},l=i,v=n("0c7c"),b=Object(v["a"])(l,r,s,!1,null,null,null);t["default"]=b.exports}}]);
//# sourceMappingURL=devise-administration.js.map