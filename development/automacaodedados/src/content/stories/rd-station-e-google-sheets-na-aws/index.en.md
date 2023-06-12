---
title: 'RD Station and Google Sheets Part 2 - Moving to AWS'
author: henriquesouza
publishDate: 2020-09-03 19:23:00
lastMod: 2021-11-19 19:23:00
summary: We saw before on this blog how to send leads from RD Station to a spreadsheet automatically. Now we will see how to send these same leads to a database hosted on AWS
description: 'RD Station and Google Sheets Part 2 - Moving to AWS'
image_description: 'RD Station, Google Sheets and Amazon Web Services logos.'
categories:
- Automation
featured: true
---

Published on September 03, 2020 and updated on November 19, 2021.

**SPOILER ALERT: This post contains lines of code! I'll assume that you're familiar with SQL, Javascript and Node.js**.

Exactly 2 years ago I wrote a post on this blog in which I explain {{< anchor href="/en/stories/rd-station-e-google-sheets" >}}how to integrate RD Station with Google Sheets{{< /anchor >}}. With only one webhook, one automation flow and some lines of code, it is possible to automate sending leads to spreadsheets and reduce time with data collection. For a small operation this process works fine, but what when the database grows, there are many people using it and performance starts to become an issue? It is time to upgrade to a better architecture.

## The limitations of a spreadsheet

The first problem when using webhooks to integrate RD Station is felt right after turning the automation on with lists containing many leads (more than 3,000 leads): overwriting data in the spreadsheet. Each lead is sent by the webhook individually, which requires a proper process to manage multiple lines being written in the spreadsheet at the same time. Google Apps Script (or GAS) {{< anchor href="https://developers.google.com/apps-script/guides/services/quotas" target="_blank" >}}restraints the amount of simultaneous executions with 30 per user{{< /anchor >}}. Since on the previous post the spreadsheet was configured to authenticate anonymous users using the credentials of a user with write access permission, each call to the script by the webhook utilize the quota of the user. A system of lock and release was created to manage concurrent accesses, but the solution proved ineffective to manage many leads being sent through the webhook simultaneously.

This problema can be avoided by determining a cutoff date and two lead segmentation lists by date of creation: one that goes until the cutoff date and another that goes after the cutoff date. All leads created up to the cutoff date will be manually registered into the spreadsheet and the automation is turned on using the list with leads created after the cutoff date. Solved the problem, the spreadsheet will be fed with data from news leads, until one of these things starts to happen:

- The limit of cells is reached or is about to be;
- The problem with excessive amount of calls to GAS repeats due to many new leads going to the automation flow simultaneously;
- The spreadsheet, which lives in a Google Drive directory, is modified or erased by accident;
- The file starts to get really big and slow to open.

These are just problems that makes accessing the file harder, we're not even considering legal issues when uploading leads data to a Google Drive directory.

Fortunately, the place to which this solution will be moved will mitigate or solve these problems and many others.

## Cloud infrastructure

Build and maintain a infrastructure to collect, process and store data in the office is very costly. Consider just the up front costs with computers and qualified personnel. Even before storing a single bit, a company that has decided to venture into creating its own data hub will possibly dedicate months of work to make everything work as planned. Add internal bureaucracy for approving such project and the cost with maintenance and soon enough you'll end up with a project that, probably, won't pay off.

To abstract such complexity of managing the necessary infrastructure required to host apps, some companies around the world rent their own infrastructures: machines, network equipment and qualified personnel that take care of everything that happens "behind the curtains" so the focus keep on creating and maintaining applications, not worrying with building this infrastructure from scratch.

One company that offers this service is Amazon, with its infrastructure division Amazon Web Services (AWS). It is the solution provided by AWS that will be used throughout this post.

A pause before moving on: everything that will be done using AWS could have been done using any other infrastructure as a service (IaaS) provider.

## Amazon Web Services

Cloud computing solutions from AWS are prepared to receive different traffic volumes: it "scale" according to the demand, which means that more resources from the infrastructure get allocated as demand grows and once it isn't needed anymore, resources are released. Pricing is set based on the usage of the infrastructure, there is no single price or table of prices for most of the services like a traditional hosting provider. These services are listed across dozens of categories and with them it is possible to do many things, from storing text files to process neural network algorithms.

