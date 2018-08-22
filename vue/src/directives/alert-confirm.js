import Vue from 'vue'

function insertBefore (el, referenceNode) {
  return referenceNode.parentNode.insertBefore(el, referenceNode)
}

export default {
  bind: function (el, binding, vnode) {
    var clickHandler = function (e) {
      // create constructor
      var Confirm = Vue.extend({
        template: `
        <div v-if="show" class="dvs-fixed dvs-pin dvs-z-50">
          <div class="dvs-blocker"></div>
          <div class="dvs-fixed dvs-absolute-center dvs-z-50 dvs-p-8 dvs-rounded dvs-shadow-lg" style="background-color:rgba(0,0,0,0.5)">
            <h3 class="dvs-mb-8 dvs-text-white">Please Confirm</h3>
            <div class="dvs-mb-8 dvs-text-white">${binding.value.message}</div>

            <button class="dvs-btn dvs-btn-danger" @click="ok">Confirm</button>
            <button class="dvs-btn dvs-text-white" @click="cancel">Cancel</button>
            </div>
          </div>
        </div>
        `,
        data: function () {
          return {
            clicks: 0,
            show: true
          }
        },
        methods: {
          ok () {
            binding.value.callback(binding.value.arguments)
            this.close()
          },
          cancel () {
            this.close()
          },
          close () {
            this.show = false
            el.removeEventListener('click', clickHandler, true)
            insertedElement.remove()
          }
        }
      })

      var newEl = document.createElement('devise-confirm')
      var insertedElement = insertBefore(newEl, document.querySelector('#devise-admin'))

      new Confirm().$mount(insertedElement)
    }
    
    el.addEventListener('click', clickHandler)
  }
}
