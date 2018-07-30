<?php

App::uses('AppController', 'Controller');

class PopupsController extends AppController {

    var $name = "Popups";
    var $disabledAction = array(
        "admin_index",
        "admin_add",
        "admin_edit"
    );

    function beforeFilter() {
        parent::beforeFilter();
    }

    function admin_content() {
        $this->set("content", $this->params->query['content']);
        $this->set("query", $this->params->query);
        switch ($this->params->query['content']) {
            case "viewcoopsupplier":
                $this->data = ClassRegistry::init("CooperativeSupplier")->find("first", [
                    "conditions" => [
                        "CooperativeSupplier.id" => $this->params->query["supplierid"],
                    ]
                ]);
                break;
            case "viewcoopstock":
                $this->data = ClassRegistry::init("CooperativeGoodList")->find("first", [
                    "conditions" => [
                        "CooperativeGoodList.id" => $this->params->query["goodlistid"],
                    ],
                    "contain" => [
                        "CooperativeGoodListUnit",
                        "GoodType",
                        "CooperativeGoodListDetail" => [
                            "CooperativeGoodList" => [
                                "CooperativeGoodListUnit"
                            ]
                        ]
                    ]
                ]);
                break;
            case "viewcooptransaction-pmbl":
                $this->data = ClassRegistry::init("CooperativeCashDisbursement")->find("first", [
                    "conditions" => [
                        "CooperativeCashDisbursement.id" => $this->params->query["id"],
                    ],
                    "contain" => [
                        "Creator" => [
                            "Account" => [
                                "Biodata"
                            ],
                        ],
                        "CooperativeCash",
                        "CooperativeCashDisbursementDetail" => [
                            "CooperativeGoodList" => [
                                "CooperativeGoodListUnit"
                            ],
                        ],
                        "CooperativeSupplier",
                        "AssetFile",
                        "CooperativeSupplier"
                    ],
                ]);
                break;
            case "viewcooptransaction-pnju":
                $this->data = ClassRegistry::init("EmployeeDataLoan")->find("first", [
                    "conditions" => [
                        "EmployeeDataLoan.id" => $this->params->query["id"],
                    ],
                    "contain" => [
                        "Creator" => [
                            "Account" => [
                                "Biodata"
                            ],
                        ],
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                        ],
                        "CooperativeLoanInterest",
                        "CooperativeCash",
                        "CooperativeLoanType",
                        "EmployeeDataLoanDetail",
                        "VerifyStatus",
                    ],
                ]);
                break;
            case "viewcooptransaction-ansr":
                $this->data = ClassRegistry::init("EmployeeDataLoanDetail")->find("first", [
                    "conditions" => [
                        "EmployeeDataLoanDetail.id" => $this->params->query["id"],
                    ],
                    "contain" => [
                        "EmployeeDataLoan" => [
                            "Creator" => [
                                "Account" => [
                                    "Biodata"
                                ],
                            ],
                            "Employee" => [
                                "Account" => [
                                    "Biodata"
                                ],
                            ],
                            "CooperativeLoanInterest",
                            "CooperativeCash",
                            "CooperativeLoanType",
                            "VerifyStatus",
                        ],
                        "Creator" => [
                            "Account" => [
                                "Biodata"
                            ],
                        ],
                    ],
                ]);
                break;
            case "viewcooptransaction-pnjl":
                $this->data = ClassRegistry::init("CooperativeCashReceipt")->find("first", [
                    "conditions" => [
                        "CooperativeCashReceipt.id" => $this->params->query["id"],
                    ],
                    "contain" => [
                        "Operator" => [
                            "Account" => [
                                "Biodata"
                            ],
                        ],
                        "CooperativeCash",
                        "CooperativePaymentType",
                        "CooperativeCashReceiptDetail" => [
                            "CooperativeGoodList" => [
                                "CooperativeGoodListUnit"
                            ]
                        ],
                        "EmployeeDataLoan",
                    ],
                ]);
                break;
            case "viewcooptransaction-kklr":
                $this->data = ClassRegistry::init("CooperativeCashOut")->find("first", [
                    "conditions" => [
                        "CooperativeCashOut.id" => $this->params->query["id"],
                    ],
                    "contain" => [
                        "Creator" => [
                            "Account" => [
                                "Biodata"
                            ],
                        ],
                        "CooperativeCash",
                        "CooperativeCashOutDetail" => [
                            "AssetFile",
                        ],
                    ],
                ]);
                break;
            case "viewcooptransaction-kmsk":
                $this->data = ClassRegistry::init("CooperativeCashIn")->find("first", [
                    "conditions" => [
                        "CooperativeCashIn.id" => $this->params->query["id"],
                    ],
                    "contain" => [
                        "Creator" => [
                            "Account" => [
                                "Biodata"
                            ],
                        ],
                        "CooperativeCash",
                    ],
                ]);
                break;
            case "viewcooptransaction-smps":
                $this->data = ClassRegistry::init("EmployeeDataDeposit")->find("first", [
                    "conditions" => [
                        "EmployeeDataDeposit.id" => $this->params->query["id"],
                    ],
                    "contain" => [
                        "Creator" => [
                            "Account" => [
                                "Biodata"
                            ],
                        ],
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Office",
                            "Department",
                        ],
                        "VerifyStatus",
                        "VerifiedBy" => [
                            "Account" => [
                                "Biodata"
                            ],
                        ],
                        "CooperativeCash",
                        "EmployeeBalance",
                    ],
                ]);
                break;
            case "viewcooptransaction-smpt":
                $this->data = ClassRegistry::init("EmployeeDataDeposit")->find("first", [
                    "conditions" => [
                        "EmployeeDataDeposit.id" => $this->params->query["id"],
                    ],
                    "contain" => [
                        "Creator" => [
                            "Account" => [
                                "Biodata"
                            ],
                        ],
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Office",
                            "Department",
                        ],
                        "VerifyStatus",
                        "VerifiedBy" => [
                            "Account" => [
                                "Biodata"
                            ],
                        ],
                        "CooperativeCash",
                        "EmployeeBalance",
                    ],
                ]);
                break;
            case "viewcooptransaction-trns":
                $contain = am(
                        [
                    "Employee" => [
                        "Account" => [
                            "Biodata"
                        ],
                    ],
                    "CooperativeCash",
                    "CooperativeTransactionType",
                        ], ClassRegistry::init("CooperativeTransactionMutation")->_getRelatedModel(["reduction", "increase"]
                ));

                $this->data = ClassRegistry::init("CooperativeTransactionMutation")->find("first", [
                    "conditions" => [
                        "CooperativeTransactionMutation.id" => $this->params->query["id"],
                    ],
                    "contain" => $contain,
                ]);
                break;
            case "detailstockproduksi":
                $this->loadModel("Product");
                $this->Product->virtualFields = [
                    "stock" => sprintf($this->Product->vfRemainingStock, $this->stnAdmin->getBranchId()),
                ];
                $this->data = $this->Product->find("first", [
                    "conditions" => [
                        "Product.id" => $this->params->query["id"],
                    ],
                    "contain" => [
                        "Parent",
                        "ProductDetail" => [
                            "conditions" => [
                                "ProductDetail.remaining_weight > 0",
                                "ProductDetail.branch_office_id" => $this->stnAdmin->getBranchId(),
                            ],
                        ],
                        "ProductUnit",
                    ],
                ]);
                break;
            case "viewsalepackage":
                $this->data = ClassRegistry::init("Sale")->find("first", [
                    "conditions" => [
                        "Sale.id" => $this->request->query["id"],
                    ],
                    "contain" => [
                        "SaleDetail" => [
                            "Product" => [
                                "Parent",
                                "ProductUnit",
                            ],
                        ],
                        "Buyer"
                    ]
                ]);
                break;
            case "viewcoopmaterialadditional-ro":
                $contain = am(
                        [
                            "Employee" => [
                                "Account" => [
                                    "Biodata"
                                ],
                            ],
                            "RequestOrderMaterialAdditionalStatus",
                            "RequestOrderMaterialAdditionalDetail" => [
                                "MaterialAdditional" => [
                                    "MaterialAdditionalUnit"
                                ]
                            ],
                        ]
                );

                $this->data = ClassRegistry::init("RequestOrderMaterialAdditional")->find("first", [
                    "conditions" => [
                        "RequestOrderMaterialAdditional.id" => $this->params->query["id"],
                    ],
                    "contain" => $contain,
                ]);
                break;
            case "viewcoopmaterialadditional-po":
                $contain = [
                    "PurchaseOrderMaterialAdditional" => [
                        "PurchaseOrderMaterialAdditionalDetail" => [
                            "MaterialAdditional" => [
                                "MaterialAdditionalUnit"
                            ]
                        ],
                        "MaterialAdditionalSupplier",
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Office",
                            "Department"
                        ],
                    ],
                    "RequestOrderMaterialAdditionalStatus",
                    "RequestOrderMaterialAdditionalDetail" => [
                        "MaterialAdditional"
                    ],
                ];

                $this->data = ClassRegistry::init("RequestOrderMaterialAdditional")->find("first", [
                    "conditions" => [
                        "RequestOrderMaterialAdditional.id" => $this->params->query["id"],
                    ],
                    "contain" => $contain,
                ]);
                break;
            case "viewpo-materialadditional":
                $contain = [
                    "Employee" => [
                        "Account" => [
                            "Biodata"
                        ],
                        "Office",
                        "Department"
                    ],
                    "RequestOrderMaterialAdditional" => [
                        "RequestOrderMaterialAdditionalStatus",
                        "RequestOrderMaterialAdditionalDetail" => [
                            "MaterialAdditional"
                        ],
                    ],
                    "MaterialAdditionalSupplier",
                    "PurchaseOrderMaterialAdditionalDetail" => [
                        "MaterialAdditional" => [
                            "MaterialAdditionalUnit"
                        ]
                    ]
                ];

                $this->data = ClassRegistry::init("PurchaseOrderMaterialAdditional")->find("first", [
                    "conditions" => [
                        "PurchaseOrderMaterialAdditional.id" => $this->params->query["id"],
                    ],
                    "contain" => $contain,
                ]);
                break;
            case "viewcoopmaterialadditional-entry":
                $contain = am(
                        [

                            "PurchaseOrderMaterialAdditionalDetail" => [
                                "MaterialAdditional"
                            ],
                            "MaterialAdditionalEntry" => [
                                "MaterialAdditionalEntryDetail" => [
                                    "MaterialAdditional" => [
                                        "MaterialAdditionalUnit"
                                    ]
                                ]
                            ]
                        ]
                );

                $this->data = ClassRegistry::init("PurchaseOrderMaterialAdditional")->find("first", [
                    "conditions" => [
                        "PurchaseOrderMaterialAdditional.id" => $this->params->query["id"],
                    ],
                    "contain" => $contain,
                ]);
                break;
            case "viewautocountmaterialadditional":
                $sale = ClassRegistry::init("Sale")->find("first", [
                    "conditions" => [
                        "Sale.id" => $this->request->query["id"],
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
                break;
            case "viewdebitinvoice-sale":
                $contain = am(
                        [
                            "Sale" => [
                                "Buyer" => [
                                    "City",
                                    "State",
                                    "Country",
                                    "CpCity",
                                    "CpState",
                                    "CpCountry"
                                ],
                                "SaleDetail" => [
                                    "Product" => [
                                        "Parent"
                                    ],
                                    "McWeight"
                                ],
                            ],
                            "InitialBalance" => [
                                "GeneralEntryType"
                            ],
                            "VerifyStatus",
                            "VerifiedBy" => [
                                "Account" => [
                                    "Biodata"
                                ]
                            ]
                        ]
                );

                $this->data = ClassRegistry::init("DebitInvoiceSale")->find("first", [
                    "conditions" => [
                        "DebitInvoiceSale.id" => $this->params->query["id"],
                    ],
                    "contain" => $contain,
                ]);
                break;
            case "viewdebitinvoice-purchase":
                $contain = am(
                        [
                            "TransactionEntry" => [
                                "Supplier" => [
                                    "City",
                                    "State",
                                    "Country",
                                    "CpCity",
                                    "CpState",
                                    "CpCountry",
                                    "SupplierType"
                                ],
                                "TransactionMaterialEntry" => [
                                    "MaterialDetail",
                                    "MaterialSize"
                                ],
                            ],
                            "InitialBalance" => [
                                "GeneralEntryType"
                            ],
                            "VerifyStatus",
                            "VerifiedBy" => [
                                "Account" => [
                                    "Biodata"
                                ]
                            ]
                        ]
                );

                $this->data = ClassRegistry::init("DebitInvoicePurchaser")->find("first", [
                    "conditions" => [
                        "DebitInvoicePurchaser.id" => $this->params->query["id"],
                    ],
                    "contain" => $contain,
                ]);
                break;
            case "viewdebitinvoice-purchase-materialadditional":
                $contain = am(
                        [
                            "PurchaseOrderMaterialAdditional" => [
                                "MaterialAdditionalSupplier" => [
                                    "City",
                                    "State",
                                    "Country",
                                    "CpCity",
                                    "CpState",
                                    "CpCountry",
                                ],
                                "PurchaseOrderMaterialAdditionalDetail" => [
                                    "MaterialAdditional" => [
                                        "MaterialAdditionalUnit"
                                    ],
                                ],
                            ],
                            "InitialBalance" => [
                                "GeneralEntryType"
                            ],
                            "VerifyStatus",
                            "VerifiedBy" => [
                                "Account" => [
                                    "Biodata"
                                ]
                            ]
                        ]
                );

                $this->data = ClassRegistry::init("DebitInvoicePurchaserMaterialAdditional")->find("first", [
                    "conditions" => [
                        "DebitInvoicePurchaserMaterialAdditional.id" => $this->params->query["id"],
                    ],
                    "contain" => $contain,
                ]);
                break;
            case "viewpaymentpurchase-ikan":
                $contain = [
                    "TransactionEntry" => [
                        "TransactionMaterialEntry" => [
                            "MaterialDetail",
                            "MaterialSize"
                        ],
                        "Supplier" => [
                            "City",
                            "State",
                            "Country",
                            "CpCity",
                            "CpState",
                            "CpCountry",
                            "SupplierType"
                        ]
                    ],
                    "PaymentType",
                    "InitialBalance" => [
                        "GeneralEntryType"
                    ],
                    "VerifyStatus",
                    "Employee" => [
                        "Account" => [
                            "Biodata"
                        ],
                        "Department",
                        "Office"
                    ],
                    "BranchOffice",
                ];

                $this->data = ClassRegistry::init("PaymentPurchase")->find("first", [
                    "conditions" => [
                        "PaymentPurchase.id" => $this->params->query["id"],
                    ],
                    "contain" => $contain,
                ]);
                break;
            case "viewpaymentpurchase-materialpembantu":
                $contain = am(
                        [
                            "PurchaseOrderMaterialAdditional" => [
                                "MaterialAdditionalSupplier" => [
                                    "City",
                                    "State",
                                    "Country",
                                    "CpCity",
                                    "CpState",
                                    "CpCountry",
                                ],
                                "PurchaseOrderMaterialAdditionalDetail" => [
                                    "MaterialAdditional" => [
                                        "MaterialAdditionalUnit"
                                    ]
                                ],
                            ],
                            "InitialBalance" => [
                                "GeneralEntryType"
                            ],
                            "PaymentType",
                            "VerifyStatus",
                            "VerifiedBy" => [
                                "Account" => [
                                    "Biodata"
                                ]
                            ],
                            "Employee" => [
                                "Account" => [
                                    "Biodata"
                                ],
                                "Department",
                                "Office"
                            ]
                        ]
                );

                $this->data = ClassRegistry::init("PaymentPurchaseMaterialAdditional")->find("first", [
                    "conditions" => [
                        "PaymentPurchaseMaterialAdditional.id" => $this->params->query["id"],
                    ],
                    "contain" => $contain,
                ]);
                break;
            case "viewpaymentsale":
                $contain = am(
                        [
                            "Sale" => [
                                "Buyer" => [
                                    "City",
                                    "State",
                                    "Country",
                                    "CpCity",
                                    "CpState",
                                    "CpCountry",
                                    "BuyerType"
                                ],
                                "SaleDetail" => [
                                    "Product" => [
                                        "Parent"
                                    ],
                                    "McWeight"
                                ],
                                "ShipmentPaymentType",
                            ],
                            "InitialBalance" => [
                                "GeneralEntryType"
                            ],
                            "PaymentType",
                            "Employee" => [
                                "Account" => [
                                    "Biodata"
                                ],
                                "Department",
                                "Office"
                            ]
                        ]
                );

                $this->data = ClassRegistry::init("PaymentSale")->find("first", [
                    "conditions" => [
                        "PaymentSale.id" => $this->params->query["id"],
                    ],
                    "contain" => $contain,
                ]);
                break;
            case "viewpaymentsalematerialadditional" :
                $contain = [
                    "MaterialAdditionalSale" => [
                        "Supplier" => [
                            "City",
                            "State",
                            "Country",
                            "CpCity",
                            "CpState",
                            "CpCountry",
                        ],
                        "MaterialAdditionalSaleDetail" => [
                            "MaterialAdditional" => [
                                "MaterialAdditionalUnit"
                            ]
                        ],
                        "Employee" => [
                            "Account" => [
                                'Biodata'
                            ],
                            "Department",
                            "Office"
                        ]
                    ],
                    "InitialBalance" => [
                        "GeneralEntryType"
                    ],
                    "Employee" => [
                        "Account" => [
                            'Biodata'
                        ],
                        "Department",
                        "Office"
                    ],
                    "PaymentType"
                ];
                $this->data = ClassRegistry::init("PaymentSaleMaterialAdditional")->find("first", [
                    "conditions" => [
                        "PaymentSaleMaterialAdditional.id" => $this->params->query['id']
                    ],
                    "contain" => $contain
                ]);
                break;
            case "viewpaymentdebt" :
                $contain = am(
                        [
                            "TransactionEntry"
                        ]
                );
                $this->data = ClassRegistry::init("Supplier")->find("first", [
                    "conditions" => [
                        "Supplier.id" => $this->params->query['id']
                    ],
                    "contain" => $contain
                ]);
                break;
            case "viewpaymentdebt-materialadditional" :
                $contain = am([
                    "PurchaseOrderMaterialAdditional"
                ]);
                $this->data = ClassRegistry::init("MaterialAdditionalSupplier")->find("first", [
                    "conditions" => [
                        "MaterialAdditionalSupplier.id" => $this->params->query['id']
                    ],
                    "contain" => $contain
                ]);
                break;
            case "viewsaleproductadditional" :
            case "viewcooptransaction-pnjl-pt":
                $contain = [
                    "SaleProductAdditionalDetail" => [
                        "ProductAdditional"
                    ],
                    "Employee" => [
                        "Account" => [
                            "Biodata"
                        ],
                        "Department",
                        "Office"
                    ],
                    "Purchaser" => [
                        "Account" => [
                            "Biodata"
                        ]
                    ],
                    "PaymentType",
                    "InitialBalance" => [
                        "GeneralEntryType"
                    ]
                ];
                $this->data = ClassRegistry::init("SaleProductAdditional")->find("first", [
                    "conditions" => [
                        "SaleProductAdditional.id" => $this->params->query['id']
                    ],
                    "contain" => $contain
                ]);
                break;
            case "viewmaterialadditional-return" :
                $contain = [
                    "MaterialAdditionalPerContainer" => [
                        "Sale" => [
                            "SaleDetail",
                            "Buyer" => [
                                "BuyerType"
                            ],
                        ],
                    ],
                    "MaterialAdditionalReturnDetail" => [
                        "MaterialAdditionalMc",
                        'MaterialAdditionalPlastic',
                        "Product" => [
                            "Parent"
                        ]
                    ],
                    "Employee" => [
                        "Account" => [
                            "Biodata"
                        ]
                    ]
                ];
                $this->data = ClassRegistry::init("MaterialAdditionalReturn")->find("first", [
                    "conditions" => [
                        "MaterialAdditionalReturn.id" => $this->params->query['id']
                    ],
                    "contain" => $contain
                ]);
                break;
            case "viewtreatment" :
                $contain = [
                    "Treatment" => [
                        "TreatmentDetail" => [
                            "Product" => [
                                "Parent"
                            ],
                            "RejectedGradeType"
                        ],
                        "Employee" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Department",
                            "Office"
                        ],
                        "Operator" => [
                            "Account" => [
                                "Biodata"
                            ],
                            "Office",
                            "Department"
                        ],
                        "TreatmentSourceDetail" => [
                            "Product"
                        ],
                        "Freeze" => [
                            "FreezeDetail"
                        ]
                    ]
                ];
                $this->data = ClassRegistry::init("MaterialEntry")->find("first", [
                    "conditions" => [
                        "MaterialEntry.id" => $this->params->query['id']
                    ],
                    "contain" => $contain
                ]);
                break;
            case "viewproducthistories" :
                $contain = [
                    "Treatment" => [
                        "TreatmentDetail" => [
                            "Product" => [
                                "Parent"
                            ]
                        ]
                    ],
                    "Shipment" => [
                        "Sale" => [
                            "SaleDetail" => [
                                "Product" => [
                                    "Parent"
                                ]
                            ]
                        ]
                    ],
                    "ProductHistoryType",
                    "Product" => [
                        "Parent"
                    ]
                ];
                $this->data = ClassRegistry::init("ProductHistory")->find("first", [
                    "conditions" => [
                        "ProductHistory.id" => $this->params->query['id']
                    ],
                    "contain" => $contain
                ]);
                break;
            case "viewtreatment_index" :
                $contain = [
                    "TreatmentDetail" => [
                        "Product" => [
                            "Parent"
                        ],
                        "RejectedGradeType"
                    ],
                    "Employee" => [
                        "Account" => [
                            "Biodata"
                        ],
                        "Department",
                        "Office"
                    ],
                    "Operator" => [
                        "Account" => [
                            "Biodata"
                        ],
                        "Office",
                        "Department"
                    ],
                    "TreatmentSourceDetail" => [
                        "Product" => [
                            "Parent"
                        ],
                        "FreezeDetail" => [
                            "Freeze"
                        ]
                    ],
                    "VerifyStatus",
                    "VerifiedBy" => [
                        "Account" => [
                            "Biodata"
                        ]
                    ]
                ];
                $this->data = ClassRegistry::init("Treatment")->find("first", [
                    "conditions" => [
                        "Treatment.id" => $this->params->query['id']
                    ],
                    "contain" => $contain
                ]);
                break;
            case "viewsalaryallowance" :
                $contain = [
                    "Employee" => [
                        "Account" => [
                            "Biodata"
                        ]
                    ],
                    "SalaryAllowanceDetail" => [
                        "ParameterSalary"
                    ]
                ];
                $this->data = ClassRegistry::init("SalaryAllowance")->find("first", [
                    "conditions" => [
                        "SalaryAllowance.id" => $this->params->query['id']
                    ],
                    "contain" => $contain
                ]);
                break;
            case "viewcashdisbursement" :
                $contain = [
                    "TransactionCurrencyType",
                    "CashDisbursementDetail",
                    "InitialBalance" => [
                        "GeneralEntryType"
                    ],
                    "Creator" => [
                        "Account" => [
                            "Biodata"
                        ],
                        "Department",
                        "Office"
                    ],
                    "GeneralEntryType"
                ];
                $this->data = ClassRegistry::init("CashDisbursement")->find("first", [
                    "conditions" => [
                        "CashDisbursement.id" => $this->params->query['id']
                    ],
                    "contain" => $contain
                ]);
                break;
            case "viewcashdisbursement_multiplecoa" :
                $contain = [
                    "TransactionCurrencyType",
                    "CashDisbursementDetail" => [
                        "GeneralEntryType"
                    ],
                    "InitialBalance" => [
                        "GeneralEntryType"
                    ],
                    "Creator" => [
                        "Account" => [
                            "Biodata"
                        ],
                        "Department",
                        "Office"
                    ],
                ];
                $this->data = ClassRegistry::init("CashDisbursement")->find("first", [
                    "conditions" => [
                        "CashDisbursement.id" => $this->params->query['id']
                    ],
                    "contain" => $contain
                ]);
                break;
            case "viewdepreciationasset" :
                $contain = [
                    "AssetProperty"
                ];
                $this->data = ClassRegistry::init("DepreciationAsset")->find("first",[
                    "conditions" => [
                        "DepreciationAsset.id" => $this->params->query['id']
                    ],
                    "contain" => $contain
                ]);
                break;
        }
    }

}
