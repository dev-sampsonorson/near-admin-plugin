<?php
    class ScholarshipSibling extends BaseEntity {

        public $scholarshipId; // int
        public $nSiblings; // int
        public $nSiblingsInPrimary; // int
        public $nSiblingsInSecondary; // int
        public $nSiblingsInUniversity; // int

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
                "nSiblings" => $this->nSiblings,
                "nSiblingsInPrimary" => $this->nSiblingsInPrimary,
                "nSiblingsInSecondary" => $this->nSiblingsInSecondary,
                "nSiblingsInUniversity" => $this->nSiblingsInUniversity,
                "insertDate" => !is_null($this->insertDate) ? $this->insertDate->format(TEBO_DATETIME_FORMAT) : ''
            );
        }

    }
