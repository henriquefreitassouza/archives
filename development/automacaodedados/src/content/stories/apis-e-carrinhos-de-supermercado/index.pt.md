---
title: 'APIs e carrinhos de supermercado'
author: henriquesouza
publishDate: 2018-07-04 21:20:00
lastMod: 2021-11-08 21:20:00
summary: O que é uma API e para que serve? Este post vai introduzir o conceito sem entrar em aspectos técnicos.
description: APIs e carrinhos de supermercado
image_description: 'Corredor de supermercado.'
categories:
- Automação
featured: true
---

Publicado em 04/07/2018 e atualizado em 08/11/2021.

## Vamos às compras

Não sei você, mas aprendi com minha família a fazer as tais compras do mês: todo começo de mês vou ao supermercado e compro o que vou consumir ao longo daquele mês ~~(e algumas guloseimas saborosas que diminuem minha expectativa de vida)~~. Quando chego no supermercado, a primeira coisa que faço é ir buscar um carrinho. Com carrinho em mãos, passeio pelos corredores do supermercado e vou analisando cuidadosamente os produtos nas gôndolas. Levo na mente uma listinha do que vou comprar, mas gosto de ver o que tem de novo nas gôndolas. Passo setor a setor do supermercado colocando no carrinho os produtos que preciso até completar a lista. Ao final, passo no caixa, cada produto é registrado e recebo a conta de tudo o que foi colocado no carrinho multiplicado pelas quantidades de cada produto e somado aos impostos. Por fim, levo tudo e vou embora pra casa.

## Vamos às compras: modo API

Usar uma API é como ir ao supermercado. Fazendo paralelos:

- **Carrinho de supermercado**: A representação das nossas queridas APIs;
- **Supermercado**: Um banco de dados cheio de coisas que queremos comprar;
- **Caixa**: Um guardião que garante que temos permissão para comprar o que queremos comprar;
- **Produtos**: Dados e mais dados.

E a jornada de compras digital fica assim:

Quero comprar, só que não vou mais ao mercado andando ou de carro. Vou falar com a API, um carrinho de compras super inteligente, pra ela ir buscar minhas compras. Entrego para a API carrinho a listinha das coisas que quero comprar (e dessa vez a listinha tem **exatamente** o que eu quero), junto duas orientações:

- A API deve levar uma autorização para o supermercado dizendo que ela pode fazer compras em meu nome;
- A API deve pedir autorização para a **pessoa dona do supermercado** pra comprar dados, ou produtos, no supermercado dela (a dona tem o costume de não deixar qualquer um comprar no mercado dela).

Com a lista e as orientações em mãos, a API vai para o supermercado digital buscar o que está na lista. Acontece que não é qualquer pessoa que pode comprar no supermercado: ela precisa estar autorizada por alguém que pode comprar ali. Se a segurança do supermercado autorizar a pessoa que está fazendo uso da API a comprar, a API entra, pega o que precisa, passa no caixa para registrar tudo o que está levando, paga (quando não for de graça) e vai embora.

## Traçando um paralelo entre APIs e compras

A segurança é forte; carrinhos de compras possuem uma capacidade em relação ao tanto de objetos que podem levar; o dinheiro que tenho no cartão não é infinito e eu não fico passeando a toa pelos corredores. Estas são todas verdades aplicáveis ao fascinante mundo das APIs. Veja como:

- APIs são carrinhos de compras conhecidos pelas equipes de segurança. Quem as usa, no entanto, não. Para fazer uso das APIs, pessoas precisam se identificar e provar que podem comprar no supermercado. A segurança pode até autorizar a entrada da API, mas pode bloquear certas seções da loja como a de bebidas alcoólicas se as permissões que a pessoa possui são incompatíveis com o nível de acesso necessário para entrar na seção de bebidas alcoólicas;
- APIs são limitadas pelo nível de acesso que possuem. Esse nível de acesso pode ser determinado por dinheiro ou por permissões de usuário. Se uma criança vai ao supermercado, por exemplo, ela ~~provavelmente~~ não terá permissão para levar cigarros ou bebidas alcoólicas. Ou num exemplo corporativo, eu posso pedir para uma API buscar o nome de todos os meus colegas de trabalho, mas não o salário deles;
- Dinheiro pode ou não ser uma moeda de troca. Eu nunca fui em um supermercado onde tivesse que pagar pra usar um carrinho. Mas APIs são carrinhos de outro nível! Algumas só podem ser usadas mediante pagamento. Tem outras que pegam só alguns produtos de graça. Pra acessar produtos mais premium é necessário pagar uma taxa;
- APIs são bem objetivas: olham o que está na listinha, passam nos corredores certos pra pegar e tchau! Sem rodeios ~~(e sem guloseimas que possam diminuir minha expectativa de vida)~~.

Fazer compras com a ajuda da API é rápido, eficiente e o custo do frete é baixíssimo (eletricidade gasta no processo).

## O estoque do supermercado

Para que possamos comprar em um supermercado, é necessário que haja produtos em estoque. Este estoque é, portanto, abastecido de alguma forma para que os produtos estejam disponíveis nas gôndolas. Em nosso hipotético supermercado, a pessoa comerciante compra produtos de fornecedores para fazer o abastecimento desde que a seguinte condição seja aceita: **apenas o fornecedor que vendeu o produto para o lojista ou quem estiver com autorização pode comprá-lo**. Isso significa que se eu plantar tomates e vender para o supermercado, darei instruções para a pessoa lojista para que apenas eu e pessoas de minha confiança possam comprar os tomates fresquinhos. A pessoa comerciante e a administração do supermercado são responsáveis pela gestão de tudo o que vendem, mas devem seguir as regras que determinei para a venda dos tomates. Posso trocar os tomates por laranjas nas gôndolas e até pegar de volta o que eu deixei.

Imagine se você tivesse que lidar com caixas guardiões, comerciantes, fornecedores e todo mundo que participa da cadeia de produção e entrega dos produtos. Seria bem complicado, caro e ineficiente. Ainda bem que temos carrinhos de compras — ou APIs — para fazer tudo isso enquanto fazemos coisas mais produtivas.

Quando precisar fazer compras no mundo digital, já sabe: APIs são uma ótima opção!

## Leitura complementar

Para uma explicação mais técnica sobre APIs, veja {{< anchor href="/stories/fundamentos-das-apis/" >}}o post sobre fundamentos das APIs{{< /anchor >}} publicado neste blog.

Bora usar APIs!
