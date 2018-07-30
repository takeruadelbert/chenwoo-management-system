
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Transaksi Koperasi</h4>
</div>
<!-- New invoice template -->
<div class="panel form-horizontal">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">DATA PENGELUARAN
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#data-pinjaman" data-toggle="tab"><i class="icon-file6"></i> Data Pengeluaran</a></li>
                    <li><a href="#data-angsuran" data-toggle="tab"><i class="icon-coin"></i> Rincian Pengeluaran</a></li>
                </ul>   
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="data-pinjaman">
                        <table width="100%" class="table table-hover">
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Creator.Account.Biodata.first_name", __("Pegawai Pelaksana"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Creator.Account.Biodata.first_name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Creator.nip", __("NIK Pelaksana"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Creator.nip", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
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
                                                echo $this->Form->label("CooperativeCashOut.cash_out_number", __("Nomor Transaksi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("CooperativeCashOut.cash_out_number", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
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
                                                echo $this->Form->label("CooperativeCashOut.created_datetime__ic", __("Waktu Transaksi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("CooperativeCashOut.created_datetime__ic", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("CooperativeCashOut.created__ic", __("Waktu Input"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("CooperativeCashOut.created__ic", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                    </div>                                
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("CooperativeCash.name", __("Kas Asal"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("CooperativeCash.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("CooperativeCashOut.amount__ic", __("Jumlah Pengeluaran"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("CooperativeCashOut.amount__ic", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control text-right rupiah-field", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group" >
                                        <div class="text-center">
                                            Keterangan
                                        </div>
                                        <hr/>    
                                        <div id="note" style="padding:0 15px">
                                            <?= $this->data["CooperativeCashOut"]["note"] ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>                                
                    <div class="tab-pane fade" id="data-angsuran">
                        <table class="table table-hover table-bordered stn-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Pengeluaran</th>
                                    <th width="175">Tanggal</th>
                                    <th width="100">Bukti</th>
                                    <th width="225">Nominal</th>
                                </tr>
                            <thead>
                            <tbody id="target-detail-kas-keluar">
                                <?php
                                foreach ($this->data["CooperativeCashOutDetail"] as $k => $cooperativeCashOutDetail) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $k + 1 ?></td>
                                        <td>
                                            <?= $this->Form->input("CooperativeCashOutDetail.$k.uraian", array("div" => false, "label" => false, "class" => "form-control", "disabled")) ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("CooperativeCashOutDetail.$k.date__ic", array("div" => false, "label" => false, "class" => "form-control", "disabled")) ?>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            if (empty($cooperativeCashOutDetail['AssetFile']['id'])) {
                                                ?>
                                                Tidak ada file
                                                <?php
                                            } else {
                                                ?>
                                                <a href ="<?= Router::url("/admin/AssetFiles/getfile/" . $cooperativeCashOutDetail['AssetFile']['id'] . "/" . $cooperativeCashOutDetail['AssetFile']['token']) ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" name = "Download" value = "Download" title="Download Bukti"><i class="icon-download"></i></button></a>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("CooperativeCashOutDetail.$k.amount__ic", array("div" => false, "label" => false, "class" => "form-control text-right rupiah-field", "disabled")) ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" align="right">
                                        <strong>Grand Total</strong>
                                    </td>
                                    <td>
                                        <?= $this->Form->input("CooperativeCashOut.amount__ic", array("div" => false, "label" => false, "class" => "form-control text-right rupiah-field", "disabled")) ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>                                
            </div>                                
        </div>                                
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
</div>