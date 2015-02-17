@extends('devise::layouts.email')

@section('content')
	<table>
		<tr>
			<td>
				<table>
					<tr>
						<td><p style="font-size:24px;margin:10px 0 4px 0;">Your Password was Changed</p></td>
					</tr>
					<tr>
						<td style="color:#3e3e3e;font-size:14px">
							<p>This message has been sent to notify you that your password has been changed to:</p>
                            <p style="font-size:18px;"><strong><?= $new_password ?></strong></p>
							<p>If you were not responsible for the password change, please contact support.</p>

							<table style="background-color:#1FA7DB;height:75px;padding:20px;cursor:pointer;">
								<tr>
									<td cellpadding="20" style="text-align:center">
										<a href="<?= URL::action('DeviseUserController@login') ?>" style="color:#ffffff;text-decoration:none;font-size:24px;padding:25px 40px;">Go To Login</a>
									</td>
								</tr>
							</table>

							<p style="font-size:12px;padding-top:10px;">If the button above isn't working, paste the following link into your browser: <a href="<?= URL::action('DeviseUserController@login') ?>" style="color:#15c;text-decoration:none;"><?= URL::action('DeviseUserController@login') ?></a></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
@stop