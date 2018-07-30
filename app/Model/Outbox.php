<?php

class Outbox extends AppModel {

    public $useDbConfig = 'gammu';
    public $useTable = 'outbox';
    var $name = 'Outbox';
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

    function deleteData($id = null) {
        return $this->delete($id);
    }

    function sendMessage($message = "", $destiniation = "") {
        if (is_array($destiniation)) {
            foreach ($destiniation as $number) {
                $this->saveAll([
                    "Outbox" => [
                        "TextDecoded" => $message,
                        "DestinationNumber" => $number,
                        "CreatorID" => "Gammu 1.34.0",
                    ]
                ]);
            }
        } else if (is_string($destiniation)) {
            $this->saveAll([
                "Outbox" => [
                    "TextDecoded" => $message,
                    "DestinationNumber" => $destiniation,
                    "CreatorID" => "Gammu 1.34.0",
                ]
            ]);
        }
    }

}

?>
