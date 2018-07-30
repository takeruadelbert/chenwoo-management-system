<form action="#" role="form" class="panel-filter">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Filter Data</h6>
            <div class="panel-icons-group"> <a href="#" data-panel="collapse" class="btn btn-link btn-icon"><i class="icon-arrow-up9"></i></a></div>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label><?= __("Periode Jurnal") ?></label>
                        <?= $this->Form->input(null,["type" => "text", "div" => false, "placeholder" => "Awal Periode", "label" => false, "class" => "form-control datepicker", "default" => isset($this->request->query["awal_GeneralEntry_transaction_date"]) ? $this->request->query['awal_GeneralEntry_transaction_date'] : date("Y-m-01"), "name" => "awal.GeneralEntry.transaction_date", "id" => "startDate"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp") ?></label>
                        <?= $this->Form->input(null,["type" => "text", "div" => false, "placeholder" => "Akhir Periode", "label" => false, "class" => "form-control datepicker", "default" => isset($this->request->query["akhir_GeneralEntry_transaction_date"]) ? $this->request->query['akhir_GeneralEntry_transaction_date'] : date("Y-m-t"), "name" => "akhir.GeneralEntry.transaction_date", "id" => "endDate"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Nomor Referensi") ?></label>
                        <?= $this->Form->input(null,["type" => "text", "div" => false, "placeholder" => "Nomor Referensi", "label" => false, "class" => "form-control tip", "default" => isset($this->request->query["GeneralEntry_reference_number"]) ? $this->request->query['GeneralEntry_reference_number'] : "", "name" => "GeneralEntry.reference_number"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Tipe Transaksi") ?></label>
                        <?= $this->Form->input(null,["div" => false, "empty" => '' , "placeholder" => "- Pilih Tipe Transaksi -", "label" => false, "class" => "select-full", "default" => isset($this->request->query["GeneralEntry_transaction_type_id"]) ? $this->request->query['GeneralEntry_transaction_type_id'] : "", "name" => "GeneralEntry.transaction_type_id", "options" => $transactionTypes]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Kode Transaksi") ?></label>
                        <?= $this->Form->input(null,["div" => false, "empty" => '' , "placeholder" => "- Pilih Kode Transaksi -", "label" => false, "class" => "select-full", "default" => isset($this->request->query["GeneralEntry_general_entry_account_type_id"]) ? $this->request->query['GeneralEntry_general_entry_account_type_id'] : "", "name" => "GeneralEntry.general_entry_account_type_id", "options" => $generalEntryAccountTypes]) ?>
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