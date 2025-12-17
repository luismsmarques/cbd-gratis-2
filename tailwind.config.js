/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.php',
    './templates/**/*.php',
    './inc/**/*.php',
    './assets/js/**/*.js',
    './assets/js/**/*.vue',
    // Include WordPress admin files if they use Tailwind classes
    './**/*.php',
  ],
  // Safelist only critical classes that might be dynamically generated
  // This prevents removing classes that are essential but not detected by content scan
  safelist: [
    // Critical layout classes
    'container',
    'mx-auto',
    'max-w-4xl',
    'max-w-2xl',
    'max-w-3xl',
    // Critical flex/grid utilities
    'flex',
    'grid',
    'hidden',
    'items-center',
    'justify-between',
    // Critical spacing (only most used)
    'px-4',
    'py-2',
    'py-4',
    'mb-4',
    'mb-6',
    'mb-8',
    // Critical colors
    'bg-white',
    'bg-gray-50',
    'text-gray-600',
    'text-gray-700',
    'text-gray-900',
    'text-cbd-green-600',
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
        // Using system fonts only to prevent FOUT (Flash of Unstyled Text)
        // If custom fonts are needed, load them with font-display: swap
        sans: ['-apple-system', 'BlinkMacSystemFont', '"Segoe UI"', 'Roboto', '"Helvetica Neue"', 'Arial', 'sans-serif'],
        serif: ['Georgia', '"Times New Roman"', 'Times', 'serif'],
      },
      spacing: {
        '18': '4.5rem',
        '88': '22rem',
      },
    },
  },
  plugins: [],
  // Enable JIT mode for better performance and smaller output
  // This is default in Tailwind 3, but explicit is better
  corePlugins: {
    // Disable unused core plugins to reduce CSS size
    // Uncomment if you don't use these features:
    // preflight: true, // Keep preflight (base styles)
    // container: true, // Keep container
  },
}

