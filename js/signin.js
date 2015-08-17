// bad idea

/*var LOGIN = (function() {

	function recoverPasswordRedirect(e) {

		e.preventDefault();

		//ajax request redirects user from login page to recover password page
		$.ajax({
			type: 'GET',
			dataType: 'html',
			url: 'templates/recoverPassword.tmpl',
			success: function(data){
				console.log("works");
				$('body').html(data);
			},
			error: function() {
				alert('An error has occured. Please try again');
			}
		});
	}

	return {
		init: function() {
			$('form').on('click', '#recoverPassword', recoverPasswordRedirect);
		}
	}
}());


$(document).ready(function() {
	LOGIN.init();
});*/

