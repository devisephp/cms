@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1>List of Menus</h1>
    </div>

    <div id="dvs-admin-actions">
        {{ Form::select('language_id', $languages, (!Input::has('language_id')) ? 45 : Input::get('language_id'), array('id' => 'lang-select', 'class' => 'dvs-select')) }}</label>
    </div>
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
    			<th class="dvs-tac">{{ Sort::link('name','Menu Name') }}</th>
                <th class="dvs-tac">{{ Sort::link('language_id','Language') }}</th>
                <th>{{ Sort::clearSortLink('Clear Sort', array('class'=>'dvs-button dvs-button-small dvs-button-outset')) }}</th>
    		</tr>
    	</thead>

    	<tbody id="menus">
    		@foreach($menus as $menu)
    			<tr>
                    <td class="dvs-tac">{{ $menu->name }}</td>
    				<td class="dvs-tac">{{ $menu->language->name }}</td>
    				<td class="dvs-tac">
    					<a href="{{ route('dvs-menus-edit', $menu->id) }}" class="dvs-button dvs-button-small">Edit</a>
                        @if (!$page->dvs_admin)
    						{{-- Form::delete(URL::route('dvs-menus-destroy', array($menu->id)), 'Delete', null, array('class'=>'dvs-button dvs-button-small dvs-button-danger')) --}}
    					@endif
                    </td>
    			</tr>
    		@endforeach
    	</tbody>

        <tfoot>
            <tr>
                <td colspan="3">{{ $menus->appends(Input::except(['page']))->links(); }}</td>
            </tr>
        </tfoot>
    </table>

    <script>require(['app/admin/admin'])</script>
@stop