<?php

App::uses('AppController', 'Controller');

class CooperativeRemainingOperationDetailsController extends AppController {

    var $name = "CooperativeRemainingOperationDetails";
    var $disabledAction = array(
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
        $this->_setPageInfo("admin_view", "");
    }

    function admin_view_detail_SHU($id = null) {
        $this->_activePrint(func_get_args(), "detail_sisa_hasil_usaha");
        $id = $this->request->query['cooperative_remaining_operation_id'];
//        $this->Paginator->settings = array(
//            Inflector::classify($this->name) => array(
//                'conditions' => [
//                    "CooperativeRemainingOperationDetail.cooperative_remaining_operation_id" => $id,
//                ],
//                'limit' => $this->paginate['limit'],
//                'maxLimit' => $this->paginate['maxLimit'],
//                'order' => $this->order,
//                'recursive' => -1,
//                'contain' => [
//                    'Employee' => [
//                        "Account" => [
//                            "Biodata"
//                        ]
//                    ],
//                    "VerifyStatus",
//                ],
//            )
//        );
        $cooperativeRemainingOperation = $this->CooperativeRemainingOperationDetail->CooperativeRemainingOperation->find("first", [
            "conditions" => [
                "CooperativeRemainingOperation.id" => $id,
            ],
            "contain" => [
                "CooperativeRemainingOperationDetail",
            ]
        ]);
//        $rows = $this->Paginator->paginate($this->{ Inflector::classify($this->name) });
        $rows = $this->CooperativeRemainingOperationDetail->find("all", [
            "conditions" => [
                "CooperativeRemainingOperationDetail.cooperative_remaining_operation_id" => $id,
            ],
            "contain" => [
                'Employee' => [
                    "Account" => [
                        "Biodata"
                    ]
                ],
                "VerifyStatus",
            ]
        ]);
        $data = array(
            'rows' => $rows,
        );
        $this->set(compact('data', 'cooperativeRemainingOperation'));
    }

    function admin_change_status_verify() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->CooperativeRemainingOperationDetail->data['CooperativeRemainingOperationDetail']['id'] = $this->request->data['id'];
            $this->CooperativeRemainingOperationDetail->data['CooperativeRemainingOperationDetail']['verify_status_id'] = $this->request->data['status'];
            if ($this->request->data['status'] == '3') {
                $this->CooperativeRemainingOperationDetail->data['CooperativeRemainingOperationDetail']['verified_by_id'] = $this->_getEmployeeId();
                $this->CooperativeRemainingOperationDetail->data['CooperativeRemainingOperationDetail']['verified_datetime'] = date("Y-m-d H:i:s");
                $this->CooperativeRemainingOperationDetail->data['CooperativeRemainingOperationDetail']['payment_date'] = date("Y-m-d H:i:s");
                $this->CooperativeRemainingOperationDetail->data['CooperativeRemainingOperationDetail']['is_already_taken'] = 1;
            } else if ($this->request->data['status'] == '2') {
                $this->CooperativeRemainingOperationDetail->data['CooperativeRemainingOperationDetail']['verified_by_id'] = $this->_getEmployeeId();
                $this->CooperativeRemainingOperationDetail->data['CooperativeRemainingOperationDetail']['verified_datetime'] = date("Y-m-d H:i:s");
            } else {
                $this->CooperativeRemainingOperationDetail->data['CooperativeRemainingOperationDetail']['verified_by_id'] = null;
                $this->CooperativeRemainingOperationDetail->data['CooperativeRemainingOperationDetail']['verified_datetime'] = null;
            }
            $this->CooperativeRemainingOperationDetail->saveAll();
            $data = $this->CooperativeRemainingOperationDetail->find("first", array("conditions" => array("CooperativeRemainingOperationDetail.id" => $this->request->data['id']), "recursive" => 1));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['VerifyStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }

}
