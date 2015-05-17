Flashmessages for AnaxMVC
=============

Module that saves flash message in session and returns div displaying the message. Created for Anax-MVC.

How to use
-------------

###1. Download

The easiest way to install this is using composer. Add this to your composer.json: 

```javascript
    "dahc/flashmessages": "dev-master"
```

###2. Include to your frontcontroller

```php
$di->setShared('flashmessage', function() use ($di) {
    $flashmessage = new \dahc\Flashmessage\Flashmessage();
    $flashmessage->setDI($di);
    return $flashmessage;
});
```

###3. Display messages

Saving the messages

```php
    $app->flashmessage->Error('This is an error message');
    $app->flashmessage->Warning('This is a warning message');
    $app->flashmessage->Info('This is an information message');
    $app->flashmessage->Success('This is a success message');
```

Add this line to your view to display the message(s):

```php
 $this->flashmessage->getHtml() 
```

### Easy and quick way to use

Copy the flash view to your view directory<br>
Copy the css to your css directory and follow steps above
