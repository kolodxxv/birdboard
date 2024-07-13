/** @type {import('tailwindcss').Config} */

const colors = require('tailwindcss/colors')

export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    colors: {
      'grey-light': '#F5F6F9',
      'white': colors.white,
      'grey': 'rgba(0, 0, 0, 0.4)',
      'blue': '#47cdff',
      'bg-blue': '#47cdff',
      'blue-light': '#8ae2fe',
      'red': 'rgb(255,0,0)',
    },
    boxShadow: {
      default: '0 0 5px 0 rgba(0, 0, 0, 0.08)',
    },
    extend: {},
  },
  plugins: [],
}

