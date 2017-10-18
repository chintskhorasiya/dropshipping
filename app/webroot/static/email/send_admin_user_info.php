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

				<td>

					<p style="font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0; text-align:left; font-size:12px;" >

						Below are User Details

					</p>	

				</td>

			</tr>

			<tr>

				<td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px; padding-bottom:5px; margin:0;"><b>User Email:</b> '.$_POST['user_email'].'</td>

			</tr>

			<tr>

				<td style="font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; font-size:12px;"><b>User Contact No:</b> '.$_POST['user_contact_no'].'</td>

			</tr>

			<tr>

				<td height="10"></td>

			</tr>

		</table>

	</td>

</tr>

</table>';



	$subject = 'Admin Created New User on Purchasekaro!';

	

	// To send HTML mail, the Content-type header must be set

	$headers  = 'MIME-Version: 1.0' . "\r\n";

	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	

	// Mail it

	mail('divyangchauhan.cmpica@gmail.com', $subject, $html, $headers);



?>