---
title: 'Statistics for testing - P-value, alpha, beta and effect size'
author: henriquesouza
publishDate: 2017-11-27 09:47:00
lastMod: 2021-10-23 09:47:00
summary: 'The most widely adopted testing tools take care of the math on experiments, but the researcher must be able to make the necessary configurations for calculations to be correct. I will explain what are those configuration and how they correlate with a successful experiment.'
description: 'Statistics for testing - P-value, alpha, beta and effect size'
image_description: 'Overlapped normal distributions showing the critical value, effect size, alpha and beta.'
categories:
- Statistics
featured: true
---

Published on November 27, 2017 and updated on October 23, 2021.

This post is the fifth in a 6 part series in which I'll break down the main topics within statistics for online sample testing. The topics are:

- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}The importance of understanding statistics for tests with samples{{< /anchor >}};
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-2/" >}}Hypotheses{{< /anchor >}};
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}Samples and probabilities{{< /anchor >}};
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-4/" >}}Histograms and density curves{{< /anchor >}};
- **P-value, alpha, beta and power** (this post);
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-6/" >}}Designing tests and configuring calculators{{< /anchor >}}.

Bonus: {{< anchor href="/en/stories/calculadora-de-significancia-estatistica-para-testes-ab/" >}}A/B testing significance calculator{{< /anchor >}}.

## The empirical rule in practice

