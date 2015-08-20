$(document).ready(function() {

	$('.subNav').hide();

	$('nav').on('click', '.dropDown', function() {
		$('.subNav').slideToggle('slow', function() {
			$('.change-icon').toggleClass('iconMinusMore');
		});
	});


	$(document).on('opening', '.remodal', function () {
		console.log('Modal is opening');
	});

	$(document).on('opened', '.remodal', function () {
		console.log('Modal is opened');
	});

	$(document).on('closing', '.remodal', function (e) {

		// Reason: 'confirmation', 'cancellation'
		console.log('Modal is closing' + (e.reason ? ', reason: ' + e.reason : ''));
	});


	$(document).on('confirmation', '.remodal', function () {

		$('.test').submit();
		return true;
	});

	$(document).on('cancellation', '.remodal', function () {
		return false;
	});


});









