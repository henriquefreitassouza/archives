---
title: 'Como escolher o melhor gráfico?'
author: henriquesouza
publishDate: 2020-12-06 09:39:00
lastMod: 2021-11-20 09:39:00
summary: 'Gráficos tornam dados acessíveis para diferentes audiências, e podem contar as mais variadas histórias, mas como escolher o melhor gráfico para contar uma história?'
description: 'Como escolher o melhor gráfico?'
image_description: 'Diferentes tipos de gŕaficos lado a lado'
categories:
- Visualização
featured: true
---

Publicado em 06/12/2020 e atualizado em 20/11/2021.

## Conheça seus dados

Em poucas palavras, o melhor gráfico é aquele que conta a história que precisa ser contada. Para contar esta história, no entanto, precisamos conhecê-la. No contexto de dados, quais são as informações que precisam ser mostradas e como estão organizadas? A tabulação apropriada é importante para garantir a correta apresentação do gráfico. Veja a tabela a seguir:

{{< image src="images/figure1-untidy-table.webp" alt="Tabela com informações de estudantes." caption="Tabela com informações de estudantes. Fonte: Autor." title="Tabela com informações de estudantes." lazy="true" >}}

Esta tabela pode ser facilmente transformada em um gráfico que apresenta as notas por indivíduo ou por idade. Veja agora esta tabela:

{{< image src="images/figure2-tidy-table.webp" alt="Tabela com as mesmas informações de estudantes, porém há uma informação em cada coluna." caption="Tabela com as mesmas informações de estudantes, porém há uma informação em cada coluna. Fonte: Autor." title="Tabela com as mesmas informações de estudantes, porém há uma informação em cada coluna." lazy="true" >}}

A informação é a mesma da tabela anterior, notas por questão. O segundo formato, no entanto, é mais difícil de ser visualizado em um software de planilhas. Esta segunda tabela possui um arranjo chamado ***tidy***, que segue três regras:

- Cada coluna contém apenas uma variável;
- Cada linha contém uma observação;
- Cada célula contém apenas um valor.

O arranjo *tidy* é importante para a realização de análises exploratórias e para alimentar algoritmos de aprendizado de máquina. A visualização de dados neste formato é facilitada por ferramentas de manipulação de dados, como o Pandas, que será utilizado para apresentar os gráficos deste post. A primeira tabela apresentada, com um arranjo largo, ou ***untidy***, é melhor compreendida por pessoas e facilmente transformada em gráficos.

## Critérios para a escolha do melhor gráfico

Com os dados conhecidos e tabulados, é hora de montar o gráfico. A escolha do melhor gráfico {{< anchor href="https://towardsdatascience.com/data-visualization-101-how-to-choose-a-chart-type-9b8830e558d6" target="_blank" >}}terá outras influências{{< /anchor >}} além da mensagem a ser comunicada:

- Familiaridade do público com gráficos;
- Quantidade de classificações dos dados;
- Tipo de dado (discreto ou contínuo);
- Relacionamento entre os dados.

### Familiaridade do público com gráficos

Saber de antemão o quanto o público sabe interpretar gráficos pode ajudar na escolha daquele que melhor vai passar a mensagem. Tamanho da audiência também deve ser levado em consideração, visto que gráficos com muitos elementos podem não ficar bem apresentados em telas grandes como projetores.

### Quantidade de classificações dos dados

A quantidade de classificações é outro fator de importância, pois muitas divisões podem inviabilizar certas visualizações, como um gráfico de pizza.

### Tipo de dado (discreto ou contínuo)

Um determinado dado pode assumir valores **discretos** ou **contínuos**. Um dado discreto é um que pode assumir um valor dentre um conjunto finito de opções. Na tabela com arranjo *tidy* apresentada anteriormente, a coluna questão carrega dados desta natureza. As colunas idade e nota carregam dados contínuos, pois podem assumir qualquer valor. Note que, em algumas tabelas, variáveis numéricas podem ser discretas. Tendo como exemplo a coluna questão, os dados poderiam ter sido apresentados apenas por um número e não com a letra Q antes do número. Os dados então seriam numéricos, mas discretos.

### Relacionamento entre os dados

Se existe uma relação de continuidade entre os dados, alguns gráficos são melhores para mostrar esta relação, como o de linha. Dados que podem ser descritos por uma característica em comum, como o tempo, possivelmente são relacionados. Exemplo desta relação é o valor das ações de uma empresa a cada dia. Exemplo de dados que não possuem relacionamentos são as questões das tabelas apresentadas neste post. As questões podem ser representadas comparativamente em um gráfico, mas uma questão não possui relação com a outra.

## Tipos de gráficos

Ao considerar os fatores para escolha do melhor gráfico, o número de opções deve cair, mas ainda assim é possível que existam diversos bons candidatos para a visualização. É importante conhecer as características de cada tipo de gráfico para basear a escolha.

### Gráfico de barras

{{< image src="images/figure3-bar-chart.webp" alt="Gráfico de barras." caption="Gráfico de barras. Fonte: Autor." title="Gráfico de barras." lazy="true" >}}

