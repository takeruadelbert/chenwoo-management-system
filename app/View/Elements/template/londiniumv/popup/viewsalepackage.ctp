<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Packaging</h4>
</div>
<!-- New invoice template -->
<div class="panel form-horizontal">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">Rincian Packaging
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>

        <div class="well block">
            <div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("Sale.sale_no", __("Nomor Penjualan"), array("class" => "col-md-4 control-label"));
                            echo $this->Form->input("Sale.sale_no", array("div" => array("class" => "col-md-8"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("Sale.po_number", __("Nomor PO"), array("class" => "col-md-4 control-label"));
                            echo $this->Form->input("Sale.po_number", array("div" => array("class" => "col-md-8"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("Dummy.buyer", __("Pembeli"), array("class" => "col-md-4 control-label"));
                            echo $this->Form->input("Dummy.buyer", array("div" => array("class" => "col-md-8"), "type" => "text", "label" => false, "class" => "form-control", "disabled", "value" => $this->data['Buyer']['company_name']));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="panel panel-default">
                    <div class="panel-body" id="materialList">
                        <div class="table-responsive stn-table">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Penjualan") ?></h6>
                            </div>
                            <table width="100%" class="table table-hover table-bordered">                        
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th><?= __("Nama Produk") ?></th>
                                        <th width="100"><?= __("Jumlah MC Diorder") ?></th>
                                        <th width="100"><?= __("Jumlah MC Terpenuhi") ?></th>
                                        <th width="100"><?= __("Berat Pemesanan") ?></th>
                                        <th width="100"><?= __("Berat Terpenuhi") ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($this->data["SaleDetail"] as $k => $saleDetail) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $k + 1 ?></td>
                                            <td class="text-left"><?= $saleDetail["Product"]["Parent"]["name"] ?> - <?= $saleDetail["Product"]["name"] ?></td>
                                            <td class="text-right"><?= $saleDetail["quantity"] ?> MC</td>
                                            <td class="text-right"><?= $saleDetail["quantity_production"] ?> MC</td>
                                            <td class="text-right"><?= ic_kg($saleDetail["nett_weight"]) ?> <?= $saleDetail["Product"]["ProductUnit"]["name"] ?></td>
                                            <td class="text-right"><?= ic_kg($saleDetail["fulfill_weight"]) ?> <?= $saleDetail["Product"]["ProductUnit"]["name"] ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</div>