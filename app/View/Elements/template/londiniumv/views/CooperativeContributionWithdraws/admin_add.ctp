<?php echo $this->Form->create("CooperativeContributionWithdraw", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Pengambilan Iuran") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("Dummy.full_name", __("Nama Anggota Koperasi"), array("class" => "col-md-4 control-label"));
                            echo $this->Form->input("Dummy.full_name", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data["Employee"]["Account"]["Biodata"]["full_name"]));
                            ?>                                 
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("CooperativeContributionWithdraw.amount", __("Jumlah Pengambilan"), array("class" => "col-md-4 control-label"));
                            echo $this->Form->input("CooperativeContributionWithdraw.amount", array("type" => "text", "div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control rupiah-field text-right isdecimal"));
                            echo $this->Form->hidden("CooperativeContributionWithdraw.employee_id", ["value" => $this->data["CooperativeContribution"]["employee_id"]]);
                            ?>                                 
                        </div>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("Dummy.total", __("Total Iuran"), array("class" => "col-md-4 control-label"));
                            echo $this->Form->input("Dummy.total", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control rupiah-field text-right isdecimal", "disabled", "value" => $this->data["CooperativeContribution"]["total"]));
                            ?>                                 
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("Dummy.left", __("Sisa Iuran"), array("class" => "col-md-4 control-label"));
                            echo $this->Form->input("Dummy.left", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control rupiah-field text-right isdecimal", "disabled", "value" => $this->data["CooperativeContribution"]["total"] - $this->data["CooperativeContribution"]["paid"]));
                            ?>                                 
                        </div>
                    </div>
                </div>  
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <div class="form-actions text-center">
                        <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                        <input type="reset" value="Reset" class="btn btn-info">
                        <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                            <?= __("Simpan") ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>