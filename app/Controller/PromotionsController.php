<?php

App::uses('AppController', 'Controller');

class PromotionsController extends AppController {

    var $name = "Promotions";
    var $disabledAction = array(
    );

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_kenaikan_jabatan");
        $this->_setPeriodeLaporanDate("awal_Promotion_promotion_date", "akhir_Promotion_promotion_date");
        $this->contain = [
            "PromotionType",
            "PromotionStatus",
            "Employee" => [
                "Account" => [
                    "Biodata" => [
                        "Religion"
                    ]
                ],
                "Office",
                "Department"
            ],
            "CurrentOffice"
        ];
        parent::admin_index();
    }

    function admin_index_validate() {
        $this->_activePrint(func_get_args(), "data_kenaikan_jabatan_validasi");
        $this->_setPeriodeLaporanDate("awal_Promotion_promotion_date", "akhir_Promotion_promotion_date");
        $this->contain = [
            "PromotionType",
            "PromotionStatus",
            "Employee" => [
                "Account" => [
                    "Biodata" => [
                        "Religion"
                    ]
                ],
                "Office",
                "Department"
            ],
            "CurrentOffice"
        ];
        $this->conds = [
            "Promotion.promotion_status_id" => 1,
        ];
        parent::admin_index();
    }

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

    function admin_edit($id = null) {
        if ($this->request->is("post") || $this->request->is("put")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->validates()) {
                if (!is_null($id)) {
                    $this->{ Inflector::classify($this->name) }->id = $id;
                    $this->Promotion->data['Promotion']['id'] = $id;
                    $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                    $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 4));

                    $this->data = $rows;
                    $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                    $this->redirect(array('action' => 'admin_index'));
                } else {
                    
                }
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
            }
        } else {
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 4));
            $this->data = $rows;
        }
    }

    function admin_view($id = null) {
        if (!$this->Promotion->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        } else {
            $this->{ Inflector::classify($this->name) }->id = $id;
            $this->Promotion->data['Promotion']['id'] = $id;
            $rows = $this->{ Inflector::classify($this->name) }->find("first", array('conditions' => array(Inflector::classify($this->name) . ".id" => $id), "recursive" => 4));
            $this->data = $rows;
        }
    }

    function _options() {
        $this->set("promotionTypes", $this->Promotion->PromotionType->find("list", array("fields" => array("PromotionType.id", "PromotionType.name"), "order" => "PromotionType.name")));
        $this->set("promotionStatuses", $this->Promotion->PromotionStatus->find("list", array("fields" => array("PromotionStatus.id", "PromotionStatus.name"))));
        $this->set("departments", ClassRegistry::init("Department")->find("list", array("fields" => array("Department.id", "Department.name"), "order" => "Department.name")));
        $this->set("currentOffices", ClassRegistry::init("Office")->find("list", array("fields" => array("Office.id", "Office.name"), "order" => "Office.name")));
        $this->set("offices", ClassRegistry::init("Office")->find("list", array("fields" => array("Office.id", "Office.name"), "order" => "Office.uniq")));
        $this->set("branchOffices", $this->Promotion->Employee->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
    }

    function admin_change_status() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->Promotion->data['Promotion']['id'] = $this->request->data['id'];
            $this->Promotion->data['Promotion']['promotion_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '2') {
                $idPromotion = ClassRegistry::init("Promotion")->find("first", [
                    "conditions" => [
                        "Promotion.id" => $this->request->data['id'],
                    ]
                ]);
                $employee = $this->Promotion->Employee->find("first", [
                    "conditions" => [
                        "Employee.id" => $idPromotion['Promotion']['employee_id'],
                    ]
                ]);
                $this->Promotion->data['Employee']['id'] = $idPromotion['Promotion']['employee_id'];
                $this->Promotion->data['Employee']['office_id'] = $idPromotion['Promotion']['current_office_id'];

                $positionHistory = [];
                $positionHistory['PositionHistory']['nama_jabatan'] = $employee['Office']['name'];
                $positionHistory['PositionHistory']['instansi'] = $employee['BranchOffice']['name'];
                $positionHistory['PositionHistory']['unit_kerja'] = $employee['Department']['name'];
                $positionHistory['PositionHistory']['no_sk'] = $idPromotion["Promotion"]["no_sk_promotion"];
                $positionHistory['PositionHistory']['tanggal_sk'] = $idPromotion["Promotion"]["promotion_date"];
                $positionHistory['PositionHistory']['tmt'] = $employee["Employee"]["tmt"];
                $positionHistory['PositionHistory']['employee_id'] = $employee["Employee"]["id"];
                ClassRegistry::init("PositionHistory")->save($positionHistory);

                $this->Promotion->data['Promotion']['promotion_by_id'] = $this->_getEmployeeId();
                $this->Promotion->data['Promotion']['promotion_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '2') {
                $this->Promotion->data['Promotion']['promotion_by_id'] = $this->_getEmployeeId();
                $this->Promotion->data['Promotion']['promotion_datetime'] = date("Y-m-d H:i:s");
            } else if ($this->request->data['status'] == '1') {
                $this->Promotion->data['Promotion']['promotion_by_id'] = null;
                $this->Promotion->data['Promotion']['promotion_datetime'] = null;
            }
            $this->Promotion->saveAll();
            $data = $this->Promotion->find("first", array("conditions" => array("Promotion.id" => $this->request->data['id']), "recursive" => 3));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['PromotionStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

    function admin_list() {
        $this->autoRender = false;
        $conds = [];
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $conds[] = array(
                "or" => array(
                    "Biodata.first_name like" => "%$q%",
                    "Biodata.last_name like" => "%$q%",
            ));
        }
        $suggestions = ClassRegistry::init("Biodata")->find("all", array(
            "conditions" => $conds,
            "contain" => array(
                "Account" => array(
                    "Employee" => array(
                        "Office",
                        "Department",
                    ),
                    "User",
                )
            ),
            "limit"=>10,
        ));
        $result = [];
        foreach ($suggestions as $item) {
            if (!empty($item['Account']['Employee'])) {
                $result[] = [
                    "id" => $item['Account']['Employee']['id'],
                    "full_name" => $item['Biodata']['full_name'],
                    "nip" => @$item['Account']['Employee']['nip'],
                    "jabatan" => @$item['Account']['Employee']['Office']['name'],
                    "jabatan_id" => @$item['Account']['Employee']['Office']['id'],
                    "department" => @$item['Account']['Employee']['Department']['name'],
                    "department_uniq_name" => @$item['Account']['Employee']['Department']['uniq_name'],
                ];
            }
        }
        echo json_encode($result);
    }

}
