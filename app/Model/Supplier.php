<?php

class Supplier extends AppModel {

    var $name = 'Supplier';
    var $belongsTo = array(
        "Country",
        "State",
        "City",
        "Employee",
        'CpCity' => array(
            'className' => 'City',
            'foreignKey' => 'cp_city_id',
        ),
        'CpState' => array(
            'className' => 'State',
            'foreignKey' => 'cp_state_id',
        ),
        'CpCountry' => array(
            'className' => 'Country',
            'foreignKey' => 'cp_country_id',
        ),
        "SupplierType",
        "GeneralEntryType"
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "SupplierFile" => array(
            "dependent" => true,
        ),
        "SupplierBank" => array(
            "dependent" => true,
        ),
        "TransactionEntry" => array(
            "dependent" => true
        )
    );
    var $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'initial' => array(
            'Harus diisi' => 'notEmpty',
            'Sudah terpakai' => 'isUnique'
        ),
    );
    var $virtualFields = array(
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

}

?>
