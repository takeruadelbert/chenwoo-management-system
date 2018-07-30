<?php

App::uses('AppController', 'Controller');

class EmployeeSalaryPeriodsController extends AppController {

    var $name = "EmployeeSalaryPeriods";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function _options() {
        $this->set("employees", ClassRegistry::init("Employee")->getListWithFullname());
        $this->set("incomeParameterSalaries", ClassRegistry::init("ParameterSalary")->find("list", array("fields" => array("ParameterSalary.id", "ParameterSalary.name"), "conditions" => array("ParameterSalary.parameter_salary_type_id" => 1))));
        $this->set("debtParameterSalaries", ClassRegistry::init("ParameterSalary")->find("list", array("fields" => array("ParameterSalary.id", "ParameterSalary.name"), "conditions" => array("ParameterSalary.parameter_salary_type_id" => 2))));
        $this->set("mapLabelParameterSalary", ClassRegistry::init("ParameterSalary")->find("list", ["fields" => ["ParameterSalary.code", "ParameterSalary.name"]]));
        $this->set("mapParameterSalary", ClassRegistry::init("ParameterSalary")->find("list", ["fields" => ["ParameterSalary.code", "ParameterSalary.id"]]));
        $this->set("employeeSalaryPeriodStatuses", ClassRegistry::init("EmployeeSalaryPeriodStatus")->find("list", ["fields" => ["EmployeeSalaryPeriodStatus.id", "EmployeeSalaryPeriodStatus.name"]]));
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_employee_salary_period");
        $this->_setPeriodeLaporanDate("awal_EmployeeSalaryPeriod_start_dt", "akhir_EmployeeSalaryPeriod_end_dt");
        $this->contain = [
            "CreateBy" => [
                "Account" => [
                    "Biodata",
                ],
            ],
            "KnownBy" => [
                "Account" => [
                    "Biodata",
                ],
            ],
            "VerifyBy" => [
                "Account" => [
                    "Biodata",
                ],
            ],
            "ApproveBy" => [
                "Account" => [
                    "Biodata",
                ],
            ],
            "KnownStatus",
            "VerifyStatus",
            "ApproveStatus",
        ];
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $startDt = $this->EmployeeSalaryPeriod->data["EmployeeSalaryPeriod"]["start_dt"];
                $endDt = $this->EmployeeSalaryPeriod->data["EmployeeSalaryPeriod"]["end_dt"];
//                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
//                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_add_step2', '?' => ["start_dt" => $startDt, "end_dt" => $endDt]));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_add_step2() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $parameterSalaries = ClassRegistry::init("ParameterSalary")->find("list", ["fields" => ["ParameterSalary.id", "ParameterSalary.parameter_salary_type_id"]]);
                foreach ($this->EmployeeSalaryPeriod->data["EmployeeSalaryPeriod"]["EmployeeSalary"] as &$employeeSalary) {
                    $employeeSalary["start_date_period"] = $this->EmployeeSalaryPeriod->data["EmployeeSalaryPeriod"]["start_dt"];
                    $employeeSalary["end_date_period"] = $this->EmployeeSalaryPeriod->data["EmployeeSalaryPeriod"]["end_dt"];
                    $employeeSalary["made_by_id"] = $this->stnAdmin->getEmployeeId();
                    foreach ($employeeSalary["ParameterEmployeeSalary"] as &$parameterEmployeeSalary) {
                        $parameterEmployeeSalary["nominal"] = ic_number_reverse($parameterEmployeeSalary["nominal"]);
                        if ($parameterSalaries[$parameterEmployeeSalary["parameter_salary_id"]] == 2) {
                            $parameterEmployeeSalary["nominal"]*=-1;
                        }
                    }
                }
                $this->EmployeeSalaryPeriod->data["EmployeeSalaryPeriod"]["create_by_id"] = $this->stnAdmin->getEmployeeId();
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
        $employees = ClassRegistry::init("Employee")->find("all", [
            "contain" => [
                "Account" => [
                    "Biodata",
                ],
                "EmployeeBasicSalary" => [
                    "conditions" => [
                        "EmployeeBasicSalary.end_date" => null,
                    ],
                ],
            ],
            "conditions" => [
                "Employee.employee_type_id" => 1,
                "Employee.branch_office_id" => $this->stnAdmin->getBranchId(),
                "NOT" => [
                    "Employee.id" => ClassRegistry::init("Employee")->excludedEmployee(),
                ],
            ],
        ]);
        $startDt = $this->request->query["start_dt"];
        $endDt = $this->request->query["end_dt"];
        $employeeIds = array_column(array_column($employees, "Employee"), "id");
        $dataAttendance = ClassRegistry::init("Attendance")->buildReport($startDt, $endDt, $employeeIds);
        $mapParameterSalary = ClassRegistry::init("ParameterSalary")->find("list", ["fields" => ["ParameterSalary.code", "ParameterSalary.id"]]);
        $entityConfiguration = ClassRegistry::init("EntityConfiguration")->find("first");
        //data potongan iuran koperasi
        $cooperativeContributionFee = ClassRegistry::init("CooperativeContributionFee")->find("list", ["fields" => ["CooperativeContributionFee.id", "CooperativeContributionFee.amount"], "conditions" => ["CooperativeContributionFee.employee_type_id" => 1]]);
        $iuran = array_shift($cooperativeContributionFee);
        $iuran = is_null($iuran) ? 0 : $iuran;
        //data potongan kepala ikan
        $saleProductAdditionals = ClassRegistry::init("SaleProductAdditional")->find("all", [
            "conditions" => [
                "DATE(SaleProductAdditional.created) >=" => $startDt,
                "DATE(SaleProductAdditional.created) <=" => $endDt,
                "SaleProductAdditional.payment_status_id" => 1,
            ],
            "recursive" => -1,
        ]);
        $dataPotongan = [];
        foreach ($saleProductAdditionals as $saleProductAdditional) {
            if (!isset($dataPotongan[$saleProductAdditional["SaleProductAdditional"]["purchaser_id"]])) {
                $dataPotongan[$saleProductAdditional["SaleProductAdditional"]["purchaser_id"]] = [
                    "amount" => 0,
                    "data" => [],
                ];
            }
            $dataPotongan[$saleProductAdditional["SaleProductAdditional"]["purchaser_id"]]["amount"]+=$saleProductAdditional["SaleProductAdditional"]["grand_total"];
            $dataPotongan[$saleProductAdditional["SaleProductAdditional"]["purchaser_id"]]["data"][] = [
                "id" => $saleProductAdditional["SaleProductAdditional"]["id"],
                "amount" => $saleProductAdditional["SaleProductAdditional"]["grand_total"],
            ];
        }
        //data potongan hutang
        $dataPotonganKasbon = [];
        $employeeDataLoans = ClassRegistry::init("EmployeeDataLoan")->find("all", [
            "conditions" => [
                "EmployeeDataLoan.verify_status_id" => 3,
                "EmployeeDataLoan.remaining_loan > 0",
            ],
            "contain" => [
                "CooperativeLoanHold" => [
                    "conditions" => [
                        "CooperativeLoanHold.start_period" => $startDt,
                        "CooperativeLoanHold.end_period" => $endDt,
                    ]
                ],
            ]
        ]);
        foreach ($employeeDataLoans as $employeeDataLoan) {
            if (!empty($employeeDataLoan["CooperativeLoanHold"])) {
                continue;
            }
            if (!isset($dataPotonganKasbon[$employeeDataLoan["EmployeeDataLoan"]["employee_id"]])) {
                $dataPotonganKasbon[$employeeDataLoan["EmployeeDataLoan"]["employee_id"]] = [
                    "amount" => 0,
                    "data" => [],
                ];
            }
            $potongan = ceil($employeeDataLoan["EmployeeDataLoan"]["total_amount_loan"] / $employeeDataLoan["EmployeeDataLoan"]["installment_number"] / 4);
            if ($potongan > $employeeDataLoan["EmployeeDataLoan"]["remaining_loan"]) {
                $potongan = $employeeDataLoan["EmployeeDataLoan"]["remaining_loan"];
            }
            $dataPotonganKasbon[$employeeDataLoan["EmployeeDataLoan"]["employee_id"]]["amount"]+=$potongan;
            $dataPotonganKasbon[$employeeDataLoan["EmployeeDataLoan"]["employee_id"]]["data"][] = [
                "id" => $employeeDataLoan["EmployeeDataLoan"]["id"],
                "amount" => $potongan,
            ];
        }
        //==
        //data potongan sembako
        $dataPotonganSembako = [];
        $cooperativeItemLoanPayment = ClassRegistry::init("CooperativeItemLoanPayment")->find("first", [
            "conditions" => [
                "CooperativeItemLoanPayment.start_period" => $startDt,
                "CooperativeItemLoanPayment.end_period" => $endDt,
                "CooperativeItemLoanPayment.employee_type_id" => 1,
            ],
            "contain" => [
                "CooperativeItemLoanPaymentDetail" => [
                    "CooperativeItemLoan",
                ],
            ]
        ]);
        if (!empty($cooperativeItemLoanPayment)) {
            foreach ($cooperativeItemLoanPayment["CooperativeItemLoanPaymentDetail"] as $cooperativeItemLoanPaymentDetail) {
                $dataPotonganSembako[$cooperativeItemLoanPaymentDetail["CooperativeItemLoan"]["employee_id"]]["amount"] = $cooperativeItemLoanPaymentDetail["amount"];
                $dataPotonganSembako[$cooperativeItemLoanPaymentDetail["CooperativeItemLoan"]["employee_id"]]["data"]["cooperative_item_loan_payment_detail_id"] = $cooperativeItemLoanPaymentDetail["id"];
                $dataPotonganSembako[$cooperativeItemLoanPaymentDetail["CooperativeItemLoan"]["employee_id"]]["data"]["cooperative_item_loan_id"] = $cooperativeItemLoanPaymentDetail["CooperativeItemLoan"]["id"];
                $dataPotonganSembako[$cooperativeItemLoanPaymentDetail["CooperativeItemLoan"]["employee_id"]]["data"]["amount"] = $cooperativeItemLoanPaymentDetail["amount"];
            }
        }
        //==
        //data kerja dari form hari kerja
        $dataWorkCount = [];
        $manualWorkingCounts = ClassRegistry::init("ManualWorkingCount")->find("all", [
            "conditions" => [
                "date(ManualWorkingCount.working_dt) between '$startDt'and '$endDt'",
                "ManualWorkingCount.manual_working_count_status_id" => 3,
            ],
            "contain" => [
                "ManualWorkingCountType",
            ],
        ]);
        foreach ($manualWorkingCounts as $manualWorkingCount) {
            if (!isset($dataWorkCount[$manualWorkingCount["ManualWorkingCount"]["employee_id"]])) {
                $dataWorkCount[$manualWorkingCount["ManualWorkingCount"]["employee_id"]] = [
                    "normal" => 0,
                    "holiday" => 0,
                ];
            }
            switch ($manualWorkingCount["ManualWorkingCount"]["manual_working_count_type_id"]) {
                case 1:
                case 2:
                    $workCountName = "normal";
                    break;
                case 3:
                case 4:
                    $workCountName = "holiday";
                    break;
            }
            $dataWorkCount[$manualWorkingCount["ManualWorkingCount"]["employee_id"]][$workCountName]+=$manualWorkingCount["ManualWorkingCountType"]["working_day"];
        }
        //==
        $dataSalary = [];
        $now = date("Y-m-d");
        foreach ($employees as $employee) {
            $tmt = empty($employee["Employee"]["tmt"]) ? date("Y-m-d") : $employee["Employee"]["tmt"];
            $tmtPlusOnYear = date("Y-m-d", strtotime($tmt . " + 365 day"));
            $employeeId = $employee["Employee"]["id"];
            if (!isset($dataWorkCount[$employeeId])) {
                $dataWorkCount[$employeeId] = [
                    "normal" => 0,
                    "holiday" => 0,
                ];
            }
            $salary = @$employee["EmployeeBasicSalary"][0]["salary"];
            $otSalary = @$employee["EmployeeBasicSalary"][0]["ot_salary"];
            $attendanceSummary = $dataAttendance[$employeeId]["summary"];
            $totalHadir = $attendanceSummary["jumlah_hadir_libur"] + $attendanceSummary["jumlah_hadir"] + array_sum($dataWorkCount[$employeeId]);
            $totalSalary = ($attendanceSummary["jumlah_hadir"] + $dataWorkCount[$employeeId]["normal"]) * $salary;
            $totalSalaryOt = ($attendanceSummary["jumlah_hadir_libur"] + ($dataWorkCount[$employeeId]["holiday"] / 2)) * $salary * 2;
            if (($totalSalary + $totalSalaryOt) <= 0) {
                $doReduction = false;
            } else {
                $doReduction = ($totalHadir > 0) ? true : false;
            }
            $dataSalary[$employeeId] = [
                "info" => [
                    "full_name" => $employee["Account"]["Biodata"]["full_name"],
                    "join_date" => $employee["Employee"]["tmt"],
                    "basic_salary" => is_null($salary) ? 0 : $salary,
                    "ot_salary" => is_null($otSalary) ? 0 : $otSalary,
                ],
                "salary" => [
                    "pendapatan" => [
                        "id" => 1,
                        "data" => [],
                    ],
                    "potongan" => [
                        "id" => 2,
                        "data" => [],
                    ],
                ],
                "attendance" => [
                    "extra" => [
                        "activereduction" => $doReduction,
                        "manual_form" => $dataWorkCount[$employeeId],
                    ],
                ],
                "relation" => [
                    "EmployeeSalaryLoan" => $doReduction ? e_isset(@$dataPotonganKasbon[$employeeId]["data"], []) : [],
                    "EmployeeSalarySaleProductAdditional" => $doReduction ? e_isset(@$dataPotongan[$employeeId]["data"], []) : [],
                    "EmployeeSalaryItemLoan" => $doReduction ? e_isset(@$dataPotonganSembako[$employeeId]["data"], false) : false,
                ],
            ];
            $dataSalary[$employeeId]["attendance"]["summary"] = $dataAttendance[$employeeId]["summary"];
            $dataSalary[$employeeId]["attendance"]["data"] = $dataAttendance[$employeeId]["data"];
            $dataSalary[$employeeId]["salary"]["pendapatan"]["data"][$mapParameterSalary["GPK"]] = $totalSalary;
            $dataSalary[$employeeId]["salary"]["pendapatan"]["data"][$mapParameterSalary["LPH"]] = $totalSalaryOt;
            $dataSalary[$employeeId]["salary"]["pendapatan"]["data"][$mapParameterSalary["LPJ"]] = floor($attendanceSummary["jumlah_jam_lembur"] / 3600 * $otSalary);
            $dataSalary[$employeeId]["salary"]["potongan"]["data"][$mapParameterSalary["IWP"]] = $doReduction ? (($tmtPlusOnYear <= $now) ? $iuran : 0) : 0;
            $dataSalary[$employeeId]["salary"]["potongan"]["data"][$mapParameterSalary["PKI"]] = $doReduction ? e_isset(@$dataPotongan[$employeeId]["amount"], 0) : 0;
            $dataSalary[$employeeId]["salary"]["potongan"]["data"][$mapParameterSalary["PKS"]] = $doReduction ? (e_isset(@$dataPotonganKasbon[$employeeId]["amount"], 0) + e_isset(@$dataPotonganSembako[$employeeId]["amount"], 0) ) : 0;
        }
        //==start data potongan
        $salaryReductions = ClassRegistry::init("SalaryReduction")->find("all", [
            "contain" => [
                "SalaryReductionDetail",
                "ParameterSalary",
            ],
        ]);
        foreach ($salaryReductions as $salaryReduction) {
            foreach ($salaryReduction["SalaryReductionDetail"] as $salaryReductionDetail) {
                if (isset($dataSalary[$salaryReductionDetail["employee_id"]])) {
                    $doReduction = $dataSalary[$salaryReductionDetail["employee_id"]]["attendance"]["extra"]["activereduction"];
                    $dataSalary[$salaryReductionDetail["employee_id"]]["salary"]["potongan"]["data"][$salaryReduction["ParameterSalary"]["id"]] = $doReduction ? $salaryReductionDetail["amount"] : 0;
                }
            }
        }
        //==end data potongan
        $this->set("dataAttendance", $dataAttendance);
        $this->set("dataSalary", $dataSalary);
    }

