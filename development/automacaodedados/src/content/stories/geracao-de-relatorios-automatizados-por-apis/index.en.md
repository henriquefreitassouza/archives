---
title: Creating automated reports through APIs
author: henriquesouza
publishDate: 2017-11-19 13:13:00
lastMod: 2021-10-17 13:13:00
summary: Recently I had to build a repository with data that would feed some reports. The sources that would need to be ingested were scattered at least across 6 different systems and reunite all that information weekly was time consuming. I've figured out a way to make that process somewhat more efficient.
description: How to use APIs to automate report generation?
image_description: 'Dashboard being presented in a computer.'
categories:
- Automation
featured: true
---

Published on September 19, 2017. Updated on October 17, 2021.

Automate things is essential to think about productivity and scalability. Automate tasks with some degree of repetitivity means using one's time to think more strategically. In a startup environment this is simply a life or death question. A good automation pipeline can also mean cost reduction, as scalability can be achieved with little extra cost to keep the operation running. A bad automation pipeline, on the other hand, increase costs and does not scale appropriately.

Nowadays there are hundreds of tools for data management and visualization capabilities for about any business needs. Some examples are advertising management, CRM, analytics, administrative systems and many others. What happens is that the information that feed such systems must be extracted from the sources and properly treated, and there aren't always native integration channels between the sources and data platforms. In such scenarios, files like spreadsheets and documents, acting like middlewares, are manually created and filled with data from many different systems. This creates a new set of problems, such as human errors and more time working on repetitive tasks.

The solution isn't always to create a middleware. It can be simpler and cheaper. It can even use those same spreadsheets and documents that act like middlewares. Spreadsheets are extremely versatile to ingest and treat data. There are many cases when it makes sense keep a spreadsheet updated with some frequency instead of building a tool, specially if the budget is low. The work I've done resulted in one of such spreadsheets, with information to get a grasp on the financial health of the business.

## Automation with APIs

Each source from which I've needed to extract data allowed not only to export data into spreadsheet files, but also to export data in a format called JSON. The name is an acronym for Javascript Object Notation. That type of file is used to exchange messages between systems that can understand it. The following is an excerpt of a JSON file:

{{< highlight json >}}
{
  "name": "Adwords",
  "account": "xpto",
  "total_spent": "48032.44",
  "impressions": "188492"
}
{{< /highlight >}}

Each line between the brackets stores a pair, forming a key and a value. The key is an identifier and the value stores data that is identified by its key. The set of key value pairs between the brackets is called an object. A object can contain many key value pairs and keys can even store objects, forming a nested file structure.

JSON is a very useful file format, as it is a common pattern and recognized across many different technologies. All common programming languages have a way to send and receive JSON objects through the internet, and this is why it is one of the most used files to integrate digital systems. Many tools provide services that can send JSON objects to those who request them - usually other systems. These services are called APIs, or Application Programming Interfaces, gateways that deliver data under request.

## A practical example of an API

Suppose that you want to know the critic's rating for the movie Batman: The Dark Knight Returns. A database like the one {{< anchor href="http://www.omdbapi.com/" target="_blank" >}}OMDB{{< /anchor >}} provides have all the information that you need. They also provide an API to search the database. To retrieve information about the movie, you just have to access the following address: http://www.omdbapi.com/?apikey=**your_api_key**&t=Batman+The+Dark+Knight. A JSON object similar to the following one should be returned:

{{< highlight json >}}
{
  "Title": "Batman: The Dark Knight Returns, Part 1",
  "Year": "2012",
  "Rated": "PG-13",
  "Released": "25 Sep 2012",
  "Genre": "Animation, Action, Adventure",
  "Language": "English",
  "Country": "USA",
  "Awards": "5 nominations.",
  "Metascore": "N/A",
  "imdbRating": "8.0",
  "imdbVotes": "42,023",
}
{{< /highlight >}}

The highlighted portion of the address, your_api_key, is a method for authentication. This is a unique token to identify the user making the request to the API, and only authenticated users are allowed to see information about the movies. You can register for free at the OMDB website to receive an API key. The JSON object that is shown here is a simplified version, but we can see that the object contains a key called "imdbRating", with a value of 8.0. Maybe you're asking yourself what is the point of going for the trouble to find the information like that when you can simply visit the IMDB website and search for the movie. Now is the time to talk about automation: this work can be done once and scheduled to be done in regular intervals, and the object to be received will always contain the most recent information. This may not be the best example to automate searches, but imagine that this data represent the value of stocks for different companies and you're building a dashboard that will display this information refreshed hourly. This can be done by creating a routine that will call the financial API service from hour to hour and return the most recent stock prices, eliminating the need for a manual update every time the information is needed.

## Back to the automation project

Almost every tool that I've worked with had an API with a good documentation and many addresses to request different data. Once I've received the JSON object, I had to feed the data source, or the source that received and treated the external data. This source, which was also the source of the reports, was a spreadsheet created on Google Sheets. Google Sheets was chosen due to its native integration to a script editor called {{< anchor href="https://www.google.com/script/" target="_blank" >}}Google Apps Script{{< /anchor >}}. This script editor allows developers to enhance all of Google's line of office products, among other things. This tool have a very interesting resource: a utility to communicate with other systems through the internet, which is exactly what I needed.

With the script editor opened, I had just to fill in some lines of code to receive the JSON object:

{{< highlight javascript >}}
var spreadsheet = "https://sheets.google.com/id=spreadsheet1";
var sheet = SpreadsheetApp.openByUrl(spreadsheet).getSheetByName("name");
// This call will return a JSON object like the one from the previous example
var url = "http://www.omdbapi.com/?apikey=sua_api_key&t=Batman+The+Dark+Knight";
var response = UrlFetchApp.fetch(url);
var json = JSON.parse(response);
// Since I just want the review, I'll select and store only this information from the resulting object
sheet.getRange("A1").setValue(json.imdbRating);
{{< /highlight >}}

This could be done another way, but the process is the same:

- access the address;
- capture the returned JSON;
- treat the object (unserialize it);
- write the data into the spreadsheet.

I've used the OMDB example since the API is public, unlike the one I've used in the project I've worked on.

To end, Google Apps Script allows the developers to schedule scripts to execute repeatedly on set intervals. I've configured the tool to execute it hourly and it was done! I've set up an automated data ingestion pipeline. It is important to keep an eye out for API updates, but it isn't everyday that such event happens, so you can focus on understanding the data that is getting to the report and not on it's maintenance.
