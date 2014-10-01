@extends('devise::layouts.master')

@section('main')
	<a href="{{ URL::route('dvs_template_upload') }}">New Template</a>
	<table>
		<tr>
			<th>Name</th>
			<th>Extends</th>
		</tr>
		@foreach($templates as $template)
			<tr>
				<td>{{ $template }}</td>
				<td>{{ Config::get('devise::templates.' . $template . '.extends') }}</td>
			</tr>
		@endforeach
	</table>
@stop