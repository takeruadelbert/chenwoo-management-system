<?php

App::uses('AppController', 'Controller');

class ProductCategoriesController extends AppController {

    var $name = "ProductCategories";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_kategori_material");
        parent::admin_index();
    }

    function view_data_product_category($id = null) {
        $this->autoRender = false;
        if ($this->ProductCategory->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->ProductCategory->find("first", [
                    "conditions" => [
                        "ProductCategory.id" => $id
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
