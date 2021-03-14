<?php
    class ScholarshipDocument extends BaseEntity {

        protected $scholarshipId; // int
        protected $requestLetter; // string
        protected $admissionLetter; // string
        protected $jambResult; // string
        protected $waecResult; // string
        protected $matriculationNumber; // string
        protected $indigeneCertificate; // string
        protected $birthCertificate; // string
        protected $validIdCard; // string

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
                "requestLetter" => $this->requestLetter,
                "admissionLetter" => $this->admissionLetter,
                "jambResult" => $this->jambResult,
                "waecResult" => $this->waecResult,
                "matriculationNumber" => $this->matriculationNumber,
                "indigeneCertificate" => $this->indigeneCertificate,
                "birthCertificate" => $this->birthCertificate,
                "validIdCard" => $this->validIdCard,
                "insertDate" => !is_null($this->insertDate) ? $this->insertDate->format(WB_DATETIME_FORMAT) : ''
            );
        }

    }
