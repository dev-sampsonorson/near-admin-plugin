<?php
    class ScholarshipBank extends BaseEntity {

        public $scholarshipId; // int
        public $bankName; // string
        public $branchName; // string
        public $accountNumber; // string
        public $ibanNumber; // string

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
                "bankName" => $this->bankName,
                "branchName" => $this->branchName,
                "accountNumber" => $this->accountNumber,
                "ibanNumber" => $this->ibanNumber,
                "insertDate" => !is_null($this->insertDate) ? $this->insertDate->format(TEBO_DATETIME_FORMAT) : ''
            );
        }

    }
