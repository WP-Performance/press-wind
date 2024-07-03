# Press Wind FSE

Minimal starter theme for WordPress with Tailwind CSS and Vite JS for Full
Site Editing.

## Concept

This theme is build for work with gutenberg.
It's thinked for use concept of pattern.
A example of pattern is in ```patterns``` directory.
The theme.json is used for the settings of theme.
The fonts pass by the new WP font loader. Not by CSS or TailwindCSS.

## plugins required

For use ViteJS

- <https://github.com/WP-Performance/presswind-helpers>

## Plugin recommended

or disable lots of WP core functionality

- <https://github.com/WP-Performance/deaktiver>

## PHP/HTML files

This theme is developed for use Full Site Editing.

## Dependencies

- [PostCSS](https://postcss.org/)
- [TailwindCSS](https://tailwindcss.com/) - optional. You can use only postcss or lightningCSS.
- [ViteJS](https://vitejs.dev/)

## Requirement

- Node JS (>18)
- Npm, yarn, pnpm or Bun !

## Quick Start

In the root of press-wind theme

Install dependencies

```
yarn or bun install
```

In your ```wp-config.php``` file, add :

```
# for dev
define('WP_ENV', 'development');
# for production
define('WP_ENV', 'production');
```

### With Vitejs, you have a dev server include. When you change a file, the browser reload the page

## Scripts

Launch dev mode

```
yarn dev
```

Build the assets

```
yarn build
```

## Enqueue Scripts and Styles

The script and the style are automatically enqueued in theme.
Code present in functions.php

```php
/**
 * init assets front
 */
if (class_exists('PressWind\PWVite')) {

    \PressWind\PWVite::init(port: 3000, path: '');
    /**
     * init assets admin
     */
    \PressWind\PWVite::init(
        port: 4444,
        path: '/admin',
        position: 'editor',
        is_ts: false
    );
}
```

## CSS writing style

You must use ```@apply``` method for create the CSS style
It's better for reusability of your code and the readability.

Example :

```
.site-header {
  @apply flex my-4 lg:my-10 lg:items-center lg:flex-row flex-col;
}
```

**But you can use the method by the class attribute, if you prefer. Be careful
to keep maintainable project.**

## Screenshot

![https://github.com/WP-Performance/press-wind/blob/main/screenshot.png](https://github.com/WP-Performance/press-wind/blob/main/screenshot.png)
