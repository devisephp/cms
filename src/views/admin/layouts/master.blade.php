<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ (isset($title)) ? $title : 'Administration' }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />
    <link href="{{ URL::asset('/packages/devise/cms/css/jquery.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('packages/devise/cms/css/main.css') }}" type="text/css" rel="stylesheet">

	@yield('css')

    <script src="{{ URL::asset('/packages/devise/cms/js/config.js') }}"></script>
    <script data-main="app/admin/main" src="{{ URL::asset('/packages/devise/cms/js/require.js') }}"></script>
</head>

<body id="dvs-admin" class="dvs-default">
    <div id="dvs-admin-top-bar">
        <div id="dvs-admin-logo">
            <img src="{{ URL::asset('packages/devise/cms/img/admin-logo.png') }}">
        </div>

        <ul id="dvs-admin-controls">
            <li id="dvs-admin-logout"><a href="{{ URL::route('user-logout') }}"><img src="{{ URL::asset('packages/devise/cms/img/admin-logout.png') }}"></a></li>
            <li id="dvs-admin-toggle">
                <img src="{{ URL::asset('packages/devise/cms/img/admin-toggle-menu.png') }}">

                <ul class="pz" id="dvs-admin-sublinks">
                    <li><a href="{{ URL::route('dvs-content-queue-index') }}">Content</a></li>
                    <li><a href="{{ URL::route('dvs-groups') }}">Groups</a></li>
                    <li><a href="{{ URL::route('dvs-languages') }}">Languages</a></li>
                    <li><a href="{{ URL::route('dvs-menus') }}">Menus</a></li>
                    <li><a href="{{ URL::route('dvs-pages') }}">Pages</a></li>
                    <li><a href="{{ URL::route('dvs-users') }}">Users</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <div id="dvs-admin-main-menu">
        <div>
            <h2>Admin Navigation</h2>
            <p class="large">Navigate the administration by selecting from the list below or by typing what you want whenever this message is visible.</p>
            <select>
                <option value="http://google.com">Content: Pages</option>
                <option value="http://facebook.com">Application: Themes</option>
            </select>
        </div>
    </div>

    <div id="dvs-admin-body" class="vignette">

	    <div id="dvs-admin-subnavigation">
		    @yield('subnavigation')
	    </div>

        <div id="dvs-admin-title">
            @yield('title')
        </div>

        @if(Session::has('message'))
            <div class="dvs-messages">
                <h2>{{ Session::get('message') }}</h2>
                @if($errors->any())
                    <ul class="list">{{ implode('', $errors->all('<li class="error">:message')) }}</ul>
                @endif
                @if(isset($warnings) && count($warnings))
                    <ul class="list"><li>{{ implode('</li><li>', $warnings) }}</li></ul>
                @endif
            </div>
        @endif

        @yield('main')
    </div>
</body>
</html>