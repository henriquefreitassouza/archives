---
title: 'Você usa gerenciadores de tags para tudo?'
author: henriquesouza
publishDate: 2019-05-20 20:05:00
lastMod: 2021-11-18 20:05:00
summary: Gerenciadores de tags são uma mão na roda para administrar scripts e evitar conflitos entre times de marketing e desenvolvimento. Todo trecho de código injetado na página está em um mesmo lugar e a manutenção do código fica bem mais simples. Uma belezinha! Agora, o que acontece quando você recebe um visitante em seu site que está usando um bloqueador de anúncios?
description: 'Você usa gerenciadores de tags para tudo?'
image_description: 'Opções do bloqueador de rastreadores Ad Blocker.'
categories:
- Marketing
featured: true
---

Publicado em 20/05/2019 e atualizado em 18/11/2021.

Atualização 18/11/2021: Em Abril de 2021 a Apple lançou o Apple Tracking Transparency (ATT), um recurso que bloqueia tecnologias de rastreio conhecidas e só faz o desbloqueio mediante autorização dos usuários de dispositivos Apple. Tanto o Facebook quanto o Google perderam parte da eficiência que tinham em usar modelos preditivos para inferir comportamentos de consumo sem uma parte destes consumidores. A solução que o Facebook criou para contornar o problema se chama API de Conversões, e é uma forma de enviar para a plataforma de gestão de negócios do Facebook informações comportamentais de usuários em sites e aplicativos utilizando uma API. Esse método dispensa o uso do tradicional *pixel* que é instalado nas páginas do site, geralmente usando um gerenciador de *tags*. Já o Google não sentiu os efeitos da atualização da mesma forma. Meses antes a empresa estava trabalhando na adequação de seus serviços para que atendam as exigências das legislações sobre proteção de dados ao redor do mundo, o que terminou na reescrita do Google Analytics e o lançamento da versão 4. A partir de 14/10/2020 toda nova propriedade criada no Google Analytics passa a utilizar a versão 4, que não tem mais o cookie como fonte primária de coleta de dados, mas faz a coleta de dados de usuários logados em suas contas do Google. Facebook e Google estão apostando na coleta de dados do lado do servidor, e não mais do cliente via scripts injetados em páginas. Possivelmente essa é uma tendência.

Gerenciadores de *tags* são injetores de códigos em páginas de sites. Sua instalação é feita apenas uma vez por pessoas desenvolvedoras e sempre que for necessário adicionar ou retirar certas funcionalidades das páginas, basta fazer o ajuste no gerenciador de *tags*. Por serem muito usados para gerir scripts de ferramentas de rastreamento, alguns bloqueadores de anúncios impedem o carregamento do gerenciador de *tags* -- evitando que quaisquer scripts associados ao gerenciador de *tags* carreguem.

Bloqueadores de anúncios {{< anchor href="https://pagefair.com/blog/2017/adblockreport/" target="_blank" >}}já são parte do cotidiano de pelo menos 10% do tráfego na internet{{< /anchor >}}e há navegadores de internet que já vêm com seus próprios mecanismos de bloqueio de rastreadores — incluindo gerenciadores de *tags* — embutidos.

{{< image src="images/figure1-brave-browser-home-page.webp" alt="O navegador Brave possui conta com o Shield: um bloqueador de rastreadores e cookies que também força o uso do protocolo HTTPS." caption="O navegador Brave possui conta com o Shield: um bloqueador de rastreadores e cookies que também força o uso do protocolo HTTPS. Fonte: Brave." title="O navegador Brave possui conta com o Shield: um bloqueador de rastreadores e cookies que também força o uso do protocolo HTTPS." lazy="true" >}}

— E por quê bloquear *tags*?

Gerenciadores de *tags* acabam sendo o repositório central de scripts de quaisquer natureza, desde widgets de outras ferramentas a rastreadores para campanhas de remarketing em plataformas de mídia paga — alvo dos bloqueadores.

