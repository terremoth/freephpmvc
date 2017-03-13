<?php

/**
 * MainController - All Controllers must extends this class
 */
class MainController extends UserLogin 
{
    /**
     * Classe phpass 
     * @see http://www.openwall.com/phpass/
     * @access public
     */
    public $phpass;

    /**
     * Page Title // MANDAR PARA 
     * @access public
     */
    public $title;

    /**
     * Verifies if the page needs login
     * @access public
     */
    public $loginRequired = false;

    /**
     * Verify if the permission is required to proceed some action
     * @access public
     */
    public $permissionRequired = 'any';

    /**
     * Controller Params
     * @access public
     */
    public $params = array();
    
    /**
     * Model
     * @var object Model
     */
    public $model;
    
    /**
     * View
     * @var object View
     */
    public $view;
    
    /**
     * Instances $_GET and $_POST inside new objects
     * @var object Object with $_GET and $_POST
     */
    public $requestGet;
    
    /**
     * Instances $_GET and $_POST inside new objects
     * @var object Object with $_GET and $_POST
     */
    public $requestPost;

    /**
     * Configures all the class to crates Controller enviroment
     * @access public
     */
    public function __construct($params = array()) 
    {
        // Creates $_GET and $_POST
        if(isset($_GET)  && !empty($_GET)) {$this->requestGet  = $_GET;}
        if(isset($_POST) && !empty($_POST)){$this->requestPost = $_POST;}
        
        // Phpass Class
        $this->phpass = new PasswordHash(8, false);

        // Environment params
        $this->params = $params;

        /**
         * @todo Verify login : Disabled due to some issues in the UserLogin class
         */
        //$this->checkUserLogin();
        
    }

    /**
     * Load the model itself
     * @access public
     */
    public function loadModel($sModelName = false) 
    {
        
        // loadModel will return false if can't find model
        if ($sModelName === false){
            return false;
        }

        // including file
        $sModelPath = BASE_PATH . '/model/Model' . $sModelName . '.php';
        // Verifies if file exists
        if (file_exists($sModelPath)) {

            // Call file
            require_once $sModelPath;

            // Split (if it can) the path to get model's name
            $sModelName = 'Model'.$sModelName;

            // Verifies if the class exists
            if (class_exists($sModelName)) {
                
                // Return the object with the class
                return new $sModelName();
            }
        } else {
            return false;
        }
    }
    
    public function loadView($sViewName = false, $aData = array()) 
    {

        // loadView will return false if can't find view
        if (!$sViewName){
            return false;
        }

        // including file
        $sViewPath = BASE_PATH . '/view/View' . $sViewName . '.php';

        // Veries if exists
        if (file_exists($sViewPath)) {
            
            // Call file
            require_once $sViewPath;
            // Split (if it can) the path to get model's name
            $aViewName = explode('/', $sViewName);

            // Get only final name (the real one)
            $sViewName = end($aViewName);
            $sCompleteViewClass = 'View'.$sViewName;
            
            // Verifies if the class exists
            if (class_exists($sCompleteViewClass)) {
                
                // Return the object with the class
                $oView = new $sCompleteViewClass($aData);
                
                return $oView;
                
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
}
