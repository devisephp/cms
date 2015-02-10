
<div class="dvs-media-manager-container">
    <?= Form::open(['route' => 'dvs-media-manager', 'method' => 'get']) ?>
        @foreach (Input::except(['search']) as $name => $value)
            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        @endforeach
        <input type="text" name="search" value="{{ Input::get('search') }}">
        <button class="dvs-button dvs-button-small" type="submit">Search</button>
    <?= Form::close() ?>
</div>
