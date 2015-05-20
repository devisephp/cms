# Permissions

On this page you can edit an existing permission. Permissions are used to restrict access to certain areas of your application. There are several parts of a permission all discussed in detail below.

### Condition

The condition is the name of your permission. It is what the developers will used to check for access.

```
@if (DeviseUser::checkRule('@livespan([name=permission_name],condition name)'))
	// do stuff here
@endif
```

### Redirect Route Or Action

This is the Laravel route or action you want to redirect to whenever the conditions for this permission fails. This is helpful when using [route filters for a page](/admin/pages/95/edit).

### Redirect Type

Determines if we should use a route or action to resove the route above. See more about named routes at [http://laravel.com/docs/5.0/routing#named-routes](http://laravel.com/docs/5.0/routing#named-routes). If you are unsure what the name of your route is then go to Pages > Settings (for your page) > Routing > Route Name

### Redirect Message

This message can be sent along with the direct. Useful if showing the user an error message.

### Rules

Every permission is built of rules and operators. We have a list of gneric out of the box rules available for you to pick from. This includes asserting a user is within a group or is logged into the application. You can combine multiple varities of these rules.
