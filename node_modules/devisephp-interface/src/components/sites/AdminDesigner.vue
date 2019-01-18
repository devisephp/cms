<template>
  <div>
    <div class="dvs-mb-10">
      <fieldset class="dvs-fieldset">
        <label>Presets</label>
        <select @change="selectPreset($event)">
          <option value>Select a Preset</option>
          <option :value="key" :key="key" v-for="(preset, key) in presets">{{ key }}</option>
        </select>
      </fieldset>
    </div>

    <div class="dvs-flex dvs-w-full">
      <div class="dvs-w-1/4 dvs-pr-8">
        <h6 class="dvs-mb-2" :style="{color: theme.panel.color}">Panel</h6>
        <color-editor
          v-model="localValue.panelTop"
          :options="{label: 'Panel Top Color', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>
        <color-editor
          v-model="localValue.panelBottom"
          :options="{label: 'Panel Bottom Color', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>
        <color-editor
          v-model="localValue.panelText"
          :options="{label: 'Panel Text Color', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>
        <color-editor
          v-model="localValue.panelAction"
          :options="{label: 'Panel Action Color', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>
        <color-editor
          v-model="localValue.panelSidebarBackground"
          :options="{label: 'Panel Sidebar Background', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>
        <color-editor
          v-model="localValue.panelSidebarText"
          :options="{label: 'Panel Sidebar Icon Color', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>
        <color-editor
          v-model="localValue.panelSidebarAction"
          :options="{label: 'Panel Sidebar Action Color', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>
        <color-editor
          v-model="localValue.panelCardBackground"
          :options="{label: 'Panel Card Background', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>
        <color-editor
          v-model="localValue.panelCardText"
          :options="{label: 'Panel Card Text', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>

        <h6 class="dvs-mb-2 dvs-mt-8" :style="{color: theme.panel.color}">Buttons</h6>
        <color-editor
          v-model="localValue.buttonsActionText"
          :options="{label: 'Action Button Text', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>
        <color-editor
          v-model="localValue.buttonsActionBackground"
          :options="{label: 'Action Button Background', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>
        <color-editor
          v-model="localValue.buttonsSecondaryText"
          :options="{label: 'Secondary Button Text', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>
        <color-editor
          v-model="localValue.buttonsSecondaryBackground"
          :options="{label: 'Secondary Button Background', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>

        <h6 class="dvs-mb-2 dvs-mt-8" :style="{color: theme.panel.color}">Help Blocks</h6>
        <color-editor
          v-model="localValue.helpBackground"
          :options="{label: 'Background Color', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>
        <color-editor
          v-model="localValue.helpText"
          :options="{label: 'Text Color', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>

        <h6 class="dvs-mb-2 dvs-mt-8" :style="{color: theme.panel.color}">Chart Colors</h6>
        <color-editor
          v-model="localValue.chartColor1"
          :options="{label: 'Chart Color 1', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>
        <color-editor
          v-model="localValue.chartColor2"
          :options="{label: 'Chart Color 2', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>
        <color-editor
          v-model="localValue.chartColor3"
          :options="{label: 'Chart Color 3', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>
        <color-editor
          v-model="localValue.chartColor4"
          :options="{label: 'Chart Color 4', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>
        <color-editor
          v-model="localValue.chartColor5"
          :options="{label: 'Chart Color 5', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>
        <color-editor
          v-model="localValue.chartColor6"
          :options="{label: 'Chart Color 6', hidePreview: true, swatch: true}"
          class="dvs-mb-4"
        ></color-editor>
      </div>

      <div class="dvs-w-3/4 dvs-mb-8">
        <h3 class="dvs-mb-4" :style="{color: theme.panel.color}">Mini-Preview of the Editor</h3>
        <div
          class="dvs-bg-grey-light dvs-rounded dvs-w-full dvs-overflow-hidden dvs-p-1 dvs-flex dvs-flex-col dvs-items-stretch dvs-mb-12"
          style="min-height:400px"
        >
          <div
            class="dvs-bg-white dvs-m-4 dvs-rounded dvs-px-4 dvs-py-1 dvs-text-sm"
            style="height:30px;"
          >http://{{ domain }}</div>

          <div class="dvs-relative">
            <div
              class="dvs-absolute dvs-pin-t dvs-pin-l z-10 dvs-text-center dvs-rounded dvs-mt-8 dvs-ml-8 dvs-shadow dvs-min-w-64 dvs-flex dvs-items-stretch"
              :style="`
                background-image: radial-gradient(ellipse at top, ${localValue.panelTop.color} 0%, ${localValue.panelBottom.color} 100%);
                color: ${localValue.panelText.color}  
              `"
            >
              <div
                class="dvs-flex dvs-flex-col dvs-items-center dvs-p-2"
                :style="`
                    background-color: ${localValue.panelSidebarBackground.color};
                    color: ${localValue.panelSidebarText.color};
                  `"
              >
                <div class="dvs-p-2">
                  <document-icon w="18" h="18" :style="localValue.panelSidebarText.color"/>
                </div>
                <div class="dvs-p-2">
                  <cube-icon w="18" h="18" :style="localValue.panelSidebarText.color"/>
                </div>
                <div class="dvs-p-2">
                  <cog-icon w="18" h="18" :style="localValue.panelSidebarText.color"/>
                </div>
                <div class="dvs-p-2">
                  <power-icon w="18" h="18" :style="localValue.panelSidebarText.color"/>
                </div>
              </div>

              <div class="dvs-text-center dvs-w-full dvs-p-8">
                <!-- Some Bonus text stuff... maybe a menu? :) -->
                <ul class="dvs-text-left dvs-text-xs dvs-list-reset dvs-font-bold">
                  <li class="dvs-mb-4">
                    <menu-icon w="18" h="18" class="dvs-mr-2 handle" :style="theme.panelIcons"/>Lorem
                  </li>
                  <li class="dvs-mb-4">
                    <menu-icon w="18" h="18" class="dvs-mr-2 handle" :style="theme.panelIcons"/>Lorem
                  </li>
                  <li class="dvs-mb-4">
                    <menu-icon w="18" h="18" class="dvs-mr-2 handle" :style="theme.panelIcons"/>Lorem
                    <ul class="dvs-list-reset dvs-ml-8">
                      <li
                        class="dvs-mt-2 dvs-mb-4 dvs-p-1 dvs-px-4 dvs-text-sm dvs-rounded-sm"
                        :style="`
                          background-color: ${localValue.buttonsSecondaryBackground.color};
                          color: ${localValue.buttonsSecondaryText.color};
                        `"
                      >Lorem</li>
                    </ul>
                  </li>
                  <li class="dvs-mb-4">
                    <menu-icon w="18" h="18" class="dvs-mr-2 handle" :style="theme.panelIcons"/>Lorem
                  </li>
                </ul>

                <!-- Action Button -->
                <button
                  class="dvs-btn dvs-btn-xs dvs-mb-4 dvs-rounded-full dvs-border"
                  :style="`
                    border-color: ${localValue.buttonsActionBackground.color};
                    color: ${localValue.buttonsActionBackground.color};
                  `"
                >+ Add Slice</button>
                
                <button
                  class="dvs-btn dvs-btn-xs dvs-py-4 dvs-w-full"
                  :style="`
                    background-color: ${localValue.buttonsActionBackground.color};
                    color: ${localValue.buttonsActionText.color};
                  `"
                >Save Page</button>
              </div>
            </div>

            <div class="dvs-bg-white dvs-w-full dvs-p-4 dvs-relative">
              <h3>Just an example page</h3>
              <p
                class="dvs-text-xs dvs-mt-4 dvs-text-black"
              >Bacon ipsum dolor amet brisket porchetta doner shankle sirloin pancetta rump alcatra strip steak pig burgdoggen frankfurter cupim kevin. Bacon alcatra flank buffalo beef andouille spare ribs porchetta. Shank corned beef pork loin bacon beef pork belly frankfurter tri-tip venison tenderloin alcatra chuck prosciutto filet mignon cow. Kielbasa t-bone fatback filet mignon frankfurter burgdoggen biltong tri-tip jerky pork chop. Hamburger pork pork loin, brisket chuck beef turkey spare ribs swine.</p>
              <div class="dvs-flex dvs-justify-between">
                <div
                  class="dvs-bg-grey dvs-rounded dvs-flex dvs-justify-center dvs-items-center dvs-w-1/3 dvs-mr-4"
                  style="height:150px;"
                >
                  <images-icon w="40" h="40"/>
                </div>
                <div
                  class="dvs-bg-grey dvs-rounded dvs-flex dvs-justify-center dvs-items-center dvs-w-2/3"
                  style=" height:150px"
                >
                  <images-icon w="40" h="40"/>
                </div>
              </div>
              <p
                class="dvs-text-xs dvs-mt-4 dvs-text-black"
              >Bacon ipsum dolor amet brisket porchetta doner shankle sirloin pancetta rump alcatra strip steak pig burgdoggen frankfurter cupim kevin. Bacon alcatra flank buffalo beef andouille spare ribs porchetta. Shank corned beef pork loin bacon beef pork belly frankfurter tri-tip venison tenderloin alcatra chuck prosciutto filet mignon cow. Kielbasa t-bone fatback filet mignon frankfurter burgdoggen biltong tri-tip jerky pork chop. Hamburger pork pork loin, brisket chuck beef turkey spare ribs swine.</p>
              <p
                class="dvs-text-xs dvs-mt-4 dvs-text-black"
              >Bacon ipsum dolor amet brisket porchetta doner shankle sirloin pancetta rump alcatra strip steak pig burgdoggen frankfurter cupim kevin. Bacon alcatra flank buffalo beef andouille spare ribs porchetta. Shank corned beef pork loin bacon beef pork belly frankfurter tri-tip venison tenderloin alcatra chuck prosciutto filet mignon cow. Kielbasa t-bone fatback filet mignon frankfurter burgdoggen biltong tri-tip jerky pork chop. Hamburger pork pork loin, brisket chuck beef turkey spare ribs swine.</p>

              <div
                class="dvs-absolute dvs-pin-l dvs-pin-r dvs-pin-b dvs-flex dvs-justify-between dvs-items-end dvs-m-8 dvs-p-8 dvs-rounded"
                :style="`
                    background-color: ${localValue.helpBackground.color});
                    color: ${localValue.panelText.color};
                  `"
              >
                <div>Analytics</div>

                <div
                  class="dvs-rounded-full dvs-border dvs-border-white dvs-flex dvs-justify-center dvs-align-center dvs-p-8 dvs-text-xl dvs-font-bold"
                  style="width:100px; height:100px;"
                  :style="`
                    border-color: ${localValue.panelText.color};
                  `"
                >90M</div>

                <div
                  class="dvs-rounded-full dvs-border dvs-border-white dvs-flex dvs-justify-center dvs-align-center dvs-p-8 dvs-text-xl dvs-font-bold"
                  style="width:100px; height:100px;"
                  :style="`
                    border-color: ${localValue.panelText.color};
                  `"
                >90M</div>

                <div
                  class="dvs-rounded-full dvs-border dvs-border-white dvs-flex dvs-justify-center dvs-align-center dvs-p-8 dvs-text-xl dvs-font-bold"
                  style="width:100px; height:100px;"
                  :style="`
                    border-color: ${localValue.panelText.color};
                  `"
                >10K</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
var lineData = {
  data: {
    labels: ['May 16', 'May 17', 'May 18', 'May 19', 'May 20', 'May 21', 'May 22', 'May 23'],
    datasets: [
      { label: 'Page Views', data: [33, 41, 19, 5, 4, 23, 30, 11] },
      { label: 'Sessions', data: [25, 24, 14, 4, 4, 10, 17, 9] },
      { label: 'Avg. Time On Page', data: [64, 38, 155, 10, 7, 26, 145, 6] },
      { label: 'Bounce Rate', data: [48, 45, 57, 50, 25, 10, 47, 22] }
    ]
  },
  releases: ['Apr 25', 'Apr 24', 'May 2']
};

export default {
  name: 'AdminDesigner',
  data() {
    return {
      localValue: {
        panelTop: { color: null },
        panelBottom: { color: null },
        panelText: { color: null },
        panelAction: { color: null },
        panelSidebarBackground: { color: null },
        panelSidebarText: { color: null },
        panelSidebarAction: { color: null },
        panelCardBackground: { color: null },
        panelCardText: { color: null },
        buttonsActionText: { color: null },
        buttonsActionBackground: { color: null },
        buttonsSecondaryText: { color: null },
        buttonsSecondaryBackground: { color: null },
        helpBackground: { color: null },
        helpText: { color: null },
        chartColor1: { color: null },
        chartColor2: { color: null },
        chartColor3: { color: null },
        chartColor4: { color: null },
        chartColor5: { color: null },
        chartColor6: { color: null }
      },
      presets: {
        Default: {
          panelTop: { color: 'rgb(44, 56, 88)' },
          panelBottom: { color: 'rgb(24, 32, 57)' },
          panelText: { color: '#A7A9E2' },
          panelAction: { color: 'rgb(101, 139, 239)' },
          panelSidebarBackground: { color: '#182039' },
          panelSidebarText: { color: 'rgb(243, 243, 243)' },
          panelSidebarAction: { color: 'rgb(101, 139, 239)' },
          panelCardBackground: { color: '#12182d' },
          panelCardText: { color: '#eeeeee' },
          buttonsActionText: { color: 'rgb(243, 243, 243)' },
          buttonsActionBackground: { color: '#FF8889' },
          buttonsSecondaryText: { color: 'rgb(243, 243, 243)' },
          buttonsSecondaryBackground: { color: 'rgb(24, 32, 57)' },
          helpBackground: { color: '#ffe5e4' },
          helpText: { color: '#FF8889' },
          chartColor1: { color: 'rgba(54, 162, 235, 1)' },
          chartColor2: { color: 'rgba(75, 192, 192, 1)' },
          chartColor3: { color: 'rgba(255, 206, 86, 1)' },
          chartColor4: { color: 'rgba(255,99,132,1)' },
          chartColor5: { color: 'rgba(153, 102, 255, 1)' },
          chartColor6: { color: 'rgba(255, 159, 64, 1)' }
        }
      },
      chartColors: [
        {
          background: 'rgba(54, 162, 235, 0.5)',
          border: 'rgba(54, 162, 235, 1)'
        },
        {
          background: 'rgba(75, 192, 192, 0.2)',
          border: 'rgba(75, 192, 192, 1)'
        },
        {
          background: 'rgba(255, 206, 86, 0.2)',
          border: 'rgba(255, 206, 86, 1)'
        },
        {
          background: 'rgba(255, 99, 132, 0.2)',
          border: 'rgba(255,99,132,1)'
        },
        {
          background: 'rgba(153, 102, 255, 0.2)',
          border: 'rgba(153, 102, 255, 1)'
        },
        {
          background: 'rgba(255, 159, 64, 0.2)',
          border: 'rgba(255, 159, 64, 1)'
        }
      ],
      placeholderLineData: lineData
    };
  },
  mounted() {
    this.setLineGraphStyles();
    this.$nextTick(() => {
      if (typeof this.value.panelTop !== 'undefined') {
        this.applyStyles(this.value);
      } else {
        this.applyStyles(this.presets.Default);
      }
    });
  },
  methods: {
    applyStyles(styles) {
      for (var propt in styles) {
        if (typeof this.localValue[propt] !== 'undefined') {
          for (var att in styles[propt]) {
            if (typeof this.localValue[propt][att] !== 'undefined') {
              this.localValue[propt][att] = styles[propt][att];
            }
          }
        }
      }
    },
    selectPreset(e) {
      if (e.target.value !== '') {
        let preset = e.target.value;
        this.applyStyles(this.presets[preset]);
        e.target.value = '';
      }
    },
    setLineGraphStyles() {
      let self = this;
      this.placeholderLineData.data.datasets.map(function(dataset, index) {
        dataset.backgroundColor = [self.chartColors[index].background];
        dataset.fontColor = self.localValue.panelText.color;
        dataset.borderColor = [self.chartColors[index].border];
        dataset.pointRadius = 4;
        dataset.pointHoverRadius = 10;
        dataset.fill = false;

        return dataset;
      });
    }
  },
  computed: {
    options() {
      return {
        width: '8000px',
        legend: {
          labels: {
            fontColor: this.localValue.panelText.color,
            fontSize: 14
          }
        },
        scales: {
          yAxes: [
            {
              ticks: {
                fontColor: this.localValue.panelText.color,
                fontSize: 12
              }
            }
          ],
          xAxes: [
            {
              ticks: {
                fontColor: this.localValue.panelText.color,
                fontSize: 12
              }
            }
          ]
        }
      };
    }
  },
  watch: {
    localValue: {
      handler(val) {
        this.$emit('input', this.localValue);
      },
      deep: true
    }
  },
  components: {
    ColorEditor: () =>
      import(/* webpackChunkName: "js/devise-editors" */ './../pages/editor/Color'),
    TextEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './../pages/editor/Text'),
    LineChart: () => import(/* webpackChunkName: "js/devise-charts" */ './../pages/analytics/Line'),
    CogIcon: () => import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-cog.vue'),
    CubeIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-cube.vue'),
    DocumentIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-document.vue'),
    MenuIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-menu.vue'),
    PowerIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-power.vue'),
    ImagesIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-images.vue'),
    ArrowRoundBackIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-arrow-round-back.vue')
  },
  props: ['value', 'domain']
};
</script>