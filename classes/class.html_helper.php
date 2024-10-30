<?php

class MobilecomplyHTMLHelper {

    /**
     * Generates HTML code to display select input
     * 
     * @param string $name Name of the select input
     * @param array $options Option items array, each item is associative array with keys: 'value', 'title'
     * @param string $selected_value Selected option's value
     * @param string $attributes_string Select's attributes string
     * @return string 
     */
    public static function generateSelect($name, $options, $selected_value = '', $attributes_string = '') {
        $select_html = "<select name='$name' $attributes_string>";

        foreach ($options as $option) {
            $select_html .= "<option value='{$option['value']}'";
            if (!strcmp($selected_value, $option['value'])) {
                $select_html .= ' selected="selected"';
            }
            $select_html .= ">{$option['title']}</option>";
        }

        $select_html .= '</select>';

        return $select_html;
    }

    public static function generateRadio($name, $options, $selected_value = '', $theme_select = false) {
        $radio_html = '';
        foreach ($options as $option) {
            $radio_html .= '<input type = "radio" name = "' . $name . '" value="' . $option['value'] . '"';
            if (!strcmp($selected_value, $option['value'])) {
                $radio_html .= ' checked';
            }
            $radio_html .= ">";
            if ($theme_select) {
                $radio_html .= '<img src="' . plugins_url() . '/mobilecomply/images/' . $option['value'] . '_theme_image.jpg" alt = "' . $option['title'] . '"></input>';
                $radio_html .= '&nbsp;&nbsp;&nbsp;&nbsp;';
            } else {
                $radio_html .= $option['title'] . "</input>";
            }
        }
        return $radio_html;
    }

}

?>
