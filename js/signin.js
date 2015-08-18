var LOGIN = (function() {

	function ValidateEmailAddress() {

		var emailAddress = $(this).val();

		var pattern = new RegExp(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/);
		var test = pattern.test(emailAddress);

		if(!test) {
			$(".validEmail").text("Invalid email address");
		} else if (emailAddress === "") {
			$(".validEmail").text("Please enter an email address");
		} else {
			console.log("200 OK");
			$(".validEmail").text("");
		}
	}

	function checkIfPasswordsMatch() {
		if ($('#retypeNewPassword').val() == $('#newPassword').val()) {
			console.log('200 OK');
			$(".passwordsStatus").text("");
		} else {
			$(".passwordsStatus").text("Passwords do not match");
		}
	}

	function checkFirstNameContent() {
		var firstName  = $(this).val();

		if(firstName != "") {
			console.log('200 OK');
			$('.checkFirstName').text("");
		} else {
			$('.checkFirstName').text('Please enter your first name');
		}
	}

	function checkLastNameContent() {
		var lastName  = $(this).val();

		if(lastName != "") {
			console.log('200 OK');
			$('.checkLastName').text("");
		} else {
			$('.checkLastName').text('Please enter your last name');
		}
	}

	function checkUsernameContent() {
		var username  = $(this).val();

		if(username != "") {
			console.log('200 OK');
			$('.checkUsername').text("");
		} else {
			$('.checkUsername').text('Please enter your username');
		}
	}

	return {
		init: function() {
			$('form').on('keyup', '#email', ValidateEmailAddress);

			$('#newPassword, #retypeNewPassword').on('keyup', checkIfPasswordsMatch);

			$('#firstName').on('keyup', checkFirstNameContent);
			$('#lastName').on('keyup', checkLastNameContent);
			$('#username').on('keyup', checkUsernameContent);

		}
	}

}());

$(document).ready(function() {
	LOGIN.init();

	$('.signIn').on('blur', '#email', function(){
		var $this = $(this);

		$this.val() ? $this.closest('.formInput').addClass('input-focus') : $this.closest('.formInput').removeClass('input-focus');


		console.log($this.val());
	});

});