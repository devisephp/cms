# Devise Fields

## About Fields and Use Case

Ok, what are exactly are fields and when should they be used. Devise fields are anywhere you want to use non-model-driven dynamic data. A few examples that everyone has run into now and again:

* The "About Us" paragraph on the About page.
* The array of slides that appear in the slideshow hero on the homepage.
* The accent color of a page.
* The legal copy of the site's Terms and Conditions you're selling in English, Spanish and Pashtun.

Creating administration sections in your application that is already doing a bunch of other "real" tasks can be a pain, time consuming, and expensive. (You can continue charging the expensive part if you wish). By implementing devise fields in your slices you can do two very awesome things:

1. You provide a very easy way for the content manager to make in-context edits to the site.
1. You provide a way for your team to recycle design patterns again and again and again. All in different contexts.

This provides your team to be creative when making new templates, easier code to maintain, and quickly and cheaply test different scenarios with end users.

## Available Field Types

Devise ships with a bunch of useful fields for you to drop in. Additionally, you can add your own as well

### Checkbox

The checkbox field is for boolean (true / false) values in your website:

```
@section('template')
  <div v-if="devise.myCheckbox.checked">
    Hey! That checkbox must be on!
  </div>
@endsection

@section('component')
  <script>
    let module = {
      config: {
        myCheckbox: {
          type: 'checkbox',
          label: 'My Checkbox'
        }
      }
    }
  </script>
@endsection
```

### Color

Loads a color picker and returns a hex value

```
@section('template')
  <div :style="{backgroundColor: devise.myColor.color}">
    The background color you chose is a very good choice!
  </div>
@endsection

@section('component')
  <script>
    let module = {
      config: {
        myColor: {
          type: 'color',
          label: 'My Color'
        }
      }
    }
  </script>
@endsection
```

### Image

Loads a field to put the address of an image or select an image from the media manager.

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
        someImage: {
          type: 'image',
          label: 'The Image'
        }
      }
    }
  </script>
@endsection
```

### Link

```
@section('template')
  <div>
    <a :href="devise.myLink.href" :target="devise.myLink.target">@{{ devise.myLink.text }}</a>
  </div>
@endsection

@section('component')
  <script>
    let module = {
      config: {
        myLink: {
          type: 'link',
          label: 'The Link'
        }
      }
    }
  </script>
@endsection
```

### Number

```
@section('template')
  <div>
    @{{ devise.myNumberField.text }}
  </div>
@endsection

@section('component')
  <script>
    let module = {
      config: {
        myNumberField: {
          type: 'number',
          label: 'The Number'
        }
      }
    }
  </script>
@endsection
```

### Text

```
@section('template')
  <div>
    @{{ devise.myTextField.text }}
  </div>
@endsection

@section('component')
  <script>
    let module = {
      config: {
        myTextField: {
          type: 'text',
          label: 'The Text Field'
        }
      }
    }
  </script>
@endsection
```

### Text Area

```
@section('template')
  <div>
    @{{ devise.myTextareaField.text }}
  </div>
@endsection

@section('component')
  <script>
    let module = {
      config: {
        myTextareaField: {
          type: 'textarea',
          label: 'The Textarea'
        }
      }
    }
  </script>
@endsection
```

### Wysiwyg

```
@section('template')
  <div>
    <div v-html="devise.wysiwygField.text"></div>
  </div>
@endsection

@section('component')
  <script>
    let module = {
      config: {
        wysiwygField: {
          type: 'wysiwyg',
          label: 'Some HTML content'
        }
      }
    }
  </script>
@endsection
```