Este tipo de gráfico é útil para fazer agrupamentos em torno de uma métrica comum, como uma contagem, uma soma ou uma média. Esta característica o torna útil para fazer **comparações**.

- Quantidade de classificações dos dados: poucas. Embora não haja um número exato para o limite de categorias, eu tenho como referência a configuração padrão do Google Data Studio para exibição de barras no gráfico, que é **10**;
- Tipo de dado (discreto ou contínuo): discreto;
- Relacionamento entre os dados: não relacionados.

### Gráfico de linhas

{{< image src="images/figure4-line-chart.webp" alt="Gráfico de linhas." caption="Gráfico de linhas. Fonte: Autor." title="Gráfico de linhas." lazy="true" >}}

O gráfico de linhas é útil para identificar **tendências**, e é uma boa escolha quando é importante entender a oscilação entre um ponto no gráfico e os demais.

- Quantidade de classificações dos dados: poucas;
- Tipo de dado (discreto ou contínuo): contínuo;
- Relacionamento entre os dados: relacionados.

### Gráfico de pizza

{{< image src="images/figure5-pizza-chart.webp" alt="Gráfico de pizza." caption="Gráfico de pizza. Fonte: Autor." title="Gráfico de pizza." lazy="true" >}}

O gráfico de pizza possui uma utilidade particular: **observar as partes de um todo**. Este gráfico é útil para entender o que compõe um conjunto de dados com poucas classificações.

- Quantidade de classificações dos dados: muito poucas. Não há um número certo a ser considerado como limite para um gráfico desta natureza, mas procuro manter em **2** partes;
- Tipo de dado (discreto ou contínuo): discreto;
- Relacionamento entre os dados: não relacionados.

### Histograma

{{< image src="images/figure6-histogram-chart.webp" alt="Histograma." caption="Histograma. Fonte: Autor." title="Histograma." lazy="true" >}}

O histograma é similar ao gráfico de barras, mas sua função é categorizar variáveis contínuas. Ele serve para **visualizar a distribuição dos dados**. Este gráfico é útil para entender como um conjunto de dados está espalhado, ou distribuído. A categorização é feita em intervalos, ou *bins*, e sua quantidade é determinada ao construir o gráfico. Cuidado ao usar este gráfico: a escolha tendenciosa da quantidade de intervalos, ou o *binning bias*. Quantidades muito pequenas ou muito grandes de intervalos não capturam a distribuição de forma representativa, e informações valiosas podem se perder. É uma boa ideia criar este gráfico algumas vezes, com diferentes quantidades de intervalos, para saber a quantidade ideal de intervalos que representam os dados.

- Quantidade de classificações dos dados: uma;
- Tipo de dado (discreto ou contínuo): contínuo;
- Relacionamento entre os dados: não relacionados.

### Gráfico de dispersão

{{< image src="images/figure7-scatter-plot-chart.webp" alt="Gráfico de dispersão." caption="Gráfico de dispersão. Fonte: Autor." title="Gráfico de dispersão." lazy="true" >}}

Este gráfico serve para **visualizar o relacionamento entre dois conjuntos de dados contínuos**. Ele é útil para entender de forma visual como duas variáveis se movimentam juntas. O gráfico de dispersão aceita uma terceira dimensão ao utilizar recursos como cores, formas, opacidade ou tamanho dos elementos para distinguir categorias dentro de cada ponto. Utilizando as tabelas dos exemplos apresentados no começo deste post, podemos construir um gráfico de dispersão das pessoas que responderam a questão 1 e a questão 2, dispostas nos eixos X e Y (primeira e segunda dimensão). Ao dividir os respondentes por sexo e atribuir uma cor a cada sexo, por exemplo, os pontos serão colocados na tela de acordo com cada sexo, e esta é a terceira dimensão (cor).

- Quantidade de classificações dos dados: uma;
- Tipo de dado (discreto ou contínuo): contínuo;
- Relacionamento entre os dados: não relacionados.

### Gráfico de caixa

{{< image src="images/figure8-box-plot-chart.webp" alt="Gráfico de caixa." caption="Gráfico de caixa. Fonte: Autor." title="Gráfico de caixa." lazy="true" >}}

Assim como o histograma, este gráfico também **exibe a distribuição de um conjunto de dados**, porém ele traz mais informações sobre a distribuição e permite categorizar o conjunto de dados. Se em um histograma eu consigo exibir a distribuição de idades das pessoas que responderam cada questão das tabelas do início deste post, por exemplo, em um gráfico de caixa eu consigo representar esta mesma distribuição separada por sexo.

