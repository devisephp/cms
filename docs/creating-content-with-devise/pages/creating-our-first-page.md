# Creating our first page

## Create your first slice

Slices are rendered between the static content sections by Devise. These slices can be singles, repeatables \(driven by the content manager manually\), or driven by custom models \(repeat based on the number of records you hand it\).

Let's make a simple video Hero slice that we will put at the top of our homepage and save it as `/resources/views/slices/vimeo-hero.blade.php`

```text
@section('template')
<div>
  <div>
    <iframe :src="'https://player.vimeo.com/video/' + devise.vimeoId.text + '?autoplay=1&loop=1&background=1'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
  </div>
</div>
@endsection

@section('component')
  <script>
    let module = {
      config: {
        vimeoId: {
          type: 'number',
          label: 'Vimeo ID'
        }
      }
    }
  </script>
@endsection
```

So, what's in this file? There are two primary sections:

1. The template: This contains traditionally php and Laravel Blade syntax that you're probably familiar with. Additionally, you can utilize devise variables that you define in the component section of this file. For example: Here we use `devise.vimeoId.text`.
2. The component: In the component section we define our fields. Here we define the `vimeoId` field and tell Devise it's a number field-type and that we want our content editors to see the label "Vimeo ID" when they are editing.

## Put our slice in our first template

So, let's head back to the browser and using the previous example head to `http://myamazingsite.test/devise`. If you're logged in you should see the gears in the top left-hand corner. If not, head to `http://myamazingsite.test/login` and log into the system first and come back. To create a template:

1. Click on the gears in the top left-hand corner
2. Click on "Templates" in the main menu. Click "Create New Template" on the sidebar.
3. Name the template "Homepage"
4. For the Layout field put "master" if you named your file `/resources/views/master.blade.php`
5. Click "Create"

Now click "Edit" on the Homepage template and enter the template editor. It may be a pretty plain screen for now so let's get something in this template.

1. Click "Add slice to layout" button on the left side.
2. Click "Single"
3. Select "Vimeo Hero" and click "Select"
4. Click "Save Template" in the lower right-hand corner of the template editor

Click "Back to templates" near the Devise logo and then click "Back to administration". Click "Edit this page" and then on the new "Vimeo ID" field on the sidebar. If you provide the vimeo id the video should update automagically.

