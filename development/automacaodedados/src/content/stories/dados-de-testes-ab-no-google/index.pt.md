---
title: 'Lidando com diferenças nas ferramentas de testes e de analytics'
author: henriquesouza
publishDate: 2017-11-30 08:39:00
lastMod: 2021-10-31 08:39:00
summary: 'O número de visitantes ou sessões que ferramentas de testes online mostram é diferente do número reportado em ferramentas de analytics, mesmo que o teste esteja rodando com 100% do tráfego. As vezes a diferença é tal que levanta dúvidas sobre qual o conjunto de números de acessos e conversões que devem ser considerados. Como então fazer com que essa discrepância seja a menor possível?'
description: 'Lidando com diferenças nas ferramentas de testes e de analytics'
image_description: 'Dashboard no Google Analytics mostrando dados de testes A/B.'
categories:
- Analytics
featured: true
---

Publicado em 30/11/2017 e atualizado em 31/10/2021.

Atualização 31/10/2021: Na data de publicação deste post, a versão 4 do Google Analytics ainda não havia sido publicada. O Google Analytics 4 foi refeito em resposta as legislações de privacidade em diversos países ao redor do mundo. A interface e recursos sofreram diversas modificações, sendo algumas das mais notáveis a menor dependência de cookies para identificar usuários e a remoção de visões. O rastreio de eventos, utilizado ao longo deste post, difere entre as versões 3 e 4. A versão 4 não utiliza mais os atributos *Category*, *Action*, *Label* e *Value* nos eventos. Os exemplos deste post utilizam o Google Analytics versão 3.

Tanto ferramentas para testes quanto para analytics farão a coleta e o armazenamento de dados que representam usuários. Ambas gravam sessões e eventos de conversão ao longo do tempo, e exibem estas informações em painéis. Ao comparar os dados das duas ferramentas considerando a mesma janela de tempo, no entanto, os números não batem. Por que isso acontece?

## Diferenças de implementação e configuração

Ferramentas de testes e ferramentas de analytics {{< anchor href="https://support.abtasty.com/hc/en-us/articles/201747527-There-are-differences-in-data-between-AB-Tasty-and-my-analytics-tool" target="_blank" >}}são bem diferentes uma da outra{{< /anchor >}}. Mesmo que as informações sejam as mesmas, os procedimentos para coleta, tratamento e armazenamento diferem entre estas ferramentas. Mesmo com a garantia de que a implementação das ferramentas foi feita corretamente e que não há erros na coleta dos dados, os números vão continuar diferentes. A dúvida então passa a ser: qual das ferramentas devo considerar ao elaborar um relatório?

Optar por visualizar os números apenas dentro do painel de testes é uma boa opção quando esses números não estão amarrados a outras métricas da empresa. Em outras palavras, quando a métrica que está sendo medida possui baixo nível de correlação com outras. Um exemplo de uma métrica que pode ter alta correlação com outras é o CTR em um elemento de página que passa os visitantes entre etapas de funil. Nesse caso a dificuldade é usar os números reportados no painel da ferramenta de testes para calcular a taxa de visitantes únicos ou a de sessões que passa por cada etapa do funil.

Falando de ferramentas de analytics, elas computam diversas métricas ligadas a comportamentos do tráfego dentro do produto. A primeira diferença em relação a ferramentas de teste se dá na duração dos cookies: a versão 3 do Google Analytics, por exemplo, instala cookies com duração de 30 minutos após inatividade, o que significa que visitantes inativos por mais de 30 minutos terão os cookies deletados de seus navegadores. Ferramentas de teste usam cookies com durações bem maiores, e cada fabricante dá um tempo de duração padrão. A definição padrão de cookies pode ou não ser suficiente, dependerá do tipo de produto. Imagine que uma plataforma de vídeos pode não querer que a duração padrão de cookies seja 30 minutos de inatividade, pois pode ocorrer de seus visitantes assistirem a vídeos com duração superior a essa. Como pode não haver interação com a página durante a execução do vídeo, o tempo decorrido durante a execução do vídeo é tido como sendo de inatividade. A diferença no tempo de validade dos cookies pode fazer com que os mesmos visitantes sejam contados mais de uma vez em uma ferramenta e não na outra.

