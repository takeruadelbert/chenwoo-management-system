<?php

App::uses('AppController', 'Controller');

class McWeightsController extends AppController {

    var $name = "McWeights";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_mc_weight");
        parent::admin_index();
    }

    function admin_get_mc_weight() {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->find('all', array("fields" => array("McWeight.id", "McWeight.lbs", "McWeight.kg")), array("contain" => array()));
        echo json_encode($data);
    }

}
