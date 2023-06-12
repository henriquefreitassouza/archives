---
title: 'Automatic workflow to develop plugins and themes for WordPress'
author: henriquesouza
publishDate: 2018-09-15 16:29:00
lastMod: 2021-11-12 16:29:00
summary: A good workflow can reduce hours with project maintenance in WordPress. This post will present one possible way to organize a project using templates and Gulp, a task runner.
description: 'Automatic workflow to develop plugins and themes for WordPress'
image_description: 'Open terminal running Gulp tasks and, on the right side, WordPress logo.'
categories:
- Development
featured: true
---

Published on September 15, 2018 and updated on November 12, 2021.

Updates November 12, 2021:

- By the time this post was updated, the most recent stable version of WordPress is 5.8.2. Starting from version 5, the default page editor in WordPress is Gutenberg;
- Gulp tasks are now declared using the command exports, available on Javascript ES6. Tasks are functions declared with a callback passed as a parameter. This callback is a function that, when invoked, send Gulp a signal to mark the task as finished. This is done so the functions serial and parallel work properly. Those functions manage the execution of multiple tasks, which can be done sequentially or simultaneous. Using the method task is now discouraged.

**SPOILER ALERT: this post contains lines of code! I'll assume that you're familiar with software development in WordPress, know how to use Node Package Manager (NPM) and know about task runners.**

If there is one thing that have no apparent "one size fits all" solution, ({{< anchor href="https://developer.wordpress.org/themes/basics/organizing-theme-files/" target="_blank" >}}or maybe have, to some extent{{< /anchor >}}) is to organize the development of WordPress themes and plugins. There are at least dozens of possible ways to organize files for production. I'll explain here the way I usually organize project files, something that I believe it is fundamental to create a default deployment process, to ease communication with all developers and to maintain the project in the future.

I'll split the subject into the following topics:

- Download and installation of plugin and theme boilerplates;
- Creating project files and folders;
- Creating project packages using Node Package Manager (NPM);
- Download Gulp and project dependencies;
- Setting up tasks to compile all files and generate deploy verions.

## WordPress maintenance

Keep WordPress updated and with no errors is quite complicated. This is because many components are developed by different people, independent from one another, and available for download as plugins and themes. In order to make the entire ecosystem consistent, {{< anchor href="https://automattic.com/" target="_blank" >}}Automattic{{< /anchor >}} enforces a series of rules when creating {{< anchor href="https://developer.wordpress.org/themes/release/theme-review-guidelines/" target="_blank" >}}themes{{< /anchor >}} and {{< anchor href="https://developer.wordpress.org/plugins/wordpress-org/detailed-plugin-guidelines/" target="_blank" >}}plugins{{< /anchor >}} which must be followed before being submitted to the respository at {{< anchor href="https://wordpress.org/themes/" target="_blank" >}}WordPress.org{{< /anchor >}}. This helps, but plugins and themes can still be created using technologies that aren't compatible with one another, creating conflicting dependencies. I had the experience of creating a plugin that worked fine with all WordPress versions that made use of the default editor, {{< anchor href="https://codex.wordpress.org/TinyMCE" target="_blank" >}}TinyMCE{{< /anchor >}} (all up to 3.1), but breaks when installing {{< anchor href="https://wordpress.org/gutenberg/" target="_blank" >}}Gutenberg{{< /anchor >}} and using {{< anchor href="https://developer.wordpress.org/rest-api/" target="_blank" >}}WP REST API{{< /anchor >}} with Javascript at the same time.

To avoid incompatibility issues, I usually try to figure out what plugins will be required for the project. I don't specify a magic number, but try to go for the least amount of dependencies. Having understood what is that will be required and what will be developed, its time to setup a boilerplate for each plugin and theme.

## Boilerplates

I never begin developing a plugin or theme from scratch. I'll always start from a pre defined structure called boilerplate: a organization of files and folders not unlike something that would be adopted for modern software development, but that also follows Automattic's rules to publish the work on the official repositories. There are boilerplates for themes and plugins.

## Theme boilerplate

