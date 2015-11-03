# briskel
Simple Blog built using Slim Micro Framework - Modernizes a tutorial from 2012. 

[Rapid Application Prototyping in PHP Using a Micro Framework](http://code.tutsplus.com/tutorials/rapid-application-prototyping-in-php-using-a-micro-framework--net-21638)

**Note this is a prototype and is not suited for general release. It is educational only.**

### How to setup 

Download the zip file. extract. Run `composer install `. Copy the contents of public/ to the directory you want the application to run from. Update the username/password for your database. If desired change the default password/username for Basic Auth (line 21). Otherwise its admin/password. Setup your database and import the SQL from the tutorial above. You will have to change the database name . These are on lines 6-8. 



To view the application, go to http://www.domain.com/folder/where/uploaded/ and you should see the basic blog frontpage. Admin is http://www.domain.com/folder/where/uploaded/admin . Note you might have to change the .htaccess file to match the subdirectory for the Rewrite Base rule and uncomment it if you get 404 errors. 

HTTP Basic Auth is just that basic. I disabled requiring SSL. If you have SSL or don't mind adding a security exception for your domain, change line "secure"=>false to "secure"=>true . 
