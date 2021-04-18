<?php
/* if (!session_id())
    session_start(); */

use Rakit\Validation\Validator;

class ScholarshipFormController extends BaseController
{
    public $settings;

    private $post_id;
    private $validator;
    private $repo; // ScholarshipRepo
    private $stateRepo;

    public function register()
    {
        $post = get_page_by_title('Scholarship Form');
        $this->post_id = isset($post)? $post->ID : 0;

        $this->validator = ScholarshipValidator::getInstance();

        $this->settings = new SettingsApi();
        $this->callbacks = new ScholarshipFormCallbacks($this);
        $this->repo = new ScholarshipRepo();
        $this->stateRepo = new StateRepo();

        add_shortcode('near-scholarship-form', array($this->callbacks, 'renderScholarshipForm'));
        

        if ( is_admin() ) {
            add_action('wp_ajax_saveScholarshipForm', array($this, 'saveScholarshipForm'));
            add_action('wp_ajax_nopriv_saveScholarshipForm', array($this, 'saveScholarshipForm'));
        } else {
            // Add non-Ajax front-end action hooks here
        }
    }
    
    public function saveScholarshipForm() {
        try {
            if (!DOING_AJAX || !check_ajax_referer('saveScholarshipForm_nonce', 'nonce', false)) {
                return $this->return_json_error(500, 'Invalid request');
            }
            
            $validationResultList = [];
            $formData = json_decode(stripslashes($_POST['data']));

            // generate file id
            $fileId = $this->generateFileId($formData);

            // make entity
            $entity = $this->createEntity($formData, $_FILES, $fileId);

            // validate entity
            $validationResult = $this->validateEntity($entity);
            // print_r($validationResult->toArray());
            if (!$validationResult->isSuccessful())
                return $this->return_json_error(400, $validationResult->getMessage(), $validationResult->toArray());
            
            // upload documents
            $uploadResult = $this->uploadFiles($entity, $_FILES);
            if(!$uploadResult->isSuccessful())
                return $this->return_json_error(500, $uploadResult->getMessage(), $uploadResult->toArray());
                
            // save entity
            $saveResult = $this->saveEntity($entity);
            if (!$saveResult->isSuccessful())
                return $this->return_json_error(400, $saveResult->getMessage(), $saveResult->toArray());

            $scholarshipId = $saveResult->getSuccessResult()->getId();            
    
            return $this->return_json(200, $saveResult->getResult()->toArray());
        } catch(Exception $e) {
            return $this->return_json_error(400, 'Unable to save scholarship form');
        }
    }

