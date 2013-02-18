(function($) {

	var $submit, choice;

	$(document).ready(function($) {

		$submit = $('#submit-story');

		bindActions();

		$('.submit-story').live('click', function() {
			openForm();
			return false;
		});

		$('.close-submit-story').live('click', function() {
			closeForm();
			return false;
		});

		// submit
		$submit.find('form').submit(function() {
			var submission = $submit.find('#' + choice).serialize();
			$.getJSON(mappress_submit.ajaxurl, submission, function(data) {
				if(data.post_id) {
					$submit.find('.submit-content').empty();
					$submit.find('.description').text(mappress_submit.success_label);
				} else if(data.error)
					$submit.find('.error').empty().append('<p>' + data.error + '</p>');
				else
					$submit.find('.error').empty().append('<p>' + mappress_submit.error_label + '</p>');
			});
			return false;
		});

	});

	function bindActions() {
		$submit.find('.story-type a').click(function() {
			choice = $(this).data('choice');
			$submit.find('.story-type').hide('fast');
			$submit.find('#' + choice).show('fast');
			return false;
		});
	}

	function openForm() {
		$submit.find('.story-type').show();
		$submit.find('.submit-choice-content').hide();
		$submit.addClass('active');
	}

	function closeForm() {
		$submit.removeClass('active');
	}

})(jQuery);