import getThemeDir from './js-helpers/getThemeDir.mjs'
import url from 'postcss-url'
import postcssImport from 'postcss-import'
import tailwindcss from 'tailwindcss'
import autoprefixer from 'autoprefixer'

const plug = [postcssImport, tailwindcss, autoprefixer]

// only for editor css
if (process.env.IS_EDITOR) {
  const options = {
    url: ({ url }) =>
      // replace assets base
      url.replace('/assets', `/wp-content/themes/${getThemeDir()}/assets`),
  }
  plug.push(url(options))
}

export default {
  plugins: plug,
}
