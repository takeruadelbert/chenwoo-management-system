<?php

class EmployeeSalarySaleProductAdditional extends AppModel {

    var $belongsTo = array(
        "EmployeeSalary",
        "SaleProductAdditional",
    );
    var $hasOne = array(
    );
    var $hasMany = array(
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
