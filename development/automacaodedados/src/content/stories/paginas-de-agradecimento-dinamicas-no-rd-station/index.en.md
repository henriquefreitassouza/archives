---
title: 'Dynamic thank you pages using RD Station'
author: henriquesouza
publishDate: 2019-02-10 21:37:00
lastMod: 2021-11-14 21:37:00
summary: How to display dynamic content on thank you pages for converted leads using RD Station?
description: 'Dynamic thank you pages using RD Station'
image_description: 'Words thank you handwritten.'
categories:
- Marketing
featured: true
---

Published on February 10, 2019 and updated on November 14, 2021.

Update November 14, 2021: Landing page forms were updated. The hidden field "redirect_to" that was used to register the redirect url doesn't exist anymore. Use cookies to store information and retrieve them at the thank you page. This post still presents the outdated way to build dynamic thank you pages using RD Station, use it only as a guide to understand how landing pages work on RD Station.

**SPOILER ALERT: this post contains code lines! I'll assume that you have a basic understanding on HTML and Javascript**.

You've designed your entire inbound marketing strategy, defined goals for each channel, created rich content, configured Lead Score, built landing pages using form fields that are relevant to your business, created all promotional and content e-mails, hooked everything with automation flows and turned it all on. Now it is just a matter of time to nurture leads and generate sales, correct?

It depends (the famous answer for every problem in 21st century).

Tip: in case you want to go straight to the hands on section, jump to "Creating dynamic pages with RD Station".

In case you've built an inbound strategy that is so perfect that your marketing automation tool of choice can determine, with 100% precision, that qualified leads are indeed qualified leads -- read it: all qualified leads and marked as opportunities will buy -- and on top of that it is future proof -- read it: consumer behavior doesn't change -- then everything is all right :)

Now, if you've built an inbound marketing strategy and noticed that 90% of all qualified leads are lost, it may be that there is something to improve. Chances are: me, you and our wonderful digital marketing professional community are between the first and second groups. Think that even companies that use machine learning techniques to qualify leads cannot guarantee that 100% of qualified leads will eventually convert into paying customers, given that these systems rely on inferential statistics. The challenge, in summary, is: **calibrate the definition of qualified lead**.

Calibrate the definition of qualified lead is a never ending task, with or without machine learning. As great as the nutrition flow may be, the better the content is, the more personalized the flow is, it will never predict every possible way a company will interact with people. What we call leads are still people, with needs, desires, experiences and individual contexts. These differences result in leads that do not need to follow the nutrition flow as it was designed. Leads with low scores will still become customers and others, marked as promising according to the marketing automation tool, are not. This generates the need to find additional qualification signals to the Lead Score. One way to do that is to **create triggers that allow for leads to raise their hands** , after all, why only deduce if a lead is qualified if we could just ask him or her, right? Triggers can be setup anywhere along the inbound journey, but in this post we'll explore a specific place: a page that represents the end of a transaction in digital marketing terms, also called **thank you page**.

{{< image src="images/figure1-drip-thank-you-page.webp" alt="Drip's free trial thank you page." caption="Drip's free trial thank you page. Source: Drip." title="Drip's free trial thank you page." lazy="true" >}}

## Opportunities for thank you pages

Nurturing takes time. Each business and each product have its particular needs and target audiences that will determine the average time to buy. There may be exceptions, but the smaller the time to nurture, the better. Thank you pages offer the possibility to reduce the time to buy and on a very special moment on the customer journey: the **post transacional**. This moment is comparable to a post purchase in an e-commerce, and the pleasure of seeing an order complete page showing that the acquisition process was completed. In an e-commerce, this page will show information like the order number, data that was informed during the purchase and its production and delivery status. It is possible to print the whole page, keep shopping and maybe to see products that interested other people which may interest you as well. In summary: it is a page analyzed with care. In a similar way, thank you pages also represent a post transaction. A lead left valuable data when typing fields in a form expecting a return of some sort, be it a physical or digital material. Thank you pages provide instructions on how to access their prize. It is at this moment that he or she can be invited to continue interacting with the company, while "analyzing the page with care".

## Creating dynamic pages with RD Station

If you use RD Station daily, you should know that, at the time of this publication, this tool doesn't have a feature that allow to put dynamic content in landing pages. Like any landing page, you can customize the appearance and content, but not add dynamic elements using a WYSIWYG editor, similar to what is done when adding variables to e-mails. You can create one thank you page for each existing landing page or form, or you can create one thank you page for many forms. Each approach have its problems. In the first one, you'll have more pages to maintain as the content grows -- imagine editing many broken links in case one URL changes or content gets updated -- and in the second one, you offer the same content for all leads that have filled out the form showing interest on your offer, losing potential valuable actions or sales that could have been resulted from personalized content. How to solve this issue? The solution is similar to other problems presented on this blog: a good dose of code :)