{{< image src="images/figure1-underscores-website.webp" alt="Underscores home page with advanced options being displayed." caption="Underscores home page with advanced options being displayed. Source: Author." title="Underscores home page with advanced options being displayed." lazy="true" >}}

Automattic itself, under its {{< anchor href="https://themeshaper.com/" target="_blank" >}}theme development department{{< /anchor >}}, provide a boilerplate, called _s ({{< anchor href="https://underscores.me/" target="_blank" >}}Underscores{{< /anchor >}}). Upon opening Underscores website, just write the name of the theme and hit "Generate". A zipped file will be downloaded into your machine. By uploading this file into the themes folder of your WordPress installation, which can be done by on theme manager at the administrative panel or by copying and pasting the unzipped folder into wp-content/themes (or the default themes directory), the new theme will be installed at WordPress. This boilerplate not only speeds up the process of setting up some files like functions.php or style.css, but also creates some other .php files with separate responsibilities to ease both understanding and maintaining the project.

Below the theme name input there is a link to show advanced options. Hitting this link will show additional options to customize the theme, such as a slug to identify the theme, as well as information about the author a description. You can also create a boilerplate ready to work with {{< anchor href="https://woocommerce.com/" target="_blank" >}}WooCommerce{{< /anchor >}} and build a boilerplate that use Sass as the CSS pre processor.

{{< image src="images/figure2-underscores-project-structure.webp" alt="Files and folders at the root of Underscores boilerplate with _sassify! selected." caption="Files and folders at the root of Underscores boilerplate with _sassify! selected. Source: Author." title="Files and folders at the root of Underscores boilerplate with _sassify! selected." lazy="true" >}}

All themes requires two files to work: functions.php and style.css. These two were already created, along with others to render pages such as search results, blog posts and headers and footer for the entire website. Some features were already created on different files and referenced on functions.php. All files that are loaded on functions.php were created inside **inc**. There is a **js** folder with some default scripts to include accessibility, mobile navigation and load some {{< anchor href="https://developer.wordpress.org/themes/customize-api/" target="_blank" >}}Customizer{{< /anchor >}} features. The folder **languages** stores translation files, **layouts** contains style sheets and currently have two CSS files to style the main area and a sidebar. Folder **sass** was included when selecting _sassify! and includes .scss files with reset styles and default styles for elements like buttons. The last folder, **template-parts** house templates for pages such as posts, page not found and search results.

The content within these folders are referenced by files that are on the root folder of the theme. The following files include resources from template-parts to render the final pages:

- archive.php;
- index.php;
- page.php;
- search.php;
- single.php.

Files header.php and footer.php build the default header and footer, shown on all pages. Screenshot.php is a thumbnail image that is show on the theme management section of the administrative panel. The default image that is downloaded with the boilerplate is transparent and its dimensions are 1200 x 900 pixels.

## Plugin boilerplate

{{< image src="images/figure3-plugin-boilerplate-generator.webp" alt="Boilerplate wppb home page." caption="Boilerplate wppb home page. Source: Author." title="Boilerplate wppb home page." lazy="true" >}}

Just like themes, plugins also have boilerplates. The most used was created in 2011 by developer {{< anchor href="https://github.com/tommcfarlin/" target="_blank" >}}Tom McFarlin{{< /anchor >}}, currently maintained by {{< anchor href="https://github.com/DevinVinson/" target="_blank" >}}Devin Vinson{{< /anchor >}}. This boilerplate is {{< anchor href="https://github.com/DevinVinson/WordPress-Plugin-Boilerplate" target="_blank" >}}hosted on Github{{< /anchor >}} and it is used as a template for online boilerplate generators, which works similarly to Underscores. One of these boilerplates is {{< anchor href="https://wppb.me/" target="_blank" >}}WordPress Plugin Boilerplate Generator, or wppb{{< /anchor >}} maintained by developer {{< anchor href="https://enriquechavez.co/" target="_blank" >}}Enrique Chávez{{< /anchor >}}, supported by Devin Vinson.

Upon filling all required information and hitting "Build Plugin", a zipped file will be downloaded into your machine.

