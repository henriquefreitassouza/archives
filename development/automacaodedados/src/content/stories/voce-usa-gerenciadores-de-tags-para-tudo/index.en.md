---
title: 'Do you use tag managers for everything?'
author: henriquesouza
publishDate: 2019-05-20 20:05:00
lastMod: 2021-11-18 20:05:00
summary: Tag managers are convenient for managing scripts and avoiding conflicts between marketing and development teams. All snippets of code that are injected on a page are managed from the same place and code maintenance is easier. Very good! Now, what happens when you receive a visitor on your site that is using an ad blocker?
description: 'Do you use tag managers for everything?'
image_description: 'Ad Blocker tracking blocker options'
categories:
- Marketing
featured: true
---

Published on May 20, 2019 and updated on November 18, 2021.

Update November 18, 2021: In April 2021, Apple launched a new feature into the IOS ecosystem called Apple Tracking Transparency, which blocks common tracking technologies and only allow them to be executed if users explicitly consent. Both Facebook and Google saw their platforms lose some of its efficiency on predicting customer behavior using machine learning. Facebook, in response, created the Conversions API, which is a way of sending customer behavior information to Facebook Business from both websites and mobile applications using an API.This method eliminate the need for the traditional pixel that is installed on web pages, usually with a tag manager. Google, on the other hand, haven't felt the IOS update with the same strength. Months prior the company was adjusting its technologies to comply with data protection laws around the world, which resulted in the rewrite of Google Analytics and the launch of version 4. Starting from October 14, 2021, all new properties created with Google Analytics will use version 4 by default, which doesn't rely on cookies as its primary source of information, instead collect data from its logged users. Both Google and Facebook are collecting data on the side of the server, not from the client using injected scripts on web pages. This is possibly a trend.

Tag managers are code injectors place on web pages. Its installation is done only once by developers and from that forward every time that features needs to be installed, removed or modified, it is only a matter of making the change using the tag manager. Since tag managers usually inject tracking software, some ad blockers block the loading of tag managers -- ensuring that no scrips loaded using a tag manager will work.

Ad blockers {{< anchor href="https://pagefair.com/blog/2017/adblockreport/" target="_blank" >}}are already adopted by about 10% of all internet traffic{{< /anchor >}}and some browsers have their own tracker blocker tool out of the box -- which also blocks tag managers.

{{< image src="images/figure1-brave-browser-home-page.webp" alt="Brave browser is shipped with Shield: it blocks trackers and cookies while also enforcing the usage of HTTPS." caption="Brave browser is shipped with Shield: it blocks trackers and cookies while also enforcing the usage of HTTPS. Source: Brave." title="Brave browser is shipped with Shield: it blocks trackers and cookies while also enforcing the usage of HTTPS." lazy="true" >}}

— And why block tags?

Tag managers end up being central repositories for scripts of any kind, from website widgets to trackers for remarketing campaigns -- these are what ad blockers are targeting.

I'll illustrate the adoption of ad blocking technologies using one of the most used tools in the category. Adblock Plus have {{< anchor href="https://adblockplus.org/features" target="_blank" >}}a feature called EasyPrivacy{{< /anchor >}} whose task to to "block trackers". This feature blocks, among other things, tag managers. By the time this post was published it is disabled by default on new installations, but it is just a matter of pushing or ticking one checkbox in the first section of settings and done! Tag managers are no more!

{{< image src="images/figure2-ad-blocker-plus-settings.webp" alt="Option Block Additional Tracking, right after accessing the settings." caption="Option Block Additional Tracking, right after accessing the settings. Source: Author." title="Option Block Additional Tracking, right after accessing the settings." lazy="true" >}}

You may think that this is no big deal, after all most people have no idea what an ad blocker is, even less so a browser built for online privacy. I agree. What makes me start this discussion, though, is the fact that this group grows by the day.

## Browsers and ad blockers

It is nothing new that {{< anchor href="http://gs.statcounter.com/browser-market-share" target="_blank" >}}Google Chrome is the most used browser to access the internet, on both smartphones and desktops{{< /anchor >}}. Google Chrome, Apple Safari and Mozilla Firefox represent 80% of all online traffic on desktops from April 2018 to April 2019 while Google Chrome and Apple Safari represent these same 80% on mobile devices during the same period. The remaining 20% make use of other browsers.

