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
                        <label><?= __("Bunga") ?></label>
                        <div class="input-group">
                            <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control", "name" => "CooperativeLoanInterest.interest", "default" => isset($this->request->query['CooperativeLoanInterest_interest']) ? $this->request->query['CooperativeLoanInterest_interest'] : ""])?>
                            <span class="input-group-addon"><strong>%</strong></span>
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