{{< image src="images/figure4-plugin-boilerplate-folder-structure.webp" alt="Files and folders at the root section of the boilerplate plugin structure." caption="Files and folders at the root section of the boilerplate plugin structure. Source: Author." title="Files and folders at the root section of the boilerplate plugin structure." lazy="true" >}}

This plugin is ready to be installed on WordPress by uploading it using the administrative panel or by copying and pasting the unzipped files to wp-content/plugins (or the default plugin directory).

A plugin needs two things to be recognized as a plugin: a .php file with a comment and {{< anchor href="https://developer.wordpress.org/plugins/hooks/" target="_blank" >}}hooks{{< /anchor >}} that connect it to the Core. The boilerplate already took care of this and provided several folders and files to organize the plugin. Files that will be used on the administrative panel and the front end are inside **admin** and **public**, respectively. All configuration options and hooks are created inside **includes**, and translation files are stored inside **languages**.

Each boilerplate generated on wppb will create a file named after the given slug identifier. This file declares on its header all information that will be presented in the administrative panel. Description is a field to describe what the plugin does and how to use it. The root also contains a index.php with no content and a uninstall.php, which can be used to configure tasks to be done when uninstalling the plugin.

Although this boilerplate have many configurations out of the box, we still have to edit some files. We'll be working with five files to build the features:

- **class-plugin-name.php**, inside includes. This file manage all hooks and functions created on other configuration files;
- **class-plugin-name-admin.php**, inside admin. This file contains all functions that will configure the plugin in the administrative panel;
- **plugin-name-admin-display.php**, inside admin/partials. This file renders HTML inside the administrative panel;
- **class-plugin-name-public.php**, inside public. This file contains all functions that will be executed on the front end;
- **plugin-name-public-display.php**, inside public/partials. This file render HTML on the front end.

Where "plugin-name" is the name given on slug when creating the boilerplate using wppb.

## Before moving on, a word on boilerplates

Boilerplates can be very useful to quickly initiate a project, since basic setup is done and is recognized by WordPress without a single line of code. However, they are built focusing on the development and maintenance of complex projects with many features. For simple plugins and themes, a boilerplate may not be that useful. For plugins and themes that also use CSS frameworks, the default organization for styles may not be the most adequate. It is up to the developer to use a boilerplate or not and also if it makes sense to use the default structure.

## Organizing a new project

Usually when developing a WordPress theme, developers will create personalized posts, templates and taxonomies. This can be done in multiple ways:

- Adding all custom functionality in functions.php;
- Creating a plugin that will add all custom functionality to the theme.

Both approaches have their pros and cons, and there is not single way to do it. This is another development decision. I usually create a plugin that will add extra functionality to the theme. I like this approach, as I can separate concerns when working with themes and plugins, and no content will be lost when switching themes. Following this approach, it is necessary to ensure that the plugin will be compatible with new themes.

To organize the workspace, I start by creating a folder that will store all plugins and themes being developed for any given company. Inside this folder I create a folder with the name of the plugin and then two others, one called plugins and the other called themes. Inside plugins, two more folders are created: one called **src** and one called **dist**. The folder src will host development files while dist will contain files that are ready to be deployed. All files that were creating using the boilerplate generator will be stored on src. The same basic structure is applied to the themes folder, in which I create both folders src and dist and copy all theme boilerplate files into src. The following structure will be in place:

{{< highlight bash >}}
company-name/
company-name/plugins/
company-name/plugins/plugin-name/
company-name/plugins/plugin-name/src/
company-name/plugins/plugin-name/dist/
company-name/themes/
company-name/themes/theme-name/
company-name/themes/theme-name/src/
company-name/themes/theme-name/dist/
{{< /highlight >}}

Where company-name is the name of the company for which plugins and themes will be developed, plugin-name is the name of the plugin and theme-name is the name of the theme.

## NPM and Gulp: automating file preparation tasks

To reduce the final size of plugins and themes, I usually do the following:

- Concatenate similar files into one to reduce the amount of requests whenever possible;
- Remove all white spaces and line breaks from scripts and style sheets;
- Lower the quality of images to reduce file sizes;
- Load vendor libraries into the project;
- Compile .scss files into .css ones.

