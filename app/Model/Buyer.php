<?php

class Buyer extends AppModel {

    var $name = 'Buyer';
    public $belongsTo = array(
        "BuyerType",
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
    );
    public $validate = array(
        'company_name' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'company_uniq_name' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "BuyerBank" => array(
            "dependent" => true,
        )
    );
    var $virtualFields = array(
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

}
