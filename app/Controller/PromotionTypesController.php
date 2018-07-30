<?php

App::uses('AppController', 'Controller');

class PromotionTypesController extends AppController {

    var $name = "PromotionTypes";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_jenis_kenaikan_pangkat");
        parent::admin_index();
    }

    function view_promotion_type($id = null) {
        $this->autoRender = false;
        if ($this->PromotionType->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->PromotionType->find("first", ["conditions" => ["PromotionType.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
