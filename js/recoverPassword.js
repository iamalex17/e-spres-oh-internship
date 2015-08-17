var RECOVER = (function() {

	var emailAddress = $('#email').val();

	function isValidEmailAddress(emailAddress) {
		var pattern = new RegExp(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/);
		var test = pattern.test(emailAddress);
		if(!test) {
			alert("Ivalid email address");
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