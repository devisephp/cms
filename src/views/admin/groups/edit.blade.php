@extends('devise::admin.layouts.master')

@section('subnavigation')
<ul>
    <li></li>
</ul>
@stop

@section('title')
    <div id="dvs-admin-title">
        <h1>Edit Group</h1>
    </div>

    <div id="dvs-admin-actions">
        {{ link_to(URL::route('dvs-groups'), 'List of Groups', array('class'=>'dvs-button')) }}
    </div>
@stop

@section('main')
	<div class="dvs-admin-form-horizontal">
	    {{ Form::model($group, array('method' => 'PUT', 'route' => array('dvs-groups-update', $group->id))) }}
            <div class="dvs-form-group">
    	        {{ Form::label('Name') }}
    	        {{ Form::text('name', $group->name) }}
            </div>

	        {{ Form::submit('Update Group', ['class' => 'dvs-button dvs-button-large']) }}<br>
	    {{ Form::close() }}
	</div>
@stop