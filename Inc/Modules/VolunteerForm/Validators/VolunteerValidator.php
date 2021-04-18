<?php

    use Rakit\Validation\Validator;

    class VolunteerValidator {

        private static $volunteerValidator;
        private static $validator;

        private final function __construct() {
            self::$validator = new Validator();
        }

        public static function getInstance() {
            if (!isset(self::$volunteerValidator)) {
                self::$volunteerValidator = new VolunteerValidator();
            }

            return self::$volunteerValidator;
        }

        public function validate(Volunteer $entity) : array {
            self::$validator->addValidator('date_range', new DateRangeRule());
            self::$validator->addValidator('min_selected', new MinSelectedRule());
            self::$validator->addValidator('required_if_contains', new RequiredIfContainsRule($entity));
            
            $entityAsArray = $entity->toArray();
            $today = new DateTime("now", new DateTimeZone(TEBO_CURRENT_TIMEZONE));

            $validation = VolunteerValidator::$validator->make([
                'firstName' => $entityAsArray["firstName"],
                'lastName' => $entityAsArray["lastName"],
                'otherNames' => $entityAsArray["otherNames"],
                'mobileNumber' => $entityAsArray["mobileNumber"],
                'emailAddress' => $entityAsArray["emailAddress"],
                'birthDate' => $entityAsArray["birthDate"],
                'gender' => $entityAsArray["gender"],
                'stateOfOrigin' => $entityAsArray["stateOfOrigin"],
                'address' => $entityAsArray["address"],
                'availability' => $entityAsArray["availability"],
                'volunteerInterest' => $entityAsArray["volunteerInterest"],
                'volunteerInterestTutoring' => $entityAsArray["volunteerInterestTutoring"],
                'volunteerInterestOther' => $entityAsArray["volunteerInterestOther"],
            ], [
                'firstName' => 'required',
                'lastName' => 'required',
                'otherNames' => '',
                'mobileNumber' => 'required',
                'emailAddress' => 'required|email',
                'birthDate' => "required|date:Y-m-d|date_range:Y-m-d,," . $today->format(TEBO_DATE_FORMAT),
                'gender' => 'required',
                'stateOfOrigin' => 'required',
                'address' => 'required',
                
                'availability' => 'required|min_selected:1',
                'volunteerInterest' => 'required|min_selected:1',
                'volunteerInterestTutoring' => 'required_if_contains:volunteerInterest,chkInterestTutoring',
                'volunteerInterestOther' => 'required_if_contains:volunteerInterest,chkNotListedActivityOfInterest',
            ]);

            $validation->setAliases([
                'firstName' => 'Volunteer first name',
                'lastName' => 'Volunteer last name',
                'otherNames' => 'Volunteer other names',
                'mobileNumber' => 'Volunteer mobile number',
                'emailAddress' => 'Volunteer email',
                'birthDate' => 'Volunteer birth date',
                'gender' => 'Volunteer gender',
                'stateOfOrigin' => 'Volunteer state of origin',
                'address' => 'Volunteer address',
                'availability' => 'Volunteer availability',
                'volunteerInterest' => 'Volunteer interest',
                'volunteerInterestTutoring' => 'Volunteer tutoring description',
                'volunteerInterestOther' => 'Volunteer not listed activities description',
            ]);

            $validation->setMessage('required', ":attribute is required");
            
            $validation->validate();

            if (!$validation->fails())
                return [];

            return $validation->errors()->toArray();
        }
    }
