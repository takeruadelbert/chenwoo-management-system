<?php echo $this->Form->create("CooperativeGoodList", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Data Barang Koperasi") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Barang") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CooperativeGoodList.code", __("Kode Barang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("CooperativeGoodList.code", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "value" => "AUTO GENERATE", "disabled"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CooperativeGoodList.barcode", __("Barcode Barang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("CooperativeGoodList.barcode", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                            ?>
                                        </div>
                                    </div>
                                </div>                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CooperativeGoodList.name", __("Nama Barang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("CooperativeGoodList.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CooperativeGoodList.good_type_id", __("Kategori Barang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("CooperativeGoodList.good_type_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih -"));
                                            ?>
                                        </div>
                                    </div>
                                </div>                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Harga Modal</label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><strong>Rp.</strong></span>
                                                    <input type="text" class="form-control text-right isdecimal" name="data[CooperativeGoodList][capital_price]">
                                                    <span class="input-group-addon"><strong>,00.</strong></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Harga Jual</label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><strong>Rp.</strong></span>
                                                    <input type="text" class="form-control text-right isdecimal" name="data[CooperativeGoodList][sale_price]">
                                                    <span class="input-group-addon"><strong>,00.</strong></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CooperativeGoodList.stock_number", __("Stok"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("CooperativeGoodList.stock_number", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control text-right"));
                                            ?>
                                        </div>
                                    </div>  
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CooperativeGoodList.cooperative_good_list_unit_id", __("Satuan Barang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("CooperativeGoodList.cooperative_good_list_unit_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Satuan Barang -"));
                                            ?>
                                        </div>
                                    </div>                              
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("CooperativeGoodList.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("CooperativeGoodList.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
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