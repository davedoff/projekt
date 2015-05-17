<?php
/**
 * Config-file for navigation bar.
 *
 */
$navbar = [

    // Use for styling the menu
    'class' => 'navbar',
 
    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'hem'  => [
            'text'  => 'Hem',
            'url'   => '',
            'title' => ''
        ],

        // This is a menu item
        'posts'  => [
            'text'  => 'Frågor',
            'url'   => 'posts',
            'title' => 'Frågor'
        ],
 
        // This is a menu item
        'tags'  => [
            'text'  => 'Taggar',
            'url'   => 'tags',
            'title' => 'Taggar',
        ],

        // This is a menu item
        'user'  => [
            'text'  => 'Användare',
            'url'   => 'users',
            'title' => 'Användare',
        ],
 
        // This is a menu item
        'about' => [
            'text'  =>'Om sidan',
            'url'   => 'about',
            'title' => 'Om sidan'
        ],

        // This is a menu item
        'login' => [
            'text'  =>'Logga in',
            'url'   => 'users/login',
            'title' => 'Logga in'
        ],

        // This is a menu item
        'register' => [
            'text'  =>'Registrera',
            'url'   => 'users/register',
            'title' => 'Registrera'
        ],


    ],
 


    // Callback tracing the current selected menu item base on scriptname
    'callback' => function($url) {
        if ($url == $this->di->get('request')->getRoute()) {
            return true;
        }
    },

    // Callback to create the urls
    'create_url' => function($url) {
        return $this->di->get('url')->create($url);
    },
]; 


return $navbar;
