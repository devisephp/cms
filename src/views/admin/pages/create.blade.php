@extends('devise::admin.layouts.master')

@section('subnavigation')
	<ul>
		<li><a href="{{ route('dvs-pages') }}" class="dvs-button">List of Pages</a></li>
	</ul>
@stop

@section('title')

<h1>Create a New Page</h1>
<h3><span>About This</span></h3>
<p>Bacon ipsum dolor sit amet pork loin chicken doner leberkas, tail jerky brisket kevin jowl meatloaf prosciutto beef ham hock meatball fatback. Turkey kevin tenderloin, pork shank boudin andouille landjaeger cow meatloaf hamburger shankle strip steak pork belly tongue. </p>

@stop

@section('main')
	<div class="dvs-admin-form-horizontal">
		{{ Form::open(array('method' => 'POST', 'route' => array('dvs-pages-store'))) }}

            @include('devise::admin.pages._page-form')

			{{ Form::submit('Create Page', array('class' => 'dvs-button dvs-button-large')) }}
		{{ Form::close() }}
	</div>

    <script data-main="{{ URL::asset('/packages/devise/cms/js/config') }}" src="{{ URL::asset('/packages/devise/cms/js/require.js') }}"></script>
    <script>require(['app/admin/pages'])</script>
@stop