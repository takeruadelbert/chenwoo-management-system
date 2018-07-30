<?php echo $this->Form->create("CooperativeCashOut", array("class" => "form-horizontal form-separate", "type" => "file", "action" => "view", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Lihat Kas Keluar Koperasi") ?>                
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <!-- Justified pills -->
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-mail-send"></i> Data Pembelian Barang</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-file6"></i> Rincian Biaya Pengeluaran</a></li>                    
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="justified-pill1">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CooperativeCashOut.cash_out_number", __("Nomor Kas Keluar"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashOut.cash_out_number", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "value" => $this->data['CooperativeCashOut']['cash_out_number'], "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("CooperativeCashOut.created_datetime", __("Waktu Dibuat"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashOut.created_datetime", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control datetime", "value" => $this->data['CooperativeCashOut']['created_datetime'], "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">                                            
                                            <?php
                                            echo $this->Form->label("CooperativeCashOut.creator_id", __("Dibuat Oleh"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashOut.creator_id", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "value" => $this->Session->read("credential.admin.Biodata.full_name"), "disabled"));
                                            echo $this->Form->input("CooperativeCashOut.creator_id", array("type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.position", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.position", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "value" => $this->Session->read("credential.admin.Employee.Office.name"), "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">     
                                            <?php
                                            echo $this->Form->label("CooperativeCashOut.cooperative_cash_id", __("Kas Asal"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashOut.cooperative_cash_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    Keterangan
                                                </div>
                                                <hr/>
                                                <?= $this->data["CooperativeCashOut"]["note"] ?>
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
                                    <th width="3%">No</th>
                                    <th>Pengeluaran</th>
                                    <th width="25%">Nominal</th>
                                    <th width="20%">Tanggal</th>
                                    <th width="5%">Bukti</th>
                                </tr>
                            <thead>
                            <tbody id="target-detail-kas-keluar">
                                <?php
                                $i = 1;
                                foreach ($this->data['CooperativeCashOutDetail'] as $k => $details) {
                                    ?>
                                    <tr>
                                        <td class="text-center nomorIdx">
                                            <?= $i ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("CooperativeCashOutDetail.$k.ExpenditureType.name", ["div" => false, "label" => false, "class" => "form-control", "disabled"]) ?>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon">Rp.</span>
                                                <input type="text" class="form-control text-right isdecimal" name="data[CooperativeCashOutDetail][0][amount]" readonly value="<?= $details['amount'] ?>">
                                                <span class="input-group-addon">,00.</span>
                                            </div>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("CooperativeCashOutDetail.$k.date", ["type" => "text", "div" => false, "label" => false, "class" => "form-control datepicker", "value" => $details['date'], "disabled"]) ?>
                                        </td>
                                        <td>
                                            <?php
                                            if (empty($details['AssetFile']['id'])) {
                                                ?>
                                                Tidak ada file
                                                <?php
                                            } else {
                                                ?>
                                                <a href ="<?= Router::url("/admin/AssetFiles/getfile/" . $details['AssetFile']['id'] . "/" . $details['AssetFile']['token']) ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" name = "Download" value = "Download" title="Download Bukti"><i class="icon-download"></i></button></a>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /justified pills -->
        <div class="text-center">
            <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>