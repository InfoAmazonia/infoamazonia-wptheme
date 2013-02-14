(function($) {

	$(document).ready(function($) {

		$('.submit-story').live('click', function() {
			openForm();
			return false;
		});

		$('.close-submit-story').live('click', function() {
			$('#submit-story').removeClass('active');
			return false;
		})

	});

	function openForm() {
		$('#submit-story').addClass('active');
	}

})(jQuery);