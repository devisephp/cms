# Slice Configuration

We've been over a bunch of fields that you can drop into your templates and how to configure them in the component section. But in addition to what you've seen there are a few other options you can pass through to give content managers a little more information and control:

## Defaults

By setting the default property you provide a value before one has been set (or if it has been set to null).

```
@section('component')
  <script>
    let module = {
      config: {
        someImage: {
          type: 'image',
          label: 'The Image'
          default: {
            enabled: true,
            url: '/imgs/default/image-hero.jpg',
            alt: 'We should do this for SEO reasons Jim'
          }
        }
      }
    }
  </script>
@endsection
```

## Enabler

If you set the ```enabler``` property on a field it will add an "enabled" checkbox on the field editor and set it to false by default (Unless you set it's default to true - see above)

```
@section('template')
  <div v-if="devise.someImage.enabled">
    <img :src="devise.someImage.url" :alt="devise.someImage.alt" class="w-full">
  </div>
@endsection

@section('component')
  <script>
    let module = {
      config: {
        someImage: {
          type: 'image',
          label: 'The Image',
          enabler: true
        }
      }
    }
  </script>
@endsection
```

## Instructions

Instructions give a little context to your content manager. It can also serve as some good sudo-documentation at times when you need to remember that image size you cut 3 months ago.

```
@section('component')
  <script>
    let module = {
      config: {
        someImage: {
          type: 'image',
          label: 'The Image',
          enabler: true,
          instructions: '650px x 650px'
        }
      }
    }
  </script>
@endsection
```
<!--
## Slice Types

By default a slice can be used as any type in a template (single, repeats and model) but you can help filter this for your users when they don't make any sense to be included in certain ways. For instance, having the following slice wouldn't make sense to be included as a model because it doesn't utilize any so we'll just include it in the single and repeats.

```
@section('template')
  <div>
    <img :src="devise.someImage.url" :alt="devise.someImage.alt" class="w-full">
  </div>
@endsection

@section('component')
  <script>
    let module = {
      config: {
        forTypes: ['single', 'repeats'],
        someImage: {
          type: 'image',
          label: 'The Image',
          instructions: '650px x 650px'
        }
      }
    }
  </script>
@endsection
``` -->
