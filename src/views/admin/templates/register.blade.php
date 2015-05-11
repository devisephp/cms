@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1><span class="ion-android-apps"></span> Register Template</h1>
    </div>
@stop

@section('subnavigation')
    <div id="dvs-admin-actions">
        <?= link_to(URL::route('dvs-templates'), 'All Templates', array('class'=>'dvs-button dvs-button-secondary')) ?>
    </div>
@stop

@section('main')
    <div class="dvs-admin-form-horizontal">
        <?= Form::open(array('method' => 'POST', 'route' => array('dvs-templates-store'))) ?>

            <div class="dvs-form-group">
                <?= Form::label('File Name') ?>
                <?= Form::select('file_name', [0 => 'Choose an option'] + $unregisteredTemplatesList) ?>
            </div>

            <div class="dvs-form-group">
                <?= Form::label('Human Name') ?>
                <?= Form::text('human_name') ?>
            </div>

            <div class="dvs-form-group">
                <?= Form::label('Extends') ?>
                <?= Form::text('extends') ?>
            </div>

            <div class="dvs-form-group">
                <div class="dvs-submit-margin">&nbsp;</div>
                    <?= Form::submit('Register Template', array('class' => 'dvs-button dvs-button-solid dvs-button-success')) ?>
                </div>
            </div>
        <?= Form::close() ?>
    </div>
@stop