Vou pegar um dos bloqueadores de anúncios mais conhecidos para ilustrar a situação. O Adblock Plus tem um {{< anchor href="https://adblockplus.org/features" target="_blank" >}}recurso chamado EasyPrivacy{{< /anchor >}} cuja função é “bloquear rastreadores”. A função engloba, entre outras ferramentas, gerenciadores de *tags*. Na data de escrita deste post ele é desativado por padrão em novas instalações, mas basta tocar ou clicar em uma caixa de seleção na primeira opção de personalização do *plugin* e pronto! Gerenciadores de *tags* nunca mais!

{{< image src="images/figure2-ad-blocker-plus-settings.webp" alt="A opção Block Additional Tracking, logo na primeira aba das configurações do Adblock Plus." caption="A opção Block Additional Tracking, logo na primeira aba das configurações do Adblock Plus. Fonte: Autor." title="A opção Block Additional Tracking, logo na primeira aba das configurações do Adblock Plus." lazy="true" >}}

Você pode pensar que isso não é grande coisa, afinal a maioria das pessoas não deve ter ideia do que é um bloqueador de anúncios, quem dirá um navegador pensado em privacidade online. Concordo. O que me faz levantar este ponto, no entanto, é que este grupo cresce a cada dia.

## Navegadores e bloqueadores de anúncios

Não é novidade que o {{< anchor href="http://gs.statcounter.com/browser-market-share" target="_blank" >}}Google Chrome é o navegador mais usado por quem acessa a internet, tanto em smartphones quanto em desktops{{< /anchor >}}. Google Chrome, Apple Safari e Mozilla Firefox responderam por 80% do tráfego online em desktops entre Abril de 2018 e Abril de 2019 enquanto Google Chrome e Apple Safari respondem por estes mesmos 80% em dispositivos móveis no mesmo período. Os 20% restantes usam uma infinidade de outros navegadores.

{{< image src="images/figure3-browser-market-share.webp" alt="Navegadores já conhecidos continuam crescendo em uso de forma geral." caption="Navegadores já conhecidos continuam crescendo em uso de forma geral. Fonte: Statcounter." title="Navegadores já conhecidos continuam crescendo em uso de forma geral." lazy="true" >}}

No Brasil, a distância do Google Chrome para outros navegadores é ainda maior. Apenas este navegador responde por cerca de 80% do tráfego entre Abril de 2018 e Abril de 2019.

Dada a estabilidade e o crescimento da adoção dos navegadores mais usados, é difícil que vejamos algum novo competidor com fôlego para abocanhar uma fatia considerável de seu tráfego em um futuro próximo, ainda mais pensado em privacidade.

E bloqueadores de anúncios?

A história é outra quando falamos de bloqueadores de anúncios. {{< anchor href="https://pagefair.com/blog/2017/adblockreport/" target="_blank" >}}Entre 2015 e 2016 a adoção de bloqueadores de anúncios cresceu 30% no mundo todo{{< /anchor >}}. {{< anchor href="https://pagefair.com/blog/2017/adblockreport/" target="_blank" >}}No Brasil, 6% do tráfego usa bloqueadores de anúncios{{< /anchor >}}. A {{< anchor href="https://pagefair.com/blog/2017/adblockreport/" target="_blank" >}}adoção de bloqueadores de anúncios em dispositivos móveis cresce mais rápido ainda{{< /anchor >}}, resultado de {{< anchor href="https://pagefair.com/blog/2017/adblockreport/" target="_blank" >}}parcerias estabelecidas entre fabricantes de bloqueadores de anúncios e fabricantes de smartphones{{< /anchor >}}. Vale notar que boa parte deste crescimento se deu em países asiáticos, {{< anchor href="https://www.ibtimes.com/alibaba-fuels-massive-rise-mobile-ad-blocking-asia-could-us-be-next-2376144" target="_blank" >}}impulsionado pelo navegador da Alibaba, UC Browser{{< /anchor >}}, dando margem para especulações sobre uma possível onda de crescimento no lado ocidental do mundo nos próximos anos.

{{< image src="images/figure4-ad-blocker-usage-worldwide.webp" alt="Adoção de bloqueadores de anúncios ao redor do mundo em Dezembro de 2016." caption="Adoção de bloqueadores de anúncios ao redor do mundo em Dezembro de 2016. Fonte: PageFair." title="Adoção de bloqueadores de anúncios ao redor do mundo em Dezembro de 2016." lazy="true" >}}

