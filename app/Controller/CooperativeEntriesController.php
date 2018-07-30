<?php

App::uses('AppController', 'Controller');

class CooperativeEntriesController extends AppController {

    var $name = "CooperativeEntries";
    var $disabledAction = array(
    );
    var $contain = [
        "CooperativeTransactionMutation" => [
            "SaleProductAdditional" => [
                "CooperativeCash",
                "Employee" => [
                    "Account" => [
                        "Biodata"
                    ]
                ],
                "Purchaser" => [
                    "Account" => [
                        "Biodata"
                    ]
                ]
            ],
            "CooperativeCash",
        ],
        "CooperativeEntryType"
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function _options() {
        $this->set("cooperativeCashes", ClassRegistry::init("CooperativeCash")->find("list", ["fields" => ["CooperativeCash.id", "CooperativeCash.name"]]));
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function admin_sale_product_additional_list() {
        $this->conds = [
            "CooperativeEntry.cooperative_entry_type_id" => 3
        ];
        $this->_activePrint(func_get_args(), "data_hasil_penjualan_produk_tambahan");
        parent::admin_index();
    }

    function admin_pl() {
        $cooperativeEntryTypes = $this->CooperativeEntry->CooperativeEntryType->find("all", [
            "recursive" => -1,
        ]);
        $mapCategoryCooperativeEntryType = $this->CooperativeEntry->CooperativeEntryType->find("list", [
            "fields" => [
                "CooperativeEntryType.id",
                "CooperativeEntryType.category",
            ],
        ]);
        $mapCodeCooperativeEntryType = $this->CooperativeEntry->CooperativeEntryType->find("list", [
            "fields" => [
                "CooperativeEntryType.id",
                "CooperativeEntryType.code",
            ],
        ]);
        $mapNameCooperativeEntryType = $this->CooperativeEntry->CooperativeEntryType->find("list", [
            "fields" => [
                "CooperativeEntryType.code",
                "CooperativeEntryType.name",
            ],
        ]);
        $result = [];
        foreach ($cooperativeEntryTypes as $cooperativeEntryType) {
            $result[$cooperativeEntryType["CooperativeEntryType"]["category"]][$cooperativeEntryType["CooperativeEntryType"]["code"]] = [
                "amount" => 0,
            ];
        }
        if (isset($this->request->query['awal_CooperativeEntry_dt']) && !empty($this->request->query['awal_CooperativeEntry_dt']) && isset($this->request->query['akhir_CooperativeEntry_dt']) && !empty($this->request->query['akhir_CooperativeEntry_dt'])) {
            $start_date = $this->request->query['awal_CooperativeEntry_dt'];
            $end_date = $this->request->query['akhir_CooperativeEntry_dt'];
        } else {
            $start_date = date("Y-m-01");
            $end_date = $date = date("Y-m-t");
        }
        $cooperativeEntries = $this->CooperativeEntry->find("all", [
            "recursive" => -1,
            "conditions" => [
                "CooperativeEntry.dt >=" => $start_date,
                "CooperativeEntry.dt <=" => $end_date,
            ],
        ]);
        foreach ($cooperativeEntries as $cooperativeEntry) {
            if (isset($mapCategoryCooperativeEntryType[$cooperativeEntry["CooperativeEntry"]["cooperative_entry_type_id"]])) {
                $result[$mapCategoryCooperativeEntryType[$cooperativeEntry["CooperativeEntry"]["cooperative_entry_type_id"]]][$mapCodeCooperativeEntryType[$cooperativeEntry["CooperativeEntry"]["cooperative_entry_type_id"]]]["amount"]+=$cooperativeEntry["CooperativeEntry"]["amount"];
            }
        }
        $this->_activePrint(func_get_args(), "laporan_pl_koperasi");
        $this->set(compact("result", "cooperativeEntryTypes", "mapCategoryCooperativeEntryType", "mapCodeCooperativeEntryType", "mapNameCooperativeEntryType", "start_date", "end_date"));
    }

}
