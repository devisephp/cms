@extends('devise::layouts.installer')

@section('content')

    <div class="spinner" style="display: none;">
        <h3 class="mb sp30">Please wait while devise installs...</h3>
        <img src="http://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.3/images/ajax-loader.gif" width="50" height="50">
    </div>

    <div class="form-container">
        <h1 class="mb sp30">Create Admin User</h1>

        <form method="post">
            <input type="hidden" name="_token" value="<?= csrf_token() ?>">

            <div class="form-group tal">
                <label>Admin Email</label>
                <input type="text" class="form-control" name="email" placeholder="Admin Email" value="<?= $email ?>">
            </div>

            <div class="form-group tal">
                <label>Admin Username</label>
                <input type="text" class="form-control" name="username" placeholder="Admin Username" value="<?= $username ?>">
            </div>

            <div class="form-group tal">
                <label>Admin Password</label>
                <input type="text" class="form-control" name="password" placeholder="Admin Password" value="">
            </div>

            <div class="form-group dvs-form-actions mt sp30">
                <button class="back dvs-button dvs-button-secondary" type="button" onclick="location.href='database'">Back</button>
                <button class="next dvs-button dvs-button-success">Next</button>
            </div>
        </form>
    </div>
@stop

@section('scripts')
<script>
    devise.require(['jquery'], function($)
    {
        $('.next').click(function()
        {
            $('.form-container').fadeOut();
            $('.spinner').fadeIn();
        });
    });
</script>
@stop