{{< image src="images/figure1-aws-product-list.webp" alt="The different categories of services provided by AWS." caption="The different categories of services provided by AWS. Source: Author." title="The different categories of services provided by AWS." lazy="true" >}}

For this exercise, we'll make use of the following services:

- AWS API Gateway;
- AWS Lambda;
- AWS RDS MySQL.

Together, this services will be responsible to receive the webhook from RD Station (the same one used in the previous post), treat the data at the entrance and store this data into a MySQL database.

{{< image src="images/figure2-data-pipeline.webp" alt="The design to be created at AWS." caption="The design to be created at AWS. Source: Author." title="The design to be created at AWS." lazy="true" >}}

### AWS API Gateway

AWS API Gateway is the API builder from AWS. With this service it is possible to create REST APIs and also websockets, used to create instant messaging apps. With a REST API it is possible to open a door to listen for the webhook to be sent by RD Station.

### AWS Lambda

AWS Lambda is a service capable of executing code from different programming languages. This service will orchestrate the usage of all other resources to be used in the infrastructure, and will be executed as the API gets called. If you know the MVC architecture (Model, View, Controller), AWS Lambda will act as a controller.

### AWS RDS MySQL

AWS have a category of services called RDS, or Relational Database Service, which supports several known databases, such as PostgreSQL, MariaDB or MySQL. There is also a database manager built over MySQL called AWS Aurora, focused on performance. For this exercise we'll stick with an instance of a native MySQL.

Along with these services, we'll need three others to publish the architecture:

- AWS IAM;
- AWS VPC;
- AWS CloudWatch.

### AWS IAM

Every service on AWS have access restrictions. Permissions are granted for system users and to other services. The system that manage these permissions in AWS is called IAM, or Identity Access Management.

### AWS VPC

As well as user permissions, AWS services can or can't be isolated from the internet. Isolated services are part of a network whose rules are managed by administrative users and devices that are inside this network can be connected to the internet upon approval. This isolated environment is called VPC, or Virtual Private Cloud. The database will live inside this safe network.

## AWS CloudWatch

Each code executed on AWS Lambda generates an execution log. This log must, necessarily, be stored on CloudWatch. The service allows to store any kind of log, including API calls, but for this exercise only the execution log will be registered.

Each service can be configured in the smallest details using an administrative panel, called **console**.

## Setting up the environment

Identified all the services that will make up the infrastructure, time to configure them.

### Creating an account at AWS

Creating an account at AWS can be done with no cost. Throughout the first year of usage, {{< anchor href="https://aws.amazon.com/free/" target="_blank" >}}many services are free{{< /anchor >}}, including the one we'll be using throughout this post.

To utilize these services, {{< anchor href="https://portal.aws.amazon.com/billing/signup#/start" target="_blank" >}}create an AWS account{{< /anchor >}} and login in the console.

{{< image src="images/figure3-aws-console.webp" alt="AWS console." caption="AWS console. Source: Author." title="AWS console." lazy="true" >}}

All AWS services have redundancy, meaning that they're mirrored across servers located on different parts of the planet. You can choose the region you want to work from and how each service you'll be using will be mirrored on different zones, to ensure availability in case something happens to the infrastructure in which you app is hosted. When creating an account, the default region is Ohio (us-east-2), in the United States. There is an AWS data center in São Paulo (sa-east-1) which can be used to host apps that will be used in Brazil. For this exercise, I kept the default zone (us-east-2) and the language is set to english.

### Creating the database

The first thing that we'll do at the environment is to create the database. To do this, use the search bar that is located in the home screen and type RDS. Select the first result. The same menu can be accessed under Services. Upon entering the first time in any service at AWS you will be greeted with a home page presenting the service. Hit the button "Create database".

{{< image src="images/figure4-amazon-mysql.webp" alt="Configuration screen for a new MySQL database." caption="Configuration screen for a new MySQL database. Source: Author." title="Configuration screen for a new MySQL database." lazy="true" >}}

Keep the option "Standard Create" checked, to show all configurations.

Select MySQL as the database and the edition MySQL Community. Keep the suggested version (by the time this post was published, 8.0.17).

On templates, select Free tier. We'll use the service that is provided by free for the first 12 months.