Em Fevereiro de 2018, O próprio Google Chrome passou a contar com um bloqueador de anúncios feito pelo Google. A princípio isso parece estranho, dado que a principal fonte de receita do Google vem de publicidade online, mas o bloqueador de anúncios nativo bloqueia {{< anchor href="https://www.businessinsider.com/google-new-chrome-ad-blocker-will-only-block-17-of-ads-2018-1" target="_blank" >}}apenas anúncios que não aderem a um conjunto de normativas definido pela Coallition for Better Ads{{< /anchor >}}, organização da qual o Google faz parte. Este bloqueador não deve interferir com rastreadores ou gerenciadores de *tags*, e é possível imaginar que seu objetivo seja frear o crescimento de *plugins* bloqueadores de anúncios, já que são muito mais “danosos” para empresas que vivem de publicidade online. Precisamos viver por mais alguns anos para saber se o recurso irá desacelerar a adoção de bloqueadores de anúncios de terceiros mundo afora.

## Economia da vigilância 2.0: o anti vírus

Há alguns anos eu encontrava com certa frequência discussões sobre a {{< anchor href="https://duckduckgo.com/?q=anti+virus+companies+create+virus" target="_blank" >}}possibilidade de empresas fabricantes de anti vírus criarem também os males que assombram o mundo digital{{< /anchor >}}. Eu sou o tipo de pessoa que não descarta a possibilidade de alguns *players* no mercado patrocinarem esse tipo de estratégia, embora acredite também que é prática de uma minoria.

Pode ser que eu esteja entrando no curioso mundo das teorias conspiratórias, mas acredito que estamos vendo uma variação deste modelo de negócios em que um agente agressor se apresenta como benfeitor. Ou, como explicarei, um agente inicialmente benfeitor deixa escapar alguns “atos questionáveis” em prol do bem estar digital, minando ainda mais a confiança de pessoas insatisfeitas com a experiência de navegação online dos dias atuais.

O Adblock Plus permite que você adicione a uma “whitelist” os sites cujos anúncios você aceita ver. Esta whitelist já é preenchida com alguns sites que seguem um conjunto de regras definidas pela Acceptable Ads Committee. {{< anchor href="https://arstechnica.com/information-technology/2015/02/over-300-businesses-now-whitelisted-on-adblock-plus-10-pay-to-play/" target="_blank" >}}Em 2015, 10% dos donos dos sites da lista pagaram para estarem lá{{< /anchor >}}. São grandes empresas que, além de terem que se adequar aos padrões exigidos, precisaram remunerar a empresa fabricante do Adblock Plus para estarem na whitelist.

Há padrões de qualidade mesmo para quem paga, o que garante algum conforto na navegação online. De toda forma existe o perigo de a internet ficar ainda mais refém daqueles que podem pagar para fazer com que ela esteja aos conformes de pequenos grupos.

{{< image src="images/figure5-alien-abduction.webp" alt="Nave espacial abduzindo uma pessoa para ilustrar teorias da conspiração." caption="Teorias de conspiração envolvendo sequestros? Só consigo pensar em abduções para ilustrar este tópico. Fonte: Pixabay." title="Teorias de conspiração envolvendo sequestros? Só consigo pensar em abduções para ilustrar este tópico." lazy="true" >}}

Até aqui pode parecer que não há nada que envolva gerenciadores de *tags*, mas lembre-se: o processo de bloquear um gerenciador de *tags* com um bloqueador de anúncios (cujo nome passa a ser bloqueador de rastreadores) é tão simples como tocar ou clicar em uma caixa de seleção. Pessoas insatisfeitas com a experiência de navegação online vão buscar formas de se proteger de ferramentas abusivas. Conforme a demanda por privacidade online cresce, não duvido que *players* vão aparecer com soluções cada vez mais eficientes para bloqueio de anúncios e rastreadores — junto com os contêineres que os abrigam. Estes *players* farão questão de deixar bloqueadores de rastreadores e gerenciadores de *tags* ligados por padrão para vender a ideia de privacidade.

## Nadar contra a maré não irá ajudar

