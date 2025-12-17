/**
 * Admin JavaScript for Legislation Sources
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

(function($) {
	'use strict';
	
	/**
	 * Test source functionality
	 */
	$(document).on('click', '.test-source', function(e) {
		e.preventDefault();
		
		var $button = $(this);
		var sourceId = $button.data('source-id');
		
		if (!sourceId) {
			alert('ID de fonte inválido.');
			return;
		}
		
		// Disable button and show loading
		$button.addClass('loading').prop('disabled', true);
		var originalText = $button.text();
		$button.text(cbdLegislationSources.strings.testing);
		
		// Make AJAX request
		$.ajax({
			url: cbdLegislationSources.ajaxUrl,
			type: 'POST',
			data: {
				action: 'cbd_test_source',
				nonce: cbdLegislationSources.nonce,
				source_id: sourceId
			},
			success: function(response) {
				if (response.success) {
					var message = cbdLegislationSources.strings.testSuccess;
					if (response.data.has_changes) {
						message += ' Mudanças detectadas!';
					} else {
						message += ' Nenhuma mudança detectada.';
					}
					alert(message);
				} else {
					alert(cbdLegislationSources.strings.testError + ' ' + (response.data.message || ''));
				}
			},
			error: function() {
				alert(cbdLegislationSources.strings.testError);
			},
			complete: function() {
				$button.removeClass('loading').prop('disabled', false).text(originalText);
			}
		});
	});
	
	/**
	 * Form validation
	 */
	$('form').on('submit', function(e) {
		var $form = $(this);
		var $name = $form.find('#source_name');
		var $url = $form.find('#source_url');
		
		// Remove previous errors
		$form.find('.error-message').remove();
		$form.find('.error').removeClass('error');
		
		var hasError = false;
		
		// Validate name
		if (!$name.val().trim()) {
			$name.addClass('error');
			$name.after('<span class="error-message" style="color: #d63638; display: block; margin-top: 0.25rem;">Nome é obrigatório.</span>');
			hasError = true;
		}
		
		// Validate URL
		if (!$url.val().trim()) {
			$url.addClass('error');
			$url.after('<span class="error-message" style="color: #d63638; display: block; margin-top: 0.25rem;">URL é obrigatória.</span>');
			hasError = true;
		} else {
			// Basic URL validation
			var urlPattern = /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;
			if (!urlPattern.test($url.val())) {
				$url.addClass('error');
				$url.after('<span class="error-message" style="color: #d63638; display: block; margin-top: 0.25rem;">URL inválida.</span>');
				hasError = true;
			}
		}
		
		if (hasError) {
			e.preventDefault();
			return false;
		}
	});
	
	/**
	 * URL auto-format
	 */
	$('#source_url').on('blur', function() {
		var $url = $(this);
		var url = $url.val().trim();
		
		if (url && !url.match(/^https?:\/\//)) {
			$url.val('https://' + url);
		}
	});
	
})(jQuery);

