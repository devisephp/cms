@extends('devise::admin.layouts.master')

@section('title')

<h1>List of Languages</h1>
<h3><span>About This</span></h3>
<p>Bacon ipsum dolor sit amet pork loin chicken doner leberkas, tail jerky brisket kevin jowl meatloaf prosciutto beef ham hock meatball fatback. Turkey kevin tenderloin, pork shank boudin andouille landjaeger cow meatloaf hamburger shankle strip steak pork belly tongue. </p>

@stop

@section('main')
	<table class="dvs-admin-table">
		<thead>
			<tr>
				<th class="tal">
					Short Code
				</th>
				<th class="tal">
					Language
					{{ Sort::filter('human_name', "#languages, .dvs-admin-container", ['placeholder' => 'Filter by Name']) }}
				</th>
	            <th class="actions">
	            	Active
	            </th>
			</tr>
		</thead>

		<tbody id="languages" class="">
			@foreach($languages as $language)
				<tr>
					<td>{{ $language->code }}</td>
					<td>{{ $language->human_name }}</td>
					<td class="actions">
						<input class="js-active" data-url="{{ route('dvs-languages-patch', $language->id) }}" type="checkbox" name="is_active[]" value="{{ $language->id }}" type="checkbox" {{ $language->active ? 'checked' : ''}}>
	                </td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<div class="dvs-admin-container">
        {{ $languages->links(); }}
	</div>

	<script>require(['app/admin/languages'])</script>
@stop