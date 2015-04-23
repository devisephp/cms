@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1><span class="ion-android-apps"></span> Edit Template</h1>
    </div>
@stop

@section('subnavigation')
    <div id="dvs-admin-actions">
        <?= link_to(URL::route('dvs-templates'), 'List of Templates', array('class'=>'dvs-button dvs-button-secondary')) ?>
    </div>
@stop

@section('modals')

    <div class="dvs-hidden" id="dvs-admin-modal"></div>
    <div class="dvs-hidden" id="dvs-admin-blocker"></div>

@stop

@section('main')
    <div class="dvs-admin-form-horizontal">
        <?= Form::open(array('method' => 'PUT', 'route' => array('dvs-templates-update', $params['templatePath']))) ?>
            <?= Form::hidden('template_path', $params['templatePath']) ?>

            <div class="dvs-form-group">
                <?= Form::label('Human Name') ?>
                <?= Form::text('template[human_name]', array_get($template, 'human_name', '')) ?>
            </div>

            <div class="dvs-form-group">
                <?= Form::label('Extends') ?>
                <?= Form::text('template[extends]', array_get($template, 'newExtends', $template['extends'])) ?>
            </div>

            @include('devise::admin.templates.variables._variables-table')

            <?= Form::submit('Update Template', array('class' => 'dvs-button dvs-button-solid dvs-button-success')) ?>
        <?= Form::close() ?>
    </div>

    <script>
        var target = '.dvs-add-button';
        devise.require(['app/admin/templates', 'dvsModal']);
    </script>
@stop
