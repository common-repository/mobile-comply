<?php
/**
 * @package Mobilecomply theme
 * @author Mobilecomply
 * @version 1.0
 */
/*
Plugin Name: Mobilecomply theme
Plugin URI: http://mobilecomply.com/#
Description: This is plugin that change main theme to specific for mobile devices
Version: 1.0
Author: Mobilecomply
Author URI: http://mobilecomply.com/
License: GPL2
*/

require_once ABSPATH . WPINC . '/pluggable.php';
require_once 'functions.php';
require_once 'classes/class.mobilecomply.php';

register_activation_hook( __FILE__, array('MobileComply', 'install') );
register_uninstall_hook( __FILE__, array('MobileComply', 'uninstall') );

new MobileComply();
?>
