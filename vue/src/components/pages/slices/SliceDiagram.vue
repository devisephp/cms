<template>
<div class="flex justify-center">
  <div v-if="hasPreview" class="my-4 dvs-shadow-lg" style="background-color: rgba(0,0,0,0.2);padding:15px;" :style="{width: width}">
    <div v-html="preview"></div>
  </div>
</div>
</template>

<script>
import { mapGetters } from 'vuex'

var loremIpsum = require('lorem-ipsum')

export default {
  data () {
    return {
      hasPreview: false,
      totalHeight: 0,
      width: '100%'
    }
  },
  mounted () {
    this.checkHasPreview()
    this.setWidth()
  },
  methods: {
    checkHasPreview () {
      if (this.component.preview) {
        this.hasPreview = true
      }
    },
    setWidth () {
      if (this.component.previewWidth && this.component.previewWidth < 1) {
        this.width = `${this.component.previewWidth * 100}%`
      }
    },
    buildPreview (markup) {
      
      let preview = ''
      let markupParts = []

      markup.map((row) => {
        let re = /\{(.*)\}(.*)/g
        let markupPartsArr = re.exec(row)

        if (markupPartsArr) {
          markupParts.push(markupPartsArr)
          this.totalHeight += parseInt(markupPartsArr[2])
        }
      })

      markupParts.map((markupPart) => {
          var html = ' '
          let htmlParts = this.getPreviewHtmlParts(markupPart[1], markupPart[2])
          htmlParts.map((part) => {
            html += part
          })

          preview += html
      })

      return preview
    },
    getPreviewHtmlParts (description, size) {
      let previewHtmlParts = []
      let partDescriptions = description.split(',')
      let height = (size / this.totalHeight) * this.heightOfPreview

      height = (isNaN(height)) ? this.heightOfPreview : height

      // Generate Rows
      previewHtmlParts.push(`<div class="dvs-flex dvs-justify-between" style="height:${height}px">`)
      previewHtmlParts = previewHtmlParts.concat(partDescriptions.map((partDescription) => {
        return this.getPreviewHtmlPart(partDescription.trim(), partDescriptions.length, height)
      }))
      previewHtmlParts.push(`</div>`)

      return previewHtmlParts
    },
    getPreviewHtmlPart (description, columns, height) {
      let type = description.substring(0,1)
      let settings = description.substring(1)
      let width = `${1/columns * 100}%`
      let styles = `width:${width};padding:5px;`

      if (type == 'I') {
        // Icon Size: height * .75 by default, "L" = height, "S" = height * .5 
        let dims = height * .75
        if (settings.includes('s')) {
          dims = height * .5
        } 
        if (settings.includes('l')) {
          dims = height
        }

        return `<div style="${styles}background-color:rgba(255,255,255,0.2)" class="dvs-text-center dvs-relative dvs-mx-4"><svg width="20px" height="20px" class="ion__svg dvs-absolute dvs-pin-t dvs-pin-l dvs-mt-4 dvs-ml-4" viewBox="0 0 512 512"><path d="M112.6 312.3h190.7c4.5 0 7.1-5.1 4.5-8.8l-95.4-153.4c-2.2-3.2-6.9-3.2-9.1 0L108 303.5c-2.6 3.7.1 8.8 4.6 8.8zm194.1-58l35 55.7c1 1.5 2.7 2.4 4.5 2.4h53.2c4.5 0 7.1-5.1 4.5-8.8l-61.6-87.7c-2.2-3.2-6.9-3.2-9.1 0L306.6 248c-1.2 1.8-1.2 4.3.1 6.3zm44.4-86.4c13.1-1.3 23.7-11.9 25-25 1.8-17.7-13-32.5-30.7-30.7-13.1 1.3-23.7 11.9-25 25-1.7 17.7 13 32.5 30.7 30.7z"/><path d="M432 48H80c-17.7 0-32 14.3-32 32v352c0 17.7 14.3 32 32 32h352c17.7 0 32-14.3 32-32V80c0-17.7-14.3-32-32-32zm-2.7 280c0 4.4-3.6 8-8 8H90.7c-4.4 0-8-3.6-8-8V90.7c0-4.4 3.6-8 8-8h330.7c4.4 0 8 3.6 8 8V328z"/></svg></div>`
      }
      if (type == 'T') {
        let text = "Lorem ipsum dolar imet"

        if (settings.includes('c')) {
          styles += 'text-align:center;'
        }
        if (settings.includes('r')) {
          styles += 'text-align:right;'
        }
        if (settings.includes('l')) {
          styles += 'font-size:1.25rem;'
        }
        if (settings.includes('s')) {
          styles += 'font-size:0.75rem;'
        }
        if (settings.includes('~')) {
          let re = /~([0-9]*)/g
          let textLength = re.exec(settings)
          text = loremIpsum({count: textLength[1], units: 'words'})
        }
        if (settings.includes('-')) {
          let re = /-([T,C,M]*)/g
          let verticalAlignment = re.exec(settings)
          if (verticalAlignment[1] === 'C') {
            styles += 'display:flex; align-items:center'
          }
          if (verticalAlignment[1] === 'B') {
            styles += 'display:flex; align-items:end'
          }
        }
        return `<div style="${styles}" class=" dvs-mx-4">${text}</div>`
      }
    }
  },
  computed: {
    ...mapGetters('devise', [
      'componentFromView'
    ]),
    component () {
      return this.componentFromView(this.file.value)
    },
    preview () {
      let component = this.componentFromView(this.file.value)

      if(component.preview) {
        let preview = this.buildPreview(component.preview)
        if(preview) {
          return preview
        }
      }

      return false
    },
  },
  props: {
    file: {
      type: Object,
      required: true
    },
    heightOfPreview: {
      type: Number,
      required: true
    }
  }
}
</script>
