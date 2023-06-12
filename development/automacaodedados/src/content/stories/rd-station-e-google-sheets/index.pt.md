---
title: 'RD Station e Google Sheets: exportação automática de leads para planilhas'
author: henriquesouza
publishDate: 2018-09-02 14:07:00
lastMod: 2021-11-10 14:07:00
summary: Saiba como enviar dados de leads automaticamente para planilhas no Google Sheets a partir do software de automação de marketing RD Station.
description: 'RD Station e Google Sheets: exportação automática de leads para planilhas'
image_description: 'Logotipos do RD Station e do Google Sheets.'
categories:
- Automação
featured: true
---

Publicado em 02/09/2018 e atualizado em 10/11/2021.

**ALERTA DE SPOILER: este post contém linhas de código! Vou assumir que você tem familiaridade com o básico de Javascript, sabe o que é uma API e o que é JSON.**

Atualizações 04/09/2020:

- Este post agora possui uma parte 2: {{< anchor href="/stories/rd-station-e-google-sheets-na-aws/" >}}RD Station e Google Sheets Parte 2 - Migrando para a AWS{{< /anchor >}};
- A {{< anchor href="https://zapier.com/pricing" target="_blank" >}}tabela de preços do Zapier{{< /anchor >}} mudou. O plano que suporta 3.000 chamadas à API não existe mais, agora existe um com até 2.000 chamadas e o plano seguinte vai para 5.000 chamadas;
- {{< anchor href="https://developers.google.com/apps-script/guides/v8-runtime" target="_blank" >}}O Google Apps Script agora suporta a engine V8{{< /anchor >}}, o que permite a criação de aplicativos que utilizem a sintaxe moderna de JavaScript em ES6. Nem todos os recursos do ES6 são suportados até a data de atualização deste post;
- O formato do webhook do RD Station {{< anchor href="https://developers.rdstation.com/pt-BR/migration/webhooks" target="_blank" >}}irá mudar{{< /anchor >}};
- Não existe mais distinção entre fluxos de automação paralelos e gerenciais. Todo fluxo de automação é paralelo;
- O limite atual de células em uma planilha do Google Sheets é de {{< anchor href="https://support.google.com/drive/answer/37603?hl=en" target="_blank" >}}5.000.000{{< /anchor >}}.

Atualizações 10/11/2021:

- O Google Apps Script passou por novas modificações, incluíndo a forma como novos projetos são criados a partir de outros aplicativos do Google. O novo caminho para acessar o Google Apps Script é em Extensions > Apps Script;
- O RD Station está utilizando OAuth2 como protocolo de autenticação em sua API;
- O criador de fluxo de automações do RD Station possui uma nova interface e a opção de disparo de webhook se chama "Enviar Leads para Integração";
- A estrutura do webhook se mantém a mesma de quando o post foi publicado;
- O processo de publicação de *web apps* no Google Apps Script agora é feito pelo botão "Deploy", no canto superior direito da interface.

## Por que planilhas?

Exportar dados de uma fonte para outra é tarefa comum quando se trata de agrupar conjuntos de dados para análise ou visualização. Agregadores de dados bem conhecido são as planilhas eletrônicas – os Exceis e Sheets da vida. Planilhas são convenientes para armazenar, manipular e visualizar dados das mais diversas naturezas em formato tabular. São fáceis de entender e sua organização gera um padrão de comunicação entre pessoas e também entre ferramentas, por isso ainda não deram lugar a ferramentas mais robustas e inteligentes para o mesmo fim. Se você não vive sem suas planilhas de métricas sabe bem do que estou falando. Agora, é sabido que planilhas não são nada sem dados e que uma parte considerável do nosso tempo é gasto preenchendo células nos locais corretos para gerar as informações que nos levarão aos valiosos insights. Diminuir este tempo, então, significa ter mais tempo para se preocupar com análise. Ferramentas como Zapier e Pluga facilitam a vida nesse sentido, já que possuem conectores com centenas de outras ferramentas e uma interface amigável para a criação de fluxos de dados entre elas. Por que então não usá-las?

