<li id="itemOrder_<?= $item->id ?>" class="js-menu-item">
    <div>
        @if(count($item->items))
            <button type="button" class="btn btn-success menu-accordion pull-left mr sp5" data-target="#children-<?= $item->id ?>">-</button>
        @endif

        <input type="text" name="item[<?=$item->id?>][name]" value="<?= $item->name ?>" placeholder="Title" style="width: 25%;">

        @php
            if($item->page) {
                 $urlHiddenClass = ' hidden';
                 $pageHiddenClass = '';
                 $urlSelected = '';
                 $pageSelected = ' selected="selected"';
            } else {
                 $urlHiddenClass = '';
                 $pageHiddenClass = ' hidden';
                 $selected = "url";
                 $urlSelected = ' selected="selected"';
                 $pageSelected = '';
            }
        @endphp

        <select name="item[<?=$item->id?>][url_or_page]" class="url-or-page form-control btn btn-default pull-left" style="width: 10%;height:34px;font-weight:normal;">
            <option value="page"<?= $pageSelected ?>>Page</option>
            <option value="url"<?= $urlSelected ?>>URL</option>
        </select>

        <input type="text" name="item[<?= $item->id?>][url]" value="<?= $item->url ?>" placeholder="URL" style="width: 64%;">

        <input type="text" class="autocomplete-pages menu-item-page<?= $pageHiddenClass ?> form-control pull-left" placeholder="Page" style="width: 25%;" value="@if($item->page)<?= $item->page->title ?> (<?= $item->page->language->code  ?>) @endif">
        <input type="hidden" name="item[<?= $item->id  ?>][page_id]" value="<?= (isset($item->page_id)) ? $item->page_id : '' ?>">

        <button type="button" class="dvs-button js-remove-menu-item" style="padding: 0; float: right;">X</button>
    </div>

	@if ($item->items)
		<ol>
			@foreach ($item->items as $nested)
				@include('devise::admin.menus._items', ['item' => $nested])
			@endforeach
		</ol>
	@endif
</li>