A área da caixa representa o maior volume dos dados, o local onde estão concentrados a maioria dos dados. A linha dentro da caixa é a mediana da distribuição. As linhas, ou bigodes, que estendem a caixa são conjuntos de dados que estão mais longe da mediana. O intervalo entre a ponta de cada linha e as bordas da caixa e o intervalo entre as bordas da caixa e a mediana se chamam quartis, e cada quartil possui um tamanho fixo. O primeiro quartil (Q1), que vai da ponta da linha esquerda (onde estão os menores números na distribuição) até o início da borda esquerda da caixa, concentra 25% dos dados. O intervalo entre as bordas da caixa é o segundo quartil (Q2), que concentra 50% dos dados. A mediana separa as metades da caixa, de forma que cada metade em seu interior representa 25% do conjunto de dados. Por fim, o intervalo entre a borda direita da caixa e a ponta da linha direita, onde estão os maiores números na distribuição, ou o terceiro quartil (Q3), concentram os 25% finais dos dados. A área da caixa entre o primeiro e o terceiro quartil é chamada de intervalo interquartil (IQR).

Este gráfico pode ainda apresentar valores extremos, que são valores muito altos ou muito baixos em relação ao conjunto de dados. Estes dados são chamados de *outliers* e aparecem como pontos além das linhas. A definição de quais pontos vão para além da linha esquerda segue a fórmula Q1 - 1,5 * IQR e para a linha direita segue a fórmula Q3 + 1,5 * IQR. Quaisquer pontos que sejam menores ou maiores que o número calculado nas fórmulas apresentadas ficarão nas extremidades do gráfico.

- Quantidade de classificações dos dados: poucas;
- Tipo de dado (discreto ou contínuo): contínuo;
- Relacionamento entre os dados: não relacionados.

### Gráfico de área

{{< image src="images/figure9-area-chart.webp" alt="Gráfico de área." caption="Gráfico de área. Fonte: Autor." title="Gráfico de área." lazy="true" >}}

Este gráfico **mostra a distribuição de um conjunto de dados**, assim como o histograma e o gráfico de caixa. Enquanto o histograma é útil para categorizar conjuntos contínuos de dados, o gráfico de área é útil para visualizar a oscilação na distribuição dos dados sem o problema de tendência de intervalos. Este gráfico é usado para apresentar visualmente a magnitude das mudanças no conjunto de dados, representado pela área abaixo de sua curva.

- Quantidade de classificações dos dados: poucas;
- Tipo de dado (discreto ou contínuo): contínuo;
- Relacionamento entre os dados: não relacionados.

### Mapa de calor

{{< image src="images/figure10-heatmap-chart.webp" alt="Mapa de calor." caption="Mapa de calor. Fonte: Autor." title="Mapa de calor." lazy="true" >}}

Este gráfico é uma junção de dois histogramas: um no eixo X e outro no Y do gráfico, formando uma tabela com células de igual tamanho. A função deste gráfico é **mostrar a correlação entre diversas variáveis** utilizando um sistema de cores. Este gráfico é útil para visualizar, em uma única imagem, diversas correlações, sem a necessidade de criar gráficos de dispersão individuais para cada par de variáveis. Este gráfico não mostra o comportamento de uma variável em função de outra, no entanto, ele apenas mostra a força de uma correlação utilizando uma métrica de correlação escolhida.

- Quantidade de classificações dos dados: muitas;
- Tipo de dado (discreto ou contínuo): contínuo;
- Relacionamento entre os dados: não relacionados.

## Composição dos gráficos

Em 2014, a pesquisadora Tamara Munzner publicou um livro chamado Visualization Analysis and Design, que diz que certos elementos visuais são melhores do que outros para transmitir mensagens. A pesquisadora foi capaz de classificar estes elementos em uma ordem baseado na efetividade de cada elemento em transmitir informações. Os elementos com melhor efetividade para transmitir informações **ordenadas** são:

1. Posição;
2. Largura;
3. Ângulo;
4. Área;
5. Profundidade;
6. Iluminação;
7. Saturação;
8. Curvatura;
9. Volume.

E para transmitir informações **categóricas**:

1. Posição espacial;
2. Cor;
3. Movimento;
4. Forma.

{{< image src="images/figure11-cleveland-and-mcgill-element-perception.webp" alt="Classificação de formas e cores em uma escala de efetividade para transmitir informações." caption="Classificação de formas e cores em uma escala de efetividade para transmitir informações. Fonte: Universidade de Iowa." title="Classificação de formas e cores em uma escala de efetividade para transmitir informações." lazy="true" >}}

Considere também utilizar estes elementos de efetividade como critério para escolha do gráfico a ser utilizado.

## Escolhendo o melhor gráfico

Estes são só alguns dos tipos de gráficos, mas há muitos outros como o gráfico cachoeira ou gráficos polares. Os gráficos apresentados neste post devem atender as necessidades do dia a dia operacional de uma empresa. A escolha entre um e outro irá depender das características dos dados e da audiência que vai receber a mensagem, e pode acontecer de um gráfico apenas não ser o suficiente para contar toda a história.

Para ver como criei os gráficos apresentados neste post, acesse {{< anchor href="https://github.com/henriquefreitassouza/data/blob/main/fundamentals_eda/Tipos%20de%20Gr%C3%A1ficos.ipynb" target="_blank" >}}este notebook{{< /anchor >}}, feito no Jupyter Lab e hospedado no {{< anchor href="https://github.com/henriquefreitassouza" target="_blank" >}}meu Github{{< /anchor >}}.

Bora visualizar dados!
