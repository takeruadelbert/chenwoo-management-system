<?php

App::uses('AppController', 'Controller');

class TransactionMaterialEntriesController extends AppController {

    var $name = "TransactionMaterialEntries";
    var $disabledAction = array(
    );
    var $contain = [
        "Material"
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function view_detail_materials($transaction_entry_id = null) {
        $this->autoRender = false;
        if ($this->request->is("GET")) {
            $data = $this->TransactionMaterialEntry->find("all", [
                "conditions" => [
                    "TransactionEntry.id" => $transaction_entry_id,
                ],
                "contain" => [
                    "TransactionEntry",
                    "MaterialDetail",
                    "MaterialSize"
                ]
            ]);
            return json_encode($data);
        } else {
            return json_encode($this->_generateStatusCode(400));
        }
    }

}
