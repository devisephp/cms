webpackJsonp([4],{"+x/a":function(e,t,s){var a=s("VU/8")(s("Zlkm"),s("6PdP"),!1,null,null,null);e.exports=a.exports},"0nJ8":function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"dvs-p-8"},[s("h3",{staticClass:"mb-6",style:{color:e.theme.panel.color}},[e._v("Mothership")]),e._v(" "),s("ul",{staticClass:"dvs-list-reset dvs-mt-8"},[s("li",{staticClass:"dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold",on:{click:function(t){e.goToPage("devise-ms-analytics-index")}}},[e._v("\n            Analytics\n        ")]),e._v(" "),s("li",{staticClass:"dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold",on:{click:function(t){t.preventDefault(),e.goToPage("devise-ms-releases-index")}}},[e._v("\n            Releases\n        ")]),e._v(" "),s("li",{staticClass:"dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold",on:{click:function(t){t.preventDefault(),e.goToPage("devise-ms-healthreports-index")}}},[e._v("\n            Health Report\n        ")]),e._v(" "),s("li",{staticClass:"dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold",on:{click:function(t){t.preventDefault(),e.goToPage("devise-ms-backups-index")}}},[e._v("\n            Backups\n        ")])])])},staticRenderFns:[]}},"1bZM":function(e,t,s){var a=s("VU/8")(s("dMoT"),s("GEyl"),!1,null,null,null);e.exports=a.exports},"2XHl":function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",[s("div",{attrs:{id:"devise-admin-content"}},[s("action-bar",[s("li",{staticClass:"dvs-btn dvs-btn-sm dvs-mb-2",style:e.theme.actionButton,on:{click:function(t){t.preventDefault(),e.showCreateForm()}}},[e._v("\n        Create New Release\n      ")])]),e._v(" "),s("h2",{staticClass:"dvs-mb-10"},[e._v("Releases")]),e._v(" "),e._l(e.pushedReleases,function(t){return s("div",{key:t.id,staticClass:"dvs-mb-6 dvs-flex dvs-justify-between dvs-items-center"},[s("div",{staticClass:"dvs-min-w-2/5 dvs-font-bold dvs-pr-8"},[e._v("\n        "+e._s(t.message)+"\n      ")]),e._v(" "),s("div",{staticClass:"dvs-min-w-1/5 dvs-text-sm dvs-px-8 dvs-font-mono"},[e._v("\n        "+e._s(e.trucatedHash(t.commit_hash))+"\n      ")]),e._v(" "),s("div",{staticClass:"dvs-w-2/5 dvs-px-8 dvs-flex dvs-justify-end"},[e.releaseWasPulled(t.id)?s("button",{staticClass:"dvs-btn dvs-btn-xs dvs-mr-2",style:e.theme.actionButtonGhost},[e._v("Pulled\n        ")]):s("button",{staticClass:"dvs-btn dvs-btn-xs dvs-mr-2",style:e.theme.actionButtonGhost,on:{click:function(s){e.pullRelease(t.id)}}},[e._v("Pull\n        ")])])])}),e._v(" "),e.releasesLoaded&&0===e.pushedReleases.length?s("div",[s("p",[e._v("Mothership releases has not been initiated.")]),e._v(" "),s("button",{staticClass:"dvs-btn dvs-block dvs-w-full",style:e.theme.actionButton,on:{click:function(t){t.preventDefault(),e.initiateReleases(!1)}}},[e._v("\n        Initiate Mothership Releases\n      ")])]):e._e()],2),e._v(" "),s("transition",{attrs:{name:"dvs-fade"}},[s("portal",{attrs:{to:"devise-root"}},[e.showCreate?s("devise-modal",{staticClass:"dvs-z-50",on:{close:function(t){e.showCreate=!1}}},[s("h3",{staticClass:"dvs-mb-4",style:{color:e.theme.panel.color}},[e._v("Create New Release")]),e._v(" "),e._l(e.recentUpdates,function(t){return s("div",{key:t.id,staticClass:"dvs-mb-6 dvs-items-center"},[s("div",{staticClass:"dvs-w-full dvs-font-bold dvs-pr-8"},[s("label",[s("input",{attrs:{type:"checkbox"}}),e._v(" "+e._s(t.model))])]),e._v(" "),e._l(t.changes,function(t){return s("div",{key:t.id,staticClass:"dvs-w-full dvs-mb-6 dvs-mt-6 dvs-flex dvs-justify-between dvs-items-center"},[s("div",{staticClass:"dvs-min-w-2/5 dvs-font-bold dvs-pr-8"},[e._v("\n              "+e._s(t.description)+"\n            ")]),e._v(" "),s("div",{staticClass:"dvs-min-w-1/5 dvs-text-sm dvs-px-8 dvs-font-mono"},[e._v("\n              "+e._s(t.updated_at)+"\n            ")])])})],2)}),e._v(" "),s("fieldset",{staticClass:"dvs-fieldset dvs-mb-4"},[s("label",[e._v("Message")]),e._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:e.newRelease.message,expression:"newRelease.message"}],attrs:{type:"text",placeholder:"Release Message"},domProps:{value:e.newRelease.message},on:{input:function(t){t.target.composing||e.$set(e.newRelease,"message",t.target.value)}}})]),e._v(" "),s("button",{staticClass:"dvs-btn",style:e.theme.actionButton,attrs:{disabled:e.createInvalid},on:{click:e.requestCreateRelease}},[e._v("Create\n        ")]),e._v(" "),s("button",{staticClass:"dvs-btn",style:e.theme.actionButtonGhost,on:{click:function(t){e.showCreate=!1}}},[e._v("Cancel")])],2):e._e()],1)],1)],1)},staticRenderFns:[]}},"32O9":function(e,t,s){var a=s("VU/8")(s("VEJa"),s("2XHl"),!1,null,null,null);e.exports=a.exports},"56ak":function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default={name:"MothershipIndex"}},"6PdP":function(e,t){e.exports={render:function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"dvs-fixed dvs-pin"},[t("div",{staticClass:"dvs-blocker dvs-fixed dvs-pin",on:{click:this.close}}),this._v(" "),t("div",{staticClass:"dvs-absolute dvs-absolute-center dvs-z-50 dvs-min-w-2/3 dvs-max-h-screen"},[t("panel",{staticClass:"dvs-w-full",attrs:{"panel-style":this.theme.panel}},[t("div",{staticClass:"dvs-p-8"},[t("div",{on:{click:this.close}},[t("close-icon",{staticClass:"dvs-absolute dvs-pin-t dvs-pin-r dvs-m-6 dvs-cursor-pointer",style:{color:this.theme.panel.color},attrs:{w:"40",h:"40"}})],1),this._v(" "),this._t("default")],2)])],1)])},staticRenderFns:[]}},"9CyW":function(e,t,s){var a=s("VU/8")(s("iqC/"),s("xAKU"),!1,null,null,null);e.exports=a.exports},ECiu:function(e,t){e.exports={render:function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"dvs-flex dvs-justify-end dvs-items-stretch dvs-min-h-screen dvs-relative"},[t("div",{style:this.sidebarTheme,attrs:{id:"devise-sidebar","data-simplebar":""}},[t("sidebar-header",{attrs:{title:"Network Analytics","back-text":"Back to Mothership","back-page":"devise-mothership-index"}})],1),this._v(" "),t("div",{attrs:{id:"devise-admin-content"}},[this._v("\n        It's time to health report!\n    ")])])},staticRenderFns:[]}},Ev1r:function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a=s("Dd8w"),n=s.n(a),i=s("NYxO");t.default={name:"MothershipChanges",data:function(){return{analytics:null,minimized:!1,localValue:null}},mounted:function(){this.retrieveChanges()},methods:n()({},Object(i.b)("devise",["getPendingChanges"]),{retrieveChanges:function(){var e=this;this.getPendingChanges().then(function(t){e.$set(e,"localValue",t.data)})}}),computed:n()({},Object(i.c)("devise",["changes"]))}},FTOH:function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});s("NYxO"),s("bR4V");t.default={name:"MothershipHealthReports"}},GEyl:function(e,t){e.exports={render:function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"ion",class:this.ionClass,attrs:{title:this.iconTitle,name:"ios-close-icon"}},[t("svg",{staticClass:"ion__svg",attrs:{width:this.w,height:this.h,viewBox:"0 0 512 512"}},[t("path",{attrs:{d:"M278.6 256l68.2-68.2c6.2-6.2 6.2-16.4 0-22.6-6.2-6.2-16.4-6.2-22.6 0L256 233.4l-68.2-68.2c-6.2-6.2-16.4-6.2-22.6 0-3.1 3.1-4.7 7.2-4.7 11.3 0 4.1 1.6 8.2 4.7 11.3l68.2 68.2-68.2 68.2c-3.1 3.1-4.7 7.2-4.7 11.3 0 4.1 1.6 8.2 4.7 11.3 6.2 6.2 16.4 6.2 22.6 0l68.2-68.2 68.2 68.2c6.2 6.2 16.4 6.2 22.6 0 6.2-6.2 6.2-16.4 0-22.6L278.6 256z"}})])])},staticRenderFns:[]}},Jln6:function(e,t){e.exports={render:function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"dvs-flex dvs-justify-end dvs-items-stretch dvs-min-h-screen dvs-relative"},[t("div",{style:this.sidebarTheme,attrs:{id:"devise-sidebar","data-simplebar":""}},[t("sidebar-header",{attrs:{title:"Network Analytics","back-text":"Back to Mothership","back-page":"devise-mothership-index"}})],1),this._v(" "),t("div",{attrs:{id:"devise-admin-content"}},[this._v("\n        It's time to back up!\n    ")])])},staticRenderFns:[]}},L5oT:function(e,t,s){var a=s("VU/8")(s("WHf3"),s("Jln6"),!1,null,null,null);e.exports=a.exports},THaN:function(e,t,s){var a=s("VU/8")(s("56ak"),s("0nJ8"),!1,null,null,null);e.exports=a.exports},VEJa:function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a=s("Dd8w"),n=s.n(a),i=s("+x/a"),o=s.n(i),l=s("NYxO");t.default={name:"MothershipReleases",data:function(){return{showCreate:!1,releasesLoaded:!1,pushedReleases:[],pulledReleases:[],newRelease:{message:null,ids:[]},recentUpdates:[]}},mounted:function(){this.fetchAllReleases()},methods:n()({},Object(l.b)("devise",["getPushedReleases","getPulledReleases","getPendingChanges","initReleases"]),{fetchAllReleases:function(){var e=this;this.getPulledReleases().then(function(t){e.pulledReleases=t.data,e.getPushedReleases().then(function(t){e.pushedReleases=t.data,e.releasesLoaded=!0})})},initiateReleases:function(e){var t=this;this.initReleases(e).then(function(e){e.hasOwnProperty("response")&&422===e.response.status?t.showForceRequiredMessage():t.fetchAllReleases()})},showForceRequiredMessage:function(){confirm("You have uncommitted changes. Are you sure you want to create a release without committing your source?")&&this.initiateReleases(!0)},trucatedHash:function(e){return e.substring(0,6)+"..."},releaseWasPulled:function(e){return this.pulledReleases.indexOf(e)>-1},pullRelease:function(e){console.log("go")},showCreateForm:function(){this.showCreate=!0,this.loadPendingChanges()},loadPendingChanges:function(){var e=this;e.getPendingChanges().then(function(t){e.recentUpdates=t.data.data})},requestCreateRelease:function(){console.log("go")}}),computed:{createInvalid:function(){return null===this.newRelease.message}},components:{DeviseModal:o.a}}},WHf3:function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});s("NYxO"),s("bR4V");t.default={name:"MothershipBackups"}},Zlkm:function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a=s("1bZM"),n=s.n(a),i=s("Px9n"),o=s.n(i);t.default={methods:{close:function(){this.$emit("close")}},components:{CloseIcon:n.a,Panel:o.a}}},bOdI:function(e,t,s){"use strict";t.__esModule=!0;var a,n=s("C4MV"),i=(a=n)&&a.__esModule?a:{default:a};t.default=function(e,t,s){return t in e?(0,i.default)(e,t,{value:s,enumerable:!0,configurable:!0,writable:!0}):e[t]=s,e}},dMoT:function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a=s("MwzP");t.default={name:"ios-close-icon",mixins:[a.a],data:function(){return{iconTitle:this.title?this.title:"Ios Close Icon"}}}},iRRR:function(e,t,s){var a=s("VU/8")(s("FTOH"),s("ECiu"),!1,null,null,null);e.exports=a.exports},"iqC/":function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a,n=s("bOdI"),i=s.n(n),o=s("Dd8w"),l=s.n(o),r=s("NYxO"),c=s("bR4V");t.default={name:"MothershipAnalytics",data:function(){return{analytics:null,site:null,analyticsDateRange:{start:null,end:null}}},mounted:function(){this.setDefaultAnalytics()},methods:l()({},Object(r.b)("devise",["getSiteAnalytics"]),(a={setDefaultAnalytics:function(){var e=new Date,t=new Date;t.setDate(t.getDate()-7),this.analyticsDateRange.start=this.formatDate(t),this.analyticsDateRange.end=this.formatDate(e)},formatColors:function(e,t){if(e.fontColor=this.theme.panel.color,void 0!==this.theme.chartColor1){e.borderColor=[],e.backgroundColor=[],e.pointBackgroundColor=this.theme.chartColor1.color,e.pointBorderColor=this.theme.chartColor1.color;for(var s=1;s<7;s++)void 0!==this.theme["chartColor"+s]&&(e.borderColor[s]=this.theme["chartColor"+s].color,e.backgroundColor[s]=this.theme["chartColor"+s].color)}else e.borderColor=this.theme.panel.color,e.backgroundColor=this.theme.statsLeft.color,e.pointBackgroundColor=this.theme.statsRight.color,e.pointBorderColor=this.theme.statsRight.color;return e.pointRadius=4,e.pointHoverRadius=4,e.fill=!1,e}},i()(a,"formatColors",function(e,t){if(e.fontColor=this.theme.panel.color,void 0!==this.theme.chartColor1){e.borderColor=[],e.backgroundColor=[],e.pointBackgroundColor=this.theme.chartColor1.color,e.pointBorderColor=this.theme.chartColor1.color;for(var s=1;s<7;s++)void 0!==this.theme["chartColor"+s]&&(e.borderColor[s-1]=this.theme["chartColor"+s].color,e.backgroundColor[s-1]=this.theme["chartColor"+s].color)}else e.borderColor=this.theme.panel.color,e.backgroundColor=this.theme.statsLeft.color,e.pointBackgroundColor=this.theme.statsRight.color,e.pointBorderColor=this.theme.statsRight.color;return e.pointRadius=4,e.pointHoverRadius=4,e.fill=!1,e}),i()(a,"retrieveAnalytics",function(){var e=this,t=this;this.mothershipApiKey&&("string"!=typeof this.analyticsDateRange.start&&this.analyticsDateRange.start[0]&&(this.analyticsDateRange.start=this.formatDate(new Date(this.analyticsDateRange.start[0]))),"string"!=typeof this.analyticsDateRange.end&&this.analyticsDateRange.end[0]&&(this.analyticsDateRange.end=this.formatDate(new Date(this.analyticsDateRange.end[0]))),this.getSiteAnalytics({site:this.site.id,dates:this.analyticsDateRange}).then(function(s){for(var a in s.data.sessions.datasets.map(function(e,s){return t.formatColors(e,s)}),s.data.channels.datasets.map(function(e,s){return t.formatColors(e,s)}),s.data.browser.datasets.map(function(e,s){return t.formatColors(e,s)}),s.data["date-searched"])s.data["date-searched"].hasOwnProperty(a)&&(s.data["date-searched"][e.formatDate(a)]=s.data["date-searched"][a],delete s.data["date-searched"][a]);t.$set(t,"analytics",s.data)}))}),a)),computed:l()({},Object(r.c)("devise",["mothership","mothershipApiKey","sites"]),{options:function(){return{responsive:!0,maintainAspectRatio:!1,legend:{labels:{fontColor:this.theme.panel.color,fontSize:14}},scales:{yAxes:[{ticks:{fontColor:this.theme.panel.color,fontSize:12}}],xAxes:[{ticks:{fontColor:this.theme.panel.color,fontSize:12}}]}}},barOptions:function(){return{responsive:!0,maintainAspectRatio:!1,legend:{labels:{fontColor:this.theme.panel.color,fontSize:14}},scales:{yAxes:[{ticks:{fontColor:this.theme.panel.color,fontSize:12}}],xAxes:[{ticks:{fontColor:this.theme.panel.color,fontSize:12}}]}}},pieOptions:function(){return{responsive:!0,maintainAspectRatio:!1,legend:{labels:{fontColor:this.theme.panel.color,fontSize:14}}}}}),components:{BarChart:function(){return s.e(13).then(s.bind(null,"cG/d"))},DoughnutChart:function(){return s.e(13).then(s.bind(null,"NEjW"))},PieChart:function(){return s.e(13).then(s.bind(null,"ZLyF"))},LineChart:function(){return s.e(13).then(s.bind(null,"E8vZ"))},DatePicker:function(){return s.e(1).then(s.bind(null,"d73q"))},SimpleTable:function(){return s.e(5).then(s.bind(null,"pQZG"))}},mixins:[c.a]}},ldZi:function(e,t,s){var a=s("VU/8")(s("Ev1r"),s("ojEH"),!1,null,null,null);e.exports=a.exports},ojEH:function(e,t){e.exports={render:function(){this.$createElement;this._self._c;return this._m(0)},staticRenderFns:[function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"dvs-p-8"},[t("h3",{staticClass:"mb-6"},[this._v("Mothership")]),this._v(" "),t("div",{attrs:{id:"devise-admin-content"}},[this._v("\n        It's time to make some changes\n    ")])])}]}},xAKU:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",[s("div",{staticClass:"dvs-relative dvs-full",attrs:{id:"devise-admin-content"}},[null!==e.site?s("div",{staticClass:"dvs-p-8"},[s("h2",{staticClass:"dvs-mb-8",style:{color:e.theme.panel.color}},[e._v("\n          "+e._s(e.site.name)+" Analytics\n        ")]),e._v(" "),s("div",{staticClass:"dvs-flex dvs-mb-8"},[s("fieldset",{staticClass:"dvs-fieldset mr-8"},[s("label",[e._v("Analytics Start Date")]),e._v(" "),s("date-picker",{attrs:{settings:{date:!0,time:!1},placeholder:"Start Date"},on:{update:function(t){e.retrieveAnalytics()}},model:{value:e.analyticsDateRange.start,callback:function(t){e.$set(e.analyticsDateRange,"start",t)},expression:"analyticsDateRange.start"}})],1),e._v(" "),s("fieldset",{staticClass:"dvs-fieldset"},[s("label",[e._v("Analytics End Date")]),e._v(" "),s("date-picker",{attrs:{settings:{date:!0,time:!1},placeholder:"End Date"},on:{update:function(t){e.retrieveAnalytics()}},model:{value:e.analyticsDateRange.end,callback:function(t){e.$set(e.analyticsDateRange,"end",t)},expression:"analyticsDateRange.end"}})],1)]),e._v(" "),null!==e.analytics?[s("div",{staticClass:"dvs-flex dvs-justify-between dvs-text-center dvs-text-xs dvs-mb-8"},[s("div",{staticClass:"dvs-rounded-sm dvs-p-4 dvs-w-1/5",style:e.theme.actionButton},[s("h2",{staticClass:"dvs-font-bold",style:{color:e.theme.actionButton.color}},[e._v("\n              "+e._s(e.analytics["usage-totals"].Users)+"\n            ")]),e._v(" "),s("strong",{staticClass:"dvs-uppercase"},[e._v("Users")])]),e._v(" "),s("div",{staticClass:"dvs-rounded-sm dvs-p-4 dvs-w-1/5",style:e.theme.actionButton},[s("h2",{style:{color:e.theme.actionButton.color}},[e._v("\n              "+e._s(e.analytics["usage-totals"].Sessions)+"\n            ")]),e._v(" "),s("strong",{staticClass:"dvs-uppercase"},[e._v("Sessions")])]),e._v(" "),s("div",{staticClass:"dvs-rounded-sm dvs-p-4 dvs-w-1/5",style:e.theme.actionButton},[s("h2",{style:{color:e.theme.actionButton.color}},[e._v("\n              "+e._s(e.analytics["usage-totals"]["Page Views"])+"\n            ")]),e._v(" "),s("strong",{staticClass:"dvs-uppercase"},[e._v("Page Views")])]),e._v(" "),s("div",{staticClass:"dvs-rounded-sm dvs-p-4 dvs-w-1/5",style:e.theme.actionButton},[s("h2",{style:{color:e.theme.actionButton.color}},[e._v("\n              "+e._s(e.analytics["usage-totals"]["Bounce Rate"])+"\n            ")]),e._v(" "),s("strong",{staticClass:"dvs-uppercase"},[e._v("Bounce Rate")])])]),e._v(" "),s("div",{staticClass:"dvs-flex dvs-flex-col lg:dvs-flex-row dvs-mb-8"},[s("div",{staticClass:"lg:dvs-w-1/2 lg:dvs-pr-10"},[s("div",{staticClass:"dvs-mb-16"},[s("h4",{staticClass:"dvs-mb-4",style:{color:e.theme.panel.color}},[e._v("How are site sessions trending?")]),e._v(" "),s("line-chart",{staticClass:"dvs-mb-8",attrs:{"chart-data":e.analytics.sessions,options:e.options}})],1),e._v(" "),s("div",{staticClass:"dvs-mb-16"},[s("h4",{staticClass:"dvs-mb-4",style:{color:e.theme.panel.color}},[e._v("Channels")]),e._v(" "),s("div",[s("bar-chart",{staticClass:"dvs-mb-8",attrs:{"chart-data":e.analytics.channels,options:e.barOptions}})],1)]),e._v(" "),s("div",{staticClass:"dvs-mb-8"},[s("h4",{staticClass:"dvs-mb-4",style:{color:e.theme.panel.color}},[e._v("Channels")]),e._v(" "),s("div",[s("pie-chart",{staticClass:"dvs-mb-8",attrs:{"chart-data":e.analytics.browser,options:e.pieOptions}})],1)])]),e._v(" "),s("div",{staticClass:"lg:dvs-w-1/2 dvs-p-8 dvs-rounded dvs-shadow-lg",style:e.theme.panelCard},[s("div",{staticClass:"dvs-mb-8"},[s("h4",{staticClass:"dvs-mb-4",style:{color:e.theme.panel.color}},[e._v("What are the top countries by sessions?")]),e._v(" "),s("simple-table",{staticClass:"dvs-w-full",attrs:{data:e.analytics.countries,columns:[{name:"Country"},{name:"Sessions",property:"Sessions"}]}})],1),e._v(" "),s("div",{staticClass:"dvs-mb-8"},[s("simple-table",{staticClass:"dvs-w-full",attrs:{data:e.analytics.regions,columns:[{name:"Region"},{name:"Sessions",property:"Sessions"}]}})],1)])]),e._v(" "),s("div",{staticClass:"dvs-mb-8"},[s("h4",{staticClass:"dvs-mb-4",style:{color:e.theme.panel.color}},[e._v("Acquisition Sources")]),e._v(" "),s("simple-table",{staticClass:"dvs-w-full",attrs:{data:e.analytics["sources-sessions-pageviews"],columns:[{name:"Acquisition Source"},{name:"Sessions",property:"Sessions"},{name:"Pages / Sessions",property:"Pages Per Session"}]}})],1),e._v(" "),s("div",{staticClass:"dvs-mb-8"},[s("h4",{staticClass:"dvs-mb-4",style:{color:e.theme.panel.color}},[e._v("Date Searched")]),e._v(" "),s("simple-table",{staticClass:"dvs-w-full",attrs:{data:e.analytics["date-searched"],columns:[{name:"Date Searched"},{name:"Sessions",property:"Sessions"}]}})],1),e._v(" "),s("div",{staticClass:"dvs-mb-8"},[s("h4",{staticClass:"dvs-mb-4",style:{color:e.theme.panel.color}},[e._v("Landing Page")]),e._v(" "),s("simple-table",{staticClass:"dvs-w-full",attrs:{data:e.analytics["landing-page"],columns:[{name:"Page"},{name:"Sessions",property:"Sessions"}]}})],1),e._v(" "),s("div",{staticClass:"dvs-mb-8"},[s("h4",{staticClass:"dvs-mb-4",style:{color:e.theme.panel.color}},[e._v("Devices")]),e._v(" "),s("simple-table",{staticClass:"dvs-w-full",attrs:{data:e.analytics.devices,columns:[{name:"Date Searched"},{name:"Sessions",property:"Sessions"}]}})],1)]:e._e()],2):s("div",{staticClass:"dvs-p-8"},[s("h2",{staticClass:"dvs-mb-4",style:{color:e.theme.panel.color}},[e._v("To get started select a Site")]),e._v(" "),s("fieldset",{staticClass:"dvs-fieldset"},[s("select",{directives:[{name:"model",rawName:"v-model",value:e.site,expression:"site"}],on:{change:[function(t){var s=Array.prototype.filter.call(t.target.options,function(e){return e.selected}).map(function(e){return"_value"in e?e._value:e.value});e.site=t.target.multiple?s:s[0]},function(t){e.retrieveAnalytics()}]}},[s("option",{domProps:{value:null}},[e._v("Select a site")]),e._v(" "),e._l(e.sites.data,function(t){return s("option",{key:t.id,domProps:{value:t}},[e._v(e._s(t.name))])})],2)])])])])},staticRenderFns:[]}}});