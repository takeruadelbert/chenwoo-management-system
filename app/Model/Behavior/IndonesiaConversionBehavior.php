<?php

/*
 * Model Behavior
 * purpose  : saving multi language into single fields using json format
 * written  : Surya Wono(suryawono@yahoo.co.id)
 * standard : user ISO 639-2/5 as language code
 */

class IndonesiaConversionBehavior extends ModelBehavior {

    public $suffix = "__ic";
    public $config = [];
    public $hari = array(
        "Minggu",
        "Senin",
        "Selasa",
        "Rabu",
        "Kamis",
        "Jumat",
        "Sabtu"
    );
    public $bulan = [
        1 => "Januari",
        2 => "Febuari",
        3 => "Maret",
        4 => "April",
        5 => "Mei",
        6 => "Juni",
        7 => "Juli",
        8 => "Agustus",
        9 => "September",
        10 => "Oktober",
        11 => "November",
        12 => "Desember"
    ];

    public function setup(Model $Model, $config = array()) {
        $this->config = $config;
    }

    function afterFind(\Model $model, $results, $primary = false) {
        parent::afterFind($model, $results, $primary);
        foreach ($results as $i => $result) {
            $results[$i] = $this->_proccess($result);
        }
        return $results;
    }

    function _proccess($o = null, $name = null, $grandName = null) {
        foreach ($o as $k => $v) {
            if (is_array($v)) {
                $o[$k] = $this->_proccess($v, $k, $name);
            } else {
                $needle = $name;
                if (is_int($name)) {
                    $needle = $grandName;
                }
                if (is_string($k) && isset($this->config[$needle]) && array_key_exists($k, $this->config[$needle])) {
                    switch ($this->config[$needle][$k]['type']) {
                        case "date":
                            $o[$k . $this->suffix] = $this->_cvtHariTanggal($v);
                            break;
                        case "dateonly":
                            $o[$k . $this->suffix] = $this->_cvtHariTanggal($v, true);
                            break;
                        case "datetime":
                            $o[$k . $this->suffix] = $this->_cvtWaktu($v);
                            break;
                        case "idrseprator":
                            $o[$k . $this->suffix] = $this->_idr($v);
                            break;
                        case "numberseparator":
                            $o[$k . $this->suffix] = $this->_numberseparator($v);
                            break;
                        case "kg":
                            $o[$k . $this->suffix] = $this->_kg($v);
                            break;
                    }
                }
            }
        }
        return $o;
    }

    function _cvtHariTanggal($date, $dateonly = false) {
        if (!empty($date)) {
            $tgl = date("d", strtotime($date));
            $bulan = $this->bulan[date("n", strtotime($date))];
            $tahun = date("Y", strtotime($date));
            $hari = $this->hari[date("w", strtotime($date))];
        } else {
            return "-";
        }
        if ($dateonly) {
            return "$tgl $bulan $tahun";
        } else {
            return "$hari, $tgl $bulan $tahun";
        }
    }

    function _cvtWaktu($datetime) {
        if (!empty($datetime)) {
            $tgl = date("d", strtotime($datetime));
            $bulan = $this->bulan[date("n", strtotime($datetime))];
            $tahun = date("Y", strtotime($datetime));
            $hari = $this->hari[date("w", strtotime($datetime))];
            $jam = date("H", strtotime($datetime));
            $menit = date("i", strtotime($datetime));
        } else {
            return "-";
        }
        return "$tgl $bulan $tahun - $jam:$menit";
    }

    function _idr($idr) {
        if ($idr == "") {
            return "0";
        }
        return number_format($idr, 0, "", ".");
    }

    function _numberseparator($number) {
        if ($number == "") {
            return "0";
        }
        return number_format($number, 0, "", ".");
    }

    function _kg($berat) {
        return ic_kg($berat);
    }

}
