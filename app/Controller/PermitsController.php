<?php

App::uses('AppController', 'Controller');

class PermitsController extends AppController {

    var $name = "Permits";
    var $disabledAction = array(
    );

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_izin_pegawai");
        $this->contain = [
            "PermitType",
            "PermitStatus",
            "Employee" => [
                "Account" => [
                    "Biodata" => [
                        "Religion"
                    ]
                ],
                "Office",
                "Department"
            ]
        ];
        parent::admin_index();
    }

    function admin_index_validate() {
        $this->_activePrint(func_get_args(), "data_izin_pegawai_validasi");
        $this->contain = [
            "PermitType",
            "PermitStatus",
            "Employee" => [
                "Account" => [
                    "Biodata" => [
                        "Religion"
                    ]
                ],
                "Office",
                "Department"
            ]
        ];
        $this->conds = [
            "Permit.permit_status_id" => 1,
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
                    $this->Permit->data['Permit']['id'] = $id;
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
        if (!$this->Permit->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->Permit->data['Permit']['id'] = $id;
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 4));
            $this->data = $rows;
        }
    }

    function _options() {
        $this->set("permitTypes", $this->Permit->PermitType->find("list", array("fields" => array("PermitType.id", "PermitType.name"), "order" => "PermitType.name")));
        $this->set("permitStatuses", $this->Permit->PermitStatus->find("list", array("fields" => array("PermitStatus.id", "PermitStatus.name"))));
        $this->set("branchOffices", $this->Permit->Employee->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("employeeTypes", $this->Permit->Employee->EmployeeType->find("list", array("fields" => array("EmployeeType.id", "EmployeeType.name"))));
        $this->set("departments", ClassRegistry::init("Department")->find("list", array("fields" => array("Department.id", "Department.name"), "order" => "Department.name")));
        $this->set("pegawai", ClassRegistry::init("Employee")->getListWithFullname());
    }

    function admin_change_status() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->Permit->id = $this->request->data['id'];
            $this->Permit->save(array("Permit" => array("permit_status_id" => $this->request->data['status'])));
            $data = $this->Permit->find("first", array("conditions" => array("Permit.id" => $this->request->data['id']), "recursive" => 1));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['PermitStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_selfadd() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            $this->Permit->data["Permit"]["employee_id"] = $this->_getEmployeeId();
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $savedData = $this->Permit->find("first", [
                    "conditions" => [
                        'Permit.id' => $this->Permit->getLastInsertID(),
                    ],
                    "contain" => [
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                        ],
                        "Supervisor",
                    ]
                ]);
                $this->loadModel("Notification");
                $this->Notification->addNotification($savedData['Permit']['id'], null, null, $savedData["Supervisor"]["id"], "Pegawai {$savedData["Employee"]["Account"]["Biodata"]["full_name"]} mengajukan permohonan ijin", "/admin/permits/index");
                $this->Session->setFlash(__("Pengajuan ijin berhasil dikirim"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_selfadd'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                try {
                    $savedData = [];
                    $permit_type_id = $this->Permit->data['Permit']['permit_type_id'];
                    $start_date = $this->Permit->data['Permit']['start_date'];
                    $end_date = $this->Permit->data['Permit']['end_date'];
                    $jam_keluar = $this->Permit->data['Permit']['jam_keluar'];
                    $tujuan_dinas = $this->Permit->data['Permit']['tujuan_dinas'];
                    $keterangan = $this->Permit->data['Permit']['keterangan'];
                    $personalia_note = $this->Permit->data['Permit']['personalia_note'];
                    $general_manager_note = $this->Permit->data['Permit']['general_manager_note'];
                    foreach ($this->Permit->data['Permit']['nomor'] as $employee) {                        
                        $savedData = [
                            "Permit" => [
                                "employee_id" => $employee,
                                "permit_type_id" => $permit_type_id,
                                "start_date" => $start_date,
                                "end_date" => $end_date,
                                "jam_keluar" => $jam_keluar,
                                "tujuan_dinas" => $tujuan_dinas,
                                "keterangan" => $keterangan,
                                "personalia_note" => $personalia_note,
                                "general_manager_note" => $general_manager_note
                            ]
                        ];
                        $this->Permit->saveAll($savedData);
                    }
                    $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                    $this->redirect(array('action' => 'admin_index'));
                } catch (Exception $ex) {
                    $this->Session->setFlash(__("Error found when saving data."), 'default', array(), 'danger');
                }
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_print_form_izin($id = null) {
        if ($this->{ Inflector::classify($this->name) }->exists($id)) {
            $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
                'conditions' => array(
                    Inflector::classify($this->name) . '.id' => $id,
                    Inflector::classify($this->name) . '.permit_status_id' => 1,
                ),
                'contain' => [
                    "PermitType",
                    "PermitStatus",
                    "Employee" => [
                        "Account" => [
                            "Biodata" => [
                                "Religion"
                            ]
                        ],
                        "Office",
                        "Department"
                    ]
                ],
            ));
            $this->data = $rows;
            $data = array(
                'title' => '<br>PT. CHEN WOO FISHERY <br> <u>Jl. Kima 4 Block K9/B2, Kawasan Industri Makassar</u> <br><br> FORMULIR KETERANGAN <br> IZIN PEGAWAI',
                'title2' => 'KETERANGAN IZIN PEGAWAI',
                'rows' => $rows,
            );
            $this->set(compact('data'));
            $this->_activePrint(["print"], "print_form_izin", "form_izin");
        } else {
            throw new NotFoundException(__("404 Data Not Found."));
        }
    }

    function admin_get_quota_cuti() {
        $this->autoRender = false;
        $employeeId = $this->request->query["employee_id"];
        $startDt = $this->request->query["start_dt"];
        $year = date("Y", strtotime($startDt));
        $taken = $this->Permit->countCutiTahunan($employeeId, $year);
        $annualPermit = ClassRegistry::init("AnnualPermit")->find("first", [
            "conditions" => [
                "AnnualPermit.year" => $year,
            ],
        ]);
        if (empty($annualPermit)) {
            $quota = 0;
        } else {
            $quota = $annualPermit["AnnualPermit"]["quota"];
        }
        echo json_encode($this->_generateStatusCode(206, null, ["quota" => $quota - $taken]));
    }

    function admin_annual_permit_report() {
        $conds = [];
        if (isset($this->request->query['Laporan_tahun']) && !empty($this->request->query['Laporan_tahun'])) {
            $year = $this->request->query['Laporan_tahun'];
        } else {
            $year = date("Y");
        }
        if (isset($this->request->query['Laporan_cabang']) && !empty($this->request->query['Laporan_cabang'])) {
            $conds = [
                "Employee.branch_office_id" => $this->request->query['Laporan_cabang'],
            ];
        }
        if (isset($this->request->query['select_Employee_employee_type_id']) && !empty($this->request->query['select_Employee_employee_type_id'])) {
            $type = $this->request->query['select_Employee_employee_type_id'];
            $conds = [
                "Employee.branch_office_id" => $type,
            ];
        }
        $employeeList = ClassRegistry::init("Employee")->getListInfo($conds);
        $result = [];
        foreach ($employeeList as $employeeId => $info) {
            $result[$employeeId] = $this->Permit->countCutiTahunan($employeeId, $year);
        }
        $annualPermit = ClassRegistry::init("AnnualPermit")->find("first", [
            "conditions" => [
                "AnnualPermit.year" => $year,
            ],
        ]);
        if (empty($annualPermit)) {
            $quota = 0;
        } else {
            $quota = $annualPermit["AnnualPermit"]["quota"];
        }
        $today = date("Y-m-d");
        $this->set(compact("result", "employeeList", "quota", "year", "today"));
        $this->_activePrint(func_get_args(), "laporan_cuti_tahunan");
    }

}
