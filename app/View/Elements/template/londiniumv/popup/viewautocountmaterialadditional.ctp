<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Material Tambahan</h4>
</div>
<!-- New invoice template -->
<div class="panel form-horizontal">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">Perhitungan Biaya Material Tambahan Berdasarkan Parameter Pemakaian
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
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Rincian Perhitungan") ?></h6>
                            </div>
                            <table width="100%" class="table table-hover table-bordered">                        
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th><?= __("Nama Produk") ?></th>
                                        <th width="145"><?= __("Jenis MC") ?></th>
                                        <th width="45"><?= __("Jumlah MC") ?></th>
                                        <th width="55"><?= __("Harga Satuan (Rp)") ?></th>
                                        <th width="80"><?= __("Total Biaya MC (Rp)") ?></th>
                                        <th width="145"><?= __("Jenis Plastik") ?></th>
                                        <th width="45"><?= __("Jumlah Plastik") ?></th>
                                        <th width="55"><?= __("Harga Satuan (Rp)") ?></th>
                                        <th width="80"><?= __("Total Biaya Plastik (Rp)") ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $grandTotalMc = 0;
                                    $grandTotalPlastik = 0;
                                    foreach ($this->data["SaleDetail"] as $k => $saleDetail) {
                                        $totalMC = ceil(@$saleDetail["quantity"] * @$saleDetail["McUsage"]["ProductMaterialAdditional"]["quantity"]);
                                        $totalPlastic = ceil(@$saleDetail["nett_weight"] * @$saleDetail["PlasticUsage"]["ProductMaterialAdditional"]["quantity"]);
                                        $grandTotalMc+=$biayaMC = @$saleDetail["McUsage"]["MaterialAdditional"]["price"] * $totalMC;
                                        $grandTotalPlastik+=$biayaPlastic = @$saleDetail["PlasticUsage"]["MaterialAdditional"]["price"] * $totalPlastic;
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $k + 1 ?></td>
                                            <td class="text-left"><?= $saleDetail["Product"]["Parent"]["name"] ?> - <?= $saleDetail["Product"]["name"] ?></td>
                                            <td class="text-<?= empty($saleDetail["McUsage"]["MaterialAdditional"]["name"]) ? "center" : "left" ?>"><?= emptyToStrip(@$saleDetail["McUsage"]["MaterialAdditional"]["name"]) ?></td>
                                            <td class="text-right"><?= ic_decimalseperator($totalMC) ?></td>
                                            <td class="text-right"><?= ic_rupiah(@$saleDetail["McUsage"]["MaterialAdditional"]["price"]) ?></td>
                                            <td class="text-right"><?= ic_rupiah($biayaMC) ?></td>
                                            <td class="text-<?= empty($saleDetail["PlasticUsage"]["MaterialAdditional"]["name"]) ? "center" : "left" ?>"><?= emptyToStrip(@$saleDetail["PlasticUsage"]["MaterialAdditional"]["name"]) ?></td>
                                            <td class="text-right"><?= ic_decimalseperator($totalPlastic) ?></td>
                                            <td class="text-right"><?= ic_rupiah(@$saleDetail["PlasticUsage"]["MaterialAdditional"]["price"]) ?></td>
                                            <td class="text-right"><?= ic_rupiah($biayaPlastic) ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="10" style="height:5px;padding:0"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" colspan="5">Total Biaya Pemakaian MC</td>
                                        <td class="text-right"><?= ic_rupiah($grandTotalMc)?></td>
                                        <td class="text-center" colspan="3">Total Biaya Pemakaian Plastik</td>
                                        <td class="text-right"><?= ic_rupiah($grandTotalPlastik)?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="10" style="height:5px;padding:0"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" colspan="9">Total Biaya Keseluruhan</td>
                                        <td class="text-right"><?= ic_rupiah($grandTotalPlastik+$grandTotalMc)?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</div>