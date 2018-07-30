<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Produksi</h4>
</div>
<!-- New invoice template -->
<div class="panel form-horizontal">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">Stok Produksi
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <table width="100%" class="table table-hover">
            <tr>
                <td colspan="3" style="width:200px">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("Product.name", __("Nama Produk"), array("class" => "col-sm-4 control-label"));
                                echo $this->Form->input("Product.name", array("div" => array("class" => "col-sm-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data["Parent"]["name"] . " - " . $this->data["Product"]["name"]));
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("Product.stock__ic", __("Jumlah Berat"), array("class" => "col-md-4 control-label"));
                                echo $this->Form->input("Product.stock__ic", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control text-right addon-field", "disabled", "data-addon-symbol" => $this->data["ProductUnit"]["name"]));
                                ?>
                            </div>
                        </div>
                    </div>                                
                </td>
            </tr>
        </table>
        <div class="panel-heading" style="background:#2179cc">
            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Produksi") ?></h6>
        </div>
        <table width="100%" class="table table-hover stn-table table-bordered">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>PDC</th>
                    <th colspan="2">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($this->data["ProductDetail"])) {
                    foreach ($this->data["ProductDetail"] as $k => $productDetail) {
                        ?>
                        <tr>
                            <td class="text-center"><?= $k + 1 ?></td>
                            <td class="text-left"><?= $this->Chenwoo->labelBatchNumber($productDetail) ?></td>
                            <td class="text-right" width="75" style="border-right:none !important;padding-right:0"><?= ic_kg($productDetail["remaining_weight"]) ?></td>
                            <td class="text-left" width="25" style="border-left:none !important;padding-left:5px"><?= $this->data["ProductUnit"]["name"] ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td class="text-center" colspan="4">Tidak ada data</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>                          
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
</div>