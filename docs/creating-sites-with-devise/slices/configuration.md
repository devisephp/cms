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

If you set the `enabler` property on a field it will add an "enabled" checkbox on the field editor and set it to false by default (Unless you set it's default to true - see above)

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
          instructions: '650px x 650px'
        }
      }
    }
  </script>
@endsection
```

## Editor Label

On the editor sidebar it's not very helpful when you see a huge list of slices, often which repeat. To help the user understand where they are it's helpful to provide an `editorLabel` property to the field that you feel best represents the slice when it's populated. Devise uses the slice name until that field is populated and then replaces it with the contents of that field when the user hydrates that instance. Title fields and even images can serve as great editor labels.

```
@section('component')
  <script>
    let module = {
      config: {
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

## Previews

Previews are wireframes that Devise will draw for you when you provide it with some markup that describes how the slice generally looks. This wireframe, like all wireframes, isn't meant to be a perfect representation but to provide the user with a visual cue of what to expect when selecting a slice.

The markup is an array of strings that represent a full row. of the drawing. There is 250px of height to work with. Here is how the syntax works for a single row:

`'{[Element Type (uppercase)][Element Settings (lowercase)]}[Height of row]`

If you had an image above a title with a paragraph below it you might have markup like this:

```
@section('component')
  <script>
    let module = {
      config: {
        preview: ['{I}20', '{Tlg~3}', '{Tsm~20}']
        someImage: {
          type: 'image',
          label: 'The Image',
        }
      }
    }
  </script>
@endsection
```

You can also put multiple elements on a single row by seperating them with a comma like-a-so:

`['{I, I, I}', '{Tlg~2, Tlg~2, Tlg~2}', '{Tsm~10, Tsm~10, Tsm~10}']`

This would give you a three column version of the Image on top of Title on top of Copy.

### Preview Element Types

#### Text

Text is represented by `T` and can have any number of the following settings trailing it:

##### Alignment

Left Align Default

> `c` Center Text
>
> `r` Right Align Text
>
> Example: Center aligned text
>
> `['{Tc}']`

##### Size

> `l` Large
> `xl` Extra Large
> `s` Small

##### Styles

`b` Bold

`i` Italic

##### Number of Words

`~10` This would generate 10 words

#### Image

Image is represented by `I` and can have any number of the following settings trailing it. Note that the default height of an image is 100px.

##### Sizes

`s` Small

`l` Large

#### Video

Video is represented by `V` and can have any number of the following settings trailing it. Note that the default height of a video is 100px.

##### Sizes

`s` Small

`l` Large

#### Blank

Blanks are represented by `B` and can have any number of the following settings trailing it. Default height is 100px Blanks serve two purposes:

1. They can fill empty space so you can push things over on a row
2. By adding a `bg` you can represent arbitrary blocks.

##### Fill

`bg` Fills the blank area to make it.... not blank.

##### Sizes

`s` Small

`l` Large