Choose a name to identify this instance of the database and a password. This name is not the database name, but an identifier to represent both the database and its configurations.

Keep the default options for hardware configurations.

Under Connectivity, make sure that there is a VPC (Virtual Private Cloud) selected. When creating a database, it will be associated with a VPC.

Hit Additional connectivity configuration to show additional options.

In Subnet group make sure that the default network group is selected.

On Public access select Yes. It will be possible to access the database from tools outside the VPC, and this will be done only to create the database and the table at which the data from RD Station will be stored. After finishing creating the database and table, we'll disable public access and let VPC control the traffic allowed to access the database.

In Existing VPC security groups, select the default option.

Keep all remaining configurations as is and hit Create database.

{{< image src="images/figure5-database-created.webp" alt="New database info screen created at AWS." caption="New database info screen created at AWS. Source: Author." title="New database info screen created at AWS." lazy="true" >}}

Now that the database is created, write down the endpoint, which is the address that will be used to connect to the database, the given port number (the default port is 3306), user and password created in the previous step. With this data it is possible to use any MySQL client to connect to the database.

It is not possible to connect to the database yet. Although Public access was set to Yes when creating the database, services outside the VPC still can't access the database because they can't enter the VPC. It is necessary to allow them to do so, which will be done listing the IP address of your machine to the list of authorized addresses that can access the VPC.

### Configuring the network on VPC

Use the search bar available on Services to search for "VPC". Select the first result. You will see the initial page for the service.

In the options menu for the service, click in Security Groups, under Security. This will list all security groups for the default VPC that is created together with the AWS account.

{{< image src="images/figure6-vpc-configuration.webp" alt="List of security groups inside the default VPC." caption="List of security groups inside the default VPC. Source: Author." title="List of security groups inside the default VPC." lazy="true" >}}

Each security group contains a set of rules for traffic to enter and leave each service inside a VPC. It is possible to create many groups with different settings for each service. In this exercise we'll just edit the default security group to authorize the IP address from your machine to be able to access the database.

Click on the default security group ID. There are rules set for traffic that come and go on tabs Inbound rules and Outbound rules, respectively. The default exit rule is to authorize all traffic under the VPC. Hit Edit inbound rules.

Hit the button Add rule. Each rule in the security group must have set the type of traffic, protocol, port and origin address. To authorize the IP address from your machine establishing a connection with the database select the type All TCP. Both protocol and port will be automatically filled. Select Source and then My IP. You IP address will be added to the table. Hit Save rules to apply the configuration.

You IP address is now authorized to enter the VPC and connect with the database using the endpoint that was assigned during creation. We'll now test this connection.

## Database configuration

For this exercise, I'll use MySQL Workbench, which can be {{< anchor href="https://dev.mysql.com/downloads/workbench/" target="_blank" >}}downloaded for free{{< /anchor >}} in MySQL website. With MySQL opened, hit new connection. Give a name for the connection, leave the mode as Standard (TCP/IP) and fill the inputs Hostname, Port, Username and Password with those that were given to you after creating the new MySQL instance on AWS. Click on Test connection to validate if it is possible to connect to the database from your local machine. If everything is OK, hit "OK" to establish a new connection with the database.

{{< image src="images/figure7-mysql-workbench.webp" alt="Open connection between MySQL Workbench and the database." caption="Open connection between MySQL Workbench and the database. Source: Author." title="Open connection between MySQL Workbench and the database." lazy="true" >}}

Let's create a database called rdstation. For that, write the following query using the query editor:

{{< highlight mysql >}}
CREATE DATABASE rdstation;
{{< /highlight >}}

Run the command using the lightning icon, in the toolbar above the text editor or using the shortcut CTRL + Enter (or command + Enter). A new database was created. We need now to create a table in this database to store leads coming from RD Station. Before creating the table we need to select a database. To select the newly created database execute the following query:

{{< highlight mysql >}}
USE rdstation;
{{< /highlight >}}

With the database selected, create a table called leads:

{{< highlight mysql >}}
CREATE TABLE leads(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200),
  email VARCHAR(200)
);
{{< /highlight >}}

The database is now configured to store data from new leads coming from the webhook.

### Creating the lambda function

