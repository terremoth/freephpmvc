<?php

/**
 * Applications's Main Model, all models should extend this
 */
class MainModel
{
	/**
	 * The send form data 
	 * @access public
	 */	
	public $formData;
 
	/**
	 * Feed back form messages
	 * @access public
	 */	
	public $formMsg;
 
	/**
	 * Message to confirm to delete data
	 * @access public
	 */
	public $formConfirm;
 
	/**
	 * PDO database object
	 * @access public
	 */
	protected $db;
 
	/**
	 * The controller that generates this model
	 * @access public
	 */
	public $controller;
 
	/**
	 * URL params
	 * @access public
	 */
	public $params;
 
	/**
	 * User data
	 * @access public
	 */
	public $userData;
    
    /**
     * Creates connection with Database
     */
    public function initDB() 
    {
        // Instances DataBase Object
        $this->db = new Database();
    }
    
	/**
	 * Get date and Invert date value - From: d-m-Y H:i:s to Y-m-d H:i:s or vice-verse.
	 * @access public
	 * @param string $sDate The date itself
	 */
	public function invertData($sDate = false) 
    {
	
		// Start new date var
		$sNewDate = false;
		
		// If the data was sent
		if ($sDate) {
		
			// Splits date by -, /, : or space
			$sDate = preg_split('/-|/|s|:/', $sDate);
			
			// Removes beginning and end whitespaces from date
			$sDate = array_map('trim', $sDate);
			
			// Creates inverse date
			$sNewDate .= arrayKey($sDate, 2) . '-';
			$sNewDate .= arrayKey($sDate, 1) . '-';
			$sNewDate .= arrayKey($sDate, 0);
			
			// Hours
			if (arrayKey($sDate, 3)) {
				$sNewDate .= ' ' . arrayKey($sDate, 3);
			}
			
			// Minutes
			if (arrayKey($sDate, 4)) {
				$sNewDate .= ':' . arrayKey($sDate, 4);
			}
			
			// Seconds
			if (arrayKey($sDate, 5)) {
				$sNewDate .= ':' . arrayKey($sDate, 5);
			}
		}
		
		// Returns new Date
		return $sNewDate;
	} 
 
}