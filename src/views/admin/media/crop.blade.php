@extends('devise::admin.layouts.media-manager')

@section('main')
    <div id="dvs-media-manager">
        <div class="container">
            <div class="crop-container">
              <img src="<?= array_get($input, 'image') ?>" class="js-crop-container" style="width:500px;">
            </div>
        </div>

        <div id="dvs-media-cropper-settings">
            <?= Form::open(array('url' => URL::full())) ?>

                <?= Form::hidden('cropper[x]') ?>
                <?= Form::hidden('cropper[y]') ?>
                <?= Form::hidden('cropper[x2]') ?>
                <?= Form::hidden('cropper[y2]') ?>
                <?= Form::hidden('cropper[w]') ?>
                <?= Form::hidden('cropper[h]') ?>

                <?= Form::label('Width') ?>
                <input type="number" name="cropper[width]" value="<?= array_get($input, 'width', 500) ?>">

                <?= Form::label('Height') ?>
                <input type="number" name="cropper[height]" value="<?= array_get($input, 'height', 270) ?>">

                <?= Form::submit('Crop', array('class' => 'dvs-button dvs-button-small'))?>
            <?= Form::close() ?>
        </div>

        <div class="js-image-preview"></div>
    </div>
	<script>
        devise.require(['app/admin/media-manager-crop', 'app/admin/admin']);
    </script>
@stop