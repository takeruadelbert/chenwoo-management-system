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
                        <label><?= __("Nama Barang") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "name" => "CooperativeGoodList.name", "default" => isset($this->request->query['CooperativeGoodList_name']) ? $this->request->query['CooperativeGoodList_name'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Kategori Barang") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "name" => "select.Good.good_type_id", "default" => isset($this->request->query['select_Good_good_type_id']) ? $this->request->query['select_Good_good_type_id'] : "", "empty" => "", "placeholder" => "- Semua -", "options" => $goodTypes]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Kode Barang") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "name" => "CooperativeGoodList.code", "default" => isset($this->request->query['CooperativeGoodList_code']) ? $this->request->query['CooperativeGoodList_code'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Barcode") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "name" => "CooperativeGoodList.barcode", "default" => isset($this->request->query['CooperativeGoodList_barcode']) ? $this->request->query['CooperativeGoodList_barcode'] : ""]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "name" => "select.CooperativeGoodList.branch_office_id", "default" => isset($this->request->query['select_CooperativeGoodList_branch_office_id']) ? $this->request->query['select_CooperativeGoodList_branch_office_id'] : "", "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
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
<script>
    filterReload();
</script>
