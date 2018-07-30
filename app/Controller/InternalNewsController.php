<?php

App::uses('AppController', 'Controller');

class InternalNewsController extends AppController {

    var $name = "InternalNews";
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
        $this->_activePrint(func_get_args(), "berita_internal");
        $this->contain = [
            "Employee" => [
                "Department", "Account" => [
                    "Biodata"
                ]
            ]
        ];
        parent::admin_index();
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("branchOffices", $this->InternalNews->Employee->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->InternalNews->data['InternalNews']['employee_id'] = $this->_getEmployeeId();
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
        if ($this->request->is("post") || $this->request->is("put")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                if (!is_null($id)) {
                    $this->{ Inflector::classify($this->name) }->data[Inflector::classify($this->name)]['id'] = $id;
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

    function view_news($id = null) {
        if ($this->InternalNews->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->InternalNews->find("first", ["conditions" => ["InternalNews.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function update_status_news($id = null) {
        if ($this->InternalNews->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("PUT")) {
                $data = [];
                $data['InternalNews']['id'] = $id;
                $data['InternalNews']['is_seen'] = 1;
                $this->InternalNews->save($data);
                return json_encode($this->_generateStatusCode(200));
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function ajax_news() {
        $this->autoRender = false;
        $this->response->type("json");
        if (isset($this->request->query["limit"]) && !empty($this->request->query["limit"])) {
            $limit = $this->request->query["limit"];
        } else {
            $limit = 3;
        }
        if (isset($this->request->query["order"]) && !empty($this->request->query["order"])) {
            $order = $this->request->query["order"];
        } else {
            $order = "InternalNews.created desc";
        }
        if (isset($this->request->query["page"]) && !empty($this->request->query["page"])) {
            $page = $this->request->query["page"];
        } else {
            $page = 1;
        }
        $conds = [];
        $filter = [
            "page" => $page,
            "order" => $order,
            "limit" => $limit,
            "conditions" => [
                $conds,
                "Employee.branch_office_id" => $this->Session->read("credential.admin.Employee.branch_office_id"),
            ],
            "contain" => [
                "Employee" => [
                    "Account" => [
                        "Biodata",
                        "User" => [
                            "UserGroup"
                        ]
                    ]
                ]
            ],
        ];
        $news = ClassRegistry::init("InternalNews")->find("all", $filter);
        $count = ClassRegistry::init("InternalNews")->find("count", ["conditions" => $conds]);
        $info = [];
        $info['totalItem'] = $count;
        $info['totalPage'] = ceil($count / $limit);
        $info['currentPage'] = $page;
        $info['limit'] = $limit;
        $info['startItem'] = ($page - 1) * $limit + 1;
        $info['endItem'] = $info['startItem'] + $limit - 1;
        if ($info['endItem'] > $info['totalItem']) {
            $info['endItem'] = $info['totalItem'];
        } 
        if ($info['totalItem'] == 0 && $info['endItem'] == 0) {
            $info['totalPage'] = 1;
        }
        echo json_encode($this->_generateStatusCode(206, null, ["items" => $news, "pagination_info" => $info, "filter" => $filter]));
    }

}
