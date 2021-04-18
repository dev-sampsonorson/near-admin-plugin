<?php

    use Rakit\Validation\Validator;

    class DonationValidator {

        private static $donationValidator;
        private static $validator;

        private final function __construct() {
            self::$validator = new Validator();
        }

        public static function getInstance() {
            if (!isset(self::$donationValidator)) {
                self::$donationValidator = new DonationValidator();
            }

            return self::$donationValidator;
        }

        public function validate(Donation $entity) : array {            
            $entityAsArray = $entity->toArray();

            $validation = DonationValidator::$validator->make([
                'emailAddress' => $entityAsArray["emailAddress"],
                'amount' => $entityAsArray["amount"],
                'reason' => $entityAsArray["reason"],
                'narration' => $entityAsArray["narration"],
            ], [
                'emailAddress' => 'required|email',
                'amount' => 'required',
                'reason' => 'required',
                'narration' => '',
            ]);

            $validation->setAliases([
                'emailAddress' => 'Donation email',
                'amount' => 'Donation amount',
                'reason' => 'Donation reason',
                'narration' => 'Donation narration',
            ]);

            $validation->setMessage('required', ":attribute is required");
            
            $validation->validate();

            if (!$validation->fails())
                return [];

            return $validation->errors()->toArray();
        }
    }
