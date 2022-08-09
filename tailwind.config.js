module.exports = {
  // use preflight (reset CSS) override fonts size from theme.json
  corePlugins: {
    preflight: false,
  },
  content: ['./**/*.{php,twig,html}', './assets/*.{js,jsx,ts,tsx,vue}'],
  safelist: [],
  theme: {
    fontFamily: {
      display: ['PlayfairDisplay'],
      body: ['Roboto'],
    },
    extend: {
      backgroundImage: (theme) => ({
        'wp-performance': "url('/assets/media/wp-performance.png')",
      }),
    },
  },
  plugins: [],
}
