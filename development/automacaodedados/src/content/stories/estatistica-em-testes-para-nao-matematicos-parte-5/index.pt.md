---
title: 'Estatística para testes - P-valor, alfa, beta e tamanho do efeito'
author: henriquesouza
publishDate: 2017-11-27 09:47:00
lastMod: 2021-10-23 09:47:00
summary: 'As ferramentas para testes mais conhecidas conseguem cuidar dos cálculos envolvidos na execução dos experimentos, porém a pessoa projetista de testes deve ser capaz de fornecer as variáveis matemáticas que compõem estes cálculos. Explicarei quais são estas variáveis e como elas se relacionam para gerar o resultado de um teste.'
description: 'Estatística para análise de dados - P-valor, alfa, beta e tamanho do efeito'
image_description: 'Distribuições normais sobrepostas mostrando o valor crítico, o tamanho do efeito, alfa e beta.'
categories:
- Estatística
featured: true
---

Publicado em 27/11/2017 e atualizado em 23/10/2021.

Este post é o quinto de uma série com 6 em que vou destrinchar os principais conceitos estatísticos para testes online. Os tópicos serão:

- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}A importância de entender estatística para testes com amostras{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-2/" >}}Hipóteses{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}Amostras e probabilidades{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-4/" >}}Histogramas e curvas de densidade{{< /anchor >}};
- **P-valor, alfa, beta e tamanho do efeito** (este post);
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-6/" >}}Configuração de testes com amostras online e de calculadoras{{< /anchor >}}.

Bônus: {{< anchor href="/stories/calculadora-de-significancia-estatistica-para-testes-ab/" >}}Calculadora de significância estatística para testes A/B{{< /anchor >}}.

## A regra empírica na prática

