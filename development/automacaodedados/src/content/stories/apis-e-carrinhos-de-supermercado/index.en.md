---
title: 'APIs and grocery carts'
author: henriquesouza
publishDate: 2018-07-04 21:20:00
lastMod: 2021-11-08 21:20:00
summary: What is an API and what it is for? This post will introduce it without using technical language.
description: APIs and grocery carts
image_description: 'grocery cart.'
categories:
- Automation
featured: true
---

Published on July 04, 2018 and updated on November 08, 2021.

## Let's go shopping

I don't know about you, but I've learned with my family to shop every month: at the beginning of every month I'll go to the supermarket and buy everything that I'll eat that month ~~(including some tasty treats that lower my life expectancy)~~. Upon arriving at the supermarket, the first thing that I do is to search for a grocery cart. With a grocery cart in hand, I walk around the corridors carefully analyzing the product at display. I usually have with me a list of items to purchase, but I like to see what is new on display. I walk each sector filling the grocery cart everything that I need until the list is checked. To conclude, I'll register everything that I'll be taking on the cash register and receive a bill that is the sum of every product bought multiplied by their quantities and added taxes. I pay for everything and go home.

## Let's go shopping: API mode

Using an API is like going to the supermarket. Making parallels:

- **Grocery cart**: a representation of our good friends APIs;
- **supermarket**: a database filled with things to buy;
- **Cash register**: a guardian that ensures we have permission to buy what we need;
- **Products**: Data and more data.

And the digital purchase journey goes like this:

I want to shop, but I don't go shopping on foot or by car anymore. I'll call an API, a very intelligent grocery cart, and ask it to get everything I need for me. I then deliver the API the list of things I want to buy (and this time this list have **exactly** what I want), together with a pair of instructions:

- The API must be authorized to shop on my name;
- The API must be authorized by the **shop owner** to buy data, or products, in his supermarket (the owner doesn't allow just anyone to buy at his shop).

With both the list and instructions at hand, the API goes to the digital supermarket to search the items in the list. It happens that not just anyone can enter in this supermarket: it needs authorization from someone that can buy there. If security allows the person that's using the API to purchase in this supermarket, the API goes in, take whatever it is needed, goes to the cash register to pass everything, pay (when it isn't for free) and leaves.

## Drawing parallels between APIs and shopping

Security is tight; grocery carts have a limited capacity on the amount of items they can carry; the amount of money that I have on my card is limited and I do not keep randomly walking on all corridors. These are all truths that can be related to the fascinating world of APIs. Let's see how:

- APIs are grocery carts already known to security staff. Those who make use of them, though, are not. In order to use APIs, people need to identify themselves and prove that they can buy at this supermarket. Security can even authorize the entrance, but block certain sections from the store like alcoholic beverages if they notice that the set of permissions that the person have do not match the authorization level required to access this section;
- APIs are limited by the level of permission that they have. This level of permission can be determined by money or by privileges. If a child goes to the supermarket, for instance, she ~~probably~~ won't be allowed to buy cigarettes or alcoholic beverage. Or in a corporate setting, I could ask an API to retrieve the names of my colleagues, but not their salaries;
- Money can or cannot be exchangeable. I had never been into a supermarket in which I had to pay to use a grocery cart. APIs, though, are grocery carts from another level! Some can only be used upon payment. Others can only retrieve a couple of products for free, and payment is required to access premium products;
- APIs are straight to the point: they look at the list, walk the corridors in which products are, take them and goodbye! No circling around ~~(and no tasty treats that lower my life expectancy)~~.

Buying with the help of APIs is fast, efficient and shipping rates are really low (electricity used throughout the process).

## Supermarket's inventory

In order for us to buy at supermarkets, it is necessary for them to have products in stock. This inventory is regularly refilled and placed in display. In our hypothetical supermarket, merchants buy products from suppliers to keep their stocks at a reasonable level, but they must follow this rule: **only the supplier that sold the product to the merchant or those authorized can buy these products**. This means that if I plant tomatoes and sell them to the supermarket, I'll instruct the merchant that only myself and other that I trust can buy fresh tomatoes. Both the merchant and the staff at the supermarket are responsible for managing what's being sold, but must follow the rules that I've set regarding the merchandise I've sold. I can replace tomatoes for oranges for display and even get my merchandise back.

Imagine if you had to deal with guardian cash registers, merchants, suppliers and everyone else that's in the middle of the process of producing and delivering products. This would be quite complicated, expensive and inefficient. It's good that we have grocery carts -- or APIs -- to do all that while we occupy ourselves with more productive matters.

When in need to shop online, you already know: APIs are a good choice!

## Further reading

For a more technical explanation on APIs, check out {{< anchor href="/en/stories/fundamentos-das-apis/" >}}the post on API fundamentals{{< /anchor >}} published on this blog.

Let's use APIs!
