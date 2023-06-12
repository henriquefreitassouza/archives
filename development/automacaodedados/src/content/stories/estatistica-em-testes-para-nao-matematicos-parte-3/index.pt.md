---
title: 'Estatística para testes - Amostras e probabilidades'
author: henriquesouza
publishDate: 2017-11-24 11:21:00
lastMod: 2021-10-22 11:21:00
summary: 'Como garantir que o resultado de um teste de hipóteses com amostras é representativo da população estudada?'
description: 'Estatística para testes - Amostras e probabilidades'
image_description: 'Função de probabilidade. P é igual a divisão entre a probabilidade de um evento e o conjunto de eventos possíveis.'
categories:
- Estatística
featured: true
---

Publicado em 24/11/2017 e atualizado em 22/10/2021.

Este post é o terceiro de uma série com 6 em que vou destrinchar os principais conceitos estatísticos para testes online. Os tópicos serão:

- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}A importância de entender estatística para testes com amostras{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-2/" >}}Hipóteses{{< /anchor >}};
- **Amostras e probabilidades** (este post);
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-4/" >}}Histogramas e curvas de densidade{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-5/" >}}P-valor, alfa, beta e tamanho do efeito{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-6/" >}}Configuração de testes com amostras online e de calculadoras{{< /anchor >}}.

Bônus: {{< anchor href="/stories/calculadora-de-significancia-estatistica-para-testes-ab/" >}}Calculadora de significância estatística para testes A/B{{< /anchor >}}.

Raramente experimentos em ambientes digitais serão feitos com populações inteiras, ao menos em um contexto corporativo. Quando é impossível estudar cada indivíduo de uma população, são utilizadas amostras. Uma amostra é um grupo extraído de uma população. Os aprendizados com a amostra são, então, assumidos para toda a população de onde a amostra foi retirada. Como exatamente é formada a amostra e como saber se ela de fato representa a população em estudo?

## População x amostra

Uma população representa todos os indivíduos de um grupo. A população de um país, por exemplo, é composta por todas as pessoas que vivem naquele país. Em produtos digitais, uma população é composta por todas as pessoas que acessam o produto. Já a amostra representa uma porção da população, e é usada para inferir informações que se apliquem a toda uma população.

Amostras possuem qualidade. Uma boa amostra é capaz de representar a população estudada. A coleta das amostras deve, então, ser feita com muito cuidado. Mesmo um experimento bem executado e sem erros aleatórios pode gerar resultados errados, se a amostra não é representativa da população. Para ser boa, uma amostra precisa ser:

- Significante: isto é, ser grande os suficiente para o estudo em questão;
- Representativa: as características da amostra precisam ser fiéis aquelas da população;
- Randômica: a seleção da amostra precisa ser randômica para evitar análises tendenciosas.

Ferramentas de teste irão garantir a seleção randômica da amostra, mas a significância e a representatividade serão determinadas pela pessoa projetista de testes.

Populações e amostras são grupos que apresentam traços comuns de comportamento. Para saber como o grupo está organizado em função destes traços, um número conhecido como **medida de tendência central** é utilizado. Medidas de tendência central são números que explicam conjuntos de dados. As três mais comuns são a média, a mediana e o modo. Para testes com amostras online, a **média** é utilizada. Ter um conjunto explicado por um único número é útil para conhecer a organização geral do grupo. Quando não é possível ter acesso a toda uma população para um estudo, a **média populacional** é simplesmente desconhecida. Quando a média populacional é desconhecida, a medida usada é a **média amostral**. Quanto mais significativa e representativa a amostra for, mais próxima essa média estará da média populacional.

Quando estudos estatísticos são feitos com amostras, as ferramentas matemáticas utilizadas para calcular o nível de proximidade das amostras com as populações entram no campo da **estatística inferencial**.

## Estatística descritiva e estatística inferencial

O campo da estatística é dividido em dois conjuntos, chamados de **estatística descritiva** e **estatística inferencial**.

- Estatística descritiva: busca explicar conjuntos de dados. Sumarizar estes conjuntos de dados com médias ou explicar a distribuição destes dados são operações de estatística descritiva. É importante notar que em estatística descritiva não é possível tirar conclusões que estão além do conjunto de dados estudado;
- Estatística inferencial: busca explicar características de toda uma população baseado em partes dela. Testes com hipóteses são ferramentas estatísticas dentro deste grupo.

A inferência em estatística inferencial se dá pela **probabilidade**.

## Probabilidades

Probabilidade é a chance de um evento acontecer. Probabilidades são divididas em dois tipos: **independente** e **condicional**.

### Probabilidade independente

A independência entre probabilidades significa que a probabilidade de um evento acontecer não está atrelada eventos anteriores. Pense em um dado com seis faces. Na primeira jogada pode sair qualquer número entre 1 e 6. Na segunda também, na terceira a mesma coisa, e assim sucessivamente. O mesmo conceito se aplica a uma moeda em um jogo de cara e coroa, por exemplo.

### Probabilidade condicional

A probabilidade muda de acordo com eventos passados. Um exemplo é um baralho de cartas completo, em que existe igual probabilidade de tirar qualquer uma delas do bolo. A medida que as cartas vão saindo do baralho, a probabilidade de tirar uma das restantes aumenta.

## A lei dos números grandes

Qual a probabilidade de um dado evento ocorrer? Quanto maior o número de tentativas (ou eventos, ou observações), mais precisa é a estimativa dessa probabilidade. Esse fenômeno é chamado de **lei dos números grandes**. Desconsiderando as limitações com teste com amostras online citadas no {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}post introdutório{{< /anchor >}} desta série, quanto maior a amostra, maior será a probabilidade de o tratamento dado a um grupo de estudo e o comportamento apresentado estarem correlacionados.

Em software, os testes são baseados em ações que os indivíduos de uma amostra são ou não capazes de concluir, e a principal métrica é o percentual dos indivíduos da amostra que concluem a determinada ação. Este percentual é conhecido como **taxa de conversão**. Em termos estatísticos, o número é representado de forma absoluta e chamado de **proporção** (ou probabilidade de sucesso, representado pela letra P). É impossível saber qual a verdadeira taxa de conversão (P) quando o tamanho da população é desconhecido (e esta é a realidade de produtos digitais). Aqui entra a estatística inferencial, quando precisamos estimar a proporção P para a ocorrência de um dado evento em uma hipótese.

Ao longo deste e dos próximos posts usarei os termos taxa de conversão, probabilidade de sucesso e proporção como sinônimos.

## Probabilidades combinadas

Probabilidades ainda podem ser combinadas, contanto que os eventos probabilísticos sejam **mutuamente exclusivos**. O que isso quer dizer é que dois ou mais eventos podem acontecer sem interferência entre si. Um exemplo no mundo online seria “quantos visitantes que acessaram a página de categoria também acessaram a página de produto?” (assumindo que é possível chegar a essa página de produto sem antes passar pela página de categoria). Se os eventos não são mutuamente exclusivos, é necessário subtrair a porção desses eventos que se cruzam antes de combinar as probabilidades para evitar amostras duplicadas.

Em testes com amostras online, o número em estudo é a probabilidade de sucessos de acordo com a hipótese formulada, ou a taxa de conversão. O projetista de testes calcula a taxa de conversão média de cada amostra, para calcular a **taxa de conversão média das amostras**, e também uma **margem de erro**. A soma e a subtração da margem de erro com a taxa de conversão média das amostras forma um intervalo que representa as potenciais taxas de conversão para amostras estudadas, chamado de **intervalo de confiança**. Como cada amostra provavelmente possui algum grau de diferença entre as demais colhidas, um intervalo de possíveis taxas de conversão é estimado para inferir a taxa de conversão média de toda a população.

O intervalo de confiança e a probabilidade de sucesso P serão explorados com mais detalhes em outro post.

## Leitura complementar

Aprenda probabilidades com mais profundidade no site {{< anchor href="http://jukebox.esc13.net/untdeveloper/RM/Stats_Module_2/" target="_blank" >}}Statistics and Risk Management{{< /anchor >}}, de onde os exemplos com dados e cartas usados neste post foram retirados.

Bora estimar probabilidades!
