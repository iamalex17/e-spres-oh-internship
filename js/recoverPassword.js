var RECOVER = (function() {


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

	return {
		init: function() {
			$('form').on('click', '#buttonSubmitRecover', isValidEmailAddress);
		}
	}

}());

$(document).ready(function() {
	RECOVER.init();
});