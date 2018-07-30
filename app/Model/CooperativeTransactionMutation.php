<?php

class CooperativeTransactionMutation extends AppModel {

    public $validate = array(
    );
    public $belongsTo = array(
        "EmployeeDataDeposit",
        "EmployeeDataLoan",
        "CooperativeCashReceipt",
        "CooperativeCashDisbursement",
        "CooperativeTransactionType",
        "Employee",
        "CooperativeCashIn",
        "CooperativeCashOut",
        "CooperativeCashMutation",
        "CooperativeCash",
        "EmployeeDataLoanDetail",
        "SaleProductAdditional",
        "CooperativeItemLoanPayment"
    );
    public $hasOne = array(
    );
    public $hasMany = array(
    );
    public $virtualFields = array(
    );
    public $mapNomor = [
        "PNJU" => "receipt_loan_number",
        "SMPS" => "id_number",
        "SMPT" => "id_number",
        "PMBL" => "cash_disbursement_number",
        "PNJL" => "reference_number",
        "KMSK" => "cash_in_number",
        "KKLR" => "cash_out_number",
        "MTSK" => "id_number",
        "PNJB" => "",
        "ANSR" => "coop_receipt_number",
        "PNJL-PT" => "reference_number", // PNJL-PT => Penjualan Produk Tambahan
        "ANSR-SMBK" => ""
    ];

    public function postProductAdditionalShare($sale_product_additional_id) {
        $amount = 0;
        if (!$this->hasAny(["CooperativeTransactionMutation.sale_product_additional_id" => $sale_product_additional_id])) {
            $saleProductAdditional = ClassRegistry::init("SaleProductAdditional")->find("first", [
                "conditions" => [
                    "SaleProductAdditional.id" => $sale_product_additional_id,
                ],
                "recursive" => -1,
                "contain" => [
                    "SaleProductAdditionalDetail" => [
                        "ProductAdditional",
                    ],
                ],
            ]);
            foreach ($saleProductAdditional["SaleProductAdditionalDetail"] as $saleProductAdditionalDetail) {
                $amount+=$saleProductAdditionalDetail["ProductAdditional"]["default_price"];
            }
            if ($amount > 0) {
                $this->addMutation(12, $sale_product_additional_id, "PNJL-PT", $amount, date("Y-m-d H:i:s"), ClassRegistry::init("CooperativeEntryType")->getIdByCode(111));
            }
        }
        return $amount;
    }

    public function addMutation($cooperativeCashId = null, $relationId = null, $code = null, $nominal = null, $dt = null, $entryType = false) {
        $cooperativeTransactionType = $this->CooperativeTransactionType->find("first", [
            "conditions" => [
                "CooperativeTransactionType.code" => $code,
            ]
        ]);
        $cooperativeCash = ClassRegistry::init("CooperativeCash")->find("first", [
            "conditions" => [
                "CooperativeCash.id" => $cooperativeCashId,
            ]
        ]);
        $balance_before_transaction = $cooperativeCash['CooperativeCash']['nominal'];
        $cooperativeTransactionMutation = [];
        $cooperativeTransactionMutation["CooperativeTransactionMutation"]['employee_id'] = $this->stnAdmin->getEmployeeId();
        $cooperativeTransactionMutation["CooperativeTransactionMutation"]['cooperative_transaction_type_id'] = $cooperativeTransactionType["CooperativeTransactionType"]["id"];
        $cooperativeTransactionMutation["CooperativeTransactionMutation"]['cooperative_cash_id'] = $cooperativeCashId;
        $cooperativeTransactionMutation["CooperativeTransactionMutation"]['nominal'] = $nominal;
        $cooperativeTransactionMutation["CooperativeTransactionMutation"]['transaction_date'] = $dt;
        $cooperativeTransactionMutation["CooperativeTransactionMutation"][Inflector::underscore(Inflector::classify($cooperativeTransactionType["CooperativeTransactionType"]["table_name"])) . "_id"] = $relationId;
        $cooperativeTransactionMutation['CooperativeCash']['id'] = $cooperativeCashId;
        if ($cooperativeTransactionType["CooperativeTransactionType"]["operation"] == "reduction") {
            $cooperativeTransactionMutation['CooperativeCash']['nominal'] = $cooperativeCash['CooperativeCash']['nominal'] - $nominal;
        } else if ($cooperativeTransactionType["CooperativeTransactionType"]["operation"] == "increase") {
            $cooperativeTransactionMutation['CooperativeCash']['nominal'] = $cooperativeCash['CooperativeCash']['nominal'] + $nominal;
        }
        $cooperativeTransactionMutation['CooperativeTransactionMutation']['balance_before_transaction'] = $balance_before_transaction;
        $cooperativeTransactionMutation['CooperativeTransactionMutation']['balance_after_transaction'] = $cooperativeTransactionMutation['CooperativeCash']['nominal'];
        $this->saveAll($cooperativeTransactionMutation);
        $thisId = $this->getLastInsertID();
        $this->generateNomor($thisId);
        ClassRegistry::init("CooperativeEntry")->addManual($entryType, $nominal, $dt, $thisId);
    }

