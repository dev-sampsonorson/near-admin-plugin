<?php
    class ScholarshipMother extends BaseEntity {

        protected $scholarshipId; // int
        protected $name; // string
        protected $aliveOrDeceased; // string
        protected $occupation; // string
        protected $monthlyIncome; // string
        protected $city; // string
        protected $state; // string
        protected $mobileNumber; // string

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
                "insertDate" => !is_null($this->insertDate) ? $this->insertDate->format(WB_DATETIME_FORMAT) : ''
            );
        }

    }
