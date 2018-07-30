<?php echo $this->Form->create("Satuan", array("class" => "form-horizontal form-separate", "action" => "view", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#data-utama" data-toggle="tab"><i class="icon-user3"></i> <?= __("Data Utama") ?></a></li>
        <li><a href="#data-login" data-toggle="tab"><?= __("Login") ?></a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active fade in" id="data-utama">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr"><?= __("Data Utama") ?>
                        </h6>
                    </div>
                    <div>
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("Satuan.name", __("Nama"), array("class" => "col-md-2 control-label"));
                            echo $this->Form->input("Satuan.name", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control"));
                            ?>
                        </div>
                    </div>
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
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>