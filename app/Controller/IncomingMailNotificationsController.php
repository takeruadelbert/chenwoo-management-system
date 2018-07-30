<?php

App::uses('AppController', 'Controller');

class IncomingMailNotificationsController extends AppController {

    var $name = "IncomingMailNotifications";
    var $disabledAction = array(
        "admin_index",
        "admin_add",
        "admin_edit",
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function cron_send() {
        $this->autoRender = false;
        $this->loadModel("Outbox");
        $this->loadModel("User");
        //surat masuk
        //-sms
        $incomingMailNotifs = $this->IncomingMailNotification->IncomingMail->find("all", [
            "conditions" => [
                "OR" => [
                    "NOT" => [
                        "IncomingMailNotification.sms" => 1,
                    ],
                    "IncomingMailNotification.sms" => null,
                ],
            ],
            "contain" => [
                "IncomingMailNotification",
                "Employee" => [
                    "Account" => [
                        "Biodata",
                    ]
                ]
            ]
        ]);
        foreach ($incomingMailNotifs as $incomingMailNotif) {
            $destination = $incomingMailNotif["Employee"]["Account"]["Biodata"]["handphone"];
            $message = "Anda menerima surat pada {$incomingMailNotif['IncomingMail']['dt__ic']} perihal {$incomingMailNotif['IncomingMail']['perihal']}";
            //sms
            $this->Outbox->sendMessage($message, $destination);
            if (is_null($incomingMailNotif["IncomingMailNotification"]["id"])) {
                $this->IncomingMailNotification->saveAll([
                    "IncomingMailNotification" => [
                        'incoming_mail_id' => $incomingMailNotif["IncomingMail"]["id"],
                        "notification_type_id" => 1,
                        "sms" => 1,
                    ]
                ]);
            } else {
                $this->IncomingMailNotification->saveAll([
                    "IncomingMailNotification" => [
                        "sms" => 1,
                        "id" => $incomingMailNotif["IncomingMailNotification"]["id"],
                    ]
                ]);
            }
        }
        //-email
        $incomingMailNotifs = $this->IncomingMailNotification->IncomingMail->find("all", [
            "conditions" => [
                "OR" => [
                    "NOT" => [
                        "IncomingMailNotification.email" => 1,
                    ],
                    "IncomingMailNotification.email" => null,
                ],
            ],
            "contain" => [
                "IncomingMailNotification",
                "Employee" => [
                    "Account" => [
                        "Biodata",
                        "User",
                    ]
                ]
            ]
        ]);
        foreach ($incomingMailNotifs as $incomingMailNotif) {
            $destination = $incomingMailNotif["Employee"]["Account"]["User"]["email"];
            $this->_sentEmail("surat-masuk", [
                "tujuan" => $destination,
                "subject" => "SIDISPOP - Surat Masuk",
                "from" => array("noreply@dispopsulbar.com" => "SIDISPOP"),
                "acc" => "NoReply",
                "item" => [
                    'tanggal_surat' => $incomingMailNotif['IncomingMail']['dt__ic'],
                    'perihal' => $incomingMailNotif['IncomingMail']['perihal'],
                    'penerima' => $incomingMailNotif["Employee"]["Account"]["Biodata"]["full_name"],
                ],
            ]);
            if (is_null($incomingMailNotif["IncomingMailNotification"]["id"])) {
                $this->IncomingMailNotification->saveAll([
                    "IncomingMailNotification" => [
                        'incoming_mail_id' => $incomingMailNotif["IncomingMail"]["id"],
                        "notification_type_id" => 1,
                        "email" => 1,
                    ]
                ]);
            } else {
                $this->IncomingMailNotification->saveAll([
                    "IncomingMailNotification" => [
                        "email" => 1,
                        "id" => $incomingMailNotif["IncomingMailNotification"]["id"],
                    ]
                ]);
            }
        }
    }

}
