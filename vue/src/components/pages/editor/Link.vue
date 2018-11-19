<template>
  <field-editor :options="options" v-model="localValue" :showEditor="showEditor" @toggleShowEditor="toggleEditor" @cancel="cancel">

    <template slot="preview">
      <span v-if="localValue.text === null || localValue.text === ''" class="dvs-italic">
        Currently No Value
      </span>
      <div><a :href="localValue.href" :target="localValue.target">{{localValue.text}}</a></div>
    </template>

    <template slot="editor">
      <fieldset class="dvs-fieldset">
        <label>Label</label>
        <input ref="focusInput" type="text" class="dvs-mb-4" v-model="localValue.text" v-on:input="updateValue()">
      </fieldset>

      <label>Link Mode</label>
      <div class="dvs-flex">
        <label>
        <input type="radio" class="dvs-w-auto dvs-mr-2" v-model="localValue.mode" value="url" v-on:input="updateValue()">
        URL
        </label>
      </div>
      <div class="dvs-flex dvs-mb-4">
        <label>
        <input type="radio" class="dvs-w-auto dvs-mr-2" v-model="localValue.mode" value="page" v-on:input="updateValue()">
        Page
        </label>
      </div>

      <template v-if="localValue.mode === 'url'">
        <fieldset class="dvs-fieldset">
          <label>URL</label>
          <input type="text" v-model="localValue.href" v-on:input="updateValue()">
        </fieldset>
      </template>
      <template v-if="localValue.mode === 'page'">
        <fieldset class="dvs-fieldset">
          <label>Page</label>
          <select v-model="localValue.routeName" @change="updateValue()">
            <option :value="0">Select a Page</option>
            <option :value="page.route_name" v-for="page in pagesList.data" :key="page.id">{{page.title}}</option>
          </select>
        </fieldset>
      </template>
    </template>

  </field-editor>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'

export default {
  name: 'LinkEditor',
  data () {
    return {
      localValue: {},
      showEditor: false
    }
  },
  mounted () {
    this.originalValue = Object.assign({}, this.value)
    this.localValue = this.value

    this.retrieveAllPagesList()
  },
  methods: {
    ...mapActions('devise', [
      'getPagesList'
    ]),
    toggleEditor () {
      this.showEditor = !this.showEditor
      this.focusForm()
    },
    focusForm () {
      if (this.showEditor) {
        this.$nextTick(() => {
          setTimeout(() => {
            this.$refs.focusInput.focus()
          }, 200);
        })
      }
    },
    retrieveAllPagesList (loadbar = true) {
      let filters = {language_id:deviseSettings.$page.language.id}
      this.getPagesList(filters).then(function () {
        if (loadbar) {
          devise.$bus.$emit('incrementLoadbar', self.modulesToLoad)
        }
      })
    },
    cancel () {
      this.localValue.mode = this.originalValue.mode
      this.localValue.text = this.originalValue.text
      this.localValue.href = this.originalValue.href
      this.localValue.routeName = this.originalValue.routeName
      this.updateValue()
      this.toggleEditor()
    },
    updateValue: function () {
      // Emit the number value through the input event
      this.$emit('input', this.localValue)
      this.$emit('change', this.localValue)
    }
  },
  computed: {
    ...mapGetters('devise', [
      'pagesList'
    ]),
  },
  props: ['value', 'options'],
  components: {
    FieldEditor: () => import(/* webpackChunkName: "devise-editors" */ './Field'),
  }
}
</script>
