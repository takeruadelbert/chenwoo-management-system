
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Transaksi Koperasi</h4>
</div>
<!-- New invoice template -->
<div class="panel form-horizontal">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">DATA PINJAMAN PEGAWAI
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#data-pinjaman" data-toggle="tab"><i class="icon-file6"></i> Data Pinjaman</a></li>
                    <li><a href="#data-angsuran" data-toggle="tab"><i class="icon-coin"></i> Data Angsuran</a></li>
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
                                                echo $this->Form->label("EmployeeDataLoan.receipt_loan_number", __("Nomor Transaksi"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataLoan.receipt_loan_number", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("VerifyStatus.name", __("Status"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("VerifyStatus.name", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
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
                                                echo $this->Form->label("Employee.Account.Biodata.first_name", __("Pegawai Peminjam"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Employee.Account.Biodata.first_name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Employee.nip", __("NIK Peminjam"), array("class" => "col-sm-3 col-md-4 control-label"));
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
                                                echo $this->Form->label("EmployeeDataLoan.date__ic", __("Waktu Peminjaman"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataLoan.date__ic", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("EmployeeDataLoan.created__ic", __("Waktu Input"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataLoan.created__ic", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
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
                                                echo $this->Form->label("CooperativeLoanType.name", __("Jenis Peminjaman"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("CooperativeLoanType.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("EmployeeDataLoan.amount_loan__ic", __("Jumlah Pinjaman"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataLoan.amount_loan__ic", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control text-right rupiah-field", " disabled", "type" => "text"));
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
                                                echo $this->Form->label("EmployeeDataLoan.interest_rate", __("Bunga Pinjaman"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataLoan.interest_rate", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control text-right persen-field", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("EmployeeDataLoan.total_amount_loan__ic", __("Jumlah Tanggungan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataLoan.total_amount_loan__ic", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control text-right rupiah-field", " disabled", "type" => "text"));
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
                                                echo $this->Form->label("EmployeeDataLoan.installment_number", __("Tenor"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataLoan.installment_number", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control text-right tenor-field", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("EmployeeDataLoan.remaining_loan__ic", __("Sisa Pembayaran"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataLoan.remaining_loan__ic", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control text-right rupiah-field", " disabled", "type" => "text"));
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
                                            <b>Keterangan</b>
                                        </div>
                                        <hr/>    
                                        <div id="note" style="padding:0 15px">
                                            <?= $this->data["EmployeeDataLoan"]["note"] ?>
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
                                    <th>Nomor Kwintansi</th>
                                    <th width="200" colspan="2">Nominal Pembayaran</th>
                                    <th width="150">Tanggal Pembayaran</th>
                                    <th width="150">Sisa Pinjaman</th>
                                </tr>
                            <thead>
                            <tbody id="target-detail-kas-keluar">
                                <?php
                                if (!empty($this->data["EmployeeDataLoanDetail"])) {
                                    foreach ($this->data["EmployeeDataLoanDetail"] as $k => $employeeDataLoanDetail) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $k + 1 ?></td>
                                            <td>
                                                <?= $employeeDataLoanDetail['coop_receipt_number'] ?>
                                            </td>
                                            <td class="text-center" style= "width:50px; border-right-style:none;">           
                                                Rp.
                                            </td>    
                                            <td class = "text-right" style="border-left-style:none; width: 120px;">
                                                <?= ic_rupiah($employeeDataLoanDetail['amount']) ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $this->Html->cvtTanggal($employeeDataLoanDetail['paid_date'], false) ?>
                                            </td>
                                            <td class="text-center" style="background-color:<?= ($employeeDataLoanDetail['remaining_loan'] <= 0)?"rgb(51,103,214)":"white"?>;color:<?= ($employeeDataLoanDetail['remaining_loan'] <= 0)?"white":"black"?>">
                                                <?= ($employeeDataLoanDetail['remaining_loan'] <= 0)?"Lunas":ic_rupiah($employeeDataLoanDetail['remaining_loan']); ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            Belum ada angsuran.
                                        </td>
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
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
</div>