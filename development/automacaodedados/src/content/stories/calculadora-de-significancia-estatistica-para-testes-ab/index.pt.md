---
title: Calculadora para testes com amostras online
author: henriquesouza
publishDate: 2017-12-06 11:36:00
lastMod: 2021-11-03 11:36:00
summary: Construí uma calculadora para testes com amostras online. Ela retorna o tamanho da amostra necessária para o teste, a duração estimada de dias para que o teste seja concluído e a significância estatística de todas as variações. Explicarei neste post como esta calculadora funciona e como usá-la.
description: Calculadora para testes com amostras online
image_description: 'Configurações da calculadora para testes com amostras, feita no Google Sheets'
categories:
- Estatística
featured: true
---

Publicado em 06/12/2017 e atualizado em 03/11/2021.

Ao longo da {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}série de posts sobre estatística para testes{{< /anchor >}}, foram apresentados vários conceitos de estatística inferencial que são usados em aplicações envolvendo testes com amostras. Com esta calculadora, tudo o que foi apresentado na série será posto em prática.

## Configurações

{{< image src="images/figure1-calculator-configurations.webp" alt="Configurações da calculadora de testes com amostras." caption="Configurações da calculadora de testes com amostras. Fonte: Autor." title="Configurações da calculadora de testes com amostras." lazy="true" >}}

Essa é a parte editável da calculadora. Os parâmetros são:

- Número de variações (controle + tratamentos): o número de divisões do grupo de estudo, sendo o número composto pelo grupo de controle mais todos os grupos de tratamentos;
- Caudas: informa se o teste é em uma ou nas duas caudas da distribuição normal. Esse parâmetro define se α (alfa) será distribuído entre as extremidades da distribuição. Em termos práticos, define se a pessoa projetista de testes quer ver tanto pioras quanto melhoras na performance do grupo de tratamento em relação ao grupo de controle ou quer ver apenas melhoras. Se forem duas caudas, alfa será α / 2;
- Significância estatística (1 - α): o intervalo de confiança nos resultados obtidos, ou a probabilidade de corretamente rejeitar a hipótese nula;
- Poder estatístico (1 - β): a probabilidade de encontrar o efeito esperado. Em termos estatísticos é a probabilidade de corretamente aceitar a hipótese alternativa. A larga maioria das calculadoras e ferramentas de teste usa 80% de poder estatístico (e consequentemente, 20% de probabilidade de falso negativo). β é a letra grega que representa beta;
- Taxa de conversão atual: a taxa de conversão média do evento em estudo;
- Efeito mínimo detectável: o tamanho da diferença entre os grupos de estudo que o pesquisador quer ver. Útil para ignorar diferenças muito pequenas, que possivelmente não valem o esforço de implementação mesmo em caso de vitória do grupo de tratamento;
- Média de sessões / usuários por dia: essa média é a de pessoas que passam pela página que está sendo trabalhada. O número serve para calcular a quantidade de dias necessários para o teste;
- Percentual de sessões / usuários incluídos no teste: percentual do tráfego do site que participará do teste.

As configurações de Erro e Z-score são usadas para os demais cálculos. O erro tira o alfa da significância estatística com a equação **1 - (1 - α)**, onde 1 - α é a significância estatística. Os z-scores de alfa e beta são usados para calcular o tamanho da amostra.

Para cada divisão do grupo de estudo, os parâmetros são:

- Número de sessões / usuários: número de visitantes que passaram por cada uma das variações do teste. Note que fica a cargo da pessoa projetista de testes usar usuários únicos, sessões ou visitas. Ferramentas de testes costumam usar sessões, mas dependendo do tipo de negócio o número de sessões pode divergir muito do número de usuários;
- Número de conversões: número de eventos de conversão em cada variação.

Esta calculadora compara até 4 variações (controle + três tratamentos), mas se o teste possuir menos, basta configurar o número de variações e os dados de acesso / conversões de acordo e deixar em branco o que não for usado.

## Z-scores

{{< image src="images/figure2-z-score-one-two-tails.webp" alt="Z-scores de alfa e beta com uma e duas caudas." caption="Z-scores de alfa e beta com uma e duas caudas. Fonte: Autor." title="Z-scores de alfa e beta com uma e duas caudas." lazy="true" >}}

Essa tabela de z-scores é usada apenas para calcular o tamanho da amostra com uma e duas caudas. Ferramentas e calculadoras de testes com amostras não mostram esta tabela. Com base na seleção dos níveis de significância estatística e poder estatístico, uma consulta é feita nessa tabela para retornar os z-scores correspondentes.

## Tamanho da amostra

{{< image src="images/figure3-sample-size-estimator.webp" alt="Tamanho da amostra por variação, total e estimativa de dias para a realização do teste." caption="Tamanho da amostra por variação, total e estimativa de dias para a realização do teste. Fonte: Autor." title="Tamanho da amostra por variação, total e estimativa de dias para a realização do teste." lazy="true" >}}

