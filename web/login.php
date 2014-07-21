<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style-main.css">
		<link rel="stylesheet" type="text/css" href="style-form.css">
		<script type="text/javascript" src="jquery-1.11.1.js"></script>
		<script type="text/javascript" src="script-account.js"></script>
	</head>

	<body>
		<div id="ui-wrapper">

			<!-- Topbar -->
			<div id="generic-topbar"></div>

			<form id="cleo-login-form" class="cleo-form">
				<div class="cleo-form-title">
					Log In
					<div class="cleo-form-subtext">Need an account? Sign up <a href="register.php">here</a>!</div>
				</div>
				<?php
					if(isset($_GET['form_message'])){
						echo	"<div class=\"cleo-form-row cleo-form-error-wrapper\" style=\"visibility: visible\">" .
									"<div class=\"cleo-form-success\">" . $_GET['form_message'] . "</div>" .
								"</div>";
					}
					else{ echo "<div class=\"cleo-form-row cleo-form-error-wrapper\"></div>"; }
				?>
				<div class="cleo-form-row">
					<label for="email1">Email Address</label>
					<input type="text" id="cleo-login-email" name="email" placeholder="foo@bar.com" required>
					<label for="password"> Password</label>
					<input type="password" id="cleo-login-pass" name="password" placeholder="Please enter a password" required>
				</div>
				<div class="cleo-form-submit-wrapper">
					<input class="cleo-form-submit" type="submit" value="Log In" style="margin-left: auto; margin-right: auto;" required>
				</div>
			</form>
		</div>
	</body>
</html>