A escolha do plano de uso destas ferramentas depende da quantidade de chamadas feitas a elas. Um plano inicial para processar uma quantidade pequena de dados pode dar conta do recado a um custo baixo, porém, quanto maior a base, maior deverá ser o plano da ferramenta de integração (para referência, no momento da escrita deste texto, em Agosto de 2018, o Zapier cobra USD 62,50 mensais para até 3.000 chamadas em seu plano professional. Acima disso o plano passa a ser o professional plus, cujo preço sobe para USD 156,25. Com base nisso, vou considerar que 3.000 chamadas é pouco, mas entendo que depende do contexto de cada empresa e da existência de caixa para pagar essa mensalidade. Considere que, na aplicação de automatizar o envio de de leads para uma ferramenta externa, uma chamada significa enviar um lead para esta ferramenta, nesse caso uma planilha. Com o plano professional do Zapier, no máximo 3.000 leads poderão ser entregues para a planilha mensalmente).

{{< image src="images/figure1-zapier-price-plans-august-2018.webp" alt="Planos e recursos do Zapier em Agosto de 2018." caption="Planos e recursos do Zapier em Agosto de 2018. Fonte: Zapier." title="Planos e recursos do Zapier em Agosto de 2018." lazy="true" >}}

O tamanho do plano limita a integração pelo número de chamadas feitas na ferramenta, e o que exceder o limite fica pendurado em uma fila esperando o reinício da contagem de chamadas ou o pagamento de um plano maior. Isso ainda pode ser aceitável para alimentar planilhas cujo consumo tem data definida, mas análises *ad hoc*, que podem forçar atualizações de dados não programadas, podem ser deixadas de lado para não estourar o plano da ferramenta. Outra desvantagem é contar com este tipo de integração para ações sazonais, como co-marketing ou presença em eventos, onde geralmente as empresas recebem um volume grande de leads. Se não for previsto, este volume de entrada anormal pode gerar surpresas e estourar o plano, fazendo com que a integração deixe de funcionar. Em outras palavras: escalar pode ser um problema. Mais um ponto: durante a construção da integração será necessário testá-la. Uma vez que a integração esteja em produção, cada chamada a ela consome do plano, mesmo que seja uma chamada de teste. Há outra maneira de fazer esta integração, contornando os problemas apresentados.

## A receita ~~não mais~~ secreta por trás da integração

A partir do plano PRO, o {{< anchor href="https://www.rdstation.com/" target="_blank" >}}RD Station{{< /anchor >}} possui recursos para que pessoas desenvolvedoras possam criar integrações entre a ferramenta de automação de marketing e outras ferramentas. Estes recursos são chamados de APIs e webhooks, interfaces – ou portas – que permitem o tráfego de dados para dentro e para fora da ferramenta. APIs permitem a comunicação com o RD Station por meio de interfaces de programação, enquanto webhooks são notificadores de eventos que enviam dados para fontes determinadas. Caso queira entender melhor o que é uma API, veja estes posts:

- {{< anchor href="/stories/apis-e-carrinhos-de-supermercado/" >}}APIs e carrinhos de supermercado{{< /anchor >}} (sem jargões técnicos);
- {{< anchor href="/stories/fundamentos-das-apis/" >}}Fundamentos das APIs{{< /anchor >}} (com jargões técnicos).

Neste post, vamos utilizar **webhooks**.

Para que um webhook envie dados para algum lugar, ele precisa de duas informações:

- Um endereço para onde os dados devem ser enviados;
- Qual o gatilho que, quando disparado, vai acionar o webhook.

Este endereço precisa ser uma URL que esteja preparada para receber os dados do webhook.

A ação que dispara o webhook é chamada de gatilho, é algo que precisa acontecer para, só então, o webhook mandar os dados para o endereço. Este gatilho é configurado na ferramenta que dispara o webhook. Neste caso, o RD Station.

