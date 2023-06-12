---
title: 'Configurando Metabase e PostgreSQL no Docker'
author: henriquesouza
publishDate: 2020-11-17 09:10:00
lastMod: 2021-11-20 09:10:00
summary: 'Como elaborar uma arquitetura de serviços simples, de fácil manutenção e portátil utilizando o Docker? Ao longo deste post, você vai descobrir como fazer isso integrando um banco de dados PostgreSQL ao Metabase'
description: 'Configurando Metabase e PostgreSQL no Docker'
image_description: 'Logotipos do Metabase, PostgreSQL e Docker'
categories:
- Automação
featured: true
---

Publicado em 17/11/2020 e atualizado em 20/11/2021.

## Isolamento de ambientes com Docker

Uma infraestrutura que escale conforme a demanda é essencial para qualquer produto digital que tenha alcance. Capacidade de escala depende de muitas coisas, que variam de especificações técnicas da máquina escolhida a arquitetura de serviços configurada. Uma destas variáveis, tópico deste post, é a configuração de ambientes. Um ambiente bem configurado é fácil de manter e de ajustar, ajudando a evitar — ou a diminuir o impacto — de uma manutenção, seja ela programada ou não.

Você possivelmente já viu este problema: um mesmo software é desenvolvido em uma máquina, armazenado em um repositório em outra máquina, copiado e modificado em outras cinco máquinas de pessoas desenvolvedoras, unificado no repositório, levado para outra máquina em um ambiente de validação e depois para mais uma máquina em um ambiente de produção. São muitas as máquinas, diversas as configurações e possivelmente o software que funcionou em algumas destas máquinas não funcionará em outras. Horas de pessoas desenvolvedoras são investidas na correção de erros descobertos após o deploy, até descobrir que bastava alterar a versão da linguagem de programação ou do banco de dados utilizada na máquina de produção. Problema resolvido, é hora de espelhar esta mesma configuração em todas as máquinas envolvidas no desenvolvimento. Acontece que o software passará a utilizar uma nova dependência, que requer uma determinada configuração no ambiente onde estará hospedada. Se todas as máquinas envolvidas no processo também não estiverem com esta mesma configuração, a aplicação não funcionará como o esperado, e mais horas de pessoas desenvolvedoras serão investidas para corrigir o problema.

É para resolver problemas como este que existe o **Docker**, um gerenciador de contêineres. Um contêiner é um local isolado. O isolamento é alcançado ao garantir que, dentro deste ambiente, todas as ferramentas necessárias para o funcionamento da aplicação estejam à disposição, nas versões necessárias. O Docker possui arquivos de configuração chamados **Dockerfiles**, que determinam as configurações de cada ambiente. Estes arquivos são portáteis, o que permite que sejam carregados em diferentes máquinas para criar ambientes idênticos em máquinas com configurações diferentes.

Vamos explorar o Docker, um exemplo de Dockerfile e descobrir como gerenciar mais de um contêiner, ou ambiente.

## Instalação do Docker

A primeira coisa a ser feita é instalar o Docker no seu computador. O download do Docker pode ser feito pelo {{< anchor href="https://www.docker.com/" target="_blank" >}}site oficial{{< /anchor >}}. Uma vez que o Docker estiver instalado, abra um console e digite o seguinte comando (caso esteja utilizando ambiente Linux, pode ser necessário utilizar o comando sudo para dar as permissões devidas ao Docker):

{{< highlight bash >}}
docker --version
{{< /highlight >}}

Se o Docker estiver instalado, você verá na tela qual a versão do Docker que está instalada. O passo seguinte é instalar o {{< anchor href="https://docs.docker.com/compose/install/" target="_blank" >}}Docker Compose{{< /anchor >}}, um utilitário para o Docker que facilita a gestão de múltiplos contêineres. Faça o download e a instalação do Docker Compose no seu computador. Em seguida, abra um terminal e digite o comando:

{{< highlight bash >}}
docker-compose --version
{{< /highlight >}}

Se o Docker Compose estiver instalado, você verá na tela qual a versão do Docker Compose que está instalada.

{{< image src="images/figure1-docker-and-docker-compose-installed.webp" alt="Versões do Docker e Docker Compose instaladas na minha máquina." caption="Versões do Docker e Docker Compose instaladas na minha máquina. Fonte: Autor." title="Versões do Docker e Docker Compose instaladas na minha máquina." lazy="true" >}}

