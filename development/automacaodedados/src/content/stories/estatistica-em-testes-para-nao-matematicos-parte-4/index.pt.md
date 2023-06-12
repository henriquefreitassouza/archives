---
title: 'Estatística para testes - Histogramas e curvas de densidade'
author: henriquesouza
publishDate: 2017-11-26 09:59:00
lastMod: 2021-10-23 09:59:00
summary: 'Ao longo de um teste, várias amostras são obtidas e suas taxas de conversão são calculadas. O próximo passo é agrupar e classificar esses dados de tal forma que seja possível tirar as informações necessárias para inferir dados sobre toda a população. Como exatamente isso acontece e qual sua importância para a execução de testes?'
description: 'Estatística para testes - Histogramas e curvas de densidade'
image_description: 'Gráficos de histograma e curva de densidade.'
categories:
- Estatística
featured: true
---

Publicado em 26/11/2017 e atualizado em 23/10/2021.

Este post é o quarto de uma série com 6 em que vou destrinchar os principais conceitos estatísticos para testes online. Os tópicos serão:

- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}A importância de entender estatística para testes com amostras{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-2/" >}}Hipóteses{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}Amostras e probabilidades{{< /anchor >}};
- **Histogramas e curvas de densidade** (este post);
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-5/" >}}P-valor, alfa, beta e tamanho do efeito{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-6/" >}}Configuração de testes com amostras online e de calculadoras{{< /anchor >}}.

Bônus: {{< anchor href="/stories/calculadora-de-significancia-estatistica-para-testes-ab/" >}}Calculadora de significância estatística para testes A/B{{< /anchor >}}.

## Medidas de tendência central e distribuição dos dados

Conjuntos de dados amostrais são explicados usando dois tipos de números: um que seja representativo de todo o grupo e outro que explique a dispersão dos dados. O primeiro destes números é a **medida de tendência central**, brevemente apresentada no {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}post anterior{{< /anchor >}}, e o segundo é a **medida de distribuição**. O post anterior também apresentou as medidas de tendência central mais comuns, que são:

- Média: a média é a medida mais conhecida entre elas. É calculada pela soma de todos os dados numéricos e dividido pela quantidade de dados somados;
- Mediana: a mediana é obtida após ordenar os dados e selecionar o número que estiver no meio do conjunto. Se o conjunto tiver uma quantidade par de dados, a mediana é a média dos dois números mais ao meio;
- Modo: o modo é o número que aparece com mais frequência em um conjunto de dados. Se dois ou mais números aparecem no conjunto com a mesma frequência, o conjunto terá mais de um modo, proporcional a quantidade de números com igual frequência.

Cada medida tem seus usos, e dentro de testes é comum usar a média.

Além das medidas de tendência central existem as medidas de distribuição de dados. Entender a forma como os dados estão distribuídos em um conjunto de dados é importante para calcular o quanto eles **desviam** da medida de tendência central. Duas dessas medidas são:

- Variância: a variabilidade média dos dados;
- Desvio padrão: a raiz quadrada da variância, usada em conjunto com a média para estimar a dispersão média do conjunto de dados.

Ambas as medidas explicam a dispersão de dados de um conjunto, porém a variância não é sensível a diferenças nas distâncias entre valores. Isso significa que não é possível detectar números que estejam mais ou menos próximos entre si. Este problema é resolvido ao calcular a raiz quadrada da variância, chegando no desvio padrão. O desvio padrão é comparado a média para saber se um número está dentro ou fora da média do conjunto.

## A classificação das probabilidades de sucesso

O {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}post anterior{{< /anchor >}} apresentou brevemente a teoria da probabilidade, a probabilidade de sucessos dentro do contexto online, ou a taxa de conversão, bem como a importância de coletar taxas de conversão de várias amostras para encontrar a taxa de conversão da população. O próximo passo é entender o que acontece quando essas várias taxas de conversão são coletadas.

Ao longo da execução de um teste online, o tráfego participante é contabilizado, e também o número de indivíduos que executaram a ação em estudo que representa a conversão em cada uma das variações do teste (seja submeter um formulário, clicar em um botão, comprar e etc). Amostras desse tráfego são separadas, e suas taxas de conversão são colhidas. Essas taxas de conversão são classificadas em “baldes” chamados de **frequências**. O número de frequências em um conjunto de dados é definido e ajustado pela ferramenta de testes conforme os dados dos participantes vão sendo colhidos. Um exemplo delas seria “entre 0% e 0,99%, entre 1% e 1,99%, entre 2% e 2,99%, ..., entre n% e n,99%”. As taxas de conversão das amostras são então calculadas e agrupadas de acordo com a frequência apropriada.

