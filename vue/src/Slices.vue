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
          return h(Slice, {
            props: {
              devise: s
            }
          })
        }
      })
    }
  },
  mounted () {
    // Emit the bus event to notifify that we are done loading
    this.$nextTick(function () {
      // Emit the bus event to notifify that we are done loading
      window.bus.$emit('devise-loaded')
    })
  }
}
</script>