    function admin_view($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__("Id Not Found"));
        } else {
            $this->_activePrint(func_get_args(), "cetak_gaji_pegawai_harian");
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                'conditions' => array(
                    Inflector::classify($this->name) . ".id" => $id
                ),
                'contain' => [
                    "EmployeeSalary" => [
                        "ParameterEmployeeSalary" => [
                            "ParameterSalary",
                        ],
                        "Employee" => [
                            "Account" => [
                                "Biodata",
                            ],
                        ],
                        "EmployeeSalaryInfo",
                    ],
                    "CreateBy" => [
                        "Account" => [
                            "Biodata",
                        ],
                    ],
                    "KnownBy" => [
                        "Account" => [
                            "Biodata",
                        ],
                    ],
                    "VerifyBy" => [
                        "Account" => [
                            "Biodata",
                        ],
                    ],
                    "ApproveBy" => [
                        "Account" => [
                            "Biodata",
                        ],
                    ],
                ],
            ));
            $this->data = $rows;
        }
    }

    function admin_change_status() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $bulkStatus = false;
            switch ($this->request->query["type"]) {
                case "known":
                    $modelStatus = "KnownStatus";
                    $modelEmployee = "KnownBy";
                    $fieldStatus = "known_status_id";
                    $fieldEmployee = "known_by_id";
                    break;
                case "verify":
                    $modelStatus = "VerifyStatus";
                    $modelEmployee = "VerifyBy";
                    $fieldStatus = "verify_status_id";
                    $fieldEmployee = "verify_by_id";
                    break;
                case "approve":
                    $modelStatus = "ApproveStatus";
                    $modelEmployee = "ApproveBy";
                    $fieldStatus = "approve_status_id";
                    $fieldEmployee = "approve_by_id";
                    $bulkStatus = true;
                    break;
            }
            $this->EmployeeSalaryPeriod->id = $this->request->data['id'];
            $this->EmployeeSalaryPeriod->save(array("EmployeeSalaryPeriod" => array($fieldStatus => $this->request->data['status'], $fieldEmployee => $this->stnAdmin->getEmployeeId())));
            if ($bulkStatus && $this->request->data['status'] == 3) {
                ClassRegistry::init("EmployeeSalary")->updateAll([
                    "validate_status_id" => 2,
                    "validate_by_id" => $this->stnAdmin->getEmployeeId(),
                    "validate_datetime" => "'" . date('Y-m-d H:i:s') . "'",
                        ], [
                    "EmployeeSalary.employee_salary_period_id" => $this->request->data['id'],
                ]);
            } else if ($this->request->data['status'] == 2) {
                ClassRegistry::init("EmployeeSalary")->updateAll([
                    "validate_status_id" => 3,
                    "validate_by_id" => $this->stnAdmin->getEmployeeId(),
                    "validate_datetime" => "'" . date('Y-m-d H:i:s') . "'",
                        ], [
                    "EmployeeSalary.employee_salary_period_id" => $this->request->data['id'],
                ]);
            }
            $data = $this->EmployeeSalaryPeriod->find("first", array("conditions" => array("EmployeeSalaryPeriod.id" => $this->request->data['id']), "contain" => [$modelStatus, $modelEmployee => ["Account" => ["Biodata"]]]));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data[$modelStatus]['name'], "by" => $data[$modelEmployee]["Account"]["Biodata"]['full_name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_print_receipt_salary($id = null) {
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . ".id" => $id,
            ),
            'contain' => [
                "EmployeeSalary" => [
                    "ParameterEmployeeSalary" => [
                        "ParameterSalary",
                    ],
                    "Employee" => [
                        "Account" => [
                            "Biodata",
                        ],
                        "Department",
                        "EmployeeType"
                    ],
                    "EmployeeSalaryInfo",
                ],
                "CreateBy" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
                "KnownBy" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
                "VerifyBy" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
                "ApproveBy" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
            ],
        ));
        $this->data = $rows;

        $data = array(
            'title' => 'Slip Gaji',
            'rows' => $rows,
        );
        $this->set(compact('data'));
        if(isset($this->request->query['q']) && !empty($this->request->query['q'])) {
            $print_type = $this->request->query['q'];
            $layout_print = $print_type == "print" ? "print_receipt_salary" : "excel"; 
        }
        $this->_activePrint(["print", "excel"], "cetak_slip_gaji_harian", $layout_print);
    }
    
    function admin_print_receipt_salary_with_upper_average_salary($id = null) {
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . ".id" => $id,
            ),
            'contain' => [
                "EmployeeSalary" => [
                    "ParameterEmployeeSalary" => [
                        "ParameterSalary",
                    ],
                    "Employee" => [
                        "Account" => [
                            "Biodata",
                        ],
                        "Department",
                        "EmployeeType"
                    ],
                    "EmployeeSalaryInfo",
                ],
                "CreateBy" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
                "KnownBy" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
                "VerifyBy" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
                "ApproveBy" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
            ],
        ));
        $this->data = $rows;

        $data = array(
            'title' => 'Slip Gaji',
            'rows' => $rows,
        );
        $this->set(compact('data'));
        $this->_activePrint(["print"], "cetak_slip_gaji_harian_lebih_dari_ketentuan", "print_receipt_salary");
    }
    
    function admin_print_receipt_salary_with_lower_average_salary($id = null) {
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
                Inflector::classify($this->name) . ".id" => $id,
            ),
            'contain' => [
                "EmployeeSalary" => [
                    "ParameterEmployeeSalary" => [
                        "ParameterSalary",
                    ],
                    "Employee" => [
                        "Account" => [
                            "Biodata",
                        ],
                        "Department",
                        "EmployeeType"
                    ],
                    "EmployeeSalaryInfo",
                ],
                "CreateBy" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
                "KnownBy" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
                "VerifyBy" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
                "ApproveBy" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
            ],
        ));
        $this->data = $rows;

        $data = array(
            'title' => 'Slip Gaji',
            'rows' => $rows,
        );
        $this->set(compact('data'));
        $this->_activePrint(["print"], "cetak_slip_gaji_harian_kurang_dari_ketentuan", "print_receipt_salary");
    }
}
