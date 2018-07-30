<?php

App::uses('AppController', 'Controller');

class TransactionMaterialOutsController extends AppController {

    var $name = "TransactionMaterialOuts";
    var $disabledAction = array(
    );
    var $contain = [
        ""
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function view_detail_items($transaction_out_id = null) {
        $this->autoRender = false;
        if ($this->request->is("GET")) {
            $data = $this->TransactionMaterialOut->find("all", [
                "conditions" => [
                    "TransactionOut.id" => $transaction_out_id,
                ],
                "contain" => [
                    "TransactionOut",
                    "Package" => [
                        "PackageDetail" => [
                            "ProductData" => [
                                "ProductSize" => [
                                    "Product"
                                ],
                            ],
                        ]
                    ],
                ]
            ]);
            return json_encode($data);
        } else {
            return json_encode($this->_generateStatusCode(400));
        }
    }

}
