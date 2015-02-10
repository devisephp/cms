@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1>Create Group</h1>
        <p>Use the form below to create a new group.</p>
    </div>

    <div id="dvs-admin-actions">
        <?= link_to(URL::route('dvs-groups'), 'List of Groups', array('class'=>'dvs-button')) ?>
    </div>
@stop

@section('main')
	<div class="dvs-admin-form-horizontal">
	    <?= Form::open(array('route' => array('dvs-groups-store'))) ?>
		    <div class="dvs-form-group">
		        <?= Form::label('Name') ?><br>
		        <?= Form::text('name') ?><br>
			</div>

	        <?= Form::submit('Create Group', array('class' => 'dvs-button dvs-button-large')) ?><br>
	    <?= Form::close() ?>
	</div>
@stop