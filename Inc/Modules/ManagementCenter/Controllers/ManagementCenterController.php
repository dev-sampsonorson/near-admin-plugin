<?php

    use Rakit\Validation\Validator;

    /**
     * @package Near Foundation Admin Plugin
     */

    class ManagementCenterController extends BaseController {

        public $settings;
        public $callbacks;

        private $volunteerRepo; // volunteerRepo
        private $scholarshipRepo; // scholarshipRepo
        private $donationRepo; // donationRepo

        private $donationFormatter;
        private $volunteerFormatter;
        private $scholarshipFormatter;
    
        public function register() {      
            $this->settings = new SettingsApi();    
            $this->callbacks = new ManagementCenterCallbacks($this);

            $this->volunteerRepo = new VolunteerRepo();
            $this->scholarshipRepo = new ScholarshipRepo();
            $this->donationRepo = new DonationRepo();

            $this->donationFormatter = new DonationFormatter();
            $this->volunteerFormatter = new VolunteerFormatter();
            $this->scholarshipFormatter = new ScholarshipFormatter();            
    
            $this->settings
                 ->addPages($this->getPages())
                 ->withSubPage('Volunteers')
                 ->addSubPages($this->getSubPages())
                 ->register();  
                 
            
            add_action('wp_ajax_getRecordInfo', array($this, 'getRecordInfo'));
            add_action('wp_ajax_nopriv_getRecordInfo', array($this, 'getRecordInfo'));
                 

            if ( is_admin() ) {
                // Tryout First
                // add_action('wp_ajax_getApplicationInfo', array($this, 'getApplicationInfo'));            
                // add_action('wp_ajax_nopriv_getApplicationInfo', array($this, 'getApplicationInfo'));
            } else {
                // Add non-Ajax front-end action hooks here
            }
        }  

        private function getPages() {
            return array(
                array(
                    'page_title' => 'Management Center', // Management Center
                    'menu_title' => 'Near Foundation Admin', 
                    'capability' => 'manage_options', 
                    'menu_slug' => 'near-admin-plugin', 
                    'callback' => array($this->callbacks, 'volunteersView'), 
                    'icon_url' => 'dashicons-admin-generic', 
                    'position' => 110
                )
            );
        }        

        private function getSubPages() {
            return array(               
                array(
                    'parent_slug' => 'near-admin-plugin', 
                    'page_title' => 'Scholarship Applications', 
                    'menu_title' => 'Scholarship Applications', 
                    'capability' => 'manage_options', 
                    'menu_slug' => 'near-admin-scholarship-apps', 
                    'callback' => array($this->callbacks, 'scholarshipAppsView')
                ),                
                array(
                    'parent_slug' => 'near-admin-plugin', 
                    'page_title' => 'Donations', 
                    'menu_title' => 'Donations', 
                    'capability' => 'manage_options', 
                    'menu_slug' => 'near-admin-donations', 
                    'callback' => array($this->callbacks, 'donationsView')
                ),
                array(
                    'parent_slug' => 'near-admin-plugin', 
                    'page_title' => 'Short Codes', 
                    'menu_title' => 'Short Codes', 
                    'capability' => 'manage_options', 
                    'menu_slug' => 'near-admin-shortcode', 
                    'callback' => array($this->callbacks, 'shortcodeView')
                )
            );
        }        

        public function getRecordInfo() {
            try {
                if (!DOING_AJAX || !check_ajax_referer('getRecordInfo_nonce', 'nonce', false)) {
                    return $this->return_json_error(500, 'Invalid request');
                }

                $recordId = isset($_GET['recordId'])? intval($_GET['recordId']) : 0;
                $recordType = isset($_GET['recordType'])? $_GET['recordType'] : '';
                $result = null;

                if ($recordId === 0)
                    throw new Exception('Invalid record identifier');

                if ($recordType === '')
                    throw new Exception('Invalid record type');

                if ($recordType === 'volunteer') {
                    $result = $this->volunteerFormatter->format($this->volunteerRepo->getById($recordId));
                } else if ($recordType === 'scholarship') {
                    $result = $this->scholarshipFormatter->format($this->scholarshipRepo->getById($recordId));
                } else if ($recordType === 'donation') {
                    $result = $this->donationFormatter->format($this->donationRepo->getById($recordId));
                }
                
                return $this->return_json(200, $result);
            } catch(Exception $e) {
                return return_json_error(404, 'Record Not Found');
            }
        } 
    }
