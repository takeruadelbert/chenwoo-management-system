<?php

App::uses('AppController', 'Controller');

class PackagesController extends AppController {

    var $name = "Packages";
    var $disabledAction = array(
    );
    var $contain = [
        "PackageDetail" => [
            "ProductDetail" => [
                "Product" => [
                    "Parent"
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
        $this->_activePrint(func_get_args(), "data_produksi_tahap3_top");
        $this->conds = [
            "Package.branch_office_id" => $this->stnAdmin->roleBranchId(),
        ];
        parent::admin_index();
    }
    
    function admin_index_validate() {
        $this->_activePrint(func_get_args(), "data_package");
        $conds = ["Package.verify_status_id" => 2];
        if (!empty($this->request->query['select_Employee_branch_office_id'])) {
            $conds = [
                "Employee.branch_office_id" => $this->request->query['select_Employee_branch_office_id']
            ];
        }
        if (isset($this->request->query)) {
            if (!empty($this->request->query['start_date'])) {
                $startDate = $this->request->query['start_date'];
                $newStartDate = date("Y-m-d H:i:s", strtotime($startDate));
                $conds[] = [
                    "DATE_FORMAT(Package.created, '%Y-%m-%d %H:%i:%s') >=" => $newStartDate
                ];
                unset($_GET['start_date']);
            }
            if (!empty($this->request->query['end_date'])) {
                $endDate = $this->request->query['end_date'];
                $newEndDate = date("Y-m-d H:i:s", strtotime($endDate));
                $conds[] = [
                    "DATE_FORMAT(Package.created, '%Y-%m-%d %H:%i:%s') <=" => $newEndDate
                ];
                unset($_GET['end_date']);
            }
        }
        $this->conds = [
            $conds
        ];
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            $creatorId = $this->Session->read("credential.admin.Employee.id");
            $saleId = $this->Package->data["Sale"]["id"];
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $sale = ClassRegistry::init("Sale")->find("first", [
                    "conditions" => [
                        "Sale.id" => $saleId,
                    ],
                    "recursive" => -1,
                ]);
                $branchOfficeId = $sale["Sale"]["branch_office_id"];
                $this->Package->data["Package"]["branch_office_id"] = $branchOfficeId;
                $this->Package->data["Package"]["employee_id"] = $this->stnAdmin->getBranchId();
                $productDetailUsage = [];
                $saleDetailFullFilled = [];
                $mapProductDetailToProduct = [];
                if (!empty($this->Package->data["PackageDetail"])) {
                    foreach ($this->Package->data["PackageDetail"] as $k => $packageDetail) {
                        if (empty($packageDetail["product_detail_id"])) {
                            unset($this->Package->data["PackageDetail"][$k]);
                            continue;
                        }
                        $this->Package->data["PackageDetail"][$k]["is_filled"] = 1;
                        $this->Package->data["PackageDetail"][$k]["creator_id"] = $this->stnAdmin->getEmployeeId();
                        //Update product detail remaining
                        if (!isset($productDetailUsage[$packageDetail["product_detail_id"]])) {
                            $productDetailUsage[$packageDetail["product_detail_id"]] = 0;
                        }
                        $productDetailUsage[$packageDetail["product_detail_id"]] += floatval($packageDetail['nett_weight']);
                        if (!isset($mapProductDetailToProduct[$packageDetail["product_detail_id"]])) {
                            $productDetail = ClassRegistry::init("ProductDetail")->find("first", [  
                                "conditions" => [
                                    "ProductDetail.id" => $packageDetail["product_detail_id"],
                                ],
                                "recursive" => -1,
                            ]);
                            $mapProductDetailToProduct[$packageDetail["product_detail_id"]] = $productDetail["ProductDetail"]["product_id"];
                        }
                        if (!isset($saleDetailFullFilled[$mapProductDetailToProduct[$packageDetail["product_detail_id"]]])) {
                            $saleDetailFullFilled[$mapProductDetailToProduct[$packageDetail["product_detail_id"]]] = [
                                "mc" => 0,
                                "weight" => 0,
                            ];
                        }
                        $saleDetailFullFilled[$mapProductDetailToProduct[$packageDetail["product_detail_id"]]]["mc"] ++;
                        $saleDetailFullFilled[$mapProductDetailToProduct[$packageDetail["product_detail_id"]]]["weight"]+=floatval($packageDetail['nett_weight']);
                    }
                    $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                    $productDetailModel = ClassRegistry::init("ProductDetail");
                    foreach ($productDetailUsage as $productDetailId => $usageAmount) {
                        $productDetail = $productDetailModel->find("first", [
                            "conditions" => [
                                "ProductDetail.id" => $productDetailId,
                            ],
                            "recursive" => -1
                        ]);
                        $productDetailModel->save([
                            "id" => $productDetailId,
                            "remaining_weight" => $productDetail["ProductDetail"]["remaining_weight"] - $usageAmount,
                        ]);
                    }
                    $saleDetailModel = ClassRegistry::init("SaleDetail");
                    foreach ($saleDetailFullFilled as $productId => $fullFilledData) {
                        $saleDetail = $saleDetailModel->find("first", [
                            "conditions" => [
                                "SaleDetail.product_id" => $productId,
                                "SaleDetail.sale_id" => $saleId,
                            ],
                            "recursive" => -1
                        ]);
                        $saleDetailModel->save([
                            "id" => $saleDetail["SaleDetail"]["id"],
                            "fulfill_weight" => $saleDetail["SaleDetail"]["fulfill_weight"] + $fullFilledData["weight"],
                            "quantity_production" => $saleDetail["SaleDetail"]["quantity_production"] + $fullFilledData["mc"],
                        ]);
                    }
                }
                ClassRegistry::init("Sale")->checkPackagingStatus($saleId);
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('controller' => 'sales', 'action' => 'admin_package'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
                $this->redirect(array('controller' => 'packages', 'action' => 'admin_add?id='.$saleId));
            }
        } else {
            $this->data = $this->Package->Sale->find("first", [
                "conditions" => [
                    "Sale.id" => $this->request->query["id"],
                ],
                "contain" => [
//                    "PackageDetail" => [
//                        "Product" => [
//                            "Parent",
//                            "ProductUnit",
//                        ],
//                        "ProductDetail" => [
//                            "Product"
//                        ],
//                    ],
                    "SaleDetail" => [
                        "Product" => [
                            "Parent",
                            "ProductUnit",
                        ],
                    ],
                ]
            ]);
        }
        $this->set("dataProduct", ClassRegistry::init("Product")->find('all', array(
                    "contain" => array(
                        "Parent",
                        "ProductUnit",
                    ),
                    "conditions" => [
                        "Not" => [
                            "Product.parent_id" => null,
                        ]
                    ],
        )));
//        $this->set("dataTreatment", ClassRegistry::init("TreatmentDetail")->find('all', array(
//                    "contain" => array(
//                        "Treatment" => [
//                            "Freeze" => [
//                                "Conversion" => [
//                                    "MaterialEntryGradeDetail",
//                                ],
//                            ],
//                            "MaterialEntry" => [
//                                "MaterialEntryGrade" => [
//                                    "MaterialEntryGradeDetail",
//                                ],
//                            ],
//                        ],
//                    ),
//                    "conditions" => [
//                        "TreatmentDetail.remaining_weight >" => 0,
//                        "Treatment.verify_status_id" => 3,
//                        "Treatment.branch_office_id" => $this->stnAdmin->getBranchId()
//                    ]
//        )));
        $this->set("dataProductDetail", ClassRegistry::init("ProductDetail")->find('all', array(
                    "contain" => array(
                        "Product" => [
                            "Parent" => [
                            ],
                        ],
                    ),
                    "conditions" => [
                        "ProductDetail.remaining_weight >" => 0,
                        "ProductDetail.branch_office_id" => $this->stnAdmin->getBranchId()
                    ]
        )));
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

    function admin_stock_ready() {
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
                'contain' => ["PackageDetail" => ['Product' => ['Parent', 'ProductUnit']]],
                'group' => ['Package.id'],
            )
        );
        $rows = $this->Paginator->paginate($this->{ Inflector::classify($this->name) });
//        debug($rows);
//        die;
        $data = array(
            'rows' => $rows,
        );
//        debug($data);
//        die;
        $this->set(compact('data'));
    }

    function admin_multiple_delete() {
        $this->{ Inflector::classify($this->name) }->PackageDetail->set($this->data);
        if (empty($this->data)) {
            $code = 203;
        } else {
            $allData = $this->data[Inflector::classify($this->name)]['checkbox'];
            foreach ($allData as $data) {
                if ($data != '' || $data != 0) {
                    $this->{ Inflector::classify($this->name) }->PackageDetail->delete($data, true);
                }
            }
            $code = 204;
        }
        echo json_encode($this->_generateStatusCode($code));
        die();
    }

    function admin_delete($id = null) {
        if ($this->request->is("delete")) {
            if ($this->{ Inflector::classify($this->name) }->delete($id)) {
//                foreach($this->data["PackageDetail"] as $n=>$productData){
//                    $toUpdate = [
//                        "ProductData" => [
//                            "id" => intval($productData['product_data_id']),
//                            "product_status_id" => 2 
//                        ]
//                    ];
//                    ClassRegistry::init("ProductData")->saveAll($toUpdate);
//                }
                $code = 204;
            } else {
                $code = 401;
            }
        } else {
            $code = 400;
        }
        echo json_encode($this->_generateStatusCode($code));
        die();
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function admin_daily_packaging() {
        if ($this->request->is("post")) {
            $this->admin_print_packaging_daily($this->data['Packaging']['date']);
        }
    }

    function admin_print_packaging_daily($date = null) {
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . '.created > ' => $date . " 00:00:00",
                Inflector::classify($this->name) . '.created <=' => $date . " 23:59:59",
            ),
            'contain' => [
                "Sale" => [
                    "Buyer"
                ],
                "PackageDetail" => [
                    "Product" => [
                        "Parent",
                        "ProductUnit"
                    ]
                ]
            ],
        ));