## Download das imagens

Agora que o Docker está instalado na máquina, podemos criar os contêineres que utilizaremos neste tutorial: um com o {{< anchor href="https://www.metabase.com/" target="_blank" >}}Metabase{{< /anchor >}} instalado e outro com o {{< anchor href="https://www.postgresql.org/" target="_blank" >}}PostgreSQL{{< /anchor >}}.

Além de garantir um ambiente controlado para hospedagem de softwares, outra grande vantagem do Docker é sua portabilidade. Você pode criar as configurações do seu ambiente e compartilhar com outras pessoas para que elas não precisem fazer este mesmo trabalho do zero. Isto é tão comum na comunidade Docker que existe até um repositório com modelos de ambientes prontos para serem utilizados, chamado {{< anchor href="https://hub.docker.com/" target="_blank" >}}Docker Hub{{< /anchor >}}. Estes modelos de ambientes se chamam **imagens**. Uma imagem contém todos os arquivos e ferramentas necessárias para que o ambiente funcione de forma isolada. Imagens são como uma planta de uma casa, enquanto a casa é o contêiner. É com base na imagem que o contêiner é gerado. Há imagens oficiais de aplicações conhecidas como WordPress, MySQL ou Node.js e há imagens que foram criadas por pessoas da comunidade Docker.

Vamos utilizar duas imagens: a do {{< anchor href="https://hub.docker.com/r/metabase/metabase" target="_blank" >}}Metabase{{< /anchor >}} e a do {{< anchor href="https://hub.docker.com/_/postgres" target="_blank" >}}PostgreSQL{{< /anchor >}}. É necessário baixar estas imagens do Docker Hub. Para baixar a imagem do PostgreSQL, abra um terminal e digite o seguinte comando:

{{< highlight bash >}}
docker pull postgres
{{< /highlight >}}

Você pode acompanhar o progresso do download pelo próprio terminal. Ao finalizar, baixe a imagem do Metabase digitando o seguinte comando:

{{< highlight bash >}}
docker pull metabase/metabase
{{< /highlight >}}

Cada imagem disponível no Docker Hub possui uma versão, e a versão mais recente é identificada por uma tag chamada latest. É esta versão que é baixada por padrão quando não há especificação de qual versão utilizar. Você pode precisar de versões diferentes para aplicações que requerem certas versões de determinado software. A ferramenta de automação de marketing open source {{< anchor href="https://www.mautic.org/" >}}Mautic{{< /anchor >}} é um exemplo de tal ferramenta, que na data de escrita deste post não funciona com PHP 7.3 ou superior, sendo necessário utilizar a versão 7.2. A página de cada imagem no Docker Hub contém instruções de como baixar a imagem na última versão ou escolher uma versão específica.

Com as imagens disponíveis na máquina, é hora de configurar os contêineres.

## Criação de um contêiner

Para utilizar as imagens é necessário informar ao Docker como elas serão utilizadas. Você pode usar cada imagem da forma como ela foi baixada do repositório ou fazer modificações antes de gerar o contêiner. Ao utilizar a imagem da forma como ela foi baixada, o Docker saberá o que precisa fazer e você já pode gerar um contêiner. Para criar um contêiner utilizando a imagem do Metabase, por exemplo, basta rodar o comando:

{{< highlight bash >}}
docker run -p 3000:3000 metabase/metabase
{{< /highlight >}}

O comando run cria um novo contêiner com os argumentos passados, sendo o único obrigatório o nome da imagem que será usada para gerar o contêiner. Para que o Metabase seja acessível, é necessário mapear uma porta da máquina para uma porta do contêiner. Isto é feito com a *flag* “p”. A primeira porta especificada é a da sua máquina e a segunda é a do contêiner, separadas por dois pontos (:). **Verifique se a porta 3000 no seu computador está livre, caso contrário utilize uma porta livre**.

Por padrão, o contêiner do Metabase expõe a porta 3000. Abra um navegador e digite localhost:3000. Você verá a tela de configurações iniciais do Metabase. Como vamos utilizar o Metabase em conjunto com o PostgreSQL, finalize a conexão entre o terminal e o contêiner entrando no terminal e forçando a parada pelo atalho CTRL + C. Esta parada apenas desliga a conexão direta entre o terminal e o contêiner, mas o contêiner ainda está rodando. Ele precisa ser parado para que a porta 3000 fique livre. Para isto, vamos listar os contêineres em execução com o comando:

