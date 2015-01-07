@extends('devise::admin.layouts.master')

@section('title')

    <div id="dvs-admin-title">
        <h1>Copy Page</h1>

        <p>COPYING PAGE: {{ $page->title }}</p>
    </div>

    <div id="dvs-admin-actions">
        {{ link_to(URL::route('dvs-pages'), 'List of Pages', array('class'=>'dvs-button')) }}
    </div>

@stop

@section('main')
<div class="dvs-admin-form-horizontal">
	<?php
		$page->title = $page->title . ' Copy';
	?>

    {{ Form::model($page, array('method' => 'POST', 'route' => array('dvs-pages-copy-store', $page->id))) }}

        @include('devise::admin.pages._page-form', ['translatedFromPage' => true, 'method' => 'copy'])

        {{ Form::submit('Copy Page', array('class' => 'dvs-button dvs-button-large')) }}

    {{ Form::close() }}
</div>

<script data-main="{{ URL::asset('/packages/devisephp/cms/js/config') }}" src="{{ URL::asset('/packages/devisephp/cms/js/require.js') }}"></script>
<script>devise.require(['app/admin/pages'])</script>
@stop