# Editing a Template

### Getting Devise to Recognize Your Template
The file name dropdown is auto-populated by Devise, but you might be wondering where and why? Devise checks the ```/resources/views/``` directory and it's sub-directories for any unregistered blade files which *do not begin with an underscore (_)*. These files are excluded because partials start with an underscore and can be included inside multiple templates.

*The current template's path is:*

``` php
/resources/views/@livespan([name="template_path"]).blade.php
```

### Human Name Field

Primarily used as meta data on the admin templates index.

### Extends Field

Defines layout used by the template and the value is inserted into the extends tag within the blade file:

``` php
@extends(@livespan([name="template[extends]"]))
```

### Variables

Template variables offer a simple and quick way to set data available inside a template. All defined variables are listed in the "Variables" section.

### Adding New Variables

After clicking on the "Add New Variable" button, a variable can be created in two ways:
1. Select an existing variable from the list.
1. Add a new variable. This requires three fields:

#### Variable Name
Any unique variable name which will become available in the current template.

#### Class Path
The namespaced class where you will be retrieving data.

#### Method Name
The method/function name which will be called from inside the Class Path set above.

### Adding Param(s) to Variables

After a new variable has been added to the current template, parameters can be added with the "Create New Param" form. Currently, Devise supports these parameter types:
- Input
- Url Parameters
- Defined Variables (any vars already added to current template)
- Static Values

### Parameter Examples

#### Input Param Examples
Assume our url looks like, __<?= url() ?>?fooId=10&isLoggedIn=1__, which calls the *_fooIsUserLoggedIn_* method inside of class Foo\UserManager.

__input__ - passes the entire query input to the method.

```
public function fooIsUserLoggedIn($input)
{
    var_dump($input); // array('fooId' => 10, isLoggedIn' => 1)
}
```

__input.fooId__ - only passes "fooId" from the query input array

```
public function fooIsUserLoggedIn($fooId)
{
    echo $fooId; // 10
}
```

#### URL Param Example

Now, our url has a param for "id" __<?= url("/some/:id") ?>__ and for our example let's say the id is "10". Now, we can get the id like:

__params.id__ - passes the id
```
public function fooFindUserById($id)
{
    echo $id;   // 10
}
```