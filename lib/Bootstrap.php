<?php

class Bootstrap 
{
    const _DEFAULT  = 'default';
    const PRIMARY   = 'primary';
    const SUCCESS   = 'success';
    const INFO      = 'info';
    const WARNING   = 'warning';
    const DANGER    = 'danger';

    
    
    /**
     * Open's a Bootstrap Modal
     * @todo Create Object of this funcion
     * @param string $sModalId Modal Identification
     * @param string $sModalTitle Modal's Title
     * @param mixed $aForm Array of form's tag "attributes => values". False if do not want any < form > after modal body, 
     * @param string $sModalBody The text to go inside modal
     * @param array $sModalFooter Array of Button Objects
     */
    public function modal($sModalId, $sModalTitle = '', $aForm = false, $sModalBody = '', $sModalFooter = '', $sModalStyle = '', $sModalEffect = '') 
    {
        $sModal = '
            <div class="modal fade" id="'.$sModalId.'" tabindex="-1" role="dialog" aria-labelledby="my'.$sModalId.'">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="my'.$sModalId.'">'.$sModalTitle.'</h4>
                        </div>
                        ';
                        
                        if(is_array($aForm)){
                            $sModal = '<form ';
                            
                            foreach ($aForm as $sAttribute => $sValue) {
                                $sModal .= $sAttribute.'="'.$sValue.' ';
                            }
                            
                            $sModal .= '>';
                            
                        }
                        
                        // Modal Body
                        $sModal = '
                                <div class="modal-body">
                                    '.$sModalBody.'
                                 </div>
                                <div class="modal-footer">
                                    '.$sModalFooter.'
                                </div>';

                        
                        if(is_array($aForm)){
                            $sModal .= '</form>';
                        }  
                            
                    $sModal .= '
                    </div>
                </div>
            </div>
        ';
    }
    
    protected function createModalForm($aForm) 
    {
        
    }
}
