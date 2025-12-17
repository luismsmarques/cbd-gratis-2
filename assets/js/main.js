/**
 * Main JavaScript File
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

// Mobile menu toggle with ARIA
document.addEventListener('DOMContentLoaded', function() {
	const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
	const mobileNavigation = document.getElementById('mobile-navigation');
	
	if (mobileMenuToggle && mobileNavigation) {
		mobileMenuToggle.addEventListener('click', function() {
			const isExpanded = mobileMenuToggle.getAttribute('aria-expanded') === 'true';
			mobileNavigation.classList.toggle('hidden');
			mobileMenuToggle.setAttribute('aria-expanded', !isExpanded);
		});
	}
	
	// Close mobile menu when clicking outside
	document.addEventListener('click', function(event) {
		if (mobileNavigation && !mobileNavigation.contains(event.target) && 
		    mobileMenuToggle && !mobileMenuToggle.contains(event.target)) {
			mobileNavigation.classList.add('hidden');
			if (mobileMenuToggle) {
				mobileMenuToggle.setAttribute('aria-expanded', 'false');
			}
		}
	});
	
	// Dropdown menu handling for desktop
	const menuItems = document.querySelectorAll('.menu-item-has-children');
	menuItems.forEach(item => {
		const link = item.querySelector('a');
		const dropdown = item.querySelector('.dropdown-menu');
		
		if (link && dropdown) {
			// Close dropdown when clicking outside
			document.addEventListener('click', function(event) {
				if (!item.contains(event.target)) {
					dropdown.style.display = 'none';
				}
			});
			
			// Toggle dropdown on click (mobile)
			if (window.innerWidth < 1024) {
				link.addEventListener('click', function(e) {
					e.preventDefault();
					const isOpen = dropdown.style.display === 'block';
					dropdown.style.display = isOpen ? 'none' : 'block';
				});
			}
		}
	});
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
	anchor.addEventListener('click', function (e) {
		const href = this.getAttribute('href');
		if (href !== '#') {
			const target = document.querySelector(href);
			if (target) {
				e.preventDefault();
				target.scrollIntoView({
					behavior: 'smooth',
					block: 'start'
				});
			}
		}
	});
});