Doing each one of those tasks manually can take a considerable amount of time. This is why I use {{< anchor href="https://gulpjs.com/" target="_blank" >}}Gulp{{< /anchor >}} to automate them. Gulp is a task runner and it is designed to automate common tasks that are not related to software development, so the developer can focus on coding. Gulp is available as a package at {{< anchor href="https://www.npmjs.com/" target="_blank" >}}Node Package Manager, or NPM{{< /anchor >}}. NPM is a package manager with many open source libraries available to use. NPM, in turn, is the package manager that run with {{< anchor href="https://nodejs.org/" target="_blank" >}}Node.js{{< /anchor >}}, a Javascript server. In order to install Gulp it is necessary to have NPM installed, which in turn requires Node.js. Upon downloading and installing Node.js in your machine, NPM will be installed automatically.

Once the folder structure is ready, I create a new package for each folder named theme-name and plugin-name. To do that, I open a terminal, navigate to each directory and execute the following command:

{{< highlight bash >}}
npm init
{{< /highlight >}}

{{< image src="images/figure5-npm-init.webp" alt="Creating a new package inside plugin folder." caption="Creating a new package inside plugin folder. Source: Author." title="Creating a new package inside plugin folder." lazy="true" >}}

This command will ask for some information about the package. A file called package.json is created once the package is configured. This file specify all dependencies that this package -- the plugin or theme -- have. By now there is no dependency, but as new packages get installed, they will appear inside this file as dependencies for the project. I've started by creating a package inside the plugins folder, but there is no right order. After repeating the previous steps to create a package inside the theme folder, a package.json will be available in this folder as well. I create a package for each theme and plugin that will be developed for the company, this being done so each project is managed independently from one another.

The next step is to install Gulp, which can be done with the following command:

{{< highlight bash >}}
npm install --g gulp-cli
npm install --save-dev gulp
{{< /highlight >}}

Gulp was installed using the flag -\-g, which instructs NPM to install this package globally. Since Gulp have a command line interface, the installation is done globally so Gulp executable is installed in a directory that is already listed on the PATH variable, which allows Gulp to be called from a command line in any directory.

Note that a new folder was created in the same directory in which folder src and dist were created previously. This folder is called **node_modules** and contains all dependencies not only from the package that we're developing, but from all packages that are being used. If, for instance, this package is dependent of a package A and this package A also depends from a package B, both packages will be listed on node_modules. Also note that Gulp was downloaded using the flag -\-save-dev, which marks this package as being a development dependency, not being necessary for end users. This prevents this package from being bundled with production files, and differentiate development and production projects. NPM have at least three scopes to manage packages:

- **Global**: global packages can be referenced on all projects;
- **Local**: this is the default scope when running npm install;
- **Development**: this is the scope set when using the flag -\-save-dev. Packages marked as development dependencies are used only during development. Other people that make use of this package downloading it by running npm install will not download packages listed as development dependencies. Packages marked with -\-save-dev will have a dedicated section on package.json.

Gulp and any other package should be installed for each plugin and theme. The command line interface is installed only once.

## Gulpfile.js configuration

In order to run, Gulp needs one file called gulpfile.js. This file will contain all tasks that Gulp will run when project files are modified and it should be located in the root of the project, which in this case is are the folders that house the directories src, dist and node_modules. All dependencies that Gulp needs to automate tasks such as concatenation, minification and compilation of Sass files will also be loaded on gulpfile.js.

Since we'll load third party packages into gulpfile.js, we'll have to download them using NPM. Each project will have its own dependencies. For this project, I'll load some libraries which I've been working with recently. To do that, we'll run npm install in a terminal to download the following packages:

{{< highlight bash >}}

npm install --save-dev gulp-sass gulp-autoprefixer gulp-uglify gulp-cssnano gulp-rename merge2

{{< /anchor >}}

Several development dependencies were separated by spaces after the flag -\-save-dev. These are:

- Sass (gulp-sass): compile all .scss files into .css ones;
- Autoprefixer (gulp-autoprefixer): add browser extensions to CSS selectors as needed, such as -webkit, -o, -ms or -moz. This plugin use {{< anchor href="https://caniuse.com/" target="_blank" >}}Caniuse{{< /anchor >}} as reference;
- Uglify (gulp-uglify): minify Javascript files;
- Css Nano (gulp-cssnano): minify CSS files;
- Rename (gulp-rename): rename files;
- Merge (merge2): manage multiple task streams simultaneously.

