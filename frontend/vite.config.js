import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    vueDevTools(),
  ],
  server: {
    historyApiFallback: true, // ✅ สำคัญ
    proxy: {
      '/api': {
        target: 'http://localhost:8080',
        changeOrigin: true,
        secure: false,
      },
    },
    headers: {
      'Content-Security-Policy': "script-src 'self' 'unsafe-eval';"
    }
  },
  resolve: {
    alias: {
       '@': path.resolve(__dirname, './src'),
    },
  },
})
