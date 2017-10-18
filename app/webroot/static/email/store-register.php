<?php 
$html = '<table width="100%" cellspacing="10" cellpadding="10" style="background:#fff" style="border:2px solid #ccc;" >
<tr>
	<td>
		<table cellpadding="0" cellspacing="0" width="100%" style="border-bottom:2px solid #ccc;">
			<tr>
				<td style="padding-bottom:15px;"><img src="'.IMAGEURL.'logo.jpg" alt="'.SITETITLE.'" height="50" /></td>
			</tr>
		</table>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<th style="color:#12AFE3; text-align:left; font-size:17px; font-weight:bold; font-family:Verdana, Arial, Helvetica, sans-serif; padding:10px 0;">Welcome To Purchasekaro</th>
			</tr>
			<tr>
				<td><p style="font-weight:bold; text-align:left; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0;">Dear '.$store_fullname.',</p></td>
			</tr>
			<tr>
				<td><p style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-bottom:10px; margin:0;">Your store is successfully registered on Purchasekaro!</p></td>
			</tr>
			<tr>
				<td><p style="font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0; text-align:left; font-size:12px;" >Below are your login details. Please keep this email for future use.</p></td>
			</tr>
			<tr>
				<td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-bottom:5px; margin:0;"><b>Username:</b> '.$store_username.'</td>
			</tr>
			<tr>
				<td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px;"><b>Password:</b> '.$store_password.'</td>
			</tr>
			<tr>
				<td height="10"></td>
			</tr>
		</table>
	</td>
</tr>
</table>';
?>