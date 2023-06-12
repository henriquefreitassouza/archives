---
title: 'Google Apps Script com OAuth2'
author: henriquesouza
publishDate: 2018-01-29 14:42:00
lastMod: 2021-11-07 14:42:00
summary: O Google Apps Script possui uma variedade de recursos que torna os aplicativos do Google ainda mais poderosos. Um destes recursos permite que aplicativos do Google possam se conectar a fontes externas. Ao longo deste post, este recurso será apresentado, com foco em APIs que utilizam o protocolo OAuth2 para autenticação.
description: Google Apps Script com OAuth2
image_description: 'Fluxo de autenticação OAuth2.'
categories:
- Automação
featured: true
---

Publicado em 29/01/2018 e atualizado em 07/11/2021.

Atualização 07/11/2021: Desde a publicação deste post, o Google Apps Script passou por uma série de modificações, incluíndo atualizações na interface, a adoção da especificação ES6 do Javascript, um novo sistema de logs de saída e um novo processo para gestão de gatilhos. O procedimento para autenticação em APIs que utilizam OAuth2, no entanto, permanece idêntico ao documentado neste post.

## O que é OAuth2?

Se trata da segunda versão de um protocolo de autorização em que recursos protegidos de algum tipo de sistema são acessados por usuários que possuam as devidas permissões. O protocolo OAuth foi apresentado no post sobre {{< anchor href="/stories/fundamentos-das-apis/" >}}fundamentos de APIs{{< /anchor >}}.

## Por que usar OAuth?

Trabalhar com métodos como chaves de API requer quer a pessoa projetista de software utilize e armazene a chave de forma segura em sua aplicação. Embora alguns serviços tenham sistemas de permissão e restrição de uso das chaves, sua segurança ainda está sob a responsabilidade da pessoa desenvolvedora. Outro problema com chaves é que geralmente elas não levam em consideração o nível de privilégios que um usuário possui, o que torna difícil a distribuição correta das permissões. O protocolo OAuth trabalha com a ideia de tokens, chaves com data de expiração, permissões de acesso e pertencem a um usuário autenticado.

Para exemplificar a diferença entre o funcionamento de OAuth e uma chave de API, imagine o seguinte cenário: alguém chega em um hotel e pede um quarto. O gerente dá a essa pessoa um bolo de chaves que abre todas as portas, mesmo que ela vá usar apenas uma chave para entrar um quarto específico. Ao final da estadia, a pessoa vai embora e se esquece de devolver as chaves para o gerente. A experiência no hotel foi tão legal que ela indica o hotel para um conhecido, emprestando para ele o bolo de chaves com acesso a todos os quartos. No final do período, o segundo hóspede faz uma festa e estraga todo o quarto onde ficou. Neste exemplo, a chave de API é o bolo de chaves. Essas chaves não expiram, acessam todos os cômodos do hotel e qualquer um pode usar.

Imagine agora a reescrita deste cenário: a mesma pessoa vai em um outro hotel e solicita um quarto. O gerente pergunta para quantas pessoas e se possui preferências particulares. Após a pessoa responder, o gerente separa uma chave, entrega na mão do hóspede e informa o número do quarto. Ao final da estadia a pessoa devolve a chave para o gerente e deixa o hotel. A experiência foi muito agradável e essa pessoa recomenda um conhecido. A pessoa indicada vai conhecer o hotel e se depara com o gerente, que lhe pergunta que tipo de quarto ele gostaria. Ao descrever suas necessidades, o gerente lhe entrega uma outra chave, que abre a porta de outro quarto. Ao final da estadia, o indicado devolve a chave para o gerente e vai embora. Neste segundo exemplo, a chave é um token obtido por autenticação OAuth. Essa chave é usada por um usuário específico para acessar um recurso específico e está a disposição deste usuário enquanto ele for hóspede do hotel. Este é o conceito usado no fluxo de autorização do OAuth: a autenticação e concessão dos recursos protegidos é administrada tendo em vista a segurança. Mesmo que outro usuário tenha acesso a um token de autenticação, esse token não terá utilidade se não for associado a ele.