Hora de falar um pouco sobre o lado da planilha para então colocar-mos a mão na massa!

## Planilhas com scripts?

Desenvolver scripts em planilhas não é algo novo. {{< anchor href="https://www.oreilly.com/library/view/vb-vba/1565923588/1565923588_ch01-6-fm2xml.html" target="_blank" >}}O VBA no Excel está aí para provar{{< /anchor >}}. Faremos algo nesta linha, mas usando outro software de gestão de planilhas, outra ferramenta de scripts e outra linguagem de programação. O software de gestão de planilhas é o {{< anchor href="https://www.google.com/sheets/about/" target="_blank" >}}Google Sheets{{< /anchor >}}, a ferramenta de scripts é o {{< anchor href="/stories/uma-introducao-ao-google-apps-script/" >}}Google Apps Script{{< /anchor >}} e a linguagem de programação é Apps Script, criada pelo Google e baseada em JavaScript. A similaridade de Apps Script com JavaScript tem um benefício imediato: JavaScript é uma linguagem usada em aplicações web, portanto, quem já desenvolve em JavaScript não precisa aprender uma linguagem nova, e quem aprende Apps Script pode aproveitar o conhecimento para desenvolver para a web com JavaScript. Quanto ao software gerenciador de planilhas, uma vantagem em trabalhar especificamente com o Google Sheets está no fato de a ferramenta estar na nuvem e configurada para trabalhar com o recebimento de dados de outras ferramentas. Isso significa que não precisamos escrever código para “abrir uma porta” por onde os dados podem entrar porque isso já foi feito.

## Mão na massa: a configuração da planilha

Vamos começar pelo Google Sheets. Crie uma planilha em sua conta. Com a planilha criada, acesse o menu Tools e clique em Script Editor.

{{< image src="images/figure2-google-sheets-script-editor.webp" alt="Opção editor de scripts no menu ferramentas do Google Sheets em Agosto de 2018." caption="Opção editor de scripts no menu ferramentas do Google Sheets em Agosto de 2018. Fonte: Autor." title="Opção editor de scripts no menu ferramentas do Google Sheets em Agosto de 2018." lazy="true" >}}

A interface do Google Apps Script será mostrada.

{{< image src="images/figure3-google-apps-script-editor.webp" alt="Editor de scripts do Google Apps Script aberto." caption="Editor de scripts do Google Apps Script aberto. Fonte: Autor." title="Editor de scripts do Google Apps Script aberto." lazy="true" >}}

O Google Apps Script se divide em três principais seções: o menu de ferramentas, no topo, o painel de arquivos do projeto, à esquerda, e a interface de escrita de código, à direita. A {{< anchor href="https://developers.google.com/apps-script/reference/" target="_blank" >}}documentação{{< /anchor >}} é um bom ponto de partida para se familiarizar com o editor e com a linguagem.

O primeiro passo será informar para o Google Apps Script (que a partir de agora vou chamar apenas de GAS) que o script deverá receber e tratar dados externos, ou, se comunicar com o mundo externo. Nos termos do GAS, o script será um aplicativo web (*web app*). Para fazer isto, apague a função padrão, criada junto com o arquivo Code.gs, e crie duas outras, chamadas doGet e doPost. Ambas recebem um argumento “e” que representa os dados recebidos pelo script.

{{< highlight javascript >}}
function doGet(e) {
  // Todo
}

function doPost(e) {
  // Todo
}
{{< /highlight >}}

A função doGet recebe dados que são passados como parâmetros na URL do script. Se, por exemplo, o endereço do script for https://script.google.com/d/id_do_script/exec?nome=Henrique&cargo=cientista_de_dados, o que está à direita do sinal de interrogação são os parâmetros passados na forma de chave=valor, separados por um sinal de igual. A primeira chave, no exemplo, é “nome” e contém o valor “Henrique”. Conjuntos de chave / valor são separados por *ampersands*, ou “e comercial” (&).

