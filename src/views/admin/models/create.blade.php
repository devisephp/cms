@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1><span class="ion-android-apps"></span> Model Builder</h1>
    </div>
@stop

@section('main')

    <div class="dvs-admin-form-horizontal">
        <?= Form::open(array('method' => 'POST', 'route' => array('dvs-model-creator-store'), 'class' => 'dvs-model-creator-form')) ?>

            <div class="dvs-form-group">
                <?= Form::label('Model Name') ?>
                <?= Form::text('model_name') ?>
            </div>

            <div class="dvs-form-group">
                <?= Form::label('timestamps') ?>
                <div class="fancyCheckbox">
                    <?= Form::checkbox('timestamps', 'on', false, array('id' => 'timestamps')) ?>
                    <?= Form::label('timestamps', '&nbsp;') ?>
                </div>
            </div>

            <div class="dvs-form-group">
                <?= Form::label('deleted_at', 'Soft Delete') ?>
                <div class="fancyCheckbox">
                    <?= Form::checkbox('deleted_at', 'on', false, array('id' => 'deleted_at')) ?>
                    <?= Form::label('deleted_at', '&nbsp;') ?>
                </div>
            </div>

            <div class="dvs-form-group">
                <?= Form::label('Model Fields') ?>
                <button type="button" class="dvs-button dvs-button-secondary dvs-add-model-field">Add Field</button>
            </div>

            <div class="dvs-form-group">
                <ol class="dvs-sort-items sortable" id="dvs-fields-list">
                    <li class="dvs-field" data-dvs-field-id="0">
                        <div class="ui-sortable-handle">
                            <?= Form::text('fields[0][name]', 'id', ['class' => 'dvs-pl', 'placeholder' => 'Name']) ?>
                            <?= Form::select('fields[0][type]', $fieldTypesList, 'increments', ['class' => '']) ?>
                            <?= Form::text('fields[0][label]', 'Id', ['class' => 'dvs-pl', 'placeholder' => 'Label']) ?>
                            <?= Form::text('fields[0][default]', null, ['class' => 'dvs-pl', 'placeholder' => 'Default Value']) ?>
                            <?= Form::select('fields[0][formType]', [0 => 'Form Type'] + $formTypesList, null, ['class' => 'dvs-form-type']) ?>
                            <?= Form::button('<span class="ion-android-close"></span>', array('class' => 'dvs-remove-field dvs-button dvs-button-danger dvs-button-tiny dvs-pr')) ?>

                            <div class="dvs-form-group dvs-borderless">
                                <button class="dvs-hidden dvs-add-choice dvs-button dvs-button-secondary dvs-button-tiny" type="button">Add Choice</button>
                                <label><?= Form::checkbox('fields[0][displayForm]', true, false) ?> On Form</label>
                                <label><?= Form::checkbox('fields[0][displayIndex]', true, true) ?> On Index</label>
                                <label><?= Form::checkbox('fields[0][index]', 'index', true) ?> Is Index</label>
                            </div>

                            <ol class="dvs-choices-list">
                            </ol>
                        </div>
                    </li>
                </ol>
            </div>

            <?= Form::submit('Create Model', array('class' => 'dvs-button dvs-button-solid dvs-button-success')) ?>
        <?= Form::close() ?>
    </div>
@stop

@section('js')
    <script>
        var newFieldHtml = '@include("devise::admin.models._single-field-html")';
        var newChoiceHtml = '@include("devise::admin.models._single-choice-html")';

        devise.require(['app/admin/models']);
    </script>
@stop