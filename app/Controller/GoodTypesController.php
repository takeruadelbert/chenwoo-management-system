<?php

App::uses('AppController', 'Controller');

class GoodTypesController extends AppController {

    var $name = "GoodTypes";
    var $disabledAction = array(
    );
    var $contain = [
        "Parent"
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_kategori_barang_koperasi");
        parent::admin_index();
    }

    function _options() {
        $parents = $this->{ Inflector::classify($this->name) }->find("list", array("fields" => array("GoodType.id", "GoodType.name", "Parent.name"), "contain" => ['Parent']));
        $parents['Kategori Utama'] = $parents[0];
        unset($parents[0]);
        $this->set(compact("parents"));
    }

    function view_goods_type($id = null) {
        if ($this->GoodType->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->GoodType->find("first", [
                    "conditions" => [
                        "GoodType.id" => $id
                    ],
                    "contain" => [
                        "Parent"
                    ]
                ]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

}