The next step is to configure the Lambda service, which executes code snippets that will orchestrate all services used in the architecture to be created. The code will be executed inside functions, called after some event. These functions are called lambda functions. It is not necessary to create and configure an environment to run lambda functions, this was already done by AWS. We will focus on creating the code and load it to the service.

Using the search bar, search for "Lambda" and click at the first result. After entering page for the Lambda service, hit "Create function".

{{< image src="images/figure8-aws-lambda.webp" alt="New function configuration settings at AWS." caption="New function configuration settings at AWS. Source: Author." title="New function configuration settings at AWS." lazy="true" >}}

Amazon provides a list of templates for commonly used functions. For this exercise, we'll create a new blank function (Author from scratch).

The next step is to name the function, following the same rules used by programming languages.

For this exercise Javascript will be the language of choice, under a Node.js server. The most recent version available when this post was published will be used (12.x).

The next step is grant the function the permissions it needs to run. It is possible to create a new set of rules (roles) without leaving the lambda creation screen. To do that, select the option "Create a new role with basic Lambda permissions".

Finally, hit Create function.

{{< image src="images/figure9-aws-test-function.webp" alt="New function created at AWS Lambda." caption="New function created at AWS Lambda. Source: Author." title="New function created at AWS Lambda." lazy="true" >}}

Now that the function is created, we need to setup the moment in which it will be called. As in the architecture designed at the beginning of this post, we need the function to be called as soon as the API receive data from a webhook. Let's create this API from the lambda function that was configured.

In the Designer section, hit Add trigger. Expand the options in the search input that appears and select API Gateway. Upon selecting this option, an API configuration assistant will open. Select Create an API  and select the option REST API. In security, keep the option Open. Hit Additional settings. Give a name for the API and, optionally, a name for the current development stage. You can create several development stages, useful to create distinct environments such as development, staging and production, for instance. With all configurations set, hit Add.

Go back to the function configurations page. Find the group of settings VPC. We need to add this lambda function inside the VPC where the database lives. This isn't the only way to establish this connection, it is possible to leave the lambda function ouside the VPC and establish a connection with the VPC and with the database. By keeping the lambda function inside a VPC, tough, we eliminate the need to setup a connection between the lambda function and the VPC. **Remember: objects inside a VPC have no internet access by default. In this exercise, it will be possible to place the lambda function inside the VPC, since the function only interacts with a database that is also inside the VPC, with no need to call external services on the internet**.

In VPC, hit Edit. Select the default VPC, the three default subnets and the default security group. Note that by selecting a default security group, the page will show all Inbound and Outbound rules defined on security group settings, including the one we created to authorize the IP address of your local machine to connect with the VPC. Hit Save.

The function is configured, but there are two more tasks left: grant API reading permissions to the function that was created and writing down the endpoint address from which the webhook from RD Station will be sending data to.

### Granting permissions to the lambda function

When creating a lambda function, we checked the option to create a set of permissions for the function to work. These permissions authorize the function to:

- Write logs on AWS CloudWatch;
- Write data on AWS EC2, which is the AWS virtual machines service, where functions are stored.

We need to grant another permission to the function, one that will allow it to read data from the API previously created. To do that, go to Services and search for "IAM". Select the first result. In the options menu, select Roles.

{{< image src="images/figure10-aws-iam.webp" alt="List of roles that were created as we configured AWS services." caption="List of roles that were created as we configured AWS services. Source: Author." title="List of roles that were created as we configured AWS services." lazy="true" >}}

The role that was created have the same name as the function. Select this role.

Hit the button "Attach policies". A list of possible permissions for this role will appear on the page. Using the search box, search for a permission called "AmazonAPIGatewayInvokeFullAccess". Select this permission and hit "Attach policy". This permission will be added to the role, and all services that use this role will have this and all permissions associated with the role.

### Finding the API address

The last configuration step is to get the API endpoint address. To do that, go to Services. In the search box, type "API" and select the first option. The screen that opens will show that there's an API already created, which is the one automatically created when configuring the trigger for the lambda function. Select this API. Note that there is an endpoint already created that uses the same name as the lambda function previously created. Once the API was published, it was assigned an endpoint following the convention https://api-address/stage/functionName, where stage is the name of the default stage that was created and functionName is the resource that invoke the lambda function. If you don't include the function name (also called resource or method) in the address that calls the API, you will see an error when trying to access this address directly from the browser that says "Missing authentication token".

