<?php
    class Volunteer extends BaseEntity {

        protected $firstName; // string
        protected $lastName; // string
        protected $otherNames; // string
        protected $mobileNumber; // string
        protected $emailAddress; // string
        protected $birthDate; // DateTime
        protected $gender; // string
        protected $address; // string
        protected $availability; // string
        protected $volunteerInterest; //string
        protected $volunteerInterestTutoring; // string
        protected $volunteerInterestOther; // string
        protected $approved; // bool

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
                "mobileNumber" => $this->mobileNumber,
                "emailAddress" => $this->emailAddress,
                "birthDate" => $this->birthDate->format(WB_DATE_FORMAT),
                "gender" => $this->gender,
                "address" => $this->address,
                "availability" => $this->availability,
                "volunteerInterest" => $this->volunteerInterest,
                "volunteerInterestTutoring" => $this->volunteerInterestTutoring,
                "volunteerInterestOther" => $this->volunteerInterestOther,
                "approved" => $this->approved,
                "insertDate" => !is_null($this->insertDate) ? $this->insertDate->format(WB_DATETIME_FORMAT) : ''
            );
        }

    }
