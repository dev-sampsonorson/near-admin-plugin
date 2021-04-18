<?php
    class Donation extends BaseEntity {

        public $emailAddress; // string
        public $amount; // string
        public $reason; // string
        public $narration; // string

        public function __construct(array $config) {
            parent::__construct($config);
        }

        public function validate() : bool {
            return true;
        }

        public function toArray() : array {
            return array(
                "id" => $this->id,
                "emailAddress" => $this->emailAddress,
                "amount" => $this->amount,
                "reason" => $this->reason,
                "narration" => $this->narration,
                "insertDate" => !is_null($this->insertDate) ? $this->insertDate->format(TEBO_DATETIME_FORMAT) : ''
            );
        }

    }
