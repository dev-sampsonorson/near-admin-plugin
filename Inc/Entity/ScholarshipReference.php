<?php
    class ScholarshipReference extends BaseEntity {

        public $scholarshipId; // int
        public $lastName; // string
        public $firstName; // string
        public $otherNames; // string
        public $occupation; // string
        public $position; // string
        public $address; // string
        public $phoneNumber; // string

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
                "lastName" => $this->lastName,
                "firstName" => $this->firstName,
                "otherNames" => $this->otherNames,
                "occupation" => $this->occupation,
                "position" => $this->position,
                "address" => $this->address,
                "phoneNumber" => $this->phoneNumber,
                "insertDate" => !is_null($this->insertDate) ? $this->insertDate->format(TEBO_DATETIME_FORMAT) : ''
            );
        }

    }
