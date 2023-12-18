import { defineConfig } from 'vite'
import { resolve } from 'path'
import react from '@vitejs/plugin-react'
import EnvironmentPlugin from 'vite-plugin-environment'
import viteConfig from '../vite.config'
import getThemeDir from '../js-helpers/getThemeDir.mjs'

const viteAdminConfig = {
  // vite config from frontend
  ...viteConfig,
  ...{
    // no public dir
    publicDir: false,
    // custom cache dir admin for vite
    cacheDir: './node_modules/.vite/press-wind-admin',
    plugins: [
      ...viteConfig.plugins,
      // add react for use jsx and extends gutenberg blocks :)
      react(),
      EnvironmentPlugin({ IS_GUTENBERG_PLUGIN: false }),
    ],
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
        // avoid conflict with front vite port
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
