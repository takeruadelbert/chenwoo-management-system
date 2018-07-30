<?php

App::uses('AppController', 'Controller');

class RetainedEarningsController extends AppController {

    var $name = "RetainedEarnings";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }

    function view_retained_earning($id = null) {
        if ($this->RetainedEarning->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->RetainedEarning->find("first", ["conditions" => ["RetainedEarning.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->RetainedEarning->_numberSeperatorRemover();
                
                /* updating the nominal in ProfitAndLoss Table */
                $dataProfitAndLoss = ClassRegistry::init("ProfitAndLoss")->find("first",[
                    "conditions" => [
                        "ProfitAndLoss.id" => $this->data['RetainedEarning']['profit_and_loss_id']
                    ]
                ]);
                $updated = [];
                $updated['ProfitAndLoss']['id'] = $dataProfitAndLoss['ProfitAndLoss']['id'];
                $updated['ProfitAndLoss']['nominal'] = $dataProfitAndLoss['ProfitAndLoss']['nominal'] - $this->RetainedEarning->data['RetainedEarning']['nominal'];
                ClassRegistry::init("ProfitAndLoss")->save($updated);

                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_edit($id = null) {
        if (!$this->{ Inflector::classify($this->name) }->exists($id)) {
            throw new NotFoundException(__('Data tidak ditemukan'));
        } else {
            if ($this->request->is("post") || $this->request->is("put")) {
                $this->{ Inflector::classify($this->name) }->set($this->data);
                $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
                if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                    if (!is_null($id)) {
                        $this->RetainedEarning->_numberSeperatorRemover();
                        $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                        $this->Session->setFlash(__("Data berhasil diubah"), 'default', array(), 'success');
                        $this->redirect(array('action' => 'admin_index'));
                    } else {
                        
                    }
                } else {
                    $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                }
            } else {
                $rows = $this->{ Inflector::classify($this->name) }->find("first", array(
                    'conditions' => array(
                        Inflector::classify($this->name) . ".id" => $id
                    ),
                    'recursive' => 2
                ));
                $this->data = $rows;
            }
        }
    }

    function get_data_profit_and_loss($month, $year) {
        $this->autoRender = false;
        if (!empty($month) && !empty($year)) {
            if ($this->request->is("GET")) {
                $data = ClassRegistry::init("ProfitAndLoss")->find("first", [
                    "conditions" => [
                        "MONTH(ProfitAndLoss.print_date)" => $month,
                        "YEAR(ProfitAndLoss.print_date)" => $year
                    ]
                ]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            return json_encode("Invalid Request");
        }
    }
    
    function admin_index() {
        $conds = [];
        if(!empty($this->request->query['start_date'])) {
            $startDate = $this->request->query['start_date'];
            $conds[] = [
                "DATE_FORMAT(RetainedEarning.datetime, '%Y-%m-%d') >=" => $startDate
            ];
            unset($_GET['start_date']);
        }
        if(!empty($this->request->query['end_date'])) {
            $endDate = $this->request->query['end_date'];
            $conds[] = [
                "DATE_FORMAT(RetainedEarning.datetime, '%Y-%m-%d') <=" => $endDate
            ];
            unset($_GET['end_date']);
        }
        $this->conds = [
            $conds
        ];
        parent::admin_index();
    }
}