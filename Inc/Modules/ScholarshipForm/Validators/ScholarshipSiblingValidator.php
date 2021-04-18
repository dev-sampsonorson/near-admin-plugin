<?php

    use Rakit\Validation\Validator;

    class ScholarshipSiblingValidator {

        private static $siblingValidator;
        private static $validator;

        private $validation;

        private final function __construct() {
            self::$validator = new Validator();
        }

        public static function getInstance() {
            if (!isset(self::$siblingValidator)) {
                self::$siblingValidator = new ScholarshipSiblingValidator();
            }

            return self::$siblingValidator;
        }

        public function validate(ScholarshipSibling $entity) : array {            
            $entityAsArray = $entity->toArray();
            $today = new DateTime("now", new DateTimeZone(TEBO_CURRENT_TIMEZONE));

            $this->validation = ScholarshipSiblingValidator::$validator->make([
                'nSiblings' => $entityAsArray["nSiblings"],
                'nSiblingsInPrimary' => $entityAsArray["nSiblingsInPrimary"],
                'nSiblingsInSecondary' => $entityAsArray["nSiblingsInSecondary"],
                'nSiblingsInUniversity' => $entityAsArray["nSiblingsInUniversity"],
            ], [
                'nSiblings' => 'required|numeric',
                'nSiblingsInPrimary' => 'required|numeric',
                'nSiblingsInSecondary' => 'required|numeric',
                'nSiblingsInUniversity' => 'required|numeric',
            ]);

            $this->validation->setAliases([
                'nSiblings' => 'Number of siblings',
                'nSiblingsInPrimary' => 'Number of siblings in primary school',
                'nSiblingsInSecondary' => 'Number of siblings in secondary school',
                'nSiblingsInUniversity' => 'Number of siblings in the university',
            ]);

            $this->validation->setMessage('required', ":attribute is required");
            
            $this->validation->validate();

            if (!$this->validation->fails())
                return [];

            return $this->validation->errors()->toArray();
        }

        public function fails() {
            return $this->validation->fails();
        }
    }
