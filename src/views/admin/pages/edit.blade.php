@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1><span class="ion-document"></span> Edit Page</h1>
    </div>
@stop

@section('css')
    <link href="{{ URL::asset('/packages/devisephp/cms/css/devise-vue.css') }}" type="text/css" rel="stylesheet">
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

            <div class="dvs-form-group">
                <div class="dvs-submit-margin">&nbsp;</div>
                    <?= Form::submit('Edit Page', array('class' => 'dvs-button dvs-button-solid dvs-button-success')) ?>
                </div>
            </div>
        <?= Form::close() ?>

        <div class="dvs-admin-form-horizontal" style="margin-top:30px;">
          <h4>Page Specific Meta</h4>
          <div id="app"></div>
        </div>
    </div>

    <script>
      window.mode = "meta"
      window.pageId = {{ $page->id }}
    </script>

    <script src="https://localhost:8080/app.js"></script>
    {{-- <script type=text/javascript src="/packages/devisephp/cms/js/devise-vue-manifest.js"></script>
    <script type=text/javascript src="/packages/devisephp/cms/js/devise-vue-vendor.js"></script>
    <script type=text/javascript src="/packages/devisephp/cms/js/devise-vue.js"></script> --}}

    <script data-main="<?= URL::asset('/packages/devisephp/cms/js/config') ?>" src="<?= URL::asset('/packages/devisephp/cms/js/require.js') ?>"></script>
    <script>devise.require(['app/admin/pages'])</script>
@stop