I'll show what I consider that is the simplest way to put dynamic content inside thank you pages: writing the name of the person that filled out a form on the title of the thank you page. For this exercise, we'll choose a pre built landing page of type capture, which will have a form with fields name and e-mail, and another pre built landing page of type thank you page which will show the name of the person that filled out the form. This same exercise could be done using standalone forms instead of landing pages, but you need to ensure that it will be possible to put some code snippets at the page that will embed the form. Take for instance sites built with WordPress. Anything written between \<script> and \</script> tags is blocked by default when using the content editor. In order to use Javascript on WordPress without disabling for code checking (which opens a security breach), WordPress documentation suggest that you {{< anchor href="https://codex.wordpress.org/Using_Javascript" target="_blank" >}}create a separate script file, load this file inside the theme's functions.php or using a plugin, calling this code using functions{{< /anchor >}}.

Given the challenge, it is time to practice.

RD Station have a feature called **advanced editing** inside the landing page editor. When opening this editor you will see a popup window and inside it three tabs to inject code. The first tab allows you to include CSS and the remaining ones are for Javascript. The second tab allows to include Javascript between \<head> and \</head> tags and the last one is to include Javascript before the closing \<body> tag. This is useful to control the placement of code in order to manipulate DOM elements in the right time, and to have some control when script files will load, so users won't feel any interference when using the page. In this example we'll use Javascript to read and edit DOM elements, which is a good indication that we should use the last tab to inject our code.

{{< image src="images/figure2-rd-station-advanced-editor.webp" alt="Landing page editor with advanced editing opened." caption="Landing page editor with advanced editing opened. Source: Author." title="Landing page editor with advanced editing opened." lazy="true" >}}

Let's begin by creating the landing page. Use the editor to customize both the form and layout as you need. Made the adjustments, go to "advanced options" and then to "advanced editing" (or just "advanced editing" if using the beta editor available at the time this post was published). With the code editor opened, go to the tab "Javascript on BODY" and write the following code snippet inside \<script> and \</script> tags:

{{< highlight javascript >}}

$('#conversion-form').submit(function() {
    var name = $("#name").val();
    $("input[name='redirect_to'").val($("input[name='redirect_to'").val() + "?name=" + name);
});

{{< /highlight >}}

Analyzing the code:

1. RD Station load the library JQuery as a dependecy, so it is ready to be used (with all its conveniences). If you're using standalone forms embedded in a page, make sure that JQuery is loaded as well before using this code;
2. Wait for a form submission event. ID #conversion-form is automatically given by RD Station to the conversion form, but **only when using forms with landing pages**. If you're using standalone forms embedded on a page, RD Station should create the form ID using the convention conversion-form-[FORM_NAME]-[FORM_ID], where [FORM_NAME] is the name that you gave to the form when creating it on RD Station and [FORM_ID] is an identifier automatically generated by RD Station. You should replace #conversion-form with the ID that was created for the standalone form. To find this identifier, open the browser code inspector (usually available using the shortcut F12 on a keyboard) and find the form id inside the \<form> tag, once you have embedded the form at the destination page;
3. Declare a variable called "name" that register the value of an input called "name";
4. Rewrite the value of a hidden field inside the form named "redirect_to". The new value will be the same one with a parameter "?name=name" added to it, where the "name" after equal sign is the variable that was created in the previous step. RD Station uses this hidden field "redirect_to" to register the address from which users should be redirected once submitting a form. This address is set when editing landing pages or forms in RD Station, when choosing the option "page redirect" under "configurations". If you've configured the form to redirect to "http://henriquefreitas.com.br", this value will set on the field "redirect_to". What this block of code does is add parameters to the redirect url to be read at the thank you page. This code snippet is an adaptation of one found at the help center of RD Station with {{< anchor href="https://ajuda.rdstation.com.br/hc/pt-br/articles/115004821743-Dicas-de-Edição-Avançada-de-Landing-Page" target="_blank" >}}landing pages advanced editing tips{{< /anchor >}}.

Update November 14, 2021: RD Station doesn't create landing pages with a hidden field called "redirect_to" anymore, making this procedure outdated.

