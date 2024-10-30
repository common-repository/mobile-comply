<?php

/**
 * Saves tracking info
 */
define('VISIT_SESSION_TIME', 3000);

class MobilecomplyTracking {
    /**
     * Default fields for tracking table
     * 
     * @var array
     */
    private $aTrackingDefault = array(
        'visit_id' => 0,
        'user_id' => 0,
        'post_id' => 0,
        'page_id' => 0,
        'cat' => 0,
        'author' => 0,
        'tag_id' => 0,
        'is_front_page' => 0,
        'tracking_ip' => '',
        'tracking_phone' => '',
        'tracking_carrier' => '',
        'tracking_user_agent' => '',
        'tracking_referring_url' => '',
        'tracking_status' => 1,
        'tracking_date' => '',
        'tracking_url' => '',
        'tracking_search' => '',
        'tracking_page_title' => '',
        'visitor_id' => 0
    );
    
    /**
     * Format for insert/update operations for visit table
     * 
     * @var array
     */
    private $aTrackingInsertUpdateFormat = array(
        '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d'
    );
    
    private static $iVisitorId = -1;

    public function __construct() {
        require_once 'Browscap.php';
        require_once 'class.visitor.php';
        require_once 'class.visit.php';
    }

    /**
     * Adds tracked user interaction in the database
     *
     * @param array $aTrackingData
     * @return int
     */
    public function addTracking($aTrackingData) {
        global $wpdb;
        
        $aTrackingData = array_merge($this->aTrackingDefault, $aTrackingData);
        
        $aTrackingData['tracking_date'] = current_time('mysql');
        
        $wpdb->insert($wpdb->prefix . 'tracking', $aTrackingData, $this->aTrackingInsertUpdateFormat);

        return $wpdb->insert_id;
    }
    
    /**
     * Edits tracking info in the database
     * 
     * @param int $iTrackingId
     * @param mixed $mTrackingData
     * @return boolean
     */
    public function editTracking($iTrackingId, $mTrackingData) {
        global $wpdb;
        
        $aTrackingData = (array)$mTrackingData;        
        $aTrackingData = array_merge($this->aTrackingDefault, $aTrackingData);

        return $wpdb->update(
            $wpdb->prefix . 'tracking', 
            $aTrackingData, 
            array('tracking_id' => $iTrackingId), 
            $this->aTrackingInsertUpdateFormat, 
            array('%d')
        );
    }

    /**
     * Tracks current user interaction and saves it into database
     */
    public function track() {
        if (!isset($_SERVER['HTTP_X_MOZ']) || $_SERVER['HTTP_X_MOZ'] != 'prefetch') {
            $aTrackingData = array();
            $tracking_format = array();

            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }

            $aTrackingData['tracking_ip'] = $ip;
            $tracking_format[] = '%s';

            $site_url = get_home_url();
            if (substr($site_url, -1) != '/') {
                $site_url .= '/';
            }
            $aTrackingData['tracking_url'] = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            if (strpos($aTrackingData['tracking_url'], 'http://') === false) {
                $aTrackingData['tracking_url'] = 'http://' . $aTrackingData['tracking_url'];
            }
            $tracking_format[] = '%s';

            $aTrackingData['tracking_user_agent'] = '';
            $tracking_format[] = '%s';
            if (!empty($_SERVER['HTTP_USER_AGENT'])) {
                $aTrackingData['tracking_user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                $tracking_format[] = '%s';
            }

            if (!empty($_SERVER['HTTP_REFERER'])) {
                $aTrackingData['tracking_referring_url'] = $_SERVER['HTTP_REFERER'];
                $tracking_format[] = '%s';
            }

            $aTrackingData['tracking_date'] = current_time('mysql');
            $aTrackingData['tracking_status'] = 1;

            $aTrackingData = $this->addWordpressData($aTrackingData);
            $iTrackingId = $this->addTracking($aTrackingData);

            $aTrackingData = $this->storeVisitInfo($iTrackingId, $aTrackingData);
        }
        
        do_action('mc_track');
    }

