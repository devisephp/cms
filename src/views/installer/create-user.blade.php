@extends('devise::layouts.installer')

@section('content')

    <h1>Create Admin User</h1>

    <form method="post">
        <input type="hidden" name="_token" value="<?= csrf_token() ?>">

        <div class="form-group">
            <label>Admin Email</label>
            <input type="text" class="form-control" name="email" placeholder="Admin Email" value="<?= $email ?>">
        </div>

        <div class="form-group">
            <label>Admin Username</label>
            <input type="text" class="form-control" name="username" placeholder="Admin Username" value="<?= $username ?>">
        </div>

        <div class="form-group">
            <label>Admin Password</label>
            <input type="text" class="form-control" name="password" placeholder="Admin Password" value="">
        </div>

        <div class="form-group dvs-form-actions mt sp30">
            <button class="back dvs-button dvs-button-secondary" type="button" onclick="location.href='database'">Back</button>
            <button class="next dvs-button dvs-button-success">Next</button>
        </div>
    </form>
@stop

@section('scripts')

@stop