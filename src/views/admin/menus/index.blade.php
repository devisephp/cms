@extends('devise::admin.layouts.master')

@section('title')

<h1>List of Menus</h1>
<p><label>Active Languages: {{ Form::select('language_id', $languages, (!Input::has('language_id')) ? 45 : Input::get('language_id'), array('id' => 'lang-select')) }}</label></p>

@stop

@section('main')

<div class="dvs-admin-form-horizontal">
	{{ Form::open(['route' => 'dvs-menus-store']) }}
		<div class="dvs-form-group">
			{{ Form::label('Menu Name') }}
	    	{{ Form::text('name', null, array('placeholder' => 'Menu Name', 'class' => 'form-control')) }}
		</div>

		{{ Form::submit('Create New Menu', array('class' => 'dvs-button dvs-button-large')) }}
    {{ Form::close() }}
</div>

<table class="dvs-admin-table">
	<thead>
		<tr>
			<th class="tal">
				Menu Name
			</th>
            <th class="tal">
                Language
            </th>
            <th class="actions">
            	Actions
            </th>
		</tr>
	</thead>

	<tbody id="languages" class="">
		@foreach($menus as $menu)
			<tr>
                <td>{{ $menu->name }}</td>
				<td>{{ $menu->language->name }}</td>
				<td class="actions">
					<a href="{{ route('dvs-menus-edit', $menu->id) }}" class="dvs-button dvs-button-small">Edit</a>
                    @if (!$page->dvs_admin)
						{{-- Form::delete(URL::route('dvs-menus-destroy', array($menu->id)), 'Delete', null, array('class'=>'dvs-button dvs-button-small dvs-button-danger')) --}}
					@endif
                </td>
			</tr>
		@endforeach
	</tbody>
</table>

<div class="dvs-admin-container">
    {{ $menus->links(); }}
</div>
    <script>require(['app/admin/admin'])</script>

@stop