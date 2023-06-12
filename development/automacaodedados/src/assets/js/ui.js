window.addEventListener('load', () => {
  let theme_toggle = document.getElementById('theme-toggle-icon');
  let site_logo = document.getElementById('site-logo');

  document.getElementById('navigation-menu-toggle').addEventListener('click', (e) => {
    e.preventDefault();

    let menu = document.getElementById('navigation-toggle-icon');
    menu.classList.toggle('navigation-menu-icon');
    menu.classList.toggle('close-icon');
    document.getElementById('main-menu').classList.toggle('hidden');
  });

  document.getElementById('theme-menu-toggle').addEventListener('click', (e) => {
    let theme = localStorage.getItem('theme');

    if (theme == 'light') {
      document.documentElement.classList.add('dark');
      site_logo.setAttribute('src', '/images/automacaodedados_logo_white.svg');
      theme_toggle.setAttribute('class', 'light-mode-icon w-7 h-7 filter invert');
      localStorage.setItem('theme', 'dark');
    } else {
      document.documentElement.classList.remove('dark');
      site_logo.setAttribute('src', '/images/automacaodedados_logo.svg');
      theme_toggle.setAttribute('class', 'dark-mode-icon w-7 h-7');
      localStorage.setItem('theme', 'light');
    }
  });

  let search_form = document.getElementsByClassName('inline-search')[0];
  let search_input = document.getElementById('q');

  search_input.addEventListener('keyup', (e) => {
    if (e.target.value.length < 3) {
      search_form.classList.add('border-primary-darker');
    } else {
      search_form.classList.remove('border-primary-darker');
      search_form.classList.add('border-blue-400');
    }
  });

  search_input.addEventListener('focus', (e) => {
    search_form.classList.add('border-primary-darker');
  });

  search_input.addEventListener('blur', (e) => {
    search_form.classList.remove('border-primary-darker');
    search_form.classList.remove('border-blue-400');
  });

  search_form.addEventListener('submit', (e) => {
    if (search_input.value.length < 3) {
      e.preventDefault();
      e.target.classList.add('border-primary-darker');
    }
  });
});
