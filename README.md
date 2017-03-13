# Taskero
Open Source Web Task Management Software

## Features 

- Using FreePHPMVC Framework created by Lucas Marques Dutra
- Using PSR (PHP Standard Recomendations): http://www.php-fig.org/psr/
- PHP Version >= 5.3
- PDO Database Driver
- Obs: mod_rewrite must be uncommented at Apaches's httpd.conf to load URL like this: http://localhost/taskero/controller/action/params

### Main Files
-
- index.php: starts the Application;
- configuration.php: The file you need to alter for your preferences;
- loader.php: This file loads the entire Application, the Global Functions and the main class: FreePHPMVC;
- system/FreePHPMVC.php: One of the most important Application's file, the "mainframe" of all MVC;
- system/GlobalFunction.php: This file contains the main functions that will be used in the entire Application

-
Feel free to use and do what you want :-)
