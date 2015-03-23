<?php include('header.php'); ?>
	<form action='expresscheckout.php' METHOD='POST'>
		<div class="span4"></div>
        <div class="span4">
            <h3> Pet Rock </h3>
            <table>
                <tr><img src="img/pet_rock.jpg" width="300" height="250"/></tr>
                <tr><td><h4>Product Info</h4></td></tr>
                <tr><td>Price:</td><td>$10.00</td></tr>
                <tr><td>Description:</td><td>Companion for life</td></tr>
            </table>
            </br>
            <input type='image' name='submit' src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' border='0' align='top' alt='Check out with PayPal'/>
        </div>
        <div class="span4"></div>
	</form>
<?php include('footer.php'); ?>
