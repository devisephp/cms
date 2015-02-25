@extends('devise::layouts.installer')

@section('content')

    <img src="<?= url('packages/devisephp/cms/img/devise-installer-logo.gif') ?>" width="300" height="300">

    <div class="main-content">

	    <h1>Create Admin User</h1>

        <div class="dvs-form-group">
            <label>Admin Email</label>
            <input type="text" name="email" placeholder="Admin Email" value="<?= $email ?>">
        </div>

        <div class="dvs-form-group">
            <label>Admin Password</label>
            <input type="text" name="password" placeholder="Admin Password" value="">
        </div>

        <div class="dvs-form-group dvs-form-actions">
            <button class="back dvs-button dvs-button-secondary" type="button" onclick="location.href='database'">Back</button>
            <button class="next dvs-button dvs-button-success">Next</button>
        </div>
    </div>
@stop


@section('scripts')

@stop