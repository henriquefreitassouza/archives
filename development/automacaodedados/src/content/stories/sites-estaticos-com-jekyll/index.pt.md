---
title: 'Sites estáticos com Jekyll e Github Pages'
author: henriquesouza
publishDate: 2018-01-01 19:47:00
lastMod: 2021-11-07 19:47:00
summary: Sites são raramente construídos do zero. Há uma infinidade de ferramentas e frameworks que oferecem estruturas prontas para construir e publicar sites na internet. Este post vai apresentar o Jekyll, um gerador de sites estáticos, e como usá-lo em conjunto com o Github Pages para publicar sites sem custo algum.
description: Sites estáticos com Jekyll e Github Pages
image_description: 'Octocat, logo do Github.'
categories:
- Programação
featured: true
---

Publicado em 01/01/2018 e atualizado em 07/11/2021.

Atualização 07/11/2021: este blog foi originalmente construído utilizando as tecnologias apresentadas neste post. Atualmente o gerenciador de sites estáticos utilizado é o {{< anchor href="https://gohugo.io/" target="_blank" >}}Hugo{{< /anchor >}}.

Sistemas gerenciadores de conteúdo (CMS) estão por trás de muitos sites na internet. Apenas o {{< anchor href="https://wordpress.org/" target="_blank" >}}WordPress{{< /anchor >}} é o CMS presente {{< anchor href="https://w3techs.com/technologies/overview/content_management/all" target="_blank" >}}em quase 30% dos sites em toda a internet{{< /anchor >}}, com 60% de *market share*. No total, cerca de 50% de toda a internet funciona com alguma tecnologia de CMS. O que os torna tão populares é a combinação entre facilidade de uso, tecnologia *open source* e temas e plugins prontos para uso. Nem todas as plataformas de CMS são abertas, mas as mais usadas são as que abraçam o conceito de código livre e há uma comunidade de entusiastas dando continuidade aos projetos. Há casos, no entanto, em que o projeto não requer a robustez de um CMS e pode se beneficiar de uma estrutura mais enxuta. Entra o **gerenciador de sites estáticos**.

## Sites estáticos x dinâmicos

Sites dinâmicos geralmente possuem alguma interação com sistemas de bancos de dados e outras fontes de informação. Essas informações alimentam a estrutura do site para entregar conteúdo. Um exemplo de tal dinamismo está nas páginas de produtos de e-commerces. A estrutura da página é a mesma, mas seu conteúdo muda conforme o produto que é selecionado.

Um site estático, por outro lado, não é alimentado por bancos de dados relacionais. Seu conteúdo está todo disponível no HTML que é servido ao navegador.

## Gerenciadores de sites estáticos

Assim como o CMS, um gerenciador de sites estáticos possui estrutura para produzir diferentes tipos de sites, como blogs, portfolios, páginas de captura e até e-commerces. Esses gerenciadores de sites possuem inclusive plugins e temas que permitem a expansão de suas capacidades nativas. Algumas características que os tornam mais atraentes que um CMS são a **simplicidade**, a **velocidade** e o **custo**. Enquanto um CMS precisa de um servidor com alguma tecnologia de interpretação de linguagem back end e um banco de dados instalado, um gerenciador de sites estáticos precisa apenas de um servidor capaz de servir arquivos estáticos. Mesmo que haja alguma transformação nos arquivos servidos, o procedimento é muito mais rápido do que interpretar uma linguagem e consultar um banco de dados para depois servir o arquivo final. A estrutura de um gerenciador de sites estáticos é mais enxuta, o que torna o site mais fácil e barato de manter. Uma desvantagem em relação a um CMS é que conhecimentos em desenvolvimento *front end* ou em *markdown* são necessários para fazer a manutenção do site.

Existem várias tecnologias que geram sites estáticos. A {{< anchor href="https://learn.cloudcannon.com/" target="_blank" >}}Cloud Cannon{{< /anchor >}} montou a lista a seguir com algumas das ferramentas disponíveis:

{{< image src="images/figure1-static-site-generators.webp" alt="Algumas das plataformas que geram sites estáticos." caption="Algumas das plataformas que geram sites estáticos. Fonte: Cloud Cannon." title="Algumas das plataformas que geram sites estáticos." lazy="true" >}}

