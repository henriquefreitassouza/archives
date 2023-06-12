---
title: 'RD Station and Google Sheets: automatically exporting leads to spreadsheets'
author: henriquesouza
publishDate: 2018-09-02 14:07:00
lastMod: 2021-11-10 14:07:00
summary: 'Get to know how to automatically send leads to Google Sheets from RD Station, a marketing automation software'
description: 'RD Station and Google Sheets: automatically exporting leads to spreadsheets'
image_description: 'RD Station and Google Sheets logos.'
categories:
- Automation
featured: true
---

Published on September 02, 2018 and updated on November 10, 2021.

**SPOILER ALERT: this post contains code lines! I'll assume that you're familiar with some fundamental concepts of Javascript, know what is an API and what is JSON.**

Update September 04, 2020:

- This post now have a second part: {{< anchor href="/en/stories/rd-station-e-google-sheets-na-aws/" >}}RD Station and Google Sheets Part 2 -  Migrating to AWS{{< /anchor >}};
- {{< anchor href="https://zapier.com/pricing" target="_blank" >}}Price plans for Zapier have changed{{< /anchor >}}. The plan that allowed for 3.000 API calls doesn't exist anymore, the current plan allows for 2.000 API calls and the upgrade goes to 5.000 API calls;
- {{< anchor href="https://developers.google.com/apps-script/guides/v8-runtime" target="_blank" >}}Google Apps Script now runs the V8 engine{{< /anchor >}}, which allows to write apps using the ES6 Javascript syntax. Not all ES6 resources are available by the time this post was updated;
- RD Station webhook object syntax {{< anchor href="https://developers.rdstation.com/pt-BR/migration/webhooks" target="_blank" >}}will change{{< /anchor >}};
- There is no distinction between parallel and managerial automation flows anymore. Every automation flow is now parallel;
- Current limit of cells in a single Google spreadsheet file is {{< anchor href="https://support.google.com/drive/answer/37603?hl=en" target="_blank" >}}5.000.000{{< /anchor >}}.

Update November 10, 2021:

- Google Apps Script was updated, including the way it is accessed from other Google services. The new path is Extensions > Apps Script;
- RD Station is using OAuth2 as the authentication protocol for its API;
- Automation flows are created and edited using a new interface and the option to send webhooks is called "Send Leads to Integration";
- Webhook object syntax hasn't changed since the last time this post was updated;
- Publishing web apps on Google Apps Script is now done by pressing the button "Deploy", located on the top right corner of the editor.

## Why spreadsheets?

Exchange data between sources is something commonly done when aggregating data to further analyze or visualize. One very known data aggregator is the electronic spreadsheet -- everyday Excel and Sheet files. Spreadsheets are convenient to store, manipulate and visualize data from many different formats using a tabular syntax. They are easy to understand and the way it is organized is convenient for sharing with other people and also with other tools, which is why they were never replaced for tools more suited for data analysis. If you can't live without your metrics spreadsheet you know what I'm talking about. Now, it is known that spreadsheets are nothing without data and that a considerable amount of time is spent filling cells in the right places to produce the information that will lead us to our valuable insights. Reducing this time, then, means having more time to analyze data. Tools like Zapier and Pluga ease our lives with this, since they already have connections with hundreds of other tools and a friendly interface to create data flows between them. Why them not use these tools?

