<?php

class ScholarshipFormCallbacks extends BaseController
{

    protected $controller;

    public function __construct($controller)
    {
        parent::__construct();

        $this->controller = $controller;
    }

    public function renderScholarshipForm() {
        if(!is_page(array(NEAR_FOUNDATION_SCHOLARSHIP_FORM_SLUG))) return;

        // enqueue scripts here

        $controller = $this->controller;

        ob_start();
        require_once($this->modules_path . "ScholarshipForm/Views/ScholarshipFormView.php");
        return ob_get_clean();
    }

}
