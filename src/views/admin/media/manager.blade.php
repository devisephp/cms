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

    @include('devise::admin.media.dropzone-preview-item')

	<script>
        devise.require(['app/admin/media-manager', 'app/admin/admin'],
            function(module) {
                module.init(<?= json_encode($input) ?>, <?= json_encode($finalImages) ?>);
            }
        );

        var myDropzone = new Dropzone("html", {
            clickable: false,
            method: 'POST',
            url: "<?= route('dvs-media-upload') ?>",
            previewsContainer: '.dropzone-previews',
            previewTemplate: document.querySelector('template[name="dropzone-preview-item"]').innerHTML,
            sending: function(file, xhr, formdata) {
                formdata.append('category', "<?= array_get($input, 'category', '') ?>");
                 xhr.setRequestHeader("X-XSRF-TOKEN", "<?= Crypt::encrypt(csrf_token()) ?>");
            },
            success: function(file, response) {
                if (! file.previewElement) return;

                var path = response.path || '';
                var updateElements = file.previewElement.querySelectorAll('[data-filepath]');

                var paths = path.split('/');
                var filename = paths[paths.length - 1];
                file.previewElement.querySelector('[data-dz-name]').innerText = filename;

                for (var i = 0; i < updateElements.length; i++)
                {
                    if (typeof updateElements[i].dataset.filepath !== 'undefined' && path !== '') {
                        updateElements[i].dataset.filepath = path.substring(0, 1) == '/' ? '' : '/' + path;
                    }
                }

                file.previewElement.classList.add("dz-success");
            }
        });

    </script>
@stop