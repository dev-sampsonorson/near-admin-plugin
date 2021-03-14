<?php
    if (!session_id())
        session_start();

    /**
     * @package Near Foundation Admin Plugin
     */

    /**
     * Plugin Name: Near Foundation Admin Plugin
     * Description: Use this plugin to manage the Galaxy website
     * Version: 1.0.0
     * Author: Sampson Orson Jackson
     * Text Domain: galaxy-admin-plugin
     */

    // Make sure we don't expose any info if called directly
    defined('ABSPATH') or die('Hey, you can\'t access this file');
    define ('WB_PLUGIN_PATH', plugin_dir_path(__FILE__));
    define ('WB_MODULES_PATH', plugin_dir_path(__FILE__). 'Inc/Modules/');
    define ('WB_MAX_UPLOAD_SIZE', 31457280);
    define ('WB_CURRENT_TIMEZONE', "Africa/Lagos");
    define ('WB_DATE_FORMAT', "Y-m-d");
    define ('WB_DATETIME_FORMAT', "Y-m-d H:i:s");
    
    define ('PLUGIN_INDEX_FILE', 'near-admin-plugin.php' );

    define ('ADMIN_DB_VERSION_KEY', 'galaxy_admin_db_version' );
    define ('ADMIN_DB_VERSION', '1.0' );

    define ('GALAXY_ADMIN_VERSION', '1.0' );
    define ('GALAXY_APPLICATION_FORM_SLUG', 'application-form' );

    define ('GALAXY_DEFAULT_PAGE_SIZE', 2);
    define ('GALAXY_SEARCH_QUERY_PARAM', 'gxy-search');
    define ('GALAXY_PAGE_QUERY_PARAM', 'gxy-page');
    define ('GALAXY_QUERY_TYPE', 'gxy-query-type');
    define ('GALAXY_QUERY_TYPE_ALL', 'all');
    define ('GALAXY_QUERY_TYPE_SEARCH', 'term');

    define ('GALAXY_SECRET_KEY', 'sk_test_1780b2d72694b3828573c2881a683a8ac6b6aac1');
    define ('GALAXY_PUBLIC_KEY', 'pk_test_3567256fe2dff4bcc7e1d162ddfd839af43dddb0');

    date_default_timezone_set(WB_CURRENT_TIMEZONE);

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // Composer
    require('vendor/autoload.php');

    // Helper
    require_once(WB_PLUGIN_PATH . 'Inc/Core/Helper.php');

    // Functions
    require_once(WB_PLUGIN_PATH . 'Inc/Functions.php');
    
    // Libraries
    
    // Core
    require_once(WB_PLUGIN_PATH . 'Inc/Core/AppError.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Core/Result.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Core/BaseEntity.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Core/BaseRepository.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Core/BaseController.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Core/Enqueue.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Core/SettingsLinks.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Core/Manager.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Core/SettingsApi.php');

    /*
     * Entities
     */
    require_once(WB_PLUGIN_PATH . 'Inc/Entity/Volunteer.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Entity/Scholarship.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Entity/ScholarshipBank.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Entity/ScholarshipDocument.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Entity/ScholarshipEducation.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Entity/ScholarshipFather.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Entity/ScholarshipMother.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Entity/ScholarshipReference.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Entity/ScholarshipSibling.php');

    /*
     * Repository
     */
    require_once(WB_PLUGIN_PATH . 'Inc/Repository/VolunteerRepo.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Repository/ScholarshipRepo.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Repository/ScholarshipBankRepo.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Repository/ScholarshipEducationRepo.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Repository/ScholarshipFatherRepo.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Repository/ScholarshipMotherRepo.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Repository/ScholarshipSiblingRepo.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Repository/ScholarshipDocumentRepo.php');
    require_once(WB_PLUGIN_PATH . 'Inc/Repository/ScholarshipReferenceRepo.php');
    
    /*
     * Validators
     */
    require_once(WB_PLUGIN_PATH . 'Inc/Validators/DateRangeRule.php');
    
    /*
     * Modules
     */

    // Management Center Module
    require_once(WB_MODULES_PATH . 'ManagementCenter/Callbacks/ManagementCenterCallbacks.php');
    require_once(WB_MODULES_PATH . 'ManagementCenter/Controllers/ManagementCenterController.php');

    // Application Form Module
    /* require_once(WB_MODULES_PATH . 'ApplicationForm/Validators/StudentValidator.php');
    require_once(WB_MODULES_PATH . 'ApplicationForm/Validators/PurchaseHeaderValidator.php');
    require_once(WB_MODULES_PATH . 'ApplicationForm/Validators/PurchaseItemValidator.php');
    require_once(WB_MODULES_PATH . 'ApplicationForm/Validators/GuardianValidator.php');
    require_once(WB_MODULES_PATH . 'ApplicationForm/Callbacks/ApplicationFormCallbacks.php');
    require_once(WB_MODULES_PATH . 'ApplicationForm/Controllers/ApplicationFormController.php'); */

    // Initialization
    require_once(WB_PLUGIN_PATH . 'Inc/Init.php');

    register_activation_hook(__FILE__, array('Manager', 'activate'));
    register_deactivation_hook(__FILE__, array('Manager', 'deactivate'));
    register_uninstall_hook(__FILE__, array('Manager', 'uninstall'));

    
    add_action( 'init', function() {
        if (class_exists('Init')) {
            Init::register_services();
        }
    });
    
    $scholorshipRepo = new ScholarshipRepo();
    $scholarship = new Scholarship(array(
        "id" => 1,
        "firstName" => "Alice",
        "lastName" => "Doe",
        "otherNames" => "Fish",
        "nationalIdNumber" => "094394903",
        "birthPlace" => "Abuja",
        "birthDate" => Helper::toDateTimeFromString("2021-12-30", WB_DATE_FORMAT),
        "emailAddress" => "example@email.com",
        "mobileNumber" => "09023223432",
        "parentNumber" => "09023223432",
        "gotScholarshipLastYear" => 0,
        "requiredScholarships" => "chkScholarshipReqAccomodation,chkScholarshipReqTuition,chkScholarshipReqMonthlyAllowance",
        "fileId" => "00000",
        "address" => "Address 1",
        "howKnowFoundation" => "Internet",
        "volunteerInterest" => "",
        "whyScholarship" => "Love",
        "iAgree" => 1,
        "approved" => 0,

        "__scholarshipBank" => array(
            // "id" => 3,
            "scholarshipId" => 1,
            "bankName" => "Oceanic",
            "branchName" => "Maitama",
            "accountNumber" => "094394903",
            "ibanNumber" => "00001112"
        ),
        "__scholarshipEducation" => array(
            // "id" => 3,
            "scholarshipId" => 1,
            "level" => "chkEduPrimary,chkEduUniversity",
            "schoolName" => "University of Abuja",
            "department" => "Social Sciences",
            "class" => "200L",
            "city" => "Abuja",
            "state" => "FCT",
        ),
        "__scholarshipFather" => array(
            // "id" => 1,
            "scholarshipId" => 1,
            "name" => "Fred Akara",
            "aliveOrDeceased" => "alive",
            "occupation" => "Doctor",
            "monthlyIncome" => 300000,
            "city" => "Abuja",
            "state" => "FCT",
            "mobileNumber" => "09033433266",
        ),
        "__scholarshipMother" => array(
            // "id" => 1,
            "scholarshipId" => 1,
            "name" => "Mama Agada",
            "aliveOrDeceased" => "alive",
            "occupation" => "Nurse",
            "monthlyIncome" => 170000.50,
            "city" => "Aba",
            "state" => "Abia",
            "mobileNumber" => "09033433266",
        ),
        "__scholarshipSibling" => array(
            // "id" => 2,
            "scholarshipId" => 1,
            "nSiblings" => 5,
            "nSiblingsInPrimary" => 1,
            "nSiblingsInSecondary" => 1,
            "nSiblingsInUniversity" => 3,
        ),
        "__scholarshipDocument" => array(
            // "id" => 1,
            "scholarshipId" => 1,
            "requestLetter" => "requestLetterUpdated.pdf",
            "admissionLetter" => "admissionLetter.pdf",
            "jambResult" => "jambResult.pdf",
            "waecResult" => "waecResult.pdf",
            "matriculationNumber" => "matriculationNumber.pdf",
            "indigeneCertificate" => "indigeneCertificate.pdf",
            "birthCertificate" => "birthCertificate.pdf",
            "validIdCard" => "validIdCard.pdf",
        ),
        "__scholarshipReference" => array(
            // "id" => 1,
            "scholarshipId" => 1,
            "lastName" => "Kalu",
            "firstName" => "Victor",
            "otherNames" => "Ebere",
            "occupation" => "Accountant",
            "position" => "Chief Accountant",
            "address" => "Gwarinpa",
            "phoneNumber" => "08034483893",
        ),
    ));
    $scholorshipRepo->update($scholarship);
    // print_r($scholorshipRepo->update($scholarship));
    echo "<pre>";
    print_r($scholorshipRepo->getById(1));
    echo "</pre>";
    
    /*  */

    /* $myArray = array('key' => NULL);
    echo isset($myArray['key']) ? 'Yes' : 'No'; */
    exit();
