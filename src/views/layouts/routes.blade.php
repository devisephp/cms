
<?= "<?php\n"; ?>

@foreach ($routes as $route)

    Route::<?= $route->http_verb ?>('<?= $route->slug ?>', [
        'as' => '<?= $route->route_name ?>',
        'uses' => '<?= $route->uses ?>',
        @if ($route->before)'before' => '<?= $route->before ?>'@endif
        @if ($route->after)'after' => '<?= $route->after ?>'@endif

    ]);

@endforeach