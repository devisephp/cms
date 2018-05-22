<template>
  <div>
    <div class="dvs-mb-10">
      <fieldset class="dvs-fieldset">
        <label>Presets</label>
        <select @change="selectPreset($event)">
          <option value="">Select a Preset</option>
          <option value="Default">Default</option>
          <option value="Purple Dinosaur">Purple Dinosaur</option>
        </select>
      </fieldset>
    </div>

    <div class="dvs-flex dvs-w-full">
      <div class="dvs-w-1/4">
        <color-editor v-model="localValue.sidebarTop" :options="{label: 'Sidebar Top Color', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.sidebarBottom" :options="{label: 'Sidebar Bottom Color', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.sidebarText" :options="{label: 'Sidebar Text Color', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.buttonsActionText" :options="{label: 'Action Button Text', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.buttonsActionLeft" :options="{label: 'Action Button Left', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.buttonsActionRight" :options="{label: 'Action Button Right', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.buttonsActionShadowColor" :options="{label: 'Action Button Shadow Color', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <text-editor v-model="localValue.buttonsActionShadowSize" :options="{label: 'Action Button Shadow Size', hidePreview: true}" class="dvs-mb-4"></text-editor>
        <color-editor v-model="localValue.userBackground" :options="{label: 'User Block Background', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.userText" :options="{label: 'User Block Text', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.userShadowColor" :options="{label: 'User Block Shadow Color', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <text-editor v-model="localValue.userShadowSize" :options="{label: 'User Block Shadow Size', hidePreview: true}" class="dvs-mb-4"></text-editor>
        <color-editor v-model="localValue.statsLeft" :options="{label: 'Info Block Background Left', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.statsRight" :options="{label: 'Info Block Background Right', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.statsText" :options="{label: 'Info Block Text', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.statsShadowColor" :options="{label: 'Info Block Shadow Color', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <text-editor v-model="localValue.statsShadowSize" :options="{label: 'Info Block Shadow Size', hidePreview: true}" class="dvs-mb-4"></text-editor>
      </div>

      <div class="dvs-w-3/4 dvs-flex dvs-justify-stretch">

        <div class="dvs-bg-grey-light dvs-rounded dvs-w-full dvs-overflow-hidden dvs-p-1 dvs-flex dvs-flex-col dvs-items-stretch" style="min-height:400px">
          
          <div class="dvs-bg-white dvs-m-4 dvs-rounded dvs-px-4 dvs-py-1 dvs-text-sm" style="height:30px;">
            http://{{ domain }}
          </div>

          <div class="dvs-flex dvs-justify-stretch dvs-relative dvs-flex-grow">
            <div 
              class="dvs-w-1/4 dvs-relative dvs-text-center dvs-p-8"
              style="min-height:400px;" 
              :style="`
                background-image: linear-gradient(180deg, ${localValue.sidebarTop.color} 0%, ${localValue.sidebarBottom.color} 100%);
                color: ${localValue.sidebarText.color}  
              `">

              <!-- Logo -->
              <devise-logo class="dvs-my-4 dvs-mt-2" :color="localValue.sidebarText.color" v-if="!logo" />

              <!-- Titley-ish thing -->
              <div class="dvs-mb-8 dvs-text-2xs dvs-uppercase dvs-font-bold">
                Edit Page: Homepage
              </div>

              <!-- Action Button -->
              <button 
                class="dvs-btn dvs-btn-xs dvs-mb-8" 
                :style="`
                  background-image: linear-gradient(90deg, ${localValue.buttonsActionLeft.color} 0%, ${localValue.buttonsActionRight.color} 100%);
                  color: ${localValue.buttonsActionText.color};
                  box-shadow: -4px -4px ${localValue.buttonsActionShadowSize.text} ${localValue.buttonsActionShadowColor.color};
                `">Save Page
              </button>

              <!-- Some Bonus text stuff... maybe a menu? :) -->
              <ul class="dvs-text-left dvs-text-xs dvs-list-reset">
                <li class="dvs-mb-4">Lorem</li>
                <li class="dvs-mb-4">Lorem</li>
                <li class="dvs-mb-4">Lorem
                  <ul class="dvs-list-reset dvs-ml-4">
                    <li>Ipsum</li>
                  </ul>
                </li>
                <li class="dvs-mb-4">Lorem</li>

              </ul>

              <!-- User Block -->
              <div 
                class="dvs-rounded-sm dvs-flex dvs-items-center dvs-text-xs dvs-p-2 dvs-absolute pin-b pin-l pin-r dvs-m-8"
                :style="`
                  background: ${localValue.userBackground.color};
                  color: ${localValue.userText.color};
                  box-shadow: -4px -4px ${localValue.userShadowSize.text} ${localValue.userShadowColor.color};
                `">
                <div class="dvs-w-3/4">
                  John Doh
                </div>
                <div>
                  <i class="ion-power"></i>
                </div>
              </div>

            </div>

            <div class="dvs-bg-white dvs-w-3/4 dvs-p-4 dvs-relative">
              <h3>Just an example page</h3>
              <p class="dvs-text-xs dvs-mt-4">Bacon ipsum dolor amet brisket porchetta doner shankle sirloin pancetta rump alcatra strip steak pig burgdoggen frankfurter cupim kevin. Bacon alcatra flank buffalo beef andouille spare ribs porchetta. Shank corned beef pork loin bacon beef pork belly frankfurter tri-tip venison tenderloin alcatra chuck prosciutto filet mignon cow. Kielbasa t-bone fatback filet mignon frankfurter burgdoggen biltong tri-tip jerky pork chop. Hamburger pork pork loin, brisket chuck beef turkey spare ribs swine.</p>
              <div class="dvs-flex dvs-justify-between">
                <div class="dvs-bg-grey dvs-rounded dvs-flex dvs-justify-center dvs-items-center dvs-w-1/3 dvs-mr-4" style="height:150px;">
                  <i class="ion-image dvs-text-3xl"></i>
                </div>
                <div class="dvs-bg-grey dvs-rounded dvs-flex dvs-justify-center dvs-items-center dvs-w-2/3" style=" height:150px">
                  <i class="ion-image dvs-text-3xl"></i>
                </div>
              </div>
              <p class="dvs-text-xs dvs-mt-4">Bacon ipsum dolor amet brisket porchetta doner shankle sirloin pancetta rump alcatra strip steak pig burgdoggen frankfurter cupim kevin. Bacon alcatra flank buffalo beef andouille spare ribs porchetta. Shank corned beef pork loin bacon beef pork belly frankfurter tri-tip venison tenderloin alcatra chuck prosciutto filet mignon cow. Kielbasa t-bone fatback filet mignon frankfurter burgdoggen biltong tri-tip jerky pork chop. Hamburger pork pork loin, brisket chuck beef turkey spare ribs swine.</p>
              <p class="dvs-text-xs dvs-mt-4">Bacon ipsum dolor amet brisket porchetta doner shankle sirloin pancetta rump alcatra strip steak pig burgdoggen frankfurter cupim kevin. Bacon alcatra flank buffalo beef andouille spare ribs porchetta. Shank corned beef pork loin bacon beef pork belly frankfurter tri-tip venison tenderloin alcatra chuck prosciutto filet mignon cow. Kielbasa t-bone fatback filet mignon frankfurter burgdoggen biltong tri-tip jerky pork chop. Hamburger pork pork loin, brisket chuck beef turkey spare ribs swine.</p>

              <div class="dvs-absolute dvs-pin-l dvs-pin-r dvs-pin-b dvs-flex dvs-justify-between dvs-items-end dvs-m-8 dvs-p-8 dvs-rounded"
                  :style="`
                    background-image: linear-gradient(90deg, ${localValue.statsLeft.color} 0%, ${localValue.statsRight.color} 100%);
                    color: ${localValue.statsText.color};
                    box-shadow: -4px -4px ${localValue.statsShadowSize.text} ${localValue.statsShadowColor.color};
                  `"
              >
                <div>
                  Analytics
                </div>

                <div 
                  class="dvs-rounded-full dvs-border dvs-border-white dvs-flex dvs-justify-center dvs-align-center dvs-p-8 dvs-text-xl dvs-font-bold" 
                  style="width:100px; height:100px;"
                  :style="`
                    border-color: ${localValue.statsText.color};
                  `">
                  90M
                </div>

                <div 
                  class="dvs-rounded-full dvs-border dvs-border-white dvs-flex dvs-justify-center dvs-align-center dvs-p-8 dvs-text-xl dvs-font-bold" 
                  style="width:100px; height:100px;"
                  :style="`
                    border-color: ${localValue.statsText.color};
                  `">
                  90M
                </div>

                <div 
                  class="dvs-rounded-full dvs-border dvs-border-white dvs-flex dvs-justify-center dvs-align-center dvs-p-8 dvs-text-xl dvs-font-bold" 
                  style="width:100px; height:100px;"
                  :style="`
                    border-color: ${localValue.statsText.color};
                  `">
                  10K
                </div>
              </div>
            </div>


          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>

import ColorEditor from './../pages/editor/Color'
import TextEditor from './../pages/editor/Text'
import DeviseLogo from './../utilities/DeviseLogo'

export default {
  name: 'AdminDesigner',
  data () {
    return {
      logo: null,
      localValue: {
        sidebarTop: {color: '#343434'},
        sidebarBottom: {color: '#2199be'},
        sidebarText: {color: '#ffffff'},
        buttonsActionText: {color: '#ffffff'},
        buttonsActionLeft: {color: '#4e9bb5'},
        buttonsActionRight: {color: '#27afd8'},
        buttonsActionShadowColor: {color: '#1baeda'},
        buttonsActionShadowSize: {text: '30px'},
        userBackground: {color: 'rgba(0,0,0,0.4)'},
        userText: {color: '#ffffff'},
        userShadowColor: {color: '#1baeda'},
        userShadowSize: {text: '30px'},
        statsText: {color: '#ffffff'},
        statsLeft: {color: '#2da2c4'},
        statsRight: {color: '#a67045'},
        statsShadowColor: {color: '#1baeda'},
        statsShadowSize: {text: '30px'}
      },
      presets: {
        Default: {
          sidebarTop: {color: '#343434'},
          sidebarBottom: {color: '#2199be'},
          sidebarText: {color: '#ffffff'},
          buttonsActionText: {color: '#ffffff'},
          buttonsActionLeft: {color: '#4e9bb5'},
          buttonsActionRight: {color: '#27afd8'},
          buttonsActionShadowColor: {color: '#1baeda'},
          buttonsActionShadowSize: {text: '30px'},
          userBackground: {color: 'rgba(0,0,0,0.4)'},
          userText: {color: '#ffffff'},
          userShadowColor: {color: '#1baeda'},
          userShadowSize: {text: '30px'},
          statsText: {color: '#ffffff'},
          statsLeft: {color: '#2da2c4'},
          statsRight: {color: '#a67045'},
          statsShadowColor: {color: '#1baeda'},
          statsShadowSize: {text: '30px'}
        },
        'Purple Dinosaur': {
          sidebarTop: {color: '#855791'},
          sidebarBottom: {color: '#564278'},
          sidebarText: {color: '#ffffff'},
          buttonsActionText: {color: '#ffffff'},
          buttonsActionLeft: {color: '#7148c1'},
          buttonsActionRight: {color: '#c57dd5'},
          buttonsActionShadowColor: {color: '#b92ed7'},
          buttonsActionShadowSize: {text: '30px'},
          userBackground: {color: 'rgba(66,41,118,0.6)'},
          userText: {color: '#ffffff'},
          userShadowColor: {color: '#69267d'},
          userShadowSize: {text: '30px'},
          statsText: {color: '#ffffff'},
          statsLeft: {color: '#57467a'},
          statsRight: {color: '#913ea6'},
          statsShadowColor: {color: '#c67dd4'},
          statsShadowSize: {text: '30px'}
        }
      }
    }
  },
  mounted () {
    // this.localValue.sidebarTop = this.value.sidebarTop
    this.applyStyles(this.value)
  },
  methods: {
    applyStyles (styles) {
      for(var propt in styles){
        if (typeof this.localValue[propt] !== 'undefined') {
          for(var att in styles[propt]){
            if (typeof this.localValue[propt][att] !== 'undefined') {
              this.localValue[propt][att] = styles[propt][att]
            }
          }
        }
      }
    },
    selectPreset (e) {
      if (e.target.value !== '') {
        let preset = e.target.value
        this.applyStyles(this.presets[preset])
        e.target.value = ''
      }
    }
  },
  watch: {
    localValue: {
      handler (val) {
        this.$emit('input', this.localValue)
      },
      deep: true
    }
  },
  components: {
    ColorEditor,
    TextEditor,
    DeviseLogo
  },
  props: ['value', 'domain']
}
</script>