É bem simples encontrar algum {{< anchor href="https://duckduckgo.com/?q=detect+ad+blocker" target="_blank" >}}tutorial ensinando desenvolvedores a detectar bloqueadores de anúncios e rastreadores{{< /anchor >}}. Em sites como portais de notícias, a detecção é usada para exibir mensagens alertando visitantes sobre a importância dos anúncios para a manutenção do portal. Alguns sites não permitem que seus visitantes acessem o conteúdo, outros limitam o acesso por quantidade de visualizações de páginas e há também quem faça apenas o aviso, sem limitar o acesso a conteúdo.

O problema em limitar o acesso a conteúdo é que achar conteúdo similar na internet é bem fácil. Ao encontrar um popup bloqueando acesso a conteúdo, a maioria das pessoas simplesmente vai embora. {{< anchor href="https://pagefair.com/blog/2017/adblockreport/" target="_blank" >}}Três em cada quatro pessoas com um bloqueador de anúncios ligado saem do site quando um popup de ad block as impede de acessar o conteúdo{{< /anchor >}}.

## Não é possível prevenir o futuro, mas é possível abraçá-lo

Visitantes com bloqueadores de rastreadores ligados não vão desativar o bloqueador porque um site está pedindo com carinho. Imagine que a internet é o espaço sideral e os visitantes navegam em espaçonaves e trajes de astronautas. O que muitos sites pedem é para que os visitantes tirem seus trajes, abram as portas da nave e tentem respirar — ou ao menos é essa a ideia que passam.

Ao menos enquanto sites não encontram uma forma justa e não intrusiva de ganhar dinheiro com o tráfego que geram, bloqueadores de anúncios e rastreadores farão parte das vidas de pessoas desenvolvedoras de software e pessoas publicitárias do mundo digital. O que é possível fazer diante deste cenário? **Compartimentalizar ao máximo o que está sendo colocado nas páginas**. Dado que gerenciadores de *tags* podem ser bloqueados pode fazer sentido que sejam usados apenas para incluir scripts relacionados a ferramentas de anúncios, rastreio e estudos comportamentais. E como incluir scripts de widgets e ferramentas necessários para o funcionamento ideal do site? Do jeito antigo: pedindo as amigas e amigos desenvolvedores que os incluam nas páginas, de preferência do lado do servidor. Isso pode até não que um bloqueador de rastreadores trave a execução de alguns scripts, mas se o script não for identificado como sendo um rastreador pelo bloqueador, ele irá executar normalmente — se o Javascript estiver habilitado.

{{< image src="images/figure6-blocked-container-management.webp" alt="Serviço de chat bloqueado em um site que o carrega via Google Tag Manager. Pelo menos teve uma devolutiva." caption="Serviço de chat bloqueado em um site que o carrega via Google Tag Manager. Pelo menos teve uma devolutiva. Fonte: Suporte de uma fintech." title="Serviço de chat bloqueado em um site que o carrega via Google Tag Manager. Pelo menos teve uma devolutiva." lazy="true" >}}

Sim, sites vão continuar perdendo receita para bloqueadores de anúncios e rastreadores, dados comportamentais para melhorar continuamente o que oferecem e até mesmo funcionalidades básicas que são carregadas por widgets de terceiros, como chats. {{< anchor href="/stories/as-pessoas-por-tras-das-personas/" >}}Escrevi certa vez que o ambiente digital carece de confiança{{< /anchor >}} e que só com o cultivo da confiança é que as pessoas vão se abrir para ouvir o que empresas têm a dizer sobre seus super produtos e serviços. Podemos continuar insistindo em detectar quem usa bloqueadores e impedir que façam uso dos sites que construímos, mas não podemos evitar a desconfiança que isso gera. Cada pessoa que sai de um site sem conseguir fazer o que veio fazer leva consigo o potencial de uma relação frutífera para ambas as partes. Por mais que estejamos dando o braço a torcer, a verdade é que o primeiro passo para uma relação de confiança deve vir de quem publica alguma coisa na internet — e não o contrário. Parte deste primeiro passo é aceitar que seus visitantes são desconfiados, pois a vida online os ensinou a ser assim.

Bora criar sites responsáveis — e não só responsivos (não pude me conter).
