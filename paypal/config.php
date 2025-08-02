<?php
define('ProPayPal', 1);
if(ProPayPal){
	define("PayPalClientId", "AfZivblkeVeIuGq9xSnMHwnnUSNKYGIiIkgHq1wKZo5ecRAAVi8DuQ7X0hbm9k_e_mPVMxt1IJLWEE5F");
	define("PayPalSecret", "EHu3dGwgygWoSWMOhkZ-c03gZ-IkRuOPPKtBZrEGS5maOdwrN1zISPlDkaqNt0sILk-gc-WZ2LO-vEuJ");
	define("PayPalBaseUrl", "https://api.paypal.com/v1/");
	define("PayPalENV", "production");
} else {
	define("PayPalClientId", "AXOkrZQdsAQ0xradoITm1RzM9cNjPnWSdK7MbwjCM-mbYX87WZKQsb7KA6Lgcr0KxROe8svhI6TWX3Jy");
	define("PayPalSecret", "ENgOPBG5IyTm0Fjj2wWjNedBbdTo1z4srB4uQWZGYEolgohbNaKWvn8wCaCO_aMIDadUEQOc8CjHXxvz");
	define("PayPalBaseUrl", "https://api.sandbox.paypal.com/v1/");
	define("PayPalENV", "sandbox");
}
?>