<?php

class CooperativeEntryType extends AppModel {

    public $validate = array(
        'code' => array(
            'rule' => 'isUnique',
            'message' => 'Sudah Terpakai'
        ),
        'category' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
    );
    public $belongsTo = array(
    );
    public $hasOne = array(
    );
    public $hasMany = array(
    );
    public $virtualFields = array(
    );

    public function listCategory() {
        return ["income" => "Income", "outcome" => "Outcome", "netral" => "Netral"];
    }

    public function listByCategory($category = ["income", "outcome", "netral"]) {
        $cooperativeEntryTypes = $this->find("all", [
            "conditions" => [
                "CooperativeEntryType.category" => $category,
            ],
        ]);
        $result = [];
        foreach ($cooperativeEntryTypes as $cooperativeEntryType) {
            $result[$cooperativeEntryType["CooperativeEntryType"]["id"]] = $cooperativeEntryType["CooperativeEntryType"]["name"];
        }
        return $result;
    }

    function getIdByCode($code) {
        $cooperativeEntryType = $this->find("first", [
            "conditions" => [
                "CooperativeEntryType.code" => $code,
            ]
        ]);
        return $cooperativeEntryType["CooperativeEntryType"]["id"];
    }

}
