/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
      },
      colors: {
        primary: '#18534F',
        secondary: '#226D68',
        clear: '#ECF8F6',
        yellow: '#FEEAA1',
        orangeCustom: '#D6955B',
      },
    },
  },
  plugins: [],
}