{{< highlight bash >}}
docker ps
{{< /highlight >}}

Veja no terminal que a última coluna é a coluna nome. Nesta coluna está a identificação de cada contêiner criado, e estes nomes são gerados automaticamente se não forem especificados. Cada vez que você gerar um novo contêiner, o Docker dará um nome aleatório para o contêiner. Você pode especificar o nome usando a *flag* “name”. Por hora, pare a execução do contêiner com o comando:

{{< highlight bash >}}
docker stop nome_do_container
{{< /highlight >}}

Onde nome_do_container é o nome que o Docker deu para o contêiner recém gerado, que é diferente do nome da imagem.

## Criação de um Dockerfile

Você pode modificar uma imagem baixada de um repositório ou criar uma imagem do zero. Para isto, precisará criar um arquivo chamado **Dockerfile** e fazer as devidas configurações nele. Ao finalizar as configurações, você deverá informar ao Docker como encontrar este arquivo e rodar os comandos que irão construir uma nova imagem.

Para criar uma nova imagem, crie uma pasta em qualquer diretório no seu computador e, em seguida, abra um bloco de notas. Com o bloco de notas aberto, digite as seguintes linhas:

{{< highlight dockerfile >}}
FROM metabase/metabase:latest
LABEL Description="This is a custom build based on the official Metabase image."
{{< /highlight >}}

Salve o arquivo no diretório criado com o nome Dockerfile. Este arquivo Dockerfile possui apenas duas instruções:

- Utilizar a imagem base do Metabase em sua versão mais recente (caso a imagem não tivesse sido baixada anteriormente, o Docker tentaria baixar a imagem do repositório);
- Descreve o ambiente.

Há muitos outros comandos que podem ser utilizados no Dockerfile, úteis para fazer coisas como adicionar outras dependências ao ambiente. A lista completa de comandos pode ser acessada na {{< anchor href="https://docs.docker.com/engine/reference/builder/" target="_blank" >}}documentação oficial do Docker{{< /anchor >}}.

Abra um terminal e digite os seguintes comandos, lembrando de adaptar o código para que o diretório seja o diretório onde está o arquivo Dockerfile:

{{< highlight bash >}}
cd /path/to/Dockerfile
docker build --tag latest metabase_sandbox .
{{< /highlight >}}

Fazendo a inspeção deste código:

- O comando cd navega pela estrutura de pastas e arquivos do sistema. O caminho a ser digitado deve ser o caminho para chegar até o Dockerfile recém criado;
- O comando build cria uma nova imagem com base na imagem especificada no Dockerfile. A *flag* “tag” informa que uma tag chamada latest deve ser colocada na imagem, o nome da imagem será metabase_sandbox e o caminho para o Dockerfile é o diretório atual (note o ponto final após o nome da imagem, separado por um espaço. Se o Dockerfile estivesse em outro diretório o ponto seria substituído pelo caminho do Dockerfile).

Você pode acompanhar cada etapa de criação da imagem no terminal. Ao final da execução, rode o seguinte comando no terminal:

{{< highlight bash >}}
docker image ls
{{< /highlight >}}

Todas as imagens que você possui em seu computador serão mostradas no terminal, incluindo a recém criada, chamada metabase_sandbox. Teste esta nova imagem executando o comando:

{{< highlight bash >}}
docker run -p 3000:3000 metabase_sandbox
{{< /highlight >}}

O resultado deve ser o mesmo de quando você criou um contêiner com base na imagem original. Abra um navegador e digite localhost:3000. A mesma tela de configurações do Metabase irá aparecer.

Encerre a conexão do terminal com o contêiner utilizando CTRL + C. Todas as imagens e contêineres que são criados consomem espaço no computador e você pode economizar espaço ao eliminar tudo o que não vai mais usar. Para fazer esta limpeza, comece digitando o seguinte comando:

{{< highlight bash >}}
docker ps -a
{{< /highlight >}}

O comando ps vai mostrar todos os contêineres criados, e a *flag* “a” vai mostrar também os contêineres que não estão sendo executados no momento. Para excluir o contêiner recém criado rode o comando:

