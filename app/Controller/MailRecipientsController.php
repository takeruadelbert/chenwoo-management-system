<?php

App::uses('AppController', 'Controller');

class MailRecipientsController extends AppController {

    var $name = "MailRecipients";
    var $disabledAction = array(
        "admin_add",
        "admin_edit",
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
    }

    function admin_index() {
        $this->contain = [
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
        ];
        if (!$this->_isAdmin()) {
            $this->conds = [
                "MailRecipient.employee_id" => $this->_getEmployeeId(),
            ];
        }
        $mailUnread = $this->MailRecipient->find('count', array('conditions' => array("and" => ['MailRecipient.seen' => 0, "MailRecipient.employee_id" => $this->_getEmployeeId(), "NOT" => ["MailRecipient.forwarded" => 1]])));
        $this->set('mailUnread', $mailUnread);
        $mailRead = $this->MailRecipient->find('count', array('conditions' => array("and" => ['MailRecipient.seen' => 1, "MailRecipient.employee_id" => $this->_getEmployeeId(), "NOT" => ["MailRecipient.forwarded" => 1]])));
        $this->set('mailRead', $mailRead);
        $dispositionMail = $this->MailRecipient->find('count', array('conditions' => array('MailRecipient.dispositor_id' => $this->_getEmployeeId())));
        $this->set('dispositionMail', $dispositionMail);
        $total = $mailUnread + $mailRead + $dispositionMail;
        $this->set('total', $total);
        parent::admin_index();
    }

    function admin_disposisi_surat() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $seq = $this->request->data['seq'];
            $this->MailRecipient->data = array(
                "MailRecipient" => array(
                    "dispositor_id" => $this->_getEmployeeId(),
                    "employee_id" => $this->request->data['employeeId'],
                    "incoming_mail_id" => $this->request->data['id'],
                    "seq" => $seq + 1,
                    "memo" => $this->request->data['memo'],
                ),
            );

            $this->MailRecipient->data['MailDisposition']['memo'] = $this->request->data['memo'];
            $this->MailRecipient->data['MailDisposition']['regard'] = $this->request->data['regard'];
            $this->MailRecipient->data['MailDisposition']['nomor_disposisi'] = $this->_generateIdDokumen($this->request->data['id'], $this->request->data['department']);
            $this->MailRecipient->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
            if ($seq != 0) {
                $this->MailRecipient->flagForward($this->request->data['currentRecipientId']);
            }
            $data = $this->MailRecipient->find("first", array("conditions" => array("MailRecipient.id" => $this->MailRecipient->getLastInsertID()), "contain" => [
                    "Dispositor" => [
                        "Account" => [
                            "Biodata"
                        ]
                    ],
            ]));
            //carbon copy
            $ccModel = ClassRegistry::init("IncomingMailCarbonCopy");
            if (isset($this->request->data['ccId']) && is_array($this->request->data['ccId'])) {
                foreach ($this->request->data['ccId'] as $ccid) {
                    $ccModel->create();
                    $ccModel->save([
                        "employee_id" => $ccid,
                        "incoming_mail_id" => $this->request->data['id'],
                    ]);
                }
            }
            echo json_encode($this->_generateStatusCode(206, "Surat berhasil diteruskan", array("dispositor_name" => $data['Dispositor']['Account']['Biodata']['full_name'], "dispositor_nip" => $data['Dispositor']['nip_baru'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function _generateIdDokumen($id = null, $department_uniq = null) {
        $inc_id = 1;
        $Y = date('Y');
        $testCode = "[0-9]{4}/DIS/$department_uniq/$Y";
        $lastRecord = $this->MailRecipient->MailDisposition->find('first', array('conditions' => array('not' => array('MailDisposition.id' => $id), 'and' => array("MailDisposition.nomor_disposisi regexp" => $testCode)), 'order' => array('MailDisposition.nomor_disposisi' => 'DESC')));
        if (!empty($lastRecord)) {
            $codeList = explode('/', $lastRecord['MailDisposition']['nomor_disposisi']);
            if ($department_uniq == $codeList[2] && $Y == $codeList[3]) {
                $first = intval($codeList[0]);
                $inc_id+=$first;
            }
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = strtoupper("$inc_id/DIS/$department_uniq/$Y");
        return $kode;
    }

    function admin_view($id = null) {
        if (!$this->IncomingMail->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->IncomingMail->data['IncomingMail']['id'] = $id;
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 2));
            $this->data = $rows;
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

    function admin_cetak_disposisi($mail_recipient_id = null) {
        if ($this->MailRecipient->exists($mail_recipient_id)) {
            $this->_activePrint(['print'], "surat_disposisi");
            $this->set("data", $this->MailRecipient->find("first", [
                        "conditions" => [
                            "MailRecipient.id" => $mail_recipient_id,
                        ],
                        "recursive" => 4
            ]));
        } else {
            throw new NotFoundException(__('Data tidak ditemukan'));
        }
    }

}
