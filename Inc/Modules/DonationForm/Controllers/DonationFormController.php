<?php
/* if (!session_id())
    session_start(); */

use Rakit\Validation\Validator;

class DonationFormController extends BaseController
{
    public $settings;

    private $post_id;
    private $validator;
    private $repo; // DonationRepo

    public function register()
    {
        $post = get_page_by_title('Donation Form');
        $this->post_id = isset($post)? $post->ID : 0;

        $this->validator = DonationValidator::getInstance();

        $this->settings = new SettingsApi();
        $this->callbacks = new DonationFormCallbacks($this);
        $this->repo = new DonationRepo();

        add_shortcode('near-donation-form', array($this->callbacks, 'renderDonationForm'));
        

        if ( is_admin() ) {            
            add_action('wp_ajax_generatePaymentRef', array($this, 'generatePaymentRef'));
            add_action('wp_ajax_nopriv_generatePaymentRef', array($this, 'generatePaymentRef'));
            
            add_action('wp_ajax_verifyTransaction', array($this, 'verifyTransaction'));
            add_action('wp_ajax_nopriv_verifyTransaction', array($this, 'verifyTransaction'));
            
            add_action('wp_ajax_saveDonation', array($this, 'saveDonation'));
            add_action('wp_ajax_nopriv_saveDonation', array($this, 'saveDonation'));
        } else {
            // Add non-Ajax front-end action hooks here
        }
    }

    public function generatePaymentRef() {
        try {
            if (!DOING_AJAX || !check_ajax_referer('generatePaymentRef_nonce', 'nonce', false)) {
                return $this->return_json_error(500, 'Invalid request');
            }

            $now = new DateTime('now');
            $ref = 'near' . $now->format('Y') . uniqid() . $now->format('m') . $now->format('d') .
                   $now->format('H') . $now->format('i') . $now->format('s') .
                   strval(microtime(true) * 10000);
                
            return $this->return_json(200, array( "ref" => $ref));
        } catch(Exception $e) {
            return return_json_error(404, 'Unable to process payment');
        }

    }

    public function verifyTransaction() {
        try {
            if (!DOING_AJAX || !check_ajax_referer('verifyTransaction_nonce', 'nonce', false)) {
                return $this->return_json_error(500, 'Invalid request');
            }

            $paymentReference = isset($_GET["reference"]) ? $_GET["reference"] : "";

            $curl = curl_init();
  
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.paystack.co/transaction/verify/". $paymentReference,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . NEAR_FOUNDATION_SECRET_KEY,
                "Cache-Control: no-cache",
              ),
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            
            if ($err) {
              echo "cURL Error #:" . $err;
              throw new Exception('CURL error');
            }
            
            $responseAsArray = json_decode($response, true);

            return $this->return_json(200, $responseAsArray);
        } catch(Exception $e) {
            return return_json_error(404, 'Unable to process donation');
        }

    }

    public function saveDonation() {
        try {
            if (!DOING_AJAX || !check_ajax_referer('saveDonationNonce_nonce', 'nonce', false)) {
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
            $saveResult = $this->saveDonationEntity($entity);

            if (!$saveResult->isSuccessful())
                return $this->return_json_error(400, $saveResult->getMessage(), $saveResult->toArray());

            $donationId = $saveResult->getSuccessResult()->getId();

            return $this->return_json(200, $saveResult->getResult()->toArray()); 
        } catch(Exception $e) {
            return $this->return_json_error(400, 'Unable to save donation form');
        }
    }

    private function createEntity($data): Donation {
        $config = array();

        $config["amount"] = $data->ddlAmount === 'other' ? intval($data->txtOtherAmount) : $data->ddlAmount;
        $config["emailAddress"] = $data->txtEmail;
        $config["reason"] = $data->ddlReason;
        $config["narration"] = $data->txtDonationNarration;
        
        return new Donation($config);
    }

    private function validateEntity($entity): Result {
        $result = $this->validator->validate($entity);
        
        if (count($result) > 0)
            return Result::fromErrorWithResult(AppError::ERROR_VALIDATION, $result, "Invalid donation information");

        return Result::fromSuccess();
    }

    private function saveDonationEntity($entity): Result {
        $donation = $this->repo->insert($entity);        
        
        if ($donation == null)
            return Result::fromError(AppError::ERROR_GENERAL, "Unable to save donation information");

        return Result::fromSuccess($donation);
    }
}
