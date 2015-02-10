<?= Form::open(array('route' => array('dvs-fields-update', $element->id), 'method' => 'put', 'data-dvs-field-id' => $element->id, 'data-dvs-field-type' => $element->dvs_type, 'id' => 'dvs-sidebar-field-form')) ?>

    @include('devise::admin.sidebar._collection_instance_id')

    <div class="dvs-editor-values">
        <div class="dvs-google-map" style="width:100%;height:300px;"></div>

        <div class="dvs-property">
            <?= Form::label('Full Address') ?>
            <?= Form::text('address', $element->value->address) ?>
        </div>

        <div class="dvs-property">
            <?= Form::label('latitude') ?>
            <?= Form::text('latitude', $element->value->latitude) ?>
        </div>

        <div class="dvs-property">
            <?= Form::label('longitude') ?>
            <?= Form::text('longitude', $element->value->longitude) ?>
        </div>
    </div>
    <div class="dvs-editor-settings">

        <div class="dvs-property">
        <?= Form::label('Mode') ?>
        <?= Form::select('mode', [ 'roadmap' => 'Road Map', 'satellite' => 'Satellite', 'hybrid' => 'Hybrid', 'terrain' => 'Terrain' ], $element->value->mode, array('class' => 'dvs-select')) ?>
        </div>

        <div class="dvs-property">
        <?= Form::label('Starting Zoom') ?>
        <?= Form::selectRange('startingZoom', 1, 19, $element->value->startingZoom, array('class' => 'dvs-select')) ?>
        </div>

        <div class="dvs-property">
        <?= Form::label('Min Zoom') ?>
        <?= Form::selectRange('minZoom', 1, 19, $element->value->minZoom, array('class' => 'dvs-select')) ?>
        </div>

        <div class="dvs-property">
        <?= Form::label('Max Zoom') ?>
        <?= Form::selectRange('maxZoom', 1, 19, $element->value->maxZoom(19), array('class' => 'dvs-select')) ?>
        </div>

        @include('devise::admin.sidebar._field_scope')
    </div>
<?= Form::close() ?>

<script src="http://maps.google.com/maps/api/js?sensor=false&callback=initializeGoogleMaps"></script>

<script type="text/javascript">
    function initializeGoogleMaps()
    {
        devise.require(['app/sidebar/map'], function(obj)
        {
            obj.init();
        });
    }
</script>