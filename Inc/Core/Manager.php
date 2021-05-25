<?php
    /**
     * @package Near Foundation Admin Plugin
     */

    class Manager extends BaseController {

        private const ADD = 1;
        private const DELETE = 1;

        private static $tables = array(
            BaseRepository::STATES_TABLE_NAME => array(
                'primary_key' => 'id',
                'columns' => array(
                    'id' => 'int(11) NOT NULL AUTO_INCREMENT',
                    'stateName' => 'varchar(50) NOT NULL',
                    'zoneId' => 'int(11) NOT NULL'
                ),
                'data' => array(
                    array('id' => 1,  'stateName' => 'Abia',                            'zoneId' => 1),
                    array('id' => 2,  'stateName' => 'Abuja Federal Capital Territory', 'zoneId' => 1),
                    array('id' => 3,  'stateName' => 'Adamawa',                         'zoneId' => 4),
                    array('id' => 4,  'stateName' => 'Akwa Ibom',                       'zoneId' => 1),
                    array('id' => 5,  'stateName' => 'Anambra',                         'zoneId' => 1),
                    array('id' => 6,  'stateName' => 'Bauchi',                          'zoneId' => 4),
                    array('id' => 7,  'stateName' => 'Bayelsa',                         'zoneId' => 5),
                    array('id' => 8,  'stateName' => 'Benue',                           'zoneId' => 1),
                    array('id' => 9,  'stateName' => 'Borno',                           'zoneId' => 4),
                    array('id' => 10, 'stateName' => 'Cross River',                     'zoneId' => 1),
                    array('id' => 11, 'stateName' => 'Delta',                           'zoneId' => 5),
                    array('id' => 12, 'stateName' => 'Ebonyi',                          'zoneId' => 1),
                    array('id' => 13, 'stateName' => 'Edo',                             'zoneId' => 5),
                    array('id' => 14, 'stateName' => 'Ekiti',                           'zoneId' => 5),
                    array('id' => 15, 'stateName' => 'Enugu',                           'zoneId' => 1),
                    array('id' => 16, 'stateName' => 'Gombe',                           'zoneId' => 4),
                    array('id' => 17, 'stateName' => 'Imo',                             'zoneId' => 1),
                    array('id' => 18, 'stateName' => 'Jigawa',                          'zoneId' => 3),
                    array('id' => 19, 'stateName' => 'Kaduna',                          'zoneId' => 2),
                    array('id' => 20, 'stateName' => 'Kano',                            'zoneId' => 3),
                    array('id' => 21, 'stateName' => 'Katsina',                         'zoneId' => 3),
                    array('id' => 22, 'stateName' => 'Kebbi',                           'zoneId' => 3),
                    array('id' => 23, 'stateName' => 'Kogi',                            'zoneId' => 1),
                    array('id' => 24, 'stateName' => 'Kwara',                           'zoneId' => 1),
                    array('id' => 25, 'stateName' => 'Lagos',                           'zoneId' => 5),
                    array('id' => 26, 'stateName' => 'Nasarawa',                        'zoneId' => 1),
                    array('id' => 27, 'stateName' => 'Niger',                           'zoneId' => 2),
                    array('id' => 28, 'stateName' => 'Ogun',                            'zoneId' => 5),
                    array('id' => 29, 'stateName' => 'Ondo',                            'zoneId' => 5),
                    array('id' => 30, 'stateName' => 'Osun',                            'zoneId' => 5),
                    array('id' => 31, 'stateName' => 'Oyo',                             'zoneId' => 5),
                    array('id' => 32, 'stateName' => 'Plateau',                         'zoneId' => 2),
                    array('id' => 33, 'stateName' => 'Rivers',                          'zoneId' => 1),
                    array('id' => 34, 'stateName' => 'Sokoto',                          'zoneId' => 3),
                    array('id' => 35, 'stateName' => 'Taraba',                          'zoneId' => 4),
                    array('id' => 36, 'stateName' => 'Yobe',                            'zoneId' => 4),
                    array('id' => 37, 'stateName' => 'Zamfara',                         'zoneId' => 3),
                )
            ),
            BaseRepository::DONATION_TABLE_NAME => array(
                'primary_key' => 'id',
                'columns' => array(
                    'id' => 'int(11) NOT NULL AUTO_INCREMENT',
                    'emailAddress' => 'tinytext NOT NULL',
                    'amount' => 'double(24,2) NOT NULL',
                    'reason' => 'varchar(100) NOT NULL',
                    'narration' => 'varchar(1000) NOT NULL',
                    'insertDate' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP'
                )
            ),
            BaseRepository::VOLUNTEER_TABLE_NAME => array(
                'primary_key' => 'id',
                'columns' => array(
                    'id' => 'int(11) NOT NULL AUTO_INCREMENT',
                    'firstName' => 'tinytext NOT NULL',
                    'lastName' => 'tinytext NOT NULL',
                    'otherNames' => 'tinytext NOT NULL',
                    'mobileNumber' => 'tinytext NOT NULL',
                    'emailAddress' => 'tinytext NOT NULL',
                    'birthDate' => 'DATETIME NOT NULL',
                    'gender' => 'tinytext NOT NULL',
                    'stateOfOrigin' => 'int(11) NOT NULL',
                    'address' => 'tinytext NOT NULL',
                    'availability' => 'varchar(1000) NOT NULL',
                    'volunteerInterest' => 'varchar(1000) NOT NULL',
                    'volunteerInterestTutoring' => 'varchar(1000) NOT NULL',
                    'volunteerInterestOther' => 'varchar(1000) NOT NULL',
                    'approved' => 'boolean NOT NULL',
                    'insertDate' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP'
                )
            ),
            BaseRepository::SCHOLARSHIP_TABLE_NAME => array(
                'primary_key' => 'id',
                'columns' => array(
                    'id' => 'int(11) NOT NULL AUTO_INCREMENT',
                    'firstName' => 'tinytext NOT NULL',
                    'lastName' => 'tinytext NOT NULL',
                    'otherNames' => 'tinytext NOT NULL',
                    'nationalIdNumber' => 'tinytext NOT NULL',
                    'birthPlace' => 'tinytext NOT NULL',
                    'birthDate' => 'DATETIME NOT NULL',
                    'emailAddress' => 'tinytext NOT NULL',
                    'mobileNumber' => 'tinytext NOT NULL',
                    'parentNumber' => 'tinytext NOT NULL',
                    'gotScholarshipLastYear' => 'boolean NOT NULL',
                    'requiredScholarships' => 'varchar(1000) NOT NULL',
                    'fileId' => 'varchar(500) NOT NULL',
                    'stateOfOrigin' => 'int(11) NOT NULL',
                    'address' => 'varchar(2000) NOT NULL',
                    'howKnowFoundation' => 'varchar(2000) NOT NULL',
                    'volunteerInterest' => 'boolean NOT NULL',
                    'whyScholarship' => 'varchar(2000) NOT NULL',
                    'iAgree' => 'boolean NOT NULL',
                    'approved' => 'boolean NOT NULL',
                    'insertDate' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP'
                )
            ),
            BaseRepository::SCHOLARSHIP_BANK_TABLE_NAME => array(
                'primary_key' => 'id',
                'columns' => array(
                    'id' => 'int(11) NOT NULL AUTO_INCREMENT',
                    'scholarshipId' => 'int(11) NOT NULL',
                    'bankName' => 'tinytext NOT NULL',
                    'branchName' => 'tinytext NOT NULL',
                    'accountNumber' => 'tinytext NOT NULL',
                    'ibanNumber' => 'tinytext NOT NULL',
                    'insertDate' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP'
                )
            ),
            BaseRepository::SCHOLARSHIP_EDUCATION_TABLE_NAME => array(
                'primary_key' => 'id',
                'columns' => array(
                    'id' => 'int(11) NOT NULL AUTO_INCREMENT',
                    'scholarshipId' => 'int(11) NOT NULL',
                    'level' => 'varchar(200) NOT NULL',
                    'schoolName' => 'tinytext NOT NULL',
                    'department' => 'tinytext NOT NULL',
                    'class' => 'tinytext NOT NULL',
                    'city' => 'tinytext NOT NULL',
                    'state' => 'tinytext NOT NULL',
                    'insertDate' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP'
                )
            ),
            BaseRepository::SCHOLARSHIP_FATHER_TABLE_NAME => array(
                'primary_key' => 'id',
                'columns' => array(
                    'id' => 'int(11) NOT NULL AUTO_INCREMENT',
                    'scholarshipId' => 'int(11) NOT NULL',
                    'name' => 'varchar(1000) NOT NULL',
                    'aliveOrDeceased' => 'tinytext NOT NULL',
                    'occupation' => 'varchar(500) NOT NULL',
                    'monthlyIncome' => 'double(24,2) NOT NULL',
                    'city' => 'tinytext NOT NULL',
                    'state' => 'tinytext NOT NULL',
                    'mobileNumber' => 'tinytext NOT NULL',
                    'insertDate' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP'
                )
            ),
            BaseRepository::SCHOLARSHIP_MOTHER_TABLE_NAME => array(
                'primary_key' => 'id',
                'columns' => array(
                    'id' => 'int(11) NOT NULL AUTO_INCREMENT',
                    'scholarshipId' => 'int(11) NOT NULL',
                    'name' => 'varchar(1000) NOT NULL',
                    'aliveOrDeceased' => 'tinytext NOT NULL',
                    'occupation' => 'varchar(500) NOT NULL',
                    'monthlyIncome' => 'double(24,2) NOT NULL',
                    'city' => 'tinytext NOT NULL',
                    'state' => 'tinytext NOT NULL',
                    'mobileNumber' => 'tinytext NOT NULL',
                    'insertDate' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP'
                )
            ),
            BaseRepository::SCHOLARSHIP_SIBLINGS_TABLE_NAME => array(
                'primary_key' => 'id',
                'columns' => array(
                    'id' => 'int(11) NOT NULL AUTO_INCREMENT',
                    'scholarshipId' => 'int(11) NOT NULL',
                    'nSiblings' => 'int NOT NULL',
                    'nSiblingsInPrimary' => 'int NOT NULL',
                    'nSiblingsInSecondary' => 'int NOT NULL',
                    'nSiblingsInUniversity' => 'int NOT NULL',
                    'insertDate' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP'
                )
            ),
            BaseRepository::SCHOLARSHIP_DOCUMENTS_TABLE_NAME => array(
                'primary_key' => 'id',
                'columns' => array(
                    'id' => 'int(11) NOT NULL AUTO_INCREMENT',
                    'scholarshipId' => 'int(11) NOT NULL',
                    'passportPhotograph' => 'varchar(500) NOT NULL',
                    'requestLetter' => 'varchar(500) NOT NULL',
                    'admissionLetter' => 'varchar(500) NOT NULL',
                    'jambResult' => 'varchar(500) NOT NULL',
                    'waecResult' => 'varchar(500) NOT NULL',
                    'matriculationNumber' => 'varchar(500) NOT NULL',
                    'indigeneCertificate' => 'varchar(500) NOT NULL',
                    'birthCertificate' => 'varchar(500) NOT NULL',
                    'validIdCard' => 'varchar(500) NOT NULL',
                    'insertDate' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP'
                )
            ),
            BaseRepository::SCHOLARSHIP_REFERENCE_TABLE_NAME => array(
                'primary_key' => 'id',
                'columns' => array(
                    'id' => 'int(11) NOT NULL AUTO_INCREMENT',
                    'scholarshipId' => 'int(11) NOT NULL',
                    'lastName' => 'tinytext NOT NULL',
                    'firstName' => 'tinytext NOT NULL',
                    'otherNames' => 'tinytext NOT NULL',
                    'occupation' => 'tinytext NOT NULL',
                    'position' => 'tinytext NOT NULL',
                    'address' => 'varchar(2000) NOT NULL',
                    'phoneNumber' => 'tinytext NOT NULL',
                    'insertDate' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP'
                )
            ),
        );

        public static function activate() {
            flush_rewrite_rules();

            foreach(Manager::$tables as $table_name => $value) {
                if (!Manager::createTable($table_name, Manager::$tables[$table_name])) 
                    continue;

                if(!array_key_exists('data', Manager::$tables[$table_name]) || count($value['data']) == 0)
                    continue;
                
                if(!Manager::loadDefaultData($table_name, Manager::$tables[$table_name]))
                    exit();
            }
            
            // when creating tables
            // add_option(ADMIN_DB_VERSION_KEY, ADMIN_DB_VERSION);
            Manager::addOrRemoveAdminDbVersion(self::ADD);

            Manager::createPages();
        }

        private static function addOrRemoveAdminDbVersion($operation) {
            if ($operation == self::ADD) {
                add_option(ADMIN_DB_VERSION_KEY, ADMIN_DB_VERSION);
            } 
            
            if ($operation == self::DELETE) {
                delete_option(ADMIN_DB_VERSION_KEY);
            }
        }

        private static function createTable($table_name, $table_cols) {
            
            try {
                if (Manager::tableExists($table_name)) return false;
    
                $sql = "CREATE TABLE $table_name (";
                foreach($table_cols['columns'] as $key => $value) {
                    $sql .= "$key $value, ";
                }
    
                $sql .= "PRIMARY KEY (" . $table_cols['primary_key'] . ")";
                $sql .= ")";            
    
                if (!isset($sql)) return;
    
                dbDelta($sql);
    
                // add_option(ADMIN_DB_VERSION_KEY, ADMIN_DB_VERSION);
                Manager::addOrRemoveAdminDbVersion(self::ADD);
            }
            catch(Exception $e) {
                return false;
            }

            return true;
        }

        private static function tableExists($table_name) {
            global $wpdb;
            return $wpdb->get_var("SHOW TABLES LIKE '" . $table_name . "'") == $table_name;
        }

        private static function hasData($table_name) {
            global $wpdb;            
            return $wpdb->get_var("SELECT COUNT(*) FROM " . $table_name) > 0;
        }

        private static function removeTable($table_name) {
            global $wpdb;

            $sql = "DROP TABLE IF EXISTS " . $table_name;

            return $wpdb->query($sql);
        }

        private static function loadDefaultData($table_name, $table_cols) {            
            global $wpdb; 

            try {

                if(!array_key_exists('data', Manager::$tables[$table_name]))
                    return false;  
                
                if (!Manager::tableExists($table_name)) return false;
                if (Manager::hasData($table_name)) return false;
    
                // $query = "INSERT INTO $table_name (`review_cost_type_id`, `review_cost_type`) VALUES (%d, %s)";
    
                foreach($table_cols['data'] as $row) {
                    $query_template = "";
                    $value_template = "";
                    $query_template = "INSERT INTO $table_name (";

                    foreach($row as $key => $value) {
                        $isString = in_array(trim(gettype($value)), array("string"));
                        $isNumber = in_array(trim(gettype($value)), array("integer", "double", "float"));
                        $query_template .= "`{$key}`,";
                        $value_template .= $isString == true ? "%s," : "";
                        $value_template .= $isNumber == true  ? "%d," : "";
                    }
    
                    $query_template = substr(trim($query_template), 0, -1);
                    $value_template = substr(trim($value_template), 0, -1);
    
                    $query_template .= ") VALUES (";
                    $query_template .= $value_template;
                    $query_template .= ")";

                    $prepare_query = $wpdb->prepare($query_template, array_values($row));
                    
                    $result = $wpdb->query($prepare_query);
                }

            } catch(Exception $e) {
                return false;
            }
            
            return $result ? true : false;
        }

        public static function createPages() {
            // Scholarship
            $scholarship_title = 'Scholarship Form';
            $scholarship_content = '<!-- wp:shortcode -->[near-scholarship-form]<!-- /wp:shortcode -->';
            $scholarship_type = 'page';
            if (!post_exists($scholarship_title, $scholarship_content, '', $scholarship_type)) {
                $wordpress_page = array(
                    'post_name' => NEAR_FOUNDATION_SCHOLARSHIP_FORM_SLUG,
                    'post_title'    => $scholarship_title,
                    'post_content'  => $scholarship_content,
                    'post_status'   => 'publish',
                    'post_author'   => 1,
                    'post_type' => $scholarship_type
                );
                wp_insert_post( $wordpress_page );
            }

            // Volunteer
            $volunteer_title = 'Volunteer Form';
            $volunteer_content = '<!-- wp:shortcode -->[near-volunteer-form]<!-- /wp:shortcode -->';
            $volunteer_type = 'page';
            if (!post_exists($volunteer_title, $volunteer_content, '', $volunteer_type)) {
                $wordpress_page = array(
                    'post_name' => NEAR_FOUNDATION_VOLUNTEER_FORM_SLUG,
                    'post_title'    => $volunteer_title,
                    'post_content'  => $volunteer_content,
                    'post_status'   => 'publish',
                    'post_author'   => 1,
                    'post_type' => $volunteer_type
                );
                wp_insert_post( $wordpress_page );
            }

            // Donation
            $donation_title = 'Donation';
            $donation_content = '<!-- wp:shortcode -->[near-donation-form]<!-- /wp:shortcode -->';
            $donation_type = 'page';
            if (!post_exists($donation_title, $donation_content, '', $donation_type)) {
                $wordpress_page = array(
                    'post_name' => NEAR_FOUNDATION_DONATION_FORM_SLUG,
                    'post_title'    => $donation_title,
                    'post_content'  => $donation_content,
                    'post_status'   => 'publish',
                    'post_author'   => 1,
                    'post_type' => $donation_type
                );
                wp_insert_post( $wordpress_page );
            }
        }

        public static function deletePages() {
            wp_delete_post(get_page_id_by_slug(NEAR_FOUNDATION_SCHOLARSHIP_FORM_SLUG), true);            
            wp_delete_post(get_page_id_by_slug(NEAR_FOUNDATION_VOLUNTEER_FORM_SLUG), true);            
            wp_delete_post(get_page_id_by_slug(NEAR_FOUNDATION_DONATION_FORM_SLUG), true);
        }

        public static function deactivate() {
            flush_rewrite_rules();

            Manager::deletePages();
        }

        public static function uninstall() {
            // when deleting tables
            // delete_option(NEAR_FOUNDATION_ADMIN_VERSION);
            Manager::addOrRemoveAdminDbVersion(self::DELETE);

            foreach(Manager::$tables as $table_name => $value) {
                $result = Manager::removeTable($table_name, Manager::$tables[$table_name]);
            }

            Manager::deletePages();
        }

    }
