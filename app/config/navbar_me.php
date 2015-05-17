<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
 
    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'hem'  => [
            'text'  => 'Hem',
            'url'   => '',
            'title' => 'hem'
        ],
		
		// This is a menu item
        'questions' => [
            'text'  => 'Frågor',
            'url'   => 'questions',
            'title' => 'Frågor'
        ],
		
		// This is a menu item
        'tags' => [
            'text'  => 'Taggar',
            'url'   => 'tags',
            'title' => 'Taggar'
        ],
		
		// This is a menu item
        'users'  => [
            'text'  => 'Användare',
            'url'   => 'users/list',
            'title' => 'Användare'
        ],

		// This is a menu item
        'about'  => [
            'text'  => 'Om oss',
            'url'   => 'about',
            'title' => 'Om oss'
        ],
		
    ],
 
    // Callback tracing the current selected menu item base on scriptname
    'callback' => function ($url) {
        if ($url == $this->di->get('request')->getRoute()) {
                return true;
        }
    },

    // Callback to create the urls
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },
]; 