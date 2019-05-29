# Slice Structure and Example

Let's imagine that you had a slice that contained a content-manageable image. Maybe you have an idea how this slice will be used in an initial instance but you also know that you or your client might use this slice in unexpected ways - any place they want an image.

### Our First Slice

If we create a file in `/resources/views/slices` called `wideimage.blade.php` and it contained the following code we'll be off to the races.

```text
@section('template')
  <div>
    <img :src="devise.someImage.url" :alt="devise.someImage.alt" class="w-full">
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

Ok, so what is happening here? There are two sections defined by the Laravel blade-directive "section". Both are required for Devise to understand what you want to happen. So, let's break down the first section: template.

#### Template Section

This probably looks familiar: It's just some HTML with some Vue JS bindings. In Devise, every slice ends up being a Vue JS component with a prop called "devise". So, all we are doing is setting the devise prop along with a custom property called 'someImage' equal to the src and alt tags.

{% hint style="info" %}
Because we are in a Laravel Blade template you can also use PHP and Laravel's Blade syntax in this section. Those are just handy shortcuts to do nifty PHP thinks. You can learn more about Laravel's Blade syntax here: [Laravel 5.8 Blade Docs](https://laravel.com/docs/5.8/blade)
{% endhint %}

#### Component Section

The script section tells Devise about the fields that we want to provide to the content manager when this slice is used. In the example above our component sets a variable called module and in that module sets the configuration of the slice. Within that object we have our list of fields and their settings. In this example we only have one: `someImage` and we tell devise that it's an image and that we want the content manager to see "The Image" in the sidebar editor.

Devise comes built in with a bunch of different fields which you can read about in the [fields documentation](../fields/)

## Subslices

Slices can be nested in other slices. This is useful for many use cases but imagine if you wanted to have a flex container that contained _n_ instances \(more on repeatables in Templates\) of another slice? Simple: Just add `@slices` to your template section whereever you want those slices to appear.

```text
@section('template')
  <div>
    <img :src="devise.someImage.url" :alt="devise.someImage.alt" class="w-full">

    <div class="flex flex-wrap">
      @slices
    </div>
  </div>
@endsection
```

## 

