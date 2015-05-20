# Menus

This page shows all the menus in the system. Out of the box Devise ships with the Admin Menu. This makes it easy to add new custom menu links to the backend admin section.

Create a new menu and then the menu can be placed onto a layout or blade view by the developer. This allows the developer and designer to style your menu while the administrator/content mangers can change the content of the menus.

Menus can be nested many layers deep. The designer and developer will need to be aware that you want nested menus otherwise the menu may not be shown correctly.

### How to use

The developer can add a menu by adding the menu to a template. Instructions on how to do this are located at [http://devisephp.com/docs/menus/](http://devisephp.com/docs/menus/).

To summarize the developer adds a new variable to the template using classpath `Devise\Menus\MenusRepository` and method `buildMenu` with a static parameter of `Admin Menu` (or a different menu name). To display the menu the following code is inserted into the layout.

```
@foreach ($myMenu as $menuGroup)
    <h5>{{ $menuGroup->name }}</h5>
    <ul class="dvs-admin-links">
        @foreach ($menuGroup->children as $link)
            <li><a class="{{ isActiveLink($link->url) }}" href="{{ $link->url }}">{{ $link->name }}</a></li>
        @endforeach
    </ul>
@endforeach
```

