$(document).ready(function() {

	$('.subNav').hide();

	$('nav').on('click', '.dropDown', function() {
		$('.subNav').slideToggle('slow', function() {
			$('.change-icon').toggleClass('iconMinusMore');
		});
	});

	//$('.successMessage').fadeIn('fast').delay(3000).fadeOut('fast');


});









