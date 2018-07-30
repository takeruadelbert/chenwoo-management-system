<form action="#" role="form" class="panel-filter">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Filter Data</h6>
            <div class="panel-icons-group"> <a href="#" data-panel="collapse" class="btn btn-link btn-icon"><i class="icon-arrow-up9"></i></a></div>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Nomor PO") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "type" => "text", "name" => "PurchaseOrderMaterialAdditional.po_number", "default" => isset($this->request->query['PurchaseOrderMaterialAdditional_po_number']) ? $this->request->query['PurchaseOrderMaterialAdditional_po_number'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Nomor RO") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "type" => "text", "name" => "RequestOrderMaterialAdditional.ro_number", "default" => isset($this->request->query['RequestOrderMaterialAdditional_ro_number']) ? $this->request->query['RequestOrderMaterialAdditional_ro_number'] : ""]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label><?= __("Periode PO") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['awal_PurchaseOrderMaterialAdditional_po_date']) ? $this->request->query['awal_PurchaseOrderMaterialAdditional_po_date'] : "", "name" => "awal.PurchaseOrderMaterialAdditional.po_date", "class" => "form-control datepicker", "id" => "startDate", "type" => "text", "div" => false, "label" => false, "placeholder" => "Awal Periode"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['akhir_PurchaseOrderMaterialAdditional_po_date']) ? $this->request->query['akhir_PurchaseOrderMaterialAdditional_po_date'] : "", "name" => "akhir.PurchaseOrderMaterialAdditional.po_date", "class" => "form-control datepicker", "id" => "endDate", "type" => "text", "div" => false, "label" => false, "placeholder" => "Akhir Periode"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "name" => "select.RequestOrderMaterialAdditional.branch_office_id", "default" => isset($this->request->query['select_RequestOrderMaterialAdditional_branch_office_id']) ? $this->request->query['select_RequestOrderMaterialAdditional_branch_office_id'] : "", "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Supplier") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_PurchaseOrderMaterialAdditional_material_additional_supplier_id']) ? $this->request->query['select_PurchaseOrderMaterialAdditional_material_additional_supplier_id'] : "", "name" => "select.PurchaseOrderMaterialAdditional.material_additional_supplier_id", "class" => "select-full", "div" => false, "label" => false, "options"=>$materialAdditionalSuppliers, "empty" => "", "placeholder" => "- Cari Supplier -"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Status") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_PurchaseOrderMaterialAdditional_purchase_order_material_additional_status_id']) ? $this->request->query['select_PurchaseOrderMaterialAdditional_purchase_order_material_additional_status_id'] : "", "name" => "PurchaseOrderMaterialAdditional.purchase_order_material_additional_status_id", "class" => "select-full", "div" => false, "label" => false, "options"=>$purchaseOrderMaterialAdditionalStatuses, "empty" => "", "placeholder" => "- Cari Status -"]) ?>
                    </div>
                </div>
            </div>    
            <div class="form-actions text-center">
                <input type="button" value="<?= __("Reset") ?>" class="btn btn-danger btn-filter-reset">
                <input type="button" value="<?= __("Cari") ?>" class="btn btn-info btn-filter">
            </div>
        </div>
    </div>
</form>
