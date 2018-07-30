<?php echo $this->Form->create("Box", array("class" => "form-horizontal form-separate", "action" => "daily_boxing_per_product", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Laporan Pengepakan Ikan Harian") ?>
                </h6>
            </div>
            <div id="materialList">
                <div class="form-group">
                    <?php
                    echo $this->Form->label("Boxing.date", __("Tanggal Pengemasan"), array("class" => "col-md-3 control-label"));
                    echo $this->Form->input("Boxing.date", array("div" => array("class" => "col-md-3"), "label" => false, "class" => "form-control datepicker"));
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
                <input type="submit" value="<?= __("Cetak Laporan Pengemasan") ?>" class="btn btn-danger">
            </div>
        </div>
    </div>
</div>
