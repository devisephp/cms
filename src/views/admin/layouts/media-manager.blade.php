<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $page->title ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= Crypt::encrypt(csrf_token()) ?>">

    <link href="<?= URL::asset('/packages/devisephp/cms/css/main.css') ?>" type="text/css" rel="stylesheet">
    <link href="<?= URL::asset('/packages/devisephp/cms/css/jquery.Jcrop.min.css') ?>" type="text/css" rel="stylesheet">

    <!-- WILL YOU PLEASE MOVE THIS INTO THE CSS PLACE GARY, DID NOT WANT MERGE CONFLICTS -->
    <style>

        html.dz-drag-hover div#dvs-admin {
            opacity: 0;
        }

        html.dz-drag-hover body {
            opacity: 0.7;
            background-color: hotpink !important;
        }

        .dropzone-previews .dz-processing {
            opacity: 0.5;
        }

        .dropzone-previews .dz-processing.dz-complete {
            opacity: 1;
        }

        /** ... got an error when uploading ... */
        .dropzone-previews .dz-processing.dz-error {
            background: hotpink !important;
            opacity: 0.25;
        }

        .dropzone-previews .dz-processing .dvs-media-item-actions {
            display: none;
        }

        .dropzone-previews .dz-processing.dz-success .dvs-media-item-actions {
            display: inherit;
        }

        .dropzone-previews .empty {
            display: none;
        }

        .dropzone-previews .empty:only-child {
            display: inherit;
        }


    </style>
    <!-- PLUS THIS WILL NEED TO BE STYLED HOW YOU WANT IT TO REACT TO DRAG/DROP -->

	@yield('css')

    <script src="<?= URL::asset('/packages/devisephp/cms/js/lib/dropzone.js') ?>"></script>
    <script src="<?= URL::asset('/packages/devisephp/cms/js/devise.min.js') ?>"></script>
    <script>devise.require(['app/admin/main'])</script>
</head>

<body id="dvs-admin" class="dvs-default">

    <div id="dvs-admin">

        @if(Session::has('message'))
            <div class="dvs-messages">
                <h2><?= Session::get('message') ?></h2>
                @if($errors->any())
                    <ul class="list"><?= implode('', $errors->all('<li class="error">:message')) ?></ul>
                @endif
                @if(isset($warnings) && count($warnings))
                    <ul class="list"><li><?= implode('</li><li>', $warnings) ?></li></ul>
                @endif
            </div>
        @endif

        @yield('main')

    </div>
</body>
</html>