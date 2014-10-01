@extends('devise::admin.layouts.master')

@section('subnavigation')
	<ul>
		<li>{{ link_to(URL::route('dvs-pages-create'), 'Create New Page', array('class'=>'dvs-button')) }}</li>
	</ul>
@stop

@section('title')

<h1>List of Pages</h1>
<p><label>Active Languages: {{ Form::select('language_id', $languages, (!Input::has('language_id')) ? 45 : Input::get('language_id'), array('id' => 'lang-select')) }}</label></p>
@stop

@section('main')
	<table class="dvs-admin-table">
		<thead>
			<tr>
				<th class="tal">
					{{ Sort::link('title','Page Name') }}
				</th>
				<th class="tal">
					{{ Sort::link('slug','Path') }} {{ Sort::filter('slug', "#pages, .dvs-admin-container", ['placeholder' => 'Filter by Slug', 'class' => 'filter-by-slug']) }}
				</th>
	            <th class="tal">
	                Route Name
	            </th>
				<th class="tal">
					{{ Sort::link('http_verb','Type') }}
				</th>
				<th>
					Languages
				</th>
				<th>
					{{ Sort::link('is_admin','Admin') }}
				</th>
				<th class="actions">
					{{ Sort::clearSortLink('Clear Sort', array('class'=>'dvs-button dvs-button-small dvs-button-secondary')) }}
				</th>
			</tr>
		</thead>

		<tbody id="pages">
			@foreach($pages as $page)
				<tr>
					<td>{{ $page->title }}</td>
					<td>{{ HTML::filterLinkParts($page->slug) }}</td>
					<td>{{ $page->route_name }}</td>
					<td>{{ HTML::httpVerb($page->http_verb, false) }}</td>
					<td>{{ HTML::showLanguagesForPages($page->availableLanguages) }}
					<td class="tac">{{ ($page->is_admin) ? 'Yes' : 'No' }}</td>
					<td class="tac actions dvs-button-group">
						{{ link_to($page->slug, 'View', array('class'=>'dvs-button dvs-button-small dvs-button-secondary')) }}
						{{ link_to(URL::route('dvs-pages-edit', array($page->id)), 'Edit', array('class'=>'dvs-button dvs-button-small')) }}
						{{ link_to(URL::route('dvs-pages-copy', array($page->id)), 'Copy', array('class'=>'dvs-button dvs-button-small')) }}
	                    @if(!$page->dvs_admin)
						{{Form::delete(URL::route('dvs-pages-destroy', array($page->id)), 'Delete', null, array('class'=>'dvs-button dvs-button-small dvs-button-danger'))}}
						@endif
	                </td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<div class="dvs-admin-container">
        {{ $pages->appends(Input::except(['page']))->links(); }}
	</div>

	<script>require(['app/admin/admin', 'app/bindings/data-dvs-replacement', 'app/bindings/data-change-target'])</script>
@stop