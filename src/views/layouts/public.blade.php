<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page->title ?></title>

	<link href="<?= URL::asset('/packages/devisephp/cms/css/dvs-admin.css') ?>" type="text/css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?= URL::asset('/packages/devisephp/cms/css/bootstrap.min.css') ?>">
    <link href="<?= URL::asset('/packages/devisephp/cms/css/main.css') ?>" rel="stylesheet">

    <script type="text/javascript" src="<?= URL::asset('/packages/devisephp/cms/js/devise.min.js') ?>"></script>

    {{-- Add this include and the scripts for the devise editor. --}}
    @include('devise::styles')
</head>

<body id="dvs-admin">

    @yield('content')

    {{-- Yup, this guy too. --}}
    @include('devise::scripts')

</body>
</html>