To find the address associated with the API, go to Stages and select the stage that was created when setting up the API. Write down the address given in Invoke URL. Note that this address have no resource attached to it (there is no function name after the stage). For the address to be complete, it should reference the name of the resource. If you need to know the exact name of the resource that was created for you, go to Resources, above Stages in the menu.

## The orchestrator

The lambda function we've created will orchestrate all resources used in this infrastructure. We need to teach it how to do that. Go to the lambda service page and select the function that was created. We could type all commands using the editor provided by AWS. There is a restriction with this editor, though: we can't install packages. Using Node.js as the server, we can't use NPM (Node Package Manager). We need the mysql package to establish a connection with the database from within the lambda function and this package is not available on this environment. All necessary dependencies for the project need to be available at AWS.

To load all required files, create a folder in a directory on your local machine and start a new Node.js project in the root of this folder. If you don't have Node.js installed on your machine, {{< anchor href="https://nodejs.org/en/" target="_blank" >}}install it{{< /anchor >}} before moving on.

Once Node.js is installed on your machine, open a terminal and access the root folder of the project to be loaded on AWS Lambda. Inside this folder, run the command:

{{< highlight bash >}}
npm init
{{< /highlight >}}

This command will ask for some information to setup the project, like author name and initialization file. Fill this as you prefer, keep the entrance point as being index.js and confirm everything once you're done.

It is necessary to install the mysql package, {{< anchor href="https://www.npmjs.com/package/mysql" target="_blank" >}}available on NPM{{< /anchor >}}. Run the following command on your terminal:

{{< highlight bash >}}
npm install mysql
{{< /highlight >}}

The package will be installed in the project folder, with all its dependencies, inside a folder called node_modules.

With mysql installed, we can use it to establish a connection with the database.

Open your code editor of choice and create, inside the root folder for this project, a file called index.js. This file will contain the code we'll write to catch the webhook from RD Station and store its data into the database.

### The basic structure of a lambda function

All lambda functions are declared with a basic setup. In Javascript that is running on a Node.js server, this structure is:

{{< highlight javascript >}}

exports.handler = async (event) => {
	// TODO
  const response = {
    statusCode: 200,
    body: JSON.stringify('Hello from lambda!')
  };
  return response;
}

{{< /highlight >}}

This handler object stores the "heart" of the lambda function. Everything that's core is set to run inside a function that's stored inside the handler and its execution status is returned once finished. Before writing the code that goes into the function, we'll adjust this basic structure to run synchronously.

{{< highlight javascript >}}

exports.handler = function(event, context, callback) {
  context.callbackWaitsForEmptyEventLoop = false;

  callback(null, {
    statusCode: 200,
    body: 'Hello from lambda!',
    headers: {
      'Content-Type': 'application/json',
      'Access-Control-Allow-Origin': '*'
    }
  });
}

{{< /highlight >}}

There are some things to be noticed after rewriting this function:

- The function declared now have three parameters;
- The function is now finished when calling a callback function;
- We configure an object called context to tell Node.js to {{< anchor href="https://nodejs.org/en/docs/guides/event-loop-timers-and-nexttick/" target="_blank" >}}not wait for the event queue to be processed{{< /anchor >}};
- The object to be returned now have a headers property to send headers along with the data. The header Access-Control-Allow-Origin allows the API to be called from services outside the domain where it is hosted, {{< anchor href="https://docs.aws.amazon.com/apigateway/latest/developerguide/how-to-cors.html" target="_blank" >}}which is required for the API to read the data that will be sent by the webhook{{< /anchor >}}.

With this setup in place, let's write the function code inside index.js.

{{< highlight javascript >}}

const mysql = require('mysql');

function handleEvent(event) {
  if (event.body != null) return JSON.parse(event.body);

  return null;
}

function handleCallback(callback, error, status_code, message) {
  callback(error, {
    statusCode: status_code,
    body: message,
    headers: {
      'Content-Type': 'application/json',
      'Access-Control-Allow-Origin': '*'
    }
  });
}

{{< /highlight >}}