{{< image src="images/figure3-browser-market-share.webp" alt="Known browsers keep growing in general." caption="Known browsers keep growing in general. Source: Statcounter." title="Known browsers keep growing in general." lazy="true" >}}

In Brazil, Google Chrome is even more widespread when compared to other browsers. This browser alone represent 80% of all traffic between April 2018 and April 2019.

Given that the most used browser are still growing in popularity, it is hard to believe that we'll see a new competitor gaining a considerable portion of market share in a foreseeable future, even less so built with privacy in mind.

And what about ad blockers?

A completely different story is told when talking about ad blockers. {{< anchor href="https://pagefair.com/blog/2017/adblockreport/" target="_blank" >}}Between 2015 and 2016 ad blocker adoption rised by 30% worldwide{{< /anchor >}}. {{< anchor href="https://pagefair.com/blog/2017/adblockreport/" target="_blank" >}}In Brazil, 6% of all internet traffic use ad blockers{{< /anchor >}}. {{< anchor href="https://pagefair.com/blog/2017/adblockreport/" target="_blank" >}}Mobile ad blocker usage grows even faster{{< /anchor >}}, which is a result of {{< anchor href="https://pagefair.com/blog/2017/adblockreport/" target="_blank" >}}partnerships between ad blocker providers and smartphone providers{{< /anchor >}}. Asian countries saw the fastest adoption rate of ad blockers, {{< anchor href="https://www.ibtimes.com/alibaba-fuels-massive-rise-mobile-ad-blocking-asia-could-us-be-next-2376144" target="_blank" >}}mostly due to UC Browser, developed by Alibaba{{< /anchor >}}, giving margin for speculations about a possible wave of adoption in the west on the next few years.

{{< image src="images/figure4-ad-blocker-usage-worldwide.webp" alt="Ad blocker adoption worldwide in December 2016." caption="Ad blocker adoption worldwide in December 2016. Source: PageFair." title="Ad blocker adoption worldwide in December 2016." lazy="true" >}}

On February 2018, Google Chrome shipped its own ad blocker made by Google. At first this seems odd, since Google's main revenue stream comes from online advertising, but the ad blocker {{< anchor href="https://www.businessinsider.com/google-new-chrome-ad-blocker-will-only-block-17-of-ads-2018-1" target="_blank" >}}block only ads that don't comply with a set of norms defined by Coallition for Better Ads{{< /anchor >}}, organization from which Google is a member of. This blocker shouldn't interfere with trackers or tag managers, and it is possible to imagine that this blocker is intended to stop the spread of ad blocker plugins, since they cause much more damage for companies that live off online advertising. We'll need to live a couple more years to know if ad blocker adoption will slow down worldwide.

## Surveillance economy 2.0: the anti virus

Some years ago it was easy to find discussions about {{< anchor href="https://duckduckgo.com/?q=anti+virus+companies+create+virus" target="_blank" >}}the possibility of anti virus providers being also the ones responsible for disseminating different types of viruses on the internet{{< /anchor >}}. I'm the kind of person that don't discard the possibility that some providers may actually do that, although I believe they're a minority.

I may be entering the curious world of conspiracy theories, but I believe we're seeing something similar to that, when someone creates a disease first to sell a cure later. Or, as I'll explain, some well intended agent conveniently take some "questionable decisions" in favor of common good, making suspicious people even more suspicious when browsing online.

Adblock Plus allow you to add to a "whitelist" web sites with ads that you're ok with. This whitelist is already filled with some web sites that follow some quality standards set by Acceptable Ads Committee. {{< anchor href="https://arstechnica.com/information-technology/2015/02/over-300-businesses-now-whitelisted-on-adblock-plus-10-pay-to-play/" target="_blank" >}}In 2015, 10% of all website owners in this list paid to be there{{< /anchor >}}. These are big companies that, not only had to comply with ad standards, but had also to pay the company behind Adblock Plus to be in the whitelist.