O tempo e o local de carregamento dos scripts das ferramentas de analytics e de testes também pode causar diferenças. Scripts referenciados no rodapé de uma página precisam esperar a página toda ser servida para então serem carregados, caso não estejam sendo pré carregados. Se a página contém muitos elementos multimídia e/ou dinâmicos, o carregamento pode demorar. Outra situação perigosa está na forma assíncrona de carregamento dos scripts. Scripts, folhas de estilo, imagens e outros elementos que compõem uma página podem ser carregados de forma **síncrona** ou **assíncrona**. Carregamento síncrono significa que, quando o navegador estiver fazendo a leitura da página a ser exibida e ela faz referência a documentos externos, como um script, o restante do carregamento da página será interrompido para que o arquivo externo possa ser incluído com o restante da página. O carregamento assíncrono faz com que os carregamentos dos arquivos externos e da página aconteçam simultaneamente. O que acontece no carregamento assíncrono, em particular, é que a página pode ter carregado e o documento externo ainda estar carregando. Se o visitante deixa a página ou o produto antes que a ferramenta possa carregar, ele não é contabilizado. O teste neste caso não terá sequer iniciado. Em outros casos o teste pode iniciar depois que o visitante estiver interagindo com a página e neste caso a experiência de navegação será alterada se ele cair nas variações de tratamento, pois as alterações do teste serão aplicadas na frente dele (efeito conhecido como *Flash of Original Content*, ou FOOC).

## E o Google Optimize?

O {{< anchor href="https://www.google.com/analytics/optimize/" target="_blank" >}}Google Optimize{{< /anchor >}} é uma ferramenta para testes A/B, A/B/N, mvt e split criada pela Google. Por ser parte da suíte de produtos Google, possui integração nativa com o Google Analytics. Para criar testes com ela, é necessário fornecer o ID de uma visão do Google Analytics, na versão 3, para que o Optimize alimente o relatório apropriado, que fica em Behavior > Experiments. Uma vez que o Optimize tenha permissão de acesso a visão, os dados de testes estarão disponíveis na ferramenta. Mesmo o Optimize apresenta diferenças entre o Analytics e seu painel interno de relatórios. As diferenças são tanto entre o relatório de experimentos no Google Analytics e no painel da ferramenta quanto o relatório de experimentos no Google Analytics e os demais relatórios do próprio analytics. {{< anchor href="https://support.google.com/360suite/optimize/answer/6323229?hl=en" target="_blank" >}}A documentação{{< /anchor >}} diz que isso acontece por diferenças na forma como os cálculos acontecem entre as ferramentas, e também por diferença no tempo de alimentação dos relatórios. Enquanto o Google Analytics recebe os dados do teste com frequência, o Optimize recebe cargas de dados do Analytics a cada 12 horas. A recomendação do Google é sempre olhar para os dados do painel do Optimize para tomar decisões.

## O painel de eventos

Várias ferramentas de testes possuem conectores com o Google Analytics que facilitam o envio de informações para a ferramenta, mas possuem limitações similares as do Google Optimize. Uma forma que encontrei para ajudar na conciliação dos números foi usar o recurso de eventos. Ferramentas de analytics conseguem registrar eventos personalizados. Esses eventos podem ser configurados por pessoas desenvolvedoras direto na aplicação ou por uma equipe de marketing, caso uma ferramenta de gestão de tags esteja instalada. Um exemplo de tal ferramenta é o {{< anchor href="https://www.google.com/analytics/tag-manager/" target="_blank" >}}Google Tag Manager{{< /anchor >}} (GTM).

Eventos são ações de interesse. Exemplos de eventos são:

- Acessar uma página;
- Clicar em um botão;
- Assistir a um vídeo;
- Baixar um arquivos.

Uma vez monitorados, informações sobre os eventos são enviadas para a ferramenta de analytics. No caso da versão 3 do Google Analytics, um disparo de evento gera as seguintes informações:

