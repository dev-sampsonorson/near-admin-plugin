<?php

    use Rakit\Validation\Validator;

    class ScholarshipEducationValidator {

        private static $educationValidator;
        private static $validator;

        private $validation;

        private final function __construct() {
            self::$validator = new Validator();
        }

        public static function getInstance() {
            if (!isset(self::$educationValidator)) {
                self::$educationValidator = new ScholarshipEducationValidator();
            }

            return self::$educationValidator;
        }

        public function validate(ScholarshipEducation $entity) : array {            
            $entityAsArray = $entity->toArray();
            $today = new DateTime("now", new DateTimeZone(TEBO_CURRENT_TIMEZONE));

            $this->validation = ScholarshipEducationValidator::$validator->make([
                'level' => $entityAsArray["level"],
                'schoolName' => $entityAsArray["schoolName"],
                'department' => $entityAsArray["department"],
                'class' => $entityAsArray["class"],
                'city' => $entityAsArray["city"],
                'state' => $entityAsArray["state"],
            ], [
                'level' => 'required',
                'schoolName' => 'required',
                'department' => 'required',
                'class' => 'required',
                'city' => 'required',
                'state' => 'required',
            ]);

            $this->validation->setAliases([
                'level' => 'Level of education',
                'schoolName' => 'School name',
                'department' => 'Department',
                'class' => 'Class',
                'city' => 'City (Local Government)',
                'state' => 'State',
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
