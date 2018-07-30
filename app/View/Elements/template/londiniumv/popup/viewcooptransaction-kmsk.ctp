
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Transaksi Koperasi</h4>
</div>
<!-- New invoice template -->
<div class="panel form-horizontal">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">DATA PEMASUKAN
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="well block">
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
                                            echo $this->Form->label("CooperativeCashIn.cash_in_number", __("Nomor Transaksi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("CooperativeCashIn.cash_in_number", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
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
                                            echo $this->Form->label("CooperativeCashIn.created_datetime__ic", __("Waktu Transaksi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("CooperativeCashIn.created_datetime__ic", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CooperativeCashIn.created__ic", __("Waktu Input"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("CooperativeCashIn.created__ic", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
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
                                            echo $this->Form->label("CooperativeCashIn.amount__ic", __("Jumlah Pemasukan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("CooperativeCashIn.amount__ic", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control text-right rupiah-field", " disabled", "type" => "text"));
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
                                        <?= $this->data["CooperativeCashIn"]["note"] ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>       
            </div>                              
        </div>                                
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
</div>