<?php

App::uses('AppController', 'Controller');

class TransferEmployeesController extends AppController {

    var $name = "TransferEmployees";
    var $disabledAction = array(
    );
    var $contain = [
        "TransferEmployeeType",
        "Employee" => [
            "Account" => [
                "Biodata" => [
                    "Religion"
                ]
            ],
            "Office",
            "Department"
        ],
        "BranchOffice",
        "VerifyStatus",
        "Office",
        "Department"
    ];

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_mutasi_pegawai");
        $this->_setPeriodeLaporanDate("awal_TransferEmployee_tanggal_sk_mutasi", "akhir_TransferEmployee_tanggal_sk_mutasi");
        $this->contain = [
            "TransferEmployeeType",
            "Employee" => [
                "Account" => [
                    "Biodata" => [
                        "Religion"
                    ]
                ],
                "Office",
                "Department",
                "BranchOffice",
            ],
            "BranchOffice",
            "Office",
            "Department",
            "OriginOffice",
            "OriginDepartment",
            "OriginBranchOffice",
            "VerifyStatus"
        ];
        parent::admin_index();
    }

    function admin_index_validate() {
        $this->_activePrint(func_get_args(), "data_mutasi_pegawai_validasi");
        $this->_setPeriodeLaporanDate("awal_TransferEmployee_tanggal_sk_mutasi", "akhir_TransferEmployee_tanggal_sk_mutasi");
        $this->contain = [
            "TransferEmployeeType",
            "Employee" => [
                "Account" => [
                    "Biodata" => [
                        "Religion"
                    ]
                ],
                "Office",
                "Department",
                "BranchOffice",
            ],
            "BranchOffice",
            "Office",
            "Department",
            "OriginOffice",
            "OriginDepartment",
            "OriginBranchOffice",
            "VerifyStatus"
        ];
        $this->conds = [
            "TransferEmployee.verify_status_id" => 1,
        ];
        parent::admin_index();
    }

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function admin_edit($id = null) {
        if ($this->request->is("post") || $this->request->is("put")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->validates()) {
                if (!is_null($id)) {
                    $this->{ Inflector::classify($this->name) }->id = $id;
                    $this->TransferEmployee->data['TransferEmployee']['id'] = $id;
                    $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                    $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 4));

                    $this->data = $rows;
                    $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                    $this->redirect(array('action' => 'admin_index'));
                } else {
                    
                }
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
            }
        } else {
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 4));
            $this->data = $rows;
        }
    }

    function admin_view($id = null) {
        if (!$this->TransferEmployee->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->TransferEmployee->data['TransferEmployee']['id'] = $id;
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 4));
            $this->data = $rows;
        }
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $empId = $this->TransferEmployee->data["TransferEmployee"]["employee_id"];
                $this->TransferEmployee->data["TransferEmployee"]["verify_status_id"] = 1;
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function _options() {
        $this->set("departments", $this->TransferEmployee->Department->find("list", array("fields" => array("Department.id", "Department.name"))));
        $this->set("offices", $this->TransferEmployee->Office->find("list", array("fields" => array("Office.id", "Office.name"))));
        $this->set("transferEmployeeTypes", $this->TransferEmployee->TransferEmployeeType->find("list", array("fields" => array("TransferEmployeeType.id", "TransferEmployeeType.name"))));
        $this->set("employees", $this->TransferEmployee->Employee->getListWithFullname());
        $this->set("employeeTypes", $this->TransferEmployee->Employee->EmployeeType->find("list", array("fields" => array("EmployeeType.id", "EmployeeType.name"))));
        $this->set("branchOffices", $this->TransferEmployee->Employee->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("verifyStatuses", $this->TransferEmployee->VerifyStatus->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))));
    }

    function admin_change_status_verify() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->TransferEmployee->data['TransferEmployee']['id'] = $this->request->data['id'];
            $this->TransferEmployee->data['TransferEmployee']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '3') {
                $idTransferEmployee = ClassRegistry::init("TransferEmployee")->find("first", [
                    "conditions" => [
                        "TransferEmployee.id" => $this->request->data['id'],
                    ],
                ]);
                $employee = $this->TransferEmployee->Employee->find("first", [
                    "conditions" => [
                        "Employee.id" => $idTransferEmployee['TransferEmployee']['employee_id'],
                    ],
                ]);
                $this->TransferEmployee->data['Employee']['id'] = $idTransferEmployee['TransferEmployee']['employee_id'];
                $this->TransferEmployee->data['Employee']['department_id'] = $idTransferEmployee['TransferEmployee']['department_id'];
                $this->TransferEmployee->data['Employee']['office_id'] = $idTransferEmployee['TransferEmployee']['office_id'];
                $this->TransferEmployee->data['Employee']['branch_office_id'] = $idTransferEmployee['TransferEmployee']['branch_office_id'];
                $this->TransferEmployee->data['TransferEmployee']['origin_branch_office_id'] = $employee['Employee']['branch_office_id'];
                $this->TransferEmployee->data['TransferEmployee']['origin_department_id'] = $employee['Employee']['department_id'];
                $this->TransferEmployee->data['TransferEmployee']['origin_office_id'] = $employee['Employee']['office_id'];

                $positionHistory = [];
                $positionHistory['PositionHistory']['nama_jabatan'] = $employee['Office']['name'];
                $positionHistory['PositionHistory']['instansi'] = $employee['BranchOffice']['name'];
                $positionHistory['PositionHistory']['unit_kerja'] = $employee['Department']['name'];
                $positionHistory['PositionHistory']['no_sk'] = $idTransferEmployee["TransferEmployee"]["no_sk_mutasi"];
                $positionHistory['PositionHistory']['tanggal_sk'] = $idTransferEmployee["TransferEmployee"]["tanggal_sk_mutasi"];
                $positionHistory['PositionHistory']['tmt'] = $employee["Employee"]["tmt"];
                $positionHistory['PositionHistory']['employee_id'] = $employee["Employee"]["id"];
                ClassRegistry::init("PositionHistory")->save($positionHistory);
                $this->TransferEmployee->data['TransferEmployee']['verified_by_id'] = $this->_getEmployeeId();
                $this->TransferEmployee->data['TransferEmployee']['verified_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '2') {
                $this->TransferEmployee->data['TransferEmployee']['verified_by_id'] = $this->_getEmployeeId();
                $this->TransferEmployee->data['TransferEmployee']['verified_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '1') {
                $this->TransferEmployee->data['TransferEmployee']['verified_by_id'] = null;
                $this->TransferEmployee->data['TransferEmployee']['verified_datetime'] = null;
            }
            $this->TransferEmployee->saveAll();
            $data = $this->TransferEmployee->find("first", array("conditions" => array("TransferEmployee.id" => $this->request->data['id']), "recursive" => 3));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

}
