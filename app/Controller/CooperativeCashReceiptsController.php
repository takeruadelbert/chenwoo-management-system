<?php

App::uses('AppController', 'Controller');
App::import('Controller', 'EmployeeDataLoans');

class CooperativeCashReceiptsController extends AppController {

    var $name = "CooperativeCashReceipts";
    var $disabledAction = array(
    );
    var $contain = [
        "CooperativeCashReceiptDetail" => [
            "CooperativeGoodList" => [
                "CooperativeGoodListUnit"
            ]
        ],
        "Operator" => [
            "Account" => [
                "Biodata",
            ],
        ],
        "CooperativeCash",
        "CooperativePaymentType",
        "BranchOffice"
    ];
    var $periodeLaporanField = "CooperativeCashReceipt_date";

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

    function _options() {
        $this->set("cooperativeCashes", $this->CooperativeCashReceipt->CooperativeCash->find("list", ["fields" => ["CooperativeCash.id", "CooperativeCash.name"]]));
        $this->set("branchOffices", $this->CooperativeCashReceipt->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("cooperativePaymentTypes", $this->CooperativeCashReceipt->CooperativePaymentType->find("list", ["fields" => ["CooperativePaymentType.id", "CooperativePaymentType.name"]]));
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->CooperativeCashReceipt->_numberSeperatorRemover();
                $this->{ Inflector::classify($this->name) }->data['CooperativeCashReceipt']['branch_office_id'] = $this->stnAdmin->getBranchId();
                $stock_is_available = true; // default
                foreach ($this->data['CooperativeCashReceiptDetail'] as $details) {
                    $dataStock = ClassRegistry::init("CooperativeGoodList")->find("first", [
                        "conditions" => [
                            "CooperativeGoodList.id" => $details['cooperative_good_list_id']
                        ]
                    ]);
                    /* check whether the stock is sufficient or not to be sold */
                    if ($dataStock['CooperativeGoodList']['stock_number'] - $details['quantity'] < 0) {
                        $stock_is_available = false;
                    }
                }
                $cooperativePaymentTypeId = $this->CooperativeCashReceipt->data['CooperativeCashReceipt']['cooperative_payment_type_id'];
                if ($stock_is_available) {
                    if ($this->CooperativeCashReceipt->data['CooperativeCashReceipt']['cooperative_payment_type_id'] == 1) {
                        //move to after save
                    } else if ($this->CooperativeCashReceipt->data['CooperativeCashReceipt']['cooperative_payment_type_id'] == 2) {
                        $totalLoan = $this->CooperativeCashReceipt->data['CooperativeCashReceipt']['grand_total'];
                        $employeeId = $this->data['EmployeeDataLoan']['employee_id'];
                    }
                    unset($this->CooperativeCashReceipt->data["EmployeeDataLoan"]);
                    $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                    $cooperativeCashReceiptId = $this->CooperativeCashReceipt->getLastInsertID();
                    ClassRegistry::init("CooperativeGoodList")->updateByCashReceipt($cooperativeCashReceiptId);
                    $this->CooperativeCashReceipt->generateNomor($cooperativeCashReceiptId);
                    $cooperativeCashReceipt = $this->CooperativeCashReceipt->find("first", [
                        "conditions" => [
                            "CooperativeCashReceipt.id" => $cooperativeCashReceiptId,
                        ],
                        "recursive" => -1
                    ]);
                    $this->CooperativeCashReceipt->data["EmployeeDataLoan"]["cooperative_cash_receipt_id"] = $cooperativeCashReceiptId;
                    $entity = $cooperativeCashReceipt["CooperativeCashReceipt"];
                    if ($cooperativePaymentTypeId == 1) {
                        //tunai
                        ClassRegistry::init("CooperativeTransactionMutation")->addMutation($entity["cooperative_cash_id"], $entity["id"], "PNJL", $entity["grand_total"], $entity["date"], ClassRegistry::init("CooperativeEntryType")->getIdByCode(101));
                    } else if ($cooperativePaymentTypeId == 2) {
                        //kredit
                        ClassRegistry::init("CooperativeItemLoan")->addLoan($employeeId, $totalLoan, $cooperativeCashReceiptId);
                    }
                    $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                    $this->redirect(array('action' => 'admin_add'));
                } else {
                    $this->Session->setFlash(__("Stok Barang Tidak Cukup Untuk Dijual."), 'default', array(), 'danger');
                    $this->redirect(array('action' => 'admin_add'));
                }
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_transaksi_penjualan_koperasi");
        $this->_setPeriodeLaporanDate("awal_CooperativeCashReceipt_date", "akhir_CooperativeCashReceipt_date");
        parent::admin_index();
    }

    function view_data_cooperative_cash_receipt($id) {
        if (!empty($id) && $id != null) {
            $this->autoRender = false;
            $data = ClassRegistry::init("CooperativeCashReceipt")->find("first", [
                "conditions" => [
                    "CooperativeCashReceipt.id" => $id,
                ],
                "contain" => [
                    "Operator" => [
                        "Account" => [
                            "Biodata",
                        ],
                    ],
                    "CooperativeCashReceiptDetail" => [
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

    function admin_reference_number_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "CooperativeCashReceipt.reference_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("CooperativeCashReceipt")->find("all", array(
            "conditions" => [
                $conds,
            ],
            "contain" => [
                "Operator" => [
                    "Account" => [
                        "Biodata"
                    ],
                ],
            ]
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => @$item['CooperativeCashReceipt']['id'],
                    "reference_number" => @$item['CooperativeCashReceipt']['reference_number'],
                    "date" => @$item['CooperativeCashReceipt']['date'],
                    "fullname" => @$item['Operator']['Account']['Biodata']['full_name'],
                ];
            }
        }
        echo json_encode($result);
    }

    function admin_print_cooperative_cash_receipt($id) {
        $this->_activePrint(["print"], "print_cooperative_cash_receipt", "kwitansi_no_kop");
        $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
            'conditions' => array(
                "CooperativeCashReceipt.id" => $id,
            ),
            "contain" => [
                "CooperativeCashReceiptDetail" => [
                    "CooperativeGoodList" => [
                        "CooperativeGoodListUnit"
                    ],
                ],
                "CooperativePaymentType",
                "Operator" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
                "EmployeeDataLoan" => [
                    "Employee" => [
                        "Account" => [
                            "Biodata",
                        ],
                    ],
                ],
            ],
        ));
        $data = array(
            'title' => 'Struk Kasir Penjualan Koperasi',
            'rows' => $rows,
        );
        $totalPenjualan = 0;
        $total = [];
        foreach ($rows['CooperativeCashReceiptDetail'] as $detail) {
            $getDiscount = $detail['quantity'] * $detail['price'] * $detail['discount'] / 100;
            $totalPenjualan += ($detail['quantity'] * $detail['price']) - $getDiscount;
            $total[] = $totalPenjualan;
        }
        $totalPenjualan = $totalPenjualan - ($totalPenjualan * $rows['CooperativeCashReceipt']['discount']);
        $this->set(compact('data', 'totalPenjualan', 'total'));
    }

}
