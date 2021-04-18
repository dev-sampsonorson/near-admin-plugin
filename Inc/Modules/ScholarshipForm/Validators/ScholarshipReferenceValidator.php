<?php

    use Rakit\Validation\Validator;

    class ScholarshipReferenceValidator {

        private static $referenceValidator;
        private static $validator;

        private $validation;

        private final function __construct() {
            self::$validator = new Validator();
        }

        public static function getInstance() {
            if (!isset(self::$referenceValidator)) {
                self::$referenceValidator = new ScholarshipReferenceValidator();
            }

            return self::$referenceValidator;
        }

        public function validate(ScholarshipReference $entity) : array {            
            $entityAsArray = $entity->toArray();
            $today = new DateTime("now", new DateTimeZone(TEBO_CURRENT_TIMEZONE));

            $this->validation = ScholarshipReferenceValidator::$validator->make([
                'lastName' => $entityAsArray["lastName"],
                'firstName' => $entityAsArray["firstName"],
                'otherNames' => $entityAsArray["otherNames"],
                'occupation' => $entityAsArray["occupation"],
                'position' => $entityAsArray["position"],
                'address' => $entityAsArray["address"],
                'phoneNumber' => $entityAsArray["phoneNumber"],
            ], [
                'lastName' => 'required',
                'firstName' => 'required',
                'otherNames' => '',
                'occupation' => 'required',
                'position' => 'required',
                'address' => 'required',
                'phoneNumber' => 'required',
            ]);

            $this->validation->setAliases([
                'lastName' => 'Reference last name',
                'firstName' => 'Reference first name',
                'otherNames' => 'Reference other names',
                'occupation' => 'Reference occupation',
                'position' => 'Reference position',
                'address' => 'Reference address',
                'phoneNumber' => 'Reference phone number',
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
