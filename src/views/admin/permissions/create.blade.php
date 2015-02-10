@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1>Register New Permission</h1>

        <p>Use the form below to register a new permission.</p>
    </div>

    <div id="dvs-admin-actions">
        <?= link_to(URL::route('dvs-permissions'), 'List of Permissions', array('class'=>'dvs-button')) ?>
    </div>
@stop

@section('main')
    <div class="dvs-admin-form-horizontal">
        <?= Form::open(array('method' => 'POST', 'route' => array('dvs-permissions-store'))) ?>
            <div class="dvs-form-group">
                <?= Form::label('Condition') ?>
                <?= Form::text('permission_name', null, array('id'=>'permission-name')) ?>
            </div>

            <div class="dvs-form-group">
                <?= Form::label('Redirect Route or Action') ?>
                <?= Form::text('redirect', null, array('class' => 'short')) ?>
            </div>

            <div class="dvs-form-group">
                <?= Form::label('Redirect Type') ?>
                <?= Form::select('redirect_type', ['route'=>'Route','action'=>'Action'], null, array('class' => 'short')) ?>
            </div>

            <div class="dvs-form-group">
                <?= Form::label('Redirect Message') ?>
                <?= Form::text('redirect_message', null, array('class' => 'short')) ?>
            </div>

            <div id="dvs-permissions">
                <div class="dvs-form-group">
                    @include('devise::admin.permissions._group')
                </div>
            </div>

            <?= Form::submit('Update Permission', array('class' => 'dvs-button')) ?>

            <?= Form::button('Reset Form', array('class' => 'dvs-button', 'id' => 'dvs-reset-form')) ?>

        <?= Form::close() ?>
    </div>

    <script>
        var ruleParamMap = {{ json_encode($ruleParamMap) }};
        var emptyParamInput = '{{ Form::text('', null, array('class' => 'rule-param', 'placeholder' => 'Parameter')) }}';
        var emptyGroup = '{{ HTML::getHtmlForJsVar('devise::admin.permissions._group', array('availableRulesList'=> $availableRulesList)) }}';
        var emptyRule = '{{ HTML::getHtmlForJsVar('devise::admin.permissions._rule', array('availableRulesList'=> $availableRulesList)) }}';
        var operatorHtml = '{{ HTML::getHtmlForJsVar('devise::admin.permissions._operator') }}';
        devise.require(['app/admin/permissions'], function(obj) {
            obj.initialize();
        });
    </script>
@stop
