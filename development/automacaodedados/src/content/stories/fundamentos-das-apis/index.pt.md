---
title: Os fundamentos das APIs
author: henriquesouza
publishDate: 2017-12-12 21:34:00
lastMod: 2021-11-04 21:34:00
summary: APIs são extremamente úteis para automatizar processos e personalizar fluxos de trabalho. Do ponto de vista técnico, contribuem para o desenvolvimento de aplicações distribuídas. Saber trabalhar com APIs é fundamental para criar aplicações que sejam capazes de se comunicar com o mundo exterior.
description: Os fundamentos das APIs
image_description: 'Nuvem de serviços conectados à internet.'
categories:
- Automação
featured: true
---

Publicado em 12/12/2017 e atualizado em 04/11/2021.

O que é uma API? API é a sigla para Application Programming Interface, ou Interface de Programação de Aplicação. APIs são canais para troca de informação entre sistemas. APIs fornecem ou recebem dados de fontes terceiras que projetistas de software podem usar em suas próprias aplicações, como {{< anchor href="/stories/uma-introducao-ao-google-apps-script/" >}}informações sobre filmes{{< /anchor >}}. Apesar de serem conceitos similares, existem algumas diferenças entre APIs e os chamados ***webhooks***, que são notificadores de eventos. Enquanto APIs são explicitamente chamadas por uma aplicação, *webhooks* notificam outros sistemas na ocorrência de determinado evento. Exemplos de *webhooks* são os usados em *gateways* de pagamento. Quando uma pessoa faz uma compra, uma notificação de pagamento é enviada para o lojista, que despacha a mercadoria. Chamadas a *webhooks* podem inclusive ser feitas com APIs.

## O funcionamento das APIs

As principais aplicações de negócio para APIs são **integrar sistemas** e **automatizar processos**. A integração consiste na construção de um fluxo de informação por onde dados trafegam entre dois ou mais pontos e a automação é coletar, processar, armazenar e entregar dados sem intervenção humana. APIs reduzem custos e aumentam o desempenho de operações. *Web services* costumam fazer uso de APIs.

A arquitetura na qual APIs funcionam envolve pelo menos duas entidades: um **cliente**, que solicita informações, e um **servidor**, que entrega as informações solicitadas. A comunicação entre essas entidades acontece por meio de um **protocolo**, que é um conjunto de regras conhecidas por emissores e receptores. Como os dados trafegam pela web, o protocolo usado geralmente é o **HTTP**. Uma requisição feita pelo protocolo HTTP possui quatro partes:

- URL: o endereço do local onde estão os dados;
- Método: a operação que será realizada no servidor. Pode ser GET, POST, PUT, PATCH e DELETE;
- Cabeçalhos: informações adicionais a serem enviadas com os dados;
- Corpo: os dados que serão enviados com a requisição.

E uma resposta possui três partes:

- Código de status: um número com três dígitos que informa o status da operação requisitada pelo cliente, como sucesso ou falha;
- Cabeçalhos: informações adicionais a serem trafegadas com os dados;
- Corpo: os dados que serão trafegados.

Os principais formatos de dados que trafegam por APIs são **XML** e **JSON**.

XML possui uma estrutura similar a HTML:

{{< highlight xml >}}
<pedido>
  <item>
    <nome>Smartphone</nome>
    <preco>899.99</preco>
  </item>
  <item>
    <nome>Smart TV</nome>
    <preco>1299.99</preco>
  </item>
  <total>2199.98</total>
  <status>aguardando pagamento</status>
</pedido>
{{< /highlight >}}

E JSON é bem similar a objetos Javascript:

{{< highlight json >}}
{
  "pedido": {
    "items": [
      {
        "nome": "Smartphone",
        "preco": 899.99
      },
      {
        "nome": "Smart TV",
        "preco": 1299.99
      }
    ],
    "total": "2199.98",
    "status": "aguardando pagamento"
  }
}
{{< /highlight >}}

Além de serem baseadas no protocolo HTTP e usarem formatos de dados já estabelecidos, a forma como APIs são construídas também possuem padrões. Os dois padrões mais conhecidos são **SOAP** e **REST**. Enquanto SOAP é um protocolo, REST é um estilo arquitetural, ou uma forma de organização dos componentes usados na comunicação entre sistemas. {{< anchor href="https://blog.smartbear.com/apis/understanding-soap-and-rest-basics/" target="_blank" >}}As principais diferenças entre os dois{{< /anchor >}} são:

- SOAP pode ser usado com outros protocolos que não o HTTP e usa XML para trafegar dados;
- REST é baseado em HTTP e consegue trabalhar com diferentes formatos de arquivo.

REST é o formato mais usado para construir APIs, pois possui uma curva de aprendizado menor e é mais rápido se comparado ao SOAP.

## Autenticação

Pode ser que seja necessário fornecer credenciais ao servidor ao qual uma API se conecta para estabelecer uma comunicação. A autenticação pode ser feita das seguintes formas:

