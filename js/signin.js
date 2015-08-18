var LOGIN = (function() {

	function isValidEmailAddress() {

		var emailAddress = $('#email').val();

		var pattern = new RegExp(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/);
		var test = pattern.test(emailAddress);
		if(!test) {
			alert("Invalid email address");
		} else {
			console.log("200 OK");
		}
	}

	function checkIfPasswordsMatch() {
		if ($('#retypeNewPassword').val() === $('#newPassword').val()) {
			$(".errorMessage").text("Passwords match");
		} else {
			$(".errorMessage").text("Passwords do not match");
		}
	}

	return {
		init: function() {
			$('form').on('click', '#buttonSubmitRecover', isValidEmailAddress);

			$('#newPassword, #retypeNewPassword').on('keyup', checkIfPasswordsMatch);


		}
	}

}());

$(document).ready(function() {
	LOGIN.init();
});