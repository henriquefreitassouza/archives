---
title: 'Statistics for testing - why should I know statistics?'
author: henriquesouza
publishDate: 2017-11-22 10:35:00
lastMod: 2021-10-20 10:35:00
summary: When you see the results of an A/B or split test, do you question the results that you get or accept them without hesitation? If you don\'t question them, you should.
description: 'Statistics for testing - why should I know statistics?'
image_description: 'Several statistics calculators used for statistical inferences.'
categories:
- Statistics
featured: true
---

Published on November 22, 2017 and updated on October 20, 2021.

this is the first post on a series with 6 in which I'll break down the main topics within statistics for online sample testing. The topics are:

- **The importance of understanding statistics for tests with samples** (this post);
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-2/" >}}Hypotheses{{< /anchor >}};
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}Samples and probabilities{{< /anchor >}};
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-4/" >}}Histograms and density curves{{< /anchor >}};
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-5/" >}}P-value, alpha, beta and power{{< /anchor >}};
- {{< anchor href="/en/stories/estatistica-em-testes-para-nao-matematicos-parte-6/" >}}Designing tests and configuring calculators{{< /anchor >}}.

Bonus: {{< anchor href="/en/stories/calculadora-de-significancia-estatistica-para-testes-ab/" >}}A/B testing significance calculator{{< /anchor >}}.

The first post in this series will highlight the importance of having some statistical background to study samples, and what are the possible test types that can be done with online samples.

## The tools that I use already do all the calculations, so why should I worry about it?

Interpreting results is an experiment step, and one that have the same level of importance as all the other steps. A bad or wrong interpretation can lead to wrong conclusions. A simple example can be found in the so called **statistical significance**. If you start a test and stop it as soon as it reaches statistical significance for the first time, you're probably going to get results that are not representative of the whole population. Statistical significance isn't alone a reason to stop the test, as I will explain in a future post. This is only one of many possible ways to invalidate a test. A {{< anchor href="https://www.google.com.br/search?biw=1536&bih=734&ei=I3AVWv66LIOgwgSVx5e4Aw&q=ab+tests+done+wrong&oq=ab+tests+done+wrong&gs_l=psy-ab.3..33i22i29i30k1.5850.7240.0.7331.13.9.0.0.0.0.256.1048.0j5j1.6.0....0...1c.1.64.psy-ab..7.5.792...0j0i22i30k1j0i22i10i30k1j33i160k1j33i21k1.0.Of9q5XbMUnQ" target="_blank" >}}simple online search{{< /anchor >}} will yield a plethora of results with examples of common errors when designing online sample tests.

## How much mathematics should I know to work with sample testing?

Enough to understand how sample tests work and how they are configured. It isn't necessary to know how to calculate complex formulas by hand, but know what they are and what each variable is in order to correctly read data that results from tests with samples. Any tool with make the calculations, but what they return as a result still should be properly interpreted. {{< anchor href="https://www.evanmiller.org/ab-testing/" target="_blank" >}}Some sample size or testing time calculators{{< /anchor >}} will expect information that will be directly fed into the mathematical formulas that calculate those numbers, and those that do not ask for such information will assume default values. The problem with that is that the default options won't be always the best ones for the business. One example is the definition of **minimal detectable effect**. Depending on the context, it may be misleading to treat a testing variation as a winner by a small change. The size of the difference that you expect is defined by that variable, and it is common that sample test calculators set a default value. Setting this parameter will change the sample size required to finish a test, which will in turn change the amount of time required to collect the required sample.

## Characteristics of experiments with online samples

Collecting online samples and designing experiments for digital products aren't that different from designing experiments with samples on areas like medicine and politics. In medicine, for instance, what changes is that the testing environment is more controlled, the number of samples is usually smaller, and the statistical significance required to conclude an experiment is usually greater than the ones typically used in businesses. Research in this area can also use different testing techniques, which are outside the scope of this post, depending on what is required. Statistical studies in the field of politics, on the other hand, resembles what is commonly done in marketing, product or data departments. To know voting intentions for the entire population of contries, many electorate samples are randomly selected to participate on voting intention researches and, based on the answers of the samples, voting intentions for the entire country are inferred.

Some characteristics that apply only to tests with online samples are:
- The lack of control that the researches have on the environment in which studies are carried (the online);
- Samples are made from anonymous users, identified only by a cookie installed on their machines. Problems with cookies are their expiration date and the possibility of being altered;
- It is hard to draw characteristics from the sample. Studies are then behavioral;
- Cross platform experiences are usually problematic for tests and generate noise in the data.

The number of variables outside the control of the researches is simply uncountable. It is impossible to ensure the complete absence of noise on data, but it is possible to ensure that the procedures used to collect the data and the statistical requirements are met to produce data that represent the whole population being studied.

## Online sample testing types

A/B tests are so popular that sometimes this may be the only type of test that exists. There are other types of tests that can be designed according to the need and the objective. The testing types are:

- A/B test: this is a test in which samples are split in two groups. One of the groups receive some kind of treatment and the behaviors of both groups are compared against each other for correlations between the treatment and the presented behavior. One example of this test is the split of traffic on two versions of a web page.
- mvt test: the multivariate test, or mvt test, is designed to study behaviors when multiple treatments are given to portions of the sample and are then compared to a sample without any modifications. The samples are studied in search of correlations between the treatments and the presented behaviors. One example of this test is when traffic of a web page is split among many versions of a page that have some differences between them.
- A/B/N test: similar to the mvt test. The main difference is that the treatment applied consist of variations from the same base change across portions of the sample, when the mvt test accepts different changes across the samples. One example of this test is to split the traffic of a web page across versions of it that have variations on the same element.
- Split test: this test is specific to online environments, in which portions of the traffic of a page are split across different web addresses. This can be used to test different variations of a page layout or different pages.
- mab test: the multi armed bandit, or mab, test is one that use machine learning algorithms to split the sample and study their behaviors. These samples are then categorized by predictive models based on clustering techniques, which organizes samples based on common behavioral patterns.

In general, A/B tests are more commonly used, since they are simpler and give researches more comfort to correlate behaviors with given treatments. When new variables are presented, the test becomes more complex, and the possibility of errors is increased.

The following posts will present important topics on statistics for tests with samples, starting with hypothesis.

Let's learn statistics!
