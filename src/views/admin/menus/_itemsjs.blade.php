<!-- template for dvs-menu-links -->
<div style="display: none;" id="js-menu-item-template">
	<li id="itemOrder_{cid}" class="js-menu-item">
        <div class="ui-sortable-handle">
            <input name="item[{cid}][page_id]" type="hidden" value="<?=$page->id?>">

            <input type="text" name="item[{cid}][name]" placeholder="Title">

            <select name="item[{cid}][url_or_page]"  class="url-or-page form-control pull-left btn btn-default">
                <option value="page">Page</option>
                <option value="url">URL</option>
            </select>

            <input type="text" name="item[{cid}][url]" placeholder="URL">

            <input type="text" class="autocomplete-pages menu-item-page form-control pull-left" placeholder="Page" value="">
            <input type="hidden" name="item[{cid}][page_id]" value="">
            <button type="button" class="dvs-button dvs-button-danger dvs-button-small js-remove-menu-item dvs-pr"><span class="ion-android-close"></span></button>
        </div>
	</li>
</div>