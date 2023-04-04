import { resolve, sep } from 'path'
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
// import legacy from '@vitejs/plugin-legacy'
import liveReload from 'vite-plugin-live-reload'

// find theme plugin name
export function getDir() {
  const _path = process.cwd().split(sep)
  // get the last part of the path after 'wp-content'
  const spl = _path.splice(_path.indexOf('wp-content') + 1)
  return spl.join(sep)
}

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    liveReload([
      __dirname + '/**/*.php',
      // __dirname + '/**/*.twig'
    ]),
    // legacy({
    //   targets: ['defaults'],
    //   additionalLegacyPolyfills: ['regenerator-runtime/runtime'],
    //   polyfills: [],
    //   modernPolyfills: [],
    // }),
  ],
  base:
    process.env.APP_ENV === 'development'
      ? `/wp-content/${getDir()}/`
      : `/wp-content/${getDir()}/`,
  root: '',
  build: {
    // output dir for production build
    outDir: resolve(__dirname, 'dist'),
    emptyOutDir: true,
    manifest: true,
    target: 'es6',
    rollupOptions: {
      input: resolve(__dirname, 'main.js'),
    },
  },
  optimizeDeps: {
    // exclude: ['vue'],
  },
  server: {
    cors: true,
    strictPort: true,
    port: 8888,
    https: false,
    hmr: {
      protocol: 'ws',
      port: 8888,
      // host: 'localhost',
    },
  },
})
