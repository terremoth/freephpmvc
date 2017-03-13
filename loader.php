<?php

// This file cannot be directly accessed!
if (!defined('BASE_PATH')){
    die('Base Path not defined! Define it in configuration file.');
}

// Start the user session
session_start();

// Verify if in development mode
if (!defined('DEBUG') || DEBUG === false) {
    
    // Hide all possible errors
    error_reporting(0);
    ini_set("display_errors", 0);
    
} else { // Production mode:
    
    // Showing all errors
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

// Load Global FreeMVCPHP Functions
require_once '/system/GlobalFunction.php';

// Loads Entire Application
$oFreePHPMVC = new FreePHPMVC();