## O fluxo de autorização do protocolo OAuth2

Um fluxo OAuth2 funciona da seguinte maneira:

- Um usuário executa uma ação que dá início ao fluxo, como clicar em um botão;
- A aplicação que armazena os dados protegidos pede as credenciais do usuário;
- Se as credenciais estiverem corretas, o usuário é identificado. Caso contrário, o sistema rejeita a entrada do usuário;
- O usuário autenticado recebe um token que o permite acessar os recursos designados pelo dono dos dados protegidos;
- O usuário requisita dados protegidos e passa seu token de acesso;
- Se o token e o usuário são reconhecidos, os dados são concedidos.

Este fluxo se parece com o da imagem a seguir, criada pela {{< anchor href="https://www.digitalocean.com/" target="_blank" >}}Digital Ocean{{< /anchor >}}:

{{< image src="images/figure1-oauth2-authentication-process.webp" alt="Fluxo de autenticação OAuth2." caption="Fluxo de autenticação OAuth2. Fonte: Digital Ocean." title="Fluxo de autenticação OAuth2." lazy="true" >}}

## Como OAuth2 e o Google Apps Scripts são usados em conjunto?

Serviços externos usam diferentes formas para autenticar e autorizar usuários, e as vezes podem usar mais de uma. No caso dos apps do Google, por exemplo, eles costumam ter a disposição tanto chaves de API quanto OAuth2. O Google Apps Script não possui suporte nativo a OAuth2, porém possui bibliotecas externas que podem ser adicionadas aos projetos criados na ferramenta. Vejamos na prática como todo o processo funciona conectando uma planilha do Google Sheets com o {{< anchor href="https://search.google.com/search-console/about" target="_blank" >}}Google Search Console{{< /anchor >}} (antigo Webmaster Tools).

### 1. Crie um novo arquivo no Google Sheets

Crie um arquivo novo e vá em Tools > Script Editor. O editor de scripts é o Google Apps Script.

{{< image src="images/figure2-google-apps-script-editor.webp" alt="Editor de arquivos do Google Apps Script." caption="Editor de arquivos do Google Apps Script. Fonte: Autor." title="Editor de arquivos do Google Apps Script." lazy="true" >}}

Com exceção do arquivo Code.gs, os demais arquivos foram criados por mim. A primeira coisa a ser feita é instalar a biblioteca que dá suporte a OAuth2. Com o editor aberto vá em Resources > Libraries. O campo "Find a Library" busca bibliotecas disponíveis para extensão do script. O código da biblioteca OAuth2 usada neste post é **1B7FSrk5Zi6L1rSxxTDgDEUsPzlukDsi4KGuTMorsTQHhGBzBkMun4iDF**. Basta colar este código na caixa de busca e aparecerá a biblioteca. Selecione a versão mais recente (24 na época da escrita deste post) e selecione OK.

{{< image src="images/figure3-google-apps-script-oauth2-plugin.webp" alt="Biblioteca OAuth2, feita pelo Google." caption="Biblioteca OAuth2, feita pelo Google. Fonte: Autor." title="Biblioteca OAuth2, feita pelo Google." lazy="true" >}}

### 2. Configure o projeto associado ao script da planilha no Google Cloud Console

O {{< anchor href="https://console.cloud.google.com/" target="_blank" >}}Google Cloud Console{{< /anchor >}} é uma plataforma sobre a qual são construídos aplicativos usados pelos serviços do Google, como plugins. Nesta plataforma são gerenciados os aplicativos criados por pessoas desenvolvedoras e as credenciais de acesso que esses aplicativos possuem aos serviços do Google. Para acessar o Google Cloud Console vá em Resources > Cloud Platform project. Abrirá um modal com um link cujo texto possui o formato [nome-do-script]-project-id-[id-do-projeto], onde [nome-do-script] é o nome dado ao script associado a planilha e [id-do-projeto] é um identificador único atribuído pelo Google Cloud Console.

