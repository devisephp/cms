<h3>General Page Settings</h3>
<hr>

<div class="dvs-form-group">
    {{ Form::label('Title of the Page') }}
    {{ Form::text('title', null) }}
    <div class="dvs-helptext">
        <p>This is for administration purposes only.</p>
    </div>
</div>

<div class="dvs-form-group">
	{{ Form::label('Short description of the page') }}
	{{ Form::textarea('short_description', null, array('class' => 'short')) }}
	<div class="dvs-helptext">
		<p>The short description will only be used in the administration section of the application.</p>
	</div>
</div>

<div class="dvs-form-group open simpletoggle" id="view-template-form">
    {{ Form::label('Language') }}
    {{ Form::select('language_id', $languages) }}
    @if(isset($translatedFromPage) && $translatedFromPage)
    {{ Form::hidden('translated_from_page_id', $page->id) }}
    @endif
</div>

<h3>Above It</h3>
<hr>

<div class="dvs-form-group">
    {{ Form::label('Route Type') }}
    {{ Form::select('http_verb', array('get' => 'Regular Page (GET)', 'post' => 'Create (POST)', 'put' => 'Update (PUT)', 'delete' => 'Delete (DELETE)', 'any' => 'Any Method'), null, array('id' => 'http-verb')) }}
    <div class="dvs-helptext">
        <p>Typically, if you are just creating a page for people to view you will select "Regular Page (GET)". However, if you want to create a page that creates a new record, updates a record, or deletes a record select the appropriate method.</p>
    </div>
</div>

<div class="dvs-form-group">
    {{ Form::label('Page Slug') }}
    {{ Form::text('slug', null, array('placeholder' => 'e.g. /about-us')) }}
    <div class="dvs-helptext">
        <p>The permalink defines the URL. This should represent the 'path' from the base URL. If your site is http://example.com and you want this new page to appear at http://example.com/new-page put "/new-page" in this field. You can use subfolders like "/category/cars/new-page".</p>
    </div>
</div>

<div class="dvs-form-group open simpletoggle" id="view-template-form">
    {{ Form::label('View Template to Use') }}
    {{ Form::select('view', ['' => 'Select a Template'] + $viewList + ['custom' => 'Custom'], null, array('placeholder' => 'View Template')) }}
    <div class="dvs-helptext">
        <p>You only need to select a template view file if the page is a regular page (GET).</p>
    </div>
</div>

<div class="dvs-form-group simpletoggle" id="response-path-form">
    {{ Form::label('Response Path') }}
    {{ Form::text('response_path', null, array('placeholder' => 'Response Path')) }}
    <div class="dvs-helptext">
        <p>When creating a new "create", "update", or "delete" you will need to define a response path. This is the namespace, classname, and public method that you want to execute when this route is loaded. Example: "\CarApp\Cars\CarManager.createNewCar". The period denotes the separation between the class and the method in that class you wish to execute.</p>
    </div>
</div>

<div class="dvs-form-group simpletoggle" id="response-params-form">
    {{ Form::label('Response Parameters') }}
    {{ Form::text('response_params', null, array('placeholder' => 'Response Params')) }}
    <div class="dvs-helptext">
        <p>A comma separated list of parameters that need to passed into the response path method. Example: "id, input"</p>
    </div>
</div>

<div class="dvs-form-group">
    {{ Form::label('Published') }}
    <div class="fancyCheckbox">
        {{ Form::checkbox('published', null, null, array('id' => 'published')) }}
        {{ Form::label('published', '&nbsp;') }}
    </div>
</div>

<div class="dvs-form-group">
    {{ Form::label('Show Advanced Options') }}
    <div class="fancyCheckbox">
        {{ Form::checkbox('show_advanced', null, null, array('id' => 'show-advanced')) }}
        {{ Form::label('show-advanced', '&nbsp;') }}
    </div>
</div>

<div class="dvs-advanced">
    <h3>Meta</h3>
    <hr>

    <div class="dvs-form-group">
        {{ Form::label('Meta Title') }}
        {{ Form::text('meta_title', null, array('placeholder' => 'Meta Title')) }}
        <div class="dvs-helptext">
            <p>The title will appear as the title of the page on the tab of the browser. This is important for SEO purposes.</p>
        </div>
    </div>

    <div class="dvs-form-group">
        {{ Form::label('Meta Description') }}
        {{ Form::textarea('meta_description', null, array('class' => 'short', 'placeholder' => 'Meta Description')) }}
    </div>

    <div class="dvs-form-group">
        {{ Form::label('Meta Keywords') }}
        {{ Form::textarea('meta_keywords', null, array('class' => 'short', 'placeholder' => 'Meta Keywords')) }}
    </div>

    <div class="dvs-form-group">
        {{ Form::label('Head Code') }}
        {{ Form::textarea('head', null, array('class' => 'short', 'placeholder' => 'Head Code')) }}
        <div class="dvs-helptext">
            <p>This will insert any additional code that may be required in the &lt;head&gt; section of the page.</p>
        </div>
    </div>

    <div class="dvs-form-group">
        {{ Form::label('Footer Code') }}
        {{ Form::textarea('footer', null, array('class' => 'short', 'placeholder' => 'Footer Code')) }}
        <div class="dvs-helptext">
            <p>This will insert any additional code that may be required right before the &lt;/body&gt; tag. This is useful for additional scripts or tracking code.</p>
        </div>
    </div>

    <div class="dvs-form-group">
        {{ Form::label('Administration Page?') }}
        <div class="fancyCheckbox">
            {{ Form::checkbox('is_admin', null, null, array('id' => 'is_admin')) }}
            {{ Form::label('is_admin', '&nbsp;') }}
        </div>
    </div>
</div>