{{< image src="images/figure4-doget-dopost-functions.webp" alt="Funções doPost e doGet declaradas no script." caption="Funções doPost e doGet declaradas no script. Fonte: Autor." title="Funções doPost e doGet declaradas no script." lazy="true" >}}

Para ser caracterizado como um *web app*, o script só precisa de uma das funções. Declaramos a doGet apenas para tratar a saída caso o endereço do script seja acessado usando o método GET (improvável, mas possível). Se a função não estivesse declarada, um acesso direto a URL do script iria mostrar uma mensagem como "O script terminou a execução e não há nada a ser exibido na saída". Com a função declarada e sem nada dentro, o script irá mostrar uma tela em branco. Manteremos desta forma.

A função que vai receber e tratar os dados do RD Station é a doPost. Ela recebe dados passados no corpo de uma mensagem que trafega pela web usando o método POST.

Para começar, vamos escrever o código que irá tratar os dados e exibi-los na planilha. Dentro da função doPost escreva o seguinte trecho de código:

{{< highlight javascript >}}
// Verifica se a chamada POST veio com dados no corpo e se os dados estão no formato correto
if (e.postData.contents && e.postData.type == 'application/json') {
   // Caso existam dados eles virão em formato JSON e é necessário transformar estes dados para usá-los no aplicativo
  var lead = JSON.parse(e.postData.contents);

  // Chama uma função para gravar o lead na planilha. Esta função será criada
  gravarMensagem(lead);
}
{{< /highlight >}}

O que este código está fazendo, em sequência:

- Verifica se o parâmetro definido na função POST está com dados, e também se o tipo de informação que está vindo para o script é JSON. Se estiver, significa que o webhook conseguiu acessar a URL e entregar os dados do lead;
- Caso os dados estejam no parâmetro, faz o chamado *parse* deles, que é a transformação do objeto que chegou em formato de texto para o formato de objeto do Javascript. O Apps Script usa a mesma classe e método do JavaScript para tratar este texto JSON. O *parse* é feito usando JSON.parse() e o método recebe o texto que será tratado, que neste caso é o texto que veio do webhook. O texto tratado é armazenado na variável lead;
- A linha seguinte chama a função gravarMensagem e recebe um argumento. Passamos o lead que foi recebido e tratado.

O passo seguinte é criar a função gravarMensagem. Escreva o seguinte trecho de código no mesmo arquivo:

{{< highlight javascript >}}
function gravarMensagem(mensagem) {
  // Abre a planilha e seleciona a aba Sheet1
  var celulas = SpreadsheetApp.getActiveSpreadsheet().getSheetByName('Sheet1');

  // Seleciona as células que conterão o cabeçalho. Em ordem, os parâmetros são: primeira linha, primeira coluna, última linha, última coluna. Os parâmetros vão formar uma área com todas as células contidas entre os extremos indicados
  var cabecalho = celulas.getRange(1, 1, 1, 8);

  // Escreve os nomes das colunas nas células de cabeçalho
  cabecalho.setValues([['Nome', 'Email', 'Data de Criação', 'Empresa', 'Origem da Primeira Conversão', 'Estágio no Funil', 'Lead Scoring', 'Interesse']]);

  // Cria uma trava que impede que dois ou mais usuários executem o script simultaneamente
  var trava = LockService.getScriptLock();

  // Espera 1 segundo até que as linhas de código a seguir terminem
  trava.waitLock(1000);

  // Navega pelos dados enviados pelo webhook
  for (var i = 0; i < mensagem.leads.length; i++) {

    // Escreve os dados na planilha
    celulas.appendRow([mensagem.leads[i].name,
                       mensagem.leads[i].email,
                       mensagem.leads[i].created_at,
                       mensagem.leads[i].company,
                       mensagem.leads[i].first_conversion.source,
                       mensagem.leads[i].lead_stage,
                       mensagem.leads[i].fit_score,
                       mensagem.leads[i].interest]);

    // Atualiza a planilha com a nova linha
    SpreadsheetApp.flush();
  }

  // Desativa a trava do script para que possa receber outras mensagens do webhook
  trava.releaseLock();
}
{{< /highlight >}}

