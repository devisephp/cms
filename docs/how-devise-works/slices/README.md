# Slices

## What is a Slice?

A "slice" is a reusable layout that can be used in multiple templates and contain different information on the pages that utilize those templates. Slices are blade files that reside in your ```/resources/views/slices``` directory.

## Example Time

Let's imagine that you had a slice that contained a content-manageable image. Maybe you have an idea how this slice will be used in an initial instance but you also know that you or your client might use this slice in unexpected ways - any place they want an image.

### Our First Slice

If we create a file in ```/resources/views/slices``` called ```wideimage.blade.php``` and it contained the following contents we'll be off to the races.

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

Ok, so what is happening here? There are two sections defined by the Laravel blade-directive "section". Both are required for Devise to understand what you want to happen. So, let's break down the first section: template.

#### Template Section

This probably looks familiar: It's just some HTML with some Vue JS bindings. In Devise, every slice ends up being a Vue JS component with a prop called "devise". So, all we are doing is setting the devise prop along with a custom property called 'someImage' equal to the src and alt tags.

#### Component Section

The script section tells Devise about the fields that we want to provide to the content manager when this slice is used. In the example above our component sets a variable called module and in that module sets the configuration of the slice. Within that object we have our list of fields and their settings. In this example we only have one: ```someImage``` and we tell devise that it's an image and that we want the content manager to see "The Image" in the sidebar editor.

Devise comes built in with a bunch of different fields which you can read about in the [fields documentation](fields.md)

## Subslices

Slices can be nested in other slices. This is useful for many use cases but imagine if you wanted to have a flex container that contained *n* instances (more on repeatables in Templates) of another slice? Simple: Just add ```@slices``` to your template section whereever you want those slices to appear.

```
@section('template')
  <div>
    <img :src="devise.someImage.url" :alt="devise.someImage.alt" class="w-full">

    <div class="flex flex-wrap">
      @slices
    </div>
  </div>
@endsection
```

## Is that it?

Yea, it is for now. Blades that are located in the slices directory are automatically available for use in templates. There is more configuration options and tons of fields so be sure to keep reading!
