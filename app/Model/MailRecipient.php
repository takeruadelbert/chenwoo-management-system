<?php

class MailRecipient extends AppModel {

    var $name = 'MailRecipient';
    var $belongsTo = array(
        "Employee",
        "IncomingMail",
        "Dispositor" => [
            "className" => "Employee",
            "foreignKey" => "dispositor_id",
        ],
        "MailDisposition",
    );
    var $hasOne = array(
        "MailRecipientNotification" => array(
            "dependent" => true
        ),
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

    function flagForward($id = null) {
        if ($this->exists($id)) {
            $this->id = $id;
            $this->data['MailRecipient']['forwarded'] = 1;
            $this->save();
            return true;
        }
        return false;
    }

    function getForward($id = null) {
        $current = $this->find("first", [
            "conditions" => [
                "MailRecipient.id" => $id,
            ],
        ]);
        if (!empty($current)) {
            $next = $this->find("first", [
                "conditions" => [
                    "MailRecipient.incoming_mail_id" => $current['MailRecipient']['incoming_mail_id'],
                    "MailRecipient.seq" => $current['MailRecipient']['seq'] + 1,
                ],
                "contain"=>[
                  "Employee"=>[
                      "Account"=>[
                          "Biodata",
                      ]
                  ]  
                ],
            ]);
            return $next;
        }
        return [];
    }

}

?>
