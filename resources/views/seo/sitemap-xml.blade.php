<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($pages as $page)
  @if (Route::getRoutes()->hasNamedRoute($page->route_name))
    <url>
      <loc>{{ route($page->route_name) }}</loc>
    </url>
  @endif
@endforeach
</urlset>