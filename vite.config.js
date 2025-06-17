import { defineConfig } from 'vite'
import { resolve } from 'path'

export default defineConfig({
  build: {
    outDir: 'public',
    rollupOptions: {
      input: {
        charts: resolve(__dirname, 'src/js/charts.js'),
        flowbite: resolve(__dirname, 'src/js/flowbite.js'),
        sidebar: resolve(__dirname, 'src/js/sidebar.js'),
        darkmode: resolve(__dirname, 'src/js/darkmode.js'),
        bankgraph: resolve(__dirname, 'src/js/bankgraph.js'),
        yearlychart: resolve(__dirname, 'src/js/yearlychart.js'),
        transactions: resolve(__dirname, 'src/js/transactions.js'),
      },
      output: {
        entryFileNames: 'js/[name].min.js',
        name: '[name]Bundle',
        assetFileNames: (assetInfo) => {
          if (assetInfo.name.endsWith('.css')) {
            return 'styles/[name].min[extname]'
          }
          return 'assets/[name][extname]'
        },
        chunkFileNames: 'js/[name].js'
      }
    },
    emptyOutDir: false,
    copyPublicDir: false
  }
})
