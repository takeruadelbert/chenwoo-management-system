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
                        <label><?= __("Nama Dokumen") ?></label>
                        <?= $this->Form->input(null, array("default" => isset($this->request->query['Archive_name']) ? $this->request->query['Archive_name'] : '', "name" => "Archive.name", "div" => false, "label" => false, "class" => "form-control tip")) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tanggal Upload") ?></label>
                        <div class="row">
                            <div class="col-md-12">
                                <?= $this->Form->input(null, ["default" => isset($this->request->query['Archive_created']) ? $this->request->query['Archive_created'] : '', "name" => "Archive.created", "class" => "form-control datepicker", "div" => false, "label" => false]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label ><?= __("Jenis Dokumen") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_Archive_document_type_id']) ? $this->request->query['select_Archive_document_type_id'] : 0, "options" => $documentTypes, "name" => "select.Archive.document_type_id", "class" => "select-full", "div" => false, "label" => false, "empty" => "", "placeholder" => "- Pilih Jenis Dokumen -"]) ?>
                    </div>
                    <?php
                    if ($this->StnAdmin->is("admin", $this->Session->read("credential.admin"))) {
                        ?>
                        <div class="col-md-6">
                            <label ><?= __("Departemen") ?></label>
                            <?= $this->Form->input(null, ["default" => isset($this->request->query['select_Employee_department_id']) ? $this->request->query['select_Employee_department_id'] : 0, "options" => $departments, "name" => "select.Employee.department_id", "class" => "select-full", "div" => false, "label" => false, "empty" => "", "placeholder" => "- Pilih Departemen -"]) ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_Employee_branch_office_id']) ? $this->request->query['select_Employee_branch_office_id'] : '', "name" => "select.Employee.branch_office_id", "class" => "select-full", "div" => false, "label" => false, "options" => $branchOffices, "empty" => "", "placeholder" => "- semua -"]) ?>
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
