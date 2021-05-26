<?php
    if (!session_id())
        session_start();

    /**
     * @package Near Foundation Admin Plugin
     */

    /**
     * Plugin Name: Near Foundation Admin Plugin
     * Description: Use this plugin to manage the Near Foundation website
     * Version: 1.0.0
     * Author: Sampson Orson Jackson
     * Text Domain: near-foundation-admin-plugin
     */

    // Make sure we don't expose any info if called directly
    defined('ABSPATH') or die('Hey, you can\'t access this file');
    define ('TEBO_PLUGIN_PATH', plugin_dir_path(__FILE__));
    define ('TEBO_MODULES_PATH', plugin_dir_path(__FILE__). 'Inc/Modules/');
    define ('TEBO_UPLOAD_BASE_PATH', plugin_dir_path(__FILE__). 'uploads/');
    define ('TEBO_UPLOAD_BASE_URL', plugin_dir_url(__FILE__). 'uploads/');
    define ('TEBO_MAX_UPLOAD_SIZE', 31457280);
    define ('TEBO_CURRENT_TIMEZONE', "Africa/Lagos");
    define ('TEBO_DATE_FORMAT', "Y-m-d");
    define ('TEBO_DATETIME_FORMAT', "Y-m-d H:i:s");
    
    define ('TEBO_PLUGIN_INDEX_FILE', 'near-admin-plugin.php' );

    define ('ADMIN_DB_VERSION_KEY', 'near_foundation_admin_db_version' );
    define ('ADMIN_DB_VERSION', '1.0' );

    define ('NEAR_FOUNDATION_ADMIN_VERSION', '1.0' );
    define ('NEAR_FOUNDATION_VOLUNTEER_FORM_SLUG', 'near-volunteer-form' );
    define ('NEAR_FOUNDATION_SCHOLARSHIP_FORM_SLUG', 'near-scholarship-form' );
    define ('NEAR_FOUNDATION_DONATION_FORM_SLUG', 'near-donation-form' );

    define ('NEAR_FOUNDATION_DEFAULT_PAGE_SIZE', 2);
    define ('NEAR_FOUNDATION_SEARCH_QUERY_PARAM', 'near-search');
    define ('NEAR_FOUNDATION_PAGE_QUERY_PARAM', 'near-page');
    define ('NEAR_FOUNDATION_QUERY_TYPE', 'near-query-type');
    define ('NEAR_FOUNDATION_QUERY_TYPE_ALL', 'all');
    define ('NEAR_FOUNDATION_QUERY_TYPE_SEARCH', 'term');

    define ('NEAR_FOUNDATION_SECRET_KEY', 'sk_test_1780b2d72694b3828573c2881a683a8ac6b6aac1');
    define ('NEAR_FOUNDATION_PUBLIC_KEY', 'pk_test_3567256fe2dff4bcc7e1d162ddfd839af43dddb0');

    define ('NEAR_FOUNDATION_FILEID_PADDING', 10);

    date_default_timezone_set(TEBO_CURRENT_TIMEZONE);

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // Composer
    require('vendor/autoload.php');

    // Helper
    require_once(TEBO_PLUGIN_PATH . 'Inc/Core/Helper.php'); 

    // Functions
    require_once(TEBO_PLUGIN_PATH . 'Inc/Functions.php');
    
    // Libraries
    
    // Core
    require_once(TEBO_PLUGIN_PATH . 'Inc/Core/AppError.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Core/Result.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Core/BaseEntity.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Core/BaseFormatter.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Core/BaseRepository.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Core/BaseController.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Core/Enqueue.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Core/SettingsLinks.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Core/Manager.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Core/SettingsApi.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Core/FileInfo.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Core/PageResult.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Core/Bank.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Core/BankCollection.php');

    /*
     * Entities
     */
    require_once(TEBO_PLUGIN_PATH . 'Inc/Entity/State.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Entity/Donation.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Entity/Volunteer.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Entity/Scholarship.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Entity/ScholarshipBank.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Entity/ScholarshipDocument.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Entity/ScholarshipEducation.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Entity/ScholarshipFather.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Entity/ScholarshipMother.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Entity/ScholarshipReference.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Entity/ScholarshipSibling.php');

    require_once(TEBO_PLUGIN_PATH . 'Inc/Entity/VolunteerReport.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Entity/ScholarshipReport.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Entity/DonationReport.php');

    /*
     * Repository
     */
    require_once(TEBO_PLUGIN_PATH . 'Inc/Repository/StateRepo.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Repository/DonationRepo.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Repository/VolunteerRepo.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Repository/ScholarshipRepo.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Repository/ScholarshipBankRepo.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Repository/ScholarshipEducationRepo.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Repository/ScholarshipFatherRepo.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Repository/ScholarshipMotherRepo.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Repository/ScholarshipSiblingRepo.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Repository/ScholarshipDocumentRepo.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Repository/ScholarshipReferenceRepo.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Repository/ReportRepo.php');
    
    /*
     * Validators
     */
    require_once(TEBO_PLUGIN_PATH . 'Inc/Validators/DateRangeRule.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Validators/MinSelectedRule.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Validators/RequiredIfContainsRule.php');
    
    /*
     * Formatters
     */
    require_once(TEBO_PLUGIN_PATH . 'Inc/Formatter/DonationFormatter.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Formatter/VolunteerFormatter.php');
    require_once(TEBO_PLUGIN_PATH . 'Inc/Formatter/ScholarshipFormatter.php');
    
    /*
     * Modules
     */

    // Management Center Module
    require_once(TEBO_MODULES_PATH . 'ManagementCenter/Callbacks/ManagementCenterCallbacks.php');
    require_once(TEBO_MODULES_PATH . 'ManagementCenter/Controllers/ManagementCenterController.php');

    // Scholarship Module
    require_once(TEBO_MODULES_PATH . 'ScholarshipForm/Validators/ScholarshipValidator.php');
    require_once(TEBO_MODULES_PATH . 'ScholarshipForm/Validators/ScholarshipBankValidator.php');
    require_once(TEBO_MODULES_PATH . 'ScholarshipForm/Validators/ScholarshipDocumentValidator.php');
    require_once(TEBO_MODULES_PATH . 'ScholarshipForm/Validators/ScholarshipEducationValidator.php');
    require_once(TEBO_MODULES_PATH . 'ScholarshipForm/Validators/ScholarshipFatherValidator.php');
    require_once(TEBO_MODULES_PATH . 'ScholarshipForm/Validators/ScholarshipMotherValidator.php');
    require_once(TEBO_MODULES_PATH . 'ScholarshipForm/Validators/ScholarshipReferenceValidator.php');
    require_once(TEBO_MODULES_PATH . 'ScholarshipForm/Validators/ScholarshipSiblingValidator.php');
    require_once(TEBO_MODULES_PATH . 'ScholarshipForm/Callbacks/ScholarshipFormCallbacks.php');
    require_once(TEBO_MODULES_PATH . 'ScholarshipForm/Controllers/ScholarshipFormController.php');

    // Volunteer Module
    require_once(TEBO_MODULES_PATH . 'VolunteerForm/Validators/VolunteerValidator.php');
    require_once(TEBO_MODULES_PATH . 'VolunteerForm/Callbacks/VolunteerFormCallbacks.php');
    require_once(TEBO_MODULES_PATH . 'VolunteerForm/Controllers/VolunteerFormController.php');

    // Donation Module
    require_once(TEBO_MODULES_PATH . 'DonationForm/Validators/DonationValidator.php');
    require_once(TEBO_MODULES_PATH . 'DonationForm/Callbacks/DonationFormCallbacks.php');
    require_once(TEBO_MODULES_PATH . 'DonationForm/Controllers/DonationFormController.php');

    // Application Form Module
    /* require_once(TEBO_MODULES_PATH . 'ApplicationForm/Validators/StudentValidator.php');
    require_once(TEBO_MODULES_PATH . 'ApplicationForm/Validators/PurchaseHeaderValidator.php');
    require_once(TEBO_MODULES_PATH . 'ApplicationForm/Validators/PurchaseItemValidator.php');
    require_once(TEBO_MODULES_PATH . 'ApplicationForm/Validators/GuardianValidator.php');
    require_once(TEBO_MODULES_PATH . 'ApplicationForm/Callbacks/ApplicationFormCallbacks.php');
    require_once(TEBO_MODULES_PATH . 'ApplicationForm/Controllers/ApplicationFormController.php'); */

    // Initialization
    require_once(TEBO_PLUGIN_PATH . 'Inc/Init.php');

    register_activation_hook(__FILE__, array('Manager', 'activate'));
    register_deactivation_hook(__FILE__, array('Manager', 'deactivate'));
    register_uninstall_hook(__FILE__, array('Manager', 'uninstall'));

    
    add_action( 'init', function() {
        if (class_exists('Init')) {
            Init::register_services();
        }
    });
