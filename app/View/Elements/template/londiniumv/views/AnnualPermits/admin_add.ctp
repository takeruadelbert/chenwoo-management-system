<?php echo $this->Form->create("AnnualPermit", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Setup Jatah Cuti Tahunan") ?>
                    </h6>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <tr>
                            <td>

                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("AnnualPermit.year", __("Tahun"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("AnnualPermit.year", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full","options"=>$this->Echo->periodeTahun(),"empty"=>"","placeholder"=>"-Pilih Tahun-"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("AnnualPermit.quota", __("Jatah Cuti Tahunan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("AnnualPermit.quota", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-actions text-center">
                                    <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                                    <input type="reset" value="Reset" class="btn btn-info">
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                                        <?= __("Simpan") ?>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>