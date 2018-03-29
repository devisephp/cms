<script>

import Slice from './Slice'

export default {
  name: 'DeviseSlices',
  functional: true,
  render (h, ctx) {
    if (ctx.props.devise.slices && ctx.props.devise.slices.length) {
      return ctx.props.devise.slices.map(function (s) {
        if (s.settings && s.settings.numberOfInstances) {
          var placeholderSlices = []
          for (var i = 0; i < s.settings.numberofInstances; i++) {
            placeholderSlices.push(
              h(Slice, {
                props: {
                  slice: s
                }
              })
            )
          }
          return placeholderSlices
        } else {
          return h(Slice, {
            props: {
              slice: s
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
