@if (!Input::get('search'))
	<div id="dvs-media-mngr-categories">
	    <button class="dvs-button dvs-button-secondary" id="dvs-open-new-category">Add New Category</button>

        <div id="dvs-new-category" class="dvs-hidden">
            <?= Form::open(array('route' => 'dvs-media-category-store', 'files' => true)) ?>
            <?= Form::hidden('category', (isset($input['category'])) ? $input['category'] : '') ?>
            <?= Form::text('name', null, ['placeholder' => 'New Category Name']) ?>
            <?= Form::submit('Add This Category', array('class' => 'dvs-button dvs-button-small dvs-button-success dvs-button-solid')) ?>
            <?= Form::close() ?>
        </div>

        <hr>

	    @if(count($pageData['categories']))
	        <ul>
	            @foreach ($pageData['categories'] as $category)
	                <li>
	                	<a href="<?= $category['url'] ?>"><?= $category['name'] ?></a>

	                	<div class="dvs-category-actions">
		                	<a data-path="<?= $category['path'] ?>" data-name="<?= $category['name'] ?>" class="dvs-button-tiny dvs-button dvs-cat-rename-btn" data-url="<?= $category['rename-url'] ?>" href="#"><span class="ion-ios-minus-empty"></span></a>
		                	<a class="dvs-button-tiny dvs-button dvs-cat-delete-btn dvs-button-danger" href="<?= $category['delete-url'] ?>"><span class="ion-android-close"></span></a>
		                </div>
	                </li>
	            @endforeach
	        </ul>
	    @else
	        <h6 class="empty">No Categories Found</h6>
	    @endif
	</div>
@endif