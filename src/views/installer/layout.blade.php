<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To Devise</title>

    <link href='http://fonts.googleapis.com/css?family=Lato:400,900' rel='stylesheet' type='text/css'>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>

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

    	.btn {
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
    <div class="dvs-container pt sp45">
        <div class="dvs-form-horizontal">
            <ul class="validation-errors">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <form method="post">
                <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                @yield('content')
            </form>
        </div>
    </div>

    @yield('scripts')
</body>
</html>