const plugin = require('tailwindcss/plugin')

module.exports = {
  purge: {
    enabled: true, // true to remove unused classes
    content: ['layouts/**/*.html'],
    options: {
      safelist: ['dark',
      'border-blue-400',
      'light-mode-icon',
      'dark-mode-icon',
      'close-icon',
      'search-icon',
      'navigation-menu-icon',
      'invert',
      'border-primary-darker',
      'chroma',
      'lntd',
      'lntable',
      'lnt'
      ]
    }
  },
  darkMode: 'class', // or 'media' or 'class'
  theme: {
    extend: {
      fontFamily: {
        'title': ['Bungee Regular', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', '"Segoe UI"', 'Roboto', '"Helvetica Neue"', 'Arial', '"Noto Sans"', 'sans-serif', '"Apple Color Emoji"', '"Segoe UI Emoji"', '"Segoe UI Symbol"', '"Noto Color Emoji"'],
        'body': ['Montserrat Regular', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', '"Segoe UI"', 'Roboto', '"Helvetica Neue"', 'Arial', '"Noto Sans"', 'sans-serif', '"Apple Color Emoji"', '"Segoe UI Emoji"', '"Segoe UI Symbol"', '"Noto Color Emoji"'],
        'highlight': ['Montserrat Bold', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', '"Segoe UI"', 'Roboto', '"Helvetica Neue"', 'Arial', '"Noto Sans"', 'sans-serif', '"Apple Color Emoji"', '"Segoe UI Emoji"', '"Segoe UI Symbol"', '"Noto Color Emoji"']
      },
      colors: {
        'primary-lighter': '#E4629D',
        'primary': '#DB2777',
        'primary-darker': '#AE1E5F',
        'secondary-lighter': '#075E9D',
        'secondary': '#04395E',
        'secondary-darker': '#021827',
        'neutral-lighter': '#ECDAC1',
        'neutral': '#DAB785',
        'neutral-darker': '#CFA263',
      },
      margin: {
        '-1/2': '-50vw'
      }
    }
  },
  variants: {
    extend: {
      boxShadow: ['active'],
      margin: ['last'],
      padding: ['last'],
      display: ['targeted'],
      filter: ['dark'],
      invert: ['dark']
    },
  },
  plugins: [
    plugin(function({ addVariant, e }) {
      addVariant('targeted', ({ modifySelectors, separator }) => {
        modifySelectors(({ className }) => {
          return `.${e(`targeted${separator}${className}`)}:target`
        })
      })
    })
  ],
}