Os espaços e comentários dão a impressão de que o código é longo, mas em realidade ele é bem simples:

- Abre a planilha associada ao script e seleciona a aba com o nome Sheet1. SpreadsheetApp é o nome da classe que gerencia planilhas e o funcionamento dela pode ser consultado na documentação do GAS;
- Seleciona as linhas da planilha que conterão o cabeçalho. Para escrever na planilha usando a classe SpreadsheetApp é necessário antes selecionar a ou as células que terão novos valores. Há muitas outras propriedades que podemos extrair dos leads, incluindo campos personalizados. Para deixar o exemplo simples, selecionamos apenas algumas das propriedades padrão da ferramenta;
- Escreve as colunas do cabeçalho na primeira linha da planilha. O argumento do método setValues recebe uma lista com duas dimensões, por isso os valores são passados dentro de uma lista multidimensional;
- Se o fluxo de automação do RD Station tiver como critério de entrada ser novo ou já existir em uma lista de segmentação, todos os leads existentes na lista serão enviados simultaneamente para a planilha, ou em intervalos muito curtos de tempo. Isso gera um problema, pois o script não consegue gerenciar o recebimento de muitas mensagens simultaneamente e acaba escrevendo uma linha por cima da outra, fazendo com que alguns registros sumam. Para contornar o problema, usamos a classe LockService, que faz a gestão de acessos simultâneos ao script;
- O método waitLock é usado para travar a seção do código que vem após ele, garantindo que apenas um acesso por vez seja feito. Os demais acessos entram em uma fila para serem processados conforme a trava vai sendo liberada;
- A navegação pelo objeto recebido do webhook será feita usando um laço do tipo for, cuja condição de término é que uma variável chamada i tenha valor igual ao total de leads enviados pelo webhook (tirando o caso em que o critério de entrada do fluxo de automação é ser novo ou existente em uma lista de segmentação, o webhook deve enviar apenas um lead, então o laço for normalmente vai ter sua variável i começando em 0 e terminando em 1);
- Para cada volta no laço, adiciona uma nova linha na planilha escrevendo os dados do lead. Repare que o objeto mensagem possui uma propriedade leads, que é uma lista. Para navegar nesta lista usamos a variável i que vai sendo alterada ao final de cada volta no laço. O método appendRow é inteligente o suficiente para descobrir qual a última linha preenchida e pular para a linha abaixo para escrever nas células, assim as informações de cabeçalho e leads anteriores não são sobrescritas;
- Após escrever a linha, a planilha é atualizada usando o método *flush* da classe SpreadsheetApp. As operações de escrita em células são agrupadas para serem feitas em conjuntos, melhorando a performance do *web app*. Neste caso precisamos que a linha seja gravada nas células da planilha imediatamente, pois essa operação precisa ser feita antes da liberação da trava;
- A trava é desfeita após a escrita e outros acessos podem ser feitos.

Este código é executado a partir da função doPost sempre que um novo lead chega via webhook. Note que o cabeçalho é escrito sempre. Poderíamos ter feito uma verificação de existência do cabeçalho, mas para ficar simples vamos deixar desta forma. As linhas com os leads não são sobrescritas, graças a trava de segurança que foi feita para evitar múltiplos acessos dentro do laço.

O passo seguinte é publicar o aplicativo. Publicar o aplicativo significa tornar o *web app* público, o que é necessário para que o RD Station consiga enviar os dados. Para publicar o aplicativo, acesse o menu Publish > Deploy as a Web App. Especifique a versão do projeto (neste caso, New) e documente as mudanças ao longo da evolução do projeto. Nas permissões, use seu usuário para autorizar o script e informe que qualquer pessoa pode acessá-lo, mesmo um usuário anônimo, para que o RD Station consiga se conectar com o script. Ao clicar no botão “Deploy”, o GAS pedirá para que você autorize o script a escrever em planilhas e a receber dados de sistemas externos usando suas credenciais. Após a autorização, o aplicativo será publicado e uma URL pública será criada. É esta URL que vamos passar para o RD Station mais adiante.