{{< image src="images/figure4-google-cloud-project-id.webp" alt="ID do Google Cloud Project associado ao script." caption="ID do Google Cloud Project associado ao script. Fonte: Autor." title="ID do Google Cloud Project associado ao script." lazy="true" >}}

Todo projeto criado no Google Apps Script cria também um projeto no Google Cloud Console, onde é feita a gestão das credenciais utilizadas para acessar serviços externos.

{{< image src="images/figure5-google-cloud-project-info.webp" alt="Painel de informações do projeto criado no Google Cloud Console." caption="Painel de informações do projeto criado no Google Cloud Console. Fonte: Autor." title="Painel de informações do projeto criado no Google Cloud Console." lazy="true" >}}

Uma vez que o projeto esteja aberto, é necessário selecionar os serviços do Google que serão usados. Há um para o Search Console, que será usado neste post. Dentro da caixa "Getting Started" clique em "Enable APIs and get credentials like keys". No menu lateral, vá para "Library" e na caixa de busca digite "Search Console". O primeiro resultado é o da API chamada "Google Search Console API". Clique nele e clique no botão "Enable".

{{< image src="images/figure6-google-search-console-api.webp" alt="Serviço de conexão com a API do Google Search Console." caption="Serviço de conexão com a API do Google Search Console. Fonte: Autor." title="Serviço de conexão com a API do Google Search Console." lazy="true" >}}

Selecionada a API, é necessário informar como será feito o processo de autorização aos dados que a API entregará. Existem basicamente dois tipos: chave de autenticação e OAuth2. Neste post será usada a opção OAuth2. No menu lateral, acesse a opção "Credentials" e na tela exibida, clique no botão "Create credentials". No drop down que surge, clique em "OAuth client ID".

{{< image src="images/figure7-google-cloud-project-credentials.webp" alt="Passo 1 da configuração de novas credenciais para acesso a API do Google Search Console." caption="Passo 1 da configuração de novas credenciais para acesso a API do Google Search Console. Fonte: Autor." title="Passo 1 da configuração de novas credenciais para acesso a API do Google Search Console." lazy="true" >}}

O Google Cloud Console pergunta que tipo de aplicativo a pessoa desenvolvedora está criando. Para trabalhar com o Google Apps Script é necessário selecionar a opção "Web application" e preencher as informações que surgem na porção inferior da tela. As duas informações necessárias para preenchimento são o nome do aplicativo e pelo menos uma URL de redirecionamento, que será usada para redirecionar o usuário após a autenticação. A URL de redirecionamento será o próprio script do Google Apps Script. A URL de um script possui o formato https://script.google.com/macros/d/[SCRIPT ID]/usercallback, onde [SCRIPT ID] é o identificador do script gerado pelo Google Apps Script quando o projeto foi criado. Esse id pode ser acessado em File > Project properties. Copie o id e monte o restante da URL.

Configurado o projeto e a forma de autorização, duas informações serão disponibilizadas no painel do Google Cloud Console: um CLIENT ID e um CLIENT SECRET. Essas informações serão usadas para construir uma segunda URL, a URL de autenticação. Copie estas credenciais e feche o Google Cloud Console.

### 3. Escreva os códigos de autorização e chamadas a API

Agora que o Google Cloud Console está pronto para gerenciar requisições de um aplicativo externo é possível fazer chamadas a este serviço pelo Google Apps Script, contanto que existam credenciais com permissões de acesso aos recursos do Search Console. A primeira coisa a ser feita é escrever o código que será usado para autorizar usuários que queriam acessar o Search Console a partir da planilha. O editor de scripts criou um arquivo chamado Code.gs e uma função vazia. Criei um arquivo novo contendo as variáveis globais do código para facilitar a manutenção. No arquivo criado, declare as seguintes variáveis:

