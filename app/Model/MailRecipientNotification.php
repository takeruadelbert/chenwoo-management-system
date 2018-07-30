<?php

class MailRecipientNotification extends AppModel {

    public $validate = array(
    );
    public $belongsTo = array(
        "MailRecipient",
        "NotificationType",
    );
    public $hasOne = array(
    );
    public $virtualFields = array(
    );

}