Estas são apenas algumas. O site {{< anchor href="https://www.staticgen.com/" target="_blank" >}}Static Gen{{< /anchor >}} lista outras dezenas dessas ferramentas. O que elas fazem essencialmente é compilar a estrutura de arquivos e pastas do site em um conjunto de documentos HTML que podem ser hospedados em servidores web. Durante a compilação, quaisquer linguagens de marcação, de templates e outros códigos são transformados em arquivos HTML. Apesar de o conteúdo final ser estático, os arquivos que compõem a versão de desenvolvimento das páginas podem utilizar estruturas típicas de linguagens de programação, como condicionais ou loops.

## Jekyll

Tomei familiaridade com gerenciadores de sites estáticos pelo {{< anchor href="https://jekyllrb.com/" target="_blank" >}}Jekyll{{< /anchor >}}, uma ferramenta com integração nativa com o {{< anchor href="https://pages.github.com/" target="_blank" >}}Github Pages{{< /anchor >}}.

O Jekyll possui um arquivo de configuração chamado **_config.yml**. Nesse arquivo são colocadas variáveis que podem ser referenciadas em quaisquer páginas do site. As variáveis podem receber números, textos, valores condicionais e listas. Essas variáveis são declaradas no formato **chave: valor**. Variáveis também podem receber escopo. Os escopos podem ser global, de aplicação em todo o site, local, de aplicação em páginas específicas, e ainda é possível criar escopos personalizados. Além de criadas no arquivo de configuração, variáveis podem ser declaradas dentro dos cabeçalhos das páginas usando uma notação chamada de **Front Matter**. Declarações em Front Matter são metadados das páginas, e contém instruções para a compilação das páginas nos arquivos finais em HTML. Usando Front Matter, é possível separar configurações globais do site de configurações específicas de cada página. Um exemplo desse tipo de operação é selecionar o layout que irá compor a página criada. Suponha que o cabeçalho e o rodapé de uma página tenham sido criadas em seu próprio arquivo. Dentro de uma página "filha" é possível especificar a variável **layout** com o nome da página de template. O Jekyll irá buscar dentro da pasta de templates pelo nome especificado.

Essa ferramenta é bastante usada para criar blogs e parte da estrutura padrão reflete isso. Um projeto padrão vai conter a seguinte estrutura de pastas:

- **_draft**: contém posts de rascunho;
- **_posts**: contém posts publicados;
- **_layouts**: contém templates utilizados pelas páginas do site;
- **_data**: contém fontes de dados que poder ser usadas para alimentar seções do site;
- **_plugins**: contém arquivos de plugins;
- **_site**: contém os arquivos finais que serão hospedados no servidor.

A linguagem de template padrão usada no Jekyll é a {{< anchor href="http://shopify.github.io/liquid/" target="_blank" >}}Liquid{{< /anchor >}}, criada pela {{< anchor href="https://pt.shopify.com/" target="_blank" >}}Shopify{{< /anchor >}}. De forma geral, há dois tipos de tags usadas em Liquid. Elas são **tags de saída** e **tags de operações**. Uma saída em Liquid é qualquer coisa impressa entre dois pares de chaves:

{{< highlight javascript >}}
{{ valor }}
{{< /highlight >}}

As tags de saída ainda podem receber filtros. A saída é separada do filtro por uma barra vertical, e podem ser aplicados filtros como todas as letras em maiúsculas ou cortar letras, para citar alguns:

{{< highlight javascript >}}
{{ valor | upcase }}
{{< /highlight >}}

Já a tag de operação executa alguma operação lógica, e é escrita com um par de chaves e um par de sinais de porcentagem dentro. A maioria dessas operações possuem início e fim declaradas:

{{< highlight javascript >}}
{% if valor %}
  // TODO
{% endif %}
{{< /highlight >}}

Além de if else e for, a operação include também é usada com esta sintaxe:

{{< highlight javascript >}}
{% include arquivo.html param="valor" %}
{{< /highlight >}}

A operação de inclusão de arquivos não possui tag de fechamento e a passagem de parâmetros é opcional.

Posts em Jekyll são escritos em {{< anchor href="https://daringfireball.net/projects/markdown/" target="_blank" >}}Markdown{{< /anchor >}} por padrão. Um post em Jekyll precisa ter o nome de arquivo seguindo a convenção **ano-mês-dia-nome.md** ou **ano-mês-dia-nome.markdown** sendo ano com 4 dígitos, mês e dia com 2 dígitos. A extensão pode ser md ou markdown. Todo post também precisa ter o Front Matter em seu início:

