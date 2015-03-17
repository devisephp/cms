<h3>Settings</h3>
<hr>

<div class="dvs-form-group">
    <?= Form::label('Name Of Request') ?>
    <?= Form::text('title', null) ?>
</div>

<h3>Routing</h3>
<hr>

<div class="dvs-form-group">
    <?= Form::label('Route Type') ?>
    <?= Form::select('http_verb', array('get' => 'Regular (GET)', 'post' => 'Create (POST)', 'put' => 'Update (PUT)', 'delete' => 'Delete (DELETE)', 'any' => 'Any Method (ANY)'), null, array('id' => 'http-verb')) ?>
</div>

@if ($method == 'update')
    <div class="dvs-form-group">
        <?= Form::label('Route Name') ?>
        <?= Form::text('route_name', null, array('disabled' => 'disabled')) ?>
    </div>
@endif

<div class="dvs-form-group">
    <?= Form::label('Request Slug') ?>
    <?= Form::text('slug', null, array('placeholder' => 'e.g. /about-us')) ?>
</div>

<div class="dvs-form-group simpletoggle" id="response-path-form">
    <?= Form::label('Response Class') ?>
    <?= Form::text('response_class', null, array('placeholder' => 'Response Class')) ?>
</div>

<div class="dvs-form-group simpletoggle" id="response-path-form">
    <?= Form::label('Response Method') ?>
    <?= Form::text('response_method', null, array('placeholder' => 'Response Method')) ?>
</div>

<div class="dvs-form-group simpletoggle" id="response-params-form">
    <?= Form::label('Response Parameters') ?>
    <?= Form::text('response_params', null, array('placeholder' => 'Response Params (Comma Separated)')) ?>
</div>

<h3>Filters</h3>
<hr>

<div class="dvs-form-group">
    <?= Form::label('Before') ?>
    <?= Form::text('before', null, array('placeholder' => 'Before Filters')) ?>
</div>