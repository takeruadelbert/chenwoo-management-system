<?php

class ProductionCommonStatus extends AppModel {

    var $belongsTo = array(
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

    function getList($type = "all") {
        switch ($type) {
            case "conversion":
            case "freezing":
            case "treatment":
            case "materialprocessing":
            case "packaging":
                $cond = [
                    "ProductionCommonStatus.id" => [1, 2]
                ];
                break;
            case "all":
                $cond = [];
                break;
        }
        return $this->find("list", ["fields" => ["ProductionCommonStatus.id", "ProductionCommonStatus.name"], "conditions" => $cond]);
    }

}
