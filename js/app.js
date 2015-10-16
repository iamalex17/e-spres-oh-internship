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

	function showDropdownMenu() {
		$(this).find('.subNav').slideToggle('slow', function() {
			$(this).closest('.dropDown').find('.change-icon').toggleClass('iconMinusMore');
		});
	}

	function loadFile() {
			var reader = new FileReader();
			reader.onload = function(){
				var output = document.getElementById('output');
				output.src = reader.result;
			};
			reader.readAsDataURL(event.target.files[0]);
	}

	return {
		init: function() {


			$('form').find('input').each( keepInputFocusStyle );

			$('form').on('blur keyup', '#email', ValidateEmailAddress);
			$('.buttonAlign').on('change', '#buttonAddImage',loadFile);

			$('#newPassword, #retypeNewPassword').on('keyup', checkIfPasswordsMatch);

			//check if input field has no value
			$('#firstName').on('keyup', checkInputValue);
			$('#lastName').on('keyup', checkInputValue);
			$('#username').on('keyup', checkInputValue);
			$('#oldPassword').on('keyup', checkInputValue);

			$('form').on('blur', 'input', keepInputFocusStyle);

			// show-hide dropdown list from sidebar
			$('.subNav').hide();

			if( $('.dropDown').hasClass('active-sidebar') ){
				$('.active-sidebar').find('.subNav').show();
				$('.active-sidebar').find('.change-icon').toggleClass('iconMinusMore');
			}
			$('nav').on('click', '.dropDown', showDropdownMenu);

			// hide error/success message
			$('.successMessage').on('click', 'a', function (e) {
				e.preventDefault();
				$(this).closest('.successMessage').fadeOut();
			});
			$('.successMessageLogin').on('click', 'a', function (e) {
				e.preventDefault();
				$(this).closest('.successMessageLogin').fadeOut();
			});
			$('.errorMessageContainer').on('click', 'a', function (e) {
				e.preventDefault();
				$(this).closest('.errorMessageContainer').fadeOut();
			});
			$('.errorMessageLogin').on('click', 'a', function (e) {
				e.preventDefault();
				$(this).closest('.errorMessageLogin').fadeOut();
			});

			$('.buttonDelete').bind('click', function(e) {
				e.preventDefault();
				$idTest = $(this).attr('value');
				$('.modal-container').bPopup({
					closeClass: 'remodal-cancel',
					modalClose: true
				});
				$('.remodal-confirm').attr('value', $idTest);
			});

			$('.remodal-confirm').on('click', function() {
				$(this).submit();
			});

			$('.pending-user').on('click', '.accept', function(e) {
				e.preventDefault();
				$(this).closest('.pending-user').find('.select-role-wrapper').slideToggle();
			}); 
		}

	}

}());

$(document).ready(function() {
	APP.init();
});