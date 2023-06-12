---
title: 'Static sites with Jekyll and Github Pages'
author: henriquesouza
publishDate: 2018-01-01 19:47:00
lastMod: 2021-11-07 19:47:00
summary: Websites are rarely built from scratch. There are many tools and frameworks which provide built in structures to build and publish websites on the internet. This post will present Jekyll, a static site generator, and how to use it in conjunction with Github Pages to publish sites on the internet with no cost.
description: Static sites with Jekyll and Github Pages
image_description: Octocat, Github's logo.
categories:
- Development
featured: true
---

Published on January 01, 2018 and updated on November 07, 2021.

Update November 07, 2021: this blog was originally made with the technology stack presented on this post. Currently it is built using {{< anchor href="https://gohugo.io/" target="_blank" >}}Hugo{{< /anchor >}}.

Content management systems (CMS) are behind many websites on the internet. {{< anchor href="https://wordpress.org/" target="_blank" >}}WordPress{{< /anchor >}} alone is present {{< anchor href="https://w3techs.com/technologies/overview/content_management/all" target="_blank" >}}on almost 30% of all published websites{{< /anchor >}}, with 60% market share. In total, about 50% of all internet is built with some CMS technology. What makes them so popular is a combination between simplicity, ease of use, open source technology and readily available themes and plugins. Not all CMS platforms are open, but the most commonly used ones embrace open source and are maintained by huge communities of enthusiasts. There are cases, though, in which projects do not need all the features present in a CMS and can benefit from simpler structures. This is when **static site generators** comes in.

## Static x dynamic websites

Dynamic sites usually have a connection with database management systems and other information sources. These information feed the structure of websites to deliver content. One example of such can be found within product pages from e-commerces. Product pages have the same base structure, but its content change according to the product being selected.

A static site, on the other hand, doesn't use relational databases to fill its content. All content is present on HTML files that are served to the browser.

## Static site generators

Just like a CMS, static site generators are capable of producing lots of different websites, like blogs, portfolios, landing pages and even e-commerces. They even have plugins and themes that add more features to them. Possible reasons to use static site generators instead of a CMS are for its **simplicity**, **speed** and **cost**. While a CMS runs on a server that interprets back end programming languages and databases, static site generators need only a server that can deliver static files. Even if there is a transformation pipeline before serving files, this process is much faster than interpreting languages or consulting databases. Static sites are more lightweight, keeping them easier to maintain. One downside compared to a CMS, though, is that its users should have some knowledge on front end or markdown in order to maintain the website.

There are many technologies for creating static websites. {{< anchor href="https://learn.cloudcannon.com/" target="_blank" >}}Cloud Cannon{{< /anchor >}} built the following list with some of these tools:

{{< image src="images/figure1-static-site-generators.webp" alt="Some tools for creating static websites." caption="Some tools for creating static websites. Source: Cloud Cannon." title="Some tools for creating static websites." lazy="true" >}}

These are just some of the tools. The website {{< anchor href="https://www.staticgen.com/" target="_blank" >}}Static Gen{{< /anchor >}} built a list with dozens more. What they do essentially is compile the project into a series of HTML files that can be hosted on web servers. During compilation, any markup languages, template languages and other pieces of code are transformed into HTML files. Although the final content is static, each file within the project can make use of structures usually associated with programming languages such as conditionals and loops.

## Jekyll

I first stumbled upon static site generators by meeting {{< anchor href="https://jekyllrb.com/" target="_blank" >}}Jekyll{{< /anchor >}}, a tool that have native integration with {{< anchor href="https://pages.github.com/" target="_blank" >}}Github Pages{{< /anchor >}}.

Jekyll have a configuration file called **_config.yml**. This file contains variables that can be referenced on any page of the website. Variables can store numbers, text, conditional values and lists. These variables are declared using a **key: value** syntax. Variables can also be scoped. Scopes can be global, which can be referenced on all pages, local, which are page specific, and it is also possible to create custom scopes. Variables can also be declared inside pages using a notation called **Front Matter**. Front Matter declaration are metadata with instructions on how to compile the page into the final HTML. Using Front Matter, it is possible to separate global configurations from page specific configurations. One example of such is choosing the layout that will be used to render the page. Suppose that the header and footer sections have their own files. Inside a "child" page, it is possible to declare a variable called **layout** and specify which template will be used when rendering the child page. Jekyll will search inside a templates folder for a file matching the given name.

This tool is widely used to create blogs, which can be seen when analyzing the default project structure. A default project contain the following folder structure:

- **_draft**: contains draft posts;
- **_posts**: contains published posts;
- **_layouts**: contains templates used on all pages;
- **_data**: contains data sources that can feed pages;
- **_plugins**: contains plugin files;
- **_site**: contains compile HTML files to be hosed on web servers.

