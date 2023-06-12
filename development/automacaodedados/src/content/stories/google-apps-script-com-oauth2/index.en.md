---
title: 'Google Apps Script with OAuth2'
author: henriquesouza
publishDate: 2018-01-29 14:42:00
lastMod: 2021-11-07 14:42:00
summary: Google Apps Script is packed with many features to enhance other Google products. One of these features allows Google apps to connect with third party services. This feature will be presented throughout this post, focusing on APIs that authenticate using OAuth2 protocol.
description: Google Apps Script with OAuth2
image_description: 'OAuth2 authentication flow.'
categories:
- Automation
featured: true
---

Published on January 29, 2018 and updated on November 07, 2021.

Update November 07, 2021: Since this post was published, Google Apps Script had many updates, including changes to the interface, the adoption of ES6 for writing Javascript, a new log output system and a new trigger management system. Authenticating on services that use OAuth2, though, works the same way as the time of the original publication.

## What is OAuth2?

It is the second version of an authentication protocol that grant permissions to resources based on the privileges of the user that is trying to access them. OAuth protocol was mentioned on this blog, when discussing {{< anchor href="/en/stories/fundamentos-das-apis/" >}}the fundamentals of APIs{{< /anchor >}}.

## Why use OAuth?

Other methods of authentication, such as API keys, require developers to manipulate and store these keys safely somewhere. Although some services implement restrictions around the usage of keys, it is still up to the developer to secure the keys. Another problem with keys is that they usually disregard the level of privileges that users using it have, making it difficult to grant the right permissions to the right users. OAuth protocol implement the concept of tokens, keys that expire, grant specific privileges and are bound to a single authenticated user.

To illustrate the difference between authenticating with OAuth and API keys, imagine the following: someone arrives at a hotel and ask for a room. The manager then gives the guest a handful of keys that opens all doors, even if the guest is only going to use one room. At the end of the stay, the guest check out and forget to give the keys back to the manager. The stay was so good that he recommended the hotel to a friend, to whom he gave the whole set of keys. At the end of the stay, the second guest organized a party and wrecked the whole room. In this example, API keys is the equivalent to the handful of keys. These keys do not expire, open every room and anyone can use.

Imagine now a new scenario: the same person goes to a hotel and asks for a room. The manager then asks for how many people and if the guest have any particular preferences. After answering all questions, the manager find the appropriate key, give it to the guest and informs the room number. At the end of the stay, the guest give the key back to the manager and leave the hotel. The experience was very nice and this person recommend the hotel to a friend. The friend then go to the hotel and meet the manager, who ask the same questions about size and preferences in order to find the best room. Upon answering the questions, the manager then give another key to the guest, which opens up a different room. At the end of the stay, the new guest give they key back to the manager and leave. In this second example, the key is a OAuth token. This key is used by specific users to access specific resources and is in possession of the user as long as he's hosted in the hotel. This is the idea behind OAuth: authentication and privileges are managed with security in mind. Even if another user have an access token, this token will not have use if it was not granted to him.

## OAuth2 protocol authorization flow

A OAuth2 authorization flow works as follows:

- Users initiate the process by triggering some event, such as a button click;
- Users are then required to provide access credentials;
- If provided credentials are correct, the user is identified. On the contrary, the system will block access to protected resources;
- Authenticated users receive access tokens that grant the amount of privileges as defined by the owner of protected resources;
- Users ask for protected resources and send their access token to confirm their identities;
- If both user and token are recognized, restricted data is sent back to the user.

This flow looks like the one from the following image, made by {{< anchor href="https://www.digitalocean.com/" target="_blank" >}}Digital Ocean{{< /anchor >}}:

{{< image src="images/figure1-oauth2-authentication-process.webp" alt="OAuth2 authentication flow." caption="OAuth2 authentication flow. Source: Digital Ocean." title="OAuth2 authentication flow." lazy="true" >}}

## How does OAuth2 and Google Apps Script are used together?

External services may use different approaches when authenticating and authorizing users, and sometimes have more than one. Google apps, for instance, may use both API keys and OAuth2. Google Apps Script have no native support to OAuth2, but there are external libraries that can be added to projects. Let's see how this works by connecting a spreadsheet created on Google Sheets with {{< anchor href="https://search.google.com/search-console/about" target="_blank" >}}Google Search Console{{< /anchor >}} (former Webmaster Tools).


### 1. Create a new file on Google Sheets

