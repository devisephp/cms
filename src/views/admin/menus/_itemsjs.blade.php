<!-- template for dvs-menu-links -->
<div style="display: none;" id="js-menu-item-template">
	<li id="itemOrder_{cid}" class="js-menu-item">
        <div>
            <input type="text" name="item[{cid}][name]" placeholder="Title" style="width: 25%; height: 25px;">

            <select name="item[{cid}][url_or_page]"  class="url-or-page form-control pull-left btn btn-default" style="width: 10%;height:34px;font-weight:normal;">
                <option value="page">Page</option>
                <option value="url">URL</option>
            </select>

            <input type="text" name="item[{cid}][url]" placeholder="URL" style="width: 64%; height: 25px;">
            <input type="text" class="autocomplete-pages menu-item-page form-control pull-left" placeholder="Page" style="width: 25%;" value="">
            <input type="hidden" name="item[{cid}][page_id]" value="">
            <button type="button" class="dvs-button js-remove-menu-item" style="padding: 0; float: right;">X</button>
        </div>
	</li>
</div>