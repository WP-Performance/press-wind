import { resolve, sep } from 'path'
import { defineConfig } from 'vite'
import legacy from '@vitejs/plugin-legacy'
import liveReload from 'vite-plugin-live-reload'

// find theme dir name
export function getThemDir() {
  const _path = process.cwd().split(sep)
  return _path[_path.length - 1]
}

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    liveReload([
      __dirname + '/**/*.php',
      // __dirname + '/**/*.twig'
    ]),
    legacy({
      // target is default
      // targets: ['defaults', 'ie >= 11'],
      additionalLegacyPolyfills: ['regenerator-runtime/runtime'],
      polyfills: [],
      modernPolyfills: [],
    }),
  ],
  base:
    process.env.APP_ENV === 'development'
      ? `/wp-content/themes/${getThemDir()}/`
      : `/wp-content/themes/${getThemDir()}/dist/`,
  root: '',
  build: {
    // output dir for production build
    outDir: resolve(__dirname, 'dist'),
    emptyOutDir: true,
    manifest: true,
    // override by legacy plugin
    // target: 'es6',
    rollupOptions: {
      input: resolve(__dirname, 'main.js'),
    },
  },
  server: {
    cors: true,
    strictPort: true,
    port: 3000,
    https: false,
    hmr: {
      protocol: 'ws',
      port: 3000,
      // host: 'localhost',
    },
  },
})
