@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1><span class="ion-ios-copy-outline"></span> API Requests</h1>
    </div>
@stop

@section('subnavigation')
    <div id="dvs-admin-actions">
        <?= link_to(URL::route('dvs-api-create'), 'Create New Page', array('class'=>'dvs-button'))  ?>
    </div>
@stop

@section('main')
    <table class="dvs-admin-table">
		<thead>
			<tr>
				<th class="dvs-tal">
                    <div class="dvs-inline-block dvs-tal">
                        <?= Sort::filter('slug', "#pages, #pagination-links", ['placeholder' => 'Filter by Slug', 'class' => 'filter-by-slug'])  ?>
                    </div>
                </th>
				<th>Type</th>
				<th>
                    <div class="dvs-inline-block dvs-button-group dvs-sort-group dvs-pr">
                        <?= Sort::link('slug','Path', array('class' => 'dvs-button dvs-button-small dvs-button-outset'))  ?>
                        <?= Sort::link('title','Page Name', array('class' => 'dvs-button dvs-button-small dvs-button-outset'))  ?>
                        <?= Sort::clearSortLink('Clear Sort', array('class'=>'dvs-button dvs-button-small dvs-button-outset'))  ?>
                    </div>
                </th>
			</tr>
		</thead>

		<tbody id="pages">
			@foreach($pages as $page)
				<tr>
					<td class="dvs-stacked-col dvs-tal">
                        <div><?= HTML::showPagesWithRequestedContent($page) ?><?= $page->title ?></div>
                        <div class="dvs-inset-text"><?= HTML::filterLinkParts($page->slug)  ?></div>
                    </td>
                    <td class="dvs-tac"><?= $page->http_verb  ?></td>
					<td class="dvs-tac dvs-button-group">
						<?= link_to(URL::route('dvs-api-edit', array($page->id)), 'Settings', array('class'=>'dvs-button dvs-button-small'))  ?>

                        @if(!$page->dvs_admin)
						  <?=Form::delete(URL::route('dvs-api-destroy', array($page->id)), 'Delete', null, array('class'=>'dvs-button dvs-button-small dvs-button-danger')) ?>
						@endif
	                </td>
				</tr>
			@endforeach
		</tbody>

        <tfoot>
            <tr id="pagination-links">
                <td colspan="4"><?= $pages->appends(Input::except(['page']))->render()  ?></td>
            </tr>
        </tfoot>
	</table>

	<script>devise.require(['app/admin/admin', 'app/admin/pages-index', 'app/bindings/data-dvs-replacement', 'app/bindings/data-change-target'])</script>
@stop