<?php

App::uses('AppController', 'Controller');

class ProductHistoriesController extends AppController {

    var $name = "ProductHistories";
    var $disabledAction = array(
    );
    var $contain = [
        "Treatment",
        "Shipment" => [
            "Sale"
        ],
        "ProductHistoryType",
        "Product" => [
            "Parent",
            "ProductUnit"
        ]
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }
    
    function _options() {
        $this->set("products", $this->ProductHistory->Product->getList());
        $this->set("productHistoryTypes", $this->ProductHistory->ProductHistoryType->find("list", ["fields" => ["ProductHistoryType.id", "ProductHistoryType.name"]]));
    }
    
    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "product-history");
        $this->_setPeriodeLaporanDate("awal_ProductHistory_history_datetime", "akhir_ProductHistory_history_datetime");
        parent::admin_index();
    }
    
    function admin_production_report() {
        $this->_activePrint(func_get_args(), "product-history-report");
        $this->_setPeriodeLaporanDate("awal_ProductHistory_history_datetime", "akhir_ProductHistory_history_datetime");
        $conds = $this->_filter($this->request->query, $this->filterCond);
        
        if (empty($conds)) {
            $conds = $this->defaultConds;
        }
        $conds['AND'] = am($conds, array("ProductHistory.product_history_type_id"=>1), $this->conds);
        if ($this->order === false) {
            $this->order = Inflector::classify($this->name) . '.created desc';
        }
        //$this->Paginator->settings = array(
            $rows = ClassRegistry::init("ProductHistory")->find("all", array(
                'conditions' => $conds,
                //'limit' => $this->paginate['limit'],
                //'maxLimit' => $this->paginate['maxLimit'],
                'order' => $this->order,
                'recursive' => -1,
                'contain' => $this->contain,
            ));
        //);
        
        //$rows = $this->{ Inflector::classify($this->name) };
        $data = array(
            'rows' => $rows,
        );
        $this->set(compact('data'));
    }
}