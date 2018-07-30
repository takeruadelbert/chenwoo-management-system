<?php

App::uses('AppController', 'Controller');

class PackageDetailsController extends AppController {

    var $name = "PackageDetail";
    var $disabledAction = array(
    );
    var $contain = [
        "Sale" => [
            "SaleDetail" => [
                "Product" => [
                    "Parent"
                ],
                "McWeight"
            ],
            "Buyer"
        ],
        "Product" => [
            "ProductUnit",
            "Parent"
        ],
        "BranchOffice",
        "ProductDetail",
        "PackageDetailProduct" => [
            "ProductDetail",
            "PackageDetail"
        ]
    ];

    function admin_view_package($id = null) {
        $id = $this->request->query['sale_id'];
        $type = $this->request->query['type'];
        if ($type == "shipment") {
            $this->Paginator->settings = array(
                Inflector::classify($this->name) => array(
                    'conditions' => ["PackageDetail.sale_id" => $id, "PackageDetail.is_filled" => 1], //Shipment check mc yg udah di load
                    'limit' => $this->paginate['limit'],
                    'maxLimit' => $this->paginate['maxLimit'],
                    'order' => $this->order,
                    'recursive' => -1,
                    'contain' => $this->contain,
                )
            );
        } else {
            $this->Paginator->settings = array(
                Inflector::classify($this->name) => array(
                    'conditions' => ["PackageDetail.sale_id" => $id],
                    'limit' => $this->paginate['limit'],
                    'maxLimit' => $this->paginate['maxLimit'],
                    'order' => $this->order,
                    'recursive' => -1,
                    'contain' => $this->contain,
                )
            );
        }
        $sale = $this->PackageDetail->Sale->find("first", [
            "conditions" => [
                "Sale.id" => $id,
            ],
            "contain" => [
                "Buyer",
                "SaleDetail" => [
                    "Product" => [
                        "Parent",
                    ],
                    "McWeight",
                ],
            ]
        ]);
        $rows = $this->Paginator->paginate($this->{ Inflector::classify($this->name) });
        $data = array(
            'rows' => $rows,
        );
        $this->set(compact('data', 'sale'));
//        $this->conds = [
//            "PackageDetail.sale_id" => $id,
//        ];
//        $this->order = [
//            "PackageDetail.modified DESC",
//        ];
//        parent::admin_index();
    }

