<?php 
$html = '<table width="100%" cellspacing="10" cellpadding="10" style="background:#f5f5f5" style="border:2px solid #ccc;" >
<tr>
	<td>
		<table cellpadding="0" cellspacing="0" width="100%" style="border-bottom:2px solid #ccc;">
			<tr>
				<td style="padding-bottom:15px;"><img src="'.IMAGEURL.'logo.jpg" alt="'.SITETITLE.'" height="50" /></td>
			</tr>
		</table>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td><p style="font-weight:bold; text-align:left; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0;">Dear '.$user_data['store_username'].',</p></td>
			</tr>
			<tr>
				<td><p style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-bottom:10px; margin:0;"><h4>Thanks for Selecting PURCHASEKARO.COM as Your Business Partner...</h4></p></td>
			</tr>
			<tr>
				<td><p style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-bottom:10px; margin:0;">Purchasekaro.com at <a href="'.SITEURL.'mystore">www.purchasekaro.com/mystore</a></p></td>
			</tr>
			<tr>
				<td><p style="font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0; text-align:left; font-size:12px;">To activate your account <a href="'.SITEURL.'storeactivate.php?key='.$user_data['store_key'].'&t='.base64_encode($user_data['store_id']).'">click here</a></p></td>
			</tr>
			<tr>
				<td><p style="font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0; text-align:left; font-size:12px;" >Below is your user name and password for you to create and manage your online store at</p></td>
			</tr>
			<tr>
				<td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-bottom:5px; margin:0;"><b>User Email:</b> '.$user_data['store_email'].'</td>
			</tr>
			<tr>
				<td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px;"><b>Password:</b> '.base64_decode($user_data['store_pwd']).'</td>
			</tr>
			<tr>
				<td><p style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-top:15px;padding-bottom:15px; margin:0;">Please login at MYSTORE and Update your KYC & Contact Information of Your Store.....!!!</p></td>
			</tr>
			<tr>
				<td><p style="font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin-top:30px; text-align:left; font-size:12px;" >If you have any questions, you can email us at <a href="mailto:sellerdesk@purchasekaro.com" target="_blank">
sellerdesk@purchasekaro.com</a> & To Know our policies visit <a href="info.purchasekaro.com" target="_blank">info.purchasekaro.com</a></p></td>
			</tr>
			<tr>
				<td>
					Regards,
					<br/>
					Seller Desk
					<br/>
					Purchasekaro.com
				</td>
			</tr>
			<tr>
				<td height="10"></td>
			</tr>
		</table>
		
	</td>
</tr>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; padding-bottom:15px; padding-top:15px; border-top:1px solid #ccc;text-align:center;background:#ccc;">©2014 Purchasekaro Online Shopping PVT. LTD..</a></td>
			</tr>
		</table>
</table>

';
?>