Update November 11, 2021: Gulp now have two methods called serial and parallel that can be used to manage multiple tasks. These can be used in favor of Merge.

With all dependencies downloaded, we can load them into gulpfile.js and setup all tasks that should be automatically executed. Starting with the plugin, create a file at the root (where folders src, dist, node_modules and package.json are) called gulpfile.js. Write the following code inside this newly created file:

{{< highlight javascript >}}

var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var uglify = require('gulp-uglify');
var cssnano = require('gulp-cssnano');
var rename = require('gulp-rename');
var merge = require('merge2');

var directories = {
  src: './src/',
  dist: './dist/',
  node_modules: './node_modules/'
};

{{< /highlight >}}

All dependencies are loaded using a function called require and stored on variables for later use. A variable called directories was declared an stores an object referencing the locations of src, dist and node_modules starting from the root. This is optional, I like using it to organize all directories that are constantly referenced by tasks.

The next step is to create all tasks. The first task I usually create is one called skeleton: this task will load everything that is ready for production into the dist folder and creates the entire project structure.

{{< highlight javascript >}}

gulp.task('build-skeleton', function() {
  return gulp.src([
    directories.src + '**/*.php',
    directories.src + '**/*.txt',
    directories.src + '**/*.pot'
  ])
  .pipe(gulp.dest(directories.dist));
});

{{< /highlight >}}

Update November 11, 2021: {{< anchor href="https://gulpjs.com/docs/en/api/task/" target="_blank" >}}Using task is deprecated{{< /anchor >}}. Tasks should be created as functions and exported. These functions shouldn't return Gulp streams, rather they should invoke a callback method that is passed as a parameter to the function. The previous function, if rewritten using the convention that is adopted by the time of this update, becomes:

{{< highlight javascript >}}

function build_skeleton(cb) {
  gulp.src([
    directories.src + '**/*.php',
    directories.src + '**/*.txt',
    directories.src + '**/*.pot'
  ])
  .pipe(gulp.dest(directories.dist));

  cb();
};

{{< /highlight >}}

Gulp uses {{< anchor href="https://en.wikipedia.org/wiki/Glob_(programming)" target="_blank" >}}Glob{{< /anchor >}} syntax to find files and folders. The array of patterns passed on gulp.src matches files with extensions .php, .txt and .pot inside the root folder and any folder below it, and place them on the directory listed at directories.dist. This function returns an "execution stream" associated with a task, signaling other tasks when it is done. This is useful to build a workflow with task dependencies. In this instance, I need vendor Javascript and CSS to be loaded before building the final scripts and style sheets.

Moving on, we'll create a task to compile all Javascript files and place them on dist.

{{< highlight javascript >}}

gulp.task('build-script', function() {
  var scripts_admin = gulp.src([
    directories.src + 'admin/js/plugin-name-admin.js'
  ])
  .pipe(uglify())
  .pipe(rename({
    suffix: '.min'
  }))
  .pipe(gulp.dest(directories.dist + 'admin/js'));

  var scripts_public = gulp.src([
    directories.src + 'public/js/plugin-name-public.js'
  ])
  .pipe(uglify())
  .pipe(rename({
    suffix: '.min'
  }))
  .pipe(gulp.dest(directories.dist + 'public/js'));

  return merge(scripts_admin, scripts_public);
});

{{< /highlight >}}

Since we're not going to use third party Javascript libraries, there is no task configured to load them into the project. If that was the case, then this task would have to be created and setup to run before the task that compiles all scripts. When the plugin boilerplate was generated, some Javascript and CSS files were created and named "plugin-name-admin.js", "plugin-name-admin.css", "plugin-name-public.js" and "plugin-name-public.css", where plugin-name is the slug that was given for the plugin on wppb's boilerplate generator.

Task build-script will:

