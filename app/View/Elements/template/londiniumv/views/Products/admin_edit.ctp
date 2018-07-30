<?php echo $this->Form->create("Product", array("class" => "form-horizontal form-separate", "action" => "edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Ubah Data Produk") ?>
                    </h6>
                </div>
                <div class="table-responsive">
                    <div class="panel-heading" style="background:#2179cc">
                        <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Produk") ?></h6>
                    </div>
                    <table width="100%" class="table">
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6 ">
                                            <?php
                                            echo $this->Form->label("Product.name", __("Nama Produk"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Product.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                            ?>
                                        </div>
                                        <div class="col-md-6 ">
                                            <?php
                                            echo $this->Form->label("Product.parent_id", __("Kategori"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Product.parent_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih -", "id" => "parent"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6 ">
                                            <?php
                                            echo $this->Form->label("Product.product_unit_id", __("Satuan Produk"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Product.product_unit_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih -", "id" => "satuan", "disabled" => "disabled"));
                                            ?>
                                        </div>
                                        <div class="col-md-6 ">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Berat</label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <?php
                                                    echo $this->Form->input("Product.weight", array("div" => array("class" => ""), "id" => "weight", "type" => "number", "label" => false, "class" => "form-control text-right", "disabled"));
                                                    ?>
                                                    <span class="input-group-addon"><strong>Kg</strong></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6 ">
                                            <?php
                                            echo $this->Form->label("Product.code", __("Kode Produk"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Product.code", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                        <div class="col-md-6 ">
                                            <?php
                                            echo $this->Form->label("Product.name_label", __("Label Produk"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Product.name_label", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Harga Per Produk") ?></h6>
                        </div>  
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6 ">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Harga Dalam Rupiah <br/> (per KG)</label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-addon currencyUniq" class="currencyUniq"><strong>Rp.</strong></span>
                                                    <?php
                                                    echo $this->Form->input("Product.price_rupiah", array("div" => array("class" => ""), "id" => "pricePerRupiah", "type" => "text", "label" => false, "class" => "form-control text-right isdecimal", "disabled"));
                                                    ?>
                                                    <span class="input-group-addon currencyUniq" class="currencyUniq"><strong>,00</strong></span>
                                                </div>
                                            </div>
                                        </div>    
                                        <div class="col-md-6 ">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Harga per satuan <br/> ( per LBS )</label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-addon currencyUniq" class="currencyUniq"><strong>$</strong></span>
                                                    <?php
                                                    echo $this->Form->input("Product.price_usd", array("div" => array("class" => ""), "id" => "pricePerUSD", "type" => "text", "label" => false, "class" => "form-control text-right", "disabled"));
                                                    ?>
                                                </div>
                                            </div>
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
<script>
    $(document).ready(function () {
        if ($("#parent").val() == "") {
            $("#satuan").attr("disabled", "disabled");
            $("#weight").attr("disabled", "disabled");
            $("#ProductCode").attr("disabled", "disabled");
            $("#pricePerRupiah").attr("disabled", "disabled");
            $("#pricePerUSD").attr("disabled", "disabled");
            $("#ProductNameLabel").attr("disabled", "disabled");
        } else {
            $("#satuan").removeAttr("disabled");
            $("#weight").removeAttr("disabled");
            $("#ProductCode").removeAttr("disabled");
            $("#pricePerRupiah").removeAttr("disabled");
            $("#pricePerUSD").removeAttr("disabled");
            $("#ProductNameLabel").removeAttr("disabled");
        }
        $("#parent").on("change", function () {
            $("#parent").click(function () {
                if ($(this).val() != '' && $(this).val() != null) {
                    $("#satuan").select2("val", 1);
                    $("#satuan").removeAttr("disabled");
                    $("#weight").removeAttr("disabled");
                    $("#ProductCode").removeAttr("disabled");
                    $("#pricePerRupiah").removeAttr("disabled");
                    $("#pricePerUSD").removeAttr("disabled");
                    $("#ProductNameLabel").removeAttr("disabled");
                } else {
                    $("#satuan").attr("disabled", "disabled");
                    $("#weight").attr("disabled", "disabled");
                    $("#ProductCode").attr("disabled", "disabled");
                    $("#pricePerRupiah").attr("disabled", "disabled");
                    $("#pricePerUSD").attr("disabled", "disabled");
                    $("#ProductNameLabel").attr("disabled", "disabled");
                }
            });
        });
    });
</script>