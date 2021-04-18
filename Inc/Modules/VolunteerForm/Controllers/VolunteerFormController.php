<?php
/* if (!session_id())
    session_start(); */

use Rakit\Validation\Validator;

class VolunteerFormController extends BaseController
{
    public $settings;

    private $post_id;
    private $validator;
    private $repo; // VolunteerRepo

    public function register()
    {
        $post = get_page_by_title('Volunteer Form');
        $this->post_id = isset($post)? $post->ID : 0;

        $this->validator = VolunteerValidator::getInstance();

        $this->settings = new SettingsApi();
        $this->callbacks = new VolunteerFormCallbacks($this);
        $this->repo = new VolunteerRepo();

        add_shortcode('near-volunteer-form', array($this->callbacks, 'renderVolunteerForm'));
        

        if ( is_admin() ) {
            add_action('wp_ajax_saveVolunteerForm', array($this, 'saveVolunteerForm'));
            add_action('wp_ajax_nopriv_saveVolunteerForm', array($this, 'saveVolunteerForm'));
        } else {
            // Add non-Ajax front-end action hooks here
        }
    }
    
    public function saveVolunteerForm() {
        try {
            if (!DOING_AJAX || !check_ajax_referer('saveVolunteerForm_nonce', 'nonce', false)) {
                return $this->return_json_error(500, 'Invalid request');
            }
            
            $validationResultList = [];
            $formData = json_decode(stripslashes($_POST['data']));

            // make entity
            $entity = $this->createEntity($formData);

            // validate entity
            $validationResult = $this->validateEntity($entity);

            if (!$validationResult->isSuccessful())
                return $this->return_json_error(400, $validationResult->getMessage(), $validationResult->toArray());    

            // save entity
            $saveResult = $this->saveVolunteerEntity($entity);

            if (!$saveResult->isSuccessful())
                return $this->return_json_error(400, $saveResult->getMessage(), $saveResult->toArray());

            $volunteerId = $saveResult->getSuccessResult()->getId();

            return $this->return_json(200, $saveResult->getResult()->toArray()); 
        } catch(Exception $e) {
            return $this->return_json_error(400, 'Unable to save volunteer form');
        }
    }

    private function createEntity($data): Volunteer {
        $config = array();

        $config["lastName"] = $data->txtLastName;
        $config["firstName"] = $data->txtFirstName;
        $config["otherNames"] = $data->txtOtherName;
        $config["mobileNumber"] = $data->txtMobileNumber;
        $config["emailAddress"] = $data->txtEmailAddress;
        $config["birthDate"] = Helper::toDateTimeFromString($data->dtpBirthDate, TEBO_DATE_FORMAT);
        $config["gender"] = $data->ddlGender;
        $config["stateOfOrigin"] = $data->ddlStateOfOrigin;
        $config["address"] = $data->txtAddress;
        
        $availablitySelected = "";
        foreach($data->availability->group as $item) {
            $availablitySelected .= $item . ",";
        }
        $config["availability"] = substr($availablitySelected, 0, strlen($availablitySelected) - 1);

        
        $interestSelected = "";
        foreach($data->interest->group as $item) {
            $interestSelected .= $item . ",";

            if ($item === 'chkInterestTutoring') {
                $config["volunteerInterestTutoring"] =
                $data->interest->chkInterestTutoring->txtInterestTutoringDetail;
            }

            if ($item === 'chkNotListedActivityOfInterest') {
                $config["volunteerInterestOther"] =
                $data->interest->chkNotListedActivityOfInterest->txtNotListedActivityOfInterest;
            }
        }
        $config["volunteerInterest"] = substr($interestSelected, 0, strlen($interestSelected) - 1);

        return new Volunteer($config);
    }

    private function validateEntity($entity): Result {
        $result = $this->validator->validate($entity);
        
        if (count($result) > 0)
            return Result::fromErrorWithResult(AppError::ERROR_VALIDATION, $result, "Invalid volunteer information");

        return Result::fromSuccess();
    }

    private function saveVolunteerEntity($entity): Result {
        $volunteer = $this->repo->insert($entity);        
        
        if ($volunteer == null)
            return Result::fromError(AppError::ERROR_GENERAL, "Unable to save volunteer information");

        return Result::fromSuccess($volunteer);
    }
}