    function admin_view_package_product($id = null) {
        if ($id == null) {
            $id = $this->request->query['product_id'];
        }
        $this->Paginator->settings = array(
            Inflector::classify($this->name) => array(
                'conditions' => ['not' =>["PackageDetail.sale_id" => NULL], "PackageDetail.product_id" => $id, "PackageDetail.is_load" => 0], //,"NOT"=>["PackageDetail.is_load" => 0]
                'limit' => $this->paginate['limit'],
                'maxLimit' => $this->paginate['maxLimit'],
                'order' => $this->order,
                'recursive' => -1,
                'contain' => ['Product', "PackageDetailProduct" => ['ProductDetail']],
            )
        );
        $rows = $this->Paginator->paginate($this->{ Inflector::classify($this->name) });
        $data = array(
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_package");
        $this->_setPeriodeLaporanDate("awal_PackageDetail_modified", "akhir_PackageDetail_modified");
        $this->conds = [
            "PackageDetail.is_filled" => 1,
        ];
        $this->contain = [
            "ProductDetail",
            "TreatmentDetail" => [
                "Treatment" => [
                    "Freeze" => [
                        "Conversion" => [
                            "MaterialEntryGradeDetail",
                        ],
                    ],
                ],
            ],
            "Product" => [
                "Parent",
                "ProductUnit",
            ],
            "Sale",
            "BranchOffice"
        ];
        parent::admin_index();
    }

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_stock_ready() {
        if ($this->order === false) {
            $this->order = Inflector::classify($this->name) . '.created desc';
        }
        $this->Paginator->settings = array(
            Inflector::classify($this->name) => array(
                'conditions' => ["NOT"=>["PackageDetail.sale_id" => NULL,"PackageDetail.product_id" => NULL,"PackageDetail.is_load" => 1]],
                'limit' => $this->paginate['limit'],
                'maxLimit' => $this->paginate['maxLimit'],
                'order' => $this->order,
                'recursive' => -1,
                'contain' => ['Product' => ['Parent', 'ProductUnit'], 'BranchOffice'],
                'group' => '`PackageDetail.product_id`',
            )
        );
        $dataProducts = $this->{ Inflector::classify($this->name) }->find('all', array('fields' => ['COUNT(PackageDetail.id) AS count', 'PackageDetail.id', 'PackageDetail.product_id', 'PackageDetail.branch_office_id', 'Product.product_unit_id', "Product.id", "Product.name", "Product.parent_id", "BranchOffice.name"], 'contain' => ['Product' => ['Parent', 'ProductUnit'], 'BranchOffice'], 'group' => ['PackageDetail.product_id'], "conditions" => ["PackageDetail.is_load" => 0, "NOT" => ["PackageDetail.sale_id" => NULL,"PackageDetail.product_id" => NULL]]));
        $rows = $this->Paginator->paginate($this->{ Inflector::classify($this->name) });
        $data = array(
            'dataProducts' => $dataProducts,
        );
        //$data = Set::combine($data, '{n}.ProductDetail.product_id', '{n}.ProductDetail.COUNT(id)');
        $this->set(compact('data'));
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $parents = $this->PackageDetail->Product->find("list", array("fields" => array("Product.id", "Product.name"), "conditions" => array("Product.parent_id" => null)));
        $this->set(compact("parents"));
        $this->set("productLists", $this->PackageDetail->Product->find("list", ["fields" => ["Product.id", "Product.name", "Parent.name"], 'contain' => ["Parent"]]));
        $this->set("branchOffices", ClassRegistry::init("BranchOffice")->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("productUnits", ClassRegistry::init("ProductUnit")->find("list", array("fields" => array("ProductUnit.id", "ProductUnit.name"))));
        $this->set("sales", ClassRegistry::init("Sale")->find("list", array("fields" => array("Sale.id", "Sale.sale_no"), "conditions" => array("Sale.verify_status_id" => 3))));
    }

    function admin_print_trackcode($id = null) {
        $this->_activePrint(["print"], "print_single_barcode", "print_barcode");
        $this->data = $this->PackageDetail->find("first", [
            "conditions" => [
                "PackageDetail.id" => $id,
            ],
            "contain" => [
                "Product" => [
                    "Parent",
                ],
            ],
        ]);
    }

    function admin_reset_package($id = null) {
        $product_id = 0;
        $packageDetailProduct = ClassRegistry::init("PackageDetailProduct")->find("all", array('conditions' => array("PackageDetailProduct.package_detail_id" => $id)));
        foreach ($packageDetailProduct as $detail) {
            ClassRegistry::init("PackageDetailProduct")->delete($detail['PackageDetailProduct']['id']);
            $product_id = $detail['PackageDetail']['product_id'];
        }
        //reset data
        $toUpdatePackageDetail = [
            "PackageDetail" => [
                "id" => $id,
                "sale_id" => NULL,
                "creator_id" => NULL,
                "product_id" => NULL,
                "nett_weight" => 0,
                "brut_weight" => 0,
                "quantity_per_pack" => 0,
            ]
        ];
        if (ClassRegistry::init("PackageDetail")->saveAll($toUpdatePackageDetail)) {
            ClassRegistry::init("PackageDetail")->saveAll($toUpdatePackageDetail);
            $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
            $this->redirect(array('controller' => 'package_details', 'action' => "/view_package_product?product_id=" . $product_id));
        } else {
            $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            $this->redirect(array('controller' => 'package_details', 'action' => "/view_package_product?product_id=" . $product_id));
        }

        //echo "<script>window.close()</script>";
    }

    function admin_print_qr_code($id) {
        $this->_activePrint(["print"], "print_barcode", "print_barcode");
        $data = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id)));
        $this->set(compact('data'));
    }

    function admin_view_data_package_by_sale($id = null) {
        $this->autoRender = false;
        if ($this->request->is("GET")) {
            $data = $this->PackageDetail->find("all", [
                "conditions" => [
                    "PackageDetail.sale_id" => $id
                ],
                "contain" => [
                ]
            ]);
            echo json_encode($this->_generateStatusCode(206, null, $data));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_daily_packaging() {
        $this->_activePrint(func_get_args(), "report_packaging_daily", ["excel" => "excel", "print" => "print_tanpa_kop"]);
        $conds = [];
        if (isset($this->request->query['PackageDetail_date']) && !empty($this->request->query['PackageDetail_date'])) {
            $date = $this->request->query['PackageDetail_date'];
        } else {
            $date = date("Y-m-d");
        }
        if (isset($this->request->query['Package_branch_office_id']) && !empty($this->request->query['Package_branch_office_id'])) {
            $conds = [
                "Package.branch_office_id" => $this->request->query['Package_branch_office_id']
            ];
        }
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                'date(PackageDetail.packaging_dt) ' => $date,
                $conds,
                "NOT" => [
                    "PackageDetail.product_id" => null,
                ],
            ),
            'contain' => [
                "Sale" => [
                    "Buyer"
                ],
                "Product" => [
                    "Parent",
                    "ProductUnit"
                ],
                "Package"
            ],
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'DAILY PACKING REPORT',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_print_packaging_daily($date = null) {
        $this->_activePrint(["print"], "report_packaging_daily", "print_tanpa_kop");
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.created > ' => $date . " 00:00:00",
                Inflector::classify($this->name) . '.created <=' => $date . " 23:59:59",
            ),
            'contain' => [
                "Sale" => [
                    "Buyer"
                ],
                "Product" => [
                    "Parent",
                    "ProductUnit"
                ]
            ],
        ));

        $this->data = $rows;
        $data = array(
            'title' => 'DAILY PACKING REPORT',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_form_packaging() {
        $this->_activePrint(func_get_args(), "form_packaging", ["excel" => "excel", "print" => "print_tanpa_kop"]);
        $conds = [];
        if (isset($this->request->query['start_date']) && !empty($this->request->query['start_date']) && isset($this->request->query['end_date']) && !empty($this->request->query['end_date'])) {
            $dateFrom = $this->request->query['start_date'];
            $dateTo = $this->request->query['end_date'];
        } else {
            $dateFrom = date("Y-m-d");
            $dateTo = date("Y-m-d");
        }
        if (isset($this->request->query['Package_branch_office_id']) && !empty($this->request->query['Package_branch_office_id'])) {
            $conds = [
                "Package.branch_office_id" => $this->request->query['Package_branch_office_id']
            ];
        }
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.created > ' => $dateFrom . " 00:00:00",
                Inflector::classify($this->name) . '.created <=' => $dateTo . " 23:59:59",
                Inflector::classify($this->name) . '.nett_weight !=' => 0,
                $conds
            ),
            'contain' => [
                "Sale" => [
                    "Buyer"
                ],
                "Product" => [
                    "ProductUnit"
                ],
                "Package"
            ],
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'FORM PACKING',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function admin_form_packaging_daily($dateFrom = null, $dateTo = null) {
        $this->_activePrint(["print"], "form_packaging", "print_tanpa_kop");
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.created > ' => $dateFrom . " 00:00:00",
                Inflector::classify($this->name) . '.created <=' => $dateTo . " 23:59:59",
                Inflector::classify($this->name) . '.nett_weight !=' => 0,
            ),
            'contain' => [
                "Sale" => [
                    "Buyer"
                ],
                "Product" => [
                    "ProductUnit"
                ]
            ],
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'FORM PACKING',
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }

    function api_load_to_container() {
        if ($this->request->is("POST")) {
            if ($this->_checkData(["package_no"])) {
                $packageNo = $this->request->data["package_no"];
                $packageDetail = $this->PackageDetail->find("first", array(
                    "recursive" => -1,
                    "conditions" => array(
                        "PackageDetail.package_no" => $packageNo,
                    ),
                ));
                if (!empty($packageDetail)) {
                    if ($packageDetail["PackageDetail"]["is_load"] === false) {
                        if ($packageDetail["PackageDetail"]["sale_id"] === null) {
                            $this->_writeApiResponse($this->_generateStatusCode(405, "Paket data belum lengkap!"));
                        } else {
                            $this->PackageDetail->save([
                                "PackageDetail" => [
                                    "id" => $packageDetail["PackageDetail"]["id"],
                                    "is_load" => 1,
                                    "loader_id" => $this->apiCredential["Employee"]["id"],
                                    "loading_dt" => date("Y-m-d H:i:s"),
                                ]
                            ]);
                            $this->_writeApiResponse($this->_generateStatusCode(207, "Loaded to container"));
                        }
                    } else {
                        $this->_writeApiResponse($this->_generateStatusCode(405, "Paket sudah diload sebelumnya"));
                    }
                } else {
                    $this->_writeApiResponse($this->_generateStatusCode(401));
                }
            }
        } else {
            $this->_writeApiResponse($this->_generateStatusCode(400));
        }
    }

    function api_detail() {
        if ($this->_checkData(["package_no"])) {
            $packageNo = $this->request->data["package_no"];
            $packageDetail = $this->PackageDetail->find("first", array(
                "contain" => [
                    "Product" => [
                        "Parent",
                        "ProductUnit"
                    ],
                    "Sale" => [
                        "Buyer",
                        "Shipment"
                    ],
                    "PackageDetailProduct" => [
                        "ProductDetail" => [
                            "MaterialEntry" => [
                                "Supplier"
                            ]
                        ]
                    ],
                ],
                "conditions" => array(
                    "PackageDetail.package_no" => $packageNo,
                ),
            ));
            if (!empty($packageDetail)) {
                $batchnumber = "";
                foreach ($packageDetail["PackageDetailProduct"] as $k => $packageDetailProduct) {
                    if ($k > 0) {
                        $batchnumber = $batchnumber . ", " . $packageDetailProduct['ProductDetail']['batch_number'];
                    } else {
                        $batchnumber = $packageDetailProduct['ProductDetail']['batch_number'];
                    }
                }
                $shipmentBy = "-";
                $shipmentDate = "-";
                $supplier = "";
                $materialEntry = "";
                if (isset($packageDetail["Sale"]["Shipment"]['id'])) {
                    $shipmentDate = $packageDetail["Sale"]["Shipment"]['shipment_date'];
                }
                foreach ($packageDetail["PackageDetailProduct"] as $k => $packageDetailProduct) {
                    if ($k == 0) {
                        $supplier = $packageDetailProduct['ProductDetail']['MaterialEntry']['Supplier']['name'];
                        $materialEntry = $packageDetailProduct['ProductDetail']['MaterialEntry']['material_entry_number'];
                    } else {
                        $supplier += ", " . $packageDetailProduct['ProductDetail']['MaterialEntry']['Supplier']['name'];
                        $materialEntry += $packageDetailProduct['ProductDetail']['MaterialEntry']['material_entry_number'];
                    }
                }
                $result = [
                    "package_no" => $packageDetail["PackageDetail"]["package_no"],
                    "nama_produk" => $packageDetail["Product"]["Parent"]["name"] . " " . $packageDetail["Product"]["name"],
                    "batch_number" => $batchnumber, //waiting for 
                    "berat_bersih" => $packageDetail["PackageDetail"]["nett_weight"] . " " . $packageDetail["Product"]['ProductUnit']["name"],
                    "pcs" => $packageDetail["PackageDetail"]["quantity_per_pack"],
                    "nomor_po" => $packageDetail["Sale"]["po_number"],
                    "nomor_invoice" => $packageDetail["Sale"]["sale_no"],
                    "nama_supplier" => $supplier,
                    "nomor_nota_timbang" => $materialEntry,
                    "tanggal_produksi" => $packageDetail['PackageDetailProduct'][0]['ProductDetail']['production_date'],
                    "nama_pembeli" => $packageDetail["Sale"]["Buyer"]["company_name"],
                    "tanggal_pengiriman" => $shipmentDate,
                    "shipped_by" => $shipmentBy,
                ];
                $this->_writeApiResponse($this->_generateStatusCode(206, null, $result));
            } else {
                $this->_writeApiResponse($this->_generateStatusCode(401));
            }
        }
    }

    function api_cancel_loading() {
        if ($this->_checkData(["package_no"])) {
            $packageNo = $this->request->data["package_no"];
            $packageDetail = $this->PackageDetail->find("first", array(
                "recursive" => -1,
                "conditions" => array(
                    "PackageDetail.package_no" => $packageNo,
                ),
            ));
            if (!empty($packageDetail)) {
                $toUpdatePackageDetail = [
                    "PackageDetail" => [
                        "id" => $packageDetail["PackageDetail"]["id"],
                        "is_load" => 0,
                    ]
                ];
                ClassRegistry::init("PackageDetail")->saveAll($toUpdatePackageDetail);
                $this->_writeApiResponse($this->_generateStatusCode(207, "Success! Data Berhasil Diubah"));
            } else {
                $this->_writeApiResponse($this->_generateStatusCode(401));
            }
        } else {
            $this->_writeApiResponse($this->_generateStatusCode(401));
        }
    }

    function api_update_package() {
        if ($this->request->is("POST")) {
            if ($this->_checkData(["id", "product_detail_id", "nett_weight", "brut_weight", "quantity_per_pack", "sale_id", "product_id"])) {
                $id = $this->request->data["id"];
                $packageDetail = $this->PackageDetail->find("first", array(
                    "recursive" => -1,
                    "conditions" => array(
                        "PackageDetail.id" => $id,
                    ),
                    "contain" => [
                        "SaleDetail",
                    ],
                ));
                if (!empty($packageDetail)) {
                    if ($packageDetail["PackageDetail"]["is_load"]) {
                        $this->_writeApiResponse($this->_generateStatusCode(405, "Error! Paket sudah di Load ke Kontainer"));
                    } else {
                        //Update to Package Detail Product
                        $total_nett_weight = 0;
                        $total_brut_weight = 0;
                        $total_quantity = 0;
                        foreach ($this->request->data["product_detail_id"] as $k => $value) {
                            $toUpdatePackageDetailProduct = [
                                "PackageDetailProduct" => [
                                    "package_detail_id" => $this->request->data["id"],
                                    "product_detail_id" => $value,
                                    "nett_weight" => $this->request->data["nett_weight"][$k],
                                    "brut_weight" => $this->request->data["brut_weight"][$k],
                                    "quantity" => $this->request->data["quantity_per_pack"][$k],
                                ]
                            ];
                            ClassRegistry::init("PackageDetailProduct")->saveAll($toUpdatePackageDetailProduct);
                            $total_nett_weight += floatval($this->request->data["nett_weight"][$k]);
                            $total_brut_weight += floatval($this->request->data["brut_weight"][$k]);
                            $total_quantity += floatval($this->request->data["quantity_per_pack"][$k]);

                            //Kurangin Stok Produk Detail
                            $productDetailDatas = ClassRegistry::init("ProductDetail")->find("first", array(
                                "recursive" => -1,
                                "conditions" => array(
                                    "ProductDetail.id" => $value
                                ),
                            ));

                            $toUpdateProductDetail = [
                                "ProductDetail" => [
                                    "id" => $value,
                                    "remaining_weight" => $productDetailDatas['ProductDetail']['remaining_weight'] - $total_nett_weight,
                                ]
                            ];
                            ClassRegistry::init("ProductDetail")->saveAll($toUpdateProductDetail);
                        }
                        $saleData = ClassRegistry::init("SaleDetail")->find("first", array(
                            "recursive" => -1,
                            "conditions" => array(
                                "SaleDetail.sale_id" => $this->request->data["sale_id"],
                                "SaleDetail.product_id" => $this->request->data["product_id"],
                            ),
                        ));
                        //Update to Package Detail
                        $this->PackageDetail->save([
                            "PackageDetail" => [
                                "id" => $this->request->data["id"],
                                "sale_id" => $this->request->data["sale_id"],
                                "sale_detail_id" => $saleData['SaleDetail']['id'],
                                "product_id" => $this->request->data["product_id"],
                                //"product_detail_id" => $this->request->data["product_detail_id"],
                                "nett_weight" => $total_nett_weight,
                                "brut_weight" => $total_brut_weight,
                                "quantity_per_pack" => $total_quantity,
                                "creator_id" => $this->apiCredential["Employee"]["id"],
                                "branch_office_id" => $this->apiCredential["Employee"]["branch_office_id"],
                                "packaging_dt" => date("Y-m-d H:i:s"),
                                "is_filled" => true,
                            ]
                        ]);

                        //Kurangin Stok Produk
                        $productDatas = ClassRegistry::init("Product")->find("first", array(
                            "recursive" => -1,
                            "conditions" => array(
                                "Product.id" => $this->request->data["product_id"]
                            ),
                        ));

                        $toUpdateProduct = [
                            "Product" => [
                                "id" => $this->request->data["product_id"],
                                "total_weight_stock" => $productDatas['Product']['total_weight_stock'] - $total_nett_weight,
                            ]
                        ];
                        ClassRegistry::init("Product")->saveAll($toUpdateProduct);

                        //Update sale
                        $toUpdateSale = [
                            "SaleDetail" => [
                                "id" => $saleData['SaleDetail']['id'],
                                "fulfill_weight" => $saleData['SaleDetail']['fulfill_weight'] + $total_nett_weight,
                                "quantity_production" => $saleData['SaleDetail']['quantity_production'] + 1,
                            ]
                        ];
                        ClassRegistry::init("SaleDetail")->saveAll($toUpdateSale);

                        //Update status penjualan paket jika paket sudah terpenuhi semua
                        $saleDetailDatas = ClassRegistry::init("SaleDetail")->find("all", array(
                            "recursive" => -1,
                            "conditions" => array(
                                "SaleDetail.sale_id" => $this->request->data["sale_id"],
                            ),
                        ));
                        $status = false;
                        foreach ($saleDetailDatas as $saleDetailData) {
                            if ($saleDetailData['SaleDetail']['quantity_production'] <= $saleDetailData['SaleDetail']['quantity']) {
                                $status = true;
                            }
                        }
                        if ($status == false) {
                            $toUpdateSaleInfo = [
                                "Sale" => [
                                    "id" => $this->request->data["sale_id"],
                                    "packaging_status_id" => 2,
                                ]
                            ];
                            ClassRegistry::init("Sale")->saveAll($toUpdateSaleInfo);
                        }

                        //reduce previous sale_detail if change PO
                        if ($packageDetail["PackageDetail"]["is_filled"]) {
                            ClassRegistry::init("SaleDetail")->saveAll([
                                "SaleDetail" => [
                                    "id" => $packageDetail["SaleDetail"]["id"],
                                    "fulfill_weight" => $packageDetail["SaleDetail"]["fulfill_weight"] - $packageDetail["PackageDetail"]["nett_weight"],
                                    "quantity_production" => $packageDetail["SaleDetail"]["quantity_production"] - 1,
                                ]
                            ]);
                            ClassRegistry::init("SaleDetail")->saveAll($toUpdateSale);
                        }
                        $this->_writeApiResponse($this->_generateStatusCode(207, "Success! Data Berhasil Diubah"));
                    }
                } else {
                    $this->_writeApiResponse($this->_generateStatusCode(401));
                }
            }
        } else if ($this->request->is("GET")) {
            if ($this->_checkData(["package_no"])) {
                $packageNo = $this->request->query["package_no"];
                $packageDetail = $this->PackageDetail->find("first", array(
                    "recursive" => -1,
                    "conditions" => array(
                        "PackageDetail.package_no" => $packageNo,
                    ),
                    "contain" => [
                    ]
                ));
                $result = [];
                if (!empty($packageDetail)) {
                    if ($packageDetail["PackageDetail"]["is_load"]) {
                        $this->_writeApiResponse($this->_generateStatusCode(405, "Error! Paket sudah di Load ke Kontainer"));
                        return;
                    } else {
                        //Get Product Detail
                        $productDetails = $this->PackageDetail->ProductDetail->find("all", array(
                            "fields" => [
                                "ProductDetail.id", "ProductDetail.batch_number"
                            ],
                            "recursive" => -1,
                            "conditions" => array(
                            //"ProductDetail.product_id" => $packageDetail['PackageDetail']['product_id'],
                            ),
                        ));
                        //Get sale
                        $sales = [];
                        $i = 0;
                        $saleDatas = ClassRegistry::init("Sale")->find("all", array(
                            "fields" => [
                                "Sale.id", "Sale.sale_no", "Sale.po_number"
                            ],
                            "conditions" => array(
                                "Sale.shipment_status" => 0,
                                "Sale.verify_status_id" => 3
                            ),
                            "contain" => [
                                "SaleDetail" => [
                                    "Product" => [
                                        "ProductDetail",
                                        'Parent'
                                    ]
                                ]
                            ],
                            "recursive" => -1,
                        ));
                        //debug($saleDatas);
                        foreach ($saleDatas as $saleData) {
                            $products = [];
                            $count = 0;
                            foreach ($saleData['SaleDetail'] as $saleDetailProduct) {
                                $productDetails = [];
                                $countDetail = 0;
                                foreach ($saleDetailProduct['Product']['ProductDetail'] as $productDetail) {
                                    $productDetails[$countDetail] = [
                                        "id" => $productDetail["id"],
                                        "batchnumber" => $productDetail["batch_number"],
                                            //"product_id" => $productDetail["ProductDetail"]["Product"]["id"]
                                    ];
                                    $countDetail++;
                                }
                                $products[$count] = [
                                    "id" => $saleDetailProduct["Product"]["id"],
                                    "name" => $saleDetailProduct["Product"]["name"] . " " . $saleDetailProduct["Product"]['Parent']["name"],
                                    "product_detail" => $productDetails
                                ];
                                $count++;
                            }
                            //$batchNumbers[$productDetail["ProductDetail"]["id"]] = $productDetail["ProductDetail"]["batch_number"];
                            $sales[$i] = [
                                "id" => $saleData["Sale"]["id"],
                                "sale_no" => $saleData["Sale"]["po_number"],
                                "product" => $products,
                                    //"product_id" => $productDetail["ProductDetail"]["Product"]["id"]
                            ];
                            $i++;
                        }
//                    $batchNumbers = [];
//                    $i = 0;
//                    foreach ($productDetails as $productDetail) {
//                        //$batchNumbers[$productDetail["ProductDetail"]["id"]] = $productDetail["ProductDetail"]["batch_number"];
//                        $batchNumbers[$i] = [
//                            "id" => $productDetail["ProductDetail"]["id"],
//                            "batchnumber" => $productDetail["ProductDetail"]["batch_number"],
//                                //"product_id" => $productDetail["ProductDetail"]["Product"]["id"]
//                        ];
//                        $i++;
//                    }
                        $result["package_info"] = [
                            //"product_name" => $packageDetail['Product']['Parent']['name'] . " " . $packageDetail['Product']['name'],
                            "trackcode" => $packageDetail["PackageDetail"]['package_no'],
                            "id_package" => $packageDetail["PackageDetail"]['id'],
                        ];
                        //result for batch number
                        //$result["product_detail"] = $batchNumbers;
                        //result for sale list
                        $result["sale"] = $sales;
                        $this->_writeApiResponse($this->_generateStatusCode(206, null, $result));
                    }
                } else {
                    $this->_writeApiResponse($this->_generateStatusCode(401));
                }
            }
        }
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        $saleId = $this->request->query['sale_id'];

        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "PackageDetail.is_filled" => 0,
                "PackageDetail.sale_id" => $saleId,
                "PackageDetail.package_no like" => "%$q%",
            );
        }
        $suggestions = ClassRegistry::init("PackageDetail")->find("all", array(
            "conditions" => $conds,
            "contain" => array(
                "Product" => [
                    "Parent",
                    "ProductDetail",
                ],
            ),
            "limit" => 10
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $productDetails = [];
                foreach ($item["Product"]["ProductDetail"] as $productDetail) {
                    $date = date("Y-m-d", strtotime($productDetail["production_date"]));
                    $productDetails[] = [
                        "id" => $productDetail["id"],
                        "batch_number" => $productDetail["batch_number"] . " | " . $date,
                        "remaining_weight" => $productDetail["remaining_weight"],
                    ];
                }
                $result[] = [
                    "id" => @$item['PackageDetail']['id'],
                    "package_no" => @$item['PackageDetail']['package_no'],
                    "product" => @$item['Product']['Parent']['name'] . @$item['Product']['name'],
                    "product_detail" => $productDetails,
                ];
            }
        }
        echo json_encode($result);
    }

    function admin_generate_package() {
        if ($this->request->is("post")) {
            $i = $this->data['PackageDetail']['package_number'];
            $codes = [];
            for ($c = 0; $c < $i; $c++) {
                $this->PackageDetail->create();
                $packageDetail = [
                ];
                $this->PackageDetail->save($packageDetail);
                $codes[] = $this->PackageDetail->generatePackageCode($this->PackageDetail->getLastInsertID());
            }
            $conds = [
                "PackageDetail.package_no" => $codes,
            ];
            $data = ClassRegistry::init("PackageDetail")->find("all", [
                "conditions" => [
                    $conds
                ],
                "recursive" => -1
            ]);
            $this->set(compact("data"));
            $this->_activePrint(["print"], "print_package_number_barcode", "print_barcode");
        }
    }

    function admin_generate_package_number_barcode() {
        if (!empty($this->request->query['start_no_package']) && !empty($this->request->query['end_no_package'])) {
            if ($this->request->query['start_no_package'] <= $this->request->query['end_no_package']) {
                $startNoPackage = $this->request->query['start_no_package'];
                $endNoPackage = $this->request->query['end_no_package'];
                $conds = [
                    "PackageDetail.package_no >=" => $startNoPackage,
                    "PackageDetail.package_no <=" => $endNoPackage
                ];
                $data = ClassRegistry::init("PackageDetail")->find("all", [
                    "conditions" => [
                        $conds
                    ],
                    "recursive" => -1
                ]);
                $this->_activePrint(["print"], "print_package_number_barcode", "print_barcode");
                $this->set(compact("data"));
            } else {
                $this->Session->setFlash(__("Input Range Nomor Paket Tidak Benar. Silahkan Coba Lagi."), 'default', array(), 'danger');
            }
        }
    }

    function cron_generate_package() {
        $this->autoRender = false;
        $sales = $this->PackageDetail->Sale->find("all", [
            "conditions" => [
                "Sale.generate_status_id" => 1,
            ],
            "contain" => [
                "SaleDetail",
            ]
        ]);
        $startTime = time();
        $endTime = $startTime + 20;
        foreach ($sales as $sale) {
            foreach ($sale["SaleDetail"] as $saleDetail) {
                for ($i = 1; $i <= $saleDetail["quantity"] - $saleDetail["package_detail_count"]; $i++) {
                    $this->PackageDetail->create();
                    $packageDetail = [
                            //"sale_id" => $sale["Sale"]["id"],
                            //"sale_detail_id" => $saleDetail["id"],
                            //"product_id" => $saleDetail["product_id"],
                            //"branch_office_id" => $sale["Sale"]["branch_office_id"],
                    ];
                    $this->PackageDetail->save($packageDetail);
                    $this->PackageDetail->generateTrackCode($this->PackageDetail->getLastInsertID());
                    if ($endTime < time()) {
                        return;
                    }
                }
            }
            $this->PackageDetail->SaleDetail->Sale->save([
                "id" => $sale["Sale"]["id"],
                "generate_status_id" => 2,
            ]);
        }
    }

    function admin_get_package_detail($product_id = null) {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->find('all', array(
            "conditions" => array(
                "PackageDetail.product_id" => $product_id
            ),
            "contain" => array(
                "Product" => [
                    "Parent"
                ],
                "ProductDetail"
        )));
        echo json_encode($data);
    }

    function admin_set_sale_package() {
        $status = true;
        if (!empty($this->request->query['package_id']) && !empty($this->request->query['no_sale'])) {
            $startPackageId = $this->request->query['package_id'];
            $NoSale = $this->request->query['no_sale'];

            $dataProduct = $this->{ Inflector::classify($this->name) }->find('first', array(
                "conditions" => array(
                    "PackageDetail.id" => $startPackageId
                ),
                "contain" => array(
                )
            ));
            $sales = ClassRegistry::init("SaleDetail")->find("first", array(
                "conditions" => [
                    "SaleDetail.sale_id" => $NoSale,
                    "SaleDetail.product_id" => $dataProduct['PackageDetail']['product_id'],
                ],
                "recursive" => -1,
            ));
            $packageDetail = [
                "id" => $startPackageId,
                "sale_id" => $NoSale,
                "sale_detail_id" => $NoSale,
            ];
            if ($this->PackageDetail->save($packageDetail)) {
                $this->PackageDetail->save($packageDetail);
            } else {
                $status = false;
            }
            if ($status == true) {
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('controller' => 'package_details', 'action' => "/set_sale_package"));
            } else {
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
                $this->redirect(array('controller' => 'package_details', 'action' => "/set_sale_package"));
            }
        }
    }

    function admin_set_package_to_container() {
        $status = true;
        if (!empty($this->data['PackageDetail']['sale_id'])) {
            //$startPackageId = $this->request->query['package_id'];
            //$NoSale = $this->request->query['no_sale'];
            foreach ($this->data['dummy'] as $k => $item) {
                $toUpdatePackageDetail = [
                    "PackageDetail" => [
                        "id" => $item['id'],
                        "packaging_dt"=>$this->data['PackageDetail']['packaging_dt'],
                        "loading_dt"=>$this->data['PackageDetail']['packaging_dt'],
                        "sale_id" => $this->data['PackageDetail']['sale_id'],
                        "creator_id" => $this->Session->read("credential.admin.Employee.id"),
                        "branch_office_id" => $this->Session->read("credential.admin.Employee.branch_office_id"),
                        "product_id" => $item['product_id'],
                        "product_detail_id" => $item['product_detail_id'],
                        "nett_weight" => $item['nett_weight'],
                        "brut_weight" => $item['brut_weight'],
                        "quantity_per_pack" => $item['quantity_per_pack'],
                        "is_filled" => 1,
                        "is_load" => 0,
                    ]
                ];
                if (ClassRegistry::init("PackageDetail")->saveAll($toUpdatePackageDetail)) {
                    ClassRegistry::init("PackageDetail")->saveAll($toUpdatePackageDetail);
                    //Update Package Detail Product
                    $toUpdatePackageDetailProduct = [
                        "PackageDetailProduct" => [
                            "package_detail_id"=> $item['id'],
                            "product_detail_id"=>$item['product_detail_id'],
                            "nett_weight" => $item['nett_weight'],
                            "brut_weight" => $item['brut_weight'],
                            "quantity" => $item['quantity_per_pack'],
                        ]
                    ];
                    ClassRegistry::init("PackageDetailProduct")->saveAll($toUpdatePackageDetailProduct);
                    //Kurangin Stok Produk Detail
                    $productDetailDatas = ClassRegistry::init("ProductDetail")->find("first", array(
                        "recursive" => -1,
                        "conditions" => array(
                            "ProductDetail.id" => $item['product_detail_id']
                        ),
                    ));

                    $toUpdateProductDetail = [
                        "ProductDetail" => [
                            "id" => $item['product_detail_id'],
                            "remaining_weight" => $productDetailDatas['ProductDetail']['remaining_weight'] - $item['nett_weight'],
                        ]
                    ];
                    ClassRegistry::init("ProductDetail")->saveAll($toUpdateProductDetail);
                    //Kurangin Stok Produk
                    $productDatas = ClassRegistry::init("Product")->find("first", array(
                        "recursive" => -1,
                        "conditions" => array(
                            "Product.id" => $item['product_id']
                        ),
                    ));

                    $toUpdateProduct = [
                        "Product" => [
                            "id" => $item['product_id'],
                            "total_weight_stock" => $productDatas['Product']['total_weight_stock'] - $item['nett_weight'],
                        ]
                    ];
                    ClassRegistry::init("Product")->saveAll($toUpdateProduct);
                } else {
                    $status = false;
                }
            }
            if ($status == true) {
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('controller' => 'package_details', 'action' => "/set_package_to_container"));
            } else {
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
                $this->redirect(array('controller' => 'package_details', 'action' => "/set_package_to_container"));
            }
//            $packageDetail = [
//                "id" => $startPackageId,
//                "sale_id" => $NoSale,
//            ];
//            $this->PackageDetail->save($packageDetail);
        }
    }

    //for add package to container
    function admin_get_product_by_sale_id($sale_id = null) {
        $this->autoRender = false;
        $conds = [];
        $suggestions = ClassRegistry::init("Sale")->find("first", array(
            "conditions" => [
                "Sale.id" => $sale_id,
            ],
            "contain" => [
                "SaleDetail" => [
                    "Product" => [
                        "Parent"
                    ]
                ]
            ],
            "recursive" => -1
        ));
        $result = [];
        foreach ($suggestions['SaleDetail'] as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => $item['Product']['id'],
                    "name" => $item['Product']['Parent']['name'] . " - " . $item['Product']['name']
                ];
            }
        }
        echo json_encode($result);
    }

    function admin_get_batch_number_by_product_id($product_id = null) {
        $this->autoRender = false;
        $conds = [];
        $suggestions = ClassRegistry::init("Product")->find("first", array(
            "conditions" => [
                "Product.id" => $product_id,
            ],
            "contain" => [
                "ProductDetail"=>[
                    "conditions"=>[
                        "ProductDetail.remaining_weight >" => 0,
                    ]
                ]
            ],
            "recursive" => -1
        ));
        $result = [];
        if (!empty($suggestions['ProductDetail'])) {
            $code = 205;
            foreach ($suggestions['ProductDetail'] as $item) {
                $result[$item['id']] = $item['batch_number'];
            }
        } else {
            $code = 401;
        }

        echo json_encode($this->_generateStatusCode($code, null, $result));
    }
    
    function admin_getPackageDetail() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "PackageDetail.package_no like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("PackageDetail")->find("all", array(
            "conditions" => [
                $conds,
                "AND" => [
                    "PackageDetail.product_id" => null,
                ],
            ],
            "contain" => array(
            ),
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item['PackageDetail'])) {
                $result[] = [
                    "id" => $item['PackageDetail']['id'],
                    "package_no" => $item['PackageDetail']['package_no'],
                ];
            }
        }
        echo json_encode($result);
    }

    function admin_package_no_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "PackageDetail.package_no like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("PackageDetail")->find("all", array(
            "conditions" => [
                $conds
            ],
            "limit" => 10,
            "recursive" => -1
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => $item['PackageDetail']['id'],
                    "package_no" => $item['PackageDetail']['package_no']
                ];
            }
        }
        echo json_encode($result);
    }

    function admin_package_empty_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "PackageDetail.package_no like" => "%$q%",
                "PackageDetail.is_load" => 0,
                "NOT" => array(
                    "PackageDetail.product_id" => null,
                    "PackageDetail.sale_id" => null,
                )
            );
        }
        $suggestions = ClassRegistry::init("PackageDetail")->find("all", array(
            "conditions" => [
                $conds
            ],
            "limit" => 10,
            "recursive" => -1,
            "contain" => [
                "Product" => [
                    "Parent"
                ]
            ]
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item)) {
                $result[] = [
                    "id" => $item['PackageDetail']['id'],
                    "package_no" => $item['PackageDetail']['package_no'],
                    "product" => $item['Product']['Parent']['name'] . " " . $item['Product']['name']
                ];
            }
        }
        echo json_encode($result);
    }

}
