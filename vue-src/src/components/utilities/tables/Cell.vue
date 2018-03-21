<script>
  export default {
    name: 'Cell',
    data () {
      return {
        eventName: ''
      }
    },
    created () {
      this.$options.template = '<div>' + this.contents + '</div>'
    },
    methods: {
      emit (event) {
        this.eventName = event
        // TODO - Bus needs to be defined
        // Bus.$emit(event, this.record)
      }
    },
    props: ['contents', 'record']
  }
</script>