O tamanho de amostra é calculado usando a equação **numerador * (σ / (p * efeito))**, onde numerador é **2 * (α + β)²**, p é a taxa de conversão atual e efeito é o efeito mínimo detectável, ou o tamanho da mudança que o pesquisador deseja ver entre os grupos de estudo de controle e tratamentos. A letra σ é o desvio padrão amostral. O numerador que compõe a fórmula de cálculo de tamanho de amostra é definido na {{< anchor href="http://www.vanbelle.org/chapters/webchapter2.pdf" target="_blank" >}}equação de Lehr{{< /anchor >}}, uma equação para cálculo de tamanho de amostra, e a larga maioria das calculadoras e ferramenta assume o número 16. Para que o numerador seja 16, α precisa ser 0,05 e β precisa ser 0,2. Em outras palavras, significância estatística deve ser 95% e poder estatístico deve ser 80%. O valor exato que a equação do numerador produz com esses parâmetros é 15,68. O número é, então, arrendondado para 16. Esta calculadora calcula o numerador sem usar a regra dos 16, como é conhecida, o que faz com que o tamanho da amostra discorde das demais calculadoras e ferramentas.

Ao lado do tamanho da amostra por variação é mostrado o tamanho da amostra usada no teste. O número varia conforme o tráfego que será considerado para o teste.

O tamanho do grupo de estudo é a multiplicação do tamanho da amostra pelo número de variações. Se não for usado 100% do tráfego para o teste é usada a equação **((((1 - tráfego) * amostra) + (amostra * tráfego)) * variações) - 1**, onde tráfego é o percentual do tráfego do site a participar do teste, amostra é o tamanho da amostra **por variação** e variações é o número de variações do teste (controle + tratamentos). A subtração de 1 no final aproxima o tamanho do tráfego total com a soma de cada variação.

Estimativa de dias para o teste é a divisão do tamanho total do grupo de estudo pelo número médio de visitantes, considerando o tráfego que será usado para o teste. Note que essa estimativa pode diferir bastante do número de dias estimado em outras calculadoras. A {{< anchor href="https://vwo.com/ab-split-test-duration/" target="_blank" >}}calculadora de duração estimada da VWO{{< /anchor >}} por exemplo, estima que um teste dure 37 dias se usados estes parâmetros:

- *Estimated existing conversion rate*: 30%;
- *Minimum improvement in conversion rate you want to detect*: 10%;
- *Number of variations / combinations (including control)*: 2;
- *Average number of daily visitors*: 1000;
- *Percent visitor included in test*: 20%.

A calculadora que criei estima que o número de dias seja 49 com duas caudas e 29 com uma cauda, usando os mesmos parâmetros. Isso acontece por conta da forma como o numerador é calculado, dispensando a regra dos 16, e o fato de o número de caudas ser assumido na calculadora da VWO.

## Cálculos

{{< image src="images/figure4-p-value-calculation.webp" alt="Cálculo das métricas até chegar em p-valor e z-score." caption="Cálculo das métricas até chegar em p-valor e z-score. Fonte: Autor." title="Cálculo das métricas até chegar em p-valor e z-score." lazy="true" >}}

Com os dados de configuração, as equações serão executadas e os valores de resposta obtidos. Estes cálculos são:

