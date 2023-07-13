import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  server: {
    host: true,
    port: 8000,

    // add the next lines if you're using windows and hot reload doesn't work
    watch: {
      usePolling: true
    }
  },
})