{{< highlight javascript >}}
var CLIENT_ID = 'SEU_CLIENT_ID';
var CLIENT_SECRET = 'SEU_CLIENT_SECRET';
var SCOPE = 'https://www.googleapis.com/auth/webmasters.readonly';
var SITE = 'SEU_SITE_NO_SEARCH_CONSOLE';
{{< /highlight >}}

CLIENT_ID e CLIENT_SECRET são as credenciais fornecidas pelo Google Cloud Console na criação no método de autorização. Coloque-as nos locais indicados por "SEU_CLIENT_ID" E "SEU_CLIENT_SECRET". O escopo de acesso é necessário para qualquer fluxo OAuth2 e representa o conjunto de permissões a que um usuário tem acesso. Todos os escopos de produtos do Google para uso em autorizações OAuth2 estão disponíveis na {{< anchor href="https://developers.google.com/identity/protocols/googlescopes" target="_blank" >}}documentação do Google{{< /anchor >}}. O Search Console possui dois escopos: *readonly*, para apenas leitura e *webmasters*, para leitura e modificação das informações. Neste post será usado o escopo *readonly*. A variável SITE contém o site cadastrado no Search Console cujos dados iremos consultar. O nome do site deve ser informado da forma como está no search console. Se o site é, por exemplo, http://henriquefreitas.com.br, a variável deve ser preenchida de acordo.

Crie um novo arquivo em File > New > Script file. Dê um nome para o arquivo e clique em OK. Neste arquivo será colocado o código que cria o objeto que dá início ao fluxo de autorização OAuth2:

{{< highlight javascript >}}
function getService() {
  return OAuth2.createService('searchconsole')
      .setAuthorizationBaseUrl('https://accounts.google.com/o/oauth2/auth')
      .setTokenUrl('https://accounts.google.com/o/oauth2/token')

      .setClientId(CLIENT_ID)
      .setClientSecret(CLIENT_SECRET)

      .setCallbackFunction('authCallback')

      .setPropertyStore(PropertiesService.getUserProperties())

      .setScope(SCOPE)

      .setParam('login_hint', Session.getActiveUser().getEmail())
      .setParam('access_type', 'offline');
}

function authCallback(request) {
  var service = getService();
  var isAuthorized = service.handleCallback(request);
  if (isAuthorized) {
    return HtmlService.createHtmlOutput('Autorizado. Pode fechar esta aba.');
  } else {
    return HtmlService.createHtmlOutput('Acesso negado. Verifique as credenciais fornecidas e tente novamente. Pode fechar esta aba.');
  }
}
{{< /highlight >}}

Repare que as variáveis criadas no arquivo de variáveis globais são reconhecidas neste novo arquivo. A função getService é a responsável por criar e retornar um objeto OAuth2 com escopo e fluxo de autenticação definidos. Vários métodos são encadeados para obter o resultado final:

- setAuthorizationBaseUrl monta a URL base de autenticação. Essa URL é composta por informações como o CLIENT ID e o CLIENT SECRET portanto ela muda para cada usuário. A porção base, no entanto, é especificada neste método;
- setTokenUrl é a URL que retorna tokens de autenticação para usuários autorizados;
- setCallbackFunction aponta uma função que será executada após a tentativa de autenticação;
- setPropertyStore determina o local onde tokens autorizados são armazenados;
- setScope determina o escopo de acesso aos dados protegidos;
- setParam adiciona configurações personalizadas. O parâmetro login_hint previne que a tela de login seja mostrada várias vezes para usuários logados em mais de uma conta do Google. O parâmetro access_type autoriza o uso das informações offline.

A função authCallback é executada sempre que getService é chamada. Ela verifica se a autorização foi concedida e informa ao usuários solicitante. No exemplo, uma aba é aberta no navegador com um texto informando o status da tentativa de autenticação.

Crie mais um arquivo em File > New > Script file. Dê um nome para o arquivo e clique em OK. Neste arquivo serão feitas as chamadas ao serviço e solicitados os dados do Search Console mediante autenticação. Escreva o seguinte código:

