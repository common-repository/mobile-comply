<?php

/**
 * Responsible for operations with visitor table
 */
class Visitor {

    /**
     * Instance of Visitor object
     *
     * @var Visitor
     */
    protected static $_oInstance;

    /**
     * Returns a reference to the global object
     *
     * @return Visitor
     */
    public static function getInstance() {
        if (is_null(self::$_oInstance)) {
            self::$_oInstance = new Visitor();
        }

        return self::$_oInstance;
    }

    /**
     * Returns details of visitor
     *
     * @param int $iVisitorId
     * @return object | boolean
     */
    public function getVisitor($iVisitorId) {
        global $wpdb;

        $sSql = "SELECT * FROM {$wpdb->prefix}visitor WHERE visitor_id = %d";

        return $wpdb->get_row($wpdb->prepare($sSql, $iVisitorId));
    }

    /**
     * Returns details of visitor by visit ip and visit user agent
     *
     * @param string $sVisitIp
     * @param string $sVisitUserAgent
     * @return object | boolean
     */
    public function getVisitorByIpAndUserAgent($sVisitIp, $sVisitUserAgent) {
        global $wpdb;
        
        $sSql = "SELECT vr.* FROM {$wpdb->prefix}visit AS v 
					LEFT JOIN {$wpdb->prefix}visitor AS vr 
                                        ON v.visitor_id = vr.visitor_id 
					WHERE 
					v.visit_ip = %s AND 
					v.visit_user_agent = %s 
					ORDER BY v.visit_date_finish DESC
					LIMIT 1";
        
        $oRowVisitor = $wpdb->get_row( $wpdb->prepare($sSql, $sVisitIp, $sVisitUserAgent) );
        
        return $oRowVisitor;
    }

    /**
     * Adds new visitor into database
     *
     * @return int
     */
    public function addVisitor() {
        global $wpdb;

        $wpdb->query("INSERT INTO {$wpdb->prefix}visitor() VALUES()");

        return $wpdb->insert_id;
    }

    /**
     * Deletes specified visitor from database
     *
     * @param int $iVisitorId
     * @return boolean
     */
    public function deleteVisitor($iVisitorId) {
        global $wpdb;

        $sSql = "DELETE FROM {$wpdb->prefix}visitor WHERE visitor_id = %d";

        $bResult = $wpdb->query( $wpdb->prepare($sSql, $iVisitorId) );

        return true;
    }

}