<table style="margin-left:auto;margin-right:auto;padding:0 40px 12px;font-family:'Helvetica Neue', Helvetica, Arial, Verdana, sans-serif;font-size:14px;font-weight:100;background-color:#e9eaec;text-align:center;" width="600">
	<tr>
		<td style="padding-bottom:16px;">
			<img src="<?= URL::asset('/packages/devisephp/cms/img/email-header-logo-huge.png') ?>" />
		</td>
	</tr>
	<tr>
		<td style="width:100%;padding:0 20px 20px;color:#2d3039;">

			@yield('content')

		</td>
	</tr>
	<tr>
		<td style="font-size:12px;line-height:18px;color:#9498a7;">
			<p style="text-align:left;">Powered by <img src="<?= URL::asset('/packages/devisephp/cms/img/email-legal-logo-sm.png') ?>" width="83" style="margin-bottom:-12px;" /></p>

			<p style="text-align:justify;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat.</p>
		</td>
	</tr>
</table>