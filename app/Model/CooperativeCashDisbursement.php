<?php

class CooperativeCashDisbursement extends AppModel {

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
        "VerifiedBy" => [
            "className" => 'Employee',
            "foreignKey" => "verified_by_id"
        ],
        "CooperativeCash",
        "VerifyStatus",
        "CooperativeSupplier",
        "AssetFile",
        "BranchOffice"
    );
    public $hasOne = array(
        "CooperativeTransactionMutation"
    );
    public $virtualFields = array(
    );
    public $hasMany = array(
        "CooperativeCashDisbursementDetail" => array(
            "dependent" => true
        ),
    );
    
    function generateNomor($id) {
        $inc_id = 1;
        $m = date('n');
        $mRoman = romanic_number($m);
        $Y = date('Y');
        $testCode = "[0-9]{4}/PMBL-KOP/$mRoman/$Y";
        $lastRecord = $this->find('first', array('conditions' => array("not"=>["CooperativeCashDisbursement.id"=>$id],'and' => array("CooperativeCashDisbursement.cash_disbursement_number regexp" => $testCode)), 'order' => array('CooperativeCashDisbursement.cash_disbursement_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['CooperativeCashDisbursement']['cash_disbursement_number']);
            $inc_id += $current[0];
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/PMBL-KOP/$mRoman/$Y";
        $this->save(["id"=>$id,"cash_disbursement_number"=>$kode]);
    }

}
