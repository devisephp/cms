<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To Devise</title>

    <link href="<?= URL::asset('/packages/devisephp/cms/css/dvs-admin.css') ?>" type="text/css" rel="stylesheet">
    <link href="<?= URL::asset('/packages/devisephp/cms/css/main.css') ?>" rel="stylesheet">
    <link href="<?= URL::asset('/packages/devisephp/cms/css/dvs-installer.css') ?>" type="text/css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="<?= URL::asset('/packages/devisephp/cms/js/devise.min.js') ?>"></script>
    <script>devise.require(['app/admin/main'])</script>
</head>

<body id="dvs-installer">
    <form method="post">
        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
        @yield('content')
    </form>

    @yield('scripts')
    <script>devise.require(['app/admin/admin'])</script>
</body>
</html>