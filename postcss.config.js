const { resolve, sep } = require('path')
const url = require('postcss-url')
const plug = [
  require('postcss-import'),
  require('tailwindcss'),
  require('autoprefixer'),
]

// find theme dir name
function getThemDir() {
  const _path = process.cwd().split(sep)
  return _path[_path.length - 1]
}

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
