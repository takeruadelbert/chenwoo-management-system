<?php

App::uses('AppController', 'Controller');

class HolidaysController extends AppController {

    var $name = "Holidays";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_hari_libur");
        if (isset($_GET["bulan"])) {
            $bulan = $_GET["bulan"];
            unset($_GET["bulan"]);
        }
        if (isset($_GET["tahun"])) {
            $tahun = $_GET["tahun"];
            unset($_GET["tahun"]);
        }
        if (!empty($bulan) && !empty($tahun)) {
            $this->conds["and"][] = [
                "or" => [
                        ["and" => [
                            "YEAR(Holiday.start_date)" => $tahun,
                            "MONTH(Holiday.start_date)" => $bulan,
                        ]
                    ],
                        ["and" => [
                            "YEAR(Holiday.end_date)" => $tahun,
                            "MONTH(Holiday.end_date)" => $bulan,
                        ]
                    ],
                ],
            ];
        } else if (!empty($bulan)) {
            $this->conds["and"][] = [
                "or" => [
                        ["and" => [
                            "MONTH(Holiday.start_date)" => $bulan,
                        ]
                    ],
                        ["and" => [
                            "MONTH(Holiday.end_date)" => $bulan,
                        ]
                    ],
                ],
            ];
        } else if (!empty($tahun)) {
            $this->conds["and"][] = [
                "or" => [
                        ["and" => [
                            "YEAR(Holiday.start_date)" => $tahun,
                        ]
                    ],
                        ["and" => [
                            "YEAR(Holiday.end_date)" => $tahun,
                        ]
                    ],
                ],
            ];
        }
        $this->order = "Holiday.start_date desc";
        parent::admin_index();
    }

    function view_data_holiday($id = null) {
        $this->autoRender = false;
        if ($this->Holiday->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->Holiday->find("first", ["conditions" => ["Holiday.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
