@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1><span class="ion-ios-copy-outline"></span> Copy Page</h1>
    </div>
@stop

@section('subnavigation')
    <div id="dvs-admin-actions">
        <?= link_to(URL::route('dvs-pages'), 'List of Pages', array('class'=>'dvs-button dvs-button-secondary')) ?>
    </div>
@stop

@section('main')

@if(!isset($input['reason']))
    @if(isset($languages) && count($languages) <= 1)
        <div class="alert">
            <h2>Notice about copying page <?= $page->title ?></h2>
            <ul class="list"><li>Translate option is unavailable because the page has been translated to all available languages.</li></ul>
        </div>
    @endif

    <div class="dvs-admin-form-horizontal">
        <h3>Reason For Making Copy</h3>
        <hr>

        <div class="dvs-form-group">
            <?= Form::label('Please Select One') ?>
                <?= link_to(URL::route('dvs-pages-copy', array($page->id)) . '?reason=copy', 'Basic Page Copy', array('class'=>'dvs-button dvs-button-secondary')) ?>
                @if(isset($languages) && count($languages) >= 1)
                    <?= link_to(URL::route('dvs-pages-copy', array($page->id)) . '?reason=translate', 'Translate Page', array('class'=>'dvs-button dvs-button-secondary')) ?>
                @endif
            <div class="dvs-helptext">
                <p>For what purpose are you copying this page.</p>
            </div>
        </div>
    </div>

@else

    <div class="dvs-admin-form-horizontal">
    	<?php
    		$page->title = $page->title . ' Copy';
    	?>

        <?= Form::model($page, array('method' => 'POST', 'route' => array('dvs-pages-copy-store', $page->id))) ?>

            <h3>Page Version</h3>

            <hr>

            <div class="dvs-form-group">
                <?= Form::label('Version To Copy') ?>
                <?= Form::select('page_version_id', $versionsList, ($liveVersion) ? $liveVersion->id : null, array('id' => 'http-verb')) ?>
                <div class="dvs-helptext">
                    <p>Which page version would you like to use when this copy is created. The currently live version (if one exists) is selected by default.</p>
                </div>
            </div>

            @include('devise::admin.pages._page-form', ['method' => $input['reason']])

            <?= Form::submit('Copy Page', array('class' => 'dvs-button dvs-button-large')) ?>

        <?= Form::close() ?>
    </div>

@endif

<script data-main="<?= URL::asset('/packages/devisephp/cms/js/config') ?>" src="<?= URL::asset('/packages/devisephp/cms/js/require.js') ?>"></script>
<script>devise.require(['app/admin/pages'])</script>
@stop