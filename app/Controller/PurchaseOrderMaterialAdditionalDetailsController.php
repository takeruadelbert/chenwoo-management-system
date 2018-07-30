<?php

App::uses('AppController', 'Controller');

class PurchaseOrderMaterialAdditionalDetailsController extends AppController {

    var $name = "PurchaseOrderMaterialAdditionalDetails";
    var $disabledAction = array(
    );
    var $contain = [
        "MaterialAdditional"
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function view_detail_material_additional($po_id = null) {
        $this->autoRender = false;
        if ($this->request->is("GET")) {
            $data = $this->PurchaseOrderMaterialAdditionalDetail->find("all", [
                "conditions" => [
                    "PurchaseOrderMaterialAdditional.id" => $po_id,
                ],
                "contain" => [
                    "PurchaseOrderMaterialAdditional",
                    "MaterialAdditional" => [
                        "MaterialAdditionalUnit"
                    ],
                ]
            ]);
            return json_encode($data);
        } else {
            return json_encode($this->_generateStatusCode(400));
        }
    }

}
