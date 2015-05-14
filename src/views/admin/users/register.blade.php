@extends('devise::layouts.public')

@section('content')
    <div class="container pt sp45">
        <div class="tac mb sp75">
            <img src="<?= URL::asset('/packages/devisephp/cms/img/admin-logo.png') ?>">
        </div>

        @if(Session::has('message-success') || Session::has('message-errors'))
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-sm-offset-4 col-md-offset-4">
                @include('devise::admin.elements.validation')
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-md-4 col-md-offset-4 tac">
                <form method="POST" action="<?= URL::route('user-attempt-register') ?>">
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">

                    <div class="form-group">
                        <input name="name" type="text" class="form-control" placeholder="Name" value="<?= old('name') ?>">
                    </div>

                    <div class="form-group">
                        <input name="username" type="text" class="form-control" placeholder="Username" value="<?= old('username') ?>">
                    </div>

                    <div class="form-group">
                        <input name="email" type="text" class="form-control" placeholder="Email" value="<?= old('email') ?>" />
                    </div>

                    <div class="form-group">
                        <input name="password" type="password" class="form-control" placeholder="Password" />
                    </div>

                    <div class="form-group">
                        <input name="password_confirmation" type="password" class="form-control" placeholder="Confirm Password" />
                    </div>

                    <div class="form-group mt sp30">
                        <button class="dvs-button dvs-button-primary">Register New User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop