@extends('devise::admin.layouts.master')

@section('subnavigation')
<ul>
    <li>{{ link_to(URL::route('dvs-pages'), 'List of Pages', array('class'=>'dvs-button')) }}</li>
</ul>
@stop

@section('title')

<h1>Copy Page</h1>
<h3><span>COPYING PAGE: {{ $page->title }}</span></h3>
@if ($page->short_description != '')
<p>{{ $page->short_description }}</p>
@else
<br><br>
@endif

@stop

@section('main')
<div class="dvs-admin-form-horizontal">
	<?php
		$page->title = $page->title . ' Copy';
	?>

    {{ Form::model($page, array('method' => 'POST', 'route' => array('dvs-pages-copy-store', $page->id))) }}

        @include('devise::admin.pages._page-form', array('translatedFromPage' => true))

        {{ Form::submit('Copy Page', array('class' => 'dvs-button dvs-button-large')) }}

    {{ Form::close() }}
</div>

<script data-main="{{ URL::asset('/packages/devisephp/cms/js/config') }}" src="{{ URL::asset('/packages/devisephp/cms/js/require.js') }}"></script>
<script>require(['app/admin/pages'])</script>
@stop