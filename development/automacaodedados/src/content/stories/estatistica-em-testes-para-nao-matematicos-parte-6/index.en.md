---
title: 'Statistics for testing - Setup testing tools'
author: henriquesouza
publishDate: 2017-11-29 09:12:00
lastMod: 2021-10-30 09:12:00
summary: 'Setup tests with online samples require careful planning. Wrong configurations can invalidate any findings and lead businesses to make wrong decisions – what can be worse than having no data at all.'
description: 'Statistics for testing - Setup testing tools'
image_description: 'Software tools for online sample testing.'
categories:
- Statistics
featured: true
---

Published on November 29, 2017 and updated on October 30, 2021.

Update October 30, 2021: When the original post was written, Google had not launched Google Analytics version 4, which doesn't use views anymore and makes less use of cookies to identify users.

This is the sixth and last post of a 6 part series in which I'll break down the main topics within statistics for online sample testing. The topics are:

- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}The importance of understanding statistics for tests with samples{{< /anchor >}};
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-2/" >}}Hypotheses{{< /anchor >}};
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}Samples and probabilities{{< /anchor >}};
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-4/" >}}Histograms and density curves{{< /anchor >}};
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-5/" >}}P-value, alpha, beta and power{{< /anchor >}};
- **Designing tests and configuring calculators** (this post).

Bonus: {{< anchor href="/en/stories/calculadora-de-significancia-estatistica-para-testes-ab/" >}}A/B testing significance calculator{{< /anchor >}}.

## Testing process

This series presented many mathematical topics that, together, make a standardized process to study samples. This process, seen from a panoramic perspective, have the following steps:

- Describe null and alternate hypotheses;
- Determine if the test will have one or two tails;
- Determine alpha and beta;
- Collect the samples;
- Calculate the conversion rates (also called proportions or probabilities of success) for all samples;
- Classify each conversion rate within a frequency;
- Repeat the previous steps for all testing variations until their conversion rate frequencies assume a normal distribution;
- Overlap all normal distributions within the same level;
- Calculate the combined mean and p-value for all normal distributions;
- Locate the p-value within the combined normal distribution using the standard error and a z-scores table;
- Check if p-value is smaller than alpha in one of the tails of the null hypothesis normal distribution;
- Check if the sample size is bigger enough to finish the test once statistical significance is achieved.

Throughout this post, some details will be added to the process in order to properly setup testing tools and calculators.

## minimum detectable effect

