import { resolve } from 'path'
import { defineConfig } from 'vite'
import legacy from '@vitejs/plugin-legacy'
import basicSsl from '@vitejs/plugin-basic-ssl'
import liveReload from 'vite-plugin-live-reload'
import getThemeDir from './inc/js-helpers/getThemeDir.js'

// https://vitejs.dev/config/
export const viteConfig = {
  cacheDir: './node_modules/.vite/press-wind',
  plugins: [
    basicSsl(),
    liveReload([
      __dirname + '/**/*.php',
      // __dirname + '/**/*.twig'
    ]),
    legacy({
      // target is default
      targets: ['defaults', 'ie >= 11'],
      additionalLegacyPolyfills: ['regenerator-runtime/runtime'],
      polyfills: [],
      modernPolyfills: [],
    }),
  ],
  base:
    process.env.APP_ENV === 'development'
      ? `/wp-content/themes/${getThemeDir()}/`
      : `/wp-content/themes/${getThemeDir()}/dist/`,
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
    https: true,
    hmr: {
      protocol: 'wss',
      port: 3000,
      // host: 'localhost',
    },
  },
}

export default defineConfig(viteConfig)
