<?php

App::uses('AppController', 'Controller');

class SaleDetailsController extends AppController {

    var $name = "SaleDetail";
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

    function view_detail_products($sale_id = null) {
        $this->autoRender = false;
        if ($this->request->is("GET")) {
            $data = $this->SaleDetail->find("all", [
                "conditions" => [
                    "Sale.id" => $sale_id,
                ],
                "contain" => [
                    "Sale" => [
                        "ShipmentPaymentType"
                    ],
                    "Product" => [
                        "Parent"
                    ],
                    "McWeight"
                ]
            ]);
            return json_encode($data);
        } else {
            return json_encode($this->_generateStatusCode(400));
        }
    }

}