- Com usuário e senha;
- Com uma chave de autenticação.

A chave de autenticação substitui o uso de usuários e senhas, e é gerada dentro de uma aplicação protegida por credenciais. A forma mais simples de obter tal chave é fazer o login em um aplicativo que possua API e gerar a chave de autenticação. Essa chave pode estar associada a permissões de uso, dependendo da API. A chave pode dar acesso de visualização ou de escrita para determinados dados ou todos eles. Algumas chaves podem ter tempo de validade.

O método de autenticação varia conforme a API. Algumas formas são:

- Enviar as credenciais junto com a URL na forma de um parâmetro;
- Enviar as credenciais dentro do cabeçalho *Authentication*;
- Enviar as credenciais no corpo da requisição;
- Usar o protocolo de autenticação ***OAuth***.

### OAuth

OAuth é uma abreviação para Open Authentication. É um protocolo de autenticação de sistemas cuja especificação é mantida pela {{< anchor href="https://www.ietf.org/" target="_blank" >}}Internet Engineering Task Force{{< /anchor >}}, e na data de escrita deste post está na versão 2 (OAuth2). O protocolo OAuth é utilizado para desenvolver sistemas de autenticação para APIs utilizando padrões de design que hoje são estabelecidos. As etapas de autenticação no protocolo OAuth2 são:

- Uma solicitação de acesso ao sistema é enviada ao servidor;
- A pessoa solicitante é redirecionada para o servidor de autenticação para fornecer usuário e senha;
- Uma vez autenticado, um código de autorização é enviado para a aplicação que fez a solicitação;
- Esse código de autorização é enviado novamente para o servidor junto com uma chave do cliente, que é gerada na aplicação detentora dos dados;
- Uma vez que a combinação de código de autorização e chave do cliente tenha sido aceita pelo servidor, a aplicação recebe um *token* de acesso.

O *token* pode ser usado para manipular os dados da aplicação. Algumas aplicações dão prazo de validade ao token para aumentar a segurança. Quando o token expira, o fluxo de autenticação é reiniciado. *Tokens* também podem conceder permissões específicas para manuseio dos dados pela API.

## Usando uma API

O manuseio da API é feito por meio de **endpoints**, que são URLs que solicitam os dados que serão recuperados, enviados, modificados ou excluídos. Uma chamada a um endpoint como este, por exemplo:

**https://api.servico.com/dados**

Poderia dar um retorno como este:

{{< highlight json >}}
{
  "clientes": [
    {
      "nome": "Miguel",
      "email": "cliente1@servico.com",
      "telefone": "11 4446-9965"
    },
    {
      "nome": "Laura",
      "email": "cliente2@servico.com",
      "telefone": "13 4526-9847"
    }
  ]
}
{{< /highlight >}}

O endpoint se chama "dados" e retorna informações sobre clientes. Esta chamada de exemplo utilizou o método GET. Cada requisição no protocolo HTTP é feita com um destes métodos. O mais comum na internet é o GET, usado para recuperar informações do servidor. Outros métodos utilizados no protocolo HTTP e em APIs são:

- POST: envia dados para o servidor;
- PUT: atualiza informações gravadas no servidor ou insere novas informações, caso não existam;
- PATCH: atualiza informações gravadas no servidor;
- DELETE: exclui dados do servidor.

É importante notar que algumas APIs podem fazer uso do método POST também para fazer a leitura de registros no servidor.

Uma requisição do tipo POST possivelmente vai ter um endpoint similar ao do GET, e em seu corpo serão transmitidos os dados que serão gravados no servidor. Um exemplo de tal requisição usando o {{< anchor href="https://developers.google.com/apps-script/" target="_blank" >}}Google Apps Script{{< /anchor >}} seria:

{{< highlight javascript >}}
  var customer = {
    "nome": "Marcelo",
    "email": "cliente3@servico.com",
    "telefone": "11 9485-6685"
  };

  var options = {
    "method": "post",
    "payload": customer
  };

  response = UrlFetchApp.fetch("https://api.servico.com/dados", options);
{{< /highlight >}}

O objeto *customer* recebe o conteúdo que será enviado no corpo da requisição. O método foi declarado como POST na chave "method" das opções, indicando que se trata de uma operação de envio de informações pelo protocolo HTTP.

APIs são extremamente simples de usar e fornecem uma interface segura para manipulação de dados. Elas são uma ponte que integra os mais variados tipos de serviço e tornam a web mais rica a cada dia. Embora possuam um padrão seguido pela indústria, cada aplicação possui seus detalhes que a diferem das demais. Cada provedor de APIs abertas fornece também uma **documentação**, componente essencial para o entendimento de uma API.

## Leitura complementar

A Zapier possui {{< anchor href="https://zapier.com/learn/apis/" target="_blank" >}}um curso{{< /anchor >}} bem detalhado sobre os fundamentos de APIs, que vai desde o conceito até a forma de implementação em uma aplicação.

Bora integrar e automatizar!