{{< highlight yaml >}}
---
layout: post
title:  "Hello world!"
date:   2018-01-01 19:47:00
category: geral
---
{{< /highlight >}}

A linguagem utilizada para escrever o Front Matter das páginas chama-se **Yaml**, uma linguagem de serialização de dados usada para criar arquivos de configuração. O que estiver entre os dois conjuntos de três traços será compilado, e o Front Matter não aparece no arquivo final.

O Jekyll ainda conta com {{< anchor href="http://jekyllthemes.org/" target="_blank" >}}temas{{< /anchor >}} e {{< anchor href="https://jekyllrb.com/docs/plugins/" target="_blank" >}}plugins{{< /anchor >}} prontos para uso e mantidos pela comunidade.

## Github Pages

O Github Pages é um servidor de arquivos estáticos hospedado no Github. Ele pode ser usado para hospedar sites e usa o Jekyll como gerenciador de sites estáticos. Não há custo para hospedar um site no Github Pages. Útil para hospedar um portfolio, um blog, ou qualquer outra aplicação que não exige dinamismo. Para usar o Github pages basta criar um repositório com o nome do seu endereço no Git. O meu endereço, por exemplo, é henriquefreitassouza.github.io, então o nome do repositório será henriquefreitassouza.github.io. O caminho completo para o repositório será https://github.com/seuusuario/seuusuario.github.io. O caminho completo para o repositório do meu site é https://github.com/henriquefreitassouza/henriquefreitassouza.github.io. Ao acessar o endereço https://seuusuario.github.io, o conteúdo do repositório será servido como um site.

Como o Github Pages já usa o Jekyll, basta clonar o repositório, criar os arquivos do Jekyll dentro da pasta e enviá-los para o Github uma vez que o desenvolvimento tenha sido finalizado. O projeto é automaticamente compilado e os arquivos do diretório _site (o diretório onde os arquivos finais do projeto são colocados) são servidos pelo Github Pages.

Para deixar ainda mais profissional, o repositório ainda pode ser referenciado por um nome de domínio personalizado. Se você possui um domínio e quiser configurá-lo para apontar para o repositório é bem simples. Nas configurações do repositório há uma opção chamada **domínio customizado** dentro do grupo de opções **Github Pages**. Basta colocar o nome do domínio e salvar que um arquivo CNAME será criado na raiz do projeto. O passo seguinte é configurar os servidores DNS com a empresa onde foi comprado o domínio. Se estiver usando o {{< anchor href="https://registro.br/" target="_blank" >}}registro.br{{< /anchor >}}, basta selecionar o nome do domínio, clicar em **editar zona** e adicionar os endereços do Github com o nome do domínio e tipo **A**. Por fim, o subdomínio www pode ser configurado adicionando uma nova entrada do tipo CNAME com o nome www seguido pelo endereço do seu domínio. Os endereços que o Github fornece para configuração de DNS são **192.30.252.153** e **192.30.252.154**. Pode levar até 24 horas para que as alterações se propaguem.

Um detalhe importante sobre o Github Pages é que qualquer site hospedado por lá é executado com uma configuração chamada de **-\-safe**, o que impede a execução de plugins. Uma opção para contornar tal limitação é compilar os arquivos em sua máquina local e enviar os arquivos já compilados da pasta _site para o Github Pages.

## Leitura complementar

Esse post teve como objetivo apenas introduzir o mundo dos gerenciadores de sites estáticos, não sendo, portanto, um tutorial. Para aprender mais sobre as ferramentas citadas, use as seguintes fontes:

- {{< anchor href="https://learn.cloudcannon.com/" target="_blank" >}}Tutorial completo de Jekyll da Cloud Cannon{{< /anchor >}};
- {{< anchor href="https://pages.github.com/" target="_blank" >}}Como configurar o repositório no Github Pages{{< /anchor >}};
- {{< anchor href="https://jekyllrb.com/" target="_blank" >}}Documentação do Jekyll{{< /anchor >}};
- {{< anchor href="https://willianjusten.com.br/dominio-proprio-no-github-pages/" target="_blank" >}}Configurando domínio próprio do Registro.br no Github Pages{{< /anchor >}};
- {{< anchor href="https://github.com/henriquefreitassouza/henriquefreitassouza.github.io" target="_blank" >}}O meu repositório de sites no Github como exemplo{{< /anchor >}}.

Bora criar sites estáticos!
