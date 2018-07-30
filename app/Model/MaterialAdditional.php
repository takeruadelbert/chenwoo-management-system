<?php

class MaterialAdditional extends AppModel {

    var $name = 'MaterialAdditional';
    var $belongsTo = array(
        'MaterialAdditionalCategory',
        "MaterialAdditionalUnit",
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
    );
    var $virtualFields = array(
        //"full_label" => "concat(name,(if (size='','',(concat(' (',size,')')))))",
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }
    
//    function listWithFullLabel() {
//        $materialAdditionallist = $this->find("list", [
//            "fields" => [
//                "MaterialAdditional.id",
//                "MaterialAdditional.full_label",
//            ],
//            "recursive"=>-1,
//        ]);
//        asort($materialAdditionallist);
//        return $materialAdditionallist;
//    }

}

?>
