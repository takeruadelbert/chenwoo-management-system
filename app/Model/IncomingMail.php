<?php

class IncomingMail extends AppModel {

    public $validate = array(
    );
    public $belongsTo = array(
        "MailType",
        "MailClassification",
        "MailUrgency",
        "MailOrigin",
        "MailRack",
        "MailStatus",
        "AssetFile",
        "Employee",
        "Approver" => [
            "className" => "Employee",
            "foreignKey" => "approver_id",
        ],
        "Korespondensi" => [
            "className" => "OutgoingMail",
            "foreignKey" => "korespondensi_id",
        ],
    );
    public $hasOne = array(
        "KorespondensiAfter" => [
            "className" => "OutgoingMail",
            "foreignKey" => "referensi_id",
        ],
        "IncomingMailNotification" => array(
            "dependent" => true
        ),
    );
    public $hasMany = array(
        "MailRecipient" => [
            "dependent" => true,
        ],
        "IncomingMailFile" => array(
            "dependent" => true
        ),
//        "IncomingMailCarbonCopy",
    );
    public $virtualFields = array(
    );

    public function generateNomorAgenda($id = null) {
        $inc_id = 1;
        $testCode = "m[0-9]{5}";
        $lastRecord = $this->find('first', array('conditions' => array('not' => array('IncomingMail.id' => $id), 'and' => array("IncomingMail.nomor_agenda regexp" => $testCode)), 'order' => array('IncomingMail.nomor_agenda' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = ltrim($lastRecord['IncomingMail']['nomor_agenda'], 'm');
            $inc_id+=$current;
        }

        $inc_id = sprintf("%05d", $inc_id);
        $kode = "m$inc_id";
        $this->id = $id;
        $this->save(array("nomor_agenda" => $kode));
        return $kode;
    }

    function _findAllKoresponden($current, &$found) {
        ksort($found);
        if (empty($found)) {
            if (isset($current['IncomingMail'])) {
                $found[0] = am($current, ["uniq" => $current["IncomingMail"]['jenis'] . $current["IncomingMail"]['id']]);
            } else {
                $found[0] = am($current, ["uniq" => $current["OutgoingMail"]['jenis'] . $current["OutgoingMail"]['id']]);
            }
        }
        if (isset($current['Korespondensi']) && !is_null($current['Korespondensi']['id']) && !in_array($current['Korespondensi']['jenis'] . $current['Korespondensi']['id'], array_column($found, "uniq"))) {
            $prev = ClassRegistry::init("OutgoingMail")->find("first", [
                "conditions" => [
                    "OutgoingMail.id" => $current['Korespondensi']['id'],
                ],
                "contain" => [
                    "Referensi",
                    "ReferensiAfter",
                ]
            ]);
            reset($found);
            $firstIdx = key($found);
            $found[$firstIdx - 1] = am($prev,["uniq"=>$current['Korespondensi']['jenis'] . $current['Korespondensi']['id']]);
            $this->_findAllKoresponden($prev, $found);
        }
        if (isset($current['KorespondensiAfter']) && !is_null($current['KorespondensiAfter']['id']) && !in_array($current['KorespondensiAfter']['jenis'] . $current['KorespondensiAfter']['id'], array_column($found, "uniq"))) {
            $prev = ClassRegistry::init("OutgoingMail")->find("first", [
                "conditions" => [
                    "OutgoingMail.id" => $current['KorespondensiAfter']['id'],
                ],
                "contain" => [
                    "Referensi",
                    "ReferensiAfter",
                ]
            ]);
            end($found);
            $lastIdx = key($found);
            $found[$lastIdx + 1] = am($prev,["uniq"=>$current['KorespondensiAfter']['jenis'] . $current['KorespondensiAfter']['id']]);
            $this->_findAllKoresponden($prev, $found);
        }
        if (isset($current['Referensi']) && !is_null($current['Referensi']['id']) && !in_array($current['Referensi']['jenis'] . $current['Referensi']['id'], array_column($found, "uniq"))) {
            $prev = ClassRegistry::init("IncomingMail")->find("first", [
                "conditions" => [
                    "IncomingMail.id" => $current['Referensi']['id'],
                ],
                "contain" => [
                    "Korespondensi",
                    "KorespondensiAfter",
                ]
            ]);
            reset($found);
            $firstIdx = key($found);
            $found[$firstIdx - 1] = am($prev,["uniq"=>$current['Referensi']['jenis'] . $current['Referensi']['id']]);
            $this->_findAllKoresponden($prev, $found);
        }
        if (isset($current['ReferensiAfter']) && !is_null($current['ReferensiAfter']['id']) && !in_array($current['ReferensiAfter']['jenis'] . $current['ReferensiAfter']['id'], array_column($found, "uniq"))) {
            $prev = ClassRegistry::init("IncomingMail")->find("first", [
                "conditions" => [
                    "IncomingMail.id" => $current['ReferensiAfter']['id'],
                ],
                "contain" => [
                    "Korespondensi",
                    "KorespondensiAfter",
                ]
            ]);
            end($found);
            $lastIdx = key($found);
            $found[$lastIdx + 1] = am($prev,["uniq"=>$current['ReferensiAfter']['jenis'] . $current['ReferensiAfter']['id']]);
            $this->_findAllKoresponden($prev, $found);
        }
    }

}