{{< highlight bash >}}
docker rm nome_do_container
{{< /highlight >}}

Sendo nome_do_container o nome que o Docker determina automaticamente após sua criação ou o nome que você especificou pela *flag* “name” no comando run. O contêiner será excluído do sistema. Você pode comandar a exclusão automática de um contêiner dentro do comando run, utilizando a *flag* “rm”. Desta forma, o contêiner será automaticamente excluído assim que sua execução for finalizada.

Exclua também a imagem metabase_sandbox. Para isso, com todos os contêineres que utilizam esta imagem desativados, rode o seguinte comando:

{{< highlight bash >}}
docker image rm metabase_sandbox
{{< /highlight >}}

Você pode verificar que a imagem não existe mais ao rodar o comando:

{{< highlight bash >}}
docker image ls
{{< /highlight >}}

O Dockerfile é necessário para customizar uma imagem existente ou criar uma do zero, mas e quando precisamos de mais de um serviço e estes serviços possuem dependências entre si?

## Múltiplos contêineres no Docker com Docker Compose

Existem ferramentas desenhadas especificamente para trabalhar com a gestão de diversos contêineres em Docker. Vamos utilizar uma ferramenta com estas características para centralizar toda a configuração do ambiente em um único local, e esta ferramenta é o **Docker Compose**. O Docker Compose utiliza um único arquivo para fazer toda a configuração dos contêineres, e cada contêiner pode ter seu Dockerfile se for necessário. Este arquivo utilizado pelo Docker Compose se chama **docker-compose.yml**. O arquivo é escrito em {{< anchor href="https://en.wikipedia.org/wiki/YAML" target="_blank" >}}yaml{{< /anchor >}}. Vamos criar este arquivo no mesmo diretório onde está o Dockerfile criado anteriormente. Entre neste diretório e crie um novo arquivo de texto com este código:

{{< highlight yaml >}}
version: "3.8"

services:
	db:
    		image: postgres
    		container_name: postgresql_metabase
    		restart: always
    		environment:
        		POSTGRES_DB: metabase
        		POSTGRES_USER: metabase
        		POSTGRES_PASSWORD: db_password
    		volumes:
        		- db_data:/var/lib/postgresql/data
    		ports:
      	  	- 5432:5432

	dataviz:
    		image: metabase/metabase
    		container_name: metabase
    		restart: always
    		environment:
     	   	MB_DB_TYPE: postgres
       	 	MB_DB_DBNAME: metabase
       	 	MB_DB_PORT: 5432
        		MB_DB_USER: metabase
        		MB_DB_PASS: db_password
       	 	MB_DB_HOST: db
       	 	MB_DB_FILE: /metabase-data/metabase.db
    		depends_on:
      	  	- db
    		volumes:
       	 	- dataviz_data:/metabase-data
    		ports:
       	 	- 3000:3000

volumes:
	db_data:
	dataviz_data:
{{< /highlight >}}

Há uma série de configurações neste arquivo. Todas estas configurações poderiam ter sido feitas em Dockerfiles separadamente, com exceção da especificação de relação entre os dois contêineres. O que este arquivo está fazendo:

- Especifica que a versão da linguagem a ser usada no arquivo é a 3.8. Todo arquivo docker-compose.yml deve ter especificado na primeira linha a versão a ser usada. A mais recente na data de escrita deste post é a 3.8;
- Cria dois serviços: um chamado db e outro chamado dataviz. Serviços neste contexto são contêineres e suas respectivas configurações;
- Cria dois **volumes**, repositórios que gravam os dados gerados dentro de contêineres. Sempre que um contêiner é finalizado, os dados gerados são perdidos e os volumes evitam que isso aconteça. Estes volumes foram apenas declarados. Na definição de cada serviço, os volumes serão utilizados para mapear diretórios na máquina e no contêiner, para que arquivos sejam compartilhados entre o contêiner e a máquina. O Docker possui um diretório padrão para armazenar volumes, mas você pode utilizar qualquer outro diretório no computador. É importante lembrar apenas que volumes com diretório declarado vão depender da existência deste diretório em quaisquer máquinas que o docker-compose.yml for instalado, caso contrário a criação dos contêineres resultará em erro.

