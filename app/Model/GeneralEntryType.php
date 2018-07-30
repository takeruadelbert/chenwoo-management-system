<?php

class GeneralEntryType extends AppModel {

    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'code' => array(
            'Harus diisi' => array("rule" => "notEmpty"),
            'Kode Akun Sudah Terdaftar' => array("rule" => 'isUnique'),
        ),
        'currency_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        )
    );
    public $belongsTo = array(
        "Parent" => array(
            "className" => "GeneralEntryType",
            "foreignKey" => "parent_id",
        ),
        "Currency"
    );
    public $hasOne = array(
        "InitialBalance"
    );
    public $virtualFields = array(
    );
    public $hasMany = [
        "Child" => [
            "className" => "GeneralEntryType",
            "foreignKey" => "parent_id",
        ]
    ];

    function closing_book($closing_date, $employee_id, $closing_book_type_id) {
        try {
            /* updating each data from General Entry Type Table */
            $dataGeneralEntryType = ClassRegistry::init("GeneralEntryType")->find("all");
            foreach ($dataGeneralEntryType as $generalEntryType) {
                if($generalEntryType['GeneralEntryType']['id'] != 42) {
                    $updatedData = [];
                    $updatedData['GeneralEntryType']['id'] = $generalEntryType['GeneralEntryType']['id'];
                    $updatedData['GeneralEntryType']['initial_balance'] = 0;
                    $updatedData['GeneralEntryType']['latest_balance'] = $generalEntryType['GeneralEntryType']['initial_balance'];
                    ClassRegistry::init("GeneralEntryType")->saveAll($updatedData);

                    /* posting history to table Closing Book */
                    $dataHistory = [];
                    $dataHistory['ClosingBook']['general_entry_type_id'] = $generalEntryType['GeneralEntryType']['id'];
                    $dataHistory['ClosingBook']['previous_balance'] = $generalEntryType['GeneralEntryType']['initial_balance'];
                    $dataHistory['ClosingBook']['current_balance'] = 0;
                    $dataHistory['ClosingBook']['closing_datetime'] = $closing_date;
                    $dataHistory['ClosingBook']['closing_book_type_id'] = $closing_book_type_id;
                    $dataHistory['ClosingBook']['employee_id'] = $employee_id;
                    ClassRegistry::init("ClosingBook")->saveAll($dataHistory);
                }
            }

            /* updating each data from Initial Balance Table */
            $dataInitialBalance = ClassRegistry::init("InitialBalance")->find("all", ["recursive" => -1]);
            foreach ($dataInitialBalance as $initialBalances) {
                $updatedDataInitialBalance = [];
                $updatedDataInitialBalance['InitialBalance']['id'] = $initialBalances['InitialBalance']['id'];
                $updatedDataInitialBalance['InitialBalance']['initial_amount'] = $initialBalances['InitialBalance']['nominal'];
                ClassRegistry::init("InitialBalance")->saveAll($updatedDataInitialBalance);
            }
            
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    function increaseLatestBalance($general_entry_type_id, $amount) {
        if (!empty($general_entry_type_id)) {
            $dataGeneralEntryType = ClassRegistry::init("GeneralEntryType")->find("first", [
                "conditions" => [
                    "GeneralEntryType.id" => $general_entry_type_id
                ],
                "recursive" => -1
            ]);
            $current_balance = $dataGeneralEntryType['GeneralEntryType']['latest_balance'];
            $mutation_balance = $current_balance + $amount;
            $updatedData = [];
            $updatedData['GeneralEntryType']['id'] = $general_entry_type_id;
            $updatedData['GeneralEntryType']['latest_balance'] = $mutation_balance;
//            debug("increase latest balance");
//            debug($updatedData);
            ClassRegistry::init("GeneralEntryType")->saveAll($updatedData);
        }
    }

    function decreaseLatestBalance($general_entry_type_id, $amount) {
        if (!empty($general_entry_type_id)) {
            $dataGeneralEntryType = ClassRegistry::init("GeneralEntryType")->find("first", [
                "conditions" => [
                    "GeneralEntryType.id" => $general_entry_type_id
                ],
                "recursive" => -1
            ]);
            $current_balance = $dataGeneralEntryType['GeneralEntryType']['latest_balance'];
            $mutation_balance = $current_balance - $amount;
            $updatedData = [];
            $updatedData['GeneralEntryType']['id'] = $general_entry_type_id;
            $updatedData['GeneralEntryType']['latest_balance'] = $mutation_balance;
//            debug("decrease latest balance");
//            debug($updatedData);
            ClassRegistry::init("GeneralEntryType")->saveAll($updatedData);
        }
    }

    function listWithFullLabel($conds = "") {
        $this->virtualFields = [
            "full_label" => "concat(IFNULL(GeneralEntryType.code,''),' ',GeneralEntryType.name)",
        ];
        $generalEntryTypeList = $this->find("list", [
            "fields" => [
                "GeneralEntryType.id",
                "GeneralEntryType.full_label",
                "Parent.name"
            ],
            "contain" => [
                "Parent"
            ],
            "conditions" => $conds
        ]);
        if(!empty($generalEntryTypeList[0])) {
            $generalEntryTypeList['Kategori Utama'] = $generalEntryTypeList[0];
            unset($generalEntryTypeList[0]);
        }
        return $generalEntryTypeList;
    }

}
