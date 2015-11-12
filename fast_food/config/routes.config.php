<?php

return array(

    "/categorias" => array(
        "controller" => 'Application\Controller\CategoriaController'
    ),

    "/estoque/itens" => array(
        "controller" => 'Application\Controller\ProdutoController'
    ),

    "/estoque/produtos" => array(
        "controller" => 'Application\Controller\ProdutoController'
    ),

    "/pedidos" => array(
        "controller" => 'Application\Controller\PedidoController'
    ),

    "/clientes" => array(
        "controller" => 'Application\Controller\ClientesController'
    ),

    "/usuarios" => array(
        "controller" => 'Application\Controller\UsuarioController'
    ),

    "/login" => array(
        "controller" => 'Application\Controller\LoginController'
    ),

    "/image" => array(
        "controller" => 'Application\Controller\ImageController'
    ),

    "/" => array(
        "controller" => 'Application\Controller\IndexController'
    ),

    "default_controller" => 'Application\Controller\IndexController'
);