(function () {
  const headerElement = document.getElementById('site-header');
  if (!headerElement) {
    return;
  }

  const basePath = document.body.dataset.basePath || '.';
  const normalizedBase = basePath.endsWith('/') ? basePath.slice(0, -1) : basePath;
  const partialPath = `${normalizedBase}/partials/header.html`;
  const navContext = document.body.dataset.navContext || '';

  fetch(partialPath)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`No se pudo cargar el encabezado: ${response.status}`);
      }
      return response.text();
    })
    .then((markup) => {
      const resolvedMarkup = markup.replace(/\{\{base\}\}/g, normalizedBase);
      headerElement.classList.add('site-header');
      headerElement.innerHTML = resolvedMarkup;

      const toggle = headerElement.querySelector('.site-nav__toggle');
      const navigation = headerElement.querySelector('.site-nav');

      if (navContext === 'admin') {
        const linksList = headerElement.querySelector('.site-nav__links');
        if (linksList) {
          const adminLinks = [
            {
              href: `${normalizedBase}/vista_admin/calendario_admin/index.php`,
              label: 'Mis citas',
            },
            {
              href: `${normalizedBase}/vista_admin/pacientes/index.php`,
              label: 'Pacientes',
            },
            {
              href: `${normalizedBase}/vista_admin/control_de_pagos/index.php`,
              label: 'Control de pagos',
            },
          ];

          adminLinks.forEach(({ href, label }) => {
            const listItem = document.createElement('li');
            const link = document.createElement('a');
            link.href = href;
            link.textContent = label;
            listItem.appendChild(link);
            linksList.appendChild(listItem);
          });
        }
      }

      if (!toggle || !navigation) {
        return;
      }

      const navigationLinks = headerElement.querySelectorAll('.site-nav a');

      const closeNavigation = () => {
        navigation.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
      };

      toggle.addEventListener('click', () => {
        const isOpen = navigation.classList.toggle('is-open');
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      });

      navigationLinks.forEach((link) => {
        link.addEventListener('click', () => {
          if (window.innerWidth < 768) {
            closeNavigation();
          }
        });
      });

      window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
          navigation.classList.remove('is-open');
          toggle.setAttribute('aria-expanded', 'false');
        }
      });
    })
    .catch((error) => {
      console.error(error);
    });
})();
