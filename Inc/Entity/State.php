<?php
    class State extends BaseEntity {

        public $stateName; // string
        public $zoneId; // string

        public function __construct(array $config) {
            parent::__construct($config);
        }

        public function validate() : bool {
            return true;
        }

        public function toArray() : array {
            return array(
                "id" => $this->id,
                "stateName" => $this->stateName,
                "zoneId" => $this->zoneId,
            );
        }

    }
