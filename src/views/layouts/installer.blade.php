<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To Devise</title>

    <link href="<?= URL::asset('/packages/devisephp/cms/css/dvs-admin.css') ?>" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= URL::asset('/packages/devisephp/cms/css/bootstrap.min.css') ?>">
    <link href="<?= URL::asset('/packages/devisephp/cms/css/main.css') ?>" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="<?= URL::asset('/packages/devisephp/cms/js/devise.min.js') ?>"></script>
    <script>devise.require(['app/admin/main'])</script>
</head>

<body id="dvs-admin">
    <div class="container pt sp45">

        <div class="tac mb sp75">
            <img src="<?= URL::asset('/packages/devisephp/cms/img/admin-logo.png') ?>">
        </div>

        @if(Session::has('message-success') || Session::has('message-errors'))
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                    @include('devise::admin.elements.validation')
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6 col-md-offset-3 tal">

                @yield('content')

            </div>
        </div>
    </div>

    @yield('scripts')
    <script>devise.require(['app/admin/admin'])</script>

</body>
</html>