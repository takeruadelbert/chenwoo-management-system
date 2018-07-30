<?php

App::uses('AppController', 'Controller');

class BoxesController extends AppController {

    var $name = "Boxes";
    var $disabledAction = array(
    );
    var $contain = [
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            $this->{ Inflector::classify($this->name) }->data['Box']['box_no'] = $this->_generateBoxNo();
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
        $this->set("dataPackage", ClassRegistry::init("PackageDetail")->find("all", array("fields" => array(), "contain" => array("Product" => "Parent"), "conditions" => array("PackageDetail.used" => 0))));
    }

    function admin_edit($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    if (!is_null($id)) {
                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                        $this->redirect(array('action' => 'admin_index'));
                    } else {
                        
                    }
                } else {
                    $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                }
            } else {
                $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                    'conditions' => array(
                        Inflector::classify($this->name) . ".id" => $id
                    ),
                    'recursive' => 2
                ));
                $this->data = $rows;
            }
        }
    }

    function admin_daily_boxing() {
        if ($this->request->is("post")) {
            $this->admin_print_boxing_daily($this->data['Boxing']['date']);
        }
    }

    function admin_print_boxing_daily($date = null) {
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.created > ' => $date . " 00:00:00",
                Inflector::classify($this->name) . '.created <=' => $date . " 23:59:59",
            ),
            'contain' => [
                "Sale" => [
                    "Buyer"
                ],
                "BoxDetail" => [
                    "PackageDetail" => [
                        "Product" => [
                            "ProductUnit",
                            "Parent"
                        ]
                    ]
                ]
            ],
        ));

        $this->data = $rows;
        $data = array(
            'title' => 'Laporan Pengepakan Ikan Harian',
            'rows' => $rows,
        );
//        debug($data);
//        die;
        $this->set(compact('data'));
        $this->_activePrint(["print"], "report_boxing_daily", "print_plain");
    }

    function admin_daily_boxing_per_product() {
        if ($this->request->is("post")) {
            $this->admin_print_boxing_daily($this->data['Boxing']['date']);
        }
    }

    function admin_print_boxing_daily_per_product($date = null) {
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.created > ' => $date . " 00:00:00",
                Inflector::classify($this->name) . '.created <=' => $date . " 23:59:59",
            ),
            'contain' => [
                "Sale" => [
                    "Buyer"
                ],
                "BoxDetail" => [
                    "PackageDetail" => [
                        "Product" => [
                            "ProductUnit",
                            "Parent"
                        ]
                    ]
                ]
            ],
        ));

        $this->data = $rows;
        $data = array(
            'title' => 'Laporan Pengepakan Ikan Harian',
            'rows' => $rows,
        );
//        debug($data);
//        die;
        $this->set(compact('data'));
        $this->_activePrint(["print"], "report_boxing_daily_per_product", "print_plain");
    }
    
    function admin_view_data_box($id = null) {
        $this->autoRender = false;
        if ($this->Box->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->Box->find("first", [
                    "conditions" => [
                        "Box.id" => $id
                    ],
                    "contain" => [
                        "Sale"=>[
                            "Buyer"
                        ],
                        "BoxDetail" => [
                            "PackageDetail" => [
                                "Product" => [
                                    "Child",
                                    "ProductUnit"
                                ]
                            ],
                        ]
                    ]
                ]);
                echo json_encode($this->_generateStatusCode(206, null, $data));
            } else {
                echo json_encode($this->_generateStatusCode(400));
            }
        } else {
            echo json_encode($this->_generateStatusCode(401));
        }
    }

    //Function For Android App
    function get_detail_box($boxNumber){
        $this->autoRender = false;
        if ($boxNumber != null) {
            $data = $this->{ Inflector::classify($this->name) }->find("first", ["fields" => [], "conditions" => ["Box.box_no" => $boxNumber], "contain" => ["Sale" => ["Buyer"], "BoxDetail" => ["PackageDetail" => ["Product" => ["Parent", "ProductUnit"]]]]]);
            if ($data!=null) {
                echo json_encode($this->_generateStatusCode(206, null, $data));
            } else {
                echo json_encode($this->_generateStatusCode(401));
            }
        } else {
            echo json_encode($this->_generateStatusCode(401));
        }
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("sales", ClassRegistry::init("Sale")->find("list", array("fields" => array("Sale.id", "Sale.sale_no"))));
    }

    function admin_print_qr_code($id) {
        $data = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id)));
        $this->set(compact('data'));
        $this->_activePrint(["print"], "print_barcode_box", "print_barcode");
    }

    function _generateBoxNo($count = 1) {
        $inc_id = 1 + $count;
        $testCode = "53849094[0-9]{3}";
        $lastRecord = $this->Box->find('first', array('conditions' => array('and' => array("Box.box_no regexp" => $testCode)), 'order' => array('Box.box_no' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = substr($lastRecord["Box"]["box_no"], -3);
            $inc_id+=$current;
        }
        $inc_id = sprintf("%03d", $inc_id);
        $kode = "53849094$inc_id";
        return $kode;
    }

    function view_data_boxes($boxesId) {
        if (!empty($boxesId) && $boxesId != null) {
            $this->autoRender = false;
            $data = ClassRegistry::init("Box")->find("first", [
                "conditions" => [
                    "Box.id" => $boxesId,
                ],
                "contain" => [
                    "Sale" => [
                        "Buyer",
                    ],
                    "BoxDetail" => [
                        "PackageDetail" => [
                            "Product" => [
                                "ProductUnit",
                                "Parent"
                            ]
                        ]
                    ]
                ],
            ]);
            return json_encode($data);
        } else {
            throw new NotFoundException(__('Data Not Found'));
        }
    }

}
