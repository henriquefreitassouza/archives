---
title: 'An overview of Google Apps Script'
author: henriquesouza
publishDate: 2017-11-20 15:05:00
lastMod: 2021-10-18 15:05:00
summary: In a previous post I briefly presented Google Apps Script, a tool capable of enhancing the default features of any Google apps. In this post, I will make its proper introduction and show how to use it to automate data collection and treatment tasks.
description: Understand the fundamentals of Google Apps Script and get to know how to use it to automate tasks.
image_description: 'Google Apps Script home website page.'
categories:
- Automation
featured: true
---

Published on November 20, 2017 and updated on October 18, 2021.

Update October 18, 2021: on this date, it is possible to use Javascript's ES6 features to write scripts on Google Apps Script.

I've used Google Apps Script for the first time when I needed to transport data from external sources to a spreadsheet on Google Sheets. The task I had to accomplish was similar to the one I've described on my {{< anchor href="/en/stories/geracao-de-relatorios-automatizados-por-apis/" >}}previous post{{< /anchor >}}: ingest and transform data to feed the correct cells on the spreadsheet. I've been studying the tool since, trying to understand what else it can accomplish. I've figured out many interesting things, some of which I'm going to share on this post.

## Google Apps Script

The tool is a script editor that can execute code from a language very similar to Javascript. With it, it is possible to create apps that are executed alongside Google's main line of products, making those products even more personalized to any need. Those that are used with Javascript or similar languages don't have to learn a new language to start working with Google Apps Script. The difference between the Javascript that is used inside Google Apps Script is that it implements some classes and utilities to work with the other Google apps. There are also utilities to make some tasks easier, like calls to external services or work with dates and times.

Google Apps Script can do more that modify content created on apps like Google Docs, Google Spreadsheets or Google Slides. They allow developers to do things like create new options for those apps, send emails through Gmail, create and organize documents on Google Drive, consume APIs like the one from Google Maps and build workflows, just to cite some of its resources. On the documentation page there is a {{< anchor href="https://developers.google.com/apps-script/guides/support/case-studies" target="_blank" >}}showcase{{< /anchor >}} of applications made by users.

## How to use Google Apps Script

Essentially, there are two ways to create scripts using the tool: bound to an existing Google document or a standalone script.

### Bind scripts

Scripts that are created and bind to a document have all permissions to work with the document that it is bound to. Once bound, the script cannot be unbound from the document. To create a bind script, open or create a new Google document, then open the menu Tools > Script editor.

{{< image src="images/figure1-script-editor-menu-open.webp" alt="Spreadsheet opened with menu option Script Editor shown." caption="Spreadsheet opened with menu option Script Editor shown. Source: Author." title="Spreadsheet opened with menu option Script Editor shown." lazy="true" >}}

Once opened, the script editor will load with a blank file called Code.gs.

{{< image src="images/figure2-script-editor-main-screen-opened.webp" alt="Script editor main screen opened in 2017." caption="Script editor main screen opened in 2017. Source: Author." title="Script editor main screen opened in 2017." lazy="true" >}}

The panel interface is the same for both bind and standalone scripts. The left side panel shows all project files and the right side panel is the editor area. The file that is created with every new project, Code.gs, there is only one function predefined, called myFunction. Once the code is ready, it can be executed by going to Execute > Execute function > Function name, as funtion name being the name of a function that is declared.

{{< image src="images/figure3-script-editor-run-function.webp" alt="Script editor ready to run a function in 2017." caption="Script editor ready to run a function in 2017. Source: Author." title="Script editor ready to run a function in 2017." lazy="true" >}}

The console log can be used to visualize any script outputs.

{{< image src="images/figure4-script-editor-executions-logged.webp" alt="Popup window showing logs in 2017." caption="Popup window showing logs in 2017. Source: Author" title="Popup window showing logs in 2017." lazy="true" >}}

This log is different from the execution log. While the execution log register script execution outputs, the console log register data produced by the function throughout its execution. To send data to the console log, which can be used to test the output for instance, use the Logger class:

