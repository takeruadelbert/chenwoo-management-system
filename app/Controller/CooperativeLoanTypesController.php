<?php

App::uses('AppController', 'Controller');

class CooperativeLoanTypesController extends AppController {

    var $name = "CooperativeLoanTypes";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_tipe_pinjaman_koperasi");
        parent::admin_index();
    }

    function view_loan_type($id = null) {
        if ($this->CooperativeLoanType->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->CooperativeLoanType->find("first", ["conditions" => ["CooperativeLoanType.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
