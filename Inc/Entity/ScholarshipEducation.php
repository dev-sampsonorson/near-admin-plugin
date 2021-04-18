<?php
    class ScholarshipEducation extends BaseEntity {

        public $scholarshipId; // int
        public $level; // string
        public $schoolName; // string
        public $department; // string
        public $class; // string
        public $city; // string
        public $state; // string

        public function __construct(array $config) {
            parent::__construct($config);
            
            $this->scholarshipId = $config['scholarshipId'] ?? 0;
        }

        public function setScholarshipId($scholarshipId) {
            $this->scholarshipId = $scholarshipId;
        }

        public function getScholarshipId() {
            return $this->scholarshipId;
        }

        public function validate() : bool {
            return true;
        }

        public function toArray() : array {
            return array(
                "id" => $this->id,
                "scholarshipId" => $this->scholarshipId,
                "level" => $this->level,
                "schoolName" => $this->schoolName,
                "department" => $this->department,
                "class" => $this->class,
                "city" => $this->city,
                "state" => $this->state,
                "insertDate" => !is_null($this->insertDate) ? $this->insertDate->format(TEBO_DATETIME_FORMAT) : ''
            );
        }

    }
