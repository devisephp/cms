<script>

import Slice from './Slice'
import Strings from './mixins/Strings'

export default {
  name: 'DeviseSlices',
  functional: true,
  render (h, ctx) {
    if (ctx.props.slices && ctx.props.slices.length) {
      return ctx.props.slices.map(function (s) {
        if (s.config && s.config.numberOfInstances) {
          var placeholderSlices = []
          for (var i = 0; i < s.config.numberOfInstances; i++) {
            placeholderSlices.push(
              h(Slice, Object.assign({}, ctx.data, {
                key: Strings.methods.randomString(8),
                props: {
                  devise: s,
                  editorMode: ctx.props.editorMode
                }
              }))
            )
          }
          return placeholderSlices
        } else {
          // If it's a placeholder for model or repeatable's we need to dig down
          // one level and use the placeholder's slices.
          if (s.metadata.type === 'repeats' || s.metadata.type === 'model') {
            if (s.slices) {
              let slices = s.slices.map(s => h(
                Slice, 
                Object.assign({}, ctx.data, { 
                  key: Strings.methods.randomString(8),
                  props: { 
                    devise: s,
                    editorMode: ctx.props.editorMode
                  }
                })
              ))
              return slices
            }
          } else {
            let slice = h(Slice, Object.assign({}, ctx.data, {
              key: Strings.methods.randomString(8),
              props: {
                devise: s,
                editorMode: ctx.props.editorMode
              }
            }))
            return slice
          }
        }
      })
    }
  },
  mounted () {
    // Emit the bus event to notifify that we are done loading
    this.$nextTick(function () {
      // Emit the bus event to notifify that we are done loading
      devise.$bus.$emit('devise-loaded')
    })
  },
  props: [
    'editorMode'
  ],
  mixin: []
}
</script>
