<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Transaksi Koperasi</h4>
</div>
<!-- New invoice template -->
<div class="panel">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">TRANSAKSI PEMBELIAN KOPERASI
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-file6"></i> Data Pembelian</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-coin"></i> Rincian Biaya Pembelian</a></li>
                    <li><a href="#bukti-pembelian" data-toggle="tab"><i class="icon-file"></i> Bukti Pembelian</a></li>
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="justified-pill1">
                        <table width="100%" class="table table-hover">
                            <tbody>

                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Creator.Account.Biodata.full_name", __("Dibuat Oleh"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Creator.Account.Biodata.full_name", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Creator.nip", __("NIK"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Creator.nip", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CooperativeCashDisbursement.cash_disbursement_number", __("Nomor Transaksi"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashDisbursement.cash_disbursement_number", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("CooperativeCashDisbursement.created_date__ic", __("Tanggal Dibuat"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashDisbursement.created_date__ic", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control datepicker", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">     
                                            <?php
                                            echo $this->Form->label("CooperativeCash.name", __("Kas Asal"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCash.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?> 
                                            <?php
                                            echo $this->Form->label("CooperativeCashDisbursement.grand_total__ic", __("Total Transaksi"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashDisbursement.grand_total__ic", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control text-right rupiah-field", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">     
                                            <?php
                                            echo $this->Form->label("CooperativeSupplier.name", __("Supplier"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeSupplier.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?> 
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group" >
                                            <div class="text-center">
                                                <b>Keterangan</b>
                                            </div>
                                            <hr/>    
                                            <div id="note" style="padding:0 15px">
                                                <?= $this->data["CooperativeCashDisbursement"]["note"] ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>                    
                    <div class="tab-pane fade" id="justified-pill3">
                        <table class="table table-hover table-bordered stn-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Barang</th>
                                    <th width="175" colspan="2">Jumlah</th>
                                    <th width="190" colspan="2">Harga Satuan</th>
                                    <th width="135" colspan="2">Diskon</th>
                                    <th width="190" colspan="2">Total</th>
                                </tr>
                            <thead>
                            <tbody id="target-detail-kas-keluar">
                                <?php
                                foreach ($this->data["CooperativeCashDisbursementDetail"] as $k => $cooperativeCashDisbursementDetail) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $k + 1 ?></td>
                                        <td>
                                            <?= $cooperativeCashDisbursementDetail['CooperativeGoodList']['name'] ?>
                                        </td>
                                        <td class="text-right" style="border-right-style:none; width:75px;">
                                            <?= ic_decimalseperator($cooperativeCashDisbursementDetail['quantity']) ?>
                                        </td> 
                                        <td class = "text-left" style= "width:75px; border-left-style:none;">
                                            <?= $cooperativeCashDisbursementDetail['CooperativeGoodList']['CooperativeGoodListUnit']['name'] ?>
                                        </td>
                                        <td class="text-center" style= "width:50px; border-right-style:none;">           
                                            Rp.
                                        </td>    
                                        <td class = "text-right" style="border-left-style:none; width: 120px;">
                                            <?= ic_rupiah($cooperativeCashDisbursementDetail['amount']) ?>
                                        </td>
                                        <td class="text-right" style="border-right-style:none;">
                                            <?= $cooperativeCashDisbursementDetail['discount'] ?>
                                        </td> 
                                        <td class = "text-left" style= "width:30px; border-left-style:none;">
                                            %
                                        </td>  
                                        <td class="text-center" style= "width:50px; border-right-style:none;">           
                                            Rp.
                                        </td>    
                                        <td class = "text-right" style="border-left-style:none; width: 120px;">
                                            <?= ic_rupiah($cooperativeCashDisbursementDetail['total_amount']) ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8" align="right">
                                        <strong>Diskon</strong>
                                    </td>
                                    <td colspan="2" class = "text-right" style= "width:50px; border-left-style:none;">
                                        <?= $this->data['CooperativeCashDisbursement']['discount'] ?>  %
                                    </td> 
                                </tr>
                                <tr>
                                    <td colspan="8" align="right">
                                        <strong>Grand Total</strong>
                                    </td>
                                    <td class="text-center" style= "width:50px; border-right-style:none;">           
                                        Rp.
                                    </td>    
                                    <td class = "text-right" style="border-left-style:none; width: 120px;">
                                        <?= ic_rupiah($this->data['CooperativeCashDisbursement']['grand_total']) ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="bukti-pembelian">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="block-inner text-danger">
                                    <h6 class="heading-hr"><?= __("Preview Bukti Pembelian") ?>
                                    </h6>
                                    <?php
                                    if (!empty($this->data["CooperativeCashDisbursement"]["asset_file_id"])) {
                                        if (in_array($this->data["AssetFile"]["ext"], ["jpg", "png"])) {
                                            ?>
                                            <div class="text-center">
                                                <img style="max-width:100%" src="<?= Router::url("/admin/asset_files/getfile/{$this->data["AssetFile"]["id"]}/{$this->data["AssetFile"]["token"]}?dl=0", true) ?>"/>
                                            </div>
                                            <?php
                                        } else if ($this->data["AssetFile"]["ext"] == "pdf") {
                                            ?>
                                            <object width="100%" height="800px" data="<?= Router::url("/admin/asset_files/getfile/{$this->data["AssetFile"]["id"]}/{$this->data["AssetFile"]["token"]}?dl=0", true) ?>" type="application/pdf">
                                                Browser anda tidak mensupport PDF reader, <a href="<?= Router::url("/admin/asset_files/getfile/{$this->data["AssetFile"]["id"]}/{$this->data["AssetFile"]["token"]}", true) ?>">klik disini untuk download</a>
                                            </object>
                                            <?php
                                        } else {
                                            ?>
                                            Lampiran tidak dapat dipreview, <a href="<?= Router::url("/admin/asset_files/getfile/{$this->data["AssetFile"]["id"]}/{$this->data["AssetFile"]["token"]}?dl=1", true) ?>">klik disini untuk download</a>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        Tidak ada lampiran
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- /new invoice template -->
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
        </div>
    </div>
</div>