# Permissions

This page lists all the permissions for devise. A permission consists of one or more rules joined by (and/or) operators. These permissions are used by the developer to restrict access to specific areas of this application. The developer will use the permission name to do this.

```
@if (DeviseUser::checkConditions('canDrinkBeer'))
	// do stuff for this beer drinker
@endif
```

More info can be seen about this on the [docs](http://devisephp.com/docs/permissions/).