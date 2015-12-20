<?php

return array(

    '/pedidos/{num}/verificar' => array(
        'controller' => 'FastFood\Controller\PedidoController',
        'action' => 'verificar'
    ),

    '/pedidos/{num}/produtosclassificacao' => array(
    'controller' => 'FastFood\Controller\PedidoController',
    'action' => 'produtos'
),

    '/pedidos/{num}/produtos' => array(
        'controller' => 'FastFood\Controller\PedidoController',
        'action' => 'detalhes'
    ),

    '/pedidos/cliente/{num}' => array(
        'controller' => 'FastFood\Controller\PedidoController',
        'action' => 'abertos'
    ),

    '/pedidos/{num}' => array(
        'controller' => 'FastFood\Controller\PedidoController',
        'action' => 'index'
    ),

    '/pedidos' => array(
        'controller' => 'FastFood\Controller\PedidoController',
        'action' => 'index'
    ),

    '/clientes/{num}/contatos/{num}' => array(
        'controller' => 'FastFood\Controller\ClienteController',
        'action' => 'contatos'
    ),

    '/clientes/{num}/enderecos/{num}' => array(
        'controller' => 'FastFood\Controller\ClienteController',
        'action' => 'enderecos'
    ),

    '/clientes/imagem' => array(
        'controller' => 'FastFood\Controller\ClienteController',
        'action' => 'imagem'
    ),

    '/clientes/novo' => array(
        'controller' => 'FastFood\Controller\CadastroClienteController',
        'action' => 'index'
    ),

    '/clientes/{num}' => array(
        'controller' => 'FastFood\Controller\ClienteController',
        'action' => 'index'
    ),

    '/produtos/votar/{num}/{num}/{num}' => array(
        'controller' => 'FastFood\Controller\ProdutoController',
        'action' => 'votar'
    ),

    '/produtos/{num}/detalhes' => array(
        'controller' => 'FastFood\Controller\ProdutoController',
        'action' => 'detalhe'
    ),

    '/cidades' => array(
        'controller' => 'FastFood\Controller\CidadeController',
        'action' => 'index'
    ),

    '/produtos/{num}' => array(
        'controller' => 'FastFood\Controller\ProdutoController',
        'action' => 'index'
    ),

    '/produtos' => array(
        'controller' => 'FastFood\Controller\ProdutoController',
        'action' => 'index'
    ),

    '/login' => array(
        'controller' => 'FastFood\Controller\LoginController',
        'action' => 'index'
    ),

    "default_controller" => 'FastFood\Controller\IndexController'
);