var RESET = (function() {

	function validatePassword() {
		if ($('#retypeNewPassword').val() === $('#newPassword').val()) {
			$(".errorMessage").text("Passwords match");
		} 
		else {
			$(".errorMessage").text("Passwords do not match");
		}
	}

	return {
		init: function() {

			$('#newPassword, #retypeNewPassword').on('keyup', validatePassword);
		}
	}


}());

$(document).ready(function() {
	RESET.init();
});