There are some quality standards even for those who pay, which creates some sense of comfort with browsing online. There is anyway the danger that the internet will be more so hostage of those that can pay for it to be shaped around the needs of small groups.

{{< image src="images/figure5-alien-abduction.webp" alt="Spaceship abducting a person to illustrate conspiracy theories for this topic." caption="Conspiracy theories involving abductions? I can only think on spaceship abductions to illustrate this topic. Source: Pixabay." title="Conspiracy theories involving abductions? I can only think on spaceship abductions to illustrate this topic." lazy="true" >}}

So far it may look like that there is nothing to worry about when using tag managers, but remember: blocking tag managers using an ad blocker (whose name is now tracker blocker) is simple as pushing or ticking a checkbox. People dissatisfied with online browsing experiences will search for alternatives when protecting themselves from abusive tools. As the demand for online privacy grows, I have no doubt that players will present better and better solutions for blocking trackers -- with the containers that wrap them up. These players will ensure that trackers and tag managers are blocked by default when selling their solutions to sell the idea of privacy.

## Swim against the tide won't help

It is fairly easy to find a {{< anchor href="https://duckduckgo.com/?q=detect+ad+blocker" target="_blank" >}}tutorial teaching developers to detect ad and tracker blockers{{< /anchor >}}. Websites like news portals use this kind of detection to alert ad blocker visitors about the importance of ads for maintaining the website. Some even block these visitors from accessing their content, others restrict access by the amount of visited pages and there are also those that warn, without restricting access to the content.

The problem with restricting access to content is that similar content can easily be found on the internet. Most people simply leave a website that blocks content. {{< anchor href="https://pagefair.com/blog/2017/adblockreport/" target="_blank" >}}Three out of four people with an ad blocker turned on leave websites that show ad blocker popups blocking the access to the content{{< /anchor >}}.

## It is not possible to avoid the future, but it is possible to embrace it

Visitors with tracker blockers on will not turn them off because a website is asking with care. Imagine that the internet is the outer space and visitors access it using spaceships and space suits. What many websites are asking is for people to take their space suits off, open the doors of the spaceship and try to breathe -- at least this is that looks like they convey.

As long as websites don't find just and unobtrusive ways of profiting with the traffic that they generate, ad and tracker blockers will be something for developers and marketers to deal with. What can we do? **Compartimentalize the most what is being loaded into web pages**. Given that tag managers can be blocked it makes sense using them only to include non essential scripts related to advertising, tracking and behavioral studies. And how to include scripts from widgets and tools required for basic functionality? The old way: asking for the help of our friends in the development team to include these scripts, preferably on the server side. This may not be enough for some tracker blockers, but if the script doesn't get identified as being a tracker by a blocker, it will run normally -- as long as Javascript is enabled.

{{< image src="images/figure6-blocked-container-management.webp" alt="Chat service that was loaded using a tag manager blocked by an ad blocker. At least there was a helpful message." caption="Chat service that was loaded using a tag manager blocked by an ad blocker. At least there was a helpful message. Source: Support service of a fintech." title="Chat service that was loaded using a tag manager blocked by an ad blocker. At least there was a helpful message." lazy="true" >}}

Yes, websites will still lose revenue due to the usage of ad and tracker blockers and also behavioral data that is used to continually improve their offers, even basic functionality as chats. {{< anchor href="/en/stories/as-pessoas-por-tras-das-personas/" >}}I wrote once that the digital environment lacks trust{{< /anchor >}} and it is only by cultivating trust is that people will be more open minded to listen for what companies have to say about their incredible products and services. We can keep insisting on detecting and blocking visitors that use ad blockers from our websites, but we can't avoid them to be suspicious of what we do. Each visitor that leave a website without being able to do what he or she came to do takes with him or herself the possibility of a prosperous relationship for both parties. Doesn't matter how insistent we are, the first step to build trust should come from those who publish something online -- and not the other way around. Part of this first step is to accept that visitors are suspicious, because the online life taught them to be like this.

Let's create responsible web site -- and not only responsive (sorry, I couldn't hold myself).