- Load Javascript files on folders named js, which are located on directories admin and public;
- Minify all Javascript files;
- Add suffix ".min" on all files;
- Copy resulting files into directories dist, admin/js and public/js respectively;
- Return the stream that is created when combining the streams referenced on scripts_admin and scripts_public.

Note that we're not returning the gulp object itself, it was stored on scripts_admin and scripts_public. Both streams are returned inside of a merge object, that will manage task dependencies. Another thing: the method src that is being called from gulp receives an array with only one item. This method can also accept strings, so this snippet of code could have been written the following way:

{{< highlight javascript >}}

gulp.src(directories.src + 'admin/js/plugin-name.js')
    .pipe(gulp.dest(...));

{{< /highlight >}}

I usually pass lists as parameters to maintain code consistency;

We'll do something similar to process CSS files. The plugin boilerplate is not ready to work with Sass, so there is no specific directory to work with it. What I usually do is erase the css folder and its contents, and create a new folder called scss, and I do this inside both the admin and public directories. These folders will hold all .scss files, as well as folders for partials, mixins, variables etc. Both admin and public folder will also have files called plugin-name-admin.css and plugin-name-public.css respectively. I delete both files and create new ones using Sass, keeping the names, adding .min as a suffix and a css directory inside dist.

{{< highlight javascript >}}

gulp.task('build-style', function() {
  var admin_style = gulp.src([
    directories.src + 'admin/scss/plugin-name.admin.scss'
  ])
  .pipe(sass())
  .pipe(autoprefixer())
  .pipe(cssnano())
  .pipe(rename({
    suffix: '.min'
  }))
  .pipe(gulp.dest(directories.dist + 'admin/css'));

  var public_style = gulp.src([
    directories.src + 'public/scss/plugin-name.public.scss'
  ])
  .pipe(sass())
  .pipe(autoprefixer())
  .pipe(cssnano())
  .pipe(rename({
    suffix: '.min'
  }))
  .pipe(gulp.dest(directories.dist + 'public/css'));

  return merge(admin_style, public_style);
});

{{< /highlight >}}

This task will:

- Search for styles called plugin-name.admin.scss and plugin-name.public.scss inside a scss folder on directories admin and public, respectively;
- Compile all files into .css ones;
- Add browser extensions to CSS selectors as needed;
- Minify all .css files;
- Add suffix .min to all file names;
- Place all files into admin/css and public/css inside directories admin and public, respectively;
- Return the combined stream.

With all tasks created, it is time to setup Gulp to execute them. I do this in three steps:

- Creating a task that invoke build-skeleton, copying all files to dist;
- Creating a task that copies everything that's in dist to the location of the WordPress installation;
- Setting up Gulp's default task to run the previous tasks and monitor all files for changes.

{{< highlight javascript >}}

gulp.task('build-project', ['build-skeleton', 'build-script', 'build-style']);

{{< /highlight >}}

Update November 12, 2021: Gulp tasks now must be declared with a new syntax:

{{< highlight javascript >}}

exports.build_project = gulp.serial([
  gulp.parallel(['build_skeleton']),
  'build_script',
  'build_style'
]);

{{< /highlight >}}

Tasks are called on a terminal the same way.

An array containing the names of tasks that were previously created and a callback function are passed to build-project. This array indicates that the task build-project can only be executed after build-skeleton, build-script and build-style. Since there is no callback function, nothing will be done after all tasks are finished. A workflow that calls all the other tasks was made using build-project. After build-project finishes, dist should contain all files that will be put on production.

To test everything, open a terminal and navigate to the directory in which the gulpfile.js is located (this should be the root of the plugin folder). Type:

{{< highlight bash >}}

gulp build-project

{{< /highlight >}}

After seeing the process done on the terminal, the dist folder should be populated with all files that are ready to be copied.

{{< image src="images/figure6-gulp-workflow-running.webp" alt="All tasks were executed as planned." caption="All tasks were executed as planned. Source: Author." title="All tasks were executed as planned." lazy="true" >}}

Navigate into dist and check the contents of admin and public. Note that there's a css folder and the file inside this folder is the compiled .css, not the .scss that was created during development. There is no scss folder inside dist. Also note that all css and js files have a .min suffix on their names.

