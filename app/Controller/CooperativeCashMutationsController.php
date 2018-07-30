<?php

App::uses('AppController', 'Controller');

class CooperativeCashMutationsController extends AppController {

    var $name = "CooperativeCashMutations";
    var $disabledAction = array(
    );
    var $contain = [
        "CooperativeCashTransfered" => [
            "CashType",
            "CooperativeBankAccount" => [
                "BankAccountType"
            ]
        ],
        "CooperativeCashReceived" => [
            "CashType",
            "CooperativeBankAccount" => [
                "BankAccountType"
            ]
        ],
        "Creator" => [
            "Account" => [
                "Biodata"
            ]
        ]
    ];

    function _options() {
        $this->set("cooperativeCashs", ClassRegistry::init("CooperativeCash")->getListWithFullLabel());
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_mutasi_kas_koperasi");
        $conds = [];
        if (isset($this->request->query)) {
            if (!empty($this->request->query['start_date'])) {
                $startDate = $this->request->query['start_date'];
                $newStartDate = date("Y-m-d H:i:s", strtotime($startDate));
                $conds[] = [
                    "DATE_FORMAT(CooperativeCashMutation.transfer_date, '%Y-%m-%d %H:%i:%s') >=" => $newStartDate
                ];
                unset($_GET['start_date']);
            }

            if (!empty($this->request->query['end_date'])) {
                $endDate = $this->request->query['end_date'];
                $newEndDate = date("Y-m-d H:i:s", strtotime($endDate));
                $conds[] = [
                    "DATE_FORMAT(CooperativeCashMutation.transfer_date, '%Y-%m-%d %H:%i:%s') <=" => $newEndDate
                ];
                unset($_GET['end_date']);
            }
        }
        $this->conds = [
            $conds
        ];
        $this->set(compact("startDate", "endDate"));
        parent::admin_index();
    }

    function view_cash_mutation($id = null) {
        if ($this->CooperativeCashMutation->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->CooperativeCashMutation->find("first", [
                    "conditions" => [
                        "CooperativeCashMutation.id" => $id
                    ],
                    "contain" => [
                        "CooperativeCashTransfered" => [
                            "CooperativeBankAccount" => [
                                "BankAccountType"
                            ]
                        ],
                        "CooperativeCashReceived" => [
                            "CooperativeBankAccount" => [
                                "BankAccountType"
                            ]
                        ],
                        "Creator" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Department",
                            "Office"
                        ]
                    ]
                ]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->CooperativeCashMutation->_numberSeperatorRemover();

                /* Update transfered cash balance */
                $dataCooperativeCash = ClassRegistry::init("CooperativeCash")->find("first", [
                    "conditions" => [
                        "CooperativeCash.id" => $this->data['CooperativeCashMutation']['cooperative_cash_transfered_id'],
                    ]
                ]);
                $dataUpdatedCoopCash = [];
                $dataUpdatedCoopCash['CooperativeCash']['id'] = $this->data['CooperativeCashMutation']['cooperative_cash_transfered_id'];
                $dataUpdatedCoopCash['CooperativeCash']['nominal'] = $dataCooperativeCash['CooperativeCash']['nominal'] - $this->CooperativeCashMutation->data['CooperativeCashMutation']['nominal'];
                ClassRegistry::init("CooperativeCash")->save($dataUpdatedCoopCash);

                /* update recevied cash balance */
                $dataReceivedCash = ClassRegistry::init("CooperativeCash")->find("first", [
                    "conditions" => [
                        "CooperativeCash.id" => $this->data['CooperativeCashMutation']['cooperative_cash_received_id']
                    ]
                ]);
                $dataReceivedCashUpdated = [];
                $dataReceivedCashUpdated['CooperativeCash']['id'] = $this->data['CooperativeCashMutation']['cooperative_cash_received_id'];
                $dataReceivedCashUpdated['CooperativeCash']['nominal'] = $dataReceivedCash['CooperativeCash']['nominal'] + $this->CooperativeCashMutation->data['CooperativeCashMutation']['nominal'];
                ClassRegistry::init("CooperativeCash")->save($dataReceivedCashUpdated);

                /* adding to the Cooperative Transaction Mutation Table */
                $this->CooperativeCashMutation->data['CooperativeTransactionMutation']['employee_id'] = $this->data['CooperativeCashMutation']['creator_id'];
                $this->CooperativeCashMutation->data['CooperativeTransactionMutation']['cooperative_transaction_type_id'] = 8;
                $this->CooperativeCashMutation->data['CooperativeTransactionMutation']['nominal'] = $this->CooperativeCashMutation->data['CooperativeCashMutation']['nominal'];
                $this->CooperativeCashMutation->data['CooperativeTransactionMutation']['transaction_date'] = $this->data['CooperativeCashMutation']['transfer_date'];

                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->{ Inflector::classify($this->name) }->generateNomor($this->{ Inflector::classify($this->name) }->getLastInsertID());
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

}
