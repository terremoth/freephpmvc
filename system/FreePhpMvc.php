<?php

/**
 * FreePhpMvc - Manages the entire MVC
 *
 * @name FreePhpMvc
 * @package FreePhpMvc
 * @author Lucas Marques Dutra <dutr4@outlook.com>
 * @version 1.0.0
 * @since 2016-11-25
 * @link https://github.com/terremoth/freephpmvc
 * @license https://github.com/terremoth/freephpmvc/LICENSE.md
 * @copyright (c) 2016, Lucas Marques Dutra - General Public License v.3 / Copyleft Software
 */
class FreePhpMvc 
{
    /**
     * Application Controller
     *
     * Receives the controller name through the URL first structure
     * http://example.com/controllerName/
     *
     * @access private
     */
    private $controller;

    /**
     * Application actions (controller methods)
     *
     * Receives the action through the URL second structure 
     * http://example.com/controllerName/action
     *
     * @access private
     */
    private $action;

    /**
     * Application Parameters (the controller's function params)
     *
     * Receive an array through the third structure to beyond:
     * http://example.com/controllerName/action/param1/param2/paramX...
     *
     * @access private
     */
    private $params;

    /**
     * Class constructor
     * Get controller, action and params, then configures it all
     */
    public function __construct() 
    {
        // Get the controller values, action and params through the URL, and configures it
        $this->getUrlData();
            
        //Verify if controller exists. In false case, loads the default controller
        if (!$this->controller) {
            $this->loadDefaultController();
        } else {
            $this->tryDefinedController();
        }
        
    }

    /**
     * Get params from $_GET['path'] and condfigures its properties
     * The URL must be formatted like this:
     * http://www.example.com/controller/action/parame1/parame2/etc...
     */
    public function getUrlData() 
    {
        // Verifies if path was send
        if (isset($_GET['path'])) {

            // Get the value of $_GET['path']
            $sPath = $_GET['path'];

            // Cleans dirty data
            $sPath = rtrim($sPath, '/');
            $sPath = filter_var($sPath, FILTER_SANITIZE_URL);

            // Create array with path properties
            $sPath = explode('/', $sPath);
            $this->controller  = 'Controller';
            // Controller Name
            $this->controller .= arrayKey($sPath, 0);
            // Action/Method passed to the controller
            $this->action = arrayKey($sPath, 1);
            
            // Configura os parâmetros
            if (arrayKey($sPath, 2)) {
                unset($sPath[0]);
                unset($sPath[1]);

                // All the params will be sent here reorganizing the arrays positions
                $this->params = array_values($sPath);
            }
            
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Loads the default defined controller name, using "APP_HOME"
     */
    public function loadDefaultController() 
    {
        // Add default controller
        require_once BASE_PATH . '/controller/Controller'.APP_HOME.'.php';
        
        // Creates controller Defined as home by the user
        $sControllerName = 'Controller'.APP_HOME;
        
        $this->controller = new $sControllerName();

        // executes index method
        $this->controller->index();
    }
    
    /**
     * Try to load the default instancied/initialized controller
     * @return boolean
     */
    public function tryDefinedController() 
    {
        // If the controller file not exists, go to 404 defined page
        $sControllerFile = BASE_PATH . '/controller/' . $this->controller . '.php';

        if (file_exists($sControllerFile)) {
            // Include controller name
            require_once $sControllerFile;

            // Removes invalid characters from controller name to generate the ClassName
            // If the file name is "ControllerBlog" for example, the class name should be ControllerBlog too
            $this->controller = preg_replace('/[^a-zA-Z]/i', '', $this->controller);

            // If the class name/file still not existing, go to 404 page 
            if (class_exists($this->controller)) {
                // now it creates the controller class and send params
                $oController = new $this->controller;
                $this->controller = new $oController();
                $this->tryDefinedMethod();
                
                return true;
            }
        }
        
        require_once PAGE_404;
        return false;
    }
    
    /**
     * Verifies if the controller has method/action
     * in case of true, load it, else tries to call index method/action
     */
    public function tryDefinedMethod() 
    {
        // if method exists, call it and send the params
        if (method_exists($this->controller, $this->action)) {
            $this->controller->{$this->action}($this->params);
        } else {
            //if does not have a defined method, so the application will call the "index method"
            $this->callIndexMethod();
        }
    }
    
    /**
     * Tries to call the index method in the setted controller
     * if cannot load, go to 404 page
     * @return boolean load status
     */
    public function callIndexMethod() 
    {
        if (!$this->action && method_exists($this->controller, 'index')) {
            $this->controller->index($this->params);
            return true;
        } 
        
        require_once PAGE_404;
        return false;
    }
}
