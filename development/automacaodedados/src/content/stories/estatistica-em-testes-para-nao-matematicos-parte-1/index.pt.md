---
title: 'Estatística para testes - A importância de saber estatística'
author: henriquesouza
publishDate: 2017-11-22 10:35:00
lastMod: 2021-10-20 10:35:00
summary: Você costuma fazer testes do tipo A/B, split ou outros e se pergunta se os dados que a ferramenta de testes fornece são válidos? Se a resposta é não, você deveria.
description: 'Estatística para testes - A importância de saber estatística'
image_description: 'Diversas calculadoras de métricas relevantes para estudos estatísticos inferenciais.'
categories:
- Estatística
featured: true
---

Publicado em 22/11/2017 e atualizado em 20/10/2021.

Este post é o primeiro de uma série com 6 em que vou destrinchar os principais conceitos estatísticos para testes online. Os tópicos serão:

- **A importância de entender estatística para testes com amostras** (este post);
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-2/" >}}Hipóteses{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}Amostras e probabilidades{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-4/" >}}Histogramas e curvas de densidade{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-5/" >}}P-valor, alfa, beta e tamanho do efeito{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-6/" >}}Configuração de testes com amostras online e de calculadoras{{< /anchor >}}.

Bônus: {{< anchor href="/stories/calculadora-de-significancia-estatistica-para-testes-ab/" >}}Calculadora de significância estatística para testes A/B{{< /anchor >}}.

O primeiro post desta série será dedicado a esclarecer a importância da bagagem estatística para estudos com amostras, e quais são os tipos de testes disponíveis para aplicações online.

## As ferramentas que uso já fazem os cálculos estatísticos que preciso, então por quê preciso me preocupar com isso?

A interpretação do resultado de um experimento é tão importante quanto as demais etapas do processo de aprendizado. Uma interpretação errônea ou negligente pode levar a conclusões equivocadas. Um exemplo simples envolve a chamada **significância estatística**. Se você inicia um teste e o pára assim que a ferramenta diz que a significância estatística foi alcançada, você provavelmente terá resultados não condizentes com a realidade. Significância estatística não é motivo para parada de um teste, como explicarei em outro post. Esta é só uma das formas de como testes podem ser incorretamente conduzidos. Uma {{< anchor href="https://www.google.com.br/search?biw=1536&bih=734&ei=I3AVWv66LIOgwgSVx5e4Aw&q=ab+tests+done+wrong&oq=ab+tests+done+wrong&gs_l=psy-ab.3..33i22i29i30k1.5850.7240.0.7331.13.9.0.0.0.0.256.1048.0j5j1.6.0....0...1c.1.64.psy-ab..7.5.792...0j0i22i30k1j0i22i10i30k1j33i160k1j33i21k1.0.Of9q5XbMUnQ" target="_blank" >}}rápida pesquisa na internet{{< /anchor >}} vai resultar em vários outros exemplos de erros comuns em implementações de testes com amostras.

## O quanto é necessário conhecer de matemática para trabalhar com testes com amostras?

O suficiente para entender como testes com amostras são conduzidos e configurados. Não é necessário saber calcular fórmulas complexas no papel, mas saber o que elas são e o que representam suas variáveis é fundamental para fazer a leitura correta de dados de testes com amostras. As ferramentas fazem o cálculo, mas o que elas retornam como resultado ainda deve ser propriamemte interpretado. {{< anchor href="https://www.evanmiller.org/ab-testing/" target="_blank" >}}Algumas calculadoras de tamanho de amostra ou de duração de testes{{< /anchor >}} pedem informações que serão diretamente inseridas nas fórmulas matemáticas que calculam esses números, e as que não pedem tais informações assumem números padrão. O problema com isso é que nem sempre a configuração definida representa a realidade de cada negócio. Um exemplo está na definição do **efeito mínimo detectável**. Dependendo do tipo de negócio que você possui, pode não fazer sentido declarar uma variação em um teste como sendo a vencedora por uma diferença muito pequena. O tamanho da diferença que você quer ver entre as variações em um teste é definida por esta variável, e é comum que calculadoras e ferramentas de teste definam um número padrão. Configurar este parâmetro reflete no tamanho da amostra necessária para executar um teste, o que implica diretamente no tempo necessário para colher os dados.

