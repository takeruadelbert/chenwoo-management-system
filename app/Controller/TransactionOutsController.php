<?php

App::uses('AppController', 'Controller');

class TransactionOutsController extends AppController {

    var $name = "TransactionOuts";
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
//            foreach ($this->data['TransactionMaterialOut'] as $k => $params) {
//                $price = ClassRegistry::init("ProductSize")->find("first", [
//                    "conditions" => [
//                        "ProductSize.id" => $params['product_size_id'],
//                    ],
//                ]);
//                $total = $total + (intval($price['ProductSize']["price"]) * intval($this->data['TransactionMaterialOut'][$k]['quantity']));
//                $product = ClassRegistry::init("Product")->ProductSize->find("first", [
//                    "conditions" => [
//                        "ProductSize.id" => $params['product_size_id'],
//                    ],
//                ]);
//                $toUpdate = [
//                    "ProductSize" => [
//                        "id" => intval($params['product_size_id']),
//                        "quantity" => $product["ProductSize"]["quantity"] - intval($params['quantity'])
//                    ]
//                ];
//                ClassRegistry::init("ProductSize")->saveAll($toUpdate);
//            }
//          $this->{ Inflector::classify($this->name) }->data['TransactionOut']['total'] = $total;
            $this->{ Inflector::classify($this->name) }->data['TransactionOut']['invoice_number'] = $this->generateInvoiceNumber($this->data['TransactionOut']['shipment_id']);
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
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
    
    function admin_report(){
        if ($this->request->is("post")) {
            $this->admin_print_report($this->data['TransactionOut']['dateFrom'],$this->data['TransactionOut']['dateTo']);
        }
    }

    function admin_print_report($startDate,$endDate) {

        $productCategories = ClassRegistry::init("ProductCategory")->find("all");

        $data = array(
            'title' => 'Laporan Pembelian Ikan',
            'date' => $endDate,
        );
        //$startDate1="2016-01-01";
        //$endDate1="2016-12-31";
        $result = $this->TransactionOut->buildReport($startDate,$endDate);
        //debug($result);
        //die;
        $this->set(compact('data', "result", "productCategories"));
        $this->_activePrint(["print"], "report_out", "print_plain");
    }
    
    function admin_rekapitulasi_per_buyer(){
        if ($this->request->is("post")) {
            $this->admin_print_rekapitulasi_per_buyer($this->data['TransactionOut']['dateFrom'],$this->data['TransactionOut']['dateTo'],$this->data['Purchase']['buyer_id']);
        }
    }

    function admin_print_rekapitulasi_per_buyer($startDate,$endDate,$buyerId) {
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.created > ' => $startDate." 00:00:00",
                Inflector::classify($this->name) . '.created <=' => $endDate." 23:59:59",
                "Purchase.buyer_id" => $buyerId,
            ),
            'contain' => [
                "Purchase"=>[
                    "Buyer",
                    "PurchaseDetail"=>[
                        "ProductSize"=>[
                            "Product",
                            "ProductUnit"
                        ]
                    ]
                ],
                "Shipment",
                "TransactionMaterialOut"=>[
                    "Package"=>[
                        
                    ]
                ]
            ],
        ));
        
        $data = array(
            'title' => 'Laporan Rekapitulasi Export ke '.$rows[0]['Purchase']['Buyer']['company_name'],
            'rows' => $rows,
        );