- *Category*: identificador da categoria de eventos;
- *Action*: identificador da ação que disparou o evento. Exemplos podem ser play, click, download e etc;
- *Label*: uma etiqueta com informações adicionais sobre o evento, que o distingue de outros com a mesma ação e que estejam na mesma categoria;
- *Value*: um valor numérico associado ao evento. Pode ser um valor monetário ou algum número que quantifique a ação executada.

Esses atributos possuem uma relação de hierarquia, de forma que evento contém categorias, categorias contém ações, ações contém labels e labels contém valores.

## Mapeamento de eventos de teste no Google Analytics versão 3

A solução para o problema de diferença de números será registrar eventos na ferramenta de analytics em dois momentos:

- Um quando o visitante acessa o produto;
- Um quando o visitante realiza o evento de conversão.

Os eventos possuem praticamente as mesmas propriedades em *Event*, *Action* e *Label*. O uso de *Value* é opcional. O que vai mudar é o *Action*, que vai assumir um valor quando um visitante for selecionado para participar do teste e outro quando o visitante executar o evento de conversão. Um diagrama da solução proposta se parece com este:

{{< image src="images/figure1-hierarchy-google-events.webp" alt="Hierarquia de eventos na versão 3 do Google Analytics para testes A/B." caption="Hierarquia de eventos na versão 3 do Google Analytics para testes A/B. Fonte: Autor." title="Hierarquia de eventos na versão 3 do Google Analytics para testes A/B." lazy="true" >}}

## Configuração da ferramenta de testes

Para ilustrar o conceito, será apresentada uma proposta de implementação utilizando o Google Optimize e a versão 3 do Google Analytics. O envio de informações para o Google Analytics será feito pelo gerenciador de tags Google Tag Manager.

Em geral, ferramentas de testes possuem tanto um editor de sites do tipo “clicar e arrastar” quanto um para inserção de código manual. Esses editores de código aceitam HTML, CSS e Javascript, e em algumas ferramentas possuem injeção de códigos em dois níveis: um global e um local. O editor de scripts global injeta trechos de código em todas as variações do teste, enquanto o local é carregado de acordo com a variação selecionada.

Para o exemplo de implementação a seguir, o código será escrito no editor local.

Com o Google Tag Manager instalado, basta chamar o método push do objeto dataLayer e enviar os dados para um evento que tenha sido registrado no Google Tag Manager:

{{< highlight javascript >}}
  dataLayer.push({
    event: 'evento_no_gtm',
    category: 'categoria',
    action: 'acao',
    label: 'descricao'
  });
{{< /highlight >}}

Esse atributo "event" pertence ao objeto dataLayer e faz referência a uma tag no Google Tag Manager. Em uma instalação da versão 3 do Google Analytics sem o Google Tag Manager, será necessário mandar um disparo do tipo evento para dentro do Google Analytics:

{{< highlight javascript >}}
  ga('send', 'event', 'categoria', 'acao', 'descricao');
{{< /highlight >}}

No caso do push com o dataLayer, será feito um disparo de uma tag de evento que enviará os dados para o Google Analytics. Dentro do editor de scripts local, cada variação vai receber um trecho de código como um dos exemplos, que deve ser disparado em dois momentos diferentes para cada variação do teste. Os parâmetros serão:

- category: recomendo usar o nome ou um identificador do teste dentro da categoria;
- action: a ação terá duas opções, uma para acesso e outra para conversão. Action pode assumir "acesso" ou "conversão" por exemplo;
- label: guardará a variação do teste. Pode ser uma letra ou o nome da alteração induzida.

Category será igual em todas as chamadas ao código de disparo, label e action vão mudar conforme a variação do teste, e se foi feita uma visita ou uma conversão. A segunda chamada ao código de disparo do evento deve ser feita somente após o evento de conversão ter sido disparado, nesse caso é necessário criar um trigger que escute esse evento:

{{< highlight javascript >}}
  window.onload = function() {
    var cta = document.getElementById('cta');
    cta.onlick = function() {
      // Se usar o Google Tag Manager
      dataLayer.push({
        event: 'evento_no_gtm',
        category: 'categoria',
        action: 'acao',
        label: 'descricao'
      });

      // Se não usar o Google Tag Manager
      ga('send', 'event', 'categoria', 'acao', 'descricao')
    }
  }
{{< /highlight >}}

