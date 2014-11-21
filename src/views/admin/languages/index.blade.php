@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1>List of Languages</h1>
    </div>
@stop

@section('main')
	<table class="dvs-admin-table">
		<thead>
			<tr>
				<th class="dvs-tal">{{ Sort::link('code','Short Code') }}</th>
				<th class="dvs-tal">
					{{ Sort::link('human_name','Language') }}
					{{ Sort::filter('human_name', "#languages, .dvs-admin-container", ['placeholder' => 'Filter by Name']) }}
				</th>
	            <th>Active</th>
			</tr>
		</thead>

		<tbody id="languages">
			@foreach($languages as $language)
				<tr>
					<td>{{ $language->code }}</td>
					<td>{{ $language->human_name }}</td>
					<td>
						<input class="js-active" data-url="{{ route('dvs-languages-patch', $language->id) }}" type="checkbox" name="is_active[]" value="{{ $language->id }}" type="checkbox" {{ $language->active ? 'checked' : ''}}>
	                </td>
				</tr>
			@endforeach
		</tbody>

        <tfoot>
            <tr>
                <td>{{ $languages->appends(Input::except(['page']))->links(); }}</td>
            </tr>
        </tfoot>
	</table>

	<script>require(['app/admin/languages'])</script>
@stop