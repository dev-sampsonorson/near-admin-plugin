<?php
    /**
     * @package Near Foundation Admin Plugin
     */

    class Manager extends BaseController {

        private const ADD = 1;
        private const DELETE = 1;

        private static $tables = array(
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
                    'monthlyIncome' => 'double(12,2) NOT NULL',
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
                    'monthlyIncome' => 'double(12,2) NOT NULL',
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

        public static function deactivate() {
            flush_rewrite_rules();
        }

        public static function uninstall() {
            // when deleting tables
            // delete_option(ADMIN_DB_VERSION_KEY);
            Manager::addOrRemoveAdminDbVersion(self::DELETE);

            foreach(Manager::$tables as $table_name => $value) {
                $result = Manager::removeTable($table_name, Manager::$tables[$table_name]);
            }
        }

    }
