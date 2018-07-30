<?php

App::uses('AppController', 'Controller');

class OutboxesController extends AppController {

    var $name = "Outboxes";
    var $disabledAction = array(
        "admin_add",
        "admin_edit",
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
    }

    function admin_kirim_sms() {
        $departments = ClassRegistry::init("Department")->find("list", ["fields" => ["Department.id", "Department.name"]]);
        foreach ($departments as $k => $v) {
            $departments["d_$k"] = $v;
            unset($departments[$k]);
        }
        $religions = ClassRegistry::init("Religion")->find("list", ["fields" => ["Religion.id", "Religion.name"]]);
        foreach ($religions as $k => $v) {
            $religions["a_$k"] = $v;
            unset($religions[$k]);
        }
        $tujuan = [
            "p" => "- Perorangan -",
            "s" => "- Semua -",
            "Departemen" => $departments,
            "Agama" => $religions,
        ];
        if ($this->request->is("post")) {
            $destinationArray = explode("_", $this->data["Outbox"]["tujuan"]);
            switch ($destinationArray[0]) {
                case "p":
                    $this->Outbox->sendMessage($this->data["Outbox"]["pesan"], $this->data["Outbox"]["nomor"]);
                    $this->Session->setFlash(__("SMS berhasil dikirim"), 'default', array(), 'success');
                    break;
                case "s":
                    $employees = ClassRegistry::init("Employee")->find("all", [
                        "contain" => [
                            "Account" => [
                                "Biodata",
                            ],
                        ],
                    ]);
                    foreach ($employees as $employee) {
                        $this->Outbox->sendMessage($this->data["Outbox"]["pesan"], $employee["Account"]["Biodata"]["handphone"]);
                    }
                    $this->Session->setFlash(__("SMS berhasil dikirim"), 'default', array(), 'success');
                    break;
                case "d":
                    $employees = ClassRegistry::init("Employee")->find("all", [
                        "contain" => [
                            "Account" => [
                                "Biodata",
                            ],
                        ],
                        "conditions" => [
                            "Employee.department_id" => $destinationArray[1],
                        ]
                    ]);
                    foreach ($employees as $employee) {
                        $this->Outbox->sendMessage($this->data["Outbox"]["pesan"], $employee["Account"]["Biodata"]["handphone"]);
                    }
                    $this->Session->setFlash(__("SMS berhasil dikirim"), 'default', array(), 'success');
                    break;
                case "a":
                    $employees = ClassRegistry::init("Account")->find("all", [
                        "contain" => [
                            "Biodata",
                        ],
                        "conditions" => [
                            "Biodata.religion_id" => $destinationArray[1],
                        ]
                    ]);
                    foreach ($employees as $employee) {
                        $this->Outbox->sendMessage($this->data["Outbox"]["pesan"], $employee["Biodata"]["handphone"]);
                    }
                    $this->Session->setFlash(__("SMS berhasil dikirim"), 'default', array(), 'success');
                    break;
                default:
                    $this->Session->setFlash(__("Tidak ada tujuan pengiriman"), 'default', array(), 'danger');
                    break;
            }
        }
        $this->data = [];
        $this->set(compact("tujuan"));
    }

}
