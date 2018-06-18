<template>
  <div v-if="localValue.sidebarTop.color">
    <div class="dvs-mb-10">
      <fieldset class="dvs-fieldset">
        <label>Presets</label>
        <select @change="selectPreset($event)">
          <option value="">Select a Preset</option>
          <option :value="key" v-for="(preset, key) in presets" :key="key">{{ key }}</option>
        </select>
      </fieldset>
    </div>

    <div class="dvs-flex dvs-w-full">
      <div class="dvs-w-1/4 dvs-pt-12">
        <h6 class="dvs-mb-2" :style="{color: theme.adminText.color }">Sidebar</h6>
        <color-editor v-model="localValue.sidebarTop" :options="{label: 'Top Color', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.sidebarBottom" :options="{label: 'Bottom Color', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.sidebarText" :options="{label: 'Text Color', hidePreview: true}" class="dvs-mb-4"></color-editor>

        <h6 class="dvs-mb-2 dvs-mt-8" :style="{color: theme.adminText.color }">Action Buttons</h6>
        <color-editor v-model="localValue.buttonsActionText" :options="{label: 'Text Color', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.buttonsActionLeft" :options="{label: 'Left Color', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.buttonsActionRight" :options="{label: 'Right Color', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.buttonsActionShadowColor" :options="{label: 'Shadow Color', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <text-editor v-model="localValue.buttonsActionShadowSize" :options="{label: 'Shadow Size', hidePreview: true}" class="dvs-mb-4"></text-editor>
        
        <h6 class="dvs-mb-2 dvs-mt-8" :style="{color: theme.adminText.color }">User / Help Blocks</h6>
        <color-editor v-model="localValue.userBackground" :options="{label: 'Background Color', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.userText" :options="{label: 'Text Color', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.userShadowColor" :options="{label: 'Shadow Color', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <text-editor v-model="localValue.userShadowSize" :options="{label: 'Shadow Size', hidePreview: true}" class="dvs-mb-4"></text-editor>

        <h6 class="dvs-mb-2 dvs-mt-8" :style="{color: theme.adminText.color }">Info Block</h6>
        <color-editor v-model="localValue.statsLeft" :options="{label: 'Background Left Color', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.statsRight" :options="{label: 'Background Right Color', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.statsText" :options="{label: 'Text Color', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.statsShadowColor" :options="{label: 'Shadow Color', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <text-editor v-model="localValue.statsShadowSize" :options="{label: 'Shadow Size', hidePreview: true}" class="dvs-mb-4"></text-editor>

        <h6 class="dvs-mb-2 dvs-mt-8" :style="{color: theme.adminText.color }">Admin Wide Windows</h6>
        <color-editor v-model="localValue.adminBackground" :options="{label: 'Background Color', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.adminText" :options="{label: 'Text Color', hidePreview: true}" class="dvs-mb-4"></color-editor>

        <h6 class="dvs-mb-2 dvs-mt-8" :style="{color: theme.adminText.color }">Chart Colors</h6>
        <color-editor v-model="localValue.chartColor1" :options="{label: 'Chart Color 1', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.chartColor2" :options="{label: 'Chart Color 2', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.chartColor3" :options="{label: 'Chart Color 3', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.chartColor4" :options="{label: 'Chart Color 4', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.chartColor5" :options="{label: 'Chart Color 5', hidePreview: true}" class="dvs-mb-4"></color-editor>
        <color-editor v-model="localValue.chartColor6" :options="{label: 'Chart Color 6', hidePreview: true}" class="dvs-mb-4"></color-editor>
      </div>

      <div class="dvs-w-3/4 dvs-mb-8">

        <h3 class="dvs-mb-4" :style="{color: theme.adminText.color}">Mini-Preview of the Editor</h3>
        <div class="dvs-bg-grey-light dvs-rounded dvs-w-full dvs-overflow-hidden dvs-p-1 dvs-flex dvs-flex-col dvs-items-stretch dvs-mb-12" style="min-height:400px">
          
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
              <h2 :style="{color: localValue.sidebarText.color}" class="dvs-mb-2">Editor</h2>
              <div class="dvs-mb-8 dvs-text-2xs dvs-uppercase dvs-font-bold">
                <i class="ion-arrow-left-c"></i> Full Administration
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
              <p class="dvs-text-xs dvs-mt-4 dvs-text-black">Bacon ipsum dolor amet brisket porchetta doner shankle sirloin pancetta rump alcatra strip steak pig burgdoggen frankfurter cupim kevin. Bacon alcatra flank buffalo beef andouille spare ribs porchetta. Shank corned beef pork loin bacon beef pork belly frankfurter tri-tip venison tenderloin alcatra chuck prosciutto filet mignon cow. Kielbasa t-bone fatback filet mignon frankfurter burgdoggen biltong tri-tip jerky pork chop. Hamburger pork pork loin, brisket chuck beef turkey spare ribs swine.</p>
              <div class="dvs-flex dvs-justify-between">
                <div class="dvs-bg-grey dvs-rounded dvs-flex dvs-justify-center dvs-items-center dvs-w-1/3 dvs-mr-4" style="height:150px;">
                  <i class="ion-image dvs-text-3xl"></i>
                </div>
                <div class="dvs-bg-grey dvs-rounded dvs-flex dvs-justify-center dvs-items-center dvs-w-2/3" style=" height:150px">
                  <i class="ion-image dvs-text-3xl"></i>
                </div>
              </div>
              <p class="dvs-text-xs dvs-mt-4 dvs-text-black">Bacon ipsum dolor amet brisket porchetta doner shankle sirloin pancetta rump alcatra strip steak pig burgdoggen frankfurter cupim kevin. Bacon alcatra flank buffalo beef andouille spare ribs porchetta. Shank corned beef pork loin bacon beef pork belly frankfurter tri-tip venison tenderloin alcatra chuck prosciutto filet mignon cow. Kielbasa t-bone fatback filet mignon frankfurter burgdoggen biltong tri-tip jerky pork chop. Hamburger pork pork loin, brisket chuck beef turkey spare ribs swine.</p>
              <p class="dvs-text-xs dvs-mt-4 dvs-text-black">Bacon ipsum dolor amet brisket porchetta doner shankle sirloin pancetta rump alcatra strip steak pig burgdoggen frankfurter cupim kevin. Bacon alcatra flank buffalo beef andouille spare ribs porchetta. Shank corned beef pork loin bacon beef pork belly frankfurter tri-tip venison tenderloin alcatra chuck prosciutto filet mignon cow. Kielbasa t-bone fatback filet mignon frankfurter burgdoggen biltong tri-tip jerky pork chop. Hamburger pork pork loin, brisket chuck beef turkey spare ribs swine.</p>

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

        <h3 class="dvs-mb-4" :style="{color: localValue.adminText.color}">Mini-Preview of the Admin</h3>

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
              <h2 :style="{color: localValue.sidebarText.color}" class="dvs-mb-2">Settings</h2>
              <div class="dvs-mb-8 dvs-text-2xs dvs-uppercase dvs-font-bold">
                <i class="ion-arrow-left-c"></i> Back to Settings
              </div>

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

            <div class="dvs-w-3/4 dvs-p-4 dvs-relative"  :style="{ backgroundColor: localValue.adminBackground.color, color: localValue.adminText.color}">
              <h3 :style="{color: localValue.adminText.color}">Full-width administration page</h3>
              <p class="dvs-text-xs dvs-mt-4">Below are a few examples of things you will see in the administration sections of Devise. Note: when building your own administration sections it is up to you (or your developer) to construct pages utilizing the "theme" variable. It is auto-injected as a computed property in every Devise component.</p>

              <line-chart class="dvs-mb-8" :chart-data="placeholderLineData.data" :options="options" :width="800" :height="200" />

              <h6 class="dvs-mb-4" :style="{color: localValue.adminText.color}"> Buttons</h6>
              <div class="dvs-flex">
                <button class="dvs-btn dvs-mr-4" :style="{
                  backgroundImage: `linear-gradient(90deg, ${localValue.buttonsActionLeft.color} 0%, ${localValue.buttonsActionRight.color} 100%)`,
                  color: localValue.buttonsActionText.color,
                  boxShadow: `-4px -4px ${localValue.buttonsActionShadowSize.text} ${localValue.buttonsActionShadowColor.color}`
                }"
                >
                  Action Button
                </button>

                <button class="dvs-btn" :style="{
                  backgroundColor: localValue.buttonsActionLeft.color,
                  color: localValue.buttonsActionText.color
                }">
                  Regular Button
                </button>
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
import LineChart from './../pages/analytics/Line'

