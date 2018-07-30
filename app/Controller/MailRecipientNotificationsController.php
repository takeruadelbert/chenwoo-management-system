<?php

App::uses('AppController', 'Controller');

class MailRecipientNotificationsController extends AppController {

    var $name = "MailRecipientNotifications";
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
        $this->loadModel("IncomingMailDelayNotification");
        $this->loadModel("User");
        //belum disetujui
        $lastNotif = $this->IncomingMailDelayNotification->find("first", [
            "conditions" => [
                "DATE(IncomingMailDelayNotification.created) = DATE(NOW())"
            ],
            "order" => "IncomingMailDelayNotification.created desc",
        ]);
        if (empty($lastNotif)) {
            $this->IncomingMailDelayNotification->save(['count']);
            $jumlahSuratBelumDisetujui = $this->MailRecipientNotification->MailRecipient->IncomingMail->find("count", [
                "conditions" => [
                    "IncomingMail.created < DATE_SUB(CURDATE(), INTERVAL 3 DAY)",
                    "IncomingMail.mail_status_id" => 1,
                ],
            ]);
            if ($jumlahSuratBelumDisetujui > 0) {
                $destinations = [];
                $sekretaris = $this->User->find("all", [
                    "conditions" => [
                        "UserGroup.name" => "sekretaris"
                    ],
                    "contain" => [
                        "UserGroup",
                        "Account" => [
                            "Biodata",
                        ]
                    ]
                ]);
                foreach ($sekretaris as $s) {
                    $destinations[] = $s["Account"]["Biodata"]["handphone"];
                }
                $message = "Anda memiliki $jumlahSuratBelumDisetujui surat yang belum diproses";
                //sms
                $this->Outbox->sendMessage($message, $destinations);
                $this->IncomingMailDelayNotification->saveAll(['count' => $jumlahSuratBelumDisetujui]);
            }
        }
        
        //mendapatkan disposisi surat masuk
        //sms
        $penerimaSuratMasuk = $this->MailRecipientNotification->MailRecipient->find("all", [
            "conditions" => [
                "MailRecipient.seen" => 0,
                "OR" => [
                    "NOT" => [
                        "MailRecipientNotification.sms" => 1,
                    ],
                    "MailRecipientNotification.sms" => null,
                ],
            ],
            "contain" => [
                "Employee" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
                "IncomingMail",
                "MailRecipientNotification",
            ]
        ]);
        foreach ($penerimaSuratMasuk as $p) {
            $destination = $p["Employee"]["Account"]["Biodata"]["handphone"];
            $message = "Anda menerima disposisi surat pada {$p['IncomingMail']['dt__ic']} perihal {$p['IncomingMail']['perihal']}";
            $this->Outbox->sendMessage($message, $destination);
            if (is_null($p["MailRecipientNotification"]["id"])) {
                $this->MailRecipientNotification->saveAll([
                    "MailRecipientNotification" => [
                        "sms" => 1,
                        "mail_recipient_id" => $p["MailRecipient"]["id"],
                        "notification_type_id" => 2,
                    ]
                ]);
            } else {
                $this->MailRecipientNotification->saveAll([
                    "MailRecipientNotification" => [
                        "id" => $p["MailRecipientNotification"]["id"],
                        "sms" => 1,
                    ]
                ]);
            }
        }
        //email
        $penerimaSuratMasuk = $this->MailRecipientNotification->MailRecipient->find("all", [
            "conditions" => [
                "MailRecipient.seq > " => 1,
                "MailRecipient.seen" => 0,
                "OR" => [
                    "NOT" => [
                        "MailRecipientNotification.email" => 1,
                    ],
                    "MailRecipientNotification.email" => null,
                ],
            ],
            "contain" => [
                "Employee" => [
                    "Account" => [
                        "Biodata",
                        "User",
                    ],
                ],
                "Dispositor" => [
                    "Account" => [
                        "Biodata",
                        "User",
                    ],
                ],
                "IncomingMail",
                "MailRecipientNotification",
            ]
        ]);
        foreach ($penerimaSuratMasuk as $p) {
            $destination = $p["Employee"]["Account"]["User"]["email"];
            $this->_sentEmail("disposisi-surat-masuk", [
                "tujuan" => $destination,
                "subject" => "SIDISPOP - Disposisi Surat",
                "from" => array("noreply@dispopsulbar.com" => "SIDISPOP"),
                "acc" => "NoReply",
                "item" => [
                    'tanggal_surat' => $p['IncomingMail']['dt__ic'],
                    'perihal' => $p['IncomingMail']['perihal'],
                    'penerima' => $p["Employee"]["Account"]["Biodata"]["full_name"],
                    'dispositor' => $p["Dispositor"]["Account"]["Biodata"]["full_name"],
                ],
            ]);
            if (is_null($p["MailRecipientNotification"]["id"])) {
                $this->MailRecipientNotification->saveAll([
                    "MailRecipientNotification" => [
                        "email" => 1,
                        "mail_recipient_id" => $p["MailRecipient"]["id"],
                        "notification_type_id" => 2,
                    ]
                ]);
            } else {
                $this->MailRecipientNotification->saveAll([
                    "MailRecipientNotification" => [
                        "id" => $p["MailRecipientNotification"]["id"],
                        "email" => 1,
                    ]
                ]);
            }
        }
    }

}
