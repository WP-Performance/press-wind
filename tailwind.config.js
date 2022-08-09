module.exports = {
  // use preflight (reset CSS) overide font from theme
  corePlugins: {
    preflight: false,
  },
  content: ['./**/*.{php,twig,html}', './assets/*.{js,jsx,ts,tsx,vue}'],
  safelist: [],
  theme: {},
  plugins: [],
}
