# Database Powered Slices

So you've seen how content managers can drop in Devise slice in a page that they can content manage. But how do you utilize data from one of your database models in a slice?

## Model Slice Query

Allows for iteration of a slice based on the results of a model query. Think repeatable driven by data coming back from your custom models. This allows a content manager to iterate over the results of their query without a need for a programatic loop... er.... or one written by you.

For this example we need to talk about your slice as if it was already created. Imagine you have a card-type layout slice that you've made to display users. You want it to have an image, a name, and job title. on it. It looks... like this:

![Card Layout Example](https://github.com/devisephp/cms/raw/v2-dev/docs/imgs/card-example.jpg)

Now, maybe this slice get's added to a slice that uses flexbox to show all the users in the database. Let's imagine that your slice looks like the following:

```text
@section('template')
  <div class="p-8 bg-white rounded-sm">
    <img :src="devise.headshot.src" :alt="`${devise.name} Headshot`" class="dvs-mb-4">
    <h5 class="mb-1 uppercase">@{{ devise.name }}</h5>
    <h6>@{{ devise.title }}</h6>
  </div>
@endsection
```

In the template editor the content manager chooses add slice, then selects "Model Type", selects the "User" model, and then hits "Done" when all the users come back in the table.

What Devise does is loop over the results of the model and sets the value of each to the `devise` JavaScript variable. This results in Devise drawing out 10 cards if there are 10 users in the database. You can apply filters to the query so that only the users with a "G" in their first name appear.

## Setting up a Model for Devise Query Builder

Using the previous example we would need to add these two public variables to the User.php model:

```text
    // Properties available in the slice
    public $slice = [
        'id',
        'first_name',
        'last_name',
        'email'
    ];

    // Properties users can filter and sort by
    public $tableColumns = [
        [
            "key"    => 'first_name',
            "label"  => 'First Name',
            "sort"   => 'first_name',
            "search" => 'first_name'
        ],
        [
            "key"    => 'last_name',
            "label"  => 'Last Name',
            "sort"   => 'last_name',
            "search" => 'last_name'
        ]
    ];
```

