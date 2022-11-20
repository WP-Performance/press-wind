# Press Wind FSE Version

Minimal starter theme for WordPress with Tailwind CSS and Vite JS for Full Site Editing.

## 👉 [Complete documentation here](https://presswind-doc.wp-performance.com/)

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
