<?php

    /**
     * @package Near Foundation Admin Plugin
     */

    class Enqueue extends BaseController {
        public function register() {
            add_action('wp_enqueue_scripts', array($this, 'enqueueFrontendScripts'));
            add_action('admin_enqueue_scripts', array($this, 'enqueueBackendScripts'));
        }
    
        public function enqueueBackendScripts() {
            wp_enqueue_style( 'tailwind-css', $this->plugin_url . 'dist/css/tailwind.min.css', array(), false, false);
            // wp_enqueue_style( 'bootstrap-css', $this->plugin_url . 'dist/css/bootstrap.min.css', array(), false, false);
            wp_enqueue_style( 'near-plugin-backend-css', $this->plugin_url . 'dist/css/backend.css', array('tailwind-css'), microtime(), false);
            
            wp_enqueue_script( 'runtime-js', $this->plugin_url . 'dist/js/runtime.plugin-bundle.js', array(), false, true);
            wp_enqueue_script( 'vendor-js', $this->plugin_url . 'dist/js/vendor.plugin-bundle.js', array('runtime-js'), false, true);
            // wp_enqueue_script( 'modernizr-js', $this->plugin_url . 'dist/js/modernizr-custom.js', array('vendor-js'), false, true);
            wp_enqueue_script( 'backend-js', $this->plugin_url . 'dist/js/backend-index.plugin-bundle.js', array('vendor-js'), microtime(), true);

            $backend_script_config = array(
                'ajaxRequestUrl' => admin_url('admin-ajax.php'),
                'getRecordInfoNonce' => wp_create_nonce("getRecordInfo_nonce")
            );
            wp_localize_script( 'backend-js', 'backend_script_config', $backend_script_config );
            wp_enqueue_script( 'backend-js' );
        }

        public function enqueueFrontendScripts() {
            $frontend_script_config = array(
                'publicKey' => NEAR_FOUNDATION_PUBLIC_KEY,
                'ajaxRequestUrl' => admin_url('admin-ajax.php'),
                'saveVolunteerFormNonce' => wp_create_nonce("saveVolunteerForm_nonce"),
                'saveScholarshipFormNonce' => wp_create_nonce("saveScholarshipForm_nonce"),
                'saveDonationNonce' => wp_create_nonce("saveDonationNonce_nonce"),
                'generatePaymentRefNonce' => wp_create_nonce("generatePaymentRef_nonce"),
                'verifyTransactionNonce' => wp_create_nonce("verifyTransaction_nonce")
            );

            wp_enqueue_style( 'bootstrap-css', $this->plugin_url . 'dist/css/bootstrap.min.css', array(), false, false);
            wp_enqueue_style( 'bootstrap-datepicker3-css', $this->plugin_url . 'dist/css/bootstrap-datepicker3.min.css', array('bootstrap-css'), false, false);
            wp_enqueue_style( 'near-plugin-frontend-css', $this->plugin_url . 'dist/css/frontend.css', array('bootstrap-datepicker3-css'), microtime(), false);
            
            wp_enqueue_script( 'runtime-js', $this->plugin_url . 'dist/js/runtime.plugin-bundle.js', array(), false, true);
            wp_enqueue_script( 'vendor-js', $this->plugin_url . 'dist/js/vendor.plugin-bundle.js', array('runtime-js'), false, true);
            // wp_enqueue_script( 'bootstrap-bundle-js', $this->plugin_url . 'dist/js/bootstrap.bundle.min.js', array('vendor-js'), false, true);a
            // wp_enqueue_script( 'frontend-js', $this->plugin_url . 'dist/js/frontend-index.plugin-bundle.js', array('modernizr-js'), microtime(), true);

            wp_register_script( 'paystack-js', 'https://js.paystack.co/v1/inline.js', array(), false, true);
            wp_register_script( 'frontend-volunteer-js', $this->plugin_url . 'dist/js/volunteer-frontend.plugin-bundle.js', array('vendor-js'), microtime(), true); //, 'paystack-js'
            wp_register_script( 'frontend-scholarship-js', $this->plugin_url . 'dist/js/scholarship-frontend.plugin-bundle.js', array('vendor-js'), microtime(), true); 
            wp_register_script( 'frontend-donation-js', $this->plugin_url . 'dist/js/donation-frontend.plugin-bundle.js', array('vendor-js', 'paystack-js'), microtime(), true); 
            
            wp_localize_script( 'frontend-volunteer-js', 'frontend_script_config', $frontend_script_config );
            wp_enqueue_script( 'frontend-volunteer-js' );

            wp_localize_script( 'frontend-scholarship-js', 'frontend_script_config', $frontend_script_config );
            wp_enqueue_script( 'frontend-scholarship-js' );

            wp_localize_script( 'frontend-donation-js', 'frontend_script_config', $frontend_script_config );
            wp_enqueue_script( 'frontend-donation-js' );
        }
    }