Atualização 10/11/2021: este procedimento agora é feito clicando no botão "Deploy", na porção superior direita da tela. É necessário criar um novo *deploy*, clicar no ícone de engrenagem do tipo de *deploy* e selecionar a opção *web app*. O restante do preenchimento é idêntico ao método anterior e a URL pública do aplicativo é gerada após a publicação.

{{< image src="images/figure5-deploy-web-app.webp" alt="Tela de criação de novo deploy em Agosto de 2018." caption="Tela de criação de novo deploy em Agosto de 2018. Fonte: Autor." title="Tela de criação de novo deploy em Agosto de 2018." lazy="true" >}}

{{< image src="images/figure6-web-app-url.webp" alt="Tela de web app publicado com o endereço público em Agosto de 2018." caption="Tela de web app publicado com o endereço público em Agosto de 2018. Fonte: Autor." title="Tela de web app publicado com o endereço público em Agosto de 2018." lazy="true" >}}

O próximo passo é configurar o RD Station para enviar os dados para a planilha, mas antes vale um aviso: ao permitir que qualquer pessoa possa executar o script, uma brecha de segurança é aberta para que dados não intencionados sejam enviadas para o script. A princípio o script (no papel de servidor) está configurado para receber quaisquer requisições GET ou POST. É importante tratar os dados de entrada para ter certeza de que o retorno é o esperado.

## Mais mão na massa: o RD Station

O RD Station permite Configurar webhooks de duas maneiras: usando o recurso de webhooks que está no menu Integrações, que aparece ao clicar / apertar o nome da conta na porção superior direita da tela ou usando os fluxos de automação. O que difere entre as formas de criar o webhook é que ao fazer a criação pelo menu de integrações, só é possível enviar leads via webhook após eventos de conversão ou nova oportunidade, enquanto pelos fluxos de automação é possível também esperar que entrem em uma lista de segmentação. Vou mostrar as duas formas, bem como quando usar uma e quando usar outra. Vamos começar pelo método de criar o webhook pelo menu de integrações. Ao abrir a página de integrações, a opção de configurar webhooks estará disponível junto com outras opções de integração. Aperte o botão “Configurar” ao lado da opção de webhooks para abrir a tela com a listagem dos webhooks criados e um botão no canto superior direito da tela para criar novos webhooks. Aperte este botão para abrir um popup com os dados a serem preenchidos.

{{< image src="images/figure7-rd-station-webhook.webp" alt="Tela de criação de novo webhook pelo menu Integrações em Agosto de 2018." caption="Tela de criação de novo webhook pelo menu Integrações em Agosto de 2018. Fonte: Autor." title="Tela de criação de novo webhook pelo menu Integrações em Agosto de 2018." lazy="true" >}}

O nome do webhook é um identificador interno. A URL é o endereço para onde o webhook deve mandar os dados dos leads. Esta é a URL que foi gerada ao fazer a publicação do web app pelo GAS. O gatilho pode ser Conversão ou Oportunidade. Caso seja Oportunidade o campo abaixo some e é só salvar o webhook. Caso o gatilho seja a Conversão, você pode selecionar eventos de conversão específicos, útil para registrar apenas os leads que converterem em determinada landing page ou formulário. Se o campo ficar em branco, todas as conversões serão enviadas pelo webhook. Ao salvar o webhook, o RD Station iniciará o envio dos dados após o evento definido no gatilho acontecer.

A segunda forma de criar um webhook é usando fluxos de automação. Usarei esta forma para fazer a integração neste post, pois o critério de seleção de leads para envio para a planilha é a entrada em uma lista de segmentação. A integração por fluxo permite adicionar etapas entre o evento que irá causar o disparo do webhook e o disparo em sí. Desta forma você pode, por exemplo, notificar um endereço de e-mail quando um lead for enviado, adicionar uma tag ou mudar o estagio do lead no funil.

