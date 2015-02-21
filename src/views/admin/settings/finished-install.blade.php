@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1>Congratulations, you've installed Devise!</h1>
    </div>
@stop

@section('main')
	<h3>Next let's configure the mail server</h3>

    <div class="dvs-admin-form-horizontal">

		<form action="<?= route('dvs-settings-update') ?>" method="post">
			<input type="hidden" name="_method" value="PUT">
			<input type="hidden" name="_token" value="<?= csrf_token() ?>">

			<div class="dvs-settings">

				<div class="dvs-form-group dvs-setting-item">
					<label>Mail Host</label>
					<input type="text" name="settings[mail.host]" value="<?= config('mail.host') ?>">
				</div>

			</div>

			<button type="submit" class="dvs-button dvs-button-large">Next</button>
		</form>

    </div>
@stop

