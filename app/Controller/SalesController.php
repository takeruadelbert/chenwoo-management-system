<?php

App::uses('AppController', 'Controller');

class SalesController extends AppController {

    var $name = "Sales";
    var $disabledAction = array(
    );
    var $contain = [
        "SaleDetail",
        "Buyer" => [
            "BuyerType"
        ],
        "PackagingStatus",
        "VerifyStatus",
        "BranchOffice",
        "VerifiedBy" => [
            "Account" => [
                "Biodata"
            ]
        ],
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_penjualan_produk");
        parent::admin_index();
    }
    
    function admin_sale_status() {
        $this->conds = [
            "Sale.verify_status_id" => 3,
        ];
        parent::admin_index();
    }

    function admin_index_validate() {
        $this->_activePrint(func_get_args(), "data_penjualan_produk_validate");
        $this->conds = [
            "Sale.verify_status_id" => 1,
        ];
        parent::admin_index();
    }

    function admin_change_status_verify() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->Sale->data['Sale']['id'] = $this->request->data['id'];
            $this->Sale->data['Sale']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] !== '1') {
                $this->Sale->data['Sale']['verified_by_id'] = $this->_getEmployeeId();
                $this->Sale->data['Sale']['verified_datetime'] = date("Y-m-d H:i:s");
            } else {
                $this->Sale->data['Sale']['verified_by_id'] = null;
                $this->Sale->data['Sale']['verified_datetime'] = null;
            }
            $this->Sale->saveAll();
            $data = $this->Sale->find("first", array("conditions" => array("Sale.id" => $this->request->data['id']), "contain" => ["VerifyStatus"]));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_material_additional_per_po() {
        $this->_activePrint(func_get_args(), "data_permintaan_material_pembantu_ke_gudang");
        $this->contain = [
            "SaleDetail",
            "Buyer" => [
                "BuyerType"
            ],
            "MaterialAdditionalPerContainer" => [
                "MaterialAdditionalPerContainerDetail" => [
//                    "MaterialAdditionalMc" => array(
//                        'className' => 'MaterialAdditional',
//                        'foreignKey' => 'material_additional_mc_id',
//                    ),
//                    'MaterialAdditionalPlastic' => array(
//                        'className' => 'MaterialAdditional',
//                        'foreignKey' => 'material_additional_plastic_id',
//                    ),
                ],
                "VerifyStatus",
                "GudangStatus"
            ],
            "BranchOffice"
        ];
        $this->conds = [
            "Sale.branch_office_id" => $this->stnAdmin->roleBranchId()
        ];
        $this->order = "Sale.created desc";
        parent::admin_index();
    }

    function admin_add_export() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                if (!empty($this->data['Sale']['exchange_rate'])) {
                    $temp = ic_number_reverse($this->data['Sale']['exchange_rate']);
                }
                $this->Sale->data["Sale"]["grand_total"] = ac_number_reverse($this->Sale->data["Sale"]["grand_total"]);
                foreach ($this->Sale->data["SaleDetail"] as &$saleDetail) {
                    $saleDetail["total"] = ac_number_reverse($saleDetail["total"]);
                }
                $this->{ Inflector::classify($this->name) }->data['Sale']['exchange_rate'] = $temp;
                $this->{ Inflector::classify($this->name) }->data['Sale']['sale_no'] = $this->_generateSaleNo();
                $this->{ Inflector::classify($this->name) }->data['Sale']['verify_status_id'] = 1;
                if ($this->{ Inflector::classify($this->name) }->data['Sale']['shipment_payment_type_id'] == 2) {
                    $this->{ Inflector::classify($this->name) }->data['Sale']['grand_total'] = $this->Sale->data['Sale']['grand_total'] + $this->Sale->data['Sale']['shipping_cost'];
                    $this->{ Inflector::classify($this->name) }->data['Sale']['remaining'] = $this->{ Inflector::classify($this->name) }->data['Sale']['grand_total'];
                } else if ($this->{ Inflector::classify($this->name) }->data['Sale']['shipment_payment_type_id'] == 1) {
                    $this->{ Inflector::classify($this->name) }->data['Sale']['remaining'] = $this->Sale->data['Sale']['grand_total'];
                }
                $this->{ Inflector::classify($this->name) }->data['Sale']['branch_office_id'] = $this->Session->read("credential.admin.Employee.branch_office_id");
                if (isset($this->data['SaleFile']) && !empty($this->data['SaleFile'])) {
                    foreach ($this->data['SaleFile'] as $k => $details) {
                        if (!empty($details['file']['name'])) {
                            App::import("Vendor", "qqUploader");
                            $allowedExt = array("jpg", "jpeg", "png", "pdf", "doc", "docx", "xls", "xlsx");
                            $size = 10 * 1024 * 1024;
                            $uploader = new qqFileUploader($allowedExt, $size, $this->Sale->data['SaleFile'][$k]['file'], true);
                            $result = $uploader->handleUpload("sale_eksport" . DS);
                            switch ($result['status']) {
                                case 206:
                                    $this->Sale->data['SaleFile'][$k]['AssetFile'] = array(
                                        "folder" => $result['data']['folder'],
                                        "filename" => $result['data']['fileName'],
                                        "ext" => $result['data']['ext'],
                                        "is_private" => true,
                                    );
                                    break;
                            }
                            unset($this->Sale->data['SaleFile'][$k]['gambar']);
                        }
                    }
                }
                /* adding to the journal */
