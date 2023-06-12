---
title: Geração de relatórios automatizados por APIs
author: henriquesouza
publishDate: 2017-11-19 13:13:00
lastMod: 2021-10-17 13:13:00
summary: Recentemente me envolvi em um projeto em que eu precisava construir um repositório de dados para alimentação de relatórios. As fontes que continham as informações de interesse estavam espalhadas em pelo menos 6 sistemas diferentes e juntar essas informações semanalmente demandava um bom tempo. Este post descreve a solução que encontrei para tornar este tempo mais produtivo.
description: Como utilizar APIs para automatizar a geração de relatórios?
image_description: 'Dashboard sendo apresentado em computador.'
categories:
- Automação
featured: true
---

Publicado em 19/11/2017. Atualizado em 17/10/2021.

Automação é fundamental para escala e ganho de produtividade. Automatizar tarefas com algum grau de repetitividade significa aproveitar melhor o tempo para pensar em questões mais estratégicas ou táticas de um negócio. Uma automação bem feita significa também redução de custos uma vez que é possível escalar cada vez mais rápido com pouco ou nenhum aumento nos custos necessários para manter a operação. Uma mal feita, ao contrário, custa para manter e não escala apropriadamente.

Hoje em dia há centenas de ferramentas de manipulação e visualização de dados para as mais variadas necessidades de negócio. Podemos citar plataformas para gestão de anúncios, CRM, analytics, sistemas administrativos e tantas outras. Acontece que muitas das informações que alimentam tais plataformas precisam ser extraídas e combinadas em diferentes visões para auxiliar tomadores de decisão, e nem sempre há uma integração nativa entre as ferramentas envolvidas. Esse cenário gera inúmeras planilhas e documentos que fazem o meio de campo, carregados com dados de vários sistemas que são baixados e tratados manualmente, portanto, sujeito a falhas humanas e aumento do tempo dedicado a tarefas rotineiras.

Nem sempre a solução é construir um *middleware*. Ela pode ser mais simples e barata. Ela pode até mesmo utilizar estas mesmas planilhas e documentos que fazem o meio de campo. Planilhas são extremamente dinâmicas quanto as possibilidades para ingestão e tratamento de dados. Há muitos casos em que faz sentido manter uma planilha atualizada com certa frequência em prol de construir uma ferramenta, especialmente se o orçamento for baixo. O trabalho que desenvolvi resultou em uma destas planilhas, cujas informações traziam o estado de saúde financeira da organização.

## Automação com APIs

As fontes das quais precisei extrair dados permitem não só a exportação dos dados para planilha, mas também em um formato chamado JSON. O nome é um acrônimo para *Javascript Object Notation*, e esse tipo de arquivo é muito usado para criar comunicações entre sistemas que, a priori, não se entendem. Um exemplo desse formato:

{{< highlight json >}}
{
  "nome": "Adwords",
  "conta": "xpto",
  "gasto_total": "48032.44",
  "impressoes": "188492"
}
{{< /highlight >}}

Cada linha entre as chaves representa um par, em forma de chave e valor. A chave representa um identificador enquanto o valor é o conteúdo da chave. O conjunto de pares entre os símbolos de chave recebe o nome de objeto. Um objeto pode conter vários pares de chaves e valores dentro dele e armazenar até mesmo outros objetos.

O JSON é um formato útil por ser padrão entre diferentes tecnologias. Todas as linguagens de programação mais conhecidas possuem uma forma para enviar e receber objetos JSON pela internet, e por isso é comum que este seja um dos formatos mais adotados para integrar ferramentas. Diversas ferramentas fornecem um serviço capaz de entregar objetos JSON para quem os solicita - geralmente outros sistemas. Este serviço é chamado de API, ou *Application Programming Interface*, uma espécie de ponte que entrega determinados dados conforme solicitado.

## Um exemplo prático de funcionamento de APIs

Imagine que você queira saber as avaliações dadas pela crítica ao filme Batman: O Cavaleiro Das Trevas Retorna. Uma base de dados como a fornecida pela {{< anchor href="http://www.omdbapi.com/" target="_blank" >}}OMDB{{< /anchor >}} possui as informações que você busca e disponibiliza uma API para fazer a consulta. Basta acessar o endereço http://www.omdbapi.com/?apikey=**sua_api_key**&t=Batman+The+Dark+Knight e você terá uma informação como esta:

