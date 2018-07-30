<?php

class MaterialEntry extends AppModel {

    var $name = 'MaterialEntry';
    var $belongsTo = array(
        "Supplier",
        "Employee",
        "MaterialCategory",
        "BranchOffice",
        "ConversionStatus" => [
            "className" => "ProductionCommonStatus",
            "foreignKey" => "conversion_status_id",
        ],
        "FreezingStatus" => [
            "className" => "ProductionCommonStatus",
            "foreignKey" => "freezing_status_id",
        ],
        "TreatmentStatus" => [
            "className" => "ProductionCommonStatus",
            "foreignKey" => "treatment_status_id",
        ],
        "Operator" => [
            "className" => "Employee",
            "foreignKey" => "operator_id"
        ],
        "VerifyStatus",
        "VerifiedBy" => [
            "className" => "Employee",
            "foreignKey" => "verified_by_id"
        ],
    );
    var $hasOne = array(
        "TransactionEntry",
    );
    var $hasMany = array(
        "MaterialEntryGrade" => array(
            "dependent" => true
        ),
        "Conversion" => array(
            "dependent" => true
        ),
        "Freeze" => array(
            "dependent" => true
        ),
        "Treatment" => array(
            "dependent" => true
        ),
    );
    var $validate = array(
        "supplier_id" => [
            'rule' => 'notEmpty',
            'message' => 'Harus Dipilih!'
        ],
        "weight_date" => [
            'rule' => 'notEmpty',
            'message' => 'Harus Diisi!'
        ],
        "material_category_id" => [
            'rule' => 'notEmpty',
            'message' => 'Harus Dipilih!'
        ],
        "operator_id" => [
            'rule' => 'notEmpty',
            'message' => 'Harus Dipilih!'
        ],
    );
    var $virtualFields = array(
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

    function updateConversionStatus($materialEntryId = false) {
        $materialEntry = $this->find("first", [
            "conditions" => [
                "MaterialEntry.id" => $materialEntryId,
            ],
            "contain" => [
                "MaterialEntryGrade" => [
                    "MaterialEntryGradeDetail",
                ],
            ],
        ]);
        $countUnfinished = 0;
        foreach ($materialEntry["MaterialEntryGrade"] as $materialEntryGrades) {
            foreach ($materialEntryGrades["MaterialEntryGradeDetail"] as $materialEntryGradeDetail) {
                $countUnfinished+=$materialEntryGradeDetail["is_used"] == 1 ? 0 : 1;
            }
        }
        if ($countUnfinished <= 0) {
            $this->save([
                "id" => $materialEntryId,
                "conversion_status_id" => 2,
            ]);
        }
    }

    function updateFreezeStatus($materialEntryId = false) {
        $materialEntry = $this->find("first", [
            "conditions" => [
                "MaterialEntry.id" => $materialEntryId,
            ],
            "contain" => [
                "MaterialEntryGrade" => [
                    "MaterialEntryGradeDetail",
                ],
                "Conversion" => [
                    "Freeze",
                ],
            ],
        ]);
        $countFish = 0;
        $countFinishedFish = 0;
        $countUnfinishedFish = 0;
        $countUnfihisedConversion = 0;
        if ($materialEntry["MaterialEntry"]['material_category_id'] == 1) { //for whole
            foreach ($materialEntry["MaterialEntryGrade"] as $materialEntryGrades) {
                foreach ($materialEntryGrades["MaterialEntryGradeDetail"] as $materialEntryGradeDetail) {
                    $countUnfinishedFish+=$materialEntryGradeDetail["is_used"] == 1 ? 0 : 1;
                }
            }
            $countUnfihisedConversion = 0;
            foreach ($materialEntry["Conversion"] as $conversion) {
                if (empty($conversion["Freeze"]["id"])) {
                    $countUnfihisedConversion++;
                }
            }
            if ($countUnfinishedFish <= 0 && $countUnfihisedConversion <= 0) {
                $this->save([
                    "id" => $materialEntryId,
                    "freezing_status_id" => 2,
                ]);
            }
        } else { //for loin
            $status = true;
            foreach ($materialEntry["MaterialEntryGrade"] as $materialEntryGrades) {
                if ($materialEntryGrades["is_used"] == 0) {
                    $status = false;
                }
            }
            if ($status == true) {
                $this->save([
                    "id" => $materialEntryId,
                    "freezing_status_id" => 2,
                ]);
            }
        }
    }

    function updateTreatmentStatus($materialEntryId = false) {
        $materialEntry = $this->find("first", [
            "conditions" => [
                "MaterialEntry.id" => $materialEntryId,
            ],
            "contain" => [
                "MaterialEntryGrade" => [
                    "MaterialEntryGradeDetail",
                ],
                "Conversion" => [
                    "Freeze",
                ],
                "Freeze" => [
                    "FreezeDetail",
                    "Treatment",
                ],
            ],
        ]);
        $countUnfinishedFish = 0;
        if ($materialEntry["MaterialEntry"]['material_category_id'] == 1) { //for whole
            foreach ($materialEntry["MaterialEntryGrade"] as $materialEntryGrades) {
                foreach ($materialEntryGrades["MaterialEntryGradeDetail"] as $materialEntryGradeDetail) {
                    $countUnfinishedFish+=$materialEntryGradeDetail["is_used"] == 1 ? 0 : 1;
                }
            }
            $countUnfihisedConversion = 0;
            foreach ($materialEntry["Conversion"] as $conversion) {
                if (empty($conversion["Freeze"]["id"])) {
                    $countUnfihisedConversion++;
                }
            }
            $countUnfihisedFreeze = 0;
            foreach ($materialEntry["Freeze"] as $freeze) {
                if (empty($freeze["Treatment"]["id"])) {
                    $countUnfihisedFreeze++;
                }
            }
            if ($countUnfinishedFish <= 0 && $countUnfihisedConversion <= 0 && $countUnfihisedFreeze <= 0) {
                $this->save([
                    "id" => $materialEntryId,
                    "treatment_status_id" => 2,
                ]);
            }
        }else { //for loin
            $status = true;    
            if ($materialEntry["freezing_status_id"]==1) {
                $status = false;
            }
            foreach ($materialEntry["Freeze"] as $freeze) {
                foreach ($freeze["FreezeDetail"] as $freezeDetail) {
                    if ($freezeDetail["remaining_weight"] > 0) {
                        $status = false;
                    }
                }
            }
            if ($status == true) {
                $this->save([
                    "id" => $materialEntryId,
                    "treatment_status_id" => 2,
                ]);
            }
        }
    }

    function updateFishStatusForColly($materialEntryGradeId = null) {
        $materialEntryGradeIds = $this->MaterialEntryGrade->find("list", [
            "conditions" => [
                "MaterialEntryGrade.id" => $materialEntryGradeId,
            ],
            "fields" => [
                "MaterialEntryGrade.id"
            ],
        ]);
        $this->MaterialEntryGrade->MaterialEntryGradeDetail->updateAll([
            "MaterialEntryGradeDetail.is_used" => 1,
                ], [
            "MaterialEntryGradeDetail.material_entry_grade_id" => $materialEntryGradeIds,
        ]);
    }

}

?>
