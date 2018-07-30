<?php

class Product extends AppModel {

    var $name = 'Product';
    var $belongsTo = array(
        "ProductCategory",
        "ProductUnit",
        "Parent" => [
            "foreignKey" => "parent_id",
            "className" => "Product",
        ],
        "BranchOffice"
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "ProductSize" => array(
            "dependent" => true
        ),
        "Child" => [
            "foreignKey" => "parent_id",
            "className" => "Product",
        ],
        "TreatmentDetail" => [
            "dependent" => true
        ],
        "ProductMaterialAdditional" => [
            "depend" => true,
        ],
        "ProductDetail",
    );
    var $validate = array(
        'price' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
        'product_category_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus dipilih'
        ),
    );
    var $virtualFields = array(
    );
    var $vfRemainingStock = "select sum(ProductDetailOF.remaining_weight) from product_details ProductDetailOF where ProductDetailOF.product_id=Product.id and ProductDetailOF.branch_office_id = %d";

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

    function getList() {
        $products = $this->find("all", [
            "conditions" => [
                "NOT" => [
                    "Product.parent_id" => null,
                ],
            ],
            "Parent",
        ]);
        $result = [];
        foreach ($products as $product) {
            if (!isset($result[$product["Parent"]["name"]])) {
                $result[$product["Parent"]["name"]] = [];
            }
            $result[$product["Parent"]["name"]][$product["Product"]["id"]] = $product["Parent"]["name"] . " " . $product["Product"]["name"];
        }
        return $result;
    }

}

?>
