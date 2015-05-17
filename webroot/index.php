<?php

// Get environment & autoloader.
require __DIR__.'/config_with_app.php'; 

// Create services and inject into the app. 
$di  = new \Anax\DI\CDIFactoryDefault();

$di->set('form', '\Mos\HTMLForm\CForm'); 

$di->set('CommentController', function() use ($di) {
    $controller = new \Anax\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});


$di->set('AnswerController', function() use ($di) {
    $controller = new \Anax\Answer\AnswerController();
    $controller->setDI($di);
    return $controller;
});


$di->set('TagController', function() use ($di) {
    $controller = new \Anax\Tag\TagController();
    $controller->setDI($di);
    return $controller;
});


$di->set('QuestionController', function() use ($di) {
    $controller = new \Anax\Question\QuestionController();
    $controller->setDI($di);
    return $controller;
});


$di->set('Cfmessage', function() use ($di) {
    $message = new \Chja\Cfmessage\CfmessageAnax();
    $message->setDI($di);
    return $message;
}); 


$di->set('UsersController', function() use ($di) {
    $controller = new \Anax\Users\UsersController();
    $controller->setDI($di);
    return $controller;
});


$di->setShared('db', function() {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/database_mysql.php');
    $db->connect();
    return $db;
});

$app = new \Anax\Kernel\CAnax($di); 

// Configure (theme file, navbar file)
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

$app->session(); // Will load the session service which also starts the session 
 
// Hem
$app->router->add('', function() use ($app) {

	$app->theme->setTitle("Hem");
	
	$content = $app->fileContent->get('welcome.md');
	$content = $app->textFilter->doFilter($content, 'shortcode, markdown');
	
	$app->views->add('me/page', [
        'content' => $content,
    ]);
	
	$app->dispatcher->forward([
		'controller' => 'tag',
		'action'     => 'viewFirst',
    ]);
	
	$app->dispatcher->forward([
		'controller' => 'question',
		'action'     => 'viewFirst',
    ]);
	
	$app->dispatcher->forward([
		'controller' => 'users',
		'action'     => 'viewFirst',
    ]);


});

$app->router->add('questions', function() use ($app) {
  $app->theme->setTitle("Frågor");
  
  $app->dispatcher->forward([
    'controller' => 'question',
    'action'     => 'view',
  ]);
});

$app->router->add('tags', function() use ($app) {
  $app->theme->setTitle("Taggar");
  
  $app->dispatcher->forward([
    'controller' => 'tag',
    'action'     => 'view',
  ]);
});

$app->router->add('about', function() use ($app) {
  $app->theme->setTitle("Om oss");
  
  $content = $app->fileContent->get('about.md');
  $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
	
	$app->views->add('me/page2', [
        'content' => $content,
    ]);

});

 
// Check for matching routes and dispatch to controller/handler of route
$app->router->handle();

// Render the page
$app->theme->render();