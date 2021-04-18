<?php

    use Rakit\Validation\Validator;

    class ScholarshipMotherValidator {

        private static $motherValidator;
        private static $validator;

        private $validation;

        private final function __construct() {
            self::$validator = new Validator();
        }

        public static function getInstance() {
            if (!isset(self::$motherValidator)) {
                self::$motherValidator = new ScholarshipMotherValidator();
            }

            return self::$motherValidator;
        }

        public function validate(ScholarshipMother $entity) : array {            
            $entityAsArray = $entity->toArray();
            $today = new DateTime("now", new DateTimeZone(TEBO_CURRENT_TIMEZONE));

            $this->validation = ScholarshipMotherValidator::$validator->make([
                'name' => $entityAsArray["name"],
                'aliveOrDeceased' => $entityAsArray["aliveOrDeceased"],
                'occupation' => $entityAsArray["occupation"],
                'monthlyIncome' => $entityAsArray["monthlyIncome"],
                'city' => $entityAsArray["city"],
                'state' => $entityAsArray["state"],
                'mobileNumber' => $entityAsArray["mobileNumber"],
            ], [
                'name' => 'required',
                'aliveOrDeceased' => 'required',
                'occupation' => 'required',
                'monthlyIncome' => 'required',
                'city' => 'required',
                'state' => 'required',
                'mobileNumber' => 'required',
            ]);

            $this->validation->setAliases([
                'name' => 'Mother name',
                'aliveOrDeceased' => 'Mother alive or deceased',
                'occupation' => 'Mother occupation',
                'monthlyIncome' => 'Mother monthly income',
                'city' => 'Mother city',
                'state' => 'Mother state',
                'mobileNumber' => 'Mother mobile number',
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
