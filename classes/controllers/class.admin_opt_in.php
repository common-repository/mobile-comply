<?php
/**
 * Controller is responsible for display of opt in list and add/edit/delete of records
 *
 * @author izmaylav
 */
class MobilecomplyAdminOptInController extends MobilecomplyBaseController {
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Performs operation on DB
     */
    public function save() {
        parent::save();
        
        if (isset ($_GET['action'])) {
            if (($_GET['action'] == 'delete') && isset ($_GET['opt_in_id'])) {
                // Delete opt in record
                $opt_in_id = intval ($_GET['opt_in_id']);
                
                $oMobilecomplyOptIn = new MobilecomplyOptIn();
                $oMobilecomplyOptIn->deleteOptInUser($opt_in_id);
                
                wp_redirect ("admin.php?page={$_GET['page']}&action=delete_success");
                exit ();
            } else if ($_GET['action'] == 'add_new_opt_in') {
                // Add new opt in record
                $oMobilecomplyOptIn = new MobilecomplyOptIn();
        
                // Check input values
                if (empty($_POST['opt_in_name'])) {
                    $this->oError->add($this->iErrorCode, 'Please, fill in name field.');
                }

                if (empty($_POST['opt_in_mobile_number'])) {
                    $this->oError->add($this->iErrorCode, 'Please, fill in mobile number field.');
                }

                if (empty($_POST['opt_in_email'])) {
                    $this->oError->add($this->iErrorCode, 'Please, fill in e-mail field.');
                }

                if ($oMobilecomplyOptIn->isUserRegisteredWithEmail($_POST['opt_in_email'])) {
                    $this->oError->add($this->iErrorCode, 'User with such e-mail is already registered in system.');
                }

                if (!$this->oError->get_error_messages($this->iErrorCode)) {
                    // Insert new record into DB
                    $aNewOptInUser = array(
                        'opt_in_name' => $_POST['opt_in_name'],
                        'opt_in_mobile_phone' => $_POST['opt_in_mobile_number'],
                        'opt_in_email' => $_POST['opt_in_email'],
                        'visitor_id' => -1,
                        'opt_in_date' => current_time('mysql'),
                        'opt_in_receive_mobile_offers' => $_POST['receive_mobile_offers']
                    );

                    $oMobilecomplyOptIn->addNewOptInUser($aNewOptInUser);

                    wp_redirect ("admin.php?page={$_GET['page']}&action=add_success");
                    exit();
                } else {
                    $this->oError->add_data($_POST, $this->iErrorCode);
                }
            } else if (isset ($_POST['edit_new_opt_in']) && isset ($_GET['opt_in_id'])) {
                // Add new opt in record
                $oMobilecomplyOptIn = new MobilecomplyOptIn();
                
                $opt_in_id = intval($_GET['opt_in_id']);
                $oRowOptIn = $oMobilecomplyOptIn->getOptInUser($opt_in_id);
                
                // Check input values
                if (empty($_POST['opt_in_name'])) {
                    $this->oError->add($this->iErrorCode, 'Please, fill in name field.');
                }

                if (empty($_POST['opt_in_mobile_number'])) {
                    $this->oError->add($this->iErrorCode, 'Please, fill in mobile number field.');
                }

                if (empty($_POST['opt_in_email'])) {
                    $this->oError->add($this->iErrorCode, 'Please, fill in e-mail field.');
                }

                if (($oRowOptIn->opt_in_email != $_POST['opt_in_email']) 
                        && $oMobilecomplyOptIn->isUserRegisteredWithEmail($_POST['opt_in_email'])) {
                    $this->oError->add($this->iErrorCode, 'User with such e-mail is already registered in system.');
                }

                if (!$this->oError->get_error_messages($this->iErrorCode)) {
                    // Insert new record into DB
                    $aOptInUser = array(
                        'opt_in_name' => $_POST['opt_in_name'],
                        'opt_in_mobile_phone' => $_POST['opt_in_mobile_number'],
                        'opt_in_email' => $_POST['opt_in_email'],
                        'visitor_id' => $oRowOptIn->visitor_id,
                        'opt_in_date' => $oRowOptIn->opt_in_date,
                        'opt_in_receive_mobile_offers' => $_POST['receive_mobile_offers']
                    );

                    $oMobilecomplyOptIn->editOptInUser($opt_in_id, $aOptInUser);

                    wp_redirect ("admin.php?page={$_GET['page']}&action=edit_success&opt_in_id=$opt_in_id");
                    exit();
                } else {
                    $this->oError->add_data($_POST, $this->iErrorCode);
                }
            } else if ($_GET['action'] == 'export_to_csv') {
                $this->exportToCSV();
            }
        }
    }

    /**
     * Displays controller's view
     * 
     */
    public function display() {
        parent::display();
        
        $sAction = isset ($_GET['action']) ? $_GET['action'] : '';
        
        switch ($sAction) {
            case 'edit':
            case 'edit_success':
                $this->displayEditOptIn();
                break;
            default:
                $this->displayOptInList();
                break;
        }
    }
    
