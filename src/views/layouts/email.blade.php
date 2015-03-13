<table style="margin-left:auto;margin-right:auto;padding-bottom:12px;font-family:'Helvetica Neue', Helvetica, Arial, Verdana, sans-serif;font-weight:100;background-color:#e9eaec;text-align:center;" width="600">
	<tr>
		<td style="padding-bottom:16px;">
			<img src="<?= URL::asset('/packages/devisephp/cms/img/email-cropped-header-logo.png') ?>" style="margin:-2px;" />
		</td>
	</tr>
	<tr>
		<td style="width:100%;padding:0 40px 20px;color:#2d3039;font-size:16px;line-height:26px;">

			@yield('content')

		</td>
	</tr>
	<tr>
		<td style="padding:0 40px;font-size:12px;line-height:18px;color:#9498a7;">
			<p style="text-align:left;">Powered by <a href="http://devisephp.com/"><img src="<?= URL::asset('/packages/devisephp/cms/img/email-legal-logo.png') ?>" width="83" style="margin-bottom:-12px;" /></p></a>

			<p style="text-align:justify;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea</p>
		</td>
	</tr>
</table>