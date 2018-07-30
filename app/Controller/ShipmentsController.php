<?php

App::uses('AppController', 'Controller');

class ShipmentsController extends AppController {

    var $name = "Shipments";
    var $disabledAction = array(
    );
    var $contain = [
        "ShipmentStatus",
        "Sale" => [
            "Buyer",
            "Box" => [
                "BoxDetail" => [
                    "PackageDetail"
                ]
            ]
        ]
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_pengiriman_barang");
        $this->_setPeriodeLaporanDate("awal_Shipment_shipment_date", "akhir_Shipment_shipment_date");
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->data['Shipment']['shipment_status_id'] = 1;
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
//                foreach ($this->data['ShipmentMaterial'] as $k => $params) {
//                    $toUpdatePackageDetail = [
//                        "PackageDetail" => [
//                            "id" => intval($params['package_detail_id']),
//                            "used" => 1
//                        ]
//                    ];
//                    ClassRegistry::init("PackageDetail")->saveAll($toUpdatePackageDetail);
//                }

                $this->{ Inflector::classify($this->name) }->data['Sale']['id'] = $this->data['Shipment']['sale_id'];
                //Update Sales shipment_status
                $toUpdateSale = [
                    "Sale" => [
                        "id" => intval($this->data['Shipment']['sale_id']),
                        "shipment_status" => 1
                    ]
                ];
                ClassRegistry::init("Sale")->saveAll($toUpdateSale);

                //check is_load package if is_load==0 then reset sale_id
                $dataPackage = ClassRegistry::init("PackageDetail")->find("all", array("conditions" => array("PackageDetail.sale_id" => $this->data['Shipment']['sale_id'])));
                foreach ($dataPackage as $k => $params) {
                    if ($params['PackageDetail']['is_load'] != 1 && $params['PackageDetail']['sale_id'] == intval($this->data['Shipment']['sale_id'])) {
                        $toUpdatePackageDetail = [
                            "PackageDetail" => [
                                "id" => intval($params['PackageDetail']['id']),
                                "sale_id" => NULL,
                                "sale_detail_id" => NULL,
                                "sale_id" => NULL,
                                "sale_id" => NULL,
                            ]
                        ];
                        ClassRegistry::init("PackageDetail")->saveAll($toUpdatePackageDetail);
                    }
                }

                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
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

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("users", ClassRegistry::init("User")->find("list", array("fields" => array("User.id", "User.username"))));
//        $this->set("buyers", ClassRegistry::init("Buyer")->find("list", array("fields" => array("Buyer.id", "Buyer.company_name"))));
        $this->set("shipmentStatuses", $this->Shipment->ShipmentStatus->find("list", array("fields" => array("ShipmentStatus.id", "ShipmentStatus.name"))));
        $this->set("shipmentAgents", $this->Shipment->ShipmentAgent->find("list", array("fields" => array("ShipmentAgent.id", "ShipmentAgent.name"))));
        $this->set("sales", ClassRegistry::init("Sale")->find("list", array("fields" => array("Sale.id", "Sale.sale_no"))));
    }

    function admin_get_shipment_details($id = null) {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->find('first', array("fields" => array(), "conditions" => array("Shipment.id" => $id),
            "contain" => array(
                "ShipmentAgent",
                "Sale" => [
                    "Buyer",
                    "SaleDetail" => [
                        "Product" => [
                            "ProductUnit",
                            "Parent"
                        ]
                    ],
                ],
        )));
        echo json_encode($data);
    }

