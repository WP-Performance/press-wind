const { resolve, sep } = require('path')

// find theme dir name
function getThemeDir() {
  const _path = process.cwd().split(sep)
  return _path[_path.length - 1]
}

module.exports = getThemeDir
