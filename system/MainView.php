<?php

class MainView 
{
    
    private $pageTitle = '';
    protected $data;
        
    function __construct($aData = false) {
        if(!$aData){
            $this->data = $aData;
        }
    }

    /**
     * Echoes < link > for CSS tag
     * @param string $sFilename The CSS filename to load
     */
    protected function loadCSS($sFilename){
        echoln('<link rel="stylesheet" type="text/css" href="' . HOME_URI . '/asset/css/'. $sFilename . '.css">');
    }
    
    /**
     * Echoes < script > tag
     * @param string $sFilename The JavaScript filename to load
     */
    protected function loadJS($sFilename){
        echoln('<script type="text/javascript" src="' . HOME_URI . '/asset/js/'. $sFilename . '.js"></script>');
    }
    
    /**
     * Echoes < img > tag
     * @param string $sCompleteFilename The image filename including its extension to load
     */
    protected function loadImage($sCompleteFilename, $sWidth = null, $sHeight = null, $sClass = null, $sStyle = null){
        echoln('<img src="'.HOME_URI . '/asset/images/'.$sCompleteFilename.'" width="'.$sWidth.'" height="'.$sHeight.'" style="'.$sStyle.'" class="'.$sClass.'">');
    }
    
    
    /**
     * Echoes < iframe > tag
     * @param string $sFilename The iFrame filename to load
     */
    protected function loadIFrame($sFilename){}
    
    /**
     * Loads < ul/ol > and < li > tags with its contents inside
     * @param array $aContents
     * @param bool $bOrderedList
     */
    protected function listTag($aContents, $bOrderedList = false) {
        
        if(!$bOrderedList){
            echoln('<ul>');
        } else {
            echoln('<ol>');
        }
        
        foreach ($aContents as $sValue) {
            echoln('<li>'.$sValue.'</li>');
        }
        
        if(!$bOrderedList){
            echoln('</ul>');
        } else {
            echoln('</ol>');
        }
    }
    
    protected function loadHead($aScripts = array()) {
        ?>
        <!DOCTYPE html>
        <html lang="<?php echo APP_LANG; ?>">
            <head>
                <meta charset="<?php echo APP_CHARSET; ?>">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                
                <meta name="description" content="">
                <meta name="author" content="">
                <title><?php echo APP_NAME; ?></title>
                <?php 
                    
                    foreach ($aScripts as $sScript) {
                        $this->loadCSS($sScript);
                    }
                ?>
            </head>
            <body>
        <?php
    }
    
    public function loadPageEnd($aScripts = array(), $sCustomScript=false){
        foreach ($aScripts as $sScript) {
            $this->loadJS($sScript);
        }
        
        if($sCustomScript !== false){
            $this->customScript($sCustomScript);
        }
        
        ?>
                
            </body>
        </html>
        
        <?php
    }
    
    function customScript($sScript) {
        echoln(
            '<script>'.
                $sScript
            .'</script>'
        );
    }
    
    function alertJS($sText) {
        $this->customScript('alert(\''.$sText.'\');');
    }
    
    function confirmJS($sText, $sTrueExpression, $sFalseExpression = false) {
        $sConfirmExpression = 'var bConfirm = confirm(\''.$sText.'\');'."\n";
        $sConfirmExpression .= 'if(bConfirm) {'."\n";
        $sConfirmExpression .= "\t".$sTrueExpression."\n";
        $sConfirmExpression .= '}';
        
        if($sFalseExpression !== false){
            $sConfirmExpression .= ' else {'."\n";
            $sConfirmExpression .= "\t".$sFalseExpression."\n";
            $sConfirmExpression .= '}';
        }
        
        $this->customScript($sConfirmExpression);
    }
    
    protected function getPageTitle() {
        return $this->pageTitle;
    }
    
    protected function setPageTitle($pageTitle) {
        $this->pageTitle = $pageTitle;
    }


}

        