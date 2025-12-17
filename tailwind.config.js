/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.php',
    './templates/**/*.php',
    './inc/**/*.php',
    './assets/js/**/*.js',
    './assets/js/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        'cbd-green': {
          50: '#f0f9f0',
          100: '#dcf2dc',
          200: '#bce5bc',
          300: '#8fd18f',
          400: '#5cb35c',
          500: '#3d8f3d',
          600: '#2d712d',
          700: '#255a25',
          800: '#214921',
          900: '#1d3d1d',
        },
        'cbd-natural': {
          50: '#faf8f5',
          100: '#f5f0e8',
          200: '#e9dfd0',
          300: '#d9c8b0',
          400: '#c5ab8a',
          500: '#b8946f',
          600: '#a8825f',
          700: '#8b6b4f',
          800: '#725845',
          900: '#5f4a3c',
        },
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
        serif: ['Merriweather', 'Georgia', 'serif'],
      },
      spacing: {
        '18': '4.5rem',
        '88': '22rem',
      },
    },
  },
  plugins: [],
}

