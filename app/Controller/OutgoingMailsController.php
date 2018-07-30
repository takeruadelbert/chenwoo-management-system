<?php

App::uses('AppController', 'Controller');

class OutgoingMailsController extends AppController {

    var $name = "OutgoingMails";
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
            "Creator" => [
                "Account" => [
                    "Biodata",
                ]
            ],
            "MailType",
            "MailClassification",
            "Approver" => [
                "Account" => [
                    "Biodata",
                ]
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
            "belum_disetujui" => $this->{ Inflector::classify($this->name) }->find("count", ["conditions" => am($conds, ["OutgoingMail.mail_status_id" => 1])]),
            "disetujui" => $this->{ Inflector::classify($this->name) }->find("count", ["conditions" => am($conds, ["OutgoingMail.mail_status_id" => 2])]),
            "revisi" => $this->{ Inflector::classify($this->name) }->find("count", ["conditions" => am($conds, ["OutgoingMail.mail_status_id" => 3])]),
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
                $uploader = new qqFileUploader($allowedExt, $size, $this->data['OutgoingMail']['lampiran'], true);
                $result = $uploader->handleUpload("lampiransuratkeluar" . DS);
                switch ($result['status']) {
                    case 206:
                        $this->OutgoingMail->data['AssetFile'] = array(
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
                unset($this->OutgoingMail->data['OutgoingMail']['lampiran']);
                $this->OutgoingMail->data['OutgoingMail']['creator_id'] = $this->_getEmployeeId();
                $this->OutgoingMail->data['OutgoingMail']['mail_status_id'] = 1;
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->OutgoingMail->generateNomorAgenda($this->OutgoingMail->getLastInsertID());
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
                    $uploader = new qqFileUploader($allowedExt, $size, $this->data['OutgoingMail']['lampiran'], true);
                    $result = $uploader->handleUpload("lampiransuratkeluar" . DS);
                    switch ($result['status']) {
                        case 206:
                            $this->OutgoingMail->data['AssetFile'] = array(
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
                    unset($this->OutgoingMail->data['OutgoingMail']['lampiran']);
                    $this->OutgoingMail->data['OutgoingMail']['creator_id'] = $this->_getEmployeeId();
                    $this->OutgoingMail->data['OutgoingMail']['mail_status_id'] = 1;

                    $this->{ Inflector::classify($this->name) }->id = $id;
                    $this->OutgoingMail->data['OutgoingMail']['id'] = $id;
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
        if (!$this->OutgoingMail->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->OutgoingMail->data['OutgoingMail']['id'] = $id;
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 4));
            $this->data = $rows;
        }
    }

    function admin_change_status() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->OutgoingMail->id = $this->request->data['id'];
            if ($this->request->data['status'] == 2) {
                $this->OutgoingMail->data['OutgoingMail']['revision_memo'] = "Sudah Disetujui.";
            } else if ($this->request->data['status'] == 3) {
                $this->OutgoingMail->data['OutgoingMail']['revision_memo'] = $this->request->data['memo'];
            }
            $this->OutgoingMail->save(array("OutgoingMail" => array("mail_status_id" => $this->request->data['status'], "status_action_dt" => DboSource::expression('NOW()'), "approver_id" => $this->_getEmployeeId())));
            $data = $this->OutgoingMail->find("first", array("conditions" => array("OutgoingMail.id" => $this->request->data['id']), "contain" => [
                    "Approver" => [
                        "Account" => [
                            "Biodata"
                        ]
                    ],
                    "MailStatus",
            ]));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['MailStatus']['name'], "approver_nip" => $data['Approver']['nip_baru'], "approver_name" => $data['Approver']['Account']['Biodata']['full_name'], "approver_tanggal" => date("Y-m-d", strtotime($data['OutgoingMail']['status_action_dt'])))));
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
                    "OutgoingMail.nomor_surat like" => "%$q%",
                    "OutgoingMail.nomor_agenda like" => "%$q%",
            ));
        } else {
            $conds = array();
        }
        $suggestions = ClassRegistry::init("OutgoingMail")->find("all", array(
            "conditions" => $conds,
            "contain" => [
                "Creator"
            ],
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item['OutgoingMail'])) {
                if ($item['Creator']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => $item['OutgoingMail']['id'],
                        "pengirim" => $item['OutgoingMail']['pengirim'],
                        "nomor_agenda" => $item['OutgoingMail']['nomor_agenda'],
                        "nomor_surat" => $item['OutgoingMail']['nomor_surat'],
                        "perihal" => $item['OutgoingMail']['perihal'],
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function admin_korespondensi($id = null) {
        if ($this->OutgoingMail->exists($id)) {
            $this->_activePrint(func_get_args(), "korespondensi_surat_keluar");
            $currentMail = $this->OutgoingMail->find("first", [
                "conditions" => [
                    "OutgoingMail.id" => $id
                ],
                "contain" => [
                    "Referensi",
                    "ReferensiAfter",
                ]
            ]);
            $result = [];
            $this->OutgoingMail->_findAllKoresponden($currentMail, $result);
            ksort($result);
            $this->set("result", $result);
        } else {
            throw new NotFoundException(__('Data tidak ditemukan'));
        }
    }

}
