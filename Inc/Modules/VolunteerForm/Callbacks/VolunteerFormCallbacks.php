<?php

class VolunteerFormCallbacks extends BaseController
{

    protected $controller;

    public function __construct($controller)
    {
        parent::__construct();

        $this->controller = $controller;
    }

    public function renderVolunteerForm() {
        if(!is_page(array(NEAR_FOUNDATION_VOLUNTEER_FORM_SLUG))) return;

        // enqueue scripts here

        $controller = $this->controller;

        ob_start();
        require_once($this->modules_path . "VolunteerForm/Views/VolunteerFormView.php");
        return ob_get_clean();
    }

}
