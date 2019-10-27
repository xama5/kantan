# Kantan - Simple and easy WordPress Starter Theme

Modern web development with WordPress is too complicated ... let's simplify it!

<img src="screenshot.png" alt="kantan" width="400">

## Features

- Blade templates
  - Create template files with blade (DRY)
  - Create Gutenberg blocks with ACF and blade templates
- **NO** local dveelopment environment needed
- Edit the theme directly with the theme editor from WordPress
- Use SASS, JS, and further supported file types and let your WordPress compile them on the fly! (similar to how Shopify does it)
- Simple to understand
- [Sage](https://github.com/roots/sage) like environment
- Automatic enable/disable of plugins on different environments
- Tons of optimizations for WordPress; for having a smoother and faster experience
- Simple and intuitive to use, even my grandma could do it.

## Installation

Grab a pre-packaged release under the Release tab of GitHub and basically extract it directly into your /wp-content/themes folder.

## Getting started

The theme layout is basically the same as a Shopify theme. For more info click [here](https://help.shopify.com/en/themes/development/templates).

It is designed to be edited directly in the theme editor of WordPress. Yes, you read that right.

You'll see the following folder structure in the theme editor:

- /Assets (put here your .scss, .js, etc)
- /Blocks (Custom blocks for Gutenberg made with ACF)
- /Config (you'll hardly ever need to edit the configuration, we might move this folder to a different directory later)
- /Functions (any filters, functions, theme supports, etc. you may have)
- /Layout (this defines the outer structure of your page.)
- /Locales (any .mo, .po language files)
- /Snippets (partial blade templates for use in templates)
- /Templates (template files you know and love from WordPress)

As you noticed, we're using Blade templates.

### Optimizations

There are pre-packaged plugins with this theme. Most are required, but some are optional. **This theme is designed to be used as a starter theme on a __fresh__ WordPress installation.**

However, you can choose if you want to install them or not. There are also a bunch of constants you can define to disable certain optimizations.

#### SEO

- Yoast SEO
- Disable Attachment Pages by LittleBizzy
- Disable Author Pages by LittleBizzy

#### Performance

- W3 Total Cache (only production)
- Dashboard Cleanup by LittleBizzy
- Delete Expired Transients by LittleBizzy
- Disable Emojis by LittleBizzy
- Disable jQuery Migrate by LittleBizzy (heads up! this might cause issues with older plugins, disable it in this case)
- Soil by Roots
- Header Cleanup by LittleBizzy
- Database speedup with Indices by LittleBizzy
- Limit Heartbeat by LittleBizzy

#### Security

- Disable Post by E-Mail by LittleBizzy
- Disable XML RPC by LittleBizzy
- WordFence (only production)

#### Misc

- Download Theme as ZIP by LittleBizzy


### Resources

- This theme is based on Sage, head over to their documentation for advanced usage: https://roots.io/sage/docs
- Here's a complete reference to plugins of LittleBizzy https://www.littlebizzy.com/plugins

## Main principles

### Decisions, not options

More flexibility means development gets more complicated. Why should we develop tens of components, which probably never get used anyway? Why should we think of thousands of scenarios a user will be using the CMS?

This boilerplate ships with the bare minimum (in terms of functionality), to allow better performance and usability.

### To Gutenberg or not to Gutenberg

The Gutenberg editor will be used in the following scenarios:

- Blog posts

It will **not** be used in these cases:

- Regular pages
- Most post types (e.g. post types for a team)

Repeated content is generally to be placed in a custom post type. There's no point in building a team site using a block editor (such as Gutenberg, Visual Composer, etc.)
Why? Imagine you're building a team page, and decide to use the same layout in a different place on your site. The day comes when you want to adjust the layout, and it isn't easily doable in plain CSS. You maybe start fidling around with jQuery and your content starts to flicker. Just to avoid having to repeat yourself in adjusting the layout in the block editor. There's a reason there are template files, and with using a block editor for everything - they become redundant.

### Performance

The modern WordPress is bloated with stuff to accomadate most users. However, many features aren't used by many users. Almost like a paradox. Thus, the site becomes more slow. (example: emojis, meta tags, ...)

This boilerplate disables these features, and allows the user to re-enable them if they really need them.

### Simplicity

Modern web development requires a local environment, including webpack, npm/yarn, composer, and tons of libraries. On top of that, you're probably using Bedrock with Trellis/Capistrano/Deployer. Sure, developers are optimizing their code (including libraries and assets) by using a builder like webpack, and using a deployment solution definitely reduces possible downtime. But is this really "simple"? Once you get used to it, it seemingly isn't that bad, is it? Imagine you're building inexpensive websites for clients, do you really have the time to waste with this huge development environment? You might be tempted to use a theme with visual composer, throw some elements together and call it a day. But the result is a hardly maintable site, which is also performance-wise terrible.
Think of updates. They're critical for WordPress, do you really have time and motivation to update dozens of websites for clients if you're using Capistrano (or similar)? On average, you're spending about 5-10 minutes updating a bedrock site. Why not automate WordPress updates with ManageWP? Right, you can't. Capistrano doesn't work like that.
Sure you can use the more complicated approach for bigger sites, but it usually pays better too.

The boilerplate should allow you to make most changes directly on the site, even without using a local development environment. But still you should be able to use SCSS, JS minifiers, etc. Or do you want to mess around with plain CSS? I don't think so either. You should be able to update the site easily (maybe by also using something like ManageWP), or even use tools to move a site between different environments. (live, staging, local)

## Contribution

Asking questions is encouraged with GitHub Issues. Whenever a question comes up, the issue lies in lacking documentation. However, it is expected from the users to take a look at the documentation first before asking a question.

Pull requests are welcome as well, but should clearly indicate the benefits of being merged.