{{< highlight javascript >}}
function getSearchConsole() {
  var apiUrl = 'https://www.googleapis.com/webmasters/v3/sites/' + SITE + '/searchAnalytics/query?fields=rows&alt=json';
  var response = getSearchConsoleData(apiUrl, ['query']);

  if (response) {
    var json = JSON.parse(response);

    if (!json.error) {
      var reportHeaders = [['Keyword', 'Clicks', 'Impressions', 'CTR', 'Position']];
      displaySearchConsoleData(json, reportHeaders, 1, 1);
    }
  }
}

function getSearchConsoleData(url, dimensions) {
  var response = null;
  var headers, payload, options;
  var startDate = Utilities.formatDate(new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000), Session.getScriptTimeZone(), 'yyyy-MM-dd');
  var endDate = Utilities.formatDate(new Date(), Session.getScriptTimeZone(), 'yyyy-MM-dd');
  var service = getService();

  if (service.hasAccess()) {
    headers = {'Authorization': 'Bearer ' + service.getAccessToken() };
    payload = {
      'startDate': startDate,
      'endDate': endDate,
      'dimensions': dimensions
    };
    options = {
      'headers': headers,
      'contentType': 'application/json',
      'method': 'post',
      'payload': JSON.stringify(payload),
      'muteHttpExceptions': true
    };

    try {
      response = UrlFetchApp.fetch(url, options);
    } catch (e) {}

  } else showDialog();

  return response;
}

function displaySearchConsoleData(json, reportHeaders, numKeys, initialColumnPosition) {
  var searchConsoleData = spreadsheet.getActiveSpreadsheet().getSheetByName('Search Console');
  var report = [];

  for (var i in json.rows) {
    var keys = [];
    for (var j = 0; j < numKeys; j++) {
      keys.push(
        json.rows[i].keys[j]
      );
    };
    report.push(keys);

    report[i].push(
      json.rows[i].clicks,
      json.rows[i].impressions,
      json.rows[i].ctr,
      json.rows[i].position
    );
  };

  searchConsoleData.getRange(1, initialColumnPosition, 1, reportHeaders[0].length).setValues(reportHeaders);
  searchConsoleData.getRange(2, initialColumnPosition, report.length, reportHeaders[0].length).setValues(report);
}
{{< /highlight >}}

Foram criadas funções diferentes para modularizar o projeto. É possível fazer diferentes chamadas a API especificando diferentes visões de dados para serem retornadas. O que este código faz:

- A função getSearchConsole monta o *endpoint* da API que contém os dados de interesse;
- Na sequência, faz uma chamada a essa URL usando a função getSearchConsoleData que foi criada passando como parâmetros a URL e uma lista com apenas um item: query. Query é o parâmetro que retorna as palavras chave que resultaram em impressões ou cliques de resultados do site na SERP (página de resultados de busca). Outros possíveis parâmetros de retorno são page, device, country, search type e date. Para passar mais de um parâmetro na lista, basta incluir novos itens no array, por exemplo: ['query', 'page', 'device']. Essa lista de parâmetros representa as dimensões pelas quais as métricas serão organizadas;
- Verifica se a chamada a API retornou dados do Google Search Console;
- Se há dados, decodifica a string de retorno, que está em formato JSON, e escreve os dados na planilha usando o método displaySearchConsoleData, criada no fim do arquivo. Os parâmetros recebidos em displaySearchConsoleData são o retorno da chamada a API decodificado, o cabeçalho do relatório em um array multidimensional, um número de chaves que representa seções específicas do arquivo de retorno a chamada da API e o número da coluna mais à esquerda onde os dados serão escritos na planilha.

Uma chamada a API do Google Search Console vai devolver um objeto como o do exemplo a seguir:

{{< highlight javascript >}}
{
  {
    keys: {
      query: 'palavra_chave'
    },
    clicks: 1000,
    impressions: 1000,
    ctr: 1.0,
    position: 3.2
  },
  {
    keys: {
      query: 'outra_palavra'
    },
    clicks: 2000,
    impressions: 3000,
    ctr: 0.6,
    position: 1.2
  }
}
{{< /highlight >}}

