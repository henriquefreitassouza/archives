# Dash

Tema criado para o CMS Grav com foco na construção de blogs. Com uma interface que prioriza poucos elementos simultâneos, o tema suporta páginas de blog e de captura. Os seguintes tipos de página estão disponíveis:

- Post
- Listagem
- Modular
- Busca
- Categoria

Os tipos Busca e Categoria não fazem parte da estrutura padrão do Grav.

## Como utilizar a página de blog?

Ao criar uma nova página basta definir, no painel de administração ou pelo nome do arquivo, que o template a ser usado é o blog. Não é necessário fazer nenhuma configuração adicionais uma vez que o template é selecionado.

Nesta versão do tema, utilize o slug **/blog**.

## Como utilizar a página de busca?

Basta criar uma página que utilize o template search. Ao criar links para a página de busca, é necessário passar o parâmetro de busca "q" na URL. Exemplo: "/search?q=roupas".

Nesta versão do tema, utilize o slug **/search**.

## Como utilizar a página de categoria?

Crie uma página que utilize o template category e a taxonomia padrão category. Este template espera que a URL de categoria seja criada no formato /category/minha-categoria e por isso o tema faz a leitura apenas da primeira categoria selecionada para um post. Para fazer com que o Grav entenda que endereços como /category/roupas ou /category/minha-categoria devem fazer uso da página de categoria, é necessário criar uma rota, o que pode ser feito em configurações > site ou editando o arquivo site.yaml. Em ambos os casos, crie uma rota para com a seguinte configuração: **'/category/(.*)':'/category'**. Esta rota irá fazer com que tudo o que vier depois do endereço /category seja válido ao entrar na página de categoria.

Nesta versão do tema, utilize o slug **/category**.