We start by importing the package mysql. Next, we create two functions: handleEvent and handleCallback. The function handleEvent will treat the object event. This object carries information about the request and have a property called body. When a POST request is done and data is passed on its body (which is the case of the webhook from RD Station), this property will have data. To make this exercise simple, we'll just check if there's data in the property body and, if there is, we try to parse the object assuming it it formatted as JSON.

The next function, handleCallback, abstract the call to callback, which is sent as a parameter to the function declared on the object handler. This function returns to the requester the status of its execution.

We'll now create an object to connect with the database.
{{< highlight javascript >}}

const connection = mysql.createConnection({
  host: process.env.RDS_HOST,
  user: process.env.RDS_USER,
  password: process.env.RDS_PASSWORD,
  port: process.env.RDS_PORT,
  database: process.env.RDS_DATABASE
});

{{< /highlight >}}

We'll setup some environment variables inside the lambda function that will store the database access credentials. AWS have a service designed to store information like credentials called AWS Secrets Manager. This service, though, is not available in the free tier.

Once everything is done, we'll now write the function that will receive the webhook and store its data into the database.

{{< highlight javascript >}}

exports.handler = function(event, context, callback) {
  context.callbackWaitsForEmptyEventLoop = false;

  let response = handleEvent(event);

  if (response && response.hasOwnProperty('leads')) {
    let lead = response.leads[0];
    setTimeout(function() {
      // This INSERT syntax is valid in MySQL but it isn't a default SQL standard
      connection.query('INSERT INTO leads SET ?', {name: lead.name, email: lead.email}, function(error, results, fields) {
        connection.release();

        if (error) throw error;

        handleCallback(callback, null, 200, 'ok');
      });
    }, 1000);
  } else handleCallback(callback, null, 200, 'Script ended');
};

{{< /highlight >}}

This function:
- Tells Node.js that the callback function doesn't need to wait for other events that need to be processed;
- Check if the there's a body parameter within the API request and if there's JSON data in it;
- Check if the object that was returned have a property called leads*;
- If there are no leads, invoke the callback function;
- If there are leads, wait 1 second for a query to insert data into the database to run.

\* {{< anchor href="https://developers.rdstation.com/pt-BR/migration/webhooks" target="_blank" >}}The webhook format will change{{< /anchor >}}. For reference, this is the content that we're expecting at the time this post was published:

{{< highlight javascript >}}

{
  "leads": [
    {
      "id": "1",
      "uuid": "c2f3d2b3-......-eef38be32f7f",
      "email": "email@email.com",
      "name": "Lead Name",
      "company": "Company Name",
      "job_title": "Job",
      "bio": "This is my bio",
      "created_at": "2012-06-04T15:31:35-03:00",
      "opportunity": "false",
      "number_conversions": "3",
      "user": "email@example.com",
      "first_conversion": {
        "content": {
          "identificador": "ebook-abc",
          "nome": "Lead Name",
          "email_lead": "email@email.com",
          "telefone": "99999999",
          "empresa": "Company Name",
          "cargo": "IT"
        },
        "created_at": "2012-06-04T15:31:35-03:00",
        "cumulative_sum": "1",
        "source": "source 1",
        "conversion_origin": {
          "source": "source 1",
          "medium": "medium 1",
          "value": "value 1",
          "campaign": "campaign 1",
          "channel": "channel 1"
        }
      },
      "last_conversion": {
        "content": {
          "identificador": "webinar-abc",
          "email_lead": "support@example.org"
        },
        "created_at": "2012-06-04T15:31:35-03:00",
        "cumulative_sum": "2",
        "source": "source 2"
      },
      "custom_fields": {},
      "website": "http://www.mywebsite.com",
      "personal_phone": "48 999999999",
      "mobile_phone": "48 999999999",
      "city": "Florianópolis",
      "state": "SC",
      "lead_stage": "Lead",
      "tags": [
        "tag 1",
        "tag 2"
      ],
      "fit_score": "d",
      "interest": 0
    }
  ]
}

{{< /highlight >}}

The final index.js file:

{{< highlight javascript >}}

const mysql = require('mysql');

function handleEvent(event) {
  if (event.body != null) return JSON.parse(event.body);

  return null;
}

