import { resolve } from 'path'
import { defineConfig } from 'vite'
import legacy from '@vitejs/plugin-legacy'
import basicSsl from '@vitejs/plugin-basic-ssl'
import liveReload from 'vite-plugin-live-reload'
import getThemeDir from './js-helpers/getThemeDir.mjs'

// https://vitejs.dev/config/
export const viteConfig = {
  // custom cache dir for vite
  cacheDir: './node_modules/.vite/press-wind',
  // plugins : ssl, live reload, legacy
  plugins: [basicSsl(), liveReload([`${__dirname}+ "/**/*.php`]), legacy({})],
  base:
    process.env.APP_ENV === 'development'
      ? `/wp-content/themes/${getThemeDir()}/`
      : `/wp-content/themes/${getThemeDir()}/dist/`,
  root: '',
  // you can use lightningcss for minify css only if you don't use tailwindcss
  // css: {
  // 	transformer: "lightningcss",
  // 	lightningcss: {
  // 		targets: browserslistToTargets(browserslist(">= 0.25%")),
  // 	},
  // },
  build: {
    cssCodeSplit: true,
    cssMinify: 'lightningcss',
    // output dir for production build
    outDir: resolve(__dirname, 'dist'),
    emptyOutDir: true,
    // required for load assets
    manifest: true,
    rollupOptions: {
      input: resolve(__dirname, 'main.js'),
    },
  },
  server: {
    cors: true,
    strictPort: true,
    // port for dev server, you can change it if you want but you need to change the port in the function.php too
    port: 3000,
    // use ssl
    https: true,
    // hot module replacement port
    hmr: {
      protocol: 'wss',
      port: 3000,
    },
  },
}

export default defineConfig(viteConfig)