Dica: opte por usar javascript nativo quando possível para evitar a dependência de outras bibliotecas, o que pode tornar o tempo de carregamento maior e aumentar a possibilidade de o conteúdo da página "piscar" diante do usuário (FOOC).

O uso de window.onload garante que o botão só será acessado após ter sido carregado. Pode acontecer de o trecho de código javascript carregar antes da página e ele tentar acessar elementos que ainda não foram carregados. O uso de DOMContentLoaded fica a cargo da pessoa desenvolvedora, considerando {{< anchor href="https://caniuse.com/#search=DOMContentLoaded" target="_blank" >}}que navegadores antigos não reconhecem este método{{< /anchor >}}.

O código completo a ser adicionado a cada variação do teste:

{{< highlight javascript >}}
  // Código executado assim que o visitante é direcionado para uma das variações do teste
  window.onload = function() {
    // Se não usar Google Tag Manager dá pra fazer com ga('send', 'event', 'teste_no_cta', 'acesso', 'grupo_controle')
    dataLayer.push({
      event: 'testes_tag', // Nome da tag no Google Tag Manager
      category: 'teste_no_cta', // Nome do teste
      action: 'acesso', // Acesso a página do teste
      label: 'grupo-controle' // O visitante caiu no grupo de controle.
    });

    var btn = document.getElementById('cta');

    btn.onclick = function() {
      // Se não usar Google Tag Manager dá pra fazer com ga('send', 'event', 'teste_no_cta', 'conversao', 'grupo_controle')
      dataLayer.push({
        event: 'testes_tag', // Nome da tag no Google Tag Manager
        category: 'teste_no_cta', // Nome do teste
        action: 'conversao', // Conversão na página do teste
        label: 'grupo-controle' // O visitante caiu no grupo de controle.
      });
    }
  }
{{< /highlight >}}

Navegue até o relatório de eventos em Behavior > Events > Top Events. Uma vez que o teste tenha iniciado, os eventos de acesso e conversão deverão ser registrados neste relatório. Veja a diferença entre as colunas de eventos e eventos únicos. Como o teste pode funcionar em mais de uma página ou os visitantes a recarregarem, acompanhe pelos eventos únicos, que não serão atualizados com múltiplos disparos sendo enviados ao Google Analytics. Para comparar a quantidade de eventos com usuários ou sessões, crie um relatório personalizado em Customization > Custom Reports incluindo usuários únicos e eventos únicos, com quebra por categoria, ação e label.

{{< image src="images/figure2-google-custom-report.webp" alt="Criação de relatório personalizado na versão 3 do Google Analytics." caption="Criação de relatório personalizado na versão 3 do Google Analytics. Fonte: Autor." title="Criação de relatório personalizado na versão 3 do Google Analytics." lazy="true" >}}

Dessa forma é possível contabilizar acessos individuais e também por sessão dentro do Google Analytics.

{{< image src="images/figure3-google-test-event-dashboard.webp" alt="Painel de métricas de testes A/B na versão 3 do Google Analytics." caption="Painel de métricas de testes A/B na versão 3 do Google Analytics. Fonte: Autor." title="Painel de métricas de testes A/B na versão 3 do Google Analytics." lazy="true" >}}

Ao clicar na categoria do evento, deverão ser abertas as ações com o número de visitantes que participaram do teste e o número total de conversões. Ao clicar em uma das ações (acesso ou conversão) o relatório irá mostrar as variações do teste para acessos ou para conversões dependendo de qual ação tenha sido selecionada. Para ver as categorias, ações e labels em uma mesma tabela, basta usar a opção de tabela fixa no relatório personalizado. Os números de usuários, sessões e eventos únicos deverão ficar próximos visto que as informações sobre testes só vão para o Google Analytics uma vez que o teste tenha iniciado.

Mesmo que a diferença de dados entre as ferramentas de testes e de analytics não deixe de existir, os números nos painéis estarão mais próximos e terão uma mesma fonte de origem, que é a ferramenta de testes.