Create a new file, then go to Tools > Script Editor. The script editor is Google Apps Script.

{{< image src="images/figure2-google-apps-script-editor.webp" alt="Google Apps Script file editor." caption="Google Apps Script file editor. Source: Author." title="Google Apps Script file editor." lazy="true" >}}

With the exception of Code.gs, all files were created by me. The first step is to install the library that implements OAuth2. With the editor opened, go to Resources > Libraries. The field "Find a Library" is a search engine for libraries. The code associated with the library used throughout this post is **1B7FSrk5Zi6L1rSxxTDgDEUsPzlukDsi4KGuTMorsTQHhGBzBkMun4iDF**. It suffice to paste this code into the field and the library will show up. Select the latest version (24 by the time this post was published) and hit OK.

{{< image src="images/figure3-google-apps-script-oauth2-plugin.webp" alt="OAuth2 library, made by Google." caption="OAuth2 library, made by Google. Source: Author." title="OAuth2 library, made by Google." lazy="true" >}}

### 2. Setup the project that was associated with the script on Google Cloud Console

{{< anchor href="https://console.cloud.google.com/" target="_blank" >}}Google Cloud Console{{< /anchor >}} is a platform that host apps built and used by Google services, like plugins. Custom apps and access credentials are managed on Google Cloud Console. To access Google Cloud Console go to Resources > Cloud Platform project. A popup window will provide a link with format [script-name]-project-id-[project-id], where [script-name] is the name given to the script associated with the spreadsheet and [project-id] is a random identifier assigned by Google Cloud Console.

{{< image src="images/figure4-google-cloud-project-id.webp" alt="Google Cloud Project's ID associated to the script." caption="Google Cloud Project's ID associated to the script. Source: Author." title="Google Cloud Project's ID associated to the script." lazy="true" >}}

Projects created on Google Apps Script will also create Google Cloud Console projects, where access credentials for third party services are managed.

{{< image src="images/figure5-google-cloud-project-info.webp" alt="Google Cloud Console project's dashboard." caption="Google Cloud Console project's dashboard. Source: Author." title="Google Cloud Console project's dashboard." lazy="true" >}}

One the project is open, it is necessary to select all Google services to be used. There is one for Search Console, which will be used for this post. Within the section "Getting Started" click at "Enable APIs and get credentials like keys". On the sidebar, go to "Library" and search for "Search Console" in the search box. The first result is from an API called "Google Search Console API". Choose this option and click at the button labeled "Enable".

{{< image src="images/figure6-google-search-console-api.webp" alt="Google Search Console API connection service." caption="Google Search Console API connection service. Source: Author." title="Google Search Console API connection service." lazy="true" >}}

After selecting the API, it is necessary to inform how users will authenticate when retrieving data through this API. There are basically two authentication methods: authentication keys and OAuth2. This post will use the option OAuth2. In the sidebar, choose the option "Credentials" and in the next screen, click in "Create credentials". In the following drop down, select "OAuth client ID".

{{< image src="images/figure7-google-cloud-project-credentials.webp" alt="First step when setting up new Google Search Console API credentials." caption="First step when setting up new Google Search Console API credentials. Source: Author." title="First step when setting up new Google Search Console API credentials." lazy="true" >}}

Google Cloud Console will ask what kind of app is being built. Select the option "Web application" and fill the required fields. There are two required fields, which are the name of the app and at least one redirect URL, which will be used to redirect users after authentication process. This URL will be the one assigned to the script created at Google Apps Script. This URL will be something like https://script.google.com/macros/d/[SCRIPT ID]/usercallback, where [SCRIPT ID] is a random identifier generated by Google Apps Script when the project was created. This id can be found in File > Project properties. Copy the id and set up the URL.

Once the project is configured, the following information will be provided in Google Cloud Console: a CLIENT ID and a CLIENT SECRET. These will be used to build another URL, the authentication URL. Copy this information and close Google Cloud Console.

### 3. Write the code that will authorize and access the API

Now that Google Cloud Console is ready to manage external requests it is possible to call this service from Google Apps Script, given that there are credentials with access to Search Console data. The first thing to be done is to write the code that will be used to authenticate users that will access Search Console data from the spreadsheet. There is a default file created in the editor called Code.gs and an empty function. I've created a new file declaring global variables to ease maintenance. In this newly created file, declare the following variables:

