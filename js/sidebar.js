

$(document).ready(function() {

	$('.subNav').hide();

	$('nav').on('click', '.dropDown', function() {
		$('.subNav').slideToggle('slow', function() {
			$('.change-icon').toggleClass('iconMinusMore');
		});
	});

	$('#confirm-delete').on('show.bs.modal', function(e) {
		$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
		$('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
	});
});