Save your work by pressing the button "Apply" (or "Save" depending on which editor version you're using) and go to the next step to configure the landing page. Select the option "page redirect" and type the address of your thank you page. Setup the remaining options as you need, then publish the page.

{{< image src="images/figure3-landing-page-redirect-configuration.webp" alt="Page redirect enabled and destination page address configured." caption="Page redirect enabled and destination page address configured. Source: Author." title="Page redirect enabled and destination page address configured." lazy="true" >}}

Create a new pre built page using the thank you page model and adjust the layout as you need. Publish this page and navigate to it using its public URL (the same that was added to "page redirect" when configuring the landing page). We need to figure out which CSS selector will reference the element we want to become dynamic, with the name of the person who submitted the form. We could use the title of this page, which possibly is an \<h1> tag. Use the code inspector to search for it easily. On the pre built model I've used for this example, the content that I wanted was inside a \<span> tag, and that tag was inside an \<h1> tag with id "video-title". The selector I was looking for then is "**#video-title span**".

{{< image src="images/figure4-thank-you-page-code-inspect.webp" alt="HTML element that renders the page title." caption="HTML element that renders the page title. Source: Author." title="HTML element that renders the page title." lazy="true" >}}

I've found the HTML element that renders the page title. It is a span that's inside an H1 with ID "video-title". To select it using CSS use #video-title span.

With this selector in our hands, go back to the thank you page editor. At the page editor, navigate to "advanced options" and "avanced editing" (or just "advanced editing" if using the beta editor available by the time this post was published). Inside the code editor, open the tab "Javascript on BODY" and paste the following code snippet between \<script> and \</script> tags, and change the CSS selector to the one you've found when inspecting the source code of the thank you page:

{{< highlight javascript >}}

var page_address = window.location.href;
var url = new URL(page_address);
var name = url.searchParams.get('name');
var page_title = document.querySelector('[YOUR_SELECTOR]'); // Change [YOUR_SELECTOR] to the one you've found when inspecting the source code of the thank you page.

if (name != null && name != 'null')
  page_title.innerHTML = 'Thank you ' + name + '!';
else
  page_title.innerHTML = 'Thank you!'; // Optional treatment

window.history.pushState('', '', url.pathname); // Optional treatment

{{< /highlight >}}

{{< image src="images/figure5-javascript-injected.webp" alt="Advanced editing enabled and code that read the URL and change the DOM applied." caption="Advanced editing enabled and code that read the URL and change the DOM applied. Source: Author." title="Advanced editing enabled and code that read the URL and change the DOM applied." lazy="true" >}}

Let's analyze the code:

1. There's a variable called page_address that store the current URL being served by the browser. This address is the one for the thank you page and should have the parameter that was created in the landing page. If this page is accessed another way, the parameter probably won't be available;
2. A variable called "url" was declared containing an instance of the URL class. This class is available through an API developed on recent versions of Javascript, meaning that this feature {{< anchor href="https://caniuse.com/#search=URL" target="_blank" >}}is not available on every browser and device{{< /anchor >}}. I will use the API since on this exercise browser compatibility is not a requirement;
3. Call the get method from searchParams, object from class URL, to search the parameter "name" which was created at the landing page, and the result is stored in a variable called "name";
4. Create a variable called "page_title" which contains the DOM element that renders the page title. Note that this code use the selector that was found at the thank you page after publishing it the first time. Add the selector you've found between quotes on the marked place. Also note that we're using the method querySelector called by object document. Unlike the class URL, this method {{< anchor href="https://caniuse.com/#search=querySelector" target="_blank" >}}is safer to use, although older browsers aren't supported{{< /anchor >}};
5. Check if the parameter is available in the URL. This is done because the page can be accessed directly or errors can happen during the redirect process, since we're using Javascript to create dynamic content. If there is a parameter, the title will now be "Thank you, [NAME]!", where [NAME] is the name that was passed on the URL parameter. If there is no parameter, the titile will be just "Thank you!". You could decide not to code the case where there is no parameter, since when using the editor you probably wrote the title anyway. This title will be shown by default if the else statement is not present in the code;
6. Finally, the method pushState from object history is used to rewrite the URL without making a complete page redirect. This line is coded only to make the URL more friendly, without showing parameters, and it is completely optional. It will work the same way if this line is not present in the code. {{< anchor href="https://caniuse.com/#search=pushState" target="_blank" >}}Use this method with caution if you need this page to work with older browsers{{< /anchor >}}.

Publish the page and test it! First access the URL and add a parameter "?name=Test". When reloading the page using this parameter you should see the message "Thank you, Test!". If everything worked, make another test, this time filling out the form inside the landing page. You should be redirected to the thank you page greeted with the message "Thank you, [NAME]", where [NAME] is the name that you've wrote when filling the name on the form.

{{< image src="images/figure6-dynamic-thank-you-page.webp" alt="Example of a thank you page after testing it." caption="Example of a thank you page after testing it. Source: Author." title="Example of a thank you page after testing it." lazy="true" >}}

## Continually improvements to the funnel

This is a simple example on how to customize a thank you page based on information that was given by form respondents, but there are other possibilities. We could improve this example to send, as well as the name, the address to the rich content that should be delivered upon filling the form, if it is something to be immediately accessed such as an ebook or webinar. Its link could be a URL parameter to be read at the thank you page and added to a button, or as a link to additional resources, which you can use to personalize a set of related offers. The process is the same, what changes are the CSS selectors to be used when altering the DOM of a thank you page.

With this tip you should be able to make some adjustments to personalize offers on thank you pages, and communicate with your target audience more effectively, increasing conversions on your success metric that could otherwise be lost if relying solely on the Lead Score.

Let's optimize!