function handleCallback(callback, error, status_code, message) {
  callback(error, {
    statusCode: status_code,
    body: message,
    headers: {
      'Content-Type': 'application/json',
      'Access-Control-Allow-Origin': '*'
    }
  });
}

const connection = mysql.createConnection({
  host: process.env.RDS_HOST,
  user: process.env.RDS_USER,
  password: process.env.RDS_PASSWORD,
  port: process.env.RDS_PORT,
  database: process.env.RDS_DATABASE
});

exports.handler = function(event, context, callback) {
  context.callbackWaitsForEmptyEventLoop = false;

  let response = handleEvent(event);

  if (response && response.hasOwnProperty('leads')) {
    let lead = response.leads[0];
    setTimeout(function() {
      // This INSERT syntax is valid in MySQL but it isn't a default SQL standard
      connection.query('INSERT INTO leads SET ?', {name: lead.name, email: lead.email}, function(error, results, fields) {
        connection.release();

        if (error) throw error;

        handleCallback(callback, null, 200, 'ok');
      });
    }, 1000);
  } else handleCallback(callback, null, 200, 'Script ended');
};

{{< /highlight >}}

Save the file. Select all files and folders created (index.js, node_modules and package.json) and add them into a compressed file. This file must be compressed as zip.

{{< image src="images/figure11-aws-lambda-function.webp" alt="Compressed folder containing index.js, node_modules and package.json." caption="Compressed folder containing index.js, node_modules and package.json. Source: Author." title="Compressed folder containing index.js, node_modules and package.json." lazy="true" >}}

With the compressed folder in hand, open up the page for AWS Lambda and, inside the block Function code, select Actions > Upload a .zip file. A select file window will open. Select the compressed file that contains the project files and hit Save. These files will be served in the editor for this lambda function, just like the mysql package and its dependencies.

### Setting up environment variables

When creating the object that establish a connection with the database, we've used five environment variables:

- RDS_HOST;
- RDS_PORT;
- RDS_DATABASE;
- RDS_USER;
- RDS_PASSWORD.

We need to create those variables inside lambda environment. Browse to Environment variables, below the code editor, and hit Edit. In the field Key, add RDS_HOST and in Value the endpoint that was obtained when creating the database. Select Add environment variable to add another environment variable to the project. Create all variables and add the configuration you've received when creating the database instance and the database itself.

## Setting up the webhook in RD Station

The final step is to activate sending webhooks from RD Station, {{< anchor href="/stories/rd-station-e-google-sheets/" >}}which can be accomplished under account configurations or automation flows{{< /anchor >}}. Just follow the same procedure that was done in the post on integrating RD Station and Google Sheets, changing only the address to where the webhook must send data to. We'll be using the API address that was created on AWS API Gateway instead of GAS. Remember that the address must have the name of the endpoint and the resource.

All done! RD Station leads are now being stored in a relational database at AWS.

## Optional: disable public access to the database endpoint

If you want, you can disable external access to the database endpoint outside the VPC and make sure that only the lambda function is allowed to access the database. To do that, go to Services and search for RDS (or use the history bar next to the options menu to access the service).

Hit databases and select the instance that was created for the database.

Hit the button Modify.

In the group of options Connectivity, select Additional connectivity configuration and in Public access select the option Not publicly accessible. Hit the button Continue at the end of the page to update the instance with the new configuration.

## Next steps

After running this exercise, you had a brief introduction to some of the services provided by AWS. This same architecture could have been done differently, using other services. RD Station can be just one source of data to a Data Warehouse or a Data Lake, or yet could have entered a more complex data pipeline before being written into the database. There are many possibilities and the way the implementation will work will vary according to each project's needs. {{< anchor href="https://docs.aws.amazon.com/index.html" target="_blank" >}}AWS documentation{{< /anchor >}} is a great source of information, just like the many posts available at Stack Overflow from people that had issues when setting up AWS services.

Remember the problem illustrated at the beginning of this post when integrating RD Station and Google Sheets: the high volume of simultaneous leads. Many leads being simultaneously sent to the API can result in many instances of a lambda function running and many database connections to be opened. The solution given to this problem at the beginning of the post was to separate leads based on the date they were created, which also works here. This solution avoids wasting computational resources and increase costs associated with this task on AWS.

Let's continue automating!
