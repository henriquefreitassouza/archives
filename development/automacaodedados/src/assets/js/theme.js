let theme_toggle = document.getElementById('theme-toggle-icon');
let site_logo = document.getElementById('site-logo');

if (localStorage.getItem('theme') == 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
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
