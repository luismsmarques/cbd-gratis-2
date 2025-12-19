/**
 * Newsletter Subscription Handler
 * 
 * Handles newsletter form submissions via Brevo API
 */

(function() {
	'use strict';
	
	// Initialize newsletter forms
	document.addEventListener('DOMContentLoaded', function() {
		const forms = document.querySelectorAll('.newsletter-form');
		
		forms.forEach(function(form) {
			form.addEventListener('submit', handleNewsletterSubmit);
		});
	});
	
	/**
	 * Handle newsletter form submission
	 */
	function handleNewsletterSubmit(e) {
		e.preventDefault();
		
		const form = e.target;
		const emailInput = form.querySelector('.newsletter-email-input');
		const submitBtn = form.querySelector('.newsletter-submit-btn');
		const messageDiv = form.querySelector('.newsletter-message');
		const btnText = submitBtn.querySelector('.btn-text');
		const btnLoading = submitBtn.querySelector('.btn-loading');
		
		const email = emailInput.value.trim();
		
		// Validate email
		if (!email || !isValidEmail(email)) {
			showMessage(messageDiv, 'Por favor, insira um email válido.', 'error');
			return;
		}
		
		// Disable form
		emailInput.disabled = true;
		submitBtn.disabled = true;
		btnText.style.display = 'none';
		btnLoading.style.display = 'inline-block';
		messageDiv.style.display = 'none';
		
		// Get REST API URL
		const apiUrl = (window.cbdAIData && window.cbdAIData.apiUrl) 
			? window.cbdAIData.apiUrl 
			: '/wp-json/cbd-ai/v1/';
		
		const nonce = (window.cbdAIData && window.cbdAIData.nonce) 
			? window.cbdAIData.nonce 
			: '';
		
		// Make API request
		fetch(apiUrl + 'newsletter/subscribe', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-WP-Nonce': nonce
			},
			body: JSON.stringify({
				email: email
			})
		})
		.then(function(response) {
			return response.json();
		})
		.then(function(data) {
			if (data.success !== false && !data.code) {
				// Success
				showMessage(messageDiv, data.message || 'Subscrição realizada com sucesso!', 'success');
				emailInput.value = '';
			} else {
				// Error
				const errorMsg = data.message || data.code || 'Erro ao processar subscrição. Por favor, tente novamente.';
				showMessage(messageDiv, errorMsg, 'error');
			}
		})
		.catch(function(error) {
			console.error('Newsletter subscription error:', error);
			showMessage(messageDiv, 'Erro de conexão. Por favor, tente novamente mais tarde.', 'error');
		})
		.finally(function() {
			// Re-enable form
			emailInput.disabled = false;
			submitBtn.disabled = false;
			btnText.style.display = 'inline';
			btnLoading.style.display = 'none';
		});
	}
	
	/**
	 * Show message to user
	 */
	function showMessage(element, message, type) {
		if (!element) return;
		
		element.textContent = message;
		element.style.display = 'block';
		
		// Remove previous classes
		element.classList.remove('text-green-600', 'text-red-600', 'text-cbd-green-600');
		
		// Add appropriate class
		if (type === 'success') {
			element.classList.add('text-green-600', 'text-cbd-green-600');
		} else {
			element.classList.add('text-red-600');
		}
		
		// Auto-hide after 5 seconds
		setTimeout(function() {
			element.style.display = 'none';
		}, 5000);
	}
	
	/**
	 * Validate email format
	 */
	function isValidEmail(email) {
		const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		return re.test(email);
	}
})();



