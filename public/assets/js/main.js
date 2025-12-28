/**
 * Global Password Visibility Toggle
 * Toggles the type of the password input and the icon
 */
function togglePasswordVisibility(iconElement) {
    console.log('Password toggle clicked:', iconElement);
    try {
        const wrapper = iconElement.closest('.password-wrapper');
        if (!wrapper) {
            console.error('Password wrapper not found!');
            return;
        }

        const input = wrapper.querySelector('input');
        if (!input) {
            console.error('Password input not found inside wrapper!');
            return;
        }

        if (input.type === 'password') {
            input.type = 'text';
            iconElement.classList.replace('fa-eye', 'fa-eye-slash');
            console.log('Password visible');
        } else {
            input.type = 'password';
            iconElement.classList.replace('fa-eye-slash', 'fa-eye');
            console.log('Password hidden');
        }
    } catch (err) {
        console.error('Error toggling password visibility:', err);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    console.log('LibyanJobs main.js loaded');

    // Hero Glow Effect
    const heroSection = document.querySelector('.hero-section');
    const heroGlow = document.querySelector('.hero-glow');

    if (heroSection && heroGlow) {
        heroSection.addEventListener('mousemove', (e) => {
            const rect = heroSection.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            heroGlow.style.left = `${x}px`;
            heroGlow.style.top = `${y}px`;
            heroGlow.style.opacity = '1';
        });

        heroSection.addEventListener('mouseleave', () => {
            heroGlow.style.opacity = '0';
        });
    }

    // Filter Dropdown Logic
    const filterBtn = document.getElementById('filterBtn');
    const filterDropdown = document.getElementById('filterDropdown');

    if (filterBtn && filterDropdown) {
        filterBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            filterDropdown.classList.toggle('show');
        });

        // Apply Button Logic
        const applyBtn = document.getElementById('applyFiltersBtn');
        if (applyBtn) {
            applyBtn.addEventListener('click', (e) => {
                e.preventDefault();
                const form = applyBtn.closest('form');
                if (form) form.submit();
                filterDropdown.classList.remove('show');
            });
        }

        // Auto-Submit Logic
        const autoSubmitElements = document.querySelectorAll('.auto-submit');
        autoSubmitElements.forEach(el => {
            el.addEventListener('change', () => {
                const form = el.closest('form');
                if (form) form.submit();
            });
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (!filterBtn.contains(e.target) && !filterDropdown.contains(e.target)) {
                filterDropdown.classList.remove('show');
            }
        });
    }
});
