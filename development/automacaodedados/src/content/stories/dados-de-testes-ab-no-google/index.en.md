---
title: 'Dealing with differences between testing and analytics dashboards'
author: henriquesouza
publishDate: 2017-11-30 08:39:00
lastMod: 2021-10-31 08:39:00
summary: 'The number of visitors or sessions that online testing tools display is different from those shown in analytics tools, even if the test is using 100% of available traffic. Sometimes the difference is so significant that raises the question about which dashboard should be used. How to make that difference manageable?'
description: 'Dealing with differences between testing and analytics dashboards'
image_description: 'Google Analytics dashboard with A/B test data.'
categories:
- Analytics
featured: true
---

Published on November 30, 2017 and updated on October 31, 2021.

Update October 31, 2021: At the publication of this post, version 4 of Google Analytics had not been launched. Google Analytics 4 was redesigned to answer privacy laws around the world. The interface and features have changed significantly, some of the most notable changes are the reduced dependency of cookies and the removal of views. Event tracking, used throughout this post, is different across versions 3 and 4. Version 4 doesn't need attributes Category, Action, Label and Value for events to be registered. Examples shown throughout this post use Google Analytics version 3.

Both testing and analytics tools collect and store data on users. Both store sessions and conversion events throughout time, and show this information on dashboards. When comparing data produced by both tools under the same time frame, though, numbers do not match. Why is this the case?

## Implementation and configuration differences

Testing and analytics tools {{< anchor href="https://support.abtasty.com/hc/en-us/articles/201747527-There-are-differences-in-data-between-AB-Tasty-and-my-analytics-tool" target="_blank" >}}are different things{{< /anchor >}}. Even if both tools collect the same information, procedures for collecting, treating and storing differ among those tools. Even with guarantee that the implementation of both tools was correctly done and that there are no data collection errors, numbers will still differ. The question then is: which tool should I look for when building a report?

Choosing to visualize numbers only on the testing tool is a good option when these numbers are not bound with other metrics at the company. In other words, when the analyzed metric have small correlation with other metrics. One example of a metric that can have high levels of correlation with others is the CTR of a page element that sends visitors across steps of a funnel. In this case it is hard to use the numbers being displayed on the testing tool to calculate other metrics such as the rate of unique visitors or sessions across funnel steps.

About analytics tools, they register many metrics related to traffic behavior within a product. The first difference between these and testing tools is related to cookie duration: Google Analytics version 3, for instance, install cookies that expire after 30 minutes of inactivity, meaning that visitors idle for more than 30 minutos will have the cookie deleted from their browsers. Testing tools usually have cookies with longer expiration dates, and each provider have its own default configuration. The default expiration date may not be well suited depending on the product. Imagine that a video platform may not want that their cookies expire after 30 minutes of inactivity, since visitors may spend longer times idle while watching videos. Differences on cookie's expiration dates may lead tools to count twice the same user.

Time to load and loading placement can also produce different data when looking at testing and analytics tools. Scripts placed on footers need the whole page to be available in order for them to be loaded, assuming that no pre loading was configured. If the page have many multimedia and/or dynamic content, loading can take some time. Another dangerous scenario happens when scripts are asynchronous loaded. Scripts, style sheets, images and other elements that build a page can be **synchronously** or **asynchronously** loaded. Synchronously loading means that, when browsers are reading the page and there is a call for an external file, like an script, page load is halted until the external dependencies have been fully loaded and included on the rendered page. Asynchronous loading render both the page and external resources at the same time, as they finish loading. What can happen on asynchronous loading is that the page was loaded but the scripts that load testing and analytics tools were not. If visitors leave the page on such state, they will not be registered. Tests may even not start properly. In some other cases, tests can start after visitors are interacting with the original page, which leads to unwanted induced treatments on samples as they browse. This is known as Flash of Original Content (FOOC).

## What about Google Optimize?

