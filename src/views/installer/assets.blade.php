<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To Devise | Installing Assets</title>

	<style>
	@import url("https://fonts.googleapis.com/css?family=Roboto:100");

	body {
		background-color:#2D3039;
		color:#fff;
		text-align: center;
	}

	h1 {
		font-size:36px;
		margin-top:200px;
		padding:0 20px;
		width:100%;
		font-weight:100;
		font-family:"Roboto", Tahoma, Arial, sans-serif;
	}

	img {
		opacity:0.2;
	}

	</style>

    <script>
    	setTimeout(
    		function() {
		    	window.location.href = '{{ url('install/assets') }}';
		    }, 1000
		);
    </script>
</head>

<body id="dvs-admin">
    <div class="container pt sp45">

        @if(Session::has('message-success') || Session::has('message-errors'))
        	@include('devise::admin.elements.validation')
        @endif

        <div class="row">
            <div class="col-md-6 col-md-offset-3 tal">

                <h1>Squeeeee! Please be patient while we install Devise assets.</h1>
                <img src="http://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.3/images/ajax-loader.gif" width="50" height="50">
            </div>
        </div>
    </div>

</body>
</html>