    function generateShipmentNumber() {
        $inc_id = 1;
        $Y = date('Y');
        $M = romanic_number(date('n'));
        $testCode = "[0-9]{4}/DLVR-PRO/$M/$Y";
        $lastRecord = $this->Shipment->find('first', array('conditions' => array('and' => array("Shipment.shipment_number regexp" => $testCode)), 'order' => array('Shipment.shipment_number' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = substr($lastRecord["Shipment"]["shipment_number"], 0, 4);
            $inc_id += $current;
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/DLVR-PRO/$M/$Y";
        return $kode;
    }

    function admin_change_status_verify() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->Shipment->data['Shipment']['id'] = $this->request->data['id'];
            $this->Shipment->data['Shipment']['shipment_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] !== '1') {
                $this->Shipment->data['Shipment']['shipment_date'] = date("Y-m-d H:i:s");
                $dataShipment = $this->Shipment->find("first", [
                    "conditions" => [
                        "Shipment.id" => $this->request->data['id']
                    ],
                    "contain" => [
                        "ShipmentStatus",
                        "Sale" => [
                            "Buyer"
                        ]
                    ]
                ]);

                $sale_id = $dataShipment['Shipment']['sale_id'];
                $packages = ClassRegistry::init("PackageDetail")->find("all", [
                    "conditions" => [
                        'PackageDetail.sale_id' => $sale_id
                    ],
                    "recursive" => -1,
                ]);
                //check all package must is_load == 1
                $packageStatus = true;
                foreach ($packages as $package) {
                    if ($package['PackageDetail']['is_load'] == false) {
                        $packageStatus = false;
                    }
                }
                if ($packageStatus) {
                    /* posting to transaction mutation table */
                    $this->Shipment->data['TransactionMutation']['reference_number'] = $dataShipment['Shipment']['shipment_number'];
                    $this->Shipment->data['TransactionMutation']['transaction_name'] = "Penjualan";
                    $this->Shipment->data['TransactionMutation']['debit'] = $dataShipment['Sale']['grand_total'];
                    $this->Shipment->data['TransactionMutation']['transaction_date'] = date("Y-m-d");
                    $this->Shipment->data['TransactionMutation']['transaction_type_id'] = 3;

                    /* posting to general entry table */
                    $account_receivable_type = "Piutang Dagang";
                    $general_entry_type_id_account_receivable = 52;
                    if ($dataShipment['Sale']['Buyer']['buyer_type_id'] == 1) {
                        //                    $dataInitialBalance = ClassRegistry::init("InitialBalance")->find("first",["conditions" => ['InitialBalance.currency_id' => 1]]);
                        //                    $initial_balance_id = $dataInitialBalance['InitialBalance']['id'];
                        $sell_type = "Penjualan Lokal";
                        $sell_account_type_id = 31;
                    } else {
                        //                    $dataInitialBalance = ClassRegistry::init("InitialBalance")->find("first",["conditions" => ['InitialBalance.currency_id' => 2]]);
                        //                    $initial_balance_id = $dataInitialBalance['InitialBalance']['id'];
                        $sell_type = "Penjualan Export";
                        $sell_account_type_id = 8;
                    }
                    //                $this->Shipment->data['GeneralEntry'][0]['initial_balance_id'] = $initial_balance_id;
                    $this->Shipment->data['GeneralEntry'][0]['reference_number'] = $dataShipment['Shipment']['shipment_number'];
                    $this->Shipment->data['GeneralEntry'][0]['transaction_name'] = $account_receivable_type;
                    $this->Shipment->data['GeneralEntry'][0]['debit'] = $dataShipment['Sale']['grand_total'];
                    $this->Shipment->data['GeneralEntry'][0]['transaction_date'] = date("Y-m-d");
                    $this->Shipment->data['GeneralEntry'][0]['general_entry_type_id'] = $general_entry_type_id_account_receivable;
                    $this->Shipment->data['GeneralEntry'][0]['transaction_type_id'] = 3;
                    $this->Shipment->data['GeneralEntry'][0]['general_entry_account_type_id'] = 2;
                    //                $this->Shipment->data['GeneralEntry'][1]['initial_balance_id'] = $initial_balance_id;
                    $this->Shipment->data['GeneralEntry'][1]['reference_number'] = $dataShipment['Shipment']['shipment_number'];
                    $this->Shipment->data['GeneralEntry'][1]['transaction_name'] = $sell_type;
                    $this->Shipment->data['GeneralEntry'][1]['credit'] = $dataShipment['Sale']['grand_total'];
                    $this->Shipment->data['GeneralEntry'][1]['transaction_date'] = date("Y-m-d");
                    $this->Shipment->data['GeneralEntry'][1]['general_entry_type_id'] = $sell_account_type_id;
                    $this->Shipment->data['GeneralEntry'][1]['transaction_type_id'] = 3;
                    $this->Shipment->data['GeneralEntry'][1]['general_entry_account_type_id'] = 2;

                    if ($dataShipment["Sale"]['shipment_payment_type_id'] == 2) {
                        $this->Shipment->data['GeneralEntry'][2]['initial_balance_id'] = $initial_balance_id;
                        $this->Shipment->data['GeneralEntry'][2]['reference_number'] = $dataShipment['Shipment']['shipment_number'];
                        $this->Shipment->data['GeneralEntry'][2]['transaction_name'] = "Biaya Freight Kapal dan Pesawat";
                        $this->Shipment->data['GeneralEntry'][2]['debit'] = $dataShipment['Sale']['shipping_cost'];
                        $this->Shipment->data['GeneralEntry'][2]['transaction_date'] = date("Y-m-d");
                        $this->Shipment->data['GeneralEntry'][2]['general_entry_type_id'] = 20;
                        $this->Shipment->data['GeneralEntry'][2]['transaction_type_id'] = 3;
                        $this->Shipment->data['GeneralEntry'][2]['general_entry_account_type_id'] = 1;
                        $this->Shipment->data['GeneralEntry'][3]['initial_balance_id'] = $initial_balance_id;
                        $this->Shipment->data['GeneralEntry'][3]['reference_number'] = $dataShipment['Shipment']['shipment_number'];
                        $this->Shipment->data['GeneralEntry'][3]['transaction_name'] = "Hutang Dagang";
                        $this->Shipment->data['GeneralEntry'][3]['credit'] = $dataShipment['Sale']['shipping_cost'];
                        $this->Shipment->data['GeneralEntry'][3]['transaction_date'] = date("Y-m-d");
                        $this->Shipment->data['GeneralEntry'][3]['general_entry_type_id'] = 35;
                        $this->Shipment->data['GeneralEntry'][3]['transaction_type_id'] = 3;
                        $this->Shipment->data['GeneralEntry'][3]['general_entry_account_type_id'] = 1;
                    }
                    $this->Shipment->saveAll();

                    /* posting to Product History Table */
                    $dataShipment = $this->Shipment->find("first", [
                        "conditions" => [
                            "Shipment.id" => $this->request->data['id']
                        ],
                        "contain" => [
                            "Sale" => [
                                "SaleDetail" => [
                                    "PackageDetail" => [
                                        "PackageDetailProduct" => [
                                            "ProductDetail",
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ]);
                    $shipment_id = $dataShipment['Shipment']['id'];
                    $dt = date("Y-m-d H:i:s");
                    foreach ($dataShipment['Sale']['SaleDetail'] as $details) {

                        $product_id = $details['product_id'];
                        $weight = $details['fulfill_weight'];
                        //reduce stock
                        foreach ($details["PackageDetail"] as $packageDetails) {
                            if (isset($packageDetails["PackageDetailProduct"]) && !empty($packageDetails["PackageDetailProduct"])) {
                                foreach ($packageDetails["PackageDetailProduct"] as $packageDetailProduct) {
                                    //Pengurangan paket dilakukan di proses packing
//                                    $productDetail = $packageDetailProduct["ProductDetail"];
//                                    $currentWeight = $productDetail["remaining_weight"];
//                                    $afterShipment = $currentWeight - $packageDetailProduct["nett_weight"];
//                                    ClassRegistry::init("ProductDetail")->saveAll([
//                                        "ProductDetail" => [
//                                            "id" => $productDetail["id"],
//                                            "remaining_weight" => $afterShipment,
//                                        ],
//                                    ]);
                                }
                            }
                        }
                        //end of reduce stock
                        ClassRegistry::init("ProductHistory")->postHistoryProduct($shipment_id, $product_id, $weight, $dt, "KLR");
                    }
                    $data = $this->Shipment->find("first", array("conditions" => array("Shipment.id" => $this->request->data['id']), "recursive" => 1));
                    echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['ShipmentStatus']['name'])));
                } else {
                    echo json_encode($this->_generateStatusCode(499));
                }
            } else {
                $this->Shipment->data['Shipment']['shipment_date'] = null;
            }
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

}
