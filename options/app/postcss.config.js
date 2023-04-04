const { sep } = require("path");
const url = require("postcss-url");
const plug = [require("postcss-import"), require("autoprefixer")];

// find theme plugin name
function getPluginDir() {
  const _path = process.cwd().split(sep);
  return _path[_path.length - 1];
}

// only for editor css
if (process.env.IS_EDITOR) {
  const options = {
    url: ({ url }) =>
      // replace assets base
      url.replace("/assets", `/wp-content/plugins/${getPluginDir()}/assets`),
  };
  plug.push(url(options));
}

module.exports = {
  plugins: plug,
};