A seção keys contém as dimensões (ou qualidades) dos dados, e as métricas estão nas demais propriedades do objeto. O parâmetro que informa o número de chaves basicamente informa quantas dimensões o arquivo de retorno tem para que a função de imprimir os dados na tela monte a tabela corretamente. O último parâmetro informa a partir de qual coluna o relatório deve ser gerado.

A função getSearchConsoleData, chamada por getSearchConsole, faz o seguinte:

- Consulta o objeto OAuth2 pela função getService e verifica se o usuário está autorizado a puxar os dados do Search Console;
- Caso esteja autorizado, são criados objetos de configuração dos cabeçalhos da requisição e os dados de configuração da solicitação (data de início, data de fim e dimensões);
- Chama a API usando um método estático do Google Apps Script: UrlFetchApp.fetch(url, options). Esse método retorna um objeto HTTPResponse contendo os dados e cabeçalhos de resposta;
- O resultado da chamada será devolvido na variável response, que é retornada pela função;
- O método showDialog, acionado caso o usuário não esteja logado, será criado posteriormente.

A função displaySearchConsoleData mostra na planilha os dados retornados da API e recebe como parâmetros o objeto contendo os dados de retorno já decodificados, uma lista de cabeçalhos em um array multidimensional e os já comentados número de chaves e o número da coluna a partir do qual o relatório será mostrado. Ela funciona da seguinte maneira:

- Abre uma pasta na planilha chamada Search Console (veja se o nome da pasta onde os dados do Google Search Console serão colocados é igual ao nome da pasta nesta linha);
- Itera pelo objeto retornado, acessando suas propriedades;
- Armazena as dimensões selecionadas em um array chamado keys;
- Armazena o array keys dentro de outro chamado report;
- Itera pelas propriedades com as métricas do Search Console, adicionando-as também na lista report;
- Escreve na planilha os cabeçalhos da tabela e os dados de retorno.

### 4. Construa uma interface que permita chamadas à API

Até o momento não há como interagir com esse script a partir da planilha. No editor de códigos do Google Apps Script, crie um arquivo novo e escreva o seguinte código:

{{< highlight javascript >}}

function showSidebar() {
  var service = getService();
  var page, template;

  if (!service.hasAccess()) {
    var authorizationUrl = service.getAuthorizationUrl();
    template = HtmlService.createTemplate(
      '<h1>Autentication</h1> ' +
      '<a href="<?= authorizationUrl ?>" target="_blank">Autorize este script a acessar a API do Google Search Console em seu nome.</a>. ' +
      '<p>Por que preciso fazer isso?</p> ' +
      '<p>Este aplicativo precisa da sua permissão para fazer a leitura dos dados da sua conta no Google Search Console.</p>'
    );
    template.authorizationUrl = authorizationUrl;
  } else {
    template = HtmlService.createTemplate('O script já possui autorização para acessar os dados do Search Console. Esta aba pode ser fechada.');
  }

  page = template.evaluate();
  SpreadsheetApp.getUi().showSidebar(page);
}

function showDialog() {
  service = getService();
  if (!service.hasAccess()) Browser.msgBox('Autorize este script a acessar os dados do Search Console por você. Acesse Search Console > Login.', Browser.Buttons.OK);
}

function getData() {
  try {
    getSearchConsole();
  } catch (e) {
    Browser.msgBox(e, Browser.Buttons.OK);
  }
}

function onOpen() {
  var ui = SpreadsheetApp.getUi();
  ui.createMenu('Search Console')
      .addItem('Login', 'showSidebar')
      .addItem('Refresh data', 'getData')
      .addToUi();

  showDialog();
}
{{< /highlight >}}

A função showSidebar monta uma barra lateral na planilha com um link para iniciar o fluxo OAuth2. Se o usuário já estiver autenticado, esta informação será apresentada a ela na barra lateral.

