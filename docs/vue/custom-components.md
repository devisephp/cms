# Custom Components

## Updating components

Sometimes you are going to want to update your component when changes are made from a Devise field. In the example below we allow the content editor to change if the slider autoplays or not. If they change the setting to true from false nothing will happen because the slider has already been initialized with the setting of false. We want to "rebuild" the slider with the new prop values on save. To do the following take a look at these two file examples:

1. slider.blade.php - This file is the Devise Slice that contains the custom component `<slider>`.
2. Slider.vue - Is the slider component that is really doing all the heavy lifting

In Slider.vue we provide code to rebuild the slider in the "rebuild" method of the component. (We are using [TinySlider](https://github.com/ganlanyuan/tiny-slider) in this example). That method is exposed to our Devise Slice by referencing the component. Since Devise emits an event on save (`devise-page-saved`) we can listen for that global event and call the rebuild function to destroy the TinySlider and build it again (this time with the autosave set as the new value coming into the component as a prop).

slider.blade.php

```javascript
@section('template')
  <div>
    <slider
      ref="slider"
      :autoplay="devise.autoplay.checked">
      @slices
    </slider>
  </div>
@endsection

@section('component')
  <script>
    let component = {
      description: 'Slider of things',
      fields: {
        autoplay: {
          label: "Autoplay",
          type: 'checkbox',
          default: {
            value: false
          }
        }
      },
      mounted: function () {
        var self = this
        deviseSettings.$bus.$on('devise-page-saved', function () {
          self.$refs.slider.rebuild()
        })
      }
    }
  </script>
@endsection
```

Slider.vue

```javascript
<template>
  <div :class="controlStyle">
    <div class="slider">
      <slot></slot>
    </div>
  </div>
</template>

<script>
import { tns } from "tiny-slider/src/tiny-slider";

export default {
  data() {
    return {
      slider: null
    };
  },
  props: {
    autoplay: {
      type: Boolean,
      default: false
    }
  },
  mounted() {
    this.build();
  },
  methods: {
    build() {
      this.slider = tns({
        container: this.$el.getElementsByClassName("slider")[0],
        items: 1,
        slideBy: "page",
        autoplay: this.autoplay,
        autoplayButtonOutput: false,
        autoplayHoverPause: true,
        autoplayResetOnVisibility: true,
      });
    },
    rebuild() {
      this.slider.destroy();
      this.build();
    }
  }
};
</script>
```

But sometimes you want the user to _preview_ the change before they save. No problem. Just listen for the `devise-slice-changed` event.

```javascript
@section('template')
  <div>
    <slider
      ref="slider"
      :autoplay="devise.autoplay.checked">
      @slices
    </slider>
  </div>
@endsection

@section('component')
  <script>
    let component = {
      description: 'Slider of things',
      fields: {
        autoplay: {
          label: "Autoplay",
          type: 'checkbox',
          default: {
            value: false
          }
        }
      },
      mounted: function () {
        var self = this
        deviseSettings.$bus.$on('devise-slice-changed', function () {
          self.$refs.slider.rebuild()
        })
      }
    }
  </script>
@endsection
```
