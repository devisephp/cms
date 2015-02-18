@if (!Input::get('search'))
	<div id="dvs-media-mngr-categories">
	    <h4>
	        Categories
	        <span class="crumbs">
	            @foreach ($pageData['crumbs'] as $crumb)
	                &nbsp;/&nbsp;<a href="<?= $crumb['url'] ?>"><?= $crumb['name'] ?></a>
	            @endforeach
	        </span>
	    </h4>
	    @if(count($pageData['categories']))
	        <ul>
	            @foreach ($pageData['categories'] as $category)
	                <li>
	                	<a class="dvs-button-small dvs-button dvs-button-gray dvs-cat-btn" href="<?= $category['url'] ?>"><?= $category['name'] ?></a>
	                	<a data-path="<?= $category['path'] ?>" data-name="<?= $category['name'] ?>" class="dvs-button-small dvs-button dvs-button-dark dvs-cat-rename-btn" data-url="<?= $category['rename-url'] ?>" href="#">-</a>
	                	<a class="dvs-button-small dvs-button dvs-cat-delete-btn  dvs-button-dark" href="<?= $category['delete-url'] ?>">X</a>
	                </li>
	            @endforeach
	        </ul>
	    @else
	        <h5 class="empty">No Categories Found</h5>
	    @endif
	</div>
@endif