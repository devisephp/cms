<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ (isset($title)) ? $title : 'Administration' }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />
    <link href="{{ URL::asset('/packages/devisephp/cms/css/jquery.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('/packages/devisephp/cms/css/main.css') }}" type="text/css" rel="stylesheet">

    @yield('css')

    <script src="{{ URL::asset('/packages/devisephp/cms/js/devise.min.js') }}"></script>
    <script>devise.require(['app/admin/main'])</script>
</head>

<body id="dvs-admin" class="dvs-default">
    <div id="dvs-admin-sidenav">
        <div id="dvs-admin-logo">
            <img src="{{ URL::asset('/imgs/admin-logo.png') }}" width="100%">
        </div>

        <hr class="dvs-thick">

        <h5>Website Management</h5>
        <ul class="dvs-admin-links">
            <li><a class="{{ isActiveLink('admin') }}" href="{{ URL::route('dvs-dashboard') }}">Dashboard</a></li>
            <li><a class="{{ isActiveLink('admin/menus*') }}" href="{{ URL::route('dvs-menus') }}">All Menus</a></li>
            <li><a class="{{ isActiveLink('admin/pages*') }}" href="{{ URL::route('dvs-pages') }}">All Pages</a></li>
            <li><a href="{{ URL::route('user-logout') }}">Logout</a></li>
        </ul>

        <hr>

        <h5>Application Management</h5>
        <ul class="dvs-admin-links">
            <li><a class="{{ isActiveLink('admin/users*') }}" href="{{ URL::route('dvs-users') }}">Users</a></li>
            <li><a class="{{ isActiveLink('admin/groups*') }}" href="{{ URL::route('dvs-groups') }}">Groups</a></li>
            <li><a class="{{ isActiveLink('admin/languages*') }}" href="{{ URL::route('dvs-languages') }}">Languages</a></li>
        </ul>

        <div class="dvs-hide-mobile" id="dvs-devise-logo-sm">
            <img src="{{ URL::asset('/packages/devisephp/cms/img/admin-devise-powered-logo.png') }}" width="100%">
        </div>
    </div>

    <div id="dvs-admin-body">
        <div id="dvs-admin-subnavigation">
            @yield('subnavigation')
        </div>

        <div class="dvs-admin-container">
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