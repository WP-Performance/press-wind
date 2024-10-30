// block extensions example
import './exemple-visibility'

wp.domReady(() => {
  // exemple for add styles to block image
  // wp.blocks.registerBlockStyle('core/image', {
  //   name: 'bottom-right',
  //   label: 'Bottom Right',
  // })
  // unregister round button style
  wp.blocks.unregisterBlockStyle('core/button', 'rounded')

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
    initExtension()
    // remove styles
    // wp.blocks.unregisterBlockStyle('core/button', [
    //   'default',
    //   'fill',
    //   'outline',
    // ])
    wp.blocks.unregisterBlockStyle('core/image', ['default', 'rounded'])
  })
})
