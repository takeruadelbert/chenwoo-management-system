<?php

class CooperativeItemLoanPaymentDetail extends AppModel {

    var $name = 'CooperativeItemLoanPaymentDetail';
    var $belongsTo = array(
        "CooperativeItemLoanPayment",
        "CooperativeItemLoan",
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

    function updatePayment($cooperativeItemLoanPaymentDetailId, $amount) {
        $cooperativeItemLoanPayment = $this->find("first", [
            "conditions" => [
                "CooperativeItemLoanPaymentDetail.id" => $cooperativeItemLoanPaymentDetailId,
            ],
            "contain" => [
                "CooperativeItemLoan",
            ]
        ]);
        if (!empty($cooperativeItemLoanPayment)) {
            $this->CooperativeItemLoan->save([
                "id" => $cooperativeItemLoanPayment["CooperativeItemLoan"]["id"],
                "remaining" => $cooperativeItemLoanPayment["CooperativeItemLoan"]["remaining"] - $amount,
                "paid" => $cooperativeItemLoanPayment["CooperativeItemLoan"]["paid"] + $amount,
            ]);
        }
    }

}

?>
