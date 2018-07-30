<?php echo $this->Form->create("EmployeeDataLoanDetail", array("class" => "form-horizontal form-separate", "action" => "edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Ubah Data Transaksi Angsuran") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>

                <div class="well block">
                    <div class="tabbable">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-user4"></i>Data Pegawai</a></li>
                            <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-menu2"></i>Data Jenis Angsuran</a></li>
                            <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-file"></i>Data Jenis Pembayaran</a></li>
                        </ul>
                        <div class="tab-content pill-content">
                            <div class="tab-pane fade in active" id="justified-pill1">
                                <div class="hidden nHolder" data-n="0"></div>
                                <div class="table-responsive">
                                    <table width="100%" class="table">
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php
                                                            echo $this->Form->label("Dummy.nomor_pinjaman", __("Nomor Pinjaman"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Dummy.nomor_pinjaman", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['EmployeeDataLoan']['receipt_loan_number']));
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
                                                            echo $this->Form->label("Dummy.name", __("Nama Pegawai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Dummy.name", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['EmployeeDataLoan']['Employee']['Account']['Biodata']['full_name']));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                    
                                                            <?php
                                                            echo $this->Form->label("Dummy.nip", __("NIP"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Dummy.nip", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['EmployeeDataLoan']['Employee']['nip']));
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
                                                            echo $this->Form->label("Dummy.department", __("Departemen"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Dummy.department", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "value" => $this->data['EmployeeDataLoan']['Employee']['Department']['name'], "disabled"));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                    
                                                            <?php
                                                            echo $this->Form->label("Dummy.office", __("Jabatan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Dummy.office", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "value" => $this->data['EmployeeDataLoan']['Employee']['Office']['name'], "disabled"));
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>                                
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="justified-pill2">
                                <table width="100%" class="table">
                                    <tr>
                                        <td colspan="3" style="width:200px">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="col-sm-3 col-md-4 control-label">
                                                            <label>Jenis Angsuran</label>
                                                        </div>
                                                        <div class="col-sm-9 col-md-8">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control text-right" id="totalInstallment" value="<?= $this->data['EmployeeDataLoan']['installment_number'] ?>" disabled>
                                                                <span class="input-group-addon"><strong>kali</strong></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="col-sm-3 col-md-4 control-label">
                                                            <label>Bunga (Jasa)</label>
                                                        </div>
                                                        <div class="col-sm-9 col-md-8">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control text-right" id="interest" value="<?= $this->data['EmployeeDataLoan']['CooperativeLoanInterest']['interest'] ?>" disabled>
                                                                <span class="input-group-addon"><strong>%</strong></span>
                                                            </div>
                                                        </div>
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
                                                        <div class="col-sm-3 col-md-4 control-label">
                                                            <label>Jumlah Angsuran Sekarang</label>
                                                        </div>
                                                        <div class="col-sm-9 col-md-8">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control text-right" id="currentInstallment" value="<?= $this->data['EmployeeDataLoan']['total_installment_paid'] ?>" disabled>
                                                                <span class="input-group-addon"><strong>kali</strong></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">                                    
                                                        <?php
                                                        echo $this->Form->label("EmployeeDataLoan.date", __("Tanggal Pinjam"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("EmployeeDataLoan.date", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Html->cvtTanggal($this->data['EmployeeDataLoan']['date'])));
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
                                                        <div class="col-sm-3 col-md-4 control-label">
                                                            <label>Jumlah Pinjaman</label>
                                                        </div>
                                                        <div class="col-sm-9 col-md-8">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><strong>Rp.</strong></span>
                                                                <input type="text" class="form-control text-right" id="amountLoan"  value="<?= $this->Html->Rp($this->data['EmployeeDataLoan']['amount_loan']) ?>" disabled>
                                                                <span class="input-group-addon"><strong>,00.</strong></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="col-sm-3 col-md-4 control-label">
                                                            <label>Total Pinjaman</label>
                                                        </div>
                                                        <div class="col-sm-9 col-md-8">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><strong>Rp.</strong></span>
                                                                <input type="text" class="form-control text-right" readonly id="totalAmountLoan" name="data[EmployeeDataLoanDetail][total_amount_loan]" value=" <?= $this->Html->Rp($this->data['EmployeeDataLoanDetail']['total_amount_loan']) ?>">
                                                                <span class="input-group-addon"><strong>,00.</strong></span>
                                                            </div>
                                                        </div>
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
                                                        <div class="col-sm-3 col-md-4 control-label">
                                                            <label>Sisa Pinjaman</label>
                                                        </div>
                                                        <div class="col-sm-9 col-md-8">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><strong>Rp.</strong></span>
                                                                <input type="text" class="form-control text-right" id="remainingLoan" readonly name="data[EmployeeDataLoanDetail][remaining_loan]"  value="<?= $this->data['EmployeeDataLoanDetail']['remaining_loan'] ?>">
                                                                <span class="input-group-addon"><strong>,00.</strong></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="justified-pill3">
                                <table width="100%" class="table">
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("EmployeeDataLoanDetail.coop_receipt_number", __("Nomor Kwitansi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("EmployeeDataLoanDetail.coop_receipt_number", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">                                    
                                                        <?php
                                                        echo $this->Form->label("EmployeeDataLoanDetail.paid_date", __("Tanggal Bayar"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("EmployeeDataLoanDetail.paid_date", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "value" => date("Y-m-d"), "disabled"));
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
                                                        <div class="col-sm-3 col-md-4 control-label">
                                                            <label>Biaya Angsuran Bulan Ini</label>
                                                        </div>
                                                        <div class="col-sm-9 col-md-8">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><strong>Rp.</strong></span>
                                                                <input type="text" class="form-control text-right" value="<?= $this->Html->Rp($this->data['EmployeeDataLoanDetail']['amount']) ?>" disabled>
                                                                <span class="input-group-addon"><strong>,00.</strong></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("EmployeeDataLoanDetail.due_date", __("Tanggal Jatuh Tempo"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("EmployeeDataLoanDetail.due_date", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "disabled"));
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("EmployeeDataLoanDetail.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("EmployeeDataLoanDetail.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix"));
                                                ?>
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
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive stn-table">
                    <div class="panel-heading" style="background:#2179cc">
                        <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Angsuran") ?></h6>
                    </div>
                    <br>
                    <table width="100%" class="table table-hover table-bordered">                        
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th><?= __("Nomor Kwitansi") ?></th>
                                <th><?= __("Nominal Pembayaran") ?></th>
                                <th><?= __("Tanggal Jatuh Tempo") ?></th>
                                <th><?= __("Tanggal Pembayaran") ?></th>
                            </tr>
                        </thead>
                        <tbody id="target-installment">
                            <?php
                            $i = 1;
                            $count = 0;
                            $totalIncome = 0;
                            if (!empty($this->data['EmployeeDataLoan']['EmployeeDataLoanDetail'])) {
                                foreach ($this->data['EmployeeDataLoan']['EmployeeDataLoanDetail'] as $k => $loans) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?></td>
                                        <td class="text-center"><?= $loans['EmployeeDataLoan']['EmployeeDataLoanDetail'][$count]['coop_receipt_number'] ?></td>        
                                        <td class="text-center"><?= $this->Html->IDR($loans['EmployeeDataLoan']['EmployeeDataLoanDetail'][$count]['amount']) ?></td>
                                        <td class="text-center"><?= $this->Html->cvtTanggal($loans['EmployeeDataLoan']['EmployeeDataLoanDetail'][$count]['due_date']) ?></td>
                                        <td class="text-center"><?= $this->Html->cvtTanggal($loans['EmployeeDataLoan']['EmployeeDataLoanDetail'][$count]['paid_date']) ?></td>
                                    </tr>
                                    <?php
                                    $count++;
                                    $i++;
                                }
                            } else {
                                ?>
                                <tr id="init">
                                    <td class = "text-center" colspan = 5>Tidak Ada Data</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <div class="form-actions text-center">
                        <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                        <input type="reset" value="Reset" class="btn btn-info">
                        <button class="btn btn-danger" data-toggle="modal" data-target="#edit" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_edit', true); ?>">
                            <?= __("Simpan") ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>