{{< highlight javascript >}}
var CLIENT_ID = 'YOUR_CLIENT_ID';
var CLIENT_SECRET = 'YOUR_CLIENT_SECRET';
var SCOPE = 'https://www.googleapis.com/auth/webmasters.readonly';
var SITE = 'YOUR_SITE_ON_SEARCH_CONSOLE';
{{< /highlight >}}

CLIENT_ID and CLIENT_SECRET are credentials provided by Google Cloud Console when creating an authorization method. Replace both "YOUR_CLIENT_ID" and "YOUR_CLIENT_SECRET" with the ones that were copied from Google Cloud Console. Access scopes are a requirement for any OAuth2 flow and grant specific access permissions. All access scopes for OAuth2 flows at Google are available on the {{< anchor href="https://developers.google.com/identity/protocols/googlescopes" target="_blank" >}}documentation page{{< /anchor >}}. Search Console have two scopes: readonly, which grants read privileges, and webmasters, which grants read and write privileges. This post will use readonly. The variable SITE declare the website that is registered in Search Console, whose data will be returned. The name of this website should match the one registered on Search Console. If the website is, for instance, http://henriquefreitas.com.br, this variable should be filled accordingly.

Create a new file on File > New > Script file. Give a name and hit OK. In this file, write the code that instantiate the OAuth2 object and start the authorization flow:

{{< highlight javascript >}}
function getService() {
  return OAuth2.createService('searchconsole')
      .setAuthorizationBaseUrl('https://accounts.google.com/o/oauth2/auth')
      .setTokenUrl('https://accounts.google.com/o/oauth2/token')

      .setClientId(CLIENT_ID)
      .setClientSecret(CLIENT_SECRET)

      .setCallbackFunction('authCallback')

      .setPropertyStore(PropertiesService.getUserProperties())

      .setScope(SCOPE)

      .setParam('login_hint', Session.getActiveUser().getEmail())
      .setParam('access_type', 'offline');
}

function authCallback(request) {
  var service = getService();
  var isAuthorized = service.handleCallback(request);
  if (isAuthorized) {
    return HtmlService.createHtmlOutput('Authenticated. You can close this tab.');
  } else {
    return HtmlService.createHtmlOutput('Access denied. Check your credentials and try again. You can close this tab.');
  }
}
{{< /highlight >}}

Note that the variables that were created at the global variables file are recognized in this file. The function getService is responsible for creating and returning an OAuth2 object with defined scope and authentication flow. Different methods are chained to produce the final object:

- setAuthorizationBaseUrl build the authentication URL. This URL is built using data such as CLIENT ID and CLIENT SECRET, making it unique for each user. The base section, though, is the same and defined on this method;
- setTokenUrl is the URL that will return valid authentication tokens for authorized users;
- setCallbackFunction points to a function that will be executed after the authentication flow finishes;
- setPropertyStore registers where tokens will be stored;
- setScope set access scope;
- setParam add custom configurations. Parameter login_hint prevent login screens to be shown to users logged in more than one Google account. Parameter access_type authorize offline usage.

The function authCallback is triggered every time getService is called. This checks if users are authenticated and informs them. A sidebar is opened in the browser showing messages for login attempts.

Create another file in File > New > Script file. Name this file and hit OK. This is the file that will request data from Search Console through its API. Write the following code:

{{< highlight javascript >}}
function getSearchConsole() {
  var apiUrl = 'https://www.googleapis.com/webmasters/v3/sites/' + SITE + '/searchAnalytics/query?fields=rows&alt=json';
  var response = getSearchConsoleData(apiUrl, ['query']);

  if (response) {
    var json = JSON.parse(response);

    if (!json.error) {
      var reportHeaders = [['Keyword', 'Clicks', 'Impressions', 'CTR', 'Position']];
      displaySearchConsoleData(json, reportHeaders, 1, 1);
    }
  }
}

function getSearchConsoleData(url, dimensions) {
  var response = null;
  var headers, payload, options;
  var startDate = Utilities.formatDate(new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000), Session.getScriptTimeZone(), 'yyyy-MM-dd');
  var endDate = Utilities.formatDate(new Date(), Session.getScriptTimeZone(), 'yyyy-MM-dd');
  var service = getService();

  if (service.hasAccess()) {
    headers = {'Authorization': 'Bearer ' + service.getAccessToken() };
    payload = {
      'startDate': startDate,
      'endDate': endDate,
      'dimensions': dimensions
    };
    options = {
      'headers': headers,
      'contentType': 'application/json',
      'method': 'post',
      'payload': JSON.stringify(payload),
      'muteHttpExceptions': true
    };

    try {
      response = UrlFetchApp.fetch(url, options);
    } catch (e) {}

  } else showDialog();

  return response;
}

