@layout('admin::layouts/admin_email')

@section('content')
	<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#368ee0">
		<tr>
			<td align="center">
				<center>
					<table border="0" width="600" cellpadding="0" cellspacing="0">
						<tr>
							<td style="color:#ffffff !important; font-size:24px; font-family: Arial, Verdana, sans-serif; padding-left:10px;" height="40">{{ Config::get('admin::config.site_title') }} - Reset Password! </td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table>

	<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff">
		<tr>
			<td align="center">
				<center>
					<table border="0" width="600" cellpadding="0" cellspacing="0">
						<tr>
							<td style="color:#333333 !important; font-size:20px; font-family: Arial, Verdana, sans-serif; padding-left:10px;" height="40">
								<h3 style="font-weight:normal; margin: 20px 0;">Hey {{ $message['firstname'] }} {{ $message['lastname'] }}</h3>
								<p style="font-size:12px; line-height:18px;">
									A request to reset password for this email address has bee sent from {{ Config::get('admin::config.site_title') }}. Use the link below to complete the process.<br>
               <a href="{{ $message['reset'] }}">{{ $message['reset'] }}</a>      
                  
								</p>
							</td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#368ee0" style="margin-top:50px !important;">
		<tr>
			<td align="center">
				<center>
					<table border="0" width="600" cellpadding="0" cellspacing="0">
						<tr>
							<td style="color:#ffffff !important; font-size:20px; font-family: Arial, Verdana, sans-serif; padding-left:10px;" height="40">
								<center>
									<p style="font-size:12px; line-height:18px;">
									If you have received this email in error use the link below to inform us.
                 
									<br />
									<a href="#" style="color:#ffffff !important;">Click to report a misuse</a>
								</p>
								</center>
							</td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table>

@endsection