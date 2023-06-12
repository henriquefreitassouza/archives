---
title: 'Statistics for testing - Histograms and density curves'
author: henriquesouza
publishDate: 2017-11-26 09:59:00
lastMod: 2021-10-23 09:59:00
summary: 'During a test, many samples are collected and its conversion rates calculated. The next step is to group and classify this data in such a way that will be possible to infer data about the whole population. How does that happen and why this is important inside a test?'
description: 'Statistics for testing - Histograms and density curves'
image_description: 'Histogram and density curve charts.'
categories:
- Statistics
featured: true
---

Published on November 26, 2017 and updated on October 23, 2021.

This post is the fourth in a 6 part series in which I'll break down the main topics within statistics for online sample testing. The topics are:

- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}The importance of understanding statistics for tests with samples{{< /anchor >}};
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-2/" >}}Hypotheses{{< /anchor >}};
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}Samples and probabilities{{< /anchor >}};
- **Histograms and density curves** (this post);
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-5/" >}}P-value, alpha, beta and power{{< /anchor >}};
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-6/" >}}Designing tests and configuring calculators{{< /anchor >}}.

Bonus: {{< anchor href="/en/stories/calculadora-de-significancia-estatistica-para-testes-ab/" >}}A/B testing significance calculator{{< /anchor >}}.

## Central tendency measures and the distribution of data

Sets of data are explained using two types of numbers: one that can represent the whole group and another to show the distribution of the data. The first number is the **measure of central tendency**, shortly presented on the {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}previous post{{< /anchor >}}, and the other one is the **measure of distribution**. The previous post also presented three common measures of central tendency, that are:

- Mean (or average): better known between the three. The mean is calculated by adding all the numbers in the set and dividing the result by the number of values;
- Median: the median is calculated by ordering the numbers and selecting the one that is in the middle of the set. If there is an even amount of numbers, the median is the mean between the two numbers in the middle of the set;
- Mode: the mode is the most frequent number in a set. If there are two or more numbers in the set that appear with the same frequency, the set will have more than one mode, relative to the amount of numbers with equal frequencies in the set.

Each measurement have its uses, and tests use the mean.

Besides the measures of central tendency there are distribution measures. Understanding the distribution of data in a set is imoprtant to calculate by how much they **deviate** from the measure of central tendency. Two deviation measures are:

- Variance: the variability within a data set;
- Standard deviation: the square root of the variance, used in conjunction with the mean to estimate the average deviation for the data set.

Both measures explain the deviation within a data set, but the variance is not sensitive to differences between individual distances. This means that it is not possible to calculate individual distances between data points. This problem is solved by calculating the square root of the variance, resulting in the standard deviation. The standard deviation is used to compare individual data points against the mean.

## Classifying probabilities of success

The {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}previous post{{< /anchor >}} briefly presented the probability theory, the probability of successes (or conversion rates) within the context of online tests, as well as the importance of collecting conversion rates from many samples in order to find the conversion rate for the population. The next step is to understand what happens when these conversion rates are calculated.

Throughout the execution of a test, the portion of the traffic that is participating from the test is counted, as well as the number of individuals that completed the task being studied, which represents a conversion. This is done for all testing groups, and can be a form submission, a button click, a purchase etc. Samples from this traffic are collected and their conversion rates are calculated. There conversion rates are then classified on "buckets" called **frequencies**. Testing tools automatically adjust the number of frequencies as more data is being collected. Examples of frequencies would be "between 0% and 0.99%, between 1% and 1.99%, between 2% and 2.99%, ..., between n% and n.99%". Samples are collected, their conversion rates are calculated and then placed inside the appropriate frequency.

The chart that plot frequency distributions is the **histogram**. It shows the distribution of numeric data by the number of occurrences for each defined frequency (or bin). In our example, frequencies are the intervals between probabilities of success, presented on the x axis, and the number of samples in each frequency, presented on the y axis.

{{< image src="images/figure1-histogram-with-bins.webp" alt="Example of histogram with defined frequency intervals." caption="Example of histogram with defined frequency intervals. Source: Author." title="Example of histogram with defined frequency intervals." lazy="true" >}}

## The law of big numbers and the theorem of central limit

The way converion rates are distributed in the data set is important. When more samples are collected, and more conversion rates are calculated, the distribution takes on a specific shape when presented on a histogram. The post on {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}probabilities{{< /anchor >}} presented the law of big numbers, which states that the bigger the study group, the closest the mean of all observed events will be from the population mean. This is noticeable in a histogram, as more and more conversion rates get classified inside the frequencies. The shape that the histogram takes resembles a mountain, or a **bell**.

{{< image src="images/figure2-histogram-resembling-a-normal-distribution.webp" alt="Example of a histogram taking on a specific shape." caption="Example of a histogram taking on a specific shape. Source: Author." title="Example of a histogram taking on a specific shape." lazy="true" >}}

This particular distribution is called a **normal distribution** (or gaussian distribution, or bell shaped distribution). The normal distribution is part of a mathematical field called **probability distribution**, which are mathematical functions that explain the probability of certain events. There is more than one probability distribution, and the one that explain normal distributions is called **continuous probability distribution**. The continuous probability distribution calculates the probability of a number being inside an interval.

{{< image src="images/figure3-distribution-over-histogram.webp" alt="Histogram resembling a normal distribution." caption="Histogram resembling a normal distribution. Source: Author." title="Histogram resembling a normal distribution." lazy="true" >}}

The distribution of data in a set approximates a normal distribution the bigger the sample and conversion rates. This concept is called the **central limit theorem**. According to the central limit theorem, characteristics and behaviors from samples will be in accordance with those presented by the population, which means that the distribution of the data in both the sample and the population will be the same or very close. Is this certainty that makes it possible to use sample data to infer behaviors and characteristics for entire populations.

## The empirical rule

Probability distribution function calculate **areas** under the distribution, and the goal is to know the probability that a number will fall within a certain range inside the area. Since probabilities of success can assume any value, and it is impossible to know what this value is for the entire population, calculate areas is useful to estimate an interval of possible values for the probability of success. This interval is the confidence interval, which was briefly presented in the {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}previous post{{< /anchor >}}. Another useful property, particular to normal distributions, is the so called **empirical rule**. This rule, also called 68-95-99.7, states that 68% of all data in a normal distribution will be located within one unit of distance from the measure of central tendency, 95% of all data will be located within two units of distance from the measure of central tendency, and 99.7% of all data will be located within three units of distance from the measure of central tendency. The unit of distance is the standard deviation and the measure of central tendency is the mean.

{{< image src="images/figure4-normal-distribution-and-standard-deviation-en.webp" alt="Marks for standard deviations within a normal distribution." caption="Marks for standard deviations within a normal distribution. Source: Author." title="Marks for standard deviations within a normal distribution." lazy="true" >}}

Once the data is normally distributed for each variation of a test, some calculations are performed to get to the numbers that are displayed on the dashboards of testing tools. These distribution curves need also to be juxtaposed to calculate the difference between them. This will be the topic for the next post.

## Further reading

{{< anchor href="https://stats.stackexchange.com/questions/35123/whats-the-difference-between-variance-and-standard-deviation" target="_blank" >}}This post on the statistics forum of Stack Exchange{{< /anchor >}} makes in in depth explanation of the difference between the variation and the standard deviation.

Let's study statistics!
