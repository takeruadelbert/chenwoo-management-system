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
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "name" => "GeneralEntryType.name", "default" => isset($this->request->query['GeneralEntryType_name']) ? $this->request->query['GeneralEntryType_name'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tanggal Buat") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control datepicker", "name" => "InitialBalance.initial_date", "default" => isset($this->request->query['InitialBalance_initial_date']) ? $this->request->query['InitialBalance_initial_date'] : ""]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Bank") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "name" => "select.BankAccount.bank_account_type_id", "default" => isset($this->request->query['select_BankAccount_bank_account_type_id']) ? $this->request->query['select_BankAccount_bank_account_type_id'] : "", "empty" => "", "placeholder" => "- Semua -", "options" => $bankAccountTypes]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tipe Kas") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "name" => "select.InitialBalance.cash_type_id", "default" => isset($this->request->query['select_InitialBalance_cash_type_id']) ? $this->request->query['select_InitialBalance_cash_type_id'] : "", "empty" => "", "placeholder" => "- Semua -", "options" => $cashTypes]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Nomor Rekening") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "name" => "BankAccount.code", "default" => isset($this->request->query['BankAccount_code']) ? $this->request->query['BankAccount_code'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Atas Nama Rekening") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "name" => "BankAccount.on_behalf", "default" => isset($this->request->query['BankAccount_on_behalf']) ? $this->request->query['BankAccount_on_behalf'] : ""]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['InitialBalance_branch_office_id']) ? $this->request->query['InitialBalance_branch_office_id'] : '', "name" => "InitialBalance.branch_office_id", "class" => "select-full", "div" => false, "label" => false, "options" => $branchOffices, "empty" => "", "placeholder" => "- Pilih Cabang Perusahaan -"]) ?>
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
