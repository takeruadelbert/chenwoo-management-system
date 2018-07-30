<?php

App::uses('AppController', 'Controller');

class CooperativeCashDisbursementsController extends AppController {

    var $name = "CooperativeCashDisbursements";
    var $disabledAction = array(
    );
    var $contain = [
        "CooperativeCashDisbursementDetail" => [
            "CooperativeGoodList" => [
                "CooperativeGoodListUnit"
            ]
        ],
        "CooperativeCash",
        "Creator" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "VerifiedBy" => [
            "Account" => [
                "Biodata"
            ]
        ],
        "BranchOffice"
    ];

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

    function view_cash_disbursement($id = null) {
        if ($this->CooperativeCashDisbursement->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->CashDisbursement->find("first", ["conditions" => ["CashDisbursement.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function _options() {
        $this->set("cooperativeCashes", $this->CooperativeCashDisbursement->CooperativeCash->getListWithFullLabel());
        $this->set("branchOffices", $this->CooperativeCashDisbursement->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("verifyStatuses", $this->CooperativeCashDisbursement->VerifyStatus->find("list", ["fields" => ["VerifyStatus.id", "VerifyStatus.name"]]));
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->CooperativeCashDisbursement->_numberSeperatorRemover();
                $this->{ Inflector::classify($this->name) }->data['CooperativeCashDisbursement']['branch_office_id'] = $this->stnAdmin->getBranchId();
                App::import("Vendor", "qqUploader");
                $allowedExt = array("pdf", "png", "jpg");
                $size = 20 * 1024 * 1024;
                $uploader = new qqFileUploader($allowedExt, $size, $this->data['CooperativeCashDisbursement']['bukti_pembelian'], true);
                $result = $uploader->handleUpload("bukti_pembelian" . DS);
                switch ($result['status']) {
                    case 206:
                        $this->CooperativeCashDisbursement->data['AssetFile'] = array(
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
                        $var = "";
                        foreach ($allowedExt as $index => $ext) {
                            $var .= $ext . ", ";
                        }
                        $this->Session->setFlash(__("Ekstensi file salah, yang diperbolehkan hanya " . $var), 'default', array(), 'warning');
                        $this->redirect(array('action' => 'admin_add'));
                        break;
                    case 442:
                        $this->Session->setFlash(__($result['message']), 'default', array(), 'danger');
                        return;
                        break;
                }

                unset($this->CooperativeCashDisbursement->data['CooperativeCashDisbursement']['bukti_pembelian']);
                $this->CooperativeCashDisbursement->data["CooperativeCashDisbursement"]["employee_id"] = $this->stnAdmin->getEmployeeId();
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->CooperativeCashDisbursement->generateNomor($this->CooperativeCashDisbursement->getLastInsertID());
                /* updating the remaining stock after buying them */
                ClassRegistry::init("CooperativeGoodList")->updateByCashDisbursement($this->CooperativeCashDisbursement->getLastInsertID());
                $cooperativeCashDisburment = $this->CooperativeCashDisbursement->find("first", [
                    "conditions" => [
                        "CooperativeCashDisbursement.id" => $this->CooperativeCashDisbursement->getLastInsertID(),
                    ],
                    "recursive" => -1,
                ]);
                $entity = $cooperativeCashDisburment["CooperativeCashDisbursement"];
                //update to cooperative cash
                ClassRegistry::init("CooperativeTransactionMutation")->addMutation($entity["cooperative_cash_id"], $entity["id"], "PMBL", $entity["grand_total"], $entity["created_date"], ClassRegistry::init("CooperativeEntryType")->getIdByCode(201));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_add'));
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
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    if (!is_null($id)) {
                        $this->CooperativeCashDisbursement->_numberSeperatorRemover();
                        foreach ($this->data['CooperativeCashDisbursementDetail'] as $k => $details) {
                            if (isset($details['id']) && !empty($details['id'])) {
                                $this->CooperativeCashDisbursement->CooperativeCashDisbursementDetail->data['CooperativeCashDisbursementDetail']['id'] = $details['id'];
                            }
                            if (!empty($details)) {
                                App::import("Vendor", "qqUploader");
                                $allowedExt = array("jpg", "jpeg", "png");
                                $size = 10 * 1024 * 1024;
                                $uploader = new qqFileUploader($allowedExt, $size, $this->CooperativeCashDisbursement->data['CooperativeCashDisbursementDetail'][$k]['gambar'], true);
                                $result = $uploader->handleUpload("kaskeluar" . DS . "koperasi" . DS);
                                switch ($result['status']) {
                                    case 206:
                                        $this->CooperativeCashDisbursement->data['CooperativeCashDisbursementDetail'][$k]['AssetFile'] = array(
                                            "folder" => $result['data']['folder'],
                                            "filename" => $result['data']['fileName'],
                                            "ext" => $result['data']['ext'],
                                            "is_private" => true,
                                        );
                                        break;
                                }
                                unset($this->CooperativeCashDisbursement->data['CooperativeCashDisbursementDetail'][$k]['gambar']);
                            }
                        }
                        $this->CooperativeCashDisbursement->_deleteableHasmany();
                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                        $this->redirect(array('action' => 'admin_index'));
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

//    function admin_change_status_verify() {
//        $this->autoRender = false;
//        if ($this->request->is("PUT")) {
//            $total = 0;
//            $this->CooperativeCashDisbursement->_numberSeperatorRemover();
//            $this->CooperativeCashDisbursement->data['CooperativeCashDisbursement']['id'] = $this->request->data['id'];
//            $this->CooperativeCashDisbursement->data['CooperativeCashDisbursement']['verify_status_id'] = $this->request->data['status'];
//            if ($this->request->data['status'] == '2') {
//                $this->CooperativeCashDisbursement->data['CooperativeCashDisbursement']['verified_by_id'] = $this->_getEmployeeId();
//                $this->CooperativeCashDisbursement->data['CooperativeCashDisbursement']['verified_datetime'] = date("Y-m-d H:i:s");
//            } else if ($this->request->data['status'] == '3') {
//                $idKas = ClassRegistry::init("CooperativeCashDisbursement")->find("first", [
//                    "conditions" => [
//                        "CooperativeCashDisbursement.id" => $this->request->data['id'],
//                    ]
//                ]);
//                $dataKasKeluar = $this->CooperativeCashDisbursement->CooperativeCash->find("first", [
//                    "conditions" => [
//                        "CooperativeCash.id" => $idKas['CooperativeCashDisbursement']['cooperative_cash_id'],
//                    ],
//                ]);
//                $detail = $this->CooperativeCashDisbursement->CooperativeCashDisbursementDetail->find("all", [
//                    "conditions" => [
//                        "CooperativeCashDisbursementDetail.cooperative_cash_disbursement_id" => $idKas['CooperativeCashDisbursement']['id'],
//                    ],
//                ]);
//                foreach ($detail as $details) {
//                    $total = $total + $details['CooperativeCashDisbursementDetail']['amount'];
//                }
//                $remaining = $dataKasKeluar['CooperaiveCash']['nominal'] - $total;
//                $this->CooperativeCashDisbursement->data['CooperativeCash']['id'] = $idKas['CashDisbursement']['cooperative_cash_id'];
//                $this->CooperativeCashDisbursement->data['CooperativeCash']['nominal'] = $remaining;
//                $this->CooperativeCashDisbursement->data['CooperativeCashDisbursement']['verified_by_id'] = $this->_getEmployeeId();
//                $this->CooperativeCashDisbursement->data['CooperativeCashDisbursement']['verified_datetime'] = date("Y-m-d H:i:s");
//            } else {
//                $this->CooperativeCashDisbursement->data['CooperativeCashDisbursement']['verified_by_id'] = null;
//                $this->CooperativeCashDisbursement->data['CooperativeCashDisbursement']['verified_datetime'] = null;
//            }
//            $this->CooperativeCashDisbursement->saveAll();
//            $data = $this->CooperativeCashDisbursement->find("first", array("conditions" => array("CooperativeCashDisbursement.id" => $this->request->data['id']), "recursive" => 3));
//            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
//        } else {
//            echo json_encode($this->_generateStatusCode(400));
//        }
//    }

    function admin_view($id = null) {
        $this->{ Inflector::classify($this->name) }->id = $id;
        $this->CooperativeCashDisbursement->data['CooperativeCashDisbursement']['id'] = $id;
        $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 2));
        $this->data = $rows;
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "CooperativeCashDisbursement.cash_disbursement_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("CooperativeCashDisbursement")->find("all", array(
            "conditions" => [
                $conds,
            ],
            "contain" => [
                "Creator" => [
                    "Account" => [
                        "Biodata"
                    ],
                ],
            ],
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => @$item['CooperativeCashDisbursement']['id'],
                    "cash_disbursement_number" => @$item['CooperativeCashDisbursement']['cash_disbursement_number'],
                    "date" => @$item['CooperativeCashDisbursement']['created_date'],
                    "fullname" => @$item['Creator']['Account']['Biodata']['full_name'],
                ];
            }
        }
        echo json_encode($result);
    }

    function view_data_kas_keluar($id) {
        if (!empty($id) && $id != null) {
            $this->autoRender = false;
            $data = ClassRegistry::init("CooperativeCashDisbursement")->find("first", [
                "conditions" => [
                    "CooperativeCashDisbursement.id" => $id,
                ],
                "contain" => [
                    "Creator" => [
                        "Account" => [
                            "Biodata",
                        ],
                        "Office",
                    ],
                    "CooperativeCashDisbursementDetail" => [
                        "CooperativeGoodList"
                    ],
                    "CooperativeCash",
                ],
            ]);
            return json_encode($data);
        } else {
            throw new NotFoundException(__('Data Not Found'));
        }
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_transaksi_pembelian_koperasi");
        $this->periodeLaporanField = "CooperativeCashDisbursement_created_date";
        parent::admin_index();
    }

    function admin_print_cooperative_disbursement_receipt($id) {
        $this->_activePrint(["print"], "print_cooperative_cash_disbursement", "kwitansi");
        $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
            'conditions' => array(
                "CooperativeCashDisbursement.id" => $id,
            ),
            "contain" => [
                "CooperativeCashDisbursementDetail" => [
                    "CooperativeGoodList" => [
                        "CooperativeGoodListUnit"
                    ],
                ]
            ]
        ));
        $data = array(
            'title' => 'Struk Kasir Pembelian Koperasi',
            'rows' => $rows,
        );
        $totalPembelian = 0;
        $total = [];
        foreach ($rows['CooperativeCashDisbursementDetail'] as $detail) {
            $getDiscount = $detail['quantity'] * $detail['amount'] * $detail['discount'] / 100;
            $totalPembelian += ($detail['quantity'] * $detail['amount']) - $getDiscount;
            $total[] = $totalPembelian;
        }
        $totalPembelian = $totalPembelian - ($totalPembelian * $rows['CooperativeCashDisbursement']['discount']);
        $this->set(compact('data', 'totalPembelian', 'total'));
    }

}
