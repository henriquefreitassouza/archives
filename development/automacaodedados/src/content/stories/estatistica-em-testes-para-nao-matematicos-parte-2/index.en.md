---
title: 'Statistics for testing - Hypotheses'
author: henriquesouza
publishDate: 2017-11-23 11:07:00
lastMod: 2021-10-21 11:07:00
summary: 'There are many types of tests with samples, and this post will present the most used with online testing techniques, such as A/B tests: hypotheses tests.'
description: 'Statistics for testing - Hypotheses'
image_description: 'Different types of hypotheses shown over density curves.'
categories:
- Statistics
featured: true
---

Published on November 23, 2017 and updated on October 21, 2021.

This post is the second in a 6 part series in which I'll break down the main topics within statistics for online sample testing. The topics are:

- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}The importance of understanding statistics for tests with samples{{< /anchor >}};
- **Hypotheses;** (this post);
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}Samples and probabilities{{< /anchor >}};
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-4/" >}}Histograms and density curves{{< /anchor >}};
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-5/" >}}P-value, alpha, beta and power{{< /anchor >}};
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-6/" >}}Designing tests and configuring calculators{{< /anchor >}}.

Bonus: {{< anchor href="/en/stories/calculadora-de-significancia-estatistica-para-testes-ab/" >}}A/B testing significance calculator{{< /anchor >}}.

## The beginning of an experiment: hypotheses

There are many types of tests with samples. The most common, adopted by many testing tools, are called **hypotheses tests**. A hypothesis is a statement that reflects a belief. The goal of a test is to validate or invalidate a hypothesis. There are two hypotheses to be noted on a hypothesis test: the **null hypothesis** and the **alternate hypothesis** (also called alpha hypothesis). The null hypothesis is a premise that the treatment gave to a study group and observed behaviors are not correlated, and the alternate hypothesis is the belief that the treatment gave to a study group and observed behaviors are correlated. One example of alternate hypothesis: changing the color of a button on the home page of a website will increase traffic on the product page by 10%. The null hypothesis is, then, the premise that changing the color of the button will not increase traffic on the product page by 10%. These definitions are important to both design and analyze the results of a test.

When testing results are compared against the null hypothesis, it can be **rejected** or **accepted**, on statistical terms. Accepting the null hypothesis means that the treatment gave to the treatment group didn't had the expected results. Rejecting the null hypothesis, on the other hand, means that the probability that the observed behavior on the treatment group happened by chance is small. Naming conventions may seen a little difficult to grasp at first, but in practical terms this means that even if there is an observed difference of behaviors after a treatment was given to a treatment group in a study, there is a chance that maybe the change is not a product of the treatment itself, but of a complete different variable. Going back to the example with a button on the home page of a website. Assuming that the button was changed and the product page saw an increase of 10% in traffic after the change, how can we be sure that changing the button was what caused the traffic to increase on the product page? Rejecting the null hypothesis doesn't mean necessarily that the alternate hypothesis should be accepted. There is a way to calculate the probability that the induced change is what caused an observed behavior, and this will be explained in a future post.

## Errors types

Tests with samples can yield wrong results, even if the procedures were carried out correctly. This happens due to the use of samples in studies, and not the whole population. Samples may not be representative of the population being studied, giving room for errors, in statistical terms called **type I error** (also called alpha or false positive) and **type II error** (also called beta or false negative).

- Type I error happens when the null hypothesis is rejected when it should have been accepted. In other words, **saying that something is true when it is not**.
- Type II error happens when the null hypothesis is accepted when it should have been rejected. In other words, **saying that something if false when it is not**.

Type I error is directly associated with a concept to be properly introduced in a future post, called **alpha**. Maybe you have heard about its counterpart, called **statistical significance**. For now, statistical significance is a setting on testing tools that defines the level of trust on the results of a test. Common values for statistical significance are 90%, 95% and 99%. What 95% of statistical significance, for instance, means is that for each 20 tests, one will yield a false positive, or type I error.

Type II error, on the other hand, is associated with a concept called **beta**, also to be properly introduced in a future post. In a testing calculator, for instance, the counterpart of beta is a parameter used to calculate the probability that an effect as big as the expected will be found during a test. This is usually set to 80%, meaning that for each ten tests, the result in two of them are going to be false negatives, or type II errors.

A common analogy to explain the relationship between null and alternate hypothesis, as well as the testing errors, is to see how the justice system works. Imagine that a judge must decide if a defendant is innocent or guilty. By law, it is assumed that the citizen is innocent (null hypothesis) until it is proven otherwise (alternate hypothesis). Shown as a table, the possible outcomes for the judgment are:

{{< image src="images/figure2-different-types-of-errors-en.webp" alt="Table showing the possible outcomes of a trial, presenting error types I and II." caption="Table showing the possible outcomes of a trial, presenting error types I and II. Source: Author." title="Table showing the possible outcomes of a trial, presenting error types I and II." lazy="true" >}}

If enough evidence if found against the defendant, the null hypothesis (his innocence) will be rejected. If evidence shows that the defendant committed the crime for what he is being accused of, the alternate hypothesis (his guilty) will be accepted. Now, if the evidence that was presented isn't strong enough, the judge may sentence an innocent (false positive or type I) or freeing an guilty defendant (false negative or type II).

Back to the corporate reality, acceptable error margins should be set by the organization based on the cost of a mistake. In cases with online sample tests, it is reasonable to think that type I errors, or false positives, are worse than type I errors, since it means that decisions are made based on wrong information. Type II errors may not be that bad if that means only that an opportunity was missed and nothing changes. For other areas, like medicine, these margins should be the closest to zero as possible, as studies are directly correlated with human lives. The downside is that the smaller the error margin, the bigger the sample and longer the time required to collect them. For a company, this means that the experiment will take longer to complete and may cost more.

Follow the next posts to know how to test hypotheses. The next topic is **probability**.

Let's create hypotheses!
