<?php

class EmployeeDataDeposit extends AppModel {

    public $validate = array(
        'employee_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'cooperative_deposit_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'cooperative_cash_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'amount' => array(
            'rule' => array('comparison', '>', 0),
            'message' => 'Minimal 1',
        ),
        'account_number' => array(
            "rule" => "notEmpty",
            "message" => "Harus Diisi"
        ),
    );
    public $belongsTo = array(
        "Employee",
        "CooperativeCash",
        "VerifiedBy" => [
            "className" => "Employee",
            "foreignKey" => "verified_by_id"
        ],
        "Creator" => [
            "className" => "Employee",
            "foreignKey" => "creator_id",
        ],
        "VerifyStatus",
        "EmployeeBalance",
        "DepositIoType",
        "BranchOffice",
    );
    public $hasOne = array(
        "CooperativeTransactionMutation"
    );
    public $hasMany = array(
    );
    public $virtualFields = array(
        "balance_after" => "case EmployeeDataDeposit.deposit_io_type_id when 1 then EmployeeDataDeposit.amount + EmployeeDataDeposit.deposit_previous_balance when 3 then EmployeeDataDeposit.amount + EmployeeDataDeposit.deposit_previous_balance when 2 then EmployeeDataDeposit.deposit_previous_balance - EmployeeDataDeposit.amount else EmployeeDataDeposit.deposit_previous_balance end",
    );

    function generateNomorBunga($id) {
        $inc_id = 1;
        $m = date('n');
        $mRoman = romanic_number($m);
        $Y = date('Y');
        $testCode = "[0-9]{4}/BNGA-KOP/$mRoman/$Y";
        $lastRecord = $this->find('first', array('conditions' => array("not" => ["EmployeeDataDeposit.id" => $id], 'and' => array("EmployeeDataDeposit.id_number regexp" => $testCode)), 'order' => array('EmployeeDataDeposit.id_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['EmployeeDataDeposit']['id_number']);
            $inc_id += $current[0];
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/BNGA-KOP/$mRoman/$Y";
        $this->save(["id" => $id, "id_number" => $kode]);
    }
    
    function generateNomorSimpanan($id) {
        $inc_id = 1;
        $m = date('n');
        $mRoman = romanic_number($m);
        $Y = date('Y');
        $testCode = "[0-9]{4}/SMPS-KOP/$mRoman/$Y";
        $lastRecord = $this->find('first', array('conditions' => array("not" => ["EmployeeDataDeposit.id" => $id], 'and' => array("EmployeeDataDeposit.id_number regexp" => $testCode)), 'order' => array('EmployeeDataDeposit.id_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['EmployeeDataDeposit']['id_number']);
            $inc_id += $current[0];
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/SMPS-KOP/$mRoman/$Y";
        $this->save(["id" => $id, "id_number" => $kode]);
    }

    function generateNomorPenarikan($id) {
        $inc_id = 1;
        $m = date('n');
        $mRoman = romanic_number($m);
        $Y = date('Y');
        $testCode = "[0-9]{4}/SMPT-KOP/$mRoman/$Y";
        $lastRecord = $this->find('first', array('conditions' => array("not" => ["EmployeeDataDeposit.id" => $id], 'and' => array("EmployeeDataDeposit.id_number regexp" => $testCode)), 'order' => array('EmployeeDataDeposit.id_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['EmployeeDataDeposit']['id_number']);
            $inc_id += $current[0];
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/SMPT-KOP/$mRoman/$Y";
        $this->save(["id" => $id, "id_number" => $kode]);
    }

}
