<?php
/*==================================================================
 PayPal Express Checkout Call
 ===================================================================
*/
// Check to see if the Request object contains a variable named 'token'	
$token = "";
if (isset($_REQUEST['token']))
{
	$token = $_REQUEST['token'];
}

// If the Request object contains the variable 'token' then it means that the user is coming from PayPal site.	
if ( $token != "" )
{

	require_once ("paypalfunctions.php");

	/*
	'------------------------------------
	' Calls the GetExpressCheckoutDetails API call
	'
	' The GetShippingDetails function is defined in PayPalFunctions.jsp
	' included at the top of this file.
	'-------------------------------------------------
	*/
	

	$resArray = GetShippingDetails( $token );
	$ack = strtoupper($resArray["ACK"]);
	if( $ack == "SUCCESS" || $ack == "SUCESSWITHWARNING") 
	{
		/*
		' The information that is returned by the GetExpressCheckoutDetails call should be integrated by the partner into his Order Review 
		' page		
		*/
		$email 				= $resArray["EMAIL"]; // ' Email address of payer.
		$payerId 			= $resArray["PAYERID"]; // ' Unique PayPal customer account identification number.
		$payerStatus		= $resArray["PAYERSTATUS"]; // ' Status of payer. Character length and limitations: 10 single-byte alphabetic characters.
		$firstName			= $resArray["FIRSTNAME"]; // ' Payer's first name.
		$lastName			= $resArray["LASTNAME"]; // ' Payer's last name.
		$cntryCode			= $resArray["COUNTRYCODE"]; // ' Payer's country of residence in the form of ISO standard 3166 two-character country codes.
		$shipToName			= $resArray["SHIPTONAME"]; // ' Person's name associated with this address.
		$shipToStreet		= $resArray["SHIPTOSTREET"]; // ' First street address.
		$shipToCity			= $resArray["SHIPTOCITY"]; // ' Name of city.
		$shipToState		= $resArray["SHIPTOSTATE"]; // ' State or province
		$shipToCntryCode	= $resArray["SHIPTOCOUNTRYCODE"]; // ' Country code. 
		$shipToZip			= $resArray["SHIPTOZIP"]; // ' U.S. Zip code or other country-specific postal code.
		$addressStatus 		= $resArray["ADDRESSSTATUS"]; // ' Status of street address on file with PayPal   
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

<?php include('header.php'); ?>
<form action='order_confirm.php' METHOD='POST'>
		<div class="span4"></div>
        <div class="span4">
        	<h3>Confirm your Information</h3>
            <table>
                <tr><td>Name:</td><td><?= $lastName." ".$firstName ?></td></tr>
                <tr><td>Email:</td><td><?= $email ?></td></tr>
                <tr><td>Payment:</td><td>$<?= $_SESSION["Payment_Amount"] ?></td></tr>
                <tr><td>Street:</td><td><?= $shipToStreet?></td></tr>
                <tr><td>City:</td><td><?= $shipToCity ?></td></tr>
                <tr><td>State:</td><td><?= $shipToState ?></td></tr>
                <tr><td>Zipcode:</td><td><?= $shipToZip ?></td></tr>
            </table>
            </br>
            <input class="btn btn-primary" type="submit" value="Confirm"/>
        </div>
        <div class="span4"></div>
		
	</form>
<?php include('footer.php'); ?>