<script>
import Slice from './Slice';
import Strings from './../../mixins/Strings';

const UNIQUE_KEY_PROP = '__unique_key_prop__';
const KEY_PREFIX = '__key_prefix__' + Date.now() + '_';

let uid = 0;

const isObject = val => val !== null && typeof val === 'object';

const genUniqueKey = obj => {
  if (isObject(obj)) {
    if (UNIQUE_KEY_PROP in obj) {
      return obj[UNIQUE_KEY_PROP];
    }
    const value = KEY_PREFIX + uid++;
    Object.defineProperty(obj, UNIQUE_KEY_PROP, { value });
    return value;
  }
  return obj;
};

export default {
  name: 'DeviseSlices',
  functional: true,
  render(h, ctx) {
    if (ctx.props.slices && ctx.props.slices.length) {
      return ctx.props.slices.map(function(s) {
        // If it's a placeholder for model we need to dig down
        // one level and use the placeholder's slices.
        if (s.metadata.type === 'model') {
          if (s.slices) {
            let slices = s.slices.map(s =>
              h(
                Slice,
                Object.assign({}, ctx.data, {
                  key: genUniqueKey(s),
                  props: {
                    devise: s,
                    editorMode: ctx.props.editorMode
                  }
                })
              )
            );
            return slices;
          }
        } else {
          return h(
            Slice,
            Object.assign({}, ctx.data, {
              key: genUniqueKey(s),
              props: {
                devise: s,
                editorMode: ctx.props.editorMode
              }
            })
          );
        }
      });
    }
  },
  mounted() {
    // Emit the bus event to notifify that we are done loading
    this.$nextTick(function() {
      // Emit the bus event to notifify that we are done loading
      devise.$bus.$emit('devise-loaded');
    });
  },
  props: ['editorMode']
};
</script>
