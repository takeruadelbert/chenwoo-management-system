<?php

App::uses('AppController', 'Controller');

class EmployeesController extends AppController {

    var $name = "Employees";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "employees");
        $this->contain = [
            "Biodata" => [
                "Religion",
                "Gender",
            ],
            "User",
            "Employee" => [
                "Office",
                "EmployeeSignature",
                "EmployeeType",
                "BranchOffice",
                "Department"
            ],
        ];
        $conds = $this->_filter($_GET, $this->filterCond);
        if (empty($conds)) {
            $conds = $this->defaultConds;
        }
//        debug(ClassRegistry::init('Employee')->excludedEmployee());
//        debug($this->stnAdmin->branchPrivilege());
        $conds['AND'] = am($conds, array(
            'NOT' => [
                'Account.id' => ClassRegistry::init('Employee')->excludedEmployee(),
            ]
                ), $this->conds);
        if ($this->order === false) {
            $this->order = 'Account.created desc';
        }
        $this->Paginator->settings = array(
            "Account" => array(
                'conditions' => $conds,
                'limit' => $this->paginate['limit'],
                'maxLimit' => $this->paginate['maxLimit'],
                'order' => $this->order,
                'recursive' => -1,
                'contain' => $this->contain,
            )
        );
        $rows = $this->Paginator->paginate("Account");
        $data = array(
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            $password = $this->{ Inflector::classify($this->name) }->data['Account']["User"]["password"];
            $salt = hash("sha224", uniqid(mt_rand(), true), false);
            $encrypt = hash("sha512", $password . $salt, false);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->Employee->_numberSeperatorRemover();
                $this->{ Inflector::classify($this->name) }->data['Account']["User"]["password"] = $encrypt;
                $this->{ Inflector::classify($this->name) }->data['Account']["User"]["salt"] = $salt;
                unset($this->{ Inflector::classify($this->name) }->data['Account']["User"]["repeat_password"]);
                App::import("Vendor", "qqUploader");
                $allowedExt = array("jpg", "jpeg", "png");
                $size = 10 * 1024 * 1024;
                $uploader = new qqFileUploader($allowedExt, $size, $this->Employee->data['EmployeeSignature']['file'], true);
                $result = $uploader->handleUpload("ttd" . DS);
                switch ($result['status']) {
                    case 206:
                        $this->Employee->data['EmployeeSignature']['AssetFile'] = array(
                            "folder" => $result['data']['folder'],
                            "filename" => $result['data']['fileName'],
                            "ext" => $result['data']['ext'],
                            "is_private" => true,
                        );
                        break;
                    case 442:
                    case 443:
                        $this->Session->setFlash(__($result['message']), 'default', array(), 'danger');
                        return;
                        break;
                }
                unset($this->Employee->data['EmployeeSignature']['file']);
                $this->Employee->data['EmployeeSignature']['employee_id'] = $this->_getEmployeeId();

                $uploader = new qqFileUploader($allowedExt, $size, $this->data['Foto']["file"], false);
                $results = $uploader->handleUpload("img" . DS . "employee" . DS);
                switch ($results['status']) {
                    case 206 :
                        $this->Employee->data['Account']['User']['profile_picture'] = "/" . $results['data']['folder'] . $results['data']['fileName'];
                        break;
                    case 442:
                    case 443:
                        $this->Session->setFlash(__($result['message']), 'default', array(), 'danger');
                        return;
                }
                switch ($this->Employee->data["Employee"]["employee_type_id"]) {
                    case 1:
                        $userGroupId = ClassRegistry::init("UserGroup")->translateToId("staff_harian");
                        $this->Employee->data["Account"]["User"]["user_group_id"] = $userGroupId;
                        break;
                    case 2:
                        $userGroupId = ClassRegistry::init("UserGroup")->translateToId("staff_bulanan");
                        $this->Employee->data["Account"]["User"]["user_group_id"] = $userGroupId;
                        break;
                }
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_edit($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    if (!is_null($id)) {
                        $this->Employee->_numberSeperatorRemover();
                        if (isset($this->data['EmployeeSignature']['file']) && !empty($this->data['EmployeeSignature']['file']) && isset($this->data['Foto']['file']) && !empty($this->data['Foto']['file'])) {
                            App::import("Vendor", "qqUploader");
                            $allowedExt = array("jpg", "jpeg", "png");
                            $size = 10 * 1024 * 1024;
                            $uploader = new qqFileUploader($allowedExt, $size, $this->Employee->data['EmployeeSignature']['file'], true);
                            $result = $uploader->handleUpload("ttd" . DS);
                            switch ($result['status']) {
                                case 206:
                                    $this->Employee->data['EmployeeSignature']['AssetFile'] = array(
                                        "folder" => $result['data']['folder'],
                                        "filename" => $result['data']['fileName'],
                                        "ext" => $result['data']['ext'],
                                        "is_private" => true,
                                    );
                                    break;
                                case 443:
                                    $this->Session->setFlash(__($result['message']), 'default', array(), 'danger');
                                    $this->redirect(array("controller" => "taskings", 'action' => 'admin_view', $this->data['Comment']['tasking_id']));
                                    break;
                            }
                            unset($this->Employee->data['EmployeeSignature']['file']);

                            $uploader = new qqFileUploader($allowedExt, $size, $this->data['Foto']["file"], false);
                            $results = $uploader->handleUpload("img" . DS . "employee" . DS);
                            switch ($results['status']) {
                                case 206 :
                                    $this->Employee->data['Account']['User']['profile_picture'] = "/" . $results['data']['folder'] . $results['data']['fileName'];
                                    break;
                                case 441:
                                    unset($this->Employee->data['Account']['User']['profile_picture']);
                                    break;
                                default:
                                    $this->Session->setFlash(__($result['message']), 'default', array(), 'danger');
                                    $this->redirect(array('action' => 'admin_edit'));
                                    break;
                            }
                        }
                        $this->{ Inflector::classify($this->name) }->id = $id;
                        $this->Employee->data['Employee']['id'] = $id;
                        $this->Employee->data['Account']['Biodata']['id'] = $this->data['Account']['Biodata']['id'];
                        $this->Employee->data['Account']['User']['id'] = $this->data['Account']['User']['id'];
                        $this->Employee->_deleteableHasmany();
                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                        $this->redirect(array('action' => 'admin_index'));
                    } else {
                        
                    }
                } else {
                    $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                }
            } else {
                $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                    'conditions' => array(
                        Inflector::classify($this->name) . ".id" => $id
                    ),
                    'recursive' => 2
                ));
                $this->data = $rows;
            }
        }
    }

    function admin_view($id = null) {
        if (!$this->Employee->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->Employee->data['Employee']['id'] = $id;
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                'conditions' => array(
                    Inflector::classify($this->name) . ".id" => $id
                ),
                "contain" => [
                    "EducationHistory",
                    "PositionHistory",
                    "Family" => [
                        "Gender",
                        "Education",
                        "Religion",
                        "MaritalStatus",
                        "LifeStatus",
                        "FamilyRelation"
                    ],
                    "Training",
                    "Honor"
                ],
                "recursive" => 2));
            $this->data = $rows;
        }
    }

    function admin_profil() {
        $id = $this->_getEmployeeId();
        if (!$this->Employee->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->Employee->data['Employee']['id'] = $id;
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 4));
            $this->data = $rows;
            $this->_activePrint(func_get_args(), "print_profile", "print_profile");
        }
    }

    function admin_profil_edit($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    if (!is_null($id)) {
                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                        $this->redirect(array('action' => 'admin_profil'));
                    } else {
                        
                    }
                } else {
                    $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                }
            } else {
                $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                    'conditions' => array(
                        Inflector::classify($this->name) . ".id" => $id
                    ),
                    'recursive' => 4
                ));
                $this->data = $rows;
            }
        }
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("religions", $this->Employee->Account->Biodata->Religion->find("list", array("fields" => array("Religion.id", "Religion.name"))));
        $this->set("genders", $this->Employee->Account->Biodata->Gender->find("list", array("fields" => array("Gender.id", "Gender.name"))));
        $this->set("states", ClassRegistry::init("State")->find("list", array("fields" => array("State.id", "State.name"), "conditions" => ["State.country_id" => 102])));
        $this->set("cities", []);
        $this->set("bloodTypes", ClassRegistry::init("BloodType")->find("list", array("fields" => array("BloodType.id", "BloodType.name"))));
        $this->set("userGroups", ClassRegistry::init("UserGroup")->find("list", array("fields" => array("UserGroup.id", "UserGroup.label"))));
        $this->set("departments", ClassRegistry::init("Department")->find("list", array("fields" => array("Department.id", "Department.name"), "order" => "Department.name")));
        $this->set("maritalStatuses", ClassRegistry::init("MaritalStatus")->find("list", array("fields" => array("MaritalStatus.id", "MaritalStatus.name"))));
        $this->set("tingkatPendidikanAwals", ClassRegistry::init("Education")->find("list", array("fields" => array("Education.id", "Education.name"))));
        $this->set("tingkatPendidikanAkhirs", ClassRegistry::init("Education")->find("list", array("fields" => array("Education.id", "Education.name"))));
        $this->set("offices", ClassRegistry::init("Office")->find("list", array("fields" => array("Office.id", "Office.name"), "order" => "Office.uniq")));
        $this->set("workingHourTypes", ClassRegistry::init("WorkingHourType")->find("list", array("fields" => array("WorkingHourType.id", "WorkingHourType.name"))));
        $this->set("educations", ClassRegistry::init("Education")->find("list", array("fields" => array("Education.id", "Education.name"))));
        $this->set("lifeStatuses", ClassRegistry::init("LifeStatus")->find("list", array("fields" => array("LifeStatus.id", "LifeStatus.name"))));
        $this->set("familyRelations", ClassRegistry::init("FamilyRelation")->find("list", array("fields" => array("FamilyRelation.id", "FamilyRelation.name"))));
        $this->set("employeeTypes", ClassRegistry::init("EmployeeType")->find("list", array("fields" => array("EmployeeType.id", "EmployeeType.name"))));
        $this->set("branchOffices", $this->Employee->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Biodata.first_name like" => "%$q%",
                    "Biodata.last_name like" => "%$q%",
                    "Employee.nip like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("Account")->find("all", array(
            "conditions" => [
                $conds,
                "NOT" => [
                    "Account.id" => ClassRegistry::init("Employee")->excludedEmployee(),
                ],
            ],
            "contain" => array(
                "Employee" => array(
                    "Office",
                    "Department",
                    "BranchOffice",
                ),
                "Biodata",
            ),
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item['Employee'])) {
                $result[] = [
                    "id" => $item['Employee']['id'],
                    "full_name" => $item['Biodata']['full_name'],
                    "nip" => @$item['Employee']['nip'],
                    "jabatan" => @$item['Employee']['Office']['name'],
                    "jabatan_id" => @$item['Employee']['Office']['id'],
                    "department" => @$item['Employee']['Department']['name'],
                    "department_uniq_name" => @$item['Employee']['Department']['uniq_name'],
                    "branch_office" => @$item['Employee']['BranchOffice']['name'],
                ];
            }
        }
        echo json_encode($result);
    }

    function admin_list_cooperative() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Biodata.first_name like" => "%$q%",
                    "Biodata.last_name like" => "%$q%",
                    "Employee.nip like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("Account")->find("all", array(
            "conditions" => [
                $conds,
                "NOT" => [
                    "Account.id" => ClassRegistry::init("Employee")->excludedEmployeeNoBoundaries(),
                ],
            ],
            "contain" => array(
                "Employee" => array(
                    "Office",
                    "Department",
                    "BranchOffice",
                ),
                "Biodata",
            ),
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item['Employee'])) {
                $result[] = [
                    "id" => $item['Employee']['id'],
                    "full_name" => $item['Biodata']['full_name'],
                    "nip" => @$item['Employee']['nip'],
                    "jabatan" => @$item['Employee']['Office']['name'],
                    "jabatan_id" => @$item['Employee']['Office']['id'],
                    "department" => @$item['Employee']['Department']['name'],
                    "department_uniq_name" => @$item['Employee']['Department']['uniq_name'],
                    "branch_office" => @$item['Employee']['BranchOffice']['name'],
                ];
            }
        }
        echo json_encode($result);
    }

    function admin_list_office() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Biodata.first_name like" => "%$q%",
                    "Biodata.last_name like" => "%$q%",
                    "Employee.nip like" => "%$q%",
            ));
        }
        $supervisor = ClassRegistry::init("Office")->find("first", array(
            "conditions" => [
                "Office.id" => $this->_getOfficeId(),
            ]
        ));
        $suggestions = ClassRegistry::init("Account")->find("all", array(
            "conditions" => [
                $conds,
                "NOT" => [
                    "Account.id" => ClassRegistry::init("Employee")->excludedEmployee(),
                ],
            ],
            "contain" => array(
                "Employee" => array(
                    "Office",
                    "Department",
                ),
                "Biodata",
                "User",
                "BranchOffice",
            ),
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item['Employee']) && $item['Employee']['Office']['id'] == $supervisor['Office']['supervisor_id']) {
                $result[] = [
                    "id" => $item['Employee']['id'],
                    "full_name" => $item['Biodata']['full_name'],
                    "nip" => @$item['Employee']['nip'],
                    "jabatan" => @$item['Employee']['Office']['name'],
                    "jabatan_id" => @$item['Employee']['Office']['id'],
                    "department" => @$item['Employee']['Department']['name'],
                    "department_uniq_name" => @$item['Employee']['Department']['uniq_name'],
                    "branch_office" => @$item['Employee']['BranchOffice']['name'],
                ];
            }
        }
        echo json_encode($result);
    }

    function admin_list_bulanan($type) {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Biodata.first_name like" => "%$q%",
                    "Biodata.last_name like" => "%$q%",
                    "Employee.nip like" => "%$q%",
                ),
            );
        }
        $suggestions = ClassRegistry::init("Account")->find("all", array(
            "conditions" => [
                $conds,
                "Employee.employee_type_id" => $type,
                "NOT" => [
                    "Account.id" => ClassRegistry::init("Employee")->excludedEmployee(),
                ],
            ],
            "contain" => array(
                "Employee" => array(
                    "Office",
                    "Department",
                    "EmployeeType",
                    "BranchOffice",
                ),
                "Biodata",
                "User",
            ),
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => $item['Employee']['id'],
                    "full_name" => $item['Biodata']['full_name'],
                    "nip" => @$item['Employee']['nip'],
                    "jabatan" => @$item['Employee']['Office']['name'],
                    "jabatan_id" => @$item['Employee']['Office']['id'],
                    "department" => @$item['Employee']['Department']['name'],
                    "department_uniq_name" => @$item['Employee']['Department']['uniq_name'],
                    "branch_office" => @$item['Employee']['BranchOffice']['name'],
                ];
            }
        }
        echo json_encode($result);
    }

    function admin_listprio() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Biodata.first_name like" => "%$q%",
                    "Biodata.last_name like" => "%$q%",
                    "Employee.nip like" => "%$q%",
            ));
        }

        $suggestions = ClassRegistry::init("Biodata")->find("all", array(
            "conditions" => $conds,
            "contain" => array(
                "Account" => array(
                    "Employee" => array(
                        "Office",
                        "Department",
                        "BranchOffice"
                    ),
                ),
            ),
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item['Account']['Employee'])) {
                if (in_array($item["Account"]["User"]["user_group_id"], $this->_excludedUserGroup())) {
                    continue;
                }
                if (!in_array($item['Account']['Employee']['Office']['uniq'], ["kabid", "kasi", "kadis"])) {
                    continue;
                }
                $result[] = [
                    "id" => $item['Account']['Employee']['id'],
                    "full_name" => $item['Biodata']['full_name'],
                    "nip" => @$item['Account']['Employee']['nip_baru'],
                    "eselon" => @$item['Account']['Employee']['EmployeeClass']['name'],
                    "jabatan" => @$item['Account']['Employee']['Office']['name'],
                    "department" => @$item['Account']['Employee']['Department']['name'],
                    "department_uniq_name" => @$item['Account']['Employee']['Department']['uniq_name'],
                    "branch_office" => @$item['Employee']['BranchOffice']['name'],
                ];
            }
        }
        echo json_encode($result);
    }

    function change_status_work($employeeId, $status_work) {
        $this->autoRender = false;
        $this->Employee->id = $employeeId;
        $this->Employee->save(array("Employee" => array("employee_work_status_id" => $status_work)));
        $data = $this->Employee->find("first", array("conditions" => array("Employee.id" => $employeeId), "contain" => ["EmployeeWorkStatus"]));
        echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['EmployeeWorkStatus']['name'])));
    }

    function admin_change_employee_status_work() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->Employee->id = $this->request->data['id'];
            $this->Employee->save(array("Employee" => array("employee_work_status_id" => $this->request->data['status'])));
            $data = $this->Employee->find("first", array("conditions" => array("Employee.id" => $this->request->data['id']), "contain" => ["EmployeeWorkStatus"]));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['EmployeeWorkStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_change_status_work() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->Employee->id = $this->request->data['id'];
            $this->Employee->save(array("Employee" => array("employee_work_status_id" => $this->request->data['status'])));
            $data = $this->Employee->find("first", array("conditions" => array("Employee.id" => $this->request->data['id']), "contain" => ["EmployeeWorkStatus"]));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['EmployeeWorkStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_print_profile($id = null) {
        if (empty($id)) {
            $conds = [];
        } else {
            $conds = [
                "Employee.id" => $id,
            ];
        }
        $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
            'conditions' => array(
                "Employee.employee_work_status_id" => 1,
                "NOT" => [
                    "Account.id" => $this->Employee->excludedEmployee(),
                ],
                $conds,
            ),
            'contain' => [
                "Account" => [
                    "Biodata" => [
                        "City",
                        "State",
                        "Religion",
                        "Gender",
                        "MaritalStatus"
                    ],
                    "User"
                ],
                "EmployeeSignature" => [
                    "AssetFile"
                ],
                "Department",
                "Office",
                "EmployeeType",
                "EmployeeWorkStatus",
                "BranchOffice",
                "Training",
                "EducationHistory",
                "Honor",
                "PositionHistory",
                "Family" => [
                    "Gender",
                    "Education",
                    "Religion",
                    "MaritalStatus",
                    "LifeStatus",
                    "FamilyRelation"
                ],
            ],
        ));
        $this->data = $rows;

        $data = array(
            'title' => 'BIODATA KARYAWAN',
            'rows' => $rows,
        );
        $this->set(compact('data'));
        $this->_activePrint(["print"], "print_profile", "print_profile");
    }

    function admin_print_employee_biodata($id = null) {
        if (empty($id)) {
            $conds = [];
        } else {
            $conds = [
                "Employee.id" => $id,
            ];
        }
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                "Employee.employee_work_status_id" => 1,
                "NOT" => [
                    "Account.id" => $this->Employee->excludedEmployee(),
                ],
                $conds,
            ),
            'contain' => [
                "Account" => [
                    "Biodata" => [
                        "City",
                        "State",
                        "Religion",
                        "Gender",
                        "MaritalStatus"
                    ],
                    "User"
                ],
                "EmployeeSignature" => [
                    "AssetFile"
                ],
                "Department",
                "Office",
                "EmployeeType",
                "EmployeeWorkStatus",
                "BranchOffice",
                "Training",
                "EducationHistory",
                "Honor",
                "PositionHistory",
                "Family" => [
                    "Gender",
                    "Education",
                    "Religion",
                    "MaritalStatus",
                    "LifeStatus",
                    "FamilyRelation"
                ],
            ],
        ));
        $this->data = $rows;

        $data = array(
            'title' => 'BIODATA KARYAWAN',
            'rows' => $rows,
        );
        $this->set(compact('data'));
        $this->_activePrint(["print"], "print_employee_biodata", "print_employee_biodata");
    }

    function admin_statistic() {
        if (!empty($this->request->query["branch_office_id"])) {
            $branchOfficeId = $this->request->query["branch_office_id"];
            $employeeConds = [
                "Employee.branch_office_id" => $branchOfficeId,
            ];
            $pensionConds = [
                "Employee.branch_office_id" => $branchOfficeId,
            ];
            $resignationConds = [
                "Employee.branch_office_id" => $branchOfficeId,
            ];
            $transferEmployeeConds = [
                "TransferEmployee.origin_branch_office_id" => $branchOfficeId,
            ];
            $branchOffice = ClassRegistry::init("BranchOffice")->find("first", [
                "conditions" => [
                    "BranchOffice.id" => $branchOfficeId
                ],
                "recursive" => -1,
            ]);
            $namaCabang = $branchOffice["BranchOffice"]["name"];
        } else {
            $employeeConds = [];
            $pensionConds = [];
            $resignationConds = [];
            $transferEmployeeConds = [];
            $namaCabang = "Seluruh Cabang";
        }
        $employees = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                "NOT" => [
                    "Employee.id" => $this->Employee->excludedEmployee(),
                ],
                $employeeConds
            ),
            'contain' => [
                "Account" => [
                    "Biodata",
                    "User"
                ],
                "Department",
                "Office",
                "Training"
            ],
        ));
        $employeeTypes = $this->Employee->EmployeeType->find("all", [
            "recursive" => -1,
            "order" => "EmployeeType.id desc",
        ]);
        $genders = ClassRegistry::init("Gender")->find("all", [
            "recursive" => -1
        ]);
        $offices = ClassRegistry::init("Office")->find("all", [
            "contain" => [
                "Department",
            ]
        ]);
        $pensions = ClassRegistry::init("Pension")->find("all", [
            "conditions" => [
                "Year(Pension.tanggal_sk)" => date("Y"),
                "Month(Pension.tanggal_sk)" => date("m"),
                $resignationConds,
            ],
            "contain" => [
                "Employee" => [
                    "Account" => [
                        "Biodata",
                        "User"
                    ],
                    "Department",
                    "Office",
                ],
            ],
        ]);
        $resignations = ClassRegistry::init("Resignation")->find("all", [
            "conditions" => [
                "Year(Resignation.resignation_date)" => date("Y"),
                "Month(Resignation.resignation_date)" => date("m"),
                $resignationConds,
            ],
            "contain" => [
                "Employee" => [
                    "Account" => [
                        "Biodata",
                        "User"
                    ],
                    "Department",
                    "Office",
                ],
            ],
        ]);
        $transferEmployees = ClassRegistry::init("TransferEmployee")->find("all", [
            "conditions" => [
                "Year(TransferEmployee.tanggal_sk_mutasi)" => date("Y"),
                "Month(TransferEmployee.tanggal_sk_mutasi)" => date("m"),
                $transferEmployeeConds
            ],
            "contain" => [
                "Employee" => [
                    "Account" => [
                        "Biodata",
                        "User"
                    ],
                    "Department",
                    "Office",
                ],
                "OriginBranchOffice",
                "BranchOffice",
            ],
        ]);
        $data = [
            "employees" => $employees,
            "employeeTypes" => $employeeTypes,
            "genders" => $genders,
            "pensions" => $pensions,
            "resignations" => $resignations,
            "transferEmployees" => $transferEmployees,
        ];
        $this->set(compact('data', 'namaCabang'));
        $this->_activePrint(func_get_args(), "employee_statistic");
    }

    function admin_test() {
        $employees = $this->Employee->find("all", [
            "conditions" => [
                "NOT" => [
                    "Account.id" => ClassRegistry::init("Employee")->excludedEmployee(),
                ]
            ],
            "contain" => [
                "Account" => [
                    "Biodata",
                ],
                "Office",
            ]
        ]);
        $departments = $this->Employee->Department->find("list", [
            "fields" => [
                "Department.id",
                "Department.name",
            ]
        ]);
        $this->set(compact("employees", "departments"));
    }

    function admin_employee_production_process_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Biodata.first_name like" => "%$q%",
                    "Biodata.last_name like" => "%$q%",
                    "Employee.nip like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("Account")->find("all", array(
            "conditions" => [
                $conds,
                "NOT" => [
                    "Account.id" => ClassRegistry::init("Employee")->excludedEmployee(),
                ],
            ],
            "contain" => array(
                "Employee" => array(
                    "Office",
                    "Department",
                    "BranchOffice",
                ),
                "Biodata",
                "User" => [
                    "UserGroup"
                ]
            )
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item['Employee'])) {
                if ($item['Employee']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    if ($item['User']['UserGroup']['name'] == "staff_produksi" || $item['User']['UserGroup']['name'] == "processing_manager" || $item['User']['UserGroup']['name'] == "production_dept_head" || $item['User']['UserGroup']['name'] == "staff_processing") {
                        $result[] = [
                            "id" => $item['Employee']['id'],
                            "full_name" => $item['Biodata']['full_name'],
                            "nip" => @$item['Employee']['nip'],
                            "jabatan" => @$item['Employee']['Office']['name'],
                            "jabatan_id" => @$item['Employee']['Office']['id'],
                            "department" => @$item['Employee']['Department']['name'],
                            "department_uniq_name" => @$item['Employee']['Department']['uniq_name'],
                            "branch_office" => @$item['Employee']['BranchOffice']['name'],
                        ];
                    }
                }
            }
        }
        echo json_encode($result);
    }

    function admin_update_salary_harian($employeeId = null) {
        $employee = $this->Employee->find("first", [
            "conditions" => [
                "Employee.employee_type_id" => 1,
                "Employee.id" => $employeeId,
            ],
            "recursive" => -1,
        ]);
        if (empty($employee)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        }
        if ($this->request->is("POST")) {

            $newSalary = ic_number_reverse($this->data["EmployeeBasicSalary"]["new_salary"]);
            $newOtSalary = ic_number_reverse($this->data["EmployeeBasicSalary"]["new_ot_salary"]);
            if (empty($newSalary)) {
                $this->Session->setFlash(__("Gaji Pokok Baru harus diisi"), 'default', array(), 'danger');
            } else if (empty($newOtSalary)) {
                $this->Session->setFlash(__("Gaji Lembur Baru harus diisi"), 'default', array(), 'danger');
            } else {
                $previousSalary = $this->Employee->EmployeeBasicSalary->find("first", [
                    "conditions" => [
                        "EmployeeBasicSalary.employee_id" => $employeeId,
                    ],
                    "order" => "EmployeeBasicSalary.start_date desc",
                ]);
                if (empty($previousSalary)) {
                    $this->Employee->EmployeeBasicSalary->create();
                    $this->Employee->EmployeeBasicSalary->save([
                        "salary" => $newSalary,
                        "ot_salary" => $newOtSalary,
                        "start_date" => DboSource::expression('NOW()'),
                        "employee_id" => $employeeId,
                    ]);
                } else {
                    $this->Employee->EmployeeBasicSalary->create();
                    $this->Employee->EmployeeBasicSalary->id = $previousSalary["EmployeeBasicSalary"]["id"];
                    $this->Employee->EmployeeBasicSalary->save([
                        "end_date" => DboSource::expression('NOW()'),
                    ]);
                    $this->Employee->EmployeeBasicSalary->create();
                    $this->Employee->EmployeeBasicSalary->save([
                        "salary" => $newSalary,
                        "ot_salary" => $newOtSalary,
                        "start_date" => DboSource::expression('NOW()'),
                        "employee_id" => $employeeId,
                    ]);
                    $this->Session->setFlash(__("Gaji Pokok Baru berhasil ditambahkan"), 'default', array(), 'success');
                }
            }
        }
        $employee = $this->Employee->find("first", [
            "conditions" => [
                "Employee.id" => $employeeId,
            ],
            "contain" => [
                "EmployeeBasicSalary" => [
                    "order" => "EmployeeBasicSalary.start_date asc",
                ],
                "Account" => [
                    "Biodata",
                ],
                "EmployeeType",
            ],
        ]);
        $this->data = $employee;
        $this->set(compact("employee"));
    }

    function admin_update_salary_bulanan($employeeId = null) {
        $employee = $this->Employee->find("first", [
            "conditions" => [
                "Employee.employee_type_id" => 2,
                "Employee.id" => $employeeId,
            ],
            "recursive" => -1,
        ]);
        if (empty($employee)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        }
        if ($this->request->is("POST")) {
            $newSalary = ic_number_reverse($this->data["EmployeeBasicSalary"]["new_salary"]);
            $newOtSalary = ic_number_reverse($this->data["EmployeeBasicSalary"]["new_ot_salary"]);
            if (empty($newSalary)) {
                $this->Session->setFlash(__("Gaji Pokok Baru harus diisi"), 'default', array(), 'danger');
            } else if (empty($newOtSalary)) {
                $this->Session->setFlash(__("Gaji Lembur Baru harus diisi"), 'default', array(), 'danger');
            } else {
                $previousSalary = $this->Employee->EmployeeBasicSalary->find("first", [
                    "conditions" => [
                        "EmployeeBasicSalary.employee_id" => $employeeId,
                    ],
                    "order" => "EmployeeBasicSalary.start_date desc",
                ]);
                if (empty($previousSalary)) {
                    $this->Employee->EmployeeBasicSalary->create();
                    $this->Employee->EmployeeBasicSalary->save([
                        "salary" => $newSalary,
                        "ot_salary" => $newOtSalary,
                        "start_date" => DboSource::expression('NOW()'),
                        "employee_id" => $employeeId,
                    ]);
                } else {
                    $this->Employee->EmployeeBasicSalary->create();
                    $this->Employee->EmployeeBasicSalary->id = $previousSalary["EmployeeBasicSalary"]["id"];
                    $this->Employee->EmployeeBasicSalary->save([
                        "end_date" => DboSource::expression('NOW()'),
                    ]);
                    $this->Employee->EmployeeBasicSalary->create();
                    $this->Employee->EmployeeBasicSalary->save([
                        "salary" => $newSalary,
                        "ot_salary" => $newOtSalary,
                        "start_date" => DboSource::expression('NOW()'),
                        "employee_id" => $employeeId,
                    ]);
                    $this->Session->setFlash(__("Gaji Pokok Baru berhasil ditambahkan"), 'default', array(), 'success');
                }
            }
        }
        $employee = $this->Employee->find("first", [
            "conditions" => [
                "Employee.id" => $employeeId,
            ],
            "contain" => [
                "EmployeeBasicSalary" => [
                    "order" => "EmployeeBasicSalary.start_date asc",
                ],
                "Account" => [
                    "Biodata",
                ],
                "EmployeeType",
                "Office",
                "Department",
            ],
        ]);
        $this->data = $employee;
        $this->set(compact("employee"));
    }

    function admin_salary_detail_harian() {
        $this->autoRender = false;
        $employeeId = $this->request->query["employee_id"];
        $startDate = $this->request->query["start_date"];
        $endDate = $this->request->query["end_date"];
        $dataAttendance = ClassRegistry::init("Attendance")->buildReport($startDate, $endDate, $employeeId);
        $basicSalary = ClassRegistry::init("EmployeeBasicSalary")->find("first", [
            "conditions" => [
                "EmployeeBasicSalary.employee_id" => $employeeId,
                "EmployeeBasicSalary.end_date" => null,
            ],
            "recursive" => -1,
        ]);
        $mapParameterSalary = ClassRegistry::init("ParameterSalary")->find("list", ["fields" => ["ParameterSalary.code", "ParameterSalary.id"]]);
        $entityConfiguration = ClassRegistry::init("EntityConfiguration")->find("first");
        $lateFine = $entityConfiguration["EntityConfiguration"]["late_charge"];
        $salary = $basicSalary["EmployeeBasicSalary"]["salary"];
        $otSalary = $basicSalary["EmployeeBasicSalary"]["ot_salary"];
        $result = [];
        $result["attendance"]["summary"] = $dataAttendance[$employeeId]["summary"];
        $result["attendance"]["data"] = $dataAttendance[$employeeId]["data"];
        $attendanceSummary = $dataAttendance[$employeeId]["summary"];
        $result["salary"] = [
            "pendapatan" => [
                "id" => 1,
                "data" => [],
            ],
            "potongan" => [
                "id" => 2,
                "data" => [],
            ],
        ];
        $result["salary"]["pendapatan"]["data"][$mapParameterSalary["GPK"]] = $attendanceSummary["jumlah_hadir"] * $salary;
        $result["salary"]["pendapatan"]["data"][$mapParameterSalary["LPH"]] = $attendanceSummary["jumlah_hadir_libur"] * $salary * 2;
        $result["salary"]["pendapatan"]["data"][$mapParameterSalary["LPJ"]] = floor($attendanceSummary["jumlah_jam_lembur"] / 3600 * $otSalary);
//        $result["salary"]["potongan"]["data"][$mapParameterSalary["DKT"]] = floor($attendanceSummary["jumlah_telat"] / 60 * $lateFine);
        echo json_encode($this->_generateStatusCode(206, null, $result));
    }

    function admin_basic_salary_harian() {
        $this->contain = [
            "Biodata" => [
                "Religion",
                "Gender",
            ],
            "User",
            "Employee" => [
                "Office",
                "EmployeeSignature",
                "EmployeeType",
                "BranchOffice",
                "Department",
                "EmployeeBasicSalary" => [
                    "conditions" => [
                        "EmployeeBasicSalary.end_date" => null,
                    ]
                ],
            ],
        ];
        $this->conds = [
            "Employee.employee_type_id" => 1,
        ];
        $conds = $this->_filter($_GET, $this->filterCond);
        if (empty($conds)) {
            $conds = $this->defaultConds;
        }
        $conds['AND'] = am($conds, array(
            'NOT' => [
                'Account.id' => ClassRegistry::init('Employee')->excludedEmployee(),
            ]
                ), $this->conds);
        if ($this->order === false) {
            $this->order = 'Account.created desc';
        }
        $this->Paginator->settings = array(
            "Account" => array(
                'conditions' => $conds,
                'limit' => $this->paginate['limit'],
                'maxLimit' => $this->paginate['maxLimit'],
                'order' => $this->order,
                'recursive' => -1,
                'contain' => $this->contain,
            )
        );
        $rows = $this->Paginator->paginate("Account");
        $data = array(
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_basic_salary_bulanan() {
        $this->contain = [
            "Biodata" => [
                "Religion",
                "Gender",
            ],
            "User",
            "Employee" => [
                "Office",
                "EmployeeSignature",
                "EmployeeType",
                "BranchOffice",
                "Department",
                "EmployeeBasicSalary" => [
                    "conditions" => [
                        "EmployeeBasicSalary.end_date" => null,
                    ]
                ],
            ],
        ];
        $this->conds = [
            "Employee.employee_type_id" => 2,
        ];
        $conds = $this->_filter($_GET, $this->filterCond);
        if (empty($conds)) {
            $conds = $this->defaultConds;
        }
        $conds['AND'] = am($conds, array(
            'NOT' => [
                'Account.id' => ClassRegistry::init('Employee')->excludedEmployee(),
            ]
                ), $this->conds);
        if ($this->order === false) {
            $this->order = 'Account.created desc';
        }
        $this->Paginator->settings = array(
            "Account" => array(
                'conditions' => $conds,
                'limit' => $this->paginate['limit'],
                'maxLimit' => $this->paginate['maxLimit'],
                'order' => $this->order,
                'recursive' => -1,
                'contain' => $this->contain,
            )
        );
        $rows = $this->Paginator->paginate("Account");
        $data = array(
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_get_salary_detail() {
        $this->autoRender = false;
        $mapParameterSalary = ClassRegistry::init("ParameterSalary")->find("list", ["fields" => ["ParameterSalary.code", "ParameterSalary.id"]]);
        $employeeId = $this->request->query["employee_id"];
        $startDt = $this->request->query["start_date"];
        $endDt = $this->request->query["end_date"];
        $employee = $this->Employee->find("first", [
            "conditions" => [
                "Employee.id" => $employeeId,
            ],
            "recursive" => -1,
        ]);
        $employeeTypeId = $employee["Employee"]["employee_type_id"];
        $loanFactor = $employeeTypeId == 1 ? 4 : 1;

        $dataAttendance = ClassRegistry::init("Attendance")->buildReport($startDt, $endDt, $employeeId);
        $entityConfiguration = ClassRegistry::init("EntityConfiguration")->find("first");
        $lateFine = $entityConfiguration["EntityConfiguration"]["late_charge"];
        $result = [];
        $result["attendance"]["summary"] = $dataAttendance[$employeeId]["summary"];
//        $result["attendance"]["data"] = $dataAttendance[$employeeId]["data"];
        $attendanceSummary = $dataAttendance[$employeeId]["summary"];
        $result["salary"] = [
            "pendapatan" => [
                "id" => 1,
                "data" => [],
            ],
            "potongan" => [
                "id" => 2,
                "data" => [],
            ],
        ];
        $basicSalary = ClassRegistry::init("EmployeeBasicSalary")->find("first", [
            "conditions" => [
                "EmployeeBasicSalary.employee_id" => $employeeId,
                "EmployeeBasicSalary.end_date" => null,
            ],
            "recursive" => -1,
        ]);
        $salary = e_isset(@$basicSalary["EmployeeBasicSalary"]["salary"], 0);
        $otSalary = e_isset(@$basicSalary["EmployeeBasicSalary"]["ot_salary"], 0);
        //data potongan iuran koperasi
        $cooperativeContributionFee = ClassRegistry::init("CooperativeContributionFee")->find("list", ["fields" => ["CooperativeContributionFee.id", "CooperativeContributionFee.amount"], "conditions" => ["CooperativeContributionFee.employee_type_id" => $employeeTypeId]]);
        $iuran = array_shift($cooperativeContributionFee);
        $iuran = is_null($iuran) ? 0 : $iuran;
        $result["salary"]["potongan"]["data"][$mapParameterSalary["IWP"]] = $iuran;
        //data potongan kepala ikan
        $saleProductAdditionals = ClassRegistry::init("SaleProductAdditional")->find("all", [
            "conditions" => [
                "DATE(SaleProductAdditional.created) >=" => $startDt,
                "DATE(SaleProductAdditional.created) <=" => $endDt,
                "SaleProductAdditional.purchaser_id" => $employeeId,
            ],
            "recursive" => -1,
        ]);
        $dataPotongan = [
            "amount" => 0,
            "data" => []
        ];
        foreach ($saleProductAdditionals as $saleProductAdditional) {
            $dataPotongan["amount"]+=$saleProductAdditional["SaleProductAdditional"]["grand_total"];
            $dataPotongan["data"][] = [
                "id" => $saleProductAdditional["SaleProductAdditional"]["id"],
                "amount" => $saleProductAdditional["SaleProductAdditional"]["grand_total"],
            ];
        }
        $result["salary"]["potongan"]["data"][$mapParameterSalary["PKI"]] = $dataPotongan["amount"];
        //data potongan hutang
        $dataPotonganKasbon = [
            "amount" => 0,
            "data" => []
        ];
        $employeeDataLoans = ClassRegistry::init("EmployeeDataLoan")->find("all", [
            "conditions" => [
                "EmployeeDataLoan.verify_status_id" => 3,
                "EmployeeDataLoan.remaining_loan > 0",
                "EmployeeDataLoan.employee_id" => $employeeId,
            ],
            "contain" => [
                "CooperativeLoanHold" => [
                    "conditions" => [
                        "CooperativeLoanHold.start_period" => $startDt,
                        "CooperativeLoanHold.end_period" => $endDt,
                    ]
                ],
            ]
        ]);
        foreach ($employeeDataLoans as $employeeDataLoan) {
            if (!empty($employeeDataLoan["CooperativeLoanHold"])) {
                continue;
            }
            $potongan = ceil($employeeDataLoan["EmployeeDataLoan"]["total_amount_loan"] / $employeeDataLoan["EmployeeDataLoan"]["installment_number"] / $loanFactor);
            if ($potongan > $employeeDataLoan["EmployeeDataLoan"]["remaining_loan"]) {
                $potongan = $employeeDataLoan["EmployeeDataLoan"]["remaining_loan"];
            }
            $dataPotonganKasbon["amount"]+=$potongan;
            $dataPotonganKasbon["data"][] = [
                "id" => $employeeDataLoan["EmployeeDataLoan"]["id"],
                "amount" => $potongan,
            ];
        }
        $result["salary"]["potongan"]["data"][$mapParameterSalary["PKS"]] = $dataPotonganKasbon["amount"];
        //data potongan sembako
        $dataPotonganSembako = [
            "amount" => 0,
            "data" => []
        ];
        $cooperativeItemLoanPayment = ClassRegistry::init("CooperativeItemLoanPayment")->find("first", [
            "conditions" => [
                "CooperativeItemLoanPayment.start_period" => $startDt,
                "CooperativeItemLoanPayment.end_period" => $endDt,
                "CooperativeItemLoanPayment.employee_type_id" => $employeeTypeId,
            ],
            "contain" => [
                "CooperativeItemLoanPaymentDetail" => [
                    "CooperativeItemLoan" => [
                        "conditions" => [
                            "CooperativeItemLoan.employee_id" => $employeeId,
                        ]
                    ],
                ],
            ]
        ]);
        if (!empty($cooperativeItemLoanPayment["CooperativeItemLoanPaymentDetail"][0]["CooperativeItemLoan"])) {
            $dataPotonganSembako["amount"] = $cooperativeItemLoanPayment["CooperativeItemLoanPaymentDetail"][0]["amount"];
            $dataPotonganSembako["data"]["cooperative_item_loan_payment_detail_id"] = $cooperativeItemLoanPayment["CooperativeItemLoanPaymentDetail"][0]["id"];
            $dataPotonganSembako["data"]["cooperative_item_loan_id"] = $cooperativeItemLoanPayment["CooperativeItemLoanPaymentDetail"][0]["CooperativeItemLoan"]["id"];
            $dataPotonganSembako["data"]["amount"] = $cooperativeItemLoanPayment["CooperativeItemLoanPaymentDetail"][0]["amount"];
        }
        $result["salary"]["potongan"]["data"][$mapParameterSalary["PBK"]] = $dataPotonganSembako["amount"];
        //==
        //==start data potongan
        $salaryReductions = ClassRegistry::init("SalaryReduction")->find("all", [
            "contain" => [
                "SalaryReductionDetail" => [
                    "conditions" => [
                        "SalaryReductionDetail.employee_id" => $employeeId,
                    ]
                ],
                "ParameterSalary",
            ],
        ]);
        foreach ($salaryReductions as $salaryReduction) {
            foreach ($salaryReduction["SalaryReductionDetail"] as $salaryReductionDetail) {
                $result["salary"]["potongan"]["data"][$salaryReduction["ParameterSalary"]["id"]] = $salaryReductionDetail["amount"];
            }
        }
        //==end data potongan
        //denda keterlambatan
        $result["salary"]["potongan"]["data"][$mapParameterSalary["DKT"]] = floor($attendanceSummary["jumlah_jam_telat"] / 60) * $lateFine;

        //lainnya
        $result["salary"]["pendapatan"]["data"][$mapParameterSalary["GPB"]] = $salary;
        $result["salary"]["pendapatan"]["data"][$mapParameterSalary["LPJ"]] = floor($attendanceSummary["jumlah_jam_lembur"] / 3600 * $otSalary);

        // get parameter salaries for certain employee
        $salaryAllowances = ClassRegistry::init("SalaryAllowance")->find("first", [
            "conditions" => [
                "SalaryAllowance.employee_id" => $employeeId
            ],
            "contain" => [
                "SalaryAllowanceDetail"
            ]
        ]);
        if (!empty($salaryAllowances)) {
            foreach ($salaryAllowances['SalaryAllowanceDetail'] as $details) {
                $result['salary']['pendapatan']['data'][$details['parameter_salary_id']] = $details['amount'];
            }
        }

        $result["relation"] = [
            "EmployeeSalaryLoan" => e_isset(@$dataPotonganKasbon["data"], []),
            "EmployeeSalarySaleProductAdditional" => e_isset(@$dataPotongan["data"], []),
            "EmployeeSalaryItemLoan" => e_isset(@$dataPotonganSembako["data"], false),
        ];
        echo json_encode($this->_generateStatusCode(206, null, $result));
    }

    function admin_list_cooperative_item_loan() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Biodata.first_name like" => "%$q%",
                    "Biodata.last_name like" => "%$q%",
                    "Employee.nip like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("Account")->find("all", array(
            "conditions" => [
                $conds
            ],
            "contain" => array(
                "Employee" => array(
                    "Office",
                    "Department",
                    "BranchOffice",
                    "CooperativeItemLoan"
                ),
                "Biodata",
            ),
            "limit" => 10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item['Employee']) && !empty($item['Employee']['CooperativeItemLoan'])) {
                if ($item['Employee']['CooperativeItemLoan']['remaining'] > 0) {
                    $result[] = [
                        "id" => $item['Employee']['id'],
                        "full_name" => $item['Biodata']['full_name'],
                        "nip" => @$item['Employee']['nip'],
                        "jabatan" => @$item['Employee']['Office']['name'],
                        "jabatan_id" => @$item['Employee']['Office']['id'],
                        "department" => @$item['Employee']['Department']['name'],
                        "department_uniq_name" => @$item['Employee']['Department']['uniq_name'],
                        "branch_office" => @$item['Employee']['BranchOffice']['name'],
                        "remaining" => @$item['Employee']['CooperativeItemLoan']['remaining'],
                        "total_loan" => @$item['Employee']['CooperativeItemLoan']['total_loan'],
                        "employee_type_id" => @$item['Employee']['employee_type_id'],
                        "cooperative_item_loan_id" => @$item['Employee']['CooperativeItemLoan']['id']
                    ];
                }
            }
        }
        echo json_encode($result);
    }

}