Como visto no post sobre {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-4/" >}}histogramas e curvas de densidade{{< /anchor >}}, a regra empírica, ou regra 68-95-99,7, descreve a distribuição de um conjunto de dados ao longo de uma curva gaussiana – ou distribuição normal. Pela regra, 68% dos dados estão a uma medida de distância, ou desvio padrão, da média, 95% estão a dois desvios padrão da média e 99,7% estão a três desvios padrão da média. O desvio padrão é uma medida de variabilidade que está na mesma escala da média de um conjunto de dados.

{{< image src="images/figure1-empirical-rule-pt.webp" alt="Distribuição normal dividida em desvios padrão." caption="Distribuição normal dividida em desvios padrão. Fonte: Autor." title="Distribuição normal dividida em desvios padrão." lazy="true" >}}

Dizer que 68% dos dados estão a uma medida de distância, ou um desvio padrão, da média significa dizer que 68% dos valores encontrados vão cair dentro de um intervalo específico, determinado pela porção mais ao meio da distribuição normal. Quando um teste está em execução e amostras estão sendo computadas com suas probabilidades de sucesso (as taxas de conversão ou proporções), essas probabilidades possuem 68% de chances de estar a um desvio padrão da média, 95% de chances de estar a dois e 99,7% de estar a três.

## P-valor

Cada variação de um teste terá a sua curva de distribuição, com sua própria média e desvio padrão, e a pessoa projetista de testes precisa ser capaz de comparar estas variações para determinar se há correlação entre o tratamento aplicado e o comportamento observado. As distribuições normais, calculadas individualmente, não podem ser comparadas umas com as outras por estarem em escalas diferentes. É necessário **normalizá-las dentro de um mesmo plano**. Para isto, é importante ter um número que seja capaz de representar todas as probabilidades dentro de cada distribuição normal, e classificar este número dentro da área das distribuições normais combinadas. Este número chama-se **p-valor**.

Uma definição formal para o p-valor é a de que ele é a probabilidade de obter um efeito tão extremo quanto o observado, considerando que a hipótese nula é verdadeira. Como visto no post sobre {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-2/" >}}hipóteses{{< /anchor >}}, não é possível assumir que a hipótese alternativa é verdadeira apenas porque existem evidências que neguem uma hipótese nula. É importante lembrar que existem duas probabilidades para a hipótese nula: a de que ela é falsa e também **a de que ela é verdadeira**. O mesmo vale para a hipótese alternativa. O p-valor é o número usado para responder se o tratamento aplicado em um grupo de estudo é a causa de um comportamento observado, assumindo que a hipótese nula é verdadeira. Se há evidências de que o tratamento e o comportamento observado se correlacionam, o p-valor adotará valores dentro de um intervalo que permita negar a hipótese nula.

Em testes com amostras online, a definição dada ao p-valor pode ser reescrita da seguinte forma: qual é a chance de ver o tráfego de um produto digital se comportar da forma que foi observado no teste se não fosse feita nenhuma mudança no produto? Se a probabilidade é baixa, então é bem provável que o comportamento observado não tenha sido obra do acaso. Nesse caso, tende-se a acreditar na hipótese alternativa (as alterações no produto foram o que apresentou a mudança de comportamento do tráfego estudado).

Um ponto importante sobre usar o p-valor para decidir entre hipóteses nula e alternativa é que não é possível provar a resposta encontrada. Sempre haverá uma margem de erro associada, e em alguns casos a resposta encontrada simplesmente será a errada, como visto no {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-2/" >}}post sobre hipóteses{{< /anchor >}}. O p-valor é usado como medida de certeza entre a causa e o efeito, ou o tratamento dado e o comportamento observado. O máximo que pode ser feito é executar o teste novamente para verificar se o valor encontrado cai dentro do intervalo esperado ou não. O negócio ainda terá que decidir se irá agir conforme o resultado do teste ou não, considerando a margem de erro na resposta.

Quanto deve ser o p-valor para que o resultado de um teste possa tender em prol da hipótese alternativa? Depende. O valor é definido pela pessoa projetista de testes, e chama-se **alfa**.

{{< image src="images/figure2-p-value-compared-to-alpha-pt.webp" alt="P-valor e alfa posicionados em uma distribuição normal." caption="P-valor e alfa posicionados em uma distribuição normal. Fonte: Autor." title="P-valor e alfa posicionados em uma distribuição normal." lazy="true" >}}

## Alfa

Alfa, ou **nível de significância**, é a probabilidade de o resultado ser um falso positivo. O valor de alfa é uma constante que delimita uma área dentro da distribuição normal. Essa área vai de uma das extremidades até o valor definido. Os valores mais comuns adotados em ferramentas de teste e calculadoras são 0,1, 0,05 e 0,01 (ou 10%, 5% e 1% de chances de falso positivo, respectivamente). Essas ferramentas costumam pedir que a pessoa projetista de testes defina o inverso de alfa para os cálculos, ou 1 - alfa. O inverso de alfa é o número conhecido como **significância estatística**, e representa a probabilidade de o valor encontrado estar correto assumindo que a hipótese nula é verdadeira. Outra forma de pensar neste número é como sendo a probabilidade de rejeitar a hipótese nula considerando que ela é verdadeira, ou ainda, a probabilidade de o resultado encontrado não ter sido coincidência.

Na prática, o p-valor precisa ser menor do que o alfa em uma das extremidades da distribuição normal. Quando isso acontece, o resultado encontrado no estudo é dito “estatisticamente significante”.

{{< image src="images/figure3-p-value-greater-than-alpha-pt.webp" alt="P-valor menor do que alfa." caption="P-valor menor do que alfa. Fonte: Autor." title="P-valor menor do que alfa." lazy="true" >}}

## Testes com uma e duas caudas

Embora o valor de alfa seja uma constante, a maneira como ele é distribuído na curva gaussiana pode mudar de acordo com as configurações do teste. Em um estudo online, por exemplo, a pessoa projetista de testes pode ter como objetivo conhecer a diferença entre uma alteração feita em um site contra a configuração já existente. Se o objetivo é apenas verificar se a alteração performa melhor então o teste será de **uma cauda**, e se o objetivo é verificar se a alteração performa melhor ou pior do que o que já existe, o teste é de **duas caudas**. A cauda de uma distribuição é a porção dos dados localizados nas extremidades da distribuição normal.

{{< image src="images/figure4-left-and-right-tails-of-a-normal-distribution-pt.webp" alt="Caudas de uma distribuição normal." caption="Caudas de uma distribuição normal. Fonte: Autor." title="Caudas de uma distribuição normal." lazy="true" >}}

Quando o teste é de uma cauda, o valor de alfa é concentrado na extremidade à direita da distribuição, e o p-valor precisa passar de alfa apenas nesta extremidade. Se o teste é com duas caudas, o valor de alfa é dividido entre as extremidades e o número passa a ser alfa / 2. Se um alfa é 0,05 por exemplo, quando consideradas as duas caudas de uma distribuição, o número será distribuído em 0,025 para cada extremidade, e p-valor precisa ser menor do que alfa / 2 em uma das extremidades.

## O deslocamento de p-valor na distribuição normal

Para saber se o p-valor é menor ou maior do que alfa, é preciso saber o quanto ele se desloca da média em cada uma das variações de um teste, utilizando uma notação padrão que permita comparar as diferenças entre os grupos de estudo. Para isto, é utilizado um número chamado de **z-score**. Os deslocamentos em z-scores ao longo da distribuição normal {{< anchor href="http://www.z-table.com/" target="_blank" >}}estão disponíveis na internet em tabelas para consulta{{< /anchor >}}. Cada deslocamento em z-scores é associado a cobertura de uma porção da distribuição normal, sendo que quanto mais próximo de zero, menor é a área da distribuição coberta, e quanto mais próximo de um, maior é a área. Os deslocamentos são calculados a partir de desvios padrão.

{{< image src="images/figure5-z-score-table.webp" alt="Tabela de valores calculados para o z-score." caption="Tabela de valores calculados para o z-score. Fonte: Z Score Table." title="Tabela de valores calculados para o z-score." lazy="true" >}}

Z-scores podem ser números positivos ou negativos, sendo que z-scores negativos estão abaixo da média e os positivos estão acima dela. A leitura dessas tabelas é feita da seguinte forma: uma vez que um p-valor é calculado, a área associada a ele está na célula que intersecta uma linha e uma coluna. Suponha que um p-valor calculado seja de 1,96. O primeiro passo é procurar pelo número 1,9 na primeira coluna da tabela. Encontrado esse número, o passo seguinte é encontrar o número 0,06, a parte restante do número 1,96. Basta olhar a primeira linha da tabela, com os cabeçalhos que vão de 0,00 a 0,09. A área equivalente do número 1,96 estará então na célula que cruza a linha e coluna correspondentes. Neste caso, o número é 0,9750 (ou 97,50% da distribuição, considerando uma tabela de z-scores que mostra toda a área da distribuição normal). Como a área de uma distribuição é um número que vai de zero a um, é necessário traduzir os números de p-valor e alfa para a escala usada na distribuição, e é isso o que o z-score faz. O z-score é uma medida útil, pois descreve a distância de um número em relação a média, e descreve essa distância de forma normalizada para várias distribuições normais. Este aspecto do z-score é importante, pois é o que permite a comparação entre as distribuições dos grupos de estudos.

Há várias tabelas de z-score online, e elas diferem entre tabelas que mostram as áreas à direita da distribuição normal (acima da média), tabelas que mostram a área à esquerda da distribuição normal (abaixo da média) e tabelas que mostram toda a área, com z-scores negativos e positivos.

## Z-score de alfa: valor crítico

Para obter o z-score de alfa, chamado de **valor crítico**, o caminho é o inverso do feito para obter o z-score do p-valor: buscar o valor da área para encontrar o z-score correspondente. Há mais de uma forma de encontrar o z-score do valor crítico. Para um teste com uma cauda, basta subtrair 1 de alfa, e para um teste com duas caudas, basta subtrair 1 do resultado da divisão entre alfa e 2. O número final é a localização de alfa na distribuição normal, que pode ser consultada na tabela de z-scores para encontrar o z-score equivalente. Considere o alfa de 0,05 e um teste de uma cauda, por exemplo. Subtrair este alfa de 1 resulta no número 0,95 (ou .9500). O z-score mais próximo deste valor calculado é 1,65 (.9505). Quando o teste possui duas caudas, faça a divisão de alfa por 2, que resulta em 0,025, e subtraia este resultado de 1, que resulta em 0,975 (ou .9750). O z-score mais próximo deste valor calculado é 1,96 (.9750). Os z-scores correspondentes as configurações mais comuns de alfa são 1,645 para alfa 0,1, 1,96 para alfa 0,05 e 2,576 para alfa 0,01. Note que neste post foi mostrada apenas a tabela de z-scores positivos. Outros métodos de calculo fazem uso da tabela de z-scores negativos.

O z-score de alfa é chamado de valor crítico porque ele é o número que dividide a distribuição em duas regiões: a região de **falha ao rejeitar a hipótese nula** e a região de **rejeição da hipótese nula**. Enquanto alfa representa a área das extremidades da distribuição normal associada ao falso positivo, o valor crítico é o “divisor de águas” entre a rejeição e a não rejeição da hipótese nula, ou entre estatisticamente significante e não estatisticamente significante.

{{< image src="images/figure6-null-hypothesis-boundaries-pt.webp" alt="Ponto crítico para aceitação ou rejeição da hipótese nula." caption="Ponto crítico para aceitação ou rejeição da hipótese nula. Fonte: Autor." title="Ponto crítico para aceitação ou rejeição da hipótese nula." lazy="true" >}}

Uma vez que a média da amostra, o valor crítico e o desvio padrão são conhecidos, é possível calcular uma métrica já citada no {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}post sobre probabilidades{{< /anchor >}}: o intervalo de confiança. O intervalo de confiança é uma área de possíveis valores onde a taxa de conversão pode cair. O cálculo é feito duas vezes: uma para o intervalo superior e outra para o intervalo inferior. O intervalo superior é obtido somando a média ao produto do valor crítico com o desvio padrão. O intervalo inferior é obtido subtraindo a média do produto do valor crítico com o desvio padrão.

Em suma:

- P-valor: probabilidade de encontrar um comportamento extremo assumindo que a hipótese nula é verdadeira;
- Alfa: probabilidade de falso positivo;
- Z-score: número de desvios padrão em relação a média;
- Valor crítico: ponto de separação entre as áreas de rejeição e não rejeição da hipótese nula.

## Curvas de densidade combinadas

Todo o processo descrito para cálculos em testes gera um p-valor para comparação com alfa, porém esse é o processo para uma variação dentro do teste. Testes possuem no mínimo duas: uma chamada de **controle** e as demais chamadas de **tratamentos** (ou variações). O grupo de controle é o grupo que não recebe nenhum tipo de tratamento, e os grupos de tratamentos possuem algum tipo de modificação em relação ao grupo de controle. Cada grupo de controle e tratamento tem sua coleta e classificação de dados, seu histograma, sua curva de densidade e seu p-valor. É necessário combinar essas curvas e projetar um único p-valor para comparação com alfa, o que é feito com os z-scores. Essa combinação de curvas é apenas uma projeção em que as duas curvas são colocadas no mesmo plano, e os números de p-valor e a medida de desvio são calculadas de forma combinada.

{{< image src="images/figure7-control-and-treatment-distributions-pt.webp" alt="Curvas de distribuição dos grupos de controle e tratamento sobrepostas." caption="Curvas de distribuição dos grupos de controle e tratamento sobrepostas. Fonte: Autor." title="Curvas de distribuição dos grupos de controle e tratamento sobrepostas." lazy="true" >}}

Quando as distribuições são sobrepostas e há mais de uma média no conjunto de dados resultante, o desvio padrão não pode ser usado como medida de dispersão. A métrica de desvio nessa combinação é o **erro padrão**, e ele é derivado do desvio padrão. O erro padrão é uma estimativa da diferença entre os desvios padrão das amostras e da população. Ele é usado, entre outras situações, para determinar a variabilidade entre os dados quando há mais de uma média no conjunto, o que passa a ser o caso quando duas ou mais distribuições normais são combinadas. O erro padrão é usado no lugar do desvio padrão para gerar o intervalo de confiança. A média a ser usada para o cálculo do intervalo de confiança é uma média combinada, calculada a partir da subtração das médias das distribuições normais combinadas.

Com um único p-valor e uma única medida de desvio, o valor obtido representa todo o grupo de controle e tratamentos.

## Significância estatística e tamanho da amostra

Um erro comum na execução de testes, comentado no {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}post introdutório desta série{{< /anchor >}}, é finalizar sua execução logo que a significância estatística é alcançada. O que acontece é que ao longo da execução de um teste a significância estatística pode ser alcançada zero, uma ou diversas vezes. Você pode um dia abrir a ferramenta usada para o teste e receber uma mensagem dizendo que a significância estatística foi alcançada, e no dia seguinte, a ferramenta informar que a significância estatística não foi alcançada para o mesmo teste.

Isso acontece porque as amostras estão sendo coletadas ao longo do teste, e os números apresentam muita variabilidade – especialmente no começo de um teste. Encontrar o tamanho da amostra apropriado é de suma importância para que o teste tenha validade. Quanto maior a amostra, menor o erro padrão e mais estreita se torna a distribuição normal, o que está relacionado com a {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-4/" >}}lei dos números grandes e o teorema do limite central{{< /anchor >}}. A amostra influencia o erro padrão, que por sua vez influencia o chamado **poder estatístico**, ou a probabilidade de rejeitar a hipótese nula corretamente em favor da hipótese alternativa. Algumas calculadoras de teste pedem para que a pessoa projetista de testes informe, entre outras coisas, o poder estatístico para calcular o tamanho da amostra necessária para um teste.

## Poder estatístico e seus quatro componentes: beta, tamanho do efeito, alfa e tamanho da amostra

Em um gráfico de área, o poder estatístico representa a área das distribuições normais combinadas relacionada a hipótese alternativa que não intersecta com a distribuição normal da hipótese nula. Poder estatístico é representado por 1 - beta.

{{< image src="images/figure8-critical-value-and-power-pt.webp" alt="Visualização do tamanho do efeito." caption="Visualização do tamanho do efeito. Fonte: Autor." title="Visualização do tamanho do efeito." lazy="true" >}}

O poder estatístico é formado por quatro componentes:

- Beta: este beta é o mesmo do post sobre {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-2/" >}}hipóteses{{< /anchor >}}, ou a probabilidade de um falso negativo. Quanto menor for o beta, maior o poder estatístico;
- Tamanho do efeito: tamanho do efeito é uma medida de distância entre as médias das distribuições normais sobrepostas. É a diferença entre essas médias dividida pelo desvio padrão;
- Alfa: probabilidade de falso positivo. Quanto menor for alfa, maior é o beta e, consequentemente, menor o poder estatístico;
- Tamanho da amostra: quantidade de participantes do teste. Quanto maior a amostra, menor o beta e maior o poder estatístico.

Ajustar alfa e beta apropriadamente significa dizer o quanto de erro um negócio está disposto a aceitar na resposta de um teste. O tamanho do erro aceito dependerá de cada negócio, mas é comum assumir 0,05 de alfa e 0,2 para beta. O valor de beta não costuma ser definido em nenhuma das ferramentas de teste mais conhecidas, é assumido 0,2 por padrão. No entanto, pode ser que seja necessário trabalhar com outros betas, e nesse caso é útil fazer os cálculos estatísticos para testes usando planilhas ou calculadoras mais avançadas.

## Leitura complementar

- {{< anchor href="https://www.youtube.com/watch?v=zTABmVSAtT0" target="_blank" >}}Este vídeo{{< /anchor >}} explica de maneira bem didática a distinção entre os termos p-valor, alfa, valor crítico e z-score e como eles se relacionam;
- {{< anchor href="https://theebmproject.wordpress.com/power-type-ii-error-and-beta/" target="_blank" >}}Estes vídeos{{< /anchor >}} descrevem em detalhes os conceitos de beta, tamanho do efeito e poder estatístico.

Bora validar hipóteses!
