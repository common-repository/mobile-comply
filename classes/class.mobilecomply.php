<?php

/**
 * Main class which is responsible for install of plugin, returns common variables
 * users' tracking and also it defines if user is using mobile device
 */
define('MC_MAX_LOGO_HEIGHT', 130);
define('MC_MAX_LOGO_WIDTH', 220);
define('MCI_SERVER', 'http://www.mobilecomply.com/');

require_once 'class.mdetect.php';
require_once 'class.html_helper.php';
require_once 'class.frontend.php';
require_once 'class.admin.php';
require_once 'class.tracking.php';
require_once 'class.opt_in.php';

class MobileComply {

    /**
     * Indicates if user uses mobile phone
     * 
     * @var bool
     */
    private static $_is_mobile;

    /**
     * Plugin's directory
     * 
     * @var string
     */
    private static $_plugin_directory;

    /**
     * Plugin's directory URL
     * 
     * @var string
     */
    private static $_plugin_directory_url;

    /**
     * Stores uagent_object instance for fast access
     * 
     * @var uagent_info
     */
    private static $_uagent_info = null;

    /**
     * Performs installation actions
     */
    public static function install() {
        global $wpdb;

        // Setups default options
        add_option('mobilecomply_site_title', get_option('blogname'));
        add_option('mobilecomply_landing_page', 'recent_posts');
        add_option('mobilecomply_phone_number', '');
        add_option('mobilecomply_google_map_code', '');
        add_option('mobilecomply_contact_page', '');
        add_option('mobilecomply_logo_url', '');
        add_option('mobilecomply_footer_javascript', '');
        add_option('mobilecomply_footer_copyright', '');
        add_option('mobilecomply_remove_flash', '0');

        add_option('mobilecomply_theme', 'default');

        add_option('mobilecomply_content_font_family', 'Verdana');
        add_option('mobilecomply_content_font_size', '17');
        add_option('mobilecomply_content_font_size_unit', 'px');
        add_option('mobilecomply_content_font_color', '666666');
        add_option('mobilecomply_content_link_color', '189ad7');

        add_option('mobilecomply_header_font_family', '');
        add_option('mobilecomply_header_font_size', '24');
        add_option('mobilecomply_header_font_size_unit', 'px');
        add_option('mobilecomply_header_font_color', 'ffffff');
        add_option('mobilecomply_header_background_color', '0087e5');

        add_option('mobilecomply_toolbar_background_color', 'caab74');
        add_option('mobilecomply_toolbar_button_color', 'b9985d');
        add_option('mobilecomply_toolbar_button_font_family', 'Verdana');
        add_option('mobilecomply_toolbar_button_font_color', 'ffffff');
        add_option('mobilecomply_footer_copyright_font_color', 'ffffff');
        add_option('mobilecomply_show_top_toolbar', 1);
        add_option('mobilecomply_show_top_toolbar_search', 1);
        add_option('mobilecomply_show_footer_toolbar', 1);

        add_option('mobilecomply_menu_font_family', '');
        add_option('mobilecomply_menu_font_size', '18');
        add_option('mobilecomply_menu_font_size_unit', 'px');
        add_option('mobilecomply_menu_font_color', 'ffffff');
        add_option('mobilecomply_menu_background_color', '01327e');

        add_option('mobilecomply_background_color', 'ffffff');
        add_option('mobilecomply_background_image_url', '');

        // Creates tables
        $query = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}tracking` (
          `tracking_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
          `visit_id` int(11) unsigned NOT NULL,
          `user_id` int(11) unsigned DEFAULT '0',
          `post_id` int(11) unsigned DEFAULT '0',
          `page_id` int(11) unsigned NOT NULL,
          `cat` int(11) unsigned DEFAULT '0',
          `author` int(11) unsigned NOT NULL,
          `tag_id` int(11) unsigned NOT NULL,
          `date` varchar(8) NOT NULL,
          `is_front_page` tinyint(1) NOT NULL,
          `tracking_ip` varchar(20) DEFAULT NULL,
          `tracking_phone` varchar(20) DEFAULT NULL,
          `tracking_carrier` varchar(255) DEFAULT NULL,
          `tracking_user_agent` varchar(255) DEFAULT NULL,
          `tracking_referring_url` varchar(255) DEFAULT NULL,
          `tracking_status` enum('0','1') NOT NULL DEFAULT '1',
          `tracking_date` datetime NOT NULL,
          `tracking_url` varchar(255) NOT NULL,
          `tracking_search` varchar(255) NOT NULL,
          `tracking_page_title` varchar(255) NOT NULL,
          `visitor_id` int(11) unsigned NOT NULL,
          PRIMARY KEY (`tracking_id`),
          KEY `tracking_FKIndex3` (`post_id`),
          KEY `tracking_FKIndex4` (`cat`),
          KEY `tracking_FKIndex6` (`user_id`),
          KEY `listing_id` (`tracking_date`)
        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
        $wpdb->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}visit` (
          `visit_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `visitor_id` int(10) unsigned NOT NULL,
          `visit_ip` varchar(255) NOT NULL,
          `visit_user_agent` text NOT NULL,
          `visit_cookie_flag` tinyint(1) NOT NULL,
          `visit_browser` varchar(255) NOT NULL,
          `visit_date_start` timestamp NULL DEFAULT NULL,
          `tracking_id_start` int(11) NOT NULL,
          `visit_date_finish` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
          `tracking_id_finish` int(11) NOT NULL,
          `visit_is_crawler` tinyint(1) NOT NULL,
          `tracking_device` varchar(255) NOT NULL,
          PRIMARY KEY (`visit_id`),
          KEY `visit_browser` (`visit_browser`)
        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
        $wpdb->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}visitor` (
          `visitor_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          PRIMARY KEY (`visitor_id`)
        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
        $wpdb->query($query);

        $query = "CREATE TABLE `{$wpdb->prefix}opt_in` (
          `opt_in_id` int(11) NOT NULL AUTO_INCREMENT,
          `opt_in_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `opt_in_mobile_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `opt_in_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `visitor_id` int(11) NOT NULL,
          `opt_in_date` datetime NOT NULL,
          `opt_in_receive_mobile_offers` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
          PRIMARY KEY (`opt_in_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
        $wpdb->query($query);
    }

    /**
     * Removes plugins data from DB at uninstall
     * 
     * @global type $wpdb 
     */
    public static function uninstall() {
        global $wpdb;
        
        // Delete options
        delete_option('mobilecomply_activation_code');
        delete_option('mobilecomply_mobile_opt_in');
        delete_option('mobilecomply_facebook');
        delete_option('mobilecomply_full_site_option');
        delete_option('mobilecomply_mobile_pressroom');
        delete_option('mobilecomply_site_title');
        delete_option('mobilecomply_landing_page');
        delete_option('mobilecomply_phone_number');
        delete_option('mobilecomply_google_map_code');
        delete_option('mobilecomply_contact_page');
        delete_option('mobilecomply_logo_filename');
        delete_option('mobilecomply_logo_url');
        delete_option('mobilecomply_footer_javascript');
        delete_option('mobilecomply_footer_copyright');
        delete_option('mobilecomply_remove_flash');

        delete_option('mobilecomply_theme');

        delete_option('mobilecomply_content_font_family');
        delete_option('mobilecomply_content_font_size');
        delete_option('mobilecomply_content_font_size_unit');
        delete_option('mobilecomply_content_font_color');
        delete_option('mobilecomply_content_link_color');

        delete_option('mobilecomply_header_font_family');
        delete_option('mobilecomply_header_font_size');
        delete_option('mobilecomply_header_font_size_unit');
        delete_option('mobilecomply_header_font_color');
        delete_option('mobilecomply_header_background_color');

        delete_option('mobilecomply_toolbar_background_color');
        delete_option('mobilecomply_toolbar_button_color');
        delete_option('mobilecomply_toolbar_button_font_family');
        delete_option('mobilecomply_toolbar_button_font_color');
        delete_option('mobilecomply_footer_copyright_font_color');
        delete_option('mobilecomply_show_top_toolbar');
        delete_option('mobilecomply_show_top_toolbar_search');
        delete_option('mobilecomply_show_footer_toolbar');

        delete_option('mobilecomply_menu_font_family');
        delete_option('mobilecomply_menu_font_size');
        delete_option('mobilecomply_menu_font_size_unit');
        delete_option('mobilecomply_menu_font_color');
        delete_option('mobilecomply_menu_background_color');

        delete_option('mobilecomply_background_color');
        delete_option('mobilecomply_background_image_url');

        // Delete tables
        $query = "DROP TABLE `{$wpdb->prefix}tracking`;";
        $wpdb->query($query);

        $query = "DROP TABLE `{$wpdb->prefix}visit`;";
        $wpdb->query($query);

        $query = "DROP TABLE `{$wpdb->prefix}visitor`;";
        $wpdb->query($query);

        $query = "DROP TABLE `{$wpdb->prefix}opt_in`;";
        $wpdb->query($query);
    }

    /**
     * Constructor
     */
    public function __construct() {
        // Check if this is request from mobilecomply site to check out presenñe of mobilecomply plugin
        if (isset($_GET['is_mobilecomply_plugin'])) {
            echo 'yes';
            exit();
        }

        // Initialize instance variables
        //self::$_is_mobile = true; // For testing purposes
        self::$_is_mobile = self::_is_mobile();

        $current_class_directory = plugin_dir_path(__FILE__);
        self::$_plugin_directory = str_replace('/classes', '', $current_class_directory);

        $current_class_directory_url = plugin_dir_url(__FILE__);
        self::$_plugin_directory_url = str_replace('/classes', '', $current_class_directory_url);

        register_sidebar(array(
            'name' => __('Mobilecomply Sidebar', 'twentyeleven'),
            'id' => 'sidebar-mobilecomply',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        if (!is_admin()) {
            if (true) {
                add_action('wp', array(&$this, 'tracking')); // Track user's info
            }

            if (MobileComply::is_mobile()) {
                new MobilecomplyFrontend();
            }
        } else {
            new MobilecomplyAdmin();
        }
    }

    /**
     * Returns plugin's directory root
     * 
     * @return string
     */
    public static function get_plugin_dir() {
        return self::$_plugin_directory;
    }

    /**
     * Returns plugin's directory URL
     * 
     * @return string
     */
    public static function get_dir_plugin_url() {
        return self::$_plugin_directory_url;
    }

    /**
     * Returns true if user uses mobile phone and false in other case
     * 
     * @return boolean
     */
    public static function is_mobile() {
        return self::$_is_mobile;
    }

    /**
     * Detects if user is using mobile device
     * 
     * @return boolean
     */
    public static function _is_mobile() {
        if (self::is_activated()) {
            if (isset($_GET['mc']) && ($_GET['mc'] == 1)) {
                return true;
            }

            $uagent_info = self::get_uagent_info();

            return $uagent_info->DetectIos() || $uagent_info->DetectAndroid() || $uagent_info->DetectWindowsPhone7();
        } else {
            return false;
        }
    }

    /**
     * Checks if plugin is registered
     * 
     * @return bool
     */
    public static function is_activated() {
        $activation_code = get_option('mobilecomply_activation_code');
        if (!empty($activation_code)) {
            $site_url = urlencode(get_home_url());

            $response = self::getDataFromServer("mobilecomply_server.php?check_activation_code=$activation_code&site_url=$site_url");
            if ($response && strlen($response) == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Gets data from server
     * 
     * @param string $request
     * @return string
     */
    public static function getDataFromServer($request) {
        $hostname = str_replace('http://', '', MCI_SERVER);
        if (substr($hostname, -1) == '/') {
            $hostname = substr($hostname, 0, -1);
        }
        $fp = fsockopen($hostname, 80, $errno, $errstr, 30);
        if (!$fp) {
            return false;
        } else {
            $out = "GET /$request HTTP/1.1\r\n";
            $out .= "Host: $hostname\r\n";
            $out .= "Connection: Close\r\n\r\n";

            fwrite($fp, $out);

            $responseHeader = '';
            $result = '';
            do {
                $responseHeader.= fread($fp, 1);
            } while (!preg_match('/\\r\\n\\r\\n$/', $responseHeader));


            if (!strstr($responseHeader, "Transfer-Encoding: chunked")) {
                while (!feof($fp)) {
                    $result.= fgets($fp, 128);
                }
            } else {

                while ($chunk_length = hexdec(fgets($fp))) {
                    $responseContentChunk = '';

                    $read_length = 0;

                    while ($read_length < $chunk_length) {
                        $responseContentChunk .= fread($fp, $chunk_length - $read_length);
                        $read_length = strlen($responseContentChunk);
                    }

                    $result.= $responseContentChunk;

                    fgets($fp);
                }
            }

            fclose($fp);

            return $result;
        }
    }

    /**
     * Returns uagent_info object
     * 
     * @return uagent_info
     */
    public static function get_uagent_info() {
        if (empty(self::$_uagent_info)) {
            self::$_uagent_info = new uagent_info();
        }

        return self::$_uagent_info;
    }

    /**
     * Saves tracking data after proceeding of request
     * 
     * @param WP $oQuery
     */
    public function tracking($wp) {
        $oTracking = new MobilecomplyTracking();
        $oTracking->track();
    }

}

?>
