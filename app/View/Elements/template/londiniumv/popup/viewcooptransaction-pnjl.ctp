<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Transaksi Koperasi</h4>
</div>
<div class="panel">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">DATA PENJUALAN KOPERASI
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-file6"></i> Data Penjualan</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-coin"></i> Rincian Harga Barang</a></li>
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="justified-pill1">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Operator.Account.Biodata.first_name", __("Pegawai Pelaksana"), array("class" => "col-md-4 control-label"));
                                                    echo $this->Form->input("Operator.Account.Biodata.first_name", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Operator.nip", __("NIK Pelaksana"), array("class" => "col-md-4 control-label"));
                                                    echo $this->Form->input("Operator.nip", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
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
                                                    echo $this->Form->label("CooperativeCashReceipt.reference_number", __("Nomor Transaksi"), array("class" => "col-md-4 control-label"));
                                                    echo $this->Form->input("CooperativeCashReceipt.reference_number", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("CooperativeCashReceipt.date__ic", __("Tanggal Transaksi"), array("class" => "col-md-4 control-label"));
                                                    echo $this->Form->input("CooperativeCashReceipt.date__ic", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
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
                                                    echo $this->Form->label("CooperativePaymentType.name", __("Jenis Pembayaran"), array("class" => "col-md-4 control-label"));
                                                    echo $this->Form->input("CooperativePaymentType.name", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("CooperativeCashReceipt.grand_total__ic", __("Total Transaksi"), array("class" => "col-md-4 control-label"));
                                                    echo $this->Form->input("CooperativeCashReceipt.grand_total__ic", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control rupiah-field", " disabled", "type" => "text"));
                                                    ?>
                                                </div>
                                            </div>
                                        </div>                                
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="row">
                                            <?php
                                            if ($this->data["CooperativeCashReceipt"]["cooperative_payment_type_id"] == 1) {
                                                ?>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("CooperativeCash.name", __("Kas Tujuan"), array("class" => "col-md-4 control-label"));
                                                        echo $this->Form->input("CooperativeCash.name", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("EmployeeDataLoan.receipt_loan_number", __("Nomor Kredit"), array("class" => "col-md-4 control-label"));
                                                        echo $this->Form->input("EmployeeDataLoan.receipt_loan_number", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
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
                                                <?= $this->data["CooperativeCashReceipt"]["note"] ?>
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
                                    <th width="150" colspan="2">Harga Satuan</th>
                                    <th width="135" colspan="2">Diskon</th>
                                    <th width="190" colspan="2">Total</th>
                                </tr>
                            <thead>
                            <tbody id="target-detail-kas-keluar">
                                <?php
                                foreach ($this->data["CooperativeCashReceiptDetail"] as $k => $cooperativeCashReceiptDetail) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $k + 1 ?></td>
                                        <td>
                                            <?= $cooperativeCashReceiptDetail['CooperativeGoodList']['name'] ?>
                                        </td>
                                        <td class="text-right" style="border-right-style:none; width:75px;">
                                            <?= ic_decimalseperator($cooperativeCashReceiptDetail['quantity']) ?>
                                        </td> 
                                        <td class = "text-left" style= "width:75px; border-left-style:none;">
                                            <?= $cooperativeCashReceiptDetail['CooperativeGoodList']['CooperativeGoodListUnit']['name'] ?>
                                        </td>  
                                        <td class="text-center" style= "width:50px; border-right-style:none;">           
                                            Rp.
                                        </td>    
                                        <td class = "text-right" style="border-left-style:none; width: 120px;">
                                            <?= ic_rupiah($cooperativeCashReceiptDetail['price']) ?>
                                        </td>
                                        <td class="text-right" style="border-right-style:none;">
                                            <?= $cooperativeCashReceiptDetail['discount'] ?>
                                        </td> 
                                        <td class = "text-left" style= "width:30px; border-left-style:none;">
                                            %
                                        </td>  
                                        <td class="text-center" style= "width:50px; border-right-style:none;">           
                                            Rp.
                                        </td>    
                                        <td class = "text-right" style="border-left-style:none; width: 120px;">
                                            <?= ic_rupiah($cooperativeCashReceiptDetail['total_amount']) ?>
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
                                        <?= $this->data['CooperativeCashReceipt']['discount'] ?>  %
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
                                        <?= ic_rupiah($this->data['CooperativeCashReceipt']['grand_total']) ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
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
