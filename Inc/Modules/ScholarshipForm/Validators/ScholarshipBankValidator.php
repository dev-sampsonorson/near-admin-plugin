<?php

    use Rakit\Validation\Validator;

    class ScholarshipBankValidator {

        private static $bankValidator;
        private static $validator;

        private $validation;

        private final function __construct() {
            self::$validator = new Validator();
        }

        public static function getInstance() {
            if (!isset(self::$bankValidator)) {
                self::$bankValidator = new ScholarshipBankValidator();
            }

            return self::$bankValidator;
        }

        public function validate(ScholarshipBank $entity) : array {      
            $entityAsArray = $entity->toArray();
            $today = new DateTime("now", new DateTimeZone(TEBO_CURRENT_TIMEZONE));

            $this->validation = ScholarshipBankValidator::$validator->make([
                'bankName' => $entityAsArray["bankName"],
                'bankCode' => $entityAsArray["bankCode"],
                'bankSortCode' => $entityAsArray["bankSortCode"],
                'accountName' => $entityAsArray["accountName"],
                'accountNumber' => $entityAsArray["accountNumber"],
                'ibanNumber' => $entityAsArray["ibanNumber"],
            ], [
                'bankName' => 'required',
                'bankCode' => 'required',
                'bankSortCode' => 'required',
                'accountName' => 'required',
                'accountNumber' => 'required',
                'ibanNumber' => 'required',
            ]);

            $this->validation->setAliases([
                'bankName' => 'Bank name',
                'bankCode' => 'Bank code',
                'bankSortCode' => 'Bank sort code',
                'accountName' => 'Account name',
                'accountNumber' => 'Account number',
                'ibanNumber' => 'IBAN number',
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
