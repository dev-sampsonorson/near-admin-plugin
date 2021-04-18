<?php

    use Rakit\Validation\Validator;

    class ScholarshipDocumentValidator {

        private static $documentValidator;
        private static $validator;

        private $validation;

        private final function __construct() {
            self::$validator = new Validator();
        }

        public static function getInstance() {
            if (!isset(self::$documentValidator)) {
                self::$documentValidator = new ScholarshipDocumentValidator();
            }

            return self::$documentValidator;
        }

        public function validate(ScholarshipDocument $entity) : array {            
            $entityAsArray = $entity->toArray();
            $today = new DateTime("now", new DateTimeZone(TEBO_CURRENT_TIMEZONE));

            $this->validation = ScholarshipDocumentValidator::$validator->make([
                'passportPhotograph' => $entityAsArray["passportPhotograph"]["fileArray"],
                'requestLetter' => $entityAsArray["requestLetter"]["fileArray"],
                'admissionLetter' => $entityAsArray["admissionLetter"]["fileArray"],
                'jambResult' => $entityAsArray["jambResult"]["fileArray"],
                'waecResult' => $entityAsArray["waecResult"]["fileArray"],
                'matriculationNumber' => $entityAsArray["matriculationNumber"]["fileArray"],
                'indigeneCertificate' => $entityAsArray["indigeneCertificate"]["fileArray"],
                'birthCertificate' => $entityAsArray["birthCertificate"]["fileArray"],
                'validIdCard' => $entityAsArray["validIdCard"]["fileArray"],
            ], [
                'passportPhotograph' => 'required|uploaded_file:0,1M,pdf',
                'requestLetter' => 'required|uploaded_file:0,1M,pdf',
                'admissionLetter' => 'required|uploaded_file:0,1M,pdf',
                'jambResult' => 'required|uploaded_file:0,1M,pdf',
                'waecResult' => 'required|uploaded_file:0,1M,pdf',
                'matriculationNumber' => 'required|uploaded_file:0,1M,pdf',
                'indigeneCertificate' => 'required|uploaded_file:0,1M,pdf',
                'birthCertificate' => 'required|uploaded_file:0,1M,pdf',
                'validIdCard' => 'required|uploaded_file:0,1M,pdf',
            ]);

            $this->validation->setAliases([
                'passportPhotograph' => 'Passport photograph',
                'requestLetter' => 'Request letter',
                'admissionLetter' => 'Admission letter',
                'jambResult' => 'JAMB result',
                'waecResult' => 'WAEC result',
                'matriculationNumber' => 'Matriculation number',
                'indigeneCertificate' => 'Indigene certificate',
                'birthCertificate' => 'Birth certificate',
                'validIdCard' => 'Valid ID card',
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
