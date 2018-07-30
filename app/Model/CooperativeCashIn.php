<?php

class CooperativeCashIn extends AppModel {

    public $validate = array(
        'amount' => array(
            'rule' => array('comparison', '>', 0),
            'message' => 'Input tidak boleh 0'
        ),
        'cooperative_cash_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),        
    );
    public $belongsTo = array(
        "CooperativeCash",
        "Creator" => [
            "className" => "Employee",
            "foreignKey" => "creator_id"
        ],
        "BranchOffice"
    );
    public $hasOne = array(
        "CooperativeTransactionMutation"
    );
    public $hasMany = array(
    );
    public $virtualFields = array(
    );
    
    function generateNomor($id) {
        $inc_id = 1;
        $m = date('n');
        $mRoman = romanic_number($m);
        $Y = date('Y');
        $testCode = "[0-9]{4}/KMSK-KOP/$mRoman/$Y";
        $lastRecord = $this->find('first', array('conditions' => array("not"=>["CooperativeCashIn.id"=>$id],'and' => array("CooperativeCashIn.cash_in_number regexp" => $testCode)), 'order' => array('CooperativeCashIn.cash_in_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['CooperativeCashIn']['cash_in_number']);
            $inc_id += $current[0];
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/KMSK-KOP/$mRoman/$Y";
        $this->save(["id"=>$id,"cash_in_number"=>$kode]);
    }

}
