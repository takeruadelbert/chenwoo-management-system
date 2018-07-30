<?php

class TransactionMutation extends AppModel {

    var $name = 'TransactionMutation';
    var $belongsTo = array(
        "CashIn",
        "CashDisbursement",
        "PaymentSale",
        "PaymentPurchase",
        "CashMutation",
        "TransactionType",
        "EmployeeSalary",
        "InitialBalance",
        "PurchaseOrderMaterialAdditional",
        "Shipment",
        "ReturnOrder",
        "DebitInvoiceSale",
        "DebitInvoicePurchaser",
        "AssetProperty",
        "SaleProductAdditional",
        "PaymentSaleMaterialAdditional",
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
    );
    var $virtualFields = array(
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }
    
    function post_transaction($reference_number, $transaction_name, $transcation_date, $transaction_type_id, $debit_or_credit_type , $amount, 
            $relation_table_name = null, $relation_table_id = null, $initial_balance_id = null, $initial_balance = null, $mutation_balance = null) {
        $dataTransaction = [];
        $dataTransaction['TransactionMutation']['reference_number'] = $reference_number;
        $dataTransaction['TransactionMutation']['transaction_name'] = $transaction_name;
        $dataTransaction['TransactionMutation']['transaction_date'] = $transcation_date;
        $dataTransaction['TransactionMutation']['transaction_type_id'] = $transaction_type_id;
        if(strtolower($debit_or_credit_type) == 'debit') {
            $dataTransaction['TransactionMutation']['debit'] = $amount;
        } else {
            $dataTransaction['TransactionMutation']['credit'] = $amount;
        }
        $dataTransaction['TransactionMutation']['initial_balance_id'] = $initial_balance_id;
        $dataTransaction['TransactionMutation']['initial_balance'] = $initial_balance;
        $dataTransaction['TransactionMutation']['mutation_balance'] = $mutation_balance;
        if(!empty($relation_table_name)) {
            $dataTransaction['TransactionMutation'][$relation_table_name] = $relation_table_id;
        }
//        debug("Transaction Mutation");
//        debug($dataTransaction);
        ClassRegistry::init("TransactionMutation")->saveAll($dataTransaction);
    }

}

?>