    /**
     * Checks if session data is setuped in the right way
     * 
     * @return boolean
     */
    private function checkSessionData() {
        return isset($_SESSION['visit_id'])
                && isset($_SESSION['visit_time'])
                && isset($_SESSION['visitor_id']);
    }

    /**
     * Checks cookies data
     * 
     * @return boolean
     */
    private function checkCookiesData() {
        return isset($_COOKIE)
                && isset($_COOKIE['visitor_id'])
                && isset($_COOKIE['visit_time'])
                && isset($_COOKIE['visit_id'])
                && isset($_COOKIE['hostsite_id']);
    }

    /**
     * Performs storing of visit info
     * 
     * @param int $iTrackingId
     * @param array $aTrackingData
     * @return array
     */
    private function storeVisitInfo($iTrackingId, $aTrackingData) {
        // Trying to get visit data if visit data is empty or visit time has been expired then add new visit
        $oBrowscap = new Browscap(MobileComply::get_plugin_dir() . 'browscap_cache');
        $oVisit = Visit::getInstance();
        
        $sUserBrowser = $aTrackingData['tracking_user_agent'];
        $sUserBrowserVersion = '';
        $bUserIsCrawler = false;

        try {
            $oBrowserInfo = $oBrowscap->getBrowser();

            if (!empty($oBrowserInfo)) {
                $sUserBrowser = isset($oBrowserInfo->Browser) ? $oBrowserInfo->Browser : '';
                $sUserBrowserVersion = isset($oBrowserInfo->Version) ? $oBrowserInfo->Version : '';
                $bUserIsCrawler = isset($oBrowserInfo->Crawler) ? $oBrowserInfo->Crawler : '';
            }
        } catch (Exception $e) {}

        // Trying to write visit info or update current visit
        if ($this->checkSessionData()) { // If session data is presented
            if (($_SESSION['visit_time'] - time()) <= VISIT_SESSION_TIME) { // If session hasn`t expired then just update visit info
                $iVisitId = $_SESSION['visit_id'];
                $iVisitorId = $_SESSION['visitor_id'];
                $oRowVisit = $oVisit->getVisit($iVisitId);

                if (!empty($oRowVisit)) {
                    $this->updateVisit($oRowVisit, $iTrackingId);
                } else {
                    $iVisitId = $this->addNewVisit($sUserBrowser, $iTrackingId, $aTrackingData, $iVisitorId, $bUserIsCrawler);
                }
            } else { // If session data has expired then add new visit
                $iVisitorId = $_SESSION['visitor_id'];

                $iVisitId = $this->addNewVisit($sUserBrowser, $iTrackingId, $aTrackingData, $iVisitorId, $bUserIsCrawler);
            }
        } else { // If there is no session data
            $oVisitor = Visitor::getInstance();
            $iVisitId = 0;
            $iVisitorId = 0;

            if ($this->checkCookiesData()) { // Try to check cookie data and get visitor id
                $iVisitorId = $_COOKIE['visitor_id'];
                $sVisitTime = $_COOKIE['visit_time'];
                $iVisitId = $_COOKIE['visit_id'];

                $oRowVisit = $oVisit->getVisit($iVisitId);

                if ((abs(time() - $sVisitTime) < VISIT_SESSION_TIME) && (!empty($oRowVisit))) {
                    $this->updateVisit($oRowVisit, $iTrackingId);
                } else {
                    $iVisitId = $this->addNewVisit($sUserBrowser, $iTrackingId, $aTrackingData, $iVisitorId, $bUserIsCrawler);
                }
            } else { // If cookie is empty the try to get visitor by ip and user agent
                $oRowVisitor = $oVisitor->getVisitorByIpAndUserAgent($aTrackingData['tracking_ip'], $aTrackingData['tracking_user_agent']);
                
                if ($oRowVisitor) { // If such user is presented in system
                    $iVisitorId = $oRowVisitor->visitor_id;

                    // Try to get last user`s visit
                    $oRowVisit = $oVisit->getLastVisit($iVisitorId);

                    if (!empty($oRowVisit)) { // If visit is presented and session time has not expired then just update visit info
                        $iVisitId = $oRowVisit->visit_id;

                        list($iYear, $iMonth, $iDay, $iHour, $iMinute, $iSecond) = sscanf($oRowVisit->visit_date_finish, '%d-%d-%d %d:%d:%d');
                        $iVisitTime = mktime($iHour, $iMinute, $iSecond, $iMonth, $iDay, $iYear);

                        if (abs($iVisitTime - time()) < VISIT_SESSION_TIME) {
                            $this->updateVisit($oRowVisit, $iTrackingId);
                        } else {
                            $iVisitId = 0;
                        }
                    }
                }
            }

            if (!$iVisitorId) { // If there is no visitor then create new visitor
                $iVisitorId = $oVisitor->addVisitor();
            }

            if (!$iVisitId) { // If there is no visit then create new visit
                $iVisitId = $this->addNewVisit($sUserBrowser, $iTrackingId, $aTrackingData, $iVisitorId, $bUserIsCrawler);
            }
        }

        $aTrackingData['visit_id'] = $iVisitId;
        $aTrackingData['visitor_id'] = $iVisitorId;
        
        self::$iVisitorId = $iVisitorId;
        
        $this->editTracking($iTrackingId, $aTrackingData);

        return $aTrackingData;
    }
    
