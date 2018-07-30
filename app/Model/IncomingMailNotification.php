<?php

class IncomingMailNotification extends AppModel {

    public $validate = array(
    );
    public $belongsTo = array(
        "IncomingMail",
        "NotificationType",
    );
    public $hasOne = array(
    );
    public $virtualFields = array(
    );

}