var lineData = {"data":{"labels":["May 16","May 17","May 18","May 19","May 20","May 21","May 22","May 23"],"datasets":[{"label":"Page Views","data":[33,41,19,5,4,23,30,11]},{"label":"Sessions","data":[25,24,14,4,4,10,17,9]},{"label":"Avg. Time On Page","data":[64,38,155,10,7,26,145,6]},{"label":"Bounce Rate","data":[48,45,57,50,25,10,47,22]}]},"releases":["Apr 25","Apr 24","May 2"]}

export default {
  name: 'AdminDesigner',
  data () {
    return {
      logo: null,
      localValue: {
        sidebarTop: {color: null},
        sidebarBottom: {color: null},
        sidebarText: {color: null},
        buttonsActionText: {color: null},
        buttonsActionLeft: {color: null},
        buttonsActionRight: {color: null},
        buttonsActionShadowColor: {color: null},
        buttonsActionShadowSize: {text: null},
        userBackground: {color: null},
        userText: {color: null},
        userShadowColor: {color: null},
        userShadowSize: {text: null},
        statsText: {color: null},
        statsLeft: {color: null},
        statsRight: {color: null},
        statsShadowColor: {color: null},
        statsShadowSize: {text: null},
        adminBackground: {color: null},
        adminText: {color: null},
        chartColor1: {color: null},
        chartColor2: {color: null},
        chartColor3: {color: null},
        chartColor4: {color: null},
        chartColor5: {color: null},
        chartColor6: {color: null}
      },
      presets: {
        Default: {
          sidebarTop: { color:'rgba(240,240,240,1)' },
          sidebarBottom: { color:'rgba(211,211,211,1)' },
          sidebarText: { color:'rgba(34,34,34,1)' },
          buttonsActionText: { color:'rgba(24,24,24,1)' },
          buttonsActionLeft: { color:'rgba(255,255,255,1)' },
          buttonsActionRight: { color:'rgba(231,231,241,1)' },
          buttonsActionShadowColor: { color:'rgba(3,7,32,0.14)' },
          buttonsActionShadowSize: { text:'8px' },
          userBackground: { color:'rgba(0,0,0,0.6)' },
          userText: { color:'#ffffff' },
          userShadowColor: { color:'rgba(0,0,0,0.43)' },
          userShadowSize: { text:'30px' },
          statsText: { color:'rgba(0,0,0,1)' },
          statsLeft: { color:'rgba(255,255,255,0.87)' },
          statsRight: { color:'rgba(212,211,211,0.66)' },
          statsShadowColor: { color:'rgba(0,0,0,0.51)' },
          statsShadowSize: { text:'30px' },
          adminBackground: { color:'rgba(255,255,255,1)' },
          adminText: { color:'rgba(80,80,80,1)' },
          buttonsInverseLeft: { color:'rgb(255, 255, 255)' },
          buttonsInverseRight: { color:'rgb(241, 231, 236)' },
          buttonsInverseText: { color:'rgb(24, 24, 24)' },
          chartColor1: {color: 'rgba(54, 162, 235, 1)'},
          chartColor2: {color: 'rgba(75, 192, 192, 1)'},
          chartColor3: {color: 'rgba(255, 206, 86, 1)'},
          chartColor4: {color: 'rgba(255, 99, 132, 1)'},
          chartColor5: {color: 'rgba(153, 102, 255, 1)'},
          chartColor6: {color: 'rgba(255, 159, 64, 1)'}
        },
        'Blue Sunrise': {
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
          statsShadowSize: {text: '30px'},
          adminBackground: {color: '#2199be'},
          adminText: {color: '#ffffff'},
          chartColor1: {color: 'rgba(54, 162, 235, 1)'},
          chartColor2: {color: 'rgba(75, 192, 192, 1)'},
          chartColor3: {color: 'rgba(255, 206, 86, 1)'},
          chartColor4: {color: 'rgba(255, 99, 132, 1)'},
          chartColor5: {color: 'rgba(153, 102, 255, 1)'},
          chartColor6: {color: 'rgba(255, 159, 64, 1)'}
        },
        'Purple Dinosaur': {
          sidebarTop: { color: '#855791' },
          sidebarBottom: { color: '#564278' },
          sidebarText: { color: '#ffffff' },
          buttonsActionText: { color: '#ffffff' },
          buttonsActionLeft: { color: '#7148c1' },
          buttonsActionRight: { color: '#c57dd5' },
          buttonsActionShadowColor: { color: 'rgba(185,46,215,0.3)' },
          buttonsActionShadowSize: { text: '8px' },
          userBackground: { color: 'rgba(66,41,118,0.6)' },
          userText: { color: '#ffffff' },
          userShadowColor: { color: '#69267d' },
          userShadowSize: { text: '30px' },
          statsText: { color: '#ffffff' },
          statsLeft: { color: 'rgba(70,34,112,0.87)' },
          statsRight: { color: 'rgba(86,26,167,0.66)' },
          statsShadowColor: { color: 'rgba(47,15,83,1)' },
          statsShadowSize: { text: '30px' },
          adminBackground: { color: '#564278' },
          adminText: { color: '#ffffff' },
          buttonsInverseLeft: { color: '#c1485c' },
          buttonsInverseRight: { color: '#d5997d' },
          buttonsInverseText: { color: '#ffffff' },
          chartColor1: {color: 'rgba(54, 162, 235, 1)'},
          chartColor2: {color: 'rgba(75, 192, 192, 1)'},
          chartColor3: {color: 'rgba(255, 206, 86, 1)'},
          chartColor4: {color: 'rgba(255, 99, 132, 1)'},
          chartColor5: {color: 'rgba(153, 102, 255, 1)'},
          chartColor6: {color: 'rgba(255, 159, 64, 1)'}
        },
        'RedRum': {
          sidebarTop: { color: 'rgba(194,33,33,1)' },
          sidebarBottom: { color: 'rgba(83,10,10,1)' },
          sidebarText: { color: '#ffffff' },
          buttonsActionText: { color: '#ffffff' },
          buttonsActionLeft: { color: 'rgba(195,70,70,1)' },
          buttonsActionRight: { color: 'rgba(226,15,15,1)' },
          buttonsActionShadowColor: { color: 'rgba(0,0,0,0.19)' },
          buttonsActionShadowSize: { text: '30px' },
          userBackground: { color: 'rgba(0,0,0,0.4)' },
          userText: { color: '#ffffff' },
          userShadowColor: { color: 'rgba(255,0,0,0.31)' },
          userShadowSize: { text: '30px' },
          statsText: { color: '#ffffff' },
          statsLeft: { color: 'rgba(196,45,45,1)' },
          statsRight: { color: 'rgba(197,33,85,1)' },
          statsShadowColor: { color: 'rgba(218,27,27,1)' },
          statsShadowSize: { text: '30px' },
          adminBackground: { color: 'rgba(177,42,44,1)' },
          adminText: { color: '#ffffff' },
          buttonsInverseLeft: { color: 'rgb(132, 195, 70)' },
          buttonsInverseRight: { color: 'rgb(120, 226, 15)' },
          buttonsInverseText: { color: '#ffffff' },
          chartColor1: {color: 'rgba(54, 162, 235, 1)'},
          chartColor2: {color: 'rgba(75, 192, 192, 1)'},
          chartColor3: {color: 'rgba(255, 206, 86, 1)'},
          chartColor4: {color: 'rgba(255, 99, 132, 1)'},
          chartColor5: {color: 'rgba(153, 102, 255, 1)'},
          chartColor6: {color: 'rgba(255, 159, 64, 1)'}
        }
      },
      chartColors: [
        {
          background:'rgba(54, 162, 235, 0.5)',
          border: 'rgba(54, 162, 235, 1)'
        },
        {
          background:'rgba(75, 192, 192, 0.2)',
          border: 'rgba(75, 192, 192, 1)'
        },
        {
          background:'rgba(255, 206, 86, 0.2)',
          border: 'rgba(255, 206, 86, 1)'
        },
        {
          background:'rgba(255, 99, 132, 0.2)',
          border: 'rgba(255,99,132,1)'
        },
        {
          background:'rgba(153, 102, 255, 0.2)',
          border: 'rgba(153, 102, 255, 1)',
        },
        {
          background:'rgba(255, 159, 64, 0.2)',
          border: 'rgba(255, 159, 64, 1)'
        }
      ],
      placeholderLineData: lineData
    }
  },
  mounted () {
    this.setLineGraphStyles()
    this.applyStyles(this.presets.Default)
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
    },
    setLineGraphStyles () {
      let self = this
      this.placeholderLineData.data.datasets.map(function (dataset, index) {
          dataset.backgroundColor = [self.chartColors[index].background]
          dataset.fontColor = self.theme.statsText.color
          dataset.borderColor = [self.chartColors[index].border]
          dataset.pointRadius = 4
					dataset.pointHoverRadius = 10
					dataset.fill = false

          return dataset
        })
    }
  },
  computed: {
    options () {
      return {
        width: '8000px',
        legend: {
          labels: {
              fontColor: this.theme.statsText.color,
              fontSize: 14
          }
        },
        scales: {
            yAxes: [{
                ticks: {
                    fontColor: this.theme.statsText.color,
                    fontSize: 12
                }
            }],
            xAxes: [{
                ticks: {
                    fontColor: this.theme.statsText.color,
                    fontSize: 12
                }
            }]
        }
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
    DeviseLogo,
    LineChart,
    TextEditor
  },
  props: ['value', 'domain']
}
</script>