//                $sale_type_id = 2;
//                $initial_balance_id = 2;
//                $dataInitialBalance = ClassRegistry::init("InitialBalance")->find("first", [
//                    "conditions" => [
//                        "InitialBalance.id" => $initial_balance_id
//                    ]
//                ]);
//                $this->Sale->data['GeneralEntry'][0]['reference_number'] = $this->generateReferenceNumber($sale_type_id);
//                $this->Sale->data['GeneralEntry'][0]['transaction_name'] = "Piutang Export";
//                $this->Sale->data['GeneralEntry'][0]['transaction_date'] = date("Y-m-d");
//                $this->Sale->data['GeneralEntry'][0]['transaction_type_id'] = 3;
//                $this->Sale->data['GeneralEntry'][0]['general_entry_type_id'] = 34;
//                $this->Sale->data['GeneralEntry'][0]['debit'] = $this->{ Inflector::classify($this->name) }->data['Sale']['grand_total'];
//                $this->Sale->data['GeneralEntry'][0]['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
//                $this->Sale->data['GeneralEntry'][0]['mutation_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
//                $this->Sale->data['GeneralEntry'][0]['initial_balance_id'] = $initial_balance_id;
//                $this->Sale->data['GeneralEntry'][0]['general_entry_account_type_id'] = 2;
//                $this->Sale->data['GeneralEntry'][1]['reference_number'] = $this->generateReferenceNumber($sale_type_id);
//                $this->Sale->data['GeneralEntry'][1]['transaction_name'] = "Penjualan Export";
//                $this->Sale->data['GeneralEntry'][1]['transaction_date'] = date("Y-m-d");
//                $this->Sale->data['GeneralEntry'][1]['transaction_type_id'] = 3;
//                $this->Sale->data['GeneralEntry'][1]['general_entry_type_id'] = 8;
//                $this->Sale->data['GeneralEntry'][1]['credit'] = $this->{ Inflector::classify($this->name) }->data['Sale']['grand_total'];
//                $this->Sale->data['GeneralEntry'][1]['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
//                $this->Sale->data['GeneralEntry'][1]['mutation_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
//                $this->Sale->data['GeneralEntry'][1]['initial_balance_id'] = $initial_balance_id;
//                $this->Sale->data['GeneralEntry'][1]['general_entry_account_type_id'] = 2;

                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                //make package detail
//                ClassRegistry::init("PackageDetail")->generatePackageDetail($this->Sale->getLastInsertID());
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_add_local() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->_numberSeperatorRemover();
                $this->{ Inflector::classify($this->name) }->data['Sale']['sale_no'] = $this->_generateSaleNo();
                $this->{ Inflector::classify($this->name) }->data['Sale']['verify_status_id'] = 1;
                if ($this->{ Inflector::classify($this->name) }->data['Sale']['shipment_payment_type_id'] == 2) {
                    $this->{ Inflector::classify($this->name) }->data['Sale']['grand_total'] = $this->Sale->data['Sale']['grand_total'] + $this->Sale->data['Sale']['shipping_cost'];
                    $this->{ Inflector::classify($this->name) }->data['Sale']['remaining'] = $this->{ Inflector::classify($this->name) }->data['Sale']['grand_total'];
                } else if ($this->{ Inflector::classify($this->name) }->data['Sale']['shipment_payment_type_id'] == 1) {
                    $this->{ Inflector::classify($this->name) }->data['Sale']['remaining'] = $this->Sale->data['Sale']['grand_total'];
                }
                $this->{ Inflector::classify($this->name) }->data['Sale']['branch_office_id'] = $this->Session->read("credential.admin.Employee.branch_office_id");
                if (isset($this->data['SaleFile']) && !empty($this->data['SaleFile'])) {
                    foreach ($this->data['SaleFile'] as $k => $details) {
                        if (!empty($details['file']['name'])) {
                            App::import("Vendor", "qqUploader");
                            $allowedExt = array("jpg", "jpeg", "png", "pdf");
                            $size = 10 * 1024 * 1024;
                            $uploader = new qqFileUploader($allowedExt, $size, $this->Sale->data['SaleFile'][$k]['file'], true);
                            $result = $uploader->handleUpload("sale_lokal" . DS);
                            switch ($result['status']) {
                                case 206:
                                    $this->Sale->data['SaleFile'][$k]['AssetFile'] = array(
                                        "folder" => $result['data']['folder'],
                                        "filename" => $result['data']['fileName'],
                                        "ext" => $result['data']['ext'],
                                        "is_private" => true,
                                    );
                                    break;
                            }
                            unset($this->Sale->data['SaleFile'][$k]['gambar']);
                        }
                    }
                }
                /* adding to the journal */
