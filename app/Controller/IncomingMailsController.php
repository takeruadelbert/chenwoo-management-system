<?php

App::uses('AppController', 'Controller');

class IncomingMailsController extends AppController {

    var $name = "IncomingMails";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->contain = [
            "MailStatus",
            "Employee" => [
                "Account" => [
                    "Biodata",
                ]
            ],
            "MailClassification",
            "MailUrgency",
            "Approver" => [
                "Account" => [
                    "Biodata",
                ]
            ],
            "AssetFile",
            "IncomingMailFile" => [
                "AssetFile"
            ],
        ];
        $conds = $this->_filter($_GET, $this->filterCond);
        if (empty($conds)) {
            $conds = $this->defaultConds;
        }
        $conds['AND'] = am($conds, array(
                ), $this->conds);
        if ($this->order === false) {
            $this->order = Inflector::classify($this->name) . '.created desc';
        }
        $this->Paginator->settings = array(
            Inflector::classify($this->name) => array(
                'conditions' => $conds,
                'limit' => $this->paginate['limit'],
                'maxLimit' => $this->paginate['maxLimit'],
                'order' => $this->order,
                'recursive' => -1,
                'contain' => $this->contain,
            )
        );
        $rows = $this->Paginator->paginate($this->{ Inflector::classify($this->name) });
        $data = array(
            'rows' => $rows,
        );
        //sumary data
        $summary = [
            "belum_disetujui" => $this->{ Inflector::classify($this->name) }->find("count", ["conditions" => am($conds, ["IncomingMail.mail_status_id" => 1])]),
            "disetujui" => $this->{ Inflector::classify($this->name) }->find("count", ["conditions" => am($conds, ["IncomingMail.mail_status_id" => 2])]),
            "revisi" => $this->{ Inflector::classify($this->name) }->find("count", ["conditions" => am($conds, ["IncomingMail.mail_status_id" => 3])]),
        ];
        $this->set(compact('data', "summary"));
        if ($this->args === false) {
            $args = func_get_args();
        } else {
            $args = $this->args;
        }
        if (isset($args[0])) {
            $jenis = $args[0];
            $this->cetak = $jenis;
            if ($this->cetak_template === false) {
                $this->render($jenis);
            } else {
                $this->render($this->cetak_template);
            }
        }
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("mailTypes", ClassRegistry::init("MailType")->find("list", ["fields" => ["MailType.id", "MailType.name"], "order" => "MailType.name asc"]));
        $this->set("mailClassifications", ClassRegistry::init("MailClassification")->find("list", ["fields" => ["MailClassification.id", "MailClassification.name"], "order" => "MailClassification.name asc"]));
        $this->set("mailUrgencies", ClassRegistry::init("MailUrgency")->find("list", ["fields" => ["MailUrgency.id", "MailUrgency.name"], "order" => "MailUrgency.name asc"]));
        $this->set("mailOrigins", ClassRegistry::init("MailOrigin")->find("list", ["fields" => ["MailOrigin.id", "MailOrigin.name"], "order" => "MailOrigin.name asc"]));
        $this->set("mailRacks", ClassRegistry::init("MailRack")->find("list", ["fields" => ["MailRack.id", "MailRack.name"], "order" => "MailRack.name asc"]));
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                App::import("Vendor", "qqUploader");
                $allowedExt = array("gif", "png", "jpg", "jpeg", "pdf", "doc", "docx");
                $size = 2 * 1024 * 1024;
                $uploader = new qqFileUploader($allowedExt, $size, $this->data['IncomingMail']['lampiran'], true);
                $result = $uploader->handleUpload("lampiransuratmasuk" . DS);
                switch ($result['status']) {
                    case 206:
                        $this->IncomingMail->data['AssetFile'] = array(
                            "folder" => $result['data']['folder'],
                            "filename" => $result['data']['fileName'],
                            "ext" => $result['data']['ext'],
                            "is_private" => true,
                        );
                        break;
                    case 440:
                    case 441:
                        break;
                    case 443:
                    case 442:
                        $this->Session->setFlash(__($result['message']), 'default', array(), 'danger');
                        break;
                }
                unset($this->IncomingMail->data['IncomingMail']['lampiran']);
                $this->IncomingMail->data['IncomingMail']['employee_id'] = $this->_getEmployeeId();
                $this->IncomingMail->data['IncomingMail']['mail_status_id'] = 1;
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->IncomingMail->generateNomorAgenda($this->IncomingMail->getLastInsertID());
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_edit($id = null) {
        if ($this->request->is("post") || $this->request->is("put")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->validates()) {
                if (!is_null($id)) {
                    App::import("Vendor", "qqUploader");
                    $allowedExt = array("gif", "png", "jpg", "jpeg", "pdf", "doc", "docx");
                    $size = 2 * 1024 * 1024;
                    $uploader = new qqFileUploader($allowedExt, $size, $this->data['IncomingMail']['lampiran'], true);
                    $result = $uploader->handleUpload("lampiransuratkeluar" . DS);
                    switch ($result['status']) {
                        case 206:
                            $this->IncomingMail->data['AssetFile'] = array(
                                "folder" => $result['data']['folder'],
                                "filename" => $result['data']['fileName'],
                                "ext" => $result['data']['ext'],
                                "is_private" => true,
                            );
                            break;
                        case 440:
                        case 441:
                            break;
                        case 443:
                        case 442:
                            $this->Session->setFlash(__($result['message']), 'default', array(), 'danger');
                            break;
                    }
                    unset($this->IncomingMail->data['IncomingMail']['lampiran']);
                    $this->IncomingMail->data['IncomingMail']['creator_id'] = $this->_getEmployeeId();
                    $this->IncomingMail->data['IncomingMail']['mail_status_id'] = 1;

                    $this->{ Inflector::classify($this->name) }->id = $id;
                    $this->IncomingMail->data['IncomingMail']['id'] = $id;
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
        if (!$this->IncomingMail->exists($id)) {
            throw new NotFoundException(__('Data Not Found'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->IncomingMail->data['IncomingMail']['id'] = $id;
            $this->data = $this->_queryDetailSurat($id);
        }
    }

    function admin_detailsurat($id = null) {
        if (!$this->IncomingMail->exists($id)) {
            throw new NotFoundException(__('Data Not Found'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->IncomingMail->data['IncomingMail']['id'] = $id;
            $currentEmp = $this->_getEmployeeId();
            $this->IncomingMail->query("UPDATE mail_recipients SET seen = 1 WHERE incoming_mail_id = $id AND employee_id = $currentEmp");
            $this->data = $this->_queryDetailSurat($id);
            if ($this->request->is("ajax")) {
                $this->autoRender = false;
                echo json_encode($this->_generateStatusCode(206, null, $this->data));
            }
        }
    }

    function admin_detailsurattembusan($id = null) {
        if (!$this->IncomingMail->exists($id)) {
            throw new NotFoundException(__('Data Not Found'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->IncomingMail->data['IncomingMail']['id'] = $id;
            $currentEmp = $this->_getEmployeeId();
            $this->IncomingMail->query("UPDATE incoming_mail_carbon_copies SET seen = 1 WHERE incoming_mail_id = $id AND employee_id = $currentEmp");
            $this->data = $this->_queryDetailSurat($id);
            if ($this->request->is("ajax")) {
                $this->autoRender = false;
                echo json_encode($this->_generateStatusCode(206, null, $rows));
            }
        }
    }

    function _queryDetailSurat($id = null) {
        return $this->{ Inflector::classify($this->name) }->find("first", array(
                    'conditions' => [
                        Inflector::classify($this->name) . ".id" => $id
                    ],
                    "contain" => [
                        "Approver" => [
                            "Account" => [
                                "Biodata",
                                "User"
                            ],
                            "Department",
                            "Office",
                        ],
                        "Employee" => [
                            "Account" => [
                                "Biodata",
                                "User"
                            ],
                            "Department",
                            "Office",
                        ],
                        "IncomingMailCarbonCopy" => [
                            "Employee" => [
                                "Account" => [
                                    "Biodata",
                                    "User"
                                ],
                                "Department",
                                "Office",
                            ],
                        ],
                        "MailRecipient" => [
                            "Employee" => [
                                "Account" => [
                                    "Biodata",
                                    "User"
                                ],
                                "Department",
                                "Office",
                            ],
                            "Dispositor" => [
                                "Account" => [
                                    "Biodata",
                                    "User"
                                ],
                                "Department",
                                "Office",
                            ],
                        ],
                        "IncomingMailFile" => [
                            "AssetFile",
                        ],
                        "Korespondensi",
                        "AssetFile",
                    ]
        ));
    }

    function admin_change_status() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->IncomingMail->data = array(
                "IncomingMail" => array(
                    "id" => $this->request->data['id'],
                    "mail_status_id" => $this->request->data['status'],
                    "status_action_dt" => date("Y-m-d H:i:s"),
                    "approver_id" => $this->_getEmployeeId()
                )
            );
//            if ($this->request->data['status'] == 2) {
//                $this->IncomingMail->data['MailRecipient'][0]['employee_id'] = $this->request->data['receiver'];
//                $this->IncomingMail->data['MailRecipient'][0]['seq'] = 1;
//            }
            $this->IncomingMail->saveAll($this->IncomingMail->data, ["deep" => true]);
            $data = $this->IncomingMail->find("first", array("conditions" => array("IncomingMail.id" => $this->request->data['id']), "contain" => [
                    "Approver" => [
                        "Account" => [
                            "Biodata"
                        ]
                    ],
                    "MailStatus",
            ]));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['MailStatus']['name'], "approver_nip" => $data['Approver']['nip_baru'], "approver_name" => $data['Approver']['Account']['Biodata']['full_name'], "approver_tanggal" => date("Y-m-d", strtotime($data['IncomingMail']['status_action_dt'])))));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_list() {
        $this->autoRender = false;
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds = array(
                "or" => array(
                    "IncomingMail.nomor_surat like" => "%$q%",
                    "IncomingMail.nomor_agenda like" => "%$q%",
            ));
        } else {
            $conds = array();
        }
        $suggestions = ClassRegistry::init("IncomingMail")->find("all", array(
            "conditions" => $conds,
            "contain" => [
                "Employee"
            ],
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item['IncomingMail'])) {
                if ($item['Employee']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => $item['IncomingMail']['id'],
                        "pengirim" => $item['IncomingMail']['pengirim'],
                        "nomor_agenda" => $item['IncomingMail']['nomor_agenda'],
                        "nomor_surat" => $item['IncomingMail']['nomor_surat'],
                        "perihal" => $item['IncomingMail']['perihal'],
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function admin_korespondensi($id = null) {
        if ($this->IncomingMail->exists($id)) {
            $this->_activePrint(func_get_args(), "korespondensi_surat");
            $currentMail = $this->IncomingMail->find("first", [
                "conditions" => [
                    "IncomingMail.id" => $id
                ],
                "contain" => [
                    "Korespondensi",
                    "KorespondensiAfter",
                ]
            ]);
            $result = [];
            $this->IncomingMail->_findAllKoresponden($currentMail, $result);
            ksort($result);
            $this->set("result", $result);
        } else {
            throw new NotFoundException(__('Data tidak ditemukan'));
        }
    }

    function admin_add_penerima() {
        
    }

    function admin_laporan() {
        if (isset($this->request->query["tipe_surat"]) && $this->request->query["tipe_surat"] == "masuk") {
            $this->_activePrint(func_get_args(), "laporan_surat");
            $awal = $this->request->query['tanggal_awal'];
            $akhir = $this->request->query['tanggal_akhir'];
            $result = $this->IncomingMail->find("all", [
                "conditions" => [
                    "IncomingMail.created between '$awal' and '$akhir'"
                ],
                "contain" => [
                    "MailClassification",
                    "MailOrigin",
                    "MailType"
                ]
            ]);

            $this->set("inMail", $result);
            $this->set(compact("awal", "akhir"));
        } else if (isset($this->request->query["tipe_surat"]) && $this->request->query["tipe_surat"] == "keluar") {
            $this->_activePrint(func_get_args(), "laporan_surat");
            $awal = $this->request->query['tanggal_awal'];
            $akhir = $this->request->query['tanggal_akhir'];
            $result = ClassRegistry::init("OutgoingMail")->find("all", [
                "conditions" => [
                    "OutgoingMail.created between '$awal' and '$akhir'"
                ],
                "contain" => [
                    "MailClassification",
                    "MailType"
                ]
            ]);
            $this->set(compact("awal", "akhir"));
            $this->set("outMail", $result);
        }
    }

    function admin_ekspedisi($id = null) {
        if (!$this->IncomingMail->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            $this->_activePrint(func_get_args(), "ekspedisi_surat_masuk");
            $result = $this->IncomingMail->find("first", [
                "conditions" => [
                    "IncomingMail.id" => $id,
                ],
                "contain" => [
                    "MailRecipient" => [
                        "IncomingMail" => [
                            "Approver",
                            "MailStatus",
                        ],
                        "Dispositor" => [
                            "Account" => [
                                "Biodata",
                            ],
                        ],
                        "Employee" => [
                            "Account" => [
                                "Biodata",
                            ],
                            "Department"
                        ],
                        "order" => "MailRecipient.created asc",
                    ],
                    "MailStatus",
                    "Employee" => [
                        "Account" => [
                            "Biodata",
                        ]
                    ],
                    "MailClassification",
                    "MailUrgency",
                    "Approver" => [
                        "Account" => [
                            "Biodata",
                        ]
                    ],
                ]
            ]);
            $this->set(compact("result"));
        }
    }

    function cron_surat() {
        
    }

}
