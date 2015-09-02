$(document).ready(function() {
	$('.create-menu .tab-links a').on('click', function(e)  {
		var currentAttrValue = $(this).attr('href');
// Show/Hide Tabs
		$('.create-menu ' + currentAttrValue).show().siblings().hide();
// Change/remove current tab to active
		$(this).parent('li').addClass('active').siblings().removeClass('active').addClass('inactive');
		e.preventDefault();
	});

	tinymce.init({
			selector: "textarea",
			plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks code fullscreen",
				"insertdatetime media table contextmenu paste"
			],
			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
		});

	$('#tab2').on('click', '#buttonAddExercise', function(e) {
		e.preventDefault();
		$('.create-exercise').last().clone().appendTo('.create-exercise-container');
	});
});