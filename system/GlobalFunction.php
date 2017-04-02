<?php

/**
 * PHP's Default function to automatically load classes from a directory
 */
function __autoload($sClassName) 
{
    $sFile = BASE_PATH . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . $sClassName.'.php';
    
    if (!file_exists($sFile)) {
        //If the file does not exists go to 404
        require_once BASE_PATH .DIRECTORY_SEPARATOR . 'system'. DIRECTORY_SEPARATOR . '.404.php';
    } else {
        // Load the class file
        require_once $sFile;
    }
}

/**
 * Verifies if array key exists and then returns the value that corresponds that key
 * @param array  $aArray The array itself
 * @param string $iKey Array key
 * @return string|false 
 */
function arrayKey($aArray, $iKey) 
{
    // verifies if the key exists in array and is not empty
    if (isset($aArray[$iKey]) && !empty($aArray[$iKey])) {
        // Retorna o valor da chave
        return $aArray[$iKey];
    } else {
        return false;
    }
}

/**
 * Echoes a string adding a new line
 * @param type $sString string that wants to echoes
 */
function echoln($sString) 
{
    echo $sString . PHP_EOL;
}

/**
 * Verifies if a given value exist
 * @param mixed $xValue The value itself
 * @param boolean $bVerifyNonVisualValues if this param is true will verif
 * @return boolean
 */
function existVisualValue($xValue) 
{    
    // $xValue needs to be seeted, cannot be empty string, neither false or null
    if (    isset($xValue) 
        && !empty($xValue) 
        && ($xValue !== false) 
        && ($xValue !== null)
    ) {
        return true;
    } else {
        return false;
    }
}

/**
 * Loads favicon files inside HTML
 * @todo More complex intelligent favicon loader, loading its sizes 
 * @param string $sCompleteFilename The favicon image filename including its extension to load
 */
function loadFavIcon($sCompleteFilename){

   $sFileInfo = pathinfo(BASE_PATH . '/asset/img/'. $sCompleteFilename);
   
   if ($sFileInfo['extension'] == 'ico') {
       $sFileInfo['extension'] =  'x-icon';
   }
   
   echoln('<link rel="shortcut icon" type="image/'.$sFileInfo['extension'].'" href="' . BASE_PATH . '/asset/img/'. $sCompleteFilename . '">');
   echoln('<link rel="icon" type="image/'.$sFileInfo['extension'].'" href="' . BASE_PATH . '/asset/img/'. $sCompleteFilename . '">');
}

/**
 * Clears dirty data
 * @param string $sSenderRequest
 * @param bool $bStriptTags 
 * @return string Decoded string
 */
function sanitizeRequest($sSenderRequest, $bStriptTags = false)
{
    // Removes < > (tags structures)
    $sSenderRequest = $bStriptTags ? strip_tags($sSenderRequest) : $sSenderRequest;
    
    // Converts special chars to html entities
    $sCharset = defined('APP_CHARSET') ? APP_CHARSET : 'UTF-8';
    $sDecodedString = htmlspecialchars($sSenderRequest, ENT_QUOTES, strtoupper($sCharset));
    
    return $sDecodedString;
}