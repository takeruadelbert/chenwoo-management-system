<?php echo $this->Form->create("CooperativeItemLoanPayment", array("class" => "form-horizontal form-separate", "action" => "add_step2", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<?= $this->Form->hidden("CooperativeItemLoanPayment.creator_id", ["value" => $stnAdmin->getEmployeeId()]) ?>
<?= $this->Form->hidden("CooperativeItemLoanPayment.employee_type_id", ["value" => $this->request->query["employee_type_id"]]) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Setup Potongan Sembako") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="well block">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("CooperativeItemLoanPayment.start_period", __("Periode Awal"), array("class" => "col-sm-3 col-md-4 control-label"));
                                echo $this->Form->input("CooperativeItemLoanPayment.start_period", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text"));
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("CooperativeItemLoanPayment.end_period", __("Periode Akhir"), array("class" => "col-sm-3 col-md-4 control-label"));
                                echo $this->Form->input("CooperativeItemLoanPayment.end_period", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text"));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive stn-table">
                    <table width="100%" class="table table-bordered table-hover">
                        <thead>
                            <tr bordercolor="#000000">
                                <th width="50" align="center" valign="middle" bgcolor="#feffc2">No</th>
                                <th align="center" valign="middle" bgcolor="#feffc2">Nama Pegawai</th>
                                <th width="300" align="center" valign="middle" bgcolor="#feffc2">Total Hutang Sembako</th>
                                <th width="300" align="center" valign="middle" bgcolor="#feffc2">Jumlah Potongan Periode Ini</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            if (!empty($cooperativeItemLoans)) {
                                foreach ($cooperativeItemLoans as $k => $cooperativeItemLoan) {
                                    ?>
                                    <tr>
                                        <td align="center" class="nomorIdx"><?= $k + 1 ?></td>
                                        <td>
                                            <div class="false">
                                                <?= $this->Form->input("Dummy.$i.name", [ "value" => $cooperativeItemLoan["Employee"]["Account"]["Biodata"]["full_name"], "div" => false, "class" => "form-control", "label" => false, "disabled"]) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="false">
                                                <?= $this->Form->input("Dummy.$i.total", [ "value" => $cooperativeItemLoan["CooperativeItemLoan"]["remaining"], "div" => false, "class" => "form-control text-right rupiah-field isdecimal", "label" => false, "disabled"]) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="false">
                                                <?= $this->Form->input("CooperativeItemLoanPaymentDetail.$i.amount", ["type" => "text", "div" => false, "class" => "form-control text-right rupiah-field isdecimal", "label" => false]) ?>
                                                <?= $this->Form->hidden("CooperativeItemLoanPaymentDetail.$i.cooperative_item_loan_id", ["value" => $cooperativeItemLoan["CooperativeItemLoan"]["id"]]) ?>
                                                <?= $this->Form->hidden("CooperativeItemLoanPaymentDetail.$i.current_debt", ["value" => $cooperativeItemLoan["CooperativeItemLoan"]["remaining"]]) ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data hutang.</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>  
                    </table>
                </div>
                <div class="well block">
                    <div class="form-actions text-center">
                        <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                        <input type="reset" value="Reset" class="btn btn-info">
                        <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                            <?= __("Simpan") ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>