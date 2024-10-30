<?php
/**
 * Base controller which defines standard functions for all controllers
 *
 * @author izmaylav
 */
class MobilecomplyBaseController {
    /**
     * Stores errors
     * 
     * @var WP_Error
     */
    protected $oError;
    
    /**
     * Common error code for controllers
     * 
     * @var int
     */
    protected $iErrorCode;


    /**
     * Constructor
     */
    public function __construct() {
        $this->iErrorCode = 1001;
        $this->oError = new WP_Error();
    }
    
    /**
     * Displays controller's view
     */
    public function display() {
        
    }
    
    /**
     * Saves form's info, if there is form
     */
    public function save() {
        
    }
}
?>
