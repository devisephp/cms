<h3>General Page Settings</h3>
<hr>

<div class="dvs-form-group">
    <?= Form::label('Title of the Page') ?>
    <?= Form::text('title', null) ?>
</div>

<div class="dvs-form-group">
	<?= Form::label('Short description of the page') ?>
	<?= Form::textarea('short_description', null, array('class' => 'short')) ?>
</div>

@if ($method != 'update')
    <div class="dvs-form-group open simpletoggle" id="view-template-form">
        <?= Form::label('Language') ?>
        <?= Form::select('language_id', ($method != 'translate') ? $languages : $availableLanguages) ?>

        @if($method == 'translate')
            <?= Form::hidden('translated_from_page_id', $page->id) ?>
        @endif

    </div>
@endif

<div class="dvs-form-group open simpletoggle" id="view-template-form">
    <?= Form::label('View Template to Use') ?>
    <?= Form::select('view', ['' => 'Select a Template'] + $templateList + ['custom' => 'Custom'], null, array('placeholder' => 'View Template')) ?>
</div>

<h3>Routing</h3>
<hr>

<div class="dvs-form-group">
    <?= Form::label('Route Type') ?>
    <?= Form::select('http_verb', array('get' => 'Regular Page (GET)', 'post' => 'Create (POST)', 'put' => 'Update (PUT)', 'delete' => 'Delete (DELETE)', 'any' => 'Any Method'), null, array('id' => 'http-verb')) ?>
</div>

@if ($method == 'update')
    <div class="dvs-form-group">
        <?= Form::label('Route Name') ?>
        <?= Form::text('route_name', null, array('disabled' => 'disabled')) ?>
    </div>
@endif

<div class="dvs-form-group">
    <?= Form::label('Page Slug') ?>
    <?= Form::text('slug', null, array('placeholder' => 'e.g. /about-us')) ?>
</div>

<div class="dvs-form-group simpletoggle" id="response-path-form">
    <?= Form::label('Response Path') ?>
    <?= Form::text('response_path', null, array('placeholder' => 'Response Path')) ?>
</div>

<div class="dvs-form-group simpletoggle" id="response-params-form">
    <?= Form::label('Response Parameters') ?>
    <?= Form::text('response_params', null, array('placeholder' => 'Response Params')) ?>
</div>

@if ($method == 'store')
    <div class="dvs-form-group">
        <?= Form::label('Publish on save') ?>
        <div class="fancyCheckbox">
            <?= Form::checkbox('published', true, true, array('id' => 'published')) ?>
            <?= Form::label('published', '&nbsp;') ?>
        </div>
    </div>
@endif

<div class="dvs-form-group">
    <?= Form::label('Show Advanced Options') ?>
    <div class="fancyCheckbox">
        <?= Form::checkbox('show_advanced', null, null, array('id' => 'show-advanced')) ?>
        <?= Form::label('show-advanced', '&nbsp;') ?>
    </div>
</div>

<div class="dvs-advanced">
    <h3>Meta</h3>
    <hr>

    <div class="dvs-form-group">
        <?= Form::label('Meta Title') ?>
        <?= Form::text('meta_title', null, array('placeholder' => 'Meta Title')) ?>
    </div>

    <div class="dvs-form-group">
        <?= Form::label('Meta Description') ?>
        <?= Form::textarea('meta_description', null, array('class' => 'short', 'placeholder' => 'Meta Description')) ?>
    </div>

    <div class="dvs-form-group">
        <?= Form::label('Meta Keywords') ?>
        <?= Form::textarea('meta_keywords', null, array('class' => 'short', 'placeholder' => 'Meta Keywords')) ?>
    </div>

    <div class="dvs-form-group">
        <?= Form::label('Head Code') ?>
        <?= Form::textarea('head', null, array('class' => 'short', 'placeholder' => 'Head Code')) ?>
    </div>

    <div class="dvs-form-group">
        <?= Form::label('Footer Code') ?>
        <?= Form::textarea('footer', null, array('class' => 'short', 'placeholder' => 'Footer Code')) ?>
    </div>

    <div class="dvs-form-group">
        <?= Form::label('Administration Page?') ?>
        <div class="fancyCheckbox">
            <?= Form::checkbox('is_admin', null, null, array('id' => 'is_admin')) ?>
            <?= Form::label('is_admin', '&nbsp;') ?>
        </div>
    </div>
    <h3>Filters</h3>
    <hr>

    <div class="dvs-form-group">
        <?= Form::label('Before') ?>
        <?= Form::text('before', null, array('placeholder' => 'Before Filters')) ?>
    </div>
    <div class="dvs-form-group">
        <?= Form::label('After') ?>
        <?= Form::text('after', null, array('placeholder' => 'After Filters')) ?>
    </div>
</div>