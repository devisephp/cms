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

			<h3>Mail Settings</h3>
			<div class="dvs-settings">
				<div class="dvs-form-group dvs-setting-item">
					<label>Mail Driver<br> <span class="dvs-helptext">Options are typically "smtp", "mail", "sendmail", "mailgun", "mandrill", "log"</span></label>
					<input type="text" name="settings[mail.driver]" value="<?= config('mail.driver') ?>">
				</div>
				<div class="dvs-form-group dvs-setting-item">
					<label>Host</label>
					<input type="text" name="settings[mail.host]" value="<?= config('mail.host') ?>">
				</div>
				<div class="dvs-form-group dvs-setting-item">
					<label>Port</label>
					<input type="text" name="settings[mail.port]" value="<?= config('mail.port') ?>">
				</div>
				<div class="dvs-form-group dvs-setting-item">
					<label>Encryption</label>
					<input type="text" name="settings[mail.encryption]" value="<?= config('mail.encryption') ?>">
				</div>
				<div class="dvs-form-group dvs-setting-item">
					<label>Username</label>
					<input type="text" name="settings[mail.username]" value="<?= config('mail.username') ?>">
				</div>
				<div class="dvs-form-group dvs-setting-item">
					<label>SMTP Password</label>
					<input type="password" name="settings[mail.password]" value="<?= config('mail.password') ?>">
				</div>

				<div class="dvs-form-group dvs-setting-item">
					<label>Mandrill Password</label>
					<input type="password" name="settings[services.mandrill][secret]" value="<?= config('services.mandrill')['secret'] ?>">
				</div>

				<div class="dvs-form-group dvs-setting-item">
					<label>Mailgun Domain</label>
					<input type="text" name="settings[services.mailgun][domain]" value="<?= config('services.mailgun')['domain'] ?>">
				</div>
				<div class="dvs-form-group dvs-setting-item">
					<label>Mailgun Secret</label>
					<input type="password" name="settings[services.mailgun][secret]" value="<?= config('services.mailgun')['secret'] ?>">
				</div>

				<div class="dvs-form-group dvs-setting-item">
					<label>Pretend?</label>
					<select name="settings[mail.pretend]">
						<option value="true" <?= (config('mail.pretend') == true) ? 'selected="selected"' : '' ?>>True</option>
						<option value="false" <?= (config('mail.pretend') == false) ? 'selected="selected"' : '' ?>>False</option>
					</select>
				</div>
			</div>

			<h3>Third Party Services</h3>
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

