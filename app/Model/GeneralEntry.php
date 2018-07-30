<?php

class GeneralEntry extends AppModel {

    var $name = 'GeneralEntry';
    var $belongsTo = array(
        "CashIn",
        "CashDisbursement",
        "PaymentSale",
        "PaymentPurchase",
        "CashMutation",
        "TransactionType",
        "EmployeeSalary",
        "GeneralEntryType",
        "InitialBalance",
        "Sale",
        "GeneralEntryAccountType",
        "PurchaseOrderMaterialAdditional",
        "Shipment",
        "ReturnOrder",
        "DebitInvoiceSale",
        "DebitInvoicePurchaser",
        "AssetProperty",
        "DepreciationAsset",
        "SaleProductAdditional",
        "TransactionEntry",
        "PaymentSaleMaterialAdditional"
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
        "transaction_name" => array(
            "rule" => "notEmpty",
            "message" => "Harus Diisi"
        ),
        "transaction_date" => array(
            "rule" => "notEmpty",
            "message" => "Harus Diisi"
        ),
        "general_entry_type_id" => array(
            "rule" => "notEmpty",
            "message" => "Harus Dipilih"
        ),
        "transaction_type_id" => array(
            "rule" => "notEmpty",
            "message" => "Harus Dipilih"
        ),
        "general_entry_account_type_id" => array(
            "rule" => "notEmpty",
            "message" => "Harus Dipilih"
        ),
        "exchange_rate" => array(
            'rule' => array('comparison', '>', 0),
            'message' => 'Input tidak boleh 0'
        )
    );
    var $virtualFields = array(
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }
    
    function post_to_journal($reference_number, $transaction_names, $debits_or_credits, $transaction_date, $transaction_type_id, $general_entry_type_ids, 
            $amounts, $general_entry_account_type_id, $relation_table_name = null, $relation_table_id = null, $initial_balance_id = null, 
            $initial_balance = null, $mutation_balance = null) {
        $dataJournal = [];
        if( (count($transaction_names) == count($debits_or_credits) ) && count($debits_or_credits) == count($general_entry_type_ids) && (count($general_entry_type_ids) == count($amounts)) ) {
            foreach ($debits_or_credits as $index => $transactions) {
                $dataJournal['GeneralEntry'][$index]['reference_number'] = $reference_number;
                $dataJournal['GeneralEntry'][$index]['transaction_name'] = $transaction_names[$index];
                $dataJournal['GeneralEntry'][$index]['transaction_date'] = $transaction_date;
                $dataJournal['GeneralEntry'][$index]['transaction_type_id'] = $transaction_type_id;
                $dataJournal['GeneralEntry'][$index]['general_entry_type_id'] = $general_entry_type_ids[$index];
                if(strtolower($transactions) == "debit") {
                    $dataJournal['GeneralEntry'][$index]['debit'] = $amounts[$index];
                } else {
                    $dataJournal['GeneralEntry'][$index]['credit'] = $amounts[$index];
                }
                $dataJournal['GeneralEntry'][$index]['initial_balance_id'] = $initial_balance_id;
                $dataJournal['GeneralEntry'][$index]['initial_balance'] = $initial_balance;
                $dataJournal['GeneralEntry'][$index]['mutation_balance'] = $mutation_balance;
                $dataJournal['GeneralEntry'][$index]['general_entry_account_type_id'] = $general_entry_account_type_id;
                if(!empty($relation_table_name) && !empty($relation_table_id)) {
                    $dataJournal['GeneralEntry'][$index][$relation_table_name] = $relation_table_id;
                }
            }
//            debug("general entry");
//            debug($dataJournal);
            foreach ($dataJournal as $journals) {
                ClassRegistry::init("GeneralEntry")->saveAll($journals);
            }
        } else {
            debug("error");
            die;
            echo "Found error when posting the transaction to the journal.";
        }
    }
}
?>