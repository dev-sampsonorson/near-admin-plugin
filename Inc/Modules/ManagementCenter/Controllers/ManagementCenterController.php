<?php

    use Rakit\Validation\Validator;

    /**
     * @package Near Foundation Admin Plugin
     */

    class ManagementCenterController extends BaseController {

        public $settings;
        public $callbacks;
    
        public function register() {      
            $this->settings = new SettingsApi();    
            $this->callbacks = new ManagementCenterCallbacks($this);
    
            $this->settings
                 ->addPages($this->getPages())
                 ->withSubPage('Management Center')
                 ->addSubPages($this->getSubPages())
                 ->register();           
                 

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
                    'page_title' => 'Management Center', 
                    'menu_title' => 'Near Foundation Admin', 
                    'capability' => 'manage_options', 
                    'menu_slug' => 'near-admin-plugin', 
                    'callback' => array($this->callbacks, 'dashboardView'), 
                    'icon_url' => 'dashicons-admin-generic', 
                    'position' => 110
                )
            );
        }        

        private function getSubPages() {
            return array(
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
    }