//        debug($rows);
//        die;
        $this->set(compact('data'));
        $this->_activePrint(["print"], "report_rekapitulasi_per_buyer", "print_plain");
    }
    
    function admin_view_data_transaction_outs($id = null) {
        $this->autoRender = false;
        if ($this->TransactionOut->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->TransactionOut->find("first", ["conditions" => ["TransactionOut.id" => $id],"contain"=>["TransactionMaterialOut"=>["Package"=>["PackageDetail"=>["ProductData"=>["ProductSize"=>["Product"]]]]]]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("products", ClassRegistry::init("Product")->ProductSize->find("list", array("fields" => array("ProductSize.id", "ProductSize.name"))));
        $this->set("shipments", ClassRegistry::init("Shipment")->find("list", array("fields" => array("Shipment.id", "Shipment.shipment_number"))));
        $this->set("shipmentAgents", ClassRegistry::init("ShipmentAgent")->find("list", array("fields" => array("ShipmentAgent.id", "ShipmentAgent.name"))));
        $this->set("containers", ClassRegistry::init("Container")->find("list", array("fields" => array("Container.id", "Container.number_container"))));
        $this->set("purchases", ClassRegistry::init("Purchase")->find("list", array("fields" => array("Purchase.id", "Purchase.purchase_no"))));
        $this->set("buyers", ClassRegistry::init("Buyer")->find("list", array("fields" => array("Buyer.id", "Buyer.company_name"))));
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "TransactionOut.invoice_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("TransactionOut")->find("all", array(
            "conditions" => [
                $conds,
            ],
            "contain" => [
                "TransactionMaterialOut" => [
                    "Package",
                ],
                "PaymentSale",
                "Shipment" => [
                    "Buyer",
                ],
                "ShipmentAgent",
                "Container"
            ]
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => @$item['TransactionOut']['id'],
                    "total_invoice" => @$item['TransactionOut']['total'],
                    "invoice_number" => @$item['TransactionOut']['invoice_number'],
                    "invoice_id" => @$item['PaymentSale'][0]['id'],
                    "buyer_id" => @$item['Shipment']['Buyer']['id'],
                    "company_name" => @$item['Shipment']['Buyer']['company_name'],
                    "contact_person" => @$item['Shipment']['Buyer']['contact_person'],
                    "company_address" => @$item['Shipment']['Buyer']['address'],
                    "company_city" => @$item['Shipment']['Buyer']['city'],
                    "company_state" => @$item['Shipment']['Buyer']['state'],
                    "company_phone" => @$item['Shipment']['Buyer']['phone_number'],
                    "company_hp" => @$item['Shipment']['Buyer']['handphone_number'],
                    "company_email" => @$item['Shipment']['Buyer']['email'],
                    "shipment_name" => @$item['ShipmentAgent']['name'],
                    "shipment_phone" => @$item['ShipmentAgent']['phone_number'],
                    "shipment_address" => @$item['ShipmentAgent']['address'],
                    "shipment_city" => @$item['ShipmentAgent']['city'],
                    "shipment_state" => @$item['ShipmentAgent']['state'],
                    "shipment_country" => @$item['ShipmentAgent']['country'],
                    "container_number" => @$item['Container']['container_number'],
                ];
            }
        }
        echo json_encode($result);
    }

    function admin_list_hutang() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "TransactionOut.invoice_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("TransactionOut")->find("all", array(
            "conditions" => [
                $conds,
                "TransactionOut.remaining >" => 0,
            ],
            "contain" => [
                "TransactionMaterialOut" => [
                    "Package",
                ],
                "PaymentSale",
                "Shipment" => [
                    "Buyer",
                ],
                "ShipmentAgent",
                "Container"
            ]
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => @$item['TransactionOut']['id'],
                    "total_invoice" => @$item['TransactionOut']['total'],
                    "invoice_number" => @$item['TransactionOut']['invoice_number'],
                    "invoice_id" => @$item['PaymentSale'][0]['id'],
                    "buyer_id" => @$item['Shipment']['Buyer']['id'],
                    "company_name" => @$item['Shipment']['Buyer']['company_name'],
                    "contact_person" => @$item['Shipment']['Buyer']['contact_person'],
                    "company_address" => @$item['Shipment']['Buyer']['address'],
                    "company_city" => @$item['Shipment']['Buyer']['city'],
                    "company_state" => @$item['Shipment']['Buyer']['state'],
                    "company_country" => @$item['Shipment']['Buyer']['country'],
                    "company_phone" => @$item['Shipment']['Buyer']['phone_number'],
                    "company_hp" => @$item['Shipment']['Buyer']['handphone_number'],
                    "company_email" => @$item['Shipment']['Buyer']['email'],
                    "shipment_name" => @$item['ShipmentAgent']['name'],
                    "shipment_phone" => @$item['ShipmentAgent']['phone_number'],
                    "shipment_address" => @$item['ShipmentAgent']['address'],
                    "shipment_city" => @$item['ShipmentAgent']['city'],
                    "shipment_state" => @$item['ShipmentAgent']['state'],
                    "shipment_country" => @$item['ShipmentAgent']['country'],
                    "container_number" => @$item['Container']['container_number'],
                ];
            }
        }
        echo json_encode($result);
    }

    function admin_list_lunas() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "TransactionOut.invoice_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("TransactionOut")->find("all", array(
            "conditions" => [
                $conds,
                "TransactionOut.remaining =" => 0,
            ],
            "contain" => [
                "TransactionMaterialOut" => [
                    "Package",
                ],
                "PaymentSale",
                "Shipment" => [
                    "Buyer",
                ],
                "ShipmentAgent",
                "Container"
            ]
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => @$item['TransactionOut']['id'],
                    "total_invoice" => @$item['TransactionOut']['total'],
                    "invoice_number" => @$item['TransactionOut']['invoice_number'],
                    "invoice_id" => @$item['PaymentSale'][0]['id'],
                    "buyer_id" => @$item['Shipment']['Buyer']['id'],
                    "company_name" => @$item['Shipment']['Buyer']['company_name'],
                    "contact_person" => @$item['Shipment']['Buyer']['contact_person'],
                    "company_address" => @$item['Shipment']['Buyer']['address'],
                    "company_city" => @$item['Shipment']['Buyer']['city'],
                    "company_state" => @$item['Shipment']['Buyer']['state'],
                    "company_phone" => @$item['Shipment']['Buyer']['phone_number'],
                    "company_hp" => @$item['Shipment']['Buyer']['handphone_number'],
                    "company_email" => @$item['Shipment']['Buyer']['email'],
                    "shipment_name" => @$item['ShipmentAgent']['name'],
                    "shipment_phone" => @$item['ShipmentAgent']['phone_number'],
                    "shipment_address" => @$item['ShipmentAgent']['address'],
                    "shipment_city" => @$item['ShipmentAgent']['city'],
                    "shipment_state" => @$item['ShipmentAgent']['state'],
                    "shipment_country" => @$item['ShipmentAgent']['country'],
                    "container_number" => @$item['Container']['container_number'],
                ];
            }
        }
        echo json_encode($result);
    }

    function admin_account_receivable_product_list() {
        $this->contain = [
            "PaymentSale" => [
                "order" => "PaymentSale.id DESC",
                "conditions" => [
                ],
                "limit" => 1,
            ]
        ];
        $this->conds = [
            "TransactionOut.remaining >" => 0,
        ];
        parent::admin_index();
    }

    function admin_invoice_sale_payment() {
        $this->contain = [
            "TransactionMaterialOut" => [
                "Package" => [
                    "PackageDetail"
                ]
            ]
        ];
        $this->conds = [
        ];
        parent::admin_index();
    }

    function admin_invoice_sale_payment_view($id = null) {
        if (!$this->TransactionOut->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->TransactionOut->data['TransactionOut']['id'] = $id;
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                'conditions' => array(Inflector::classify($this->name) . ".id" => $id),
                "recursive" => -1,
                "contain" => [
                    "TransactionMaterialOut" => [
                        "Package" => [
                            "PackageDetail" => [
                                "ProductData" => [
                                    "ProductSize" => [
                                        "Product"
                                    ]
                                ]
                            ]
                        ]
            ]]));
            $this->data = $rows;
        }
    }

    function generateInvoiceNumber($idShipment) {
        $inc_id = 1;
        $buyerData = ClassRegistry::init("Shipment")->find('first', array('conditions' =>['Shipment.id'=>$idShipment],'contain'=>['Buyer']));
        $company_code = $buyerData['Buyer']['company_uniq_name'];
        $testCode = "INV($company_code)-[0-9]{3}";
        $lastRecord = $this->TransactionOut->find('first', array(
            'conditions' => array(
                'and' => array(
                    "TransactionOut.invoice_number regexp" => $testCode)),
            'order' => array(
                'TransactionOut.invoice_number' => 'DESC'),
            'contain' => [
                'Shipment' => [
                    'Buyer'
                ]
            ]
        ));
        if (!empty($lastRecord)) {
            $current = explode("/", $lastRecord['TransactionOut']['invoice_number']);
            $inc_id+=$current[count($current) - 1];
        }
        $inc_id = sprintf("%03d", $inc_id);
        //$company_code = $lastRecord['Shipment']['Buyer']['company_uniq_name'];
        $kode = "INV($company_code)-$inc_id";
        return $kode;
    }

    function view_transaction_out_item($transaction_out_id = null) {
        $this->autoRender = false;
        if ($this->request->is("GET")) {
            $data = $this->TransactionOut->TransactionMaterialOut->find("all", [
                "conditions" => [
                    "TransactionMaterialOut.transaction_out_id" => $transaction_out_id,
                ],
                "contain" => [
                ]
            ]);
            return json_encode($data);
        } else {
            return json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_print_invoice_sale_payment($id = null) {
        $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.id' => $id,
            ),
            "contain" => [
                "TransactionMaterialOut" => [
                    "Package" => [
                        "PackageDetail" => [
                            "ProductData" => [
                                "ProductSize" => [
                                    "Product"
                                ]
                            ]
                        ]
                    ]
                ],
                "PaymentSale",
                "Shipment" => [
                    "Buyer",
                ],
                "ShipmentAgent",
                "Container"
            ]
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'Invoice',
            'rows' => $rows,
        );
        $this->set(compact('data'));
        $this->_activePrint(["print"], "print_invoice_sale_payment", "kwitansi");
    }

}