//                $sale_type_id = 2;
//                $initial_balance_id = 1;
//                $dataInitialBalance = ClassRegistry::init("InitialBalance")->find("first", [
//                    "conditions" => [
//                        "InitialBalance.id" => $initial_balance_id
//                    ]
//                ]);
//                $this->Sale->data['GeneralEntry'][0]['reference_number'] = $this->generateReferenceNumber($sale_type_id);
//                $this->Sale->data['GeneralEntry'][0]['transaction_name'] = "Piutang Lokal";
//                $this->Sale->data['GeneralEntry'][0]['transaction_date'] = date("Y-m-d");
//                $this->Sale->data['GeneralEntry'][0]['transaction_type_id'] = 3;
//                $this->Sale->data['GeneralEntry'][0]['general_entry_type_id'] = 39;
//                $this->Sale->data['GeneralEntry'][0]['debit'] = $this->{ Inflector::classify($this->name) }->data['Sale']['grand_total'];
//                $this->Sale->data['GeneralEntry'][0]['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
//                $this->Sale->data['GeneralEntry'][0]['mutation_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
//                $this->Sale->data['GeneralEntry'][0]['initial_balance_id'] = $initial_balance_id;
//                $this->Sale->data['GeneralEntry'][0]['general_entry_account_type_id'] = 2;
//                $this->Sale->data['GeneralEntry'][1]['reference_number'] = $this->generateReferenceNumber($sale_type_id);
//                $this->Sale->data['GeneralEntry'][1]['transaction_name'] = "Penjualan Lokal";
//                $this->Sale->data['GeneralEntry'][1]['transaction_date'] = date("Y-m-d");
//                $this->Sale->data['GeneralEntry'][1]['transaction_type_id'] = 3;
//                $this->Sale->data['GeneralEntry'][1]['general_entry_type_id'] = 31;
//                $this->Sale->data['GeneralEntry'][1]['credit'] = $this->{ Inflector::classify($this->name) }->data['Sale']['grand_total'];
//                $this->Sale->data['GeneralEntry'][1]['initial_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
//                $this->Sale->data['GeneralEntry'][1]['mutation_balance'] = $dataInitialBalance['InitialBalance']['nominal'];
//                $this->Sale->data['GeneralEntry'][1]['initial_balance_id'] = $initial_balance_id;
//                $this->Sale->data['GeneralEntry'][1]['general_entry_account_type_id'] = 2;
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
//                ClassRegistry::init("PackageDetail")->generatePackageDetail($this->Sale->getLastInsertID());
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_edit_export($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    foreach ($this->Sale->data["SaleDetail"] as &$saleDetail) {
                        $saleDetail["nett_weight"] = ac_number_reverse($saleDetail["nett_weight"]);
                    }
                    if (!is_null($id)) {
                        if (isset($this->data['SaleFile']) && !empty($this->data['SaleFile'])) {
                            foreach ($this->data['SaleFile'] as $k => $details) {
                                if (!empty($details['file']['name'])) {
                                    App::import("Vendor", "qqUploader");
                                    $allowedExt = array("jpg", "jpeg", "png", "pdf");
                                    $size = 10 * 1024 * 1024;
                                    $uploader = new qqFileUploader($allowedExt, $size, $this->Sale->data['SaleFile'][$k]['file'], true);
                                    $result = $uploader->handleUpload("sale_lokal" . DS);
                                    switch ($result['status']) {
                                        case 206:
                                            $this->Sale->data['SaleFile'][$k]['AssetFile'] = array(
                                                "folder" => $result['data']['folder'],
                                                "filename" => $result['data']['fileName'],
                                                "ext" => $result['data']['ext'],
                                                "is_private" => true,
                                            );
                                            break;
                                    }
                                    unset($this->Sale->data['SaleFile'][$k]['gambar']);
                                }
                            }
                        }
                        $this->{ Inflector::classify($this->name) }->data['Sale']['verify_status_id'] = 1;
                        $this->{ Inflector::classify($this->name) }->data['Sale']['remaining'] = $this->{ Inflector::classify($this->name) }->data['Sale']['grand_total'];
                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                        $this->redirect(array('action' => 'admin_index'));
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

    function admin_edit_local($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    if (!is_null($id)) {
                        if (isset($this->data['SaleFile']) && !empty($this->data['SaleFile'])) {
                            foreach ($this->data['SaleFile'] as $k => $details) {
                                if (!empty($details['file']['name'])) {
                                    App::import("Vendor", "qqUploader");
                                    $allowedExt = array("jpg", "jpeg", "png", "pdf");
                                    $size = 10 * 1024 * 1024;
                                    $uploader = new qqFileUploader($allowedExt, $size, $this->Sale->data['SaleFile'][$k]['file'], true);
                                    $result = $uploader->handleUpload("sale_lokal" . DS);
                                    switch ($result['status']) {
                                        case 206:
                                            $this->Sale->data['SaleFile'][$k]['AssetFile'] = array(
                                                "folder" => $result['data']['folder'],
                                                "filename" => $result['data']['fileName'],
                                                "ext" => $result['data']['ext'],
                                                "is_private" => true,
                                            );
                                            break;
                                    }
                                    unset($this->Sale->data['SaleFile'][$k]['gambar']);
                                }
                            }
                        }
                        $this->{ Inflector::classify($this->name) }->_numberSeperatorRemover();
                        $this->{ Inflector::classify($this->name) }->data['Sale']['verify_status_id'] = 1;
                        $this->{ Inflector::classify($this->name) }->data['Sale']['remaining'] = $this->{ Inflector::classify($this->name) }->data['Sale']['grand_total'];
                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                        $this->redirect(array('action' => 'admin_index'));
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

    function admin_index_status() {
        $this->_activePrint(func_get_args(), "data_produksi_tahap4");
        $conds = $this->_filter($_GET, $this->filterCond);
        if (empty($conds)) {
            $conds = $this->defaultConds;
        }
        $conds['AND'] = am($conds, array(
                ), $this->conds);
        if ($this->order === false) {
            $this->order = Inflector::classify($this->name) . '.created desc';
        }
        $this->Paginator->settings = array(
            Inflector::classify($this->name) => array(
                'conditions' => $conds,
                'limit' => $this->paginate['limit'],
                'maxLimit' => $this->paginate['maxLimit'],
                'order' => $this->order,
                'recursive' => -1,
                'contain' => $this->contain,
            )
        );
        $rows = $this->Paginator->paginate($this->{ Inflector::classify($this->name) });
        $data = array(
            'rows' => $rows,
//            'rows' => [],
        );
        $this->set(compact('data'));
//        if ($this->args === false) {
//            $args = func_get_args();
//        } else {
//            $args = $this->args;
//        }
//        if (isset($args[0])) {
//            $jenis = $args[0];
//            $this->cetak = $jenis;
//                $this->render($this->cetak_template);
//        }
    }

    function admin_print_nota($id = null) {
        $this->_activePrint(["print"], "nota_sale", "print_plain");
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.id' => $id,
            ),
            'contain' => [
                "SaleDetail" => [
                    "ProductSize" => [
                        "Product",
                        "ProductUnit"
                    ]
                ],
                "Buyer"
            ],
        ));

        $this->data = $rows;
        $data = array(
            'title' => 'Nota Penjualan Ikan',
            'rows' => $rows,
        );
//        debug($data);
//        die;
        $this->set(compact('data'));
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("buyerTypes", ClassRegistry::init("BuyerType")->find("list", array("fields" => array("BuyerType.id", "BuyerType.name"))));
        $this->set("verifyStatuses", ClassRegistry::init("VerifyStatus")->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))));
        $this->set("buyerLocals", ClassRegistry::init("Buyer")->find("list", array("fields" => array("Buyer.id", "Buyer.company_name"), "conditions" => array("BuyerType.id" => 1), "contain" => array("BuyerType"))));
        $this->set("buyerExports", ClassRegistry::init("Buyer")->find("list", array("fields" => array("Buyer.id", "Buyer.company_name"), "conditions" => array("BuyerType.id" => 2), "contain" => array("BuyerType"))));
        $this->set("branchOffices", $this->Sale->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("shipmentPaymentTypes", $this->Sale->ShipmentPaymentType->find("list", array("fields" => array("ShipmentPaymentType.id", "ShipmentPaymentType.name"))));
        $this->set("packagingStatuses", ClassRegistry::init("ProductionCommonStatus")->getList("packaging"));
        $this->set("buyers", ClassRegistry::init("Buyer")->find("list", array("fields" => array("Buyer.id", "Buyer.company_name"))));
        $this->set("mcWeights", ClassRegistry::init("McWeight")->find("list", array("fields" => array("McWeight.id", "McWeight.label_lbs"), "order" => "McWeight.label_lbs asc")));
        $this->set("dataMcWeight", ClassRegistry::init("McWeight")->find("all", ["order" => "McWeight.lbs asc"]));
        $this->set("products", $this->Sale->SaleDetail->Product->find("list", ["fields" => ["Product.id", "Product.name"]]));
        $this->set("dataProduct", ClassRegistry::init("Product")->find('all', array("fields" => array("Product.id", "Product.name"), "contain" => array("Child"), "conditions" => ["Product.parent_id is null"])));
    }

    function admin_get_sale_list($id = null) {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->find('all', array(
            "fields" => array(
                "Sale.sale_no",
                "Buyer.company_name"
            ),
            "conditions" => array(
                "Sale.id" => $id
            ),
            "contain" => array(
                "Buyer",
                "SaleDetail" => [
                    "TreatmentProduct" => [
                    ]
//                    "fields" => [
//                        "TransactionMaterialEntry.material_id",
//                        "TransactionMaterialEntry.quantity"
//                    ]
                ]
        )));
        echo json_encode($data);
    }

    function admin_sale_setup() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->data["Buyer"]["buyer_type_id"] == 1) {
                $this->redirect(array('action' => 'admin_add_local'));
            } else if ($this->data["Buyer"]["buyer_type_id"] == 2) {
                $this->redirect(array('action' => 'admin_add_export'));
            }
        }
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Sale.sale_no like" => "%$q%",
                    "Sale.po_number like" => "%$q%",
            ));
        }
        if (isset($this->request->query['type'])) {
            switch ($this->request->query['type']) {
                case "validate";
                    $conds[] = [
                        "Sale.remaining >" => 0,
                        "Sale.verify_status_id" => 1
                    ];
                    break;
            }
        }
        $suggestions = ClassRegistry::init("Sale")->find("all", array(
            "conditions" => $conds,
            "contain" => array(
                "PaymentSale",
                "Buyer" => [
                    "BuyerType"
                ],
            ),
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item['Sale'])) {
                $result[] = [
                    "id" => $item['Sale']['id'],
                    "sale_no" => $item['Sale']['sale_no'],
                    "po_number" => $item['Sale']['po_number'],
                    "sale_no_po_number" => $item['Sale']['sale_no'] . " | " . $item['Sale']['po_number'],
                    "buyer_name" => $item['Buyer']['company_name'],
                    "buyer_type_id" => $item['Buyer']['buyer_type_id'],
                    "total_invoice" => @$item['Sale']['grand_total'],
                ];
            }
        }
        echo json_encode($result);
    }

    //Untuk Shipment. Dicari yang 
    function admin_list_shipment() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Sale.sale_no like" => "%$q%",
                    "Sale.po_number like" => "%$q%",
                ),
            );
        }
        $suggestions = ClassRegistry::init("Sale")->find("all", array(
            "conditions" => array(
                $conds,
                "Sale.shipment_status" => 0,
                "Sale.verify_status_id" => 3,
            ),
            "contain" => array(
                "PaymentSale",
                "Buyer" => [
                    "BuyerType"
                ],
            ),
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item['Sale'])) {
                $result[] = [
                    "id" => $item['Sale']['id'],
                    "sale_no" => $item['Sale']['sale_no'],
                    "po_number" => $item['Sale']['po_number'],
                    "sale_no_po_number" => $item['Sale']['sale_no'] . " | " . $item['Sale']['po_number'],
                    "buyer_name" => $item['Buyer']['company_name'],
                    "buyer_type_id" => $item['Buyer']['buyer_type_id'],
                    "total_invoice" => @$item['Sale']['grand_total'],
                ];
            }
        }
        echo json_encode($result);
    }

    function admin_list_po_number() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Sale.po_number like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("Sale")->find("all", array(
            "conditions" => $conds,
            "contain" => array(
                "PaymentSale",
                "Buyer",
            ),
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item['Sale'])) {
                $result[] = [
                    "id" => $item['Sale']['id'],
                    "po_number" => $item['Sale']['po_number'],
                    "buyer_name" => $item['Buyer']['company_name'],
                    "total_invoice" => @$item['Sale']['grand_total'],
                ];
            }
        }
        echo json_encode($result);
    }

    function view_data_sales_boxes($id = null) {
        $this->autoRender = false;
        if ($this->Sale->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->Sale->find("first", [
                    "conditions" => [
                        "Sale.id" => $id
                    ],
                    "contain" => [
                        "Package" => [
                            "PackageDetail" => [
                                "Product" => [
                                    "Parent"
                                ]
                            ]
                        ]
                    ]
                ]);
                echo json_encode($data);
            } else {
                echo json_encode($this->_generateStatusCode(400));
            }
        } else {
            echo json_encode($this->_generateStatusCode(401));
        }
    }

    function admin_view_data_sale($id = null) {
        $this->autoRender = false;
        if ($this->{ Inflector::classify($this->name) }->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->{ Inflector::classify($this->name) }->find("first", [
                    "conditions" => [
                        "Sale.id" => $id
                    ],
                    "contain" => [
                        "Buyer" => [
                            "City",
                            "State",
                            "Country",
                            "CpCity",
                            "CpState",
                            "CpCountry"
                        ],
                        "ShipmentPaymentType",
                        "SaleDetail" => [
                            "Product" => [
                                "Parent",
                                "ProductUnit"
                            ],
                            "McWeight"
                        ],
                        "Shipment" => [
                            "ShipmentAgent"
                        ]
                    ],
                ]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function admin_rekapitulasi_per_buyer() {
        $this->_activePrint(func_get_args(), "report_rekapitulasi_per_buyer", ["excel" => "excel", "print" => "print_tanpa_kop"]);
        $conds = [];
        if (isset($this->request->query['start_date']) && !empty($this->request->query['start_date']) && isset($this->request->query['end_date']) && !empty($this->request->query['end_date']) && isset($this->request->query['buyer_id']) && !empty($this->request->query['buyer_id'])) {
            $startDate = $this->request->query['start_date'];
            $endDate = $this->request->query['end_date'];
            $buyerId = $this->request->query['buyer_id'];
        } else {
            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d');
            $buyerId = 0;
        }
        if (isset($this->request->query['Sale_branch_office_id']) && !empty($this->request->query['Sale_branch_office_id'])) {
            $conds = [
                "Sale.branch_office_id" => $this->request->query['Sale_branch_office_id']
            ];
        }
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.created > ' => $startDate . " 00:00:00",
                Inflector::classify($this->name) . '.created <=' => $endDate . " 23:59:59",
                Inflector::classify($this->name) . '.buyer_id' => $buyerId,
                $conds
            ),
            'contain' => [
                "Buyer",
                "SaleDetail" => [
                    "Product" => [
                        "Parent",
                        "ProductUnit"
                    ]
                ],
                "Shipment",
                "PaymentSale"
            ],
        ));
        $data = array(
            'title' => 'Rekapitulasi Export',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_print_rekapitulasi_per_buyer($startDate, $endDate, $buyerId) {
        $this->_activePrint(["print"], "report_rekapitulasi_per_buyer", "print_tanpa_kop");
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.created > ' => $startDate . " 00:00:00",
                Inflector::classify($this->name) . '.created <=' => $endDate . " 23:59:59",
                Inflector::classify($this->name) . '.buyer_id' => $buyerId,
            ),
            'contain' => [
                "Buyer",
                "SaleDetail" => [
                    "Product" => [
                        "Parent",
                        "ProductUnit"
                    ]
                ],
                "Shipment",
                "PaymentSale"
            ],
        ));
        $data = array(
            'title' => 'Rekapitulasi Export',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_rekapitulasi_per_month() {
        $this->_activePrint(func_get_args(), "report_rekapitulasi_per_month", ["excel" => "excel", "print" => "print_tanpa_kop"]);
        $conds = [];
        if (isset($this->request->query['Laporan_bulan']) && !empty($this->request->query['Laporan_bulan']) && isset($this->request->query['Laporan_tahun']) && !empty($this->request->query['Laporan_tahun'])) {
            $month = $this->request->query['Laporan_bulan'];
            $year = $this->request->query['Laporan_tahun'];
        } else {
            $month = date('m');
            $year = date('Y');
        }
        if (isset($this->request->query['Sale_branch_office_id']) && !empty($this->request->query['Sale_branch_office_id'])) {
            $conds = [
                "Sale.branch_office_id" => $this->request->query['Sale_branch_office_id']
            ];
        }
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                "DATE_FORMAT(Sale.created, '%c')" => $month,
                "DATE_FORMAT(Sale.created, '%Y')" => $year,
                $conds
            ),
            'contain' => [
                "Buyer",
                "SaleDetail" => [
                    "Product" => [
                        "Parent",
                        "ProductUnit"
                    ]
                ],
                "Shipment",
                "PaymentSale"
            ],
        ));
        $data = array(
            'title' => 'Rekapitulasi Export Per Bulan',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_print_rekapitulasi_per_month($month = null, $year = null) {
        $this->_activePrint(["print"], "report_rekapitulasi_per_month", "print_tanpa_kop");
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                "DATE_FORMAT(Sale.created, '%c')" => $month,
                "DATE_FORMAT(Sale.created, '%Y')" => $year,
            ),
            'contain' => [
                "Buyer",
                "SaleDetail" => [
                    "Product" => [
                        "Parent",
                        "ProductUnit"
                    ]
                ],
                "Shipment",
                "PaymentSale"
            ],
        ));
        $data = array(
            'title' => 'Rekapitulasi Export Per Bulan',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_sales_report() {
        $this->_activePrint(func_get_args(), "report_sales", ["excel" => "excel", "print" => "print_tanpa_kop"]);
        if (isset($this->request->query['Laporan_bulan']) && !empty($this->request->query['Laporan_bulan']) && isset($this->request->query['Laporan_tahun']) && !empty($this->request->query['Laporan_tahun'])) {
            $month = $this->request->query['Laporan_bulan'];
            $year = $this->request->query['Laporan_tahun'];
        } else {
            $month = date('m');
            $year = date('Y');
        }
        if (isset($this->request->query['Laporan_kurs']) && !empty($this->request->query['Laporan_kurs'])) {
            $kurs = $this->request->query['Laporan_kurs'];
        } else {
            $kurs = 0;
        }
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                "DATE_FORMAT(Sale.created, '%c')" => $month,
                "DATE_FORMAT(Sale.created, '%Y')" => $year,
            ),
            'contain' => [
                "Buyer",
                "SaleDetail" => [
                    "Product" => [
                        "Parent",
                        "ProductUnit"
                    ]
                ],
                "Shipment",
                "PaymentSale"
            ],
        ));
        $data = array(
            'title' => 'Laporan Penjualan',
            'rows' => $rows,
            'month' => $month,
            'year' => $year,
            'kurs' => $kurs,
        );
        $this->set(compact('data', 'kurss'));
    }

    function admin_print_sales_report($month = null, $year = null) {
        $this->_activePrint(["print"], "report_sales", "print_tanpa_kop");
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                "DATE_FORMAT(Sale.created, '%c')" => $month,
                "DATE_FORMAT(Sale.created, '%Y')" => $year,
            ),
            'contain' => [
                "Buyer",
                "SaleDetail" => [
                    "Product" => [
                        "Parent",
                        "ProductUnit"
                    ]
                ],
                "Shipment",
                "PaymentSale"
            ],
        ));
        $data = array(
            'title' => 'Laporan Penjualan',
            'rows' => $rows,
            'month' => $month,
            'year' => $year,
        );
        $this->set(compact('data'));
    }

    function _generateSaleNo() {
        $inc_id = 1;
        $month = romanic_number(date("n"));
        $year = date("Y");
        $testCode = "[0-9]{4}/SALE-PRO/$month/$year";
        $lastRecord = $this->Sale->find('first', array('conditions' => array('and' => array("Sale.sale_no regexp" => $testCode)), 'order' => array('Sale.sale_no' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = substr($lastRecord["Sale"]["sale_no"], 0, 4);
            $inc_id += $current;
        }
        $inc_id = sprintf("%04d", $inc_id);
        $kode = "$inc_id/SALE-PRO/$month/$year";
        return $kode;
    }

    function admin_list_lunas() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Sale.sale_no like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("Sale")->find("all", array(
            "conditions" => [
                $conds,
                "Sale.remaining <=" => 0,
            ],
            "contain" => [
                "PaymentSale",
                "Buyer" => [
                    "BuyerType",
                    "City",
                    "State",
                    "Country",
                    "CpCity",
                    "CpState",
                    "CpCountry"
                ],
                "BranchOffice"
            ],
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Sale']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => @$item['Sale']['id'],
                        "sale_no" => @$item['Sale']['sale_no'],
                        "invoice_id" => @$item['PaymentSale'][0]['id'],
                        "grand_total" => @$item['Sale']['grand_total'],
                        "remaining" => @$item['Sale']['remaining'],
                        "buyer_id" => @$item['Sale']['buyer_id'],
                        "buyer_type_id" => @$item['Buyer']['buyer_type_id'],
                        "company_name" => @$item['Buyer']['company_name'],
                        "company_email" => @$item['Buyer']['email'],
                        "company_address" => @$item['Buyer']['address'],
                        "company_postal_code" => @$item['Buyer']['postal_code'],
                        "company_phone" => @$item['Buyer']['phone_number'],
                        "company_website" => @$item['Buyer']['website'],
                        "company_city" => @$item['Buyer']['City']['name'],
                        "company_state" => @$item['Buyer']['State']['name'],
                        "company_country" => @$item['Buyer']['Country']['name'],
                        "cp_name" => @$item['Buyer']['cp_name'],
                        "cp_position" => @$item['Buyer']['cp_position'],
                        "cp_address" => @$item['Buyer']['cp_address'],
                        "cp_phone_number" => @$item['Buyer']['cp_phone_number'],
                        "cp_email" => @$item['Buyer']['cp_email'],
                        "cp_city" => @$item['Buyer']['CpCity']['name'],
                        "cp_state" => @$item['Buyer']['CpState']['name'],
                        "cp_country" => @$item['Buyer']['CpCountry']['name'],
                        "branch_office_id" => @$item['Sale']['branch_office_id'],
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function admin_list_hutang($id) {
        $this->autoRender = false;
        $conds = [];
        if ($id != null) {
            $conds [] = [
                "Buyer.buyer_type_id" => $id,
            ];
        }
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Sale.sale_no like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("Sale")->find("all", array(
            "conditions" => [
                $conds,
                "Sale.remaining >" => 0,
                "Sale.verify_status_id" => 3
            ],
            "contain" => [
                "PaymentSale",
                "Buyer" => [
                    "City",
                    "State",
                    "Country",
                    "CpCity",
                    "CpState",
                    "CpCountry"
                ],
                "ShipmentPaymentType",
                "Shipment" => [
                    "ShipmentAgent"
                ],
            ],
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Sale']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => @$item['Sale']['id'],
                        "sale_no" => @$item['Sale']['sale_no'],
                        "shipping_cost" => @$item['Sale']['shipping_cost'],
                        "invoice_id" => @$item['PaymentSale'][0]['id'],
                        "total_invoice" => @$item['Sale']['grand_total'],
                        "exchange_rate" => @$item['Sale']['exchange_rate'],
                        "buyer_id" => @$item['Sale']['buyer_id'],
                        "company_name" => @$item['Buyer']['company_name'],
                        "company_email" => @$item['Buyer']['email'],
                        "company_address" => @$item['Buyer']['address'],
                        "company_postal_code" => @$item['Buyer']['postal_code'],
                        "company_phone" => @$item['Buyer']['phone_number'],
                        "company_website" => @$item['Buyer']['website'],
                        "company_city" => @$item['Buyer']['City']['name'],
                        "company_state" => @$item['Buyer']['State']['name'],
                        "company_country" => @$item['Buyer']['Country']['name'],
                        "cp_name" => @$item['Buyer']['cp_name'],
                        "cp_position" => @$item['Buyer']['cp_position'],
                        "cp_address" => @$item['Buyer']['cp_address'],
                        "cp_phone_number" => @$item['Buyer']['cp_phone_number'],
                        "cp_email" => @$item['Buyer']['cp_email'],
                        "cp_city" => @$item['Buyer']['CpCity']['name'],
                        "cp_state" => @$item['Buyer']['CpState']['name'],
                        "cp_country" => @$item['Buyer']['CpCountry']['name'],
                        "shipment_payment_type" => @$item['ShipmentPaymentType']['name'],
                        "shipment_payment_type_id" => @$item['ShipmentPaymentType']['id'],
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function admin_list_hutang_index() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Sale.sale_no like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("Sale")->find("all", array(
            "conditions" => [
                $conds,
                "Sale.remaining >" => 0,
                "Sale.verify_status_id" => 3
            ],
            "contain" => [
                "PaymentSale",
                "Buyer",
                "ShipmentPaymentType",
                "Shipment" => [
                    "ShipmentAgent"
                ],
            ],
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                if ($item['Sale']['branch_office_id'] == $this->Session->read("credential.admin.Employee.branch_office_id")) {
                    $result[] = [
                        "id" => @$item['Sale']['id'],
                        "sale_no" => @$item['Sale']['sale_no'],
                        "shipping_cost" => @$item['Sale']['shipping_cost'],
                        "invoice_id" => @$item['PaymentSale'][0]['id'],
                        "total_invoice" => @$item['Sale']['grand_total'],
                        "exchange_rate" => @$item['Sale']['exchange_rate'],
                        "buyer_id" => @$item['Sale']['buyer_id'],
                        "company_name" => @$item['Buyer']['company_name'],
                        "contact_person" => @$item['Buyer']['contact_person'],
                        "company_address" => @$item['Buyer']['address'],
                        "company_city" => @$item['Buyer']['city'],
                        "company_state" => @$item['Buyer']['state'],
                        "company_phone" => @$item['Buyer']['phone_number'],
                        "company_hp" => @$item['Buyer']['handphone_number'],
                        "company_email" => @$item['Buyer']['email'],
                        "company_country" => @$item['Buyer']['country'],
                        "shipment_name" => @$item['Shipment']['ShipmentAgent']['name'],
                        "shipment_number" => @$item['Shipment']['shipment_number'],
                        "seal_number" => @$item['Shipment']['seal_number'],
                        "anova_po" => @$item['Shipment']['anova_po'],
                        "from_dock" => @$item['Shipment']['from_dock'],
                        "to_dock" => @$item['Shipment']['to_dock'],
                        "bl_number" => @$item['Shipment']['bl_number'],
                        "fda_reg_no" => @$item['Shipment']['fda_reg_no'],
                        "container_number" => @$item['Shipment']['container_number'],
                        "shipment_payment_type" => @$item['ShipmentPaymentType']['name'],
                        "shipment_payment_type_id" => @$item['ShipmentPaymentType']['id'],
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    function admin_account_receivable_product_list() {
        $this->_activePrint(func_get_args(), "data_piutang_usaha");
        $this->_setPeriodeLaporanDate("awal_Sale_due_date", "akhir_Sale_due_date");
        $this->contain = [
            "PaymentSale" => [
                "order" => "PaymentSale.id DESC",
                "conditions" => [
                ],
                "limit" => 1,
            ],
            "BranchOffice",
            "Buyer"
        ];
        $this->conds = [
            "Sale.remaining >" => 0,
            "Sale.verify_status_id" => 3,
        ];
        parent::admin_index();
    }

    function admin_invoice_sale_payment() {
        $this->_activePrint(func_get_args(), "data_invoice_penjualan");
        $this->_setPeriodeLaporanDate("awal_Sale_due_date", "akhir_Sale_due_date");
        $this->contain = [
            "SaleDetail" => [
                "Product" => [
                    "Parent"
                ]
            ],
            "Buyer",
            "BranchOffice"
        ];
        $this->conds = [
            "Sale.shipment_status" => 1,
            "Sale.verify_status_id" => 3,
        ];
        $this->order = [
            "Sale.due_date DESC"
        ];
        parent::admin_index();
    }

    function admin_invoice_sale_payment_view($id = null) {
        if (!$this->Sale->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->Sale->data['Sale']['id'] = $id;
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                'conditions' => array(Inflector::classify($this->name) . ".id" => $id),
                "recursive" => -1,
                "contain" => [
                    "SaleDetail" => [
                        "Product" => [
                            "Parent"
                        ]
                    ],
                ]
            ));
            $this->data = $rows;
        }
    }

    function admin_get_product($saleId) {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->SaleDetail->find('all', array(
            "fields" => array(
            //"Product.id", "Product.name"
            ),
            "contain" => array(
                "Product" => [
                    "Parent"
                ],
            ),
            "conditions" => [
                "Sale.id" => $saleId,
            ]
        ));
        debug($data);
        echo json_encode($data);
    }

    function admin_print_invoice_sale_payment($id = null) {
        $this->_activePrint(["print"], "print_invoice_sale_payment", "invoice_penjualan");
        $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.id' => $id,
                "Buyer.buyer_type_id" => 2,
            ),
            "contain" => [
                "SaleDetail" => [
                    "Product" => [
                        "Parent"
                    ],
                    "McWeight"
                ],
                "PaymentSale",
                "Shipment" => [
                    "ShipmentAgent"
                ],
                "Buyer" => [
                    "City",
                    "State",
                    "Country",
                    "BuyerType"
                ]
            ]
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'Invoice',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_print_invoice_sale_payment_local($id = null) {
        $this->_activePrint(["print"], "print_invoice_sale_payment_local", "invoice_penjualan");
        $rows = $this->{ Inflector::classify($this->name) }->find('first', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.id' => $id,
                "Buyer.buyer_type_id" => 1,
            ),
            "contain" => [
                "SaleDetail" => [
                    "Product" => [
                        "Parent"
                    ]
                ],
                "PaymentSale",
                "Shipment" => [
                    "ShipmentAgent"
                ],
                "Buyer" => [
                    "City",
                    "Country"
                ]
            ]
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'Invoice',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function ajax_sales() {
        $this->autoRender = false;
        $this->response->type("json");
        if (isset($this->request->query["limit"]) && !empty($this->request->query["limit"])) {
            $limit = $this->request->query["limit"];
        } else {
            $limit = 3;
        }
        if (isset($this->request->query["order"]) && !empty($this->request->query["order"])) {
            $order = $this->request->query["order"];
        } else {
            $order = "Sale.due_date desc";
        }
        if (isset($this->request->query["page"]) && !empty($this->request->query["page"])) {
            $page = $this->request->query["page"];
        } else {
            $page = 1;
        }
        $conds = [
            "Sale.remaining >" => 0,
            "BranchOffice.id" => $this->Session->read("credential.admin.Employee.branch_office_id"),
        ];
        $filter = [
            "page" => $page,
            "order" => $order,
            "limit" => $limit,
            "conditions" => [
                $conds,
            ],
            "contain" => [
                "BranchOffice",
                "Buyer"
            ],
        ];
        $sales = ClassRegistry::init("Sale")->find("all", $filter);
        $count = ClassRegistry::init("Sale")->find("count", [
            "conditions" => $conds,
            "contain" => [
                "BranchOffice"
            ]
        ]);
        $info = [];
        $info['totalItem'] = $count;
        $info['totalPage'] = ceil($count / $limit);
        $info['currentPage'] = $page;
        $info['limit'] = $limit;
        $info['startItem'] = ($page - 1) * $limit + 1;
        $info['endItem'] = $info['startItem'] + $limit - 1;
        if ($info['endItem'] > $info['totalItem']) {
            $info['endItem'] = $info['totalItem'];
        }
        if ($info['totalItem'] == 0 && $info['endItem'] == 0) {
            $info['totalPage'] = 1;
        }
        echo json_encode($this->_generateStatusCode(206, null, ["items" => $sales, "pagination_info" => $info, "filter" => $filter]));
    }

    function generateReferenceNumber($sale_type_id) {
        if (!empty($sale_type_id)) {
            $month = romanic_number(date("n"));
            $year = date("Y");
            $temp = "/$month/$year/";
            $dataSale = $this->Sale->find("first", [
                "order" => "Sale.id DESC"
            ]);
            if (!empty($dataSale)) {
                $current_id = $dataSale['Sale']['id'];
            } else {
                $current_id = 1;
            }
            $no_id = sprintf("%04d", $current_id);
            $code = "$no_id/SALE-PRO/$month/$year";
            return $code;
        }
    }

    function admin_package() {
        $this->_activePrint(func_get_args(), "data_packaging");
        $this->contain = [
            "SaleDetail",
            "Buyer" => [
                "BuyerType"
            ],
            "PackagingStatus",
            "BranchOffice",
        ];
        $this->conds = [
            "Sale.branch_office_id" => $this->stnAdmin->roleBranchId(),
            "Sale.verify_status_id" => 3
        ];
        parent::admin_index();
    }

    function admin_autocount() {
        $this->_activePrint(func_get_args(), "data_perhitungan_pemakaian_material_tambahan");
        $this->contain = [
            "Buyer" => [
                "BuyerType"
            ],
            "BranchOffice"
        ];
        parent::admin_index();
    }

    function admin_print_autocount($id = null) {
        $this->_activePrint(["print"], "print_perhitungan_pemakaian_material_tambahan");
        $sale = ClassRegistry::init("Sale")->find("first", [
            "conditions" => [
                "Sale.id" => $id,
            ],
            "contain" => [
                "Buyer",
                "SaleDetail" => [
                    "Product" => [
                        "Parent",
                        "ProductUnit",
                    ],
                ],
            ],
        ]);
        foreach ($sale["SaleDetail"] as &$saleDetail) {
            $productMaterialAdditional = ClassRegistry::init("ProductMaterialAdditional")->find("first", [
                "conditions" => [
                    "ProductMaterialAdditional.product_id" => $saleDetail["product_id"],
                    "ProductMaterialAdditional.mc_weight_id" => $saleDetail["mc_weight_id"],
                ],
                "contain" => [
                    "MaterialAdditional",
                ],
            ]);
            $saleDetail["McUsage"] = $productMaterialAdditional;
            $productMaterialAdditional = ClassRegistry::init("ProductMaterialAdditional")->find("first", [
                "conditions" => [
                    "ProductMaterialAdditional.product_id" => $saleDetail["product_id"],
                    "ProductMaterialAdditional.material_additional_category_id" => 2,
                ],
                "contain" => [
                    "MaterialAdditional",
                ],
            ]);
            $saleDetail["PlasticUsage"] = $productMaterialAdditional;
        }
        $this->data = $sale;
    }

}
