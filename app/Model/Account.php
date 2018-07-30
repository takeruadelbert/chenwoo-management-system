<?php

class Account extends AppModel {

    public $validate = array(
    );
    public $belongsTo = array(
        'AccountStatus',
        'Employee',
        "PasswordReset",
    );
    public $hasOne = array(
        "User" => array(
            "dependent" => true
        ),
        "Biodata" => array(
            "dependent" => true
        ),
    );

    function isValidApiToken($token = false) {
        $account = $this->find("first", [
            "conditions" => [
                "User.api_token" => $token,
            ],
            "contain" => [
                "User",
                "Employee",
            ]
        ]);
        if (!empty($account)) {
            return $account;
        } else {
            return false;
        }
    }

}
