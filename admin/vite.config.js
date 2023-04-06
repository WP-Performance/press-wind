import { defineConfig } from 'vite'
import { resolve } from 'path'
import react from '@vitejs/plugin-react'
import viteConfig from '../vite.config'
import getThemeDir from '../inc/js-helpers/getThemeDir.js'

const viteAdminConfig = {
  ...viteConfig,
  ...{
    publicDir: false,
    cacheDir: './node_modules/.vite/press-wind-admin',
    // add react for use jsx and extends gutenberg blocks :)
    plugins: [...viteConfig.plugins, react()],
    base:
      process.env.APP_ENV === 'development'
        ? `/wp-content/themes/${getThemeDir()}/`
        : `/wp-content/themes/${getThemeDir()}/admin/dist/`,
    build: {
      ...viteConfig.build,
      ...{
        outDir: resolve(__dirname, 'dist'),
        rollupOptions: {
          input: resolve(__dirname, 'main.js'),
        },
      },
    },
    server: {
      ...viteConfig.server,
      ...{
        port: 4444,
        hmr: {
          ...viteConfig.server.hmr,
          ...{ port: 4444 },
        },
      },
    },
  },
}

export default defineConfig(viteAdminConfig)
