<?php

class DonationFormCallbacks extends BaseController
{

    protected $controller;

    public function __construct($controller)
    {
        parent::__construct();

        $this->controller = $controller;
    }

    public function renderDonationForm() {
        if(!is_page(array(NEAR_FOUNDATION_DONATION_FORM_SLUG))) return;

        // enqueue scripts here

        $controller = $this->controller;

        ob_start();
        require_once($this->modules_path . "DonationForm/Views/DonationFormView.php");
        return ob_get_clean();
    }

}