Para configurar o webhook por fluxos, vá em Relacionar > Automação de Marketing e crie um novo fluxo de automação. Escolha entre o paralelo e o gerencial e dê um nome para o fluxo. Escolha o evento que dará início ao fluxo, que pode ser conversão ou entrada em uma lista de segmentação. Construa o fluxo de acordo com as suas necessidades e no final escolha a ação “Enviar para a URL (Integração)”. A URL a ser informada é a URL gerada na publicação do web app. A {{< anchor href="https://ajuda.rdstation.com.br/hc/pt-br/articles/115001273943" target="_blank" >}}documentação do RD Station para envio de webhooks por fluxos de automação{{< /anchor >}} sugere criar uma espera de um minuto entre a entrada do lead no fluxo de automação e o envio dele para a URL de integração.

Atualização 10/11/2021: O RD Station não suporta mais fluxos de automação gerenciais. Todo fluxo de automação é paralelo.

{{< image src="images/figure8-automation-flow-send-to-web-app.webp" alt="Fluxo de automação configurado para enviar dados para uma planilha em Agosto de 2018." caption="Fluxo de automação configurado para enviar dados para uma planilha em Agosto de 2018. Fonte: Autor." title="Fluxo de automação configurado para enviar dados para uma planilha em Agosto de 2018." lazy="true" >}}

Atualização 10/11/2021: A interface do RD Station para criação de fluxos de automação é diferente da mostrada aqui, porém o procedimento é o mesmo.

Ao finalizar, salve e ative o fluxo de automação. Neste ponto, a integração já deve funcionar e assim que um lead atende as condições do fluxo de automação ele será enviado para o script, que fará o tratamento da informação e o mostrará na planilha.

{{< image src="images/figure9-populated-spreadsheet.webp" alt="Dados de leads escritos nas células da planilha em Agosto de 2018." caption="Dados de leads escritos nas células da planilha em Agosto de 2018. Fonte: Autor." title="Dados de leads escritos nas células da planilha em Agosto de 2018." lazy="true" >}}

Sempre que um novo lead entrar na lista, ele entrará também no fluxo de automação e será enviado para a planilha. Como usamos o método appendRow, o novo lead não irá sobrescrever dados existentes.

Listas grandes podem demorar para serem escritas na planilha e uma sugestão para otimização é exportar manualmente a lista completa, importar para o Google Sheets e ligar a integração apenas para novos leads. O RD Station limita a quantidade de chamadas feitas a suas APIs e webhooks com base no plano contratado. Para referência, entrei em contato com o suporte no dia 30/08/2018 e fui informado que estes são os limites de envio:

- 120 conversões por minuto nos planos Pro ou inferior;
- 500 conversões por minuto no plano Enterprise.

Estes limites são bem confortáveis para pequenas empresas que buscam ganhar escala e reduzir custos. Também é importante ter em mente a quantidade máxima de células que o Google Sheets pode ter, {{< anchor href="https://support.google.com/drive/answer/37603?hl=en" target="_blank" >}}que é 2.000.000{{< /anchor >}}. Esse número é usado para determinar a quantidade de linhas e colunas que o arquivo pode ter. Quanto menor o número de colunas, maior o de linhas e vice versa.

Atualização 10/11/2021. O limite atual de células é 5.000.000.

Pronto! Sempre que um lead atender a determinadas condições dentro do RD Station, ele será enviado automaticamente para uma planilha.

## Leitura adicional

Veja a parte 2 deste post e saiba como mandar os dados do RD Station para a AWS: {{< anchor href="/stories/rd-station-e-google-sheets-na-aws/" >}}RD Station e Google Sheets Parte 2 - Migrando para a AWS{{< /anchor >}}.

Bora automatizar!