{{< anchor href="https://www.google.com/analytics/optimize/" target="_blank" >}}Google Optimize{{< /anchor >}} is a tool to run A/B, A/B/N, mvt and split tests created by Google. Since it is part of Google's portfolio, it integrates natively with Google Analytics. To start running tests with it, it needs a Google Analytics view ID, on version 3, in order for Optimize to send the data to the correct place, located on Behavior > Experiments. Once Optimize have access privilege to the view, testing data will be available at Google Analytics. There are differences even between Optimize and Analytics across their dashboards. Different numbers can be spot both between the experiments report on Google Analytics and the dashboard on the testing tool, and between the experiments report and the remaining reports of Google Analytics. {{< anchor href="https://support.google.com/360suite/optimize/answer/6323229?hl=en" target="_blank" >}}Official documentation{{< /anchor >}} provides that there are differences on the way that calculations are performed across tools, and also that reports are updated at different times. While Google Analytics is updated regularly, Google Optimize is loaded each 12 hours with a batch of data. Google's recommendation is to **always use the data that is displayed on Optimize's dashboard to make decisions**.

## Events panel

Many testing tools have native connectors for Google Analytics that ease sending information to the tool, but display similar restrictions to Google Optimize. One way I've found to circumvent this is to use events. Analytics tools can track custom events. These events can be configured by developers or a marketing team, provided that a tag manager tool is available. One example of such tool is {{< anchor href="https://www.google.com/analytics/tag-manager/" target="_blank" >}}Google Tag Manager{{< /anchor >}} (GTM).

Events are actions of interest. Some events are:

- View a page;
- Click on a button;
- Watch a video;
- Download a file.

Once monitored, event data is sent to the analytics tool. On Google Analytics version 3, an event can have the following information:

- Category: name of the event category;
- Action: name of the trigger. Some examples are play, click, download etc;
- Label: tag with additional information on the event that can be used to distinguish it from similar ones;
- Value: a numeric value added to the event. Can be monetary or any other number that quantify the action.

These attributes follow a hierarchy starting with categories, which contain actions, which contains labels, which contains values.

## Mapping test events to Google Analytics version 3

The solution for the difference is to register events on the analytics tools in two moments:

- Once when a visitor access the product;
- Once when a visitor reaches the conversion event.

Both events will have almost the same information on Event, Action and Label. Using Value is optional. What will change is the Action, which will assume different values for when visitors are selected to participate in the test and when visitors convert. A diagram with the solution will look like this:

{{< image src="images/figure1-hierarchy-google-events.webp" alt="Event hierarchy for A/B tests on Google Analytics version 3." caption="Event hierarchy for A/B tests on Google Analytics version 3. Source: Author." title="Event hierarchy for A/B tests on Google Analytics version 3." lazy="true" >}}

## Configuring the testing tool

To illustrate the concept, a solution proposition will be presented using Google Optimize and Google Analytics version 3. Information will be sent to Google Analytics using the tag manager Google Tag Manager.

Generally, testing tools have both a "drag and drop" editor and a code editor. These code editors run HTML, CSS and javascript, and some tools are able to inject code on two scopes: global and local. Global script editor inject code on all testing variations, and local is injected on the selected variation.

For the following example, code will be written on the local editor.

With Google Tag Manager installed, it suffice to call the method push from the dataLayer and send the data to an registered event on Google Tag Manager:

{{< highlight javascript >}}
  dataLayer.push({
    event: 'gtm_event',
    category: 'category',
    action: 'action',
    label: 'label'
  });
{{< /highlight >}}

This "event" attribute belongs to the dataLayer object and points to a tag on Google Tag Manager. Without Google Tag Manager, data must be sent to Google Analytics version 3 using the following code:

{{< highlight javascript >}}
  ga('send', 'event', 'category', 'action', 'label');
{{< /highlight >}}

