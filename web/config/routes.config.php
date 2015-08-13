<?php

return array(

    "/admin" => array(
        'controller' => 'Administrator\Controller\IndexController'
    ),

    "/login" => array(
        'controller' => 'Administrator\Controller\LoginController'
    ),

    "/image" => array(
        'controller' => 'Administrator\Controller\ImageController'
    ),

    "/" => array(
        'controller' => 'Application\Controller\IndexController'
    )
);