The next step is to copy all files on dist to the directory in which WordPress is installed.

{{< highlight javascript >}}

gulp.task('build-project-on-stage', ['build-project'], function() {
  return gulp.src([
    directories.dist + '**/*'
  ])
  .pipe(gulp.dest('/installation/directory/wordpress/wp-content/plugins/plugin-name'));
});

{{< /highlight >}}

I'll assume that your WordPress installation is configured to use the default folder for plugins, wp-content/plugins. If it's not the case, the directory must be changed to the plugin installation path. A folder called plugin-name will be created if not exists and all files within dist will be placed inside this folder. The contents of build-project-on-stage will only be executed after build-project is finished.

As a final step, we'll configure Gulp's default task, called default, to execute all previous tasks and watch all development files for change. Once a file is modified, all tasks will be executed.

{{< highlight javascript >}}

gulp.task('default', ['build-project-on-stage'], function() {
  gulp.watch(directories.src + '**/*', ['build-project-on-stage']);
});

{{< /highlight >}}

Gulp tries to run a task called default in case the command gulp runs without specifying a task. This task is configured to watch the directory specified on directories.src and everything inside it for file changes. Once a change is detected, this task will call another task, build-project-on-stage, triggering the entire chain of tasks we've built, and once all tasks are done, Gulp will watch all files for new changes.

We're almost done! But we created an issue when adding the suffix .min to the files inside the plugin folder.

Do you remember that we added a .min suffix on files "plugin-name-admin.js", "plugin-name-public.js", "plugin-name-admin.css" and "plugin-name-public.css"? When this was done, references to the previous files were lost and the plugin is trying to load them. We need to change some configurations inside the newly created plugin to reference these files with .min extensions added.

To do that, open the file plugin-name-admin.php, being plugin-name the name that was given to the plugin. There are two methods declared in this file: enqueue-styles and enqueue-scripts. These methods are associated with a hook called admin_enqueue_scripts, inside includes/class-plugin-name.php. Note that the method enqueue_styles that is declared on the file we've just opened invokes a function called wp_enqueue_style, which is part of the Core, to load a CSS style sheet.

{{< highlight php >}}

wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-admin.css', array(), $this->version, 'all' );

{{< /highlight >}}

We need to add .min to the CSS file that is being loaded. This reference will be updated to plugin-name-admin.min.css.

Similarly, enqueue_scripts search for a Javascript file that does not contain a .min extension using wp_enqueue_script.

{{< highlight php >}}

wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-admin.js', array( 'jquery' ), $this->version, false );

{{< /highlight >}}

The new referenced file will have a .min extension, and its name will be plugin-name-admin.min.js.

We also have to change all CSS file names that inside public, editing the file plugin-name-public.php. This file have the same functions enqueue_styles and enqueue_scripts that reference a hook inside includes/class-plugin-name.php. The file names that have to be edited are plugin-name-public.css and plugin-name.js.

Now we're done! The automation is done and once developers get to work on this plugin, they just have to open a terminal, browse to the root folder of the project, where a gulpfile.js file is located, and type gulp. Simple as that! All files will be loaded into dist. In order to have all files automatically copied into the WordPress installation directory, just open the gulpefile.js and add the directory in which WordPress is installed and all files will be also copied into this directory each time they're changed. The method watch will keep an eye for file changes and upload the latest versions into the server automatically.

Let's review all steps to setup a WordPress development environment with a theme and plugin:

- We've downloaded a theme boilerplate and a plugin boilerplate;
- We've copied both boilerplates to company-name/plugins/plugin-name/src and company-name/themes/theme-name/src;
- We've created folders called dist next to both src folder, one for plugins and another one for themes;
- We've installed Node.js and NPM;
- We've created a package on the root folder of plugins and themes using npm init;
- We've installed Gulp command line interface globally using NPM;
- We've installed Gulp and several development dependencies using NPM;
- We've create a file called gulpfile.js at the root of plugins and created all tasks to be executed;
- We've setup Gulp to watch all files inside src for changes, then transfer their latest versions to dist and also to the folder in which WordPress is installed;
- We've updated all references to script and style sheet files inside class-plugin-name-admin.php and class-plugin-name-public.php for the new ones that were compiled by Gulp.

