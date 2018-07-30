<?php

class Notification extends AppModel {

    var $name = 'Notification';
    var $belongsTo = array(
        "Employee",
        "Permit",
        "MissAttendance",
        "EmployeeSalary",
        "EmployeeDataLoan",
        "Sale",
        "RequestOrderMaterialAdditional",
        "PurchaseOrderMaterialAdditional",
        "DebitInvoiceSale",
        "PaymentPurchase",
        "PaymentPurchaseMaterialAdditional",
        "DebitInvoicePurchaser",
        "DebitInvoicePurchaserMaterialAdditional",
        "MaterialAdditionalPerContainer",
        "Conversion",
        "Freeze",
        "Treatment",
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

    //old
    function addNotification($permit_id = null, $miss_attendance_id = null, $employee_salary_id = null, $employee_id = null, $message = "", $target = "#") {
        $this->saveAll([
            "permit_id" => $permit_id,
            "miss_attendance_id" => $miss_attendance_id,
            "employee_salary_id" => $employee_salary_id,
            "employee_id" => $employee_id,
            "message" => $message,
            "target" => $target,
        ]);
    }

    //new
    function addNotifications($fieldName = "", $relationId = null, $employeeIds = [], $message = "", $target = "#") {
        foreach ($employeeIds as $employeeId) {
            $check = [
                $fieldName => $relationId,
                "employee_id" => $employeeId,
            ];
            if ($this->hasAny($check)) {
                continue;
            }
            $this->create();
            $this->save([
                $fieldName => $relationId,
                "employee_id" => $employeeId,
                "message" => $message,
                "target" => $target,
            ]);
        }
    }

}

?>
