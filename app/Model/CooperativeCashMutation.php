<?php

class CooperativeCashMutation extends AppModel {

    public $validate = array(
        'nominal' => array(
            'rule' => array('comparison', '>', 0),
            'message' => 'Input tidak boleh 0'
        ),
        'cooperative_cash_transfered_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'cooperative_cash_received_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
    );
    public $belongsTo = array(
        "CooperativeCashTransfered" => [
            "className" => "CooperativeCash",
            "foreignKey" => "cooperative_cash_transfered_id"
        ],
        "CooperativeCashReceived" => [
            "className" => "CooperativeCash",
            "foreignKey" => "cooperative_cash_received_id"
        ],
        "Creator" => [
            "className" => "Employee",
            "foreignKey" => "creator_id"
        ]
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
        $testCode = "[0-9]{4}/MTSK-KOP/$mRoman/$Y";
        $lastRecord = $this->find('first', array('conditions' => array("not"=>["CooperativeCashMutation.id"=>$id],'and' => array("CooperativeCashMutation.id_number regexp" => $testCode)), 'order' => array('CooperativeCashMutation.id_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['CooperativeCashMutation']['id_number']);
            $inc_id += $current[0];
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/MTSK-KOP/$mRoman/$Y";
        $this->save(["id"=>$id,"id_number"=>$kode]);
    }
}