    /**
     * Displays Opt in list
     * 
     * @global wpdb $wpdb 
     */
    private function displayOptInList() {
        global $wpdb;
        
        // Variables initialization
        $iItemsPerPage = 10;
        $aOptInRecords = array();
        $sSuccessMessage = '';
        
        // Get values for 'Add new user' form, if there were errors then takes user's values
        $aFormValues = $this->oError->get_error_data($this->iErrorCode);
                
        $receive_mobile_offers = isset ($aFormValues['receive_mobile_offers']) ? $aFormValues['receive_mobile_offers'] : 0;
        $opt_in_name = isset ($aFormValues['opt_in_name']) ? $aFormValues['opt_in_name'] : '';
        $opt_in_mobile_number = isset ($aFormValues['opt_in_mobile_number']) ? $aFormValues['opt_in_mobile_number'] : '';
        $opt_in_email = isset ($aFormValues['opt_in_email']) ? $aFormValues['opt_in_email'] : '';
        
        // Get success message
        if (isset ($_GET['action'])) {
            switch ($_GET['action']) {
                case 'delete_success':
                    $sSuccessMessage = 'Record was successfully deleted';
                    break;
                case 'add_success':
                    $sSuccessMessage = 'Record was successfully added';
                    break;
            }
        }
        
        // Get errors list
        $aErrors = $this->oError->get_error_messages($this->iErrorCode);
        
        // Get users list and create paginatin object
        $sQuery = "SELECT COUNT(opt_in_id) FROM {$wpdb->prefix}opt_in";
        $iTotalNumber = $wpdb->get_var($sQuery);
        
        $bShowPagination = false;
        $oPagination = new pagination();
        if ($iTotalNumber) {
            $oPagination->items($iTotalNumber);
            $oPagination->limit($iItemsPerPage); // Limit entries per page
            $oPagination->target("admin.php?page={$_GET['page']}");
            $oPagination->currentPage('paging'); // Gets and validates the current page
            $oPagination->calculate(); // Calculates what to show
            $oPagination->parameterName('paging');
            $oPagination->adjacents(1); //No. of page away from the current page
            
            if(!isset($_GET['paging'])) {
                $oPagination->page = 1;
            } else {
                $oPagination->page = $_GET['paging'];
            }
            
            if ($iTotalNumber > $iItemsPerPage) {
                $bShowPagination = true;
            }

            //Query for limit paging
            $sLimit = "LIMIT " . ($oPagination->page - 1) * $oPagination->limit  . ", " . $oPagination->limit;
            
            $oMobilecomplyOptIn = new MobilecomplyOptIn();
            $aOptInRecords = $oMobilecomplyOptIn->getOptInUserList($sLimit);
        }
        
        require_once MobileComply::get_plugin_dir() . 'admin_views/opt_in.php';
    }
    
    /**
     * Displays edit opt in form
     * 
     * @global wpdb $wpdb 
     */
    private function displayEditOptIn() {
        global $wpdb;
        
        parent::display();
        
        $oMobilecomplyOptIn = new MobilecomplyOptIn();
        
        $opt_in_id = isset ($_GET['opt_in_id']) ? $_GET['opt_in_id'] : 0;
        
        // Get success message
        $sSuccessMessage = '';
        if (isset ($_GET['action'])) {
            switch ($_GET['action']) {
                case 'edit_success':
                    $sSuccessMessage = 'Record was successfully changed';
                    break;
                case 'add_success':
                    $sSuccessMessage = 'Record was successfully added';
                    break;
            }
        }
        
        $receive_mobile_offers = '';
        $opt_in_name = '';
        $opt_in_mobile_number = '';
        $opt_in_email = '';
        if ($opt_in_id) {
            $oRowOptIn = $oMobilecomplyOptIn->getOptInUser($opt_in_id);
            if (is_wp_error($oRowOptIn)) {
                $this->oError->add($this->iErrorCode, 'Can\'t find opt in record');
                exit();
            }
            
            $receive_mobile_offers = $oRowOptIn->opt_in_receive_mobile_offers;
            $opt_in_name = $oRowOptIn->opt_in_name;
            $opt_in_mobile_number = $oRowOptIn->opt_in_mobile_phone;
            $opt_in_email = $oRowOptIn->opt_in_email;
        } else {
            $this->oError->add($this->iErrorCode, 'Can\'t find opt in record');
        }
        
        // Get errors list
        $aErrors = $this->oError->get_error_messages($this->iErrorCode);
        
        require_once MobileComply::get_plugin_dir() . 'admin_views/edit_opt_in.php';
    }
    
    private function exportToCSV() {
        $oMobilecomplyOptIn = new MobilecomplyOptIn();
        $aOptInRecords = $oMobilecomplyOptIn->getOptInUserList();

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=opt_in_users_list.csv");
        
        echo '"Name";"Mobile Number";"Email Address";"Receive Offers?";"Date Added"' . "\r\n";
        
        if (!is_wp_error ($aOptInRecords) && !empty ($aOptInRecords)) {
            foreach ($aOptInRecords as $oRowOptIn) {
                echo '"' . 
                    $oRowOptIn->opt_in_name . '";"' .
                    $oRowOptIn->opt_in_mobile_phone . '";"' .
                    $oRowOptIn->opt_in_email . '";"' .
                    $oRowOptIn->opt_in_receive_mobile_offers . '";"' .
                    $oRowOptIn->opt_in_date . '"' . "\r\n";
            }
        } else {
            echo 'No records';
        }

        exit ();
    }
}
?>
