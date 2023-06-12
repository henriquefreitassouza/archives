---
title: The basics of APIs
author: henriquesouza
publishDate: 2017-12-12 21:34:00
lastMod: 2021-11-04 21:34:00
summary: APIs are very useful to automate processes and personalize workflows. From a technical standpoint, they contribute for developing distributed applications. Knowing APIs is vital to create applications able to communicate with the outside world.
description: The basics of APIs
image_description: 'Cloud of services connected to the internet.'
categories:
- Automation
featured: true
---

Published on December 12, 2017 and updated on November 04, 2021.

What is an API? API stands for Application Programming Interface. APIs are channels for information exchange between systems. APIs provide or retrieve data that software developers can use inside their own applications, like {{< anchor href="/en/stories/uma-introducao-ao-google-apps-script/" >}}information about movies{{< /anchor >}}. Although being similar concepts, there are differences between APIs and the called **webhooks**, which are event notifiers. While APIs are explicitly called by applications, webhooks notify external sources when events are triggered. Examples of webhooks are those used on payment gateways. When someone purchase a product, a payment notification is sent to the vendor, which then send the product. Calls to webhooks can even be done by APIs.

## The inner workings of APIs

The two main employments for APIs are to **integrate systems** and **automate processes**. Integration is done by building a workflow from which two or more systems exchange data and automation is done by collecting, processing, storing and delivering data without human intervention. APIs reduce costs and increase the performance of teams. Web services usually use APIs.

APIs work with at least two actors: a **client**, which request information, and a **server**, which deliver the information being requested. These actors communicate through a **protocol**, which is a set os rules known by all parties. Since data is transferred over the internet, the protocol that is usually adopted is the **HTTP**. An HTTP request consists of four parts:

- URL: the address in which data is located;
- Method: the operation that is to be performed on the server. Can be GET, POST, PUT, PATCH and DELETE;
- Headers: additional information, or metadata, to be sent along the data;
- Body: data to be sent with the request.

And response have three parts:

- Status code: three digits number that inform the status of the current request, such as success or fail;
- Headers: additional information, or metadata, received along the data;
- Body: data to be received.

Data sent through APIs are mainly **XML** and **JSON** files.

XML is similar to HTML:

{{< highlight xml >}}
<order>
  <item>
    <name>Smartphone</name>
    <price>899.99</price>
  </item>
  <item>
    <name>Smart TV</name>
    <price>1299.99</price>
  </item>
  <total>2199.98</total>
  <status>payment pending</status>
</order>
{{< /highlight >}}

And JSON is similar to Javascript objects:

{{< highlight json >}}
{
  "order": {
    "items": [
      {
        "name": "Smartphone",
        "price": 899.99
      },
      {
        "name": "Smart TV",
        "price": 1299.99
      }
    ],
    "total": "2199.98",
    "status": "payment pending"
  }
}
{{< /highlight >}}

APIs are built over established technologies and are designed following a set of best practices. The most known API design patterns are **SOAP** and **REST**. While SOAP is a protocol, REST is an architectural style, or an arrangement of components used to establish communication between systems. {{< anchor href="https://blog.smartbear.com/apis/understanding-soap-and-rest-basics/" target="_blank" >}}The main differences between the two{{< /anchor >}} are:

- SOAP can use other protocols besides HTTP and use XML to transfer data;
- REST is based on HTTP and can use different file formats.

REST is commonly used to build APIs, since it is easier to learn and is generally faster than SOAP.

## Authentication

Some APIs require users to authenticate in order to access their resources. Authentication can be done in following ways:

- With user and password;
- With access keys.

Access keys replace user and password credentials, and are created inside an application protected by credentials. The simpler way to retrieve a key is to login to a service that has APIs and create access keys. These keys may have specific usage permissions, depending on the API. Keys can grant read or write access to specific data or everything. Some keys have expiration dates.

Authentication methods vary with each API. Some methods are:

- Send credentials along with the requested URL as parameters;
- Send credentials along with the header Authentication;
- Send credentials along with the request body;
- Use authentication protocol **OAuth**.

### OAuth

OAuth is abbreviation for Open Authentication. It is a protocol to authenticate systems whose specs are maintained by {{< anchor href="https://www.ietf.org/" target="_blank" >}}Internet Engineering Task Force{{< /anchor >}}, and by the time of this post is on version 2 (OAuth2). OAuth protocol is used to build authentication systems for APIs using established design patterns. Authentication steps under OAuth2 are as follow:

- Client send access request to the server;
- Client is redirected to authentication server to provide user and password;
- Once authenticated, an authorization code is sent to the requester;
- This authorization code is sent along with a client key to the server. This client key is created inside the application that house the data to be accessed;
- Once the combination of authorization code and client key is accepted, the requester receive an access token.

Tokens can be used to access data. Some applications may give expiration dates for tokens for security purposes. When a token expires, the authentication workflow is reset. Token can also grant specific permissions to the data through APIs.

## Working with an API

APIs are accessed through **endpoints**, which are URLs that request, send, modify or delete data. For instance, accessing the hypothetical endpoint:

**https://api.service.com/data**

Could result in the following data being sent back to the requester:

{{< highlight json >}}
{
  "customers": [
    {
      "name": "Miguel",
      "email": "customer1@service.com",
      "phone": "+55 11 4446-9965"
    },
    {
      "name": "Laura",
      "email": "customer2@service.com",
      "phone": "+55 13 4526-9847"
    }
  ]
}
{{< /highlight >}}

The endpoint is called "data" and return information about customers. This example call used the GET method. Each HTTP request is done using one of several methods. The most common is GET, used to retrieve information from servers. Other HTTP methos that are used with APIs are:

- POST: send data to the server;
- PUT: update data stored in the server or insert it if not available;
- PATCH: update data stored in the server;
- DELETE: delete data from the server.

It is important to note that some APIs may deliver data only when using POST requests and not GET.

A POST request will probably have and endpoint similar to the one used for GET requests, and its body will carry the data that will be transferred to the server. One example of such request done using {{< anchor href="https://developers.google.com/apps-script/" target="_blank" >}}Google Apps Script{{< /anchor >}} can look like this:

{{< highlight javascript >}}
  var customer = {
    "name": "Marcelo",
    "email": "customer3@service.com",
    "phone": "+55 11 9485-6685"
  };

  var options = {
    "method": "post",
    "payload": customer
  };

  response = UrlFetchApp.fetch("https://api.service.com/data", options);
{{< /highlight >}}

The customer object store the data that will be sent on the body of the request. The method that was used is POST on the "method" key, indicating that this request will send data over the internet using the HTTP protocol.

APIs are very simple to use and provide a secure interface to access data. They work like a bridge that connect all sorts of services and make the internet richer by the day. Although they follow industry standard practices, each application will have its own specific business needs, which differentiate each API from all the others. This is why each API provider will also provide a **documentation**, an essential component to understand an API.

## Further reading

Zapier developed {{< anchor href="https://zapier.com/learn/apis/" target="_blank" >}}a complete course{{< /anchor >}} on the basics of APIs, from concepts to implementation.

Let's integrate and automate!
