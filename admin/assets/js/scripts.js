wp.domReady(() => {
  // exemple for add styles to block image
  // wp.blocks.registerBlockStyle('core/image', {
  //   name: 'bottom-right',
  //   label: 'Bottom Right',
  // })
  // wp.blocks.registerBlockStyle('core/image', {
  //   name: 'bottom-left',
  //   label: 'Bottom Left',
  // })
  // wp.blocks.registerBlockStyle('core/image', {
  //   name: 'center',
  //   label: 'Center',
  // })

  // sometime unregister don't work without that
  window._wpLoadBlockEditor.then(() => {
    console.log('Gutenberg ready !')
    // remove styles
    wp.blocks.unregisterBlockStyle('core/button', [
      'default',
      'fill',
      'outline',
    ])
    wp.blocks.unregisterBlockStyle('core/image', ['rounded'])
  })
})
