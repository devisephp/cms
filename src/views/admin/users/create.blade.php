@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1><span class="ion-ios-person"></span> New User</h1>
    </div>
@stop

@section('subnavigation')
    <div id="dvs-admin-actions">
        <?= link_to(URL::route('dvs-users'), 'List of Users', array('class'=>'dvs-button dvs-button-secondary')) ?>
    </div>
@stop

@section('main')
    <div class="dvs-admin-form-horizontal">
        <?= Form::open(array('route' => 'dvs-users-store')) ?>
            <div class="dvs-form-group">
                <?= Form::label('Active') ?>
                <?= Form::checkbox('activated', true, true) ?>
            </div>

            <div class="dvs-form-group">
                <?= Form::label('User Group') ?>
                <?= Form::select('group_id', ['Choose an option'] + $groups) ?>
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
                <?= Form::label('Password') ?>
                <?= Form::password('password') ?>
            </div>

            <div class="dvs-form-group">
                <?= Form::label('Confirm Password') ?>
                <?= Form::password('password_confirmation') ?>
            </div>

            <div class="dvs-form-group">
                <div class="dvs-submit-margin">&nbsp;</div>
                    <?= Form::submit('Create User', ['class' => 'dvs-button dvs-button-solid dvs-button-success']) ?>
                </div>
            </div>
        <?= Form::close() ?>
    </div>
@stop