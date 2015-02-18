@extends('devise::admin.layouts.master')

@section('main')
	<div class="dvs-admin-container">
        <div class="dvs-admin-card wide" data-dvs-url="{{ URL::route('dvs-pages') }}">
            <div class="dvs-card-top" style="background-image: url('{{ URL::asset('packages/devisephp/cms/img/default-images/diego.jpg') }}')"></div>
            <div class="dvs-card-bottom">
                <h5>Pages</h5>
                <p>Manage pages, set URLs, and page versions.</p>
            </div>
        </div>

        <div class="dvs-admin-card" data-dvs-url="{{ URL::route('dvs-menus') }}">
            <div class="dvs-card-top" style="background-image: url('{{ URL::asset('packages/devisephp/cms/img/default-images/diego.jpg') }}')"></div>
            <div class="dvs-card-bottom">
                <h5>Menus</h5>
                <p>Manage menus and children items.</p>
            </div>
        </div>

        <div class="dvs-admin-card" data-dvs-url="{{ URL::route('dvs-users') }}">
            <div class="dvs-card-top" style="background-image: url('{{ URL::asset('packages/devisephp/cms/img/default-images/diego.jpg') }}')"></div>
            <div class="dvs-card-bottom">
                <h5>Users</h5>
                <p>Manage users and define group associations.</p>
            </div>
        </div>

        <div class="dvs-admin-card" data-dvs-url="{{ URL::route('dvs-groups') }}">
            <div class="dvs-card-top" style="background-image: url('{{ URL::asset('packages/devisephp/cms/img/default-images/diego.jpg') }}')"></div>
            <div class="dvs-card-bottom">
                <h5>Groups</h5>
                <p>Manage groups and related details.</p>
            </div>
        </div>

        <div class="dvs-admin-card" data-dvs-url="{{ URL::route('dvs-permissions') }}">
            <div class="dvs-card-top" style="background-image: url('{{ URL::asset('packages/devisephp/cms/img/default-images/diego.jpg') }}')"></div>
            <div class="dvs-card-bottom">
                <h5>Permissions</h5>
                <p>Manage permission conditions.</p>
            </div>
        </div>

        <div class="dvs-admin-card large" data-dvs-url="{{ URL::route('dvs-templates') }}">
            <div class="dvs-card-top" style="background-image: url('{{ URL::asset('packages/devisephp/cms/img/default-images/diego.jpg') }}')"></div>
            <div class="dvs-card-bottom">
                <h5>Templates</h5>
                <p>Manage templates your pages can use.</p>
            </div>
        </div>

        <div class="dvs-admin-card" data-dvs-url="{{ URL::route('dvs-languages') }}">
            <div class="dvs-card-top" style="background-image: url('{{ URL::asset('packages/devisephp/cms/img/default-images/diego.jpg') }}')"></div>
            <div class="dvs-card-bottom">
                <h5>Languages</h5>
                <p>Manage languages and set active languages.</p>
            </div>
        </div>
	</div>
@stop