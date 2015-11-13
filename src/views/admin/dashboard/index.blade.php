@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1><span class="ion-speedometer"></span> Dashboard</h1>
    </div>
@stop

@section('main')

    <div class="dvs-flexbox">
        <div class="dvs-admin-card wide dvs-pages" data-dvs-url="<?= URL::route('dvs-pages') ?>">
            <div class="dvs-card-top">
                <span class="dvs-icon ion-document"></span>
            </div>
            <div class="dvs-card-bottom">
                <div class="dvs-icon ion-document"></div>
                <h5>Pages</h5>
                <p>Manage pages, set URLs, and page versions.</p>
            </div>
        </div>

        @if (DeviseUser::checkConditions('isDeveloper'))
            <div class="dvs-admin-card dvs-api" data-dvs-url="<?= URL::route('dvs-api') ?>">
                <div class="dvs-card-top">
                    <span class="dvs-icon ion-code-working"></span>
                </div>
                <div class="dvs-card-bottom">
                    <div class="dvs-icon ion-code-working"></div>
                    <h5>APIs</h5>
                    <p>Where your application does stuff.</p>
                </div>
            </div>
        @endif

        <div class="dvs-admin-card dvs-menus" data-dvs-url="<?= URL::route('dvs-menus') ?>">
            <div class="dvs-card-top">
                <span class="dvs-icon ion-android-menu"></span>
            </div>
            <div class="dvs-card-bottom">
                <div class="dvs-icon ion-android-menu"></div>
                <h5>Menus</h5>
                <p>Manage menus and children items.</p>
            </div>
        </div>

        @if (DeviseUser::checkConditions('isDeveloper'))
            <div class="dvs-admin-card dvs-templates" data-dvs-url="<?= URL::route('dvs-templates') ?>">
                <div class="dvs-card-top">
                    <span class="dvs-icon ion-android-apps"></span>
                </div>
                <div class="dvs-card-bottom">
                    <div class="dvs-icon ion-android-apps"></div>
                    <h5>Templates</h5>
                    <p>Manage templates your pages can use.</p>
                </div>
            </div>
        @endif

        <div class="dvs-admin-card dvs-users" data-dvs-url="<?= URL::route('dvs-users') ?>">
            <div class="dvs-card-top">
                <span class="dvs-icon ion-ios-person"></span>
            </div>
            <div class="dvs-card-bottom">
                <div class="dvs-icon ion-ios-person"></div>
                <h5>Users</h5>
                <p>Manage users and define group associations.</p>
            </div>
        </div>

        @if (DeviseUser::checkConditions('isDeveloper'))
            <div class="dvs-admin-card dvs-groups" data-dvs-url="<?= URL::route('dvs-groups') ?>">
                <div class="dvs-card-top">
                    <span class="dvs-icon ion-ios-people"></span>
                </div>
                <div class="dvs-card-bottom">
                    <div class="dvs-icon ion-ios-people"></div>
                    <h5>Groups</h5>
                    <p>Manage groups and related details.</p>
                </div>
            </div>

            <div class="dvs-admin-card dvs-permissions" data-dvs-url="<?= URL::route('dvs-permissions') ?>">
                <div class="dvs-card-top">
                    <span class="dvs-icon ion-lock-combination"></span>
                </div>
                <div class="dvs-card-bottom">
                    <div class="dvs-icon ion-lock-combination"></div>
                    <h5>Permissions</h5>
                    <p>Manage permission conditions.</p>
                </div>
            </div>
        @endif

        <div class="dvs-admin-card dvs-languages" data-dvs-url="<?= URL::route('dvs-languages') ?>">
            <div class="dvs-card-top">
                <span class="dvs-icon ion-android-globe"></span>
            </div>
            <div class="dvs-card-bottom">
                <div class="dvs-icon ion-android-globe"></div>
                <h5>Languages</h5>
                <p>Manage languages and set active languages.</p>
            </div>
        </div>
    </div>

    <script>devise.require(['app/admin/dashboard'])</script>
@stop