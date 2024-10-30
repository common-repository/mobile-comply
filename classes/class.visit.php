<?php

class Visit {

    /**
     * Instance of Visit object
     *
     * @var Visit
     */
    protected static $_oInstance;
    
    /**
     * Default fields for visit table
     * 
     * @var array
     */
    private $aVisitDefault = array(
        'visitor_id' => 0,
        'visit_ip' => '',
        'visit_user_agent' => '',
        'visit_cookie_flag' => 0,
        'visit_browser' => '',
        'visit_date_start' => '',
        'tracking_id_start' => 0,
        'visit_date_finish' => '',
        'tracking_id_finish' => 0,
        'visit_is_crawler' => 0,
        'tracking_device' => ''
    );
    
    /**
     * Format for insert/update operations for visit table
     * 
     * @var array
     */
    private $aVisitInsertUpdateFormat = array(
        '%d', '%s', '%s', '%d', '%s', '%s', '%d', '%s', '%d', '%d', '%s'
    );

    /**
     * Returns a reference to the global object
     *
     * @return Visit
     */
    public static function getInstance() {
        if (is_null(self::$_oInstance)) {
            self::$_oInstance = new Visit();
        }

        return self::$_oInstance;
    }

    /**
     * Returns details of visit
     *
     * @param int $iVisitId
     * @return object | boolean
     */
    public function getVisit($iVisitId) {
        global $wpdb;
        
        $sSql = "SELECT * FROM {$wpdb->prefix}visit WHERE visit_id = %d";

        return $wpdb->get_row( $wpdb->prepare($sSql, $iVisitId) );
    }

    /**
     * Returns details of users last visit
     *
     * @param int $iVisitorId
     * @return object | boolean
     */
    public function getLastVisit($iVisitorId) {
        global $wpdb;
        
        $sSql = "SELECT * FROM {$wpdb->prefix}visit WHERE visitor_id = %d ORDER BY visit_date_finish DESC LIMIT 1";
        
        return $wpdb->get_row( $wpdb->prepare($sSql, $iVisitorId) );
    }

    /**
     * Returns details of visit by visitor id
     *
     * @param int $iVisitorId
     * @return object | boolean
     */
    public function getVisitByVisitorId($iVisitorId) {
        global $wpdb;
        
        $sSql = "SELECT * FROM {$wpdb->prefix}visit WHERE visitor_id = %d";

        return $wpdb->get_row( $wpdb->prepare($sSql, $iVisitorId) );
    }

    /**
     * Adds new visit into database
     *
     * @param array $aVisit
     * @return int
     */
    public function addVisit($aVisit) {
        global $wpdb;
        
        $aVisit = array_merge($this->aVisitDefault, $aVisit);
        $wpdb->insert($wpdb->prefix . 'visit', $aVisit, $this->aVisitInsertUpdateFormat);

        return $wpdb->insert_id;
    }

    /**
     * Updates data of selected visit in the database
     *
     * @param int $iVisitId
     * @param array $mVisit
     * @return int | boolean
     */
    public function editVisit($iVisitId, $mVisit) {
        global $wpdb;
        
        $aVisit = array_merge($this->aVisitDefault, (array)$mVisit);
        if (isset($aVisit['visit_id'])) {
            unset ($aVisit['visit_id']);
        }
        
        $bResult = $wpdb->update(
            $wpdb->prefix . 'visit',              
            $aVisit, 
            array('visit_id' => $iVisitId),
            $this->aVisitInsertUpdateFormat,
            array('%d')
        );

        return $bResult;
    }

    /**
     * Deletes specified visit from database
     *
     * @param int $iVisitId
     * @return boolean
     */
    public function deleteVisit($iVisitId) {
        global $wpdb;

        $sSql = "DELETE FROM {$wpdb->prefix}visit WHERE visit_id = %d";

        return $wpdb->query( $wpdb->prepare($sSql, $iVisitId) );
    }

}