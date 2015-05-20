# Registering a Template

### Important Notes
You will notice the file name dropdown has been populated by Devise, but you might be wondering where and why? Devise checks inside the ```/resources/views/``` directory (and any sub-directories) for any non-registered blade files which *do not begin with an underscore (_)*. These are excluded becuase in Devise partials start with an underscore and can be included inside multiple templates.

### Human Name Field

The human name field is primarily used on the admin templates index, so it can be quickly found by us humans.

### Extends Field

This sets the layout used by the template blade. This field's value is inserted into:
``` php
@extends('devise::admin.layouts.master')
```

### Using a Template After Registering

After successfully registering a new template, its as simple as navigating to Pages admin and selecting your newly registered template from the dropdown on either, the Page Create or Page Edit forms.