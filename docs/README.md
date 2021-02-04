# Kantan - Simple and easy WordPress Starter Theme

Modern web development with WordPress is too complicated ... let's simplify it!

<img src="../screenshot.png" alt="kantan" width="400">

## Features

- Blade templates
  - Create template files with blade
  - Create Gutenberg blocks with ACF and blade templates
- Directly edit and let your webserver compile on the fly:
  - SCSS/SASS (autoprefix, compile to css, minify)
  - JS (minify)
- Combined JS and CSS: all assets are combined into a single file. (plugins included)

## Installation

You can either download the source code as ZIP or download kantan.zip from releases.
Either zip can be directly installed, no composer needed, as all dependencies are bundled.

## Getting started

Since this is a starter theme, you don't have to worry about updates. Simply start adding templates you need, and code away!

This is perfect if you want to upload your files via (S)FTP.

The repository contains the bare minimum to run a theme, inside functions.php you'll find that we preloaded a main.js and style.scss.

If you decide to use the on-the-fly compilation feature of kantan, you do not need to set up your local environment to compile your assets, kantan will do this for you on the webserver. Simply upload the updated style.scss and changes are detected automatically.
You can also use the theme editor of wordpress to make changes to the .scss files, those will be detected as well.

Prefer to compile your assets locally and upload them yourself? No problem, just remove `define('KANTAN_ENABLE_COMPILER', true);` from the functions file. Or set the constant to `false`.
Remember to adjust the paths too. The .scss extension only works if you enabled the compiler.

### Optimization considerations

This theme will combine all resources in a single file (if the compiler is enabled), however, there are more optimizations one can do. Here are some recommendations from our side:

#### SEO

- RankMath
- **Avoid** Yoast - as of now, yoast considerably slows down wordpress

#### Caching

- Fastest Cache
- W3 Total Cache

#### Theme tweaks

- Soil (move js to footer is NOT supported, as kantan already does this for you)
- Disable emojis
- Disable jquery migrate (and jquery if you don't need it)

#### Security

- WordFence

### Resources

- This theme is based on Sage, head over to their documentation for advanced usage: https://roots.io/sage/docs
- Here's a complete reference to plugins of LittleBizzy https://www.littlebizzy.com/plugins

## Main principles

### Decisions, not options

More flexibility means development gets more complicated. Why should we develop tens of components, which probably never get used anyway? Why should we think of thousands of scenarios a user will be using the CMS?

This boilerplate ships with the bare minimum (in terms of functionality), to allow better performance and usability.

### To Gutenberg or not to Gutenberg

The Gutenberg editor can be used in the following scenarios:

- Blog posts

It should **not** be used in these cases:

- Regular pages
- Most post types (e.g. post types for a team)

Repeated content is generally to be placed in a custom post type. There's no point in building a team site using a block editor (such as Gutenberg, Visual Composer, etc.)
Why? Imagine you're building a team page, and decide to use the same layout in a different place on your site. The day comes when you want to adjust the layout, and it isn't easily doable in plain CSS. You maybe start fidling around with jQuery and your content starts to flicker. Just to avoid having to repeat yourself in adjusting the layout in the block editor. There's a reason there are template files, and with using a block editor for everything - they become redundant.

### Simplicity

Modern web development requires a local environment, including webpack, npm/yarn, composer, and tons of libraries. On top of that, you're probably using Bedrock with Trellis/Capistrano/Deployer. Sure, developers are optimizing their code (including libraries and assets) by using a builder like webpack, and using a deployment solution definitely reduces possible downtime. But is this really "simple"? Once you get used to it, it seemingly isn't that bad, is it? Imagine you're building inexpensive websites for clients, do you really have the time to waste with this huge development environment? You might be tempted to use a theme with visual composer, throw some elements together and call it a day. But the result is a hardly maintable site, which is also performance-wise terrible.
Think of updates. They're critical for WordPress, do you really have time and motivation to update dozens of websites for clients if you're using Capistrano (or similar)? On average, you're spending about 5-10 minutes updating a bedrock site. Why not automate WordPress updates with ManageWP? Right, you can't. Capistrano doesn't work like that.
Sure you can use the more complicated approach for bigger sites, but it usually pays better too.

The boilerplate should allow you to make most changes directly on the site, even without using a local development environment. But still you should be able to use SCSS, JS minifiers, etc. Or do you want to mess around with plain CSS? I don't think so either. You should be able to update the site easily (maybe by also using something like ManageWP), or even use tools to move a site between different environments. (live, staging, local)

## Contribution

Asking questions is encouraged with GitHub Issues. Whenever a question comes up, the issue lies in lacking documentation. However, it is expected from the users to take a look at the documentation first before asking a question.

Pull requests are welcome as well, but should clearly indicate the benefits of being merged.
