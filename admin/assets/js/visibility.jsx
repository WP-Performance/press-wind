// const { useState, useEffect } = wp.element
const { __ } = wp.i18n
const { createHigherOrderComponent } = wp.compose
const { Fragment } = wp.element
const { InspectorControls } = wp.blockEditor
const { PanelBody, ToggleControl } = wp.components

import classnames from 'classnames'

// Enable custom attributes on Image block
const enableSidebarSelectOnBlocks = ['core/group']

let spaces = []

const callSpaces = async () => {
  if (spaces.length > 0) return spaces
  spaces = await wp.apiFetch({ path: '/patrimonia/v1/spaces' })
  return spaces
}
callSpaces()

const setSidebarSelectAttribute = (settings, name) => {
  // Do nothing if it's another block than our defined ones.
  if (!enableSidebarSelectOnBlocks.includes(name)) {
    return settings
  }

  return Object.assign({}, settings, {
    attributes: Object.assign({}, settings.attributes, {
      hideOnSpaces: {
        type: 'array',
        default: [],
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
    const { hideOnSpaces } = attributes

    // use effect bug
    callSpaces()

    return (
      <Fragment>
        <BlockEdit {...props} />
        <InspectorControls>
          <PanelBody
            icon="visibility"
            title={__('Hide on Space', 'press-wind')}
          >
            {spaces.map((space) => (
              <ToggleControl
                checked={hideOnSpaces.includes(space.id)}
                label={space.slug}
                key={space.id}
                onChange={(e) => {
                  if (e) {
                    setAttributes({ hideOnSpaces: [...hideOnSpaces, space.id] })
                  } else {
                    setAttributes({
                      hideOnSpaces: hideOnSpaces.filter(
                        (id) => id !== space.id,
                      ),
                    })
                  }
                }}
              />
            ))}
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
    const { hideOnSpaces } = attributes
    if (hideOnSpaces) {
      extraProps.className = classnames(
        extraProps.className,
        classnames(hideOnSpaces),
      )
    }
  }

  return extraProps
}

wp.hooks.addFilter(
  'blocks.getSaveContent.extraProps',
  'press-wind/save-visibility-attribute',
  saveVisibilityAttribute,
)
