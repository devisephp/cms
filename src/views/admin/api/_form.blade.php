<h3>Settings</h3>
<hr>

<div class="dvs-form-group">
    <?= Form::label('Name Of Request') ?>
    <?= Form::text('title', null) ?>
    <span data-dvs-document="name-of-request" class="dvs-document-button"></span>
</div>

<h3>Routing</h3>
<hr>

<div class="dvs-form-group">
    <?= Form::label('Route Type') ?>
    <?= Form::select('http_verb', array('get' => 'Regular (GET)', 'post' => 'Create (POST)', 'put' => 'Update (PUT)', 'delete' => 'Delete (DELETE)', 'any' => 'Any Method (ANY)'), null, array('id' => 'http-verb')) ?>
    <span data-dvs-document="route-type" class="dvs-document-button"></span>
</div>

@if ($method == 'update')
    <div class="dvs-form-group">
        <?= Form::label('Route Name') ?>
        <?= Form::text('route_name', null, array('disabled' => 'disabled')) ?>
        <span data-dvs-document="route-name" class="dvs-document-button"></span>
    </div>
@endif

<div class="dvs-form-group">
    <?= Form::label('Request Slug') ?>
    <?= Form::text('slug', null, array('placeholder' => 'e.g. /about-us')) ?>
    <span data-dvs-document="request-slug" class="dvs-document-button"></span>
</div>

<div class="dvs-form-group simpletoggle" id="response-path-form">
    <?= Form::label('Response Class') ?>
    <?= Form::text('response_class', null, array('placeholder' => 'Response Class')) ?>
    <span data-dvs-document="response-class" class="dvs-document-button"></span>
</div>

<div class="dvs-form-group simpletoggle" id="response-path-form">
    <?= Form::label('Response Method') ?>
    <?= Form::text('response_method', null, array('placeholder' => 'Response Method')) ?>
    <span data-dvs-document="response-method" class="dvs-document-button"></span>
</div>

<div class="dvs-form-group simpletoggle" id="response-params-form">
    <?= Form::label('Response Parameters') ?>
    <?= Form::text('response_params', null, array('placeholder' => 'Response Params (Comma Separated)')) ?>
    <span data-dvs-document="response-parameters" class="dvs-document-button"></span>
</div>

<h3>Filters</h3>
<hr>

<div class="dvs-form-group">
    <?= Form::label('Before') ?>
    <?= Form::text('before', null, array('placeholder' => 'Before Filters')) ?>
    <span data-dvs-document="before" class="dvs-document-button"></span>
</div>