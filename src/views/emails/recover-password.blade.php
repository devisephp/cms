@extends('devise::layouts.email')

@section('content')
	<table>
		<tr>
			<td>
				<table>
					<tr>
						<td>
							<p style="margin-bottom:8px;font-size:40px;line-height:44px;">Password Reset</p>
						</td>
					</tr>
					<tr>
						<td>
							<p style="padding-bottom:20px;">A password reset was requested for this email address. Continue on to the password reset form by clicking the button below:</p>
						</td>
					</tr>
					<tr>
						<td style="padding-bottom:36px;">
							<table width="100%">
								<tr>
									<td style="width:50%;text-align:center;">
										<a href="<?= URL::route('dvs-user-reset-password') . '?token=' . $token ?>" style="display:block;width:80%;max-width:220px;margin:auto;padding:25px 20px;font-weight:500;color:#59babe;text-decoration:none;background-color:transparent;border:2px solid #59babe;border-radius:4px;cursor:pointer;">Reset Your Password</a>
									</td>

									<!--
									<td style="width:50%;text-align:center;">
										<a href="#REPLACE_HREF" style="display:block;width:80%;max-width:220px;margin:auto;padding:25px 20px;font-weight:500;color:#a1a1a1;text-decoration:none;background-color:transparent;border:2px solid #a1a1a1;border-radius:4px;cursor:pointer;">Secondary Button</a>
									</td>
									-->
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
@stop