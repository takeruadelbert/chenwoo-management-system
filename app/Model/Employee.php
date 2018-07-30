<?php

class Employee extends AppModel {

    public $validate = array(
        'nip' => array(
            'Harus diisi' => array("rule" => "notEmpty"),
            'Sudah terdaftar' => array("rule" => 'isUnique'),
        ),
        'department_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'office_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'employee_type_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'branch_office_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'working_hour_type_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'tmt' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
    );
    public $belongsTo = array(
        "TingkatPendidikanAwal" => [
            "foreignKey" => "tingkat_pendidikan_awal_id",
            "className" => "Education",
        ],
        "TingkatPendidikanAkhir" => [
            "foreignKey" => "tingkat_pendidikan_akhir_id",
            "className" => "Education",
        ],
        "Office",
        "Department",
        "WorkingHourType",
        "EmployeeWorkStatus",
        "EmployeeType",
        "BranchOffice"
    );
    public $hasOne = array(
        "Account" => array(
            "dependent" => true
        ),
        "EmployeeSignature" => array(
            "dependent" => true
        ),
        "Couple" => array(
            "dependent" => true
        ),
        "CooperativeItemLoan"
    );
    public $hasMany = array(
        "Training" => array(
            "dependent" => true
        ),
        "Honor" => array(
            "dependent" => true
        ),
        "EducationHistory" => array(
            "dependent" => true
        ),
        "EmployeeParent" => array(
            "dependent" => true
        ),
        "PositionHistory" => array(
            "dependent" => true
        ),
        "Family" => array(
            "dependent" => true
        ),
        "SeenNews" => array(
            "dependent" => true
        ),
        "EmployeeDataLoan" => array(
            "dependent" => true
        ),
        "EmployeeBalance" => array(
            "dependent" => true
        ),
        "AttendanceEmployeeUid" => [
            "dependent" => true,
        ],
        "EmployeeBasicSalary",
    );

    function getListWithFullname($optGroup = false) {
        $conds = [
            "NOT" => [
                "Employee.id" => $this->excludedEmployee(),
            ]
        ];
        $data = $this->find("all", [
            "contain" => [
                "Account" => [
                    "Biodata",
                    "User",
                ],
                "BranchOffice",
            ],
            "conditions" => [
                $conds,
            ]
        ]);
        $result = [];
        if ($optGroup === false) {
            foreach ($data as $tuple) {
                $result[$tuple["Employee"]['id']] = $tuple['Account']['Biodata']['full_name'];
            }
            asort($result);
        } else {
            foreach ($data as $tuple) {
                $result[$tuple["BranchOffice"]["name"]][$tuple["Employee"]['id']] = $tuple['Account']['Biodata']['full_name'];
            }
            asort($result);
        }
        return $result;
    }

    function getListInfo($conds = []) {
        $conds[] = [
            "NOT" => [
                "Employee.id" => $this->excludedEmployee(),
            ]
        ];
        $data = $this->find("all", [
            "contain" => [
                "Account" => [
                    "Biodata",
                    "User",
                ],
                "BranchOffice",
                "Office",
                "Department",
            ],
            "conditions" => [
                $conds,
            ]
        ]);
        $result = [];
        foreach ($data as $tuple) {
            $result["0" . $tuple["Employee"]['id']] = [
                "full_name" => $tuple['Account']['Biodata']['full_name'],
                "office" => e_isset(@$tuple["Office"]["name"]),
                "nip" => $tuple["Employee"]["nip"],
                "department" => e_isset(@$tuple["Department"]["name"]),
            ];
        }
        array_multisort(array_column($result, "full_name"), SORT_ASC, $result);

        function castToInt($x) {
            return (int) $x;
        }

        $employeeIds = array_map("castToInt", array_keys($result));
        $infos = array_values($result);
        $result = array_combine($employeeIds, $infos);
        return $result;
    }

    function getEmployeeIdByBranch($branchOfficeId = false) {
        if ($branchOfficeId === false) {
            $employeeId = $this->find("list", [
                "fields" => [
                    "Employee.id"
                ],
            ]);
        } else {
            $employeeId = $this->find("list", [
                "fields" => [
                    "Employee.id"
                ],
                "conditions" => [
                    "Employee.branch_office_id" => $branchOfficeId,
                ]
            ]);
        }
        return $employeeId;
    }

    function excludedEmployee() {
        $conds = [];
        if (!$this->stnAdmin->branchPrivilege()) {
            $conds = [
                "NOT" => [
                    "Employee.branch_office_id" => $this->stnAdmin->roleBranchId(),
                ],
            ];
        }
        $accountIds = ClassRegistry::init("Account")->find("list", [
            "fields" => [
                "Account.id",
            ],
            "conditions" => [
                "OR" => [
                    $conds,
                    "Employee.employee_work_status_id" => [3, 4],
                    "User.user_group_id" => ClassRegistry::init("UserGroup")->translateToId("admin"),
                ],
            ],
            "contain" => [
                "Employee",
                "User",
            ]
        ]);
        return am([1], $accountIds);
    }

    function excludedEmployeeNoBoundaries() {
        $conds = [];
        if (!$this->stnAdmin->branchPrivilege()) {
            $conds = [
                "NOT" => [
                    "Employee.branch_office_id" => $this->stnAdmin->roleBranchId(),
                ],
            ];
        }
        $accountIds = ClassRegistry::init("Account")->find("list", [
            "fields" => [
                "Account.id",
            ],
            "conditions" => [
                "OR" => [
                    $conds,
//                    "Employee.employee_work_status_id" => [3, 4],
                    "User.user_group_id" => ClassRegistry::init("UserGroup")->translateToId("admin"),
                ],
            ],
            "contain" => [
                "Employee",
                "User",
            ]
        ]);
        return am([1], $accountIds);
    }

    function changeWorkStatus($employee_id = null, $status = 1) {
        $this->saveAll(["Employee" => ["id" => $employee_id, "employee_work_status_id" => $status]]);
    }

    function getListWithFullnameExcludedEmployee($optGroup = false) {
        $conds = [
            "Employee.id" => $this->excludedEmployee(),
        ];
        $data = $this->find("all", [
            "contain" => [
                "Account" => [
                    "Biodata",
                    "User",
                ],
                "BranchOffice",
            ],
            "conditions" => [
                $conds,
            ]
        ]);
        $result = [];
        if ($optGroup === false) {
            foreach ($data as $tuple) {
                $result[$tuple["Employee"]['id']] = $tuple['Account']['Biodata']['full_name'];
            }
            asort($result);
        } else {
            foreach ($data as $tuple) {
                $result[$tuple["BranchOffice"]["name"]][$tuple["Employee"]['id']] = $tuple['Account']['Biodata']['full_name'];
            }
            asort($result);
        }
        return $result;
    }

}