    private function createEntity($data, $files, $fileId): Scholarship {
        $config = array();

        $config["firstName"] = $data->txtLastName;
        $config["lastName"] = $data->txtFirstName;
        $config["otherNames"] = $data->txtOtherName;
        $config["nationalIdNumber"] = $data->txtNationalIdNumber;
        $config["birthPlace"] = $data->txtBirthPlace;
        $config["birthDate"] = Helper::toDateTimeFromString($data->dtpBirthDate, TEBO_DATE_FORMAT);
        $config["emailAddress"] = $data->txtEmailAddress;
        $config["mobileNumber"] = $data->txtMobileNumber;
        $config["parentNumber"] = $data->txtParentsPhone;
        $config["gotScholarshipLastYear"] = $data->rbLastYearScholarship === 'true' ? true : fasle;
        $config["requiredScholarships"] = Helper::arrayToStringList($data->scholarshipType->group);
        $config["fileId"] = $fileId; // Genegrated file id
        $config["stateOfOrigin"] = $data->ddlStateOfOrigin;
        $config["address"] = $data->txtAddress;
        $config["howKnowFoundation"] = $data->txtHowKnowFoundation;
        $config["volunteerInterest"] = $data->rbVolunteerParticipation === 'true' ? true : fasle;
        $config["whyScholarship"] = $data->txtWhyScholarship;
        $config["iAgree"] = $data->chkIAgree === 'true' ? true : fasle;

        // Bank
        $config["__scholarshipBank"] = array(
            "bankName" => $data->txtBankName,
            "branchName" => $data->txtBankBranch,
            "accountNumber" => $data->txtAccountNumber,
            "ibanNumber" => $data->txtIbanNumber
        );        
        
        // Education
        $config["__scholarshipEducation"] = array(
            "level" => Helper::arrayToStringList($data->educationLevel->group),
            "schoolName" => $data->txtEduSchoolName,
            "department" => $data->txtEduDepartment,
            "class" => $data->txtEduClass,
            "city" => $data->txtEduCity,
            "state" => $data->txtEduState,
        );

        // Father
        $config["__scholarshipFather"] = array(
            "name" => $data->txtFamilyFatherName,
            "aliveOrDeceased" => $data->rbFamilyFatherAlive,
            "occupation" => $data->txtFamilyFatherOccupation,
            "monthlyIncome" => $data->txtFamilyFatherIncome,
            "city" => $data->txtFamilyFatherCity,
            "state" => $data->txtFamilyFatherState,
            "mobileNumber" => $data->txtFamilyFatherMobileNumber,
        );

        // Mother
        $config["__scholarshipMother"] = array(
            "name" => $data->txtFamilyMotherName,
            "aliveOrDeceased" => $data->rbFamilyMotherAlive,
            "occupation" => $data->txtFamilyMotherOccupation,
            "monthlyIncome" => $data->txtFamilyMotherIncome,
            "city" => $data->txtFamilyMotherCity,
            "state" => $data->txtFamilyMotherState,
            "mobileNumber" => $data->txtFamilyMotherMobileNumber,
        );

        // Sibling
        $config["__scholarshipSibling"] = array(
            "nSiblings" => $data->txtSiblingNumber,
            "nSiblingsInPrimary" => $data->txtSiblingPrimarySchNumber,
            "nSiblingsInSecondary" => $data->txtSiblingSecondarySchNumber,
            "nSiblingsInUniversity" => $data->txtSiblingUniversityNumber,
        );

        // Document
        // print_r($_FILES['filePassportPhotograph']);
        $config["__scholarshipDocument"] = array(
            "passportPhotograph" => new FileInfo($_FILES['filePassportPhotograph'], Helper::generateFileName($_FILES['filePassportPhotograph'], 1)),
            "requestLetter" => new FileInfo($_FILES['fileRequestLetter'], Helper::generateFileName($_FILES['fileRequestLetter'], 1)),
            "admissionLetter" => new FileInfo($_FILES['fileAdmissionLetter'], Helper::generateFileName($_FILES['fileAdmissionLetter'], 2)),
            "jambResult" => new FileInfo($_FILES['fileJambResult'], Helper::generateFileName($_FILES['fileJambResult'], 3)),
            "waecResult" => new FileInfo($_FILES['fileWaecResult'], Helper::generateFileName($_FILES['fileWaecResult'], 4)),
            "matriculationNumber" => new FileInfo($_FILES['fileMatriculationNumber'], Helper::generateFileName($_FILES['fileMatriculationNumber'], 5)),
            "indigeneCertificate" => new FileInfo($_FILES['fileIndigeneCertificate'], Helper::generateFileName($_FILES['fileIndigeneCertificate'], 6)),
            "birthCertificate" => new FileInfo($_FILES['fileBirthCertificate'], Helper::generateFileName($_FILES['fileBirthCertificate'], 7)),
            "validIdCard" => new FileInfo($_FILES['fileValidIdCard'], Helper::generateFileName($_FILES['fileValidIdCard'], 8)),
        );

        // Reference
        $config["__scholarshipReference"] = array(
            "lastName" => $data->txtRefLastName,
            "firstName" => $data->txtRefFirstName,
            "otherNames" => $data->txtRefOtherName,
            "occupation" => $data->txtRefOccupation,
            "position" => $data->txtRefPosition,
            "address" => $data->txtRefAddress,
            "phoneNumber" => $data->txtRefPhoneNumber,
        );

        return new Scholarship($config);
    }