A função showDialog apresenta uma mensagem pedindo que o usuário navegue até o menu Search Console > Login. A função que gera este menu será criada adiante, neste mesmo arquivo.

A função getData faz uma chamada a API do Search Console. Se a chamada não dá certo, apresenta uma mensagem de erro para o usuário.

A função onOpen é uma função especial do Google Apps Script que executa sempre que o arquivo associado ao script, neste caso a planilha, é aberta. Sempre que o arquivo for aberto, esta função criará um menu chamado Search Console com duas opções: Login, para iniciar o fluxo de autenticação e apontando para a função showSidebar, e um menu chamado Refresh data, que faz uma chamada a API.

### 5. Automatize a chamada a API (opcional)

Da forma como está, os dados dos últimos sete dias do Search Console serão escritos na planilha especificada, mas é possível automatizar essa chamada para que os usuários não precisem abrir o menu para atualizar os dados. Para isso, vá no editor de scripts e acesse o menu Edit > Current project's triggers. Essa opção também está disponível na barra de ferramentas, representada por um ícone de um relógio. Ao clicar no relógio ou usar o menu, aparecerá um modal para criação de triggers. Experimente criar um novo trigger que chame a função getData a cada hora, por exemplo. Clique em Save. De hora em hora esta função será chamada e os dados da planilha serão atualizados automaticamente!

{{< image src="images/figure8-google-apps-script-run-trigger.webp" alt="Configuração de gatilho para disparo automático da função de atualização dos dados do Search Console." caption="Configuração de gatilho para disparo automático da função de atualização dos dados do Search Console. Fonte: Autor." title="Configuração de gatilho para disparo automático da função de atualização dos dados do Search Console." lazy="true" >}}

## Automação com Google Apps Script

Scripts como o deste post são extremamente úteis para automatizar tarefas repetidas e realocar pessoas em tarefas mais estratégicas para o departamento onde trabalham ou mesmo para a empresa como um todo. Automação e extensão de funcionalidades de produtos Google são apenas algumas das coisas que o Google Apps Script pode fazer. A implementação apresentada neste post pode ser aplicada para gerar backups dos volumes e termos de busca para a propriedade configurada. O Search Console armazena dados dos últimos doze meses, sendo necessário criar backups periódicos para consultar períodos mais antigos. Basta fazer um pequeno ajuste neste script para que novas linhas não sobrescrevam as antigas na planilha e pronto! Backups automáticos configurados.

## Leitura complementar

Leia os seguintes conteúdos para se aprofundar mais em Google Apps Script e no protocolo OAuth2:

- {{< anchor href="https://github.com/googlesamples/apps-script-oauth2" target="_blank" >}}Biblioteca OAuth2{{< /anchor >}} disponibilizada pelo próprio Google e usada neste post;
- {{< anchor href="https://developers.google.com/apps-script/overview" target="_blank" >}}Documentação do Google Apps Script{{< /anchor >}};
- O post sobre {{< anchor href="/stories/fundamentos-das-apis/" >}}fundamentos de APIs{{< /anchor >}} escrito neste blog;
- O post sobre {{< anchor href="/stories/uma-introducao-ao-google-apps-script/" >}}fundamentos do Google Apps Script{{< /anchor >}} escrito neste blog;
- {{< anchor href="https://aaronparecki.com/oauth-2-simplified/" target="_blank" >}}Os fundamentos de OAuth, por Aaron Parecki{{< /anchor >}};
- {{< anchor href="https://developers.google.com/identity/protocols/OAuth2" target="_blank" >}}OAuth2 com Google Apps{{< /anchor >}};
- {{< anchor href="https://developers.google.com/oauthplayground/" target="_blank" >}}Playground de experimentação com OAuth2 para os serviços do Google{{< /anchor >}};
- {{< anchor href="https://developers.google.com/apis-explorer/#p/" target="_blank" >}}Lista de endpoints e testes de chamadas as APIs do Google{{< /anchor >}}.

Bora automatizar!
