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
                        <label><?= __("Judul Berita") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "name" => "InternalNews.title", "default" => isset($this->request->query['InternalNews_title']) ? $this->request->query['InternalNews_title'] : ""]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Tanggal Post") ?></label>
                        <div class="row">
                            <div class="col-md-12">
                                <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control datepicker", "name" => "InternalNews.created", "default" => isset($this->request->query['InternalNews_created']) ? $this->request->query['InternalNews_created'] : ""]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_Employee_branch_office_id']) ? $this->request->query['select_Employee_branch_office_id'] : '', "name" => "select.Employee.branch_office_id", "class" => "select-full", "div" => false, "label" => false, "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
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
