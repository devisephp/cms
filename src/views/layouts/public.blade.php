<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title }}</title>

	<link href="{{ URL::asset('/packages/devisephp/cms/css/dvs-admin.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ URL::asset('/packages/devisephp/cms/css/main.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('/packages/devisephp/cms/css/bootstrap.min.css') }}">

    <script type="text/javascript" src="{{ URL::asset('/packages/devisephp/cms/js/devise.min.js') }}"></script>
</head>

<body id="dvs-admin">

    @yield('content')

</body>
</html>