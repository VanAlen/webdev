/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./assets/**/*.css",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      fontFamily: {
        cactus: ['"Cactus Classical"', 'serif'],
        jacques: ['"Jacques Francois Shadow"', 'serif'],
      },
      colors: {
        forest: '#014421',
        beige: '#F5F5DC',
        cream: '#FAF3E0', 
        black: '#111111', // slightly lighter black
      },
      keyframes: {
        fadeOut: {
          '0%': { opacity: '1' },
          '100%': { opacity: '0' },
        },
      },
      animation: {
        fadeOut: 'fadeOut 0.5s ease-out forwards',
      },
    },
  },
  plugins: [
    require('tailgrids/plugin'),
  ],
};
