<?php
/**
 * Controller is responsible for display and interaction with options page
 *
 * @author izmaylav
 */
class MobilecomplyAdminOptionsController extends MobilecomplyBaseController {
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Saves form values
     */
    public function save() {
        parent::save();
        
        if (isset($_POST['save_mobilecomply_options'])) {
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $site_url = urlencode(get_home_url());
                
                $activation_code = MobileComply::getDataFromServer("mobilecomply_server.php?get_activation_code=&username=$username&password=$password&site_url=$site_url");
                if ($activation_code && strlen(32)) {
                    update_option('mobilecomply_activation_code', $activation_code);
                }
            }
            
            update_option('mobilecomply_theme', $_POST['theme']);
            update_option('mobilecomply_site_title', $_POST['site_title']);
            update_option('mobilecomply_landing_page', $_POST['landing_page']);
            update_option('mobilecomply_phone_number', $_POST['phone_number']);
            update_option('mobilecomply_google_map_code', $_POST['google_map_code']);
            update_option('mobilecomply_contact_page', $_POST['contact_page']);
            update_option('mobilecomply_logo_url', $_POST['logo_url']);
            update_option('mobilecomply_footer_javascript', $_POST['footer_javascript']);
            update_option('mobilecomply_footer_copyright', $_POST['footer_copyright']);
            update_option('mobilecomply_remove_flash', $_POST['remove_flash']);
            update_option('mobilecomply_mobile_opt_in', $_POST['mobile_opt_in']);
            update_option('mobilecomply_facebook', $_POST['facebook']);
            
            update_option('mobilecomply_content_font_family', $_POST['content_font_family']);
            update_option('mobilecomply_content_font_size', $_POST['content_font_size']);
            update_option('mobilecomply_content_font_size_unit', $_POST['content_font_size_unit']);
            update_option('mobilecomply_content_font_color', $_POST['content_font_color']);
            update_option('mobilecomply_content_link_color', $_POST['content_link_color']);
            
            update_option('mobilecomply_header_font_family', $_POST['header_font_family']);
            update_option('mobilecomply_header_font_size', $_POST['header_font_size']);
            update_option('mobilecomply_header_font_size_unit', $_POST['header_font_size_unit']);
            update_option('mobilecomply_header_font_color', $_POST['header_font_color']);
            update_option('mobilecomply_header_background_color', $_POST['header_background_color']);
            
            update_option('mobilecomply_toolbar_background_color', $_POST['toolbar_background_color']);
            update_option('mobilecomply_toolbar_button_color', $_POST['toolbar_button_color']);
            update_option('mobilecomply_toolbar_button_font_family', $_POST['toolbar_button_font_family']);
            update_option('mobilecomply_toolbar_button_font_color', $_POST['toolbar_button_font_color']);
            update_option('mobilecomply_footer_copyright_font_color', $_POST['footer_copyright_font_color']);
            update_option('mobilecomply_show_top_toolbar', $_POST['show_top_toolbar']);
            update_option('mobilecomply_show_top_toolbar_search', $_POST['show_top_toolbar_search']);
            update_option('mobilecomply_show_footer_toolbar', $_POST['show_footer_toolbar']);
            
            update_option('mobilecomply_menu_font_family', $_POST['menu_font_family']);
            update_option('mobilecomply_menu_font_size', $_POST['menu_font_size']);
            update_option('mobilecomply_menu_font_size_unit', $_POST['menu_font_size_unit']);
            update_option('mobilecomply_menu_font_color', $_POST['menu_font_color']);
            update_option('mobilecomply_menu_background_color', $_POST['menu_background_color']);
            
            update_option('mobilecomply_background_color', $_POST['background_color']);
            update_option('mobilecomply_background_image_url', $_POST['background_image_url']);
            
            $current_url = admin_url( 'options-general.php?page=' . $_GET['page'] );
            wp_redirect($current_url);
            exit();
        }
    }

        /**
     * Loads options page
     */
    public function display() {
        parent::display();
        
        // Prepare data for selects
        $design_theme_options = $this->get_design_theme_list();
        $font_family_options = $this->get_font_family_list();
        $font_size_unit_options = $this->get_font_size_unit_list();
        $color_options = $this->get_color_list();
        $landing_page_options = $this->get_landing_page_list();
        $template_images = $this->get_template_images();
        $contact_page_options = $this->get_page_list();
        
        $is_activated = MobileComply::is_activated();

        // Common preferences
        $site_title = get_option('mobilecomply_site_title');
        $landing_page_select = MobilecomplyHTMLHelper::generateSelect('landing_page', $landing_page_options, get_option('mobilecomply_landing_page'));
        $phone_number = get_option('mobilecomply_phone_number');
        $google_map_code = get_option('mobilecomply_google_map_code');
        $contact_page_select = MobilecomplyHTMLHelper::generateSelect('contact_page', $contact_page_options, get_option('mobilecomply_contact_page'));
        $logo_url = get_option('mobilecomply_logo_url');
        $footer_copyright = get_option('mobilecomply_footer_copyright');
        $footer_javascript = get_option('mobilecomply_footer_javascript');
        $remove_flash = get_option('mobilecomply_remove_flash');
        $mobile_opt_in_select = MobilecomplyHTMLHelper::generateSelect('mobile_opt_in', $contact_page_options, get_option('mobilecomply_mobile_opt_in'));
        $facebook = get_option('mobilecomply_facebook');
        
        $background_color = get_option('mobilecomply_background_color');
        $background_color_select = MobilecomplyHTMLHelper::generateSelect('background_color', $color_options, $background_color, 'class="color_select"');
        $background_image_url = get_option('mobilecomply_background_image_url');
        
        $logo_width = 0;
        $logo_height = 0;
        $logo_margin_left = 0;
        $logo_margin_top = 0;
        if ($logo_url) {
            list($logo_width, $logo_height) = getimagesize(convertUrlToPath($logo_url));
            if ($logo_height > MC_MAX_LOGO_HEIGHT) {
                $logo_width = intval($logo_width * MC_MAX_LOGO_HEIGHT / $logo_height);
                $logo_height = MC_MAX_LOGO_HEIGHT;
            }

            if ($logo_width > MC_MAX_LOGO_WIDTH) {
                $logo_height = intval($logo_height * MC_MAX_LOGO_WIDTH / $logo_width);
                $logo_width = MC_MAX_LOGO_WIDTH;
            }

            $logo_margin_left = intval((MC_MAX_LOGO_WIDTH - $logo_width) / 2) + 20;
            $logo_margin_top = intval((MC_MAX_LOGO_HEIGHT - $logo_height) / 2);
        }
        //Design theme option
        $design_theme = get_option('mobilecomply_theme');
        $design_theme_select = $this->generateRadioForThemeSelect('theme', $design_theme_options, $design_theme);
        
        
        // Content preferences
        $content_font_family = get_option('mobilecomply_content_font_family');
        $content_font_family_select = MobilecomplyHTMLHelper::generateSelect('content_font_family', $font_family_options, $content_font_family, 'id="content_font_family"');
        $content_font_size = get_option('mobilecomply_content_font_size');
        $content_font_size_unit = get_option('mobilecomply_content_font_size_unit');
        $content_font_size_unit_select = MobilecomplyHTMLHelper::generateSelect('content_font_size_unit', $font_size_unit_options, $content_font_size_unit, 'id="content_font_size_unit"');
        $content_font_color = get_option('mobilecomply_content_font_color');
        $content_font_color_select = MobilecomplyHTMLHelper::generateSelect('content_font_color', $color_options, $content_font_color, 'class="color_select" id="content_font_color"');
        $content_link_color = get_option('mobilecomply_content_link_color');
        $content_link_color_select = MobilecomplyHTMLHelper::generateSelect('content_link_color', $color_options, $content_link_color, 'class="color_select"');
        
        // Header preferences
        $header_font_family = get_option('mobilecomply_header_font_family');
        $header_font_family_select = MobilecomplyHTMLHelper::generateSelect('header_font_family', $font_family_options, $header_font_family, 'id="header_font_family"');
        $header_font_size = get_option('mobilecomply_header_font_size');
        $header_font_size_unit = get_option('mobilecomply_header_font_size_unit');
        $header_font_size_unit_select = MobilecomplyHTMLHelper::generateSelect('header_font_size_unit', $font_size_unit_options, $header_font_size_unit, 'id="header_font_size_unit"');
        $header_font_color = get_option('mobilecomply_header_font_color');
        $header_font_color_select = MobilecomplyHTMLHelper::generateSelect('header_font_color', $color_options, $header_font_color, 'class="color_select"');
        $header_background_color = get_option('mobilecomply_header_background_color');
        $header_background_color_select = MobilecomplyHTMLHelper::generateSelect('header_background_color', $color_options, $header_background_color, 'class="color_select"');
        
        // Toolbar preferences
        $toolbar_background_color = get_option('mobilecomply_toolbar_background_color');
        $toolbar_background_color_select = MobilecomplyHTMLHelper::generateSelect('toolbar_background_color', $color_options, $toolbar_background_color, 'class="color_select"');
        $toolbar_button_color = get_option('mobilecomply_toolbar_button_color');
        $toolbar_button_color_select = MobilecomplyHTMLHelper::generateSelect('toolbar_button_color', $color_options, $toolbar_button_color, 'class="color_select"');
        $toolbar_button_font_family = get_option('mobilecomply_toolbar_button_font_family');
        $toolbar_button_font_family_select = MobilecomplyHTMLHelper::generateSelect('toolbar_button_font_family', $font_family_options, $toolbar_button_font_family, 'id="toolbar_button_font_family"');
        $toolbar_button_font_color = get_option('mobilecomply_toolbar_button_font_color');
        $toolbar_button_font_color_select = MobilecomplyHTMLHelper::generateSelect('toolbar_button_font_color', $color_options, $toolbar_button_font_color, 'class="color_select"');
        $footer_copyright_font_color = get_option('mobilecomply_footer_copyright_font_color');
        $footer_copyright_font_color_select = MobilecomplyHTMLHelper::generateSelect('footer_copyright_font_color', $color_options, $footer_copyright_font_color, 'class="color_select"');
        $show_top_toolbar = get_option('mobilecomply_show_top_toolbar');
        $show_top_toolbar_search = get_option('mobilecomply_show_top_toolbar_search');
        $show_footer_toolbar = get_option('mobilecomply_show_footer_toolbar');
        
        // Main menu preferences
        $menu_font_family = get_option('mobilecomply_menu_font_family');
        $menu_font_family_select = MobilecomplyHTMLHelper::generateSelect('menu_font_family', $font_family_options, $menu_font_family, 'id="menu_font_family"');
        $menu_font_size = get_option('mobilecomply_menu_font_size');
        $menu_font_size_unit = get_option('mobilecomply_menu_font_size_unit');
        $menu_font_size_unit_select = MobilecomplyHTMLHelper::generateSelect('menu_font_size_unit', $font_size_unit_options, $menu_font_size_unit, 'id="menu_font_size_unit"');
        $menu_font_color = get_option('mobilecomply_menu_font_color');
        $menu_font_color_select = MobilecomplyHTMLHelper::generateSelect('menu_font_color', $color_options, $menu_font_color, 'class="color_select"');
        $menu_background_color = get_option('mobilecomply_menu_background_color');
        $menu_background_color_select = MobilecomplyHTMLHelper::generateSelect('menu_background_color', $color_options, $menu_background_color, 'class="color_select"');
        
        $hsl = _color_rgb2hsl(_color_unpack($menu_background_color));
        $hsl[2] -= 30;
        $menu_background_color_light = _color_pack(_color_hsl2rgb($hsl));
        $menu_background_color_light = substr($menu_background_color_light, 1);
        if (strlen($menu_background_color_light) > 6) $menu_background_color_light = '000000';
        require_once MobileComply::get_plugin_dir() . 'admin_views/options.php';
    }
    /**
     * Return list of available design themes
     * 
     * @return array
     */
    private function get_design_theme_list() {
        $theme_list = array(
            array('value' => 'default', 'title' => 'Default Theme'),
            array('value' => 'new', 'title' => 'New Theme')
        );
        
        return $theme_list;
    }
    
    /**
     * Return list of font families, that is ready to use for generating of select
     * 
     * @return array
     */
    private function get_font_family_list() {
        /*$font_family_list = array(
            'Helvetica' => '', 
            'Arial' => '', 
            'Verdana' => '', 
            'Tahoma' => '', 
            'Georgia' => ''
        );
        
        $style_file_content = $this->get_styles_file();
        $font_family_lines = array();
        
        // Try to find font-family options in template's CSS
        if (preg_match_all('(font-family[ ]*:([a-z,A-Z \,\'"]+)\;)', $style_file_content, $font_family_lines)) {
            $font_family_lines = $font_family_lines[1];
            
            // Look through all font-family records
            foreach ($font_family_lines as $font_family_line) {
                // If there is several font-families in one record then separate them
                $font_family_line_items = explode(',', $font_family_line);
                
                // Add new font-families to the main list
                foreach ($font_family_line_items as $font_family) {
                    $font_family = trim($font_family);
                    
                    if (!isset ($font_family_list[$font_family]) && ($font_family != 'inherit')) {
                        $font_family_list[$font_family] = '';
                    }
                }
            }
        }
        
        foreach ($font_family_list as $font_family => $empty) {
            $font_family_options[] = array('value' => $font_family, 'title' => $font_family);
        }*/
        
        $font_family_options = array(
            array('value' => 'American Typewriter', 'title' => 'American Typewriter'),
            array('value' => 'Arial', 'title' => 'Arial'),
            array('value' => 'Arial Rounded MT Bold', 'title' => 'Arial Rounded MT Bold'),
            array('value' => 'Courier New', 'title' => 'Courier New'),
            array('value' => 'Georgia', 'title' => 'Georgia'),
            array('value' => 'Helvetica', 'title' => 'Helvetica'),
            array('value' => 'Marker Felt', 'title' => 'Marker Felt'),
            array('value' => 'Times New Roman', 'title' => 'Times New Roman'),
            array('value' => 'Trebuchet MS', 'title' => 'Trebuchet MS'),
            array('value' => 'Verdana', 'title' => 'Verdana')
        );
        
        return $font_family_options;
    }
    
    /**
     * Return list of font sizes, that is ready to use for generating of select
     * 
     * @return array
     */
    private function get_font_size_unit_list() {
        $font_size_unit_options = array(
            array('value' => 'px', 'title' => 'px'),
            array('value' => 'em', 'title' => 'em'),
            array('value' => '%', 'title' => '%')
        );
        
        return $font_size_unit_options;
    }
    
    /**
     * Return list of colors, that is ready to use for generating of select
     * 
     * @return array
     */
    private function get_color_list() {
        $color_options = array();
        $colors_list = array(
            '#ffffff' => 'ffffff',
            '#000000' => '000000'
        );
        
        $options_with_colors = array(
            'mobilecomply_content_font_color',
            'mobilecomply_content_link_color',
            'mobilecomply_header_font_color',
            'mobilecomply_header_background_color',
            'mobilecomply_toolbar_background_color',
            'mobilecomply_toolbar_button_color',
            'mobilecomply_toolbar_button_font_color',
            'mobilecomply_footer_copyright_font_color',
            'mobilecomply_menu_font_color',
            'mobilecomply_menu_background_color',
            'mobilecomply_background_color'
        );
        foreach ($options_with_colors as $option_with_color) {
            $option_color = get_option($option_with_color);
            if ($option_color) {
                $colors_list['#' . $option_color] = $option_color;
            }
        }
        
        $style_file_content = $this->get_styles_file();
        $colors_from_style = array();
        // Look for 'color' CSS options
        if (preg_match_all('({[^{}]+(:[^:;#]*(#[0-9a-zA-Z]+)[^;]*;[^{}])[^{}]+)', $style_file_content, $colors_from_style)) {            
            $colors_from_style = $colors_from_style[2];
            foreach ($colors_from_style as $color) {
                // If this is short version of color then make it long
                if (strlen($color) == 4) {
                    $color = '#' . $color[1] . $color[1] . $color[2] . $color[2] . $color[3] . $color[3];
                }
                
                // Add new color to the list
                if (!isset ($colors_list[$color])) {
                    $colors_list[$color] = substr($color, 1);
                }
            }
            
            $colors_list = array_unique($colors_list);
        }
        
        foreach ($colors_list as $color => $value) {
            if (strlen($value) == 6) {
                $color_options[] = array('value' => $value, 'title' => $color);
            }
        }
        
        
        return $color_options;
    }
    
    /**
     * Returns list of landing page types, that is ready to use for generating of select
     * 
     * @return array
     */
    private function get_landing_page_list() {
        $landing_page_options = array(
            array('value' => 'recent_posts', 'title' => 'Recent posts')
        );
        
        $pages_options = $this->get_page_list();
        array_shift($pages_options);
        foreach ($pages_options as $page_option) {
            $landing_page_options[] = array(
                'value' => 'page-' . $page_option['value'],
                'title' => 'Page: ' . $page_option['title']
            );
        }
        
        return $landing_page_options;
    }
    
    /**
     * Returns list of pages, that is ready to use for generating of select
     * 
     * @return array
     */
    private function get_page_list() {
        $pages_options = array(
            array('value' => '', 'title' => '- Select page -')
        );
        $pages = get_pages();
        
        if ($pages) {
            foreach ($pages as $page) {
                $pages_options[] = array('value' => $page->ID, 'title' => $page->post_title);
            }
        }
        
        return $pages_options;
    }

        /**
     * Returns template's images URLs
     * 
     * @return array 
     */
    private function get_template_images() {
        return $this->get_files_by_type('image');
    }

    /**
     * Reads all styles files content from current template
     * 
     * @return string
     */
    private function get_styles_file() {
        $css_files = $this->get_files_by_type('css');
        
        $style_file_content = '';
        foreach ($css_files as $css_filename) {
            $css_filename = str_replace(get_template_directory_uri(), get_template_directory(), $css_filename);
            $style_file_content .= file_get_contents($css_filename);
        }
        
        return $style_file_content;
    }
    
    /**
     * Return array of files depending on their type
     * 
     * @param string $type
     * @return array
     */
    private function get_files_by_type($type) {
        $files = array();
        
        $template_directory = get_template_directory() . '/';
        $directories_list = array($template_directory);
        // Go through template's directories and find images
        while (!empty($directories_list)) {
            $cur_directory_path = end($directories_list);
            $cur_directory_res = opendir($cur_directory_path);
            array_pop($directories_list);
            
            // Read directory
            while ($file = readdir($cur_directory_res)) {                
                if ($file != '.' && $file != '..') {
                    $cur_file_full_path = $cur_directory_path . $file;
                    
                    if (is_dir($cur_file_full_path)) { // If cur file is derectory, then add it to stack
                        $directories_list[] = $cur_file_full_path . '/';
                    } else {
                        switch ($type) {
                            case 'image':
                                $image_size = getimagesize(convertUrlToPath($cur_file_full_path));
                                if ($image_size) { // If image then add it images' array
                                    $files[] = str_replace($template_directory, get_template_directory_uri() . '/', $cur_file_full_path);
                                }
                                break;
                            default :
                                $ext = strrchr($file, '.');
                                if ($ext == '.' . $type) {
                                    $files[] = str_replace($template_directory, get_template_directory_uri() . '/', $cur_file_full_path);
                                }
                                break;
                        }
                    }
                }
            }
        }
        
        return $files;
    }
    
    /**
     * Generates radio select with theme images
     * 
     * @param string $name
     * @param array $options
     * @param string $selected_value
     * @return string 
     */
    public function generateRadioForThemeSelect($name, $options, $selected_value = '') {
        $radio_html = '';
        foreach ($options as $option) {
            $radio_html .= '<input type = "radio" name = "' . $name . '" value="' . $option['value'] . '"';
            if (!strcmp($selected_value, $option['value'])) {
                $radio_html .= ' checked';
            }
            $radio_html .= ">";
            
            $radio_html .= '<img src="' . MobileComply::get_dir_plugin_url() . 'images/' . $option['value'] . '_theme_image.jpg" alt = "' . $option['title'] . '"></input>';
            $radio_html .= '&nbsp;&nbsp;&nbsp;&nbsp;';
        }
        return $radio_html;
    }
}
?>
