<?php

App::uses('AppController', 'Controller');

class ProductDatasController extends AppController {

    var $name = "ProductDatas";
    var $disabledAction = array(
    );
    var $contain = [
        "ProductSize" => [
            "Product",
            "ProductUnit"
        ],
        "ProductStatus"
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("productStatuses", $this->ProductData->ProductStatus->find("list", array("fields" => array("ProductStatus.id", "ProductStatus.name"))));
    }

    function admin_ready() {
        $conds = $this->_filter($_GET, $this->filterCond);
        if (empty($conds)) {
            $conds = $this->defaultConds;
        }
        $conds['AND'] = am($conds, array(
            "ProductData.product_status_id" => 2
                ), $this->conds);
        if ($this->order === false) {
            $this->order = Inflector::classify($this->name) . '.created desc';
        }
        $this->Paginator->settings = array(
            Inflector::classify($this->name) => array(
                'conditions' => $conds,
                'limit' => $this->paginate['limit'],
                'maxLimit' => $this->paginate['maxLimit'],
                'order' => $this->order,
                'recursive' => -1,
                'contain' => $this->contain,
            )
        );
        $rows = $this->Paginator->paginate($this->{ Inflector::classify($this->name)});
        $data = array(
            'rows' => $rows,
//            'rows' => [],
        );
        $this->set(compact('data'));
//        if ($this->args === false) {
//            $args = func_get_args();
//        } else {
//            $args = $this->args;
//        }
//        if (isset($args[0])) {
//            $jenis = $args[0];
//            $this->cetak = $jenis;
//                $this->render($this->cetak_template);
//        }
    }

    function admin_print_qr_code($id) {
        $this->_activePrint(["print"], "print_barcode", "print_barcode");
        $data = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id)));
        $this->set(compact('data'));
    }

    function admin_get_all_product_data() {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->find('all', array(
            "fields" => array(
                "ProductData.id", 
                "ProductData.serial_number",
                "ProductSize.name",
                //"Product[0].name"
                ),
            "conditions"=>array(
                "ProductData.product_status_id"=>1),
            "contain" => array(
                "ProductSize"=>[
                    "ProductUnit",
                    "Product"
                    ]
                )
            ));
//        debug($data);
//        die;
        $data = $this->{ Inflector::classify($this->name) }->find('all', array("fields" => array("ProductData.id", "ProductData.serial_number"), "conditions" => array("ProductData.product_status_id" => 1)), array("contain" => array()));
        echo json_encode($data);
    }

    function admin_get_price($id = null) {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->find('all', array("fields" => array("ProductData.id", "ProductData.product_size_id", "ProductSize.price"), "conditions" => array("ProductData.id" => $id), "contain" => array("ProductSize")));
        echo json_encode($data);
    }

}