Now it is done! The plugin is ready to be installed on WordPress. We've done the steps to setup a plugin project, but I also do that for themes and any other projects for whichever company I'm working with. Although the process is the same, each project will have its own dependencies, and each gulpfile.js will be unique. Another thing to have in mind is the usage of CSS and Javascript frameworks. In our example we haven't used anything other than what came in each boilerplate and what's already available on the Core, but if that was the case, we would have to load all vendor libraries inside the dist folder. When working with a library such as Bootstrap, for instance, I download it using NPM, create one or more .scss files that import only the components that will be used, and at the CSS compiling task, I reference these components inside node_modules, which will then be bundled into the final CSS file after being compiled by Gulp. Another example of external files being used inside a project is when using Underscores boilerplate. Inside the js folder, which is located at the root, there are three files: customizer.js, navigation.js and skip-link-focus-fix.js. These files are called depending on what page is requested. When on the administrative panel, for instance, customizer.js is loaded, but not on the front end. I usually include these scripts when setting up a task to compile scripts, but I create multiple files since it doesn't make much sense loading all files on every page.

With each project configured, the folder company-name/plugins will have one project for each plugin and company-name/themes will have one project for each theme.

## Setting up Git

Git repositories can be created inside company-name, which will bundle all plugins and themes inside a single repository, or inside each plugin or theme being developed. I think that for a small project, maintained by a single developer, makes sense to aggregate all projects inside a single repository. Since this rarely will be the case, I recommend setting up a repository for each project. This way each developer clone only the files that he or she will be working with, and the risk of file versions clashing with one another in case there's more than one developer updating files in the same repository is smaller. There is one advantage, though, in working with a single repository: keeping the file structure for plugins and themes presented throughout this post, assuming that all projects were created on the same machine. In a day to day basis, though, it is probable that each project will have its own repository and the structure presented here may only serve as a guide to work with multiple themes and plugins in a single machine.

To finish it all, I usually create a file called .gitignore at the root of the repository, which will instruct Git to ignore files that shouldn't be uploaded. There will be at least one line in this file:

{{< highlight plaintext >}}

**/node_modules

{{< /highlight >}}

Just like Gulp, Git uses Glob to find files and folders. This line instructs Git to ignore node_modules and everything inside it, since this folder doesn't need to be packed with any project. All packages are referenced on package.json and these references are enough to download the entire folder again when needed. After downloading this project, one should run npm init to download node_modules. End users will only use what's inside dist.

## This is the right way to setup a workflow?

There are many ways to organize files and folders to ease development. There is not a single right way to do it and the official instructions on WordPress websites don't cover many scenarios, leaving room for creativity. Setting up a project like this can be a bit overwhelming at first, but in the long run it will be for the best, particularly when editing this project months later.

## Further reading

You will probably make extensive use of the documentations for all tools used throughout this post. {{< anchor href="https://codex.wordpress.org/Developer_Documentation" target="_blank" >}}WordPress{{< /anchor >}}, {{< anchor href="https://docs.npmjs.com/" target="_blank" >}}NPM{{< /anchor >}} and {{< anchor href="https://github.com/gulpjs/gulp/blob/master/docs/README.md" target="_blank" >}}Gulp{{< /anchor >}} documentation pages will be your frieds along the way. {{< anchor href="https://stackoverflow.com/" target="_blank" >}}StackOverflow{{< /anchor >}} will also be an invaluable resource to fight against enigmatic errors that will appear throughout the journey.

Expanding the topic, {{< anchor href="https://sass-lang.com/guide" target="_blank" >}}Sass{{< /anchor >}} is a interesting technology to know, as well as how to integrate frameworks such as {{< anchor href="https://getbootstrap.com/docs/4.1/getting-started/theming/" target="_blank" >}}Bootstrap{{< /anchor >}} with Sass using the library {{< anchor href="https://www.npmjs.com/package/gulp-sass" target="_blank" >}}gulp-sass{{< /anchor >}}. Talking about NPM libraries, each one have its documentation page and a lot of options that haven't explored.

Let's organize the house!
