<?php

class Permit extends AppModel {

    var $name = 'Permit';
    var $belongsTo = array(
        "PermitType",
        "Employee",
        "PermitStatus",
        'Supervisor' => array(
            'className' => 'Employee',
            'foreignKey' => 'supervisor_id',
        ),
    );
    var $hasOne = array(
        "Notification" => array(
            "dependent" => true
        )
    );
    var $hasMany = array(
    );
    var $validate = array(
        'permit_type_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Hasur dipilih'
        ),
        'start_date' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'end_date' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
    );
    var $virtualFields = array(
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

    function countCutiTahunan($employeeId, $year) {
        $permits = $this->find("all", [
            "conditions" => [
                "Permit.employee_id" => $employeeId,
                "YEAR(Permit.start_date)" => $year,
                "Permit.permit_status_id" => 2,
                "PermitType.uniq_name" => "CT",
            ],
            "contain" => [
                "PermitType",
            ]
        ]);
        $permitDate = [];
        foreach ($permits as $permit) {
            $permitDate = am($permitDate, createDateRangeArray($permit['Permit']['start_date'], $permit['Permit']['end_date']));
        }
        $permitDate = array_unique($permitDate);
        return count($permitDate);
    }

}

?>
