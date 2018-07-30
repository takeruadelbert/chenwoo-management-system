<?php

class TransactionOut extends AppModel {

    var $name = 'TransactionOut';
    var $belongsTo = array(
        "Shipment",
        "ShipmentAgent",
        "Container"
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "TransactionMaterialOut" => array(
            "dependent" => true
        ),
        "PaymentSale" => array(
            "dependent" => true
        )
    );
    var $validate = array(
    );
    var $virtualFields = array(
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

    function buildReport($startDate = false, $endDate = false) {
        $transactionOuts = $this->find('all', [
            'conditions' => [
                "(Purchase.created between '$startDate' and '$endDate')",
            ],
            'contain' => [
                "Purchase" => [
                    "PurchaseDetail" => [
                        "ProductSize" => [
                            "Product"
                        ]
                    ]
                ],
            ],
        ]);
        //key: $s_%s : product id : product size
        $result = [];
        $productSizes = ClassRegistry::init("ProductSize")->find("all", [
            "contain" => [
                "Product",
            ]
        ]);
        foreach ($productSizes as $productSize) {
            $uniq_key = $productSize["Product"]["id"] . "_" . $productSize["ProductSize"]["id"];
            $result[$uniq_key] = [
                "info" => [
                    "name" => $productSize["Product"]["name"] . " - " . $productSize["ProductSize"]["name"],
                    "product_category_id" => $productSize["Product"]["product_category_id"],
                ],
                "transaction" => [],
                "summary" => [
                    "total_quantity" => 0,
                    "total_price" => 0,
                ],
            ];
        }
        foreach ($transactionOuts as $transactionOut) {
            foreach ($transactionOut["Purchase"]["PurchaseDetail"] as $purchaseDetail) {
                $product = $purchaseDetail["ProductSize"]["Product"];
                $productSize = $purchaseDetail["ProductSize"];
                $y = date("Y", strtotime($transactionOut["Purchase"]["created"]));
                $n = date("n", strtotime($transactionOut["Purchase"]["created"]));
                $uniq_key = $product["id"] . "_" . $productSize["id"];
                if (!isset($result[$uniq_key]["monthly"][$y][$n])) {
                    $result[$uniq_key]["monthly"][$y][$n] = [
                        "total_quantity" => 0,
                        "total_price" => 0,
                    ];
                }
                $result[$uniq_key]["transaction"][] = [
                    "dt" => $transactionOut["Purchase"]["created"],
                    "quantity" => $purchaseDetail["quantity"],
                    "price" => $purchaseDetail["price"]
                ];
                $result[$uniq_key]["summary"]["total_quantity"]+=$purchaseDetail["quantity"];
                $result[$uniq_key]["summary"]["total_price"]+=$purchaseDetail["price"];
                $result[$uniq_key]["monthly"][$y][$n]["total_quantity"]+=$purchaseDetail["quantity"];
                $result[$uniq_key]["monthly"][$y][$n]["total_price"]+=$purchaseDetail["price"];
            }
        }
        return $result;
    }

}

?>
