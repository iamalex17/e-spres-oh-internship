$(document).ready(function() {
	$('.create-menu .tab-links a').on('click', function(e)  {
		var currentAttrValue = $(this).attr('href');
		// Show/Hide Tabs
		$('.create-menu ' + currentAttrValue).show().siblings().hide();
		// Change/remove current tab to active
		$(this).parent('li').addClass('active').siblings().removeClass('active').addClass('inactive');
		e.preventDefault();
	});

	initTinyMCE();

	function initTinyMCE() {
		tinymce.init({
			selector: "textarea",
			mode: "textareas",
			theme_advanced_path: false,
			plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks code fullscreen",
				"insertdatetime media table contextmenu paste"
			],
			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
		});
	}

	$('#tab2').on('click', '#buttonAddExercise', function() {
		var ta_count = $("textarea").length;
		var elem = document.createElement("textarea");
		$(elem).attr("id", ta_count.toString());
		$(elem).appendTo(".create-exercise-container");

		initTinyMCE();
	});

	/*if($('#step').val() == 2) {
		console.log('lala');
		$('.create-menu .tab-links a').prop('disabled', true);
	}*/

	$('.solutions-container').hide();
	$('.exercise-details.submitted').on('click', '.buttonOpen', function(e) {
		e.preventDefault();
		$(this).closest('.existingExercise').find('.solutions-container').slideToggle(300, function() {
			if ($(this).is(":visible")) {
				$(this).prev().find('.buttonOpen').text('close');
			} else {
				$(this).prev().find('.buttonOpen').text('open');
			}
		});
	});

	$('.course-exercise-content').hide();
	$('.exercise-responses').on('click', '.buttonOpen', function(e){
		e.preventDefault();
		$(this).closest('.exercise-responses').find('.course-exercise-content').slideToggle(300, function() {
			if ($(this).is(":visible")) {
				$(this).prev().find('.buttonOpen').text('close');
			} else {
				$(this).prev().find('.buttonOpen').text('open');
			}
		});
	});

});