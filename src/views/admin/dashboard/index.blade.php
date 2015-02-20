@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1><span class="ion-ios-speedometer-outline"></span> Dashboard</h1>
    </div>
@stop

@section('main')

    <div class="dvs-flexbox">
        <div class="dvs-admin-card wide dvs-pages" data-dvs-url="<?= URL::route('dvs-pages') ?>">
            <div class="dvs-card-top" style="background-image: url('<?= URL::asset('packages/devisephp/cms/img/default-images/sections/pages.gif') ?>')"></div>
            <div class="dvs-card-bottom">
                <div class="dvs-icon ion-ios-copy-outline"></div>
                <h5>Pages</h5>
                <p>Manage pages, set URLs, and page versions.</p>
            </div>
        </div>

        <div class="dvs-admin-card dvs-menus" data-dvs-url="<?= URL::route('dvs-menus') ?>">
            <div class="dvs-card-top" style="background-image: url('<?= URL::asset('packages/devisephp/cms/img/default-images/sections/menus.gif') ?>')"></div>
            <div class="dvs-card-bottom">
                <div class="dvs-icon ion-android-menu"></div>
                <h5>Menus</h5>
                <p>Manage menus and children items.</p>
            </div>
        </div>

        <div class="dvs-admin-card dvs-templates" data-dvs-url="<?= URL::route('dvs-templates') ?>">
            <div class="dvs-card-top" style="background-image: url('<?= URL::asset('packages/devisephp/cms/img/default-images/sections/templates.gif') ?>')"></div>
            <div class="dvs-card-bottom">
                <div class="dvs-icon ion-android-apps"></div>
                <h5>Templates</h5>
                <p>Manage templates your pages can use.</p>
            </div>
        </div>

        <div class="dvs-admin-card dvs-users" data-dvs-url="<?= URL::route('dvs-users') ?>">
            <div class="dvs-card-top" style="background-image: url('<?= URL::asset('packages/devisephp/cms/img/default-images/sections/users.gif') ?>')"></div>
            <div class="dvs-card-bottom">
                <div class="dvs-icon ion-ios-person"></div>
                <h5>Users</h5>
                <p>Manage users and define group associations.</p>
            </div>
        </div>

        <div class="dvs-admin-card dvs-groups" data-dvs-url="<?= URL::route('dvs-groups') ?>">
            <div class="dvs-card-top" style="background-image: url('<?= URL::asset('packages/devisephp/cms/img/default-images/sections/groups.gif') ?>')"></div>
            <div class="dvs-card-bottom">
                <div class="dvs-icon ion-ios-people"></div>
                <h5>Groups</h5>
                <p>Manage groups and related details.</p>
            </div>
        </div>

        <div class="dvs-admin-card dvs-permissions" data-dvs-url="<?= URL::route('dvs-permissions') ?>">
            <div class="dvs-card-top" style="background-image: url('<?= URL::asset('packages/devisephp/cms/img/default-images/sections/permissions.gif') ?>')"></div>
            <div class="dvs-card-bottom">
                <div class="dvs-icon ion-ios-locked"></div>
                <h5>Permissions</h5>
                <p>Manage permission conditions.</p>
            </div>
        </div>

        <div class="dvs-admin-card dvs-languages" data-dvs-url="<?= URL::route('dvs-languages') ?>">
            <div class="dvs-card-top" style="background-image: url('<?= URL::asset('packages/devisephp/cms/img/default-images/sections/languages.gif') ?>')"></div>
            <div class="dvs-card-bottom">
                <div class="dvs-icon ion-android-globe"></div>
                <h5>Languages</h5>
                <p>Manage languages and set active languages.</p>
            </div>
        </div>
    </div>
@stop