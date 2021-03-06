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
                        <label><?= __("Nama Kas") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "name" => "CooperativeCash.name", "default" => isset($this->request->query['CooperativeCash_name']) ? $this->request->query['CooperativeCash_name'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tanggal Buat") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control datepicker", "name" => "CooperativeCash.created_date", "default" => isset($this->request->query['CooperativeCash_created_date']) ? $this->request->query['CooperativeCash_created_date'] : ""]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Bank") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "name" => "select.CooperativeBankAccount.bank_account_type_id", "default" => isset($this->request->query['select_CooperativeBankAccount_bank_account_type_id']) ? $this->request->query['select_CooperativeBankAccount_bank_account_type_id'] : "", "empty" => "", "placeholder" => "- Semua -", "options" => $bankAccountTypes]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tipe Kas") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "name" => "select.CooperativeCash.cash_type_id", "default" => isset($this->request->query['select_CooperativeCash_cash_type_id']) ? $this->request->query['select_CooperativeCash_cash_type_id'] : "", "empty" => "", "placeholder" => "- Semua -", "options" => $cashTypes]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Nomor Rekening") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control", "name" => "CooperativeBankAccount.code", "default" => isset($this->request->query['CooperativeBankAccount_code']) ? $this->request->query['CooperativeBankAccount_code'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Atas Nama Rekening") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control", "name" => "CooperativeBankAccount.on_behalf", "default" => isset($this->request->query['CooperativeBankAccount_on_behalf']) ? $this->request->query['CooperativeBankAccount_on_behalf'] : ""]) ?>
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
