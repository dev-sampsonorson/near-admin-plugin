<?php

    use Rakit\Validation\Validator;

    class ScholarshipFatherValidator {

        private static $fatherValidator;
        private static $validator;

        private $validation;

        private final function __construct() {
            self::$validator = new Validator();
        }

        public static function getInstance() {
            if (!isset(self::$fatherValidator)) {
                self::$fatherValidator = new ScholarshipFatherValidator();
            }

            return self::$fatherValidator;
        }

        public function validate(ScholarshipFather $entity) : array {            
            $entityAsArray = $entity->toArray();
            $today = new DateTime("now", new DateTimeZone(TEBO_CURRENT_TIMEZONE));

            $this->validation = ScholarshipFatherValidator::$validator->make([
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
                'name' => 'Father name',
                'aliveOrDeceased' => 'Father alive or deceased',
                'occupation' => 'Father occupation',
                'monthlyIncome' => 'Father monthly income',
                'city' => 'Father city',
                'state' => 'Father state',
                'mobileNumber' => 'Father mobile number',
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
