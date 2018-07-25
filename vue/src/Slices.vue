<script>

import Slice from './Slice'

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
              h(Slice, {
                props: {
                  devise: s
                }
              })
            )
          }
          return placeholderSlices
        } else {
          // If it's a placeholder for model or repeatable's we need to dig down
          // one level and use the placeholder's slices.
          if (s.metadata.placeholder) {
            if (s.slices) {
              let slices = s.slices.map(s => h(Slice, { 
                props: { 
                  devise: s
                } 
              }))
              return slices
            }
          } else {
            return h(Slice, {
              props: {
                devise: s,
                editorMode: ctx.props.editorMode
              }
            })
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
  ]
}
</script>
