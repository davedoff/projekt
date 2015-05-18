Projekt
=====================

A school project based on the framework Anax MVC. The application is a website about basketball.

How to use:
=====================
1. Clone or download the zip file.
2. Import the file "projekt.sql" to your database. You can find the file in the "database" folder
3. Change the database settings in the file "database_mysql.php" so it fits your database. You can find the file in app/config/
4. You may have to configure the file ".htaccess" depending on the location of where you save the folder. You can find the file in "webroot". 

If you work locally it should look like this:

```php
#RewriteBase /~dahc15/phpmvc/projekt/webroot/
```

If not, it should look like this:

```php
RewriteBase /~dahc15/phpmvc/projekt/webroot/
```

Just change the part after "RewriteBase" to your folder.
