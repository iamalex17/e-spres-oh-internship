var APP = (function() {

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


	function checkInputValue() {
		var $this = $(this);

		$this.closest('.formInput').next('.check-input').toggleClass("check-input-hidden", $this.val() != "");
	}


	function keepInputFocusStyle() {

		var $this = $(this);

		if( $this.val() ) {
			$this.closest('.formInput').addClass('input-focus');
		} else {
			$this.closest('.formInput').removeClass('input-focus');
		}
	}



	return {
		init: function() {


			$('form').on('blur keyup', '#email', ValidateEmailAddress);


			$('#newPassword, #retypeNewPassword').on('keyup', checkIfPasswordsMatch);

			$('#firstName').on('keyup', checkInputValue);
			$('#lastName').on('keyup', checkInputValue);
			$('#username').on('keyup', checkInputValue);
			$('#oldPassword').on('keyup', checkInputValue);

			$('form').on('change blur', 'input', keepInputFocusStyle);

			$('.subNav').hide();

			$('nav').on('click', '.dropDown', function() {
				$('.subNav').slideToggle('slow', function() {
					$('.change-icon').toggleClass('iconMinusMore');
				});
			});

			$('.successMessage').fadeIn('fast').delay(3000).fadeOut('slow');
			$('.errorMessage').fadeIn('fast').delay(3000).fadeOut('slow');
		}
	}

}());

$(document).ready(function() {
	APP.init();
});