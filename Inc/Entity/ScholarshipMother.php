<?php
    class ScholarshipMother extends BaseEntity {

        public $scholarshipId; // int
        public $name; // string
        public $aliveOrDeceased; // string
        public $occupation; // string
        public $monthlyIncome; // string
        public $city; // string
        public $state; // string
        public $mobileNumber; // string

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
                "name" => $this->name,
                "aliveOrDeceased" => $this->aliveOrDeceased,
                "occupation" => $this->occupation,
                "monthlyIncome" => $this->monthlyIncome,
                "city" => $this->city,
                "state" => $this->state,
                "mobileNumber" => $this->mobileNumber,
                "insertDate" => !is_null($this->insertDate) ? $this->insertDate->format(TEBO_DATETIME_FORMAT) : ''
            );
        }

    }
