<?php

App::uses('AppController', 'Controller');

class ProductMaterialAdditionalsController extends AppController {

    var $name = "ProductMaterialAdditionals";
    var $disabledAction = array(
    );
    var $contain = [
        "MaterialAdditionalCategory",
        "Product" => [
            "Parent",
        ],
        "MaterialAdditional" => [
            "MaterialAdditionalUnit",
        ],
    ];

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function _options() {
        $this->set("products", $this->ProductMaterialAdditional->Product->getList());
        $this->set("mcWeights", $this->ProductMaterialAdditional->McWeight->find("list", ["fields" => ["McWeight.id", "McWeight.label_lbs"]]));
        $this->set("plastikMaterialAdditionals", $this->ProductMaterialAdditional->MaterialAdditional->find("list", ["fields" => ["MaterialAdditional.id", "MaterialAdditional.name"], "conditions" => ["MaterialAdditional.material_additional_category_id" => 2]]));
        $this->set("mcMaterialAdditionals", $this->ProductMaterialAdditional->MaterialAdditional->find("list", ["fields" => ["MaterialAdditional.id", "MaterialAdditional.name"], "conditions" => ["MaterialAdditional.material_additional_category_id" => 1]]));
        $this->set("materialAdditionals", $this->ProductMaterialAdditional->MaterialAdditional->find("list", ["fields" => ["MaterialAdditional.id", "MaterialAdditional.name"]]));
        $this->set("materialAdditionalCategories", $this->ProductMaterialAdditional->MaterialAdditionalCategory->find("list", ["fields" => ["MaterialAdditionalCategory.id", "MaterialAdditionalCategory.name"]]));
    }

    function beforeRender() {
        $this->_options();
        parent::beforeRender();
    }

    function admin_add_mc() {
        parent::admin_add();
    }

    function admin_index() {
        $this->_activePrint(func_get_args(), "product_material_additional");
        parent::admin_index();
    }

}
