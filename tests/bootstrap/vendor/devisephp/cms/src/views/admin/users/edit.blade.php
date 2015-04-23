@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1><span class="ion-ios-person"></span> Editing User</h1>
    </div>
@stop

@section('subnavigation')
    <div id="dvs-admin-actions">
        <?= link_to(URL::route('dvs-users'), 'List of Users', array('class'=>'dvs-button dvs-button-secondary')) ?>
    </div>
@stop

@section('main')
    <div class="dvs-admin-form-horizontal">
        <?= Form::model($user, array('method' => 'PUT', 'route' => array('dvs-users-update', $user->id))) ?>
        	<div class="dvs-form-group">
                <?= Form::label('Active') ?>
                <?= Form::checkbox('activated') ?>
            </div>

            <div class="dvs-form-group">
                <?= Form::label('Group(s)') ?>
                @foreach ($groups as $groupId => $groupName)
                    <?= Form::checkbox('group_id[]', $groupId, in_array($groupId, array_keys($usersGroups))) ?> <?= $groupName ?>
                @endforeach
            </div>

            <div class="dvs-form-group">
                <?= Form::label('Name') ?>
                <?= Form::text('name') ?>
            </div>

            <div class="dvs-form-group">
                <?= Form::label('Email') ?>
                <?= Form::text('email') ?>
            </div>

            <div class="dvs-form-group">
                <?= Form::label('Username') ?>
                <?= Form::text('username') ?>
            </div>

            <div class="dvs-form-group">
                <label for="password">Password (enter only to change)</label>
                <?= Form::password('password') ?>
            </div>

            <div class="dvs-form-group">
                <?= Form::label('Confirm Password') ?>
                <?= Form::password('password_confirmation') ?>
            </div>

            <?= Form::submit('Update User', ['class' => 'dvs-button dvs-button-solid dvs-button-success']) ?>
        <?= Form::close() ?>
    </div>
@stop