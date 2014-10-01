@extends('devise::admin.layouts.master')

@section('subnavigation')
<ul>
    <li>{{ link_to(URL::route('dvs-pages'), 'List of Pages', array('class'=>'dvs-button')) }}</li>
</ul>
@stop

@section('title')

<h1>Edit Page</h1>
<h3><span>PAGE: {{ $page->title }}</span></h3>
@if ($page->short_description != '')
<p>{{ $page->short_description }}</p>
@else
<br><br>
@endif

@stop

@section('main')
<div class="dvs-admin-form-horizontal">
    {{ Form::model($page, array('method' => 'PUT', 'route' => array('dvs-pages-update', $page->id))) }}

        @include('devise::admin.pages._page-form')

        {{ Form::submit('Edit Page', array('class' => 'dvs-button dvs-button-large')) }}

    {{ Form::close() }}
</div>

<script data-main="{{ URL::asset('/packages/devise/cms/js/config') }}" src="{{ URL::asset('/packages/devise/cms/js/require.js') }}"></script>
<script>require(['app/admin/pages'])</script>
@stop