function displaySearchConsoleData(json, reportHeaders, numKeys, initialColumnPosition) {
  var searchConsoleData = spreadsheet.getActiveSpreadsheet().getSheetByName('Search Console');
  var report = [];

  for (var i in json.rows) {
    var keys = [];
    for (var j = 0; j < numKeys; j++) {
      keys.push(
        json.rows[i].keys[j]
      );
    };
    report.push(keys);

    report[i].push(
      json.rows[i].clicks,
      json.rows[i].impressions,
      json.rows[i].ctr,
      json.rows[i].position
    );
  };

  searchConsoleData.getRange(1, initialColumnPosition, 1, reportHeaders[0].length).setValues(reportHeaders);
  searchConsoleData.getRange(2, initialColumnPosition, report.length, reportHeaders[0].length).setValues(report);
}
{{< /highlight >}}

This code was split along different functions to modularize the project. It is possible to make different API call specifying different views of data. What this code does is:

- Function getSearchConsole build the API endpoint where data is;
- Next, call this URL using getSearchConsoleData which was created accepting as parameters the URL and a list with just one item: query. Query is the option that return searched keywords that resulted in search results being printed or clicked at SERP (Search Engine Results Page). There are other options, such as page, device, country, search type and date. To return more than one option, just pass it to the list, for instance: ['query', 'page', 'device']. This list will result in the dimensions that will be returned along with all metrics;
- Check response to see if there's any data;
- If there is data, decode the string, which is in JSON, and write the data into the spreadsheet using the method displaySearchConsoleData, created at the end of the file. This method receive as parameters the data that was returned from the API already decoded, a multidimensional list of headers that will identify each column of data, a number of keys that align with specific section of the decoded object and the column number from which the table of data will begin.

Calls to Google Search Console API will return objects like the following one:

{{< highlight javascript >}}
{
  {
    keys: {
      query: 'keyword'
    },
    clicks: 1000,
    impressions: 1000,
    ctr: 1.0,
    position: 3.2
  },
  {
    keys: {
      query: 'another_keyword'
    },
    clicks: 2000,
    impressions: 3000,
    ctr: 0.6,
    position: 1.2
  }
}
{{< /highlight >}}

The section keys hold the dimensions (or qualities) of data, and all metrics are alongside the remaining properties of the object. The parameter that contains the number of keys corresponds to the number of dimensions that were returned. This is done so the print function build the data table correctly. The last parameter defines from which sheet column the function should start writing the table.

Function getSearchConsoleData, called by getSearchConsole, does the following:

- Use getService to access the OAuth2 instance to see if the user is authorized to access Search Console data;
- If it is, objects with request headers and some configurations (start date, finish data and dimensions) are created to be sent along the request;
- Call Search Console API using a static method available on Google Apps Script: UrlFetchApp.fetch(url, options). This method return an HTTPResponse object with resulting data and response headers;
- Any data returned by this call will be stored on a variable called response, which is then returned to the requester;
- Method showDialog, called when users aren't logged in, will be created further down the line.

Function displaySearchConsoleData show in the spreadsheet the data that was returned from the API and receive as parameters the decoded object, a list of headers in a multidimensional array and the aforementioned number of keys and the number of the column that will start the report. It works the following way:

- Open a sheet inside the spreadsheet called Search Console (check if the name of the sheet where Search Console data will be stored matches the sheet name here);
- Iterate over the object, accessing its properties;
- Store all dimensions in an array called keys;
- Store this newly created array inside another one called report;
- Iterate over all Search Console metrics properties, adding them to the reports list;
- Write both table headers and data into the selected sheet.

## 4. Build an interface that will allow users to call the API

Up to this moment there is no way to interact with this script from the spreadsheet. In Google Apps Script editor, create a new file and write the following code:

{{< highlight javascript >}}

function showSidebar() {
  var service = getService();
  var page, template;

  if (!service.hasAccess()) {
    var authorizationUrl = service.getAuthorizationUrl();
    template = HtmlService.createTemplate(
      '<h1>Autentication</h1> ' +
      '<a href="<?= authorizationUrl ?>" target="_blank">Authorize this script to access Search Console data on your behalf.</a>. ' +
      '<p>Why do I have to do this?</p> ' +
      '<p>This app needs your permission in order to access data stored on Google Search Console.</p>'
    );
    template.authorizationUrl = authorizationUrl;
  } else {
    template = HtmlService.createTemplate('This script is already authorized to access data on Search Console. This tab can be closed.');
  }

  page = template.evaluate();
  SpreadsheetApp.getUi().showSidebar(page);
}

