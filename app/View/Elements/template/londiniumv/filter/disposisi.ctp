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
                        <label><?= __("No. Agenda") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['IncomingMail_nomor_agenda']) ? $this->request->query['IncomingMail_nomor_agenda'] : "", "name" => "IncomingMail.nomor_agenda", "class" => "form-control", "div" => false, "label" => false]) ?>
                    </div>
                    <div class="col-md-6">
                        <label ><?= __("No. Surat") ?></label>    
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['IncomingMail_nomor_surat']) ? $this->request->query['IncomingMail_nomor_surat'] : "", "name" => "IncomingMail.nomor_surat", "class" => "form-control", "div" => false, "label" => false]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Tanggal") ?></label>
                        <div class="row">
                            <div class="col-md-12">
                                <?= $this->Form->input(null, ["default" => isset($this->request->query['MailRecipient_created']) ? $this->request->query['MailRecipient_created'] : "", "name" => "MailRecipient.created", "class" => "form-control datepicker", "div" => false, "label" => false]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Status") ?></label>
                        <div class="row">
                            <div class="col-md-12">
                                <?= $this->Form->input(null, ["default" => isset($this->request->query['select_MailRecipient_seen']) ? $this->request->query['select_MailRecipient_seen'] : "", "name" => "select.MailRecipient.seen", "options" => [0 => "Belum dibaca", 1 => "Sudah dibaca"], "class" => "select-full", "div" => false, "label" => false, "empty" => "", "placeholder" => "- Semua -"]) ?>
                            </div>
                        </div>
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