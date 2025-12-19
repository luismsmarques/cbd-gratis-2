/**
 * Store Directory JavaScript
 * 
 * Interactive functionality for store directory pages
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

(function() {
	'use strict';
	
	// Wait for DOM to be ready
	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
	
	function init() {
		// Initialize filter form enhancements
		initFilterForm();
		
		// Initialize store card interactions
		initStoreCards();
		
		// Initialize map interactions (if any)
		initMaps();
	}
	
	/**
	 * Enhance filter form with better UX
	 */
	function initFilterForm() {
		const filterForm = document.querySelector( '.store-filter-form' );
		if ( ! filterForm ) {
			return;
		}
		
		// Auto-submit on filter change (optional - can be enabled)
		const autoSubmit = false; // Set to true to enable auto-submit
		
		if ( autoSubmit ) {
			const selects = filterForm.querySelectorAll( 'select' );
			selects.forEach( function( select ) {
				select.addEventListener( 'change', function() {
					// Small delay to allow multiple selects to change
					clearTimeout( select.dataset.submitTimeout );
					select.dataset.submitTimeout = setTimeout( function() {
						filterForm.submit();
					}, 300 );
				} );
			} );
		}
		
		// Add loading state on submit
		filterForm.addEventListener( 'submit', function( e ) {
			const submitButton = filterForm.querySelector( 'button[type="submit"]' );
			if ( submitButton ) {
				submitButton.disabled = true;
				submitButton.textContent = 'A filtrar...';
			}
		} );
	}
	
	/**
	 * Add interactive features to store cards
	 */
	function initStoreCards() {
		const storeCards = document.querySelectorAll( '.stores-grid .mui-card' );
		
		storeCards.forEach( function( card ) {
			// Add click handler to entire card (if it has a link)
			const cardLink = card.querySelector( 'a[href*="lojas-cbd"]' );
			if ( cardLink ) {
				card.style.cursor = 'pointer';
				card.addEventListener( 'click', function( e ) {
					// Don't navigate if clicking on buttons or links
					if ( e.target.tagName === 'A' || e.target.tagName === 'BUTTON' || e.target.closest( 'a, button' ) ) {
						return;
					}
					window.location.href = cardLink.href;
				} );
			}
			
			// Add hover effect
			card.addEventListener( 'mouseenter', function() {
				card.style.transform = 'translateY(-4px)';
			} );
			
			card.addEventListener( 'mouseleave', function() {
				card.style.transform = 'translateY(0)';
			} );
		} );
	}
	
	/**
	 * Initialize Google Maps embeds
	 */
	function initMaps() {
		const mapContainers = document.querySelectorAll( '.store-map-container iframe' );
		
		mapContainers.forEach( function( iframe ) {
			// Add loading="lazy" if not already present
			if ( ! iframe.hasAttribute( 'loading' ) ) {
				iframe.setAttribute( 'loading', 'lazy' );
			}
			
			// Add error handler
			iframe.addEventListener( 'error', function() {
				console.warn( 'Failed to load Google Maps embed' );
				const container = iframe.closest( '.store-map-container' );
				if ( container ) {
					container.innerHTML = '<p style="padding: 2rem; text-align: center; color: var(--mui-gray-600);">Mapa não disponível. <a href="' + iframe.src.replace( '/embed/', '/' ) + '" target="_blank">Ver no Google Maps</a></p>';
				}
			} );
		} );
	}
	
	/**
	 * Smooth scroll to top when filtering
	 */
	function scrollToTop() {
		const filterForm = document.querySelector( '.store-filter-form' );
		if ( filterForm ) {
			filterForm.addEventListener( 'submit', function() {
				setTimeout( function() {
					window.scrollTo( {
						top: 0,
						behavior: 'smooth'
					} );
				}, 100 );
			} );
		}
	}
	
	// Initialize scroll to top
	scrollToTop();
	
	/**
	 * Add keyboard navigation support
	 */
	function initKeyboardNavigation() {
		const storeCards = document.querySelectorAll( '.stores-grid .mui-card' );
		
		storeCards.forEach( function( card, index ) {
			card.setAttribute( 'tabindex', '0' );
			card.setAttribute( 'role', 'article' );
			
			card.addEventListener( 'keydown', function( e ) {
				if ( e.key === 'Enter' || e.key === ' ' ) {
					e.preventDefault();
					const link = card.querySelector( 'a[href*="lojas-cbd"]' );
					if ( link ) {
						window.location.href = link.href;
					}
				}
				
				// Arrow key navigation
				if ( e.key === 'ArrowRight' || e.key === 'ArrowDown' ) {
					e.preventDefault();
					const nextCard = storeCards[ index + 1 ];
					if ( nextCard ) {
						nextCard.focus();
					}
				}
				
				if ( e.key === 'ArrowLeft' || e.key === 'ArrowUp' ) {
					e.preventDefault();
					const prevCard = storeCards[ index - 1 ];
					if ( prevCard ) {
						prevCard.focus();
					}
				}
			} );
		} );
	}
	
	// Initialize keyboard navigation
	initKeyboardNavigation();
	
})();

