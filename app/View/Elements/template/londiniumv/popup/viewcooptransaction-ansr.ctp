
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Transaksi Koperasi</h4>
</div>
<!-- New invoice template -->
<div class="panel form-horizontal">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">DATA ANGUSRAN PEGAWAI
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li  class="active"><a href="#data-angsuran" data-toggle="tab"><i class="icon-coin"></i> Data Angsuran</a></li>
                    <li><a href="#data-pinjaman" data-toggle="tab"><i class="icon-file6"></i> Data Pinjaman</a></li>
                </ul>   
                <div class="tab-content pill-content">
                    <div class="tab-pane fade" id="data-pinjaman">
                        <table width="100%" class="table table-hover">
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("EmployeeDataLoan.Creator.Account.Biodata.first_name", __("Pegawai Pelaksana"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataLoan.Creator.Account.Biodata.first_name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("EmployeeDataLoan.Creator.nip", __("NIK Pelaksana"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataLoan.Creator.nip", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
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
                                                echo $this->Form->label("EmployeeDataLoan.VerifyStatus.name", __("Status"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataLoan.VerifyStatus.name", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
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
                                                echo $this->Form->label("EmployeeDataLoan.Employee.Account.Biodata.first_name", __("Pegawai Peminjam"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataLoan.Employee.Account.Biodata.first_name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("EmployeeDataLoan.Employee.nip", __("NIK Peminjam"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataLoan.Employee.nip", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
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
                                                echo $this->Form->label("EmployeeDataLoan.CooperativeLoanType.name", __("Jenis Peminjaman"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataLoan.CooperativeLoanType.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
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
                    <div class="tab-pane fade in active" id="data-angsuran">
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
                                                echo $this->Form->label("EmployeeDataLoanDetail.coop_receipt_number", __("Nomor Angsuran"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataLoanDetail.coop_receipt_number", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("EmployeeDataLoanDetail.created__ic", __("Waktu Input"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataLoanDetail.created__ic", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
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
                                                echo $this->Form->label("EmployeeDataLoanDetail.paid_date__ic", __("Tanggal Pembayaran"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataLoanDetail.paid_date__ic", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("EmployeeDataLoanDetail.due_date__ic", __("Tanggal Jatuh Tempo"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataLoanDetail.due_date__ic", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
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
                                                echo $this->Form->label("EmployeeDataLoanDetail.installment_of", __("Angsuran Ke"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataLoanDetail.installment_of", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("EmployeeDataLoanDetail.amount__ic", __("Jumlah Pembayaran"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("EmployeeDataLoanDetail.amount__ic", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control rupiah-field", " disabled", "type" => "text"));
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
                                            <?= $this->data["EmployeeDataLoanDetail"]["note"] ?>
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