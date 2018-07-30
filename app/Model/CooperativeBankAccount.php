<?php

class CooperativeBankAccount extends AppModel {

    public $validate = array(
        'code' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'on_behalf' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'bank_account_type_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
    );
    public $belongsTo = array(
        "BankAccountType"
    );
    public $hasOne = array(
        "CooperativeCash",
    );
    public $virtualFields = array(
    );

    function listFullLabel($all = true) {
        $this->virtualFields = [
            "full_label" => "concat(BankAccountType.name,' - ',CooperativeBankAccount.code,' (',CooperativeBankAccount.on_behalf,')')",
        ];
        if ($all) {
            $conds = [];
        } else {
            $conds = [
                "CooperativeCash.id" => null,
            ];
        }
        return $this->find("list", [
                    "fields" => [
                        "CooperativeBankAccount.id",
                        "CooperativeBankAccount.full_label",
                    ],
                    "contain" => [
                        "BankAccountType",
                        "CooperativeCash",
                    ],
                    "conditions" => [
                        $conds,
                    ],
        ]);
    }
    
    
    public function listFullData(){
        $data=$this->find("all");
        $result=[];
        foreach($data as $item){
            $result[$item["CooperativeBankAccount"]["id"]]=[
                "no_rekening"=>$item["CooperativeBankAccount"]["code"],
                "atas_nama"=>$item["CooperativeBankAccount"]["on_behalf"],
            ];
        }
        return $result;
    }

}
