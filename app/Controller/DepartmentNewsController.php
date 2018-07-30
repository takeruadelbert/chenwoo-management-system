<?php

App::uses('AppController', 'Controller');

class DepartmentNewsController extends AppController {

    var $name = "DepartmentNews";
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
        $this->_activePrint(func_get_args(), "department-news");
        $this->contain = [
            "Employee" => [
                "Department", 
                "Account" => [
                    "Biodata"
                ]
            ],
            "Department"
        ];
        parent::admin_index();
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("branchOffices", $this->DepartmentNews->Employee->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
        $this->set("departments", $this->DepartmentNews->Department->find("list", ["fields" => ["Department.id", "Department.name"]]));
    }
    
    function admin_view_news($id = null) {
        if ($this->DepartmentNews->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("GET")) {
                $data = $this->DepartmentNews->find("first", ["conditions" => ["DepartmentNews.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
        }
    }

    function update_status_news($id = null) {
        if ($this->DepartmentNews->exists($id)) {
            $this->autoRender = false;
            if ($this->request->is("PUT")) {
                $data = [];
                $data['DepartmentNews']['id'] = $id;
                $data['DepartmentNews']['is_seen'] = 1;
                $this->DepartmentNews->save($data);
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
            $order = "DepartmentNews.created desc";
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
                ],
                "Department"
            ],
        ];
        $news = ClassRegistry::init("DepartmentNews")->find("all", $filter);
        $count = ClassRegistry::init("DepartmentNews")->find("count", ["conditions" => $conds]);
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
