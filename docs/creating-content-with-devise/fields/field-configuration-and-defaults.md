# Field Configuration and Defaults

## Defaults

By setting the default property you provide a value before one has been set \(or if it has been set to null\).

```text
@section('component')
  <script>
    var component = {
      fields: {
        someImage: {
          type: 'image',
          label: 'The Image'
          default: {
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

If you set the `enabler` property on a field it will add an "enabled" checkbox on the field editor and set it to false by default \(Unless you set it's default to true as we do in this example\)

```text
@section('template')
  <div v-if="devise.someImage.enabled">
    <img :src="devise.someImage.url" :alt="devise.someImage.alt" class="w-full">
  </div>
@endsection

@section('component')
  <script>
    var component = {
      fields: {
        someImage: {
          type: 'image',
          label: 'The Image',
          enabler: true,
          default: {
            enabled: true
          }
        }
      }
    }
  </script>
@endsection
```

## Instructions

Instructions give a little context to your content manager. It can also serve as some good sudo-documentation at times when you need to remember that image size you cut 3 months ago.

```text
@section('component')
  <script>
    var component = {
      fields: {
        someImage: {
          type: 'image',
          label: 'The Image',
          instructions: 'Ensure this image is suitable for a white background'
        }
      }
    }
  </script>
@endsection
```

## Editor Label

On the editor sidebar it's not very helpful when you see a huge list of slices, often which repeat. To help the user understand where they are it's helpful to provide an `editorLabel` property to the field that you feel best represents the slice when it's populated. Devise uses the slice name until that field is populated and then replaces it with the contents of that field when the user hydrates that instance. Title fields and even images can serve as great editor labels.

```text
@section('component')
  <script>
    var component = {
      fields: {
        someImage: {
          type: 'text',
          label: 'Title',
          editorLabel: true
        }
      }
    }
  </script>
@endsection
```

