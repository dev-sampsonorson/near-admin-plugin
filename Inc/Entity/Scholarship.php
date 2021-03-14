<?php
    class Scholarship extends BaseEntity {

        protected $firstName; // string
        protected $lastName; // string
        protected $otherNames; // string
        protected $nationalIdNumber; // string
        protected $birthPlace; // string
        protected $birthDate; // DateTime
        protected $emailAddress; // string
        protected $mobileNumber; // string
        protected $parentNumber; // string
        protected $gotScholarshipLastYear; // bool
        protected $requiredScholarships; // string
        protected $fileId; // string
        protected $address; // string
        protected $howKnowFoundation; // string
        protected $volunteerInterest; // bool
        protected $whyScholarship; // string
        protected $iAgree; // bool
        protected $approved; // bool

        public $scholarshipBank;
        public $scholarshipEducation;
        public $scholarshipFather;
        public $scholarshipMother;
        public $scholarshipSibling;
        public $scholarshipDocument;
        public $scholarshipReference;

        public function __construct(array $config) {
            parent::__construct($config);
        }

        public function validate() : bool {
            return true;
        }

        public function toArray() : array {
            return array(
                "id" => $this->id,
                "firstName" => $this->firstName,
                "lastName" => $this->lastName,
                "otherNames" => $this->otherNames,
                "nationalIdNumber" => $this->nationalIdNumber,
                "birthPlace" => $this->birthPlace,
                "birthDate" => $this->birthDate->format(WB_DATE_FORMAT),
                "emailAddress" => $this->emailAddress,
                "mobileNumber" => $this->mobileNumber,
                "parentNumber" => $this->parentNumber,
                "gotScholarshipLastYear" => $this->gotScholarshipLastYear,
                "requiredScholarships" => $this->requiredScholarships,
                "fileId" => $this->fileId,
                "address" => $this->address,
                "howKnowFoundation" => $this->howKnowFoundation,
                "volunteerInterest" => $this->volunteerInterest,
                "whyScholarship" => $this->whyScholarship,
                "iAgree" => $this->iAgree,
                "approved" => $this->approved,
                "insertDate" => !is_null($this->insertDate) ? $this->insertDate->format(WB_DATETIME_FORMAT) : ''
            );
        }

    }