    function generateNomor($id) {
        $inc_id = 1;
        $m = date('n');
        $mRoman = romanic_number($m);
        $Y = date('Y');
        $testCode = "[0-9]{4}/TRNS-KOP/$mRoman/$Y";
        $lastRecord = $this->find('first', array("recursive" => -1, 'conditions' => array("not" => ["CooperativeTransactionMutation.id" => $id], 'and' => array("CooperativeTransactionMutation.id_number regexp" => $testCode)), 'order' => array('CooperativeTransactionMutation.id_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['CooperativeTransactionMutation']['id_number']);
            $inc_id += $current[0];
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/TRNS-KOP/$mRoman/$Y";
        $this->save(["id" => $id, "id_number" => $kode]);
    }

    function _getRelatedModel($type, $listType = "model") {
        if ($type == "jualbeli") {
            $cooperativeTransactionTypes = $this->CooperativeTransactionType->find("all", [
                "conditions" => [
                    "CooperativeTransactionType.code" => ["PMBL", "PNJL"],
                ],
                "recursive" => -1,
            ]);
        } else {
            $cooperativeTransactionTypes = $this->CooperativeTransactionType->find("all", [
                "conditions" => [
                    "CooperativeTransactionType.operation" => $type,
                ],
                "recursive" => -1,
            ]);
        }
        $result = [];
        foreach ($cooperativeTransactionTypes as $cooperativeTransactionType) {
            if (!empty($cooperativeTransactionType["CooperativeTransactionType"]["table_name"])) {
                if ($listType == "model") {
                    $result[Inflector::singularize(Inflector::camelize($cooperativeTransactionType["CooperativeTransactionType"]["table_name"]))] = [
                        "BranchOffice"
                    ];
                } else if ($listType = "code") {
                    $result[$cooperativeTransactionType["CooperativeTransactionType"]["code"]] = Inflector::singularize(Inflector::camelize($cooperativeTransactionType["CooperativeTransactionType"]["table_name"]));
                }
            }
        }
        return $result;
    }

    /*
     * WARNING!!!
     * For general purpose, this function generates the balance before and after the transaction.
     * call this function ONLY when necessary.
     */

    function generate_balance_before_and_after_transaction() {
        $dataCooperativeCash = ClassRegistry::init("CooperativeCash")->find("all", [
            "recursive" => -1
        ]);
        $previous_id;
        foreach ($dataCooperativeCash as $cooperativeCash) {
            $dataCoopTransMutation = $this->find("all", [
                "conditions" => [
                    "CooperativeTransactionMutation.cooperative_cash_id" => $cooperativeCash['CooperativeCash']['id']
                ],
                "contain" => [
                    "CooperativeCash",
                    "CooperativeTransactionType"
                ],
                "order" => "CooperativeTransactionMutation.id DESC"
            ]);
            $updatedData = [];
            if (!empty($dataCoopTransMutation)) {
                foreach ($dataCoopTransMutation as $index => $mutation) {
                    if (empty($mutation['CooperativeTransactionMutation']['balance_before_transaction']) && empty($mutation['CooperativeTransactionMutation']['balance_after_mutation'])) {
                        // get the latest balance of cooperative cash
                        if ($index == 0) {
                            $dataCoopCashLatestBalance = $cooperativeCash['CooperativeCash']['nominal'];
                        } else {
                            $dataCoopTransMutationPrevious = $this->find("first", [
                                "conditions" => [
                                    "CooperativeTransactionMutation.id" => $previous_id
                                ],
                                "recursive" => -1
                            ]);
                            $dataCoopCashLatestBalance = $dataCoopTransMutationPrevious['CooperativeTransactionMutation']['balance_before_transaction'];
                        }

                        // calculate the balance before transaction
                        if ($mutation['CooperativeTransactionType']['operation'] == 'reduction') {
                            $balance_before_transaction = $dataCoopCashLatestBalance + $mutation['CooperativeTransactionMutation']['nominal'];
                        } else {
                            $balance_before_transaction = $dataCoopCashLatestBalance - $mutation['CooperativeTransactionMutation']['nominal'];
                        }

                        $updatedData = [
                            "CooperativeTransactionMutation" => [
                                "id" => $mutation['CooperativeTransactionMutation']['id'],
                                "balance_after_transaction" => $dataCoopCashLatestBalance,
                                "balance_before_transaction" => $balance_before_transaction
                            ]
                        ];
                        // saving the updated data
                        try {
                            $previous_id = $mutation['CooperativeTransactionMutation']['id'];
                            $this->save($updatedData);
                        } catch (Exception $ex) {
                            echo "Error found when saving the data.\n";
                            echo "=========";
                            echo "Verbose";
                            echo "=========";
                            $verbose = [
                                "CooperativeTransactionMutation" => [
                                    "id" => $mutation['CooperativeTransactionMutation']['id'],
                                    "transaction_number" => $mutation['CooperativeTransactionMutation']['id_number'],
                                    "transaction_date" => $mutation['CooperativeTransactionMutation']['transaction_date'],
                                    "cooperative_cash_id" => $mutation['CooperativeTransactionMutation']['cooperative_cash_id'] . " ({$mutation['CooperativeCash']['name']})",
                                    "transaction_type_id" => $mutation['CooperativeTransactionMutation']['cooperative_transaction_type_id'] . " ({$mutation['CooperativeTransactionType']['name']})"
                                ]
                            ];
                            echo $verbose;
                            debug("error");
                            debug($verbose);
                            die;
                        }
                    }
                }
            }
        }
        echo "Successfully Generated the balance.";
        debug("Successfully Generated the balance.");
        die;
    }

}
