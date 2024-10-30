<?php
/**
 * Model for work with opt_in table
 *
 * @author izmaylav
 */
class MobilecomplyOptIn {
    /**
     * Default fields for opt_in table
     * 
     * @var array
     */
    private $aOptInDefaults = array(
        'opt_in_name' => '',
        'opt_in_mobile_phone' => '',
        'opt_in_email' => '',
        'visitor_id' => 0,
        'opt_in_date' => '',
        'opt_in_receive_mobile_offers' => 0
    );
    
    private $aOptInInsertUpdateFormat = array(
        '%s', '%s', '%s', '%d', '%s', '%s'
    );

    /**
     * Constructor
     */
    public function __construct() {
        
    }
    
    /**
     * Checks if current visitor is already registered in opt in
     * 
     * @global wpdb $wpdb
     * @param int $iVisistorId
     * @return boolean
     */
    public function isVisitorRegistered($iVisistorId) {
        global $wpdb;
        
        $iVisistorId = intval($iVisistorId);
        $sQuery = "SELECT COUNT(opt_in_id) FROM {$wpdb->prefix}opt_in WHERE visitor_id=$iVisistorId";
        $iRegistrationNum = $wpdb->get_var($sQuery);
        
        if ($iRegistrationNum) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Checks if user with such email is already registered in system
     * 
     * @global wpdb $wpdb
     * @param string $sEmail
     * @return boolean
     */
    public function isUserRegisteredWithEmail($sEmail) {
        global $wpdb;
        
        $sQuery = "SELECT COUNT(opt_in_id) FROM {$wpdb->prefix}opt_in WHERE opt_in_email=%s";
        $iRegistrationNum = $wpdb->get_var( $wpdb->prepare($sQuery, $sEmail) );
        
        if ($iRegistrationNum) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Gets opt in user record
     * 
     * @global wpdb $wpdb
     * @param int $iOptInId
     * @return mixed
     */
    public function getOptInUser($iOptInId) {
        global $wpdb;
        
        $iOptInId = intval($iOptInId);
        $sQuery = "SELECT * FROM {$wpdb->prefix}opt_in WHERE opt_in_id=$iOptInId";
        
        return $wpdb->get_row($sQuery);
    }
    
    /**
     * Returns list of opt in records
     * 
     * @global wpdb $wpdb
     * @param string $sLimit
     * @return mixed
     */
    public function getOptInUserList($sLimit = '') {
        global $wpdb;

        $sQuery = "SELECT * FROM {$wpdb->prefix}opt_in $sLimit";

        return $wpdb->get_results($sQuery);
    }

    /**
     * Adds tracked user interaction in the database
     *
     * @global wpdb $wpdb
     * @param array $aUserData
     * @return boolean
     */
    public function addNewOptInUser($aUserData) {
        global $wpdb;
        
        $aUserData = array_merge($this->aOptInDefaults, $aUserData);
        
        $aTrackingData['date'] = current_time('mysql');
        
        $wpdb->insert($wpdb->prefix . 'opt_in', $aUserData, $this->aOptInInsertUpdateFormat);

        return $wpdb->insert_id;
    }
    
    /**
     * Edits opt in record in the database
     * 
     * @global wpdb $wpdb
     * @param int $iOptInId
     * @param mixed $mOptInData
     * @return boolean
     */
    public function editOptInUser($iOptInId, $mOptInData) {
        global $wpdb;
        
        $aOptInData = (array)$mOptInData;        
        $aOptInData = array_merge($this->aOptInDefaults, $aOptInData);

        return $wpdb->update(
            $wpdb->prefix . 'opt_in', 
            $aOptInData, 
            array('opt_in_id' => $iOptInId), 
            $this->aOptInInsertUpdateFormat, 
            array('%d')
        );
    }
    
    /**
     * Deletes opt in user
     * 
     * @global wpdb $wpdb
     * @param int $iOptInId
     * @return boolean
     */
    public function deleteOptInUser($iOptInId) {
        global $wpdb;

        $iOptInId = intval($iOptInId);
        
        return $wpdb->query("DELETE FROM {$wpdb->prefix}opt_in WHERE opt_in_id=$iOptInId");
    }
}
?>
