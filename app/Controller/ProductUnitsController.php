<?php

App::uses('AppController', 'Controller');

class ProductUnitsController extends AppController {

    var $name = "ProductUnits";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_get_unit() {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->find('all', array("fields" => array("ProductUnit.id", "ProductUnit.name")), array("contain" => array()));
        echo json_encode($data);
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_satuan_produk");
        parent::admin_index();
    }

    function view_data_product_unit($id = null) {
        $this->autoRender = false;
        if ($this->ProductUnit->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->ProductUnit->find("first", [
                    "conditions" => [
                        "ProductUnit.id" => $id
                    ]
                ]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateProductSizeCode(400));
            }
        } else {
            throw new NotFoundException(__("404 Data Not Found"));
        }
    }

}
