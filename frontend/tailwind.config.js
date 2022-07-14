const colors = require('tailwindcss/colors')

module.exports = {
  content: [
    "./src/**/*.{js,jsx,ts,tsx}"
  ],
  theme: {
    extend: { 
      colors: {
        primary: {
          light: colors.purple[500],
          default: colors.purple[700],
          dark: colors.purple[900],
        },
        secondary: {
          light: colors.violet[500],
          default: colors.violet[700],
          dark: colors.violet[900],
        },
        bg: {
          dark: colors.gray[900],
          default: colors.white
        },
        border: colors.gray[300]
      }
    },
  },
  plugins: [],
}
