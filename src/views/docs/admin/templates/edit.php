# Editing a Template

### Important Notes
You will notice the file name dropdown has been populated by Devise, but you might be wondering where and why? Devise checks inside the ```/resources/views/``` directory (and any sub-directories) for any non-registered blade files which *do not begin with an underscore (_)*. These are excluded becuase in Devise partials start with an underscore and can be included inside multiple templates.

### Human Name Field

The human name field is used on the admin templates.

### Extends Field

This sets the layout used by the template blade and the value is inserted into:
``` php
@extends('devise::admin.layouts.master')
```

### Variables

Variables offer a quick and easy way to manage data accessible within a template. Under the "Variables" section are two lists of variables. The first, is any variables already defined and set for the current template. The second, is any variables found within the template's blade file but have not been added and saved to the current template. These "undefined" variables will only be attempted to be added when you input values in the Class Path and Method Name fields, and then click Update Template.

### Adding New Variable(s)

After clicking on the "Add New Variable" button, a variable can be created in two ways:
1. Select an existing variable in Devise (this list is pulled from all the other registered templates).
1. Add a new variable. This requires three fields:

#### Variable Name
Any unique variable name which will be available in the current template.

#### Class Path
The namespaced class path where you will be retrieving data.

#### Method Name
The method/function name which will be called in the above class.

### Adding Param(s) to Variables

After a new variable has been successfully added to the template being editted, you will notice a button labeled "Add Param." This opens a modal where different parameters can be added to support the method being called.

#### Param Types
