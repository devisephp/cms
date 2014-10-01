@extends('devise::layouts.email')

@section('content')
	<table>
		<tr>
			<td>
				<table>
					<tr>
						<td><p style="font-size:24px;margin:10px 0 4px 0;">Welcome to Devise!</p></td>
					</tr>
					<tr>
                        <td style="color:#3e3e3e;font-size:14px">
							<p>Your user account was successfully created using the email address:<br> <span style="font-weight:bold;font-size:16px;">{{ $user->email }}</span></p>

							<p>Please click on the activation link below to activate your account.</p>

							<table style="background-color:#1fa7db;height:75px;padding:20px;cursor:pointer;">
								<tr>
									<td cellpadding="20" style="text-align:center">
										<a href="{{ URL::action('DeviseUserController@activate', array('userId' => $user->id, 'activateCode' => urlencode($user->activate_code))) }}" style="color:#ffffff;text-decoration:none;font-size:20px;padding:25px 30px;">Activate User Account</a>
									</td>
								</tr>
							</table>

							<p style="font-size:12px;padding-top:10px;">If the activation button above isn't working, paste the following link into your browser: <a href="{{ URL::action('DeviseUserController@activate', array('userId' => $user->id, 'activateCode' => urlencode($user->activate_code))) }}" style="color:#15c;text-decoration:none;">{{  URL::action('DeviseUserController@activate', array('userId' => $user->id, 'activateCode' => urlencode($user->activate_code))) }}</a></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
@stop