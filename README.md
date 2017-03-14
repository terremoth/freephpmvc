# FreePHPMVC
A Free PHP MVC Framework, for general purpose.

Why should you/people use FreePhpMvc? 
- Clean code
- Lightweight
- Combines some principles such as KISS, YAGN, SOLID3, and DRY - that's right!!!
- Standardized by PSR (http://www.php-fig.org/psr/)
- Free Software
- Extremely easy to work with
- Code is fully documented in English
- Has ORM, DAO, DataMapper

## Dependencies
- PHP Version >= 5.3
- PDO Database Driver (.dll/.so)


### Main Files
- index.php: starts the Application;
- configuration.php: The file you need to alter for your preferences;
- loader.php: This file loads the entire Application, the Global Functions and the main class: FreePHPMVC;
- system/FreePHPMVC.php: One of the most important Application's file, the "mainframe" of all MVC;
- system/GlobalFunction.php: This file contains the main functions that will be used in the entire Application

 Obs: mod_rewrite must be uncommented in Apache httpd.conf to load URL like this: http://localhost/YourApp/controller/action/params

Feel free to use and do what you want :-)
