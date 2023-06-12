---
title: 'Estatística para testes - Hipóteses'
author: henriquesouza
publishDate: 2017-11-23 11:07:00
lastMod: 2021-10-21 11:07:00
summary: 'Existem vários tipos de testes baseados em amostragens, e neste post será apresentado o mais comum quando se fala em testes com amostras online, como o A/B: testes baseados em hipóteses.'
description: 'Estatística para testes - Hipóteses'
image_description: 'Diferentes tipos de hipóteses exibidas sobre curvas de densidade.'
categories:
- Estatística
featured: true
---

Publicado em 23/11/2017 e atualizado em 21/10/2021.

Este post é o segundo de uma série com 6 em que vou destrinchar os principais conceitos estatísticos para testes online. Os tópicos serão:

- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}A importância de entender estatística para testes com amostras{{< /anchor >}};
- **Hipóteses** (este post);
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}Amostras e probabilidades{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-4/" >}}Histogramas e curvas de densidade{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-5/" >}}P-valor, alfa, beta e tamanho do efeito{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-6/" >}}Configuração de testes com amostras online e de calculadoras{{< /anchor >}}.

Bônus: {{< anchor href="/stories/calculadora-de-significancia-estatistica-para-testes-ab/" >}}Calculadora de significância estatística para testes A/B{{< /anchor >}}.

## O início de um experimento: hipóteses

Existem diversos tipos de testes com amostras. Os mais comuns no mundo online e adotados pelas ferramentas de testes mais conhecidas são os **testes de hipóteses**. Uma hipótese é uma afirmação que representa uma crença estabelecida. O objetivo de um teste é pôr esta hipótese à prova para validá-la ou invalidá-la. Há duas hipóteses em testes desta natureza: a **hipótese nula** e a **hipótese alternativa** (também chamada de hipótese alfa). A hipótese nula representa a premissa de que o tratamento dado para um grupo de estudo não se correlaciona com alterações comportamentais observadas, enquanto a hipótese alternativa é a crença de que o tratamento dado para um grupo de estudo possui correlação com o comportamento apresentado após o tratamento. Um exemplo de hipótese alternativa: trocar a cor de um botão na página inicial de um site aumentará o tráfego na página de produto em 10%. A hipótese nula é, então, a premissa de que a troca da cor do botão não vai aumentar o tráfego na página de produto em 10%. A definição das hipóteses é importante para configurar e analisar o resultado de um teste.

Quando o resultado de um teste é confrontado com a hipótese nula, ela pode ser **rejeitada** ou **aceita**, em termos estatísticos. Aceitar a hipótese nula significa que a alteração induzida no grupo de tratamento não teve o efeito esperado; rejeitar a hipótese nula significa admitir que a probabilidade de o comportamento observado no grupo de tratamento ter sido obra do acaso, e não do tratamento, é baixa. A nomenclatura pode parecer estranha, mas na prática ela significa que não é só porque o pesquisador induziu uma alteração para parte do grupo de estudo que essa alteração foi a causa de uma mudança de comportamento, caso ela exista. Voltando ao exemplo do botão na página inicial de um site; assumindo que o botão foi alterado e que o tráfego na página de produto cresceu 10%, como garantir que foi essa a alteração que causou um aumento de 10% no tráfego desta página? Rejeitar a hipótese nula não significa aceitar de imediato a hipótese alternativa. A probabilidade de que a mudança de comportamento observada foi induzida pelo projetista de testes é calculada, e será definida em outro post.

## Erros em testes

Existe ainda a possibilidade do resultado de um teste estar errado, mesmo que os procedimentos tenham sido feitos corretamente. Isso acontece porque o estudo é feito com amostras e não com toda a população, e existe a chance de a amostra não representar todas as características da população estudada. Essa possibilidade abre margem para **erros amostrais**, conhecidos em termos estatísticos como **erro do tipo I** (também chamado de alfa ou falso positivo) e **erro do tipo II** (também chamado de beta ou falso negativo).

- O erro do tipo I acontece quando a hipótese nula é rejeitada quando ela deveria ter sido aceita. Em outras palavras, **afirmar que algo é verdadeiro quando não é**.
- O erro do tipo II acontece quando a hipótese nula é aceita quando ela deveria ter sido negada. Em outras palavras, **afirmar que algo é falso quando não é**.

O erro do tipo I está diretamente associado a um conceito a ser explicado em detalhes em outro post, chamado **alfa**. Talvez você já tenha ouvido falar no complemento desse número, chamado de **significância estatística**. Por hora, a significância estatística é o parâmetro definido nas ferramentas de teste que dá um nível de confiança no resultado obtido para o estudo. Geralmente são assumidos os valores de 90%, 95% ou 99%. O que 95% de significância estatística, por exemplo, quer dizer na prática é que a cada 20 repetições de um teste, em uma delas o resultado será um falso positivo, ou erro do tipo I.

Já o erro do tipo II está associado ao conceito de **beta**. Novamente, o complemento dele é mais conhecido e os detalhes deste número também serão discutidos em outro post. Em uma calculadora de testes, por exemplo, pede-se o complemento de beta para calcular a probabilidade de encontrar o efeito esperado em um teste, e geralmente assume-se 80%. Na prática, a cada dez vezes que o teste foi executado, o resultado em duas das execuções será um falso negativo, ou erro do tipo II.

Uma forma comum de explicar a relação entre hipóteses nula e alternativa, bem como os possíveis erros no resultado de testes, é fazer um paralelo com o sistema jurídico penal. Imagine que um juiz precisa decidir se um réu é inocente ou culpado. Pela lei, presume-se que um cidadão é inocente (hipótese nula) até que se prove o contrário (hipótese alternativa). Dispostos em uma tabela, os possíveis desfechos do julgamento são:

{{< image src="images/figure1-different-types-of-errors.webp" alt="Tabela com os possíveis desfechos e realidades de um julgamento, apresentando os erros dos tipos I e II." caption="Tabela com os possíveis desfechos e realidades de um julgamento, apresentando os erros dos tipos I e II. Fonte: Autor." title="Tabela com os possíveis desfechos e realidades de um julgamento, apresentando os erros dos tipos I e II." lazy="true" >}}

Se foram encontradas evidências contra o réu, a hipótese nula (sua inocência) será negada. Se estas mesmas evidências apontam que o réu cometeu o crime pelo qual está sendo julgado, a hipótese alternativa (sua culpa) será aceita. Agora, se as evidências não são fortes o suficiente, o juiz poderá proferir o veredito errado culpando um inocente (falso positivo ou tipo I) ou inocentando um culpado (falso negativo ou tipo II).

Voltando a realidade corporativa, a margem de erro aceitável deve ser definida pela organização com base no preço a ser pago por um erro. No caso de testes com amostras online, é comum pensar que erros do tipo I, ou falsos positivos, são muito mais severos do que erros do tipo II, pois na prática significa tomar decisões com base em informações inverídicas. O erro do tipo II não é tão severo se pensarmos que na prática isso significa que o negócio perdeu uma oportunidade. Neste caso a operação continua como estava. Pense que em uma área como a medicina, estas margens precisam ser o mais próximas de zero o possível, afinal os estudos lidam diretamente com vidas. Por outro lado, buscar essas margens pequenas requer mais amostras e mais tempo de execução. Para uma empresa, isso significa mais tempo e custos maiores com o experimento.

Acompanhe os próximos posts para saber como testar suas hipóteses. O próximo tópico é **probabilidades**.

Bora criar hipóteses!
