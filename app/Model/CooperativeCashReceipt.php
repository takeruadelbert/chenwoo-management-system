<?php

class CooperativeCashReceipt extends AppModel {

    var $name = 'CooperativeCashReceipt';
    var $belongsTo = array(
        "Operator" => [
            "className" => 'Employee',
            "foreignKey" => "operator_id"
        ],
        "CooperativeCash",
        "CooperativePaymentType",
        "BranchOffice"
    );
    var $hasOne = array(
        "CooperativeTransactionMutation",
        "EmployeeDataLoan",
    );
    var $hasMany = array(
        "CooperativeCashReceiptDetail" => array(
            "dependent" => true
        ),        
    );
    var $validate = array(
        'cooperative_cash_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'cooperative_payment_type_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
    );
    var $virtualFields = array(
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }
    
    function generateNomor($id) {
        $inc_id = 1;
        $m = date('n');
        $mRoman = romanic_number($m);
        $Y = date('Y');
        $testCode = "[0-9]{4}/PNJL-KOP/$mRoman/$Y";
        $lastRecord = $this->find('first', array("recursive"=>-1,'conditions' => array("not"=>["CooperativeCashReceipt.id"=>$id],'and' => array("CooperativeCashReceipt.reference_number regexp" => $testCode)), 'order' => array('CooperativeCashReceipt.reference_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['CooperativeCashReceipt']['reference_number']);
            $inc_id += $current[0];
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/PNJL-KOP/$mRoman/$Y";
        $this->save(["id"=>$id,"reference_number"=>$kode]);
    }

}

?>
