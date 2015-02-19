@extends('devise::layouts.email')

@section('content')
	<table>
		<tr>
			<td>
				<table>
					<tr>
						<td><p style="font-size:24px;margin:10px 0 4px 0;">DevisePHP Password Reset</p></td>
					</tr>
					<tr>
						<td style="color:#3e3e3e;font-size:14px">
							<p>A password reset was requested for this email. Click the button to proceed with the password recovery process.</p>

							<table style="background-color:#1FA7DB;height:75px;padding:20px;cursor:pointer;">
								<tr>
									<td cellpadding="20" style="text-align:center">
										<a href="<?= URL::route('user-reset-password') . '?token=' . $token ?>" style="color:#ffffff;text-decoration:none;font-size:24px;padding:25px 40px;">Go To Change Password</a>
									</td>
								</tr>
							</table>

							<p style="font-size:12px;padding-top:10px;">If the button above isn't working, paste the following link into your browser: <a href="<?= URL::route('user-reset-password') . '?token=' . $token ?>" style="color:#15c;text-decoration:none;"><?= URL::route('user-reset-password') . '?token=' . $token ?></a></p>

                            <p>If you did not request a password reset, please contact support.</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
@stop