## Características de testes com amostras online

O trabalho que uma pessoa projetista de testes em software tem para preparar amostras e conduzir grupos de estudo não é muito diferente do trabalho de pesquisas com amostras em outras áreas, como medicina e política. Na medicina, por exemplo, o que muda é que o ambiente de testes é bem mais controlado, o número de amostras é bem menor, e a significância estatística requerida é geralmente maior do que a adotada em testes com amostras online. Pesquisas nessa área podem usar outros métodos de testes com grupos que não o que será descrito nesse post, dependendo do que possuem para trabalhar e dos objetivos do estudo. Já o campo de estudos em política é mais parecido com a realidade de quem trabalha em um departamento de marketing, produto ou dados. Para conhecer as intenções de voto da população, várias amostras de eleitores são selecionadas de forma aleatória para participar de pesquisas de intenção de voto, e, com base nas respostas dessas amostras, são inferidas informações sobre toda a população.

Algumas características específicas de testes com amostras online são:
- O pouco controle que a pessoa projetista de testes tem sobre o ambiente de estudos (o online);
- O grupo de estudos é formado por usuários anônimos, cuja única identificação é um cookie instalado em suas máquinas. Problemas com o cookie são seu prazo de validade a possibilidade de serem manipulados pelos participantes do estudo;
- É difícil traçar características do grupo de estudos. O estudo então é feito sobre os comportamentos do grupo;
- Experiências entre múltiplos dispositivos e navegadores são normalmente problemáticas em testes e causam ruídos na coleta de dados.

O número de variáveis fora de controle é simplesmente incontável. Não é possível garantir que a amostra de um estudo com participantes anônimos não terá ruídos, mas é possível garantir a qualidade dos procedimentos de teste e o rigor estatístico para produzir dados que representem toda a população estudada.

## Tipos de testes com amostras online

Testes com amostras do tipo A/B são tão conhecidos que as vezes parece que este é o único tipo de teste existente. Há outros tipos de teste que podem ser aplicados dependendo da situação e tipo de conteúdo a ser testado. Os tipos de teste são:

- Teste A/B: um tipo de teste em que amostras são separadas em dois grupos. Um dos grupos recebe algum tipo de tratamento diferenciado e os comportamentos dos dois grupos são analisados em busca de correlações entre o tratamento aplicado e o comportamento apresentado. Um exemplo em testes com amostras online é a separação do tráfego entre duas versões de uma página web.
- Teste mvt: o teste mvt, ou multivariável, estuda o comportamento de múltiplos tratamentos simultâneos para diferentes amostras do grupo de estudo, comparados a um grupo de controle que não recebeu tratamentos. Os comportamentos são analisados em busca de correlações entre os tratamentos aplicados e os comportamentos apresentados. Um exemplo em testes com amostras online é a separação do tráfego em três ou mais versões de uma página web com alterações em diferentes elementos.
- Teste A/B/N: similar ao teste mvt. Sua diferença está na forma como o tratamento é aplicado nas diversas variações. Enquanto um teste do tipo mvt estuda diversas variações nos grupos de controle e tratamento, o teste A/B/N estuda diferenças de uma mesma variação. Um exemplo em testes com amostras online é a separação do tráfego em três ou mais versões de uma página web com várias alterações de um mesmo elemento.
- Teste split: o teste split é característico de testes com amostras online, e consiste no redirecionamento do tráfego de sites entre diferentes endereços. Pode ser usado para testar diferentes variações do layout de uma página ou diferentes páginas.
- Teste mab: o teste mab, ou multi armed bandit, é um tipo de teste que incorpora aprendizado de máquina em seu processo. O tráfego é dividido e analisado por modelos preditivos de *clusterização*, que classificam grupos da amostra com base em traços comuns de comportamento.

Em geral o teste A/B é o mais usado, pois dá mais certeza ao pesquisador sobre a correlação entre o tratamento aplicado e o comportamento das amostras. Quando novas variáveis são envolvidas o teste se torna mais complexo, e a possibilidade de erros aumenta.

Nos posts seguintes serão apresentados tópicos importantes da estatística para testes com amostras, a começar por estudo de hipóteses.

Bora aprender estatística!
