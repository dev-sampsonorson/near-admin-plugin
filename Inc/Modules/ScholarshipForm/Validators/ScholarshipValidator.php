<?php

    use Rakit\Validation\Validator;

    class ScholarshipValidator {

        private static $scholarshipValidator;
        private static $validator;
        
        private static $bankValidator;
        private static $educationValidator;
        private static $fatherValidator;
        private static $motherValidator;
        private static $siblingValidator;
        private static $documentValidator;
        private static $referenceValidator;

        private final function __construct() {
            self::$validator = new Validator();
            
            self::$bankValidator = ScholarshipBankValidator::getInstance();
            self::$educationValidator = ScholarshipEducationValidator::getInstance();
            self::$fatherValidator = ScholarshipFatherValidator::getInstance();
            self::$motherValidator = ScholarshipMotherValidator::getInstance();
            self::$siblingValidator = ScholarshipSiblingValidator::getInstance();
            self::$documentValidator = ScholarshipDocumentValidator::getInstance();
            self::$referenceValidator = ScholarshipReferenceValidator::getInstance();
        }

        public static function getInstance() {
            if (!isset(self::$scholarshipValidator)) {
                self::$scholarshipValidator = new ScholarshipValidator();
            }

            return self::$scholarshipValidator;
        }

        public function validate(Scholarship $entity) : array {
            self::$validator->addValidator('date_range', new DateRangeRule());
            self::$validator->addValidator('min_selected', new MinSelectedRule());

            
            $entityAsArray = $entity->toArray();
            $today = new DateTime("now", new DateTimeZone(TEBO_CURRENT_TIMEZONE));

            $validation = ScholarshipValidator::$validator->make([
                'firstName' => $entityAsArray["firstName"],
                'lastName' => $entityAsArray["lastName"],
                'otherNames' => $entityAsArray["otherNames"],
                'nationalIdNumber' => $entityAsArray["nationalIdNumber"],
                'birthPlace' => $entityAsArray["birthPlace"],
                'birthDate' => $entityAsArray["birthDate"],
                'emailAddress' => $entityAsArray["emailAddress"],
                'mobileNumber' => $entityAsArray["mobileNumber"],
                'parentNumber' => $entityAsArray["parentNumber"],
                'gotScholarshipLastYear' => $entityAsArray["gotScholarshipLastYear"],
                'requiredScholarships' => $entityAsArray["requiredScholarships"],
                'fileId' => $entityAsArray["fileId"],
                'stateOfOrigin' => $entityAsArray["stateOfOrigin"],
                'address' => $entityAsArray["address"],
                'howKnowFoundation' => $entityAsArray["howKnowFoundation"],
                'volunteerInterest' => $entityAsArray["volunteerInterest"],
                'whyScholarship' => $entityAsArray["whyScholarship"],
                'iAgree' => $entityAsArray["iAgree"],
            ], [
                'firstName' => 'required',
                'lastName' => 'required',
                'otherNames' => '',
                'nationalIdNumber' => '',
                'birthPlace' => 'required',
                'birthDate' => "required|date:Y-m-d|date_range:Y-m-d,," . $today->format(TEBO_DATE_FORMAT),
                'emailAddress' => 'required|email',
                'mobileNumber' => 'required',                
                'parentNumber' => 'required',
                
                'gotScholarshipLastYear' => 'required|boolean',
                'requiredScholarships' => 'required|min_selected:1',
                'fileId' => 'required',
                'stateOfOrigin' => 'required',
                'address' => 'required',
                'howKnowFoundation' => 'required',
                'volunteerInterest' => 'required|boolean',
                'whyScholarship' => 'required',
                'iAgree' => 'required|boolean',
            ]);

            $validation->setAliases([
                'firstName' => 'First name',
                'lastName' => 'Last name',
                'otherNames' => 'Other names',
                'nationalIdNumber' => 'National ID number',
                'birthPlace' => 'Birth place',
                'birthDate' => 'Birth date',
                'emailAddress' => 'Email address',
                'mobileNumber' => 'Mobile number',
                'parentNumber' => 'Parent number',
                'gotScholarshipLastYear' => 'Last year scholarship status',
                'requiredScholarships' => 'Requested scholarship',
                'fileId' => 'File ID',
                'stateOfOrigin' => 'State of origin',
                'address' => 'Address',
                'howKnowFoundation' => 'Volunteer not listed activities description',
                'volunteerInterest' => 'Interest in volunteering',
                'whyScholarship' => 'Reason requesting scholarship',
                'iAgree' => 'I agree',
            ]);

            $validation->setMessage('required', ":attribute is required");
            
            $validation->validate();

            $errors = array();

            if ($validation->fails())
                $errors = array_merge($errors, $validation->errors()->toArray());

            /* if (!$validation->fails())
                return []; */

            // Bank
            $bankValidatorResult = self::$bankValidator->validate($entity->scholarshipBank);
            if (self::$bankValidator->fails())
                $errors = array_merge($errors, $bankValidatorResult);
                
            // Education
            $educationValidatorResult = self::$educationValidator->validate($entity->scholarshipEducation);
            if (self::$educationValidator->fails())
                $errors = array_merge($errors, $educationValidatorResult);
                
            // Father
            $fatherValidatorResult = self::$fatherValidator->validate($entity->scholarshipFather);
            if (self::$fatherValidator->fails())
                $errors = array_merge($errors, $fatherValidatorResult);
                
            // Mother
            $motherValidatorResult = self::$motherValidator->validate($entity->scholarshipMother);
            if (self::$motherValidator->fails())
                $errors = array_merge($errors, $motherValidatorResult);

            // Sibling
            $siblingValidatorResult = self::$siblingValidator->validate($entity->scholarshipSibling);
            if (self::$siblingValidator->fails())
                $errors = array_merge($errors, $siblingValidatorResult);

            // Document
            $documentValidatorResult = self::$documentValidator->validate($entity->scholarshipDocument);
            if (self::$documentValidator->fails())
                $errors = array_merge($errors, $documentValidatorResult);

            // Reference
            $referenceValidatorResult = self::$referenceValidator->validate($entity->scholarshipReference);
            if (self::$referenceValidator->fails())
                $errors = array_merge($errors, $referenceValidatorResult); 
                
            if (count($errors) > 0)
                return $errors; 

            return [];
        }
    }
