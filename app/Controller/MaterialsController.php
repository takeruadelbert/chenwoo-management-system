<?php

App::uses('AppController', 'Controller');

class MaterialsController extends AppController {

    var $name = "Materials";
    var $disabledAction = array(
    );
    var $contain = [
        "MaterialCategory",
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "data_material");
        $conds = $this->_filter($_GET, $this->filterCond);
        if (empty($conds)) {
            $conds = $this->defaultConds;
        }
        $conds['AND'] = am($conds, array(
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
                'contain' => [
                    "MaterialCategory",
                    "MaterialDetail" => [
                        "Unit"
                    ]
                ]
            )
        );
        $rows = $this->Paginator->paginate($this->{ Inflector::classify($this->name) });
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

    function admin_add() {
        if ($this->request->is("post")) {
            $this->{ Inflector::classify($this->name) }->set($this->data);
            $this->{ Inflector::classify($this->name) }->data['stok'] = 0;
            if ($this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('validate' => 'only', "deep" => true))) {
                $this->{ Inflector::classify($this->name) }->saveAll($this->{ Inflector::classify($this->name) }->data, array('deep' => true));
                $this->Session->setFlash(__("Data berhasil disimpan"), 'default', array(), 'success');
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->validationErrors = $this->{ Inflector::classify($this->name) }->validationErrors;
                $this->Session->setFlash(__("Harap mengecek kembali kesalahan dibawah."), 'default', array(), 'danger');
            }
        }
    }

    function admin_multiple_delete() {
        $this->{ Inflector::classify($this->name) }->MaterialDetail->set($this->data);
        if (empty($this->data)) {
            $code = 203;
        } else {
            $allData = $this->data[Inflector::classify($this->name)]['checkbox'];
            foreach ($allData as $data) {
                if ($data != '' || $data != 0) {
                    $this->{ Inflector::classify($this->name) }->MaterialDetail->delete($data, true);
                }
            }
            $code = 204;
        }
        echo json_encode($this->_generateStatusCode($code));
        die();
    }

    function admin_print_daftar_material($id = null) {
        $rows = $this->{ Inflector::classify($this->name) }->find('all', array(
            'conditions' => array(
            //Inflector::classify($this->name) . '.id' => $id,
            ),
            'contain' => [
                "MaterialDetail" => [
                    "Unit" => [
                    ]
                ],
                "MaterialCategory",
            ],
        ));

        $this->data = $rows;
        $data = array(
            'title' => 'Daftar Material',
            'rows' => $rows,
        );
        debug($data);
        die;
        $this->set(compact('data'));
        $this->_activePrint(["print"], "print_daftar_material", "report_material");
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function _options() {
        $this->set("units", ClassRegistry::init("Unit")->find("list", array("fields" => array("Unit.id", "Unit.name"))));
        $this->set("materialCategories", ClassRegistry::init("MaterialCategory")->find("list", array("fields" => array("MaterialCategory.id", "MaterialCategory.name"))));
        $this->set("suppliers", ClassRegistry::init("Supplier")->find("list", array("fields" => array("Supplier.id", "Supplier.name"))));
    }

    function admin_get_material() {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->find('all', array("fields" => array("Material.id", "Material.name")), array("contain" => array()));
        echo json_encode($data);
    }

    function admin_get_material_by_id($id = null) {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->find('all', array("fields" => array("Material.id", "Material.name", "Unit.name"), "conditions" => array("Material.id" => $id), "contain" => array("Unit")));
        echo json_encode($data);
    }

    function admin_get_material_detail_by_id($id = null) {
        $this->autoRender = false;
        $data = $this->{ Inflector::classify($this->name) }->MaterialDetail->find('all', array("fields" => array("MaterialDetail.id", "MaterialDetail.name", "Unit.name"), "conditions" => array("MaterialDetail.id" => $id), "contain" => array("Unit")));
        echo json_encode($data);
    }

    function admin_view_data_material($id = null) {
        $this->autoRender = false;
        if ($this->Material->exists($id)) {
            if ($this->request->is("GET")) {
                $data = $this->Material->find("first", ["conditions" => ["Material.id" => $id]]);
                return json_encode($data);
            } else {
                return json_encode($this->_generateStatusCode(400));
            }
        } else {
            throw new NotFoundException(__("Data Not Found"));
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
                        $this->Material->_deleteableHasmany();
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

}
