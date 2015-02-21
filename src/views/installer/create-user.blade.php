@extends('devise::installer.layout')

@section('content')
	<h3>Create Admin User</h3>

    <div class="dvs-form-group">
        <label>Admin Email</label>
        <input type="text" name="email" placeholder="Admin Email" value="<?= $email ?>">
    </div>

    <div class="dvs-form-group">
        <label>Admin Password</label>
        <input type="text" name="password" placeholder="Admin Password" value="">
    </div>

    <div class="dvs-form-group">
        <button class="back btn" type="button" onclick="location.href='database'">Back</button>
        <button class="next btn">Next</button>
    </div>
@stop


@section('scripts')

@stop