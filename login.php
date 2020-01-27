<?php
session_start();
include_once("include/config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>C9 Admin Panel</title>
		<meta charset="utf-8">
		<link href="css/style.css" rel='stylesheet' type='text/css' />
		<link href="css/animate.css" rel='stylesheet' type='text/css' />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		<!--webfonts-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:600italic,400,300,600,700' rel='stylesheet' type='text/css'>
		<!--//webfonts-->
</head>
<body>
	 <!-----start-main---->
	 <div class="main">
		<div class="login-form">
			<h1>Admin Login</h1>
					<div class="head">
						<img src="images/user.png" alt=""/>
					</div>
				<form name="loginaccount" method="post" action="">
						<input type="text" name="username" class="text" value="USERNAME" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'USERNAME';}" >
						<input type="password" value="Password" name="password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}">
						<div class="submit">
							<input type="submit" name="submit" value="LOGIN" >
					</div>	</form>
                    <center><p class="animated fadeIn"><font color="#FF0000">
                    <?php 
					if($_POST['submit'])
					{
						$api->login($_POST['username'],$_POST['password']);
					}
					?></font>&nbsp;</p>
                    </center>
				
			</div>
			<!--//End-login-form-->
			 <!-----start-copyright---->
   					<div class="copy-right">
						<!--- copy right is here :)<p>Template by <a href="http://w3layouts.com">w3layouts</a></p> ------>
					</div>
				<!-----//end-copyright---->
		</div>
			 <!-----//end-main---->
		 		
</body>
</html>