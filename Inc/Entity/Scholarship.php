<?php
    class Scholarship extends BaseEntity {

        public $firstName; // string
        public $lastName; // string
        public $otherNames; // string
        public $nationalIdNumber; // string
        public $birthPlace; // string
        public $birthDate; // DateTime
        public $emailAddress; // string
        public $mobileNumber; // string
        public $parentNumber; // string
        public $gotScholarshipLastYear; // bool
        public $requiredScholarships; // string
        public $fileId; // string
        public $stateOfOrigin; // string
        public $address; // string
        public $howKnowFoundation; // string
        public $volunteerInterest; // bool
        public $whyScholarship; // string
        public $iAgree; // bool
        public $approved; // bool

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
                "birthDate" => !is_null($this->birthDate) ? $this->birthDate->format(TEBO_DATE_FORMAT) : '',
                "emailAddress" => $this->emailAddress,
                "mobileNumber" => $this->mobileNumber,
                "parentNumber" => $this->parentNumber,
                "gotScholarshipLastYear" => $this->gotScholarshipLastYear,
                "requiredScholarships" => $this->requiredScholarships,
                "fileId" => $this->fileId,
                "stateOfOrigin" => $this->stateOfOrigin,
                "address" => $this->address,
                "howKnowFoundation" => $this->howKnowFoundation,
                "volunteerInterest" => $this->volunteerInterest,
                "whyScholarship" => $this->whyScholarship,
                "iAgree" => $this->iAgree,
                "approved" => $this->approved ?? false,
                "insertDate" => !is_null($this->insertDate) ? $this->insertDate->format(TEBO_DATETIME_FORMAT) : ''
            );
        }

    }
