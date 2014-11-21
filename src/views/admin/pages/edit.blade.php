@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1>Edit Page</h1>

        <p>Use the form below to update a page and/or any page-related settings.</p>
    </div>

    <div id="dvs-admin-actions">
        {{ link_to(URL::route('dvs-pages'), 'List of Pages', array('class'=>'dvs-button')) }}
    </div>
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
