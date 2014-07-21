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

			<form id="cleo-register-account-form" class="cleo-form">
				<div class="cleo-form-title">
					Sign Up
					<div class="cleo-form-subtext">Already have an account? Sign in <a href="login.php">here</a>.</div>
				</div>
				<div class="cleo-form-row cleo-form-error-wrapper"></div>
				<div class="cleo-form-col">
					<label for="first_name">First Name</label>
					<input type="text" id="cleo-reg-firstname" name="first_name" placeholder="Foo" required>
				</div>
				<div class="cleo-form-col">
					<label for="last_name">Last Name</label>
					<input type="text" id="cleo-reg-lastname" name="last_name" placeholder="Bar" required>
				</div>
				<div class="cleo-form-row">
					<label for="email1">Email Address</label>
					<input type="text" id="cleo-reg-email1" name="email1" placeholder="foo@bar.com" required>
					<label for="email2"> Repeat Email</label>
					<input type="text" id="cleo-reg-email2" name="email2" placeholder="foo@bar.com" required>
				</div>
				<div class="cleo-form-col">
					<label for="password1">Password</label>
					<input type="password" id="cleo-reg-pass1" name="password1" placeholder="Please Enter A Password" required>
				</div>
				<div class="cleo-form-col">
					<label for="password2">Repeat Password</label>
					<input type="password" id="cleo-reg-pass2" name="password2" placeholder="Please Enter A Password" required>
				</div>
				<div class="cleo-form-submit-wrapper">
					<input class="cleo-form-submit" type="submit" value="*Sign Up!" required>
					<div class="cleo-form-subtext">*By clicking "Sign Up!" you are agreeing to Cleo's <a href="#">terms and conditions.</a></div>
				</div>
			</form>
		</div>
	</body>
</html>