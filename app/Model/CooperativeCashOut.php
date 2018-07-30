<?php

class CooperativeCashOut extends AppModel {

    public $validate = array(
        'cooperative_cash_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
    );
    public $belongsTo = array(
        "Creator" => [
            "className" => 'Employee',
            "foreignKey" => "creator_id"
        ],
        "CooperativeCash",
        "BranchOffice"
    );
    public $hasOne = array(
        "CooperativeTransactionMutation"
    );
    public $virtualFields = array(
    );
    public $hasMany = array(
        "CooperativeCashOutDetail" => array(
            "dependent" => true
        ),
    );

    function generateNomor($id) {
        $inc_id = 1;
        $m = date('n');
        $mRoman = romanic_number($m);
        $Y = date('Y');
        $testCode = "[0-9]{4}/KKLR-KOP/$mRoman/$Y";
        $lastRecord = $this->find('first', array('conditions' => array("not" => ["CooperativeCashOut.id" => $id], 'and' => array("CooperativeCashOut.cash_out_number regexp" => $testCode)), 'order' => array('CooperativeCashOut.cash_out_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['CooperativeCashOut']['cash_out_number']);
            $inc_id += $current[0];
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/KKLR-KOP/$mRoman/$Y";
        $this->save(["id" => $id, "cash_out_number" => $kode]);
    }

}
