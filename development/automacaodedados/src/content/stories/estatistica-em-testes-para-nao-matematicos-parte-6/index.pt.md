---
title: 'Estatística para testes - Configuração das ferramentas'
author: henriquesouza
publishDate: 2017-11-29 09:12:00
lastMod: 2021-10-30 09:12:00
summary: 'Configurar testes com amostras online requer alguns cuidados. Configurações erradas podem invalidar os achados do estudo e levar negócios a tomarem decisões com base em dados inverídicos – o que é potencialmente pior do que não ter dados.'
description: 'Estatística para testes - Configuração das ferramentas'
image_description: 'Diferentes fabricantes de ferramentas para testes com amostras online.'
categories:
- Estatística
featured: true
---

Publicado em 29/11/2017 e atualizado em 30/10/2021.

Atualização 30/10/2021: Quando este post foi escrito, o Google ainda não tinha lançado a versão 4 do Google Analytics, que dispensa o uso de visões e diminui a dependência de cookies para identificar usuários.

Este post é o sexto e último de uma série com 6 em que vou destrinchar os principais conceitos estatísticos para testes online. Os tópicos serão:

- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}A importância de entender estatística para testes com amostras{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-2/" >}}Hipóteses{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-3/" >}}Amostras e probabilidades{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-4/" >}}Histogramas e curvas de densidade{{< /anchor >}};
- {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-5/" >}}P-valor, alfa, beta e tamanho do efeito{{< /anchor >}};
- **Configuração de testes com amostras online e de calculadoras** (este post).

Bônus: {{< anchor href="/stories/calculadora-de-significancia-estatistica-para-testes-ab/" >}}Calculadora de significância estatística para testes A/B{{< /anchor >}}.

## O processo de execução de testes

Esta série apresentou diversos conceitos matemáticos que, juntos, compõem um processo padronizado para estudo de amostras. Este processo, se visto de forma panorâmica, possui as seguintes etapas:

- Descrever as hipóteses nula e alternativa;
- Determinar se o teste é de uma ou de duas caudas;
- Determinar os valores de alfa e beta;
- Colher as amostras;
- Calcular as taxas de conversão (também chamada de proporção ou probabilidade de sucesso) das amostras;
- Classificar cada taxa de conversão dentro de uma frequência;
- Repetir os procedimentos de coleta e cálculo da taxa de conversão para cada variação do teste até que as frequências das taxas de conversão assumam uma distribuição normal;
- Projetar as distribuições normais dos grupos de controle e tratamentos em um mesmo plano;
- Calcular a média combinada e o p-valor combinado de todas as distribuições normais;
- Calcular a posição de p-valor na distribuição normal combinada usando o erro padrão e uma tabela de z-scores;
- Verificar se p-valor é menor do que alfa em uma das extremidades da distribuição normal da hipótese nula;
- Verificar se o tamanho da amostra é grande o suficiente para encerrar o teste quando for atingida a significância estatística.

Ao longo deste post, serão acrescidos alguns detalhes a este processo para, depois, configurar ferramentas e calculadoras de testes com amostras.

## O efeito mínimo detectável

Efeito mínimo detectável, brevemente mencionado no {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}post introdutório da série{{< /anchor >}}, é o tamanho da diferença que o pesquisador quer ver entre duas ou mais variações em um teste. É o {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-5/" >}}tamanho do efeito{{< /anchor >}} mínimo esperado. O efeito mínimo detectável está diretamente relacionado ao tamanho da amostra. Quanto menor o efeito mínimo detectável, maior deverá ser o tamanho da amostra e, consequentemente, o tempo para coleta de dados. A hipótese matemática pode conter um tamanho de efeito mínimo.

Há empresas que definem em suas hipótese um tamanho esperado em aumento de conversões, mas o aumento pode ser menor do que o esperado. O negócio pode então aceitar esse aumento e implementar as mudanças no produto ou evitar o trabalho de fazer mudanças para obter um ganho que pode não compensar o esforço.

## Tamanho apropriado de amostra para um teste

O tamanho da amostra depende de quatro fatores:

- O efeito mínimo detectável;
- Alfa;
- Beta;
- A taxa de conversão atual (ou a taxa de conversão da hipótese nula).

Algumas calculadoras assumem pelo menos o beta como 0,2, sem possibilidade para mudar a taxa de falsos negativos. Ao colocar esses quatro valores em uma calculadora, ela pode mostrar a quantidade de indivíduos em uma amostra que são necessários em cada variação do teste ou o tamanho total da amostra. Vou usar a {{< anchor href="https://www.evanmiller.org/ab-testing/sample-size.html" target="_blank" >}}calculadora do Evan Miller{{< /anchor >}} para ilustrar o efeito de beta e tamanho mínimo detectável no cálculo de tamanho de amostra.

{{< image src="images/figure1-evan-miller-sample-size-calculator.webp" alt="Calculadora de tamanho de amostra configurada com efeito mínimo detectável de 5% e beta 0,2 (ou 80% de poder estatístico)" caption="Calculadora de tamanho de amostra configurada com efeito mínimo detectável de 5% e beta 0,2 (ou 80% de poder estatístico). Fonte: Evan Miller." title="Calculadora de tamanho de amostra configurada com efeito mínimo detectável de 5% e beta 0,2 (ou 80% de poder estatístico)." lazy="true" >}}

Ela diz qual a quantidade de indivíduos cada variação do teste precisa ter. Os parâmetros para configuração são:

- *Baseline conversion rate*: é a taxa de conversão média do produto. Essa taxa é assumida na hipótese nula;
- *Minimum detectable effect*: é o tamanho da diferença que a pessoa projetista de testes quer ver entre as conversões do grupo de controle e grupos de tratamentos. Quanto maior esse número, maior a diferença a ser detectada e menor a amostragem necessária. A leitura dele é feita em conjunto com o *baseline conversion rate*. Considerando os 20% de conversão média atuais e efeito mínimo detectável de 5%, taxas abaixo de 15% e acima de 25% serão corretamente detectadas considerando a margem de erro estabelecida em beta (a calculadora está configurada para encontrar o intervalo em valores absolutos);
- *Statistical power* (1 - beta): é a probabilidade de corretamente rejeitar a hipótese nula quando a alternativa é verdadeira. Beta é a probabilidade de falso negativo e 1 - beta é o poder estatístico;
- *Significance level* (alfa): é a probabilidade de encontrar um falso positivo. Alfa e nível de significância são sinônimos. No exemplo, alfa está configurado para 5% (ou 0,05).

Outras calculadoras podem funcionar de maneira diferente, como esta criada pela {{< anchor href="https://www.optimizely.com/sample-size-calculator/" target="_blank" >}}Optimizely{{< /anchor >}}, mas seguem os mesmos princípios matemáticos.

{{< image src="images/figure2-ab-testing-sample-size-calculator.webp" alt="Calculadora de tamanho de amostra da Optimizely." caption="Calculadora de tamanho de amostra da Optimizely. Fonte: Optimizely." title="Calculadora de tamanho de amostra da Optimizely." lazy="true" >}}

Ela é mais simples se comparada à calculadora anterior e assume um poder estatístico de 100% (ou 1) de acordo com a documentação, o que explica o tamanho de amostra ser maior do que a calculada usando a calculadora do {{< anchor href="https://www.evanmiller.org/ab-testing/sample-size.html" target="_blank" >}}calculadora do Evan Miller{{< /anchor >}} usando os mesmos parâmetros. Quanto maior o poder estatístico (1 - beta), menor é o beta (menor a margem de falsos negativos) e maior a amostra precisa ser.

Calculadoras podem diferir também entre cálculos com uma e duas caudas. Algumas calculadoras assumem que a pessoa projetista de testes queira saber apenas de melhoria da taxa de conversão na hipótese alternativa e não de pioras. Essencialmente o que muda é a distribuição de alfa pelas extremidades da distribuição da hipótese nula. Como p-valor precisa ser ainda menor considerando duas caudas, o tamanho da amostra precisa ser maior. Recomendo sempre a leitura da documentação da calculadora, caso a pessoa projetista de testes for usar uma calculadora online. Outra opção é usar planilhas para calcular tamanho da amostra.

## Duração estimada do teste

Outra métrica comum é a duração estimada para um teste. Para calcular a duração é suficiente dividir o tamanho do grupo de estudo pelo número médio de visitantes diários no produto. A calculadora da VWO, por exemplo, pede as taxas de conversão atual e estimada, o número de variações e o percentual de visitantes que serão incluídos no teste para determinar o tempo de duração do teste.

{{< image src="images/figure3-ab-testing-duration-calculator.webp" alt="Calculadora de duração do teste da VWO." caption="Calculadora de duração do teste da VWO. Fonte: VWO." title="Calculadora de duração do teste da VWO." lazy="true" >}}

Conhecer o tempo de duração do teste pode ser útil para planejar prazos, porém o tamanho da amostra é um número muito mais importante de ser atingido. Além disso, como o número de visitas diárias informado na calculadora é uma média, essa estimativa de duração não pode ser considerada verdade absoluta. Se um teste chega no número de dias estimado e o tamanho da amostra ainda não é suficiente, o teste deve continuar em execução até que isso aconteça, tomando cuidado para que o teste online não passe muito tempo em execução.

## Qualidade das amostras coletadas

No {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}primeiro post da série{{< /anchor >}} foram destacadas as limitações tecnológicas para realizar testes com amostras online. Em suma, projetistas de testes possuem pouco controle sobre as condições as quais os participantes do teste estão expostos, o que influencia na qualidade das amostras obtidas. Se não administradas com o máximo de controle possível, essas condições podem invalidar os achados de um teste. Algumas delas são:

- Interferência entre grupos de estudo de controle e variações;
- Múltiplos experimentos concomitantes;
- Expiração de cookies;
- Sazonalidades e características temporais;
- Múltiplos navegadores e dispositivos.

### Interferência entre grupos de estudo de controle e variações

De alguma forma isso pode estar ligado ao problema de múltiplos navegadores e dispositivos, onde participantes no grupo de controle passam a ver o efeito induzido no grupo de tratamentos e vice e versa. Esse tipo de interferência pode acontecer também no caso de algum visitante recomendar outro para visitar o produto e esse visitante recomendado cair em uma variação diferente no teste. Imagine que você está testando um valor diferente para frete de uma determinada categoria de produtos. Seu grupo de controle vê a página com o valor de frete normal e o grupo de tratamento vê a página com um valor de frete mais baixo. O visitante que viu o frete por um valor menor pode recomendar o produto para amigos, mas nem todas as pessoas que entrarem na página encontrarão o valor de frete mais barato, por terem caído em grupos diferente daquele cujo o frete mais barato foi aplicado. Isso gera ruído na amostra. É importante pensar na repercussão do que será testado para saber se um teste com amostras é a melhor forma de validar a hipótese formulada.

### Múltiplos experimentos concomitantes

Testes podem ser encadeados, o que acrescenta o risco de interferência de um teste em outro. Testes encadeados podem ser feitos de forma **mutuamente exclusiva**, o que significa que os participantes do experimento 1 não serão expostos ao experimento 2 e vice e versa. Outra forma é executar testes de forma **sequencial**, onde um teste termina para que outro comece. Testes mutuamente exclusivos e sequenciais reduzem o possível ruído que múltiplos testes podem causar.

{{< image src="images/figure4-concurrent-tests.webp" alt="Diagrama apresentando os possíveis caminhos percorridos por amostras participantes de múltiplos testes." caption="Diagrama apresentando os possíveis caminhos percorridos por amostras participantes de múltiplos testes. Fonte: Optimizely." title="Diagrama apresentando os possíveis caminhos percorridos por amostras participantes de múltiplos testes." lazy="true" >}}

Múltiplos experimentos podem ser úteis para reduzir o tempo necessário na execução de testes, desde que haja amostra o suficiente.

### Expiração de cookies

Pelo fato de visitantes de sites e apps serem basicamente anônimos, o cookie é a forma pela qual ferramentas os identificam. Se o visitante retornar ao produto após ter sido selecionado para participar do teste, a experiência precisa se manter consistente. Em outras palavras, as ferramentas precisam lembrar que o visitante foi previamente impactado em um estudo. Há alguns problemas com cookies:

- Podem ser alterados, excluídos ou bloqueados pelo participante do teste;
- Estão presentes apenas no navegador que fez o acesso (não são multi plataforma);
- Possuem data de validade.

A data de expiração de cookies varia conforme a ferramenta sendo usada. A documentação do VWO por exemplo, diz que o {{< anchor href="https://vwo.com/knowledge/what-are-the-cookies-stored-by-vwo/" target="_blank" >}}tempo de vida dos cookies que a ferramenta instala é de 100 dias{{< /anchor >}}. Geralmente isso pode ser modificado pela pessoa projetista de testes conforme a necessidade, e não pode ser modificado após o início de um teste.

Dada a instabilidade de cookies para identificar participantes de teste, não é possível afirmar que amostras online estão livres de ruídos, por mais cuidado que a pessoa projetista de testes tenha tido. Quanto maior o tempo do teste, mais ruído vai sendo acrescentado às amostras. Um teste que roda por tempo demais pode ter um percentual razoavelmente grande da amostra com ruídos, a ponto de invalidar os achados do teste. É comum assumir que {{< anchor href="https://conversionxl.com/blog/sample-pollution/" target="_blank" >}}testes que rodam por mais de 30 dias já tenham uma quantidade considerável de ruídos{{< /anchor >}} na amostra.

### Sazonalidade e características temporais

Eventos sazonais são exceções a regra. Considerar sazonalidades para a execução de um teste evita surpresas na forma como a amostra se comporta, e diminui a chance de invalidar estudos. Pensando no comércio, a Black Friday é um exemplo de evento sazonal. Testes em períodos como este devem considerar que as amostras serão formadas por pessoas que buscam preços baixos, o que pode ser um comportamento atípico para outros períodos do ano. Uma forma de controlar esta variável é testar apenas durante a sazonalidade, a assumindo no teste de hipóteses, ou evitar testes até que o evento sazonal passe.

Além da sazonalidade, o grupo de estudo pode se comportar de maneira diferente em determinados períodos, como finais de semana. Dependendo do tipo de negócio e produto, o volume de tráfego cai aos finais de semana. Mesmo durante a semana podem haver diferenças. Pode ser que toda quarta a noite os clientes de um e-commerce recebam um e-mail com ofertas exclusivas e parte deles se interessam por isso. Estes visitantes podem gerar ruído na amostra por não se comportarem de forma padrão. Para lidar com isso, referências online podem recomendar que {{< anchor href="https://www.convertize.com/ab-testing-statistics/" target="_blank" >}}testes rodem por mínimos de uma ou duas semanas inteiras{{< /anchor >}}, mas é importante lembrar que o tamanho de amostra precisa ser atingido.

### Múltiplos navegadores e dispositivos

A maior dificuldade na realização de testes com amostras online é identificar um mesmo indivíduo da amostra entre vários navegadores e dispositivos. Mesmo usando o mesmo navegador, o visitante pode usar o modo de navegação anônima e depois voltar em uma sessão comum, e a mesma pessoa pode ser contabilizada duas vezes. Como cookies não são compartilhados entre navegadores e dispositivos, diferentes navegadores serão contabilizados como diferentes usuários, e o mesmo vale para diferentes dispositivos. Há algumas formas para diminuir o ruído gerado, mas não há formas conhecidas de eliminar completamente o problema. Algumas das soluções são testar com base em {{< anchor href="https://www.goinflow.com/ab-testing-cross-device-world/" target="_blank" >}}regiões geográficas{{< /anchor >}} ou {{< anchor href="https://conversionxl.com/blog/sample-pollution/" target="_blank" >}}usar o Google Analytics Universal com User IDs{{< /anchor >}}, o que requer um sistema de login implementado e uma vista específica no Google Analytics para contabilizar sessões entre múltiplos dispositivos.

Amostras online sempre terão algum ruído, por mais que o ambiente seja controlado.

## Significância estatística e tamanho da amostra

Além de calcular tamanho de amostra e duração do teste, há calculadoras de significância estatística. Significância estatística é conhecida também como o complemento de alfa, ou 1 - alfa. Esse número é muito mais comum de ser usado por calculadoras ou ferramentas de teste, pois é de mais fácil compreensão por quem não tem uma base estatística e precisa executar testes. As calculadoras de significância estatística recebem como entrada o nível de significância estatística desejado, o número de visitantes e o número de eventos de conversão observados em cada variação. A calculadora do {{< anchor href="https://abtestguide.com/calc/" target="_blank" >}}AB Test Guide{{< /anchor >}} aceita como entrada também a opção de escolha entre testes com uma e duas caudas.

{{< image src="images/figure5-statistical-significance-calculator.webp" alt="Calculadora de significância estatística da AB Test Guide." caption="Calculadora de significância estatística da AB Test Guide. Fonte: AB Test Guide." title="Calculadora de significância estatística da AB Test Guide." lazy="true" >}}

Neste exemplo, o teste é com duas caudas e, por isso, é possível determinar pioras na performance de um tratamento contra o grupo de controle.

## Diferenças entre números reportados no painel de uma ferramenta de testes e em uma ferramenta de analytics

É normal que os números de acessos e conversões reportados no painel de ferramentas de teste sejam diferente daqueles visualizados em um software de analytics. Há diversos motivos pra isso, mas alguns deles são:

- A diferença na forma como um software de analytics e um de testes registram visitantes únicos, sessões e eventos de conversão;
- Erros na implementação da ferramenta de testes;
- Diferença de tempo no carregamento dos scripts.

Uma forma de diminuir as diferenças entre as visualizações é usar a ferramenta de analytics como painel de relatórios e enviar dados de testes para dentro dela.

## O viés comercial de ferramentas para testes online

A proposta de valor oferecida pela maioria das ferramentas mais conhecidas é que o projetista de testes se livra de ter que saber estatística para trabalhar com testes. Para atingir esse objetivo, fabricantes assumem valores padrão para algumas variáveis como o beta (e consequentemente seu complemento, o poder estatístico) ou se o teste é com uma ou duas caudas. Pode até ser possível que uma pessoa projetista de testes não precise saber absolutamente nada sobre estatística para executar testes e consiga usar tais ferramentas. O problema nesse caso passa a ser a falta de recursos para questionar os números obtidos e sua validade em relação a realidade do negócio. Como visto no {{< anchor href="/stories/estatistica-em-testes-para-nao-matematicos-parte-1/" >}}post introdutório da série{{< /anchor >}}, conhecer certos conceitos dentro do campo da estatística pode enriquecer a análise de um teste.

## Leitura complementar

- Como realizar a {{< anchor href="https://conversionxl.com/blog/can-you-run-multiple-ab-tests-at-the-same-time/" target="_blank" >}}execução de múltiplos testes simultaneamente{{< /anchor >}}.

Bora otimizar conversões!
