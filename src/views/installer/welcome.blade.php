<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page->title ?></title>

    <link href='http://fonts.googleapis.com/css?family=Lato:400,900' rel='stylesheet' type='text/css'>

    <style>
    	body {
    		text-align:center;
    		background-color:#f0f0f0;
    		font-family: 'Lato', Arial, Tahoma, sans-serif;
    		color: #222222;
    	}

    	h1 {
    		font-size:24px;
    		font-weight:bold;
    		text-transform: uppercase;
    	}

    	p {
    		width:400px;
    		margin: 0 auto;
    		line-height:1.5em;
    		border-top:2px solid #999;
    		padding-top:30px;
    		color:#666;
    	}

    	a {
            display:inline-block;
    		color:#f0f0f0;
    		font-weight:bold;
            font-size:11px;
            text-decoration: none;
            text-transform: uppercase;
            padding:8px 15px;
            background-color:#7dbd5d;
    	}
    </style>
</head>

<body>

    <img src="<?= URL::asset('packages/devisephp/cms/img/devise-installer-logo.gif') ?>" width="300" height="300">

    <h1>Thank You</h1>

    <p>
        We want to thank you for taking the time to give Devise a spin. We know that, as a developer, you have the opportunity to try out many packages and solutions for your team and clients. If there is anything we can do to help or if you have any feedback please reach out to us.<br><br>
        <a href="http://devisephp.com" target="_blank">devisephp.com</a>

    </p>


</body>
</html>