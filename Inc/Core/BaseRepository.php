<?php

    /**
     * @package Near Foundation Admin Plugin
     */

    abstract class BaseRepository {

        public const STATES_TABLE_NAME = 'near_states';
        public const DONATION_TABLE_NAME = 'near_donation';
        public const VOLUNTEER_TABLE_NAME = 'near_volunteer';
        public const SCHOLARSHIP_TABLE_NAME = 'near_scholarship';
        public const SCHOLARSHIP_BANK_TABLE_NAME = 'near_scholarship_bank';
        public const SCHOLARSHIP_EDUCATION_TABLE_NAME = 'near_scholarship_education';
        public const SCHOLARSHIP_FATHER_TABLE_NAME = 'near_scholarship_father';
        public const SCHOLARSHIP_MOTHER_TABLE_NAME = 'near_scholarship_mother';
        public const SCHOLARSHIP_SIBLINGS_TABLE_NAME = 'near_scholarship_siblings';
        public const SCHOLARSHIP_DOCUMENTS_TABLE_NAME = 'near_scholarship_documents';
        public const SCHOLARSHIP_REFERENCE_TABLE_NAME = 'near_scholarship_reference';

        protected $wpdb;

        public function __construct() {
            global $wpdb;

            $this->wpdb = $wpdb;
        }

        public abstract function getTableName();

    }
