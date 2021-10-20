const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");

module.exports = {
  mode: "jit",

  purge: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ["Nunito", ...defaultTheme.fontFamily.sans],
        heading: ["Recoleta", ...defaultTheme.fontFamily.sans],
      },
      colors: {
        primary: colors.amber,
        gray: {
          default: "#2C1810",
        },
      },
      zIndex: {
        "-10": "-10",
      },
    },
    container: {
      center: true,
      padding: "1rem",
      screens: {
        xl: "1200px",
        "2xl": "1200px",
      },
    },
  },

  variants: {
    extend: {
      opacity: ["disabled"],
    },
  },

  plugins: [
    require("@tailwindcss/forms"),
    require("@tailwindcss/aspect-ratio"),
    require('@tailwindcss/typography'),
  ],
};
