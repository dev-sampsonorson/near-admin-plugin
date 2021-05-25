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
        ob_start();
        echo "<link rel='stylesheet' href='{$this->plugin_url}dist/css/tailwind.min.css' type='text/css' media='all' />";
        require_once($this->modules_path . "ManagementCenter/Views/ShortcodeView.php");
        ob_end_flush();
        // ob_end_clean();
        // return require_once($this->modules_path . "ManagementCenter/Views/ShortcodeView.php");
    }

    public function volunteersView() {
        $controller = $this->controller;

        ob_start();
        echo "<link rel='stylesheet' href='{$this->plugin_url}/dist/css/tailwind.min.css' type='text/css' media='all' />";
        require_once($this->modules_path . "ManagementCenter/Views/VolunteersView.php");
        ob_end_flush();
        // ob_end_clean();
        // return require_once($this->modules_path . "ManagementCenter/Views/VolunteersView.php");
    }

    public function scholarshipAppsView() {
        $controller = $this->controller;

        ob_start();
        echo "<link rel='stylesheet' href='{$this->plugin_url}/dist/css/tailwind.min.css' type='text/css' media='all' />";
        require_once($this->modules_path . "ManagementCenter/Views/ScholarshipAppsView.php");
        ob_end_flush();
        // ob_end_clean();        
        // return require_once($this->modules_path . "ManagementCenter/Views/ScholarshipAppsView.php");
    }

    public function donationsView() {
        $controller = $this->controller;

        ob_start();
        echo "<link rel='stylesheet' href='{$this->plugin_url}/dist/css/tailwind.min.css' type='text/css' media='all' />";
        require_once($this->modules_path . "ManagementCenter/Views/DonationsView.php");
        ob_end_flush();
        // ob_end_clean();        
        // return require_once($this->modules_path . "ManagementCenter/Views/DonationsView.php");
    }
}
