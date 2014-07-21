$(function(){

	// Intercept the register form submission.
	$("#cleo-register-account-form").submit(function(e){

		// Prevent the form from actually submitting.
		e.preventDefault();

		$(".cleo-form-error-wrapper").html("");

		// Do an initial screening of the email addresses.
		if(!isValidEmail($("#cleo-reg-email1").val()) || !isValidEmail($("#cleo-reg-email2").val())){
			displayFormError("Please enter a valid email address.");
			return;
		}

		// TODO process the form.
		$.ajax({
			url: "../model/accounts/pcs_create_account.php",
			type: "POST",
			data: {	email1: $("#cleo-reg-email1").val(),
					email2: $("#cleo-reg-email2").val(),
					firstname: $("#cleo-reg-firstname").val(),
					lastname: $("#cleo-reg-lastname").val(),
					password1: $("#cleo-reg-pass1").val(),
					password2: $("#cleo-reg-pass2").val() },
			success: function(data){

				// An error occurred.
				if(data[":status"] == 1){

					// Display an error message.
					displayFormError("Error: " + data[':content']);
				}
				// Success!
				else{

					// Redirect to the login page.
					document.location.href = "login.php?form_message=Success!%20Your%20account%20has%20been%20successfully%20created.";
				}
			},
			error: function(data){
				displayFormError("An unexpected error has occurred. Please try again.");
				console.log("An unexpected error has occurred.");
				console.log(data);
			},
			dataType: "json"
		});
	});

	// Intercept the login form submission.
	$("#cleo-login-form").submit(function(e){

		// Prevent the form from actually submitting.
		e.preventDefault();

		$(".cleo-form-error-wrapper").html("");

		// TODO process the form.
		$.ajax({
			url: "../model/accounts/pcs_login.php",
			type: "POST",
			data: {	email: $("#cleo-login-email").val(),
					password: $("#cleo-login-pass").val() },
			success: function(data){

				// An error occurred.
				if(data[":status"] == 1){

					// Display an error message.
					displayFormError("Error: " + data[':content']);
				}
				// Success!
				else{
					// Redirect to the login page.
					document.location.href = "index.php";
				}
			},
			error: function(data){
				displayFormError("An unexpected error has occurred. Please try again.");
				console.log("An unexpected error has occurred.");
				console.log(data);
			},
			dataType: "json"
		});
	});
});

function displayFormError(message){

	// Append an error message to the form body.
	$(".cleo-form-error-wrapper").html(
		"<div class=\"cleo-form-error\">" + message + "</div>"
	);

	$(".cleo-form-error-wrapper").css('visibility', 'visible');
}

function displayFormSuccess(message){

	// Append an error message to the form body.
	$(".cleo-form-error-wrapper").html(
		"<div class=\"cleo-form-success\">" + message + "</div>"
	);

	$(".cleo-form-error-wrapper").css('visibility', 'visible');
}

function isValidEmail(email){
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}