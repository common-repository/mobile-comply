<?php
wp_enqueue_script('jquery');
wp_enqueue_script('jquery_validate', get_template_directory_uri() . '/js/jquery.validate.js');
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
}
add_filter('show_admin_bar', '__return_false');

// Get theme custom preferences
$site_title = get_option('mobilecomply_site_title');
$landing_page = get_option('mobilecomply_landing_page');
$phone_number = get_option('mobilecomply_phone_number');
$google_map_code = get_option('mobilecomply_google_map_code');
$contact_page = get_option('mobilecomply_contact_page');
$logo_url = get_option('mobilecomply_logo_url');
$footer_copyright = get_option('mobilecomply_footer_copyright');
$footer_javascript = get_option('mobilecomply_footer_javascript');
$opt_in_page_id = get_option('mobilecomply_mobile_opt_in');

$background_color = get_option('mobilecomply_background_color');
$background_image_url = get_option('mobilecomply_background_image_url');

// Header preferences
$header_font_family = get_option('mobilecomply_header_font_family');
$header_font_size = get_option('mobilecomply_header_font_size');
$header_font_size_unit = get_option('mobilecomply_header_font_size_unit');
$header_font_color = get_option('mobilecomply_header_font_color');
$header_background_color = get_option('mobilecomply_header_background_color');

// Toolbar preferences
$toolbar_background_color = get_option('mobilecomply_toolbar_background_color');
$toolbar_button_color = get_option('mobilecomply_toolbar_button_color');
$toolbar_button_font_family = get_option('mobilecomply_toolbar_button_font_family');
$toolbar_button_font_color = get_option('mobilecomply_toolbar_button_font_color');
$footer_copyright_font_color = get_option('mobilecomply_footer_copyright_font_color');
$show_top_toolbar = get_option('mobilecomply_show_top_toolbar');
$show_top_toolbar_search = get_option('mobilecomply_show_top_toolbar_search');
$show_footer_toolbar = get_option('mobilecomply_show_footer_toolbar');

// Menu preferences
$menu_font_family = get_option('mobilecomply_menu_font_family');
$menu_font_size = get_option('mobilecomply_menu_font_size');
$menu_font_size_unit = get_option('mobilecomply_menu_font_size_unit');
$menu_font_color = get_option('mobilecomply_menu_font_color');
$menu_background_color = get_option('mobilecomply_menu_background_color');

$hsl = _color_rgb2hsl(_color_unpack($menu_background_color));
$hsl[2] -= 30;
$menu_background_color_light = _color_pack(_color_hsl2rgb($hsl));
$menu_background_color_light = substr($menu_background_color_light, 1);

// Content preferences
$content_font_family = get_option('mobilecomply_content_font_family');
$content_font_size = get_option('mobilecomply_content_font_size');
$content_font_size_unit = get_option('mobilecomply_content_font_size_unit');
$content_font_color = get_option('mobilecomply_content_font_color');
$content_link_color = get_option('mobilecomply_content_link_color');

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

function custom_excerpt_length( $length ) 
{
	return 10;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function new_excerpt_more($more) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');


$oMCWpError = new WP_Error();

// Save opt in data
$sOptInSuccess = '';
if (isset ($_SESSION['mc_opt_in_success'])) {
    $sOptInSuccess =  $_SESSION['mc_opt_in_success'];
    unset ($_SESSION['mc_opt_in_success']);
}

function saveOptInData() {
    global $oMCWpError, $contact_page, $opt_in_page_id;
    
    if (isset ($_POST['submit_opt_in'])
    && isset ($_POST['opt_in_name'])
    && isset ($_POST['opt_in_mobile_number'])
    && isset ($_POST['opt_in_email'])
    && isset ($_POST['receive_mobile_offers'])) {        
        $oMobilecomplyOptIn = new MobilecomplyOptIn();
        
        if (empty ($_POST['opt_in_name'])) {
            $oMCWpError->add(1000, 'Please, fill in name field.');
        }

        if (empty ($_POST['opt_in_mobile_number'])) {
            $oMCWpError->add(1000, 'Please, fill in mobile number field.');
        }

        if (empty ($_POST['opt_in_email'])) {
            $oMCWpError->add(1000, 'Please, fill in e-mail field.');
        }
        
        if ($oMobilecomplyOptIn->isUserRegisteredWithEmail($_POST['opt_in_email'])) {
            $oMCWpError->add(1000, 'User with such e-mail is already registered in system.');
        }

        if (!$oMCWpError->get_error_messages()) {
            $aNewOptInUser = array(
                'opt_in_name' => $_POST['opt_in_name'],
                'opt_in_mobile_phone' => $_POST['opt_in_mobile_number'],
                'opt_in_email' => $_POST['opt_in_email'],
                'visitor_id' => MobilecomplyTracking::getCurrentVisitorId(),
                'opt_in_date' => current_time('mysql'),
                'opt_in_receive_mobile_offers' => $_POST['receive_mobile_offers']
            );

            $oMobilecomplyOptIn->addNewOptInUser($aNewOptInUser);

            $sMessage = '';
            if ($_POST['receive_mobile_offers']) {
                $_SESSION['mc_opt_in_success'] = 'Thank you for your registration for mobile offers!';
                $sMessage = 'Yes';
            } else {
                $_SESSION['mc_opt_in_success'] = 'We are sorry you selected not to receive mobile offers. If you change your mind please email us!';
                
                if ($contact_page) {
                    $_SESSION['mc_opt_in_success'] .= ' <a href="' . get_permalink($contact_page) . '">' . get_the_title($contact_page) . '</a>';
                }
                
                $sMessage = 'No';
            }
                        
            mail($_POST['opt_in_email'], 'Registration result', $sMessage);
            
            wp_redirect(get_permalink($opt_in_page_id));
            exit();
        } else {
            $oMCWpError->add_data($_POST, '1000');
        }
    }
}
add_action('mc_track', 'saveOptInData');

function showOptInForm() {
    $oMobilecomplyOptIn = new MobilecomplyOptIn();
    $iVisitorId = MobilecomplyTracking::getCurrentVisitorId();
    
    return !$oMobilecomplyOptIn->isVisitorRegistered($iVisitorId);
}
