<?php

class CooperativeContribution extends AppModel {

    var $name = 'CooperativeContribution';
    var $belongsTo = array(
        "Employee",
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
    );
    var $virtualFields = array(
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

    function addByEmployeeSalaryPeriod($employeeSalaryPeriodId) {
        $employeeSalaryPeriod = ClassRegistry::init("EmployeeSalaryPeriod")->find("first", [
            "conditions" => [
                "EmployeeSalaryPeriod.id" => $employeeSalaryPeriodId,
            ],
            "contain" => [
                "EmployeeSalary" => [
                    "ParameterEmployeeSalary" => [
                        "conditions" => [
                            "ParameterEmployeeSalary.parameter_salary_id" => ClassRegistry::init("ParameterSalary")->translteCodeToId("IWP"),
                        ]
                    ],
                ],
            ],
        ]);
        if (!empty($employeeSalaryPeriod)) {
            foreach ($employeeSalaryPeriod["EmployeeSalary"]["ParameterEmployeeSalary"] as $parameterEmployeeSalary) {
                debug($parameterEmployeeSalary);
            }
        }
    }

    function addByEmployeeSalary($employeeSalaryId) {
        $employeeSalary = ClassRegistry::init("EmployeeSalary")->find("first", [
            "conditions" => [
                "EmployeeSalary.id" => $employeeSalaryId
            ],
            "contain" => [
                "ParameterEmployeeSalary" => [
                    "conditions" => [
                        "ParameterEmployeeSalary.parameter_salary_id" => ClassRegistry::init("ParameterSalary")->translateCodetoId("IWP"),
                    ]
                ],
            ]
        ]);
        if (!empty($employeeSalary["ParameterEmployeeSalary"])){
            $pop=array_pop($employeeSalary["ParameterEmployeeSalary"]);
            $amount=abs($pop["nominal"]);
        }else{
            $amount=0;
        }
        $this->save([
            "employee_id" => $employeeSalary["EmployeeSalary"]["employee_id"],
            "start_dt" => $employeeSalary["EmployeeSalary"]["start_date_period"],
            "end_dt" => $employeeSalary["EmployeeSalary"]["end_date_period"],
            "amount" => $amount,
        ]);
    }

}

?>
