<?php

App::uses('AppController', 'Controller');

class TransferEmployeeTypesController extends AppController {

    var $name = "TransferEmployeeTypes";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function view_data_transfer_employee_types($id = null) {
        $this->autoRender = false;
        if ($this->TransferEmployeeType->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->TransferEmployeeType->find("first", ["conditions" => ["TransferEmployeeType.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
