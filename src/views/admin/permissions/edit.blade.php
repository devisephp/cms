@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1><span class="ion-lock-combination"></span> Edit Permission</h1>
    </div>
@stop

@section('subnavigation')
    <div id="dvs-admin-actions">
        <?= link_to(URL::route('dvs-permissions'), 'All Permissions', array('class'=>'dvs-button dvs-button-secondary')) ?>
    </div>
@stop

@section('main')
    <div class="dvs-admin-form-horizontal">
        <?= Form::open(array('method' => 'PUT', 'route' => array('dvs-permissions-update'))) ?>
            <?= Form::hidden('permission_name', $input['condition']) ?>

            <div class="dvs-form-group">
                <?= Form::label('Condition') ?>
                <?= Form::text('permission_name_edit', $input['condition'], array('id'=>'permission-name')) ?>
                <span data-dvs-document="condition" class="dvs-document-button"></span>
            </div>

            <div class="dvs-form-group">
                <?= Form::label('Redirect Route or Action') ?>
                <?= Form::text('redirect', isset($permission['redirect']) ? $permission['redirect'] : null, array('class' => 'short')) ?>
                <span data-dvs-document="redirect-route-or-action" class="dvs-document-button"></span>
            </div>

            <div class="dvs-form-group">
                <?= Form::label('Redirect Type') ?>
                <?= Form::select('redirect_type', ['route'=>'Route','action'=>'Action'], isset($permission['redirect_type']) ? $permission['redirect_type'] : null, array('class' => 'short')) ?>
                <span data-dvs-document="redirect-type" class="dvs-document-button"></span>
            </div>

            <div class="dvs-form-group">
                <?= Form::label('Redirect Message') ?>
                <?= Form::text('redirect_message', isset($permission['redirect_message']) ? $permission['redirect_message'] : null, array('class' => 'short')) ?>
                <span data-dvs-document="redirect-message" class="dvs-document-button"></span>
            </div>

            <div id="dvs-permissions">
                <div class="dvs-form-group">
                    @foreach(array_except($permission,['redirect','redirect_type','redirect_message']) as $operator => $rules)
                        @include('devise::admin.permissions._group', array(
                            'operator' => $operator,
                            'rules' => array_except($rules,['or','and']),
                            'groups' => array_only($rules,['or','and']
                        )))
                    @endforeach
                </div>
            </div>

        <div class="dvs-form-group">
            <div class="dvs-submit-margin">&nbsp;</div>
                <?= Form::submit('Update Permission', array('class' => 'dvs-button')) ?>
                <?= Form::button('Reset Form', array('class' => 'dvs-button', 'id' => 'dvs-reset-form')) ?>
            </div>
        </div>


        <?= Form::close() ?>
    </div>

    <script>
        var ruleParamMap = <?= json_encode($ruleParamMap) ?>;
        var emptyParamInput = '<?= Form::text('', null, array('class' => 'rule-param', 'placeholder' => 'Parameter')) ?>';
        var emptyGroup = '<?= HTML::getHtmlForJsVar('devise::admin.permissions._group', array('availableRulesList'=> $availableRulesList)) ?>';
        var emptyRule = '<?= HTML::getHtmlForJsVar('devise::admin.permissions._rule', array('availableRulesList'=> $availableRulesList)) ?>';
        var operatorHtml = '<?= HTML::getHtmlForJsVar('devise::admin.permissions._operator') ?>';
        devise.require(['app/admin/permissions'], function(obj) {
            obj.initialize();
        });
    </script>
@stop