When using push with a dataLayer, a tag will be fired sending the data to Google Analytics. Inside the local code editor, each variation will receive code similar to the ones shown previously, which should be sent on two separate occasions for each testing variation. Events will have the following configuration:

- category: I recommend using the name or identification of a test;
- action: the action field will have two values, one to register the visit and another one for the conversion. Action could be "visit" or "conversion" for instance;
- label: will register the variation. Can be a letter or the name of the treatment.

Category will be the same for every hit, label and action will change per variation, and if it is a visit or a conversion. The second call to the code that will trigger the event should be done only after the conversion has happened, and in this case it is necessary to code a trigger that listen to the conversion event:

{{< highlight javascript >}}
  window.onload = function() {
    var cta = document.getElementById('cta');
    cta.onlick = function() {
      // If using Google Tag Manager
      dataLayer.push({
        event: 'gtm_event',
        category: 'category',
        action: 'action',
        label: 'label'
      });

      // If not using Google Tag Manager
      ga('send', 'event', 'category', 'action', 'label')
    }
  }
{{< /highlight >}}

Tip: use vanilla javascript whenever possible to avoid library dependencies that can increase loading times and the possibility of "blinking" content (FOOC).

Using window.onload ensures that the button will only be accessible once is loaded. It is possible that this code loads before the page is completely rendered and tries to access elements yet to load. Using DOMContentLoaded is a development decision, since {{< anchor href="https://caniuse.com/#search=DOMContentLoaded" target="_blank" >}}old browsers won't recognize this method{{< /anchor >}}.

The full code to be added to each variation of a test:

{{< highlight javascript >}}
  // This is executed once a visitor is assigned to one of the variations
  window.onload = function() {
    // If not using Google Tag Manager, then use ga('send', 'event', 'cta_test', 'visit', 'control_group')
    dataLayer.push({
      event: 'test_tag', // Tag name on Google Tag Manager
      category: 'cta_test', // Test name
      action: 'visit', // Accessed test page
      label: 'control_group' // Visitor was assigned to control group.
    });

    var btn = document.getElementById('cta');

    btn.onclick = function() {
      // If not using Google Tag Manager, then use ga('send', 'event', 'cta_test', 'conversion', 'control_group')
      dataLayer.push({
        event: 'test_tag', // Tag name on Google Tag Manager
        category: 'cta_test', // Test name
        action: 'conversion', // Converted on test page
        label: 'control_group' // Visitor was assigned to control group.
      });
    }
  }
{{< /highlight >}}

Browse to the events report on Behavior > Events > Top Events. Once the test has started, access and conversion events should be registered on this report. Look at the difference between events and unique events. Since tests can run on more than one page or they can be reloaded, use the data on unique events, that will not be updated with multiple hits to Google Analytics. To compare events with users or sessions, create a custom report on Customization > Custom Reports including unique users and unique events, breaking down by category, action and label.

{{< image src="images/figure2-google-custom-report.webp" alt="Creating a custom report on Google Analytics version 3." caption="Creating a custom report on Google Analytics version 3. Source: Author." title="Creating a custom report on Google Analytics version 3." lazy="true" >}}

This makes it possible to count individual accesses and sessions inside Google Analytics.

{{< image src="images/figure3-google-test-event-dashboard.webp" alt="A/B test metrics inside Google Analytics version 3." caption="A/B test metrics inside Google Analytics version 3. Source: Author." title="A/B test metrics inside Google Analytics version 3." lazy="true" >}}

Upon clicking at an event category, should be displayed actions with the numbers of participants and conversions for the test. When clicking at an action (visit or conversion) the report will show the testing variations accordingly. To see categories, actions and labels on the same table, use the option to build the report based on a fixed table inside custom reports. The numbers of users, sessions and unique events should be close since testing data get to Google Analytics only after the test has started.

Even if differences on testing and analytics tools are still present, the numbers on both dashboards should be closer and using the same source, which is the testing tool.
