const { __ } = wp.i18n
const { createHigherOrderComponent } = wp.compose
const { Fragment } = wp.element
const { InspectorControls } = wp.blockEditor
const { PanelBody, ToggleControl } = wp.components

import classnames from 'classnames'

// Enable custom attributes on Image block
const enableSidebarSelectOnBlocks = ['core/group']

const setSidebarSelectAttribute = (settings, name) => {
  // Do nothing if it's another block than our defined ones.
  if (!enableSidebarSelectOnBlocks.includes(name)) {
    return settings
  }

  return Object.assign({}, settings, {
    attributes: Object.assign({}, settings.attributes, {
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
    }),
  })
}
wp.hooks.addFilter(
  'blocks.registerBlockType',
  'press-wind/set-sidebar-select-attribute',
  setSidebarSelectAttribute,
)

const withVisibility = createHigherOrderComponent((BlockEdit) => {
  return (props) => {
    // If current block is not allowed
    if (!enableSidebarSelectOnBlocks.includes(props.name)) {
      return <BlockEdit {...props} />
    }

    const { attributes, setAttributes } = props
    const { hideOnDesktop, hideOnTablet, hideOnMobile } = attributes

    return (
      <Fragment>
        <BlockEdit {...props} />
        <InspectorControls>
          <PanelBody
            icon="visibility"
            title={__('Visibility', 'block-visibility')}
          >
            <ToggleControl
              checked={hideOnDesktop}
              label={__('Hide on desktop', 'block-visibility')}
              onChange={() => setAttributes({ hideOnDesktop: !hideOnDesktop })}
            />
            <ToggleControl
              checked={hideOnTablet}
              label={__('Hide on tablet', 'block-visibility')}
              onChange={() => setAttributes({ hideOnTablet: !hideOnTablet })}
            />
            <ToggleControl
              checked={hideOnMobile}
              label={__('Hide on mobile', 'block-visibility')}
              onChange={() => setAttributes({ hideOnMobile: !hideOnMobile })}
            />
          </PanelBody>
        </InspectorControls>
      </Fragment>
    )
  }
}, 'withVisibility')

wp.hooks.addFilter(
  'editor.BlockEdit',
  'press-wind/with-visibility',
  withVisibility,
)

const saveVisibilityAttribute = (extraProps, blockType, attributes) => {
  // Do nothing if it's another block than our defined ones.
  if (enableSidebarSelectOnBlocks.includes(blockType.name)) {
    const { hideOnDesktop, hideOnTablet, hideOnMobile } = attributes
    if (hideOnDesktop || hideOnTablet || hideOnMobile) {
      extraProps.className = classnames(extraProps.className, {
        'hide-on-desktop': hideOnDesktop,
        'hide-on-tablet': hideOnTablet,
        'hide-on-mobile': hideOnMobile,
      })
    }
  }

  return extraProps
}

wp.hooks.addFilter(
  'blocks.getSaveContent.extraProps',
  'press-wind/save-visibility-attribute',
  saveVisibilityAttribute,
)
