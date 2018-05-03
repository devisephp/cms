# Model Data

So you've seen how you can drop in rando Devise fields in your templates which are super helpful when it's... well.... a rando spot that your client wants to content manage. But how do you utilize data from one of your models in a slice? There are two ways to get this data into your slices and both happen on the template editor.

## Model Slice Query

Allows for iteration of a slice based on the results of a model query. Think repeatable driven by data coming back from your custom models. This allows a content manager to iterate over the results of their query without a need for a programatic loop... er.... or one written by you.

For this example we need to talk about your slice as if it was already created. Imagine you have a card-type layout slice that you've made to display users. You want it to have an image, a name, and job title. on it. It looks... like this:

![Card Layout Example](https://github.com/devisephp/cms/raw/v2-dev/docs/imgs/card-example.jpg "Card Layout Example")

Now, maybe this slice get's added to a slice that uses flexbox to show all the users in the database. (Think company about page) So, in the template editor the content manager chooses add slice, then selects the model type, selects the "User" model, and then hits "Done" when all the users come back in the table.

Now, in your slice's template section we haven't defined any variables. What Devise does is loop over the results of the model for you and set the value of each to the ```devise``` JavaScript variable. So your card might look like this:

```
@section('template')
  <div class="p-8 bg-white rounded-sm">
    <img :src="devise.headshot" :alt="`${devise.name} Headshot`" class="mb-4">
    <h5 class="mb-1 uppercase">@{{ devise.name }}</h5>
    <h6>@{{ devise.title }}</h6>
  </div>
@endsection
```

## Template Slice query

By setting a template slice query you provide a variable that is available to all slices in the page. This is useful for scenarios like:

* Who is the current user?
* What is the current product?
* What are all the cities?

Anything where the entire page might need information from the db, not just a single slice.

To add a variable to the template you would click 'Add Variable' at the bottom of the template editor. Provide the variable name you want to add, set the data, and viola! Then, in your template you can access that data through the ```models``` variable. See below for an example:

```
@section('template')
  <div class="flex flex-col">
    <img :src="models.productVariableName.image">

    <div">
      <h1 class="mb-4">@{{ models.productVariableName.title }}</h1>
      <p v-html="models.productVariableName.description"></p>
    </div>
  </div>
```

What you should note about both of these examples is that the last property of the object reference is the field name in the database. So, above, we are referencing the ```image``` field of the products database.
