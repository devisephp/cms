@extends('devise::layouts.email')

@section('content')
	<table>
		<tr>
			<td>
				<table>
					<tr>
						<td>
							<p style="margin-bottom:8px;font-size:40px;line-height:44px;">Welcome to Devise!</p>
						</td>
					</tr>
					<tr>
						<td>
							<p style="padding-bottom:20px;">A user account was successfully created for the email address:<br><strong><?= $user->email ?></strong>. To complete the activation process, please click on the button below:</p>
						</td>
					</tr>
					<tr>
						<td style="padding-bottom:36px;">
							<table width="100%">
								<tr>
									<td style="width:50%;text-align:center;">
										<a href="<?= URL::route('dvs-user-activate', [$user->id, urlencode($user->activate_code)]) ?>" style="display:block;width:80%;max-width:220px;margin:auto;padding:25px 20px;font-weight:500;color:#59babe;text-decoration:none;background-color:transparent;border:2px solid #59babe;border-radius:4px;cursor:pointer;">Activate User Account</a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
@stop