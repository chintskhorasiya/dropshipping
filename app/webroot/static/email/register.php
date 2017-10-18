<?php 
$html = '<table width="100%" cellspacing="10" cellpadding="10" style="background:#fff" style="border:2px solid #ccc;" >
<tr>
	<td>
		<table cellpadding="0" cellspacing="0" width="100%" border="0">
				<tr>
					<td style="padding-bottom:15px;"><img src="'.IMAGEURL.'logo.png" alt="'.SITETITLE.'" height="50" /></td>
				</tr>
			</table>
		
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<th style="color:#12AFE3; text-align:left; font-size:17px; font-weight:bold; font-family:Verdana, Arial, Helvetica, sans-serif; padding:10px 0;">Welcome To Purchasekaro</th>
			</tr>
			<tr>
				<td><p style="font-weight:bold; text-align:left; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0;">Dear '.$user_data['user_name'].',</p></td>
			</tr>
			<tr>
				<td><p style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-bottom:10px; margin:0;">Thank for signing up with Purchasekaro!</p></td>
			</tr>
			<tr>
				<td><p style="font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0; text-align:left; font-size:12px;"><a href="'.SITEURL.'front/login.php">click here to login</a></p></td>
			</tr>
			<tr>
				<td><p style="font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0; text-align:left; font-size:12px;" >Below are your credentials. Please keep this email for future use.</p></td>
			</tr>
			<tr>
				<td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-bottom:5px; margin:0;"><b>Email:</b> '.$user_data['user_email'].'</td>
			</tr>
			<tr>
				<td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px;"><b>Password:</b> '.base64_decode($user_data['user_pwd']).'</td>
			</tr>
			<tr>
				<td height="10"></td>
			</tr>
		</table>
		
	</td>
</tr>
</table>';
?>