{{< highlight javascript >}}
Logger.log("Hello World!");
{{< /highlight >}}

{{< image src="images/figure5-script-editor-log-window.webp" alt="Log popup window showing user messages in 2017." caption="Log popup window showing user messages in 2017. Source: Author." title="Log popup window showing user messages in 2017." lazy="true" >}}

Another interesting Google Apps Script resource is to setup the so called triggers, that can wait for a given event to execute tasks associated with that event. Triggers can be of two types: time based and event based. Time based triggers run periodically, and the interval is set by the user, and event based triggers run when a given event occur. Some event based triggers are:

{{< highlight javascript >}}
function onEdit(e) {
  // TODO
}

function onChange(e) {
  // TODO
}

function onOpen(e) {
  // TODO
}
{{< /highlight >}}

Event based triggers are created with functions, and the code inside those functions is executed when the event happens. A practical application on Google Spreadsheets, for instance, is to update cells based on user input. Consider the example:

{{< highlight javascript >}}
function onEdit(e) {
  if (e.range.getA1Notation() == "L8") {
    var sheet = SpreadsheetApp.getActiveSheet();
    sheet.getRange("L9").setValue(e.oldValue);
  }
}
{{< /highlight >}}

This function listen the event associated with editing any cell of a spreadsheet, verify if the cell being edited correspond to the postiion L8, and then update another cell with the edited cell's previous value.

{{< image src="images/figure6-dynamically-loaded-data.webp" alt="Planilha com dados financeiros sendo atualizada automaticamente." caption="O valor da célula L9 é atualizado com base no valor da célula L8. Fonte: Autor." title="O valor da célula L9 na aba ativa é atualizado com base no valor da célula L8." lazy="true" >}}

{{< image src="images/figure6-dynamically-loaded-data.webp" alt="Spreadsheet with financial data updated automatically." caption="The value at cell L9 is updated whenever the contents of L8 cell are updated. Source: Author." title="The value at cell L9 is updated whenever the contents of L8 cell are updated." lazy="true" >}}

Triggers that are time based can be configured on the Triggers menu option, shaped after a clock. This trigger is configured by defining the moment that it will occur (when the file is opened or changed), and the time interval at which the trigger will run.

There are many other possible uses for Google Apps Script. Suppose that you have a document containing a list of contacts stored on Google Drive. You can create a script to read all the contacts on this list, register them on Google Contacts, and then send an email to the contact list using Gmail. If this is a task that must happen with frequency, it is possible to setup a time based trigger and the process will be automated.

### Standalone scripts

Standalone scripts work similar to bind scripts. Unlike the former, they are visible on Google Drive as files and can be used to create Web Apps or utilities, like a task automation utility. One example would be to organize new files that are stored on Google Drive in a given folder or with a given name.

## Web Apps

Scripts can be published on the internet, with a unique address. This is useful when the script should receive data from external systems. In order to be published on the internet and to be a web app, the project must contain at least one script with two declared functions:

{{< highlight javascript >}}
function doGet(e) {
  // TODO
  // Return object from types HtmlOutput or TextOutput
}

function doPost(e) {
  // TODO
}
{{< /highlight >}}

The function doGet must return an object of either HtmlOutput or TextOutput types. To interact with the script from an external application, it must be published as a web app with proper permissions. Once it is published, external application can easily access its web address and send the data that will be used by the script.

## Additional resources

These are some of the resources provided by Google Apps Script. I suggest you to bookmark the {{< anchor href="https://developers.google.com/apps-script/" target="_blank" >}}documentation site{{< /anchor >}} on your browser, as you will use it quite often. At the {{< anchor href="https://developers.google.com/apps-script/overview" target="_blank" >}}guides{{< /anchor >}} section there are beginner level tutorials for those who want to learn by doing, under the "5-Minute Quickstarts". In the {{< anchor href="https://developers.google.com/apps-script/support" target="_blank" >}}support{{< /anchor >}} section there are links to questions asked on Stack Overflow and many other resources.

Let's automate!
