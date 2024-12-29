import type { Config } from "tailwindcss";

export default {
  darkMode: 'selector',
  content: [
    "./public/**/*.{html,js,php}",
    "./src/templates/**/*.{html,js,php}",
    "./src/partials/**/*.{html,js,php}",
    "./node_modules/flowbite/**/*.js",
  ],
  plugins: [
    'flowbite/plugin',
  ],
} satisfies Config;