Choosing the right plan depends on the amount of calls that will be made to them. A initial plan to process a low amount of data can be enough and cheap, but, as the volume of data increase, the more upgrades will be necessary to maintain the integration working (for reference, by the time this post was published, on August 2018, Zapier charged USD 62.50 per month on its professional plan, which allowed for up to 3.000 API calls. If more calls are needed, it is necessary to upgrade to its professional plus plan, increasing the cost to USD 156.25. Based on that, I'll consider 3.000 API calls as being a low amount, but I'll make a case that this is relative for each business and the available budget. Note that, in the process of sending leads to external tools automatically, a call is the same as sending one lead to its destination, which in this case is a spreadsheet. With Zapier's professional plan it will be possible to send up to 3.000 leads to the spreadsheet each month).

{{< image src="images/figure1-zapier-price-plans-august-2018.webp" alt="Zapier plans and features in August 2018." caption="Zapier plans and features in August 2018. Source: Zapier." title="Zapier plans and features in August 2018." lazy="true" >}}

Each integration is limited by the amount of available API calls for each plan, and whatever exceeds the limit is sent to a queue, scheduled to be sent once the limit is reset or the current plan is upgraded. This can still be acceptable if the spreadsheet won't be frequently fed and / or used, but ad hoc analysis, which may need fresh data, may not be done just to avoid exceeding the limit of calls. A second disadvantage is to use this integration with seasonal events, like co-marketing and events, in which usually there's a big volume of leads. If not thought out, this abnormal amount of leads can surprise the team and exceed the plan, breaking the integration. In other words: escalation can be a problem. Another point: testing is required when building an integration. Testing calls to the API are still calls and are still deducted from the plan. There is another way to build such integration, avoiding each of those problems.

## The secret (or not) recipe behind the integration

From plan PRO onward, {{< anchor href="https://www.rdstation.com/" target="_blank" >}}RD Station{{< /anchor >}} allows for developers to integrate the automation marketing tool with other tools using what are called APIs and webhooks, interfaces -- or doors -- that allows for data to flow in and out of the system. APIs open a communication channel with RD Station through programming interfaces, while webhooks send event notification and data to specified destinations. If you're interested in learning more about APIs, check these posts:

- {{< anchor href="/en/stories/apis-e-carrinhos-de-supermercado/" >}}APIs and grocery carts{{< /anchor >}} (with no technical jargon);
- {{< anchor href="/en/stories/fundamentos-das-apis/" >}}API basics{{< /anchor >}} (with technical jargon).

In this post, we'll make use of **webhooks**.

In order for a webhook to send data somewhere, it needs two pieces of information:

- An address from where to send data;
- A trigger that will call the webhook.

This address is a URL that can listen to the webhook.

Webhooks are called when certain actions are done, called triggers. Only when triggers are executed that webhooks will notify addresses sending data. This trigger is configured inside the tool that sends them. In this case, it is RD Station.

Time to configure the spreadsheet so we can get down to business!

## Spreadsheets with scripts?

Building scripts alongside spreadsheets isn't something new, {{< anchor href="https://www.oreilly.com/library/view/vb-vba/1565923588/1565923588_ch01-6-fm2xml.html" target="_blank" >}}as Excel's VBA has been around for quite a while{{< /anchor >}}. We'll do something along these lines, but using another spreadsheet manager, another scripting tool and a different programming language. We'll use {{< anchor href="https://www.google.com/sheets/about/" target="_blank" >}}Google Sheets{{< /anchor >}} to manage spreadsheets, {{< anchor href="/en/stories/uma-introducao-ao-google-apps-script/" >}}Google Apps Script{{< /anchor >}} to develop the script and Apps Script as the programming language, created by Google and based on Javascript. Those who are familiar with Javascript will notice a lot of similarities between this language and Apps Script, which brings an immediate benefit for using it, as the learning curve gets shorter. Also, if you're learning Apps Script, you'll immediately get familiarity with Javascript and the inner workings of web applications. As for the spreadsheet management tool, one advantage of Google Sheets specifically is that the tool is already on the cloud and ready to be enhanced with plugins that can open external connections with other software. This means that we won't have to build code specifically to "open a door" and establish a communication channel for transporting data as this was already done for us.

## Hands on: configuring the spreadsheet

Let's begin with Google Sheets. Create a new spreadsheet on your account. With a new spreadsheet, navigate to Tools > Script Editor.

{{< image src="images/figure2-google-sheets-script-editor.webp" alt="Menu entry to access the Script Editor on Google Sheets on August 2018." caption="Menu entry to access the Script Editor on Google Sheets on August 2018. Source: Author." title="Menu entry to access the Script Editor on Google Sheets on August 2018." lazy="true" >}}

Google Apps Script editor will be shown.

{{< image src="images/figure3-google-apps-script-editor.webp" alt="Google Apps Script editor opened." caption="Google Apps Script editor opened. Source: Author." title="Google Apps Script editor opened." lazy="true" >}}

There are three main sections on Google Apps Script's editor: the toolbar, on top, project files panel, on the left, and the code editor, on the right. The {{< anchor href="https://developers.google.com/apps-script/reference/" target="_blank" >}}documentation{{< /anchor >}} is a good place to start if you need to familiarize yourself with both the editor and the language.

The first step will be to inform Google Apps Script (which I'll be calling GAS from now on) that the script will be receiving and managing external data, or that the script will be communicating with the external world. On GAS terms, this script will be a web application (or web app). To do that, clear the default code on the editor that was created inside the file Code.gs, and create two new functions, called doGet and doPost. Both receive an argument called "e" that represent data that was passed when calling the script.

{{< highlight javascript >}}
function doGet(e) {
  // Todo
}

function doPost(e) {
  // Todo
}
{{< /highlight >}}

The function doGet manage any data that is passed as URL parameters. If, for instance, script URL is https://script.google.com/d/id_do_script/exec?nome=Henrique&cargo=cientista_de_dados, what is on the right side of the question mark are all parameters passed as key=value pairs, separated by an equal sign. The first key, in this example, is "name" and its value is "Henrique". Key value pairs are separated with ampersands (&).

{{< image src="images/figure4-doget-dopost-functions.webp" alt="doPost and doGet functions created." caption="doPost and doGet functions created. Source: Author." title="doPost and doGet functions created." lazy="true" >}}

To be characterized as a web app, this script needs only one of these functions. We've declared doGet in case the web app is accessed directly with a GET method (unlikely, but possible). If this function is not declared, a directly access to the URL would result in a message like "The script finished execution but there is nothing to be returned". By just declaring the function the output will be a blank screen. We'll leave as is.

The function that will receive and manage data from RD Station is doPost. It accepts data passed alongside the body of a message using the POST method.

To begin with, we'll write the code that will manage the data and write it in the spreadsheet. Inside doPost write the following code:

{{< highlight javascript >}}
// Check if POST call contains data in its body and that the data is formatted as JSON
if (e.postData.contents && e.postData.type == 'application/json') {
   // In case there's JSON data, it must be transformed into an object to be further processed
  var lead = JSON.parse(e.postData.contents);

  // Call a function to write the data into the spreadsheet. This function will be created
  writeMessage(lead);
}
{{< /highlight >}}

This code is doing the following:

- Check if POST parameter have data and this data is formatted as JSON. If it is, the webhook successfully delivered data for a new lead to the URL;
- If there's data, do what is called parse, that is, transform the object that arrived to one that is recognized in Javascript. Apps Script use the same class and method to parse JSON strings, which is JSON.parse(). This method receive a string to be parsed, which will be the data contained in the webhook. The parsed text is stored at a variable called lead;
- The next line call a function writeMessage, which receives an argument. We'll send the lead that was just parsed.

The next step is to create writeMessage. Write the following code on the same file:

{{< highlight javascript >}}
function writeMessage(message) {
  // Open the spreadsheet and select the sheet Sheet1
  var sheet = SpreadsheetApp.getActiveSpreadsheet().getSheetByName('Sheet1');

  // Select a range of cells that will store headers. Arguments are, in order: first line, first row, last line, last row. The combination will create a range with all cells between first and last selected rows and columns
  var headers = sheet.getRange(1, 1, 1, 8);

  // Write down the names of the columns into Sheet1
  headers.setValues([['Nome', 'Email', 'Data de Criação', 'Empresa', 'Origem da Primeira Conversão', 'Estágio no Funil', 'Lead Scoring', 'Interesse']]);

  // Lock Sheet1 so only the user that holds the lock can write on it
  var lock = LockService.getScriptLock();

  // Wait for one second until the next lines of code finish
  lock.waitLock(1000);

  // Browse the data that arrived from the webhook
  for (var i = 0; i < message.leads.length; i++) {

    // Write down the data into Sheet1
    sheet.appendRow([message.leads[i].name,
                       message.leads[i].email,
                       message.leads[i].created_at,
                       message.leads[i].company,
                       message.leads[i].first_conversion.source,
                       message.leads[i].lead_stage,
                       message.leads[i].fit_score,
                       message.leads[i].interest]);

    // Update sheet with a new line
    SpreadsheetApp.flush();
  }

  // Release the lock on Sheet1 so other users can write to this sheet
  lock.releaseLock();
}
{{< /highlight >}}

Spaces and comments may give the impression that this code is doing a lot of things, when in reality it is not. It is doing the following:

- Open the spreadsheet bound to the script and select a sheet called Sheet1. SpreadsheetApp is the name of the class that manage spreadsheets on Google Sheets;
- Select the range that will contain headers. To write data into a sheet, one must first select a cell or interval where data will be stored. There are many properties that can be extracted from each lead sent by the webhook, including custom fields. To make things easier, we'll select only some default properties from RD Station;
- Write down all headers into the first line of Sheet1. The method setValues expects a multidimensional list, this is why values are passed into lists with two dimensions;
- If the automation flow is configured to accept both new and current leads in segmentation lists, all existing leads will be sent simultaneously to the spreadsheet, on very short intervals. This creates a problem, because the script can't manage many concurrent requests and overlap lines, causing data losses. To avoid the problem, we use the class LockService, that manage multiple requests to the script;
- Method waitLock is use to lock given sections of code, ensuring that only one execution is done per user. In the meanwhile, other requests that come in are queued and scheduled to be processed as each lock is released;
- A for loop is used to navigation on the object that was received by the webhook. This loop will stop once a variable called i is equal to the amount of leads that were sent by the webhook (except for the case when the automation flow is configured to send both new and current leads to the script, the webhook should only send one lead at a time, so this for loop will set i to be zero and increment it only once before finishing the loop);
- For each loop, add a new line to Sheet1 containing the fields that were selected. Note that the object message have a property called leads, which is a list. To iterate over this property we use the variable i, which is incremented after each loop. The method appendRow is smart enough to find the last line with data and fill the next one, ensuring that no data will be overwritten;
- After being written, the sheet is updated using the method flush from SpreadsheetApp. Writing operations are grouped to be executed together, increasing the performance of the web app. In this case we need the line to be written immediately after having the data available, as the lock must be released as soon as possible;
- The lock is released after data has been wrote and other requests can arrive.

This code is executed inside doPost every time a lead is sent by a webhook. Note that the header is written every time a new lead arrives. This could have been done differently, by first checking if headers are present, but we'll leave as it is for simplicity. Lines with lead data aren't overwritten thanks to the security lock that was applied to avoid multiple requests inside the for loop.

The next step is to publish the web app. Publish the app means making it public, what is required in order for RD Station to send the data. To publish the app, navigate to Publish > Deploy as a Web App. Select the project version (in this case will be New) and describe what is being deployed. Under permissions, choose your user to authenticate the script and allow for any user to access it, even anonymous users, so RD Station can connect with the script. After clicking "Deploy", GAS will ask you to authorize the script to write on spreadsheets and connect to external services using your credentials. Onde authorized, the app will be published and its public URL will be made available. This is the URL that will be passed to RD Station as we configure everything.

Update November 10, 2021: this procedure is now done by using a button called "Deploy", located at the top right section of the screen. It is necessary to create a new deploy, click in the cog icon that stands for the kind of deploy and select the web app option. Remaining steps are the same and the public URL is created after publication.

{{< image src="images/figure5-deploy-web-app.webp" alt="Creation of a new deploy in August 2018." caption="Creation of a new deploy in August 2018. Source: Author." title="Creation of a new deploy in August 2018." lazy="true" >}}

{{< image src="images/figure6-web-app-url.webp" alt="Published web app with a public URL in August 2018." caption="Published web app with a public URL in August 2018. Source: Author." title="Published web app with a public URL in August 2018." lazy="true" >}}

The next step is to configure RD Station to send data to the spreadsheet, but before that, there is something that you should be aware of: by allowing anyone to execute the script, a security breach is opened that may allow for unintentional data to be sent. This script, working a server, is allowed to receive any POST and GET requests. It is vital to sanitize the data to ensure no malicious data gets to the application.

## More hands on: RD Station

RD Station provides two ways to configure webhooks: using the option to create webhooks that can be found under Account Name > Integration or by using automation flows. What differs between the two is that when creating webhooks using the Integration menu, it is only possible to use new opportunity or conversion as triggers, while with automation flows it is also possible to use segmentation lists as triggers. I'll show both ways, as well as when to use each one. Let's begin by using the option that's available under Integration. Select "Configure" next to webhooks to open the list of webhooks and then "Create" on the top right portion of the page. This will present a webhook creation popup window.

{{< image src="images/figure7-rd-station-webhook.webp" alt="New webhook creation screen at August 2018." caption="New webhook creation screen at August 2018. Source: Author." title="New webhook creation screen at August 2018." lazy="true" >}}

Webhook name is an internal identifier. URL is the address from which the webhook will send data on each lead. This is the URL that was created when publishing a web app through GAS. Triggers can be conversion or new opportunity. If new opportunity is choose you just have to save and the webhook will be created. If conversion is choose, it is possible to choose a specific conversion event or leave the field blank. Doing this will result in all conversions being sent to the webhook. Once saved, RD Station will start sending data through the webhook every time that the chosen event triggers.

The second way of creating a webhook is by using automation flows. I'll use this form on this post, as this will make use of segmentation lists as a trigger. Using an automation flow allows to add steps between the trigger and calling the webhook. This way you can, for instance, notify an e-mail address when a lead is sent, add a tag or change the step of the lead on the funnel.

To configure webhooks using automation flows, go to Relationship > Marketing Automation and add a new automation flow. Choose between parallel and managerial and give a name to this flow. Choose the event that will start the automation flow, which can be conversion or upon entering a segmentation list. Build the flow according to your needs and for the last step add the webhook action, which is called "Send to URL (integration)". The URL that is being asked is the one that was generated when publishing the web app on GAS. {{< anchor href="https://ajuda.rdstation.com.br/hc/pt-br/articles/115001273943" target="_blank" >}}RD Station documentation{{< /anchor >}} suggests adding a step to wait a minute between entering a segmentation list and sending it through the webhook.

Update November 10, 2021: RD Station dropped support for managerial automation flows. Every automation flow is now parallel.

{{< image src="images/figure8-automation-flow-send-to-web-app.webp" alt="Automation flow setup to send data to a spreadsheet in August 2018." caption="Automation flow setup to send data to a spreadsheet in August 2018. Source: Author." title="Automation flow setup to send data to a spreadsheet in August 2018." lazy="true" >}}

Update November 10, 2021: RD Station automation flow editing interface is different from the one shown here, but steps remain the same.

Upon finish editing, save and activate the automation flow. By now, the integration should be working and when a new lead enters the automation flow, it will be sent to the script, which in turn will manage the data and record it on the spreadsheet.

{{< image src="images/figure9-populated-spreadsheet.webp" alt="Data on new leads being written on a spreadsheet in August 2018." caption="Data on new leads being written on a spreadsheet in August 2018. Source: Author." title="Data on new leads being written on a spreadsheet in August 2018." lazy="true" >}}

Every time that a new lead joins the list, it will also enter the automation flow and will be sent to the spreadsheet. Since we've used appendRow, new leads won't replace existing data.

Big lists can take a while before being recorded on the spreadsheet and an option is to download the entire list, import it to Google Sheets and integration only new leads. RD Station limit the amount of calls made to its APIs and webhooks based on what plan the company have. For reference, i've contacted support on August 30, 2018 and was informed that these are the current limits:

- 120 conversions per minute for plans Pro and inferior;
- 500 conversions per minute for Enterprise plans.

These limits are quite comfortable for small companies that are trying to scale and have low budgets. It is also important to have in mind the maximum amount of cells that Google Sheets can handle, {{< anchor href="https://support.google.com/drive/answer/37603?hl=en" target="_blank" >}}which is 2,000,000{{< /anchor >}}. This number is used to determine the amount of rows and columns that the file can hold. The smaller the number of rows, the bigger the number of lines and vice versa.

Update November 10, 2021: The current amount of cells a Google Sheets file can handle is 5,000,000.

Done! Every time that a new lead fulfill certain conditions inside RD Station, it will be automatically sent to a spreadsheet.

## Further reading

Check out the part 2 of this post and know how to send data from RD Station to AWS: {{< anchor href="/en/stories/rd-station-e-google-sheets-na-aws/" >}}RD Station and Google Sheets Part 2 - Migrating to AWS{{< /anchor >}}.

Let's automate!
