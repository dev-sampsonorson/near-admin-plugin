<?php
    class VolunteerReport extends BaseEntity {

        public $volunteerName; // string
        public $firstName; // string
        public $lastName; // string
        public $otherNames; // string
        public $mobileNumber; // string
        public $emailAddress; // string
        public $birthDate; // DateTime
        public $gender; // string
        public $stateOfOrigin; // string
        public $address; // string
        public $availability; // string
        public $volunteerInterest; //string
        public $volunteerInterestTutoring; // string
        public $volunteerInterestOther; // string
        public $approved; // bool

        public function __construct(array $config) {
            parent::__construct($config);
        }

        public function validate() : bool {
            return true;
        }

        public function toArray() : array {
            return array(
                "id" => $this->id,
                "volunteerName" => $this->volunteerName,
                "firstName" => $this->firstName,
                "lastName" => $this->lastName,
                "otherNames" => $this->otherNames,
                "mobileNumber" => $this->mobileNumber,
                "emailAddress" => $this->emailAddress,
                "birthDate" => $this->birthDate->format(TEBO_DATE_FORMAT),
                "gender" => $this->gender,
                "stateOfOrigin" => $this->stateOfOrigin,
                "address" => $this->address,
                "availability" => $this->availability,
                "volunteerInterest" => $this->volunteerInterest,
                "volunteerInterestTutoring" => $this->volunteerInterestTutoring ?? "",
                "volunteerInterestOther" => $this->volunteerInterestOther ?? "",
                "approved" => $this->approved ?? false,
                "insertDate" => !is_null($this->insertDate) ? $this->insertDate->format(TEBO_DATETIME_FORMAT) : ''
            );
        }

    }
