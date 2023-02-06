import { defineConfig } from 'vite'
import { resolve } from 'path'
import viteConfig from '../vite.config'
import getThemeDir from '../helpers/getThemeDir.js'

const viteAdminConfig = {
  ...viteConfig,
  ...{
    base:
      process.env.APP_ENV === 'development'
        ? `/wp-content/themes/${getThemeDir()}/admin/`
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