Cada serviço possui diversas configurações. O serviço db:

- Utiliza a imagem Postgres. Como não há especificação de versão, a versão mais recente é assumida. O contêiner recebe o nome postgresql_metabase e está configurado para ser destruído sempre que sua execução for finalizada;
- Três variáveis de ambiente são definidas. Uma das diversas opções na criação de imagens é a especificação de variáveis de ambiente, que podem ser modificadas. A imagem do Postgres possui diversas variáveis, e três delas são preenchidas na criação do contêiner: POSTGRES_DB, POSTGRES_USER e POSTGRES_PASSWORD. Estas variáveis serão usadas para criar um banco de dados padrão, um usuário e uma senha padrão respectivamente. Estas credenciais de acesso serão usadas no Metabase em um segundo momento para estabelecer a conexão com o banco de dados;
- O volume db_data é sincronizado com o diretório que contém os bancos de dados no PostgreSQL;
- A porta 5432 é exposta tanto na máquina quanto no contêiner para acesso ao banco de dados.

E o serviço dataviz:

- Utiliza a imagem do Metabase baixada anteriormente;
- Especifica que o nome do contêiner será metabase;
- Informa que o contêiner deve ser excluído quando sua execução for finalizada;
- Especifica diversas variáveis de ambiente que são exclusivas para o ambiente do Metabase. Estas variáveis informam ao Metabase onde está o banco de dados, quais as credenciais de acesso e onde, dentro do contêiner, será gravado o arquivo de dados gerado pelo Metabase, na variável de ambiente MB_DB_FILE;
- Especifica que o contêiner depende do serviço db. O Docker deve iniciar primeiro o contêiner postgresql_metabase antes de iniciar o contêiner metabase;
- Declara um volume para armazenar o conteúdo da pasta onde estará o banco de dados do Metabase;
- Expõe a porta 3000 na máquina e no contêiner.

Salve o arquivo com o nome docker-compose.yml. Repare que em nenhum momento utilizamos o Dockerfile criado anteriormente, mas é possível especificar o endereço dele no docker-compose.yml caso seja necessário personalizar a imagem. Vamos utilizar as imagens padrão, configurando apenas as variáveis de ambiente de cada contêiner, os volumes para especificação dos dados que não devem ser perdidos ao término da execução do contêiner e o relacionamento entre os contêineres.

Abra o terminal e, no diretório em que o arquivo docker-compose.yml se encontra, digite o seguinte comando:

{{< highlight bash >}}
docker-compose up
{{< /highlight >}}

Ao rodar o comando, os dois contêineres iniciaram. Entre no endereço localhost:3000 e inicie o processo de configuração do Metabase. Ao configurar o banco de dados, selecione a opção outros e digite os dados do banco que foram especificados nas variáveis de ambiente do Metabase e do PostgreSQL. No campo host basta digitar o nome do serviço criado no docker-compose.yml, com nome db. Finalize a criação e, na tela principal do Metabase, você deverá ver um banco de dados com algumas tabelas criadas ao lado do banco de dados padrão.

{{< image src="images/figure2-metabase-home-page.webp" alt="Banco de dados Metabase, criado no PostgreSQL, conectado ao Metabase." caption="Banco de dados Metabase, criado no PostgreSQL, conectado ao Metabase. Fonte: Autor." title="Banco de dados Metabase, criado no PostgreSQL, conectado ao Metabase." lazy="true" >}}

## Considerações

Esta é uma arquitetura simples com dois contêineres, mas uma arquitetura pode ter dezenas ou centenas de serviços que se relacionam entre si para fazer com que um produto funcione, conforme a necessidade de cada empresa. Mesmo uma arquitetura como esta poderia ter sido construída de outras formas. Recomendo a leitura das documentações do {{< anchor href="https://docs.docker.com/" target="_blank" >}}Docker{{< /anchor >}} e do {{< anchor href="https://docs.docker.com/compose/" target="_blank" >}}Docker Compose{{< /anchor >}} para explorar as possibilidades de configuração dos contêineres.

Infraestruturas com muitas máquinas e diversas aplicações em ambientes distribuídos usam ferramentas como {{< anchor href="https://kubernetes.io/" target="_blank" >}}Kubernetes{{< /anchor >}}, desenhadas para este cenário.

Bora configurar ambientes!
