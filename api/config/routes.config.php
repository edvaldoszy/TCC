<?php

return array(

    '/pedidos/abertos/{num}' => array(
        'controller' => 'FastFood\Controller\PedidoController',
        'action' => 'abertos'
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

    '/clientes/login' => array(
        'controller' => 'FastFood\Controller\ClienteController',
        'action' => 'login'
    ),

    '/clientes/{num}' => array(
        'controller' => 'FastFood\Controller\ClienteController',
        'action' => 'index'
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