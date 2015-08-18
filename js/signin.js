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
			$(".passwordsStatus").text("Passwords match");
		} else {
			$(".passwordsStatus").text("Passwords do not match");
		}
	}

	function keepInputFocusStyle() {

		$input = $('input').val();
		var emptyContent = "";
		if($input != emptyContent) {
			$('input').addClass('');
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