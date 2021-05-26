<?php
    class ScholarshipFormatter extends BaseFormatter {
        
        private $stateRepo;
        private $labelDictionary;

        public function __construct() {
            parent::__construct();

            $this->stateRepo = new StateRepo();
            $this->labelDictionary = array (
                "chkScholarshipReqAccomodation" => "Accommodation",
                "chkScholarshipReqTuition" => "Tuition",
                "chkScholarshipReqMonthlyAllowance" => "Monthly Allowance",
                "chkEduPrimary" => "Primary",
                "chkEduSecondary" => "Secondary",
                "chkEduUniversity" => "University",
            );
        }
        
        public function format($data) : array {
            $state = $this->stateRepo->getById($data->stateOfOrigin);

            $requiredScholarshipsSelected = [];
            foreach (explode(",", $data->requiredScholarships) as $value) {
                $requiredScholarshipsSelected[] = $this->labelDictionary[$value];
            }

            $levelSelected = [];
            foreach (explode(",", $data->scholarshipEducation->level) as $value) {
                $levelSelected[] = $this->labelDictionary[$value];
            }
            
            return array(
                "id" => $data->getId(),
                "firstName" => $data->firstName,
                "lastName" => $data->lastName,
                "otherNames" => $data->otherNames,
                "nationalIdNumber" => $data->nationalIdNumber,
                "birthPlace" => $data->birthPlace,
                "birthDate" => !is_null($data->birthDate) ? $data->birthDate->format(TEBO_DATE_FORMAT) : '',
                "emailAddress" => $data->emailAddress,
                "mobileNumber" => $data->mobileNumber,
                "parentNumber" => $data->parentNumber,
                "gotScholarshipLastYear" => $data->gotScholarshipLastYear ? "Yes" : "No",
                "requiredScholarships" => $requiredScholarshipsSelected,
                "fileId" => $data->fileId,
                "stateOfOrigin" => $state->stateName,
                "address" => $data->address,
                "howKnowFoundation" => $data->howKnowFoundation,
                "volunteerInterest" => $data->volunteerInterest ? "Yes" : "No",
                "whyScholarship" => $data->whyScholarship,
                "iAgree" => $data->iAgree ? "Yes" : "No",
                "approved" => ($data->approved ?? false) ? "Approved" : "Not Approved",
                "insertDate" => !is_null($data->getInsertDate()) ? $data->getInsertDate()->format(TEBO_DATE_FORMAT) : '',

                "bankName" => $data->scholarshipBank->bankName,
                "bankCode" => $data->scholarshipBank->bankCode,
                "bankSortCode" => $data->scholarshipBank->bankSortCode,
                "accountName" => $data->scholarshipBank->accountName,
                "branchName" => $data->scholarshipBank->branchName,
                "accountNumber" => $data->scholarshipBank->accountNumber,
                "ibanNumber" => $data->scholarshipBank->ibanNumber,

                "level" => $levelSelected,
                "schoolName" => $data->scholarshipEducation->schoolName,
                "department" => $data->scholarshipEducation->department,
                "class" => $data->scholarshipEducation->class,
                "city" => $data->scholarshipEducation->city,
                "state" => $data->scholarshipEducation->state,
                
                "fatherName" => $data->scholarshipFather->name,
                "fatherAliveOrDeceased" => $data->scholarshipFather->aliveOrDeceased,
                "fatherOccupation" => $data->scholarshipFather->occupation,
                "fatherMonthlyIncome" => $data->scholarshipFather->monthlyIncome,
                "fatherCity" => $data->scholarshipFather->city,
                "fatherState" => $data->scholarshipFather->state,
                "fatherMobileNumber" => $data->scholarshipFather->mobileNumber,
                
                "motherName" => $data->scholarshipMother->name,
                "motherAliveOrDeceased" => $data->scholarshipMother->aliveOrDeceased,
                "motherOccupation" => $data->scholarshipMother->occupation,
                "motherMonthlyIncome" => $data->scholarshipMother->monthlyIncome,
                "motherCity" => $data->scholarshipMother->city,
                "motherState" => $data->scholarshipMother->state,
                "motherMobileNumber" => $data->scholarshipMother->mobileNumber,
                
                "nSiblings" => $data->scholarshipSibling->nSiblings,
                "nSiblingsInPrimary" => $data->scholarshipSibling->nSiblingsInPrimary,
                "nSiblingsInSecondary" => $data->scholarshipSibling->nSiblingsInSecondary,
                "nSiblingsInUniversity" => $data->scholarshipSibling->nSiblingsInUniversity,
                
                "refLastName" => $data->scholarshipReference->lastName,
                "refFirstName" => $data->scholarshipReference->firstName,
                "refOtherNames" => $data->scholarshipReference->otherNames,
                "refOccupation" => $data->scholarshipReference->occupation,
                "refPosition" => $data->scholarshipReference->position,
                "refAddress" => $data->scholarshipReference->address,
                "refPhoneNumber" => $data->scholarshipReference->phoneNumber,
                
                "docPassportPhotograph" => TEBO_UPLOAD_BASE_URL . $data->scholarshipDocument->passportPhotograph->getNewFilename(),
                "docRequestLetter" => TEBO_UPLOAD_BASE_URL . $data->scholarshipDocument->requestLetter->getNewFilename(),
                "docAdmissionLetter" => TEBO_UPLOAD_BASE_URL . $data->scholarshipDocument->admissionLetter->getNewFilename(),
                "docJambResult" => TEBO_UPLOAD_BASE_URL . $data->scholarshipDocument->jambResult->getNewFilename(),
                "docWaecResult" => TEBO_UPLOAD_BASE_URL . $data->scholarshipDocument->waecResult->getNewFilename(),
                "docMatriculationNumber" => TEBO_UPLOAD_BASE_URL . $data->scholarshipDocument->matriculationNumber->getNewFilename(),
                "docIndigeneCertificate" => TEBO_UPLOAD_BASE_URL . $data->scholarshipDocument->indigeneCertificate->getNewFilename(),
                "docBirthCertificate" => TEBO_UPLOAD_BASE_URL . $data->scholarshipDocument->birthCertificate->getNewFilename(),
                "docValidIdCard" => TEBO_UPLOAD_BASE_URL . $data->scholarshipDocument->validIdCard->getNewFilename(),
            );
        }

    }
