jQuery(document).ready(function($) {

	// Toggle screening question options dropdown
	$('#wpjmsq-add-question-repeater-trigger').on('click', function(event) {
		$('.add_screening_question_button_options').toggleClass('hidden');
	});

	// Close the dropdown when clicked on the document
	$(document).on('click', function(event) {
		if ($(event.target).is('#wpjmsq-add-question-repeater-trigger') === false) {
			if (!$('.add_screening_question_button_options').hasClass('hidden')) {
				$('.add_screening_question_button_options').addClass('hidden');
			}
		}
	});

	// Show/Hide the modal
	$('[data-trigger="wpjmsq-popup"]').on('click', function(event) {
		event.preventDefault();

		$('#wpjmsq-popup').toggleClass('hidden');

		if ($(this).hasClass('wpjmsq-modal-close-btn')) {

			$('#wpjmsq-popup').find('.modal-content').html('');

		} else {

			if ($(this).attr('data-type') != 'undefined') {

				$('#wpjmsq-popup').find('.modal-content').html('<p style="text-align:center;">' + wpjmsq_vars.loading_text + '</p>');

				var request_url = $(this).attr('href');

				$.get(request_url, function(data) {
					$('#wpjmsq-popup').find('.modal-content').html(data);
				});
			}

		}
	});

	// Add suggested questions
	$(document).on('click', '.choose-suggested-questions', function(event) {
		event.preventDefault();

		var ids = [],
			question_html = '',
			form = $(this).parents('.form');

		form.find('input[type="checkbox"]:checked').each(function(index, el) {
			var that = $(this),
				question_text = that.attr('data-question'),
				question_id = that.val(),
				question_html = '';

			question_html += '<fieldset class="screening-question">';
				question_html += '<div class="input-cell">';
					question_html += '<input type="text" class="input-text" name="suggested_question[' + question_id + ']" value="' + question_text + '">';
				question_html += '</div>';

				question_html += '<div class="button-cell">';
					question_html += '<button type="button" class="remove_question_item">&times;</button>';
				question_html += '</div>';
			question_html += '</fieldset>';

			$('#wpjmsq-post-job-dynamic-loader').prepend(question_html);
		});

		$('.wpjmsq-modal-close-btn').trigger('click');
	});

	// Add new question
	$(document).on('click', '.create_question_btn', function(event) {
		event.preventDefault();

		var that = $(this),
			new_question = that.parents('.wpjmsq-modal-body').find('textarea[name="new_question"]').val(),
			question_html = '';

		question_html += '<fieldset class="screening-question">';
			question_html += '<div class="input-cell">';
				question_html += '<input type="text" class="input-text" name="new_question[]" value="' + new_question + '">';
			question_html += '</div>';

			question_html += '<div class="button-cell">';
				question_html += '<button type="button" class="remove_question_item">&times;</button>';
			question_html += '</div>';
		question_html += '</fieldset>';

		$('#wpjmsq-post-job-dynamic-loader').prepend(question_html);

		$('.wpjmsq-modal-close-btn').trigger('click');
	});

	// Remove question
	$(document).on('click', '.remove_question_item', function(event) {
		event.preventDefault();
		$(this).parents('.screening-question').remove();
	});

});