    /**
     *
     * @global WP_Query $wp_query
     * @param array $aTrackingData
     * @return array
     */
    private function addWordpressData($aTrackingData) {
        global $wp_query;
        
        if (isset($wp_query->query_vars)) {
            $query_vars = $wp_query->query_vars;
            
            if ((is_page() || is_single()) && have_posts()) {
                the_post();
                
                if (is_page()) {
                    $aTrackingData['page_id'] = get_the_ID();
                } else {
                    $aTrackingData['post_id'] = get_the_ID();
                }
                
                $aTrackingData['tracking_page_title'] = get_the_title();
                
                rewind_posts();
            }
            
            if (!empty ($query_vars['cat'])) {
                $aTrackingData['cat'] = $query_vars['cat'];
                $aTrackingData['tracking_page_title'] = get_cat_name($aTrackingData['cat']);
            }
            
            if (!empty ($query_vars['author'])) {
                $aTrackingData['author'] = $query_vars['author'];
                
                $userdata = get_userdata($query_vars['author']);
                if ($userdata) {
                    $aTrackingData['tracking_page_title'] = 'Author: ' . $userdata->user_login;
                }
            }
            
            if (!empty ($query_vars['tag_id'])) {
                $aTrackingData['tag_id'] = $query_vars['tag_id'];
                $aTrackingData['tracking_page_title'] = 'Tag: ' . single_tag_title( '', false );
            }
            
            if (!empty ($query_vars['s'])) {
                $aTrackingData['tracking_search'] = $query_vars['s'];
                $aTrackingData['tracking_page_title'] = 'Search: ' . $query_vars['s'];
            }
            
            if (!empty ($query_vars['m'])) {
                $aTrackingData['date'] = $query_vars['m'];
                
                if ( is_day() ) {
                    $aTrackingData['tracking_page_title'] = sprintf( __( 'Daily Archives: %s', 'twentyeleven' ), get_the_date() );
                } elseif ( is_month() ) {
                    $aTrackingData['tracking_page_title'] = sprintf( __( 'Monthly Archives: %s', 'twentyeleven' ), get_the_date( 'F Y' ) );
                } elseif ( is_year() ) {
                    $aTrackingData['tracking_page_title'] = sprintf( __( 'Yearly Archives: %s', 'twentyeleven' ), get_the_date( 'Y' ) );
                }
            }
            
            if (is_front_page()) {
                $aTrackingData['is_front_page'] = 1;
                $aTrackingData['tracking_page_title'] = 'Home';
            }
            
            if (is_user_logged_in()) {
                global $current_user;
                get_current_user();
                
                $aTrackingData['user_id'] = $current_user->ID;
            }
        }
        
        return $aTrackingData;
    }

