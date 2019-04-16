# Devise Fields

## About Fields and Use Case

Ok, what exactly are fields and when should they be used. Devise fields are anywhere you want to use non-model-driven dynamic data. A few examples that everyone has run into now and again:

* The "About Us" paragraph on the About page.
* The array of slides that appear in the slideshow hero on the homepage.
* The accent color of a page.
* The legal copy of the site's Terms and Conditions in English, Spanish and Pashtun.

Creating administration sections in your application that is already doing a bunch of other "real" tasks can be a pain, time consuming, and expensive. By implementing Devise fields in your slices you can do two very awesome things:

1. You provide a very easy way for the content manager to make in-context edits to the site.
2. You provide a way for your team to recycle design patterns again and again and again throughout your site.

This provides your team to be creative when making new templates, easier code to maintain, and quickly and cheaply test different scenarios with end users to find what works best.

## Available Field Types

Devise ships with a bunch of useful fields for you to drop in to your slices.

### Checkbox

The checkbox field is for boolean \(true / false\) values in your website:

```text
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

```text
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

### Date/Time

Loads a date / time picker and returns a string. The format option is modeled after the Momentjs api. Devise actually uses the smaller dayjs but the API is the same. See options [here](https://github.com/iamkun/dayjs/blob/master/docs/en/API-reference.md#format-formatstringwithtokens-string)

```text
@section('template')
  <div>
    The date selected is: @{{ devise.date.text }}
  </div>
@endsection

@section('component')
  <script>
    let module = {
      config: {
        myDate: {
          type: 'datetime',
          label: 'My Date',
          settings: {
            date: true, // Hide / Show the Calendar
            time: true, // Hide / Show the Time Picker
            format: 'MMMM D, YYYY h:mm' // Optional format
          }
        }
      }
    }
  </script>
@endsection
```

### File

```text
@section('template')
  <div>
    <a :href="devise.myFile.url">@{{ devise.myFile.text }}</a>
  </div>
@endsection

@section('component')
  <script>
    let module = {
      config: {
        myFile: {
          type: 'file',
          label: 'The Secret Documents'
        }
      }
    }
  </script>
@endsection
```

### Image

Loads a field to put the address of an image or select an image from the media manager. If you use the media manager you can select a source image and Devise will resize and attempt to optimize the image. Below are a few examples of how to utilize some different scenarios

#### Simple Image Implementation

```text
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

#### Responsive image implementation

Responsive images can be accessed via the media property. Example: `devise.someImage.media.large` which you could use. However, Devise ships with a directive that makes choosing the image automagic.

```text
@section('template')
  <div>
    <img v-devise-image="{image: devise.someImage, breakpoint: breakpoint}"  :alt="devise.someImage.alt" class="w-full">
  </div>
@endsection

@section('component')
  <script>
    let module = {
      config: {
        someImage: {
          type: 'image',
          label: 'The Image'
          sizes: {
            large: {
              w: 1200,
              h: 600,
              breakpoints: ['desktop', 'large-desktop']
            },
            medium: {
              w: 800,
              h: 400,
              breakpoints: ['tablet']
            },
            small: {
              w: 500,
              h: 250,
              breakpoints: ['mobile']
            }
          }
        }
      }
    }
  </script>
@endsection
```

#### Background responsive image

```text
@section('template')
  <div v-devise-image.background="{image: devise.someImage, breakpoint: breakpoint}" class="absolute pin">
@endsection

@section('component')
  <script>
    let module = {
      config: {
        someImage: {
          type: 'image',
          label: 'The Image'
          sizes: {
            large: {
              w: 1200,
              h: 600,
              breakpoints: ['desktop', 'large-desktop']
            },
            medium: {
              w: 800,
              h: 400,
              breakpoints: ['tablet']
            },
            small: {
              w: 500,
              h: 250,
              breakpoints: ['mobile']
            }
          }
        }
      }
    }
  </script>
@endsection
```

### Link

```text
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

```text
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

### Select

The select field gives you an opportunity to give the content manager a chance to change values that might effect layout, or maybe, just print out the value. Below shows how you could implement a dynamic v-bind class and print out it's value.

```text
@section('template')
  <div class="text-white" :class="[devise.mySelectField.value]">The background color is @{{ devise.mySelectField.value }}</div>
@endsection

@section('component')
  <script>
    let module = {
      config: {
        mySelectField: {
          type: 'select',
          label: 'Select a Color',
          options: {
            'bg-green': 'Green',
            'bg-indigo': 'Indigo',
            'bg-red': 'Red'
          },
          allowNull: true // default
        }
      }
    }
  </script>
@endsection
```

### Text

```text
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
          label: 'The Text Field',
          settings: {
            maxlength: 255
          }
        }
      }
    }
  </script>
@endsection
```

### Text Area

```text
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
          label: 'The Textarea',
          settings: {
            maxlength: 255
          }
        }
      }
    }
  </script>
@endsection
```

### Wysiwyg

The WYSIWYG provide a rich-text editor where you can add text with styles, headers, and inject images.

```text
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