function showDialog() {
  service = getService();
  if (!service.hasAccess()) Browser.msgBox('Authorize this script to access data on Google Search Console on your behalf. Access Search Console > Login.', Browser.Buttons.OK);
}

function getData() {
  try {
    getSearchConsole();
  } catch (e) {
    Browser.msgBox(e, Browser.Buttons.OK);
  }
}

function onOpen() {
  var ui = SpreadsheetApp.getUi();
  ui.createMenu('Search Console')
      .addItem('Login', 'showSidebar')
      .addItem('Refresh data', 'getData')
      .addToUi();

  showDialog();
}
{{< /highlight >}}

Function showSidebar show a sidebar with a link to iniciate an OAuth2 flow. In case the user is already authenticated, this information will be known to him on this sidebar.

Function showDialog show a message instructing users to browse to Search Console > Login. The function that build this menu will be created on this same file.

Function getData call Search Console API. If it fails, users are presented with an error message.

Function onOpen have a special meaning inside Google Apps Script. It is automatically executed whenever the file that is attached to the script, in this case a spreadsheet, is opened. Whenever opened, this function will create a menu called Search Console with two options: Login, to open the sidebar with a link to initiate the authentication flow, and Refresh data, which makes a new API call to Search Console.

### 5. Automate API calls (optional)

By now, every time that this code runs, the last seven days of data will be returned from Search Console. It is possible, though, to automate these calls so users don't have to access the menu every time they need fresh data. To do this, go to the script editor and access Edit > Current project's triggers. This options can be also accessed from the toolbar, represented with an icon of a clock. Both ways will show a modal with an option to create triggers. Try to create a new trigger that calls the function getData hourly, for instance. Hit the save button. At each hour this function will be called and fresh data will populate the spreadsheet automatically!

{{< image src="images/figure8-google-apps-script-run-trigger.webp" alt="Trigger configured to automatically run the function that updates the spreadsheet with Search Console data." caption="Trigger configured to automatically run the function that updates the spreadsheet with Search Console data. Source: Author." title="Trigger configured to automatically run the function that updates the spreadsheet with Search Console data." lazy="true" >}}

## Automation with Google Apps Script

Scripts like the one shown in this post are extremely useful to automate repetitive tasks and relocate teams on more strategic tasks for the department they work or for the entire company. Automate and add features to existing Google Products are just some of Google Apps Script's capabilities. Implementation presented in this post can be used to backup search terms and volumes for the configured Search Console property. Search Console stores twelve months of data, making backups a necessity in order to have old data to analyze. To do this, the script presented need a slight change so that fresh data do not override previous lines. Once this is adjustes it is done! Automated backups are in place.

## Further reading

Read the following to have a deep understanding of Google Apps Script and OAuth2 protocol:

- {{< anchor href="https://github.com/googlesamples/apps-script-oauth2" target="_blank" >}}OAuth2 library{{< /anchor >}} created by Google and used throughout this post;
- {{< anchor href="https://developers.google.com/apps-script/overview" target="_blank" >}}Google Apps Script documentation{{< /anchor >}};
- The post on {{< anchor href="/en/stories/fundamentos-das-apis/" >}}API basics{{< /anchor >}} written on this blog;
- The post on {{< anchor href="/en/stories/uma-introducao-ao-google-apps-script/" >}}Google Apps Script basics{{< /anchor >}} written on this blog;
- {{< anchor href="https://aaronparecki.com/oauth-2-simplified/" target="_blank" >}}OAuth basics, por Aaron Parecki{{< /anchor >}};
- {{< anchor href="https://developers.google.com/identity/protocols/OAuth2" target="_blank" >}}OAuth2 with Google Apps{{< /anchor >}};
- {{< anchor href="https://developers.google.com/oauthplayground/" target="_blank" >}}OAuth2 sandbox for testing authentication with Google Services{{< /anchor >}};
- {{< anchor href="https://developers.google.com/apis-explorer/#p/" target="_blank" >}}List of endpoints and addresses for testing Google' APIs{{< /anchor >}}.

Let's automate!
