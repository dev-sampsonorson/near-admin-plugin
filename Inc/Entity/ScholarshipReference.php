<?php
    class ScholarshipReference extends BaseEntity {

        protected $scholarshipId; // int
        protected $lastName; // string
        protected $firstName; // string
        protected $otherNames; // string
        protected $occupation; // string
        protected $position; // string
        protected $address; // string
        protected $phoneNumber; // string

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
                "insertDate" => !is_null($this->insertDate) ? $this->insertDate->format(WB_DATETIME_FORMAT) : ''
            );
        }

    }
