<?php

### RGB >> HSL

function _color_rgb2hsl($rgb) {
    $r = $rgb[0];
    $g = $rgb[1];
    $b = $rgb[2];
    $min = min($r, min($g, $b));
    $max = max($r, max($g, $b));
    $delta = $max - $min;
    $l = ($min + $max) / 2;
    $s = 0;
    if ($l > 0 && $l < 1) {
        $s = $delta / ($l < 0.5 ? (2 * $l) : (2 - 2 * $l));
    }
    $h = 0;
    if ($delta > 0) {
        if ($max == $r && $max != $g)
            $h += ($g - $b) / $delta;
        if ($max == $g && $max != $b)
            $h += (2 + ($b - $r) / $delta);
        if ($max == $b && $max != $r)
            $h += (4 + ($r - $g) / $delta);
        $h /= 6;
    } return array($h, $s, $l);
}

### HSL >> RGB

function _color_hsl2rgb($hsl) {
    $h = $hsl[0];
    $s = $hsl[1];
    $l = $hsl[2];
    $m2 = ($l <= 0.5) ? $l * ($s + 1) : $l + $s - $l * $s;
    $m1 = $l * 2 - $m2;
    return array(_color_hue2rgb($m1, $m2, $h + 0.33333),
        _color_hue2rgb($m1, $m2, $h),
        _color_hue2rgb($m1, $m2, $h - 0.33333));
}

### Helper function for _color_hsl2rgb().

function _color_hue2rgb($m1, $m2, $h) {
    $h = ($h < 0) ? $h + 1 : (($h > 1) ? $h - 1 : $h);
    if ($h * 6 < 1)
        return $m1 + ($m2 - $m1) * $h * 6;
    if ($h * 2 < 1)
        return $m2;
    if ($h * 3 < 2)
        return $m1 + ($m2 - $m1) * (0.66666 - $h) * 6;
    return $m1;
}

### Convert a hex color into an RGB triplet.

function _color_unpack($hex, $normalize = false) {
    $out = array();

    if (strlen($hex) == 4) {
        $hex = $hex[1] . $hex[1] . $hex[2] . $hex[2] . $hex[3] . $hex[3];
    } $c = hexdec($hex);
    for ($i = 16; $i >= 0; $i -= 8) {
        $out[] = (($c >> $i) & 0xFF) / ($normalize ? 255 : 1);
    } return $out;
}

### Convert an RGB triplet to a hex color.

function _color_pack($rgb, $normalize = false) {
    $out = 0;

    foreach ($rgb as $k => $v) {
        $out |= (($v * ($normalize ? 255 : 1)) << (16 - $k * 8));
    }return '#' . str_pad(dechex($out), 6, 0, STR_PAD_LEFT);
}

/**
 * Converts URL to file path
 * 
 * @param string $url
 * @return string
 */
function convertUrlToPath($url) {
    $path = str_replace(get_home_url(), ABSPATH, $url); 
    
    return $path;
}

if (!function_exists('home_url')) {

    /**
     * Retrieve the home url for the current site.
     *
     * Returns the 'home' option with the appropriate protocol,  'https' if
     * is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl() is
     * overridden.
     *
     * @package WordPress
     * @since 3.0.0
     *
     * @uses get_home_url()
     *
     * @param  string $path   (optional) Path relative to the home url.
     * @param  string $scheme (optional) Scheme to give the home url context. Currently 'http','https'
     * @return string Home url link with optional path appended.
     */
    function home_url($path = '', $scheme = null) {
        return get_home_url(null, $path, $scheme);
    }

}

if (!function_exists('get_home_url')) {

    /**
     * Retrieve the home url for a given site.
     *
     * Returns the 'home' option with the appropriate protocol,  'https' if
     * is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl() is
     * overridden.
     *
     * @package WordPress
     * @since 3.0.0
     *
     * @param  int $blog_id   (optional) Blog ID. Defaults to current blog.
     * @param  string $path   (optional) Path relative to the home url.
     * @param  string $scheme (optional) Scheme to give the home url context. Currently 'http','https'
     * @return string Home url link with optional path appended.
     */
    function get_home_url($blog_id = null, $path = '', $scheme = null) {
        $orig_scheme = $scheme;

        if (!in_array($scheme, array('http', 'https')))
            $scheme = is_ssl() && !is_admin() ? 'https' : 'http';

        if (empty($blog_id) || !is_multisite())
            $url = get_option('home');
        else
            $url = get_blog_option($blog_id, 'home');

        if ('http' != $scheme)
            $url = str_replace('http://', "$scheme://", $url);

        if (!empty($path) && is_string($path) && strpos($path, '..') === false)
            $url .= '/' . ltrim($path, '/');

        return apply_filters('home_url', $url, $path, $orig_scheme, $blog_id);
    }

}

if (!function_exists('get_template_part')) {

    /**
     * Load a template part into a template
     *
     * Makes it easy for a theme to reuse sections of code in a easy to overload way
     * for child themes.
     *
     * Includes the named template part for a theme or if a name is specified then a
     * specialised part will be included. If the theme contains no {slug}.php file
     * then no template will be included.
     *
     * The template is included using require, not require_once, so you may include the
     * same template part multiple times.
     *
     * For the parameter, if the file is called "{slug}-special.php" then specify
     * "special".
     *
     * @uses locate_template()
     * @since 3.0.0
     * @uses do_action() Calls 'get_template_part{$slug}' action.
     *
     * @param string $slug The slug name for the generic template.
     * @param string $name The name of the specialised template.
     */
    function get_template_part($slug, $name = null) {
        do_action("get_template_part_{$slug}", $slug, $name);

        $templates = array();
        if (isset($name))
            $templates[] = "{$slug}-{$name}.php";

        $templates[] = "{$slug}.php";

        locate_template($templates, true, false);
    }

}