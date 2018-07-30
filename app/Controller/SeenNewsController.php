<?php

App::uses('AppController', 'Controller');

class SeenNewsController extends AppController {

    var $name = "SeenNews";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }
    
    function check_is_seen($news_id, $employee_id) {
        $this->autoRender = false;
        $data = $this->SeenNews->find("first",[
            "conditions" => [
                "SeenNews.internal_news_id" => $news_id,
                "SeenNews.employee_id" => $employee_id
            ]
        ]);
        if(!empty($data)) {
            return json_encode($this->_generateStatusCode(503));
        } else {
            if($this->request->is("POST")) {
                $temp = [];
                $temp['SeenNews']['internal_news_id'] = $news_id;
                $temp['SeenNews']['employee_id'] = $employee_id;
                $this->SeenNews->save($temp);
                return json_encode($this->_generateStatusCode(200));
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        }
    }
    
    function admin_get_status_news($news_id, $employee_id) {
        $this->autoRender = false;
        $data = $this->SeenNews->find("first",[
            "conditions" => [
                "SeenNews.internal_news_id" => $news_id,
                "SeenNews.employee_id" => $employee_id
            ]
        ]);
        if(!empty($data)) {
            if($this->request->is("GET")) {  
                return json_encode(true);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            return json_encode(false);
        }
    }
}