minimum detectable effect, briefly mentioned in the {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}introductory post of this series{{< /anchor >}}, is the size of the difference that the researcher wants to see between two or more variations of a test. Is the {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-5/" >}}effect size{{< /anchor >}} to be expected. The minimum detectable effect is directly related to the sample size. The smaller the minimum detectable effect, the bigger must be the sample, which leads to more time to collect it. The hypothesis to be tested can contain a minimum expected size effect which can be used to configure testing tools and calculators.

Some companies state the expected minimum effect to be considered in a test, but end up finding differences that are smaller than what was expected. The business can then accept this difference and change its product or conclude that the cost to change will be greater than the return over investment.

## Minimum sample size for a test

Sample sizes depend on four factors:

- Minimum detectable effect;
- Alpha;
- Beta;
- Conversion rate (or the null hypothesis conversion rate).

Some calculators assume at least beta to be 0.2, without the possibility to change the probability of a false negative. After providing these four values in a calculator, it can show the amount of individuals required in a sample for each variation of a test or the size of the entire sample. I'll use {{< anchor href="https://www.evanmiller.org/ab-testing/sample-size.html" target="_blank" >}}Evan Miller's calculator{{< /anchor >}} to illustrate the effect of beta and the minimum detectable effect to calculate sample sizes.

{{< image src="images/figure1-evan-miller-sample-size-calculator.webp" alt="Sample size calculator configured with 5% minimum detectable effect and 0.2 beta (or 80% statistical power)" caption="Sample size calculator configured with 5% minimum detectable effect and 0.2 beta (or 80% statistical power). Source: Evan Miller." title="Sample size calculator configured with 5% minimum detectable effect and 0.2 beta (or 80% statistical power)." lazy="true" >}}

It shows the amount of individuais needed for each variation of a test. Required parameters are:

- Baseline conversion rate: is the conversion rate of a product. This is assumed in the null hypothesis;
- Minimum detectable effect: is the size of the difference that the researcher expect to see between conversions across each study group. The bigger this number, the bigger the difference to be expected and smaller the required sample size. This number is read alongside the baseline conversion rate. Using 20% as the average conversion rate and 5% minimum detectable effect, conversion rates below 15% and above 25% will be detected considering the error margin associated with beta (note that the calculator is configured to find the interval in absolute values);
- Statistical power (1 - beta): is the probability of correctly rejecting the null hypothesis when the alternate is true. Beta is the probability of false negative and 1 - beta is the statistical power;
- Significance level (alpha): is the probability of a false positive. Alpha and significance level are synonyms. In the example, alpha is 5% (or 0.05).

Calculators can work differently, like the one created by {{< anchor href="https://www.optimizely.com/sample-size-calculator/" target="_blank" >}}Optimizely{{< /anchor >}}, but the principles are the same.

{{< image src="images/figure2-ab-testing-sample-size-calculator.webp" alt="Optimizely's sample size calculator." caption="Optimizely's sample size calculator. Source: Optimizely." title="Optimizely's sample size calculator." lazy="true" >}}

This calculator is simpler when compared to the previous one and assume 100% statistical power (or 1), as per documentation, what explains the sample size being bigger than when calculated using {{< anchor href="https://www.evanmiller.org/ab-testing/sample-size.html" target="_blank" >}}Evan Miller's calculator{{< /anchor >}} using the same configuration. The bigger the statistical power (1 - beta), the smaller is beta (smaller is the probability of a false negative) and the bigger is the required sample size.

## Estimated duration of a test

Another common metric is the duration of a test. To calculate the duration of a test, it suffice to divide the sample size and the average daily number of visitors in the product. VWO calculator, for instance, ask the current and expected conversion rates, the number of testing variations and the percentage of visitors that will be included in the test in order to determine the duration of the test.

{{< image src="images/figure3-ab-testing-duration-calculator.webp" alt="VWO's testing duration calculator." caption="VWO's testing duration calculator. Source: VWO." title="VWO's testing duration calculator." lazy="true" >}}

It is useful to know how long a test will run in order to set up expectations, but achieve the required sample size is far more important. Also, since the number of daily visits given to the calculator is an average, this estimate cannot be taken as completely true. If a test runs for the expected number of days and the sample size has not achieved the required size, the test should continue until the sample size is big enough, while making sure that the test doesn't run for too long.

## Sample quality

The {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}first post of this series{{< /anchor >}} highlighted some technological restraints to perform tests with online samples. In summary, researchers have very limited amount of control over the conditions at which test subjects are exposed, which influence the quality of available samples. If not controlled properly, these conditions can invalidate any findings of a test. Some of these are:

- Interference between study groups;
- Multiple concurrent experiments;
- Cookie expiration;
- Seasonality and time based events;
- Multiple browsers and devices;

### Interference between study groups

This is somehow related to the problem when using multiple browsers and devices, in which participants can be exposed to the effect given to other variations in a test. This type of interference can also happen depending on the type of test being conducted. One example could be testing the shipping rate of a product. Users exposed to a certain price tag can recommend the product for other users based on that price, but when they get to the website, they may end up seeing a completely different shipping rate depending on the test variant they ended up. This create noise in the sample. It is important to think about the repercussion of what is being tested to know if a test with samples is the best way to validate a given hypothesis.

### Multiple concurrent experiments

Tests can be chained, increasing the risk of interference among tests. Chained tests can be **mutually exclusive**, meaning that participants from experiment 1 will not be subjected to experiment 2 and vice versa. Another type of chained test is **sequential**, in which one test must end for another to start. Mutually exclusive and sequential tests reduce can reduce noise when running multiple tests.

{{< image src="images/figure4-concurrent-tests.webp" alt="Diagram showing the possible combinations performed by samples from multiple tests." caption="Diagram showing the possible combinations performed by samples from multiple tests. Source: Optimizely." title="Diagram showing the possible combinations performed by samples from multiple tests." lazy="true" >}}

Multiple experiments can be done to reduce the necessary amount of time when performing tests, as long as there is enough sample for all tests.

### Cookie expiration

Given the fact that website and app visitors are anonymous at first, the cookie is the method by which testing tools identify them. If a visitor returns to a product after being selected for the test, the experience should remain consistent between visits. In other words, tools should remember that a returning visitor was previously selected for a study. There are some problems with cookies:

- They can be altered, deleted or blocked by test subjects;
- They are only available on the device that accessed the product (they aren't cross platform);
- They have expiration date.

Expiration dates for cookies vary according to the tool. VWO documentation, for instance, states that {{< anchor href="https://vwo.com/knowledge/what-are-the-cookies-stored-by-vwo/" target="_blank" >}}the cookies that are installed by VWO last for 100 days{{< /anchor >}}. Usually this can be configured by the researcher as needed and cannot be changed after the beginning of a test.

Given the instability of cookies to identify test subjects, it is not possible to guarantee that online samples are free from noise, no matter how much careful the environment was planned. The longer the test, the more noise gets added to the samples. A test that runs for too long can have a lot of noise and the test can lose it's validity. It is common to assume that {{< anchor href="https://conversionxl.com/blog/sample-pollution/" target="_blank" >}}tests running for more than 30 days already have a lot of noise{{< /anchor >}} on the sample.

### Seasonality and time based events

Seasonal events are exceptions to the rule. Adding seasonality as a variable avoid surprises when analyzing the behavior of a sample, and diminishes the chance of invalidating the test. Black Friday is an example of a seasonal event. Tests being performed during this event must take into account that samples will be composed of people that are looking for good prices when shopping, which can be something atypical for other times of the year. One way to control for seasonality is to test just during the seasonal event, assuming it for the hypothesis, or avoid tests during seasonal events.

Study groups can also behave differently during certain periods, like weekends. Depending on the type of business and product, traffic volumes decrease during weekends. Even during weekdays there can be differences. Let's say, for instance, that every Wednesday night customers of an e-commerce receive a newsletter containing a selection of products with discounts and some of them visit the website to redeem the offer. These visitors can generate noise to the sample, as they behave differently. To deal with that, some recommendations are to {{< anchor href="https://www.convertize.com/ab-testing-statistics/" target="_blank" >}}run tests for at least one or two full weeks{{< /anchor >}}, but it is important to remember that the sample size must be achieved.

### Multiple browsers and devices

The biggest challenge when conducting tests with online samples is to identify the same individual from a sample across multiple browsers and devices. Even using the same browser, visitors can use both an anonymous and a regular session, which will count it as being two distinct users. Since cookies are not shared across browsers and devices, different browsers will be counted as different individuals, and the same can be said for devices. There are some solutions to control for the noise, but there are no known solutions to eliminate the problem entirely. Some options are testing based on {{< anchor href="https://www.goinflow.com/ab-testing-cross-device-world/" target="_blank" >}}geographic regions{{< /anchor >}} or {{< anchor href="https://conversionxl.com/blog/sample-pollution/" target="_blank" >}}use Google Analytics Universal with User IDs{{< /anchor >}}, which requires a login system as well as a dedicated view on Google Analytics to count cross device sessions.

Online samples will always have some noise, despite how controlled is the environment.

### Statistical significance and sample size

There are calculators for sample size, duration of a test and also for statistical significance. Statistical significance is also known as the compliment of alpha, or 1 - alpha. This number is more common when using calculators or testing tools, as is easier to comprehend by those who have no statistical background but need to run tests. Statistical significance calculators receive as inputs the desired level of statistical significance, the number of visits and the number of conversion events for each testing variation. {{< anchor href="https://abtestguide.com/calc/" target="_blank" >}}AB Test Guide{{< /anchor >}} calculator accepts as input the possibility to choose between one and two tails.

{{< image src="images/figure5-statistical-significance-calculator.webp" alt="AB Test Guide statistical significance calculator." caption="AB Test Guide statistical significance calculator. Source: AB Test Guide." title="AB Test Guide statistical significance calculator." lazy="true" >}}

This example show the result for a test with two tails, which allows for results worse than the default.

## Differences on reporting for testing tools and analytics tools

Is is normal that access and conversion numbers that are reported on testing tools and analytics tools do not match. There are many reasons for that being, but some are:

- The differences on how testing and analytics software register visitors, unique sessions and conversion events;
- Errors when implementing the tools;
- Time to load the scripts.

One way to reduce the difference between reports is to use the analytics tool as a test reporting panel and send all testing data to it.

## Commercial bias for testing tools

The value proposition offered by most testing tools is that researcher do not need to know statistics to perform tests. To accomplish this, providers assume default values for some variables like beta (and by extension its compliment, statistical power) or if the test have one or two tails. It can be the case that the researcher don't need to know anything about statistics to perform tests and is capable to use such tools. The problem with that is that the researcher won't be able to question the results or if they apply to the needs of the business. As seen on the {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}introductory post for this series{{< /anchor >}}, getting to know some topics within the field of statistics can enrich the analysis of a test.

## Further reading

- How to perform {{< anchor href="https://conversionxl.com/blog/can-you-run-multiple-ab-tests-at-the-same-time/" target="_blank" >}}multiple tests simultaneously{{< /anchor >}}.

Let's optimize conversions!