        $this->data = $rows;
        $data = array(
            'title' => 'DAILY PACKING REPORT',
            'rows' => $rows,
        );
        $this->set(compact('data'));
        $this->_activePrint(["print"], "report_packaging_daily", "print_tanpa_kop");
    }

    //Function For Android App
    function get_detail_package($packageNumber) {
        $this->autoRender = false;
        if ($packageNumber != null) {
            $data = $this->{ Inflector::classify($this->name) }->PackageDetail->find("first", ["fields" => [], "conditions" => ["PackageDetail.package_no" => $packageNumber], "contain" => ["TreatmentDetail" => ["Treatment" => ["Freeze" => ["TransactionEntry" => ['TransactionEntryFile' => ['AssetFile'], 'Supplier']]]], "Package" => ["Sale" => "Buyer"], "Product" => ["Parent", "ProductUnit"]]]);
            if ($data != null) {
                echo json_encode($this->_generateStatusCode(206, null, $data));
            } else {
                echo json_encode($this->_generateStatusCode(401));
            }
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function _options() {
        $this->set("branchOffices", $this->Package->Employee->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("sales", ClassRegistry::init("Sale")->find("list", array("fields" => array("Sale.id", "Sale.po_number"))));
    }

    function admin_get_all_package($id = null) {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->PackageDetail->find('all', array("fields" => array(), "conditions" => array("PackageDetail.used" => 0), "contain" => array(
                "Product" => [
                    "Parent"
                ]
        )));
        echo json_encode($data);
    }

    function admin_get_package_total_price($id = null) {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->PackageDetail->find('all', array("fields" => array("PackageDetail.id", "ProductSize.price"), "conditions" => array("PackageDetail.product_data_id" => $id), "contain" => array(
                "ProductData" => [
                    "ProductSize"
                ]
        )));
        echo json_encode($data);
    }

    function admin_view_data_package($id = null) {
        $this->autoRender = false;
        if ($this->Package->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->Package->find("first", ["conditions" => ["Package.id" => $id], "contain" => ["PackageDetail" => ["Product" => ["ProductSize" => ["Product"]]]]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function view_data_package($id = null) {
        $this->autoRender = false;
        if ($this->Package->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->Package->find("first", ["conditions" => ["Package.id" => $id], "contain" => ["PackageDetail"]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function admin_print_barcode($id) {
        if (!empty($id)) {
            $data = ClassRegistry::init("Sale")->find("first", [
                "conditions" => [
                    "Sale.id" => $id
                ],
                "contain" => [
                    "PackageDetail" => [
                        "Product" => [
                            "Parent"
                        ]
                    ],
                ]
            ]);
            $this->set(compact('data'));
            $this->_activePrint(["print"], "print_barcode", "print_barcode");
        } else {
            throw new NotFoundException(__("404 Data Not Found."));
        }
    }

    function admin_print_manual_form($id = null) {
        if (!empty($id)) {
            $this->data = $this->Package->Sale->find("first", [
                "conditions" => [
                    "Sale.id" => $id,
                ],
                "contain" => [
                    "PackageDetail" => [
                        "Product" => [
                            "Parent",
                            "ProductUnit",
                        ],
                        "TreatmentDetail" => [
                            "Treatment" => [
                                "Freeze" => [
                                    "Conversion" => [
                                        "MaterialEntryGradeDetail",
                                    ],
                                ],
                                "MaterialEntry" => [
                                    "MaterialEntryGrade" => [
                                        "MaterialEntryGradeDetail",
                                    ],
                                ],
                            ],
                        ],
                        "ProductDetail" => [
                            "Product" => [
                                "Parent",
                                "ProductUnit",
                            ],
                        ],
                        "PackageDetailProduct" => [
                            "PackageDetail",
                            "ProductDetail"
                        ]
                    ],
                    "SaleDetail" => [
                        "Product" => [
                            "Parent",
                            "ProductUnit",
                        ],
                    ],
                ]
            ]);
            $this->set("dataProduct", ClassRegistry::init("Product")->find('all', array(
                        "contain" => array(
                            "Parent"
                        ),
                        "conditions" => [
                            "Not" => [
                                "Product.parent_id" => null,
                            ]
                        ],
            )));
            $this->set("dataTreatment", ClassRegistry::init("TreatmentDetail")->find('all', array(
                        "contain" => array(
                            "Treatment" => [
                                "Freeze" => [
                                    "Conversion" => [
                                        "MaterialEntryGradeDetail",
                                    ],
                                ],
                                "MaterialEntry" => [
                                    "MaterialEntryGrade" => [
                                        "MaterialEntryGradeDetail",
                                    ],
                                ],
                            ],
                        ),
                        "conditions" => [
                            "TreatmentDetail.remaining_weight >" => 0,
                            "Treatment.verify_status_id" => 3,
                            "Treatment.branch_office_id" => $this->stnAdmin->getBranchId()
                        ]
            )));
            $this->_activePrint(["print"], "print_packing_input_form", "no_kop");
        } else {
            throw new NotFoundException(__("404 Data Not Found."));
        }
    }

    function _generatePackageNo($count = 1, $inc_multiple) {
        $inc_id = $count + $inc_multiple;
        $testCode = "53849094[0-9]{5}";
        $lastRecord = $this->Package->PackageDetail->find('first', array('conditions' => array('and' => array("PackageDetail.package_no regexp" => $testCode)), 'order' => array('PackageDetail.package_no' => 'DESC')));
        if (!empty($lastRecord)) {
            $current = substr($lastRecord["PackageDetail"]["package_no"], -5);
            $inc_id += $current;
        }
        $inc_id = sprintf("%05d", $inc_id);
        $kode = "53849094$inc_id";
        return $kode;
    }

    function generate_barcode($no_package = null) {
        $this->autoRender = false;
        if (!empty($no_package) && $no_package != null) {
            try {
                // sample data to encode
                $data_to_encode = $no_package;

                $barcode = new BarcodeHelper();

                // Generate Barcode data
                $barcode->barcode();
                $barcode->setType('C128');
                $barcode->hideCodeType();
                $barcode->setCode($data_to_encode);
                $barcode->setSize(80, 200);

                // Generate filename
                $file = 'img/barcode/code_' . $no_package . '.png';

                // Generates image file on server            
                $barcode->writeBarcodeFile($file);

                return $file;
            } catch (Exception $ex) {
                throw new Exception("Failed to generate barcode!");
            }
        } else {
            throw NotFoundException(__("Data Not Found"));
        }
    }

}
