@extends('devise::layouts.public')

@section('content')

	<div class="container pt sp75">

        <div class="tac mb sp50">
            <img data-devise="postInstallLogo, image, It's Your App Now" src="<?= $page->postInstallLogo->image('/packages/devisephp/cms/img/admin-logo.png') ?>">
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3 tac">

            	<h1 class="mb sp30" data-devise="postInstallQuote, text, Make it Yours">
            		{!! $page->postInstallQuote->text('"Toto, I have a feeling we\'re not in Kansas anymore." <br><small>― L. Frank Baum</small>') !!}
            	</h1>

            </div>
        </div>
    </div>

    @yield('scripts')
    <script>devise.require(['app/admin/admin'])</script>

@stop