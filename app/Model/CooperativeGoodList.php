<?php

class CooperativeGoodList extends AppModel {

    var $name = 'CooperativeGoodList';
    var $belongsTo = array(
        "GoodType",
        "BranchOffice",
        "CooperativeGoodListUnit"
    );
    var $hasOne = array(
    );
    var $hasMany = array(
        "CooperativeGoodListDetail",
    );
    var $validate = array(
//        'code' => array(
//            'rule' => 'notEmpty',
//            'message' => 'Harus diisi'
//        ),
        'barcode' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'good_type_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'cooperative_good_list_unit_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'stock_number' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'sale_price' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
        'capital_price' => array(
            'rule' => 'notEmpty',
            'message' => 'Harus diisi'
        ),
    );
    var $virtualFields = array(
        "average_capital_price" => "select ceil(sum(xDetail.stock_number*xDetail.capital_price)/sum(xDetail.stock_number)) from cooperative_good_list_details xDetail where xDetail.cooperative_good_list_id=CooperativeGoodList.id"
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

    function updateByCashReceipt($cashReceiptId) {
        $modelCooperativeCashReceipt = ClassRegistry::init("CooperativeCashReceipt");
        $cashReceipt = $modelCooperativeCashReceipt->find("first", [
            "conditions" => [
                "CooperativeCashReceipt.id" => $cashReceiptId,
            ],
            "contain" => [
                "CooperativeCashReceiptDetail",
            ]
        ]);
        foreach ($cashReceipt["CooperativeCashReceiptDetail"] as $cooperativeCashReceiptDetail) {
            $boughtQuantity = $cooperativeCashReceiptDetail["quantity"];
            $cooperativeGoodListId = $cooperativeCashReceiptDetail["cooperative_good_list_id"];
            while ($boughtQuantity > 0) {
                $cooperativeGoodListDetail = $this->CooperativeGoodListDetail->find("first", [
                    "conditions" => [
                        "CooperativeGoodListDetail.cooperative_good_list_id" => $cooperativeGoodListId,
                        "CooperativeGoodListDetail.stock_number > 0",
                    ],
                    "order" => "CooperativeGoodListDetail.capital_price asc",
                    "contain" => [
                        "CooperativeGoodList",
                    ],
                ]);
                if (empty($cooperativeGoodListDetail)) {
                    break;
                }
                $currentPriceStock = $cooperativeGoodListDetail["CooperativeGoodListDetail"]["stock_number"];
                if ($currentPriceStock > $boughtQuantity) {
                    $reductionStock = $boughtQuantity;
                    $boughtQuantity = 0;
                } else {
                    $reductionStock = $currentPriceStock;
                    $boughtQuantity-=$currentPriceStock;
                }
                $this->save([
                    "CooperativeGoodList" => [
                        "id" => $cooperativeGoodListDetail["CooperativeGoodList"]["id"],
                        "stock_number" => $cooperativeGoodListDetail["CooperativeGoodList"]["stock_number"] - $reductionStock,
                    ],
                ]);
                $this->CooperativeGoodListDetail->save([
                    "CooperativeGoodListDetail" => [
                        "id" => $cooperativeGoodListDetail["CooperativeGoodListDetail"]["id"],
                        "stock_number" => $cooperativeGoodListDetail["CooperativeGoodListDetail"]["stock_number"] - $reductionStock,
                    ],
                ]);
            }
        }
    }

    function updateByCashDisbursement($cashDisbursementId) {
        $modelCooperativeCashDisbursement = ClassRegistry::init("CooperativeCashDisbursement");
        $cashDisbursement = $modelCooperativeCashDisbursement->find("first", [
            "conditions" => [
                "CooperativeCashDisbursement.id" => $cashDisbursementId,
            ],
            "contain" => [
                "CooperativeCashDisbursementDetail",
            ],
        ]);
        foreach ($cashDisbursement["CooperativeCashDisbursementDetail"] as $cooperativeCashDisbursementDetail) {
            $cooperativeGoodList = $this->find("first", [
                "conditions" => [
                    "CooperativeGoodList.id" => $cooperativeCashDisbursementDetail['cooperative_good_list_id']
                ]
            ]);
            $dataStockUpdated = [];
            $dataStockUpdated['CooperativeGoodList']['id'] = $cooperativeCashDisbursementDetail['cooperative_good_list_id'];
            $dataStockUpdated['CooperativeGoodList']['stock_number'] = $cooperativeGoodList['CooperativeGoodList']['stock_number'] + $cooperativeCashDisbursementDetail['quantity'];
            $dataStockUpdated['CooperativeGoodList']['capital_price'] = $cooperativeCashDisbursementDetail['amount'];
            $this->create();
            $this->save($dataStockUpdated);
            $cooperativeGoodListDetail = $this->CooperativeGoodListDetail->find("first", [
                "conditions" => [
                    "CooperativeGoodListDetail.cooperative_good_list_id" => $cooperativeCashDisbursementDetail['cooperative_good_list_id'],
                    "CooperativeGoodListDetail.capital_price" => $cooperativeCashDisbursementDetail["amount"],
                ]
            ]);
            if (empty($cooperativeGoodListDetail)) {
                $detail = [
                    "CooperativeGoodListDetail" => [
                        "cooperative_good_list_id" => $cooperativeCashDisbursementDetail['cooperative_good_list_id'],
                        "stock_number" => $cooperativeCashDisbursementDetail["quantity"],
                        "capital_price" => $cooperativeCashDisbursementDetail["amount"],
                    ]
                ];
            } else {
                $detail = [
                    "CooperativeGoodListDetail" => [
                        "id" => $cooperativeGoodListDetail["CooperativeGoodListDetail"]["id"],
                        "stock_number" => $cooperativeCashDisbursementDetail["quantity"] + $cooperativeGoodListDetail["CooperativeGoodListDetail"]["stock_number"],
                    ]
                ];
            }
            $this->CooperativeGoodListDetail->create();
            $this->CooperativeGoodListDetail->save($detail);
        }
    }

}

?>
