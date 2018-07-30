<?php

App::uses('AppController', 'Controller');

class SaleProductAdditionalsController extends AppController {

    var $name = "SaleProductAdditionals";
    var $disabledAction = array(
    );
    var $contain = [
//        "InitialBalance" => [
//            "GeneralEntryType"
//        ],
//        "CooperativeCash",
        "Employee" => [
            "Account" => [
                "Biodata"
            ]
        ],
        "Purchaser" => [
            "Account" => [
                "Biodata"
            ]
        ],
        "PaymentStatus",
        "PaymentType"
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_sale_product_additional");
        $this->_setPeriodeLaporanDate("awal_SaleProductAdditional_sale_date", "akhir_SaleProductAdditional_sale_date");
        parent::admin_index();
    }

    function _options() {
        $this->set("initialBalances", $this->SaleProductAdditional->InitialBalance->find("list", [
                    "fields" => [
                        "InitialBalance.id",
                        "GeneralEntryType.name"
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ],
                    "conditions" => [
                        "InitialBalance.currency_id" => 1
                    ]
        ]));
//        $this->set("cooperativeCashes", $this->SaleProductAdditional->CooperativeCash->find("list",["fields" => ["CooperativeCash.id", "CooperativeCash.name"]]));
        $this->set("productAdditionals", $this->SaleProductAdditional->SaleProductAdditionalDetail->ProductAdditional->find("list", ["fields" => ["ProductAdditional.id", "ProductAdditional.name"]]));
        $this->set("paymentTypes", ClassRegistry::init("PaymentType")->find("list", ["fields" => ["PaymentType.id", "PaymentType.name"]]));
        $this->set("paymentStatuses", ClassRegistry::init("PaymentStatus")->find("list", ["fields" => ["PaymentStatus.id", "PaymentStatus.name"]]));
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->SaleProductAdditional->_numberSeperatorRemover();
                $reference_number = $this->generateReferenceNumber();
                $nominal = $this->SaleProductAdditional->data['SaleProductAdditional']['grand_total'];
                $initial_balance_id = $this->data['SaleProductAdditional']['initial_balance_id'];
                $payment_type_id = $this->data['SaleProductAdditional']['payment_type_id'];
                if ($payment_type_id == 2) {
                    $this->SaleProductAdditional->data['SaleProductAdditional']['payment_status_id'] = 3;
                }
                $this->SaleProductAdditional->data['SaleProductAdditional']['reference_number'] = $reference_number;
                $this->SaleProductAdditional->data['SaleProductAdditional']['branch_office_id'] = $this->_getBranchId();

                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));

                if ($payment_type_id == 2) {
                    $dataInitialBalance = ClassRegistry::init("InitialBalance")->find("first", [
                        "conditions" => [
                            "InitialBalance.id" => $initial_balance_id
                        ]
                    ]);

                    // update amount of initial balance
                    $updatedInitialBalance = [];
                    $updatedInitialBalance['InitialBalance']['id'] = $initial_balance_id;
                    $mutation_balance = $dataInitialBalance['InitialBalance']['nominal'] + $nominal;
                    $updatedInitialBalance['InitialBalance']['nominal'] = $mutation_balance;
                    ClassRegistry::init("InitialBalance")->saveAll($updatedInitialBalance);
//                    
                    // update amount of general entry type
                    ClassRegistry::init("GeneralEntryType")->increaseLatestBalance($dataInitialBalance['GeneralEntryType']['id'], $nominal);

                    // post transaction to Transaction Mutation Table
                    $transaction_name = "Penjualan Produk Tambahan";
                    $transaction_type_id = 3; // transaksi penjualan
                    $debit_or_credit_type = "debit";
                    $relation_table_name = "sale_product_additional_id";
                    $relation_table_id = $this->SaleProductAdditional->getLastInsertID();
                    $initial_balance = $dataInitialBalance['InitialBalance']['nominal'];
                    $transaction_date = date("Y-m-d");
                    ClassRegistry::init("TransactionMutation")->post_transaction($reference_number, $transaction_name, $transaction_date, $transaction_type_id, $debit_or_credit_type, $nominal, $relation_table_name, $relation_table_id, $initial_balance_id, $initial_balance, $mutation_balance);

                    // post to General Entry Table
                    $transaction_names = [$dataInitialBalance['GeneralEntryType']['name'], "Penjualan Produk Tambahan"];
                    $debit_or_credits = ["debit", "credit"];
                    $general_entry_type_ids = [$dataInitialBalance['GeneralEntryType']['id'], 9];
                    $general_entry_account_type_id = 2;
                    $amounts = [$nominal, $nominal];

                    ClassRegistry::init("GeneralEntry")->post_to_journal($reference_number, $transaction_names, $debit_or_credits, $transaction_date, $transaction_type_id, $general_entry_type_ids, $amounts, $general_entry_account_type_id, $relation_table_name, $relation_table_id, $initial_balance_id, $initial_balance, $mutation_balance);
                }

                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function generateReferenceNumber() {
        $month = romanic_number(date("n"));
        $year = date("Y");
        $temp = "/$month/$year/";
        $dataSale = $this->SaleProductAdditional->find("first", [
            "order" => "SaleProductAdditional.id DESC"
        ]);
        if (!empty($dataSale)) {
            $dataCodeNumber = $dataSale['SaleProductAdditional']['reference_number'];
            $temp = explode("/", $dataCodeNumber);
            $inc_id = intval($temp[0] + 1);
        } else {
            $inc_id = 1;
        }
        $no_id = sprintf("%04d", $inc_id);
        $code = "$no_id/SALE-PRO-ADD/$month/$year";
        return $code;
    }

    function admin_export_mixed_data_sale_product_additional() {
        $this->autoRender = false;
        // fetch all back-up data from server on July 2nd 2018
        $data_sale_product_additional = ClassRegistry::init("SaleProductAdditional")->find("all", [
            "contain" => [
                "SaleProductAdditionalDetail"
            ]
        ]);
        $values = "";
        $values_detail = "";
        $increment_ids = 1;
        $increment_detail_ids = 1;
        if (!empty($data_sale_product_additional)) {
            foreach ($data_sale_product_additional as $i => $sale_product_additional) {
                $sale_product_additional_id = !empty($sale_product_additional['SaleProductAdditional']['id']) ? $sale_product_additional['SaleProductAdditional']['id'] : 'NULL';
                $payment_status_id = !empty($sale_product_additional['SaleProductAdditional']['payment_status_id']) ? $sale_product_additional['SaleProductAdditional']['payment_status_id'] : 'NULL';
                $reference_number = !empty($sale_product_additional['SaleProductAdditional']['reference_number']) ? $sale_product_additional['SaleProductAdditional']['reference_number'] : 'NULL';
                $cooperative_cash_id = !empty($sale_product_additional['SaleProductAdditional']['cooperative_cash_id']) ? $sale_product_additional['SaleProductAdditional']['cooperative_cash_id'] : 'NULL';
                $initial_balance_id = !empty($sale_product_additional['SaleProductAdditional']['cooperative_cash_id']) ? $sale_product_additional['SaleProductAdditional']['cooperative_cash_id'] : 'NULL';
                $employee_id = !empty($sale_product_additional['SaleProductAdditional']['employee_id']) ? $sale_product_additional['SaleProductAdditional']['employee_id'] : 'NULL';
                $grand_total = !empty($sale_product_additional['SaleProductAdditional']['grand_total']) ? $sale_product_additional['SaleProductAdditional']['grand_total'] : 'NULL';
                $purchaser_id = !empty($sale_product_additional['SaleProductAdditional']['purchaser_id']) ? $sale_product_additional['SaleProductAdditional']['purchaser_id'] : 'NULL';
                $branch_office_id = !empty($sale_product_additional['SaleProductAdditional']['branch_office_id']) ? $sale_product_additional['SaleProductAdditional']['branch_office_id'] : 'NULL';
                $payment_type_id = !empty($sale_product_additional['SaleProductAdditional']['payment_type_id']) ? $sale_product_additional['SaleProductAdditional']['payment_type_id'] : 'NULL';
                $sale_date = !empty($sale_product_additional['SaleProductAdditional']['sale_date']) ? $sale_product_additional['SaleProductAdditional']['sale_date'] : 'NULL';
                $created = !empty($sale_product_additional['SaleProductAdditional']['created']) ? $sale_product_additional['SaleProductAdditional']['created'] : 'NULL';
                $modified = !empty($sale_product_additional['SaleProductAdditional']['modified']) ? $sale_product_additional['SaleProductAdditional']['modified'] : 'NULL';
                $is_deleted = 0;
                $deleted_date = !empty($sale_product_additional['SaleProductAdditional']['deleted_date']) ? $sale_product_additional['SaleProductAdditional']['deleted_date'] : 'NULL';

                // process the sale product additional detail
                if (!empty($sale_product_additional['SaleProductAdditionalDetail'])) {
                    foreach ($sale_product_additional['SaleProductAdditionalDetail'] as $j => $sale_product_additional_detail) {
                        $sale_product_additional_detail_id = !empty($sale_product_additional_detail['id']) ? $sale_product_additional_detail['id'] : 'NULL';
                        $sale_prod_add_id = !empty($sale_product_additional_detail['sale_product_additional_id']) ? $sale_product_additional_detail['sale_product_additional_id'] : 'NULL';
                        $product_additional_id = !empty($sale_product_additional_detail['product_additional_id']) ? $sale_product_additional_detail['product_additional_id'] : 'NULL';
                        $nominal = !empty($sale_product_additional_detail['nominal']) ? $sale_product_additional_detail['nominal'] : 'NULL';
                        $weight = !empty($sale_product_additional_detail['weight']) ? $sale_product_additional_detail['weight'] : 'NULL';
                        $created_detail = !empty($sale_product_additional_detail['created']) ? $sale_product_additional_detail['created'] : 'NULL';
                        $modified_detail = !empty($sale_product_additional_detail['modified']) ? $sale_product_additional_detail['modified'] : 'NULL';
                        $is_deleted_detail = 0;
                        $deleted_date_detail = !empty($sale_product_additional_detail['deleted_date']) ? $sale_product_additional_detail['deleted_date'] : 'NULL';
                        $values_detail .= "($sale_product_additional_detail_id, $sale_prod_add_id, $product_additional_id, $nominal, $weight, '$created_detail', '$modified_detail', $is_deleted_detail, '$deleted_date_detail'),\n";
                        $increment_detail_ids++;
                    }
                }
                $values .= "($sale_product_additional_id, $payment_status_id, '$reference_number', $cooperative_cash_id, $initial_balance_id, $employee_id, $grand_total, $purchaser_id, $branch_office_id, $payment_type_id, '$sale_date', '$created', '$modified', $is_deleted, '$deleted_date'),\n";
                $increment_ids++;
            }
        }

        // fetch all recent data from server
        $data_sale_product_additional_from_server = ClassRegistry::init("SaleProductAdditionalFromServer")->find("all", ['contain' => ['SaleProductAdditionalDetailFromServer']]);
        if (!empty($data_sale_product_additional_from_server)) {
            foreach ($data_sale_product_additional_from_server as $i => $sale_product_additional_from_server) {
                $payment_status_id = !empty($sale_product_additional_from_server['SaleProductAdditionalFromServer']['payment_status_id']) ? $sale_product_additional_from_server['SaleProductAdditionalFromServer']['payment_status_id'] : 'NULL';
                $reference_number = !empty($sale_product_additional_from_server['SaleProductAdditionalFromServer']['reference_number']) ? $sale_product_additional_from_server['SaleProductAdditionalFromServer']['reference_number'] : 'NULL';
                $cooperative_cash_id = !empty($sale_product_additional_from_server['SaleProductAdditionalFromServer']['cooperative_cash_id']) ? $sale_product_additional_from_server['SaleProductAdditionalFromServer']['cooperative_cash_id'] : 'NULL';
                $initial_balance_id = !empty($sale_product_additional_from_server['SaleProductAdditionalFromServer']['cooperative_cash_id']) ? $sale_product_additional_from_server['SaleProductAdditionalFromServer']['cooperative_cash_id'] : 'NULL';
                $employee_id = !empty($sale_product_additional_from_server['SaleProductAdditionalFromServer']['employee_id']) ? $sale_product_additional_from_server['SaleProductAdditionalFromServer']['employee_id'] : 'NULL';
                $grand_total = !empty($sale_product_additional_from_server['SaleProductAdditionalFromServer']['grand_total']) ? $sale_product_additional_from_server['SaleProductAdditionalFromServer']['grand_total'] : 'NULL';
                $purchaser_id = !empty($sale_product_additional_from_server['SaleProductAdditionalFromServer']['purchaser_id']) ? $sale_product_additional_from_server['SaleProductAdditionalFromServer']['purchaser_id'] : 'NULL';
                $branch_office_id = !empty($sale_product_additional_from_server['SaleProductAdditionalFromServer']['branch_office_id']) ? $sale_product_additional_from_server['SaleProductAdditionalFromServer']['branch_office_id'] : 'NULL';
                $payment_type_id = !empty($sale_product_additional_from_server['SaleProductAdditionalFromServer']['payment_type_id']) ? $sale_product_additional_from_server['SaleProductAdditionalFromServer']['payment_type_id'] : 'NULL';
                $sale_date = !empty($sale_product_additional_from_server['SaleProductAdditionalFromServer']['sale_date']) ? $sale_product_additional_from_server['SaleProductAdditionalFromServer']['sale_date'] : 'NULL';
                $created = !empty($sale_product_additional_from_server['SaleProductAdditionalFromServer']['created']) ? $sale_product_additional_from_server['SaleProductAdditionalFromServer']['created'] : 'NULL';
                $modified = !empty($sale_product_additional_from_server['SaleProductAdditionalFromServer']['modified']) ? $sale_product_additional_from_server['SaleProductAdditionalFromServer']['modified'] : 'NULL';
                $is_deleted = 0;
                $deleted_date = !empty($sale_product_additional_from_server['SaleProductAdditionalFromServer']['deleted_date']) ? $sale_product_additional_from_server['SaleProductAdditionalFromServer']['deleted_date'] : 'NULL';

                // process the sale product additional detail from server
                if (!empty($sale_product_additional_from_server['SaleProductAdditionalDetailFromServer'])) {
                    foreach ($sale_product_additional_from_server['SaleProductAdditionalDetailFromServer'] as $j => $sale_product_additional_detail_from_server) {
                        $sale_product_additional_detail_id = $increment_detail_ids;
                        $sale_prod_add_id = $increment_ids;
                        $product_additional_id = !empty($sale_product_additional_detail_from_server['product_additional_id']) ? $sale_product_additional_detail_from_server['product_additional_id'] : 'NULL';
                        $nominal = !empty($sale_product_additional_detail_from_server['nominal']) ? $sale_product_additional_detail_from_server['nominal'] : 'NULL';
                        $weight = !empty($sale_product_additional_detail_from_server['weight']) ? $sale_product_additional_detail_from_server['weight'] : 'NULL';
                        $created_detail = !empty($sale_product_additional_detail_from_server['created']) ? $sale_product_additional_detail_from_server['created'] : 'NULL';
                        $modified_detail = !empty($sale_product_additional_detail_from_server['modified']) ? $sale_product_additional_detail_from_server['modified'] : 'NULL';
                        $is_deleted_detail = 0;
                        $deleted_date_detail = !empty($sale_product_additional_detail_from_server['deleted_date']) ? $sale_product_additional_detail_from_server['deleted_date'] : 'NULL';
                        $values_detail .= "($sale_product_additional_detail_id, $sale_prod_add_id, $product_additional_id, $nominal, $weight, '$created_detail', '$modified_detail', $is_deleted_detail, '$deleted_date_detail')";
                        $values_detail .= $i == count($data_sale_product_additional_from_server)-1 && $j == count($sale_product_additional_from_server['SaleProductAdditionalDetailFromServer']) - 1 ? ";" : ",\n";
                        $increment_detail_ids++;
                    }
                }
                $values .= "($increment_ids, $payment_status_id, '$reference_number', $cooperative_cash_id, $initial_balance_id, $employee_id, $grand_total, $purchaser_id, $branch_office_id, $payment_type_id, '$sale_date', '$created', '$modified', $is_deleted, '$deleted_date')";
                $values .= $i != count($data_sale_product_additional_from_server) - 1 ? ",\n" : ";";
                $increment_ids++;
            }
        }
        $script = "INSERT INTO `sale_product_additionals` (`id`, `payment_status_id`, `reference_number`, `cooperative_cash_id`, `initial_balance_id`, `employee_id`, `grand_total`, `purchaser_id`, `branch_office_id`, `payment_type_id`, `sale_date`, `created`, `modified`, `is_deleted`, `deleted_date`) VALUES\n" . $values;
        $script_sale_add_pro_detail = "INSERT INTO `sale_product_additional_details` (`id`, `sale_product_additional_id`, `product_additional_id`, `nominal`, `weight`, `created`, `modified`, `is_deleted`, `deleted_date`) VALUES\n" . $values_detail;

        /*
         *  generate a sql file
         *  generated file location : webroot/files/
         */
        $file_name = "data-sale-product-additional.sql";
        $file_name_sale_add_pro_detail = "data-sale-product-additional-detail.sql";
        try {
            // export sql script of Sale Product Additional
            $fp = fopen("files" . DS . $file_name, "wb");
            fwrite($fp, $script);
            fclose($fp);
            
            // export sql script of Sale Product Additional Detail
            $fp = fopen("files" . DS . $file_name_sale_add_pro_detail, "wb");
            fwrite($fp, $script_sale_add_pro_detail);
            fclose($fp);
            
            // zip files and auto download the files
            $files = ["files/$file_name", "files/$file_name_sale_add_pro_detail"];
            $path_to_zip = "files/data-sale-product-additional-and-detail.zip";
            $this->file_to_zip($path_to_zip, $files);
            $file_url = Router::url("/{$path_to_zip}", true);
            $this->auto_download_file($file_url);
            
            echo "a SQL file has been successfully generated and exported!";
        } catch (Exception $ex) {
            echo $ex;
            debug($ex);
            die;
        }
    }

}
