# Press Wind

WordPress Theme base with Tailwind CSS and Vite JS.

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

## Script

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
