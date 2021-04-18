<?php
    class ScholarshipDocument extends BaseEntity {

        public $scholarshipId; // int
        public $passportPhotograph; // string
        public $requestLetter; // string
        public $admissionLetter; // string
        public $jambResult; // string
        public $waecResult; // string
        public $matriculationNumber; // string
        public $indigeneCertificate; // string
        public $birthCertificate; // string
        public $validIdCard; // string

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
                "passportPhotograph" => $this->passportPhotograph->toArray(),
                "requestLetter" => $this->requestLetter->toArray(),
                "admissionLetter" => $this->admissionLetter->toArray(),
                "jambResult" => $this->jambResult->toArray(),
                "waecResult" => $this->waecResult->toArray(),
                "matriculationNumber" => $this->matriculationNumber->toArray(),
                "indigeneCertificate" => $this->indigeneCertificate->toArray(),
                "birthCertificate" => $this->birthCertificate->toArray(),
                "validIdCard" => $this->validIdCard->toArray(),
                "insertDate" => !is_null($this->insertDate) ? $this->insertDate->format(TEBO_DATETIME_FORMAT) : ''
            );
        }

    }
