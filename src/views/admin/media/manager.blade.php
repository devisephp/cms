@extends('devise::admin.layouts.media-manager')

@section('main')
    <div id="dvs-media-manager">
        @if (Session::has('dvs-error-message'))
        <div id="dvs-error-message">
            {{ Session::get('dvs-error-message') }}
        </div>
        @endif
        <div id="dvs-media-upload">
            {{ Form::open(array('route' => 'dvs-media-upload', 'files' => true)) }}
            {{ Form::hidden('category', (isset($input['category'])) ? $input['category'] : '') }}
            {{ Form::label('Upload File') }}
            {{ Form::file('file') }}
            {{ Form::submit('Upload', array('class' => 'dvs-button dvs-button-small')) }}
            {{ Form::close() }}
        </div>
        <div id="dvs-new-category">
            {{ Form::open(array('route' => 'dvs-media-category-store', 'files' => true)) }}
            {{ Form::hidden('category', (isset($input['category'])) ? $input['category'] : '') }}
            {{ Form::label('Category Name') }}
            {{ Form::text('name') }}
            {{ Form::submit('New Category', array('class' => 'dvs-button dvs-button-small')) }}
            {{ Form::close() }}
        </div>

        @include('devise::admin.media._categories')

        <div id="dvs-media-mngr-gallery">
            <h4>Media</h4>

            @include('devise::admin.media._search')

            @include('devise::admin.media._items')
        </div>
    </div>
	<script>
        require(['app/admin/media-manager', 'app/admin/admin'],
            function(module) {
                module.init({{ json_encode($input) }}, {{ json_encode($finalImages) }});
            }
        );
    </script>
@stop