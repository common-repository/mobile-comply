<?php
/**
 * Responsible for replacing of standard template with template for mobile devices
 */
class MobilecomplyFrontend {
    /**
     * Constructor
     */
    public function __construct() {
        add_filter('stylesheet', array(&$this, 'get_stylesheet'));
        add_filter('theme_root', array(&$this, 'get_template_directory'));
        add_filter('theme_root_uri', array(&$this, 'get_template_root_uri'));
        add_filter('template', array(&$this, 'get_template'));
        add_filter('the_content', array(&$this, 'remove_swf'));
        add_filter('get_the_excerpt', array(&$this, 'remove_swf'));
    }
    
    /**
     * Returns stylesheet's directory
     * 
     * @param string $stylesheet
     * @return string
     */
    public function get_stylesheet($stylesheet) {
        return get_option('mobilecomply_theme');
    }

    /**
     * Returns template's name
     * 
     * @param string $template
     * @return string
     */
    public function get_template($template) {
        return get_option('mobilecomply_theme');
    }

    /**
     * Returns template's directory
     * 
     * @param string $value
     * @return string
     */
    public function get_template_directory($value) {
        return MobileComply::get_plugin_dir() . '/themes';
    }

    /**
     * Returns template's URL
     * 
     * @param string $url
     * @return string 
     */
    public function get_template_root_uri($url) {
        return MobileComply::get_dir_plugin_url() . 'themes';
    }
    
    /**
     * Removes swf from content
     * 
     * @param string $content
     * @return string
     */
    public function remove_swf($content) {
        $uagent_info = MobileComply::get_uagent_info();
        
        $remove_flash = get_option('mobilecomply_remove_flash');        
        if ($remove_flash && $uagent_info->DetectIos() || $uagent_info->DetectWindowsPhone7()) {
            $content = preg_replace('/<object(.*)<\/object>/i', 
'', $content);
        }
        
        return $content;
    }
}
?>