    private function validateEntity($entity): Result {
        $result = $this->validator->validate($entity);
        
        if (count($result) > 0)
            return Result::fromErrorWithResult(AppError::ERROR_VALIDATION, $result, "Invalid scholarship information");

        return Result::fromSuccess();
    }

    private function saveEntity($entity): Result {
        $scholarship = $this->repo->insert($entity);        
        
        if ($scholarship == null)
            return Result::fromError(AppError::ERROR_GENERAL, "Unable to save scholarship information");

        return Result::fromSuccess($scholarship);
    }

    private function uploadFiles($entity, $files): Result {
        try {
            $destinationFilePaths = array(
                'filePassportPhotograph'  => TEBO_UPLOAD_BASE_PATH . $entity->scholarshipDocument->passportPhotograph->getNewFilename(),
                'fileRequestLetter'       => TEBO_UPLOAD_BASE_PATH . $entity->scholarshipDocument->requestLetter->getNewFilename(),
                'fileAdmissionLetter'     => TEBO_UPLOAD_BASE_PATH . $entity->scholarshipDocument->admissionLetter->getNewFilename(),
                'fileJambResult'          => TEBO_UPLOAD_BASE_PATH . $entity->scholarshipDocument->jambResult->getNewFilename(),
                'fileWaecResult'          => TEBO_UPLOAD_BASE_PATH . $entity->scholarshipDocument->waecResult->getNewFilename(),
                'fileMatriculationNumber' => TEBO_UPLOAD_BASE_PATH . $entity->scholarshipDocument->matriculationNumber->getNewFilename(),
                'fileIndigeneCertificate' => TEBO_UPLOAD_BASE_PATH . $entity->scholarshipDocument->indigeneCertificate->getNewFilename(),
                'fileBirthCertificate'    => TEBO_UPLOAD_BASE_PATH . $entity->scholarshipDocument->birthCertificate->getNewFilename(),
                'fileValidIdCard'         => TEBO_UPLOAD_BASE_PATH . $entity->scholarshipDocument->validIdCard->getNewFilename()
            );
    
            $sourceFilePaths = array(
                'filePassportPhotograph'  => $_FILES['filePassportPhotograph']['tmp_name'],
                'fileRequestLetter'       => $_FILES['fileRequestLetter']['tmp_name'],
                'fileAdmissionLetter'     => $_FILES['fileAdmissionLetter']['tmp_name'],
                'fileJambResult'          => $_FILES['fileJambResult']['tmp_name'],
                'fileWaecResult'          => $_FILES['fileWaecResult']['tmp_name'],
                'fileMatriculationNumber' => $_FILES['fileMatriculationNumber']['tmp_name'],
                'fileIndigeneCertificate' => $_FILES['fileIndigeneCertificate']['tmp_name'],
                'fileBirthCertificate'    => $_FILES['fileBirthCertificate']['tmp_name'],
                'fileValidIdCard'         => $_FILES['fileValidIdCard']['tmp_name']
            );
    
            foreach($destinationFilePaths as $key => $value) {
                if (!file_exists($destinationFilePaths[$key]))
                    move_uploaded_file($sourceFilePaths[$key], $destinationFilePaths[$key]);
                else
                    return Result::fromError(AppError::ERROR_GENERAL, "Unable to upload a document; {$key}");
            }

            return Result::fromSuccess();
        } catch(Exception $e) {
            return Result::fromError(AppError::ERROR_GENERAL, "Unable to upload scholarship documents");
        }

    }

    private function generateFileId($data) {
        $stateOfOriginId = $data->ddlStateOfOrigin;
        $state = $this->stateRepo->getById($stateOfOriginId);

        // Get year
        $year = date("y");

        // Get zone id
        $zoneId = $state->zoneId;

        // Random simple number
        $lastScholarshipId = $this->repo->getLastScholarshipId();
        // $lastScholarshipId = str_pad($this->repo->getLastScholarshipId(), NEAR_FOUNDATION_FILEID_PADDING, "0", STR_PAD_LEFT);
        $number = strtoupper(uniqid($lastScholarshipId + 1));


        return "{$year}/{$zoneId}/{$stateOfOriginId}/{$number}";
    }
}
