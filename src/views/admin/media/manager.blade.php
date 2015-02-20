@extends('devise::admin.layouts.media-manager')

@section('main')
    <div id="dvs-media-manager">

        <div id="dvs-media-top-action-bar">
            @if(count($pageData['crumbs']) > 1)
            <div id="dvs-media-crumbs">
                @foreach ($pageData['crumbs'] as $crumb)
                    &nbsp;/&nbsp;<a href="<?= $crumb['url'] ?>"><?= $crumb['name'] ?></a>
                @endforeach
            </div>
            @endif

            @include('devise::admin.media._search')
        </div>

        @if (Session::has('dvs-error-message'))
        <div id="dvs-error-message">
            <?= Session::get('dvs-error-message') ?>
        </div>
        @endif

        @include('devise::admin.media._categories')

        <div id="dvs-media-mngr-gallery">
            <div id="dvs-media-upload">
                <?= Form::open(array('route' => 'dvs-media-upload', 'files' => true)) ?>
                <?= Form::hidden('category', (isset($input['category'])) ? $input['category'] : '') ?>
                <?= Form::label('Upload File') ?>
                <?= Form::file('file') ?>
                <?= Form::submit('Upload', array('class' => 'dvs-button dvs-button-small')) ?>
                <?= Form::close() ?>
            </div>

            @include('devise::admin.media._items')
        </div>
    </div>
	<script>
        devise.require(['app/admin/media-manager', 'app/admin/admin'],
            function(module) {
                module.init(<?= json_encode($input) ?>, <?= json_encode($finalImages) ?>);
            }
        );
    </script>
@stop