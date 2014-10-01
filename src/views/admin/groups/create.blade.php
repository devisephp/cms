@extends('devise::admin.layouts.master')

@section('subnavigation')
	<ul>
		<li><a href="{{ route('dvs-groups') }}" class="dvs-button">List of Groups</a></li>
	</ul>
@stop

@section('title')

<h1>Create a New Group</h1>
<h3><span>About This</span></h3>
<p>Bacon ipsum dolor sit amet pork loin chicken doner leberkas, tail jerky brisket kevin jowl meatloaf prosciutto beef ham hock meatball fatback. Turkey kevin tenderloin, pork shank boudin andouille landjaeger cow meatloaf hamburger shankle strip steak pork belly tongue. </p>

@stop

@section('main')
	<div class="dvs-admin-form-horizontal">
	    {{ Form::open(array('route' => array('dvs-groups-store'))) }}
		    <div class="dvs-form-group">
		        {{ Form::label('Name') }}<br>
		        {{ Form::text('name') }}<br>
			</div>
			
	        {{ Form::submit('Create Group', array('class' => 'dvs-button dvs-button-large')) }}<br>
	    {{ Form::close() }}
	</div>
@stop