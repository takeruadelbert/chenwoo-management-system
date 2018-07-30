<?php

class TransactionEntry extends AppModel {

    var $name = 'TransactionEntry';
    var $belongsTo = array(
        "Supplier",
        "Employee",
        "MaterialEntry",
        "MaterialCategory",
        "BranchOffice",
        "TransactionEntryStatus",
        "DocumentStatus"
    );
    var $hasOne = array(
        "TransactionMutation"
    );
    var $hasMany = array(
        "TransactionMaterialEntry" => array(
            "dependent" => true
        ),
        "PaymentPurchase" => array(
            "dependent" => true
        ),
        "TransactionEntryFile" => array(
            "dependent" => true
        ),
        "GeneralEntry" => array(
            "dependent" => true
        )
    );
    var $validate = array(
        "supplier_id" => [
            'rule' => 'notEmpty',
            'message' => 'Harus Dipilih!'
        ],
    );
    var $virtualFields = array(
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }
    
    function generateTransactionEntryNumber() {        
        $inc_id = 1;
        $m = date('n');
        $mRoman = romanic_number($m);
        $Y = date('Y');
        $testCode = "[0-9]{4}/PMBI-KSR/$mRoman/$Y";
        $lastRecord = $this->find('first', array('conditions' => array('and' => array("TransactionEntry.transaction_number regexp" => $testCode)), 'order' => array('TransactionEntry.transaction_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['TransactionEntry']['transaction_number']);
            $inc_id += $current[0];
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/PMBI-KSR/$mRoman/$Y";
        return $kode;        
    }
}
?>
