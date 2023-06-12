---
title: 'Uma introdução ao Google Apps Script'
author: henriquesouza
publishDate: 2017-11-20 15:05:00
lastMod: 2021-10-18 15:05:00
summary: Em um post anterior falei brevemente sobre o Google Apps Script, uma ferramenta capaz de enriquecer as funcionalidades dos demais aplicativos do Google. Neste post, farei sua apresentação formal e vou mostrar como utilizá-la para automatizar tarefas de coleta e tratamento de dados.
description: Conheça os fundamentos do Google Apps Script e saiba como utilizar esta ferramenta para automatizar tarefas.
image_description: 'Página inicial do site do Google Apps Script.'
categories:
- Automação
featured: true
---

Publicado em 20/11/2017 e atualizado em 18/10/2021.

Atualização 18/10/2021: na data de atualização deste post, é possível utilizar recursos da epecificação ES6 da linguagem Javascript para escrever scripts no Google Apps Script.

Usei o Google Apps Script pela primeira vez quando precisei trazer dados de fontes externas para dentro de uma planilha que estava no Google Sheets. O trabalho que fiz foi parecido com o que descrevi no {{< anchor href="/stories/geracao-de-relatorios-automatizados-por-apis/" >}}post anterior{{< /anchor >}}: consumir os dados pra tratar e alimentar as células corretas na planilha. Meu interesse na ferramenta me levou a estudá-la mais a fundo para saber o que mais é possível realizar. Acabei descobrindo umas coisas bem legais e úteis que irei compartilhar neste post.

## O Google Apps Script

A ferramenta nada mais é do que um editor de scripts que utiliza uma linguagem baseada em Javascript. Com ela, é possível criar aplicativos que são executados junto aos produtos nativos do Google, tornando os produtos do Google ainda mais personalizados para cada tipo de necessidade. Quem já está acostumado a trabalhar com Javascript ou linguagens similares não precisam aprender uma nova linguagem para começar a trabalhar com o Google Apps Script. A diferença do Javascript usado dentro do Google Apps Script é que ele possui diversas classes já implementadas para manipular outros aplicativos do Google, e auxiliadores para realizar tarefas como chamadas a documentos externos ou formatar datas.

Além de modificar conteúdo dentro de documentos criados em aplicativos como o Google Docs, o Google Spreadsheets ou o Google Slides, os scripts permitem fazer uma infinidade de coisas, como criar novos menus dentro dos documentos, disparar e-mails pelo Gmail, criar e organizar documentos no Drive, consumir APIs como a do Google Maps e construir workflows inteiros, para citar apenas alguns de seus recursos. Dentro da documentação da ferramenta há uma página dedicada a {{< anchor href="https://developers.google.com/apps-script/guides/support/case-studies" target="_blank" >}}cases{{< /anchor >}} feitos por usuários.

## Como usar o Google Apps Script

Essencialmente há duas formas de criar scripts com a ferramenta: criar o script vinculado a um documento do Google existente no Drive ou criar um script sem associação a documentos.

### Scripts vinculados a documentos

Scripts que já nascem vinculados a determinados documentos possuem permissão total para trabalhar com o documento ao qual estão associados. Uma vez vinculado, o script não pode ser desvinculado do documento. Para criar um script vinculado a um documento basta abrir o menu Ferramentas > Editor de scripts.

{{< image src="images/figure1-script-editor-menu-open.webp" alt="Planilha aberta com menu apontado para a opção Script Editor." caption="Planilha aberta com menu apontado para a opção Script Editor. Fonte: Autor." title="Planilha aberta com menu apontado para a opção Script Editor." lazy="true" >}}

Uma vez aberto, o editor de scripts irá carregar com um arquivo em branco chamado Code.gs criado.

{{< image src="images/figure2-script-editor-main-screen-opened.webp" alt="Tela inicial do editor de scripts aberto em 2017." caption="Tela inicial do editor de scripts aberto em 2017. Fonte: Autor." title="Tela inicial do editor de scripts aberto em 2017." lazy="true" >}}

A interface do painel é a mesma independente de o documento criado estar vinculado a um documento ou não. O painel lateral esquerdo mostra os arquivos que fazem parte do projeto e a porção direita contém o conteúdo do arquivo que está sendo usado no momento. No caso do arquivo Code.gs há apenas uma função pré definida chamada myFunction. É necessário informar na ferramenta qual a função que deve ser chamada no momento da execução do script, o que deve ser feito no menu Executar > Executar função > Nome da função, onde nome da função é a função que está definida dentro do arquivo que irá rodar.

{{< image src="images/figure3-script-editor-run-function.webp" alt="Editor de scripts com o menu aberto Run > Run Function > My Function em 2017." caption="Editor de scripts com o menu aberto Run > Run Function > My Function em 2017. Fonte: Autor." title="Editor de scripts com o menu aberto Run > Run Function > My Function em 2017." lazy="true" >}}

Para visualizar qualquer saída que o script gerou basta visualizar o log do console.

