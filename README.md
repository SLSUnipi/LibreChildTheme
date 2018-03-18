# Libre Theme
This is a child theme based on Bootstrap 4, and Understrap wordpress starter theme, that we will use for our website

## How to use this child theme.
Since its a child theme of Understrap:
1) you need to have the understrap theme installed on your wordpress installation.
then...
2) just clone the repo into the wp-content/themes directory, or downloand it as a zip and add it through wordpress.

You can find Understrap here
[1] https://understrap.com/
...or search it and  install it directly through wordpress themes.

## How to modify this theme.
Since this is a child theme of Understrap it uses the understrap's official child template, and has some development dependancies that are not included into the repo. therefore after you clone the repo you need to 

1) have installed NodeJS, npm, gulp (the latest two are using NodeJS), we use npm to manage our development dependancies, and gulp to compile sass files into css and other utilities.

2) switch to the theme's directory and run 
 `$ npm install`to install dependancies and after that run 
 `$ gulp copy-assets` to load the configurations to gulp 
 `$ gulp watch` to track changes on sass files, and automatically recompile and minify/unglify them.

3) You add sass styles at `sass/theme/` ,
modify  `_child_theme_variables.scss` to overwrite bootstrap's global variables. [2]
add your own sass styles on `_child_theme.scss`.
your changes will recompile the `css/child-theme.css` and `css/child-theme.min.css` appropriately. the latest is what is the final stylesheet that its loaded.

More on bootstrap theming
[2] https://getbootstrap.com/docs/4.0/getting-started/theming/

## Why Understrap.
Understrap provides an out-of-the-box development enviroment using the latest standarts. It is also a bootstrap 4 theme, which means it comes with all the Bootstrap goodies (and we love Bootstrap goodies :) ) . What is more, by being a starter theme means it provides basic utilities and basic boilerplate setup and a basic starter layout, without getting in your way. What is more we chose to make it into a child theme in order to get any updates of Understrap.

Finally it is completely open source.

more on the Understrap Project
https://github.com/understrap

