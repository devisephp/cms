---
description: >-
  Slices are one of the cornerstones of what makes Devise amazing to work with.
  They allow pages to have a perfect balance of content management control while
  maintaining branding.
---

# Slices

## What is a Slice?

A **slice** is a reusable bit of HTML that can be used on any page within your application by content managers. The easiest way to understand what a slice is and how it can be used is by checking out a quick example. In the video below we are going to add a simple card to the page, duplicate it, change the content of each instance and reorder them.

**TODO: Slice example video on the frontend.**

In the video above you saw a card slice being added to a page and then manipulated by the content editor. Let's go over how you can make these slices based on your own designs.

### Our First Slice

Let's imagine that you had a slice that contained a content-manageable image. Maybe you have an idea how this slice will be used in an initial instance but you also know that you or your client might use this slice in unexpected ways.

If we create a file in `/resources/views/slices` called `card.blade.php` and it contained the following code we'll be off to the races.

```javascript
@section('template')
  <div class="bg-white text-grey-darker shadow rounded">
    <img 
      :src="devise.someImage.url" 
      :alt="devise.someImage.alt" 
     >
  </div>
@endsection

@section('component')
  <script>
    var component = {
      fields: {
        someImage: {
          type: 'image',
          label: 'The Image'
        }
      }
    }
  </script>
@endsection
```

Ok, so what is happening here? There are two sections defined by the Laravel blade-directive. Both are required for Devise to understand what you want to happen. So, let's break down the first section: **template**.

#### Template Section

This probably looks familiar: It's just some HTML with some Vue JS bindings. In Devise, every slice ends up being a Vue JS component with a prop called "devise". So, all we are doing is setting the devise prop along with a custom property called 'someImage' equal to the src and alt tags.

{% hint style="info" %}
Because we are in a Laravel Blade template you can also use PHP and Laravel's Blade syntax in this section. Those are just handy shortcuts to do nifty PHP thinks. You can learn more about Laravel's Blade syntax here: [Laravel 5.8 Blade Docs](https://laravel.com/docs/5.8/blade)
{% endhint %}

#### Component Section

The script section tells Devise about the fields that we want to provide to the content manager when this slice is used. In the example above our component sets a variable called `component` and in that object sets the slice configuration. Within that object we have our list of fields and settings. In this example we only have one: `someImage` and we tell devise that it's an image and that we want the content manager to see a label "The Image" in the sidebar editor.

And that's all that's needed to add a new slice with custom fields. And the data from custom fields can do really anything you want. Let's take the example above a bit further and make it a full-blown card.

```javascript
@section('template')
  <div 
    class="bg-white text-grey-darker shadow rounded"
    :class="[devise.widthOfCard.value]">
    <img 
      :src="devise.someImage.url" 
      :alt="devise.someImage.alt" 
      class="mb-4"
     >
     <div class="text-xl mb-2">
       @{{ devise.title.text }}
     </div>
     <div v-html="devise.copy.text"></div>
  </div>
@endsection

@section('component')
  <script>
    var component = {
      fields: {
        someImage: {
          type: 'image',
          label: 'The Image'
        },
        title: {
          type: 'text',
          label: 'Title'
        },
        copy: {
          type: 'wysiwyg',
          label: 'Copy'
        },
        widthOfCard: {
          type: 'select',
          label: 'Card Width'
          options: {        
            'w-1/2': '1/2',
            'w-1/3': '1/3',
            'w-1/4': '1/4',
            'w-full': 'Full'
          },
          default: {
            value: 'w-1/2'
          }
        }
      }
    }
  </script>
@endsection
```

So, what did we do above? Well, we added some [Tailwind](https://tailwindcss.com/) classes to make our card look more like a card for one. We also added three new fields for our title, copy and one to allow the content manager to set the width of the card.

{% hint style="info" %}
Don't worry too much about the field types for now. Devise comes built in with a bunch of different fields which you can read about in the upcoming [fields documentation](../fields/)
{% endhint %}

## Caveats

{% hint style="danger" %}
If you're new to Devise and Vue JS please keep the following caveats in mind:

* Your script section must not contain any syntax errors. If you have a missing comma between properties in your component definition you will get a white screen of death. 
* In your template section you can only have one root-level component which contains everything else. In the example above it's the first `<div>` you see. Everything else is contained in that div.
* Blade and Vue JS have the same syntax for echoing out data so if you want to echo out Devise data you will need to do what we did in the example above for the title and use `@{{ [your-data] }}.`Otherwise, you will get a PHP error
* Your script section must be ES5 compliant if you want to render in IE. There is no transpiling through Babel for these slices. If you want to get more complex see [Utilizing Vue JS Components](./#advanced-utilizing-vue-js-components) to get around that.
{% endhint %}

\`\`

## Subslices

Slices can be nested in other slices. This is useful for many use cases but imagine if you wanted to have a flex container that contained _n_ instances of another slice? Simple: Just add `@slices` to your template section where ever you want those slices to appear.

```php
@section('template')
  <div>
    <img :src="devise.someImage.url" :alt="devise.someImage.alt" class="w-full">

    <div class="flex flex-wrap">
      @slices
    </div>
  </div>
@endsection
```

**TODO: Subslices video**

## **Advanced: Utilizing Vue JS Components**

As we mentioned earlier slices will eventually become a Vue JS component in the browser. This allows you to utilize traditional [Vue JS SFCs](https://vuejs.org/v2/guide/single-file-components.html) properties like **methods, computed, or even watch.** Check out this example:

```javascript
@section('template')
  <div>
    <h1>@{{ devise.regularTitle.text }}</h1> 
    <h3>@{{ numberOfTimesYouPushedButton }}</h3>
    <button @click="increment">Add to number</button>
  </div>
@endsection

@section('component')
  <script>
    var component = {
      data: function () {
        return {
          numberOfTimesYouPushedButton: 0
        };
      },
      methods: {
        increment: function () {
          // Add 1 to the main variable
          this.numberOfTimesYouPushedButton += 1;
        }
      },
      fields: {
        regularTitle: {
          type: 'text',
          label: 'Regular Title'
        }
      }
    }
  </script>
@endsection
```

As you can see typical Vue JS awesomeness can live right beside the fields. 

{% hint style="danger" %}
Careful here that you only use ES5 syntax if you want to render in IE 11. 
{% endhint %}

### Getting around the above warning

Generally speaking you probably don't want to write JavaScript with arrow functions and such. So, if you're doing something super simple like the example above you have no problem. If you begin to build something that will be more complicated make you're own component and pass the devise data through as a prop.

**todo: custom vue component video**

