<?php

App::uses('AppController', 'Controller');

class CooperativeContributionsController extends AppController {

    var $name = "CooperativeContributions";
    var $disabledAction = array(
    );
    var $contain = [
        "Employee" => [
            "Account" => [
                "Biodata",
            ],
        ],
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_iuran_koperasi");
        $this->conds = [
            "NOT" => [
                "CooperativeContribution.amount" => 0,
            ]
        ];
        parent::admin_index();
    }

    function admin_rekap($id = null) {
        $this->CooperativeContribution->virtualFields = [
            "total" => "sum(CooperativeContribution.amount)",
            "paid" => "select COALESCE(sum(CooperativeContributionWithdraw.amount),0) from cooperative_contribution_withdraws CooperativeContributionWithdraw where CooperativeContributionWithdraw.employee_id=CooperativeContribution.employee_id",
        ];
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'contain' => [
                "Employee" => [
                    "Account" => [
                        "Biodata"
                    ],
                ],
            ],
            'group' => [
                "CooperativeContribution.employee_id"
            ]
        ));
        $this->data = $rows;
        $data = array(
            'title' => 'REKAPITULASI IURAN',
            'rows' => $rows,
        );
        $this->set(compact('data'));
        $this->_activePrint(func_get_args(), "print_rekapitulasi_iuran", "print");
    }

    function import() {
        $this->autoRender = false;
        /** Include path * */
        $vendorPath = App::path('Vendor');
        /** PHPExcel_IOFactory */
        include $vendorPath[0] . 'phpexcel/PHPExcel/IOFactory.php';


        $inputFileName = WWW_ROOT . DS . 'test1.xlsx';
        echo 'Loading file ', pathinfo($inputFileName, PATHINFO_BASENAME), ' using IOFactory to identify the format<br />';
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

        echo '<hr />';

        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $dataIuran = [];
        $dataIuranSebelum2017 = [];
        foreach ($sheetData as $rowName => $row) {
            if ($rowName >= 4 && $rowName <= 93) {
                $employeeId = $sheetData[$rowName]["A"];
                $amount = $sheetData[$rowName]["C"];
                $amount2017 = $sheetData[$rowName]["E"];
                if (!empty($employeeId)) {
                    $dataIuranSebelum2017[$employeeId] = ac_number_reverse(trim($amount)) - ac_number_reverse(trim($amount2017));
                }
            }
            foreach ($row as $columnName => $column) {
                if (PHPEXCEL_Cell::columnIndexFromString($columnName) >= PHPEXCEL_Cell::columnIndexFromString("F") && PHPEXCEL_Cell::columnIndexFromString($columnName) <= PHPEXCEL_Cell::columnIndexFromString("AH") && $rowName == 3) {
                    $dataIuran[$column] = [];
                }
                if ($rowName >= 4 && $rowName <= 93) {
                    $employeeId = $sheetData[$rowName]["A"];
                    $date = $sheetData[3][$columnName];
                    if (PHPEXCEL_Cell::columnIndexFromString($columnName) >= PHPEXCEL_Cell::columnIndexFromString("F") && PHPEXCEL_Cell::columnIndexFromString($columnName) <= PHPEXCEL_Cell::columnIndexFromString("AH")) {
                        if (!empty($employeeId)) {
                            $dataIuran[$date][$employeeId] = ac_number_reverse(trim($column));
                        }
                    }
                }
            }
        }
        foreach ($dataIuran as $date => $data) {
            $startDate = $date;
            $endDate = date("Y-m-d", strtotime($date . " +6 day"));
            foreach ($data as $employeeId => $amount) {
                if (!empty($amount)) {
                    $conds = [
                        "CooperativeContribution.employee_id" => $employeeId,
                        "CooperativeContribution.start_dt" => $startDate,
                        "CooperativeContribution.amount" => $amount,
                    ];
                    if (!$this->CooperativeContribution->hasAny($conds)) {
                        $this->CooperativeContribution->create();
                        $this->CooperativeContribution->save([
                            "employee_id" => $employeeId,
                            "start_dt" => $startDate,
                            "end_dt" => $endDate,
                            "amount" => $amount,
                        ]);
                    }
                }
            }
        }
        foreach ($dataIuranSebelum2017 as $employeeId => $amount) {
            $conds = [
                "CooperativeContribution.employee_id" => $employeeId,
                "CooperativeContribution.start_dt" => "2016-12-31",
                "CooperativeContribution.amount" => $amount,
            ];
            if (!$this->CooperativeContribution->hasAny($conds)) {
                $this->CooperativeContribution->create();
                $this->CooperativeContribution->save([
                    "employee_id" => $employeeId,
                    "start_dt" => "2016-12-31",
                    "end_dt" => "2016-12-31",
                    "amount" => $amount,
                ]);
            }
        }
    }

}
