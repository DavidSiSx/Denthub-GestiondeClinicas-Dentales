// script.js
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.btn-ver-mas');

    buttons.forEach(button => {
        const target = document.getElementById(button.getAttribute('data-target'));
        target.style.display = 'none'; // Ensure the details are hidden by default

        button.addEventListener('click', () => {
            if (target.style.display === 'none' || target.style.display === '') {
                target.style.display = 'block';
                button.textContent = 'Ocultar';
            } else {
                target.style.display = 'none';
                button.textContent = 'Ver más';
            }
        });
    });
});