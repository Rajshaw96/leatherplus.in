<?php


//Required PHPMailer FIles

require '../plugins/phpmailer/src/Exception.php';
require '../plugins/phpmailer/src/PHPMailer.php';
require '../plugins/phpmailer/src/SMTP.php';

require('config.php');

session_start();

//Required Config Files
require_once('../lib/config/config.php');

//Required Libraries
require_once('../lib/helpers/urlhelpers.php');
require_once('../lib/database/databaseops.php');
require_once('../lib/notifications/emailnotifications.php');
require_once('../lib/notifications/smsnotifications.php');

//Create Objects
$url = new UrlHelpers();
$database = new DatabaseOps();
$emailnotif = new EmailNotifications();
$smsnotif = new SMSNotifications();

//Declare Variables
$connStatus = $database->createConnection();

if ($connStatus == true) {

	$result_updatedetails = $database->runQuery("UPDATE `orders` SET `order_paystatus` = 1 WHERE `order_num` = '" . $_SESSION['ordernum'] . "'");

	if ($result_updatedetails != false) {

		echo "Payment status is updated!";

		header('location:../my-orders?q=order-confirmed');
	} else {

		echo "Something went wrong";
	}
} else {

	echo "Database server not established";
}

?>

<div class="container">
	<h2>Paypal Express Checkout Demo with PHP</h2>	
	<?php 
	if(!empty($_GET['paymentID']) && !empty($_GET['payerID']) && !empty($_GET['token']) && !empty($_GET['pid']) ){
		$paymentID = $_GET['paymentID'];
		$payerID = $_GET['payerID'];
		$token = $_GET['token'];
		$pid = $_GET['pid'];   
		?>
		<div class="alert alert-success">
		  <strong>Success!</strong> Your order processed successfully.
		</div>
		<table>       
			<tr>
			  <td>Payment Id:  <?php echo $paymentID; ?></td>
			  <td>Payer Id: <?php echo $payerID; ?></td>			  
			  <td><?php echo $token; ?></td>
			  <td>product Id: <?php echo $pid; ?></td>
			</tr>       
		</table>
	<?php	
	} else {
		header('Location:index.php');
	}
	?>