As saw in the post about {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-4/" >}}histograms and density curves{{< /anchor >}}, the empirical rule, or rule 68-95-99.7, describe the spread of data along a gaussian curve, or normal distribution. As per rule, 68% of data is located under one unit of distance, or standard deviation, from the mean. 95% are located under two standard deviations from the mean and 99.7% are located under three standard deviations from the mean. The standard deviation is a measure of variability that use the same scale as the mean.

{{< image src="images/figure1-empirical-rule-en.webp" alt="Normal distribution and standard deviation marks." caption="Normal distribution and standard deviation marks. Source: Author." title="Normal distribution and standard deviation marks." lazy="true" >}}

Stating that 68% from data is within one unit of distance, or standard deviation, from the mean means that 68% of data will be spread within a specific interval, calculated based on the middle of the normal distribution. When a test is running, with samples being collected and their respective probabilities of success (conversion rates or proportions) being calculated, these probabilities have 68% chance of being within one standard deviation from the mean, 95% chance of being within two standard deviations and 99.7% chance of being within three standard deviations from the mean.

## P-value

Each variation of a test will have its own distribution curve, with its own mean and standard deviation, and the researcher must compare these variations to determine if the treatment and observed behavior correlate with one another. When calculated individually, normal distributions cannot be compared amongst themselves due to their different scales. It is necessary to **normalize them**. For that, it is important to have a number capable of representing the combined probabilities from all individual samples with each distribution and locate this number within the area of the combined normal distributions. This number is called **p-value**.

A formal definition of a p-value is that it is the probability of seeing an effect that is as extreme as the one observed, assuming the null hypothesis. As saw in the post on {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-2/" >}}hypotheses{{< /anchor >}}, it is not possible to assume that the alternate hypothesis is true just because there is evidence to reject the null hypothesis. It is important to remind that there are two possibilities for the null hypothesis: one in which it is false and **one in which it is true**. The same is true for the alternate hypothesis. The p-value is the number used to tell if the treatment gave to a study group is the cause of an observed behavior, assuming the null hypothesis. If there is evidence that the treatment and the observed behavior correlate, p-value will take on values inside an interval that will allow the rejection of the null hypothesis.

In tests with online samples, the definition of a p-value could be rewritten as follows: what is the chance that the traffic of a digital product will behave the way it did during the test if no changes were made at all? If the probability is low, then it is possible that the observed behavior was not by chance. In this case, the researcher is inclined to believe in the alternate hypothesis (the induced treatment to the product is what cause the traffic to behave differently).

Something important to note about using p-values to reject the null hypothesis over the alternate hypothesis is that it is not possible to prove the result. There will always be an associated margin of error, and in some cases the answer will simply be wrong, as saw in the {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-2/" >}}post about hypotheses{{< /anchor >}}. P-values are used as certainty measures between cause and effect, or the treatment given and the observed behavior. What can be done is run a new test to check if the result will fall within an expected interval. The business will still have to decide how it will be act on accordance with test results and its associated error margin.

How much should the p-value be for the result to be interpreted tending to the alternate hypothesis? Depends. This threshold is defined by the researcher, and it is called **alpha**.

{{< image src="images/figure2-p-value-compared-to-alpha-en.webp" alt="P-value and alpha located in a normal distribution." caption="P-value and alpha located in a normal distribution. Source: Author." title="P-value and alpha located in a normal distribution." lazy="true" >}}

## Alpha

Alpha, or **signficance level**, is the probability of a false positive. This number is a constant which cover an area within the normal distribution. This area goes from one of the borders to the value set. The most common settings for testing tools and calculators are 0.1, 0.05 and 0.01 (or 10%, 5% and 1% of chance of false positive errors, respectively). These tools and calculators commonly ask for the compliment of alpha to compare against the p-value, or 1 - alpha. The compliment of alpha is the number known as **statistical significance**, and represents the probability of the result being correct, assuming the null hypothesis. Another way of thinking about this number is as it being the probability of rejecting the null hypothesis when it is true, or even, the probability that the result is not a coincidence.

In practice, p-value should be smaller than alpha at one of the ends of the normal distribution. When that happens, the result that is found is called "statistically significant".

{{< image src="images/figure3-p-value-greater-than-alpha-en.webp" alt="P-value smaller than alpha." caption="P-value smaller than alpha. Source: Author." title="P-value smaller than alpha." lazy="true" >}}

## Tests with one and two tails

Even if alpha is a constant, the way that it is distributed along the gaussian curve can change according to the configurations applied to the test. In an online study, for instance, the researcher may have as a goal know the difference between a change made in a website against the previous design. If the goal is only to check if the change performs better, the test will be with **one tail**, and if the goal is to check whether the change performs better or worse than the previous design, the test will be with **two tails**. A tail is the end portion of a distribution.

{{< image src="images/figure4-left-and-right-tails-of-a-normal-distribution-en.webp" alt="Tails of a normal distribution." caption="Tails of a normal distribution. Source: Author." title="Tails of a normal distribution." lazy="true" >}}

When the test is with one tail, alpha is located at the right corner of the distribution, and p-value should be smaller than alpha on the right side of the distribution only. If the test is with two tails, alpha is divided between the tails and the threshold becomes alpha / 2. If alpha is 0.05 for instance, when testing with two tails, the number will be distributed between 0.025 at each end, and p-value should be smaller than alpha / 2 at one of the ends.

## Moving the p-value across the normal distribution

In order to know if p-value is greater than or less than alpha, it is necessary to know by how much it moves compared to the mean for each of the testing variations, using a notation that allows for comparisons between each variation of the study. For this, it is used a number called **z-score**. Each z-score movement throughout the normal distribution {{< anchor href="http://www.z-table.com/" target="_blank" >}}can be found at online z-score tables{{< /anchor >}}. Each step in z-scores is associated with the coverage of a certain area of the normal distribution. This number represent the area of the normal distribution that is covered in z-scores. The closest to one, the greater the distribution area that is covered in z-scores. Movements are calculated based on standard deviations.

{{< image src="images/figure5-z-score-table.webp" alt="Z-score table with wide range of steps and coverage of a normal distribution." caption="Z-score table with wide range of steps and coverage of a normal distribution. Source: Z Score Table." title="Z-score table with wide range of steps and coverage of a normal distribution." lazy="true" >}}

Z-scores can assume positive and negative values. Negative z-scores are below the mean and positive z-scores are above it. These tables can be read as follows: once a p-value is calculated, the area that is associated to this p-value is at one intersection between a row and a column. Suppose that the calculated p-value is 1.96. The first step is to look for the number 1.9 in the first column. Once found, the next step is to look for the remaining part of the number, 0.06. It can be found on the header row, with numbers ranging from 0.00 to 0.09. The equivalent area to 1.96 will be at the cell that cross both the corresponding row and column. In this case, the number is 0.9750 (or 97.50% of a normal distribution, considering a z-score table that show the entire area for the normal distribution). Since the area of a distribution is a number between zero and one, it is necessary to translate p-value and alpha to the scale that is used for all the distributions. The z-score does just that. Z-scores are useful, as they describe the distance between a number and the mean, and this description is done after normalization, which can be compared across distributions. This property of z-scores is important because it is what allows the result to be compared against all study groups.

There are many z-score tables online, and they differ between tables that show areas to the right of the normal distribution (above the mean), tables that show areas to the left of the normal distribution (below the mean) and tables that show the entire area, with positive and negative z-scores.

## Alpha z-score: critical value

To calculate the z-score associated with alpha, called **critical value**, the approach is the inverse from what was done to calculate the z-score associated with a p-value: find area covered by alpha and use that area to look up the z-score in the table. There are multiple ways to find the z-score associated with the critical value. For a test with one tail, subtract 1 from alpha, and for a test with two tails, subtract 1 from the division between alpha and 2. The resulting number is the placement of alpha within the normal distribution, which can be searched for in a z-scores table to get the equivalent z-score. Consider an alpha of 0.05 and a one tailed test, for instance. The resulting number after subtracting 0.05 from 1 is 0.95 (or .9500). The closest z-score calculated in the table is 1.65 (.9505). With two tailed tests, divide alpha by 2, which results in 0.025, and subtract this number from 1. The result is 0.975 (or .9750). The closest z-score calculated in the table is 1.96 (.9750). The equivalent z-scores to the most common alpha values are 1.645 for alpha 0.1, 1.96 for alpha 0.05 and 2.576 for alpha 0.01. Note that this post only used the positive z-scores table. For other methods of finding z-scores based on the area of the normal distribution will use the negative z-scores table.

The z-score associated with alpha is called critical value because this is the number that divide the distribution between two zones: one in which **the null hypothesis is not rejected** and another in which **the null hypothesis is rejected**. While alpha is an area that is associated with false positives, the critical value is the threshold between rejection and not rejection of the null hypothesis, or between statistically significant and not statistically significant.

{{< image src="images/figure6-null-hypothesis-boundaries-en.webp" alt="Threshold to accept or reject the null hypothesis." caption="Threshold to accept or reject the null hypothesis. Source: Author." title="Threshold to accept or reject the null hypothesis." lazy="true" >}}

Once the sample mean, the critical value and the standard deviation are known, it is possible to calculate a metric that was already cited on the {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}post about probabilities{{< /anchor >}}: the confidence interval. The confidence interval is an area of possible values where the conversion rate can be located. This is calculated twice: one for the upper boundary and another for the lower boundary. The upper boundary is obtained by adding the mean to the product between the critical value and the standard deviation. The lower boundary is obtained by subtracting the mean to the product between the critical value and the standard deviation.

In summary:
- P-value: probability of observing an extreme behavior assuming the null hypothesis;
- Alpha: probability of a false positive;
- Z-score: number of standard deviations in relation to the mean;
- Critical value: threshold between the areas of rejection and acceptance of the null hypothesis;

## Combined density curves

The process that is being described so far produces a p-value to be compared against an alpha, but this is done for a single variation inside a test. Tests will have at least two: one called **control** and one or more called **treatments** (or variations). The control group is the group that is not treated, while the treatment groups are differentiated on some aspect. Each control and treatment group have its own data collected, its own histogram, its own density curve and its own p-value. It is necessary to combine these curves and project a single p-value to be compared against alpha, which was done using the z-score. This overlapping of curves is just a projection in which both curves are placed within the same level, and both p-values and the measurement of deviation are calculated for the combined set.

{{< image src="images/figure7-control-and-treatment-distributions-en.webp" alt="Overlapping distribution curves for control and treatment groups." caption="Overlapping distribution curves for control and treatment groups. Source: Author." title="Overlapping distribution curves for control and treatment groups." lazy="true" >}}

When distributions are overlapped and there is more than one mean in the resulting set, the standard deviation can't be used as a deviation measure. The deviation measurement to be used when that is the case is the **standard error**, and it is derived from the standard deviation. The standard error is an estimation of the difference between the sample and population standard deviations. This number is used, among other things, to determine the variability between data when there is more than one mean in the data set, which is the case when two or more normal distributions are overlapped. The standard error replace the standard deviation to create the confidence interval. The mean that is used to calculate the confidence interval is a combined mean, calculated by subtracting the means from the overlapped normal distributions.

With a single p-value and a single measure of deviation, the result is applicable for the control and all treatment groups.

## Statistical significance and sample size

A common error when running tests, saw on the {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}introductory post of this series{{< /anchor >}}, is to end it right after the statistical significance was achieved. What happens is that throughout the test, statistical significance can be achieved zero, one or many times. You can open your testing tool one day and see a notification saying that the statistical significance was achieved, and the next day the testing tool may inform that the statistical significance was not achieved for the same test.

This happens because samples are being collected as the test is running, and the numbers present high variability, specially in the beginning of a test. Find the appropriate sample size is fundamental for the test to be successful. The bigger the sample, smaller the standard error and narrower the normal distribution becomes, and this is related to the {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-4/" >}}law of big numbers and the central limit theorem{{< /anchor >}}. The sample influence the standard error, and the standard error influence what is called **statistical power**, or the probability of rightfully rejecting the null hypothesis in favor of the alternate hypothesis. Some testing calculators ask the researcher to inform the statistical power in order to calculate the sample size required for a test.

## Statistical power and its four components: beta, effect size, alpha and sample size

In an area chart, statistical power represent the area under the combined normal distributions that is related to the alternate hypothesis, which does not intersect the normal distribution for the null hypothesis. Statistical power is represented by 1 - beta.

{{< image src="images/figure8-critical-value-and-power-en.webp" alt="Visualization of effect size." caption="Visualization of effect size. Source: Author." title="Visualization of effect size." lazy="true" >}}

Statistical power is comprised of four components:
- Beta: this number is the same seen on the post about {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-2/" >}}probabilities{{< /anchor >}}, or a probability of a false negative. The smaller the beta, bigger will be the statistical power;
- Effect size: effect size is a measure of distance between the means of the overlapped normal distributions. Is the difference between these means divided by the standard deviation;
- Alpha: probability of a false positive. The smaller the alpha, the bigger beta will be and smaller the statistical power;
- Sample size: amount of individuals present on the test. The bigger the sample, the smaller will be beta and greater the statistical power.

Adjusting alpha and beta is related to the amount of error the business will accept with the result of a test. The accepted amount of error will vary for each business, but it is fairly common to assume 0.05 for alpha and 0.2 for beta. The value of beta is usually not changed on the most common testing tools, it is assumed 0.2 by default. If there is a need to work with different beta values, the solution is to perform the calculations using spreadsheets or advanced testing calculators.

## Further reading

- {{< anchor href="https://www.youtube.com/watch?v=zTABmVSAtT0" target="_blank" >}}This video{{< /anchor >}} explains with simple terms the distinction between the p-value, alpha, critical value and z-score, as well as how they relate to one another;
- {{< anchor href="https://theebmproject.wordpress.com/power-type-ii-error-and-beta/" target="_blank" >}}These videos{{< /anchor >}} explain in detail the concepts of beta, effect size and statistical power.

Let's validate hypotheses!
