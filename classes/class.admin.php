<?php
require_once 'class.pagination.php';
require_once 'controllers/class.base.php';
require_once 'controllers/class.admin_options.php';
require_once 'controllers/class.admin_statistic.php';
require_once 'controllers/class.admin_opt_in.php';

class MobilecomplyAdmin {
    /**
     * Stores admin controllers objects
     * 
     * @var array
     */
    private $controllers;


    /**
     * Constructor
     */
    public function __construct() {
        $this->controllers = array(
            'options' => new MobilecomplyAdminOptionsController(),
            'statistic' => new MobilecomplyAdminStatisticController(),
            'opt_in' => new MobilecomplyAdminOptInController()
        );
        
        add_action('admin_menu', array(&$this, 'admin_actions'));
        
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('google_jsapi', 'http://www.google.com/jsapi');
        wp_enqueue_script('mobilecomply_jquery_ui', MobileComply::get_dir_plugin_url() . '/js/jquery-ui-1.8.16.custom.min.js');
        wp_enqueue_script('mobilecomply_validate', MobileComply::get_dir_plugin_url() . '/js/jquery.validate.js');
        wp_enqueue_script('mobilecomply_colorpicker_script', MobileComply::get_dir_plugin_url() . '/js/jquery.colourPicker.js');
        wp_enqueue_script('mobilecomply_gvchart_script', MobileComply::get_dir_plugin_url() . '/js/jquery.gvChart-1.0.1.min.js');
        
        wp_enqueue_style('thickbox');
        wp_enqueue_style('mobilecomply_jquery_ui', MobileComply::get_dir_plugin_url() . '/css/jquery-ui-1.8.16.custom.css');
        wp_enqueue_style('mobilecomply_colorpicker_style', MobileComply::get_dir_plugin_url() . '/css/jquery.colourPicker.css');
        wp_enqueue_style('mobilecomply_admin_style', MobileComply::get_dir_plugin_url() . '/css/admin.css');
                
        $this->save_values();
    }
    
    /**
     * Store values and if success then perform redirect
     */
    private function save_values() {
        foreach ($this->controllers as $controller) {
            $controller->save();
        }
    }

    /**
     * Adds hooks to admin part 
     */
    public function admin_actions() {
        add_menu_page(
            'Mobilecomply Options', 
            'Mobilecomply', 
            'administrator', 
            'Mobilecomply-Options', 
            array($this->controllers['options'], 'display')
        );
        
        add_submenu_page( 
            'Mobilecomply-Options',
            'Statistic', 
            'Statistic', 
            'administrator', 
            'Mobilecomply-Statistic', 
            array($this->controllers['statistic'], 'display')
        );
        
        add_submenu_page( 
            'Mobilecomply-Options',
            'Opt In', 
            'Opt In', 
            'administrator', 
            'Mobilecomply-Opt-In', 
            array($this->controllers['opt_in'], 'display')
        );
    }
}
?>
