// script.js
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.service-card').forEach((card) => {
        const button = card.querySelector('.service-card__toggle');
        const panel = card.querySelector('.service-card__details');

        if (!button || !panel) {
            return;
        }

        panel.classList.remove('is-open');
        panel.setAttribute('aria-hidden', 'true');
        button.setAttribute('aria-expanded', 'false');

        button.addEventListener('click', () => {
            const isOpen = panel.classList.toggle('is-open');
            button.setAttribute('aria-expanded', String(isOpen));
            panel.setAttribute('aria-hidden', String(!isOpen));
            button.textContent = isOpen ? 'Ocultar detalles' : 'Ver más';
        });
    });
});

