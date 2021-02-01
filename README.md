# Rest Proyect
Author: Gustavo Luis <br/>
Date 01/02/2021
======================
Made in Symfony 3.4
======================
Installation guide
======================

1) git clone https://github.com/bilikui/rest.git rest
2) cd rest
2) php composer.phar install
3) If you use Apache, you should create a new VirtualHost, for example in the httpd-vhosts.conf file you should add:

<VirtualHost *:80>

        DocumentRoot "#YOUR_DIRECTORY#/rest/web"
        DirectoryIndex  app.php

        ServerName  local.rest
        ServerAlias local.rest

        <Directory "#YOUR_DIRECTORY#/rest/web">
              
			AllowOverride None
			Order Allow,Deny
			Allow from All
			
			<IfModule mod_rewrite.c>
				Options +MultiViews
			
				RewriteEngine On
				RewriteCond %{REQUEST_FILENAME} !-f
				RewriteRule ^(.*)$ app.php [QSA,L]
			</IfModule>
        </Directory>
</VirtualHost>

4) Add in the hosts file: 127.0.0.1 local.rest

5) Restart the apache service

6) Enter a web browser and go to the following url: http://local.rest/fizzbuzz/:min/:max where :min and :max are input parameters

======================
Units Test

To run the unit tests, run: vendor / bin / phpunit --filter ApiRestControllerTest

======================
PSR Fixer

To run PSR Fixer, run: vendor/bin/php-cs-fixer fix src
