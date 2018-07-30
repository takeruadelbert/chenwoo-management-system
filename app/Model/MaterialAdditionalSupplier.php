<?php

class MaterialAdditionalSupplier extends AppModel {

    var $name = 'MaterialAdditionalSupplier';
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
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "MaterialAdditionalSupplierBank" => array(
            "dependent" => true,
        ),
        "PurchaseOrderMaterialAdditional" => array(
            "dependent" => true
        )
    );
    var $validate = array(
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
