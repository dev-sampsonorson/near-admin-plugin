<?php
    class ScholarshipEducation extends BaseEntity {

        protected $scholarshipId; // int
        protected $level; // string
        protected $schoolName; // string
        protected $department; // string
        protected $class; // string
        protected $city; // string
        protected $state; // string

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
                "insertDate" => !is_null($this->insertDate) ? $this->insertDate->format(WB_DATETIME_FORMAT) : ''
            );
        }

    }