{{< highlight json >}}
{
  "Title": "Batman: The Dark Knight Returns, Part 1",
  "Year": "2012",
  "Rated": "PG-13",
  "Released": "25 Sep 2012",
  "Genre": "Animation, Action, Adventure",
  "Language": "English",
  "Country": "USA",
  "Awards": "5 nominations.",
  "Metascore": "N/A",
  "imdbRating": "8.0",
  "imdbVotes": "42,023",
}
{{< /highlight >}}

A porção do endereço com o termo "sua_api_key" se refere a autenticação. Toda chamada a API da OMDB deve ser feita com uma chave que identifica a pessoa (ou sistema) que fez a requisição, e apenas usuários verificados podem ver as informações sobre os filmes. Você pode se cadastrar gratuitamente no site da OMDB para receber uma chave de acesso a API. O JSON retornado foi simplificado, mas a avaliação buscada retornou a chave "imdbRating", com o valor 8.0. Talvez você ainda esteja se perguntando qual a utilidade de encontrar essas informações desta forma quando podemos simplesmente acessar o site da IMDB e encontrar a listagem do filme. É aqui que começamos a falar de automação: este trabalho pode ser feito uma única vez e configurado para ser re-executado sempre que você quiser, desta forma o objeto JSON que retorna terá sempre os valores mais recentes a sua disposição. Este pode não ser o melhor exemplo para fazer buscas com certa frequência, mas imagine que estes dados sejam o valor de ações de empresas e que você está montando um quadro de métricas que precisa do valor das ações atualizadas de hora em hora. Basta configurar uma rotina que vai chamar a API do serviço financeiro de hora em hora e buscar o valor mais recente das ações, e assim você não tem que buscar essa informação manualmente sempre que precisar.

## De volta ao projeto de automação

As ferramentas com as quais trabalhei para extrair as informações que precisava possuem APIs com vasta documentação e diversos endereços para puxar dados diferentes. Uma vez que capturei os objetos JSON, o trabalho foi alimentar a fonte, isto é, o local que recebeu e tratou os dados vindos dos sistemas. Esse local, que serviria de fonte para o painel de relatórios, foi uma planilha criada no Google Sheets. O Google Sheets foi escolhido por possuir uma ferramenta de criação de scripts chamada {{< anchor href="https://www.google.com/script/" target="_blank" >}}Google Apps Script{{< /anchor >}}, usada para, entre outras coisas, estender as capacidades padrão das ferramentas do Google. Um dos recursos da ferramenta é se comunicar com outros sistemas pela internet, o que atendeu a expectativa.

Com o editor de scripts aberto, algumas poucas linhas de código já me trouxeram os objetos JSON que precisava:

{{< highlight javascript >}}
var spreadsheet = "https://sheets.google.com/id=spreadsheet1";
var sheet = SpreadsheetApp.openByUrl(spreadsheet).getSheetByName("name");
// Essa chamada irá retornar um JSON como o do exemplo anterior
var url = "http://www.omdbapi.com/?apikey=sua_api_key&t=Batman+The+Dark+Knight";
var response = UrlFetchApp.fetch(url);
var json = JSON.parse(response);
// Como eu só quero a informação de avaliação, seleciono apenas ela dentro do JSON retornado
sheet.getRange("A1").setValue(json.imdbRating);
{{< /highlight >}}

Isso poderia ter sido feito de várias formas, mas o processo é idêntico:

- acessar o endereço;
- capturar o JSON retornado;
- prepará-lo para uso (desserializá-lo);
- escrever os dados recebidos na planilha.

Usei o exemplo do OMDB pois a API é pública, diferente das que eu usei no caso prático.

Para finalizar, o próprio editor de scripts dos aplicativos do Google possui uma opção para definir uma periodicidade para execução dos scripts. Apenas configurei a ferramenta para executar a cada hora e pronto! Construí um sistema de alimentação de dados automatizado. É importante ficar atento a atualizações nas APIs e seus endereços, mas não é todo dia que isso acontece, então você pode se dar ao luxo de concentrar seus esforços e tempo em compreender os dados que estão chegando ao relatório, e não na manutenção dele.
