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
                <form method="POST" action="<?= URL::route('dvs-user-attempt-login') ?>">
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">

                    @if(URL::previous() && Request::url() != URL::previous() && strpos(URL::previous(), 'admin'))
                        <input type="hidden" name="intended" value="<?= URL::previous() ?>">
                    @endif

                    <div class="form-group">
                        <input name="uname_or_email" type="text" class="form-control" placeholder="Username or Email" value="<?= old('uname_or_email') ?>" />
                    </div>

                    <div class="form-group">
                        <input name="password" type="password" class="form-control" placeholder="Password" />
                    </div>

                    <div class="form-group mt sp30">
                        <input type="submit" class="dvs-button dvs-button-primary" value="Log In to AdministrationB">
                    </div>

                    <div class="form-group">
                        <a class="dvs-small dvs-no-decoration dvs-fg dvs-mid-gray" href="<?= URL::route('dvs-user-recover-password') ?>">Forgot Your Password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop