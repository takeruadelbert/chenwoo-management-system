<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Transaksi Koperasi</h4>
</div>
<div class="panel form-horizontal">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">DATA PENARIKAN SIMPANAN PEGAWAI
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-user4"></i>Data Pegawai</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-file"></i>Data Penarikan</a></li>
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="justified-pill1">
                        <table width="100%" class="table table-hover">
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Employee.Account.Biodata.first_name", __("Nama Pegawai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Employee.Account.Biodata.first_name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Employee.nip", __("NIK"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Employee.nip", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
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
                                                echo $this->Form->label("Employee.Department.name", __("Departemen"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Employee.Department.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Employee.Office.name", __("Jabatan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Employee.Office.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
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
                                                echo $this->Form->label("EmployeeBalance.account_number", __("No Rekening Simpanan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeBalance.account_number", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("EmployeeDataDeposit.deposit_previous_balance__ic", __("Saldo Simpanan Sebelum Penarikan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataDeposit.deposit_previous_balance__ic", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control rupiah-field text-right", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                    </div>                                
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="justified-pill3">
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
                                                echo $this->Form->label("VerifiedBy.Account.Biodata.first_name", __("Pegawai Verifikasi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("VerifiedBy.Account.Biodata.first_name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("VerifiedBy.nip", __("NIK Pegawai Verifikasi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("VerifiedBy.nip", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
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
                                                echo $this->Form->label("EmployeeDataDeposit.id_number", __("Nomor Transaksi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataDeposit.id_number", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("VerifyStatus.name", __("Status"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("VerifyStatus.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
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
                                                echo $this->Form->label("EmployeeDataDeposit.transaction_date__ic", __("Waktu Transaksi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataDeposit.transaction_date__ic", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("EmployeeDataDeposit.created__ic", __("Waktu Input"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataDeposit.created__ic", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
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
                                                echo $this->Form->label("EmployeeDataDeposit.amount__ic", __("Jumlah Penarikan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataDeposit.amount__ic", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control text-right rupiah-field", " disabled", "type" => "text"));
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
                                            <b> Keterangan </b>
                                        </div>
                                        <hr/>    
                                        <div id="note" style="padding:0 15px">
                                            <?= $this->data["EmployeeDataDeposit"]["note"] ?>
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
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
</div>