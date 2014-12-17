@extends('devise::admin.layouts.master')

@section('title')

<h1>Edit Menu</h1>
<h3><span>PAGE: {{ $page->title }}</span></h3>
@if ($page->short_description != '')
<p>{{ $page->short_description }}</p>
@else
<br><br>
@endif

@stop

@section('main')

<div class="dvs-admin-form-horizontal">
    {{ Form::open(array('method' => 'put', 'route' => array('dvs-menus-update', $menu->id), 'class' => 'js-menu-form')) }}

		<div class="dvs-form-group">
		    {{ Form::label('Menu Name') }}
		    {{ Form::text('name', $menu->name, array('placeholder' => 'Menu')) }}
		</div>

		<div class="dvs-form-group">
		    {{ Form::label('Menu Items') }}
		    <button type="button" class="dvs-button js-add-menu-item">Add Item</button>
		</div>

		<div class="dvs-form-group">

			<ol class="sortable dvs-menu-items">
				@foreach ($menu->items as $item)
					@include('devise::admin.menus._items', ['item' => $item])
				@endforeach
			</ol>
		</div>

		{{ Form::submit('Update Menu', array('class' => 'dvs-button dvs-button-large')) }}
    {{ Form::close() }}
</div>

@include('devise::admin.menus._itemsjs')
<script>require(['app/admin/menus.edit'])</script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('/packages/devisephp/cms/css/jquery.nestedSortable.css') }}">

@stop