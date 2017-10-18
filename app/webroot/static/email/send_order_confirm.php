<?php 

$html .= '<table width="100%" cellspacing="10" cellpadding="10" style="background:#fff" style="border:2px solid #ccc;" >
<tr>
	<td>
		<table cellpadding="0" cellspacing="0" width="100%" style="border-bottom:2px solid #ccc;">
			<tr>
				<td style="padding-bottom:15px;"><img src="'.SITEURL.'images/logo.png" alt="'.SITETITLE.'" height="50" /></td>
			</tr>
		</table>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<th style="color:#12AFE3; text-align:left; font-size:17px; font-weight:bold; font-family:Verdana, Arial, Helvetica, sans-serif; padding:10px 0;">Order Confirmation : #'.ORDER_NUMBER.$order_date_sr.$order_id.'</th>
			</tr>
			<tr>
				<td><p style="font-weight:bold; text-align:left; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0;">Dear Merchant,</p></td>
			</tr>
					
			<tr>
				<td><p style="font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0; text-align:left; font-size:12px;" >
					You have received new order on Purchasekaro. 
				</p></td>
			</tr>
			 
			<tr>
			  <td>
			  		<table style="font-family:Verdana, Arial, Helvetica, sans-serif; padding-bottom:10px; margin:0; text-align:left; font-size:12px;">
							<tr>
							  <th align="left" width="100" >Order Id:</th><td>#'.ORDER_NUMBER.$order_date_sr.$order_id.'</td>
							</tr>
							<tr>
							  <th align="left">Customer:</th><td>'.$user_details['user_full_name'].'</td>
							</tr>
							<tr>
							  <th align="left">Product:</th><td>'.$product_name.'</td>
							</tr>
							<tr>
							  <th align="left">Quantity:</th><td>'.$products_qty.'</td>
							</tr>
							<tr>
							  <th align="left">Check orders:</th><td><a href="'.SITEURL.'mystore/orders.php">Click Here</a></td>
							</tr>
					</table>
			  </td>	
			  
			</tr>
			 
		</table>
	</td>
</tr>
</table>';

?>