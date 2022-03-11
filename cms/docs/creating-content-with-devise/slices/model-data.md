# Database Powered Slices

Static slices are great for content managers to use for content that is a one off. But what about rendering _n_ instances of a slice from the database? In Devise, you can totally do that.

**TODO: Video on creating a model slice.**

## Model Queries: As dynamic as you want

Model queries are what power database-driven slice iteration by returning the records from the database. What's great about Devise is that it gives you, the developer, the chance to give the content manager the chance to actually modify that query so they can use it differently in various scenarios. Let's jump into the classic example Blog Posts: 

{% hint style="info" %}
A very similar, but slightly more complex, example \(BlogPostsController@byCategory\) is used in the Devise website source code so you can reference it, download it, and play with it in it's completed state here: [https://github.com/devisephp/marketing](https://github.com/devisephp/marketing)
{% endhint %}

### The Controller: Building the Eloquent Query

First, let's create the query that's going to power our slices. We are going to create a controller for blog posts that contains a function that we will reference later. In this function we take three parameters that we want to use to determine which posts will come back. Through a UI the content managers will be able to determine what data comes back. 

{% code-tabs %}
{% code-tabs-item title="/app/Http/Controllers/BlogPostsController.php" %}
```php
    <?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlogPost;
use App\Http\Resources\BlogPost as BlogPostResource;

class BlogPostsController extends Controller
{
  /**
   * @var BlogPost
   */
    private $BlogPost;

   /**
   * BlogCategoriesController constructor.
   * @param BlogPost $BlogPost
   */
    public function __construct(BlogPost $BlogPost)
    {
        $this->BlogPost = $BlogPost;
    }
    
    public function afterDate($afterdate, $title = null) {
        $query = $this->BlogPost;
        
        if(!is_null) {
            $query = $query->where('title', 'like', '%' . $title . '%');
        }
        $query = $query->where('created_at', '>', date('Y-m-d H:i:s', strtotime($afterdate)));
        
        return $query->get();
    }
}
```
{% endcode-tabs-item %}
{% endcode-tabs %}

The parameters are:

1. **After Date:** This will force the query to only return posts after a given date selected by the content manager.
2. **Title:** This will allow the content manager to limit only posts with titles that contain a given string. \(Admittedly, a bit of a silly example but remember it's just an example\)

### Registering the Model Query

Next, we need to register this as a model query with Devise and give it some settings so the interface knows what parameters need to be passed and how they should be rendered in the form.

{% code-tabs %}
{% code-tabs-item title="/app/Providers/AppServiceProvider.php" %}
```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Devise\ModelQueries;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        ModelQueries::set
            // Human name in UI
            'Posts After Date',
            // Class and method we will be using (this is the from the previous step)
            'App\Http\Controllers\BlogPostsController@byTitle', 
            [
                // Parameters to be passed and the form elements to use
                // to present these.
                [
                    'type'      => 'datetime', 
                    'label'     => 'All posts after this date'
                ],
                [
                    'type'      => 'text',  // Options are: search, text, select, datetime
                    'label'     => 'Titles contain',
                    'allowNull' => true,

                ]
            ],
            ['blog.post'], // Compatible slices
        );
    }
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
```
{% endcode-tabs-item %}
{% endcode-tabs %}

What is happening is we are setting up the model query for the UI. Don't worry too much about the parameters but do note that there are two - the same as our controller method. Also note we are referencing the Class and method that we created in the previous step.

Finally, the slices that we intend for the content manager to use with this particular model query are listed in the final argument as an array. Here, we've stated that they can only use the `blog.post` slice.

### Configuring the Model

### Model Resource

### Using the Model Query

So, that's all that's all that's needed for this particular example to render correctly in the admin. So, let's go ahead and give it a whirl. Once we save and refresh click the **Add Slice** button on the editor and then select **Dynamic Slice**. Select the **Posts After Date** options from the dropdown and you should see the two fields:

**TODO: Screenshot from the Dynamic Slice example form**

Go ahead and fill it out.                

