@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1>Create a New Page</h1>

        <p>Use the form below to create a new page and define any page-related settings.</p>
    </div>

    <div id="dvs-admin-actions">
        {{ link_to(URL::route('dvs-pages'), 'List of Pages', array('class'=>'dvs-button')) }}
    </div>
@stop

@section('main')
	<div class="dvs-admin-form-horizontal">
		{{ Form::open(array('method' => 'POST', 'route' => array('dvs-pages-store'))) }}

            @include('devise::admin.pages._page-form', ['method' => 'store'])

			{{ Form::submit('Create Page', array('class' => 'dvs-button dvs-button-large')) }}
		{{ Form::close() }}
	</div>

    <script data-main="{{ URL::asset('/packages/devisephp/cms/js/config') }}" src="{{ URL::asset('/packages/devisephp/cms/js/require.js') }}"></script>
    <script>devise.require(['app/admin/pages'])</script>
@stop