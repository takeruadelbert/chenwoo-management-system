<?php

App::uses('AppController', 'Controller');

class ArchivesController extends AppController {

    var $name = "Archives";
    var $disabledAction = array(
        "admin_edit",
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_view", "");
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function admin_index() {
        $this->contain = [
            "DocumentType",
            "ArchiveSlot",
            "AssetFile",
            "Employee" => [
                "Department",
                "Account" => [
                    "Biodata"
                ]
            ],
            "Department",
//            "ArchiveShareStatus",
//            "ArchiveShare"=>[
//                "Department",
//            ]
        ];
        if (!$this->_isAdmin() && !$this->_isKadis()) {
            $empId = $this->_getEmployeeId();
            $this->conds = [
                'Archive.department_id' => $this->_getDepartmentId(),
            ];
        }
        parent::admin_index();
    }

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                App::import("Vendor", "qqUploader");
                $allowedExt = array("doc", "docx", "xls", "xlsx", "csv", "pdf", "ppt", "pptx", "jpg", "jpeg", "png", "zip");
                $size = 10 * 1024 * 1024;
                $uploader = new qqFileUploader($allowedExt, $size, $this->data['Archive']['file'], true);
                $result = $uploader->handleUpload("arsip" . DS);
                $skip = false;
//                if (is_array($this->data["Dummy"]["department_id"])) {
//                    foreach ($this->data["Dummy"]["department_id"] as $department_id) {
//                        $this->Archive->data["ArchiveShare"][]["department_id"] = $department_id;
//                    }
//                }
                switch ($result['status']) {
                    case 206:
                        $this->Archive->data['AssetFile'] = array(
                            "folder" => $result['data']['folder'],
                            "filename" => $result['data']['fileName'],
                            "ext" => $result['data']['ext'],
                            "is_private" => true,
                        );
                        break;
                    default:
                        $this->Session->setFlash(__($result['message']), 'default', array(), 'danger');
                        $skip = true;
                }
                if (!$skip) {
                    unset($this->Archive->data['Archive']['file']);
                    $this->Archive->data['Archive']['employee_id'] = $this->_getEmployeeId();
                    $this->Archive->data['Archive']['department_id'] = $this->_getDepartmentId();
                    $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                    $this->_generateIdDokumen($this->Archive->getLastInsertID());
                    $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                    $this->redirect(array('action' => 'admin_index'));
                }
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function _options() {
        $this->set("documentTypes", ClassRegistry::init("DocumentType")->find("list", array("fields" => array("DocumentType.id", "DocumentType.name"))));
        $this->set("archiveSlots", ClassRegistry::init("ArchiveSlot")->find("list", array("fields" => array("ArchiveSlot.id", "ArchiveSlot.name"))));
        $this->set("departments", ClassRegistry::init("Department")->find("list", array("fields" => array("Department.id", "Department.name"))));
        $this->set("branchOffices", $this->Archive->Employee->BranchOffice->find("list", array("fields" => array("BranchOffice.id", "BranchOffice.name"))));
//        $this->set("archiveShareStatuses", ClassRegistry::init("ArchiveShareStatus")->find("list", array("fields" => array("ArchiveShareStatus.id", "ArchiveShareStatus.name"))));
    }

    function _generateIdDokumen($id = null) {
        $inc_id = 1;
        $Y = date('Y');
        $data = $this->Archive->find('first', array('conditions' => array('Archive.id' => $id), 'recursive' => 2));
        $nama_departemen = $data['Department']['uniq_name'];
        $idEmp = $data['Archive']['employee_id'];
        $testCode = "[0-9]{4}/DOK/$nama_departemen/$Y";
        $lastRecord = $this->Archive->find('first', array('conditions' => array('not' => array('Archive.id' => $id), 'and' => array("Archive.nomor_dokumen regexp" => $testCode)), 'order' => array('Archive.nomor_dokumen' => 'DESC')));

        if (!empty($lastRecord)) {
            $codeList = explode('/', $lastRecord['Archive']['nomor_dokumen']);
            if ($nama_departemen == $codeList[2] && $Y == $codeList[3]) {
                $first = intval($codeList[0]);
                $inc_id+=$first;
            }
        }

        $inc_id = sprintf("%04d", $inc_id);
        $kode = strtoupper("$inc_id/DOK/$nama_departemen/$Y");
        $this->Archive->id = $id;
        $this->Archive->save(array("nomor_dokumen" => $kode));
        return $kode;
    }

    function admin_change_status() {
        $this->autoRender = false;
        if ($this->request->is("PUT")) {
            $this->Archive->id = $this->request->data['id'];
            $this->Archive->save(array("Archive" => array("archive_share_status_id" => $this->request->data['status'])));
            $data = $this->Archive->find("first", array("conditions" => array("Archive.id" => $this->request->data['id']), "recursive" => 1));
            echo json_encode($this->_generateStatusCode(207, null, array("status_label" => $data['ArchiveShareStatus']['name'])));
        } else {
            echo json_encode($this->_generateStatusCode(400));
        }
    }
}
