@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1>Settings</h1>
    </div>
@stop

@section('main')
    <div class="dvs-admin-form-horizontal">

		<form action="<?= route('dvs-settings-update') ?>" method="post">
			<input type="hidden" name="_method" value="PUT">
			<input type="hidden" name="_token" value="<?= csrf_token() ?>">

			<div class="dvs-settings">

				<div class="dvs-form-group dvs-setting-item">
					<label>Zencoder API Key</label>
					<input type="text" name="settings[devise.zencoder.api-key]" value="<?= config('devise.zencoder.api-key') ?>">
				</div>

				<div class="dvs-form-group dvs-setting-item">
					<label>Google Maps API Key</label>
					<input type="text" name="settings[google.maps.api-key]" value="<?= config('google.maps.api-key') ?>">
				</div>

			</div>

			<input type="submit" class="dvs-button dvs-button-success dvs-button-solid" value="Update Settings">
		</form>

    </div>
@stop

