@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1><span class=" ion-document"></span> New Page</h1>
    </div>
@stop

@section('subnavigation')
    <div id="dvs-admin-actions">
        <?= link_to(URL::route('dvs-pages'), 'List of Pages', array('class'=>'dvs-button dvs-button-secondary')) ?>
    </div>
@stop

@section('main')
	<div class="dvs-admin-form-horizontal">
		<?= Form::open(array('method' => 'POST', 'route' => array('dvs-pages-store'))) ?>

            @include('devise::admin.pages._page-form', ['method' => 'store'])

            <div class="dvs-form-group">
                <div class="dvs-submit-margin">&nbsp;</div>
                    <?= Form::submit('Create Page', array('class' => 'dvs-button dvs-button-solid dvs-button-success')) ?>
                </div>
            </div>
		<?= Form::close() ?>
	</div>

    <script data-main="<?= URL::asset('/packages/devisephp/cms/js/config') ?>" src="<?= URL::asset('/packages/devisephp/cms/js/require.js') ?>"></script>
    <script>devise.require(['app/admin/pages'])</script>
@stop