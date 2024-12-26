import postcssImport from 'postcss-import';
import tailwindcss from 'tailwindcss';
import autoprefixer from 'autoprefixer';

/** @type {import('postcss-load-config').Config} */
const config = {
  plugins: [
    postcssImport,
    tailwindcss,
    autoprefixer,
  ],
};

export default config;
