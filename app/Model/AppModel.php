<?php

/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Model', 'Model');
App::import('Vendor', 'stnadmin');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    /**
     * @var \StnAdmin;
     */
    public $stnAdmin;
    var $actsAs = array(
        'Containable',
        //model =>["field"=>["type"=>"date/datetime]]
        "IndonesiaConversion" => [
            "CooperativeCashDisbursement" => [
                "created_date" => [
                    "type" => "datetime",
                ],
                "grand_total" => [
                    "type" => "idrseprator",
                ],
            ],
            "CooperativeCashDisbursementDetail" => [
                "amount" => [
                    "type" => "idrseprator",
                ],
                "total_amount" => [
                    "type" => "idrseprator",
                ],
                "quantity" => [
                    "type" => "numberseparator",
                ],
            ],
            "EmployeeDataLoan" => [
                "amount_loan" => [
                    "type" => "idrseprator",
                ],
                "total_amount_loan" => [
                    "type" => "idrseprator",
                ],
                "remaining_loan" => [
                    "type" => "idrseprator",
                ],
                "date" => [
                    "type" => "datetime",
                ],
                "created" => [
                    "type" => "datetime",
                ],
            ],
            "CooperativeCashReceipt" => [
                "date" => [
                    "type" => "datetime",
                ],
                "grand_total" => [
                    "type" => "idrseprator",
                ],
            ],
            "CooperativeCashReceiptDetail" => [
                "amount" => [
                    "type" => "idrseprator",
                ],
                "total_amount" => [
                    "type" => "idrseprator",
                ],
                "price" => [
                    "type" => "idrseprator",
                ],
                "quantity" => [
                    "type" => "numberseparator",
                ],
            ],
            "CooperativeCashOut" => [
                "amount" => [
                    "type" => "idrseprator",
                ],
                "created" => [
                    "type" => "datetime",
                ],
                "created_datetime" => [
                    "type" => "datetime",
                ],
            ],
            "CooperativeCashOutDetail" => [
                "amount" => [
                    "type" => "idrseprator",
                ],
                "date" => [
                    "type" => "datetime",
                ],
            ],
            "CooperativeCashIn" => [
                "amount" => [
                    "type" => "idrseprator",
                ],
                "created_datetime" => [
                    "type" => "datetime",
                ],
                "created" => [
                    "type" => "datetime",
                ],
            ],
            "CooperativeTransactionMutation" => [
                "nominal" => [
                    "type" => "idrseprator",
                ],
                "transaction_date" => [
                    "type" => "datetime",
                ],
                "created" => [
                    "type" => "datetime",
                ],
            ],
            "EmployeeDataLoanDetail" => [
                "amount" => [
                    "type" => "idrseprator",
                ],
                "remaining_loan" => [
                    "type" => "idrseprator",
                ],
                "paid_date" => [
                    "type" => "dateonly",
                ],
                "due_date" => [
                    "type" => "dateonly",
                ],
                "created" => [
                    "type" => "datetime",
                ],
            ],
            "EmployeeDataDeposit" => [
                "amount" => [
                    "type" => "idrseprator",
                ],
                "withdrawal_amount" => [
                    "type" => "idrseprator",
                ],
                "balance" => [
                    "type" => "idrseprator",
                ],
                "deposit_previous_balance" => [
                    "type" => "idrseprator",
                ],
                "verified_datetime" => [
                    "type" => "dateonly",
                ],
                "transaction_date" => [
                    "type" => "dateonly",
                ],
                "created" => [
                    "type" => "datetime",
                ],
            ],
            "EmployeeBalance" => [
                "amount" => [
                    "type" => "idrseprator",
                ],
            ],
            "Conversion" => [
                "created" => [
                    "type" => "datetime",
                ],
            ],
            "Freeze" => [
                "created" => [
                    "type" => "datetime",
                ],
            ],
            "Freeze" => [
                "created" => [
                    "type" => "datetime",
                ],
            ],
            "TransactionEntry" => [
                "created_date" => [
                    "type" => "dateonly",
                ],
                "due_date" => [
                    "type" => "dateonly",
                ],
            ],
            "MaterialEntry" => [
                "weight_date" => [
                    "type" => "dateonly",
                ],
            ],
            "Product" => [
                "stock" => [
                    "type" => "kg",
                ],
            ]
        ],
    );
    var $numberSeperatorRemove = [
        "MaterialAdditionalReturnDetail" => [
            "quantity_mc" => [
                "type" => "dot"
            ],
            "quantity_plastic" => [
                "type" => "dot"
            ],
            "order_quantity_mc" => [
                "type" => "dot"
            ],
            "order_quantity_plastic" => [
                "type" => "dot"
            ],
        ],
        "PurchaseOrderMaterialAdditionalDetail" => [
            "price" => [
                "type" => "dot"
            ],
            "quantity" => [
                "type" => "dot"
            ],
            "remaining_quantity" => [
                "type" => 'dot'
            ]
        ],
        "MaterialAdditional" => [
            "quantity" => [
                "type" => "dot"
            ],
            "price" => [
                "type" => "dot"
            ],
        ],
        "PurchaseOrderMaterialAdditional" => [
            "total" => [
                "type" => "dot"
            ],
            "remaining" => [
                "type" => "dot"
            ],
            "shipment_cost" => [
                "type" => "dot"
            ],
        ],
        "MaterialAdditionalPerContainer" => [
            "total" => [
                "type" => "dot"
            ],
        ],
        "MaterialAdditionalPerContainerDetail" => [
            "quantity_plastic" => [
                "type" => "dot"
            ],
            "quantity_mc" => [
                "type" => "dot"
            ],
        ],
        "EmployeeSalary" => [
            "total_debt" => [
                "type" => "dot"
            ],
            "total_income" => [
                "type" => "dot"
            ],
        ],
        "PaymentPurchase" => [
            "amount" => [
                "type" => "dot"
            ],
            "remaining" => [
                "type" => "dot"
            ],
            "total_invoice_amount" => [
                "type" => "dot"
            ],
        ],
        "PaymentPurchaseMaterialAdditional" => [
            "amount" => [
                "type" => "dot"
            ],
            "remaining" => [
                "type" => "dot"
            ],
            "total_amount" => [
                "type" => "dot"
            ],
        ],
        "PaymentSale" => [
            "amount" => [
                "type" => "dot"
            ],
            "remaining" => [
                "type" => "dot"
            ],
            "total_invoice_amount" => [
                "type" => "dot"
            ],
            "exchange_rate" => [
                "type" => "dot"
            ],
        ],
        "PaymentSaleMaterialAdditional" => [
            'amount' => [
                'type' => 'dot'
            ],
            'remaining' => [
                'type' => "dot"
            ],
            'total_invoice_amount' => [
                'type' => "dot"
            ]
        ],
        "Sale" => [
            "grand_total" => [
                "type" => "dot"
            ],
            "remaining" => [
                "type" => "dot"
            ],
            "shipping_cost" => [
                "type" => "dot"
            ],
        ],
        "SaleDetail" => [
            "quantity" => [
                "type" => "dot"
            ],
            "price" => [
                "type" => "dot"
            ],
            "nett_weight" => [
                "type" => "dot"
            ],
        ],
        "DebitInvoicePurchaser" => [
            "amount" => [
                "type" => "dot"
            ]
        ],
        "DebitInvoicePurchaserMaterialAdditional" => [
            "amount" => [
                "type" => "dot"
            ]
        ],
        "DebitInvoiceSale" => [
            "amount" => [
                "type" => "dot"
            ]
        ],
        "ParameterEmployeeSalary" => [
            "nominal" => [
                "type" => "dot"
            ]
        ],
        "CashDisbursement" => [
            "exchange_rate" => [
                "type" => "dot"
            ]
        ],
        "CashDisbursementDetail" => [
            "amount" => [
                "type" => "dot"
            ]
        ],
        "CooperativeLoanInterest" => [
            "upper_limit" => [
                "type" => "dot"
            ],
            "bottom_limit" => [
                "type" => "dot"
            ]
        ],
        "CooperativeDeposit" => [
            "upper_limit" => [
                "type" => "dot"
            ],
            "bottom_limit" => [
                "type" => "dot"
            ]
        ],
        "CooperativeGoodList" => [
            "sale_price" => [
                "type" => 'dot'
            ],
            "capital_price" => [
                "type" => "dot"
            ]
        ],
        "CooperativeCash" => [
            "nominal" => [
                "type" => "dot"
            ]
        ],
        "InitialBalance" => [
            "nominal" => [
                "type" => "dot"
            ],
            "exchange_rate" => [
                "type" => "dot"
            ]
        ],
        "EmployeeDataLoan" => [
            "amount_loan" => [
                "type" => "dot"
            ],
            "total_amount_loan" => [
                "type" => "dot"
            ],
            "remaining_loan" => [
                "type" => "dot"
            ]
        ],
        "EmployeeDataLoanDetail" => [
            "amount" => [
                "type" => "dot"
            ],
            "remaining_loan" => [
                "type" => "dot"
            ],
            "total_amount_loan" => [
                "type" => "dot"
            ],
        ],
        "EmployeeDataDeposit" => [
            "amount" => [
                "type" => "dot"
            ],
            "balance" => [
                "type" => "dot"
            ],
            "deposit_previous_balance" => [
                "type" => "dot"
            ],
            "withdrawal_amount" => [
                "type" => "dot"
            ]
        ],
        "CooperativeCashDisbursement" => [
            "grand_total" => [
                "type" => "dot"
            ],
        ],
        "CooperativeCashDisbursementDetail" => [
            "amount" => [
                "type" => "dot"
            ],
            "total_amount" => [
                "type" => "dot"
            ]
        ],
        "CooperativeCashReceipt" => [
            "grand_total" => [
                "type" => "dot"
            ]
        ],
        "CooperativeCashReceiptDetail" => [
            "total_amount" => [
                "type" => "dot"
            ],
            "price" => [
                "type" => "dot"
            ],
        ],
        "CooperativeTransactionMutation" => [
            "nominal" => [
                "type" => "dot"
            ]
        ],
        "CashMutation" => [
            "nominal" => [
                "type" => "dot"
            ],
            "exchange_rate" => [
                "type" => "dot"
            ]
        ],
        "CashIn" => [
            "amount" => [
                "type" => "dot"
            ]
        ],
        "TransactionEntry" => [
            "shipping_cost" => [
                "type" => "dot"
            ],
            "remaining" => [
                "type" => "dot"
            ],
            "total" => [
                "type" => "dot"
            ],
        ],
        "Freeze" => [
            "total_weight" => [
                "type" => "dot"
            ],
        ],
        "GeneralEntry" => [
            "debit" => [
                "type" => "dot"
            ],
            "credit" => [
                "type" => "dot"
            ],
            "total_debit" => [
                "type" => "dot"
            ],
            "total_credit" => [
                "type" => "dot"
            ],
            "exchange_rate" => [
                "type" => "dot"
            ]
        ],
        "GeneralEntryDebit" => [
            "debit" => [
                "type" => "dot"
            ]
        ],
        "GeneralEntryCredit" => [
            "credit" => [
                "type" => "dot"
            ]
        ],
        "GeneralEntryType" => [
            "initial_balance" => [
                "type" => "dot"
            ],
            "exchange_rate" => [
                "type" => "dot"
            ]
        ],
        "TransactionMutation" => [
            "debit" => [
                "type" => "dot"
            ],
            "credit" => [
                "type" => "dot"
            ],
            "initial_balance" => [
                "type" => "dot"
            ],
            "mutation_balance" => [
                "type" => "dot"
            ]
        ],
        "ClosingBook" => [
            "previous_balance" => [
                "type" => "dot"
            ],
            "current_balance" => [
                "type" => "dot"
            ],
            "dividend" => [
                "type" => "dot"
            ],
            "retained_earning" => [
                "type" => "dot"
            ]
        ],
        "TransactionMaterialEntry" => [
            "quantity" => [
                "type" => "dot"
            ],
            "price" => [
                "type" => "dot"
            ],
        ],
        "TreatmentProduct" => [
            "price" => [
                "type" => "dot"
            ]
        ],
        "Treatment" => [
            "total" => [
                "type" => "dot"
            ],
        ],
        "TreatmentDetail" => [
            "weight" => [
                "type" => "dot"
            ]
        ],
        "CooperativeCashIn" => [
            "amount" => [
                "type" => "dot"
            ]
        ],
        "CooperativeCashOutDetail" => [
            "amount" => [
                "type" => "dot"
            ]
        ],
        "CooperativeCashMutation" => [
            "nominal" => [
                "type" => "dot"
            ]
        ],
        "Employee" => [
            "salary" => [
                "type" => "dot"
            ]
        ],
        "RetainedEarning" => [
            "nominal" => [
                "type" => "dot"
            ]
        ],
        "Product" => [
            "price_rupiah" => [
                "type" => "dot"
            ]
        ],
        "ReturnOrder" => [
            "total" => [
                "type" => "dot"
            ]
        ],
        "AssetProperty" => [
            "nominal" => [
                "type" => "dot"
            ]
        ],
        "DepreciationAsset" => [
            "depreciation_amount" => [
                "type" => "dot"
            ],
            "current_nominal" => [
                "type" => "dot"
            ]
        ],
        "RevaluationAsset" => [
            "previous_nominal" => [
                "type" => "dot"
            ],
            "revaluation_nominal" => [
                "type" => "dot"
            ]
        ],
        "ProductAdditional" => [
            "price" => [
                "type" => "dot"
            ],
            "default_price" => [
                "type" => "dot"
            ]
        ],
        "SaleProductAdditional" => [
            "grand_total" => [
                "type" => "dot"
            ]
        ],
        "SaleProductAdditionalDetail" => [
            "nominal" => [
                "type" => "dot"
            ]
        ],
        "SalaryReductionDetail" => [
            "amount" => [
                "type" => "dot"
            ]
        ],
        "CooperativeItemLoanPaymentDetail" => [
            "amount" => [
                "type" => "dot"
            ],
            "current_debt" => [
                'type' => 'dot'
            ]
        ],
        "Employee" => [
            "new_salary" => [
                "type" => "dot"
            ],
            "new_ot_salary" => [
                "type" => "dot"
            ],
        ],
        "CooperativeContributionWithdraw" => [
            "amount" => [
                "type" => "dot",
            ],
        ],
        "SalaryAllowanceDetail" => [
            "amount" => [
                "type" => "dot"
            ]
        ],
        "MaterialAdditionalSale" => [
            "total" => [
                "type" => "dot"
            ],
            "total_remaining" => [
                "type" => "dot"
            ]
        ],
        "MaterialAdditionalSaleDetail" => [
            "price" => [
                "type" => "dot"
            ]
        ]
    ];
    var $deleteableHasmany = [
        "BudgetUsageDetail" => [
            "relationField" => "budget_usage_id",
        ],
        "ArchiveSlotDetail" => [
            "relationField" => "archive_slot_id",
        ],
        "CashDisbursementDetail" => [
            "relationField" => "cash_disbursement_id",
        ],
        "ParameterEmployeeSalary" => [
            "relationField" => "employee_salary_id",
        ],
        "ModuleLink" => [
            "relationField" => "module_id",
        ],
        "EducationHistory" => [
            "relationField" => "employee_id"
        ],
        "PositionHistory" => [
            "relationField" => "employee_id"
        ],
        "Family" => [
            "relationField" => "employee_id"
        ],
        "Training" => [
            "relationField" => "employee_id"
        ],
        "Honor" => [
            "relationField" => "employee_id"
        ],
        "SupplierFile" => [
            "relationField" => "supplier_id"
        ],
        "SupplierBank" => [
            "relationField" => "supplier_id"
        ],
        "MaterialAdditionalSupplierBank" => [
            "relationField" => "material_additional_supplier_id"
        ],
        "BuyerBank" => [
            "relationField" => "buyer_id"
        ],
        "PartnerBank" => [
            "relationField" => "partner_id"
        ],
        "MaterialDetail" => [
            "relationField" => "material_id",
        ],
        "City" => [
            "relationField" => "state_id",
        ],
        "FreezeDetail" => [
            "relationField" => "freeze_id"
        ],
        "SalaryAllowanceDetail" => [
            "relationField" => "salary_allowance_id"
        ],
        "MaterialAdditionalSaleDetail" => [
            "relationField" => "material_additional_sale_id"
        ]
    ];
    var $numberFixer = [
        "Conversion" => [
            "total" => [
                "type" => "id-ID",
            ],
            "ratio" => [
                "type" => "id-ID",
            ],
        ],
        "ConversionData" => [
            "material_size_quantity" => [
                "type" => "id-ID",
            ],
        ],
        "PaymentSale" => [
            "amount" => [
                "type" => "id-ID",
            ],
        ],
    ];

    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->stnAdmin = new StnAdmin();
    }

    public function saveData() {
        $this->saveAll($this->data, array("deep" => true));
    }

    //only 1 level
    //TO-DO:deep level
    public function _numberSeperatorRemover() {
        $collectedModelName = array_keys($this->numberSeperatorRemove);
        foreach ($this->data as $modelName => $v) {
            if (in_array($modelName, $collectedModelName)) {
                if (Hash::numeric(array_keys($v))) {
                    foreach ($v as $index => $dataSet) {
                        foreach ($dataSet as $field => $value) {
                            if (array_key_exists($field, $this->numberSeperatorRemove[$modelName])) {
                                if (isset($this->data[$modelName][$index]["nsr__" . $field])) {
                                    $type = $this->data[$modelName][$index]["nsr__" . $field];
                                } else {
                                    $type = $this->numberSeperatorRemove[$modelName][$field]["type"];
                                }
                                if ($type == "dot") {
                                    $this->data[$modelName][$index][$field] = str_replace('.', '', $value);
                                } else if ($type == "comma") {
                                    $this->data[$modelName][$index][$field] = str_replace(',', '', $value);
                                }
                            }
                        }
                    }
                } else {
                    foreach ($v as $field => $value) {
                        if (array_key_exists($field, $this->numberSeperatorRemove[$modelName])) {
                            if (isset($this->data[$modelName]["nsr__" . $field])) {
                                $type = $this->data[$modelName]["nsr__" . $field];
                            } else {
                                $type = $this->numberSeperatorRemove[$modelName][$field]["type"];
                            }
                            if ($type == "dot") {
                                $this->data[$modelName][$field] = str_replace('.', '', $value);
                            } else if ($type == "comma") {
                                $this->data[$modelName][$field] = str_replace(',', '', $value);
                            }
                        }
                    }
                }
            }
        }
    }

    //only 1 level
    //TO-DO:deep level
    public function _numberFixer() {
        $collectedModelName = array_keys($this->numberFixer);
        foreach ($this->data as $modelName => $v) {
            if (in_array($modelName, $collectedModelName)) {
                if (Hash::numeric(array_keys($v))) {
                    foreach ($v as $index => $dataSet) {
                        foreach ($dataSet as $field => $value) {
                            if (array_key_exists($field, $this->numberFixer[$modelName])) {
                                if ($this->numberFixer[$modelName][$field]["type"] == "id-ID") {
                                    $this->data[$modelName][$index][$field] = ic_number_reverse($value);
                                }
                            }
                        }
                    }
                } else {
                    foreach ($v as $field => $value) {
                        if (array_key_exists($field, $this->numberFixer[$modelName])) {
                            if ($this->numberFixer[$modelName][$field]["type"] == "id-ID") {
                                $this->data[$modelName][$field] = ic_number_reverse($value);
                            }
                        }
                    }
                }
            }
        }
    }

    public function _deleteableHasmany() {
        $tosaveModel = array_keys($this->data);
        $deleteableModels = array_intersect($tosaveModel, array_keys($this->deleteableHasmany));
        foreach ($deleteableModels as $deleteableModel) {
            $relationId = @$this->data[Inflector::classify(rtrim($this->deleteableHasmany[$deleteableModel]["relationField"], "_id"))]["id"];
            if (!empty($relationId)) {
//                debug($relationId);
                $currentModel = ClassRegistry::init($deleteableModel);
                $tosaveIds = array_column($this->data[$deleteableModel], "id");
                $recordedIds = $currentModel->find("list", [
                    "fields" => [
                        "$deleteableModel.id",
                    ],
                    "conditions" => [
                        "$deleteableModel.{$this->deleteableHasmany[$deleteableModel]["relationField"]}" => $relationId,
                    ]
                ]);
                $todeleteIds = array_diff($recordedIds, $tosaveIds);
                $currentModel->deleteAll(["$deleteableModel.id" => $todeleteIds]);
            }
        }
    }

}