- Taxa de conversão: proporção de cada variação que executou o evento de conversão. A equação usada foi **p = s / t**, onde p é a proporção, s é o número de conversões e t é o tamanho do grupo de estudo de cada variação;
- Diferença para o grupo de controle: diferença na taxa de conversão entre cada tratamento e o grupo de controle. A equação usada foi **(p1 / p0) - 1** onde p1 é a proporção para o grupo de tratamento, p0 é a proporção para o grupo de controle e - 1 é uma transformação aplicada ao inverso do quociente (o resultado da divisão). Essa transformação resulta na diferença entre as taxas de conversão;
- Variância: medida de dispersão dos dados na distribuição. A equação usada é **σ² = p * (1 - p)**, onde σ² é a variância. O cálculo é uma multiplicação entre a proporção e sua inversão. A letra grega σ chama-se sigma;
- Desvio padrão: raiz quadrada da variância. Tirar a raiz funciona como uma espécie de “correção” do número, que melhor reflete a dispersão dos dados na distribuição. A equação usada é **σ = √σ²**, onde σ é o desvio padrão;
- Erro padrão: similar ao desvio padrão, porém a dispersão é calculada em relação a média populacional. Particularmente útil para determinar uma medida de desvio padrão quando há dois ou mais grupos de amostras sendo estudados, como é o caso de testes com amostras online. No erro padrão, as médias de todas as variações são levadas em consideração para determinar a média dessas médias e calcular o desvio a partir dela. A equação usada é **σx̄ = σ / √n**, onde σx̄ é o erro padrão e n é o tamanho da amostra. O símbolo x̄ representa uma média amostral;
- Z-score: a quantidade de desvios padrão em relação a média. A equação tradicional do z-score é **z = (x - μ) / σ**, onde z é o z-score, x é uma proporção individual (nesse caso, o valor de p) e μ é a média populacional. Como a média populacional é desconhecida, há mais de um grupo de estudo e precisamos normalizar as medidas de desvio em uma só para sobreposição das distribuições normais, a equação usada fica **(p1 - p0) / √(σx̄0² + σx̄1²)**, onde p1 é a proporção do grupo de tratamento, p0 é a proporção do grupo de controle, σx̄0² é o erro padrão do grupo de controle ao quadrado e σx̄1² é o erro padrão do grupo de tratamento ao quadrado;
- P-valor: considerando que a hipótese nula é verdadeira, é a probabilidade de obter um efeito extremo. Em outras palavras, a probabilidade de encontrar uma anomalia nos dados se nenhuma mudança tiver sido feita no grupo de estudo. A hipótese é a de que a probabilidade de encontrar tal anomalia é baixa então se esse número for pequeno, chances são de que a anomalia foi causada por uma indução de comportamento por parte do pesquisador. A equação é **1 - NORMSDIST(ABS(z))**, onde NORMDIST é a função de cálculo de uma distribuição normal cumulativa no Google Sheets. Como a proporção é uma variável contínua (pode assumir valores infinitos), a função que explica estes dados é cumulativa. ABS é a função de módulo do Google Sheets, ela transforma o número em um número positivo, pois p-valor é um número entre 0 e 1. O cálculo de z na distribuição normal retorna a área coberta pelo valor de z. O p-valor é o inverso desse número e representa a área que vai de uma das extremidades da distribuição normal até o ponto definido em p-valor, por isso a subtração de 1 no início da equação.

## Resultados

{{< image src="images/figure4-p-value-calculation.webp" alt="Configurações da calculadora de significância estatística." caption="Configurações da calculadora de significância estatística. Fonte: Autor." title="Configurações da calculadora de significância estatística." lazy="true" >}}

Essa seção mostra os resultados dos cálculos executados. Ela mostra os valores de α e β, se o resultado é estatisticamente significante e o intervalo de confiança. Sobre α, é aplicada a chamada correção de Bonferroni quando há mais de duas variações em um teste. A cada variação adicionada em um teste multivariável, as chances de um erro do tipo I (falso positivo) aumentam. A correção de Bonferroni é uma de várias formas de lidar com a inflação de α e a equação é **α / variações**, onde variações é o número de variações do teste (controle + tratamentos). A correção de Bonferroni é dita conservadora pois diminui α, o que requer uma amostra maior para atingir a significância estatística.

Por fim, a calculadora informa se é possível parar o teste ou não. A equação verifica o número de variações que o teste possui e verifica se foram atingidas duas condições:

- Se o tamanho total do grupo de estudo que passou pelo teste é maior ou igual ao tamanho da amostra calculada;
- Se todos os tratamentos possuem significância estatística maior ou igual a definida nas configurações.

Se o teste é multivariável, a significância estatística é verificada após a correção de Bonferroni.

## Leitura complementar

Há várias calculadoras online para cálculo de tamanho de amostra, significância estatística e duração de teste. Cada calculadora assume alguns valores para que a pessoa projetista de testes não tenha que se preocupar com a estatística por trás dela. Esta calculadora é diferente, pois não assume valor algum nos cálculos feitos.

As calculadoras que usei de referência foram:

- {{< anchor href="https://vwo.com/ab-split-test-duration/" target="_blank" >}}Calculadora de duração de testes da VWO{{< /anchor >}};
- {{< anchor href="https://vwo.com/blog/ab-testing-significance-calculator-spreadsheet-in-excel/" target="_blank" >}}Calculadora de significância estatística da VWO{{< /anchor >}};
- {{< anchor href="(https://vwo.com/blog/ab-test-duration-calculator/" target="_blank" >}}Calculadora de duração de testes da VWO - Excel{{< /anchor >}};
- {{< anchor href="https://medium.com/@rikhigham/a-free-excel-p-value-significance-calculator-ebaae9dc8c68" target="_blank" >}}Calculadora de significância estatística do Rik Higham{{< /anchor >}};
- {{< anchor href="https://www.evanmiller.org/ab-testing/sample-size.html" target="_blank" >}}Calculadora de tamanho de amostra do Evan Miller{{< /anchor >}}.

Caso precise refrescar a memória quanto aos conceitos matemáticos, leia minha série de posts sobre o assunto:

- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}A importância de entender estatística para testes{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-2/" >}}Hipóteses{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}Probabilidades{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-4/" >}}Histogramas e curvas de densidade{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-5/" >}}P-valor, alfa, beta e tamanho do efeito{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-6/" >}}Setup de testes e configuração de calculadoras{{< /anchor >}}.

Bora calcular significâncias estatísticas, tamanhos de amostra e durações estimadas para teste!
