/**
 * Featured Image Generator Admin Script
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

(function($) {
	'use strict';
	
	$(document).ready(function() {
		const $button = $('#cbd-generate-image-btn');
		const $status = $('#cbd-image-generator-status');
		const $preview = $('#cbd-image-generator-preview');
		
		if (!$button.length) {
			return;
		}
		
		$button.on('click', function(e) {
			e.preventDefault();
			
			const postId = $(this).data('post-id');
			const $btn = $(this);
			const customPrompt = $('#cbd-custom-prompt').val().trim();
			
			// Disable button
			$btn.prop('disabled', true);
			$btn.html('<span class="spinner is-active" style="float: none; margin: 0 5px 0 0;"></span> Gerando...');
			
			// Clear previous status
			$status.removeClass('notice-success notice-error notice-info').html('').show();
			$preview.html('').hide();
			
			// Show initial status
			const statusMessage = customPrompt ? 'Buscando imagem com prompt personalizado...' : cbdImageGenerator.strings.generating;
			$status.addClass('notice notice-info inline').html('<p><strong>' + statusMessage + '</strong></p>').show();
			
			// Prepare AJAX data
			const ajaxData = {
				action: 'cbd_generate_featured_image',
				nonce: cbdImageGenerator.nonce,
				post_id: postId
			};
			
			// Add custom prompt if provided
			if (customPrompt) {
				ajaxData.custom_prompt = customPrompt;
			}
			
			// Make AJAX request
			$.ajax({
				url: cbdImageGenerator.ajaxUrl,
				type: 'POST',
				data: ajaxData,
				success: function(response) {
					if (response.success) {
						// Success
						const descriptionLabel = customPrompt ? 'Prompt usado' : 'Descrição gerada';
						$status.removeClass('notice-info').addClass('notice-success').html(
							'<p><strong>✅ ' + response.data.message + '</strong></p>' +
							'<p><strong>' + descriptionLabel + ':</strong> ' + response.data.description + '</p>'
						);
						
						// Show preview
						$preview.html(
							'<strong>Imagem gerada:</strong><br>' +
							response.data.thumbnail
						).show();
						
						// Reload page after 2 seconds to show new featured image
						setTimeout(function() {
							location.reload();
						}, 2000);
					} else {
						// Error
						let errorMsg = response.data && response.data.message ? response.data.message : cbdImageGenerator.strings.error;
						
						if (response.data && response.data.step) {
							errorMsg += ' (Etapa: ' + response.data.step + ')';
						}
						
						$status.removeClass('notice-info').addClass('notice-error').html(
							'<p><strong>❌ ' + errorMsg + '</strong></p>'
						);
						
						// Show additional info if available
						if (response.data && response.data.description) {
							$status.append('<p><strong>Descrição gerada:</strong> ' + response.data.description + '</p>');
						}
					}
					
					// Re-enable button
					$btn.prop('disabled', false);
					$btn.html('<span class="dashicons dashicons-art" style="vertical-align: middle; margin-top: 3px;"></span> Gerar Imagem de Destaque');
				},
				error: function(xhr, status, error) {
					$status.removeClass('notice-info').addClass('notice-error').html(
						'<p><strong>❌ ' + cbdImageGenerator.strings.error + '</strong></p>' +
						'<p>Erro: ' + error + '</p>'
					);
					
					// Re-enable button
					$btn.prop('disabled', false);
					$btn.html('<span class="dashicons dashicons-art" style="vertical-align: middle; margin-top: 3px;"></span> Gerar Imagem de Destaque');
				}
			});
		});
	});
	
})(jQuery);

