<?php
/**
 * Controller for statistic page
 *
 * @author izmaylav
 */
class MobilecomplyAdminStatisticController extends MobilecomplyBaseController {
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Displays controller's view
     */
    public function display() {
        global $wpdb;
        
        parent::display();
        
        $query = "SELECT COUNT(t.tracking_id) FROM {$wpdb->prefix}tracking AS t";
        $total_hits = $wpdb->get_var($query);
        
        $query = "SELECT COUNT(v.visitor_id) FROM {$wpdb->prefix}visitor AS v";
        $total_visitors = $wpdb->get_var($query);
        
        $query = "SELECT COUNT(v.visit_id) FROM {$wpdb->prefix}visit AS v";
        $total_visits = $wpdb->get_var($query);
        
        $query = "SELECT COUNT(t.tracking_id) 
                    FROM {$wpdb->prefix}tracking AS t 
                    LEFT JOIN {$wpdb->prefix}visit AS v
                    ON t.visit_id=v.visit_id
                    WHERE v.tracking_device!=''";
        $total_mobilecomply_hits = $wpdb->get_var($query);
        
        $query = "SELECT COUNT(vr.visitor_id) 
                    FROM {$wpdb->prefix}visitor AS vr 
                    LEFT JOIN {$wpdb->prefix}visit AS v
                    ON vr.visitor_id=v.visitor_id
                    WHERE v.tracking_device!=''";
        $total_mobilecomply_visitors = $wpdb->get_var($query);
        
        $query = "SELECT COUNT(v.visit_id) FROM {$wpdb->prefix}visit AS v WHERE v.tracking_device!=''";
        $total_mobilecomply_visits = $wpdb->get_var($query);
        
        $query = "SELECT COUNT(opt_in_id) FROM {$wpdb->prefix}opt_in";
        $total_mobilecomply_opt_in = $wpdb->get_var($query);
        
        $query = "SELECT MIN(t.tracking_date) AS date FROM {$wpdb->prefix}tracking AS t";
        $start_date = $wpdb->get_var($query);
        
        $start_date_seconds = strtotime($start_date);
        $end_date_seconds = time();
        
        $chart_elements_number = 10;
        $display_chart = false;
        if (($end_date_seconds - $start_date_seconds) > 10) {
            $display_chart = true;
            
            $total_per_date = array(0);
            $total_mobilecomply_per_date = array(0);
            $ios_per_date = array(0);
            $android_pre_date = array(0);
            $wp7_per_date = array(0);
            $date_list = array(date('d F, Y, H:i:s', $start_date_seconds));
            $period = intval(($end_date_seconds - $start_date_seconds) / $chart_elements_number);
            
            $cur_date = $start_date_seconds;
            $new_date = $start_date_seconds + $period;
            for ($i = 0; $i < $chart_elements_number; ++$i) {
                $date_list[] = date('d F, Y, H:i:s', $new_date);
                
                // Get total hits
                $query = "SELECT COUNT(t.tracking_id) AS hits 
                        FROM {$wpdb->prefix}tracking AS t 
                        WHERE 
                        tracking_date>=%s
                        AND tracking_date<=%s";
                        
                $total_per_date[] = $wpdb->get_var( 
                        $wpdb->prepare($query, date('Y-m-d H:i:s', $cur_date), date('Y-m-d H:i:s', $new_date)) 
                );
                
                $query = "SELECT COUNT(t.tracking_id) AS hits 
                        FROM {$wpdb->prefix}tracking AS t 
                        LEFT JOIN {$wpdb->prefix}visit AS v
                        ON t.visit_id=v.visit_id
                        WHERE 
                        t.tracking_date>=%s
                        AND t.tracking_date<=%s
                        AND v.tracking_device!=''";
                        
                $total_mobilecomply_per_date[] = $wpdb->get_var( 
                        $wpdb->prepare($query, date('Y-m-d H:i:s', $cur_date), date('Y-m-d H:i:s', $new_date)) 
                );
                
                $cur_date = $new_date;
                $new_date += $period;
            }
        }
        
        require_once MobileComply::get_plugin_dir() . 'admin_views/statistic.php';
    }
}
?>
