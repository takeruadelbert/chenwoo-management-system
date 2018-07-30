<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Transaksi Kas Keluar</h4>
</div>
<div class="panel">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">DATA TRANSAKSI KAS KELUAR
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-file"></i> Data Kas Keluar</a></li>
                    <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-file6"></i>Rincian Biaya Pengeluaran</a></li>
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="justified-pill1">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CashDisbursement.cash_disbursement_number", __("Nomor Kas Keluar"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CashDisbursement.cash_disbursement_number", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("CashDisbursement.created_datetime", __("Tanggal Dibuat"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CashDisbursement.created_datetime", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control datepicker", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">                                            
                                            <?php
                                            echo $this->Form->label("Creator.Account.Biodata.full_name", __("Dibuat Oleh"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Creator.Account.Biodata.full_name", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Creator.Office.name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Creator.Office.name", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">     
                                            <?php
                                            echo $this->Form->label("InitialBalance.GeneralEntryType.name", __("Kas yang digunakan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("InitialBalance.GeneralEntryType.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("GeneralEntryType.name", __("Jenis Pengeluaran"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("GeneralEntryType.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", 'disabled'));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                if ($this->data['CashDisbursement']['transaction_currency_type_id'] == 2) {
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <div class="col-md-2 control-label">
                                                    <label>Kurs</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">Rp.</button>
                                                        </span>
                                                        <input type="text" class="form-control text-right" disabled value="<?= ic_rupiah($this->data['CashDisbursement']['exchange_rate']) ?>">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">,00.</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CashDisbursement.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->label("CashDisbursement.note", __($this->data['CashDisbursement']['note']) , array("class" => "col-sm-10"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>                    
                    <div class="tab-pane fade" id="justified-pill2">
                        <table class="table table-hover table-bordered stn-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Uraian</th>
                                    <th>Nominal</th>
                                    <th>Tanggal</th>
                                    <th width="50">Bukti</th>
                                </tr>
                            <thead>
                            <tbody id="target-detail-kas-keluar">
                                <?php
                                $index = 1;
                                foreach ($this->data['CashDisbursementDetail'] as $i => $details) {
                                ?>
                                <tr>
                                    <td class="text-center nomorIdx">
                                        <?= $index ?>
                                    </td>
                                    <td>
                                        <?= $this->Form->input("CashDisbursementDetail.$i.name", array("div" => false, "label" => false, "class" => "form-control", "disabled")) ?>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button"><?= $this->data['CashDisbursement']['transaction_currency_type_id'] == 1 ? "Rp." : "$" ?></button>
                                            </span>
                                            <input type="text" class="form-control text-right" disabled value="<?= $this->data['CashDisbursement']['transaction_currency_type_id'] == 1 ? ic_rupiah($details['amount']) : ac_dollar($details['amount']) ?>">
                                            <?php
                                            if($this->data['CashDisbursement']['transaction_currency_type_id'] == 1) {
                                            ?>
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">,00.</button>
                                            </span>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?= $this->Form->input("CashDisbursementDetail.$i.date", array("div" => false, "label" => false, "class" => "form-control datepicker text-right", "type" => "text", "disabled")) ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if(!empty($details['asset_file_id'])) {
                                        ?>
                                        <a href ="<?= Router::url("/admin/AssetFiles/getfile/{{assetId}}/{{token}}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" name = "Download" value = "Download" title="Download Bukti Bayar"><i class="icon-download"></i></button></a>
                                        <?php
                                        } else {
                                            echo "-";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                    $index++;
                                }
                                ?>
                            </tbody>
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
<script>
    $(document).ready(function() {
       reloadDatePicker(); 
    });
    </script>