/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./index.php",
    "./**.{html,js,php}",
    "./node_modules/flowbite/**/*.js",
    "./**/*.php"
  ],
  theme: {
    colors: {
      primary: "rgb(var(--color-primary)",
      secondary: "rgb(var(--color-secondary)",
    },
    extend: {
      width: {
        "300p": "300%",
      },
    },
  },
  plugins: [
    require('flowbite/plugin'),
  ],
}

