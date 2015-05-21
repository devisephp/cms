@extends('devise::layouts.installer')

@section('content')
    <h1 class="mb sp30">Thank You &amp;<br> Welcome to Devise</h1>

    <p>
        We want to thank you for taking the time to give Devise a spin. We know that, as a developer, you have the opportunity to try out many packages and solutions for your team and clients. If there is anything we can do to help or if you have any feedback please reach out to us at <a href="http://devisephp.com" target="_blank">Devisephp.com</a>.<br><br>
        <img src="<?= URL::asset('/packages/devisephp/cms/img/install-signature.png') ?>">
    </p>
    <p class="mt sp40">
    	<a tabindex="0" class="get-started dvs-button" href="environment">Get Started With Install</a>
    </p>
@stop