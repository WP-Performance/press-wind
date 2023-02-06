const getThemDir = require('./inc/js-helpers/getThemeDir.js')

const url = require('postcss-url')
const plug = [
  require('postcss-import'),
  require('tailwindcss'),
  require('autoprefixer'),
]

// only for editor css
if (process.env.IS_EDITOR) {
  const options = {
    url: ({ url }) =>
      // replace assets base
      url.replace('/assets', `/wp-content/themes/${getThemDir()}/assets`),
  }
  plug.push(url(options))
}

module.exports = {
  plugins: plug,
}
