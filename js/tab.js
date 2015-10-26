var INTERACTION = (function() {

	function incrementExerciseNumber() {
		var $exerciseNumber = $('.exercise-container').length;
		$('.exerciseNumberContainer').html($exerciseNumber);
	}

	function addExercise() {
		$('#tab2').on('click', '#buttonAddExercise', function() {
			var ta_count = $("textarea").length;
			var elem = "<div class='description-create-course create-exercise exercise-container'><textarea name='exerciseContent[]' class='mceEditor'></textarea></div>";
			$(elem).attr("id", ta_count.toString());
			$(elem).insertBefore("#buttonSaveExercise");

			initTinyMCE();
			incrementExerciseNumber();
		});
	}

	function initTinyMCE() {
		tinymce.init({
			selector: "textarea",
			mode: "textareas",
			theme_advanced_path: true,
			content_css : "../css/custom-content.css",
			plugins: [
				"advlist autolink lists link charmap print preview anchor",
				"searchreplace visualblocks code fullscreen",
				"insertdatetime media table contextmenu paste"
			],
			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
		});
	}

	function changeOpenButtonText() {
		if ($(this).is(":visible")) {
			$(this).prev().find('.buttonOpen').text('Close');
		} else {
			$(this).prev().find('.buttonOpen').text('Open');
		}
	}


	return {
		init: function() {

			incrementExerciseNumber();
			initTinyMCE();
			addExercise();

			$('.create-menu .tab-links a').on('click', function(e)  {
				// Change/remove current tab to active
				$(this).parent('li').addClass('active').siblings().removeClass('active').addClass('inactive');
				e.preventDefault();
			});

			if($('#step').attr('value') == 2) {
				$('#tab2-click').hide();
			}
			$('#tab1-click').on('click', function(){
				$('#tab1').show();
				$('#tab2').hide();
			});

			$('#tab2-click').on('click', function(){
				$('#tab2').show();
				$('#tab1').hide();
			});
			// Toggle Give feedback container
			$('.feedback-container').hide();
			$('.exercise-details').on('click', '.feedback-button', function(e) {
				e.preventDefault();
				$(this).closest('.exercise-responses').find('.feedback-container').slideToggle();

			});

			// Open/Close container for exercises from Submitted Exercises
			$('.solutions-container').hide();
			$('.exercise-details.submitted').on('click', '.buttonOpen', function(e) {
				e.preventDefault();
				$(this).closest('.existingExercise').find('.solutions-container').slideToggle(300, changeOpenButtonText);
			});

			// Open/Close for user solution from Submitted Exercises
			$('.course-solution-content').hide();
			$('.exercise-responses').on('click', '.buttonOpen', function(e){
				e.preventDefault();
				$(this).closest('.exercise-responses').find('.course-solution-content').slideToggle(300, changeOpenButtonText);
			});

			$('.edit-exercise-container').hide();
			$('.exercise-details.submitted').on('click', '.edit-exercise', function(e) {
				e.preventDefault();
				$(this).closest('.existingCourse').find('.edit-exercise-container').slideToggle();
			});

			$('.edit-solution-container').hide();
			$('.submitted-exercise-container').on('click', '.edit-solution', function(e) {
				e.preventDefault();
				$(this).closest('.exercise-details').find('.edit-solution-container').slideToggle();
			});

			$('.submitted-exercise-container').hide();

			$('.exercise-details').on('click', '.open-solution-content', function(e) {
				e.preventDefault();
				$(this).closest('.exercise-details').find('.submitted-exercise-container').slideToggle(300, function() {
					if ($(this).is(":visible")) {
						$(this).prev().prev().find('.open-solution-content').text('Close');
					} else {
						$(this).prev().prev().find('.open-solution-content').text('Open');
					}
				});
			});

			// Hide/Show mce editor for create exercise
			$('.create-exercise').hide();
			$('.exercise-container').on('click', '.buttonEdit', function() {
				$(this).closest('.exercise-container').find('.create-exercise').slideToggle();
			});
		}
	}
}()); 

$(document).ready(function() {
	INTERACTION.init();
});