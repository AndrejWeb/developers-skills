# Developers & Skills
<hr/>
Demo project which focuses on filtering database data based on provided criteria.
<br /><br />
To setup & run the project:

1) Create a mysql database with name of your choice.
2) Select the newly created database and run / import the database.sql file found in repository into your database (this will create the necessary database tables and insert data)
3) Rename App/Database/DB_Creds_example.php to DB_Creds.php
4) Enter your database credentials in App/Database/DB_Creds.php in these lines
```
return [
    'host' => 'YOUR_HOST',
    'dbname' => 'YOUR_DATABASE_NAME',
    'username' => 'YOUR_DATABASE_USERNAME',
    'password' => 'YOUR_DATABASE_PASSWORD',
];
```
5.&nbsp;Make sure you have mod_rewrite module enabled in your server configuration (this is necessary for the .htaccess file)

6.&nbsp;You can now run the application by visiting the app's URL

#### Other notes
Developers' names were created randomly using https://github.com/fzaninotto/Faker

App environment (development, production or if you add new environment) can be changed in App/app.php
```
define('ENVIRONMENT', 'development');
```
