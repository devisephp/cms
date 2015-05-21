@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1><span class="ion-code-working"></span> Edit API Request</h1>
    </div>
@stop

@section('subnavigation')
    <div id="dvs-admin-actions">
        <?= link_to(URL::route('dvs-api'), 'List of API Requests', array('class'=>'dvs-button dvs-button-secondary')) ?>
    </div>
@stop

@section('main')
    <div class="dvs-admin-form-horizontal">
        <?= Form::model($page, array('method' => 'PUT', 'route' => array('dvs-api-update', $page->id))) ?>
            @include('devise::admin.api._form', ['method' => 'update'])

            <?= Form::submit('Edit Request', array('class' => 'dvs-button dvs-button-solid dvs-button-success')) ?>
        <?= Form::close() ?>
    </div>

    <script data-main="<?= URL::asset('/packages/devisephp/cms/js/config') ?>" src="<?= URL::asset('/packages/devisephp/cms/js/require.js') ?>"></script>
    <script>devise.require(['app/admin/pages'])</script>
@stop