The default template language used with Jekyll is {{< anchor href="http://shopify.github.io/liquid/" target="_blank" >}}Liquid{{< /anchor >}}, created by {{< anchor href="https://pt.shopify.com/" target="_blank" >}}Shopify{{< /anchor >}}. Generally speaking, there are two types of tags used in Liquid. They are **output tags** and **function tags**. An exit in Liquid is anything that is written between two pairs of curly braces:

{{< highlight javascript >}}
{{ value }}
{{< /highlight >}}

output tags can even receive filters. Outputs are separated from filters with a vertical pipe, and some examples of filters are to uppercase letters and to slice them:

{{< highlight javascript >}}
{{ value | upcase }}
{{< /highlight >}}

Function tags, on the other hand, execute logical operations, and are written with a pair of curly braces with percentage symbols inside. Most of these tags can be opened and closed:

{{< highlight javascript >}}
{% if value %}
  // TODO
{% endif %}
{{< /highlight >}}

Besides if else and for, include also uses this syntax:

{{< highlight javascript >}}
{% include arquivo.html param="valor" %}
{{< /highlight >}}

It doesn't have a close tag though, and parameters are optional.

Jekyll posts are written using {{< anchor href="https://daringfireball.net/projects/markdown/" target="_blank" >}}Markdown{{< /anchor >}} by default. Post files in Jekyll must be named using the convention **year-month-day.md** or **year-month-day.markdown** with 4 digit year and month and day both with 2 digits. File extensions can be md or markdown. All posts must initiate with a Front Matter declaration at their beginning:

{{< highlight yaml >}}
---
layout: post
title:  "Hello world!"
date:   2018-01-01 19:47:00
category: geral
---
{{< /highlight >}}

Front Matter is written in a language called **Yaml**, a serialization language used to create configuration files. Everything inside the sets of three dashes will be compiled, and Front Matter directives won't be visible on compiled files.

Jekyll also have {{< anchor href="http://jekyllthemes.org/" target="_blank" >}}themes{{< /anchor >}} and {{< anchor href="https://jekyllrb.com/docs/plugins/" target="_blank" >}}plugins{{< /anchor >}} ready to be used and maintained by the community.

## Github Pages

Github Pages is a static site server hosted on Github. It can host websites and use Jekyll as its static site generator. Hosting websites on Github Pages is free. It is useful for hosting portfolios, blogs or any other website which doesn't require dynamic content. Github Pages can be used by simply creating a repository with the same name as a git account. Mine, for instance, is henriquefreitassouza.github.io, so the repository will be called henriquefreitassouza.github.io. The complete path to this newly created repository will be https://github.com/youruser/youruser.github.io. Mine, for instance, is https://github.com/henriquefreitassouza/henriquefreitassouza.github.io. When entering the address https://youruser.github.io, contents within this repository will be served as web pages.

Since Github Pages already uses Jekyll, it suffice to clone the repository, create all Jekyll files inside it and send them to Github once development is done. The project is automatically compiled and everything inside _site (the directory containing compiled files) will be served by Github Pages.

To make the website even more professional, its repository can be referenced with a custom domain name. If you have a domain name and want it to point to the repository, this can be easily accomplished. There is a setting inside repository settings called **custom domain** within section **Github Pages**. You just have to fill the name of the domain and save the settings that a CNAME file will be created on the root of the repository. The following step is to configure DNS servers with the company that provided the domain name. If using {{< anchor href="https://registro.br/" target="_blank" >}}registro.br{{< /anchor >}} for instance, just select the domain name, click in **edit zone** and add all Github addresses with the name of the domain and type **A**. To conclude, it is possible configure a www subdomain adding a new CNAME entry and adding www just before your domain name. The DNS addresses that Github offer are **192.30.252.153** and **192.30.252.154**. It can take up to 24 hours for propagation.

A important detail about Github Pages is that any website hosted there is executed under a flag called **-\-safe**, which blocks plugins by default. If you want to use plugins with your project, one option it to compile the website in your local machine and then send the compiled website to the repository that is being served at Github Pages.

## Further reading

The goal with this post was to introduce the world of static site generators and not to be a tutorial of any kind. To further learn about Jekyll and Github Pages use the following sources:

- {{< anchor href="https://learn.cloudcannon.com/" target="_blank" >}}Cloud Cannon's complete Jekyll tutorial{{< /anchor >}};
- {{< anchor href="https://pages.github.com/" target="_blank" >}}Configuring a respository on Github Pages{{< /anchor >}};
- {{< anchor href="https://jekyllrb.com/" target="_blank" >}}Jekyll docs{{< /anchor >}};
- {{< anchor href="https://willianjusten.com.br/dominio-proprio-no-github-pages/" target="_blank" >}}Setting up a custom domain name on Github Pages using Registro.br{{< /anchor >}}.

Let's generate static websites!
