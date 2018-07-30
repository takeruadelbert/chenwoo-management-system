<?php

App::uses('AppController', 'Controller');

class MaterialCategoriesController extends AppController {

    var $name = "MaterialCategories";
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

    function view_data_material_category($id = null) {
        $this->autoRender = false;
        if ($this->MaterialCategory->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->MaterialCategory->find("first", ["conditions" => ["MaterialCategory.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
