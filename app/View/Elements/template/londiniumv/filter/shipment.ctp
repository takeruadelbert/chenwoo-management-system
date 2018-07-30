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
                        <label><?= __("No. Pengiriman") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "type" => "text", "name" => "Shipment.shipment_number", "default" => isset($this->request->query['Shipment_shipment_number']) ? $this->request->query['Shipment_shipment_number'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Nomor Penjualan") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "type" => "text", "name" => "Sale.sale_no", "default" => isset($this->request->query['Sale_sale_no']) ? $this->request->query['Sale_sale_no'] : ""]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Nomor PO") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "type" => "text", "name" => "Sale.po_number", "default" => isset($this->request->query['Sale_po_number']) ? $this->request->query['Sale_po_number'] : ""]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("Periode Pengiriman") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['awal_Shipment_shipment_date']) ? $this->request->query['awal_Shipment_shipment_date'] : '', "name" => "awal.Shipment.shipment_date", "class" => "form-control datepicker", "id" => "startDate", "div" => false, "label" => false, "placeholder" => "Awal Periode"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['akhir_Shipment_shipment_date']) ? $this->request->query['akhir_Shipment_shipment_date'] : '', "name" => "akhir.Shipment.shipment_date", "class" => "form-control datepicker", "id" => "endDate", "div" => false, "label" => false, "placeholder" => "Akhir Periode"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Status Pengiriman") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "options" => $shipmentStatuses, "empty" => "", "placeholder" => "- Semua -", "class" => "select-full", "name" => "select.Shipment.shipment_status_id", "default" => isset($this->request->query['select_Shipment_shipment_status_id']) ? $this->request->query['select_Shipment_shipment_status_id'] : ""]) ?>
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
