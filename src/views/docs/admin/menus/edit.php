# Menus

This page allows us to add, remove and re-order menu items from a named menu. The menu contains many items. These items are generally urls. Menu items can be nested for nested menus.

### Menu Name

This is the name used to build the menu. The developer uses this name to build menus in other parts of the application.

```
$menu = App::make('Devise\Menus\MenusRepository')->buildMenu('@livespan([name=name],Menu Name)');

@foreach ($menu as $menuGroup)
    <h5>{{ $menuGroup->name }}</h5>
    <ul class="dvs-admin-links">
        @foreach ($menuGroup->children as $link)
            <li><a class="{{ isActiveLink($link->url) }}" href="{{ $link->url }}">{{ $link->name }}</a></li>
        @endforeach
    </ul>
@endforeach
```

### Menu Items

These are urls or nested sub menus. You can place restrictions on a menu item so that is does not show up for certain users.