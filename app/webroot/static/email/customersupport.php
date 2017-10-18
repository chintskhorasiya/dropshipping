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
				<td><p style="font-weight:bold; text-align:left; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0;">Dear '.$suport_data['f_name'].',</p></td>
			</tr>
			<tr>
				<td><p style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-bottom:10px; margin:0;">you had contact regarding following !</p></td>
			</tr>
			<tr>
				<td>
					<p style="font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0; text-align:left; font-size:12px;">
						Your Subject is : '.$suport_data['f_subject'].'						
					</p>
				</td>
			</tr>
			<tr>
				<td>
					<p style="font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0; text-align:left; font-size:12px;">
						Your Message is : '.$suport_data['f_message'].'						
					</p>
				</td>
			</tr>
			<tr>
				<td>
					<p style="font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0; text-align:left; font-size:12px;">
						Reply from Purchasekaro : '.$suport_data['a_message'].'						
					</p>
				</td>
			</tr>
			<tr>
				<td height="10"></td>
			</tr>
		</table>
		
	</td>
</tr>
</table>';
?>