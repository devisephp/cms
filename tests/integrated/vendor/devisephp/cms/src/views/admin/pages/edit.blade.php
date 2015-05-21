@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1><span class="ion-document"></span> Edit Page</h1>
    </div>
@stop

@section('subnavigation')
    <div id="dvs-admin-actions">
        <?= link_to(URL::route('dvs-pages'), 'List of Pages', array('class'=>'dvs-button dvs-button-secondary')) ?>
    </div>
@stop

@section('main')
    <div class="dvs-admin-form-horizontal">
        <?= Form::model($page, array('method' => 'PUT', 'route' => array('dvs-pages-update', $page->id))) ?>

            @include('devise::admin.pages._page-form', ['method' => 'update'])

            <?= Form::submit('Edit Page', array('class' => 'dvs-button dvs-button-solid dvs-button-success')) ?>
        <?= Form::close() ?>
    </div>

    <script data-main="<?= URL::asset('/packages/devisephp/cms/js/config') ?>" src="<?= URL::asset('/packages/devisephp/cms/js/require.js') ?>"></script>
    <script>devise.require(['app/admin/pages'])</script>
@stop
