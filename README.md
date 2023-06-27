# Press Wind FSE Version

Minimal starter theme for WordPress with Tailwind CSS and Vite JS for Full Site Editing.

## 👉 [Complete documentation here](https://presswind-doc.wp-performance.com/)

## 👉 [FSE Version on this branch](https://github.com/WP-Performance/press-wind/tree/FSE)

## Concept

This theme is build for work with gutenberg.
It's thinked for use concept of pattern.
A example of pattern is in ```patterns``` directory.
The theme.json is used for the settings of theme.
The fonts pass by the new WP font loader. Not by CSS or TailwindCSS.

## PHP/HTML files

This theme is developed for use Full Site Editing.

## Dependencies

- [PostCSS](https://postcss.org/)
- [TailwindCSS](https://tailwindcss.com/)
- [ViteJS](https://vitejs.dev/)

## Requirement

- Node JS (16)
- Npm ou yarn


## config global

default values
```
return [
  // directory target for assets generated
  'iconsDir' => 'public',
  // logo source for generate icons
  // 'source' => './assets/media/icon.svg',
  // 'manifest' => [
  //   'appName' => 'PressWind',
  //   'appShortName' => 'PressWind',
  //   'appDescription' => 'Starter theme WordPress, Tailwind, ViteJS',
  //   'background' => '#fff',
  //   'theme_color' => 'rgb(190, 24, 93)',
  //   'lang' => 'fr-FR',
  // ],
  // 'disable' => [
  //   // disable rss links
  //   'rss' => true,
  //   // remove all comments views
  //   'comment' => true,
  //   // disable emojis
  //   'emoji' => true,
  //   // media page
  //   'media' => true,
  //   // disable oembed
  //   'oembed' => true,
  //   // disable xmlrpc
  //   'xmlrpc' => true,
  //   // disble rest user endpoint
  //   'rest_user' => true
  //   // disable jquery
  //   'jquery' => false
  // ]
];
```

## Quick Start

In the root of press-wind theme

Install dependencies

```
yarn
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

Launch dev mode with editor file for admin

```
yarn dev:editor
```

Build the assets

```
yarn build
```

## Enqueue Scripts and Styles

The script and the style are automatically enqueued in theme.
The "assets" code is in file : ```inc > assets.php```

## CSS writing style

You must use ```@apply``` method for create the CSS style
It's better for reusability of your code and the readability.

Example :

```
.site-header {
  @apply flex my-4 lg:my-10 lg:items-center lg:flex-row flex-col;
}
```

**But you can use the method by the class attribute, if you prefer. Be careful to keep maintainable project.**

## Disabled WP core functionality

In ```inc > disable.php```, lots of feature are disabled.
You can comment for not disable stuff for your project like you want.

## Screenshot

![https://github.com/WP-Performance/press-wind/blob/main/screenshot.png](https://github.com/WP-Performance/press-wind/blob/main/screenshot.png)