O gráfico que representa as distribuições de frequências é o **histograma**. O histograma é um gráfico de distribuição de dados numéricos em frequências por número de ocorrências em cada frequência. Nesse caso, as frequências são os intervalos de probabilidades de sucesso, representadas no eixo x (abcissas), e o número de amostras em cada frequência, representadas no eixo y (ordenadas).

{{< image src="images/figure1-histogram-with-bins.webp" alt="Exemplo de histograma com frequências definidas." caption="Exemplo de histograma com frequências definidas. Fonte: Autor." title="Exemplo de histograma com frequências definidas." lazy="true" >}}

## A lei dos números grandes e o teorema do limite central

A forma como as taxas de conversão estão distribuídas ao longo do conjunto é importante. Quanto mais amostras vão sendo coletadas, e mais taxas de conversão vão sendo calculadas, mais o conjunto de dados vai tomando uma forma específica, quando apresentado em um histograma. O post sobre {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}probabilidades{{< /anchor >}} fez menção a chamada lei dos números grandes, que diz que quanto maior o grupo de estudo, mais as médias dos eventos observados em amostras desse grupo vão se aproximando da média para toda a população. Isso fica visível em um histograma, a medida que mais taxas de conversão vão sendo classificadas dentro das frequências. O formato que o histograma assume se parece com uma montanha, ou um **sino**.

{{< image src="images/figure2-histogram-resembling-a-normal-distribution.webp" alt="Exemplo de histograma tomando uma forma específica." caption="Exemplo de histograma tomando uma forma específica. Fonte: Autor." title="Exemplo de histograma tomando uma forma específica." lazy="true" >}}

Essa organização específica do conjunto de dados é chamada de **distribuição normal** (ou distribuição gaussiana, ou distribuição em forma de sino). A distribuição normal está dentro de um campo na matemática chamado de **distribuição probabilística**, que são funções matemáticas que tratam de explicar a probabilidade de ocorrência de determinados eventos. Há mais de um tipo de distribuição probabilística, e a que explica a distribuição normal é a **distribuição probabilística contínua**. A distribuição probabilística contínua calcula a probabilidade de um número estar dentro de algum intervalo de valores.

{{< image src="images/figure3-distribution-over-histogram.webp" alt="Histograma próximo de uma distribuição normal." caption="Histograma próximo de uma distribuição normal. Fonte: Autor." title="Histograma próximo de uma distribuição normal." lazy="true" >}}

Quanto maior o número de amostras e taxas de conversão registradas, mais a distribuição dos dados vai tomando a forma normal. Este conceito é chamado de **teorema do limite central**. Pelo teorema do limite central, o comportamento dos dados amostrais reflete o comportamento dos dados populacionais, o que significa que a distribuição dos dados das amostras e da população será igual ou muito próxima. É esta certeza que torna possível usar dados amostrais para inferir comportamentos e características de populações.

## A regra empírica

As funções de distribuição probabilística fazem cálculos sobre a **área** da distribuição, e o objetivo é saber qual a probabilidade de um dado número estar dentro da área delimitada. Como probabilidades de sucesso podem assumir qualquer valor, e é impossível saber qual é essa probabilidade para toda a população, o cálculo da área se torna útil para determinar uma faixa de possíveis valores onde a probabilidade de sucesso pode estar, sendo esta área o intervalo de confiança, brevemente apresentado no {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}post anterior{{< /anchor >}}. Outra propriedade útil de distribuições, em particular da distribuição normal, é a chamada **regra empírica**: esta regra, convenientemente conhecida como regra 68-95-99,7, diz que 68% dos dados em uma distribuição normal estão concentrados a uma medida de distância do centro da distribuição, 95% dos dados estão a duas medidas de distância do centro e 99,7% a três medidas de distância do centro. A medida de distância é o desvio padrão e o centro da distribuição é a média.

{{< image src="images/figure4-normal-distribution-and-standard-deviation-pt.webp" alt="Marcação dos desvios padrão em uma distribuição normal." caption="Marcação dos desvios padrão em uma distribuição normal. Fonte: Autor." title="Marcação dos desvios padrão em uma distribuição normal." lazy="true" >}}

Uma vez que a distribuição normal tenha sido alcançada para cada variação do teste, são necessários mais alguns cálculos para obter os números que são mostrados no painel de uma ferramenta de testes. Essas curvas também precisam ser sobrepostas para extrair a diferença entre elas. Este será o tópico do próximo post.

## Leitura complementar

{{< anchor href="https://stats.stackexchange.com/questions/35123/whats-the-difference-between-variance-and-standard-deviation" target="_blank" >}}Este post no fórum de estatística do Stack Exchange{{< /anchor >}} explica com mais detalhes a diferença entre variância e desvio padrão.

Bora estudar estatística!
