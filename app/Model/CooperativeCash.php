<?php

class CooperativeCash extends AppModel {

    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'nominal' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'date' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'cash_type_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
    );
    public $belongsTo = array(
        "CashType",
        "CooperativeBankAccount"
    );
    public $hasOne = array(
    );
    public $hasMany = array(
        "EmployeeDataDeposit" => array(
            "dependent" => true
        ),
        "EmployeeDataLoan" => array(
            "dependent" => true
        ),
        "CooperativeCashReceipt" => array(
            "dependent" => true
        ),
        "CooperativeCashDisbursement" => array(
            "dependent" => true
        ),
        "CooperativeCashIn" => [
            "dependent" => true,
        ],
        "CooperativeCashOut" => [
            "dependent" => true,
        ]
    );
    public $virtualFields = array(
    );

    function getListWithFullLabel() {
        $data = $this->find("all", [
            "contain" => [
                "CooperativeBankAccount" => [
                    "BankAccountType",
                ],
            ],
        ]);
        $result = [];
        foreach ($data as $item) {
            if (!empty($item["CooperativeBankAccount"]["id"])) {
                $result[$item["CooperativeCash"]["id"]] = "{$item["CooperativeCash"]["name"]} - {$item["CooperativeBankAccount"]["BankAccountType"]["name"]} ({$item["CooperativeBankAccount"]["code"]})";
            } else {
                $result[$item["CooperativeCash"]["id"]] = "{$item["CooperativeCash"]["name"]}";
            }
        }
        return $result;
    }

}
