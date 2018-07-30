<?php

App::uses('CakeSession', 'Model/Datasource');
App::uses('ClassRegistry', 'Utility');

class StnAdmin {

    public $cakeSession;
    public $credential;
    public $branchOffice;

    function __construct() {
        $this->cakeSession = new CakeSession();
        $this->credential = $this->cakeSession->read("credential");
        $this->branchOffice = ClassRegistry::init("BranchOffice");
    }

    public function isAdminKoperasi() {
        return $this->cakeSession->read("credential.admin.User.UserGroup.name") == "adm_koperasi" ? true : false;
    }

    public function isDireksi() {
        return $this->cakeSession->read("credential.admin.Employee.Office.uniq") == "direksi" ? true : false;
    }

    public function isAdmin() {
        return $this->cakeSession->read("credential.admin.User.user_group_id") == 1 ? true : false;
    }

    public function getEmployeeId() {
        return $this->cakeSession->read("credential.admin.Employee.id");
    }
    
    public function getEmployeeFullname() {
        return $this->cakeSession->read("credential.admin.Biodata.full_name");
    }

    public function getOfficeId() {
        return $this->cakeSession->read("credential.admin.Employee.office_id");
    }

    public function getDepartmentId() {
        return $this->cakeSession->read("credential.admin.Employee.department_id");
    }

    public function getBranchId() {
        return $this->cakeSession->read("credential.admin.Employee.branch_office_id");
    }

    public function getBranchName() {
        return $this->cakeSession->read("credential.admin.Employee.BranchOffice.name");
    }

    public function roleBranchId() {
        if ($this->isAdmin() || $this->isDireksi()) {
            return $this->branchOffice->find("list", [
                        "fields" => [
                            "BranchOffice.id",
                        ],
            ]);
        } else {
            return $this->getBranchId();
        }
    }

    public function branchPrivilege() {
        return $this->isAdmin() || $this->isDireksi();
    }

    public function cooperativeBranchPrivilege() {
        return $this->isAdminKoperasi() || $this->isAdmin();
    }

    public function getPacker() {
        $branchOffice = $this->branchOffice->find("first", [
            "conditions" => [
                "BranchOffice.id" => $this->getBranchId(),
            ],
        ]);
        return $branchOffice["BranchOffice"]["packer_code"];
    }

    function is($user_group_needles = array()) {
        $user_groups = ClassRegistry::init("UserGroup")->find("all", array(
            "conditions" => array(
                "OR" => array(
                    "UserGroup.id" => $user_group_needles,
                    "UserGroup.name" => $user_group_needles,
                ),
            ),
            "fields" => array(
                "UserGroup.id",
                "UserGroup.name",
            ),
            "recursive" => -1
        ));
        $user_group_ids = array();
        $user_group_names = array();
        foreach ($user_groups as $user_group) {
            $user_group_ids[] = $user_group["UserGroup"]["id"];
            $user_group_names[] = $user_group["UserGroup"]["name"];
        }
        return in_array($this->credential["admin"]['User']['user_group_id'], $user_group_ids);
    }

}

/**
 * @var \StnAdmin;
 */
$stnAdmin = new StnAdmin();
