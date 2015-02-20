<table style="font-family:'Lucida Grande', 'Lucida Sans Unicode', Arial, Verdana, sans-serif;font-size:12px;width:580px;border:10px solid #eaeaea" width="600">
	<tr>
		<td style="background-color:#eaeaea;height:3px;padding:8px 10px;"><img src="<?= URL::asset('/packages/devisephp/cms/img/admin-logo.png') ?>" /></td>
	</tr>
	<tr>
		<td style="padding:20px;background-color:#fafafa;width:540px;">
			@yield('content')
		</td>
	</tr>

	<tr>
		<td style="background-color:#ffffff;margin:5px 15px;">
			<p style="font-size:10px;color:#777;">If you need technical assistance or support, please contact us. To unsubscribe from receiving emails, click here to <a href="#REPLACE_HREF">unsubscribe</a>.</p>

			<p style="font-size:10px;color:#777;padding-top:8px;">&copy; <?= date('Y', strtotime('now')) ?> Devise. All Rights Reserved.</p>
		</td>
	</tr>
</table>