    /**
     * Adds new visit and returns id of new visit
     *
     * @param string $sUserBrowser
     * @param array $aTrackingData
     * @param int $iVisitorId
     * @param boolean $bUserIsCrawler
     * @return int
     */
    private function addNewVisit($sUserBrowser, $iTrackingId, $aTrackingData, $iVisitorId, $bUserIsCrawler) {
        $oVisit = Visit::getInstance();

        // Add new visit
        $aNewVisit = array();

        $aNewVisit['visit_browser'] = $sUserBrowser;
        $aNewVisit['visit_user_agent'] = $aTrackingData['tracking_user_agent'];
        $aNewVisit['visit_cookie_flag'] = setcookie('visitor_id', $iVisitorId, time() + 63072000);
        $aNewVisit['visit_date_start'] = date('Y-m-d H:i:s', time());
        $aNewVisit['tracking_id_start'] = $iTrackingId;
        $aNewVisit['visit_date_finish'] = date('Y-m-d H:i:s', time());
        $aNewVisit['tracking_id_finish'] = $iTrackingId;
        $aNewVisit['visit_ip'] = $aTrackingData['tracking_ip'];
        $aNewVisit['visitor_id'] = $iVisitorId;
        $aNewVisit['visit_is_crawler'] = $bUserIsCrawler;
        $aNewVisit['tracking_device'] = $this->getUserDevice();

        $iVisitId = $oVisit->addVisit($aNewVisit);

        $_SESSION['visit_id'] = $iVisitId;
        $_SESSION['visit_time'] = time();
        $_SESSION['visitor_id'] = $iVisitorId;

        setcookie('visit_time', time(), time() + 63072000);
        setcookie('visit_id', $iVisitId, time() + 63072000);

        return $iVisitId;
    }

    /**
     * Update visit info
     *
     * @param object $oRowVisit
     * @return boolean
     */
    private function updateVisit($oRowVisit, $iTrackingId) {
        $oVisit = Visit::getInstance();

        $oRowVisit->visit_date_finish = date('Y-m-d H:i:s', time());
        $oRowVisit->visit_cookie_flag = setcookie('visitor_id', $oRowVisit->visitor_id, time() + 63072000);
        $oRowVisit->tracking_id_finish = $iTrackingId;

        setcookie('visit_time', time(), time() + 63072000);
        setcookie('visit_id', $oRowVisit->visit_id, time() + 63072000);

        $_SESSION['visit_id'] = $oRowVisit->visit_id;
        $_SESSION['visit_time'] = time();
        $_SESSION['visitor_id'] = $oRowVisit->visitor_id;

        return $oVisit->editVisit($oRowVisit->visit_id, $oRowVisit);
        ;
    }
    
    /**
     * Returns user's device name like iPhone, iPad, Android, WP7
     * 
     * @return string
     */
    private function getUserDevice() {
        $uagent_info = new uagent_info();
        
        if ($uagent_info->DetectIphone()) {
            return 'iPhone';
        } else if ($uagent_info->DetectIpod()) {
            return 'iPod';
        } else if ($uagent_info->DetectIpad()) {
            return 'iPad';
        } else if ($uagent_info->DetectAndroidPhone()) {
            return 'Android Phone';
        } else if ($uagent_info->DetectAndroidTablet()) {
            return 'Android Tablet';
        } else if ($uagent_info->DetectAndroid()) {
            return 'Android';
        } else if ($uagent_info->DetectWindowsPhone7()) {
            return 'WP7';
        } else if ($uagent_info->DetectWindowsMobile()) {
            return 'Windows Mobile';
        } else if ($uagent_info->DetectBlackBerry()) {
            return 'BlackBerry';
        } else if ($uagent_info->DetectSmartphone()) {
            return 'Smartphone';
        } else {
            return '';
        }
    }

    public static function getCurrentVisitorId() {
        return self::$iVisitorId;
    }
}