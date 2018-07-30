<?php

App::uses('AppController', 'Controller');

class CooperativeRemainingOperationsController extends AppController {

    var $name = "CooperativeRemainingOperations";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "sisa_hasil_usaha");
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $cooperativeEntries = ClassRegistry::init("CooperativeEntry")->find("all", [
                    "conditions" => [
                        "YEAR(CooperativeEntry.dt)" => $this->data['CooperativeRemainingOperation']['year'],
                    ],
                    "contain" => [
                        "CooperativeEntryType"
                    ]
                ]);
                $income = 0;
                $outcome = 0;
                $laba = 0;
                foreach ($cooperativeEntries as $entry) {
                    if (strtolower($entry['CooperativeEntryType']['category']) == "income") {
                        $income += $entry['CooperativeEntry']['amount'];
                    } else if (strtolower($entry['CooperativeEntryType']['category']) == "outcome") {
                        $outcome += $entry['CooperativeEntry']['amount'];
                    }
                }
                $laba = $income - $outcome;
                $this->{ Inflector::classify($this->name) }->data['CooperativeRemainingOperation']['profit'] = $laba;
                $this->loadModel("CooperativeContribution");
                $this->CooperativeContribution->virtualFields = [
                    "total_month" => "count(CooperativeContribution.id)",
                    "ym" => "DATE_FORMAT(CooperativeContribution.start_dt,'%Y-%m')",
                    "m" => "Month(CooperativeContribution.start_dt)",
                    "emp_id" => "CooperativeContribution.employee_id"
                ];
                $cooperativeContributions = ClassRegistry::init("CooperativeContribution")->find("all", [
                    "conditions" => [
                        "YEAR(CooperativeContribution.start_dt)" => $this->data['CooperativeRemainingOperation']['year'],
                        "CooperativeContribution.amount > 0",
                    ],
                    "contain" => [
                        "Employee"
                    ],
                    "group" => [
                        "Year(CooperativeContribution.start_dt)",
                        "Month(CooperativeContribution.start_dt)",
                        "CooperativeContribution.employee_id",
                    ]
                ]);
                $result = [];
                foreach ($cooperativeContributions as $cooperativeContribution) {
                    $employeeId = $cooperativeContribution["CooperativeContribution"]["employee_id"];
                    if (!isset($result[$employeeId])) {
                        $result[$employeeId] = [
                            "total_month" => 0,
                            "detail_month" => [],
                            "emp_id" => $employeeId,
                        ];
                    }
                    $result[$employeeId]["total_month"] ++;
                    $result[$employeeId]["detail_month"][] = $cooperativeContribution["CooperativeContribution"]["m"];
                }
//                debug($result);
                $totalEmp = array_sum(array_count_values(array_column($result, "emp_id")));
                $this->{ Inflector::classify($this->name) }->data['CooperativeRemainingOperation']['total_employee'] = $totalEmp;
                $totalEmpMonth = array_sum(array_column($result, "total_month"));
                $k = 0;
                foreach ($result as $results) {
                    $this->{ Inflector::classify($this->name) }->data['CooperativeRemainingOperationDetail'][$k]['employee_id'] = $results['emp_id'];
                    $this->{ Inflector::classify($this->name) }->data['CooperativeRemainingOperationDetail'][$k]['duration'] = $results['total_month'];
                    $this->{ Inflector::classify($this->name) }->data['CooperativeRemainingOperationDetail'][$k]['amount'] = ($laba / $totalEmpMonth) * $results['total_month'];
                    $this->{ Inflector::classify($this->name) }->data['CooperativeRemainingOperationDetail'][$k]['abs_amount'] = floor((($laba / $totalEmpMonth) * $results['total_month']) / 1000) * 1000;
                    $k++;
                }
//                debug($this->{ Inflector::classify($this->name) }->data);
//                die;
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

}
