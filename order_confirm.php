<?php
	/*==================================================================
	 PayPal Express Checkout Call
	 ===================================================================
	*/
require_once ("paypalfunctions.php");
$PaymentOption = "PayPal";
if ( $PaymentOption == "PayPal" )
{
	/*
	'------------------------------------
	' The paymentAmount is the total value of 
	' the shopping cart, that was set 
	' earlier in a session variable 
	' by the shopping cart page
	'------------------------------------
	*/
	
	$finalPaymentAmount =  $_SESSION["Payment_Amount"];
	
	/*
	'------------------------------------
	' Calls the DoExpressCheckoutPayment API call
	'
	' The ConfirmPayment function is defined in the file PayPalFunctions.jsp,
	' that is included at the top of this file.
	'-------------------------------------------------
	*/

	$resArray = ConfirmPayment ( $finalPaymentAmount );
	$ack = strtoupper($resArray["ACK"]);
	if( $ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING" )
	{ 	
		?>
		<?php include('header.php'); ?>
		<div class="span4"></div>
		<div class="span4">
			<h3>Congratulations! You are now the proud owner of a Pet Rock!</h3>
			<h4> Click <a href='index.php'>here </a> to purchase another life companion</h4>
		</div>
		<div class="span4"></div>
		<?php include('footer.php'); ?>
		<?php
	}
	else  
	{
		//Display a user friendly Error on the page using any of the following error information returned by PayPal
		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
		
		echo "GetExpressCheckoutDetails API call failed. ";
		echo "Detailed Error Message: " . $ErrorLongMsg;
		echo "Short Error Message: " . $ErrorShortMsg;
		echo "Error Code: " . $ErrorCode;
		echo "Error Severity Code: " . $ErrorSeverityCode;
	}
}		
		
?>
