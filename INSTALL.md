Clone repository
```
git clone git@github.com:alxpolyakov/shorten-urls-app.git
cd shorten-urls-app
```
Install dependencies
```
composer update
```
Edit config/db.php
```
<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=<my_host_name>;dbname=<my_db_name>',
    'username' => '<my_username>',
    'password' => '<my_password>',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
```
Configure web server (for example apache2)
```
<VirtualHost *:80>
	ServerName my.host.name
	DocumentRoot /<path_to_project>/web
	DirectoryIndex index.php
	<Directory /<path_to_project>/web>
    	    AllowOverride All
            Require all granted
	</Directory>
	ErrorLog ${APACHE_LOG_DIR}/testtask-error.log
	CustomLog ${APACHE_LOG_DIR}/testtask-access.log combined
</VirtualHost>
```
