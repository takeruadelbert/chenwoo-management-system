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
                        <label><?= __("Nomor Penjualan") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "type" => "text", "name" => "Sale.sale_no", "default" => isset($this->request->query['ProductData_serial_number']) ? $this->request->query['ProductData_serial_number'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Pembeli") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "type" => "text", "name" => "Buyer.name", "default" => isset($this->request->query['ProductSize_name']) ? $this->request->query['ProductSize_name'] : ""]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Tanggal Awal Dibuat") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['awal_Sale_created']) ? $this->request->query['awal_Sale_created'] : '', "name" => "awal.Sale.created", "class" => "form-control datepicker", "id" => "startDate", "div" => false, "label" => false]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tanggal Akhir Dibuat") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['akhir_Sale_created']) ? $this->request->query['akhir_Sale_created'] : '', "name" => "akhir.Sale.created", "class" => "form-control datepicker", "id" => "endDate", "div" => false, "label" => false]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_Sale_branch_office_id']) ? $this->request->query['select_Sale_branch_office_id'] : '', "name" => "select.Sale.branch_office_id", "class" => "select-full", "div" => false, "label" => false, "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
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