{{< image src="images/figure4-script-editor-executions-logged.webp" alt="Janela popup de logs aberta em 2017." caption="Janela popup de logs aberta em 2017. Fonte: Autor." title="Janela popup de logs aberta em 2017." lazy="true" >}}

Este log é diferente do log de execução. Enquanto o log de execução registra as saídas da execução do script o log do console registra dados enviados pelo usuário e exceções de execução de funções. Para enviar dados ao log, seja para testar uma saída por exemplo, use:

{{< highlight javascript >}}
Logger.log("Hello World!");
{{< /highlight >}}

{{< image src="images/figure5-script-editor-log-window.webp" alt="Janela popup de logs exibindo mensagem do usuário em 2017." caption="Janela popup de logs exibindo mensagem do usuário em 2017. Fonte: Autor." title="Janela popup de logs exibindo mensagem do usuário em 2017." lazy="true" >}}

Outra funcionalidade interessante do Google Apps Script é configurar os chamados gatilhos (*triggers*), que ficam a espera de um determinado evento para executar uma ação associada a ele. Gatilhos podem ser de duas categorias: temporais e com base em evento. Gatilhos temporais disparam periodicamente, sendo o período determinado pelo usuário, e gatilhos baseados em evento disparam quando determinado evento ocorre. Alguns destes gatilhos com base em evento são:

{{< highlight javascript >}}
function onEdit(e) {
  // TODO
}

function onChange(e) {
  // TODO
}

function onOpen(e) {
  // TODO
}
{{< /highlight >}}

Gatilhos baseados em evento são implementados como funções, e o código dentro destas funções é executado quando o evento ocorre. Uma aplicação prática no Google Spreadsheets, por exemplo, é dar uma resposta para usuários após certas alterações em planilhas. Considere o exemplo:

{{< highlight javascript >}}
function onEdit(e) {
  if (e.range.getA1Notation() == "L8") {
    var sheet = SpreadsheetApp.getActiveSheet();
    sheet.getRange("L9").setValue(e.oldValue);
  }
}
{{< /highlight >}}

Esta função escuta o evento de edição em qualquer célula da planilha a qual está associada, verifica se a célula alterada é a da posição L8 e então atualiza outra célula com base na edição, inserindo o valor que a célula continha antes da modificação.

{{< image src="images/figure6-dynamically-loaded-data.webp" alt="Planilha com dados financeiros sendo atualizada automaticamente." caption="O valor da célula L9 é atualizado com base no valor da célula L8. Fonte: Autor." title="O valor da célula L9 na aba ativa é atualizado com base no valor da célula L8." lazy="true" >}}

O outro tipo de gatilho, baseado em tempo, pode ser configurado pelo menu *Triggers*, que possui um símbolo de relógio. Você deve configurar se o gatilho vai ser executado ao abrir ou ao editar o arquivo, e configurar o intervalo de tempo para a execução do script.

Há muitas outras possibilidades de uso para o Google Apps Script. Imagine que você tenha um documento com uma lista de contatos armazenada no Drive. Você pode criar um script para capturar os contatos dessa lista, cadastrar no Google Contacts e então disparar um e-mail para a base pelo Gmail. Se o procedimento deve ser feito com certa frequência, um gatilho configurado é o suficiente para ter esse processo automatizado.

### Scripts sem vinculação a documentos

As possibilidades de uso de scripts sem vinculação a documentos são similares as de scripts vinculados. Diferente dos primeiros, eles aparecerão no Drive como arquivos e podem ser usados para criar Web Apps ou servir de utilitários, como um automatizador de tarefas. Um exemplo seria organizar novos arquivos que entram no Drive em uma determinada pasta ou com determinado nome.

## Web Apps

Scripts podem ser publicados na internet, com um endereço único de acesso. Isso é útil quando o script precisa receber dados de outros sistemas. Para ser publicado na internet e se tornar um web app, o projeto deve conter ao menos um script com duas funções declaradas:

{{< highlight javascript >}}
function doGet(e) {
  // TODO
  // Retornar objeto do tipo HtmlOutput ou TextOutput
}

function doPost(e) {
  // TODO
}
{{< /highlight >}}

O retorno da função doGet deve ser um objeto contendo HTML ou texto e ser do tipo HtmlOutput ou TextOutput. Para interagir com o script via uma aplicação web, basta publicar esse script como um web app com as devidas permissões de acesso, acessar seu endereço e passar os dados que serão manipulados pelo script.

## Recursos adicionais

Essas são apenas algumas das funcionalidades do Google Apps Script. Minha sugestão é que você coloque o {{< anchor href="https://developers.google.com/apps-script/" target="_blank" >}}site da documentação{{< /anchor >}} nos seus favoritos pois você fará muito uso dela. No link de {{< anchor href="https://developers.google.com/apps-script/overview" target="_blank" >}}guias{{< /anchor >}} há projetos de fácil execução para quem já quer colocar a mão na massa, e aprender fazendo, na seção "5-Minute Quickstarts". Na seção de {{< anchor href="https://developers.google.com/apps-script/support" target="_blank" >}}suporte{{< /anchor >}} há links para perguntas feitas no Stack Overflow e outros recursos.

Bora automatizar!
