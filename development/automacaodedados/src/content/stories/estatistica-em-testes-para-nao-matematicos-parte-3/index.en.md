---
title: 'Statistics for testing - Samples and probabilities'
author: henriquesouza
publishDate: 2017-11-24 11:21:00
lastMod: 2021-10-22 11:21:00
summary: 'How to be sure that the result of a hypothesis test with samples is representative of the whole population being studied?'
description: 'Statistics for testing - Samples and probabilities'
image_description: 'Probability function. P is equal to the division between the probability of an event and the set of all possible events.'
categories:
- Statistics
featured: true
---

Published on November 24, 2017 and updated on October 22, 2021.

This post is the third in a 6 part series in which I'll break down the main topics within statistics for online sample testing. The topics are:

- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}The importance of understanding statistics for tests with samples{{< /anchor >}};
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-2/" >}}Hypotheses{{< /anchor >}};
- **Samples and probabilities** (this post);
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-4/" >}}Histograms and density curves{{< /anchor >}};
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-5/" >}}P-value, alpha, beta and power{{< /anchor >}};
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-6/" >}}Designing tests and configuring calculators{{< /anchor >}}.

Bonus: {{< anchor href="/en/stories/calculadora-de-significancia-estatistica-para-testes-ab/" >}}A/B testing significance calculator{{< /anchor >}}.

It is unlikely that experiments performed on digital environments will have a whole population available, at least in a business setting. When it is impossible to study each individual from a population, samples are used instead. A sample is a group extracted from a population. Findings from a studied sample are assumed to be the same for the population from which the sample was taken. How exactly a sample is extracted and how it is possible to know if a sample is, in fact, representative of the population being studied?

## Population x sample

A population represents every individual within a group. The population of a country, for instance, is comprised of all people that live in this country. For digital products, a population is comprised of all people that access the product. The sample represents a portion of the population, and it is used to infer information about the whole population.

Samples have quality. A good sample is one that can describe the population from which it was taken. The process of collecting the sample must, then, be done with caution. Even an experiment that was executed correctly and with no random errors for results can end up with wrong results, if the sample is not representative for the population. A good sample must be:

- Significant: big enough to satisfy the experiment under the requirements;
- Representative: population characteristics must be the present in the sample;
- Random: samples must be randomly chosen to avoid the selection bias.

Testing tools will ensure that random samples are selected for the study, but both significance and representativeness must be determined by the researcher.

Populations and samples are groups that share common traits. In order to know how the group is organized along these traits, a number known as **central tendency measure** is used. Central tendency measures are numbers that explain sets of data. The three most common are the mean (or average), the median and the mode. Tests with online samples use the **mean**. Explain, or summarize, data using only one number is useful to have an understanding on how the data is organized. When it is not possible to access the whole population, the **population mean** is unknown. When this is the case, the measure used is the **sample mean**. The more significant and representative a sample is, the closest the sample mean will be from the population mean.

When statistical studies are made with samples, the mathematical tools that are used to calculate the level of proximity between samples and populations are within the field of **inferential statistics**.

## Descriptive and inferential statistics

The field of statistics is divided between two sets, called **descriptive statistics** and **inferential statistics**.

- Descriptive statistics: explain whole sets of data. Summarizing data with averages or explain the distribution of data are operations within the field of descriptive statistics. It is important to note that methods from descriptive statistics do not allow for conclusions that are beyond the set of data being analyzed;
- Inferential statistics: explain populations based on samples. Hypotheses tests are statistical tools within this group.

Inference in statistics is given by **probabilities**.

## Probabilities

Probability is the chance that an event will happen. Probabilities are of two types: **independent** and **conditional**.

### Independent probability

The independency between probabilities means that the probability of an event to happen is not bound to previous events. Think about a dice with six equal sides. When the dice is rolled and comes to rest, any number between 1 and 6 can show. A second roll can also reveal any number from 1 to 6, same thing for the third roll and so on. The same principle can be applied to a fair coin in a heads or tails game, for instance.

### Conditional probability

Probabilities change with past events. One example is a full deck of cards, in which the probability of any card to be randomly taken from the deck is the same. For each card that is removed, the probability of taking any of the remaining cards increases.

## The law of big numbers

What is the probability of a given event to occur? The estimate becomes more precise the more attempts (or events, or observations) are registered. This phenomenon is called **law of big numbers**. Not counting the restraints with sample tests described on the {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}introductory post{{< /anchor >}} of this series, the bigger the sample, the bigger the probability of a correlation between the treatment given to a study group and observed behaviors.

In software, tests are based on certain tasks that individuals of a sample are or aren't able to complete, and the main metric is the percentage of individuals of the sample that are able to complete the task. This percentage is called **conversion rate**. In statistical terms, this number is represented in its absolute form and it is called **proportion** (or probability of success, given by P). It is impossible to know the real conversion rate (P) when the size of the population is unknown (and this is the case for digital products). We use techniques from inferential statistics to estimate the proportion P for a given event described in a hypothesis.

Throughout this and the next posts I'll be using the terms conversion rate, probability of success and proportion as synonyms.

## Combined probabilities

Probabilities can also be combined, as long as the probabilistic events are **mutually exclusive**. What does this mean is that two or more events can happen without influencing on each other. One example on the online world would be "how many visitors have viewed both the category and the product pages?" (assuming that it is possible to get to the product page without passing through the category page and vice versa). If such events aren't mutually exclusive, it is necessary to subtract the portion of events that collide before combining the probabilities in order to avoid duplicated samples.

In online sample testing, the number being studied is the probability of success as stated in the hypothesis, or the conversion rate. The researcher calculate the average conversion rate for each sample in order to calculate the **average conversion rate for all samples**, and also a **margin of error**. The sum and subtraction of margin errors from the average conversion rate of all samples form an interval. This interval is comprised of all probable conversion rates of the samples, and it is called **confidence interval**. It is likely that each sample have some degree of difference from all others, so an interval of possible conversion rates is estimated to infer the average conversion rate for all population.

Confidence intervals and probabilities of success P will be detailed in a future post.

## Further reading

Learn probabilities in depth in the website {{< anchor href="http://jukebox.esc13.net/untdeveloper/RM/Stats_Module_2/" target="_blank" >}}Statistics and Risk Management{{< /anchor >}}, from where the examples with dices and cards were used for this post.

Let's estimate probabilities!
