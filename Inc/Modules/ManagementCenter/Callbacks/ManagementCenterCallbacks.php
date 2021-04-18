<?php

/**
 * @package Near Foundation Admin Plugin
 */

class ManagementCenterCallbacks extends BaseController {

    protected $controller;

    public function __construct($controller)
    {
        parent::__construct();

        $this->controller = $controller;
    }
    
    public function shortcodeView() {
        return require_once($this->modules_path . "ManagementCenter/Views/ShortcodeView.php");
    }

    public function volunteersView() {
        $controller = $this->controller;

        return require_once($this->modules_path . "ManagementCenter/Views/VolunteersView.php");
    }

    public function scholarshipAppsView() {
        $controller = $this->controller;
        
        return require_once($this->modules_path . "ManagementCenter/Views/ScholarshipAppsView.php");
    }

    public function donationsView() {
        $controller = $this->controller;
        
        return require_once($this->modules_path . "ManagementCenter/Views/DonationsView.php");
    }
}
