# Wordpress Privacy Policy Management Plugin

Provides a set of components to generate and embed Privacy Policies in Wordpress

## Supported Policies
* Privacy Policy
* Cookie Policy

..other coming soon.

## Features
* Gutenberg Block
* Shortcode `[svbk-policy /]`
* Policy customization with Company Name, Address, Email, etc
* Wordpress default policy page replacement
* Dynamic import from Policy Providers (in progress)

## Installation

Via Composer:

```bash
composer require silverback/svbk-wp-policy
```

## Contributions

* Clone package from the repo
* Run `npm install` to install require dependencies

### Blocks
Run `npm start` to start block compiler. When finished run `npm run build`.

### Style 
Run `npm compile:scss` to start CSS compiler. To build the production version run `npm build:scss`.

See `package.json` for available commands.

