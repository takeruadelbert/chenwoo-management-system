<?php echo $this->Form->create("TransactionOut", array("class" => "form-horizontal form-separate", "action" => "rekapitulasi_per_buyer", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Laporan Transaksi Pembelian") ?>
                </h6>
            </div>
            <div id="materialList">
                <div class="form-group">
                    <?php
                    echo $this->Form->label("TransactionOut.dateFrom", __("Tanggal Laporan "), array("class" => "col-md-3 control-label"));
                    echo $this->Form->input("TransactionOut.dateFrom", array("div" => array("class" => "col-md-3"), "label" => false, "class" => "form-control datepicker"));
                    ?>
                    <?php
                    echo $this->Form->label("TransactionOut.dateTo", __("Hingga Tanggal"), array("class" => "col-md-3 control-label"));
                    echo $this->Form->input("TransactionOut.dateTo", array("div" => array("class" => "col-md-3"), "label" => false, "class" => "form-control datepicker"));
                    ?>
                </div>    
            </div>
            <div id="materialList">
                <div class="form-group">
                    <?php
                    echo $this->Form->label("Purchase.buyer_id", __("Pembeli"), array("class" => "col-md-3 control-label"));
                    echo $this->Form->input("Purchase.buyer_id", array("div" => array("class" => "col-md-3"),"empty"=>"- Pilih Pembeli -", "label" => false, "class" => "form-control"));
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
                <input type="submit" value="<?= __("Cetak Laporan Pembobotan") ?>" class="btn btn-danger">
            </div>
        </div>
    </div>
</div>
