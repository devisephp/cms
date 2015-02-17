@extends('devise::admin.layouts.master')

@section('main')
	<div class="dvs-admin-container">
        <div class="dvs-admin-card" data-dvs-url="<?= URL::route('dvs-pages') ?>">
            <div class="dvs-card-bottom">
                <h3>Pages</h3>
                <p>Manage pages, set URLs, and page versions.</p>
            </div>
        </div>

        <div class="dvs-admin-card" data-dvs-url="<?= URL::route('dvs-menus') ?>">
            <div class="dvs-card-bottom">
                <h3>Menus</h3>
                <p>Manage menus and children items.</p>
            </div>
        </div>

        <div class="dvs-admin-card" data-dvs-url="<?= URL::route('dvs-users') ?>">
            <div class="dvs-card-bottom">
                <h3>Users</h3>
                <p>Manage users and define group associations.</p>
            </div>
        </div>

        <div class="dvs-admin-card" data-dvs-url="<?= URL::route('dvs-groups') ?>">
            <div class="dvs-card-bottom">
                <h3>Groups</h3>
                <p>Manage groups and related details.</p>
            </div>
        </div>

        <div class="dvs-admin-card" data-dvs-url="<?= URL::route('dvs-permissions') ?>">
            <div class="dvs-card-bottom">
                <h3>Permissions</h3>
                <p>Manage permission conditions.</p>
            </div>
        </div>

        <div class="dvs-admin-card" data-dvs-url="<?= URL::route('dvs-templates') ?>">
            <div class="dvs-card-bottom">
                <h3>Templates</h3>
                <p>Import and manage templates your pages can use.</p>
            </div>
        </div>

        <div class="dvs-admin-card" data-dvs-url="<?= URL::route('dvs-languages') ?>">
            <div class="dvs-card-bottom">
                <h3>Languages</h3>
                <p>Manage languages and set active languages.</p>
            </div>
        </div>
	</div>
@stop