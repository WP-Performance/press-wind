import { addFilter } from '@wordpress/hooks'
import { createHigherOrderComponent } from '@wordpress/compose'
import { PanelBody, ToggleControl } from '@wordpress/components'
import { InspectorControls } from '@wordpress/block-editor'
const initExtension = () => {
  const addAttributes = (settings) => {
    console.log('hello')
    if (typeof settings.attributes !== 'undefined') {
      settings.attributes = Object.assign(settings.attributes, {
        hideOnDesktop: {
          type: 'boolean',
          default: false,
        },
        hideOnTablet: {
          type: 'boolean',
          default: false,
        },
        hideOnMobile: {
          type: 'boolean',
          default: false,
        },
      })
    }

    return settings
  }

  wp.hooks.addFilter(
    'blocks.registerBlockType',
    'press-wind/custom-attributes',
    addAttributes,
  )

  const withInspectorControl = createHigherOrderComponent((BlockEdit) => {
    console.log('hello here')
    return (props) => {
      const { attributes } = props
      const { hideOnDesktop, hideOnTablet, hideOnMobile } = attributes

      return (
        <>
          <BlockEdit {...props} />
          <InspectorControls>
            <PanelBody
              icon="visibility"
              title={__('Visibility', 'block-visibility')}
            >
              <ToggleControl
                checked={hideOnDesktop}
                label={__('Hide on desktop', 'block-visibility')}
                onChange={() =>
                  props.setAttributes({ hideOnDesktop: !hideOnDesktop })
                }
              />
              <ToggleControl
                checked={hideOnTablet}
                label={__('Hide on tablet', 'block-visibility')}
                onChange={() =>
                  props.setAttributes({ hideOnTablet: !hideOnTablet })
                }
              />
              <ToggleControl
                checked={hideOnMobile}
                label={__('Hide on mobile', 'block-visibility')}
                onChange={() =>
                  props.setAttributes({ hideOnMobile: !hideOnMobile })
                }
              />
            </PanelBody>
          </InspectorControls>
        </>
      )
    }
  }, 'withInspectorControl')

  addFilter(
    'editor.BlockEdit',
    'press-wind/with-advance-controls',
    withInspectorControl,
  )

  const addVisibilityClasses = (extraProps, blockType, attributes) => {
    const { hideOnDesktop, hideOnTablet, hideOnMobile } = attributes

    extraProps.className = classnames(extraProps.className, {
      'hide-on-desktop': hideOnDesktop,
      'hide-on-tablet': hideOnTablet,
      'hide-on-mobile': hideOnMobile,
    })

    return extraProps
  }

  addFilter(
    'blocks.getSaveContent.extraProps',
    'press-wind/add-visibility-classes',
    addVisibilityClasses,
  )
}

export default initExtension
